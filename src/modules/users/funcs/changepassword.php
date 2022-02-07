<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/03/2010 10:51
 */

if (! defined('NV_IS_MOD_USER')) {
    die('Stop!!!');
}

if (!defined('NV_IS_USER') or !$global_config['allowuserlogin']) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$page_title = $lang_module['changepassword'];
$array_mod_title[] = array(
		'catid' => 0,
		'title' => $page_title,
		'link' => NV_MY_DOMAIN .'/'.$op.'/'
	);

$mod = $nv_Request->get_title('mod', 'get', '');

// cập nhật thông tin user
if($mod == 'change_user')
{
		$array_data['last_name'] = $nv_Request->get_title('last_name', 'post', '');
		$array_data['email'] = nv_strtolower($nv_Request->get_title('email', 'post', ''));
		$array_data['phone'] = $nv_Request->get_title('phone', 'post', '');
		$array_data['gender'] = $nv_Request->get_title('gender', 'post', '');
		$array_data['birthday'] = $nv_Request->get_title('birthday', 'post', '');
		
		
		if(empty($array_data['last_name']))
		{
			nv_jsonOutput(array(
				'status' => 'error',
				'input' => 'last_name',
				'mess' => 'Họ và Tên chưa nhập'
			));
		}
		
		if(empty($array_data['email']))
		{
			nv_jsonOutput(array(
				'status' => 'error',
				'input' => 'email',
				'mess' => 'Email chưa nhập'
			));
		}
		
		$checkemail = nv_check_email_change($array_data['email'], $user_info['userid']);
		if (!empty($checkemail)) {
			nv_jsonOutput(array(
				'status' => 'error',
				'input' => 'email',
				'mess' => $checkemail
			));
		}
		
		if($array_data['phone']!=''){
			$check = preg_match('/^[0]{1}[0-9]{9}+$/',$array_data['phone']);
			if(empty($check)){
				nv_jsonOutput(array(
					'status' => 'error',
					'input' => 'phone',
					'mess' => 'Số điện thoại không hợp lệ'
				));
			}else{
				$check_phone_customer=$db->query('SELECT count(*) FROM '. $db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails_customer where phone='.$db->quote($array_data['phone']).' and userid != '.$user_info['userid'])->fetchColumn();
				if($check_phone_customer>0){
					nv_jsonOutput(array(
						'status' => 'error',
						'input' => 'phone',
						'mess' => 'Số điện thoại ' . $array_data['phone'] . ' đã có người sử dụng'
					));
				}else{
					$check_phone_customer_seller=$db->query('SELECT count(*) FROM '. $db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails_seller_management where phone='.$db->quote($array_data['phone']) .' and userid != '.$user_info['userid'])->fetchColumn();
					if($check_phone_customer_seller>0){
						nv_jsonOutput(array(
							'status' => 'error',
							'input' => 'phone',
							'mess' => 'Số điện thoại ' . $array_data['phone'] . ' đã có người sử dụng'
						));
					}
				}
			}
		}else{
			nv_jsonOutput(array(
					'status' => 'error',
					'input' => 'phone',
					'mess' => 'Vui lòng nhập số điện thoại'
			));
		}
		
		if(empty($array_data['birthday']))
		{
			nv_jsonOutput(array(
				'status' => 'error',
				'input' => 'birthday',
				'mess' => 'Ngày Sinh chưa nhập'
			));
		}
		
		$birthday = $nv_Request->get_title( 'birthday', 'post,get', '' );

		if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $birthday, $m ) )
		{
			$phour = $nv_Request->get_int( 'phour', 'post,get', 0 );
			$pmin = $nv_Request->get_int( 'pmin', 'post,get', 0 );
			$array_data['birthday'] = mktime( $phour, $pmin, 0, $m[2], $m[1], $m[3] );
		}
		
		
		
	 // Lưu thông tin và thông báo thành công
        $stmt = $db->prepare('UPDATE ' . NV_MOD_TABLE . ' SET
            last_name= :last_name,
            email= :email,
			phone=:phone,
            gender= :gender,
            birthday=' . intval($array_data['birthday']). ',
            last_update=' . NV_CURRENTTIME . '
        WHERE userid=' . $user_info['userid']);

        $stmt->bindParam(':last_name', $array_data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $array_data['email'], PDO::PARAM_STR);
		$stmt->bindParam(':phone', $array_data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $array_data['gender'], PDO::PARAM_STR);
        
        $stmt->execute();
		$db->query('UPDATE '.$db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails_customer SET phone='.$db->quote($array_data['phone']).',time_edit='.NV_CURRENTTIME.',user_edit='.$user_info['userid'].' where userid='.$user_info['userid']);
		
		
        nv_jsonOutput(array(
            'status' => 'ok',
            'input' => '',
            'mess' => $lang_module['editinfo_ok']
        ));

	
}


/**
 * nv_check_email_change()
 *
 * @param mixed $email
 * @return
 */
function nv_check_email_change(&$email, $edit_userid)
{
    global $db, $lang_module, $user_info, $global_users_config;

    $error = nv_check_valid_email($email, true);
    if ($error[0] != '') {
        return preg_replace('/\&(l|r)dquo\;/', '', strip_tags($error[0]));
    }
    $email = $error[1];

    if (!empty($global_users_config['deny_email']) and preg_match("/" . $global_users_config['deny_email'] . "/i", $email)) {
        return sprintf($lang_module['email_deny_name'], $email);
    }

    list($left, $right) = explode('@', $email);
    $left = preg_replace('/[\.]+/', '', $left);
    $pattern = str_split($left);
    $pattern = implode('.?', $pattern);
    $pattern = '^' . $pattern . '@' . $right . '$';

    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . ' WHERE userid!=' . $edit_userid . ' AND email RLIKE :pattern');
    $stmt->bindParam(':pattern', $pattern, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn()) {
        return sprintf($lang_module['email_registered_name'], $email);
    }

    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . '_reg WHERE email RLIKE :pattern');
    $stmt->bindParam(':pattern', $pattern, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn()) {
        return sprintf($lang_module['email_registered_name'], $email);
    }

    $stmt = $db->prepare('SELECT userid FROM ' . NV_MOD_TABLE . '_openid WHERE userid!=' . $edit_userid . ' AND email RLIKE :pattern');
    $stmt->bindParam(':pattern', $pattern, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn()) {
        return sprintf($lang_module['email_registered_name'], $email);
    }

    return '';
}

