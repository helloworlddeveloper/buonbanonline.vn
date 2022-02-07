<?php

/**
	* @Project NUKEVIET 4.x
	* @Author VINADES.,JSC <contact@vinades.vn>
	* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
	* @License GNU/GPL version 2 or any later version
	* @Createdate Mon, 29 Nov 2021 08:11:15 GMT
*/

if (!defined('NV_IS_FILE_ADMIN'))
die('Stop!!!');

// lên đơn lại
if ($nv_Request->isset_request('renew_order_not_received', 'post, get')) {
	$order_id = $nv_Request->get_int('order_id', 'post, get', 0);
	
	if (!$order_id){
		print_r( json_encode( array('status'=>'ERROR' ) ));
		die(); 
	}
	$db->query('UPDATE ' . TABLE . '_order_not_received SET status = 1 WHERE order_id = ' . $order_id);
	
	// cập nhật trạng thái đơn hàng = 1
	$db->query('UPDATE '. TABLE .'_order SET status = 1 where id = ' . $order_id);
	
	$info_order = get_info_order($order_id);
	
	// kiểm tra hủy đơn vị vận chuyển nếu có shipping_code
	if($info_order['shipping_code'] and ($info_order['transporters_id'] == 4 or $info_order['transporters_id'] == 4))
	{
		// hủy đơn vận chuyển
		// lấy thông tin id_vnpost vnpost để hủy vận chuyển
		$id_vnpost = $db->query('SELECT id_vnpost FROM '. TABLE .'_history_vnpos WHERE item_code ="' . $info_order['shipping_code'] .'"' )->fetchColumn();
		
		$order_vnpost = cancel_tranpost_vnpost($id_vnpost);
		
	}
	elseif($info_order['shipping_code'] and $info_order['transporters_id'] == 3)
	{
		$shop_id = get_info_warehouse($info_order['warehouse_id'])['shops_id_ghn'];
		
		$ghn_cancel = ghn_cancel($shop_id, $info_order['shipping_code'] );
		
		if($ghn_cancel['code'] == 200){
			$today = NV_CURRENTTIME;
			//cập nhật trạng thái hủy
			$db->query('UPDATE '. TABLE .'_history_ghn SET status = "cancel" WHERE order_id = ' . $info_order['id'] . ' AND order_code = "' . $info_order['shipping_code'] . '"');
			// lưu lại lịch sử vận đơn
			$db->query('INSERT INTO '. TABLE .'_history_ghn_detail (order_id, order_code_ghn, status, time_add) VALUES('. $info_order['id'] .', "'. $info_order['shipping_code'] .'", "cancel", '. $today .')');
		}
	}
	$content = 'Đơn hàng đã được tạo mới';
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',6,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
	
	$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ' đã được tạo đơn mới!';
	
	nv_insert_notification_user($admin_info['userid'], $info_order['userid'], $content_ip, $order_id, "order");
	
	nv_insert_notification_shop($admin_info['userid'], $info_order['store_id'], $content_ip, $order_id, "order");
	
	$reason = $admin_info['username'] . ' đã tạo mới đơn hàng ' . $info_order['order_code'] . ' - xử lý đơn hàng khách không nhận được hàng' ;
	insert_history_admin($admin_info['userid'], $reason);
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
	
}
// hủy đơn
if ($nv_Request->isset_request('cancel_order_not_received', 'post, get')) {
	$order_id = $nv_Request->get_int('order_id', 'post, get', 0);
	$content = $nv_Request->get_title('content', 'post, get', '');
	
	
	if (!$order_id){
		print_r( json_encode( array('status'=>'ERROR' ) ));
		die(); 
	}
	$db->query('UPDATE ' . TABLE . '_order_not_received SET status = 1 WHERE order_id = ' . $order_id);
	
	// cập nhật trạng thái đơn hàng = 4
	$db->query('UPDATE '. TABLE .'_order SET status = 4 where id = ' . $order_id);
	
	// trả hàng về kho, cập nhật kho
	$list_product = $db->query('SELECT * FROM '. TABLE .'_order_item where order_id='. $order_id)->fetchAll();
	
	foreach($list_product as $product)
	{
		$where = '';
		
		if($product['classify_value_product_id'])
		{
			$where .= ' AND id=' . $product['classify_value_product_id'];
		}
		
		$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET sl_tonkho = sl_tonkho + '. $product['quantity'] .' WHERE product_id =' . $product['product_id'] . $where);
	}
	
	$info_order = get_info_order($order_id);
	
	// kiểm tra hủy đơn vị vận chuyển nếu có shipping_code
	if($info_order['shipping_code'] and ($info_order['transporters_id'] == 4 or $info_order['transporters_id'] == 4))
	{
		// hủy đơn vận chuyển
		// lấy thông tin id_vnpost vnpost để hủy vận chuyển
		$id_vnpost = $db->query('SELECT id_vnpost FROM '. TABLE .'_history_vnpos WHERE item_code ="' . $info_order['shipping_code'] .'"' )->fetchColumn();
		
		$order_vnpost = cancel_tranpost_vnpost($id_vnpost);
		
	}
	elseif($info_order['shipping_code'] and $info_order['transporters_id'] == 3)
	{
		$shop_id = get_info_warehouse($info_order['warehouse_id'])['shops_id_ghn'];
		
		$ghn_cancel = ghn_cancel($shop_id, $info_order['shipping_code'] );
		
		if($ghn_cancel['code'] == 200){
			$today = NV_CURRENTTIME;
			//cập nhật trạng thái hủy
			$db->query('UPDATE '. TABLE .'_history_ghn SET status = "cancel" WHERE order_id = ' . $info_order['id'] . ' AND order_code = "' . $info_order['shipping_code'] . '"');
			// lưu lại lịch sử vận đơn
			$db->query('INSERT INTO '. TABLE .'_history_ghn_detail (order_id, order_code_ghn, status, time_add) VALUES('. $info_order['id'] .', "'. $info_order['shipping_code'] .'", "cancel", '. $today .')');
		}
	}
	
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',6,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
	
	$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ' đã bị hủy với lý do ' . $content;
	
	nv_insert_notification_user($admin_info['userid'], $info_order['userid'], $content_ip, $order_id, "order");
	
	nv_insert_notification_shop($admin_info['userid'], $info_order['store_id'], $content_ip, $order_id, "order");
	$info_order['lydohuy'] = $content;
	send_email_order_cancel($info_order);
	
	$reason = $admin_info['username'] . ' đã hủy đơn hàng ' . $info_order['order_code'] . ' - xử lý đơn hàng khách không nhận được hàng' ;
	insert_history_admin($admin_info['userid'], $reason);
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
}

