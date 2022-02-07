<?php
$province_id = $nv_Request->get_int( 'province_id', 'get,post', 0 );
$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
$ward_id = $nv_Request->get_int( 'ward_id', 'get,post', 0 );
if($province_id==0){
	$list=get_province_ghn();
}else{
	if($district_id==0){
		$list=get_district_ghn($province_id);
	}else{
		$list=get_ward_ghn($ward_id);
	}
}
$xtpl = new XTemplate($op.'.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
if($province_id==0){
	foreach($list['data'] as $value){
		$value['alias']= NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;province_id=' . $value['ProvinceID'];
		$xtpl->assign('VIEW', $value);

		$xtpl->parse('main.province.loop');
	}
	$xtpl->parse('main.province');
}else{
	if($district_id==0){
		foreach($list['data'] as $value){
			$value['alias']= NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;province_id=' . $value['ProvinceID'].'&amp;district_id=' . $value['DistrictID'].'&amp;ward_id=' . $value['DistrictID'];
			$xtpl->assign('VIEW', $value);
			$xtpl->parse('main.district.loop');
		}
		$xtpl->parse('main.district');
	}else{
		foreach($list['data'] as $value){
			$xtpl->assign('VIEW', $value);
			$xtpl->parse('main.ward.loop');
		}
		$xtpl->parse('main.ward');
	}
	
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['location_ghn'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';