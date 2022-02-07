<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 23 Dec 2020 08:30:40 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

// Change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;

    $query = 'SELECT status FROM ' . TABLE . '_transporters WHERE id=' . $id;
    $row = $db->query($query)->fetch();
    if (isset($row['status']))     {
        $status = ($row['status']) ? 0 : 1;
        $query = 'UPDATE ' . TABLE . '_transporters SET status=' . intval($status) . ' WHERE id=' . $id;
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
        $sql = 'SELECT id FROM ' . TABLE . '_transporters WHERE id!=' . $id . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch())
        {
            ++$weight;
            if ($weight == $new_vid) ++$weight;             $sql = 'UPDATE ' . TABLE . '_transporters SET weight=' . $weight . ' WHERE id=' . $row['id'];
            $db->query($sql);
        }
        $sql = 'UPDATE ' . TABLE . '_transporters SET weight=' . $new_vid . ' WHERE id=' . $id;
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
        $sql = 'SELECT weight FROM ' . TABLE . '_transporters WHERE id =' . $db->quote($id);
        $result = $db->query($sql);
        list($weight) = $result->fetch(3);
        
        $db->query('DELETE FROM ' . TABLE . '_transporters  WHERE id = ' . $db->quote($id));
        if ($weight > 0)         {
            $sql = 'SELECT id, weight FROM ' . TABLE . '_transporters WHERE weight >' . $weight;
            $result = $db->query($sql);
            while (list($id, $weight) = $result->fetch(3))
            {
                $weight--;
                $db->query('UPDATE ' . TABLE . '_transporters SET weight=' . $weight . ' WHERE id=' . intval($id));
            }
        }
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Transporters', 'ID: ' . $id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['name_transporters'] = $nv_Request->get_title('name_transporters', 'post', '');
    $row['symbol_transporters'] = $nv_Request->get_title('symbol_transporters', 'post', '');
	$row['description'] = $nv_Request->get_title('description', 'post', '');
	$row['max_weight'] = $nv_Request->get_title('max_weight', 'post', '');
	$row['max_length'] = $nv_Request->get_title('max_length', 'post', '');
	$row['max_width'] = $nv_Request->get_title('max_width', 'post', '');
	$row['max_height'] = $nv_Request->get_title('max_height', 'post', '');
    $row['image'] = $nv_Request->get_title('image', 'post', '');
    if (is_file(NV_DOCUMENT_ROOT . $row['image']))     {
        $row['image'] = substr($row['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/transporters/'));
    } else {
        $row['image'] = '';
    }
    $row['type'] = $nv_Request->get_int('type', 'post', 0);
    $row['money'] = $nv_Request->get_title('money', 'post', '');

    if (empty($row['name_transporters'])) {
        $error[] = $lang_module['error_required_name_transporters'];
    } elseif (empty($row['symbol_transporters'])) {
        $error[] = $lang_module['error_required_symbol_transporters'];
    } elseif (empty($row['image'])) {
        $error[] = $lang_module['error_required_image'];
    } elseif ($row['money']=='') {
        $error[] = $lang_module['error_required_money'];
    }

    if (empty($error)) {
        try {
            if (empty($row['id'])) {
             
                $stmt = $db->prepare('INSERT INTO ' . TABLE . '_transporters (name_transporters, symbol_transporters, image, type, money, time_edit, user_edit, status, weight,description,max_weight,max_length,max_width,max_height) VALUES (:name_transporters, :symbol_transporters, :image, :type, :money, :time_edit, :user_edit, :status, :weight,:description,:max_weight,:max_length,:max_width,:max_height)');

                $stmt->bindParam(':time_edit', $row['time_edit'], PDO::PARAM_INT);
                $stmt->bindParam(':user_edit', $row['user_edit'], PDO::PARAM_INT);
                $stmt->bindValue(':status', 1, PDO::PARAM_INT);

                $weight = $db->query('SELECT max(weight) FROM ' . TABLE . '_transporters')->fetchColumn();
                $weight = intval($weight) + 1;
                $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);


            } else {
                $stmt = $db->prepare('UPDATE ' . TABLE . '_transporters SET name_transporters = :name_transporters, symbol_transporters = :symbol_transporters, image = :image, type = :type, money = :money, user_edit='.$admin_info['userid'].',time_edit='.NV_CURRENTTIME.',description=:description ,max_weight=:max_weight,max_length=:max_length,max_width=:max_width,max_height=:max_height WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':name_transporters', $row['name_transporters'], PDO::PARAM_STR);
            $stmt->bindParam(':symbol_transporters', $row['symbol_transporters'], PDO::PARAM_STR);
            $stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $row['type'], PDO::PARAM_INT);
            $stmt->bindParam(':money', $row['money'], PDO::PARAM_STR);
			$stmt->bindParam(':description', $row['description'], PDO::PARAM_STR);
			$stmt->bindParam(':max_weight', $row['max_weight'], PDO::PARAM_STR);
			$stmt->bindParam(':max_length', $row['max_length'], PDO::PARAM_STR);
			$stmt->bindParam(':max_width', $row['max_width'], PDO::PARAM_STR);
			$stmt->bindParam(':max_height', $row['max_height'], PDO::PARAM_STR);
            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Transporters', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Transporters', 'ID: ' . $row['id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . TABLE . '_transporters WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['id'] = 0;
    $row['name_transporters'] = '';
    $row['symbol_transporters'] = '';
    $row['image'] = '';
    $row['type'] = 0;
    $row['money'] = '';
}
if (!empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/transporters/' . $row['image'])) {
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/transporters/' . $row['image'];
}


$where = '';
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$q = $nv_Request->get_title( 'q', 'post,get' );
$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );
$parrent_id = $nv_Request->get_int( 'parrent_id', 'post,get', 0 );

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

        $where .= ' AND time_edit >= '. $ngay_tu . ' AND time_edit <= '. $ngay_den;
        $base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
    } else if ( $ngay_tu > 0 )
 {
        $where .= ' AND time_edit >= '. $ngay_tu;
        $base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
    } else if ( $ngay_den > 0 )
 {
        $where .= ' AND time_edit <= '. $ngay_den;
        $base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
    }

}
if ( $status_ft>-1 ) {
    $where .= ' AND status ='.$status_ft;
    $base_url .= '&status_search=' . $status_ft;
}
if ( !empty( $q ) ) {
    $where .= ' AND (name_transporters LIKE "%" "'.$q. '" "%" OR symbol_transporters LIKE "%" "'.$q. '" "%")';
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
        ->from('' . TABLE . '_transporters')
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

$xtpl = new XTemplate('transporters.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
if ( $ngay_tu > 0 )
$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
if ( $ngay_den > 0 )
$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
$type = array();
$type[] = array( 'id'=>0, 'text'=>'+' );
$type[] = array( 'id'=>1, 'text'=>'-' );

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
        $xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
		if($view['type'] == 0){
			$view['money']='+ '.number_format($view['money']);
		}else{
			$view['money']='- '.number_format($view['money']);
		}
		$view['max_weight']=number_format($view['max_weight']);
		$view['max_length']=number_format($view['max_length']);
		$view['max_height']=number_format($view['max_height']);
		$view['max_width']=number_format($view['max_width']);
		if(empty($view['user_edit'])){
			$view['user_edit']='Chưa cập nhật';
			$view['time_edit']='Chưa cập nhật';
		}else{
			$view['user_edit']=get_info_user($view['user_edit'])['username'];
			$view['time_edit']=date('d/m/Y H:i',$view['time_edit']);
		}
		if (!empty($view['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/transporters/' . $view['image'])) {
			$view['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/transporters/' . $view['image'];
		}else{
			$view['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/No-image-news.png';
		}
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}
if($row['id']>0){
	
	foreach ( $type as $filt_type ) {
		$xtpl->assign('type', array(
					'key' => $filt_type['id'],
					'title' => $filt_type['text'],
					'selected' => ($filt_type['id'] == $row['type']) ? ' selected="selected"' : ''));
	  $xtpl->parse( 'main.edit.type' );
	}
	$xtpl->parse('main.edit');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['transporters'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
