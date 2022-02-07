<?php

/**
* @Project NUKEVIET 4.x
* @Author VINADES.,JSC <contact@vinades.vn>
* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
* @License GNU/GPL version 2 or any later version
* @Createdate Fri, 05 Mar 2021 04:02:08 GMT
*/

if (!defined('NV_IS_FILE_ADMIN'))
die('Stop!!!');
$mod = $nv_Request->get_string('mod', 'post, get', 0);

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
	$where = '';
	$q = $nv_Request->get_title( 'q', 'post,get' );
	$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
	$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
	$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
	$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );

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
		} else if ( $ngay_tu > 0 )
		{
			$where .= ' AND t1.time_add >= '. $ngay_tu;
		} else if ( $ngay_den > 0 )
		{
			$where .= ' AND t1.time_add <= '. $ngay_den;
		}

	}
	if ( $status_ft>-1 ) {
		$where .= ' AND t1.status ='.$status_ft;
	}
	if ( !empty( $q ) ) {
		$where .= ' AND (t2.last_name LIKE "%" "'.$q. '" "%" OR t2.first_name LIKE "%" "'.$q. '" "%" OR t2.email LIKE "%" "'.$q. '" "%" OR t1.phone LIKE "%" "'.$q. '" "%")';
	}
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_customer t1')
	->join('INNER JOIN ' . NV_TABLE_USER . ' t2 ON t1.userid=t2.userid')
	->where('1=1'.$where);

	$sth = $db->prepare($db->sql());

	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select('t1.*,t2.first_name,t2.last_name,t2.email')
	->order('t1.id DESC');
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$data_array = array();
	$dataContent = array();
	$stt = 0;
	while ($view = $sth->fetch()) {
		$data_array['stt']=++$stt;
		$data_array['first_name']=$view['first_name'];
		$data_array['last_name']=$view['last_name'];
		$data_array['phone']=$view['phone'];
		$data_array['email']=$view['email'];
		
		$dataContent[] = $data_array;	
	}
	if(count($dataContent)>0){
		$page_title = 'DANH SÁCH KHÁCH HÀNG';

		$Excel_Cell_Begin = 2; // Dong bat dau viet du lieu

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(NV_ROOTDIR . '/modules/' . $module_file . '/template_excel/customer.xlsx');

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
		$array_key_data[] = 'first_name';
		$array_key_data[] = 'last_name';
		$array_key_data[] = 'phone';
		$array_key_data[] = 'email';
		$pRow = $Excel_Cell_Begin;
		
		foreach( $dataContent as $row )
		{
			$pRow++;
			$columnIndex2 = 0;

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



		




		$file_name = 'danh_sach_khach_hang.xlsx';
		
		$file_path = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $file_name;
		
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="'. $file_name .'"' );
		header( 'Cache-Control: max-age=0' );

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save($file_path);
		$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '='.$op.'&mod=download&file_name=' . $file_name;  
		
		nv_jsonOutput( array('link'=> $link) );		
	}else{
		nv_jsonOutput( array('error'=> 'Không có khách hàng nào trong thời gian bạn chọn') );
	}	
}
// Change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
	$id = $nv_Request->get_int('id', 'post, get', 0);
	$content = 'NO_' . $id;

	$query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_customer WHERE id=' . $id;
	$row = $db->query($query)->fetch();
	if (isset($row['status']))     {
		$status = ($row['status']) ? 0 : 1;
		$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_customer SET status=' . intval($status) . ' WHERE id=' . $id;
		$userid = $db->query('SELECT userid FROM '.TABLE.'_customer where id='.$id)->fetchColumn();
		$db->query('UPDATE '.NV_TABLE_USER.' SET active='.$status.' where userid='.$userid);
		$db->query($query);
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod($module_name);
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
	$id = $nv_Request->get_int('delete_id', 'get');
	$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
	if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_customer  WHERE id = ' . $db->quote($id));
		$nv_Cache->delMod($module_name);
		nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Customer', 'ID: ' . $id, $admin_info['userid']);
		nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
	}
}


$where = '';
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$q = $nv_Request->get_title( 'q', 'post,get' );
$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );

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
if ( $status_ft>-1 ) {
	$where .= ' AND t1.status ='.$status_ft;
	$base_url .= '&status_search=' . $status_ft;
}
if ( !empty( $q ) ) {
	$where .= ' AND (t2.last_name LIKE "%" "'.$q. '" "%" OR t2.first_name LIKE "%" "'.$q. '" "%" OR t2.email LIKE "%" "'.$q. '" "%" OR t1.phone LIKE "%" "'.$q. '" "%")';
	$base_url .= '&q=' . $q;
}
// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_customer t1')
	->join('INNER JOIN ' . NV_TABLE_USER . ' t2 ON t1.userid=t2.userid')
	->where('1=1'.$where);

	$sth = $db->prepare($db->sql());

	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select('t1.*,t2.first_name,t2.last_name,t2.email')
	->order('id DESC')
	->limit($per_page)
	->offset(($page - 1) * $per_page);
	$sth = $db->prepare($db->sql());

	$sth->execute();
}

$xtpl = new XTemplate('customer.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
$xtpl->assign('Q', $q);
if ( $ngay_tu > 0 )
$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
if ( $ngay_den > 0 )
$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );

if ($show_view) {
	$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
	if (!empty($generate_page)) {
		$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
		$xtpl->parse('main.view.generate_page');
	}
	$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
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
	$status_filt = array();
	$status_filt[] = array( 'id'=>-1, 'text'=>'Tất cả trạng thái' );
	$status_filt[] = array( 'id'=>0, 'text'=>'Ngưng Hoạt động' );
	$status_filt[] = array( 'id'=>1, 'text'=>'Hoạt động' );

	foreach ( $status_filt as $filt_stt ) {
		if ( $filt_stt['id'] == $status_ft ) {
			$filt_stt['selected'] = 'selected';
		}
		$xtpl->assign( 'status_filt', $filt_stt );
		$xtpl->parse( 'main.view.status_filt' );
	}
	while ($view = $sth->fetch()) {
		$view['number'] = $number++;
		$xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=customer_add&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
		$view['user_add']=get_info_user($view['user_add'])['username'];
		$view['time_add']=date('d/m/Y H:i',$view['time_add']);
		if(empty($view['user_edit'])){
			$view['user_edit']='Chưa cập nhật';
			$view['time_edit']='Chưa cập nhật';
		}else{
			$view['user_edit']=get_info_user($view['user_edit'])['username'];
			$view['time_edit']=date('d/m/Y H:i',$view['time_edit']);
		}
		$xtpl->assign('VIEW', $view);
		$xtpl->parse('main.view.loop');
	}
	$xtpl->parse('main.view');
}


if (!empty($error)) {
	$xtpl->assign('ERROR', implode('<br />', $error));
	$xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['customer'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
