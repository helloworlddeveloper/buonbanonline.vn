<?php
	
	/**
		* @Project TMS HOLDINGS
		* @Author TMS Holdings <contact@tms.vn>
		* @Copyright ( C ) 2020 TMS Holdings. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Mon, 21 Dec 2020 09:08:19 GMT
	*/
	
	
	if ( !defined( 'NV_IS_MOD_RETAILSHOPS' ) )
	die( 'Stop!!!' );
	
	/**
		* email_new_order_payment()
		*
		* @param mixed $content
		* @param mixed $data_content
		* @param mixed $data_pro
		* @param mixed $data_table
		* @return
	*/ 
	
	function content_product_ajax($data)
	{
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config, $db, $module_data, $module_upload, $module_name ;
		
		$xtpl = new XTemplate("global.product_ajax_home.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
		$xtpl->assign('BLOCK_THEME', $global_config['module_theme']);
		
		foreach ($data as $key => $value_product) {
			
			$value_product['number_order']=number_format($value_product['number_order']);
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$value_product['price'] = $value_product['price'] ? $value_product['price'] : $value_product['price_special'];
			$value_product['price_format'] = number_format( $value_product['price'] ).'đ';
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			
			if($value_product['price_special'] and $value_product['price'] < $value_product['price_special'])
			{		
				$price_special = number_format( $value_product['price_special'] ).'đ';
				$xtpl->assign( 'price_special', $price_special);
				$xtpl->parse( 'main.product.price_special' );
			}
			if($value_product['free_ship'])
			{		
				$xtpl->parse( 'main.product.free_ship' );
			}
			
			
			$xtpl->parse( 'main.product' );
		}
		
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	
	//mail gửi khách thanh toán thất bại
	function email_payment_fail($data_order, $data_pro, $info_order)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config, $config_setting;
		
		$xtpl = new XTemplate("email_payment_fail.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		
		$info_order['time_add'] = date('d/m/Y - H:i', $info_order['time_add']);
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['voucher_price']=number_format($info_order['voucher_price']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);
		$xtpl->assign('children_fund', $config_setting['children_fund'] . '%');
		$i=0;
		
		if($info_order['voucherid'])
		{
			$xtpl->parse('main.data_product.voucher');
		}
		
		foreach ($data_pro as $data) {
		
			$info_product = get_info_product($data['product_id']);
			if($data['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($data['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = $info_product['name_product'].' ('.$name_group.')';
				}else{
				$product_name = $info_product['name_product'];
			}	
			
			$image = $info_product['image'];
			
			$xtpl->assign('image', 'https://banhang.chonhagiau.com/uploads/' . $module_file . '/' . $image);
			
			$xtpl->assign('name_group', $name_group);
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $data['quantity']);
			$xtpl->assign('product_price', number_format($data['price']));
			$xtpl->assign('product_total', number_format($data['price']*$data['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		
		
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	//mail gui khach don hang moi
	function email_new_order_payment($data_order, $data_pro,$info_order)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config, $db;
		
		$xtpl = new XTemplate("email_new_order_payment.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		$info_order['time_add'] = date('d/m/Y - H:i', $info_order['time_add']);
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['voucher_price']=number_format($info_order['voucher_price']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);
		$shop_name = $db->query('SELECT company_name FROM ' . TABLE . '_seller_management WHERE id = ' . $info_order['store_id'])->fetchColumn();
		
		$xtpl->assign('SHOP_NAME', $shop_name);
		
		$i=0;
		
		if($info_order['voucherid'])
		{
			$xtpl->parse('main.data_product.voucher');
		}
		
		foreach ($data_pro as $data) {
			$info_product = get_info_product($data['product_id']);
			if($data['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($data['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = $info_product['name_product'].' ('.$name_group.')';
				}else{
				$product_name = $info_product['name_product'];
			}	
			
			$image = $info_product['image'];
			
			$xtpl->assign('image', 'https://banhang.chonhagiau.com/uploads/' . $module_file . '/' . $image);
			
			$xtpl->assign('name_group', $name_group);
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $data['quantity']);
			$xtpl->assign('product_price', number_format($data['price']));
			$xtpl->assign('product_total', number_format($data['price']*$data['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		
		
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	// hủy đơn hàng gửi email về seller
	function email_order_cancel_seller($data_order, $data_pro, $info_order)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config, $db;
		
		$xtpl = new XTemplate("email_order_cancel_seller.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		$info_order['time_add'] = date('d/m/Y - H:i', $info_order['time_add']);
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['voucher_price']=number_format($info_order['voucher_price']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);
		$shop_name = $db->query('SELECT company_name FROM ' . TABLE . '_seller_management WHERE id = ' . $info_order['store_id'])->fetchColumn();
		$xtpl->assign('SHOP_NAME', $shop_name);
		
		$i=0;
		
		if($info_order['voucherid'])
		{
			$xtpl->parse('main.data_product.voucher');
			$xtpl->parse('main.data_product.voucher_title');
			
		}
		
		foreach ($data_pro as $data) {
		$info_product = get_info_product($data['product_id']);
			if($data['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($data['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = $info_product['name_product'].' ('.$name_group.')';
				}else{
				$product_name = $info_product['name_product'];
			}	
			
			$image = $info_product['image'];
			
			$xtpl->assign('image', 'https://banhang.chonhagiau.com/uploads/' . $module_file . '/' . $image);
			
			$xtpl->assign('name_group', $name_group);
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $data['quantity']);
			$xtpl->assign('product_price', number_format($data['price']));
			$xtpl->assign('product_total', number_format($data['price']*$data['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		
		
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	// gửi email về seller báp đơn hàng khách chưa nhận được hàng
	function email_order_not_received_seller($data_order, $data_pro, $info_order)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config, $db;
		
		$xtpl = new XTemplate("email_order_not_received_seller.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		$info_order['time_add'] = date('d/m/Y - H:i', $info_order['time_add']);
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['voucher_price']=number_format($info_order['voucher_price']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);
		$shop_name = $db->query('SELECT company_name FROM ' . TABLE . '_seller_management WHERE id = ' . $info_order['store_id'])->fetchColumn();
		$xtpl->assign('SHOP_NAME', $shop_name);
		
		$i=0;
		
		if($info_order['voucherid'])
		{
			$xtpl->parse('main.data_product.voucher');
			$xtpl->parse('main.data_product.voucher_title');
			
		}
		
		foreach ($data_pro as $data) {
		$info_product = get_info_product($data['product_id']);
			if($data['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($data['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = $info_product['name_product'].' ('.$name_group.')';
				}else{
				$product_name = $info_product['name_product'];
			}	
			
			$image = $info_product['image'];
			
			$xtpl->assign('image', 'https://banhang.chonhagiau.com/uploads/' . $module_file . '/' . $image);
			
			$xtpl->assign('name_group', $name_group);
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $data['quantity']);
			$xtpl->assign('product_price', number_format($data['price']));
			$xtpl->assign('product_total', number_format($data['price']*$data['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		
		
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	// gửi email về admin báp đơn hàng khách chưa nhận được hàng
	function email_order_not_received_admin($data_order, $data_pro, $info_order)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config, $db;
		
		$xtpl = new XTemplate("email_order_not_received_admin.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		$info_order['time_add'] = date('d/m/Y - H:i', $info_order['time_add']);
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['voucher_price']=number_format($info_order['voucher_price']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);
		
		$i=0;
		
		if($info_order['voucherid'])
		{
			$xtpl->parse('main.data_product.voucher');
			$xtpl->parse('main.data_product.voucher_title');
			
		}
		
		foreach ($data_pro as $data) {
		$info_product = get_info_product($data['product_id']);
			if($data['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($data['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = $info_product['name_product'].' ('.$name_group.')';
				}else{
				$product_name = $info_product['name_product'];
			}	
			
			$image = $info_product['image'];
			
			$xtpl->assign('image', 'https://banhang.chonhagiau.com/uploads/' . $module_file . '/' . $image);
			
			$xtpl->assign('name_group', $name_group);
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $data['quantity']);
			$xtpl->assign('product_price', number_format($data['price']));
			$xtpl->assign('product_total', number_format($data['price']*$data['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		
		
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	
	function email_new_order_payment_khach($data_order, $data_pro,$info_order)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config, $config_setting, $user_info;
		
		$xtpl = new XTemplate("email_new_order_payment_khach.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['voucher_price']=number_format($info_order['voucher_price']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);
		$xtpl->assign('children_fund', $config_setting['children_fund'] . '%');
		//xem thông tin đơn hàng
		if($user_info['userid']){
			$view_order = 'https://chonhagiau.com/vieworder/?id=' . $info_order['id'];
		}
		else{
			$view_order = 'https://chonhagiau.com/check-order/?id=' . $info_order['id'];
		}
		$xtpl->assign('VIEW_ORDER', $view_order);
		// lấy xã + huyện + tỉnh
		$address = get_full_address($info_order['ward_id'], $info_order['district_id'], $info_order['province_id']);
		
		$address_full = $info_order['address'] . $address;
		$xtpl->assign('DIACHI', $address_full);
		
		if($info_order['voucherid'])
		{
			$xtpl->parse('main.data_product.voucher');
		}
		
		
		$i=0;
		foreach ($data_pro as $data) {
			$info_product = get_info_product($data['product_id']);
			if($data['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($data['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = $info_product['name_product'].' ('.$name_group.')';
				}else{
				$product_name = $info_product['name_product'];
			}	
			
			$image = $info_product['image'];
			
			$xtpl->assign('image', 'https://banhang.chonhagiau.com/uploads/' . $module_file . '/' . $image);
			
			
			
			$xtpl->assign('name_group', $name_group);
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $data['quantity']);
			$xtpl->assign('product_price', number_format($data['price']));
			$xtpl->assign('product_total', number_format($data['price']*$data['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	
	
	// form hủy đơn hàng gửi cho khách hàng
	function email_order_cancel_khach($data_order, $data_pro, $info_order)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config;
		
		$xtpl = new XTemplate("email_order_cancel_khach.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['voucher_price']=number_format($info_order['voucher_price']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);

		
		if($info_order['voucherid'])
		{
			$xtpl->parse('main.data_product.voucher');
			$xtpl->parse('main.data_product.voucher_title');
		}
		
		$i=0;
		foreach ($data_pro as $data) {
		
			$info_product = get_info_product($data['product_id']);
			if($data['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($data['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = $info_product['name_product'].' ('.$name_group.')';
				}else{
				$product_name = $info_product['name_product'];
			}	
			
			$image = $info_product['image'];
			
			$xtpl->assign('image', 'https://banhang.chonhagiau.com/uploads/' . $module_file . '/' . $image);
			
			$xtpl->assign('name_group', $name_group);
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $data['quantity']);
			$xtpl->assign('product_price', number_format($data['price']));
			$xtpl->assign('product_total', number_format($data['price']*$data['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	
	function dathangchuathanhtoan($data_order, $data_pro,$info_order,$form)
	{ 
		global $module_info, $lang_module, $module_file, $pro_config, $global_config, $money_config;
		
		$xtpl = new XTemplate("dathangchuathanhtoan.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
		$xtpl->assign('LANG', $lang_module);
		$xtpl->assign('DATA', $data_order);
		$info_order['total_product']=number_format($info_order['total_product']);
		$info_order['fee_transport']=number_format($info_order['fee_transport']);
		$info_order['total']=number_format($info_order['total']);
		$xtpl->assign('info_order', $info_order);
		$i=0;
		foreach ($data_pro as $pdata) {
			if($pdata['classify_value_product_id']>0){
				$classify_value_product_id=get_info_classify_value_product($pdata['classify_value_product_id']);
				$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
				if($classify_value_product_id['classify_id_value2']>0){
					$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
					$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
					}else{
					$name_group=$name_classify_id_value1;
				}
				$product_name = get_info_product($pdata['product_id'])['name_product'].' ('.$name_group.')';
				}else{
				$product_name = get_info_product($pdata['product_id'])['name_product'];
			}		
			$xtpl->assign('product_name', $product_name);
			$xtpl->assign('product_number', $pdata['quantity']);
			$xtpl->assign('product_price', number_format($pdata['price']));
			$xtpl->assign('product_total', number_format($pdata['price']*$pdata['quantity']));
			$xtpl->assign('pro_no', $i + 1);
			$bg = ($i % 2 == 0) ? " style=\"background:#f3f3f3;\"" : "";
			$xtpl->assign('bg', $bg);
			$xtpl->parse('main.data_product.loop');
			++$i;
		}
		$xtpl->parse('main.data_product');
		$xtpl->parse('main');
		return $xtpl->text('main');
	}
	
	
	function nv_theme_retailshops_repayment($q){
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name,$db,$db_config,$module_data,$user_info ;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
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
		$xtpl->assign('Q', $q);
		
		
		$xtpl->parse('main');
		return $xtpl->text( 'main' );
	}

	function nv_theme_retailshops_list_order_customer($ngay_tu,$ngay_den,$status_ft,$sea_flast,$q){
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name,$db,$db_config,$module_data,$user_info ;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
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
		$xtpl->assign('Q', $q);
		
		
		$xtpl->parse('main');
		return $xtpl->text( 'main' );
	}
	
	function nv_theme_retailshops_list_order($ngay_tu,$ngay_den,$status_ft,$sea_flast,$q,$store_id,$warehouse_id){
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name,$db,$db_config,$module_data ;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
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
		$xtpl->assign('Q', $q);
		$xtpl->assign('warehouse_id', $warehouse_id);
		$xtpl->assign('store_id', $store_id);
		$list_warehouse=get_list_warehouse($store_id);
		foreach($list_warehouse as $value){
			$xtpl->assign( 'store_id_list', array(
			'key' => $value['id'],
			'title' => $value['name_warehouse'],
			'selected' => ( $value['id'] == $warehouse_id ) ? ' selected="selected"' : '' ) );
			$xtpl->parse( 'main.warehouse_id' );
		}
		if ( $ngay_tu > 0 ){
			$xtpl->assign( 'ngay_tu', date( 'd-m-Y', strtotime($ngay_tu) ) );
			}else{
			$ngay_tu=date('01-m-Y');
			$xtpl->assign( 'ngay_tu', date( '01-m-Y') );
		}
		if ( $ngay_den > 0 ){
			$xtpl->assign( 'ngay_den', date( 'd-m-Y', strtotime($ngay_den) ) );
			}else{
			$ngay_den=date('d-m-Y',NV_CURRENTTIME);
			$xtpl->assign( 'ngay_den', date( 'd-m-Y', NV_CURRENTTIME ) );
		}
		if(!empty($_SESSION[$module_data.'_status_view_order'])){
			$xtpl->assign('status_view_order', $_SESSION[$module_data.'_status_view_order']);
			}else{
			$xtpl->assign('status_view_order', 0);
		}
		if($warehouse_id>0){
			$xtpl->assign('warehouse_name', get_info_warehouse($warehouse_id)['name_warehouse']);
			}else{
			$xtpl->assign('warehouse_name', 'Chọn tất cả');
		}
		$xtpl->assign('store_id', $store_id);
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
		$list_status=get_full_order_status();
		foreach($list_status as $key=>$value){
			if(empty($_SESSION[$module_data.'_status_view_order'])){
				if($key==0){
					$xtpl->assign('active', 'active');
					}else{
					$xtpl->assign('active', '');
				}
				}else{
				if($key==$_SESSION[$module_data.'_status_view_order']){
					$xtpl->assign('active', 'active');
					}else{
					$xtpl->assign('active', '');
				}
			}
			$value['count_order'] = get_count_order( $value['status_id'], $store_id, $warehouse_id ,$ngay_tu,$ngay_den);
			$xtpl->assign('LOOP', $value);
			$xtpl->parse('main.status');
		}
		$list_store=get_full_store();
		foreach($list_store as $value2){
			$xtpl->assign('store_id_list', array(
			'key' => $value2['id'],
			'title' => $value2['company_name'].' (Người đại diện: '.$value2['name'].')',
			'selected' => ($value2['id'] == $store_id) ? ' selected="selected"' : ''));
			$xtpl->parse('main.store_id');
		}
		
		$xtpl->parse('main');
		return $xtpl->text( 'main' );
	}
	function nv_theme_retailshops_order($array_data, $list_address , $address_df,$array_payment){
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name,$db,$db_config, $user_info, $global_location, $config_setting;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
		$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
		$xtpl->assign( 'TEMPLATE', $module_info['template']);
		if($user_info['userid']){
			$xtpl->assign( 'EMAIL_USER', $user_info['email']);
		}
		else{
			$xtpl->assign( 'EMAIL_USER', $_SESSION['address_no_login']['email']);
		}
		$xtpl->assign('children_fund', $config_setting['children_fund'] . '%');

		$xtpl->assign( 'ADDRESS_DF', $address_df );
		$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
		$xtpl->assign( 'LINK_ADDRESS', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=address&id=0');
		$xtpl->assign( 'CART', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cart');

		$xtpl->assign( 'OP', $op );
		$total = 0;

		unset($_SESSION['voucher_shop']);
		if(!$user_info['userid']){
		
			$xtpl->assign('show_address', 'd-none');
			$address = get_full_address($_SESSION['address_no_login']['ward_id'],$_SESSION['address_no_login']['district_id'],$_SESSION['address_no_login']['province_id']);
			$full_address = $_SESSION['address_no_login']['address'] . $address;
			$xtpl->assign( 'FULL_ADDRESS', $full_address);
			$xtpl->assign( 'FULL_NAME', $_SESSION['address_no_login']['name']);
			$xtpl->assign( 'FULL_PHONE', $_SESSION['address_no_login']['phone']);
			$xtpl->assign( 'FULL_EMAIL', $_SESSION['address_no_login']['email']);

			$xtpl->parse('main.address_no_login');
		}
		if($list_address){
			foreach ($list_address as $key => $value) {
				
				$value['checked'] = '';
				if($value['status'])
				{
					$value['checked'] = 'checked=checked';
				}
				
				if($value['ward_id']){
					$value['ward_id'] = get_info_ward($value['ward_id'])['title'];
				}
				if($value['district_id']){
					$value['district_id'] = get_info_district($value['district_id'])['title'];
				}
				if($value['province_id']){
					$value['province_id'] = get_info_province($value['province_id'])['title'];
				}
				if($value['status'] == 1){
					$xtpl->parse('main.address_list.default');
					$xtpl->assign( 'ADDRESS', $value );
					if(count($list_address)>1){
						
						$xtpl->parse( 'main.address_list.change_address' );
					}
					$xtpl->assign('diachi', $value['address'] . ' , ' . $value['ward_id'] . ' , '. $value['district_id'] . ' , '.$value['province_id'] );
					$xtpl->parse( 'main.address_list' );
					
				}
				$xtpl->assign('diachi', $value['address'] . ' , ' . $value['ward_id'] . ' , '. $value['district_id'] . ' , '.$value['province_id'] );
				
				$xtpl->assign( 'ADDRESS', $value );
				$xtpl->parse( 'main.address_list1' );
				
				
			}
			$xtpl->assign( 'address_other', 'hidden' );
		}
		
		$_SESSION['voucher_shop'] = array();
		
		foreach($array_data as $key_store => $store){
			$voucher_all = array();
			$list_tranposter = get_full_transporters( $key_store );
			$count_store = 0;
			$total_price_shop = 0;
			$info_store = get_info_store($key_store);
			$xtpl->assign( 'info_store', $info_store );
			$alias_store = $db->query('SELECT username FROM ' . NV_TABLE_USER . ' WHERE userid = ' . $info_store['userid'])->fetchColumn();
			$xtpl->assign('ALIAS_STORE', nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias_store  , true ));
			$checked = 0; 
			$xtpl->assign('key_store', $key_store);
			
			$xtpl->assign('store_userid', $info_store['userid']);
			
			foreach ($store as $key_warehouse => $warehouse) {
			
				$array_voucher_shop = array();
				$total_weight = 0;
				$total_length = 0;
				$total_width = 0;
				$total_height = 0;
				$total_warehouse = 0;
				$info_warehouse = $db->query("SELECT * FROM " . $db_config['dbsystem'] . '.' . NV_PREFIXLANG . '_' . $module_name . "_warehouse where id= " . $key_warehouse)->fetch();
				$xtpl->assign('info_warehouse', $info_warehouse);
				$xtpl->assign('key_warehouse', $key_warehouse);
				$count_product_warehouse = 0;
				
				// cờ tự giao
				$tu_giao = false;
				$where = '';
				$number_product = 0;
				$total_price_one_shop = 0;
				// lay tong tien hang cua hang
				
				$total_price_shop = total_price_shop($warehouse);
				$arr_product = array();
				foreach($warehouse as $key_product => $value){
					
					$self_transport_price = 0;
					$self_transport_price_max = 0;
					if($value['status_check']){
						//voucher
						if($user_info['userid']){
							// lay gia voucher san pham nếu 2 sp cùng 1 voucher thì distinct
						$array_voucher_shop = voucher_price_optimal($value['product_id'], $total_price_shop, $key_store, $array_voucher_shop);
						}
						
						//lấy giá giảm nhiều nhất
						$max_price_voucher = max(array_column($array_voucher_shop, 'price', 'voucherid'));
						//vocherid từ $max_price_voucher
						$voucherid_optimal = array_keys(array_combine(array_keys($array_voucher_shop), array_column($array_voucher_shop, 'price')), $max_price_voucher);
						
						$count_product_warehouse = 1;
						$xtpl->assign('key_store', $key_store);
						$xtpl->assign('key_product', $key_product);
						
						$list_product['alias'] = $value['alias'];
						$list_product['image'] = $value['image'];
						$list_product['self_transport'] = $value['self_transport'];
						$list_product['free_ship'] = $value['free_ship'];
						$list_product['name_product'] = $value['name_product'];
						
						//shop tự giao
						if($list_product['self_transport'])
						{
							//lấy danh các tỉnh shop tự giao
							$get_province_self_transport = $db->query('SELECT json_self_transport FROM ' . TABLE . '_product_detail WHERE product_id = ' . $value['product_id'])->fetchColumn();
							
							$arr = json_decode($get_province_self_transport,true);
							
							foreach($arr as $row)
							{
								if(in_array($address_df['province_id'], $row['province']) or in_array(0, $row['province']))
								{
									$tu_giao = true;
									$self_transport_price = $row['price_ship'];
								}
							}
						}
						
						$list_product['alias'] = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $list_product['alias'].'-'. $value['product_id'], true );
						
						if (!empty($list_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $list_product['image'] )) {
							$list_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $list_product['image'] ;
							}else{
							$server = 'banhang.'.$_SERVER["SERVER_NAME"];
							$list_product['image']  ='https://' . $server . NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $list_product['image'] ;
						}
						if($value['classify_value_product_id']>0){
							$classify_value_product_id=get_info_classify_value_product($value['classify_value_product_id']);
							$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
							$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
							if($classify_value_product_id['classify_id_value2']>0){
								$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
								$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
								$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
								}else{
								$name_group=$name_classify_id_value1;
							}
							$list_product['name_group'] = '('.$name_group.')';
						}
						
						
						$list_product['quantity'] = $value['num'];
						if($value['status_check']==1){
							$total = $total + $value['price'] * $value['num'];
							$total_warehouse = $total_warehouse + $value['price'] * $value['num'];
						}
						
						$list_product['price_format'] =  number_format($value['price']);
						$list_product['price'] =  $value['price'];
						//tỉnh thành có hỗ trợ free ship
						if($list_product['free_ship'])
						{	
							//lấy danh các tỉnh có hỗ trợ free ship
							$get_province_free_ship = $db->query('SELECT json_free_ship FROM ' . TABLE . '_product_detail WHERE product_id = ' . $value['product_id'])->fetchColumn();
							
							$arr_free_ship = json_decode($get_province_free_ship,true);
							//lấy id khu vực có tỉnh giao
							$get_id_area = $db->query('SELECT id_area FROM '. $db_config['prefix'] . '_location_area_province WHERE FIND_IN_SET('. $address_df['province_id'] .', districtid)')->fetchColumn();
							
							foreach($arr_free_ship as $row)
							{	
								if(($get_id_area == $row['area']) and (in_array($address_df['province_id'], $row['province']) or in_array(0, $row['province'])))
								{
									$list_product['free_ship'] = true;
									}else{
									$list_product['free_ship'] = false;
								}
							}
						}
						
						if(!$list_product['free_ship']){
							$total_weight = $total_weight + $value['weight_product'] * $value['num'];
						}
						
						if(!$list_product['free_ship']){
							$total_length_current = $value['length_product'];
							if($total_length_current > $total_length){
								$total_length = $total_length_current;
							}
						}
						
						if(!$list_product['free_ship']){
							$total_width_current = $value['width_product'];
							
							if($total_width_current > $total_width){
								$total_width = $total_width_current;
							}
						}
						
						if(!$list_product['free_ship']){
							$total_height = $total_height + $value['height_product'] * $value['num'];
						}
						
						$list_product['total_input'] =  $value['price'] * $value['num'];
						$list_product['total'] = number_format($value['price'] * $value['num']);
						
						$total_price_one_shop = $total_price_one_shop + $list_product['total_input'];
						$xtpl->assign('LOOP_INFO_PRODUCT', $list_product);
						$xtpl->parse('main.store.warehouse.loop');
						//lấy phí ship cao nhất
						if($self_transport_price > $self_transport_price_max){
							$self_transport_price_max = $self_transport_price;
							//lưu SESSION phí ship shop tự giao 
							$_SESSION['self_transport_price_shop'][$key_store] = $self_transport_price_max;
						}else{
							$_SESSION['self_transport_price_shop'][$key_store] = $self_transport_price;
						}
						
					}//product check
				}//product
				
				
				//lấy tổng giá của 1 cửa hàng
				$xtpl->assign('total_price_one_shop', $total_price_one_shop);
				
				if($max_price_voucher){
					$xtpl->assign('max_price_voucher','-'. number_format( $max_price_voucher ) . 'đ');
					$xtpl->assign('max_price_voucher_value', $max_price_voucher);
					//voucherid
					$xtpl->assign('voucherid_optimal', $voucherid_optimal[0]);
					$xtpl->assign('border', 'border');
				}
				else
				{
					$xtpl->assign('max_price_voucher','');
					$xtpl->assign('max_price_voucher_value', 0);
					//voucherid
					$xtpl->assign('voucherid_optimal', 0);
					$xtpl->assign('border', '');
				}
				
				if($array_voucher_shop)
				{
					
					//danh sach voucher shop
					//sắp xếp giá tối ưu giảm dần
					array_multisort(array_column($array_voucher_shop, 'price'), SORT_DESC, $array_voucher_shop);
					$number_voucher = 0;
					foreach($array_voucher_shop as $voucher){
						
						if(!$number_voucher){
							$voucher['status'] = 1;
							// lưu thông tin voucher vào session
							if($voucher['voucherid'])
							{
								$_SESSION['voucher_shop'][$key_store] = $voucher;
							}
							
							}else{
							$voucher['status'] = 0;	
						}
						if($voucher['list_product'] == 0){
							
							$voucher['list_product'] = 'Voucher áp dụng cho tất cả sản phẩm của Shop';
						}
						else{
							$voucher['list_product'] = 'Voucher áp dụng cho một số sản phẩm';
						}
						if($voucher['type_discount']){
							$voucher['discount_price'] = $voucher['discount_price'] . '%';
						}
						else
						{
							$voucher['discount_price'] = number_format( $voucher['discount_price'] ).'đ'; 
						}
						
						if($voucher['product_id'])
						{
							foreach($voucher['product_id'] as $product_id)
							{
								$xtpl->assign( 'product_id_voucher', $product_id);
								$xtpl->parse( 'main.store.warehouse.voucher_shop_js.product_id' );
							}
						}
						
						$voucher['time_to'] = date("d-m-Y", $voucher['time_to']);
						$xtpl->assign( 'VOUCHER', $voucher);
						
						$xtpl->parse( 'main.store.warehouse.voucher_shop_js' );
						$number_voucher++;
					}
					//voucher giá tối ưu 
				}
				else
				{
					$xtpl->parse( 'main.store.warehouse.voucher_shop_not' );
				}
				
				if($count_product_warehouse == 1){
					
					$xtpl->assign('total_weight', $total_weight);
					$xtpl->assign('total_width', $total_width);
					$xtpl->assign('total_length', $total_length);
					$xtpl->assign('total_height', $total_height);
					$xtpl->assign('total_warehouse', $total_warehouse);
					$xtpl->assign('total_weight_format', number_format($total_weight));
					$first_tranposter = 0;
					$count_store=1;
					$list_tranposter_new=[];
					
					foreach ( $list_tranposter as $key => $value ) {
						if($value['max_weight'] >= $total_weight && $value['max_length'] >= $total_length && $value['max_width'] >= $total_width && $value['max_height'] >= $total_height){
							$list_tranposter_new[] = $value;
						}
					}
					$transporter_first = true;
					if(count($list_tranposter_new)>0){
						foreach($list_tranposter_new as $key=>$value){
						
							$xtpl->assign( 'CARRIER', $value );
							
							if($transporter_first)
							{
								if($tu_giao){
									$value['id'] = 0;
								}
								$xtpl->assign( 'transporter_first', $value['id']);
								$xtpl->assign( 'self_transport_price_max_value', $self_transport_price_max);
								$xtpl->assign( 'self_transport_price_max', number_format($self_transport_price_max));
								
							}
							
							$transporter_first = false;
							
							if(!$tu_giao)
							{
								$xtpl->parse( 'main.store.warehouse.transporters_loop_js' );
							}
						}
						$xtpl->parse( 'main.store.warehouse.transporters' );
						
						}else{
						$xtpl->assign( 'CARRIER', $value );
						$xtpl->assign( 'carrie_id_first', 0 );
						$xtpl->parse( 'main.store.warehouse.notransporters_loop' );
					}
					$xtpl->parse( 'main.store.warehouse' );
					if(!$tu_giao)
					{
						$xtpl->parse( 'main.storejs.warehousejs' );
						
					}
					$xtpl->parse( 'main.storejsorder.warehousejs' );
				}
				
			}//KHO
			
			$voucher_all[$key_store] = $array_voucher_shop;
			if($count_store==1){
				// xử lý shop tự giao
				$xtpl->parse( 'main.store' );
				$xtpl->parse( 'main.storejs' );
				$xtpl->parse( 'main.storejsorder' );
			}
		}//SHOP
		foreach($array_payment as $payment){
			if($payment['is_default'] == 1){
				$xtpl->assign( 'checked', 'checked="checked"' );
			}else{
				$xtpl->assign( 'checked', '' );
			}
			$xtpl->assign( 'PAYMENT', $payment );
			$xtpl->parse( 'main.payment' );
		}
		$xtpl->assign( 'total', $total );
		$xtpl->assign( 'total_format', number_format($total));
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function nv_theme_retailshops_cart($array_data){
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name,$db,$db_config ;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
		$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
		$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
		$xtpl->assign( 'OP', $op );
		$xtpl->assign( 'LINK_ORDER', nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=order', true ) );
		$xtpl->assign( 'HOME', NV_BASE_SITEURL );
		
		if(empty($array_data))
		{
			$xtpl->parse( 'noproduct' );
			return $xtpl->text( 'noproduct' );
		}
		else{
			
			$count_cart=0;
			$total=0;
			$check_product_all=true;
			//print_r($array_data);die;
			foreach($array_data as $key_store => $store){
				$info_store=get_info_store($key_store);
				
				$xtpl->assign( 'info_store', $info_store );
				$alias_store = $db->query('SELECT username FROM ' . NV_TABLE_USER . ' WHERE userid = ' . $info_store['userid'])->fetchColumn();
				
				$xtpl->assign('ALIAS_STORE', nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias_store  , true ));
				$checked_store = true; 
				foreach ($store as $key_warehouse => $warehouse) {
					$xtpl->assign('key_warehouse', $key_warehouse);
					foreach($warehouse as $key_product => $value){
						
						if($value['status_check']==1){
							$xtpl->assign('status_check', 'checked');
							}else{
							$check_product_all=false;
							$checked_store=false;
							$xtpl->assign('status_check', '');
						}
						$xtpl->assign('key_store', $key_store);
						$xtpl->assign('key_product', $key_product);
						$xtpl->assign('key_warehouse', $key_warehouse);
						
						$list_product = $db->query("SELECT id, name_product, alias, image FROM " .$db_config['dbsystem']. '.'.NV_PREFIXLANG. '_' . $module_name . "_product where id=".$value['product_id'])->fetch();
						
						$list_product['alias'] = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $list_product['alias'].'-'.$value['product_id'], true );
						
						if (!empty($list_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $list_product['image'] )) {
							$list_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $list_product['image'] ;
							}else{
							$server = 'banhang.'.$_SERVER["SERVER_NAME"];
							$list_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $list_product['image'] ;
						}
						
						$list_product['name_group'] = '';
						
						$list_product['number_inventory_max']=get_info_invetory_group($value['product_id'],$value['classify_value_product_id'])['sl_tonkho'];
						
						if($value['classify_value_product_id']>0){
							
							$classify_value_product_id=get_info_classify_value_product($value['classify_value_product_id']);
							
							$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
							$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
							
							if($classify_value_product_id['classify_id_value2']>0){
								$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
								$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
								$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
								}else{
								$name_group=$name_classify_id_value1;
							}
							
							$list_product['name_group'] = '('.$name_group.')';
							//print_r($list_product['name_product']);die;
						}
						$list_product['quantity'] = $value['num'];
						if($value['status_check']==1){
							$total=$total+$value['price']*$value['num'];
						}
						
						$list_product['price_format'] =  number_format($value['price']);
						$list_product['price'] =  $value['price'];
						$list_product['total_input'] =  $value['price']*$value['num'];
						$list_product['total'] = number_format($value['price']*$value['num']);
						$xtpl->assign('LOOP_INFO_PRODUCT', $list_product);
						$xtpl->parse('main.store.warehouse.loop');
					}
					
					
					$xtpl->parse( 'main.store.warehouse' );
				}
				
				if($checked_store){
					$xtpl->assign('status_check_store', 'checked');
					}else{
					$xtpl->assign('status_check_store', '');
				}
				$xtpl->parse( 'main.store' );
				
			}
			if($check_product_all){
				$xtpl->assign('status_check_store_all', 'checked');
				}else{
				$xtpl->assign('status_check_store_all', '');
			}
			$xtpl->assign( 'total', number_format($total));
			$xtpl->parse( 'main' );
			return $xtpl->text( 'main' );
			
		}
	}
	
	
	
	function nv_theme_retailshops_list_product( $sth, $per_page, $page, $num_items, $base_url, $ngay_tu, $ngay_den, $status_ft, $sea_flast, $show_view, $q ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $client_info,$list_config_retails;
		
		$xtpl = new XTemplate( 'product.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
		$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
		$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
		$xtpl->assign( 'OP', $op );
		$xtpl->assign( 'Q', $q );
		$xtpl->assign( 'product_add', nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=productadd', true ) );
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
				
				$time_step = 60*$list_config_retails['time_push_product']*60;
				$view['stt'] = $number++;
				if($view['mode_push'] == 1){
					$view['remaining'] = $time_step - (NV_CURRENTTIME - $view['time_push']);
					$view['remaining'] = $view['remaining'] + NV_CURRENTTIME;
					
					$xtpl->assign( 'pushing_time', date('Y/m/d - H:i:s',$view['remaining']));
					$xtpl->parse( 'main.view.loop.pushing_time' );
				}
				$view['user_add'] = get_info_user( $view['user_add'] )['username'];
				$view['time_add'] = date( 'd/m/Y H:i', $view['time_add'] );
				if($view['mode_push'] == 1){
					
					$xtpl->parse( 'main.view.loop.pushing' );
					}else{
					$xtpl->parse( 'main.view.loop.no_pushing' );
				}
				
				if ( empty( $view['user_edit'] ) ) {
					$view['user_edit'] = 'Chưa cập nhật';
					$view['time_edit'] = 'Chưa cập nhật';
					} else {
					$view['user_edit'] = get_info_user( $view['user_edit'] )['username'];
					$view['time_edit'] = date( 'd/m/Y H:i', $view['time_edit'] );
				}
				$list_store = get_warehouse_store( $view['store_id'] );
				
				$view['amount_total'] = 0;
				foreach ( $list_store as $value ) {
					$list_product = get_info_invetory( $view['id'], $value['id'] );
					$check_no=0;
					if(empty($list_product)){
						$list_product=get_info_invetory_no($view['id'],$value['id']);
						$check_no=1;
					}
					if ( empty( $list_product ) ) {
						$xtpl->parse( 'main.view.loop.store.noproduct' );
						$xtpl->parse( 'main.view.loop.store2.noproduct' );
						} else {
						foreach ( $list_product as $value_product ) {
							if($value_product['classify_value_product_id']>0){
								$classify_value_product_id=get_info_classify_value_product($value_product['classify_value_product_id']);
								$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
								$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
								if($classify_value_product_id['classify_id_value2']>0){
									$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
									$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
									$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
									}else{
									$name_group=$name_classify_id_value1;
								}
								$value_product['name_product_rutgon']=nv_clean60($view['name_product'].' ('.$name_group.')',60);
								$value_product['name_group']=$name_group;
								}else{
								$value_product['name_product_rutgon']=nv_clean60($view['name_product'],60);
								$value_product['name_group']='';
							}
							if($check_no==0){
								if($value_product['status']==1){
									$value_product['status']='Hoạt động';
									}else{
									$value_product['status']='Đang ngưng bán';
								}
								}else{
								$value_product['status']='Hoạt động';
							}
							$view['amount_total'] = $view['amount_total']+$value_product['amount'];
							$value_product['amount'] = number_format( $value_product['amount'] );
							$value_product['amount_delivery'] = number_format( $value_product['amount_delivery'] );
							$value_product['name_product'] = $view['name_product'];
							$value_product['name_product_rutgon'] = nv_clean60( $view['name_product'].' ('.$name_group.')', 60 );
							
							$value_product['name_group'] = $name_group;
							$xtpl->assign( 'LOOP_PRODUCT', $value_product );
							$xtpl->parse( 'main.view.loop.store.product' );
							$xtpl->parse( 'main.view.loop.store2.product' );
						}
					}
					$xtpl->assign( 'LOOP_STORE', $value );
					$xtpl->parse( 'main.view.loop.store' );
					$xtpl->parse( 'main.view.loop.store2' );
				}
				$view['amount_total'] = number_format( $view['amount_total'] );
				
				$view['categories_id'] = get_info_category( $view['categories_id'] )['name'];
				if (!empty($view['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $view['image'] )) {
					$view['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
					}else{
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$view['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
				}
				$xtpl->assign( 'CHECK', $view['status'] == 1 ? 'checked' : '' );
				$view['link_import_warehouse'] = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=productimportwarehouse&amp;id=' . $view['id'], true );
				$view['link_edit'] = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=productadd&id=' . $view['id'], true );
				$view['link_delete'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
				$xtpl->assign( 'VIEW', $view );
				
				$xtpl->parse( 'main.view.loop' );
			}
			
			$xtpl->parse( 'main.view' );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
		
	}
	function nv_theme_retailshops_view_search( $array_data, $per_page, $page, $num_items, $base_url,$list_info_shop,$keyword_ajax,$sort1,$sort2,$sort3,$sort4,$num_product ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload,$db, $user_info;
		$xtpl = new XTemplate( 'main_search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'KEY_WORD', $keyword_ajax );
		
		$xtpl->assign( 'SORT1', $sort1 );
		$xtpl->assign( 'SORT2', $sort2 );
		$xtpl->assign( 'SORT3', $sort3 );
		$xtpl->assign( 'SORT4', $sort4 );
		$xtpl->assign( 'PAGE', $page );
		$xtpl->assign( 'PAGE1', ($page+1) );
		$xtpl->assign( 'PAGE2', ($page-1) );
		$number_page = round(($num_product/$per_page), 0, PHP_ROUND_HALF_UP);
		if(round(($num_product/$per_page), 0, PHP_ROUND_HALF_UP) == 0){
			$number_page = 1;
		}
		$xtpl->assign( 'NUM_PRODUCT', $number_page);
		$xtpl->assign( 'LINK_MORE_SHOP', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=viewlistshop');
		
		
		if($page==1){
			if($number_page==1){
				$xtpl->assign( 'DISABLE_PRE', 'disabled="true"' );
				$xtpl->assign( 'DISABLE_NEXT', 'disabled="true"' );
				}else{
				$xtpl->assign( 'DISABLE_PRE', 'disabled="true"' );
				$xtpl->assign( 'DISABLE_NEXT', '' );
			}
			
			}else if($page==$number_page){
			$xtpl->assign( 'DISABLE_NEXT', 'disabled="true"' );
			$xtpl->assign( 'DISABLE_PRE', '' );
			}else{
			$xtpl->assign( 'DISABLE_NEXT', '' );
			$xtpl->assign( 'DISABLE_PRE', '' );
		}
		
		
		
		//phantrangajax//
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		//phantrangajax//
		
		if($list_info_shop){
			
			foreach ($list_info_shop as $key => $value) {
				$value['follow'] = $db->query('SELECT count(*) FROM ' . TABLE . '_follow WHERE shop_id = ' . $value['id'])->fetchColumn();
				$value['time_add'] = date('d-m-Y', $info_shop['time_add']);
				$value['number_product'] = $db->query('SELECT count(*) FROM ' . TABLE . '_product WHERE store_id = ' .  $value['id'])->fetchColumn();
				$value['following'] = $db->query('SELECT count(*) FROM ' . TABLE . '_follow WHERE user_id = ' .  $value['userid'])->fetchColumn();
				
				if($value['avatar_image']){
					$value['image'] = $value['avatar_image'];
					}else{
					$value['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/no_img.png';
				}
				
				$value['alias'] = NV_MY_DOMAIN . '/' .  $module_name . '/' . $value['username'] . '/';
				$xtpl->assign( 'SHOP', $value );
				$xtpl->parse( 'main.shop.loop' );
			}
			$xtpl->parse( 'main.shop' );
		}
		if($keyword_ajax){
			$xtpl->parse( 'main.key_word_product' );
		}
		while( $value = $array_data -> fetch() ) {
			if (!empty($value['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value['image'] )) {
				$value['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
			}
			$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'-'.$value['id'].'/';
			
			if( $value['price_min'] == 0 &&  $value['price_max'] ==0){
				if ( $value['price'] == $value['price_special'] ) {
					
					$xtpl->assign( 'PRICE', number_format( $value['price'] ).'đ' );
					$xtpl->parse( 'main.loop.one_price' );
					} else {
					if($value['price_special']>0){
						$xtpl->assign( 'PRICE_MIN', number_format( $value['price_special'] ).'đ' );
						$xtpl->assign( 'PRICE_MAX', number_format( $value['price'] ).'đ' );
						$xtpl->parse( 'main.loop.special_no_type' );
						}else{
						$xtpl->assign( 'PRICE', number_format( $value['price'] ).'đ' );
						$xtpl->parse( 'main.loop.one_price' );
					}
				}
				}else{
				if ( $value['price_min'] == $value['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value['price_min'] ).'đ' );
					$xtpl->parse( 'main.loop.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value['price_max'] ).'đ' );
					$xtpl->parse( 'main.loop.min_max_price' );
				}
			}
			
			$value['check_wishlist'] = 2;
			if($user_info['userid']){
				$value['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value['id']) -> fetchColumn();
			}
			
			$value['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value['id']) -> fetchColumn();
			if($value['check_wishlist'] == 0){
				$value['color_wishlist'] = "white_wishlist";
				}else if($value['check_wishlist']==1){
				$value['color_wishlist'] = "red_wishlist";
				}else{
				$value['color_wishlist'] = "white_wishlist";
			}
			$value['number_view'] = number_format( $value['number_view'] );
			$value['number_order'] = number_format( $value['number_order'] );
			$xtpl->assign( 'LOOP_PRODUCT', $value );
			$xtpl->parse( 'main.loop' );
			$ii ++;
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function nv_theme_retail_suggest_search( $array_data,$list_info_shop,$key_word ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload,$db, $user_info;
		$xtpl = new XTemplate( 'suggest_search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		
		if(empty($key_word))
		{
			$xtpl = new XTemplate( 'suggest_search_empty.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
			
			// danh muc tim kiem pho bien
			$get_catid_phobien = $db->query('SELECT name,alias,image FROM ' . TABLE .'_categories WHERE parrent_id = 0 AND status = 1 AND id IN(1,2,3,4)')->fetchAll();
			
			foreach($get_catid_phobien as $catalogy)
			{
				$catalogy['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $catalogy['image'];
				
				$catalogy['alias'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name .'/'.$catalogy['alias'],true);
				
				$xtpl->assign( 'catalogy', $catalogy );
				$xtpl->parse( 'main.catalogy' );
			}
		}
		
		
		//phantrangajax//
		foreach ($list_info_shop as $key => $value) {
			
			if($value['avatar_image']){
				$value['image']  = $value['avatar_image'] ;
				}else{
				$value['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/no_img.png';
			}
			
			$value['alias'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value['username'], true );
			
			$xtpl->assign( 'SHOP', $value );
			$xtpl->parse( 'main.data.shop' );
		}
		
		$number_sp = 0;
		while( $value = $array_data -> fetch() ) {
			
			if (!empty($value['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value['image'] )) {
				$value['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
			}
			
			$value['alias'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value['alias'].'-'.$value['id'], true );
			
			$number_sp++;
			$xtpl->assign( 'LOOP_PRODUCT', $value );
			$xtpl->parse( 'main.data.loop' );
		}
		
		
		if((empty($list_info_shop)) and (!$number_sp))
		{
			$xtpl->parse( 'main.nodata' ); 
		}
		else
		{
			$xtpl->parse( 'main.data' ); 
		}
		
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	function nv_theme_retail_sort_product_in_view_type_cat( $array_data, $per_page, $page, $num_items, $base_url,$category_id,$shop_id,$sort_price,$category_child,$brand,$brand_list ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		
		
		$xtpl = new XTemplate( 'main_list_sort_product_in_view_type_cat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'CATEGORY_ID', $category_id );
		$xtpl->assign( 'SHOPID', $shop_id );
		$xtpl->assign( 'CHILD_FILT_CURRENT', $category_child );
		$xtpl->assign( 'BRAND_CHUOI', $brand_list );
		
		if($category_child == 0){
			$xtpl->assign( 'ACTIVE_ALL_CATE', 'active_category' );
			}else{
			$xtpl->assign( 'ACTIVE_ALL_CATE', '' );
		}
		if($brand == 0){
			$xtpl->assign( 'ACTIVE_ALL_BRAND', 'active_category_inshop' );
			}else{
			$xtpl->assign( 'ACTIVE_ALL_BRAND', '' );
		}
		$xtpl->assign( 'BRAND_CURRENT', $brand );
		if($brand_list){
			$cat_info['brand'] = explode('|', $brand_list);
			
			foreach ($cat_info['brand'] as $key => $value) {
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value . ' AND status =1')->fetch();
				$info_brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $info_brand['logo'];
				if($value == $brand){
					$info_brand['class'] = 'active_brand';
					}else{
					$info_brand['class'] = '';
				}
				$xtpl->assign('BRAND', $info_brand);
				$xtpl->parse('main.brand');
			}
		}
		
		$list_category_parrent=get_list_category($category_id);
		
		foreach($list_category_parrent as $value){
			if($category_child == $value['id']){
				$value['class'] = 'active_category';
				}else{
				$value['class'] = '';
			}
			$xtpl->assign( 'CHILD_FILT', $value );
			$xtpl->parse( 'main.category_filt' );
		}
		if($sort_price==1){
			$selected1 = 'selected';
			$selected2 = '';
			}else{
			$selected2 = 'selected';
			$selected1 = '';
		}
		$xtpl->assign( 'SELECTED1', $selected1);
		$xtpl->assign( 'SELECTED2', $selected2);
		
		
		
		//phantrangajax//
		foreach ($array_data as $key => $value_cate) {
			$xtpl->assign( 'CATE', $value_cate );
			$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_produc_category_phantrang_type&categories_id='.$value_cate['categories_id'].'&brand='.$brand.'&limit='. $value_cate['limit'];
			$generate_page = nv_generate_page_viewcat( $base_url, $value_cate['number_product'], $value_cate['limit'], 1 , 'true', 'false', 'nv_urldecode_ajax', 'list_category_product_'.$value_cate['categories_id'] );
			if ( !empty( $generate_page ) ) {
				$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
				$xtpl->parse( 'main.cate.generate_page' );
			}
			foreach ($value_cate['list_product'] as $key1 => $value_product) {
				$value_product['number_view'] = number_format( $value_product['number_view'] );
				$value_product['number_order']=number_format($value_product['number_order']);
				$value_product['check_wishlist'] = 2;
				if($user_info['userid']){
					$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
				}
				
				$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
				if($value_product['check_wishlist'] == 0){
					$value_product['color_wishlist'] = "white_wishlist";
					}else if($value_product['check_wishlist']==1){
					$value_product['color_wishlist'] = "red_wishlist";
					}else{
					$value_product['color_wishlist'] = "white_wishlist";
				}
				if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
					if($value_product['price_min']==0 &&$value_product['price_max']==0){
						if ( $value_product['price'] == $value_product['price_special'] ) {
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.cate.product.one_price' );
							} else {
							if($value_product['price_special']>0){
								$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
								$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
								$xtpl->parse( 'main.cate.product.min_max_price' );
								}else{
								$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
								$xtpl->parse( 'main.cate.product.one_price' );
							}
						}
					}
					}else{
					if ( $value_product['price_min'] == $value_product['price_max'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
						$xtpl->parse( 'main.cate.product.one_price' );
						} else {
						$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
						$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
						$xtpl->parse( 'main.cate.product.min_max_price' );
					}
				}
				
				$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
				
				if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
					$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
					}else{
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}
				$xtpl->assign( 'LOOP_PRODUCT', $value_product);
				$xtpl->parse( 'main.cate.product' );
				
			}
			$xtpl->parse( 'main.cate' );
		}
		
		if($num_items == 0 ){
			$xtpl->parse( 'main.empty' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function nv_theme_retail_main_product_in_view_type_cat( $array_data, $per_page, $page, $num_items, $base_url,$category_id,$shop_id,$sort_price,$category_child,$brand,$brand_list ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		
		
		$xtpl = new XTemplate( 'viewcattype_product.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'CATEGORY_ID', $category_id );
		$xtpl->assign( 'SHOPID', $shop_id );
		$xtpl->assign( 'CHILD_FILT_CURRENT', $category_child );
		$xtpl->assign( 'BRAND_CHUOI', $brand_list );
		if($category_child == 0){
			$xtpl->assign( 'ACTIVE_ALL_CATE', 'active_category' );
			}else{
			$xtpl->assign( 'ACTIVE_ALL_CATE', '' );
		}
		if($brand == 0){
			$xtpl->assign( 'ACTIVE_ALL_BRAND', 'active_category_inshop' );
			}else{
			$xtpl->assign( 'ACTIVE_ALL_BRAND', '' );
		}
		$xtpl->assign( 'BRAND_CURRENT', $brand );
		if($brand_list){
			$cat_info['brand'] = explode('|', $brand_list);
			
			foreach ($cat_info['brand'] as $key => $value) {
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value . ' AND status =1')->fetch();
				$info_brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $info_brand['logo'];
				if($value == $brand){
					$info_brand['class'] = 'active_brand';
					}else{
					$info_brand['class'] = '';
				}
				$xtpl->assign('BRAND', $info_brand);
				$xtpl->parse('main.brand');
			}
		}
		
		$list_child = $db->query('SELECT * FROM ' . TABLE . '_categories WHERE parrent_id = 0 AND status =1')->fetchAll();
		foreach ($list_child as $key => $value) {
			$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'/';
			$xtpl->assign('CHILD', $value);
			$xtpl->parse('main.category_child');
			
		}
		$list_category_parrent=get_list_category($category_id);
		
		foreach($list_category_parrent as $value){
			if($category_child == $value['id']){
				$value['class'] = 'active_category';
				}else{
				$value['class'] = '';
			}
			$xtpl->assign( 'CHILD_FILT', $value );
			$xtpl->parse( 'main.category_filt' );
		}
		if($sort_price==1){
			$selected1 = 'selected';
			$selected2 = '';
			}else{
			$selected2 = 'selected';
			$selected1 = '';
		}
		$xtpl->assign( 'SELECTED1', $selected1);
		$xtpl->assign( 'SELECTED2', $selected2);
		
		
		
		//phantrangajax//
		foreach ($array_data as $key => $value_cate) {
			$xtpl->assign( 'CATE', $value_cate );
			$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_produc_category_phantrang_type&categories_id='.$value_cate['categories_id'].'&brand='.$brand.'&limit='. $value_cate['limit'];
			$generate_page = nv_generate_page_viewcat( $base_url, $value_cate['number_product'], $value_cate['limit'], 1 , 'true', 'false', 'nv_urldecode_ajax', 'list_category_product_'.$value_cate['categories_id'] );
			if ( !empty( $generate_page ) ) {
				$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
				$xtpl->parse( 'main.cate.generate_page' );
			}
			foreach ($value_cate['list_product'] as $key1 => $value_product) {
				$value_product['number_view'] = number_format( $value_product['number_view'] );
				$value_product['number_order']=number_format($value_product['number_order']);
				$value_product['check_wishlist'] = 2;
				if($user_info['userid']){
					$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
				}
				
				$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
				if($value_product['check_wishlist'] == 0){
					$value_product['color_wishlist'] = "white_wishlist";
					}else if($value_product['check_wishlist']==1){
					$value_product['color_wishlist'] = "red_wishlist";
					}else{
					$value_product['color_wishlist'] = "white_wishlist";
				}
				
				if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
					if($value_product['price_min']==0 &&$value_product['price_max']==0){
						if ( $value_product['price'] == $value_product['price_special'] ) {
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.cate.product.one_price' );
							} else {
							if($value_product['price_special']>0){
								$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
								$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
								$xtpl->parse( 'main.cate.product.min_max_price' );
								}else{
								$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
								$xtpl->parse( 'main.cate.product.one_price' );
							}
						}
					}
					}else{
					if ( $value_product['price_min'] == $value_product['price_max'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
						$xtpl->parse( 'main.cate.product.one_price' );
						} else {
						$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
						$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
						$xtpl->parse( 'main.cate.product.min_max_price' );
					}
				}
				
				$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
				
				if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
					$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
					}else{
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}
				$xtpl->assign( 'LOOP_PRODUCT', $value_product);
				$xtpl->parse( 'main.cate.product' );
				
			}
			$xtpl->parse( 'main.cate' );
		}
		
		if($num_items == 0 ){
			$xtpl->parse( 'main.empty' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	function viewcatgrid_ajax( $array_data, $per_page, $page, $num_items, $base_url ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		
		
		$xtpl = new XTemplate( 'viewcatgrid_ajax.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		
		
		//phantrangajax//
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		//phantrangajax//
		
		while( $value_product = $array_data -> fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['rate'] = rate_product($value_product['id']);
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		if($num_items == 0 ){
			$xtpl->parse( 'main.empty' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	
	function nv_theme_retail_sort_product_in_view_cat( $array_data, $per_page, $page, $num_items, $base_url,$category_id,$shop_id,$sort_price,$category_child,$brand,$brand_list ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		
		
		$xtpl = new XTemplate( 'main_list_sort_product_in_view_cat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'CATEGORY_ID', $category_id );
		$xtpl->assign( 'SHOPID', $shop_id );
		$xtpl->assign( 'CHILD_FILT_CURRENT', $category_child );
		$xtpl->assign( 'BRAND_CURRENT', $brand );
		$xtpl->assign( 'BRAND_CHUOI', $brand_list);
		if($brand_list){
			$cat_info['brand'] = explode('|', $brand_list);
			
			foreach ($cat_info['brand'] as $key => $value) {
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value . ' AND status =1')->fetch();
				$info_brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $info_brand['logo'];
				if($value == $brand){
					$info_brand['class'] = 'active_brand';
					}else{
					$info_brand['class'] = '';
				}
				$xtpl->assign('BRAND', $info_brand);
				$xtpl->parse('main.brand');
			}
		}
		
		$list_category_parrent=get_list_category($category_id);
		foreach($list_category_parrent as $value){
			if($category_child == $value['id']){
				$value['class'] = 'active_category';
				}else{
				$value['class'] = '';
			}
			$xtpl->assign( 'CHILD_FILT', $value );
			$xtpl->parse( 'main.category_filt' );
		}
		if($sort_price==1){
			$selected1 = 'selected';
			$selected2 = '';
			}else{
			$selected2 = 'selected';
			$selected1 = '';
		}
		$xtpl->assign( 'SELECTED1', $selected1);
		$xtpl->assign( 'SELECTED2', $selected2);
		
		//phantrangajax//
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'load_product' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		//phantrangajax//
		
		while( $value_product = $array_data -> fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		if($num_items == 0 ){
			$xtpl->parse( 'main.empty' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	function nv_theme_retail_sort_product_in_view_cat_list( $array_data, $per_page, $page, $num_items, $base_url,$category_id,$shop_id,$sort_price,$category_child,$brand,$brand_list ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		
		
		$xtpl = new XTemplate( 'main_list_sort_product_in_view_cat_list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'CATEGORY_ID', $category_id );
		$xtpl->assign( 'SHOPID', $shop_id );
		$xtpl->assign( 'CHILD_FILT_CURRENT', $category_child );
		$xtpl->assign( 'BRAND_CURRENT', $brand );
		$xtpl->assign( 'BRAND_CHUOI', $brand_list);
		if($brand_list){
			$cat_info['brand'] = explode('|', $brand_list);
			
			foreach ($cat_info['brand'] as $key => $value) {
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value . ' AND status =1')->fetch();
				$info_brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $info_brand['logo'];
				if($value == $brand){
					$info_brand['class'] = 'active_brand';
					}else{
					$info_brand['class'] = '';
				}
				$xtpl->assign('BRAND', $info_brand);
				$xtpl->parse('main.brand');
			}
		}
		
		$list_category_parrent=get_list_category($category_id);
		foreach($list_category_parrent as $value){
			if($category_child == $value['id']){
				$value['class'] = 'active_category';
				}else{
				$value['class'] = '';
			}
			$xtpl->assign( 'CHILD_FILT', $value );
			$xtpl->parse( 'main.category_filt' );
		}
		if($sort_price==1){
			$selected1 = 'selected';
			$selected2 = '';
			}else{
			$selected2 = 'selected';
			$selected1 = '';
		}
		$xtpl->assign( 'SELECTED1', $selected1);
		$xtpl->assign( 'SELECTED2', $selected2);
		
		//phantrangajax//
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'load_product' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		//phantrangajax//
		
		while( $value_product = $array_data -> fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		if($num_items == 0 ){
			$xtpl->parse( 'main.empty' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function shops_info_list_products( $array_data, $per_page, $page, $num_items, $base_url,$category_id,$shop_id,$sort_price ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		$xtpl = new XTemplate( 'shops_info_list_products.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'CATEGORY_ID', $category_id );
		$xtpl->assign( 'SHOPID', $shop_id );
		
		if($sort_price==1){
			$selected1 = 'selected';
			$selected2 = '';
			}else{
			$selected2 = 'selected';
			$selected1 = '';
		}
		$xtpl->assign( 'SELECTED1', $selected1);
		$xtpl->assign( 'SELECTED2', $selected2);
		
		//phantrangajax//
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'load_product_shop_category' );
		if ( !empty( $generate_page ) ) {
			
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		//phantrangajax//
		
		while( $value_product = $array_data -> fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	function nv_theme_retail_product_phan_trang_in_shop( $array_data, $per_page, $page, $num_items, $base_url,$category_id,$shop_id,$sort_price ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		$xtpl = new XTemplate( 'main_list_product_inshop_phan_trang.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'CATEGORY_ID', $category_id );
		$xtpl->assign( 'SHOPID', $shop_id );
		
		if($sort_price==1){
			$selected1 = 'selected';
			$selected2 = '';
			}else{
			$selected2 = 'selected';
			$selected1 = '';
		}
		$xtpl->assign( 'SELECTED1', $selected1);
		$xtpl->assign( 'SELECTED2', $selected2);
		
		//phantrangajax//
		
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'load_product_shop_category' );
		if ( !empty( $generate_page ) ) {
			
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		//phantrangajax//
		
		while( $value_product = $array_data -> fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function nv_theme_retailshops_main_list_product( $array_data, $per_page, $page, $num_items, $base_url ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		$xtpl = new XTemplate( 'main_list_product.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		
		//phantrangajax//
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		//phantrangajax//
		
		while( $value_product = $array_data -> fetch() ) {
			
			
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if ( $value_product['price'] == $value_product['price_special'] ) {
					
					$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					if($value_product['price_special']>0){
						$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
						$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.special_no_type' );
						}else{
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	/**
		* nv_theme_retailshops_main()
		*
		* @param mixed $array_data
		* @return
	*/
	
	
	function nv_theme_view_category_shop( $list_category,$shop_id)
	{
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name,$db,$user_info;
		$xtpl = new XTemplate('list_category_shop.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'shop_id', $shop_id );
		$xtpl->assign( 'GLANG', $lang_global );
		if($list_category){
			$i = 0;
			foreach ($list_category as $key => $value) {
				$cout_product = $db->query('SELECT count(*) FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id WHERE t1.store_id = ' . $shop_id . ' AND (t1.categories_id = ' . $value['id'] . ' OR t2.parrent_id = ' . $value['id'] . ')')->fetchColumn();
				
				if($cout_product>0){
					$xtpl->assign( 'CATEGORY', $value );
					$xtpl->parse( 'main.category' );
					$i++;
				}
				if($i==1){
					$xtpl->assign( 'DATA', $value );
					$xtpl->parse( 'main.load_first' );
					$i++;
				}
				
			}
			
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	/**
		* nv_theme_retailshops_main()
		*
		* @param mixed $array_data
		* @return
	*/
	
	function nv_theme_retailshops_main( $list_category )
	{
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name,$db,$user_info;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		foreach ($list_category as $key => $value) {
			
			if(count($value['list_product'])!=0){
				$value['alias'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name .'/'.$value['alias'];
				if($value['list_product']){
					foreach ($value['list_product'] as $key => $value_product) {
						$value_product['number_view'] = number_format( $value_product['number_view'] );
						$value_product['number_order']=number_format($value_product['number_order']);
						$value_product['check_wishlist'] = 2;
						if($user_info['userid']){
							$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
						}
						
						$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
						if($value_product['check_wishlist'] == 0){
							$value_product['color_wishlist'] = "white_wishlist";
							}else if($value_product['check_wishlist']==1){
							$value_product['color_wishlist'] = "red_wishlist";
							}else{
							$value_product['color_wishlist'] = "white_wishlist";
						}
						
						if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
							if($value_product['price_min']==0 &&$value_product['price_max']==0){
								if ( $value_product['price'] == $value_product['price_special'] ) {
									$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
									$xtpl->parse( 'main.category.product.one_price' );
									} else {
									if($value_product['price_special']>0){
										$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
										$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
										$xtpl->parse( 'main.category.product.min_max_price' );
										}else{
										$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
										$xtpl->parse( 'main.category.product.one_price' );
									}
								}
							}
							}else{
							if ( $value_product['price_min'] == $value_product['price_max'] ) {
								$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
								$xtpl->parse( 'main.category.product.one_price' );
								} else {
								$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
								$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
								$xtpl->parse( 'main.category.product.min_max_price' );
							}
						}
						
						$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
						if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
							$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
							}else{
							$server = 'banhang.'.$_SERVER["SERVER_NAME"];
							$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
						}
						$xtpl->assign( 'LOOP_PRODUCT', $value_product);
						$xtpl->parse( 'main.category.product' );
					}
				}
				$xtpl->assign( 'LOOP_CAT', $value );
				$xtpl->parse( 'main.category' );
			}	
		}
		// foreach ( $list_category as $key=>$value ) {
		// $count_product_cat = count_product_cat( $value['id'] );
		// if ( $count_product_cat>0 ) {
		// $value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'/';
		// $list_category_parrent = get_list_category( $value['id'] );
		// foreach ( $list_category_parrent as $value_group_parrent ) {
		// $value_group_parrent['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value_group_parrent['alias'].'/';
		// $xtpl->assign( 'LOOP_CAT_PARRENT', $value_group_parrent );
		// $xtpl->parse( 'main.category_detail.category_detail_parrent' );
		// }
		// if ( !empty( $value['image'] ) ) {
		// $value['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $value['image'];
		// } else {
		// $value['image'] = NV_BASE_SITEURL . 'assets/images/logo.png';
		// }
		// if ( $key == 0 ) {
		// $xtpl->assign( 'active_list_product_left', 'active_list_product_left' );
		// } else {
		// $xtpl->assign( 'active_list_product_left', '' );
		// }
		// $xtpl->assign( 'LOOP_CAT', $value );
		// $xtpl->parse( 'main.category' );
		// $xtpl->parse( 'main.category_detail' );
		// $xtpl->parse( 'main.category_js' );
		
		// }
		// }
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function nv_theme_retail_brand_list( $array_data, $per_page, $page, $num_items, $base_url, $info_brand ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		$xtpl = new XTemplate( 'view-brand-list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign( 'INFO_BRAND', $info_brand );
		//phantrangajax//
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		//phantrangajax//
		
		while( $value_product = $array_data -> fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	function nv_theme_retailshops_viewcat_ajax_main_shop( $array_data, $per_page, $page, $num_items, $cat_info, $base_url ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload;
		
		$xtpl = new XTemplate( 'viewcat_ajax_main_shop.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$cat_info['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/';
		$xtpl->assign( 'LOOP_CAT', $cat_info );
		$xtpl->assign( 'count_product', $num_items );
		if ( $num_items == 0 ) {
			$xtpl->parse( 'main.no_product' );
		}
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'list_product_'.$cat_info['id'] );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'generate_page', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		while( $value = $array_data -> fetch() ) {
			if (!empty($value['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value['image'] )) {
				$value['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
			}
			$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'-'.$value['id'].'/';
			
			
			if ( $value['price_min'] == $value['price_max'] ) {
				$xtpl->assign( 'PRICE', number_format( $value['price_min'] ).'đ' );
				$xtpl->parse( 'main.loop.one_price' );
				} else {
				$xtpl->assign( 'PRICE_MIN', number_format( $value['price_min'] ).'đ' );
				$xtpl->assign( 'PRICE_MAX', number_format( $value['price_max'] ).'đ' );
				$xtpl->parse( 'main.loop.min_max_price' );
			}
			
			$value['number_view'] = number_format( $value['number_view'] );
			$value['number_order']=number_format($value['number_order']);
			$xtpl->assign( 'LOOP_PRODUCT', $value );
			$xtpl->parse( 'main.loop' );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	function nv_theme_retailshops_viewcat_ajax_main( $array_data, $per_page, $page, $num_items, $cat_info, $base_url ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		
		$xtpl = new XTemplate( 'viewcat_ajax_main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$cat_info['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/';
		$xtpl->assign( 'LOOP_CAT', $cat_info );
		$xtpl->assign( 'count_product', $num_items );
		if ( $num_items == 0 ) {
			$xtpl->parse( 'main.no_product' );
		}
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'list_product_'.$cat_info['id'] );
		if ( !empty( $generate_page ) ) {
			$xtpl->parse( 'main.generate_page' );
		}
		
		while( $value = $array_data -> fetch() ) {
			if (!empty($value['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value['image'] )) {
				$value['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
			}
			$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'-'.$value['id'].'/';
			
			
			if ( $value['price_min'] == $value['price_max'] ) {
				$xtpl->assign( 'PRICE', number_format( $value['price_min'] ).'đ' );
				$xtpl->parse( 'main.loop.one_price' );
				} else {
				$xtpl->assign( 'PRICE_MIN', number_format( $value['price_min'] ).'đ' );
				$xtpl->assign( 'PRICE_MAX', number_format( $value['price_max'] ).'đ' );
				$xtpl->parse( 'main.loop.min_max_price' );
			}
			
			
			$value['number_view'] = number_format( $value['number_view'] );
			$value['number_order']=number_format($value['number_order']);
			$value['check_wishlist'] = 2;
			if($user_info['userid']){
				$value['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value['id']) -> fetchColumn();
			}
			
			if($value['check_wishlist'] == 0){
				$value['color_wishlist'] = "white_wishlist";
				}else if($value['check_wishlist']==1){
				$value['color_wishlist'] = "red_wishlist";
				}else{
				$value['color_wishlist'] = "white_wishlist";
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value );
			$xtpl->parse( 'main.loop' );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function nv_theme_retailshops_viewcat_ajax_type_product( $array_data, $per_page, $page, $num_items, $cat_info, $base_url ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload;
		
		$xtpl = new XTemplate( 'viewcat_ajax_type_product.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$cat_info['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/';
		$xtpl->assign( 'LOOP_CAT', $cat_info );
		$xtpl->assign( 'count_product', $num_items );
		if ( $num_items == 0 ) {
			$xtpl->parse( 'main.no_product' );
		}
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'list_product_category_'.$cat_info['id'] );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		while( $value = $array_data -> fetch() ) {
			if (!empty($value['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value['image'] )) {
				$value['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['image'] ;
			}
			$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'-'.$value['id'].'/';
			if($value['price_min']>0||$value['price_max']>0){
				if ( $value['price_min'] == $value['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value['price_min'] ).'đ' );
					$xtpl->parse( 'main.loop.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value['price_max'] ).'đ' );
					$xtpl->parse( 'main.loop.min_max_price' );
				}
				}else{
				if ( $value['price_special']>0 ) {
					$xtpl->assign( 'PRICE_MIN', number_format( $value['price_special'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value['price'] ).'đ' );
					$xtpl->parse( 'main.loop.min_max_price' );
					}else{
					$xtpl->assign( 'PRICE', number_format( $value['price'] ).'đ' );
					$xtpl->parse( 'main.loop.one_price' );
				}
			}
			
			$value['number_view'] = number_format( $value['number_view'] );
			$value['number_order'] = number_format( $value['number_order'] );
			$xtpl->assign( 'LOOP_PRODUCT', $value );
			$xtpl->parse( 'main.loop' );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	function nv_theme_wish_list( $array_data, $per_page, $page, $num_items, $base_url ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info, $q;
		
		// xuất dữ liệu ra fiel tpl view_list_wish_list.tpl
		$xtpl = new XTemplate( 'wishlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'count_product', $num_items );
		$xtpl->assign('Q', $q);
		// xuất thông tin link personal
		$xtpl->assign('personal', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=personal');
		
		$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page);
		if ( $num_items == 0 ) {
			$xtpl->parse( 'main.no_product' );
		}
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		while( $value_product = $array_data -> fetch() ) {
			
			//print_r($value_product);
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			$value_product['store_name']= $db->query("SELECT company_name FROM " . TABLE . "_seller_management where id=" . $value_product['store_id'])->fetchColumn();
			$value_product['avatar_image'] = $db->query("SELECT avatar_image FROM " . TABLE . "_seller_management where id=" . $value_product['store_id'])->fetchColumn();
			
			$userid = get_info_store($value_product['store_id'])['userid'];	
			$username = $db->query("SELECT username FROM " . NV_TABLE_USER . " where userid=" . $userid)->fetchColumn();
			
			$value_product['alias_store'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $username, true );
			
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
			
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	function nv_theme_retail_load_comment($list_rate,$page_new,$per_page,$base_url,$num_items,$page) {
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name, $db, $user_info, $db, $db_config,$db, $user_info;
		
		$xtpl = new XTemplate( 'load_comment.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'load_comment' );
		
		if ( $num_items == 0 ) {
			$xtpl->parse( 'main.no_product' );
		}
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		$total_star = 0; 
		foreach ($list_rate as $key => $value) {
			$value['info_user'] = $db->query("SELECT * FROM " .$db_config['prefix']."_users WHERE userid = " . $value['userid']) -> fetch();
			$total_star = $value['star'] + $total_star;
			if($value['info_user']['photo']){
				$value['info_user']['photo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value['info_user']['photo'];
				}else{
				$value['info_user']['photo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/no_img.png';
			}
			if($value['other_image']){
				$value['other_image'] = explode('|', $value['other_image']);
				foreach ($value['other_image'] as $key => $value_image) {
					if (!empty($value_image ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_image )) {
						$value_image  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_image ;
						}else{
						$server = 'banhang.'.$_SERVER["SERVER_NAME"];
						$value_image  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_image ;
					}
					$xtpl->assign( 'INFO_RATE_IMAGE', $value_image);
					$xtpl->parse( 'main.info_rate_content.image' );
				}
				}else{
				$xtpl->parse( 'main.info_rate_content.no_image' );
			}
			
			$value['time_add'] = date('d/m/Y - H:i:s',$value['time_add']);
			$xtpl->assign( 'INFO_RATE_CONTENT', $value);
			$xtpl->parse( 'main.info_rate_content' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	function shops_info_viewcat( $array_data, $per_page, $page, $num_items, $cat_info, $base_url ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db, $user_info;
		
		$xtpl = new XTemplate( 'shops_info_viewcat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		
		$cat_info['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/';
		$xtpl->assign( 'LOOP_CAT', $cat_info );
		$xtpl->assign( 'count_product', $num_items );
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		if ( $num_items == 0 ) {
			$xtpl->parse( 'main.no_product' );
		}
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		while( $value_product = $array_data -> fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	function viewgird_product($array_data)
	{
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db,$user_info;
		
		$xtpl = new XTemplate( 'viewcatgrid_orther.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		$xtpl->assign( 'URL', nv_url_rewrite($base_url, true)); 
		
		foreach( $array_data as $value_product ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			$value_product['price_format'] = number_format( $value_product['price'] ).'đ';
			
			if($value_product['price_special'] and $value_product['price'] < $value_product['price_special'])
			{		
				$price_special = number_format( $value_product['price_special'] ).'đ';
				$xtpl->assign( 'price_special', $price_special);
				$xtpl->parse( 'main.product.price_special' );
			}
			if($value_product['free_ship'])
			{	
				$xtpl->parse( 'main.product.free_ship' );
			}
			
			//$value_product['name_product'] = nv_clean60($value_product['name_product'], 50 , true);
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	function shops_info( $array_data, $per_page, $page, $num_items, $cat_info, $base_url,$list_category_parrent,$getbrand_all,$page_check,$info_shop,$list_voucher) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db,$user_info;
		
		if($page_check==0){
			$xtpl = new XTemplate( 'viewcatgrid_shop.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		}
		else
		{
			$xtpl = new XTemplate( 'viewcatgrid_ajax.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		}
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		$xtpl->assign( 'BRAND_CHUOI', $cat_info['brand']);
		$xtpl->assign( 'URL', nv_url_rewrite($base_url, true)); 
		$xtpl->assign( 'info_shop', $info_shop); 
		
		//print_r($info_shop);
		
		$follow['check_follow'] = 0 ;
		if($user_info['userid']){
			$follow['check_follow'] = $db->query("SELECT count(*) FROM " .TABLE."_follow WHERE user_id =".$user_info['userid']." AND shop_id = " . $info_shop['id']) -> fetchColumn();
		}
		
		if($follow['check_follow'] == 0){
			$follow['color_follow'] = "btn_ecng";
			$follow['title_follow'] = "Theo dõi";
			}else if($follow['check_follow'] == 1){
			$follow['color_follow'] = "btn_ecng_outline";
			$follow['title_follow'] = "Bỏ theo dõi";
			}else{
			$follow['color_follow'] = "btn_ecng";
			$follow['title_follow'] = "Theo dõi";
		}
		$xtpl->assign('FOLLOW', $follow);	
		
		if($getbrand_all){
			foreach($getbrand_all as $value)
			{
				if($value)
				{
					$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value . ' AND status =1')->fetch();
					
					if(!empty($info_brand['logo']))
					{
						$info_brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $info_brand['logo'];
						$xtpl->assign('BRAND', $info_brand);
						$xtpl->parse('main.enibal_brand.brand');
					}
				}
				
			}
			
			$xtpl->parse('main.enibal_brand'); 
		}
		
		if(!empty($list_category_parrent)){
			
			foreach ($list_category_parrent as $value) {
				$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'/';
				$xtpl->assign( 'CHILD', $value );
				$xtpl->parse( 'main.category_check.category_child' );
			}
			
			$xtpl->parse( 'main.category_check' );
		}
		
		
		
		
		$xtpl->assign( 'count_product', $num_items );
		if ( !count($array_data)) {
			$xtpl->parse( 'main.no_product' );
		}
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		
		
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		
		if(!empty($array_data))
		{
			foreach( $array_data as $value_product ) {
				$value_product['number_view'] = number_format( $value_product['number_view'] );
				$value_product['number_order']=number_format($value_product['number_order']);
				$value_product['check_wishlist'] = 2;
				if($user_info['userid']){
					$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
				}
				
				$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
				if($value_product['check_wishlist'] == 0){
					$value_product['color_wishlist'] = "white_wishlist";
					}else if($value_product['check_wishlist']==1){
					$value_product['color_wishlist'] = "red_wishlist";
					}else{
					$value_product['color_wishlist'] = "white_wishlist";
				}
				
				$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
				
				if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
					$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
					}else{
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}
				$value_product['price'] = $value_product['price'] ? $value_product['price'] : $value_product['price_special'];
				$value_product['price_format'] = number_format( $value_product['price'] ).'đ';
				$xtpl->assign( 'LOOP_PRODUCT', $value_product);
				
				if($value_product['price_special'] and $value_product['price'] < $value_product['price_special'])
				{		
					$price_special = number_format( $value_product['price_special'] ).'đ';
					$xtpl->assign( 'price_special', $price_special);
					$xtpl->parse( 'main.product.loop.price_special' );
				}
				//print_r($value_product);
				if($value_product['free_ship'])
				{	
					$xtpl->parse( 'main.product.loop.free_ship' );
				}
				$xtpl->parse( 'main.product.loop' );
			}
			$xtpl->parse( 'main.product' );
		}
		
		//voucher
		
		if(!empty($list_voucher))
		{
			foreach( $list_voucher as $voucher ) {
				// print_r($voucher['list_product']);
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
				
				$voucher['time_to'] = date("d-m-Y", $voucher['time_to']);
				$xtpl->assign( 'VOUCHER', $voucher);
				
				
				if($voucher['maximum_discount'])
				{	
					$xtpl->parse( 'main.voucher.voucher_loop.maximum_discount' );
					$voucher['maximum_discount'] = number_format( $voucher['maximum_discount'] ).'đ';
					$xtpl->assign( 'maximum_discount', $voucher['maximum_discount']);
				}
				
				//check voucher khach da luu
				$check_voucher_customer = $db->query('SELECT id FROM ' . TABLE . '_voucher_wallet WHERE voucherid = ' . $voucher['id'])->fetchColumn();
				if($check_voucher_customer){
					$xtpl->parse( 'main.voucher.voucher_loop.saved');
					}else{
					if(!$voucher['usage_limit_quantity']){
						$xtpl->parse( 'main.voucher.voucher_loop.not_voucher');
						}else{
						$xtpl->parse( 'main.voucher.voucher_loop.not_saved');
					}
					
				}
				
				
				$xtpl->parse( 'main.voucher.voucher_loop' );
			}
			$xtpl->parse( 'main.voucher' );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	
	function nv_theme_retailshops_viewcat_grid( $array_data, $per_page, $page, $num_items, $cat_info, $base_url,$list_category_parrent,$page_check ) {
		
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db,$user_info, $redis;
		
		 
		if($page_check==0){
			$xtpl = new XTemplate( 'viewcatgrid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		}
		else
		{
			// ajax 
			$xtpl = new XTemplate( 'viewcatgrid_ajax.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		}
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		$xtpl->assign( 'BRAND_CHUOI', $cat_info['brand']);
		$xtpl->assign( 'URL', nv_url_rewrite($base_url, true)); 
		
		
		
		
		$cat_info['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/';
		
		if($cat_info['other_image']){
			$cat_info['other_image'] = explode('|', $cat_info['other_image']);
			foreach ($cat_info['other_image'] as $key => $value) {
				
				$op_tmp = explode(';',$value);
				$data_option_product = array(
						'title' => $op_tmp[0],
						'link' => $op_tmp[1],
						'img' => $op_tmp[2]
					);
					
				if(!empty($op_tmp[2]))
				{
					
					$xtpl->assign( 'DATA_IMG', $data_option_product );
					$xtpl->parse( 'main.enibal_other_image_category.other_image_category' );
				}
				
			}
			$xtpl->parse( 'main.enibal_other_image_category' );
		}
		
		$xtpl->assign( 'LOOP_CAT', $cat_info );
		
		
		// lấy tất cả thương hiệu thuộc danh mục
		$list_brand = getbrand_all_redis($cat_info['id']);
		
		if($list_brand){
			foreach($list_brand as $info_brand)
			{
				
				if(!empty($info_brand['logo']))
				{
					$xtpl->assign('BRAND', $info_brand);
					$xtpl->parse('main.enibal_brand.brand');
				}
				
			}
			
			$xtpl->parse('main.enibal_brand'); 
		}
		
		
		
		// danh sách danh mục con của category
		$list_child = getcategory_child_lev1_redis($cat_info['id']);
		
		if(!empty($list_child)){
			
			foreach ($list_child as $value) {
				$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'/';
				$xtpl->assign( 'CHILD', $value );
				$xtpl->parse( 'main.category_check.category_child' );
			}
			
			$xtpl->parse( 'main.category_check' );
		}
		
		
		
		$xtpl->assign( 'count_product', $num_items );
		
		if ( !count($array_data)) {
			$xtpl->parse( 'main.no_product' );
		}
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		
		
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		if(!empty($array_data))
		{
			foreach( $array_data as $value_product ) {
				$value_product['number_view'] = number_format( $value_product['number_view'] );
				$value_product['number_order']=number_format($value_product['number_order']);	
				
				$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
				
				if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
					$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
					}else{
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}
				$value_product['price_format'] = number_format( $value_product['price'] ).'đ';
				$xtpl->assign( 'LOOP_PRODUCT', $value_product);
				
				if($value_product['price_special'] and $value_product['price'] < $value_product['price_special'])
				{		
					$price_special = number_format( $value_product['price_special'] ).'đ';
					$xtpl->assign( 'price_special', $price_special);
					$xtpl->parse( 'main.product.loop.price_special' );
				}
				if($value_product['free_ship'])
				{	
					$xtpl->parse( 'main.product.loop.free_ship' );
				}
				
				$xtpl->parse( 'main.product.loop' );
			}
			$xtpl->parse( 'main.product' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	
	function nv_theme_retailshops_viewcat_grid_search( $array_data, $per_page, $page, $num_items, $base_url,$list_category_parrent,$page_check,$q) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db,$user_info;
		
		if($page_check==0){
			$xtpl = new XTemplate( 'search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		}
		else
		{
			// ajax 
			$xtpl = new XTemplate( 'viewcatgrid_ajax.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		}
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		$xtpl->assign( 'URL', nv_url_rewrite($base_url, true)); 
		
		
		
		
		$list_child = get_list_full_category_lev1();
		
		$getcatid_all = getcatid_all(0);
		
		$getbrand_all = getbrand_all($getcatid_all);
		
		
		if($getbrand_all){
			foreach($getbrand_all as $value)
			{
				if($value)
				{
					$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value . ' AND status =1')->fetch();
					
					if(!empty($info_brand['logo']))
					{
						$info_brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $info_brand['logo'];
						$xtpl->assign('BRAND', $info_brand);
						$xtpl->parse('main.enibal_brand.brand');
					}
				}
				
			}
			
			$xtpl->parse('main.enibal_brand'); 
		}
		
		
		foreach($list_category_parrent as $value){
			$xtpl->assign( 'CHILD_FILT', $value );
			$xtpl->parse( 'main.category_filt' );
		}
		if(!empty($list_child)){
			
			foreach ($list_child as $value) {
				$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'/';
				$xtpl->assign( 'CHILD', $value );
				$xtpl->parse( 'main.category_check.category_child' );
			}
			
			$xtpl->parse( 'main.category_check' );
		}
		
		
		
		$xtpl->assign( 'count_product', $num_items );
		
		if ( !count($array_data)) {
			$xtpl->parse( 'main.no_product' );
		}
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		
		
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		if(!empty($array_data))
		{	
			foreach( $array_data as $value_product ) {
				$value_product['number_view'] = number_format( $value_product['number_view'] );
				$value_product['number_order']=number_format($value_product['number_order']);
				
				
				$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
				
				if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
					$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
					}else{
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}
				$value_product['price_format'] = number_format( $value_product['price'] ).'đ';
				$xtpl->assign( 'LOOP_PRODUCT', $value_product);
				// print_r($value_product['price']);
				// if($value_product['price'])
				// {		
				// $price = number_format( $value_product['price'] ).'đ';
				// $xtpl->assign( 'price', $price);
				// $xtpl->parse( 'main.product.loop.price' );
				// }
				$value_product['price'] = $value_product['price'] ? $value_product['price'] : $value_product['price_special'];
				if($value_product['price_special']  and $value_product['price'] < $value_product['price_special'])
				{		
					$price_special = number_format( $value_product['price_special'] ).'đ';
					$xtpl->assign( 'price_special', $price_special);
					$xtpl->parse( 'main.product.loop.price_special' );
				}
				//print_r($array_data);die;
				if($value_product['free_ship'])
				{		
					$xtpl->parse( 'main.product.loop.free_ship' );
				}
				$xtpl->parse( 'main.product.loop' );
			}
			$xtpl->parse( 'main.product' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	function nv_theme_phantrang_type_product($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$sort_price) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db,$user_info;
		
		$xtpl = new XTemplate( 'load_product_phan_trang.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'BRAND_CHUOI', $cat_info['brand']);
		
		$cat_info['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/';
		
		if($cat_info['other_image']){
			$cat_info['other_image'] = explode('|', $cat_info['other_image']);
			foreach ($cat_info['other_image'] as $key => $value) {
				$xtpl->assign( 'DATA_IMG', $value);
				$xtpl->parse( 'main.other_image_category' );
			}
			
		}
		
		$xtpl->assign( 'LOOP_CAT', $cat_info );
		$xtpl->assign( 'count_product', $num_items );
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page_new , 'true', 'false', 'nv_urldecode_ajax', 'list_category_product_' . $category_id );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		while( $value_product = $sth->fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	function nv_theme_retailshops_viewcat_list( $array_data, $per_page, $page, $num_items, $cat_info, $base_url,$list_category_parrent,$page_check ) {
		global $module_info, $lang_module, $lang_global, $op, $module_name, $module_upload, $db,$user_info;
		
		$xtpl = new XTemplate( 'viewcatlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'BRAND_CHUOI', $cat_info['brand']);
		
		$cat_info['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/';
		
		if($cat_info['other_image']){
			$cat_info['other_image'] = explode('|', $cat_info['other_image']);
			foreach ($cat_info['other_image'] as $key => $value) {
				$xtpl->assign( 'DATA_IMG', $value);
				$xtpl->parse( 'main.other_image_category' );
			}
			
		}
		
		$xtpl->assign( 'LOOP_CAT', $cat_info );
		$xtpl->assign( 'count_product', $num_items );
		if ( $num_items == 0 ) {
			$xtpl->parse( 'main.no_product' );
		}
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'ProductContent' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		$list_child = $db->query('SELECT * FROM ' . TABLE . '_categories WHERE parrent_id = 0 AND status =1')->fetchAll();
		
		if($cat_info['brand']){
			$cat_info['brand'] = explode('|', $cat_info['brand']);
			
			foreach ($cat_info['brand'] as $key => $value) {
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value . ' AND status =1')->fetch();
				$info_brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $info_brand['logo'];
				$xtpl->assign('BRAND', $info_brand);
				$xtpl->parse('main.brand');
			}
		}
		
		
		foreach($list_category_parrent as $value){
			$xtpl->assign( 'CHILD_FILT', $value );
			$xtpl->parse( 'main.category_filt' );
		}
		if($page_check==0){
			$xtpl->assign( 'COL','col-xs-18 col-sm-18 col-md-18 col-lg-18' );
			foreach ($list_child as $value) {
				$value['alias'] = NV_MY_DOMAIN .'/'. $module_name .'/'.$value['alias'].'/';
				$xtpl->assign( 'CHILD', $value );
				$xtpl->parse( 'main.category_check.category_child' );
			}
			$xtpl->parse( 'main.category_check' );
			}else{
			$xtpl->assign( 'COL','col-xs-24 col-sm-24 col-md-24 col-lg-24' );
		}
		while( $value_product = $array_data->fetch() ) {
			$value_product['number_view'] = number_format( $value_product['number_view'] );
			$value_product['number_order']=number_format($value_product['number_order']);
			$value_product['check_wishlist'] = 2;
			if($user_info['userid']){
				$value_product['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $value_product['id']) -> fetchColumn();
			}
			
			$value_product['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $value_product['id']) -> fetchColumn();
			if($value_product['check_wishlist'] == 0){
				$value_product['color_wishlist'] = "white_wishlist";
				}else if($value_product['check_wishlist']==1){
				$value_product['color_wishlist'] = "red_wishlist";
				}else{
				$value_product['color_wishlist'] = "white_wishlist";
			}
			
			if( $value_product['price_min'] == 0 &&  $value_product['price_max'] ==0){
				if($value_product['price_min']==0 &&$value_product['price_max']==0){
					if ( $value_product['price'] == $value_product['price_special'] ) {
						$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
						$xtpl->parse( 'main.product.one_price' );
						} else {
						if($value_product['price_special']>0){
							$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_special'] ).'đ' );
							$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.min_max_price' );
							}else{
							$xtpl->assign( 'PRICE', number_format( $value_product['price'] ).'đ' );
							$xtpl->parse( 'main.product.one_price' );
						}
					}
				}
				}else{
				if ( $value_product['price_min'] == $value_product['price_max'] ) {
					$xtpl->assign( 'PRICE', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->parse( 'main.product.one_price' );
					} else {
					$xtpl->assign( 'PRICE_MIN', number_format( $value_product['price_min'] ).'đ' );
					$xtpl->assign( 'PRICE_MAX', number_format( $value_product['price_max'] ).'đ' );
					$xtpl->parse( 'main.product.min_max_price' );
				}
			}
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_product['image'] ;
			}
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			$xtpl->parse( 'main.product' );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	// xem thêm sản phẩm giá shock
	
	function nv_theme_more_product_shock ($list_block_product,$check_block_product,$list)
	{
		global $module_info, $lang_module, $lang_global, $op,$db,$module_name,$module_upload,$block_config;
		
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		
		
		
		foreach ($list as $key => $value_product) {
		
			$value_product['price'] = number_format( $value_product['price'] ).'đ';
			
			$value_product['alias'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $block_config['module'] . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $block_config['module']. '/' . $value_product['image'] ;
			}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $block_config['module']. 'retails/' . $value_product['image'] ;
			}
			//print_r('https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $block_config['module']. '/' . $value_product['image'] );die;
			
			
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			
			if($value_product['price_special'])
			{		
				$price_special = number_format( $value_product['price_special'] ).'đ';
				$xtpl->assign( 'price_special', $price_special);
				$xtpl->parse( 'main.product.price_special' );
			}
			
			if($value_product['free_ship'])
			{		
				$xtpl->parse( 'main.product.free_ship' );
				$xtpl->assign( 'BORDER', 'picture_frames1');
			}else{
				$xtpl->assign( 'BORDER', 'border');
			}
			
			//print_r(NV_BASE_SITEURL . NV_FILES_DIR . '/' . $block_config['module']. '/' . $value_product['image']);die;
			
			
			
			$xtpl->parse( 'main.product' );

		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	/**
		* nv_theme_retailshops_detail()
		*
		* @param mixed $array_data
		* @return
	*/
	
	function nv_theme_retailshops_detail( $array_data, $list_product_category,$list_product_store, $list_rate,$page_new,$per_page,$base_url,$num_items,$page,$info_store,$list_comment)
	{
		global $module_info, $lang_module, $lang_global, $op, $module_upload, $module_name, $db, $user_info, $db, $db_config;
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		$xtpl->assign( 'URL_SHARE', NV_MY_DOMAIN .'/'. $array_data['alias'] .'-'. $array_data['id']);  
		
		if($array_data['free_ship'])
			{		
				$xtpl->parse( 'main.free_ship' );
			}
		$xtpl->assign( 'info_store', $info_store );
		// đánh giá sản phẩm
		//print_r($list_rate);die;
		
		// tổng số nhận xét, đánh giá
		$xtpl->assign( 'total_rate', number_format(count($list_rate)) );
		
		// chi tiết số lượng đánh giá
		if(!empty($list_rate))
		{
			$array_star = array();
			
			foreach($list_rate as $rate)
			{
				$array_star[$rate['star']][] = $rate['id'];
			}
			
			// đếm
			foreach($array_star as $key=>$value)
			{
				$xtpl->assign( 'star_' . $key .'_pt', ((count($value)/count($list_rate))*100) );
				$xtpl->assign( 'star_' . $key , count($value) );
			}
		}
		
		
		$xtpl->assign( 'PRODUCT_ID', $array_data['id'] );
		
		$array_data['number_order']=number_format($array_data['number_order']);
		
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		$xtpl->assign( 'LINK_CART', NV_BASE_SITEURL . $module_name.'/cart/' );
		if (!empty($array_data['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $array_data['image'] )) {
			$array_data['image_upload']  = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $array_data['image'] ;
			
			$array_data['image_thumb']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $array_data['image'] ;
			}else{
			$server = 'banhang.'.$_SERVER["SERVER_NAME"];
			$array_data['image_upload']  ='https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $array_data['image'] ;
			
			$array_data['image_thumb']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $array_data['image'] ;
		}
		
		// hình ảnh chính sản phẩm
		$xtpl->assign( 'image_main_upload', $array_data['image_upload'] );
		$xtpl->assign( 'image_main_thumb', $array_data['image_thumb'] );
		
		//Kiểm tra sp có ảnh thuộc tính không
		if($array_data['image_classify']){
			foreach($array_data['image_classify'] as $item){
				if($item['image']){
					if (is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $first_image['image'] )) {
						$first_image['image_upload']  = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $item['image'] ;
						$first_image['image_thumb']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $item['image'] ;
						}else{
						$server = 'banhang.' . $_SERVER["SERVER_NAME"];
						$first_image['image_upload']  ='https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $item['image'] ;
						$first_image['image_thumb']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $item['image'] ;
					}	
					break;
				}
			}
			
		}
		
		if($first_image){
			$xtpl->assign('first_image', $first_image['image_upload']);
			} else{
			$xtpl->assign('first_image', $array_data['image_upload']);
		}
		
		// lấy danh sách hình ảnh theo thuộc tính
		if($array_data['image_classify'])
		{
			foreach($array_data['image_classify'] as $image_classify)
			{
				if(!empty($image_classify['image']))
				{
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$image_classify['upload']  ='https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $image_classify['image'] ;
					$image_classify['thumb']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $image_classify['image'] ;
					
					$xtpl->assign( 'image_classify', $image_classify);
					$xtpl->parse( 'main.image_classify' );
				}
			}
		}
		
		$data_array=array();
		$data_array1=array();
		$wishlist['check_wishlist'] = 0;
		if($user_info['userid']){
			$wishlist['check_wishlist'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE userid =".$user_info['userid']." AND product_id = " . $array_data['id']) -> fetchColumn();
		}
		
		$wishlist['like_number'] = $db->query("SELECT count(*) FROM " .TABLE."_wishlist WHERE product_id = " . $array_data['id']) -> fetchColumn();
		if($wishlist['check_wishlist'] == 0){
			$wishlist['color_wishlist'] = "white_wishlist";
			}else if($wishlist['check_wishlist']==1){
			$wishlist['color_wishlist'] = "red_wishlist";
			}else{
			$wishlist['color_wishlist'] = "white_wishlist";
		}
		$xtpl->assign('WISHLIST', $wishlist);
		
		$warehouse_id_first = get_info_warehouse_store( $array_data['store_id'] )['id'];
		if(empty($warehouse_id_first)){
			$warehouse_id_first=0;
		}
		
		$xtpl->assign('warehouse_id', $warehouse_id_first);
		
		foreach($array_data['classify'] as $key_classify=>$value){
			
			// gán cờ thuộc tính đầu tiên active
			$first = true;
			
			$xtpl->assign( 'LOOP_CLASSIFY', $value );
			$xtpl->assign( 'key', $key_classify+1 );
			foreach($value['list_classify_value'] as $key=>$classify_value){
				if($key_classify==0){
					$data_array[]=$classify_value['id'];
					$check_class1=get_info_classify_value_product_classify_id_value1($classify_value['id']);
					}else{
					$data_array1[]=$classify_value['id'];
					$check_class1=get_info_classify_value_product_classify_id_value2($classify_value['id']);
				}
				
				// thuộc tính đầu tiên
				if($first)
				{
					$classify_value['checked'] = 'checked=checked';
					$classify_value['active'] = 'classify_active';
				}
				
				$first = false;
				
				$xtpl->assign( 'LOOP_CLASSIFY_VALUE', $classify_value );
				$xtpl->parse( 'main.classify.classify_value' );
			}
			$xtpl->parse( 'main.classify' );
		}
		$data_array_full_product=array();
		foreach($data_array as $value){
			if(count($data_array1)>0){
				foreach($data_array1 as $value1){
					$data_array_full_product[]=array(
					'classify_id_value1'=>$value,
					'classify_id_value2'=>$value1
					);
				}
				}else{
				$data_array_full_product[]=array(
				'classify_id_value1'=>$value,
				'classify_id_value2'=>0
				);
			}
		}
		
		
		if(!empty($array_data['other_image']))
		{
			$array_data['other_image'] = explode( ',', $array_data['other_image'] );
			
			//print_r($array_data['other_image']);die;
			
			foreach ( $array_data['other_image'] as $value_image ) {
				
				$value = array();
				
				if (!empty($value_image ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_image)) {
					$value['upload']  = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $value_image;
					
					$value['thumb']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_image;
					}else{
					
					$server = 'banhang.'.$_SERVER["SERVER_NAME"];
					$value['upload']  ='https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $value_image ;
					
					$value['thumb']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $value_image ;
				}
				
				$xtpl->assign( 'value_image', $value );
				
				$xtpl->parse( 'main.other_image' );
			}
			
		}
		
		$array_data['price'] = $array_data['price'] ? $array_data['price'] : $array_data['price_special'];
		$array_data['price_format'] = number_format($array_data['price']);
		// print_r($array_data['price']);die;
		if($array_data['price_special'] and $array_data['price'] < $array_data['price_special'])
		{
			$price_special_format =number_format($array_data['price_special']);
			$xtpl->assign( 'price_special_format', $price_special_format );
			$xtpl->parse( 'main.price_special' );
		}
		
		$xtpl->assign( 'ROW', $array_data );
		
		
		// sản phẩm cùng danh mục
		if(!empty($list_product_category))
		{
			if(count($list_product_category) > 6)
			{
				$xtpl->parse( 'main.product_category.readmore' );
			}
			$product_category = viewgird_product($list_product_category);
			$xtpl->assign( 'product_category', $product_category );
			$xtpl->parse( 'main.product_category' );
		}
		
		// sản phẩm cùng cửa hàng
		
		if(!empty($list_product_store))
		{
			if(count($list_product_store) > 6)
			{
				$xtpl->parse( 'main.product_store.readmore' );
			}
			$product_store = viewgird_product($list_product_store);
			$xtpl->assign( 'product_store', $product_store );
			$xtpl->parse( 'main.product_store' );
		}
		
		// comment rate product
		$xtpl->assign( 'list_comment', $list_comment );
		
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	
	// comment rate product
	function comment_rate_product($product_id, $page=1)
	{
		global $module_info, $lang_module, $lang_global, $op, $db, $db_config;
		
		$xtpl = new XTemplate( 'comment_rate_product.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'TEMPLATE', $module_info['template'] );
		
		$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=rate_comment&product_id=' . $product_id;
		
		$per_page = 10;
		
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_rate t1')
		->join('INNER JOIN '. $db_config['prefix'] .'_users t2 ON t1.userid = t2.userid')
		->where('t1.product_id='. $product_id);
		
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('t1.product_id, t1.classify_value_product_id, t1.content, t1.star, t2.first_name, t2.last_name, t2.photo')
		->order($orderby_sql)
		->limit($per_page)
		->offset(($page - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		$sth->execute();
		
		
		if($num_items)
		{
			while( $comment = $sth->fetch() )
			{
				$comment['photo'] = (!empty($comment['photo']) and file_exists(NV_ROOTDIR . '/' . $comment['photo'])) ? NV_BASE_SITEURL . $comment['photo'] : NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/users/no_avatar.png';		
				
				$xtpl->assign( 'comment', $comment );
				
				if($comment['classify_value_product_id']>0){
					
					$classify_value_product_id=get_info_classify_value_product($comment['classify_value_product_id']);
					
					$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
					$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
					
					if($classify_value_product_id['classify_id_value2']>0){
						$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
						$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
						$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
						}else{
						$name_group=$name_classify_id_value1;
					}
					
					$name_group = $array_data['name_product'] .' ('.$name_group.')';
					
					$xtpl->assign( 'name_group', $name_group );
					
					$xtpl->parse( 'main.rate_comment.loop.name_group' );
				}
				
				$xtpl->parse( 'main.rate_comment.loop' );
			}
			$xtpl->parse( 'main.rate_comment' );
		}
		
		$generate_page = nv_generate_page_viewcat( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'conten_comment_rate' );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
		
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
		
	}
	
	/**
		* nv_theme_retailshops_search()
		*
		* @param mixed $array_data
		* @return
	*/
	
	function nv_theme_retailshops_search( $array_data,$title,$list_category1,$list_brand1,$list_origin1, $link_load,$keyword,$page,$star, $price_from, $price_to )
	{
		global $module_info, $lang_module, $lang_global, $op, $list_brand, $list_origin;
		
		$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'TITLE', $title );
		$xtpl->assign( 'LINKLOAD', $link_load );
		$xtpl->assign( 'PAGE', $page );
		$xtpl->assign( 'STAR', $star );
		$xtpl->assign( 'PRICE_FROM', $price_from );
		$xtpl->assign( 'PRICE_TO', $price_to );
		if($keyword){
			$xtpl->assign( 'KEYWORD', $keyword );
			$xtpl->parse( 'main.keyword' );
			$xtpl->parse( 'main.keyword1' );
		}
		
		if($star == 5){
			$star_5 = '<i class="fa fa-check" aria-hidden="true"></i>';
			$xtpl->assign( 'STAR_SELECTING_5', $star_5 );
			}else if($star == 4){
			$star_4 = '<i class="fa fa-check" aria-hidden="true"></i>';
			$xtpl->assign( 'STAR_SELECTING_4', $star_4 );
			}else if($star == 3){
			$star_3 = '<i class="fa fa-check" aria-hidden="true"></i>';
			$xtpl->assign( 'STAR_SELECTING_3', $star_3 );
			}else if($star == 2){
			$star_2 = '<i class="fa fa-check" aria-hidden="true"></i>';
			$xtpl->assign( 'STAR_SELECTING_2', $star_2 );
			}else if($star == 1){
			$star_1 = '<i class="fa fa-check" aria-hidden="true"></i>';
			$xtpl->assign( 'STAR_SELECTING_1', $star_1 );
			}else if($star == 0){
			$star_0 = '<i class="fa fa-check" aria-hidden="true"></i>';
			$xtpl->assign( 'STAR_SELECTING_0', $star_0 );
		}
		if($list_category1){
			foreach ($list_category1 as $key => $value) {
				$xtpl->assign( 'CATEGORY', $value );
				$xtpl->parse( 'main.category' );
			}
		}
		if($list_brand1){
			foreach ($list_brand1 as $key => $value) {
				$xtpl->assign( 'BRAND', $value );
				$xtpl->parse( 'main.brand' );
			}
		}
		
		// $row['origin'] = explode("|", $row['origin']);
		// foreach ($list_origin1 as $value_list) {
		// 	foreach ($row['origin'] as $value) {
		// 		if($value == $value_list['id']){
		// 			$value_list["selected"] = "selected";
		// 		}
		// 	}
		// 	$xtpl->assign( 'STATUS', $value_list);
		// 	$xtpl->parse( 'main.origin1' );
		// }
		if($list_origin1){
			foreach ($list_origin1 as $key => $value) {
				$xtpl->assign( 'ORIGIN', $value );
				$xtpl->parse( 'main.origin' );
			}
		}
		
		//------------------
		// Viết code vào đây
		//------------------
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
