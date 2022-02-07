<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Mon, 25 Oct 2021 10:03:59 GMT
	*/
	
	if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
	
	if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
		$id = $nv_Request->get_int('delete_id', 'get');
		$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
		if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish  WHERE id = ' . $db->quote($id));
			$nv_Cache->delMod($module_name);
			nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Order_punish', 'ID: ' . $id, $admin_info['userid']);
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	
	$row = array();
	$error = array();
	$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
	if ($nv_Request->isset_request('submit', 'post')) {
		$row['order_id'] = $nv_Request->get_int('order_id', 'post', 0);
		$row['penalize_id'] = $nv_Request->get_int('penalize_id', 'post', 0);
		
		if (empty($row['penalize_id'])) {
			$error[] = $lang_module['error_required_penalize_id'];
		}
		
		if (empty($error)) {
			try {
				if (empty($row['id'])) {
					$row['time_add'] = 0;
					
					$stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish (order_id, penalize_id, time_add) VALUES (:order_id, :penalize_id, :time_add)');
					
					$stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
					
					} else {
					$stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish SET order_id = :order_id, penalize_id = :penalize_id WHERE id=' . $row['id']);
				}
				$stmt->bindParam(':order_id', $row['order_id'], PDO::PARAM_INT);
				$stmt->bindParam(':penalize_id', $row['penalize_id'], PDO::PARAM_INT);
				
				$exc = $stmt->execute();
				if ($exc) {
					$nv_Cache->delMod($module_name);
					if (empty($row['id'])) {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Order_punish', ' ', $admin_info['userid']);
						} else {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Order_punish', 'ID: ' . $row['id'], $admin_info['userid']);
					}
					nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
				}
				} catch(PDOException $e) {
				trigger_error($e->getMessage());
				die($e->getMessage()); //Remove this line after checks finished
			}
		}
		} elseif ($row['id'] > 0) {
		$row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish WHERE id=' . $row['id'])->fetch();
		if (empty($row)) {
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
		} else {
		$row['id'] = 0;
		$row['order_id'] = 0;
		$row['penalize_id'] = 0;
	}
	$array_penalize_id_retails = array();
	$_sql = 'SELECT id,title_penalize FROM tms_vi_retails_penalize';
	$_query = $db->query($_sql);
	while ($_row = $_query->fetch()) {
		$array_penalize_id_retails[$_row['id']] = $_row;
	}
	
	
	$q = $nv_Request->get_title('q', 'post,get');
	$penalize_id = $nv_Request->get_int('penalize_id', 'post,get',0);
	$store_id = $nv_Request->get_int('store_id', 'post,get',0);
	$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
	$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
	
	$where = '';
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	
    if (!empty($q)) {
		$where .= ' AND t2.order_code LIKE "%'. $q .'%"';
        $base_url .= '&q=' . $q;
	}
	
	if ($penalize_id) {
		$where .= ' AND t1.penalize_id ='. $penalize_id;
        $base_url .= '&penalize_id=' . $penalize_id;
	}
	
	if ($store_id) {
		$where .= ' AND t2.store_id ='. $store_id;
        $base_url .= '&store_id=' . $store_id;
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
	
	if($ngay_tu)
	{
		$where .= ' AND t2.time_add >= '. $ngay_tu;
        $base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu );
	}
	
	if($ngay_den)
	{
		$where .= ' AND t2.time_add <= '. $ngay_den;
        $base_url .= '&ngay_den=' . date( 'd-m-Y', $ngay_den );
	}
	
	
	// Fetch Limit
	$show_view = false;
	if (!$nv_Request->isset_request('id', 'post,get')) {
		$show_view = true;
		$per_page = 20;
		$page = $nv_Request->get_int('page', 'post,get', 1);
		$db->sqlreset()
        ->select('COUNT(*)')
        ->from(TABLE . '_order_punish t1, '. TABLE . '_order t2')
		->where('t1.order_id = t2.id' . $where);
		
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('t1.id, t1.penalize_id, t1.time_add, t2.order_code')
        ->order('t1.time_add DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		
		
		$sth->execute();
	}
	
	$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	$xtpl->assign('ROW', $row);
	
	
	$list_store = get_full_store();
	foreach ( $list_store as $value2 ) {
		$xtpl->assign( 'store_id_list', array(
        'key' => $value2['id'],
        'title' => $value2['company_name'],
        'selected' => ( $value2['id'] == $store_id ) ? ' selected="selected"' : '' ) );
        $xtpl->parse( 'main.store_id' );
	}
	
	
	foreach ($array_penalize_id_retails as $value) {
		$xtpl->assign('OPTION', array(
        'key' => $value['id'],
        'title' => $value['title_penalize'],
        'selected' => ($value['id'] == $penalize_id) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.select_penalize_id');
	}
	$xtpl->assign('Q', $q);
	
	if ($show_view) {
		
		$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
		if (!empty($generate_page)) {
			$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
			$xtpl->parse('main.generate_page');
		}
		$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
		while ($view = $sth->fetch()) {
			$view['number'] = $number++;
			$view['penalize_id'] = $array_penalize_id_retails[$view['penalize_id']]['title_penalize'];
			$view['time_add'] = date('d/m/Y - H:i',$view['time_add']);
			
			$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=order_punish&amp;id=' . $view['id'];
			$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
			$xtpl->assign('VIEW', $view);
			$xtpl->parse('main.loop');
		}
	}
	
	
	if (!empty($error)) {
		$xtpl->assign('ERROR', implode('<br />', $error));
		$xtpl->parse('main.error');
	}
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['order_punish_list'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
