<?php

/**
 * @Project WALLET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2018 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Friday, March 9, 2018 6:24:54 AM
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');
define( 'MODULE_WALLET', $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_' .  $module_data); 
define('NV_TABLE_USER',  $db_config['dbsystem']. '.'.$db_config['prefix']. '_users');
/**
 * get_display_money()
 *
 * @param mixed $amount
 * @param integer $digis
 * @param string $dec_point
 * @param string $thousan_step
 * @return
 */
function get_display_money($amount, $digis = 2, $dec_point = ',', $thousan_step = '.')
{
    $amount = number_format($amount, intval($digis), $dec_point, $thousan_step);
    $amount = rtrim($amount, '0');
    $amount = rtrim($amount, $dec_point);
    return $amount;
}

/**
 * get_db_money()
 *
 * @param mixed $amount
 * @param mixed $currency
 * @return
 */
function get_db_money($amount, $currency)
{
    if ($currency == 'VND') {
        return round($amount);
    } else {
        return round($amount, 2);
    }
}

/**
 * Cập nhật hết hạn các giao dịch
 * @return boolean
 */
function nvUpdateTransactionExpired()
{
    global $module_config, $module_name, $db, $module_data, $nv_Cache, $db_config;
    $exp_setting = $module_config[$module_name]['transaction_expiration_time'];
    if (empty($exp_setting)) {
        return true;
    }
    $since_timeout = NV_CURRENTTIME - ($exp_setting * 3600);

    // Cho hết hạn các đơn hàng đã quá hạn
    $db->query("UPDATE " . MODULE_WALLET . "_transaction SET is_expired=1 WHERE (transaction_status=0 OR transaction_status=1) AND created_time<=" . $since_timeout);

    // Tìm kiếm thời gian hết hạn tiếp theo
    $next_update_time = $db->query("SELECT MIN(created_time) FROM " . MODULE_WALLET . "_transaction WHERE (transaction_status=0 OR transaction_status=1) AND created_time>" . $since_timeout)->fetchColumn();
    if ($next_update_time > 0) {
        $next_update_time += ($exp_setting * 3600);
    }
    $db->query("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value=" . $db->quote($next_update_time) . " WHERE lang=" . $db->quote(NV_LANG_DATA) . " AND module=" . $db->quote($module_name) . " AND config_name='next_update_transaction_time'");

    $nv_Cache->delMod($module_name);
    $nv_Cache->delMod('settings');
}

$global_array_color_month = array(
    1 => '#DC143C',
    2 => '#8B4789',
    3 => '#4B0082',
    4 => '#27408B',
    5 => '#33A1C9',
    6 => '#2F4F4F',
    7 => '#008B45',
    8 => '#556B2F',
    9 => '#CD950C',
    10 => '#CD6600',
    11 => '#EE5C42',
    12 => '#EE0000',
);

// Tiền tệ hệ thống sử dụng
$sql = "SELECT * FROM " . MODULE_WALLET . "_money_sys";
$global_array_money_sys = $nv_Cache->db($sql, 'code', $module_name);

// Các cổng thanh toán đang kích hoạt
$sql = 'SELECT * FROM ' . MODULE_WALLET . '_payment WHERE active = 1 ORDER BY weight ASC';
$global_array_payments = $nv_Cache->db($sql, 'payment', $module_name);

$global_array_transaction_status = [
    0 => $lang_module['transaction_status0'],
    1 => $lang_module['transaction_status1'],
    2 => $lang_module['transaction_status2'],
    3 => $lang_module['transaction_status3'],
    4 => $lang_module['transaction_status4'],
    5 => $lang_module['transaction_status5'],
    6 => $lang_module['transaction_status6'],
    7 => $lang_module['transaction_status7']
];

$global_array_transaction_type = [
    '0' => $lang_module['status_sub0'],
    '1' => $lang_module['status_sub1'],
    '2' => $lang_module['status_sub2'],
    '4' => $lang_module['status_sub4']
];

