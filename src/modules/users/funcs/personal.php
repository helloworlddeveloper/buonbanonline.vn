<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/03/2010 10:51
 */

if (!defined('NV_IS_MOD_USER')) {
    die('Stop!!!');
}


// đây là xuất dữ liệu ra ngoài file tpl. tên file là $op . '.tpl' tương ứng $op = personal.tpl

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/'  . $module_info['template'] . '/modules/' . $module_info['module_theme']);



$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('TEMPLATE', $module_info['template']);

$logo_small = preg_replace('/(\.[a-z]+)$/i', '_small\\1', $global_config['site_logo']);
$logo = file_exists(NV_ROOTDIR . '/' . $logo_small) ? $logo_small : $global_config['site_logo'];

$xtpl->assign('LOGO_SRC', NV_BASE_SITEURL . $logo);
$xtpl->assign('SITE_NAME', $global_config['site_name']);
	
$xtpl->assign('USER_REGISTER', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=register');
$xtpl->assign('USER_LOGIN', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=login');

$xtpl->assign('USER', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);

$page_title = $lang_module['personal'];
$key_words = $module_info['personal'];
$mod_title = $lang_module['personal'];

 $xtpl->assign('SUPPORT', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=support', true));
		

if (defined('NV_IS_USER') or !$global_config['allowuserlogin']) {
	
	//print_r($user_info);die;
	if($user_info['photo']){
			$user_info['photo'] = NV_BASE_SITEURL . $user_info['photo'];
	}else{
			$user_info['photo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/no_img.png';
	}
		
	$xtpl->assign('user', $user_info);
	
	$xtpl->assign('BANHANG', 'banhang.chonhagiau.com');
	
	$xtpl->assign('ADDRESS', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=address', true));
		
    $xtpl->assign('PASSWORD', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=changepassword', true));
		
    $xtpl->assign('LOVE', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=wishlist', true));
	
    $xtpl->assign('FOLLOW', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=follow', true));
		
    $xtpl->assign('HISTORY', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=ordercustomer', true));
	
	$xtpl->assign('RE_PAYMENT', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=re-payment', true));
	//print_r(nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=re-payment', true));
	
	$xtpl->assign('COMPLAIN', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=complain-list', true));
	$xtpl->parse('main.info');
	
}
else
{
	$xtpl->parse('main.login');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$_SESSION['back_link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '='. $module_name .'&amp;' . NV_OP_VARIABLE . '=' . $op, true);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
