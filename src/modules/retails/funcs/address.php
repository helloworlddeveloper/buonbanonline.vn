<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Thu, 18 Mar 2021 01:33:55 GMT
	*/
	//TEST3
	if (!defined('NV_IS_MOD_RETAILSHOPS'))
    die('Stop!!!');
	
	$mod = $nv_Request->get_string('mod', 'post, get', 0);
	

	if($mod=="set_default"){
		$id=$nv_Request->get_int('id', 'get',0);
		$db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_address SET status = 0 WHERE userid = ' . $user_info['userid']);
		$db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_address SET status = 1 WHERE userid = ' . $user_info['userid'] .' AND id = ' . $id);
		$json[] = ['status'=>'OK', 'text'=>'Đặt địa chỉ mặc định thành công'];
		print_r(json_encode($json[0]));die(); 
	}
	if($mod=="province_id"){
		$q=$nv_Request->get_string('q', 'get','');
		$list = get_province_select2($q);
		
		foreach($list as $result){
			$json[] = ['id'=>$result['provinceid'], 'text'=>$result['title']];
		}
		print_r(json_encode($json));die(); 
	}
	if($mod=="district_id"){
		$q=$nv_Request->get_string('q', 'get','');
		$province_id=$nv_Request->get_string('province_id', 'get','');
		$list = get_district_select2($q,$province_id);
		
		foreach($list as $result){
			$json[] = ['id'=>$result['districtid'], 'text'=>$result['title']];
		}
		print_r(json_encode($json));die(); 
	}
	if($mod=="ward_id"){
		$q=$nv_Request->get_string('q', 'get','');
		$district_id=$nv_Request->get_string('district_id', 'get','');
		$list = get_ward_select2($q,$district_id);
		
		
		foreach($list as $result){
			$json[] = ['id'=>$result['wardid'], 'text'=>$result['title']];
		}
		print_r(json_encode($json));die(); 
	}
	
	if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
		$id = $nv_Request->get_int('delete_id', 'get');
		$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
		
		// kiểm tra địa chỉ mặc định không được xóa
		$default = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_address WHERE userid = '. $user_info['userid'] .' AND status = 1 AND id = ' . $db->quote($id))->fetchColumn();
		
		
		if ($id > 0 and !$default and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_address  WHERE userid = '. $user_info['userid'] .' AND id = ' . $db->quote($id));
			$nv_Cache->delMod($module_name);
			nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Address', 'ID: ' . $id, $user_info['userid']);
			nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
	}
	
	$row = array();
	$error = array();
	$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
	if ($nv_Request->isset_request('submit', 'post')) {
		
		$row['address'] = $nv_Request->get_title('maps_address', 'post', '');
		$row['userid'] = $nv_Request->get_int('userid', 'post', 0);
		$row['status'] = $nv_Request->get_int('status', 'post', 0);
		$row['time'] = NV_CURRENTTIME;
		$row['ward_id'] = $nv_Request->get_int('ward_id', 'post', 0);
		$row['district_id'] = $nv_Request->get_int('district_id', 'post', 0);
		$row['province_id'] = $nv_Request->get_int('province_id', 'post', 0);
		
		$row['phone'] = $nv_Request->get_title('phone', 'post', '');
		$row['name'] = $nv_Request->get_title('name', 'post', '');
		//$row['lat'] = $nv_Request->get_string('lat', 'post', '');
		//$row['lng'] = $nv_Request->get_string('lng', 'post', '');
		//$row['centerlng'] = $nv_Request->get_string('centerlng', 'post', '');
		//$row['centerlat'] = $nv_Request->get_string('centerlat', 'post', '');
		//$row['maps_mapzoom'] = $nv_Request->get_string('maps_mapzoom', 'post', '');

		
		if (empty($row['address'])) {
			$error[] = $lang_module['error_required_address'];
			} elseif (empty($row['ward_id'])) {
			$error[] = $lang_module['error_required_ward_id'];
			} elseif (empty($row['district_id'])) {
			$error[] = $lang_module['error_required_district_id'];
			} elseif (empty($row['province_id'])) {
			$error[] = $lang_module['error_required_province_id'];
			} elseif (empty($row['phone'])) {
			$error[] = $lang_module['error_required_phone'];
		}
		if($row['phone']!=''){
			$check = preg_match('/^[0]{1}[0-9]{9}+$/',$row['phone']);
			if(empty($check)){
				$error[] = 'Số điện thoại không hợp lệ';
			}
		}
		
		
		if (empty($error)) {
			try {
				//$row['status'] = 0;
				// SET DEFAULT
				if($row['status'])
				{
					$db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_address SET status = 0 WHERE userid = ' . $user_info['userid']);
					$row['status'] = 1;
				}
				else
				{
					$check = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_address WHERE status = 1 AND id !='. $row['id'] .' AND userid = ' . $user_info['userid'])->fetchColumn();
					
					if(!$check)
					$row['status'] = 1;
				}
				
				$address = get_full_address($row['ward_id'], $row['district_id'], $row['province_id']);

				$address_full = $row['address'] . $address;
				
				if(!$user_info){
					
				}else{
					if (empty($row['id'])) {
					
						$stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_address (lat,lng,address,name, userid, status, time_add, ward_id, district_id, province_id, phone,centerlat,centerlng,maps_mapzoom) VALUES (:lat,:lng,:address,:name, :userid, :status, :time, :ward_id, :district_id, :province_id, :phone,:centerlat,:centerlng,:maps_mapzoom)');
						
						} else {
						
						$stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_address SET lat = :lat,lng = :lng,name = :name,address = :address, userid = :userid, status = :status, time_edit = :time, ward_id = :ward_id, district_id = :district_id, province_id = :province_id, phone = :phone, centerlat=:centerlat,centerlng=:centerlng,maps_mapzoom=:maps_mapzoom WHERE id=' . $row['id']);
					}
				}

				
				
				$stmt->bindParam(':status', $row['status'], PDO::PARAM_INT);
				$stmt->bindParam(':address', $address_full, PDO::PARAM_STR);
				$stmt->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
				$stmt->bindParam(':lng', $row['lng'], PDO::PARAM_STR);
				$stmt->bindParam(':lat', $row['lat'], PDO::PARAM_STR);
				$stmt->bindParam(':time', $row['time'], PDO::PARAM_INT);
				$stmt->bindParam(':ward_id', $row['ward_id'], PDO::PARAM_INT);
				$stmt->bindParam(':district_id', $row['district_id'], PDO::PARAM_INT);
				$stmt->bindParam(':province_id', $row['province_id'], PDO::PARAM_INT);
				$stmt->bindParam(':province_id', $row['province_id'], PDO::PARAM_INT);
				$stmt->bindParam(':phone', $row['phone'], PDO::PARAM_STR, strlen($row['phone']));
				$stmt->bindParam(':name', $row['name'], PDO::PARAM_STR, strlen($row['name']));
				$stmt->bindParam(':centerlat', $row['centerlat'], PDO::PARAM_STR);
				$stmt->bindParam(':centerlng', $row['centerlng'], PDO::PARAM_STR);
				$stmt->bindParam(':maps_mapzoom', $row['maps_mapzoom'], PDO::PARAM_STR);
				
				$exc = $stmt->execute();
				
				if ($exc) {
					$nv_Cache->delMod($module_name);
					if (empty($row['id'])) {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Address', ' ', $user_info['userid']);
						} else {
						nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Address', 'ID: ' . $row['id'], $user_info['userid']);
					}
					
					if(isset($_SESSION['back_link']) and !empty($_SESSION['back_link'])){
						nv_redirect_location($_SESSION['back_link']);
						}else{
						nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
					}
					
					
				}
				} catch(PDOException $e) {
				trigger_error($e->getMessage());
				die($e->getMessage()); //Remove this line after checks finished
			}
		}
		} elseif ($row['id'] > 0) {
		$row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_address WHERE id=' . $row['id'])->fetch();
		if (empty($row)) {
			nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
			
		}
		} else {
		$row['id'] = 0;
		$row['address'] = '';
		$row['userid'] = 0;
		$row['status'] = 0;
		$row['time_add'] = 0;
		$row['time_edit'] = 0;
		$row['ward_id'] = 0;
		$row['district_id'] = 0;
		$row['province_id'] = 0;
		$row['phone'] = '';
	}
	
	$row['phone'] = nv_htmlspecialchars(nv_br2nl($row['phone']));
	
	
	$q = $nv_Request->get_title('q', 'post,get');
	
	// Fetch Limit
	$show_view = false;
	if (!$nv_Request->isset_request('id', 'post,get')) {
		$show_view = true;
		$per_page = 20;
		$page = $nv_Request->get_int('page', 'post,get', 1);
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . NV_PREFIXLANG . '_' . $module_data . '_address WHERE userid = ' . $user_info['userid'] );
		
		if (!empty($q)) {
			$db->where('address LIKE :q_address OR userid LIKE :q_userid OR status LIKE :q_status OR time_add LIKE :q_time_add OR time_edit LIKE :q_time_edit OR ward_id LIKE :q_ward_id OR district_id LIKE :q_district_id OR province_id LIKE :q_province_id OR phone LIKE :q_phone');
		}
		$sth = $db->prepare($db->sql());
		
		if (!empty($q)) {
			$sth->bindValue(':q_address', '%' . $q . '%');
			$sth->bindValue(':q_userid', '%' . $q . '%');
			$sth->bindValue(':q_status', '%' . $q . '%');
			$sth->bindValue(':q_time_add', '%' . $q . '%');
			$sth->bindValue(':q_time_edit', '%' . $q . '%');
			$sth->bindValue(':q_ward_id', '%' . $q . '%');
			$sth->bindValue(':q_district_id', '%' . $q . '%');
			$sth->bindValue(':q_province_id', '%' . $q . '%');
			$sth->bindValue(':q_phone', '%' . $q . '%');
		}
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('*')
		->order('id DESC')
		->limit($per_page)
		->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		
		if (!empty($q)) {
			$sth->bindValue(':q_address', '%' . $q . '%');
			$sth->bindValue(':q_userid', '%' . $q . '%');
			$sth->bindValue(':q_status', '%' . $q . '%');
			$sth->bindValue(':q_time_add', '%' . $q . '%');
			$sth->bindValue(':q_time_edit', '%' . $q . '%');
			$sth->bindValue(':q_ward_id', '%' . $q . '%');
			$sth->bindValue(':q_district_id', '%' . $q . '%');
			$sth->bindValue(':q_province_id', '%' . $q . '%');
			$sth->bindValue(':q_phone', '%' . $q . '%');
		}
		$sth->execute();
		
		
	}
	
	$xtpl = new XTemplate('address.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
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
	
	if($row['status'])
	{
		$xtpl->assign('checked', 'checked=checked');	
	}
	if($user_info['userid']){
		$xtpl->assign('show_email', 'd-none');	
		$xtpl->assign('show_submit', 'd-none');	
	}else{
		$xtpl->assign('show_submit1', 'd-none');
	}
	
	$xtpl->assign('Q', $q);
	
	
	$xtpl->assign('address', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=address&amp;id=0');
	$xtpl->assign('address_list', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '='. $module_name .'&amp;' . NV_OP_VARIABLE . '=' . $op);
	if(isset($_SESSION['back_link']) and !empty($_SESSION['back_link']))
	$xtpl->assign('back_link', $_SESSION['back_link']);
	
	if ($show_view) {
		// xoá secsion order
		unset( $_SESSION['back_link'] );
		
		$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
		if (!empty($q)) {
			$base_url .= '&q=' . $q;
		}
		$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
		if (!empty($generate_page)) {
			$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
			$xtpl->parse('main.view.generate_page');
		}
		$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
		while ($view = $sth->fetch()) {
			$view['number'] = $number++;
			$view['link_edit'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
			$view['link_delete'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
			
			if($view['status'] == 1){
				$xtpl->assign('btn_noChoose', 'class="btn_noChoose"');
				$xtpl->assign('VIEW', $view);
				$xtpl->parse('main.view.loop.no_set_default');
				$xtpl->parse('main.view.loop.default');
				}else{
				$xtpl->assign('btn_noChoose', 'class="btn_ecng_outline"');
				$xtpl->assign('VIEW', $view);
				$xtpl->parse('main.view.loop.set_default');
				$xtpl->parse('main.view.loop.delete');
			}
			
			$xtpl->assign('VIEW', $view);
			$xtpl->parse('main.view.loop');
			
		}
		
		$xtpl->parse('main.view');
		
		
		$xtpl->parse('main.view1');
		}else{
		$xtpl->assign('DIS', '');
		
		$address_ward = explode(',',$row['address']);
		$address_ward = $address_ward[0];
	
		$xtpl->assign('AD', $address_ward);
		
		if($row['province_id'])
		{
			$list_province = get_province_select2('');
			
			foreach ($list_province as $value_list) {
				if($row['province_id'] == $value_list['provinceid']){
					$value_list["selected"] = "selected";
				}
				$xtpl->assign( 'STATUS', $value_list);
				$xtpl->parse( 'main.edit.province_id' );
			}
		}
		
		if($row['province_id'] and $row['district_id'])
		{
			$list_district = get_district_select2('',$row['province_id']);
			
			foreach ($list_district as $value_list) {
				if($row['district_id'] == $value_list['districtid']){
					$value_list["selected"] = "selected";
				}
				$xtpl->assign( 'STATUS', $value_list);
				$xtpl->parse( 'main.edit.district_id' );
			}
		}
		
		if($row['province_id'] and $row['district_id'] and $row['ward_id'])
		{
			$list_ward = get_ward_select2('',$row['district_id']);
			foreach ($list_ward as $value_list) {
				if($row['ward_id'] == $value_list['wardid']){
					$value_list["selected"] = "selected";
				}
				$xtpl->assign( 'STATUS', $value_list);
				$xtpl->parse( 'main.edit.ward_id' );
			}
		}
		
		
	}
	
	
	if (!empty($error)) {
		$xtpl->assign('ERROR', implode('<br />', $error));
		$xtpl->parse('main.error');
	}
	
	if ($nv_Request->isset_request('id', 'get'))
	{	
		$xtpl->parse('main.edit');
	}
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = 'Quản lý địa chỉ';
	$array_mod_title[] = array(
	'catid' => 0,
	'title' => $page_title,
	'link' => NV_MY_DOMAIN .'/'.$op.'/'
	);
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
