<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 06 May 2015 02:22:19 GMT
 */

if (!defined('NV_IS_MOD_NOTIFICATION')) die('Stop!!!');


define('TABLE',   $db_config['dbsystem'] . '.'. NV_PREFIXLANG . '_retails');




$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

if (!defined('NV_IS_USER')) {
    Header('Location: ' . NV_BASE_SITEURL);
    die();
}

// Đánh dấu đã xem tất cả các thông báo
if ($nv_Request->isset_request('notification_reset', 'post')) {
    $sql = 'UPDATE ' . NV_NOTIFICATION_USER . ' SET view=1
    WHERE view=0 AND (area = 1 OR area = 2) AND (send_to = 0 OR send_to=' . $user_info['userid'] . ') AND language=' . $db->quote(NV_LANG_DATA);
    $db->query($sql);
    nv_htmlOutput('');
}

$mod = $nv_Request->get_title('mod', 'post,get', '');
if($mod=='load_notification'){

    $last_time_call = $nv_Request->get_int('timestamp', 'post', 0);
    $last_time = 0;
    $count = 0;
    $return = [];
    $sql = 'SELECT add_time FROM ' . NV_NOTIFICATION_USER . ' WHERE language="' . NV_LANG_DATA . '"
    AND (area = 1 OR area = 2) AND view=0 AND (send_to = 0 OR send_to=' . $user_info['userid'] . ') ORDER BY id DESC';
    $result = $db->query($sql);
    $count = $result->rowCount();
    if ($result) {
        $last_time = $result->fetchColumn();
    }

    if ($last_time > $last_time_call) {
        $return = [
            'data_from_file' => $count,
            'timestamp' => $last_time
        ];
    }

    nv_jsonOutput($return);

}

$page = $nv_Request->get_int('page', 'get', 1);
$is_ajax = $nv_Request->isset_request('ajax', 'post,get');
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$per_page = $is_ajax ? 10 : 20;
$array_data = [];
$db->sqlreset()
->select('COUNT(*)')
->from(NV_NOTIFICATION_USER)
->where('language = "' . NV_LANG_DATA . '" AND (area = 1 OR area = 2)  AND (send_to = 0 OR send_to=' . $user_info['userid'] . ')');



$all_pages = $db->query($db->sql())
->fetchColumn();

$db->select('*')
->order('id DESC')
->limit($per_page)
->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());
$num_rows = $result->rowCount();

while ($data = $result->fetch()) {
    if (isset($admin_mods[$data['module']]) or isset($site_mods[$data['module']])) {
        $mod = $data['module'];

        $data['content'] = $data['content'];
        // Hien thi thong bao tu cac module he thong
        if ($data['module'] == 'modules') {
            if ($data['type'] == 'auto_deactive_module') {
                $data['title'] = sprintf($lang_module['notification_module_auto_deactive'], $data['content']['custom_title']);
                $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'];
            }
        }
        if ($data['module'] == 'retails') {
            if ($data['type'] == 'listorder') {
                $data['title'] = $data['content'];
                $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=ordercustomer';
            }
            if ($data['type'] == 'follows') {
                $data['title'] = $data['content'];
                $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=follow';
            }
            if ($data['type'] == 'order') {
                $data['title'] = $data['content'];
               
				$data['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=vieworder&amp;id=' . $data['obid'],true);
				
            }
            if ($data['type'] == 'complain') {
                $data['title'] = $data['content'];
                $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=ordercustomer';
            }
            
        }
        if ($data['module'] == 'settings') {
            if ($data['type'] == 'auto_deactive_cronjobs') {
                $cron_title = $db->query('SELECT ' . NV_LANG_DATA . '_cron_name FROM ' . $db_config['dbsystem'] . '.' . NV_CRONJOBS_GLOBALTABLE . ' WHERE id=' . $data['content']['cron_id'])->fetchColumn();
                $data['title'] = sprintf($lang_module['notification_cronjobs_auto_deactive'], $cron_title);
                $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=cronjobs';
            } elseif ($data['type'] == 'sendmail_failure') {
                $data['title'] = sprintf($lang_module['notification_email_failure'], $data['content'][0], $data['content'][1]);
                $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=smtp';
            }
        }

        // Hien thi tu cac module
        if (isset($site_mods[$data['module']]) and file_exists(NV_ROOTDIR . '/modules/' . $site_mods[$data['module']]['module_file'] . '/notification.php')) {
            // Hien thi thong bao tu cac module site
            if ($data['send_from'] > 0) {
                $user_info = $db->query('SELECT username, first_name, last_name, photo FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid = ' . $data['send_from'])->fetch();
                if ($user_info) {
                    $data['send_from'] = nv_show_name_user($user_info['first_name'], $user_info['last_name'], $user_info['username']);
                } else {
                    $data['send_from'] = $lang_global['level5'];
                }

                if (!empty($user_info['avata'])) {
                    $data['photo'] = $user_info['avata'];
                } else {
                    $data['photo'] = NV_BASE_SITEURL . 'themes/default/images/users/no_avatar.png';
                }
            } else {
                $data['photo'] = NV_BASE_SITEURL . 'themes/default/images/users/no_avatar.png';
                $data['send_from'] = $lang_global['level5'];
            }
			
            include NV_ROOTDIR . '/modules/' . $site_mods[$data['module']]['module_file'] . '/notification.php';
        }

        $data['add_time_iso'] = nv_date(DATE_ISO8601, $data['add_time']);
        $data['add_time'] = nv_date('H:i - d/m/Y', $data['add_time']);

        if (!empty($data['title'])) {
            $array_data[$data['id']] = $data;
        }
    }
}

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/'.$module_name);
$xtpl->assign('LANG', $lang_module);

if (!empty($array_data)) {
    foreach ($array_data as $data) {
        if($data['view'] == 1){
            $data['background'] = '#fff';
        }else{
            $data['background'] = '#E0EAF3';
        }
        $xtpl->assign('DATA', $data);
        $xtpl->parse('main.loop');
    }

    if ($is_ajax) {
        $contents = $xtpl->text('main.loop');
    } else {
        $generate_page = nv_generate_page($base_url, $all_pages, $per_page, $page);
        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.generate_page');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    }
} elseif ($is_ajax) {
    $contents = $page == 1 ? $lang_module['notification_empty'] : '';
} else {
    if ($page != 1) {
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }

    $xtpl->parse('empty');
    $contents = $xtpl->text('empty');
}

include NV_ROOTDIR . '/includes/header.php';
echo $is_ajax ? $contents : nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';