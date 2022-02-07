<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Thu, 28 Oct 2021 09:06:03 GMT
	*/
	
	if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
	
	if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
		$id = $nv_Request->get_int('delete_id', 'get');
		$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
		if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish_complain  WHERE id = ' . $db->quote($id));
			$nv_Cache->delMod($module_name);
			nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Order_punish_complain', 'ID: ' . $id, $admin_info['userid']);
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	
	$row = array();
	$error = array();
	$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
	if ($nv_Request->isset_request('submit', 'post')) {
		$row['store_id'] = $nv_Request->get_int('store_id', 'post', 0);
		if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('time_from', 'post'), $m))     {
			$_hour = 0;
			$_min = 0;
			$row['time_from'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
		}
		else
		{
			$row['time_from'] = 0;
		}
		if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('time_to', 'post'), $m))     {
			$_hour = 0;
			$_min = 0;
			$row['time_to'] = mktime($_hour, $_min, 0, $m[2], $m[1], $m[3]);
		}
		else
		{
			$row['time_to'] = 0;
		}
		
		if (empty($row['store_id'])) {
			$error[] = $lang_module['error_required_store_id'];
			} elseif (empty($row['time_from'])) {
			$error[] = $lang_module['error_required_time_from'];
			} elseif (empty($row['time_to'])) {
			$error[] = $lang_module['error_required_time_to'];
		}
		
		if (empty($error)) {
			try {
				if (empty($row['id'])) {
					$row['time_add'] = NV_CURRENTTIME;
					
					$stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish_complain (store_id, time_from, time_to, time_add) VALUES (:store_id, :time_from, :time_to, :time_add)');
					
					$stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
					
					} else {
					$stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish_complain SET store_id = :store_id, time_from = :time_from, time_to = :time_to WHERE id=' . $row['id']);
				}
				$stmt->bindParam(':store_id', $row['store_id'], PDO::PARAM_INT);
				$stmt->bindParam(':time_from', $row['time_from'], PDO::PARAM_INT);
				$stmt->bindParam(':time_to', $row['time_to'], PDO::PARAM_INT);
				
				$exc = $stmt->execute();
				if ($exc) {
					$nv_Cache->delMod($module_name);
					if (empty($row['id'])) {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Order_punish_complain', ' ', $admin_info['userid']);
						} else {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Order_punish_complain', 'ID: ' . $row['id'], $admin_info['userid']);
					}
					nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
				}
				} catch(PDOException $e) {
				trigger_error($e->getMessage());
				die($e->getMessage()); //Remove this line after checks finished
			}
		}
		} elseif ($row['id'] > 0) {
		$row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish_complain WHERE id=' . $row['id'])->fetch();
		if (empty($row)) {
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
		} else {
		$row['id'] = 0;
		$row['store_id'] = 0;
		$row['time_from'] = 0;
		$row['time_to'] = 0;
	}
	
	if (empty($row['time_from'])) {
		$row['time_from'] = '';
	}
	else
	{
		$row['time_from'] = date('d/m/Y', $row['time_from']);
	}
	
	if (empty($row['time_to'])) {
		$row['time_to'] = '';
	}
	else
	{
		$row['time_to'] = date('d/m/Y', $row['time_to']);
	}
	
	
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	
	$q = $nv_Request->get_title('q', 'post,get');
	
	$where = '';
	
	 if (!empty($q)) {
		$where = ' AND company_name like "%'. $q .'%"';
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
        ->from(NV_PREFIXLANG . '_' . $module_data . '_order_punish_complain t1, ' . TABLE .'_seller_management t2')
		->where('t1.store_id = t2.id' . $where);
		
		$sth = $db->prepare($db->sql());
		
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('t1.*, t2.company_name')
        ->order('id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
	}
	
	$xtpl = new XTemplate('order_punish_complain.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
		
		$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
		if (!empty($generate_page)) {
			$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
			$xtpl->parse('main.view.generate_page');
		}
		$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
		while ($view = $sth->fetch()) {
			$view['number'] = $number++;
			$view['time_from'] = (empty($view['time_from'])) ? '' : nv_date('d/m/Y', $view['time_from']);
			$view['time_to'] = (empty($view['time_to'])) ? '' : nv_date('d/m/Y', $view['time_to']);
			
			$view['time_add'] = nv_date('d/m/Y - H:i', $view['time_add']);
			
			$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
			$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
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
	
	$page_title = $lang_module['order_punish_complain'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
