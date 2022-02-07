<?php
	
	/**
		* @Project TMS HOLDINGS
		* @Author TMS Holdings <contact@tms.vn>
		* @Copyright (C) 2020 TMS Holdings. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Mon, 21 Dec 2020 09:08:19 GMT
	*/
	
	if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN'))
    die('Stop!!!');
	
	define('NV_IS_FILE_ADMIN', true);
	
	$allow_func = array('main','bank','seller_management','ajax','seller_management_add','category','category_add','block','config','group','block_add','unit','unit_weight','unit_currency','tabs','transporters','product','product_add','unit_length','product_import_warehouse','warehouse_import','warehouse_import_view','location_ghn','location_viettelpost','block_list_product','listorder','view_order', 'brand','origin','images','order_print_noqr','order_print','static','categoryshop','customer','customer_add','registercontact','history_vnpay','history_vnpos','status_vnpos','history_vnpos_view','tool','product_disable','productadd_new','voucher','voucher_add','complain_list','complain','complain_status','penalize','auditing','order_punish','order_punish_list','order_punish_complain','status_ghn','vnpay_refund','auditing_detail', 'status_error_ghn', 'order_not_received', 'order_seller_delivery_failed', 'payport', 'actpay', 'changepay','defaultpay'); 
	
	require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';
	
	// phí bảo hiểm hàng hóa 1 vận đơn
	function baohiemhanghoa($order)
	{
		global $db;
		
		if(!$order['transporters_id'] or !$order['shipping_code'])
		return 0;
		
		if($order['shipping_code'] and ($order['transporters_id'] == 4 or $order['transporters_id'] == 5))
		{
			$cuocphi_thuctinh = $db->query('SELECT cuocphi_thuctinh FROM ' . TABLE .'_history_vnpos WHERE vnpost_status = 100 AND item_code ="'. $order['shipping_code'] .'"')->fetchColumn();
			
			$tongtien = $cuocphi_thuctinh - $order['fee_transport'];
		}
		
		// ghn
		if($order['shipping_code'] and $order['transporters_id'] == 3)
		{
			$total_fee = $db->query('SELECT total_fee FROM ' . TABLE .'_history_ghn WHERE status = "delivered" AND order_code ="'. $order['shipping_code'] .'"')->fetchColumn();
			
			$tongtien = $total_fee - $order['fee_transport'];
		}
		
		return $tongtien<0 ? 0 : $tongtien;
	}
	// phí bảo hiểm đơn vị vận chuyển
	function phi_baohiem($store_id, $status, $from, $to)
	{
		global $db;
		
		$where = '';
		
		if($from)
		$where .= ' AND time_edit >='. $from;
		
		if($to)
		$where .= ' AND time_edit <='. $to;
		
		if($status == 0){
			$where .= ' AND status = 7';
			} else if($status == 1){
			$where .= ' AND (status = 3 OR status = 2)';
			}else if($status == 2){
			$where .= ' AND (status = 6)';
		}
		
		$list_order = $db->query('SELECT transporters_id, fee_transport, shipping_code FROM ' . TABLE .'_order WHERE store_id = '. $store_id .' AND status_payment_vnpay = 1 ' . $where)->fetchAll();
		
		$tongtien = 0;
		
		
		
		foreach($list_order as $order)
		{
			// vnpost
			if($order['shipping_code'] and ($order['transporters_id'] == 4 or $order['transporters_id'] == 5))
			{
				$cuocphi_thuctinh = $db->query('SELECT cuocphi_thuctinh FROM ' . TABLE .'_history_vnpos WHERE vnpost_status = 100 AND item_code ="'. $order['shipping_code'] .'"')->fetchColumn();
				$temp = $cuocphi_thuctinh - $order['fee_transport'];
				if($temp > 0){
					$tongtien += $temp;
				}
			}
			
			// ghn
			if($order['shipping_code'] and $order['transporters_id'] == 3)
			{
				$total_fee = $db->query('SELECT total_fee FROM ' . TABLE .'_history_ghn WHERE status = "delivered" AND order_code ="'. $order['shipping_code'] .'"')->fetchColumn();
				
				$temp = $total_fee - $order['fee_transport'];
				if($temp > 0){
					$tongtien += $temp;
				}
			}
		}
		
		return $tongtien;
	}
	
	// phí ship các đơn của shop
	function phi_ship($store_id, $status, $from, $to){
		global $db;
		
		$where = '';
		
		if($from)
		$where .= ' AND time_edit >='. $from;
		
		if($to)
		$where .= ' AND time_edit <='. $to;
		
		if($status == 0){
			$where .= ' AND status = 7';
			} else if($status == 1){
			$where .= ' AND (status = 3 OR status = 2)';
			}else if($status == 2){
			$where .= ' AND (status = 6)';
		}
		
		$tongtien = $db->query('SELECT sum(fee_transport) as sum_ship FROM ' . TABLE .'_order WHERE store_id ='. $store_id . $where)->fetchColumn();
		return $tongtien;
	}
	
	// Tổng voucher các đơn của shop
	function voucher($store_id, $status, $from, $to){
		global $db;
		
		$where = '';
		
		if($from)
		$where .= ' AND time_edit >='. $from;
		
		if($to)
		$where .= ' AND time_edit <='. $to;
		
		if($status == 0){
			$where .= ' AND status = 7';
			} else if($status == 1){
			$where .= ' AND (status = 3 OR status = 2)';
			}else if($status == 2){
			$where .= ' AND (status = 6)';
		}
		
		$tongtien = $db->query('SELECT sum(voucher_price) as sum_voucher FROM ' . TABLE .'_order WHERE store_id ='. $store_id . $where)->fetchColumn();
		
		return $tongtien;
	}
	
	
	// phí vnpay 
	function phi_vnpay($store_id, $status, $from, $to)
	{
		global $db;
		
		$where = '';
		
		if($from)
		$where .= ' AND t1.time_edit >='. $from;
		
		if($to)
		$where .= ' AND t1.time_edit <='. $to;
		
		if($status == 0){
			$where .= ' AND t1.status = 7';
			} else if($status == 1){
			$where .= ' AND (t1.status = 3 OR t1.status = 2)';
			}else if($status == 2){
			$where .= ' AND (t1.status = 6)';
		}
		
		$list_vnpay = $db->query('SELECT t2.price, t2.vnp_bankcode FROM ' . TABLE .'_order t1, ' . TABLE .'_history_vnpay t2 WHERE t1.vnpay_code = t2.vnp_transactionno AND t2.vnp_responsedode ="00" AND t1.store_id = '. $store_id .' AND t1.status_payment_vnpay = 1 ' . $where)->fetchAll();
		
		
		$tongtien = 0;
		
		// VISA,MASTERCARD,JCB là quốc tế
		$array_quocte = array(
		'1' => 'VISA',
		'2' => 'MASTERCARD',
		'3' => 'JCB'
		);
		
		foreach($list_vnpay as $vnpay)
		{
			
			// thẻ nội địa 1.1% + 1.650đ
			
			if(in_array($vnpay['vnp_bankcode'],$array_quocte))
			{
				// thẻ quốc tế 2.4% + 2.200
				$cuocphi = (($vnpay['price'] * 2.4)/100) + 2200;
				
			}
			else
			{
				// thẻ nội địa
				$cuocphi = (($vnpay['price'] * 1.1)/100) + 1650;
			}
			
			
			$tongtien += $cuocphi;
		}
		
		return $tongtien;
	}
	
	// phi vnpay order
	function phi_vnpay_order($order, $status)
	{
		global $db;
		
		$where = '';
		if($status == 0){
			$where .= ' AND t1.status = 7';
			} else if($status == 1){
			$where .= ' AND (t1.status = 3 OR t1.status = 2)';
			}else if($status == 2){
			$where .= ' AND (t1.status = 6)';
		}
		$vnpay = $db->query('SELECT t2.price, t2.vnp_bankcode FROM ' . TABLE .'_order t1, ' . TABLE .'_history_vnpay t2 WHERE t1.id = '. $order['id'] .' AND t1.vnpay_code = t2.vnp_transactionno AND t2.vnp_responsedode ="00" AND t1.store_id = '. $order['store_id'] .' AND t1.status_payment_vnpay = 1 '. $where)->fetch();
		
		// VISA,MASTERCARD,JCB là quốc tế
		$array_quocte = array(
		'1' => 'VISA',
		'2' => 'MASTERCARD',
		'3' => 'JCB'
		);
		// thẻ nội địa 1.1% + 1.650đ
		
		$cuocphi = 0;
		if($vnpay['price']){
			if(in_array($vnpay['vnp_bankcode'],$array_quocte))
			{
				// thẻ quốc tế 2.4% + 2.200
				$cuocphi = (($vnpay['price'] * 2.4)/100) + 2200;
			}
			else
			{
				// thẻ nội địa
				$cuocphi = (($vnpay['price'] * 1.1)/100) + 1650;
			}
		}
		return $cuocphi;
	}
	
	
	// phí phi_phat
	function phi_phat($store_id, $status, $from, $to)
	{
		global $db;
		
		$where = '';
		
		if($from)
		$where .= ' AND t1.time_add >='. $from;
		
		if($to)
		$where .= ' AND t1.time_add <='. $to;
		
		if($status == 0){
			$where .= ' AND t2.status = 7';
			} else if($status == 1){
			$where .= ' AND (t2.status = 3 OR t2.status = 2)';
			}else if($status == 2){
			$where .= ' AND (t2.status = 6)';
		}
		
		$tongtien = $db->query('SELECT sum(price_penalize) FROM ' . TABLE .'_order_punish t1, ' . TABLE .'_order t2, ' . TABLE .'_penalize t3 WHERE t1.order_id = t2.id AND t1.penalize_id = t3.id AND t2.store_id = '. $store_id .' AND t2.status_payment_vnpay = 1' . $where)->fetchColumn();
		
		return $tongtien;
	}
	
	// phí phat cua order 
	function phi_phat_order($order, $status)
	{
		global $db;
		$where = '';
		if($status == 0){
			$where .= ' AND t2.status = 7';
			} else if($status == 1){
			$where .= ' AND (t2.status = 3 OR t2.status = 2)';
			}else if($status == 2){
			$where .= ' AND (t2.status = 6)';
		}
		$phiphat = $db->query('SELECT price_penalize FROM ' . TABLE .'_order_punish t1, ' . TABLE .'_order t2, ' . TABLE .'_penalize t3 WHERE t2.id = '. $order['id'] .' AND t1.order_id = t2.id AND t1.penalize_id = t3.id AND t2.store_id = '. $order['store_id'] .' AND t2.status_payment_vnpay = 1 '. $where)->fetchColumn();
		
		return $phiphat;
	}
	
	
	// thu phí sàn
	function phisan_ecng($store_id, $status, $from, $to)
	{
		global $db;
		
		$where = '';
		
		if($from)
		$where .= ' AND t1.time_edit >='. $from;
		
		if($to)
		$where .= ' AND t1.time_edit <='. $to;
		
		if($status == 0){
			$where .= ' AND t1.status = 7';
			} else if($status == 1){
			$where .= ' AND (t1.status = 3 OR t1.status = 2)';
			}else if($status == 2){
			$where .= ' AND (t1.status = 6)';
		}
		
		// giao hàng thành công, lấy tất cả sản phẩm
		$list_product = $db->query('SELECT t2.product_id, t2.total FROM ' . TABLE .'_order t1, '. TABLE .'_order_item t2 WHERE t1.store_id = '. $store_id .' AND t1.id = t2.order_id AND t1.status_payment_vnpay = 1 ' . $where)->fetchAll();
		
		$tongtien = 0;
		
		foreach($list_product as $product)
		{
			// lấy thông tin chuyên mục sản phẩm
			$catalogy_id = $db->query('SELECT categories_id FROM ' . TABLE .'_product WHERE id ='. $product['product_id'])->fetchColumn();
			
			// lấy phí sàn danh mục sản phẩm
			$phisan = phisan_danhmuc($catalogy_id);
			
			$chiec_khau = ($product['total'] * $phisan)/100;
			//print($chiec_khau . ' - ');
			
			$tongtien += $chiec_khau;
			
		}
		
		return $tongtien;
	}
	
	// phí sàn của đơn hàng
	function phi_ecng($order, $status)
	{
		global $db;
		// giao hàng thành công, lấy tất cả sản phẩm
		$where = '';
		if($status == 0){
			$where .= ' AND t1.status = 7';
			} else if($status == 1){
			$where .= ' AND (t1.status = 3 OR t1.status = 2)';
			}else if($status == 2){
			$where .= ' AND (t1.status = 6)';
		}
		$product = $db->query('SELECT t2.product_id, t2.total FROM ' . TABLE .'_order t1, '. TABLE .'_order_item t2 WHERE t1.id = ' . $order['id'] . ' AND t1.store_id = '. $order['store_id'] .' AND t1.id = t2.order_id AND t1.status_payment_vnpay = 1 '. $where)->fetch();
		// lấy thông tin chuyên mục sản phẩm
		if($product){
			$catalogy_id = $db->query('SELECT categories_id FROM ' . TABLE .'_product WHERE id ='. $product['product_id'])->fetchColumn();
			
			// lấy phí sàn danh mục sản phẩm
			$phisan = phisan_danhmuc($catalogy_id);
			$chiec_khau = ($product['total'] * $phisan)/100;
		}
		
		return $chiec_khau;
	}
	
	
	// phí sàn chuyên mục sản phẩm
	function phisan_danhmuc($catalogy_id)
	{
		global $db;
		
		if(!$catalogy_id)
		return 0;
		
		// lấy phí sàn danh mục
		
		$row = $db->query('SELECT percent_discount, parrent_id FROM ' . TABLE .'_categories WHERE id ='. $catalogy_id)->fetch();
		
		
		
		if($row['percent_discount'])
		{
			return $row['percent_discount'];
		}
		else
		{
			return phisan_danhmuc($row['parrent_id']);
		}
		
		
		
	}
	
	
	function nv_theme_retailshops_list_product_new( $sth, $per_page, $page, $num_items, $base_url, $ngay_tu, $ngay_den, $status_ft, $sea_flast, $show_view, $q, $catalogy, $store_id)
	{
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $client_info, $db, $global_config;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
		$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
		$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
		$xtpl->assign( 'NV_LANG_INTERFACE', NV_LANG_INTERFACE );
		$xtpl->assign( 'OP', $op );
		$xtpl->assign( 'Q', $q );
		$xtpl->assign( 'num_items', $num_items );
		$xtpl->assign( 'product_add', nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=productadd', true ) );
		
		$array_catalogy = get_categories_select2('', 0, 0);
		foreach($array_catalogy as $catalogy_item)
		{		
			if ( $catalogy_item['id'] == $catalogy ) {
				$catalogy_item['selected'] = 'selected';
			}
			$xtpl->assign( 'catalogy', $catalogy_item );				
			// lấy tất cả con 
			$list_sub = get_categories_select2('', 0, $catalogy_item['id']);
			foreach($list_sub as $sub)
			{
				if ( $sub['id'] == $catalogy ) {
					$sub['selected'] = 'selected';
				}
				$xtpl->assign( 'sub', $sub );
				$xtpl->parse( 'main.view.catalogy.sub' );
			}		
			$xtpl->parse( 'main.view.catalogy' );
		}
		
		if ( $ngay_tu > 0 )
		$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
		if ( $ngay_den > 0 )
		$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
		
		if ( $show_view ) {
			$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
			if ( !empty( $generate_page ) ) {
				$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
				$xtpl->parse( 'main.view.generate_page' );
			}
			$number = $page > 1 ? ( $per_page * ( $page - 1 ) ) + 1 : 1;
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
			while ( $view = $sth->fetch() ) {
				
				$view['stt'] = $number++;
				
				$view['time_add'] = date('d/m/Y - H:i',$view['time_add']);
				
				$xtpl->assign( 'VIEW', $view );
				
				$view['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $view['alias'].'-'.$view['id'], true );
				
				$view['categories_id'] = get_info_category( $view['categories_id'] )['name'];
				if (!empty($view['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $view['image'])) {
					$view['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'];
					}else{
					
					$view['image'] ='https://banhang.chonhagiau.com' .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'];
				}
				$xtpl->assign( 'CHECK', $view['inhome'] == 1 ? 'checked' : '' );
				$view['link_edit'] = nv_url_rewrite( NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=productadd_new&id=' . $view['id'], true );
				$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
				$xtpl->assign( 'VIEW', $view );
				
				
				// lấy số lượng tồn kho
				$view['warehouse'] = $db->query('SELECT sum(sl_tonkho) as sum FROM ' . TABLE .'_product_classify_value_product WHERE status = 1 AND product_id ='. $view['id'])->fetchColumn();
				$view['warehouse'] =  number_format($view['warehouse']);
				$xtpl->assign( 'warehouse', $view['warehouse']);
				
				// lấy thông tin thuộc tính sản phẩm			
				
				$list_classify = $db->query('SELECT * FROM ' . TABLE .'_product_classify WHERE status = 1 AND product_id ='. $view['id'])->fetchAll();
				
				if($list_classify)
				{
					
					$array_tam = array();
					$array_classify = array();
					$array_class_value = array();
					foreach($list_classify as $classify)
					{
						$array_classify[$classify['id']] = $classify;
						// lấy danh sách thuộc tính
						$list_classify_value = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value WHERE status = 1 AND classify_id ='. $classify['id'])->fetchAll();			
						
						
						foreach($list_classify_value as $value)
						{
							$array_tam[$value['id']] = $value;
							$array_class_value[] = $value['id'];
						}
						
						// lấy danh sách 
					}
					
					// lấy danh sách sản phẩm có giá thuộc tính
					$where = '';
					if(!empty($array_class_value))
					{
						$where = ' AND ( classify_id_value1 IN('. implode(',',$array_class_value ).') OR classify_id_value2 IN('. implode(',',$array_class_value ).'))';
					}
					
					$list_product_price = array();
					if(!empty($where))
					{
						$list_product_price = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value_product WHERE status = 1' . $where)->fetchAll();
					}
					
					if($list_product_price)
					{
						foreach($list_product_price as $product_classic)
						{
							$product_classic['price'] =  number_format($product_classic['price']);
							
							if(!$product_classic['price_special'])
							$product_classic['price_special'] = '';
							else
							$product_classic['price_special'] =  number_format($product_classic['price_special']);
							
							
							$product_classic['sl_tonkho'] =  number_format($product_classic['sl_tonkho']);
							
							$product_classic['name_classify'] = '';
							if(isset($array_tam[$product_classic['classify_id_value1']]) and isset($array_classify[$array_tam[$product_classic['classify_id_value1']]['classify_id']]['name_classify']))
							{
								$product_classic['name_classify'] = $array_classify[$array_tam[$product_classic['classify_id_value1']]['classify_id']]['name_classify'];
							}
							
							$product_classic['name'] = '';
							if(isset($array_tam[$product_classic['classify_id_value1']]) and isset($array_tam[$product_classic['classify_id_value1']]['name']))
							$product_classic['name'] = $array_tam[$product_classic['classify_id_value1']]['name'] ;
							
							$product_classic['ten_rutgon'] = $product_classic['name_classify'] . ' ' . $product_classic['name'];
							
							if($product_classic['classify_id_value2'])
							{
								$product_classic['name_classify2'] = $array_classify[$array_tam[$product_classic['classify_id_value2']]['classify_id']]['name_classify'];
								
								$product_classic['name2'] = $array_tam[$product_classic['classify_id_value2']]['name'] ;
								
								$product_classic['ten_rutgon'] = $product_classic['ten_rutgon'] . ' - ' .$product_classic['name_classify2'] . ' ' . $product_classic['name2'];
							}
							
							
							
							
							$xtpl->assign( 'classfic', $product_classic );
							$xtpl->parse( 'main.view.loop.classify.classify_loop' );
						}
						
						$xtpl->parse( 'main.view.loop.classify' );
					}
					
				}
				else
				{
					$xtpl->parse( 'main.view.loop.no_classify' );
				}
				
				$xtpl->parse( 'main.view.loop' );
			}
			$list_store=get_full_store();
			foreach($list_store as $value){
				$xtpl->assign('store_id', array(
				'key' => $value['id'],
				'title' => $value['company_name'].' (Người đại diện: '.$value['name'].')',
				'selected' => ($value['id'] == $store_id) ? ' selected="selected"' : ''));
				$xtpl->parse('main.view.store_id');
			}
			$xtpl->parse( 'main.view' );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
		
	}
	

/**
 * drawselect_number()
 *
 * @param string $select_name
 * @param integer $number_start
 * @param integer $number_end
 * @param integer $number_curent
 * @param string $func_onchange
 * @return
 */
function drawselect_number($select_name = "", $number_start = 0, $number_end = 1, $number_curent = 0, $func_onchange = "")
{
    $html = "<select class=\"form-control\" name=\"" . $select_name . "\" onchange=\"" . $func_onchange . "\">";
    for ($i = $number_start; $i < $number_end; $i++) {
        $select = ($i == $number_curent) ? "selected=\"selected\"" : "";
        $html .= "<option value=\"" . $i . "\"" . $select . ">" . $i . "</option>";
    }
    $html .= "</select>";
    return $html;
}
