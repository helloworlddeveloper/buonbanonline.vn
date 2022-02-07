<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 05 Mar 2021 04:02:08 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['phone'] = $nv_Request->get_title('phone', 'post', '');
	 $row['userid'] = $nv_Request->get_title('userid', 'post', '');
	$row['email'] = $nv_Request->get_title('email', 'post', '');
	$row['password'] = $nv_Request->get_title('password', 'post', '');
	$row['password2'] = $nv_Request->get_title('password2', 'post', '');
	$row['first_name'] = $nv_Request->get_title('first_name', 'post', '');
	$row['last_name'] = $nv_Request->get_title('last_name', 'post', '');
    if (empty($row['phone'])) {
        $error[] = $lang_module['error_required_phone'];
    }
	if($row['id']>0){
		if($row['phone']!=''){
			$check = preg_match('/^[0]{1}[0-9]{9}+$/',$row['phone']);
			if(empty($check)){
				$error[] = 'Số điện thoại không hợp lệ';
				
			}else{
				$check_phone_customer=$db->query('SELECT count(*) FROM '. $db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails_customer where phone='.$db->quote($row['phone']).' and userid!='.$row['userid'])->fetchColumn();
				if($check_phone_customer>0){
					$error[] = 'Số điện thoại đã tồn tại';
				}else{
					$check_phone_customer_seller=$db->query('SELECT count(*) FROM '. $db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails_seller_management where phone='.$db->quote($row['phone']))->fetchColumn();
					if($check_phone_customer_seller>0){
						$error[] = 'Số điện thoại đã tồn tại';
					}
				}
			}
		}else{
			$error[] = 'Vui lòng nhập số điện thoại';
		}
		if($row['password']!=''){
			if( $row['password2'] !=''){
				if ($row['password'] != $row['password2']) {
					$error[] = 'Nhập lại mật khẩu không trùng khớp';
				}
			}else{
				$error[] = 'Vui lòng nhập lại mật khẩu';
			}
		}
	}else{
		if($row['phone']!=''){
			$check = preg_match('/^[0-9]{4}-[0-9]{3}-[0-9]{3}$/',$row['phone']);
			if(empty($check)){
				$error[] = 'Số điện thoại không hợp lệ (Vui lòng nhập theo định dạng: xxxx-xxx-xxx)';
			}else{
				$check_phone_customer=$db->query('SELECT count(*) FROM '. $db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails_customer where phone='.$db->quote($row['phone']))->fetchColumn();
				if($check_phone_customer>0){
					$error[] = 'Số điện thoại đã tồn tại';
				}else{
					$check_phone_customer_seller=$db->query('SELECT count(*) FROM '. $db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails_seller_management where phone='.$db->quote($row['phone']))->fetchColumn();
					if($check_phone_customer_seller>0){
						$error[] = 'Số điện thoại đã tồn tại';
					}
				}
			}
		}else{
			$error[] = 'Vui lòng nhập số điện thoại';
		}
		if($row['password']!=''){
			if( $row['password2'] !=''){
				if ($row['password'] != $row['password2']) {
					$error[] = 'Nhập lại mật khẩu không trùng khớp';
				}
			}else{
				$error[] = 'Vui lòng nhập lại mật khẩu';
			}
		}else{
			$error[] = 'Vui lòng nhập mật khẩu';
		}
	}
    if (empty($error)) {
		$password = $crypt->hash_password($row['password'], $global_config['hashprefix']);
		
        try {
            if (empty($row['id'])) {
                $row['user_add'] = $admin_info['userid'];
                $row['time_add'] = NV_CURRENTTIME;
                $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_customer (phone, user_add, time_add,  status) VALUES (:phone, :user_add, :time_add, :status)');
                $stmt->bindParam(':user_add', $row['user_add'], PDO::PARAM_INT);
                $stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
                $stmt->bindValue(':status', 1, PDO::PARAM_INT);
            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_customer SET phone = :phone,time_edit='.NV_CURRENTTIME.', user_edit='.$admin_info['userid'].' WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':phone', $row['phone'], PDO::PARAM_STR);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Customer', ' ', $admin_info['userid']);
                } else {
					if($row['password']==''){
						$db->query('UPDATE '.NV_TABLE_USER.' SET email='.$db->quote($row['email']).',first_name='.$db->quote($row['first_name']).',last_name='.$db->quote($row['last_name']).' where userid='.$row['userid']);
					}else{
						$db->query('UPDATE '.NV_TABLE_USER.' SET email='.$db->quote($row['email']).',first_name='.$db->quote($row['first_name']).',last_name='.$db->quote($row['last_name']).',password='.$db->quote($password).' where userid='.$row['userid']);
					}
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Customer', 'ID: ' . $row['id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=customer');
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_customer WHERE id=' . $row['id'])->fetch();
	$row['email']=get_info_user($row['userid'])['email'];
	$row['first_name']=get_info_user($row['userid'])['first_name'];
	$row['last_name']=get_info_user($row['userid'])['last_name'];
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['id'] = 0;
    $row['phone'] = '';
}


$xtpl = new XTemplate('customer_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);


if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['customer_edit'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
