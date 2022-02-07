<?php

	sleep(2);
	$order_code = $nv_Request->get_title('order_code', 'get', '', 1);
	if($order_code == '' ){
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
	}else{
		$payment_method = GetPaymentMethodOrder($order_code);
		$xtpl = new XTemplate('payment_' . $payment_method . '_success.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
		$xtpl->assign('HISTORY', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ordercustomer',true));	
		$xtpl->assign('LOGO_SRC', NV_BASE_SITEURL . $global_config['site_logo']);
		$xtpl->assign('RE_PAYMENT', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=re-payment',true));
		
		$status = false;
		$inputData = array();
		$returnData = array();
		if($payment_method == 'vnpay'){
			$data = $_REQUEST;
		
			if(empty($data))
			{
				nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '='. $module_name, true);
			}
			
			foreach ($data as $key => $value)
			{
				if (substr($key, 0, 4) == "vnp_")
				{
					$inputData[$key] = $value;
				}
			}
		}
		$error = CheckPaymentOrder($payment_method,$order_code,$inputData);	

		if (!empty($error))
		{	
			
			$xtpl->assign('ERROR', implode('<br />', $error));
			$xtpl->parse('main.error');
			/*
			if(!empty($inputData['vnp_TxnRef']))
			{
				send_mail_payment_fail($inputData['vnp_TxnRef']);
			}*/
		}
			
		$data = GetPaymentStatus($payment_method,$order_code,$error,$inputData);

		if ($data['status'])
		{
			// thông tin đơn hàng
			// lấy thông tin order code
		/* 	if($payment_method == 'vnpay'){
				$order_code = $inputData['vnp_TxnRef'];
			}elseif($payment_method == 'recieve'){
				$order_code = $inputData['order_code'];
			} */	
			$array_order = array();
			if(!empty($order_code))
			{
				$list_orders = GetInfoOrderByID($order_code);
				$order_code_array = explode(",",$order_code);
				$info_order = $list_orders[$order_code_array[0]];
				//$list_order = $db->query('SELECT order_code FROM ' . TABLE .'_order WHERE id IN('. $order_code .')')->fetchAll();
				foreach($list_orders as $order)
				{
					$array_order[] = $order['order_code'];
				}
				$xtpl->assign('info_order', $info_order);
				
				
			}
			if($payment_method == 'vnpay'){
				$inputData['vnp_txnref'] = implode(' - ',$array_order);
				
				$nam = substr( $inputData['vnp_PayDate'],  0, 4);
				$thang = substr( $inputData['vnp_PayDate'],  4, 2);
				$ngay = substr( $inputData['vnp_PayDate'],  6, 2);
				$gio = substr( $inputData['vnp_PayDate'],  8, 2);
				$phut = substr( $inputData['vnp_PayDate'],  10, 2);
				
				$inputData['date_create'] = $ngay . '/' . $thang . '/' . $nam . ' - ' . $gio . ':' . $phut;
				
				$inputData['format_vnp_Amount'] = number_format($inputData['vnp_Amount']/100,0,",",",");
				$xtpl->assign('thanhtoan', $inputData);
			}elseif($payment_method == 'recieve'){
				$inputData['vnp_txnref'] = implode(' - ',$array_order);
				
				$inputData['date_create'] = date("d/m/Y H:i",$info_order['time_add']);//$ngay . '/' . $thang . '/' . $nam . ' - ' . $gio . ':' . $phut;
				
				$inputData['format_Amount'] = number_format($data['sum_total_payment'],0,",",",");
				$xtpl->assign('thanhtoan', $inputData);
			}elseif($payment_method == 'momo'){
				require_once(NV_ROOTDIR.'modules/retails/payment/momo.complete.php');
				
			}
				
			
			$xtpl->parse('main.thanhcong');
		}

		$xtpl->parse('main');
		$contents = $xtpl->text('main');

		$page_title = $lang_module['payment_' . $payment_method . '_success'];

		include NV_ROOTDIR . '/includes/header.php';
		echo nv_site_theme($contents);
		include NV_ROOTDIR . '/includes/footer.php';
	}
	