if($mod == 'change_password')
{

	// Password
    $nv_password = $nv_Request->get_title('password_old', 'post', '');
    $new_password = $nv_Request->get_title('password_new', 'post', '');
    $re_password = $nv_Request->get_title('re_password_new', 'post', '');
	
	$edit_userid = (defined('ACCESS_EDITUS')) ? $userid : $user_info['userid'];

	$sql = 'SELECT * FROM ' . NV_MOD_TABLE . ' WHERE userid=' . $edit_userid;
	$query = $db->query($sql);
	$row = $query->fetch();
	
   
    if (!empty($row['password']) and !$crypt->validate_password($nv_password, $row['password']) and !defined('ACCESS_PASSUS')) {
        nv_jsonOutput(array(
            'status' => 'error',
            'input' => 'password_old',
            'mess' => $lang_global['incorrect_password']
        ));
    }

    if (($check_new_password = nv_check_valid_pass($new_password, $global_config['nv_upassmax'], $global_config['nv_upassmin'])) != '') {
        nv_jsonOutput(array(
            'status' => 'error',
            'input' => 'password_new',
            'mess' => $check_new_password
        ));
    }

    if ($new_password != $re_password) {
        nv_jsonOutput(array(
            'status' => 'error',
            'input' => 're_password_new',
            'mess' => $lang_global['passwordsincorrect']
        ));
    }
	
	

    $re_password = $crypt->hash_password($new_password, $global_config['hashprefix']);

    $stmt = $db->prepare('UPDATE ' . NV_MOD_TABLE . ' SET password= :password, last_update=' . NV_CURRENTTIME . ' WHERE userid=' . $user_info['userid']);
    $stmt->bindParam(':password', $re_password, PDO::PARAM_STR);
    $stmt->execute();

    $name = $global_config['name_show'] ? array(
        $row['first_name'],
        $row['last_name']
    ) : array(
        $row['last_name'],
        $row['first_name']
    );
    $name = array_filter($name);
    $name = implode(' ', $name);
    $sitename = '<a href="' . NV_MY_DOMAIN . NV_BASE_SITEURL . '">' . $global_config['site_name'] . '</a>';
    $message = sprintf($lang_module['edit_mail_content'], $name, $sitename, $lang_global['password'], $new_password);
	
	
   // @nv_sendmail([$global_config['site_name'], $global_config['site_email']], $row['email'], $lang_module['edit_mail_subject'], $message);
	
	
    nv_jsonOutput(array(
        'status' => 'ok',
        'input' => nv_url_rewrite($base_url . '/password', true),
        'mess' => $lang_module['editinfo_ok']
    ));
	
}

$xtpl = new XTemplate('changepassword.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
  
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

// xuất thông tin link 
$xtpl->assign('personal', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=personal');
	
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
