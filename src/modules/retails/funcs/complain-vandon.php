<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Fri, 08 Oct 2021 07:57:15 GMT
	*/
	
	$order_id = $nv_Request->get_int('order_id', 'post, get', 0);
	// kiểm tra đơn hàng này có phải của khách hàng này không
	$check = $db->query('SELECT t1.id FROM '. TABLE .'_complain t1, ' . TABLE .'_order t2 WHERE t1.order_id = t2.id AND t2.userid ='. $user_info['userid'] . ' AND t1.order_id ='. $order_id .' AND t1.status = 3' )->fetchColumn();
	
	if(!$check)
	{
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=complain-list');
	}
	
	// lấy phí đơn vị vận chuyển vnpost giao thường get_price_vc
	if ($nv_Request->isset_request('get_price_vc', 'post, get')) {
		
		$order_id = $nv_Request->get_int('order_id_ajax', 'post, get', 0);
		$province_id = $nv_Request->get_int('province_id', 'post, get', 0);
		$district_id = $nv_Request->get_int('district_id', 'post, get', 0);
		$ward_id = $nv_Request->get_int('ward_id', 'post, get', 0);
		
		if(!$order_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Đơn hàng không tồn tại!';
			print_r(json_encode($error));die;
		}
		
		if(!$province_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa chọn tỉnh thành gửi!';
			print_r(json_encode($error));die;
		}
		
		if(!$district_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa chọn quận huyện gửi!';
			print_r(json_encode($error));die;
		}
		
		if(!$ward_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa chọn xã phường gửi!';
			print_r(json_encode($error));die;
		}
		
		// kiểm tra đơn hàng này có phải của khách hàng này không
		$row = $db->query('SELECT t1.* FROM '. TABLE .'_complain t1, ' . TABLE .'_order t2 WHERE t1.order_id = t2.id AND t2.userid ='. $user_info['userid'] . ' AND t1.order_id ='. $order_id .' AND t1.status = 3' )->fetch();
		
		if(!$row)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Đơn hàng không xác định!';
			print_r(json_encode($error));die;
		}
		
		
		// tính phí vận chuyển vnpost giao thường. 
		
		
		// lấy thông tin giá sản phẩm từ order_item
		$get_info_product = $db->query('SELECT * FROM '. TABLE .'_order_item WHERE order_id ='. $order_id .' AND product_id ='. $row['product_id'])->fetch();
		
		// lấy thông tin order
		$info_order = get_info_order($order_id);
		
		$weight_product = $get_info_product['weight'];
		$length_product = $get_info_product['length'];
		$width_product = $get_info_product['width'];
		$height_product = $get_info_product['height'];
		$total = $get_info_product['price'];
		
		
		$info_warehouse = get_info_warehouse( $info_order['warehouse_id'] );
		
		// địa chỉ nhận
		$province_id_vnpost_receive = get_info_province( $info_warehouse['province_id'] )['vnpostid'];
		$district_id_vnpost_receive = get_info_district( $info_warehouse['district_id'] )['vnpostid'];
		
		
		// địa chỉ gửi
		$province_id_vnpost_send = get_info_province( $province_id )['vnpostid'];
		$district_id_vnpost_send = get_info_district( $district_id )['vnpostid'];
		
		$transporters_id = 5;
		
		if($transporters_id==5){
			$weight_quydoi=($length_product*$width_product*$height_product)/5000;
			}else{
			$weight_quydoi=($length_product*$width_product*$height_product)/6000;
		}
		
		
		
		if($weight_product<=($weight_quydoi*1000)){
			$weight_quydoi2=($weight_quydoi*1000);
			}else{
			$weight_quydoi2=$weight_product;
		}
		
		/*
			Mã dịch vụ cộng thêm *: DichVuCongThemId
			1: Khai giá 
			2: Báo Phát 
			3: COD 
			4: DichVuHoaDon
		*/
		$Dichvucongthem[] = array(
		'DichVuCongThemId'=>1,
		'TrongLuongQuyDoi'=> $weight_quydoi2,
		'SoTienTinhCuoc'=>$total,
		'MaTinhGui'=> $province_id_vnpost_send,
		'MaTinhNhan'=> $district_id_vnpost_send
		);
		
		$code_transporters = get_info_transporters( $transporters_id )['code_transporters'];
		
		// ThuCuocNguoiNhan True: Nếu có thu tiền COD, False: Không thu COD
		$ThuCuocNguoiNhan = false;
		
		
		$fee = get_price_vnpost( $code_transporters, $province_id_vnpost_send, $district_id_vnpost_send, $province_id_vnpost_receive, $district_id_vnpost_receive, $ThuCuocNguoiNhan, $Dichvucongthem, $length_product, $width_product, $height_product, $weight_product );
		
		
		if ( empty( $fee ) ) 
		{
			$tranposter_fee = -1;
		}
		else 
		{
			
			
			$tranposter_fee = $fee['TongCuocBaoGomDVCT'];
			
			$mod = $tranposter_fee%1000;
			if($mod>0){
				$thuong = ceil($tranposter_fee / 1000);
				$tranposter_fee=$thuong*1000;
			}
		}
		
		$error['status'] = 'OK';
		$error['price_format'] = number_format($tranposter_fee);
		$error['mess'] = 'Thực hiện thành công!';
		print_r(json_encode($error));die;
		
	}
	
	
	// xử lý lên đơn vị vận chuyển
	if ($nv_Request->isset_request('send_vc_khieunai', 'post, get')) {
		
		$order_id = $nv_Request->get_int('order_id_ajax', 'post, get', 0);
		$province_id = $nv_Request->get_int('province_id', 'post, get', 0);
		$district_id = $nv_Request->get_int('district_id', 'post, get', 0);
		$ward_id = $nv_Request->get_int('ward_id', 'post, get', 0);
		$address = $nv_Request->get_title('address', 'post, get', 0);
		
		$error = array();
		
		if(!$order_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Đơn hàng không tồn tại!';
			print_r(json_encode($error));die;
		}
		
		if(!$province_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa chọn tỉnh thành gửi!';
			print_r(json_encode($error));die;
		}
		
		if(!$district_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa chọn quận huyện gửi!';
			print_r(json_encode($error));die;
		}
		
		if(!$ward_id)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa chọn xã phường gửi!';
			print_r(json_encode($error));die;
		}
		
		if(!$address)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Chưa nhập địa chỉ gửi!';
			print_r(json_encode($error));die;
		}
		
		// kiểm tra đơn hàng này có phải của khách hàng này không
		$row = $db->query('SELECT t1.* FROM '. TABLE .'_complain t1, ' . TABLE .'_order t2 WHERE t1.order_id = t2.id AND t2.userid ='. $user_info['userid'] . ' AND t1.order_id ='. $order_id .' AND t1.status = 3' )->fetch();
		
		if(!$row)
		{
			$error['status'] = 'ERROR';
			$error['mess'] = 'Đơn hàng không xác định!';
			print_r(json_encode($error));die;
		}
		
		
		// lên đơn vị vận chuyển.
		$info_order = get_info_order($order_id); 
		
		$order_code = $info_order['order_code'] . '-' . NV_CURRENTTIME;
		
		$IsPackageViewable = 0;
		$PickupType = 1;
		$PickupPoscode = 0;
		
		$info_order['transporters_id'] = 5;
		
		$ServiceName=get_info_transporters($info_order['transporters_id'])['code_transporters'];
		
		// địa chỉ gửi
		$SenderFullname = $info_order['order_name'];
		$SenderProvinceId = get_info_province( $province_id )['vnpostid'];
		$SenderDistrictId = get_info_district( $district_id )['vnpostid'];
		$SenderWardId = get_info_ward($ward_id)['vnpostid'];
		$SenderAddress = $address;
		$SenderTel = $info_order['phone'];
		
		
		
		// địa chỉ nhận
		$info_warehouse = get_info_warehouse( $info_order['warehouse_id'] );
		
		$ReceiverProvinceId = get_info_province( $info_warehouse['province_id'] )['vnpostid'];
		$ReceiverDistrictId = get_info_district( $info_warehouse['district_id'] )['vnpostid'];
		$ReceiverWardId = get_info_ward($info_warehouse['ward_id'])['vnpostid'];
		$info_order['address'] = $info_warehouse['address'];
		
		$info_store = get_info_store($info_order['store_id']);
		
		$ReceiverFullname = $info_store['company_name'];
		$ReceiverAddress = $info_warehouse['address'];
		$ReceiverTel = $info_warehouse['phone_send'];
		
		
		$PackageContent='Đơn hàng với mã đơn hàng '.$info_order['order_code'] ;
		
		// phí ship khách hàng chịu
		$IsReceiverPayFreight = true; 
		
		
		// lấy thông tin total_weight, total_length, total_width, total_height
		$array_pro = json_decode($row['product_id'],true);
		
		$total_weight = 0;
		$total_length = 0;
		$total_width = 0;
		$total_height = 0;
		$total_product = 0;
		
		foreach($array_pro as $pro)
		{
			// lấy thông tin trong order_item
			$order_item = $db->query('SELECT weight, length, width, height, price FROM '. TABLE .'_order_item WHERE order_id ='. $order_id .' AND product_id ='. $pro['product_id'] . ' AND classify_value_product_id ='. $pro['classify_value_product_id'])->fetch();
			
			$total_weight = $total_weight + ($order_item['weight'] * $pro['number']);
			
			if($order_item['length'] > $total_length)
			$total_length = $order_item['length'];
		
			if($order_item['width'] > $total_width)
			$total_width = $order_item['width'];
		
			$total_height = $total_height + ($order_item['height'] * $pro['number']);
			
			$total_product = $total_product + ($order_item['price'] * $pro['number']);
			
		}
		
		//print_r($total_weight);die; 
		
		// https://chonhagiau.com/index.php?nv=retails&op=complain-vandon&send_vc_khieunai=1&order_id_ajax=402&province_id=70&district_id=7250&ward_id=72640&address=173%20Nguy%E1%BB%85n%20V%C4%83n%20Tr%E1%BB%97i%2C%20Ph%C6%B0%E1%BB%9Dng%2010%2C%20Ph%C3%BA%20Nhu%E1%BA%ADn%2C%20Th%C3%A0nh%20ph%E1%BB%91%20H%E1%BB%93%20Ch%C3%AD%20Minh
	
		$order_vnpost=send_vnpost($order_code, $PackageContent,$ServiceName, $SenderFullname, $SenderAddress, $SenderTel,$SenderProvinceId,$SenderDistrictId, $SenderWardId, $ReceiverFullname, $ReceiverAddress, $ReceiverTel, $ReceiverProvinceId, $ReceiverDistrictId,$ReceiverWardId,0,$PickupPoscode,$total_weight,$total_length,$total_width,$total_height,$total_product,$IsReceiverPayFreight);
		
		//print_r($order_vnpost);die; 
		
		if(!empty($order_vnpost['ItemCode']))
		{
			// cập nhật trạng thái khiếu nại
			if(update_vnpost_hoantra_hang($info_order, $order_vnpost, $array_pro))
			{
				$error['status'] = 'OK';
				$error['mess'] = 'Thực hiện thành công!';
				print_r(json_encode($error));die;
			}
		}
		
		
		$error['status'] = 'OK';
		$error['mess'] = 'Thực hiện thành công!';
		print_r(json_encode($error));die;
		
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
	
	
	$order_id = $nv_Request->get_int('order_id', 'post,get', 0);
	
	if(!$order_id)
	{
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ordercustomer');
	}
	
	check_store_order_id($order_id);
	
	$xtpl->assign('order_id', $order_id);
	
	// thông tin khiếu nại
	$row = $db->query('SELECT * FROM '. TABLE .'_complain WHERE order_id ='. $order_id)->fetch();
	
	if($row['ship'] == 1)
	{
		$xtpl->parse('main.seller');
	}
	elseif($row['ship'] == 2)
	{
		$xtpl->parse('main.khach_hang');
	}
	
	$xtpl->assign('row', $row);
	
	
	
	
	// danh sách sản phẩm
	
	$array_product = json_decode($row['product_id'],true);
	
	
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
	
	
	// thông tin đơn hàng
	$info_order = get_info_order($order_id);
	$xtpl->assign('info_order', $info_order);
	
	
	// tỉnh thành quận huyện xã phường
	
	if($info_order['province_id'])
	{
		$list_province = get_province_select2('');
		
		foreach ($list_province as $value_list) {
			if($info_order['province_id'] == $value_list['provinceid']){
				$value_list["selected"] = "selected";
			}
			$xtpl->assign( 'STATUS', $value_list);
			$xtpl->parse( 'main.province_id' );
		}
	}
	
	if($info_order['province_id'] and $info_order['district_id'])
	{
		$list_district = get_district_select2('',$info_order['province_id']);
		
		foreach ($list_district as $value_list) {
			if($info_order['district_id'] == $value_list['districtid']){
				$value_list["selected"] = "selected";
			}
			$xtpl->assign( 'STATUS', $value_list);
			$xtpl->parse( 'main.district_id' );
		}
	}
	
	if($info_order['province_id'] and $info_order['district_id'] and $info_order['ward_id'])
	{
		$list_ward = get_ward_select2('',$info_order['district_id']);
		foreach ($list_ward as $value_list) {
			if($info_order['ward_id'] == $value_list['wardid']){
				$value_list["selected"] = "selected";
			}
			$xtpl->assign( 'STATUS', $value_list);
			$xtpl->parse( 'main.ward_id' );
		}
	}
	
	
	// lấy thông tin kho
	$info_warehouse = get_info_warehouse( $info_order['warehouse_id'] );
	$xtpl->assign( 'info_warehouse', $info_warehouse);
	
	// thông tin shop
	$info_store = get_info_store($info_order['store_id']);
	$xtpl->assign( 'info_store', $info_store);
	
	
	// thông tin sản phẩm
	
	//print_r($info_store);die;
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	
	$page_title = $lang_module['complain_vandon'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
