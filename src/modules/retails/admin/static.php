<?php

/**
* @Project NUKEVIET 4.x
* @Author VINADES.,JSC <contact@vinades.vn>
* @Copyright (C) 2020 VINADES.,JSC. All rights reserved
* @License GNU/GPL version 2 or any later version
* @Createdate Wed, 23 Dec 2020 08:30:40 GMT
*/

if (!defined('NV_IS_FILE_ADMIN'))
die('Stop!!!');
$mod = $nv_Request->get_string( 'mod', 'get,post', '' );
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
	$status = $nv_Request->get_int( 'status_search', 'post,get', 0 );
	$customer_id2 = $nv_Request->get_int( 'customer_id', 'post,get', 0 );
	$categories_id = $nv_Request->get_int( 'categories_id', 'post,get', 0 );
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
	if($status>0){
		$where .= ' AND t1.status ='.$status;
	}
	if($customer_id2>0){
		$where .= ' AND t1.userid ='.$customer_id2;
	}
	if($categories_id>0){
		$where .= ' AND t2.product_id IN (SELECT id FROM '.TABLE.'_product where categories_id='.$categories_id.')';
	}
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
		$data_array['total_discount']=$view['total']*$config_setting['percent_of_order_payment_discount']/100;
		if($view['plus_money']==0){
			$data_array['plus_money']='Chưa thanh toán';
		}else{
			$data_array['plus_money']='Đã thanh toán';
		}
		$dataContent[] = $data_array;	
	}
	if(count($dataContent)>0){
		$page_title = 'DANH SÁCH ĐƠN HÀNG';

		$Excel_Cell_Begin = 3; // Dong bat dau viet du lieu

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(NV_ROOTDIR . '/modules/' . $module_file . '/template_excel/order_static.xlsx');
 
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
		$array_key_data[] = 'total_discount';
		$array_key_data[] = 'plus_money';
		
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
		nv_jsonOutput( array('error'=> 'Không có đơn hàng trong thời gian bạn chọn') );
	}	
}

$count_full=$db->query('SELECT count(*) FROM '.TABLE.'_seller_management')->fetchColumn();
$count_active=$db->query('SELECT count(*) FROM '.TABLE.'_seller_management where status=1')->fetchColumn();
$count_no_active=$db->query('SELECT count(*) FROM '.TABLE.'_seller_management where status=0')->fetchColumn();

$where = '';
$store_id = $nv_Request->get_int( 'store_id', 'post,get', 0 );
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );
$customer_id2 = $nv_Request->get_int( 'customer_id', 'post,get', 0 );
$categories_id = $nv_Request->get_int( 'categories_id', 'post,get', 0 );

