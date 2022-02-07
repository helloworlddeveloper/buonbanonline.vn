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
	define('NV_TABLE_USER', $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_users');

	if (isset($array_op[0])) {
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
	}
	
	$page_title = $module_info['site_title'];
	
	
	$key_words = $module_info['keywords'];
	$mod_title = isset($lang_module['main_title']) ? $lang_module['main_title'] : $module_info['custom_title'];
	
	if (!defined('NV_IS_ADMIN') and !$global_config['allowuserlogin']) {
		$contents = user_info_exit($lang_module['notallowuserlogin']);
		} else {
		if (!defined('NV_IS_USER')) {
			$url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=login';
			$nv_redirect = nv_get_redirect();
			if (!empty($nv_redirect)) {
				$url .= '&nv_redirect=' . $nv_redirect;
			}
			nv_redirect_location($url);
			} else {
			// So nhom dang quan ly
			$user_info['group_manage'] = $db->query('SELECT COUNT(*) FROM ' . NV_MOD_TABLE . '_groups_users WHERE userid=' . $user_info['userid'] . ' AND is_leader=1')->fetchColumn();
			
			$contents = user_welcome();
			
		}
	}
	
	$mod = $nv_Request->get_title('mod', 'get', '');
	
	
	// cập nhật thông tin user
	if($mod == 'change_image'){	
		$data = $nv_Request->get_string('haha', 'post, get', '');
		
		define('UPLOAD_DIR', SYSTEM_UPLOADS_DIR . '/' . $module_upload . '/');
		$img = $data;
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . uniqid() . NV_CURRENTTIME .'.png';
		$success = file_put_contents($file, $data);
		$kq = $success ? $file : 'Unable to save the file.';
		
		//delete img
		$sql = 'SELECT photo FROM ' . NV_MOD_TABLE . ' WHERE userid=' . $user_info['userid'];
		$result = $db->query($sql);
		$oldAvatar = $result->fetchColumn();
		$result->closeCursor();

		if (!empty($oldAvatar)) {
			if (file_exists(NV_ROOTDIR . '/' . $oldAvatar)) {
				nv_deletefile(NV_ROOTDIR . '/' . $oldAvatar);
			}
		}
		//update img
		$stmt = $db->prepare('UPDATE ' . NV_MOD_TABLE . ' SET photo=:photo, last_update=' . NV_CURRENTTIME . ' WHERE userid=' . $user_info['userid']);
        $stmt->bindParam(':photo', $file, PDO::PARAM_STR);
        $stmt->execute();
		print_r(NV_BASE_SITEURL . $file);die;
	}
	
	
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';