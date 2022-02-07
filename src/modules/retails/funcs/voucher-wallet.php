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
	
	if (!defined('NV_IS_USER')) {
		echo '<script language="javascript">';
		echo 'alert("Vui lòng đăng nhập để thực hiện chức năng này");window.location = "'.NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login'.'"';
		echo '</script>';
	}
	
	
	$mod = $nv_Request->get_string('mod', 'post, get', 0);
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op.'&mod=tab_voucher';
	
	$status = $nv_Request->get_int( 'status', 'post,get', 0 );
	
	if( $mod == 'load_voucher' )
	{
		$xtpl = new XTemplate('voucher_wallet_ajax.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
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
		
		
		if($status == 0){
			$where .= $status;
			
			//print_r('SELECT t1.*,t2.voucherid as voucherid FROM ' . TABLE . '_voucher_ecng t1 INNER JOIN '. TABLE .'_voucher_wallet t2 ON t1.id = t2.voucherid WHERE t2.type_voucher = ' . $where . ' AND t2.userid = ' . $user_info[userid]);
			
			$list_voucher_ecng = $db->query('SELECT t1.*,t2.voucherid as voucherid FROM ' . TABLE . '_voucher_ecng t1 INNER JOIN '. TABLE .'_voucher_wallet t2 ON t1.id = t2.voucherid WHERE t2.type_voucher = ' . $where . ' AND t2.userid = ' . $user_info[userid])->fetchAll();
			
			
			if(!empty($list_voucher_ecng))
			{
				foreach( $list_voucher_ecng as $voucher ) {
					if($voucher['list_product'] == 0){
						$xtpl->assign( 'VOUCHER_APPLY', 'Voucher áp dụng cho tất cả sản phẩm của Shop');
					}
					else{
						$xtpl->assign( 'VOUCHER_APPLY', 'Voucher áp dụng cho một số sản phẩm');
					}
					if($voucher['type_discount']){
						$voucher['discount_price'] = $voucher['discount_price'] . '%';
						
					}
					else
					{
						$voucher['discount_price'] = number_format( $voucher['discount_price'] ).'đ'; 
					}
					$voucher['avt_store'] = $db->query('SELECT avatar_image FROM ' . TABLE . '_seller_management WHERE id = ' . $voucher['store_id'])->fetchColumn();
					
					if(!$voucher['avt_store']){
						$voucher['avt_store'] = NV_BASE_SITEURL . NV_FILES_DIR . '/no_img.png';
					}
					
					
					
					$voucher['time_to'] = date("d-m-Y", $voucher['time_to']);	
					$xtpl->assign( 'VOUCHER', $voucher);
					
					$xtpl->parse( 'main.voucher.voucher_loop' );
				}
				$xtpl->parse( 'main.voucher.voucher_loop' );
				}else{
				$xtpl->parse( 'main.not_voucher' );
			}
			
		}
		else{
			$where .= $status;
			
			$list_voucher_shop = $db->query('SELECT t1.*,t2.voucherid as voucherid FROM ' . TABLE . '_voucher_shop t1 INNER JOIN '. TABLE .'_voucher_wallet t2 ON t1.id = t2.voucherid WHERE t2.type_voucher = ' . $where . ' AND userid = ' . $user_info[userid])->fetchAll();
			
			if(!empty($list_voucher_shop))
			{
				
				foreach( $list_voucher_shop as $voucher ) {
					if($voucher['list_product'] == 0){
						$xtpl->assign( 'VOUCHER_APPLY', 'Voucher áp dụng cho tất cả sản phẩm của Shop');
					}
					else{
						$xtpl->assign( 'VOUCHER_APPLY', 'Voucher áp dụng cho một số sản phẩm');
					}
					if($voucher['type_discount']){
						$voucher['discount_price'] = $voucher['discount_price'] . '%';
					}
					else
					{
						$voucher['discount_price'] = number_format( $voucher['discount_price'] ).'đ'; 
					}
					$voucher['avt_store'] = $db->query('SELECT avatar_image FROM ' . TABLE . '_seller_management WHERE id = ' . $voucher['store_id'])->fetchColumn();
					
					if(!$voucher['avt_store']){
						$voucher['avt_store'] = NV_BASE_SITEURL . NV_FILES_DIR . '/no_img.png';
					}
					
					$voucher['time_to'] = date("d-m-Y", $voucher['time_to']);
					
					
					
					//print_r($voucher['type_discount']);
					$xtpl->assign( 'VOUCHER', $voucher);
					
					
					//$voucher['maximum_discount'] = number_format($voucher['maximum_discount']).'đ';
					
					if($voucher['maximum_discount'])
					{	
						$voucher['maximum_discount'] = number_format($voucher['maximum_discount']).'đ';
						
						$xtpl->assign( 'maximum_discount', $voucher['maximum_discount']);
						$xtpl->parse( 'main.voucher.voucher_loop.maximum_discount');
					}
					$xtpl->parse( 'main.voucher.voucher_loop' );
				}
				$xtpl->parse( 'main.voucher' );
			}
			else{
				
				$xtpl->parse( 'main.not_voucher' );
			}
		}
		
		
		$xtpl->parse('main');
		$contents = $xtpl->text('main');
		print_r($contents);die;
	}
	
	$page_title = 'Ví Voucher';
	
	
	$xtpl = new XTemplate('voucher-wallet.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
	
    $xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';