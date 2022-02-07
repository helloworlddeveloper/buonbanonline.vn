<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES., JSC <contact@vinades.vn>
		* @Copyright ( C ) 2021 VINADES., JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Mon, 04 Jan 2021 09:28:10 GMT
	*/
	
	if ( !defined( 'NV_IS_FILE_ADMIN' ) )
	die( 'Stop!!!' );
	$mod = $nv_Request->get_string( 'mod', 'get,post', '' );
	
	
	// check thông tin giá vnpost view_popup_vanchuyen
	if( $nv_Request->isset_request( 'view_popup_vanchuyen', 'get' ) )
	{
		// lên lại đơn hàng từ trạng thái giao hàng thất bại
		
		$order_id = $nv_Request->get_int( 'order_id', 'post,get' );
		$store_id = $nv_Request->get_int( 'store_id', 'post,get' );
		
		if(!$order_id)
		return false;
		
		
		$info_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE store_id='. $store_id .' AND id =' . $order_id)->fetch();
		
		if( ($info_order['status_payment_vnpay'] == 0) or ($info_order['status'] != 6) )
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		
		$info_order['warehouse_name'] = $global_config['site_name'];
		$info_order['phone_warehouse'] = $global_config['site_phone'];
		$info_order['address_warehouse'] = $config_setting['address_ecng'];
		
		
		$info_order['address_receive'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
		$info_order['transporters_name'] = get_info_transporters($info_order['transporters_id'])['name_transporters'];
		
		
		// lấy giá thu hộ trước đó. giao hàng mà thất bại
		// kiểm tra phí ship cũ trước đó.
		
		$total_code_old = 0;
		
		if($info_order['shipping_code'])
		$total_code_old = $db->query('SELECT cod FROM ' . TABLE .'_history_vnpos WHERE (vnpost_status = 91 OR vnpost_status = 161) AND item_code ="'. $info_order['shipping_code'] .'"')->fetchColumn();
	
		if(!$total_code_old)
		$total_code_old = 0;
	
		// làm tròn
		if($total_code_old)
		{
			$mod = $total_code_old%1000;
			if($mod>0){
				$thuong = ceil($total_code_old / 1000);
				$total_code_old = $thuong*1000;
			}
		}
		
		
		$order_code = $info_order['order_code'] . '-' . NV_CURRENTTIME;
		
		$IsPackageViewable = 0;
		$PickupType = 1;
		$PickupPoscode = 0;
		$CodAmountEvaluation = 0;
		
		
		$ServiceName=get_info_transporters($info_order['transporters_id'])['code_transporters'];
		$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
		$info_warehouse['address'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
		
		// lên lại vận đơn khi giao hàng thất bại sẽ lấy thông tin gửi là ECNG
		$info_warehouse['province_id'] = $config_setting['province_ecng'];
		$info_warehouse['district_id'] = $config_setting['district_ecng'];
		$info_warehouse['ward_id'] = $config_setting['ward_ecng'];
		$info_warehouse['address'] = $config_setting['address_ecng'];
		$info_warehouse['name_send'] = $global_config['site_name'];
		$info_warehouse['phone_send'] = $global_config['site_phone'];
		
		
		// 1 khai giá
		$Dichvucongthem[] = array(
		'DichVuCongThemId'=>1,
		'TrongLuongQuyDoi'=> $info_order['total_weight'],
		'SoTienTinhCuoc'=>$info_order['total_product'],
		'MaTinhGui'=> $SenderProvinceId,
		'MaTinhNhan'=> $ReceiverProvinceId
		);
		
		$Dichvucongthem[] = array(
		'DichVuCongThemId'=>3,
		'TrongLuongQuyDoi'=> $info_order['total_weight'],
		'SoTienTinhCuoc'=>$total_code_old,
		'MaTinhGui'=> $SenderProvinceId,
		'MaTinhNhan'=> $ReceiverProvinceId
		);
		
		
		$SenderProvinceId=get_info_province($info_warehouse['province_id'])['vnpostid'];
		$SenderDistrictId=get_info_district($info_warehouse['district_id'])['vnpostid'];
		$SenderWardId=get_info_ward($info_warehouse['ward_id'])['vnpostid'];
		$ReceiverProvinceId=get_info_province($info_order['province_id'])['vnpostid'];
		$ReceiverDistrictId=get_info_district($info_order['district_id'])['vnpostid'];
		$ReceiverWardId=get_info_ward($info_order['ward_id'])['vnpostid'];
		$PackageContent='Đơn hàng với mã đơn hàng '.$info_order['order_code'] ;
		$info_order['address'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
		$payment_method=get_info_order($order_id)['payment_method'];
		
		
		if($info_order['transporters_id']==5){
			$weight_quydoi=($info_order['total_length']*$info_order['total_width']*$info_order['total_height'])/5000;
			}else{
			$weight_quydoi=($info_order['total_length']*$info_order['total_width']*$info_order['total_height'])/6000;
		}
		if($info_order['total_weight']<= ($weight_quydoi*1000)){
			$weight_quydoi2= ($weight_quydoi*1000);
			}else{
			$weight_quydoi2=$info_order['total_weight'];
		}
		
		$ThuCuocNguoiNhan = true;
		
		
		
		$fee = get_price_vnpost( $ServiceName, $SenderProvinceId, $SenderDistrictId, $ReceiverProvinceId, $ReceiverDistrictId, $ThuCuocNguoiNhan, $Dichvucongthem, $info_order['total_length'], $info_order['total_width'], $info_order['total_height'], $info_order['total_weight'] );
		
		//print_r($fee);die;
		
		if ( empty( $fee ) ) {
			$tranposter_fee = -1;
			} else {
			
			$tranposter_fee = $fee['TongCuocBaoGomDVCT'];
			
			$mod = $tranposter_fee%1000;
			if($mod>0){
				$thuong = ceil($tranposter_fee / 1000);
				$tranposter_fee=$thuong*1000;
			}
		}
		
		
		$xtpl = new XTemplate('listorder_ajax_popup_vc_view.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
		$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
		$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
		$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
		$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
		$xtpl->assign('MODULE_NAME', $module_name);
		$xtpl->assign('MODULE_UPLOAD', $module_upload);
		$xtpl->assign('VIEW', $info_order);
		
		$xtpl->assign('tranposter_fee', number_format($tranposter_fee));
		
		if($total_code_old)
		{
			$xtpl->assign('total_code_old', number_format($total_code_old));
			$xtpl->assign('total', number_format(($total_code_old + $tranposter_fee)));
			
			$xtpl->parse('main.old');
		}
		
		
		$xtpl->parse('main');
		$contents = $xtpl->text('main');
		
		print_r($contents);die;
		
	}
	
	// lấy thông tin popup đơn vị vận chuyển
	if( $nv_Request->isset_request( 'popup_vanchuyen', 'get' ) )
	{
		$order_id = $nv_Request->get_int( 'order_id', 'post,get' );
		$store_id = $nv_Request->get_int( 'store_id', 'post,get' );
		
		$view = $db->query('SELECT * FROM ' . TABLE . '_order WHERE store_id='. $store_id .' AND id =' . $order_id)->fetch();
		
		// thông tin cửa hàng
		if($view['status'] == 1)
		{
			$view['store_name']=get_info_store($view['store_id'])['company_name'];
			
			$view['warehouse_name']=get_info_warehouse($view['warehouse_id'])['name_warehouse'];
			
			$view['phone_warehouse']=get_info_warehouse($view['warehouse_id'])['phone_send'];
			$info_warehouse = get_info_warehouse( $view['warehouse_id'] );
			$view['address_warehouse'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
		}
		elseif($view['status'] == 6)
		{
			// lên vận đơn lại cho đơn hàng giao thất bại
			$view['warehouse_name'] = $global_config['site_name'];
			$view['phone_warehouse'] = $global_config['site_phone'];
			$view['address_warehouse'] = $config_setting['address_ecng'];
			
		}
		// kết thúc thông tin cửa hàng
		
		$view['address_receive'] = $view['address'].', '.get_info_ward( $view['ward_id'] )['title'].', '.get_info_district( $view['district_id'] )['title'].', '.get_info_province( $view['province_id'] )['title'];
		$view['transporters_name']=get_info_transporters($view['transporters_id'])['name_transporters'];
		
		$view['total_product']=number_format($view['total_product']);
		$view['fee_transport']=number_format($view['fee_transport']);
		$view['total']=number_format($view['total']);
		$view['time_add']=date('d-m-Y H:i',$view['time_add']);
		
		
		$xtpl = new XTemplate('listorder_ajax_popup_vc.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
		$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
		$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
		$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
		$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
		$xtpl->assign('MODULE_NAME', $module_name);
		$xtpl->assign('MODULE_UPLOAD', $module_upload);
		$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
		$xtpl->assign('OP', 'ajax');
		$xtpl->assign('VIEW', $view);
		
		
		if($view['status']==0){
			$xtpl->parse('main.status0');
			}else if($view['status']==1 or $view['status']==6){
			if($view['transporters_id']==4 || $view['transporters_id']==5){
				$xtpl->assign('send_vanchuyen', 'sendvnpost');
				$xtpl->assign('VANCHUYEN', 'VNPOST');
			}elseif($view['transporters_id'] == 3){
				$xtpl->assign('send_ghn', 'sendghn');
				$xtpl->assign('VANCHUYEN', 'GHN');
				$xtpl->parse('main.khaigia_ghn');
			}
		}
		
		$xtpl->parse('main');
		$contents = $xtpl->text('main');
		
		print_r($contents);die;
	}
	
	
	if ( $mod == 'get_categories' ) {
		$q = $nv_Request->get_string( 'q', 'post', '' ); 
		$list_cat = get_categories_select2( $q,IDSITE,0 );
		$json[] = ['id'=>0, 'text'=>'<span style="font-weight:bold">Chọn tất cả</span>'];
		if(count($list_cat)>0){
			foreach ( $list_cat as $result ) {
				$json[] = ['id'=>$result['id'], 'text'=>'<span style="font-weight:bold">'.$result['name'].'</span>'];
				$list_cat2 = get_categories_select2( '', IDSITE, $result['id'] );
				foreach ( $list_cat2 as $result2 ) {
					$json[] = ['id'=>$result2['id'], 'text'=>'<span>&emsp;'.$result2['name'].'</span>'];
				}
			}
			}else{
			$list_cat = get_categories_select2( '',IDSITE,0 );
			foreach ( $list_cat as $result ) {
				$list_cat2 = get_categories_select2( $q, IDSITE, $result['id'] );
				if(count($list_cat2)>0){
					$json[] = ['id'=>$result['id'], 'text'=>'<span style="font-weight:bold">'.$result['name'].'</span>'];
					foreach ( $list_cat2 as $result2 ) {
						$json[] = ['id'=>$result2['id'], 'text'=>'<span>&emsp;'.$result2['name'].'</span>'];
					}
				}
			}
		}
		print_r( json_encode( $json ) );
		die();
		
	}
	if($mod == 'download')
	{
		$file_name = $nv_Request->get_string( 'file_name', 'get', '' );
		
		$file_path = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $file_name;
		
		if( file_exists( $file_path ) )
		{
			header( 'Content-Description: File Transfer' );
			header( 'Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
			header( 'Content-Disposition: attachment; filename=' . $file_name );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );
			header( 'Content-Length: ' . filesize( $file_path ) );
			readfile( $file_path );
			// ob_clean();
			flush();
			nv_deletefile( $file_path );
			
			exit();
		}else
		{
			die('File not exists !');
		}
	}
	if($mod=='is_download'){
		ini_set( 'memory_limit', '512M' );
		set_time_limit( 0 );
		$q = $nv_Request->get_title( 'q', 'post,get' );
		$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
		$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
		$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
		$store_id = $nv_Request->get_int( 'store_id', 'post,get', 0 );
		$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'post,get', 0 );
		$customer_id2 = $nv_Request->get_int( 'customer_id', 'post,get', 0 );
		$categories_id = $nv_Request->get_int( 'categories_id', 'post,get', 0 );
		
		if ( !empty( $_SESSION[$module_data.'_status_view_order'] ) ) {
			$status = $_SESSION[$module_data.'_status_view_order'];
			}else{
			$status = 0;
		}
		if ( preg_match( '/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/', $ngay_tu, $m ) )
		{
			$_hour = $nv_Request->get_int( 'add_date_hour', 'post', 0 );
			$_min = $nv_Request->get_int( 'add_date_min', 'post', 0 );
			$ngay_tu = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
			} else {
			$ngay_tu = 0;
		}
		
		if ( preg_match( '/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/', $ngay_den, $m ) )
		{
			$_hour = $nv_Request->get_int( 'add_date_hour', 'post', 23 );
			$_min = $nv_Request->get_int( 'add_date_min', 'post', 59 );
			$ngay_den = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
			} else {
			$ngay_den = 0;
		}
		
		if ( $sea_flast != 9 ) {
			if ( $ngay_tu > 0 and $ngay_den > 0 )
			{
				
				$where .= ' AND t1.time_add >= '. $ngay_tu . ' AND t1.time_add <= '. $ngay_den;
				$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
			} else if ( $ngay_tu > 0 )
			{
				$where .= ' AND t1.time_add >= '. $ngay_tu;
				$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
			} else if ( $ngay_den > 0 )
			{
				$where .= ' AND t1.time_add <= '. $ngay_den;
				$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
			}
			
		}
		if ( !empty( $q ) ) {
			$where .= ' AND (t1.order_code LIKE "%" "'.$q. '" "%")';
		}
		if($store_id>0){
			$where .= ' AND t1.store_id ='.$store_id;
		}
		if($warehouse_id>0){
			$where .= ' AND t1.warehouse_id ='.$warehouse_id;
		}
		if($customer_id2>0){
			$where .= ' AND t1.userid ='.$customer_id2;
		}
		if($categories_id>0){
			$where .= ' AND t2.product_id IN (SELECT id FROM '.TABLE.'_product where categories_id='.$categories_id.')';
		}
		$where .= ' AND status ='.$status;
		$db->sqlreset()
		->select('COUNT(DISTINCT t1.id)')
		->from('' . TABLE . '_order t1')
		->join('INNER JOIN ' . TABLE . '_order_item t2 ON t2.order_id=t1.id')
		->where('1=1'.$where);
		
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('t1.*')
		->order('t1.id DESC')
		->where('1=1'.$where.' group by t1.id');
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$data_array = array();
		$dataContent = array();
		$stt = 0;
		while ($view = $sth->fetch()) {
			$data_array['stt']=++$stt;
			$data_array['order_code']=$view['order_code'];
			$data_array['status_name']=get_info_order_status($view['status'])['name'];
			$data_array['store_name']=get_info_store($view['store_id'])['company_name'].' (Người đại diện: '.get_info_store($view['store_id'])['name'].')';
			$data_array['warehouse_name']=get_info_warehouse($view['warehouse_id'])['name_warehouse'];
			$info_warehouse=get_info_warehouse($view['warehouse_id']);
			$data_array['name_send']=$info_warehouse['name_send'];
			$data_array['phone_send']=$info_warehouse['phone_send'];
			$data_array['address_send'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
			$data_array['order_name']=$view['order_name'];
			$data_array['phone']=$view['phone'];
			$data_array['email']=$view['email'];
			$data_array['address_full'] = $view['address'].', '.get_info_ward( $view['ward_id'] )['title'].', '.get_info_district( $view['district_id'] )['title'].', '.get_info_province( $view['province_id'] )['title'];
			$data_array['shipping_code']=$view['shipping_code'];
			$data_array['transporters_name']=get_info_transporters($view['transporters_id'])['name_transporters'];
			$data_array['fee_transport']=$view['fee_transport'];
			$data_array['total_product']=$view['total_product'];
			$data_array['total']=$view['total'];
			$dataContent[] = $data_array;	
		}
		if(count($dataContent)>0){
			$page_title = 'DANH SÁCH ĐƠN HÀNG';
			
			$Excel_Cell_Begin = 3; // Dong bat dau viet du lieu
			
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(NV_ROOTDIR . '/modules/' . $module_file . '/template_excel/order.xlsx');
			
			$worksheet = $spreadsheet->getActiveSheet();
			
			$worksheet->setTitle( $page_title );
			
			// Set page orientation and size
			$worksheet->getPageSetup()->setOrientation( phpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE );
			$worksheet->getPageSetup()->setPaperSize( phpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4 );
			$worksheet->getPageSetup()->setHorizontalCentered( true );
			
			
			$spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd( 1, $Excel_Cell_Begin );
			
			
			
			// Du lieu
			$array_key_data = array();
			$array_key_data[] = 'stt';
			$array_key_data[] = 'order_code';
			$array_key_data[] = 'status_name';
			$array_key_data[] = 'store_name';
			$array_key_data[] = 'warehouse_name';
			$array_key_data[] = 'name_send';
			$array_key_data[] = 'phone_send';
			$array_key_data[] = 'address_send';
			$array_key_data[] = 'order_name';
			$array_key_data[] = 'phone';
			$array_key_data[] = 'email';
			$array_key_data[] = 'address_full';
			$array_key_data[] = 'shipping_code';
			$array_key_data[] = 'transporters_name';
			$array_key_data[] = 'fee_transport';
			$array_key_data[] = 'total_product';
			$array_key_data[] = 'total';
			$pRow = $Excel_Cell_Begin;
			
			foreach( $dataContent as $row )
			{
				$columnIndex2 = 0;
				$pRow++;
				foreach( $array_key_data as $key_data )
				{
					++$columnIndex2;
					$TextColumnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex( $columnIndex2 );
					$highestColumn = $TextColumnIndex; 
					$highestRow = $pRow; 
					$worksheet->setCellValue( $TextColumnIndex . $pRow, $row[$key_data] );
					$spreadsheet->getActiveSheet()->getStyle('A' . $Excel_Cell_Begin . ':' . $highestColumn . $highestRow)->getBorders()->applyFromArray( 
					[ 
					'bottom' => [ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
					'top' => 	[ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
					'left' => [ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
					'right' => 	[ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
					]);
				}
			}
			$spreadsheet->getActiveSheet()->getStyle('A' . $Excel_Cell_Begin . ':' . $highestColumn . $highestRow)->getBorders()->applyFromArray( 
			[ 
			'bottom' => [ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
			'top' => 	[ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
			'left' => [ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
			'right' => 	[ 'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ], 
			]);
			
			
			
			
			$file_name = 'danh_sach_don_hang.xlsx';
			
			$file_path = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $file_name;
			
			header( 'Content-Type: application/vnd.ms-excel' );
			header( 'Content-Disposition: attachment;filename="'. $file_name .'"' );
			header( 'Cache-Control: max-age=0' );
			
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save($file_path);
			$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '='.$op.'&mod=download&file_name=' . $file_name;  
			
			nv_jsonOutput( array('link'=> $link) );		
			}else{
			nv_jsonOutput( array('error'=> 'Không có sản phẩm nào trong thời gian bạn chọn') );
		}
		
	}
	if ( $mod == 'get_warhouse' ) {
		$q = $nv_Request->get_string( 'q', 'get,post', '' );
		$store_id = $nv_Request->get_int( 'store_id', 'get,post', 0 );
		$list_warehouse = get_warehouse_select2( $q, $store_id );
		$json[] = ['id'=>0, 'text'=>'Chọn tất cả'];
		foreach ( $list_warehouse as $result ) {
			$json[] = ['id'=>$result['id'], 'text'=>$result['name_warehouse']];
		}
		print_r( json_encode( $json ) );
		die();
	}
	if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ) ) {
		$id = $nv_Request->get_int( 'delete_id', 'get' );
		$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
		if ( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) ) {
			$db->query( 'DELETE FROM ' . TABLE . '_order  WHERE id = ' . $db->quote( $id ) );
			$nv_Cache->delMod( $module_name );
			nv_insert_logs( NV_LANG_DATA, $module_name, 'Delete Order', 'ID: ' . $id, $admin_info['userid'] );
			nv_redirect_location( NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		}
	}
	
	$q = $nv_Request->get_title( 'q', 'post,get','' );
	$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
	$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
	$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
	$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );
	$store_id = $nv_Request->get_int( 'store_id', 'post,get', 0 );
	$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'post,get', 0 );
	$customer_id2 = $nv_Request->get_int( 'customer_id', 'post,get', 0 );
	$categories_id = $nv_Request->get_int( 'categories_id', 'post,get', 0 );
	
	if($status_ft > -1)
	{	
		$_SESSION[$module_data.'_status_view_order'] = $status_ft;
	}
	
	if ( preg_match( '/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/', $ngay_tu, $m ) )
	{
		$_hour = $nv_Request->get_int( 'add_date_hour', 'post', 0 );
		$_min = $nv_Request->get_int( 'add_date_min', 'post', 0 );
		$ngay_tu = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
		} else {
		$ngay_tu = 0;
	}
	
	
	if ( preg_match( '/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/', $ngay_den, $m ) )
	{
		$_hour = $nv_Request->get_int( 'add_date_hour', 'post', 23 );
		$_min = $nv_Request->get_int( 'add_date_min', 'post', 59 );
		$ngay_den = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
		} else {
		$ngay_den = 0;
	}
	$xtpl = new XTemplate( 'order.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
	$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
	$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'ROW', $row );
	$xtpl->assign( 'Q', $q );
	$xtpl->assign( 'warehouse_id', $warehouse_id );
	$xtpl->assign( 'customer_id_2', $customer_id2 );
	$xtpl->assign( 'store_id', $store_id );
	$xtpl->assign( 'categories_id', $categories_id );
	if($categories_id>0){
		if(get_info_category($categories_id)['parrent_id']==0){
			$categories_name='<span style="font-weight:bold">'.get_info_category($categories_id)['name'].'</span>';
			}else{
			$categories_name='<span>&emsp;'.get_info_category($categories_id)['name'].'</span>';
		}
		}else{
		$categories_name='<span style="font-weight:bold">Chọn tất cả</span>';
	}
	$xtpl->assign( 'categories_name', $categories_name );
	
	if ( $ngay_tu > 0 )
	$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
	if ( $ngay_den > 0 )
	$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
	
	if ( !empty( $_SESSION[$module_data.'_status_view_order'] ) ) {
		$xtpl->assign( 'status_view_order', $_SESSION[$module_data.'_status_view_order'] );
		} else {
		$xtpl->assign( 'status_view_order', 0 );
	}
	if ( $store_id>0 ) {
		if ( $warehouse_id>0 ) {
			$xtpl->assign( 'warehouse_name', get_info_warehouse( $warehouse_id )['name_warehouse'] );
			} else {
			$xtpl->assign( 'warehouse_name', 'Chọn tất cả' );
		}
		$xtpl->parse( 'main.store_edit' );
	}
	$xtpl->assign( 'store_id', $store_id );
	$real_week = nv_get_week_from_time( NV_CURRENTTIME );
	$week = $real_week[0];
	$year = $real_week[1];
	$this_year = $real_week[1];
	$time_per_week = 86400 * 7;
	$time_start_year = mktime( 0, 0, 0, 1, 1, $year );
	$time_first_week = $time_start_year - ( 86400 * ( date( 'N', $time_start_year ) - 1 ) );
	
	$tuannay = array(
    'from' => nv_date( 'd-m-Y', $time_first_week + ( $week - 1 ) * $time_per_week ),
    'to' => nv_date( 'd-m-Y', $time_first_week + ( $week - 1 ) * $time_per_week + $time_per_week - 1 ),
	);
	$tuantruoc = array(
    'from' => nv_date( 'd-m-Y', $time_first_week + ( $week - 2 ) * $time_per_week ),
    'to' => nv_date( 'd-m-Y', $time_first_week + ( $week - 2 ) * $time_per_week + $time_per_week - 2 ),
	);
	$tuankia = array(
    'from' => nv_date( 'd-m-Y', $time_first_week + ( $week - 3 ) * $time_per_week ),
    'to' => nv_date( 'd-m-Y', $time_first_week + ( $week - 3 ) * $time_per_week + $time_per_week - 3 ),
	);
	
	$thangnay = array(
    'from' => date( 'd-m-Y', strtotime( 'first day of this month' ) ),
    'to' => date( 'd-m-Y', strtotime( 'last day of this month' ) ),
	);
	$thangtruoc = array(
    'from' => date( 'd-m-Y', strtotime( 'first day of last month' ) ),
    'to' => date( 'd-m-Y', strtotime( 'last day of last month' ) ),
	);
	$namnay = array(
    'from' => date( 'd-m-Y', strtotime( 'first day of january this year' ) ),
    'to' => date( 'd-m-Y', strtotime( 'last day of december this year' ) ),
	);
	$namtruoc = array(
    'from' => date( 'd-m-Y', strtotime( 'first day of january last year' ) ),
    'to' => date( 'd-m-Y', strtotime( 'last day of december last year' ) ),
	);
	$xtpl->assign( 'TUANNAY', $tuannay );
	
	$xtpl->assign( 'TUANTRUOC', $tuantruoc );
	
	$xtpl->assign( 'TUANKIA', $tuankia );
	
	$xtpl->assign( 'HOMNAY', date( 'd-m-Y', NV_CURRENTTIME ) );
	$xtpl->assign( 'HOMQUA', date( 'd-m-Y', strtotime( 'yesterday' ) ) );
	$xtpl->assign( 'THANGNAY', $thangnay );
	
	$xtpl->assign( 'THANGTRUOC', $thangtruoc );
	
	$xtpl->assign( 'NAMNAY', $namnay );
	
	$xtpl->assign( 'NAMTRUOC', $namtruoc );
	
	if ( $sea_flast == '1' ) {
		$xtpl->assign( 'SELECT1', 'selected="selected"' );
	}
	if ( $sea_flast == '2' ) {
		$xtpl->assign( 'SELECT2', 'selected="selected"' );
	}
	if ( $sea_flast == '3' ) {
		$xtpl->assign( 'SELECT3', 'selected="selected"' );
	}
	if ( $sea_flast == '4' ) {
		$xtpl->assign( 'SELECT4', 'selected="selected"' );
	}
	if ( $sea_flast == '5' ) {
		$xtpl->assign( 'SELECT5', 'selected="selected"' );
	}
	if ( $sea_flast == '6' ) {
		$xtpl->assign( 'SELECT6', 'selected="selected"' );
	}
	if ( $sea_flast == '7' ) {
		$xtpl->assign( 'SELECT7', 'selected="selected"' );
	}
	if ( $sea_flast == '8' ) {
		$xtpl->assign( 'SELECT8', 'selected="selected"' );
	}
	if ( $sea_flast == '9' ) {
		$xtpl->assign( 'SELECT9', 'selected="selected"' );
	}
	$list_status = get_full_order_status();
	foreach ( $list_status as $key=>$value ) {
		if ( empty( $_SESSION[$module_data.'_status_view_order'] ) ) {
			if ( $key == 0 ) {
				$xtpl->assign( 'active', 'active' );
				} else {
				$xtpl->assign( 'active', '' );
			}
			} else {
			if ( $key == $_SESSION[$module_data.'_status_view_order'] ) {
				$xtpl->assign( 'active', 'active' );
				} else {
				$xtpl->assign( 'active', '' );
			}
		}
		$value['count_order'] = get_count_order( $value['status_id'], $store_id, $warehouse_id ,$ngay_tu,$ngay_den,$customer_id2,$categories_id);
		$xtpl->assign( 'LOOP', $value );
		$xtpl->parse( 'main.status' );
	}
	$sum_order = $db->query("SELECT count(*) FROM " . TABLE . "_order")->fetchColumn();
	$xtpl->assign( 'SUM_ORDER', $sum_order );
	
	$list_store = get_full_store();
	foreach ( $list_store as $value2 ) {
		$xtpl->assign( 'store_id_list', array(
        'key' => $value2['id'],
        'title' => $value2['company_name'],
        'selected' => ( $value2['id'] == $store_id ) ? ' selected="selected"' : '' ) );
        $xtpl->parse( 'main.store_id' );
	}
	$list_customer = get_full_customer();
	foreach ( $list_customer as $value2 ) {
		$username=get_info_user($value2['userid'])['username'];
		$xtpl->assign( 'customer_id', array(
        'key' => $value2['userid'],
        'title' => $username,
        'selected' => ( $value2['userid'] == $customer_id2 ) ? ' selected="selected"' : '' ) );
        $xtpl->parse( 'main.customer_id' );
	}
    if ( !empty( $error ) ) {
        $xtpl->assign( 'ERROR', implode( '<br />', $error ) );
        $xtpl->parse( 'main.error' );
	}
	
    $xtpl->parse( 'main' );
    $contents = $xtpl->text( 'main' );
	
    $page_title = $lang_module['order'];
	
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme( $contents );
    include NV_ROOTDIR . '/includes/footer.php';
