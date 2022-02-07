<?php
	
	/**
		* @Project TMS HOLDINGS
		* @Author TMS HOLDINGS (contact@tms.vn)
		* @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate 01/01/2021 09:47
	*/
	
	if (! defined('NV_ADMIN') or ! defined('NV_MAINFILE') or ! defined('NV_IS_MODADMIN'))
    die('Stop!!!');
	
	define('NV_IS_FILE_ADMIN', true);
	require_once NV_ROOTDIR . '/modules/' . $module_file . '/location.class.php';
	
	$allow_func = array(
    'main',  
	'ajax',
    'config',
    'country',
    'area',
    'area_province',
    'refresh_redis',
    'province',
    'district',
	'district_vnpost',
    'ward'
	);
	
	

	// redis quận huyện
	if(!$redis->exists('location_province'))
	{
		$location_province = location_province_all();
		$redis->set('location_province', json_encode($location_province));	
	}
	
	$global_province = json_decode($redis->get('location_province'),true);	
	//print_r($global_province);die;
	
	// redis quận huyện
	if(!$redis->exists('location_district'))
	{
		$location_district = location_district_all();
		$redis->set('location_district', json_encode($location_district));	
	}
	
	$global_district = json_decode($redis->get('location_district'),true);	
	
	
	// redis xã phường
	if(!$redis->exists('location_ward'))
	{
		$location_ward = location_ward_all();
		$redis->set('location_ward', json_encode($location_ward));	
	}
	
	$global_ward = json_decode($redis->get('location_ward'),true);	
	
	
	
	// lấy địa chỉ theo tất cả các cấp
	if(!$redis->exists('location_all'))
	{
		$location_all = location_all();
		
		$redis->set('location_all', json_encode($location_all));	
	}
	
	//$global_location = json_decode($redis->get('location_all'),true);	
	
	function location_all()
	{
		global $db, $db_config, $module_data;
		
		// danh sách khu vực
		$list_area = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_area WHERE status = 1 ORDER BY weight ASC')->fetchAll();
		
		$data = array();
		
		foreach($list_area as $area)
		{
			// danh sách tỉnh thành trong khu vực
			$area['province'] = get_area_province($area['id']);
			$data[$area['id']] = $area;
		}
		
		return $data;
		
	}
	
	
	function get_area_province($area_id)
	{
		global $db, $db_config, $module_data, $global_province;
		
		if(!$area_id)
		return false;
		
		
		$get_province = $db->query('SELECT districtid FROM ' . $db_config['prefix'] . '_' . $module_data . '_area_province WHERE id_area ='. $area_id)->fetchColumn();
		
		$array_province = $db->query('SELECT provinceid FROM ' . $db_config['prefix'] . '_' . $module_data . '_province WHERE provinceid IN('. $get_province .') ORDER BY weight ASC')->fetchAll();
		
		$data = array();
		
		foreach($array_province as $province)
		{
			// lấy thông tin tỉnh thành
			$data[$province['provinceid']] = $global_province[$province['provinceid']];
		}
		
		return $data;
	}
	
	
	// tất cả tỉnh thành
	function location_province_all()
	{
		global $db, $db_config, $module_data;
		
		$list = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_province WHERE status = 1 ORDER BY weight ASC')->fetchAll();
		
		$data = array();
		
		foreach($list as $row)
		{
			// lấy danh sách quận huyện
			$row['district'] = get_district($row['provinceid']);
			$data[$row['provinceid']] = $row;
		}
		
		return $data;
		
	}
	
	
	
	// lấy tất cả quận huyện thuộc 1 tỉnh thành
	function get_district($provinceid)
	{
		global $db, $db_config, $module_data;
		
		if(!$provinceid)
		return false;
		
		$list = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_district WHERE provinceid =' . $provinceid .' AND status = 1 ORDER BY weight ASC')->fetchAll();
		
		$data = array();
		
		foreach($list as $row)
		{
			$data[$row['districtid']] = $row;
		}
		
		return $data;
		
	}
	
	
	// lấy tất cả xã phường thuộc 1 quận huyện
	function get_ward($districtid)
	{
		global $db, $db_config, $module_data;
		
		if(!$districtid)
		return false;
		
		$list = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_ward WHERE districtid =' . $districtid .' AND status = 1 ORDER BY weight ASC')->fetchAll();
		
		$data = array();
		
		foreach($list as $row)
		{
			$data[$row['wardid']] = $row;
		}
		
		return $data;
		
	}
	
	// tất cả quận huyện
	function location_district_all()
	{
		global $db, $db_config, $module_data;
		
		$list = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_district WHERE status = 1 ORDER BY weight ASC')->fetchAll();
		
		$data = array();
		
		foreach($list as $row)
		{
			// lấy danh sách quận huyện
			$row['ward'] = get_ward($row['districtid']);
			$data[$row['districtid']] = $row;
		}
		
		return $data;
		
	}
	
	
	// tất cả xã phường
	function location_ward_all()
	{
		global $db, $db_config, $module_data;
		
		$list = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_ward WHERE status = 1 ORDER BY weight ASC')->fetchAll();
		
		$data = array();
		
		foreach($list as $row)
		{
			$row['full_title'] = $row['type'] . ' ' . $row['title'];
			$data[$row['wardid']] = $row;
		}
		
		return $data;
		
	}
	
	
	
	function get_data($url, $token) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'h-token:'.$token,
		'Token:'.$token
		)
		);
		
        $result = curl_exec($ch);
        curl_close($ch);
		
		$data = json_decode($result,true);
        return $data;
	}
	
	
	function post_data($url, $param_array, $token) {	
		$json = json_encode($param_array);
		// URL có chứa hai thông tin name và diachi
		
		$curl = curl_init($url);
		
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($json).'',
		'h-token:'.$token,
		'Token:'.$token
		)
		);
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($curl);
		
		$data = json_decode($result,true);
		
		curl_close($curl);
		
		return $data;
		
	}
	
	function get_tinhthanh_vnpost(){
		
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain ."/TinhThanh/GetAll";
		
		$data = get_data($url,'');
		
		return $data;
	}
	function get_quanhuyen_vnpost(){
		
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain ."/QuanHuyen/GetAll";
		
		$data = get_data($url,'');
		
		return $data;
	}
	function get_xaphuong_vnpost(){
		
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain ."/PhuongXa/GetAll";
		
		$data = get_data($url,'');
		
		return $data;
	}
	
	
	/**
		* nv_location_delete_province()
		*
		* @param integer $provinceid            
		* @return
		*
	*/
	function nv_location_delete_province($provinceid)
	{
		global $db, $db_config, $module_data;
		
		// Xoa Tinh/Thanh pho
		$result = $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_province WHERE provinceid=' . $provinceid);
		if ($result) {
			// Xoa Quan/Huyen truc thuoc
			$db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_district WHERE provinceid=' . $provinceid);
		}
	}	