<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 05 Oct 2021 01:02:53 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['userid'] = $nv_Request->get_int('userid', 'post', 0);
    $row['voucher_name'] = $nv_Request->get_title('voucher_name', 'post', '');
    $row['voucher_code'] = $nv_Request->get_title('voucher_code', 'post', '');
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
    $row['discount_price'] = $nv_Request->get_title('discount_price', 'post', '');
    $row['minimum_price'] = $nv_Request->get_title('minimum_price', 'post', '');
    $row['usage_limit_quantity'] = $nv_Request->get_int('usage_limit_quantity', 'post', 0);

    if (empty($error)) {
        try {
            if (empty($row['id'])) {
                $row['time_add'] = 0;

                $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_voucher (userid, voucher_name, voucher_code, time_from, time_to, discount_price, minimum_price, usage_limit_quantity, time_add, status) VALUES (:userid, :voucher_name, :voucher_code, :time_from, :time_to, :discount_price, :minimum_price, :usage_limit_quantity, :time_add, :status)');

                $stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
                $stmt->bindValue(':status', 1, PDO::PARAM_INT);


            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_voucher SET userid = :userid, voucher_name = :voucher_name, voucher_code = :voucher_code, time_from = :time_from, time_to = :time_to, discount_price = :discount_price, minimum_price = :minimum_price, usage_limit_quantity = :usage_limit_quantity WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':userid', $row['userid'], PDO::PARAM_INT);
            $stmt->bindParam(':voucher_name', $row['voucher_name'], PDO::PARAM_STR);
            $stmt->bindParam(':voucher_code', $row['voucher_code'], PDO::PARAM_STR);
            $stmt->bindParam(':time_from', $row['time_from'], PDO::PARAM_INT);
            $stmt->bindParam(':time_to', $row['time_to'], PDO::PARAM_INT);
            $stmt->bindParam(':discount_price', $row['discount_price'], PDO::PARAM_STR);
            $stmt->bindParam(':minimum_price', $row['minimum_price'], PDO::PARAM_STR);
            $stmt->bindParam(':usage_limit_quantity', $row['usage_limit_quantity'], PDO::PARAM_INT);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Voucher', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Voucher', 'ID: ' . $row['id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=voucher' );
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_voucher WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['id'] = 0;
    $row['userid'] = 0;
    $row['voucher_name'] = '';
    $row['voucher_code'] = '';
    $row['time_from'] = '';
    $row['time_to'] = 0;
    $row['discount_price'] = '';
    $row['minimum_price'] = '';
    $row['usage_limit_quantity'] = 0;
}

if (empty($row['time_from'])) {
    $row['time_from'] = date('d/m/Y', NV_CURRENTTIME);
}
else
{
    $row['time_from'] = date('d/m/Y', $row['time_from']);
}

if (empty($row['time_to'])) {
    $row['time_to'] = date('d/m/Y', NV_CURRENTTIME);
}
else
{
    $row['time_to'] = date('d/m/Y', $row['time_to']);
}
$array_userid_retails = array();
$_sql = 'SELECT userid,company_name FROM tms_vi_retails_seller_management';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_userid_retails[$_row['userid']] = $_row;
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
        ->from('' . NV_PREFIXLANG . '_' . $module_data . '_voucher');

    if (!empty($q)) {
        $db->where('userid LIKE :q_userid OR voucher_name LIKE :q_voucher_name OR voucher_code LIKE :q_voucher_code OR time_from LIKE :q_time_from OR time_to LIKE :q_time_to OR discount_price LIKE :q_discount_price');
    }
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_userid', '%' . $q . '%');
        $sth->bindValue(':q_voucher_name', '%' . $q . '%');
        $sth->bindValue(':q_voucher_code', '%' . $q . '%');
        $sth->bindValue(':q_time_from', '%' . $q . '%');
        $sth->bindValue(':q_time_to', '%' . $q . '%');
        $sth->bindValue(':q_discount_price', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_userid', '%' . $q . '%');
        $sth->bindValue(':q_voucher_name', '%' . $q . '%');
        $sth->bindValue(':q_voucher_code', '%' . $q . '%');
        $sth->bindValue(':q_time_from', '%' . $q . '%');
        $sth->bindValue(':q_time_to', '%' . $q . '%');
        $sth->bindValue(':q_discount_price', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate('voucher_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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

foreach ($array_userid_retails as $value) {
    $xtpl->assign('OPTION', array(
        'key' => $value['userid'],
        'title' => $value['company_name'],
        'selected' => ($value['userid'] == $row['userid']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_userid');
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
        $xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
        $view['time_from'] = (empty($view['time_from'])) ? '' : nv_date('d/m/Y', $view['time_from']);
        $view['time_to'] = (empty($view['time_to'])) ? '' : nv_date('d/m/Y', $view['time_to']);
        $view['userid'] = $array_userid_retails[$view['userid']]['company_name'];
        
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

$page_title = $lang_module['voucher'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
