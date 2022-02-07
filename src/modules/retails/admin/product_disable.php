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
	
	
	if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
		$id = $nv_Request->get_int('delete_id', 'get');
		$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
		if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        	
			
			$db->query('DELETE FROM ' . TABLE . '_product WHERE id=' . intval($id));
			
			$nv_Cache->delMod($module_name);
			nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Product', 'ID: ' . $id, $admin_info['userid']);
			
			
		}
	}
	
	
	// Change status
	if ($nv_Request->isset_request('change_status', 'post, get')) {
		$id = $nv_Request->get_int('id', 'post, get', 0);
		$content = 'NO_' . $id;
		
		$query = 'SELECT inhome FROM ' . TABLE . '_product WHERE id=' . $id;
		$row = $db->query($query)->fetch();
		if (isset($row['inhome']))     {
			$inhome = ($row['inhome']) ? 0 : 1;
			$query = 'UPDATE ' . TABLE . '_product SET inhome=' . intval($inhome) . ' WHERE id=' . $id;
			$db->query($query);
			$content = 'OK_' . $id;
		}
		$nv_Cache->delMod($module_name);
		include NV_ROOTDIR . '/includes/header.php';
		echo $content;
		include NV_ROOTDIR . '/includes/footer.php';
	}
	
	$where = '';
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	$q = $nv_Request->get_title( 'q', 'post,get' );
	$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
	$catalogy = $nv_Request->get_int( 'catalogy', 'post,get',0);
	$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
	$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
	$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );
	$parrent_id = $nv_Request->get_int( 'parrent_id', 'post,get', 0 );
	$store_id = $nv_Request->get_int( 'store_id', 'post,get', 0 );
	
	
	if ( $catalogy) {
		// lấy danh sách loại con
		$get_parent_catalogy = get_list_category($catalogy);
		$array_catalogy = array();
		$array_catalogy[] = $catalogy;
		foreach($get_parent_catalogy as $cata)
		{
			$array_catalogy[] = $cata['id'];
		}
		$where .= ' AND categories_id IN('. implode(',',$array_catalogy).')';
		
		$base_url .= '&catalogy=' . $catalogy;
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
			
			$where .= ' AND time_add >= '. $ngay_tu . ' AND time_add <= '. $ngay_den;
			$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
		} else if ( $ngay_tu > 0 )
		{
			$where .= ' AND time_add >= '. $ngay_tu;
			$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
		} else if ( $ngay_den > 0 )
		{
			$where .= ' AND time_add <= '. $ngay_den;
			$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
		}
		
	}
	
	
	if ( $status_ft>-1 ) {
		$where .= ' AND inhome ='.$status_ft;
		$base_url .= '&status_search=' . $status_ft;
	}
	if ( !empty( $q ) ) {
		$where .= ' AND (name_product LIKE "%" "'.$q. '" "%")';
		$base_url .= '&q=' . $q;
	}
	if($store_id>0){
			$where .= ' AND store_id ='.$store_id;
		}
	
	// Fetch Limit
	$show_view = false;
	if (!$nv_Request->isset_request('id', 'post,get')) {
		$show_view = true;
		$per_page = 20;
		$page = $nv_Request->get_int('page', 'post,get', 1);
		$db->sqlreset()
		->select('COUNT(*)')
		->from(''. TABLE . '_product')
		->where('status = 1 AND inhome < 1 '.$where);
		
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('*')
		->order('id DESC')
		->limit($per_page)
		->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		
	}
	$contents = nv_theme_retailshops_list_product_new($sth,$per_page,$page,$num_items,$base_url,$ngay_tu,$ngay_den,$status_ft,$sea_flast,$show_view,$q,$catalogy,$store_id);
	
	$page_title = $lang_module['product_disable'];
	$array_mod_title[] = array(
	'catid' => 0,
	'title' => $page_title,
	'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.$op.'/'
	);
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
