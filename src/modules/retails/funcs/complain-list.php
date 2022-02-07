<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Fri, 08 Oct 2021 07:57:15 GMT
	*/
	
	// xử lý cập nhật trạng thái khiếu nại complain_id_ajax
	if ($nv_Request->isset_request('complain_id_ajax', 'post')) {
		
		$complain_id = $nv_Request->get_int('complain_id_ajax', 'post');
		
		$error = array();
		
		if(!$complain_id)
		{
			$error['status'] = 'ERROR';
			print_r(json_encode($error));die;
		}
		
		// kiểm tra đơn hàng có phải của cửa hàng này không
		$weight = $db->query('SELECT t1.status FROM '. TABLE .'_complain t1, '. TABLE .'_order t2 WHERE t1.order_id = t2.id AND t2.userid ="'. $user_info['userid'] .'" AND t1.id ='. $complain_id)->fetchColumn();
		
		if(!$weight)
		{
			$error['status'] = 'ERROR';
			print_r(json_encode($error));die;
		}
		
		
		
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
	
	
	
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	
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
        ->from(TABLE . '_complain t1, ' . TABLE . '_order t2')
		->where('t1.order_id = t2.id AND t2.userid ="'. $user_info['userid'] .'" '. $where);
		
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
	
	$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	
	if(!$num_items)
	{
		$xtpl->parse('main.view.no_data');
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
			
			$view['link_view_order'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=vieworder&amp;id=' . $view['order_id'],true);
			
			// trạng thái khiếu nại tiếp theo
			$view['status_next'] = $view['status'] + 1;
			
			$xtpl->assign('complain_id', $view['id']);
			$xtpl->assign('title_status', $global_status_complain[$view['status_next']]['complain_status']);
			
			$status_end = end($global_status_complain);
			
			// Xác nhận gửi hàng về cho Shop - weight = 4
			if($view['status_next'] == 4)
			{
				$link_vandon = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=complain-vandon&amp;order_id=' . $view['order_id'];
				
				$xtpl->assign('link_vandon', $link_vandon);
				$xtpl->parse('main.view.loop.vandon');
			}
			else{
				if(isset($global_status_complain[$view['status_next']]) and $global_status_complain[$view['status_next']]['seller_or_customer'] == 2)
				{
					$xtpl->parse('main.view.loop.status_next');
				}
				elseif($status_end['weight'] != $view['status'])
				{
					$xtpl->parse('main.view.loop.await');
				}
			}
			
			$arr_pro = json_decode($view['product_id'],true);
			
			$title_product = '';
			
			foreach($arr_pro as $pro)
			{
				if(!$title_product)
				$title_product = get_info_product($pro['product_id'])['name_product'];
				else
				$title_product = $title_product . ', ' . get_info_product($pro['product_id'])['name_product'];
			}
			
			$view['product_id'] = $title_product;
			
			$view['status'] = $global_status_complain[$view['status']]['complain_status'];
			
			$view['link_edit'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=complain-view&amp;order_id=' . $view['order_id'];
			
			
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
	$array_mod_title[] = array(
	'catid' => 0,
	'title' => $page_title,
	'link' => NV_MY_DOMAIN .'/'.$op.'/'
	);
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
