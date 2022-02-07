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
	
	$row = array();
	$error = array();
	$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
	$row['order_id'] = $nv_Request->get_int('order_id', 'get', 0);
	
	if ($nv_Request->isset_request('submit', 'post')) {
		
		$row['penalize_id'] = $nv_Request->get_int('penalize_id', 'post', 0);
		
		if (empty($row['penalize_id'])) {
			$error[] = $lang_module['error_required_penalize_id'];
		}
		
		// kiểm tra order_id, order_id đã tồn tại chưa
		$check_exits = $db->query('SELECT id FROM ' . TABLE .'_order_punish WHERE order_id ='. $row['order_id'] .' AND penalize_id ='. $row['penalize_id'])->fetchColumn();
		
		if($check_exits)
		{
			$error[] = 'Phạt đã tồn tại!';
		}
		
		if (empty($error)) {
			try {
				if (empty($row['id'])) {
					$row['time_add'] = NV_CURRENTTIME;
					
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
					nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=listorder');
				}
				} catch(PDOException $e) {
				trigger_error($e->getMessage());
				die($e->getMessage()); //Remove this line after checks finished
			}
		}
		}elseif ($row['id'] > 0) {
		$row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_order_punish WHERE id=' . $row['id'])->fetch();
		if (empty($row)) {
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	else {
		$row['id'] = 0;
		$row['penalize_id'] = 0;
	}
	
	
	$array_penalize_id_retails = array();
	$_sql = 'SELECT id,title_penalize FROM tms_vi_retails_penalize';
	$_query = $db->query($_sql);
	while ($_row = $_query->fetch()) {
		$array_penalize_id_retails[$_row['id']] = $_row;
	}
	
	
	// lấy thông tin mã đơn hàng
	$row['order_code'] = $db->query('SELECT order_code FROM ' . TABLE .'_order WHERE id ='. $row['order_id'])->fetchColumn();
	
	$xtpl = new XTemplate('order_punish.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	
	foreach ($array_penalize_id_retails as $value) {
		$xtpl->assign('OPTION', array(
        'key' => $value['id'],
        'title' => $value['title_penalize'],
        'selected' => ($value['id'] == $row['penalize_id']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.select_penalize_id');
	}
	
	
	if (!empty($error)) {
		$xtpl->assign('ERROR', implode('<br />', $error));
		$xtpl->parse('main.error');
	}
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['order_punish'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
