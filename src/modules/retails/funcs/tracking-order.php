<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Thu, 18 Mar 2021 01:33:55 GMT
	*/
	if (!defined('NV_IS_MOD_RETAILSHOPS'))
	die('Stop!!!');
	
	// print_r($order_text);die;
	$mod = $nv_Request->get_string('mod', 'post, get', 0);
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op.'&mod=tab_voucher';
	
	$status = $nv_Request->get_int( 'status', 'post,get', 0 );
	
	// print_r($_SESSION['order_repayment_no_login']);die;
	
	$page_title = 'Tra cứu thông tin đơn hàng';
	
	$xtpl = new XTemplate('tracking-order.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    
	$q = $nv_Request->get_title( 'q', 'post,get' );

	if( $mod == 'tracking_order' )
	{

		print_r($q);die;

	}
    $xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';