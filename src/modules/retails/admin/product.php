<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2020 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Thu, 24 Dec 2020 01:27:14 GMT
	*/
	
	if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
	
	$mod = $nv_Request->get_string('mod', 'post, get', 0);
	$q = $nv_Request->get_title( 'q', 'post,get' );
	$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
	$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
	$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
	$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );
	$parrent_id = $nv_Request->get_int( 'parrent_id', 'post,get', 0 );
	$store_id = $nv_Request->get_int( 'store_id', 'post,get', 0 );
	$block_id = $nv_Request->get_int( 'block_id', 'post,get', 0 );
	
	$xtpl = new XTemplate('product.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	$xtpl->assign('product_add', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=product_add');
	
	$where = '';
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	
	
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
		$where .= ' AND (t1.name_product LIKE "%" "'.$q. '" "%")';
		$base_url .= '&q=' . $q;
	}
	
	if($store_id>0){
		$where .= ' AND t1.store_id ='.$store_id;
		$base_url .= '&store_id=' . $store_id;
	}
	
	if($block_id>0){
		$where .= ' AND t2.bid ='.$block_id;
		$base_url .= '&block_id=' . $block_id;
	}
	
	 
	
	if ( $ngay_tu > 0 )
	$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
	if ( $ngay_den > 0 )
	$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
	
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
		
		$status_arr = array();
		$status_arr['0'] = 'Đã ẩn';
		$status_arr['1'] = 'Hiển thị';
		$status_arr['-1'] = 'Đã xóa';
		
		$list_product = $db->query('SELECT * FROM ' . TABLE .'_product WHERE 1'. $where . ' ORDER BY store_id')->fetchAll();
		
		$stt = 0;
		foreach ($list_product as $view) {
			
			$data_array = array();
			// số thứ tự
			$data_array['stt'] = ++$stt;
			
			// tên seller & người đại diện
			$store_info = $db->query("SELECT company_name, name FROM " . TABLE . "_seller_management where id=" . $view['store_id'])->fetch();
			$data_array['company_name'] = $store_info['company_name'] . ' (Người đại diện: ' . $store_info['name'] . ')';
			
			// mã vạch
			$data_array['barcode'] = $view['barcode'];
			
			// tên sản phẩm
			$data_array['name_product'] = $view['name_product'];
			
			// link sản phẩm
			$data_array['alias'] = NV_MY_DOMAIN .'/'.$view['alias'].'-'.$view['id'].'/';
			
			// danh mục
			$current_category = $db->query('SELECT parrent_id FROM '. TABLE .'_categories WHERE id = '. $view['categories_id'])->fetchColumn();
			if($current_category > 0){
				$category = $db->query('SELECT t1.name, t2.name AS parent_name, t1.parrent_id FROM '. TABLE .'_categories t1 INNER JOIN '. TABLE .'_categories t2 ON t1.parrent_id = t2.id WHERE t1.id = '. $view['categories_id'])->fetch();
				$data_array['category'] = $category['name'];
				while($category['parrent_id']>0){
					$data_array['category'] = $category['parent_name'] . '/' . $data_array['category'];
					$data_array['main_category'] = $category['parent_name'];
					$category = $db->query('SELECT t1.name, t2.name AS parent_name, t1.parrent_id FROM '. TABLE .'_categories t1 INNER JOIN '. TABLE .'_categories t2 ON t1.parrent_id = t2.id WHERE t1.id = '. $category['parrent_id'])->fetch();
				}
			} else{
				$data_array['category'] = $db->query('SELECT name FROM '. TABLE .'_categories WHERE id = '. $view['categories_id'])->fetchColumn();
				$data_array['main_category'] = $data_array['category'];
			}
			// ngành hàng
			
			// Khối lượng & đơn vị
			$data_array['weight_product'] = $view['weight_product'];
			$data_array['unit_weight'] = get_info_unit_weight($view['unit_weight'])['name_weight'];
			//print($data_array['unit_weight']);die;
			
			// Chiều dài & đơn vị
			$data_array['length_product']=$view['length_product'];
			$data_array['unit_length']=get_info_unit_length($view['unit_length'])['name_length'];
			
			// chiều rộng & đơn vị
			$data_array['width_product']=$view['width_product'];
			$data_array['unit_width']=get_info_unit_length($view['unit_width'])['name_length'];
			
			// chiều cao & đơn vị
			$data_array['height_product']=$view['height_product'];
			$data_array['unit_height']=get_info_unit_length($view['unit_height'])['name_length'];
			
			// status
			$data_array['status']=$status_arr[$view['inhome']];
			
			// thuộc tính sản phẩm
			$classify = $db->query('SELECT * FROM ' . TABLE . '_product_classify_value_product WHERE product_id = ' . $view['id'])->fetchAll();
			if(!$classify[0]['classify_id_value1'] && !$classify[0]['classify_id_value2']){ // nếu sp không có thuộc tính
				
				// thuộc tính
				$data_array['classify'] = 'none'; 
				
				// giá niêm yết
				$data_array['price_special'] = $view['price_special'];
				
				// giá bán
				$data_array['price'] = $view['price'];
				
				// tồn kho
				$data_array['warehouse'] =  $classify[0]['sl_tonkho'];
			} else if($classify[0]['classify_id_value2']){// nếu có 2 thuộc tính
				foreach($classify as $item){
					$temp1 = $db->query('SELECT t1.name, t2.name_classify FROM '. TABLE .'_product_classify_value t1 INNER JOIN '. TABLE .'_product_classify t2 ON t1.classify_id = t2.id WHERE t1.id = ' . $item['classify_id_value1'])->fetch();
					$temp2 = $db->query('SELECT t1.name, t2.name_classify FROM '. TABLE .'_product_classify_value t1 INNER JOIN '. TABLE .'_product_classify t2 ON t1.classify_id = t2.id WHERE t1.id = ' . $item['classify_id_value2'])->fetch();
					$item_value['name'] = $temp1['name_classify'] . '/' . $temp1['name'] . ' - ' . $temp2['name_classify'] . '/' . $temp2['name'];
					$item_value['price_special'] = $item['price_special'];
					$item_value['price'] = $item['price'];
					$item_value['warehouse'] = $item['sl_tonkho'];
					$data_array['classify'][] = $item_value;
				}
			} else{ // nếu có 1 thuộc tính
				foreach($classify as $item){
					$temp = $db->query('SELECT t1.name, t2.name_classify FROM '. TABLE .'_product_classify_value t1 INNER JOIN '. TABLE .'_product_classify t2 ON t1.classify_id = t2.id WHERE t1.id = ' . $item['classify_id_value1'])->fetch();
					$item_value['name'] = $temp['name_classify'] . '/' . $temp['name'];
					$item_value['price_special'] = $item['price_special'];
					$item_value['price'] = $item['price'];
					$item_value['warehouse'] = $item['sl_tonkho'];
					$data_array['classify'][] = $item_value;
				}
			}
			$dataContent[] = $data_array;	
		}
		
		$page_title = 'DANH SÁCH SẢN PHẨM';
		
		$Excel_Cell_Begin = 1; // Dong bat dau viet du lieu
		
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(NV_ROOTDIR . '/modules/' . $module_file . '/template_excel/product_shopsfull.xlsx');
		
		
		$worksheet = $spreadsheet->getActiveSheet();
		
		$worksheet->setTitle( $page_title );
		
		// Set page orientation and size
		$worksheet->getPageSetup()->setOrientation( phpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE );
		$worksheet->getPageSetup()->setPaperSize( phpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4 );
		$worksheet->getPageSetup()->setHorizontalCentered( true );
		
		$spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd( 1, $Excel_Cell_Begin );
		
		/*// ngày xuất
			$TextColumnDate = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex( 2 );
			if(!$ngay_tu && !$ngay_den){
			$worksheet->setCellValue( $TextColumnDate . 2, 'Toàn thời gian');
			} else{
			$worksheet->setCellValue( $TextColumnDate . 2, date( 'd-m-Y', $ngay_tu ) . ' - ' . date( 'd-m-Y', $ngay_den ));
		}*/
		// Du lieu
		$array_key_data = array();
		$array_key_data[] = 'stt';
		$array_key_data[] = 'status';
		$array_key_data[] = 'company_name';
		$array_key_data[] = 'barcode';
		$array_key_data[] = 'name_product';
		$array_key_data[] = 'alias';
		$array_key_data[] = 'main_category';
		$array_key_data[] = 'category';
		$array_key_data[] = 'weight_product';
		//$array_key_data[] = 'unit_weight';
		$array_key_data[] = 'length_product';
		//$array_key_data[] = 'unit_length';
		$array_key_data[] = 'width_product';
		//$array_key_data[] = 'unit_width';
		$array_key_data[] = 'height_product';
		//$array_key_data[] = 'unit_height';
		$array_key_data[] = 'classify';
		$array_key_data[] = 'price_special';
		$array_key_data[] = 'price';
		$array_key_data[] = 'warehouse';
		$key_classify[] = 'name';
		$key_classify[] = 'price_special';
		$key_classify[] = 'price';
		$key_classify[] = 'warehouse';
		
		$pRow = $Excel_Cell_Begin;
		foreach ($dataContent as $row) 
		{
			$columnIndex2 = 0;
			$pRow++;
			if($row['classify'] == 'none'){ // nếu không có thuộc tính
				foreach( $array_key_data as $key_data )
				{
					++$columnIndex2;
					$TextColumnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex( $columnIndex2 );
					$worksheet->setCellValue( $TextColumnIndex . $pRow, $row[$key_data] );
				}
			} else{// nếu có thuộc tính
				$count = count($row['classify']);
				$tempRow = $pRow;
				$merge_row = $pRow + $count - 1;
				foreach( $array_key_data as $key_data ){
					++$columnIndex2;
					if($key_data != 'classify'){
						$TextColumnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex( $columnIndex2 );
						$worksheet->setCellValue( $TextColumnIndex . $pRow, $row[$key_data] );
						$spreadsheet->getActiveSheet()->mergeCells($TextColumnIndex . $pRow . ':' . $TextColumnIndex . $merge_row);
					} else{
						foreach($row['classify'] as $item){
							$tempCol = $columnIndex2;
							foreach($key_classify as $key){
								$TextColumn = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex( $tempCol );
								$worksheet->setCellValue( $TextColumn . $tempRow, $item[$key] );
								$tempCol++;
							}
							$tempRow++;
						}
						break;
					}
				}
				$pRow = $merge_row;
			}
		}
		
		
		$file_name = 'Danh_sach_san_pham.xlsx';
		
		$file_path = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $file_name;
		
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="'. $file_name .'"' );
		header( 'Cache-Control: max-age=0' );
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save($file_path);
		
		$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '='.$op.'&mod=download&file_name=' . $file_name;  
		
		die($link);	
		
	}
	
	
	// Change status
	if ($nv_Request->isset_request('change_status', 'post, get')) {
		$id = $nv_Request->get_int('id', 'post, get', 0);
		$content = 'NO_' . $id;
		
		$query = 'SELECT inhome FROM ' . TABLE . '_product WHERE id=' . $id;
		$row = $db->query($query)->fetch();
		
		if (isset($row['inhome']))     {
			$inhome = ($row['inhome'] > 0) ? 0 : 1;
			
			if(!$inhome)
			$inhome = -1;
			
			$query = 'UPDATE ' . TABLE . '_product SET inhome=' . intval($inhome) . ' WHERE id=' . $id;
			$db->query($query);
			$content = 'OK_' . $id;
		}
		$nv_Cache->delMod($module_name);
		include NV_ROOTDIR . '/includes/header.php';
		echo $content;
		include NV_ROOTDIR . '/includes/footer.php';
	}
	
	if ($nv_Request->isset_request('ajax_action', 'post')) {
		$id = $nv_Request->get_int('id', 'post', 0);
		$new_vid = $nv_Request->get_int('new_vid', 'post', 0);
		$content = 'NO_' . $id;
		if ($new_vid > 0)     {
			$sql = 'SELECT id FROM ' . TABLE . '_product WHERE id!=' . $id . ' ORDER BY weight ASC';
			$result = $db->query($sql);
			$weight = 0;
			while ($row = $result->fetch())
			{
				++$weight;
				if ($weight == $new_vid) ++$weight;             $sql = 'UPDATE ' . TABLE . '_product SET weight=' . $weight . ' WHERE id=' . $row['id'];
				$db->query($sql);
			}
			$sql = 'UPDATE ' . TABLE . '_product SET weight=' . $new_vid . ' WHERE id=' . $id;
			$db->query($sql);
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
			
			$db->query('UPDATE ' . TABLE . '_product SET status = 0, inhome = -1 WHERE id=' . intval($id));
			
			$nv_Cache->delMod($module_name);
			nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Product', 'ID: ' . $id, $admin_info['userid']);
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	
	
	
	
	// Fetch Limit
	$show_view = false;
	if (!$nv_Request->isset_request('id', 'post,get')) {
		$show_view = true;
		$per_page = 20;
		$page = $nv_Request->get_int('page', 'post,get', 1);
		$db->sqlreset()
        ->select('COUNT(*)')
        ->from(TABLE . '_product t1')
		->join(' LEFT JOIN ' . TABLE . '_block_id t2 ON t1.id = t2.product_id')
		->where('t1.status = 1 AND t1.inhome = 1 '.$where);
		
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('t1.*, t2.bid')
        ->order('t1.time_add DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		
		//die($db->sql()); 
		
		$sth->execute();
	}
	
	
	
	if ($show_view) {
		$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
		
		if (!empty($generate_page)) {
			$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
			$xtpl->parse('main.view.generate_page');
		}
		$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
		
		while ($view = $sth->fetch()) {
			
			for($i = 1; $i <= $num_items; ++$i) {
				$xtpl->assign('WEIGHT', array(
                'key' => $i,
                'title' => $i,
                'selected' => ($i == $view['weight']) ? ' selected="selected"' : ''));
				$xtpl->parse('main.view.loop.weight_loop');
			}
			$view['user_add']=get_info_user($view['user_add'])['username'];
			$view['time_add']=date('d/m/Y H:i',$view['time_add']);
			if(empty($view['user_edit'])){
				$view['user_edit']='Chưa cập nhật';
				$view['time_edit']='Chưa cập nhật';
				}else{
				$view['user_edit']=get_info_user($view['user_edit'])['username'];
				$view['time_edit']=date('d/m/Y H:i',$view['time_edit']);
			}
			
			// thông tin kho
			
			// lấy số lượng tồn kho
			$view['warehouse'] = $db->query('SELECT sum(sl_tonkho) as sum FROM ' . TABLE .'_product_classify_value_product WHERE status = 1 AND product_id ='. $view['id'])->fetchColumn();
			$view['warehouse'] =  number_format($view['warehouse']);
			$xtpl->assign( 'warehouse', $view['warehouse']);
			
			
			
			$view['store_id']=get_info_store($view['store_id'])['company_name'].' (Người đại diện: '.get_info_store($view['store_id'])['name'].')';
			$view['alias'] = NV_MY_DOMAIN .'/'.$view['alias'].'-'.$view['id'].'/';
			//$view['categories_id'] = get_info_category($view['categories_id'])['name'];
			
			// lấy danh mục
			$current_category = $db->query('SELECT parrent_id FROM '. TABLE .'_categories WHERE id = '. $view['categories_id'])->fetchColumn();
			if($current_category > 0){
				$category = $db->query('SELECT t1.name, t2.name AS parent_name, t1.parrent_id FROM '. TABLE .'_categories t1 INNER JOIN '. TABLE .'_categories t2 ON t1.parrent_id = t2.id WHERE t1.id = '. $view['categories_id'])->fetch();
				
				$view['category'] = $category['name'];
				while($category['parrent_id']>0){
					$view['category'] = $category['parent_name'] . '/' . $view['category'];
					$category = $db->query('SELECT t1.name, t2.name AS parent_name, t1.parrent_id FROM '. TABLE .'_categories t1 INNER JOIN '. TABLE .'_categories t2 ON t1.parrent_id = t2.id WHERE t1.id = '. $category['parrent_id'])->fetch();
				}
				} else{
				$view['category'] = $db->query('SELECT name FROM '. TABLE .'_categories WHERE id = '. $view['categories_id'])->fetchColumn();
			}
			
			// ảnh sản phẩm
			if (!empty($view['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $view['image'])) {
				$view['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
				}elseif (!empty($view['image'])){
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$view['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
			}
			
			// giá niêm yết
			$view['price_special'] = number_format($view['price_special']);
			
			// giá bán
			$view['price'] = number_format($view['price']);
			
			$xtpl->assign('CHECK_NB', $view['bid'] == 1 ? 'checked' : '');
			$xtpl->assign('CHECK', $view['inhome'] == 1 ? 'checked' : '');
			$view['link_import_warehouse'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=product_import_warehouse&amp;id=' . $view['id'];
			$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=product_add&amp;id=' . $view['id'];
			$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
			$xtpl->assign('VIEW', $view);
			
			
			$xtpl->parse('main.view.loop');
		}
		
		
		// danh sách block sản phẩm
		$list_block = $db->query('SELECT * FROM ' . TABLE .'_block WHERE status = 1 ORDER BY weight ASC')->fetchAll();
		foreach($list_block as $value){
			$xtpl->assign('block_id', array(
			'key' => $value['id'],
			'title' => $value['title'],
			'selected' => ($value['id'] == $block_id) ? ' selected="selected"' : ''));
			$xtpl->parse('main.view.block_id');
		}
		
		
		$list_store=get_full_store();
		foreach($list_store as $value){
			$xtpl->assign('store_id', array(
			'key' => $value['id'],
			'title' => $value['company_name'].' (Người đại diện: '.$value['name'].')',
			'selected' => ($value['id'] == $store_id) ? ' selected="selected"' : ''));
			$xtpl->parse('main.view.store_id');
		}
		$xtpl->parse('main.view');
	}
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['product'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
