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
	
	// check thông tin order_id đã khiếu nại chưa.
	$info = $db->query('SELECT * FROM '. TABLE .'_complain WHERE order_id ='.$row['order_id'])->fetch();
	
	if($info)
	{
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=complain-view&order_id='. $row['order_id']);
	}
	
	
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
		
		
		// hình ảnh, video
		
		$flag = false;
		
		$row['other_image'] = $nv_Request->get_array('array_image_pro', 'post,get', array());
		
		if(count($row['other_image']) >= 6)
		{
			$flag = true;
		}
		
		
		$duoi = explode('.', $_FILES['video']['name']); // tách chuỗi khi gặp dấu .
		$duoi = $duoi[(count($duoi) - 1)]; //lấy ra đuôi file
		// Kiểm tra xem có phải file ảnh không
		
		
		$dinhdang_video = array('avi','flv','wmv','mov','mp4','mpeg','divx','3gp','xvid','h.264');
		
		if(!in_array($duoi,$dinhdang_video))
		{
			$flag = true;
		}
		
		if($flag)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa upload đủ 6 hình hoặc video quay 6 mặt sản phẩm!';
			print_r(json_encode($error));die;
		}
		
		
		
		$row['reason'] = $nv_Request->get_textarea('reason', '', NV_ALLOWED_HTML_TAGS);
		
		if(empty($row['reason']))
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa nhập lý do!';
			print_r(json_encode($error));die;
		}
		
		
		
		
		$target_file = NV_UPLOADS_DIR . '/' . $module_upload . '/complain/';
		
		// xử lý hình ảnh
		$array_other_img = array();
		
		
		if(!empty($row['other_image']))
		{
			
			foreach ($row['other_image'] as $otherimage) 
			{
				$file_image = conver_data_img_to_png($otherimage, $target_file, false);
				
				if($file_image)
				{
					$array_other_img[] = 'complain/' . $file_image;
				}
			}
			
		}
		
		if($array_other_img)
		$row['other_image_string'] = implode(',',$array_other_img);
		
		
		
		$size = number_format($_FILES['video']['size']/(1048576), 2);
		
		if($size > 20)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Kích thướt video vượt quá 20M';
			print_r(json_encode($error));die;
		}
		
		
		
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
		
		
		
		
		// xử lý video.
		if($_FILES['video']['name'])
		{
			
			$mang_file = explode('.' . $duoi,$_FILES['video']['name']);
			$fileName = $mang_file[0];
			
			$random_num = uniqid() . NV_CURRENTTIME ;			
			$fileName = change_alias(strtolower($fileName));
			
			$filename_new = $fileName.$random_num . '.' . $duoi;
			
			
			rename($fileName . '.' . $duoi, $filename_new);
			
			if (move_uploaded_file($_FILES['video']['tmp_name'], $target_file . $filename_new)) 
			{
				$row['video_string'] = 'complain/' . $filename_new;
			}
		}
		
		
		
		
		if(!$row['video_string'] and !$row['other_image_string'])
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Hình ảnh hoặc video không xác định!';
			print_r(json_encode($error));die;
		}
		
		
		
		
		
		// xử lý csdl
		// lấy trạng thái id mới nhất, trạng thái khiếu nại
		$row['status'] = $db->query('SELECT weight FROM ' . TABLE .'_complain_status WHERE status = 1')->fetchColumn();
		$row['time_add'] = NV_CURRENTTIME;
		$row['time_edit'] = NV_CURRENTTIME;
		
		
		$stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_complain (order_id, product_id, images, images_video, reason, status, time_add,time_edit) VALUES (:order_id, :product_id, :images, :images_video, :reason, :status, :time_add, :time_edit)');
		
		$stmt->bindParam(':status', $row['status'], PDO::PARAM_INT);
		$stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
		$stmt->bindParam(':time_edit', $row['time_edit'], PDO::PARAM_INT);
		$stmt->bindParam(':order_id', $row['order_id'], PDO::PARAM_INT);
		$stmt->bindParam(':product_id', $row['product_id'], PDO::PARAM_STR);
		$stmt->bindParam(':images', $row['other_image_string'], PDO::PARAM_STR);
		$stmt->bindParam(':images_video', $row['video_string'], PDO::PARAM_STR);
		$stmt->bindParam(':reason', $row['reason'], PDO::PARAM_STR, strlen($row['reason']));
		
		$exc = $stmt->execute();
		if ($exc) {
			
			$error['status'] = 'OK';
			$error['mess'] = 'Gửi khiếu nại thành công!. Chúng tôi sẽ sớm liên hệ với bạn. Cảm ơn bạn!';
			$error['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=complain&order_id='. $row['order_id'];
			
			print_r(json_encode($error));die;
		}
		
		
	}
	
	
	
	$row['reason'] = nv_htmlspecialchars(nv_br2nl($row['reason']));
	
	check_store_order_id($row['order_id']);
	
	$info_order = get_info_order($row['order_id']);
	
	$info_store = get_info_store( $info_order['store_id'] );
	
	$info_store['alias_shop'] = NV_MY_DOMAIN .'/'.get_info_user($info_store['userid'])['username'].'/';
	
	if($info_order['payment_method']==0){
		$info_order['payment_method']='Thanh toán khi nhận hàng';
		}else{
		$info_order['payment_method']='Thanh toán qua ví tiền';
	}
	$info_order['status1'] = $info_order['status'];
	$info_order['transporters_name']=get_info_transporters($info_order['transporters_id'])['name_transporters'];
	$info_order['status']=get_info_order_status($info_order['status'])['name'];
	$info_order['total_product']=number_format($info_order['total_product']);
	$info_order['total']=number_format($info_order['total']);
	$info_order['fee_transport']=number_format($info_order['fee_transport']);
	
	$info_order['address'] = $info_order['address'];
	$per_page = 20;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_order_item t1' )
	->join( 'INNER JOIN ' . TABLE . '_product t2 ON t1.product_id = t2.id' )
	->where( 't1.order_id='.$row['order_id'] );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	
	$db->select( 't1.*,t2.id as id_product, t2.name_product, t2.alias, t2.id as id_product,t2.barcode, t2.image' )
	->order( 't1.id DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
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
	
	$xtpl->assign( 'info_store', $info_store );
	
	
	// xuất thông tin hình ảnh chính, hình ảnh khác của sản phẩm
	
	$list_image = array();
	
	for($i = 0; $i <= 7; $i++)
	{
		$xtpl->assign('stt', $i);
		
		//print_r(NV_UPLOADS_REAL_DIR . '/' . $module_upload  . '/' . $list_image[$i]['image']);die;
		if (!empty($list_image[$i]['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload  . '/' . $list_image[$i]['image'])) {
			
			$src_image = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $list_image[$i]['image'];			
			$homeimgfile = str_replace(NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/', '',$list_image[$i]['image']);
			
			$xtpl->assign('src_image', $src_image);
			$xtpl->assign('homeimgfile', $homeimgfile);
			
			$xtpl->parse('main.data_image.loop');
			
		}
		else
		{
			$xtpl->parse('main.data_image.add');
		}
		
		$xtpl->parse('main.data_image');
	}
	
	
	if($info_order['status_payment_vnpay'] and $info_order['payment'])
	{
		$info_order['status_payment_vnpay_title'] = 'VNPAY';
	}
	else
	{
		$info_order['status_payment_vnpay_title'] = 'Chưa thanh toán';
	}
	
	$info_order['time_add']=date('d-m-Y H:i',$info_order['time_add']);
	$xtpl->assign( 'info_order', $info_order );
	
	
	$tamtinh = 0;
	
	while ( $view = $sth->fetch() ) {
		
		$view['number'] = $number++;
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
		
		if (!empty($view['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $view['image'] )) {
			$view['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
			}else{
			$server = 'banhang.'.$_SERVER["SERVER_NAME"];
			$view['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
		}
		
		$view['alias_product'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $view['alias'].'-'.$view['id_product'], true );
		
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
		$xtpl->parse( 'main.loop_send' );
		$list_product[] = $view;
	}
	
	$tamtinh=number_format($tamtinh);
	
	$xtpl->assign( 'tamtinh', $tamtinh );
	
	
	$xtpl->parse( 'main.view' );
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['complain'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
