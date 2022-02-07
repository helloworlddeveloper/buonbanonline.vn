<?php
/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2019 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 22 May 2019 04:06:54 GMT
 */

$mod = $nv_Request->get_string( 'mod', 'get,post', '' );
if($mod=="updatevnpostid"){
	$vnpostid = $nv_Request->get_title( 'vnpostid', 'post', 0);
	$provinceid = $nv_Request->get_title( 'provinceid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_province SET 
		vnpostid = ' . ( int )$vnpostid . '
		WHERE provinceid = ' . intval( $provinceid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="updatevtpid"){
	$vtpid = $nv_Request->get_title( 'vtpid', 'post', 0);
	$provinceid = $nv_Request->get_title( 'provinceid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_province SET 
		vtpid = ' . ( int )$vtpid . '
		WHERE provinceid = ' . intval( $provinceid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="updateghnid"){
	$ghnid = $nv_Request->get_title( 'ghnid', 'post', 0);
	$provinceid = $nv_Request->get_title( 'provinceid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_province SET 
		ghnid = ' .  $db->quote($ghnid) . '
		WHERE provinceid = ' . intval( $provinceid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="updatelat"){
	$lat = $nv_Request->get_title( 'lat', 'post', 0);
	$provinceid = $nv_Request->get_title( 'provinceid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_province SET 
		lat = ' .  $db->quote($lat) . '
		WHERE provinceid = ' . intval( $provinceid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="updatelng"){
	$lng = $nv_Request->get_title( 'lng', 'post', 0);
	$provinceid = $nv_Request->get_title( 'provinceid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_province SET 
		lng = ' .  $db->quote($lng) . '
		WHERE provinceid = ' . intval( $provinceid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="districtvnpostid"){
	$vnpostid = $nv_Request->get_title( 'vnpostid', 'post', 0);
	$districtid = $nv_Request->get_title( 'districtid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_district SET 
		vnpostid = ' . ( int )$vnpostid . '
		WHERE districtid = ' . intval( $districtid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="districtvtpid"){
	$vtpid = $nv_Request->get_title( 'vtpid', 'post', 0);
	$districtid = $nv_Request->get_title( 'districtid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_district SET 
		vtpid = ' . ( int )$vtpid . '
		WHERE districtid = ' . intval( $districtid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="districtghnid"){
	$ghnid = $nv_Request->get_title( 'ghnid', 'post', 0);
	$districtid = $nv_Request->get_title( 'districtid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_district SET 
		ghnid = ' . $db->quote($ghnid) . '
		WHERE districtid = ' . intval( $districtid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="districtlat"){
	$lat = $nv_Request->get_title( 'lat', 'post', 0);
	$districtid = $nv_Request->get_title( 'districtid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_district SET 
		lat = ' .  $db->quote($lat) . '
		WHERE districtid = ' . intval( $districtid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="districtlng"){
	$lng = $nv_Request->get_title( 'lng', 'post', 0);
	$districtid = $nv_Request->get_title( 'districtid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_district SET 
		lng = ' .  $db->quote($lng) . '
		WHERE districtid = ' . intval( $districtid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="wardvnpostid"){
	$vnpostid = $nv_Request->get_title( 'vnpostid', 'post', 0);
	$wardid = $nv_Request->get_title( 'wardid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_ward SET 
		vnpostid = ' . ( int )$vnpostid . '
		WHERE wardid = ' . intval( $wardid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="wardvtpid"){
	$vtpid = $nv_Request->get_title( 'vtpid', 'post', 0);
	$wardid = $nv_Request->get_title( 'wardid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_ward SET 
		vtpid = ' . ( int )$vtpid . '
		WHERE wardid = ' . intval( $wardid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="wardghnid"){
	$ghnid = $nv_Request->get_title( 'ghnid', 'post', 0);
	$wardid = $nv_Request->get_title( 'wardid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_ward SET 
		ghnid = ' . $db->quote($ghnid) . '
		WHERE wardid = ' . intval( $wardid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="wardidlat"){
	$lat = $nv_Request->get_title( 'lat', 'post', 0);
	$wardid = $nv_Request->get_title( 'wardid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_ward SET 
		lat = ' .  $db->quote($lat) . '
		WHERE wardid = ' . intval( $wardid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}
if($mod=="wardidlng"){
	$lng = $nv_Request->get_title( 'lng', 'post', 0);
	$wardid = $nv_Request->get_title( 'wardid', 'post', 0);
	$db->query('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_ward SET 
		lng = ' .  $db->quote($lng) . '
		WHERE wardid = ' . intval( $wardid ));
	$notification=array(
		"status" => "OK",
		"mess" => 'Đã thêm thành công'
	);
	echo json_encode($notification);
	die;
}