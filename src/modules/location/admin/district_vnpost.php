<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS (contact@tms.vn)
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 01/01/2021 09:47
 */

if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');




$row = array();
$error = array();
$row['districtid'] = $nv_Request->get_int('districtid', 'post,get', 0);
$row['countryid'] = $nv_Request->get_int('countryid', 'post,get', 0);
$row['provinceid'] = $nv_Request->get_int('provinceid', 'post,get', 0);


if ($nv_Request->isset_request('submit', 'post')) {
  
   
    //https://donhang.vnpost.vn/api/api/QuanHuyen/GetAll//
	$list_quanhuyen=get_xaphuong_vnpost();
    

    if (empty($error)) {
        try {
           foreach($list_quanhuyen as $location){
			$row['type'] = 'Xã/Phường';
			$row['location'] = $nv_Request->get_title('location', 'post', '');

	

			$alias = change_alias($location['TenPhuongXa']);
			$alias = strtolower($alias);

			$stmt = $db->prepare('SELECT COUNT(*) FROM ' . $db_config['prefix'] . '_' . $module_data . '_ward WHERE alias = :alias');
			$stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
			$stmt->execute();

			if ($stmt->fetchColumn()) {
				$weight = $db->query('SELECT MAX(wardid) FROM ' . $db_config['prefix'] . '_' . $module_data . '_ward')->fetchColumn();
				$weight = intval($weight) + 1;
				$alias = $alias . '-' . $weight;
			}
			$row['alias']=$alias;

        
			
			$stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_ward (code, wardid,districtid,vnpostid, title, alias, type, location, weight) VALUES (:code, :wardid,:districtid,:vnpostid,:title, :alias, :type, :location, :weight)');
            $weight = $db->query('SELECT max(weight) FROM ' . $db_config['prefix'] . '_' . $module_data . '_ward')->fetchColumn();
            $weight = intval($weight) + 1;
            $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
            $stmt->bindParam(':code', $weight, PDO::PARAM_STR);
            $stmt->bindParam(':wardid', $location['MaPhuongXa'], PDO::PARAM_STR);
			$stmt->bindParam(':districtid',$location['MaQuanHuyen'], PDO::PARAM_STR);
			$stmt->bindParam(':vnpostid', $location['MaPhuongXa'], PDO::PARAM_STR);
            $stmt->bindParam(':title', $location['TenPhuongXa'], PDO::PARAM_STR);
            $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $row['type'], PDO::PARAM_STR);
            $stmt->bindParam(':location', $row['location'], PDO::PARAM_STR);
            
            $exc = $stmt->execute();

            }
		} catch (PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); // Remove this line after checks finished
        }
    }
} elseif ($row['wardid'] > 0) {

    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_ward WHERE wardid=' . $row['wardid'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }

} else {
    $row['code'] = '';
	$row['wardid'] = 0;  
	$row['vnpostid'] = 0;  
	$row['districtid'] = 0;  
    $row['title'] = '';
    $row['alias'] = '';
    $row['status'] = 1;
    $row['type'] = '';
}

$q = $nv_Request->get_title('q', 'post,get');

// Fetch Limit
$show_view = false;
if (! $nv_Request->isset_request('id', 'post,get')) {
    $where = '';
    $show_view = true;
    $per_page = 10;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_district');
    
    if (! empty($q)) {
        $where .= ' AND ( districtid LIKE :q_districtid OR title LIKE :q_title OR type LIKE :q_type OR alias LIKE :q_alias OR location LIKE :q_location)';
    }
    $db->where('provinceid=' . $db->quote($row['provinceid']) . $where);
    $sth = $db->prepare($db->sql());
    
    if (! empty($q)) {
        $sth->bindValue(':q_districtid', '%' . $q . '%');
        $sth->bindValue(':q_title', '%' . $q . '%');
        $sth->bindValue(':q_alias', '%' . $q . '%');
        $sth->bindValue(':q_type', '%' . $q . '%');
        $sth->bindValue(':q_location', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();
    
    $db->select('*')
        ->order('weight ASC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());
    
    if (! empty($q)) {
        $sth->bindValue(':q_districtid', '%' . $q . '%');
        $sth->bindValue(':q_title', '%' . $q . '%');
        $sth->bindValue(':q_alias', '%' . $q . '%');
        $sth->bindValue(':q_type', '%' . $q . '%');
        $sth->bindValue(':q_location', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('Q', $q);

if ($show_view) {
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;countryid=' . $row['countryid'] . '&amp;provinceid=' . $row['provinceid'];
    if (! empty($q)) {
        $base_url .= '&q=' . $q;
    }
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (! empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
    while ($view = $sth->fetch()) {
        $view['count'] = $db->query('SELECT COUNT(*) FROM ' . $db_config['prefix'] . '_' . $module_data . '_ward WHERE districtid=' . $view['districtid'])->fetchColumn();
        for ($i = 1; $i <= $num_items; ++ $i) {
            $xtpl->assign('WEIGHT', array(
                'key' => $i,
                'title' => $i,
                'selected' => ($i == $view['weight']) ? ' selected="selected"' : ''
            ));
            $xtpl->parse('main.view.loop.weight_loop');
        }
        $xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;countryid=' . $row['countryid'] . '&amp;provinceid=' . $row['provinceid'] . '&amp;districtid=' . $view['districtid'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;countryid=' . $row['countryid'] . '&amp;provinceid=' . $row['provinceid'] . '&amp;delete_districtid=' . $view['districtid'] . '&amp;delete_checkss=' . md5($view['districtid'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $view['link_ward'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ward&amp;provinceid=' . $view['provinceid'] . '&amp;districtid=' . $view['districtid'];
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}

if (! empty($array_province)) {
    foreach ($array_province as $province) {
        $province['selected'] = $province['provinceid'] == $row['provinceid'] ? 'selected="selected"' : '';
        $xtpl->assign('PROVINCE', $province);
        $xtpl->parse('main.province');
    }
}

if (! empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

if (empty($row['districtid'])) {
    $xtpl->parse('main.auto_get_alias');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$array_mod_title = array(
    array(
        'title' => $lang_module['main'],
        'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name
    ),
    array(
        'title' => $array_country[$row['countryid']]['title'],
        'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=province&amp;countryid=' . $row['countryid']
    ),
    array(
        'title' => $array_province[$row['provinceid']]['title']
    )
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';