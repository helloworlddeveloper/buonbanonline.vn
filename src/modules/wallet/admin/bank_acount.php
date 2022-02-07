<?php

/**
 * @Project TMS Holdings
 * @Author TMS Holdings <contact@tms.vn>
 * @Copyright (C) 2020 TMS Holdings. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 21 Dec 2020 09:48:26 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

// Change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;

    $query = 'SELECT status FROM ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount WHERE id=' . $id;
    $row = $db->query($query)->fetch();
    if (isset($row['status']))     {
        $status = ($row['status']) ? 0 : 1;
        $query = 'UPDATE ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount SET status=' . intval($status) . ' WHERE id=' . $id;
        $db->query($query);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
}

if ($nv_Request->isset_request('ajax_action', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $new_vid = $nv_Request->get_int('new_vid', 'post', 0);
    $content = 'NO_' . $id;
    if ($new_vid > 0)     {
        $sql = 'SELECT id FROM ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount WHERE id!=' . $id . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch())
        {
            ++$weight;
            if ($weight == $new_vid) ++$weight;             $sql = 'UPDATE ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount SET weight=' . $weight . ' WHERE id=' . $row['id'];
            $db->query($sql);
        }
        $sql = 'UPDATE ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount SET weight=' . $new_vid . ' WHERE id=' . $id;
        $db->query($sql);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $weight=0;
        $sql = 'SELECT weight FROM ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount WHERE id =' . $db->quote($id);
        $result = $db->query($sql);
        list($weight) = $result->fetch(3);
        
        $db->query('DELETE FROM ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount  WHERE id = ' . $db->quote($id));
        if ($weight > 0)         {
            $sql = 'SELECT id, weight FROM ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount WHERE weight >' . $weight;
            $result = $db->query($sql);
            while (list($id, $weight) = $result->fetch(3))
            {
                $weight--;
                $db->query('UPDATE ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount SET weight=' . $weight . ' WHERE id=' . intval($id));
            }
        }
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Bank', 'ID: ' . $id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['acount_userid'] = $nv_Request->get_int('acount_userid', 'post', '');
    $row['acount_name'] = $nv_Request->get_title('acount_name', 'post', '');
    $row['acount_cccd'] = $nv_Request->get_title('acount_cccd', 'post', '');
    $row['acount_date_range'] = $nv_Request->get_title('acount_date_range', 'post', '');
    $row['acount_issued_by'] = $nv_Request->get_title('acount_issued_by', 'post', '');
    $row['acount_number'] = $nv_Request->get_title('acount_number', 'post', '');
    $row['acount_bankid'] = $nv_Request->get_int('acount_bankid', 'post', '');
    $row['acount_bankbranch'] = $nv_Request->get_title('acount_bankbranch', 'post', '');

    if (empty($row['acount_userid'])) {
        $error[] = $lang_module['error_required_bank_code'];
    } elseif (empty($row['acount_name'])) {
        $error[] = $lang_module['error_required_name_bank'];
    }

    if (empty($error)) {
        try {
            if (empty($row['id'])) {
                $row['user_add'] = $admin_info['userid'];
                $row['time_add'] = NV_CURRENTTIME ;
              

                $stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount (acount_userid, acount_name,acount_cccd, acount_date_range,acount_issued_by,acount_number, acount_bankid, acount_bankbranch,user_add, time_add, status, weight) VALUES (:acount_userid, :acount_name,:acount_cccd,:acount_date_range, :acount_issued_by, :acount_number,:acount_bankid, :acount_bankbranch, :user_add, :time_add, :status, :weight)');

                $stmt->bindParam(':user_add', $row['user_add'], PDO::PARAM_INT);
                $stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
                $stmt->bindValue(':status', 1, PDO::PARAM_INT);

                $weight = $db->query('SELECT max(weight) FROM ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount')->fetchColumn();
                $weight = intval($weight) + 1;
                $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);


            } else {
                $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount SET  acount_name = :acount_name,acount_cccd = :acount_cccd,acount_date_range = :acount_date_range,acount_issued_by = :acount_issued_by,acount_number = :acount_number,acount_bankid = :acount_bankid,acount_bankbranch = :acount_bankbranch,user_edit='.$admin_info['userid'].',time_edit='.NV_CURRENTTIME.' WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':acount_userid', $row['acount_userid'], PDO::PARAM_STR);
            $stmt->bindParam(':acount_name', $row['acount_name'], PDO::PARAM_STR);
            $stmt->bindParam(':acount_cccd', $row['acount_cccd'], PDO::PARAM_STR);
            $stmt->bindParam(':acount_date_range', $row['acount_date_range'], PDO::PARAM_STR);
            $stmt->bindParam(':acount_issued_by', $row['acount_issued_by'], PDO::PARAM_STR);
            $stmt->bindParam(':acount_number', $row['acount_number'], PDO::PARAM_STR);
            $stmt->bindParam(':acount_bankid', $row['acount_bankid'], PDO::PARAM_STR);
            $stmt->bindParam(':acount_bankbranch', $row['acount_bankbranch'], PDO::PARAM_STR);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Bank', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Bank', 'ID: ' . $row['id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] .'_'. $module_data . '_bank_acount WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {

	
    $row['acount_userid'] = '';
    $row['acount_name'] = '';
    $row['acount_cccd'] = '';
    $row['acount_date_range'] = '';
    $row['acount_issued_by'] = '';
    $row['acount_number'] = '';
    $row['acount_bankid'] = '';
    $row['acount_bankbranch'] = '';
}

$where='';
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$q = $nv_Request->get_title( 'q', 'post,get' );
$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );

if ( preg_match( '/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/', $ngay_tu, $m ) )
 {
    $_hour = $nv_Request->get_int( 'add_date_hour', 'post', 0 );
    $_min = $nv_Request->get_int( 'add_date_min', 'post', 0 );
    $ngay_tu = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
} else {
    $ngay_tu = 0;
}

if ( preg_match( '/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/', $ngay_den, $m ) )
 {
    $_hour = $nv_Request->get_int( 'add_date_hour', 'post', 23 );
    $_min = $nv_Request->get_int( 'add_date_min', 'post', 59 );
    $ngay_den = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
} else {
    $ngay_den = 0;
}

if ( $sea_flast != 9 ) {
    if ( $ngay_tu > 0 and $ngay_den > 0 )
 {

        $where .= ' AND time_add >= '. $ngay_tu . ' AND time_add <= '. $ngay_den;
        $base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
    } else if ( $ngay_tu > 0 )
 {
        $where .= ' AND time_add >= '. $ngay_tu;
        $base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
    } else if ( $ngay_den > 0 )
 {
        $where .= ' AND time_add <= '. $ngay_den;
        $base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
    }

}
if ( $status_ft>-1 ) {
    $where .= ' AND status ='.$status_ft;
    $base_url .= '&status_search=' . $status_ft;
}
if ( !empty( $q ) ) {
    $where .= ' AND (name_bank LIKE "%" "'.$q. '" "%")';
    $base_url .= '&q=' . $q;
}

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . $db_config['prefix'] .'_'. $module_data . '_bank_acount')
		->where('1=1'.$where);

    $sth = $db->prepare($db->sql());

    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('weight ASC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    $sth->execute();
}

$xtpl = new XTemplate('bank_acount.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
$xtpl->assign('Q', $q);

$list_user=get_full_user();
foreach($list_user as $value){

	$xtpl->assign('USER', array(
       'key' => $value['userid'],
       'title' => $value['username'].' - '.$value['first_name'],
	   'selected' => ($value['userid'] == $row['acount_userid']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.acount_userid');
}

$list_bank=get_full_bank();
foreach($list_bank as $value){
	$xtpl->assign('BANK', array(
       'key' => $value['bank_id'],
       'title' => $value['bank_code'].' - '.$value['name_bank'],
	   'selected' => ($value['bank_id'] == $row['acount_bankid']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.acount_bankid');
}



if ( $ngay_tu > 0 )
$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
if ( $ngay_den > 0 )
$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
if ($show_view) {
   
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
	$real_week = nv_get_week_from_time( NV_CURRENTTIME );
    $week = $real_week[0];
    $year = $real_week[1];
    $this_year = $real_week[1];
    $time_per_week = 86400 * 7;
    $time_start_year = mktime( 0, 0, 0, 1, 1, $year );
    $time_first_week = $time_start_year - ( 86400 * ( date( 'N', $time_start_year ) - 1 ) );

    $tuannay = array(
        'from' => nv_date( 'd-m-Y', $time_first_week + ( $week - 1 ) * $time_per_week ),
        'to' => nv_date( 'd-m-Y', $time_first_week + ( $week - 1 ) * $time_per_week + $time_per_week - 1 ),
    );
    $tuantruoc = array(
        'from' => nv_date( 'd-m-Y', $time_first_week + ( $week - 2 ) * $time_per_week ),
        'to' => nv_date( 'd-m-Y', $time_first_week + ( $week - 2 ) * $time_per_week + $time_per_week - 2 ),
    );
    $tuankia = array(
        'from' => nv_date( 'd-m-Y', $time_first_week + ( $week - 3 ) * $time_per_week ),
        'to' => nv_date( 'd-m-Y', $time_first_week + ( $week - 3 ) * $time_per_week + $time_per_week - 3 ),
    );

    $thangnay = array(
        'from' => date( 'd-m-Y', strtotime( 'first day of this month' ) ),
        'to' => date( 'd-m-Y', strtotime( 'last day of this month' ) ),
    );
    $thangtruoc = array(
        'from' => date( 'd-m-Y', strtotime( 'first day of last month' ) ),
        'to' => date( 'd-m-Y', strtotime( 'last day of last month' ) ),
    );
    $namnay = array(
        'from' => date( 'd-m-Y', strtotime( 'first day of january this year' ) ),
        'to' => date( 'd-m-Y', strtotime( 'last day of december this year' ) ),
    );
    $namtruoc = array(
        'from' => date( 'd-m-Y', strtotime( 'first day of january last year' ) ),
        'to' => date( 'd-m-Y', strtotime( 'last day of december last year' ) ),
    );
    $xtpl->assign( 'TUANNAY', $tuannay );

    $xtpl->assign( 'TUANTRUOC', $tuantruoc );

    $xtpl->assign( 'TUANKIA', $tuankia );

    $xtpl->assign( 'HOMNAY', date( 'd-m-Y', NV_CURRENTTIME ) );
    $xtpl->assign( 'HOMQUA', date( 'd-m-Y', strtotime( 'yesterday' ) ) );
    $xtpl->assign( 'THANGNAY', $thangnay );

    $xtpl->assign( 'THANGTRUOC', $thangtruoc );

    $xtpl->assign( 'NAMNAY', $namnay );

    $xtpl->assign( 'NAMTRUOC', $namtruoc );

    if ( $sea_flast == '1' ) {
        $xtpl->assign( 'SELECT1', 'selected="selected"' );
    }
    if ( $sea_flast == '2' ) {
        $xtpl->assign( 'SELECT2', 'selected="selected"' );
    }
    if ( $sea_flast == '3' ) {
        $xtpl->assign( 'SELECT3', 'selected="selected"' );
    }
    if ( $sea_flast == '4' ) {
        $xtpl->assign( 'SELECT4', 'selected="selected"' );
    }
    if ( $sea_flast == '5' ) {
        $xtpl->assign( 'SELECT5', 'selected="selected"' );
    }
    if ( $sea_flast == '6' ) {
        $xtpl->assign( 'SELECT6', 'selected="selected"' );
    }
    if ( $sea_flast == '7' ) {
        $xtpl->assign( 'SELECT7', 'selected="selected"' );
    }
    if ( $sea_flast == '8' ) {
        $xtpl->assign( 'SELECT8', 'selected="selected"' );
    }
    if ( $sea_flast == '9' ) {
        $xtpl->assign( 'SELECT9', 'selected="selected"' );
    }
    $status_filt = array();
    $status_filt[] = array( 'id'=>-1, 'text'=>'Tất cả trạng thái' );
    $status_filt[] = array( 'id'=>0, 'text'=>'Ngưng Hoạt động' );
    $status_filt[] = array( 'id'=>1, 'text'=>'Hoạt động' );

    foreach ( $status_filt as $filt_stt ) {
        if ( $filt_stt['id'] == $status_ft ) {
            $filt_stt['selected'] = 'selected';
        }
        $xtpl->assign( 'status_filt', $filt_stt );
        $xtpl->parse( 'main.view.status_filt' );
    }
    while ($view = $sth->fetch()) {
        for($i = 1; $i <= $num_items; ++$i) {
            $xtpl->assign('WEIGHT', array(
                'key' => $i,
                'title' => $i,
                'selected' => ($i == $view['weight']) ? ' selected="selected"' : ''));
            $xtpl->parse('main.view.loop.weight_loop');
        }
		$view['acount_regdate']=date('d/m/Y H:i',get_info_user($view['acount_userid'])['regdate']);
		$view['acount_phone']=get_info_user($view['acount_userid'])['phone'];
		$view['acount_first_name']=get_info_user($view['acount_userid'])['first_name'];
		$view['acount_userid']=get_info_user($view['acount_userid'])['username'];
		$view['acount_bankid']=get_info_bank($view['acount_bankid'])['name_bank'];
		$view['user_add']=get_info_user($view['user_add'])['username'];
		$view['time_add']=date('d/m/Y H:i',$view['time_add']);
		if(empty($view['user_edit'])){
			$view['user_edit']='Chưa cập nhật';
			$view['time_edit']='Chưa cập nhật';
		}else{
			$view['user_edit']=get_info_user($view['user_edit'])['username'];
			$view['time_edit']=date('d/m/Y H:i',$view['time_edit']);
		}
        $xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}


if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['bank'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
