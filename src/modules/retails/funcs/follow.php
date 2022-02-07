<?php

/**
	* @Project NUKEVIET 4.x
	* @Author VINADES.,JSC <contact@vinades.vn>
	* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
	* @License GNU/GPL version 2 or any later version
	* @Createdate Sat, 09 Jan 2021 09:34:49 GMT
*/

if (!defined('NV_IS_MOD_RETAILSHOPS'))
die('Stop!!!');
if (!defined('NV_IS_USER')) {
	echo '<script language="javascript">';
	echo 'alert("Vui lòng đăng nhập để thực hiện chức năng này");window.location = "'.NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login'.'"';
	echo '</script>';
}
if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
	$id = $nv_Request->get_int('delete_id', 'get');
	$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
	
	if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
		$db->query('DELETE FROM ' . TABLE . '_follow  WHERE user_id = '. $user_info['userid'].' AND id = ' . $db->quote($id));
		$nv_Cache->delMod($module_name);
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
	}
}

$row = array();
$error = array();

$where = '';

$q = $nv_Request->get_title('s', 'post,get');

if(!empty($q))
{
	$where = ' AND t2.company_name LIKE "%'. $q .'%"';
}

// Fetch Limit

if (!$nv_Request->isset_request('id', 'post,get')) {
	$per_page = 8;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_follow t1, '. TABLE .'_seller_management t2 WHERE t1.shop_id = t2.id AND user_id = ' . $user_info['userid'] . $where);	
	$sth = $db->prepare($db->sql());
	$sth->execute();
	$num_items = $sth->fetchColumn();
	
	$db->select('t2.company_name, t2.avatar_image,t2.userid, t1.id')
	->order('t1.id DESC')
	->limit($per_page)
	->offset(($page - 1) * $per_page);
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$data = $sth-> fetchAll();
	
}

$xtpl = new XTemplate('follow.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

$xtpl->assign('Q', $q);

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
if (!empty($q)) {
	$base_url .= '&s=' . $q;
}
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
	$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
	$xtpl->parse('main.view.generate_page');
}
$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
if($data){
	foreach ($data as $view) {
		$view['alias'] = NV_MY_DOMAIN .'/'. $module_name . '/' . get_info_user($view['userid'])['username'] . '/';
		
		if (!empty($view['avatar_image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/image_shop/' . $view['avatar_image'])) {
			$view['avatar_image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/image_shop/' . $view['avatar_image'];
		}
		
		$view['number'] = $number++;
		$view['link_edit'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
		$xtpl->assign('VIEW', $view);
		$xtpl->parse('main.view.loop');
		
	}
}else{
	$xtpl->parse('main.view.no_data');
}

$xtpl->assign('personal', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=personal');
$xtpl->parse('main.view');



if (!empty($error)) {
	$xtpl->assign('ERROR', implode('<br />', $error));
	$xtpl->parse('main.error');
}



$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['follow'];
$array_mod_title[] = array(
		'catid' => 0,
		'title' => $page_title,
		'link' => NV_MY_DOMAIN .'/'.$op.'/'
	);

if ($nv_Request->isset_request('s', 'get')) {
	echo $contents;
}
else
{
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
}	