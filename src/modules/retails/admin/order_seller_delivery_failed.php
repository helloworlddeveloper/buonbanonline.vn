<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Wed, 08 Dec 2021 07:51:19 GMT
	*/
	
	if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
	
	
	if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
		$id = $nv_Request->get_int('delete_id', 'get');
		
		
		$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
		if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_order_seller_delivery_failed  WHERE order_id = ' . $db->quote($id));
			$nv_Cache->delMod($module_name);
			nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Order_seller_delivery_failed', 'ID: ' . $id, $admin_info['userid']);
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	// GIAO LẠI ĐƠN HÀNG
	if ($nv_Request->isset_request('renew_order_id', 'get') and $nv_Request->isset_request('renew_order_checkss', 'get')) {
		$renew_order_id = $nv_Request->get_int('renew_order_id', 'get');
		$renew_order_checkss = $nv_Request->get_string('renew_order_checkss', 'get');
		
		if ($renew_order_id > 0 and $renew_order_checkss == md5($renew_order_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
			$db->query('UPDATE ' . TABLE . '_order_seller_delivery_failed SET status = 1 WHERE order_id = ' . $db->quote($renew_order_id));
			$db->query('UPDATE ' . TABLE . '_order SET status = 1 WHERE id = ' . $renew_order_id);
			$reason = $admin_info['username'] . ' đã cập nhật giao lại đơn hàng id - ' . $renew_order_id . ' - xử lý đơn hàng Seller giao không thành công.' ;
			insert_history_admin($admin_info['userid'], $reason);
			$nv_Cache->delMod($module_name);
			
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	//Cập nhật ĐƠN HÀNG thất bại
	if ($nv_Request->isset_request('delivery_failed_order_id', 'get') and $nv_Request->isset_request('delivery_failed_order_checkss', 'get')) {
		$delivery_failed_order_id = $nv_Request->get_int('delivery_failed_order_id', 'get');
		$delivery_failed_order_checkss = $nv_Request->get_string('delivery_failed_order_checkss', 'get');
		
		if ($delivery_failed_order_id > 0 and $delivery_failed_order_checkss == md5($delivery_failed_order_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
			$db->query('UPDATE ' . TABLE . '_order_seller_delivery_failed SET status = 1 WHERE order_id = ' . $db->quote($delivery_failed_order_id));
			$db->query('UPDATE ' . TABLE . '_order SET status = 6 WHERE id = ' . $delivery_failed_order_id);
			$reason = $admin_info['username'] . ' đã cập nhật giao thất bại đơn hàng id - ' . $delivery_failed_order_id . ' - xử lý đơn hàng Seller giao không thành công.' ;
			insert_history_admin($admin_info['userid'], $reason);
			$nv_Cache->delMod($module_name);
			
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	
	$row = array();
	$error = array();
	
	$q = $nv_Request->get_title('q', 'post,get');
	
	// Fetch Limit
	$show_view = false;
	if (!$nv_Request->isset_request('id', 'post,get')) {
		$show_view = true;
		$per_page = 20;
		$page = $nv_Request->get_int('page', 'post,get', 1);
		$db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . TABLE . '_order_seller_delivery_failed t1')
		->join('INNER JOIN ' . TABLE . '_order t2 ON t1.order_id = t2.id');
		if (!empty($q)) {
			$db->where('t1.order_id LIKE :q_order_id ');
		}
		$sth = $db->prepare($db->sql());
		
		if (!empty($q)) {
			$sth->bindValue(':q_order_id', '%' . $q . '%');
		}
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('t1.time_add, t2.order_code, t2.store_id, t1.id, t1.status, t2.status as status_order, t1.reason, t1.order_id')
        ->order('t1.time_add ASC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		
		if (!empty($q)) {
			$sth->bindValue(':q_order_id', '%' . $q . '%');
		}
		$sth->execute();
	}
	
	$xtpl = new XTemplate('order_seller_delivery_failed.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	
	$xtpl->assign('Q', $q);
	
	if ($show_view) {
		$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
		if (!empty($q)) {
			$base_url .= '&q=' . $q;
		}
		$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
		if (!empty($generate_page)) {
			$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
			$xtpl->parse('main.view.generate_page');
		}
		$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
		while ($view = $sth->fetch()) {
			$view['number'] = $number++;
			$xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
			
			$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['order_id'] . '&amp;delete_checkss=' . md5($view['order_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
			$view['link_renew_order'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;renew_order_id=' . $view['order_id'] . '&amp;renew_order_checkss=' . md5($view['order_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
			$view['link_delivery_failed_order'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delivery_failed_order_id=' . $view['order_id'] . '&amp;delivery_failed_order_checkss=' . md5($view['order_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
			$view['number'] = $number++;
			$view['complain_deadline'] = $view['time_add'] + 172800;
			$view['real_time'] = $view['complain_deadline'] - NV_CURRENTTIME;
			$view['real_time_h'] =  floor(($view['real_time'] / 3600));
			$view['real_time_m'] = floor(($view['real_time'] / 60) % 60);
			$view['time_add'] = (empty($view['time_add'])) ? '' : nv_date('H:i d/m/Y', $view['time_add']);
			$view['link_view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view_order&amp;id=' . $view['order_id'];
			
			if($view['real_time_h'] < 4){
				$xtpl->assign('COLOR','danger');
				}elseif($view['real_time_h'] < 12){
				$xtpl->assign('COLOR','warning');
				}else{
				$xtpl->assign('COLOR','success');
			}
			$xtpl->assign('VIEW', $view);
			if($view['status'] == 0)
			{	
				
				$xtpl->parse('main.view.loop');
			}
			elseif($view['status'] == 1)
			{	$xtpl->assign('COLOR','active');
				$xtpl->parse('main.view.loop1');
			}
		}
		$xtpl->parse('main.view');
	}
	
	
	if (!empty($error)) {
		$xtpl->assign('ERROR', implode('<br />', $error));
		$xtpl->parse('main.error');
	}
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['order_seller_delivery_failed'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