if($store_id > 0){
	$where .= ' AND t1.store_id ='.$store_id;
	$base_url .= '&store_id=' . $store_id;
}
if($status_ft>-1){
	$where .= ' AND t1.status ='.$status_ft;
	$base_url .= '&status_search=' . $status_ft;
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
if($customer_id2>0){
	$where .= ' AND t1.userid ='.$customer_id2;
	$base_url .= '&customer_id=' . $customer_id2;
}
if($categories_id>0){
	$where .= ' AND t2.product_id IN (SELECT id FROM '.TABLE.'_product where categories_id='.$categories_id.')';
	$base_url .= '&categories_id=' . $categories_id;
}
$per_page = 15;
$page = $nv_Request->get_int('page', 'post,get', 0);
if($page==0){
	$page_new=1;
}else{
	$page_new=$page;
}
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
	->limit($per_page)
	->offset(($page_new - 1) * $per_page)
	->where('1=1'.$where.' group by t1.id');
$sth = $db->prepare($db->sql());

$sth->execute();

$total_product_list=$db->query('SELECT SUM(DISTINCT t1.total_product) as total FROM '.TABLE.'_order t1 INNER JOIN '.TABLE.'_order_item t2 ON t1.id=t2.order_id INNER JOIN '.TABLE.'_product t3 ON t2.product_id=t3.id where 1=1'.$where.' group by t1.id')->fetchAll();
$total_product=0;
foreach($total_product_list as $value){
	$total_product=$total_product+$value['total'];
}

$fee_transport=$db->query('SELECT SUM(DISTINCT t1.fee_transport) as fee_transport FROM '.TABLE.'_order t1 INNER JOIN '.TABLE.'_order_item t2 ON t1.id=t2.order_id INNER JOIN '.TABLE.'_product t3 ON t2.product_id=t3.id where 1=1'.$where.' group by t1.id')->fetchAll();
$total_fee_transport=0;
foreach($fee_transport as $value){
	$total_fee_transport=$total_fee_transport+$value['fee_transport'];
}

$total_discount_list=$db->query('SELECT SUM(total_product) as total_product FROM '.TABLE.'_order t1 INNER JOIN ' . TABLE . '_order_item t2 ON t2.order_id=t1.id where 1=1'.$where)->fetchColumn();
$total_discount=$total_discount_list*$config_setting['percent_of_order_payment_discount']/100;
$total_discount_paid=$db->query('SELECT SUM(total_product) as total_product FROM '.TABLE.'_order t1 INNER JOIN ' . TABLE . '_order_item t2 ON t2.order_id=t1.id where 1=1'.$where.' and t1.plus_money=1')->fetchColumn();
$total_discount_paid_number=$total_discount_paid*$config_setting['percent_of_order_payment_discount']/100;

$xtpl = new XTemplate('static.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('count_full', number_format($count_full));
$xtpl->assign('count_active', number_format($count_active));
$xtpl->assign('count_no_active', number_format($count_no_active));
$xtpl->assign('total_product', number_format($total_product));
$xtpl->assign('total_fee_transport', number_format($total_fee_transport));
$xtpl->assign('total_discount', number_format($total_discount));
$xtpl->assign('total_discount_paid_number', number_format($total_discount_paid_number));
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

$date_start=strtotime(date('d-m-Y',NV_CURRENTTIME));
$date_end=strtotime('+23 hours 59 minutes', $date_start);
$month_start = strtotime(date('d-m-Y',strtotime('first day of this month', NV_CURRENTTIME)));
$month_end1 = strtotime(date('d-m-Y',strtotime('last day of this month', NV_CURRENTTIME)));
$month_end=strtotime('+23 hours 59 minutes', $month_end1);

$year_start = strtotime(date('d-m-Y',strtotime('first day of January', NV_CURRENTTIME)));
$ỷear_end1 = strtotime(date('d-m-Y',strtotime('last day of December', NV_CURRENTTIME)));
$ỷear_end=strtotime('+23 hours 59 minutes', $ỷear_end1);
	if ( $ngay_tu > 0 )
	$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
	if ( $ngay_den > 0 )
	$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
if($page==0){

	$list_status = get_full_order_status();
	foreach ( $list_status as $key=>$value ) {
		$value['count']=$db->query('SELECT count(*) FROM '.TABLE.'_order where status='.$value['status_id'].' and time_add>='.$date_start.' and time_add <= '.$date_end)->fetchColumn();
		$value['count_month']=$db->query('SELECT count(*) FROM '.TABLE.'_order where status='.$value['status_id'].' and time_add>='.$month_start.' and time_add <= '.$month_end)->fetchColumn();
		$value['count_year']=$db->query('SELECT count(*) FROM '.TABLE.'_order where status='.$value['status_id'].' and time_add>='.$year_start.' and time_add <= '.$ỷear_end)->fetchColumn();
		$xtpl->assign('status', $value);
		$xtpl->parse('main.first.status');
		$xtpl->parse('main.first.status2');
		$xtpl->parse('main.first.status3');
	}
}


$generate_page = nv_generate_page_viewcat($base_url, $num_items, $per_page, $page_new, 'true', 'false', 'nv_urldecode_ajax', 'form');
if (!empty($generate_page)) {
	$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
	$xtpl->parse('main.generate_page');
}

$number = $page_new > 1 ? ($per_page * ($page_new - 1)) + 1 : 1;
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

while ($view = $sth->fetch()) {
	$view['number'] = $number++;
	$view['store_name']=get_info_store($view['store_id'])['company_name'];
	$view['warehouse_name']=get_info_warehouse($view['warehouse_id'])['name_warehouse'];
	$view['phone_warehouse']=get_info_warehouse($view['warehouse_id'])['phone_send'];
	$info_warehouse = get_info_warehouse( $view['warehouse_id'] );
	$view['address_warehouse'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
	$view['address_receive'] = $view['address'].', '.get_info_ward( $view['ward_id'] )['title'].', '.get_info_district( $view['district_id'] )['title'].', '.get_info_province( $view['province_id'] )['title'];
	$view['transporters_name']=get_info_transporters($view['transporters_id'])['name_transporters'];
	$view['total_discount_full']=$view['total_product']*$config_setting['percent_of_order_payment_discount']/100;

	$view['total_product']=number_format($view['total_product']);
	$view['fee_transport']=number_format($view['fee_transport']);
	if($view['plus_money']==1){
		$view['total_discount2']='Đã thanh toán';
	}else{
		$view['total_discount2']='Chưa thánh toán';
	}
	
	$view['total_discount_full']=number_format($view['total_discount_full']);
	$view['time_add']=date('d-m-Y H:i',$view['time_add']);
	if($view['payment_method']==0){
		$view['payment_method']='Thanh toán khi nhận hàng';
	}else{
		$view['payment_method']='Thanh toán qua ví tiền';
	}
	$view['link_view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view_order&amp;id=' . $view['id'].'&store_id='.$view['store_id'].'&warehouse_id='.$view['warehouse_id'];
	$view['status_name']=get_info_order_status($view['status'])['name'];
	$xtpl->assign('VIEW', $view);
	$xtpl->parse('main.loop');
}
if($page==0){
	$list_store = get_full_store();
	foreach ( $list_store as $value2 ) {
		$xtpl->assign( 'store_id_list', array(
		'key' => $value2['id'],
		'title' => $value2['company_name'].' (Người đại diện: '.$value2['name'].')',
		'selected' => ( $value2['id'] == $store_id ) ? ' selected="selected"' : '' ) );
		$xtpl->parse( 'main.first.store_id' );
	}
	$list_status = get_full_order_status();
	foreach ( $list_status as $value2 ) {
		$xtpl->assign( 'status_search', array(
		'key' => $value2['status_id'],
		'title' => $value2['name'],
		'selected' => ( $value2['status_id'] == $status_ft ) ? ' selected="selected"' : '' ) );
		$xtpl->parse( 'main.first.status_search' );
	}
	$list_customer = get_full_customer();
	foreach ( $list_customer as $value2 ) {
		$username=get_info_user($value2['userid'])['username'];
		$xtpl->assign( 'customer_id', array(
			'key' => $value2['userid'],
			'title' => $username,
			'selected' => ( $value2['userid'] == $customer_id2 ) ? ' selected="selected"' : '' ) );
			$xtpl->parse( 'main.first.customer_id' );
	}
	$xtpl->parse('main.first');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['static'];
if($page==0){
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
}else{
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents,false);
	include NV_ROOTDIR . '/includes/footer.php';
}