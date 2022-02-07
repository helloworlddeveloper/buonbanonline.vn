<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 08 Dec 2021 02:49:39 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');


// xóa redis
$redis->delete('location_all', 'location_province','location_district','location_ward');


// khởi tạo redis
// redis địa chỉ
	
	
	// redis quận huyện
	if(!$redis->exists('location_province'))
	{
		$location_province = location_province_all();
		$redis->set('location_province', json_encode($location_province));	
	}
	
	
	// redis quận huyện
	if(!$redis->exists('location_district'))
	{
		$location_district = location_district_all();
		$redis->set('location_district', json_encode($location_district));	
	}
	
	// redis xã phường
	if(!$redis->exists('location_ward'))
	{
		$location_ward = location_ward_all();
		$redis->set('location_ward', json_encode($location_ward));	
	}
	
	
	// lấy địa chỉ theo tất cả các cấp
	if(!$redis->exists('location_all'))
	{
		$location_all = location_all();
		$redis->set('location_all', json_encode($location_all));	
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


$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['refresh_redis'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
