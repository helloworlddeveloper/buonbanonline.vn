<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Wed, 08 Dec 2021 03:01:35 GMT
	*/
	
	if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

	$array_id_area_location = array();
	$_sql = 'SELECT id,title_area FROM tms_location_area';
	$_query = $db->query($_sql);
	while ($_row = $_query->fetch()) {
		$array_id_area_location[$_row['id']] = $_row;
	}
	
	$array_districtid_location = array();
	$_sql = 'SELECT provinceid,title FROM tms_location_province';
	$_query = $db->query($_sql);
	while ($_row = $_query->fetch()) {
		$array_districtid_location[$_row['provinceid']] = $_row;
	}
	
	
	
	if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
		$id = $nv_Request->get_int('delete_id', 'get');
		$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
		if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
			$db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_area_province  WHERE id = ' . $db->quote($id));
			$nv_Cache->delMod($module_name);
			nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Area_province', 'ID: ' . $id, $admin_info['userid']);
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	
	$row = array();
	$error = array();
	$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
	if ($nv_Request->isset_request('submit', 'post')) {
		$row['id_area'] = $nv_Request->get_int('id_area', 'post', 0);
		$arr_districtid_get = $nv_Request->get_array('districtid', 'post', array());
		
		$row['districtid'] = implode(',',$arr_districtid_get);
		
		if (empty($row['id_area'])) {
			$error[] = $lang_module['error_required_id_area'];
			} elseif (empty($row['districtid'])) {
			$error[] = $lang_module['error_required_districtid'];
		}
		
		if (empty($error)) {
			// kiểm tra khu vực tồn tại
			$where = '';
			
			if($row['id'])
			{
				$where = ' AND id != '. $row['id'];
			}
			
			$check_area = $db->query('SELECT id FROM ' . $db_config['prefix'] . '_' . $module_data . '_area_province WHERE id_area =' . $row['id_area'] . $where)->fetchColumn();
			
			if($check_area)
			{
				$error[] = 'Khu vực đã tồn tại';	
			}
			
			// kiểm tra tỉnh thành đã tồn tại chưa.
			foreach($arr_districtid_get as $districtid)
			{
				$check_districtid = $db->query('SELECT id FROM ' . $db_config['prefix'] . '_' . $module_data . '_area_province WHERE FIND_IN_SET('. $districtid .', districtid)')->fetchColumn();
				
				if($check_districtid)
				{
					$error[] = $array_districtid_location[$districtid]['title'] . ' Đã tồn tại';	
				}
			}
			
			
		}
		
		
		if (empty($error)) {
			try {
				if (empty($row['id'])) {
					$stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_area_province (id_area, districtid) VALUES (:id_area, :districtid)');
					} else {
					$stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_area_province SET id_area = :id_area, districtid = :districtid WHERE id=' . $row['id']);
					}
					$stmt->bindParam(':id_area', $row['id_area'], PDO::PARAM_INT);
					$stmt->bindParam(':districtid', $row['districtid'], PDO::PARAM_STR);
				
				$exc = $stmt->execute();
				if ($exc) {
					$nv_Cache->delMod($module_name);
					if (empty($row['id'])) {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Area_province', ' ', $admin_info['userid']);
						} else {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Area_province', 'ID: ' . $row['id'], $admin_info['userid']);
					}
					nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
				}
				} catch(PDOException $e) {
				trigger_error($e->getMessage());
				die($e->getMessage()); //Remove this line after checks finished
			}
		}
		} elseif ($row['id'] > 0) {
		$row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_area_province WHERE id=' . $row['id'])->fetch();
		if (empty($row)) {
			nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
		} else {
		$row['id'] = 0;
		$row['id_area'] = 0;
		$row['districtid'] = 0;
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
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_area_province');
		
		if (!empty($q)) {
			$db->where('id_area LIKE :q_id_area OR districtid LIKE :q_districtid');
		}
		$sth = $db->prepare($db->sql());
		
		if (!empty($q)) {
			$sth->bindValue(':q_id_area', '%' . $q . '%');
			$sth->bindValue(':q_districtid', '%' . $q . '%');
		}
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('*')
        ->order('id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		
		if (!empty($q)) {
			$sth->bindValue(':q_id_area', '%' . $q . '%');
			$sth->bindValue(':q_districtid', '%' . $q . '%');
		}
		$sth->execute();
	}
	
	$xtpl = new XTemplate('area_province.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	
	foreach ($array_id_area_location as $value) {
		$xtpl->assign('OPTION', array(
        'key' => $value['id'],
        'title' => $value['title_area'],
        'selected' => ($value['id'] == $row['id_area']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.select_id_area');
	}
	
	$array_districtid = explode(',',$row['districtid']);
	
	foreach ($array_districtid_location as $value) {
		$xtpl->assign('OPTION', array(
        'key' => $value['provinceid'],
        'title' => $value['title'],
        'selected' => (in_array($value['provinceid'],$array_districtid)) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.select_districtid');
	}
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
			
			$view['id_area'] = $array_id_area_location[$view['id_area']]['title_area'];
			$array_districtid = explode(',',$view['districtid']);
			foreach($array_districtid as $row)
			{
				$view['number'] = $number++;
				
				$view['districtid'] = $array_districtid_location[$row]['title'];
				$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
				$xtpl->assign('VIEW', $view);
				$xtpl->parse('main.view.loop');
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
	
	$page_title = $lang_module['area_province'];
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
