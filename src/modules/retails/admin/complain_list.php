<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 08 Oct 2021 07:57:15 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');


// xử lý cập nhật trạng thái khiếu nại complain_id_ajax
if ($nv_Request->isset_request('complain_id_ajax', 'post')) {
	
	$complain_id = $nv_Request->get_int('complain_id_ajax', 'post');
	 
	$error = array();
	
	if(!$complain_id)
	{
		$error['status'] = 'ERROR';
		print_r(json_encode($error));die;
	}
	
	$weight = $db->query('SELECT status FROM '. TABLE .'_complain WHERE id ='. $complain_id)->fetchColumn();
	
	$weight_next = $weight + 1;
	
	if(isset($global_status_complain[$weight_next]))
	{
		// cập nhật trạng thái mới
		$time_edit = NV_CURRENTTIME;
		
		$db->query('UPDATE '. TABLE .'_complain SET status = "'. $weight_next .'", time_edit = "'. $time_edit .'" WHERE id ='. $complain_id);
		
		$error['status'] = 'OK';
		print_r(json_encode($error));die;
	}
	else
	{
		$error['status'] = 'ERROR';
		print_r(json_encode($error));die;
	}
	
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_complain  WHERE id = ' . $db->quote($id));
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Complain', 'ID: ' . $id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}



$row['reason'] = nv_htmlspecialchars(nv_br2nl($row['reason']));


$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
   
$search['q'] = $nv_Request->get_title('q', 'post,get');
$search['status_complain'] = $nv_Request->get_title('status_complain', 'post,get');


$where = '';

if($search['q'])
{
	$where .= ' AND t2.order_code like "%'. $search['q'] .'%"';
	 $base_url .= '&q=' . $search['q'];
}

if($search['status_complain'])
{
	$where .= ' AND t1.status=' . $search['status_complain'];
	 $base_url .= '&status_complain=' . $search['status_complain'];
}




// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_complain t1, ' . NV_PREFIXLANG . '_' . $module_data . '_order t2')
		->where('t1.order_id = t2.id '. $where);
	
	$sth = $db->prepare($db->sql());

    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('t1.*, t2.order_code, t2.id as order_id')
        ->order('time_edit DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

   
    $sth->execute();
}


$arr_ship = array('1' => 'Seller', '2' => 'Khách hàng');

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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

$xtpl->assign('search', $search);


// xuất danh sách trạng thái khiếu nại

foreach ($global_status_complain as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $title['weight'],
        'title' => $title['complain_status'],
        'selected' => ($key == $search['status_complain']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.view.status_complain');
}

if ($show_view) {
    
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
		
		$view['link_view_order'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view_order&amp;id=' . $view['order_id'];
		
		// trạng thái khiếu nại tiếp theo
		if(isset($global_status_complain[$view['status'] + 1]))
		{
			$view['status_next'] = $view['status'] + 1;
			$xtpl->assign('complain_id', $view['id']);
			$xtpl->assign('title_status', $global_status_complain[$view['status_next']]['complain_status']);
			$xtpl->parse('main.view.loop.status_next');
		}
		
		$view['ship'] = $arr_ship[$view['ship']];
		
        $view['order_id'] = $view['order_code'];
		
		$arr_pro = json_decode($view['product_id'],true);
		
		$title_product = '';
		
		foreach($arr_pro as $pro)
		{
			$view['name_group'] = '';
		
			if(isset($pro['classify_value_product_id']) and $pro['classify_value_product_id']){
					$classify_value_product_id=get_info_classify_value_product($pro['classify_value_product_id']);
					$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
					$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
					if($classify_value_product_id['classify_id_value2']>0){
						$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
						$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
						$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
						}else{
						$name_group=$name_classify_id_value1;
					}	
					$view['name_group']= '( '.$name_group.' )';
			}
		
		
			if(!$title_product)
				$title_product = get_info_product($pro['product_id'])['name_product'] . $view['name_group'];
			else
			$title_product = $title_product . ', ' . get_info_product($pro['product_id'])['name_product'] . $view['name_group'];
		}
		
        $view['product_id'] = $title_product;
		
        $view['status'] = $global_status_complain[$view['status']]['complain_status'];
		
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=complain&amp;id=' . $view['id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '='. $op .'&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
		
		// ngày tạo
		$view['time_edit'] = date('d/m/Y - H:i', $view['time_edit']);
		
		
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}


$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['complain'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
