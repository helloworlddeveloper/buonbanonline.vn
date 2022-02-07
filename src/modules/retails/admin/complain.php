<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Fri, 08 Oct 2021 07:57:15 GMT
	*/
	
	//xử lý thêm complain
	if ($nv_Request->isset_request('add_complain', 'get')) {
		
		$error = array();
		
		$row['order_id'] = $nv_Request->get_int('order_id', 'post,get', '');
		
		$thongtin_sp = $nv_Request->get_string('thongtin_sp', 'post,get', '');	
		$row['thongtin_sp'] = explode(',',$thongtin_sp);
		
		if(!$row['thongtin_sp'])
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa chọn sản phẩm khiếu nại!';
			print_r(json_encode($error));die;
		}
		
		if(!$row['order_id'])
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Đơn hàng không tồn tại!';
			print_r(json_encode($error));die;
		}
		
		
		$numbers = $nv_Request->get_string('numbers', 'post,get', '');
		$row['numbers'] = explode(',',$numbers);
		
		if(!$row['numbers'])
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Số lượng sản phẩm không đúng!';
			print_r(json_encode($error));die;
		}
		
		
		$classify_value_product_id = $nv_Request->get_string('classify_value_product_id', 'post,get', '');
		$row['classify_value_product_id'] = explode(',',$classify_value_product_id);
		
			
		// xử lý sản phẩm khiếu nại
		$array_product = array();
		for($i = 0; $i < count($row['thongtin_sp']); $i++)
		{
			if(!$row['thongtin_sp'][$i])
			continue;
			
			// kiểm tra số lượng sản phẩm đã đặt
			
			$quantity = $db->query('SELECT quantity FROM '. TABLE .'_order_item WHERE order_id ='. $row['order_id'] .' AND product_id ='. $row['thongtin_sp'][$i] .' AND classify_value_product_id ='. $row['classify_value_product_id'][$i])->fetchColumn();
			
			if($quantity < $row['numbers'][$i])
			{
				
				if($row['classify_value_product_id'][$i]>0){
					$classify_value_product_id=get_info_classify_value_product($row['classify_value_product_id'][$i]);
					$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
					$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
					if($classify_value_product_id['classify_id_value2']>0){
						$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
						$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
						$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
						}else{
						$name_group=$name_classify_id_value1;
					}	
					$view['name_group']= '( '.$name_group.' )';
				}
				$name_product = get_info_product($row['thongtin_sp'][$i])['name_product'] . $view['name_group'];
				
				$error['status'] = 'ERROR';
				$error['mess'] = 'Số lượng sản phẩm '. $name_product .' không được lớn hơn '. $quantity .' !';
				print_r(json_encode($error));die;
			}
			$product = array();
			$product['product_id'] = $row['thongtin_sp'][$i];
			$product['classify_value_product_id'] = $row['classify_value_product_id'][$i];
			$product['number'] = $row['numbers'][$i];
			
			$array_product[$product['product_id'] . '_' . $row['classify_value_product_id'][$i]] = $product;  
		}
		
		$row['product_id'] = json_encode($array_product);
		
		
		// cập nhật sản phẩm, số lượng
		$db->query("UPDATE ". TABLE ."_complain SET product_id ='". $row['product_id'] ."' WHERE order_id =". $row['order_id']);
		
		
		$error['status'] = 'OK';
		$error['mess'] = 'Cập nhật thông tin thành công!';
		print_r(json_encode($error));die;
		
		
		
	}
	
	$row = array();
	$error = array();
	
	$id = $nv_Request->get_int('id', 'post,get', 0);
	
	// check thông tin order_id đã khiếu nại chưa.
	$row = $db->query('SELECT * FROM '. TABLE .'_complain WHERE id ='.$id)->fetch();
	
	
	$row['reason'] = nv_htmlspecialchars(nv_br2nl($row['reason']));
	
	if($row['images_video'])
	{
		$row['images_video'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['images_video'];	
	}
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_order_item t1' )
	->join( 'INNER JOIN ' . TABLE . '_product t2 ON t1.product_id = t2.id' )
	->where( 't1.order_id='.$row['order_id'] );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	
	$db->select( 't1.*,t2.id as id_product, t2.name_product, t2.alias, t2.id as id_product,t2.barcode, t2.image' )
	->order( 't1.id DESC' );
	$sth = $db->prepare( $db->sql());
	
	$sth->execute();
	
	
	
	
	$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
	$xtpl->assign('LANG', $lang_module);
	$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
	$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
	$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
	$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
	$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
	$xtpl->assign('MODULE_NAME', $module_name);
	$xtpl->assign('MODULE_UPLOAD', $module_upload);
	$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
	$xtpl->assign('OP', $op);
	$xtpl->assign('ROW', $row);
	
	
	// xuất thông tin đối tượng chịu phí ship
	$arr_ship = array('1' => 'Seller', '2' => 'Khách hàng');
	
	foreach ($arr_ship as $key => $title) {
		$xtpl->assign('OPTION', array(
		'key' => $key,
		'title' => $title,
		'selected' => ($key == $row['ship']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.ship');
	}
	
	
	// xuất thông tin hình ảnh chính, hình ảnh khác của sản phẩm
	
	$list_image = explode(',',$row['images']);
	
	if($list_image)
	{
		for($i = 0; $i <= 7; $i++)
		{
			$xtpl->assign('stt', $i);
			
			if (!empty($list_image[$i]) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload  . '/' . $list_image[$i])) {
				
				$src_image = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $list_image[$i];			
				
				$xtpl->assign('src_image', $src_image);			
				$xtpl->parse('main.image.data_image.loop');
				$xtpl->parse('main.image.data_image');
			}
		}
		
		$xtpl->parse('main.image');
	}
	
	
	// xuất thông tin video
	if($row['images_video'])
	{
		$xtpl->parse('main.images_video');
	}
	
	
	$array_product = json_decode($row['product_id'],true);
	
	
	
	$tamtinh = 0;
	
	while ( $view = $sth->fetch() ) {
		
		if($view['classify_value_product_id']>0){
			$classify_value_product_id=get_info_classify_value_product($view['classify_value_product_id']);
			$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
			$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
			if($classify_value_product_id['classify_id_value2']>0){
				$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
				$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
				$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
				}else{
				$name_group=$name_classify_id_value1;
			}	
			$view['name_group']= '( '.$name_group.' )';
		}
		
		if(isset($array_product[$view['id_product'] .'_'.$view['classify_value_product_id']]))
		{
			$xtpl->assign( 'checked_product', 'checked=checked' );
			$xtpl->assign( 'product', $array_product[$view['id_product'] .'_'.$view['classify_value_product_id']]);
		}
		else
		{
			$xtpl->assign( 'checked_product', '' );
			$xtpl->assign( 'product', $view['quantity']);
		}
		
		
		
		$xtpl->assign( 'VIEW', $view );
		
		$xtpl->parse( 'main.loop_send' );
		
	}
	
	
	$xtpl->parse( 'main.view' );
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['complain'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
