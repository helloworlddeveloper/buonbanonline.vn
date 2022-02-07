<?php

/**
 * @Project TMS Holdings
 * @Author TMS Holdings <contact@tms.vn>
 * @Copyright (C) 2020 TMS Holdings. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 21 Dec 2020 09:48:26 GMT
 */

if (!defined('NV_IS_MOD_WALLET'))
    die('Stop!!!');
	
if (!defined('NV_IS_USER')) {
    $redirect = nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op, true);
    nv_redirect_location(NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_redirect_encrypt($redirect));
}

$bank_user = $db->query('SELECT *  FROM ' . MODULE_WALLET . '_bank_acount WHERE acount_userid=' . $user_info['userid'])->fetch();
if($bank_user['acount_userid'] ==0){
nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=bank');
}else{


$row = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
$sql = "SELECT * FROM " . MODULE_WALLET . "_money where userid=".$user_info['userid']."";
$sth = $db->prepare($sql);
$sth->execute();
$money_total_info = $sth->fetch();
if ($nv_Request->isset_request('submit', 'post')) {
$bank_id = $nv_Request->get_int('bank_id', 'post', '');
$sql = 'SELECT * FROM '.MODULE_WALLET.'_bank_acount t1 LEFT JOIN '.MODULE_WALLET.'_bank t2 ON t1.acount_bankid=t2.bank_id  where t1.id='.$bank_id.' AND  t1.acount_userid='.$user_info['userid'];
$sth = $db->prepare($sql);
$sth->execute();
$acount_bank_info = $sth->fetch();	

$row['money_out'] = $nv_Request->get_title('money_out', 'post', '');
$row['money_out'] = floatval(str_replace(',', '', $row['money_out']));
$row['money_unit'] = 'VND';
	$minimum_amount = !empty($module_config[$module_name]['minimum_amount'][$row['money_unit']]) ? explode(',', $module_config[$module_name]['minimum_amount'][$row['money_unit']]) : array();
    $minimum_amount = empty($minimum_amount) ? 0 : $minimum_amount[0];

	$error = "";
	if (empty($row['money_out'])) {
        $error[] = $lang_module['error_required_money_out'];
    }
	elseif ($money_total_info['money_total'] - $row['money_out'] < ($module_config[$module_name]['minimum'] + $module_config[$module_name]['withdrawal_fees'])) {
     $error = sprintf($lang_module['error_money_withdrawal2'], number_format($money_total_info['money_total']-$module_config[$module_name]['minimum']- $module_config[$module_name]['withdrawal_fees']).' '.$row['money_unit']); } 
	 
	elseif ($row['money_out'] <= 0 or ($minimum_amount > 0 and $row['money_out'] < $minimum_amount)) {
      if ($minimum_amount > 0) {$error = sprintf($lang_module['error_money_withdrawal1'], get_display_money($minimum_amount) . ' ' . $row['money_unit']); }
	  else {$error = $lang_module['error_money_withdrawal'];}
    }
	
	
    if (empty($error)) {
        try {
            if (empty($row['id'])) {
				$weight = $db->query('SELECT max(weight) FROM ' . MODULE_WALLET . '_withdrawal')->fetchColumn();
                $weight = intval($weight) + 1;
				
               $sql = 'INSERT INTO ' . MODULE_WALLET . '_withdrawal ( userid,acount_cccd,acount_name,acount_number,acount_bankid,acount_bankbranch,acount_date_range,acount_issued_by,weight) VALUES (:userid,:acount_cccd,:acount_name,:acount_number,:acount_bankid,:acount_bankbranch,:acount_date_range,:acount_issued_by,:weight)';
				
				$data_insert=array();
				$data_insert['userid'] = $user_info['userid'];
				$data_insert['acount_cccd'] = $acount_bank_info['acount_cccd'];
				$data_insert['acount_name'] = $acount_bank_info['acount_name'];
				$data_insert['acount_number'] = $acount_bank_info['acount_number'];
				$data_insert['acount_bankid'] = $acount_bank_info['name_bank'];
				$data_insert['acount_bankbranch'] = $acount_bank_info['acount_bankbranch'];
				$data_insert['acount_date_range'] = $acount_bank_info['acount_date_range'];
				$data_insert['acount_issued_by'] = $acount_bank_info['acount_issued_by'];
				$data_insert['weight'] = $weight;

				$id_withdrawal = $db->insert_id($sql, 'id', $data_insert);
            } 
			

            
            if ($id_withdrawal>0) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Withdrawal', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Withdrawal', 'ID: ' . $id_withdrawal, $admin_info['userid']);
                }
				
				$sql = "SELECT userid, username, first_name, last_name, email FROM " . NV_USERS_GLOBALTABLE . " WHERE userid=:userid";
				$sth = $db->prepare($sql);
				$sth->bindParam(':userid', $row['userid'], PDO::PARAM_STR);
				$sth->execute();
				$row['money_out2']=number_format($row['money_out']);
				$account_info = $sth->fetch();
				require_once NV_ROOTDIR . '/modules/wallet/wallet.class.php';
				$wallet = new nukeviet_wallet();
				$message = 'Yêu cầu rút tiền về tài khoản '.' '.$acount_bank_info['acount_number'].' '.$acount_bank_info['name_bank'].' ,Chi nhánh: '.$acount_bank_info['acount_bankbranch'];
				$checkUpdate = $wallet->update($row['money_out']+$module_config[$module_name]['withdrawal_fees'], 'VND', $user_info['userid'], $message);
				
				nv_insert_notification($module_name, 'ruttien',$message,$checkUpdate ,$user_info['userid'],$user_info['userid']); 
				
				$sql_update=$db->query('UPDATE '.MODULE_WALLET.'_transaction  SET status=2 ,transaction_status=1,customer_name="'.$acount_bank_info['acount_name'].'",customer_email="'.$user_info['email'].'",customer_phone="'.$user_info['phone'].'",money_net='.$row['money_out'].', money_fees='.$module_config[$module_name]['withdrawal_fees'].' where id='.$checkUpdate);
				$sql_withdrawal_update=$db->query('UPDATE '.MODULE_WALLET.'_withdrawal  SET transaction_id='.$checkUpdate.' where id='.$id_withdrawal);
				echo '<script language="javascript">';
				echo 'alert("message successfully sent");window.location = "'.NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=historyexchange'.'"';
				echo '</script>';
				

            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . MODULE_WALLET . '_withdrawal WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['id'] = 0;
    $row['userid'] = $user_info['userid'];
    $row['acount_name'] = 0;
    $row['acount_cccd'] = 0;
	$row['acount_number'] = 0;
    $row['acount_date_range'] = 0;
    $row['acount_issued_by'] = 0;
    $row['acount_bankid'] = 0;
    $row['acount_bankbranch'] = 0;
	$row['money_unit'] = 'VND';
	$row['money_out'] = number_format($money_total_info['money_total'] - $module_config[$module_name]['minimum'] - $module_config[$module_name]['withdrawal_fees']);
}
$xtpl = new XTemplate('withdrawal.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
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
$xtpl->assign('MONEY_UNIT',$row['money_unit']);
$xtpl->assign('ROW', $row);
$list_money = explode(',', $module_config[$module_name]['minimum_amount'][$row['money_unit']]);
$money_amount_min = number_format($list_money[0]);
$xtpl->assign('TOTALMONEY', number_format($money_total_info['money_total']).' VND');
$xtpl->assign('WITHDRAWAL', number_format($money_total_info['money_total'] - $module_config[$module_name]['minimum'] - $module_config[$module_name]['withdrawal_fees']).' VND');
$xtpl->assign('FEES', number_format( $module_config[$module_name]['withdrawal_fees']).' VND');
$xtpl->assign('MIN_MAX', sprintf($lang_module['money_withdrawal_minmax'],$money_amount_min.' VND', number_format($money_total_info['money_total'] - $module_config[$module_name]['minimum']- $module_config[$module_name]['withdrawal_fees']).' VND' )); 

$list_acountbank=$db->query('SELECT * FROM '.MODULE_WALLET.'_bank_acount t1 LEFT JOIN '.MODULE_WALLET.'_bank t2 ON t1.acount_bankid=t2.bank_id  where t1.acount_userid='.$user_info['userid'] )->fetchAll();
foreach($list_acountbank as $value){
		$xtpl->assign('ACBANK', array(
		'key' => $value['id'],
		'title' =>$value['acount_name'].' - '.$value['acount_number'].' - '.$value['name_bank'].' - '.$value['acount_bankbranch']));
		$xtpl->parse('main.acount_bank');
}
	

if (!empty($error)) {
    $xtpl->assign('ERROR',  $error);
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['withdrawal'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
}