<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 08 Nov 2021 09:56:47 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_vnpay_refund  WHERE id = ' . $db->quote($id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Vnpay_refund', 'ID: ' . $id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['order_id'] = $nv_Request->get_int('order_id', 'post', 0);
    $row['responsecode'] = $nv_Request->get_title('responsecode', 'post', '');
    $row['message'] = $nv_Request->get_title('message', 'post', '');
    $row['user_add'] = $nv_Request->get_int('user_add', 'post', 0);

    if (empty($row['order_id'])) {
        $error[] = $lang_module['error_required_order_id'];
    } elseif (empty($row['responsecode'])) {
        $error[] = $lang_module['error_required_responsecode'];
    } elseif (empty($row['user_add'])) {
        $error[] = $lang_module['error_required_user_add'];
    }

    if (empty($error)) {
        try {
            if (empty($row['id'])) {
                $row['time_add'] = 0;

                $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_vnpay_refund (order_id, responsecode, message, user_add, time_add) VALUES (:order_id, :responsecode, :message, :user_add, :time_add)');

                $stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);

            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_vnpay_refund SET order_id = :order_id, responsecode = :responsecode, message = :message, user_add = :user_add WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':order_id', $row['order_id'], PDO::PARAM_INT);
            $stmt->bindParam(':responsecode', $row['responsecode'], PDO::PARAM_STR);
            $stmt->bindParam(':message', $row['message'], PDO::PARAM_STR);
            $stmt->bindParam(':user_add', $row['user_add'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Vnpay_refund', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Vnpay_refund', 'ID: ' . $row['id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_vnpay_refund WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['id'] = 0;
    $row['order_id'] = 0;
    $row['responsecode'] = '';
    $row['message'] = '';
    $row['user_add'] = 0;
}
$array_order_id_retails = array();
$_sql = 'SELECT id,order_code FROM tms_vi_retails_order';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_order_id_retails[$_row['id']] = $_row;
}

$array_user_add_users = array();
$_sql = 'SELECT userid,last_name FROM tms_users';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_user_add_users[$_row['userid']] = $_row;
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
        ->from('' . NV_PREFIXLANG . '_' . $module_data . '_vnpay_refund');

    if (!empty($q)) {
        $db->where('order_id LIKE :q_order_id OR responsecode LIKE :q_responsecode OR user_add LIKE :q_user_add');
    }
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_order_id', '%' . $q . '%');
        $sth->bindValue(':q_responsecode', '%' . $q . '%');
        $sth->bindValue(':q_user_add', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_order_id', '%' . $q . '%');
        $sth->bindValue(':q_responsecode', '%' . $q . '%');
        $sth->bindValue(':q_user_add', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate('vnpay_refund.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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

foreach ($array_order_id_retails as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['id'],
        'title' => $value['order_code'],
        'selected' => ($value['id'] == $row['order_id']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_order_id');
}
foreach ($array_user_add_users as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['userid'],
        'title' => $value['last_name'],
        'selected' => ($value['userid'] == $row['user_add']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_user_add');
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
        $view['order_id'] = $array_order_id_retails[$view['order_id']]['order_code'];
        $view['user_add'] = $array_user_add_users[$view['user_add']]['last_name'];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
		
		$view['time_add'] = date('d/m/Y - H:i',$view['time_add']);
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

$page_title = $lang_module['vnpay_refund'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
