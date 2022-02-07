<?php

/**
	* @Project TMS HOLDINGS
	* @Author TMS Holdings <contact@tms.vn>
	* @Copyright (C) 2020 TMS Holdings. All rights reserved
	* @License GNU/GPL version 2 or any later version
	* @Createdate Mon, 21 Dec 2020 09:08:19 GMT
*/


if (!defined('NV_IS_MOD_RETAILSHOPS'))
die('Stop!!!');

$mod = $nv_Request->get_string('mod', 'post, get', 0);
$id = $nv_Request->get_int('id', 'get','');

if($mod=="wishlist"){
	
	if (!defined('NV_IS_USER')) {
		
		// lấy thông tin link chi tiết sản phẩm lưu vào SESSION
		$get_link_product = get_info_product($id)['link'];
		$_SESSION['back_link'] = $get_link_product;
		
		print_r( json_encode( array( 'status'=>'ERROR','link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login',true) ) ) );
		die();
		}else{
		
		
		
		$check_have_like = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $id) -> fetchColumn();
		if($check_have_like == 0){
			$db->query('INSERT INTO ' . TABLE . '_wishlist(userid,product_id,time_add) VALUES ('.$user_info['userid'].','.$id.','.NV_CURRENTTIME.')');
			
			$number_like_current = $db->query('SELECT COUNT(*) FROM ' . TABLE . '_wishlist WHERE product_id = ' . $id)->fetchColumn();
			$db->query('UPDATE ' . TABLE . '_product SET number_like = ' . $number_like_current . ' WHERE id = ' . $id);
			
			$json[] = ['status'=>'OK', 'text'=>'Thêm vào yêu thích thành công!'];
			}else{
			$json[] = ['status'=>'OK', 'text'=>'Bạn đã thích sản phẩm này rồi!'];
		}
		
		
		print_r(json_encode($json[0]));die(); 
	}
}
if($mod=="un_wishlist"){
	$id=$nv_Request->get_int('id', 'get','');
	$check_have_like = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $id) -> fetchColumn();
	if($check_have_like != 0){
		$db->query('DELETE FROM ' . TABLE . '_wishlist WHERE product_id = ' . $id . ' AND userid = ' . $user_info['userid']);
		$number_like_current = $db->query('SELECT COUNT(*) FROM ' . TABLE . '_wishlist WHERE product_id = ' . $id)->fetchColumn();
		$db->query('UPDATE ' . TABLE . '_product SET number_like = ' . $number_like_current . ' WHERE id = ' . $id);
		
		$json[] = ['status'=>'OK', 'text'=>'Xóa khỏi yêu thích thành công!'];
		}else{
		$json[] = ['status'=>'OK', 'text'=>'Bạn chưa thích sản phẩm này!'];
	}
	
	print_r(json_encode($json[0]));die(); 
}



$xtpl = new XTemplate('catalogy.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
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


$full_category = get_list_full_category();

foreach($full_category as $category)
{
	if($category['parrent_id'] == 0)
	{
		
		if (!empty($category['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $category['image'])) {
			$category['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $category['image'];
		}
		else
		{
			$category['image'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/no_image.gif';
		}
		
		$category['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $category['alias'], true );
		
		//print_r($category);die;
		$xtpl->assign('category', $category);
		$xtpl->parse('main.category');
	}
}


$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = 'Danh mục';

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
