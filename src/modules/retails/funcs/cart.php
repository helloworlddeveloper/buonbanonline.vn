<?php
if (defined('NV_IS_USER')) {
	$check_seller=$db->query('SELECT count(*) FROM '.TABLE.'_seller_management where userid='.$user_info['userid'])->fetchColumn();
	if($check_seller>0){
		echo '<script language="javascript">';
		echo 'alert("Bạn đã là người bán nên không thể mua hàng. Vui lòng tạo lại tài khoản người mua");window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=retails' . '&' . NV_OP_VARIABLE . '=main',true).'"';
		echo '</script>';
	}
}


$contents = nv_theme_retailshops_cart($_SESSION[$module_name . '_cart']);
$page_title = $lang_module['cart'];

$array_mod_title[] = array(
	'catid' => 0,
	'title' => $lang_module['cart'],
	'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.$op.'/'
);
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
