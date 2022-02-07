<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 04 Jan 2021 09:28:10 GMT
 */

if (!defined('NV_IS_MOD_RETAILSHOPS'))
    die('Stop!!!');
// if (!defined('NV_IS_USER')) {
// 	echo '<script language="javascript">';
// 	echo 'alert("Vui lòng đăng nhập trước để thực hiện chức năng này.");window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login',true).'"';
// 	echo '</script>';
// }
$mod = $nv_Request->get_string( 'mod', 'get,post', '' );

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . TABLE . '_order  WHERE id = ' . $db->quote($id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Order', 'ID: ' . $id, $user_info['userid']);
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}


$q = $nv_Request->get_title( 'q', 'post,get' );
$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' ,0);
$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get',0 );
$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );

$contents = nv_theme_retailshops_list_order_customer($ngay_tu,$ngay_den,$status_ft,$sea_flast,$q);

$page_title = $lang_module['ordercustomer'];
$array_mod_title[] = array(
	'catid' => 0,
	'title' => 'Lịch sử mua hàng',
	'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.$op.'/'
);
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