if ($nv_Request->isset_request('delete_order_not_received', 'post, get')) {
	$order_id = $nv_Request->get_int('order_id', 'post, get', 0);
	if (!$order_id){
		print_r( json_encode( array('status'=>'ERROR' ) ));
		die(); 
	}
	$db->query('DELETE FROM ' . TABLE . '_order_not_received  WHERE order_id = ' . $order_id);
	$reason = $admin_info['username'] . ' đã xóa khiếu nại đơn hàng id - ' . $order_id . ' - xử lý đơn hàng khách không nhận được hàng' ;
	insert_history_admin($admin_info['userid'], $reason);
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
	
}

$row = array();
$error = array();
$array_order_id_retails = array();
$_sql = 'SELECT id,order_code FROM tms_vi_retails_order';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
	$array_order_id_retails[$_row['id']] = $_row;
}


$q = $nv_Request->get_title('q', 'post,get');

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_order_not_received t1')
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

$xtpl = new XTemplate('order_not_received.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
		$view['complain_deadline'] = $view['time_add'] + 172800;
		$view['real_time'] = $view['complain_deadline'] - NV_CURRENTTIME;
		$view['real_time_h'] =  floor(($view['real_time'] / 3600));
		$view['real_time_m'] = floor(($view['real_time'] / 60) % 60);
		$view['time_add'] = (empty($view['time_add'])) ? '' : nv_date('H:i d/m/Y', $view['time_add']);
		$view['link_view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view_order&amp;id=' . $view['id'];
		
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

$page_title = $lang_module['order_not_received'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