if (!empty($module_config[$module_name]['next_update_transaction_time']) and $module_config[$module_name]['next_update_transaction_time'] <= NV_CURRENTTIME) {
    // Cập nhật lại trạng thái hết hạn các giao dịch
    nvUpdateTransactionExpired();
}


function ag_weekday($agtoday) {
	//print_r($a); die;
	date_default_timezone_set('Asia/Ho_Chi_Minh');
//print_r($a);die;
	$weekday = date('l', $agtoday);

	$weekday = strtolower($weekday);
	switch($weekday) {
		case 'monday':
		$weekday = 2;
		break;
		case 'tuesday':
		$weekday = 3;
		break;
		case 'wednesday':
		$weekday = 4;
		break;
		case 'thursday':
		$weekday = 5;
		
		break;
		case 'friday':
		$weekday = 6;

		break;
		case 'saturday':
		$weekday = 7;

		break;
		default:
		$weekday = 8;

		break;
	}

	return $weekday;
}

$agtoday=	ag_weekday(NV_CURRENTTIME);

function nv_get_week_from_time($time)
{
	$week = 1;
	$year = date('Y', $time);
	$real_week = array($week, $year);
	$time_per_week = 86400 * 7;
	$time_start_year = mktime(0, 0, 0, 1, 1, $year);
	$time_first_week = $time_start_year - (86400 * (date('N', $time_start_year) - 1));
	
	$addYear = true;
	$num_week_loop = nv_get_max_week_of_year($year) - 1;
	
	for ($i = 0; $i <= $num_week_loop; $i++) {
		$week_begin = $time_first_week + $i * $time_per_week;
		$week_next = $week_begin + $time_per_week;
		
		if ($week_begin <= $time and $week_next > $time) {
			$real_week[0] = $i + 1;
			$addYear = false;
			break;
		}
	}
	if ($addYear) {
		$real_week[1] = $real_week[1] + 1;
	}
	
	return $real_week;
}

/**
 * nv_get_max_week_of_year()
 * 
 * @param mixed $year
 * @return
 */
function nv_get_max_week_of_year($year)
{
	$time_per_week = 86400 * 7;
	$time_start_year = mktime(0, 0, 0, 1, 1, $year);
	$time_first_week = $time_start_year - (86400 * (date('N', $time_start_year) - 1));
	
	if (date('Y', $time_first_week + ($time_per_week * 53) - 1) == $year) {
		return 53;
	} else {
		return 52;
	}
}
function get_user_select2($q){
	global $db;
	$list=$db->query("SELECT * FROM " .NV_TABLE_USER . " where username like '%".str_replace(' ','%',$q)."%' OR username like '%".str_replace(' ','%',$q)."%'")->fetchAll();
	return $list;
}
function get_info_user($userid){
	global $db;
	$list=$db->query("SELECT * FROM " .NV_TABLE_USER . " where userid=".$userid)->fetch();
	return $list;
}


function get_full_user(){
	global $db;
	$list=$db->query("SELECT * FROM " .NV_TABLE_USER . " where active=1")->fetchAll();
	return $list; 
}

function get_full_bank(){
	global $db;
	$list=$db->query("SELECT * FROM " .MODULE_WALLET . "_bank where status=1")->fetchAll();
	return $list; 
}

function get_info_bank($bank_id){
	global $db;
	$list=$db->query("SELECT * FROM " .MODULE_WALLET . "_bank where bank_id=".$bank_id)->fetch();
	return $list;
}

function get_info_user_acountbank($userid){
	global $db;
	$list=$db->query("SELECT * FROM " .MODULE_WALLET . "_bank_acount where acount_userid=".$userid)->fetch();
	return $list;
}

function get_info_user_bank($userid){
	global $db;
	$list=$db->query("SELECT * FROM " .MODULE_WALLET . "_bank_acount where acount_userid=".$userid)->fetch();
	return $list;
}