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



$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    
    $row['doisoat'] = $nv_Request->get_int('doisoat', 'post', 0);

    if (empty($error)) {
        try {
            if (empty($row['id'])) {
            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_history_vnpos SET doisoat = :doisoat WHERE id=' . $row['id']);
            }
            
            $stmt->bindParam(':doisoat', $row['doisoat'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add History_vnpos', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit History_vnpos', 'ID: ' . $row['id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=history_vnpos');
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_history_vnpos WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
	
	$row['cuocphi_thuctinh'] = number_format($row['cuocphi_thuctinh']);
	$row['cuoc_phi'] = number_format($row['cuoc_phi']);
	$row['tongcuocdichvucongthem'] = number_format($row['tongcuocdichvucongthem']);
	$row['tongcuocbaogomdvct'] = number_format($row['tongcuocbaogomdvct']);
	$row['total_moeny'] = number_format($row['total_moeny']);
	$row['cod'] = number_format($row['cod']);
	
	if($row['date_edit'])
	{
		$row['date_edit'] = '(Ngày cập nhật '. date('d/m/Y - H:i',$row['date_edit']).')';
	}
	else
	{
		$row['date_edit'] = '';
	}
	
} else {
    $row['id'] = 0;
    $row['order_id'] = 0;
    $row['order_code'] = '';
    $row['name_products'] = '';
    $row['total_weight_convert'] = '0';
    $row['total_weight'] = '0';
    $row['total_length'] = '0';
    $row['total_width'] = '0';
    $row['total_height'] = '0';
    $row['total_moeny'] = '0';
    $row['tinhthanh_gui'] = 0;
    $row['quanhuyen_gui'] = 0;
    $row['address_gui'] = '';
    $row['phone_gui'] = '';
    $row['name_gui'] = '';
    $row['userid_add'] = 0;
    $row['tinhthanh_nhan'] = 0;
    $row['quanhuyen_nhan'] = 0;
    $row['address_nhan'] = '';
    $row['phone_nhan'] = '';
    $row['name_nhan'] = '';
    $row['item_code'] = '';
    $row['cuoc_phi'] = '0';
    $row['hinhthuc_vc'] = '';
    $row['vnpost_status'] = 0;
    $row['customer_code'] = '';
    $row['date_add'] = 0;
    $row['doisoat'] = 0;
}

if (empty($row['date_add'])) {
    $row['date_add'] = '';
}
else
{
    $row['date_add'] = date('d/m/Y', $row['date_add']);
}

$row['name_products'] = nv_htmlspecialchars(nv_br2nl($row['name_products']));

$array_order_id_retails = array();
$_sql = 'SELECT id,order_code FROM tms_vi_retails_order';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_order_id_retails[$_row['id']] = $_row;
}

$array_vnpost_status_retails = array();
$_sql = 'SELECT id_status,name_status_vnpost FROM tms_vi_retails_status_vnpos';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_vnpost_status_retails[$_row['id_status']] = $_row;
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





foreach ($array_order_id_retails as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['id'],
        'title' => $value['order_code'],
        'selected' => ($value['id'] == $row['order_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_order_id');
}
foreach ($array_vnpost_status_retails as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['id_status'],
        'title' => $value['name_status_vnpost'],
        'selected' => ($value['id_status'] == $row['vnpost_status']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_vnpost_status');
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
