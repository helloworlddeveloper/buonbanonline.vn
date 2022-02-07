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
if (!defined('NV_IS_USER')) {
	echo '<script language="javascript">';
	echo 'alert("Vui lòng đăng nhập trước để thực hiện chức năng này.");window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login',true).'"';
	echo '</script>';
}
$mod = $nv_Request->get_string( 'mod', 'get,post', '' );



$q = $nv_Request->get_title( 'q', 'post,get' );

$contents = nv_theme_retailshops_repayment($q);

$page_title = $lang_module['ordercustomer'];
$array_mod_title[] = array(
	'catid' => 0,
	'title' => 'Thanh toán thất bại',
	'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.$op.'/'
);
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
