<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Fri, 08 Oct 2021 07:57:15 GMT
	*/
	
	$row = array();
	$error = array();
	
	$row['order_id'] = $nv_Request->get_int('order_id', 'post,get', 0);
	
	if(!$row['order_id'])
	{
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ordercustomer');
	}
	
	check_store_order_id($row['order_id']);
	
	// check thông tin order_id đã khiếu nại chưa.
	$row = $db->query('SELECT * FROM '. TABLE .'_complain WHERE order_id ='.$row['order_id'])->fetch();
	
	
	$row['reason'] = nv_htmlspecialchars(nv_br2nl($row['reason']));
	
	if($row['images_video'])
	{
		$row['images_video'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['images_video'];	
	}
	
	
	
	
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
	
	// danh sách sản phẩm
	
	foreach($array_product as $product)
	{
		
		// lấy danh sách sản phẩm 
		$view = $db->query('SELECT t1.id, t1.name_product, t2.classify_value_product_id FROM '. TABLE .'_product t1, '. TABLE .'_order_item t2 WHERE t2.order_id = '. $row['order_id'] .' AND t2.product_id = t1.id AND t1.id ='. $product['product_id'])->fetch();
		
		
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
		
		$xtpl->assign( 'VIEW', $view );
		$xtpl->assign( 'number', $product['number'] );
		$xtpl->parse( 'main.loop_send' );
		
		
	}
	
	
	
	$xtpl->parse( 'main.view' );
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['complain'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
