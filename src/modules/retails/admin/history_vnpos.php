<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 17 May 2021 05:34:36 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$array_doisoat = array(
	'0' => 'Chưa đối soát',
	'1' => 'Đã đối soát'
);

// Change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;

    $query = 'SELECT doisoat FROM ' . NV_PREFIXLANG . '_' . $module_data . '_history_vnpos WHERE id=' . $id;
    $row = $db->query($query)->fetch();
    if (isset($row['doisoat']))     {
        $doisoat = ($row['doisoat']) ? 0 : 1;
		
		if($doisoat)
		{
			// đơn hàng phát thành công mới đối soát được
			$check = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_history_vnpos WHERE (vnpost_status = 100 OR vnpost_status = 170) AND id=' . $id)->fetchColumn();
			
			if(!$check)
			{
				echo $content;die;
			}
		}
		
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_history_vnpos SET doisoat=' . intval($doisoat) . ' WHERE id=' . $id;
        $db->query($query);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
}



$array_vnpost_status_retails = array();
$_sql = 'SELECT id_status,name_status_vnpost FROM tms_vi_retails_status_vnpos';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_vnpost_status_retails[$_row['id_status']] = $_row;
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
        ->from('' . NV_PREFIXLANG . '_' . $module_data . '_history_vnpos');

    if (!empty($q)) {
        $db->where('order_code LIKE :q_order_code OR name_gui LIKE :q_name_gui OR name_nhan LIKE :q_name_nhan OR item_code LIKE :q_item_code OR cuoc_phi LIKE :q_cuoc_phi OR hinhthuc_vc LIKE :q_hinhthuc_vc OR vnpost_status LIKE :q_vnpost_status OR date_add LIKE :q_date_add OR doisoat LIKE :q_doisoat');
    }
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_order_code', '%' . $q . '%');
        $sth->bindValue(':q_name_gui', '%' . $q . '%');
        $sth->bindValue(':q_name_nhan', '%' . $q . '%');
        $sth->bindValue(':q_item_code', '%' . $q . '%');
        $sth->bindValue(':q_cuoc_phi', '%' . $q . '%');
        $sth->bindValue(':q_hinhthuc_vc', '%' . $q . '%');
        $sth->bindValue(':q_vnpost_status', '%' . $q . '%');
        $sth->bindValue(':q_date_add', '%' . $q . '%');
        $sth->bindValue(':q_doisoat', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_order_code', '%' . $q . '%');
        $sth->bindValue(':q_name_gui', '%' . $q . '%');
        $sth->bindValue(':q_name_nhan', '%' . $q . '%');
        $sth->bindValue(':q_item_code', '%' . $q . '%');
        $sth->bindValue(':q_cuoc_phi', '%' . $q . '%');
        $sth->bindValue(':q_hinhthuc_vc', '%' . $q . '%');
        $sth->bindValue(':q_vnpost_status', '%' . $q . '%');
        $sth->bindValue(':q_date_add', '%' . $q . '%');
        $sth->bindValue(':q_doisoat', '%' . $q . '%');
    }
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


foreach ($array_doisoat as $key => $value) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $value,
        'checked' => ($key == $row['doisoat']) ? ' checked="checked"' : ''
    ));
    $xtpl->parse('main.radio_doisoat');
}


foreach ($array_vnpost_status_retails as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['id_status'],
        'title' => $value['name_status_vnpost'],
        'selected' => ($value['id_status'] == $row['vnpost_status']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_vnpost_status');
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
        $view['number'] = $number++;
        $xtpl->assign('CHECK', $view['doisoat'] == 1 ? 'checked' : '');
        $view['date_add'] = (empty($view['date_add'])) ? '' : nv_date('d/m/Y - H:i', $view['date_add']);
        $view['vnpost_status'] = $array_vnpost_status_retails[$view['vnpost_status']]['name_status_vnpost'];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=history_vnpos_view&amp;id=' . $view['id'];
		
		// xem chi tiết đơn hàng
		$info_order = $db->query('SELECT id, store_id, warehouse_id FROM ' . TABLE .'_order WHERE order_code ="'. $view['order_code'] .'"')->fetch();
		$view['link_view_order'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view_order&amp;id=' . $info_order['id'].'&store_id='.$info_order['store_id'].'&warehouse_id='.$info_order['warehouse_id'];
		
		// tên người lên đơn
		if($view['userid_add'])
		$info_user = $db->query('SELECT last_name, first_name FROM ' . $db_config['prefix'] . '_users WHERE userid =' . $view['userid_add'])->fetch();
		
		// kiểm tra cước phí thực tính và tạm tính giống nhau không?
		if($view['cuocphi_thuctinh'] and $view['cuocphi_thuctinh'] != $view['tongcuocbaogomdvct'])
		{
			$view['class_red'] = 'class_red';
			$view['cuocphi_thuctinh'] = number_format($view['cuocphi_thuctinh']);
			
			$xtpl->assign('cuocphi_thuctinh', $view['cuocphi_thuctinh']);
			$xtpl->parse('main.view.loop.cuocphi_thuctinh');
		}
		else
		{
			$view['class_red'] = '';
		}
		
		$view['tongcuocbaogomdvct'] = number_format($view['tongcuocbaogomdvct']);
		
		$view['name_create'] = $info_user['last_name'] . ' ' . $info_user['first_name'];
		
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

$page_title = $lang_module['history_vnpos'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
