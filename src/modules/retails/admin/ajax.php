<?php
	
	$mod = $nv_Request->get_string( 'mod', 'get,post', '' );
	
	if($mod=='plus_money'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
		$money = $nv_Request->get_int('money', 'get,post', 0);
		$store_id = $nv_Request->get_int('store_id', 'get,post', 0);
		$userid=get_info_shop($store_id)['userid'];
		require_once NV_ROOTDIR .'/modules/wallet/wallet.class.php';
		$wallet = new nukeviet_wallet();
		$checkUpdate1 = $wallet->init2($row['userid']);
		$message = 'Cộng tiền thanh toán đơn hàng với mã đơn hàng '.get_info_order($order_id)['order_code'];
		$checkUpdate = $wallet->update($money, 'VND',$userid,$admin_info['userid'],$message,  true);
		$db->query('UPDATE '.TABLE.'_order SET plus_money=1,status=5 where id='.$order_id);
		$content='Đơn hàng đã được thanh toán cho người bán';
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',3,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		$content_ip='Đơn hàng '.get_info_order($order_id)['order_code'].' đã được thanh toán cho người bán với số tiền '.number_format($money).' (đã trừ chiết khấu)';
		$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$admin_info['userid'].','.$store_id.','.$db->quote($content_ip).','.NV_CURRENTTIME.','.$order_id.',"plus_money")');
		print_r( json_encode( array('status'=>'OK','mess'=>'Cập nhật thành công' ) ));
		die();
	}
	if($mod=='update_number_product'){
		$amount = $nv_Request->get_int('amount', 'get,post', 0);
		$amount_delivery = $nv_Request->get_int('amount_delivery', 'get,post', 0);
		$product_id = $nv_Request->get_int('product_id', 'get,post', 0);
		$store_id = $nv_Request->get_int('store_id', 'get,post', 0);
		$db->query('UPDATE '.TABLE.'_inventory_product SET amount='.$amount.', amount_delivery='.$amount_delivery.' where id='.$product_id);
		print_r( json_encode( array('status'=>'OK','mess'=>'Cập nhật thành công' ) ));
		die();
	}
	if($mod=='update_number_product_full'){
		$list_product = json_decode(str_replace('&quot;','"',$nv_Request->get_string('list_product', 'get,post', 0)),true);
		$store_id = $nv_Request->get_int('store_id', 'get,post', 0);
		foreach($list_product as $value){
			$db->query('UPDATE '.TABLE.'_inventory_product SET amount='.$value['amount'].', amount_delivery='.$value['amount_delivery'].' where id='.$value['id']);
		}
		print_r( json_encode( array('status'=>'OK','mess'=>'Cập nhật thành công' ) ));
		die();
	}
	
	if($mod=='get_PickupType'){
		$q = $nv_Request->get_string('q', 'get,post', '');
		$list_service=array();
		$list_service[] = ['id'=>1, 'text'=>'Thu gom tận nơi'];
		$list_service[] = ['id'=>2, 'text'=>'Gửi hàng tại bưu cục'];
		foreach($list_service as $result){
			if($q!=''){
				if (stripos(strtoupper($result['text']), strtoupper($q)) !== false) {
					$json[] = ['id'=>$result['id'], 'text'=>$result['text']];
				}
				}else{
				$json[] = ['id'=>$result['id'], 'text'=>$result['text']];
			}
		}
		
		print_r(json_encode($json));die(); 
	}
	if($mod=='get_product_classify'){
		$q = $nv_Request->get_string('q', 'get,post', '');
		$list_product=get_full_product_classify_sellect2($q);
		$json=array();
		$json[] = ['id'=>0, 'text'=>'Chọn tất cả'];
		foreach($list_product as $result){
			$result['classify_id_value1_name']=get_info_classify_value($result['classify_id_value1'])['name'];
			if($result['classify_id_value2']>0){
				$result['classify_id_value2_name']=get_info_classify_value($result['classify_id_value2'])['name'];
				$name_group=$result['classify_id_value1_name'].', '.$result['classify_id_value2_name'];
				}else{
				$name_group=$result['classify_id_value1_name'];
			}
			$result['name_product']=$result['name_product'].' ('.$name_group.')';
			$json[] = ['id'=>$result['id'], 'text'=>$result['name_product']];
		}
		print_r(json_encode($json));die(); 
	}
	if($mod=='send_ahamove'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
		$info_order=get_info_order($order_id);
		$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
		$info_warehouse['address_full'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
		$info_order['address_full'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
		$path=array();
		
		if($info_order['payment_method']==0){
			$path[]=array(
			"lat" =>(float)$info_warehouse['lat'],
			"lng" =>(float)$info_warehouse['lng'],
			"address"=>urlencode($info_warehouse['address_full']),
			"short_address" => urlencode(get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title']),
			"name" =>urlencode($info_warehouse['name_send']),
			"mobile" =>$info_warehouse['phone_send'],
			"remarks" => urlencode("call me")
			);
			$path[]=array(
			"lat" =>(float)$info_order['lat'],
			"lng" =>(float)$info_order['lng'],
			"address"=>urlencode($info_order['address_full']),
			"short_address"=>urlencode(get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title']),
			"name"=>urlencode($info_order['order_name']),
			"mobile"=>$info_order['phone'],
			"remarks" => urlencode("call me"),
			"cod"=>$info_order['total']
			);
			}else{
			$path[]=array(
			"lat" =>(float)$info_warehouse['lat'],
			"lng" =>(float)$info_warehouse['lng'],
			"address"=>urlencode($info_warehouse['address_full']),
			"short_address" => urlencode(get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title']),
			"name" =>urlencode($info_warehouse['name_send']),
			"mobile" =>$info_warehouse['phone_send'],
			"remarks" => urlencode("call me"),
			"cod"=>0
			);
			$path[]=array(
			"lat" =>(float)$info_order['lat'],
			"lng" =>(float)$info_order['lng'],
			"address"=>urlencode($info_order['address_full']),
			"short_address"=>urlencode(get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title']),
			"name"=>urlencode($info_order['order_name']),
			"mobile"=>$info_order['phone'],
			"remarks" => urlencode("call me")
			);
		}
		$service_id=get_info_transporters($info_order['transporters_id'])['code_transporters'];
		if($info_order['payment_method']==0){
			$payment_method='CASH';
			}else{
			$payment_method='BALANCE';
		}
		
		
		
		$list_order=$db->query('SELECT t1.*, t2.name_product,t2.barcode FROM '.TABLE.'_order_item t1 INNER JOIN '.TABLE.'_product t2 ON t1.product_id=t2.id where order_id='.$order_id)->fetchAll(); 
		$list_item=array();
		
		
		
		foreach($list_order as $value){
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
				$value['name_product']=$value['name_product'].'('.$name_group.')';
			}
			$list_item[]=array(
			"_id" => $value['barcode'],
			"name" =>urlencode($value['name_product']),
			"num" => $value['quantity'],
			"price" => $value['price']
			);
		} 
		$order_ahamove=send_ahamove($path,$service_id,$list_item,$payment_method);
		
		
		if(!empty($order_ahamove['order_id'])){
			$db->query('UPDATE '.TABLE.'_order SET status=2, shipping_code='.$db->quote($order_ahamove['order_id']).',link_check_ahamove_order='.$db->quote($order_ahamove['shared_link']).' where id='.$order_id);
			$content='Chuyển sang đơn vị vận chuyển Ahamove Thành Công';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
			print_r( json_encode( array('status'=>'OK' ) ));
			die();
			}else{
			print_r( json_encode( array('status'=>'ERROR','mess'=>$order_ahamove['description'] ) ));
			die();
		}
	}
	if($mod=='send_ghn'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
		$store_id = $nv_Request->get_int('store_id', 'get,post', 0);
		$hinhthucthugom = $nv_Request->get_int('hinhthucthugom', 'get,post', 0);
		$khaigia = $nv_Request->get_int('khaigia', 'get,post', 0);
		
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		$info_order=get_info_order($order_id); 
		
		
		// sàn không cho xem hàng
		$required_note='KHONGCHOXEMHANG';
		
		//hình thức thu gom 
		//nếu có hình thức thu gom thì sẽ gán 1 mã bưu cục khi tạo đơn
		if($hinhthucthugom){
			$pick_station_id = 1444;
		}
		$cod_amount = 0;
		$payment_type_id = 1;
		// không khai giá
		if(!$khaigia){
			$info_order['total_product'] = 0;
		}
		$max = (int)$config_setting['max_price_ghn'];
		if($info_order['total_product'] >= $max){
			$info_order['total_product'] = $max ;
		}
		//giao lại phí ship khách chịu và thu cod nếu giao lại trên 2 lần
		
		if($info_order['status'] == 6){
			$info_order['warehouse_id'] = $config_setting['shop_id_ghn'];
			//phí ship khách chịu
			$payment_type_id = 2;
			//tính cod lần trước gửi không thành công
			if($info_order['shipping_code']){
				$cod_amount = $db->query('SELECT cod FROM ' . TABLE .'_history_ghn WHERE status = "return" AND order_code ="'. $info_order['shipping_code'] .'"')->fetchColumn();
				if(!$cod_amount){
					$cod_amount = 0;
				}
				$cod_amount = rounding($cod_amount);
			}
		}
		
		$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
		
		$ReceiverDistrictId=get_info_district($info_order['district_id'])['ghnid'];
		$ReceiverWardId=get_info_ward($info_order['ward_id'])['ghnid'];
		$PackageContent='Đơn hàng với mã đơn hàng '.$info_order['order_code'];
		$ServiceName=get_info_transporters($info_order['transporters_id'])['code_transporters'];
		$info_order['address'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
		$list_order=$db->query('SELECT t1.*, t2.name_product,t2.barcode FROM '.TABLE.'_order_item t1 INNER JOIN '.TABLE.'_product t2 ON t1.product_id=t2.id where order_id='.$order_id)->fetchAll();
		
		
		
		$list_item=array();
		foreach($list_order as $value){
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
				$value['name_product']=$value['name_product'].'('.$name_group.')';
			}
			$list_item[]=array(
			"name" =>$value['name_product'],
			"quantity" => (int)$value['quantity'],
			"code" => $value['barcode']
			);
		} 	
		
		$payment_method = $info_order['payment_method'];
		if($payment_method>0){
			$order_ghn = send_ghn($info_warehouse['shops_id_ghn'],$info_order['order_name'],$info_order['phone'],$info_order['address'],$ReceiverWardId,$ReceiverDistrictId,$PackageContent,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$info_order['total_product'],$ServiceName,$required_note,$list_item, $pick_station_id, $cod_amount, $payment_type_id);
			}else{
			$order_ghn = send_ghn($info_warehouse['shops_id_ghn'],$info_order['order_name'],$info_order['phone'],$info_order['address'],$ReceiverWardId,$ReceiverDistrictId,$PackageContent,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$info_order['total_product'],$ServiceName,$required_note,$list_item,$info_order['total'], $pick_station_id, $cod_amount, $payment_type_id);
		}
		
		
		if($order_ghn['code'] == 200){
			
			if(update_ghn_admin($info_order, $order_ghn))
			{
				$reason = $admin_info['username'] . ' đã gửi hàng GHN thành công' ;
				insert_history_admin($admin_info['userid'], $reason);
				print_r( json_encode( array('status'=>'OK' ) ));
				die();
			}
			}else{
			$reason = $admin_info['username'] . ' đã gửi hàng GHN thất bại' ;
			insert_history_admin($admin_info['userid'], $reason);
			update_ghn_error_admin($info_order, $order_ghn);
			print_r( json_encode( array('status'=>'ERROR') ));
			die();
		}
	}
	
	if($mod=='ghn_cancel'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
		$store_id = $nv_Request->get_int('store_id', 'get,post', 0);
		
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		$info_order=get_info_order($order_id); 
		
		// $info_order['status'] == 1 đơn hàng đã xác nhận 
		// $info_order['status_payment_vnpay'] == 1 đơn hàng đã thanh toán
		
		if( ($info_order['store_id'] != $store_id) or (!isset($store_id)) or ($info_order['status_payment_vnpay'] == 0) or ($info_order['status'] != 2) )
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		
		$shop_id = get_info_warehouse($info_order['warehouse_id'])['shops_id_ghn'];
		//print_r($info_order);die;
		$ghn_cancel = ghn_cancel($shop_id, $info_order['shipping_code'] );
		
		if($ghn_cancel['code'] == 200){
			$today = NV_CURRENTTIME;
			//cập nhật trạng thái hủy
			$db->query('UPDATE '. TABLE .'_history_ghn SET status = "cancel" WHERE order_id = ' . $info_order['id'] . ' AND order_code = "' . $info_order['shipping_code'] . '"');
			// lưu lại lịch sử vận đơn
			$db->query('INSERT INTO '. TABLE .'_history_ghn_detail (order_id, order_code_ghn, status, time_add) VALUES('. $info_order['id'] .', "'. $info_order['shipping_code'] .'", "cancel", '. $today .')');
			
			// cập nhật trạng thái đơn hàng
			$db->query('UPDATE '. TABLE .'_order SET status = 1, time_edit = ' . $today . ' WHERE id = '. $info_order['id']);
			//ghi lịch sử 
			$content = $admin_info['username'] . ' đã hủy đơn GHN' ;
			history_order($info_order['id'], 1, $content);
			$reason = $admin_info['username'] . ' đã hủy đơn GHN' ;
			insert_history_admin($admin_info['userid'], $reason);
			
			print_r( json_encode( array('status'=>'OK' ) ));
			die();
			
			}else{
			print_r( json_encode( array('status'=>'ERROR') ));
			die();
		}
		
	}
	
	
	
	
	if($mod=='check_khaigia_ghn'){
		
		$order_id = $nv_Request->get_int('order_id', 'get,post', '');
		$store_id = $nv_Request->get_int('store_id', 'get,post', '');
		//print_r($store_id);die;
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		$info_order = get_info_order($order_id); 
		
		if( ($info_order['store_id'] != $store_id) or (!isset($store_id)) or ($info_order['status_payment_vnpay'] == 0) )
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		
		
		
		$ward_id_ghn_receive = get_info_ward( $info_order['ward_id'] )['ghnid'];
		$district_id_ghn_receive = get_info_district( $info_order['district_id'] )['ghnid'];
		$info_warehouse = get_info_warehouse_store( $info_order['store_id'] );
		
		$province_id_ghn_send = get_info_province( $info_warehouse['province_id'] )['ghnid'];
		$district_id_ghn_send = get_info_district( $info_warehouse['district_id'] )['ghnid'];
		$shop_id = $info_warehouse['shops_id_ghn'];
		
		if($info_order['status'] == 6){
			$info_warehouse_ecng = get_info_warehouse( $config_setting['shop_id_ghn'] );
			$province_id_ghn_ecng = get_info_province( $config_setting['province_ecng'] )['ghnid'];
			$district_id_ghn_ecng = get_info_district( $config_setting['district_ecng'] )['ghnid'];
			
			$shop_ecng = $info_warehouse_ecng['shops_id_ghn'];
			
			$free_ship = get_price_ghn_2( 2, $shop_ecng, $district_id_ghn_receive, $ward_id_ghn_receive, $info_order['total_height'], $info_order['total_length'], $info_order['total_weight'], $info_order['total_width'], 0,$district_id_ghn_ecng );
		}
		if(!$free_ship['data']['total']){
				$free_ship['data']['total'] = 0;
			}
		$max = (int)$config_setting['max_price_ghn'];
		if($info_order['total_product'] >= $max){
			$info_order['total_product'] = $max ;
		}
		
		$fee = get_price_ghn_2( 2, $shop_id, $district_id_ghn_receive, $ward_id_ghn_receive, $info_order['total_height'], $info_order['total_length'], $info_order['total_weight'], $info_order['total_width'], $info_order['total_product'],$district_id_ghn_send );
		
		$free_ship['data']['total'] = rounding($free_ship['data']['total']);
		
		print_r( json_encode(array('insurance_fee'=>$fee['data']['insurance_fee'], 'ship'=>$free_ship['data']['total']) ) );
		die;
	}
	
	
	if($mod=='send_ghtk'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
		$info_order=get_info_order($order_id);
		$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
		$list_order=$db->query('SELECT t1.*, t2.name_product FROM '.TABLE.'_order_item t1 INNER JOIN '.TABLE.'_product t2 ON t1.product_id=t2.id where order_id='.$order_id)->fetchAll(); 
		$list_item=array();
		foreach($list_order as $value){
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
				$value['name_product']=$value['name_product'].'('.$name_group.')';
			}
			$check=get_info_product_ghtk($value['name_product']);
			if(count($check['data'])>0){
				$list_item[]=array(
				"name" =>$value['name_product'],
				"price" => $value['price'],
				"weight" => $value['weight']/1000,
				"quantity" => $value['quantity'],
				"product_code" => $check['data'][0]['product_code']
				);
				}else{
				$list_item[]=array(
				"name" =>$value['name_product'],
				"price" => $value['price'],
				"weight" => $value['weight']/1000,
				"quantity" => $value['quantity'],
				"product_code" => ""
				);
			}
		} 
		$payment_method = $info_order['payment_method'];
		$ServiceName=get_info_transporters($info_order['transporters_id'])['code_transporters'];
		if($payment_method>0){
			if($ServiceName==1){
				$order_ghtk=send_ghtk($list_item,$info_order['order_code'],$info_warehouse['name_send'],$info_warehouse['address'],get_info_province( $info_warehouse['province_id'] )['title'],get_info_district( $info_warehouse['district_id'] )['title'],get_info_ward( $info_warehouse['ward_id'] )['title'],$info_warehouse['phone_send'],$info_order['phone'],$info_order['order_name'],$info_order['address'],get_info_province( $info_order['province_id'] )['title'],get_info_district( $info_order['district_id'] )['title'],get_info_ward( $info_order['ward_id'] )['title'],0,$info_order['total'],'road','');
				}else if($ServiceName==2){
				$order_ghtk=send_ghtk($list_item,$info_order['order_code'],$info_warehouse['name_send'],$info_warehouse['address'],get_info_province( $info_warehouse['province_id'] )['title'],get_info_district( $info_warehouse['district_id'] )['title'],get_info_ward( $info_warehouse['ward_id'] )['title'],$info_warehouse['phone_send'],$info_order['phone'],$info_order['order_name'],$info_order['address'],get_info_province( $info_order['province_id'] )['title'],get_info_district( $info_order['district_id'] )['title'],get_info_ward( $info_order['ward_id'] )['title'],0,$info_order['total'],'fly','');
				}else if($ServiceName==3){
				$order_ghtk=send_ghtk($list_item,$info_order['order_code'],$info_warehouse['name_send'],$info_warehouse['address'],get_info_province( $info_warehouse['province_id'] )['title'],get_info_district( $info_warehouse['district_id'] )['title'],get_info_ward( $info_warehouse['ward_id'] )['title'],$info_warehouse['phone_send'],$info_order['phone'],$info_order['order_name'],$info_order['address'],get_info_province( $info_order['province_id'] )['title'],get_info_district( $info_order['district_id'] )['title'],get_info_ward( $info_order['ward_id'] )['title'],0,$info_order['total'],'','xteam');
			}
			}else{
			if($ServiceName==1){
				$order_ghtk=send_ghtk($list_item,$info_order['order_code'],$info_warehouse['name_send'],$info_warehouse['address'],get_info_province( $info_warehouse['province_id'] )['title'],get_info_district( $info_warehouse['district_id'] )['title'],get_info_ward( $info_warehouse['ward_id'] )['title'],$info_warehouse['phone_send'],$info_order['phone'],$info_order['order_name'],$info_order['address'],get_info_province( $info_order['province_id'] )['title'],get_info_district( $info_order['district_id'] )['title'],get_info_ward( $info_order['ward_id'] )['title'],$info_order['total'],$info_order['total'],'road','');
				}else if($ServiceName==2){
				$order_ghtk=send_ghtk($list_item,$info_order['order_code'],$info_warehouse['name_send'],$info_warehouse['address'],get_info_province( $info_warehouse['province_id'] )['title'],get_info_district( $info_warehouse['district_id'] )['title'],get_info_ward( $info_warehouse['ward_id'] )['title'],$info_warehouse['phone_send'],$info_order['phone'],$info_order['order_name'],$info_order['address'],get_info_province( $info_order['province_id'] )['title'],get_info_district( $info_order['district_id'] )['title'],get_info_ward( $info_order['ward_id'] )['title'],$info_order['total'],$info_order['total'],'fly','');
				}else if($ServiceName==3){
				$order_ghtk=send_ghtk($list_item,$info_order['order_code'],$info_warehouse['name_send'],$info_warehouse['address'],get_info_province( $info_warehouse['province_id'] )['title'],get_info_district( $info_warehouse['district_id'] )['title'],get_info_ward( $info_warehouse['ward_id'] )['title'],$info_warehouse['phone_send'],$info_order['phone'],$info_order['order_name'],$info_order['address'],get_info_province( $info_order['province_id'] )['title'],get_info_district( $info_order['district_id'] )['title'],get_info_ward( $info_order['ward_id'] )['title'],$info_order['total'],$info_order['total'],'','xteam');
			}
		}
		$db->query('UPDATE '.TABLE.'_order SET status=2, shipping_code='.$db->quote($order_ghtk['order']['label']).' where id='.$order_id);
		$content='Chuyển sang đơn vị vận chuyển GHTK Thành Công';
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	if($mod=='send_viettelpost'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
		$info_order=get_info_order($order_id); 
		$ServiceName=get_info_transporters($info_order['transporters_id'])['code_transporters'];
		$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
		$info_warehouse['address'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
		$SenderProvinceId=get_info_province($info_warehouse['province_id'])['vtpid'];
		$SenderDistrictId=get_info_district($info_warehouse['district_id'])['vtpid'];
		$SenderWardId=get_info_ward($info_warehouse['ward_id'])['vtpid'];
		$ReceiverProvinceId=get_info_province($info_order['province_id'])['vtpid'];
		$ReceiverDistrictId=get_info_district($info_order['district_id'])['vtpid'];
		$ReceiverWardId=get_info_ward($info_order['ward_id'])['vtpid'];
		$info_order['address'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
		$PackageContent='Đơn hàng với mã đơn hàng '.$info_order['order_code'];
		$PRODUCT_QUANTITY=$db->query('SELECT count(*) FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchColumn(); 
		$list_order=$db->query('SELECT t1.*, t2.name_product FROM '.TABLE.'_order_item t1 INNER JOIN '.TABLE.'_product t2 ON t1.product_id=t2.id where order_id='.$order_id)->fetchAll(); 
		$list_item=array();
		foreach($list_order as $value){
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
				$value['name_product']=$value['name_product'].'('.$name_group.')';
			}
			$list_item[]=array(
			"PRODUCT_NAME" =>$value['name_product'],
			"PRODUCT_PRICE" => $value['price'],
			"PRODUCT_WEIGHT" => $value['weight'],
			"PRODUCT_QUANTITY" => $value['quantity']
			);
		}
		$payment_method=$info_order['payment_method'];
		if($payment_method>0){
			$order_viettelpost=send_viettelpost($info_order['total'],0,'',$ServiceName,$SenderProvinceId,$SenderDistrictId,$SenderWardId,$info_warehouse['lat'],$info_warehouse['lng'],$ReceiverProvinceId,$ReceiverDistrictId,"HH",$info_order['order_code'],$info_warehouse['groupaddressid'],$info_warehouse['cusid'],$info_warehouse['name_send'],$info_warehouse['address'],str_replace("-","",$info_warehouse['phone_send']),$info_order['order_name'],$info_order['address'],$info_order['phone'],$PackageContent,$PackageContent,$PRODUCT_QUANTITY,3,$list_item,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$ReceiverWardId,$info_order['lat'],$info_order['lng']);
			}else{
			$order_viettelpost=send_viettelpost($info_order['total'],$info_order['total'],'',$ServiceName,$SenderProvinceId,$SenderDistrictId,$SenderWardId,$info_warehouse['lat'],$info_warehouse['lng'],$ReceiverProvinceId,$ReceiverDistrictId,"HH",$info_order['order_code'],$info_warehouse['groupaddressid'],$info_warehouse['cusid'],$info_warehouse['name_send'],$info_warehouse['address'],str_replace("-","",$info_warehouse['phone_send']),$info_order['order_name'],$info_order['address'],$info_order['phone'],$PackageContent,$PackageContent,$PRODUCT_QUANTITY,3,$list_item,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$ReceiverWardId,$info_order['lat'],$info_order['lng']);
		}
		$db->query('UPDATE '.TABLE.'_order SET status=2, shipping_code='.$db->quote($order_viettelpost['data']['ORDER_NUMBER']).' where id='.$order_id);
		$content='Chuyển sang đơn vị vận chuyển Viettel Post Thành Công';
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	if($mod=='send_vnpost'){
		
		
		$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		
		$info_order=get_info_order($order_id); 
		
		// $info_order['status'] == 1 đơn hàng đã xác nhận 
		// $info_order['status_payment_vnpay'] == 1 đơn hàng đã thanh toán
		
		if( ($info_order['status_payment_vnpay'] == 0) or ($info_order['status'] != 1 and $info_order['status'] != 6) )
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		
		$order_code = $info_order['order_code'] . '-' . NV_CURRENTTIME;
		
		
		$IsPackageViewable = 0;
		$PickupType = 1;
		$PickupPoscode = 0;
		$CodAmountEvaluation = 0;
		
		
		$ServiceName=get_info_transporters($info_order['transporters_id'])['code_transporters'];
		$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
		$info_warehouse['address'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
		
		// lên lại vận đơn khi giao hàng thất bại sẽ lấy thông tin gửi là ECNG
		
		if($info_order['status'] == 6)
		{
			$info_warehouse['province_id'] = $config_setting['province_ecng'];
			$info_warehouse['district_id'] = $config_setting['district_ecng'];
			$info_warehouse['ward_id'] = $config_setting['ward_ecng'];
			$info_warehouse['address'] = $config_setting['address_ecng'];
			$info_warehouse['name_send'] = $global_config['site_name'];
			$info_warehouse['phone_send'] = $global_config['site_phone'];
			
		}
		
		
		$SenderProvinceId=get_info_province($info_warehouse['province_id'])['vnpostid'];
		$SenderDistrictId=get_info_district($info_warehouse['district_id'])['vnpostid'];
		$SenderWardId=get_info_ward($info_warehouse['ward_id'])['vnpostid'];
		$ReceiverProvinceId=get_info_province($info_order['province_id'])['vnpostid'];
		$ReceiverDistrictId=get_info_district($info_order['district_id'])['vnpostid'];
		$ReceiverWardId=get_info_ward($info_order['ward_id'])['vnpostid'];
		$PackageContent='Đơn hàng với mã đơn hàng '.$info_order['order_code'] ;
		$info_order['address'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
		$payment_method=get_info_order($order_id)['payment_method'];
		
		
		if($info_order['transporters_id']==5){
			$weight_quydoi=($info_order['total_length']*$info_order['total_width']*$info_order['total_height'])/5000;
			}else{
			$weight_quydoi=($info_order['total_length']*$info_order['total_width']*$info_order['total_height'])/6000;
		}
		if($info_order['total_weight']<=($weight_quydoi*1000)){
			$weight_quydoi2=($weight_quydoi*1000);
			}else{
			$weight_quydoi2=$info_order['total_weight'];
		}
		
		
		if($info_order['status'] == 6)
		{
			// phí ship khách hàng chịu
			$IsReceiverPayFreight = true; 
			
			$total_code_old = 0;
			
			if($info_order['shipping_code'])
			$total_code_old = $db->query('SELECT cod FROM ' . TABLE .'_history_vnpos WHERE (vnpost_status = 91 OR vnpost_status = 161) AND item_code ="'. $info_order['shipping_code'] .'"')->fetchColumn();
			
			if(!$total_code_old)
			$total_code_old = 0;
			
			// làm tròn
			if($total_code_old)
			{
				$mod = $total_code_old%1000;
				if($mod>0){
					$thuong = ceil($total_code_old / 1000);
					$total_code_old = $thuong*1000;
				}
				
				$CodAmountEvaluation = $total_code_old;
			}
			
		}
		
		
		if($payment_method>0){
			// đã thanh toán đơn hàng
			$order_vnpost=send_vnpost($order_code, $PackageContent,$ServiceName, $info_warehouse['name_send'], $info_warehouse['address'], $info_warehouse['phone_send'],$SenderProvinceId,$SenderDistrictId, $SenderWardId, $info_order['order_name'], $info_order['address'], $info_order['phone'], $ReceiverProvinceId, $ReceiverDistrictId,$ReceiverWardId,$CodAmountEvaluation,$PickupPoscode,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$info_order['total_product'],$IsReceiverPayFreight);
			}else{
			// chưa thanh toán đơn hàng
			$order_vnpost=send_vnpost($order_code, $PackageContent,$ServiceName, $info_warehouse['name_send'], $info_warehouse['address'], $info_warehouse['phone_send'],$SenderProvinceId,$SenderDistrictId, $SenderWardId, $info_order['order_name'], $info_order['address'], $info_order['phone'], $ReceiverProvinceId, $ReceiverDistrictId,$ReceiverWardId,$info_order['total'],$PickupPoscode,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$info_order['total_product'],$IsReceiverPayFreight);
		}
		
		
		
		if(!empty($order_vnpost['ItemCode']))
		{
			
			if(update_vnpost($info_order, $order_vnpost))
			{
				print_r( json_encode( array('status'=>'OK' ) ));
				die();
			}
			
		}
		
		print_r( json_encode( array('status'=>'ERROR' ) ));
		die();
		
		
		
	}
	
	if($mod=='shipping'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', '');
		
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		$info_order = get_info_order($order_id); 
		
		// $info_order['status'] == 1 đơn hàng đã xác nhận 
		// $info_order['status_payment_vnpay'] == 1 đơn hàng đã thanh toán
		
		$content = $admin_info['last_name'] . ' đã cập nhật trạng thái đang giao hàng!';
		
		// xử lý thông tin sau khi tạo vận đơn thành công status=2 đơn hàng đang giao
		$db->query('UPDATE '. TABLE .'_order SET status = 2 where id = '. $info_order['id']);
		
		$db->query('INSERT INTO '. TABLE .'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $info_order['id'] .', 1, ' . $db->quote($content).','.NV_CURRENTTIME.',' . $admin_info['userid'].')');
		
		// gửi thông báo cho quản trị
		$content_ip = $admin_info['last_name'] . ' đã cập nhật trạng thái đang giao hàng, mã đơn hàng '. $info_order['order_code'] ;
		nv_insert_notification_ecng($admin_info['userid'], $info_order['store_id'], $content_ip, $info_order['id'], 'order');
		//ghi lịch sử admin
	
		$reason = $admin_info['username'] . ' đã cập nhật trạng thái đang giao hàng - ' . $info_order['order_code'];
		insert_history_admin($admin_info['userid'], $reason);
		
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	
	if($mod=='delivered'){
		$order_id = $nv_Request->get_int('order_id', 'get,post', '');
		
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		$info_order = get_info_order($order_id); 
		
		// $info_order['status'] == 1 đơn hàng đã xác nhận 
		// $info_order['status_payment_vnpay'] == 1 đơn hàng đã thanh toán
		
		$content = $admin_info['last_name'] . ' đã cập nhật trạng thái đã giao hàng thành công!';
		
		
		$db->query('UPDATE '. TABLE .'_order SET status = 3 where id = '. $info_order['id']);
		
		$db->query('INSERT INTO '. TABLE .'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $info_order['id'] .', 2, ' . $db->quote($content).','.NV_CURRENTTIME.',' . $admin_info['userid'].')');
		
		// gửi thông báo cho quản trị
		
		$content_ip = $admin_info['last_name'] . ' đã cập nhật trạng thái đã giao hàng thành công, mã đơn hàng '. $info_order['order_code'] ;
		nv_insert_notification_ecng($admin_info['userid'], $info_order['store_id'], $content_ip, $info_order['id'], 'order');
		//ghi lịch sử admin
	
		$reason = $admin_info['username'] . ' đã cập nhật trạng thái giao hàng thành công - ' . $info_order['order_code'];
		insert_history_admin($admin_info['userid'], $reason);
		
		send_mail_order_delivered($info_order);
		
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	
	if($mod=='get_buucuc'){
		$q = $nv_Request->get_string('q', 'get,post', '');
		$warehouse_id = $nv_Request->get_int('warehouse_id', 'get,post', 0);
		$province_id_send = get_info_warehouse($warehouse_id)['province_id'];
		$district_id_send = get_info_warehouse($warehouse_id)['district_id'];
		$list_buucuc=GetListBuuCucByXaHuyenTinh($province_id_send,$district_id_send);
		foreach($list_buucuc as $result){
			$result['name']=$result['TenBuuCuc']. ' - Địa chỉ: '.$result['DiaChi'];
			if($q!=''){
				if (stripos(strtoupper($result['name']), strtoupper($q)) !== false) {
					$json[] = ['id'=>$result['MaBuuCuc'], 'text'=>$result['name']];
				}
				}else{
				$json[] = ['id'=>$result['MaBuuCuc'], 'text'=>$result['name']];
			}
		}
		
		print_r(json_encode($json));die(); 
	}
	
	if($mod == 'order_hoantien')
	{
		$order_id = $nv_Request->get_title( 'order_id', 'post,get' );
		
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR','mess'=>'Đơn hàng không tồn tại' ) ));
			die();
		}
		
		// lấy thông tin đơn hàng
		$info_order = get_info_order($order_id);
		
		if(!$info_order['payment'] or !$info_order['status_payment_vnpay'])
		{
			print_r( json_encode( array('status'=>'ERROR','mess'=>'Đơn hàng chưa thanh toán' ) ));
			die();
		}
		
		// xử lý cập nhật trạng thái đơn hàng. status = 5
		$db->query('UPDATE '. TABLE .'_order SET status=5 where id='.$order_id);
		// hoàn trả tiền vnpay
		vnpay_refund($info_order);
		// ghi lại lịch sử
		$content = 'Hoàn tiền đơn hàng';
		history_order($order_id, 5,$content);
		$reason = $admin_info['username'] . ' đã hoàn tiền đơn hàng - ' . $info_order['order_code'] ;
		insert_history_admin($admin_info['userid'], $reason);
		print_r( json_encode( array('status'=>'OK','mess'=>'Hoàn tiền đơn hàng thành công' ) ));
		die();
		
	}
	
	if($mod=='change_status_cancel'){
		$order_id = $nv_Request->get_title( 'order_id', 'post,get' );
		$content = $nv_Request->get_title( 'content', 'post,get','' );
		
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		// xử lý thông tin đơn hàng hủy
		
		// cập nhật trạng thái đơn hàng = 4
		$db->query('UPDATE '. TABLE .'_order SET status = 4 where id='.$order_id);
		
		// trả hàng về kho, cập nhật kho
		$list_product = $db->query('SELECT * FROM '. TABLE .'_order_item where order_id='. $order_id)->fetchAll();
		
		foreach($list_product as $product)
		{
			$where = '';
			
			if($product['classify_value_product_id'])
			{
				$where .= ' AND id=' . $product['classify_value_product_id'];
			}
			
			$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET sl_tonkho = sl_tonkho + '. $product['quantity'] .' WHERE product_id =' . $product['product_id'] . $where);
		}
		
		$info_order = get_info_order($order_id);
		
		// kiểm tra hủy đơn vị vận chuyển nếu có shipping_code
		if($info_order['shipping_code'] and ($info_order['transporters_id'] == 4 or $info_order['transporters_id'] == 4))
		{
			// hủy đơn vận chuyển
			// lấy thông tin id_vnpost vnpost để hủy vận chuyển
			$id_vnpost = $db->query('SELECT id_vnpost FROM '. TABLE .'_history_vnpos WHERE item_code ="' . $info_order['shipping_code'] .'"' )->fetchColumn();
			
			$order_vnpost = cancel_tranpost_vnpost($id_vnpost);
			
		}
		elseif($info_order['shipping_code'] and $info_order['transporters_id'] == 3)
		{
			$shop_id = get_info_warehouse($info_order['warehouse_id'])['shops_id_ghn'];
			
			$ghn_cancel = ghn_cancel($shop_id, $info_order['shipping_code'] );
			
			if($ghn_cancel['code'] == 200){
				$today = NV_CURRENTTIME;
				//cập nhật trạng thái hủy
				$db->query('UPDATE '. TABLE .'_history_ghn SET status = "cancel" WHERE order_id = ' . $info_order['id'] . ' AND order_code = "' . $info_order['shipping_code'] . '"');
				// lưu lại lịch sử vận đơn
				$db->query('INSERT INTO '. TABLE .'_history_ghn_detail (order_id, order_code_ghn, status, time_add) VALUES('. $info_order['id'] .', "'. $info_order['shipping_code'] .'", "cancel", '. $today .')');
			}
		}
		
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',6,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		
		$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ' đã bị hủy với lý do ' . $content;
		
		nv_insert_notification_user($admin_info['userid'], $info_order['userid'], $content_ip, $order_id, "order");
		
		nv_insert_notification_shop($admin_info['userid'], $info_order['store_id'], $content_ip, $order_id, "order");
		$info_order['lydohuy'] = $content;
		send_email_order_cancel($info_order);
		
		$reason = $admin_info['username'] . ' đã hủy đơn hàng ' . $info_order['order_code'] ;
		insert_history_admin($admin_info['userid'], $reason);
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	
	if($mod=='change_status_cancel_tranpost_ahamove'){
		$order_id = $nv_Request->get_title( 'order_id', 'post,get' );
		$payment_method=get_info_order($order_id)['payment_method'];
		$content = $nv_Request->get_title( 'content', 'post,get','' );
		$warehouse_id=$db->query('SELECT warehouse_id FROM '.TABLE.'_order where id='.$order_id)->fetchColumn();
		$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchAll();
		$status_new = $nv_Request->get_int( 'status_new', 'post,get' );
		$status_old = $nv_Request->get_int( 'status_old', 'post,get' );
		$shipping_code=get_info_order($order_id)['shipping_code'];
		$check=cancel_tranpost_ahamove($shipping_code,$content);
		$db->query('UPDATE '.TABLE.'_order SET status='.$status_new.' where id='.$order_id);
		if($payment_method==1){
			require_once NV_ROOTDIR .'/modules/wallet/wallet.class.php';
			$wallet = new nukeviet_wallet();
			$checkUpdate1 = $wallet->init2($row['userid']);
			$message = 'Cộng tiền đơn hàng hủy với mã đơn hàng '.get_info_order($order_id)['order_code'];
			$checkUpdate = $wallet->update(get_info_order($order_id)['total'], 'VND',get_info_order($order_id)['userid'],$admin_info['userid'], $message,  true);
		}
		$info_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id = ' . $order_id)->fetch();
		
		foreach($list_product as $value){
			$amount_delivery_old=$db->query('SELECT amount_delivery FROM '.TABLE.'_inventory_product where warehouse_id='.$warehouse_id.' and product_id='.$value['product_id'].' and classify_value_product_id='.$value['classify_value_product_id'])->fetchColumn();
			$amount_old=$db->query('SELECT amount FROM '.TABLE.'_inventory_product where warehouse_id='.$warehouse_id.' and product_id='.$value['product_id'].' and classify_value_product_id='.$value['classify_value_product_id'])->fetchColumn();
			$amount_delivery_new = $amount_delivery_old - $value['quantity'];
			$amount_new = $amount_old + $value['quantity'];
			$db->query('UPDATE '.TABLE.'_inventory_product SET amount_delivery='.$amount_delivery_new.',amount='.$amount_new.' where warehouse_id='.$warehouse_id.' and product_id='.$value['product_id'].' and classify_value_product_id='.$value['classify_value_product_id']);
		}
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.','.$status_old.','.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		
		$content_ip= 'Đơn hàng '. $info_order['order_code'] .' của bạn đã bị hủy';
		
		$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_user(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$admin_info['admin_id'].',' . $info_order['userid'] .','.$db->quote($content_ip).','.NV_CURRENTTIME.',' . $info_order['userid'] . ',"order")');
		
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	
	
	// xử lý hủy đơn hàng vnpost vnpost_cancel
	if($mod=='vnpost_cancel'){
		$order_id = $nv_Request->get_int( 'order_id', 'post,get' );
		
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR','mess' => 'Đơn hàng không tồn tại') ));
			die();
		}
		
		// lấy thông tin đơn hàng ra
		$info_order=get_info_order($order_id); 
		
		if(!$info_order['id'])
		{
			print_r( json_encode( array('status'=>'ERROR','mess' => 'Đơn hàng không được quyền hủy vận chuyển VNPOST!') ));
			die();
		}
		else
		{
			// lấy thông tin id_vnpost vnpost để hủy vận chuyển
			$id_vnpost = $db->query('SELECT id_vnpost FROM '. TABLE .'_history_vnpos WHERE item_code ="' . $info_order['shipping_code'] .'"' )->fetchColumn();
			
			if(!$id_vnpost)
			{
				print_r( json_encode( array('status'=>'ERROR','mess' => 'Mã vận đơn không tồn tại!') ));
				die();
			}
		}
		
		
		
		$order_vnpost = cancel_tranpost_vnpost($id_vnpost);
		
		
		if(isset($order_vnpost['Id']) and $order_vnpost['Id'])
		{
			
			// khi hủy đơn hàng. sẽ được vnpost tự động cập nhật trạng thái đơn hàng, vận đơn cho hệ thống rồi
			// hủy đơn hàng vnpost thành công, cập nhật lại dữ liệu
			if(update_huy_vnpost($info_order))
			{
				print_r( json_encode( array('status'=>'OK','mess' => 'Hủy đơn hàng vận chuyển VNPOST thành công!') ));
				die();
			}
			
		}
		print_r( json_encode( array('status'=>'ERROR','mess' => 'Không xác định!') ));
		die();
		
	}
	
	if($mod=='change_status_success'){
		$order_id = $nv_Request->get_title( 'order_id', 'post,get' );
		$warehouse_id=$db->query('SELECT warehouse_id FROM '.TABLE.'_order where id='.$order_id)->fetchColumn();
		$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchAll();
		$status_new = $nv_Request->get_int( 'status_new', 'post,get' );
		$status_old = $nv_Request->get_int( 'status_old', 'post,get' );
		$db->query('UPDATE '.TABLE.'_order SET status='.$status_new.' where id='.$order_id);
		$content='Đơn hàng chuyển sang trạng thái thành công';
		$info_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id = ' . $order_id)->fetch();
		foreach($list_product as $value){
			$amount_delivery_old=$db->query('SELECT amount_delivery FROM '.TABLE.'_inventory_product where warehouse_id='.$warehouse_id.' and product_id='.$value['product_id'].' and classify_value_product_id='.$value['classify_value_product_id'])->fetchColumn();
			$amount_delivery_new=$amount_delivery_old-$value['quantity'];
			$db->query('UPDATE '.TABLE.'_inventory_product SET amount_delivery='.$amount_delivery_new.' where warehouse_id='.$warehouse_id.' and product_id='.$value['product_id'].' and classify_value_product_id='.$value['classify_value_product_id']);
			$number_order_old=$db->query('SELECT number_order FROM '.TABLE.'_product where id='.$value['product_id'])->fetchColumn();
			$number_order_new = $number_order_old+$value['quantity'];
			$db->query('UPDATE '.TABLE.'_product SET number_order='.$number_order_new.' where id='.$value['product_id']);
		}
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.','.$status_old.','.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		$content_ip= 'Đơn hàng '. $info_order['order_code'] .' của bạn đã được giao thành công';
		
		$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_user(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$admin_info['admin_id'].',' . $info_order['userid'] .','.$db->quote($content_ip).','.NV_CURRENTTIME.',' . $info_order['userid'] . ',"order")');
		$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$admin_info['admin_id'].',' . $info_order['store_id'] .','.$db->quote($content_ip).','.NV_CURRENTTIME.',' . $info_order['store_id'] . ',"order")');
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	if($mod=='change_status'){
		$order_id = $nv_Request->get_title( 'order_id', 'post,get' );
		$status_new = $nv_Request->get_int( 'status_new', 'post,get' );
		$status_old = $nv_Request->get_int( 'status_old', 'post,get' );
		$info_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE payment != 0 AND id = ' . $order_id)->fetch();
		
		if(!$info_order)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		
		$db->query('UPDATE '.TABLE.'_order SET status='.$status_new.' where id='.$order_id);
		if($status_new==1){
			$content='Đơn hàng chuyển sang trạng thái đã xác nhận';
		}
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.','.$status_new.','.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		$content_ip= 'Đơn hàng '. $info_order['order_code'] .' của bạn đã được xác nhận';
		
		nv_insert_notification_shop($admin_info['userid'], $info_order['store_id'], $content_ip, $order_id, "order");
		
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
	}
	if($mod=='load_order'){
		$where = '';
		$q = $nv_Request->get_title( 'q', 'post,get' );
		$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
		$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
		$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
		$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -2 );
		$store_id = $nv_Request->get_int( 'store_id', 'post,get', 0 );
		$_SESSION[$module_data.'_status_view_order']=$status_ft;
		$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'post,get', 0 );
		$customer_id = $nv_Request->get_int( 'customer_id', 'post,get', 0 );
		$categories_id = $nv_Request->get_int( 'categories_id', 'post,get', 0 );
		$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op.'&mod=load_order';
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
				
				$where .= ' AND t1.time_add >= '. $ngay_tu . ' AND t1.time_add <= '. $ngay_den;
				$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
			} else if ( $ngay_tu > 0 )
			{
				$where .= ' AND t1.time_add >= '. $ngay_tu;
				$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
			} else if ( $ngay_den > 0 )
			{
				$where .= ' AND t1.time_add <= '. $ngay_den;
				$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
			}
			
		}
		if ( $status_ft>-2 ) {
			$where .= ' AND t1.status ='.$status_ft;
			$base_url .= '&status_search=' . $status_ft;
			}else{
			$where .= ' ';
			$base_url .= '&status_search = ""';
		}
		if ( !empty( $q ) ) {
			$where .= ' AND (t1.order_code LIKE "%" "'.$q. '" "%")';
			$base_url .= '&q=' . $q;
		}
		if($store_id>0){
			$where .= ' AND t1.store_id ='.$store_id;
			$base_url .= '&store_id=' . $store_id;
		}
		if($warehouse_id>0){
			$where .= ' AND t1.warehouse_id ='.$warehouse_id;
			$base_url .= '&warehouse_id=' . $warehouse_id;
		}
		if($customer_id>0){
			$where .= ' AND t1.userid ='.$customer_id;
			$base_url .= '&customer_id=' . $customer_id;
		}
		if($categories_id>0){
			$where .= ' AND t2.product_id IN (SELECT id FROM '.TABLE.'_product where categories_id='.$categories_id.')';
			$base_url .= '&categories_id=' . $categories_id;
		}
		
		$per_page = 10;
		$page = $nv_Request->get_int('page', 'post,get', 1);
		$db->sqlreset()
		->select('COUNT(DISTINCT t1.id)')
		->from('' . TABLE . '_order t1')
		->join('INNER JOIN ' . TABLE . '_order_item t2 ON t2.order_id=t1.id')
		->where('1=1'.$where);
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('t1.*')
		->order('t1.time_add DESC')
		->limit($per_page)
		->offset(($page - 1) * $per_page)
		->where('1=1'.$where.' group by t1.id');
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$xtpl = new XTemplate('order_ajax.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
		$xtpl->assign('Q', $q);
		$xtpl->assign('warehouse_id', $warehouse_id);
		$xtpl->assign('store_id', $store_id);
		
		if($store_id>0){
			if($warehouse_id>0){
				$xtpl->assign('warehouse_name', get_info_warehouse($warehouse_id)['name_warehouse']);
				}else{
				$xtpl->assign('warehouse_name', 'Chọn tất cả');
			}
			$xtpl->parse('main.store_edit');
			
		}
		if ( $ngay_tu > 0 )
		$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
		if ( $ngay_den > 0 )
		$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
		
		$generate_page = nv_generate_page_viewcat($base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'form');
		if (!empty($generate_page)) {
			$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
			$xtpl->parse('main.generate_page');
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
		
		while ($view = $sth->fetch()) {
			
			$view['number'] = $number++;
			$view['store_name']=get_info_store($view['store_id'])['company_name'];
			$view['warehouse_name']=get_info_warehouse($view['warehouse_id'])['name_warehouse'];
			$view['phone_warehouse']=get_info_warehouse($view['warehouse_id'])['phone_send'];
			$info_warehouse = get_info_warehouse( $view['warehouse_id'] );
			$view['address_warehouse'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
			$view['address_receive'] = $view['address'].', '.get_info_ward( $view['ward_id'] )['title'].', '.get_info_district( $view['district_id'] )['title'].', '.get_info_province( $view['province_id'] )['title'];
			$view['transporters_name']=get_info_transporters($view['transporters_id'])['name_transporters'];
			$view['total_product2']=$view['total_product'];
			$view['total_product']=number_format($view['total_product']);
			$view['fee_transport']=number_format($view['fee_transport']);
			$view['total']=number_format($view['total']);
			
			$view['payment_tam'] = $view['payment'];
			$view['payment']=number_format($view['payment']);
			
			$view['time_add']=date('d-m-Y H:i',$view['time_add']);
			if($view['payment_method']==0){
				$view['payment_method']='Thanh toán khi nhận hàng';
				}elseif($view['payment_method']==1){
				$view['payment_method']='Thanh toán qua ví tiền';
				}elseif($view['payment_method']==2) {
				$view['payment_method']='Thanh toán qua VNPAY';
			}
			$view['link_view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view_order&amp;id=' . $view['id'];
			
			$view['link_phat'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=order_punish&amp;order_id=' . $view['id'];
			
			if($view['status_payment_vnpay'])
			{
				$view['thanhtoan'] = $lang_module['da_thanhtoan'];
			}
			else
			{
				$view['thanhtoan'] = $lang_module['chua_thanhtoan'];
			}
			
			$xtpl->assign('VIEW', $view);
			if($view['status']==0){
				$xtpl->parse('main.loop.status0');
				}else if($view['status']==1){
				if($view['transporters_id'] == 4 || $view['transporters_id'] == 5 ){
					$xtpl->parse('main.loop.vnpost');
					}elseif($view['transporters_id'] == 0){
					$xtpl->parse('main.loop.tu_giao_xac_nhan_dang_giao');
					}elseif($view['transporters_id'] == 3){
					$xtpl->parse('main.loop.ghn');
				}
				
				}else if($view['status']==2){
				// trạng thái đơn hàng đang giao. cho phép admin hủy đơn hàng
				if($view['transporters_id'] == 4 || $view['transporters_id'] == 5 ){
					$xtpl->parse('main.loop.vnpost_cancel');
					}elseif($view['transporters_id']== 0){
					$xtpl->parse('main.loop.tu_giao_xac_nhan_da_giao');
				}elseif($view['transporters_id'] == 3)
				{
					$check_status_ghn = $db->query('SELECT status FROM ' . TABLE . '_history_ghn WHERE message like "Success" AND order_id = ' . $view['id'] . ' AND order_code = "' . $view['shipping_code'] . '"')->fetchColumn();
					if($check_status_ghn == 'ready_to_pick' || $check_status_ghn == 'picking'){
						$xtpl->parse('main.loop.ghn_cancel');
					}
				}
				//status = 6
				}else if($view['status']==6){
				// trạng thái đơn hàng đang giao. cho phép admin hủy đơn hàng
				if($view['transporters_id'] == 4 || $view['transporters_id'] == 5 ){
					$xtpl->parse('main.loop.vnpost_reupload');
				}elseif($view['transporters_id'] == 3){
					$xtpl->parse('main.loop.ghn');
				}					
			} 
			
			if($view['status'] == 1 or $view['status'] == 6){
				// đơn hàng được quyền hủy status = 0 - 6
				$xtpl->parse('main.loop.status_cancel');
			}
			
			// hủy đơn nếu đã thanh toán thì hiển thị chức năng hoàn tiền đơn hàng
			if($view['status'] == 4 and $view['status_payment_vnpay'] and $view['payment_tam'])
			{
				$xtpl->parse('main.loop.hoantien');
			}
			
			// status = 4 đơn hàng hủy
			if($view['shipping_code'] and $view['status'] > 1 and $view['status'] != 4)
			{
				// in phiếu vận chuyển
				$xtpl->parse('main.loop.print_shipping_code');
			}
			
			$xtpl->parse('main.loop');
		}
		$xtpl->parse('main');
		$contents = $xtpl->text('main');
		
		$page_title = $lang_module['order'];
		echo $contents;die;
		
	}
	
	if ( $mod == 'get_province' ) {
		$q = $nv_Request->get_string( 'q', 'post', '' );
		$list_location = get_province_select2( $q );
		foreach ( $list_location as $result ) {
			$json[] = ['id'=>$result['provinceid'], 'text'=>$result['title']];
		}
		print_r( json_encode( $json ) );
		die();
		
	}
	if ( $mod == 'load_warehouse' ) {
		$sell_id = $nv_Request->get_int( 'sell_id', 'get', 0 );
		$per_page = 10;
		$page = $nv_Request->get_int( 'page', 'post,get', 1 );
		$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . TABLE . '_warehouse' )
		->where( 'sell_id='.$sell_id );
		$sth = $db->prepare( $db->sql() );
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select( '*' )
		->order( 'id ASC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
		$sth = $db->prepare( $db->sql() );
		
		$sth ->execute();
		
		$xtpl = new XTemplate( 'warehouse_seller_management_ajax.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
		$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
		$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
		$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
		$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op.'&mod=load_warehouse&sell_id='.$sell_id;
		
		$generate_page_warehouse = nv_generate_page( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'form_detail_'.$sell_id );
		if ( !empty( $generate_page ) ) {
			$xtpl->assign( 'NV_GENERATE_PAGE_WAREHOUSE', $generate_page_warehouse );
			$xtpl->parse( 'main.loop.generate_page_warehouse' );
		}
		$number = $page > 1 ? ( $per_page * ( $page - 1 ) ) + 1 : 1;
		while ( $view = $sth->fetch() ) {
			$view['address_full']=$view['address'];
			$xtpl->assign( 'LOOP', $view );
			$xtpl->parse( 'main.loop' );
		}
		
		$xtpl->parse( 'main' );
		$contents = $xtpl->text( 'main' );
		
		echo $contents;
	}
	if ( $mod == 'get_bank_search' ) {
		$q = $nv_Request->get_string( 'q', 'post', '' );
		$list_location = get_bank_select2( $q );
		$json[] = ['id'=>0, 'text'=>'Chọn tất cả'];
		foreach ( $list_location as $result ) {
			$json[] = ['id'=>$result['bank_id'], 'text'=>$result['bank_code'].' - '.$result['name_bank']];
		}
		print_r( json_encode( $json ) );
		die();
		
	}
	if ( $mod == 'get_district' ) {
		$q = $nv_Request->get_string( 'q', 'post', '' );
		$provinceid = $nv_Request->get_string( 'provinceid', 'post', '' );
		$list_location = get_district_select2( $q, $provinceid );
		foreach ( $list_location as $result ) {
			$json[] = ['id'=>$result['districtid'], 'text'=>$result['title']];
		}
		print_r( json_encode( $json ) );
		die();
		
	}
	if ( $mod == 'get_ward' ) {
		$q = $nv_Request->get_string( 'q', 'post', '' );
		$districtid = $nv_Request->get_string( 'districtid', 'post', '' );
		$list_location = get_ward_select2( $q, $districtid );
		foreach ( $list_location as $result ) {
			$json[] = ['id'=>$result['wardid'], 'text'=>$result['title']];
		}
		print_r( json_encode( $json ) );
		die();
		
	}
	if ( $mod == 'get_branch' ) {
		$q = $nv_Request->get_string( 'q', 'post', '' );
		$bank_id = $nv_Request->get_string( 'bank_id', 'post', '' );
		$list_location = get_branch_select2( $q, $bank_id );
		foreach ( $list_location as $result ) {
			$json[] = ['id'=>$result['branch_id'], 'text'=>$result['name_branch']];
		}
		print_r( json_encode( $json ) );
		die();
		
	}
	
	if ( $mod == 'inhome' ) {
		$id = $nv_Request->get_int( 'id', 'post', '' );
		$new_vid = $nv_Request->get_int( 'new_vid', 'post', '' );
		$db->query( 'UPDATE ' .TABLE . '_categories SET inhome='.$new_vid.'  ,time_edit='.NV_CURRENTTIME.', user_edit='.$admin_info['userid'].' where id='.$id );
		print_r( json_encode( array('status'=>'OK') ) );
		die();
		
	}
	if ( $mod == 'viewcat' ) {
		$id = $nv_Request->get_int( 'id', 'post', '' );
		$new_vid = $nv_Request->get_int( 'new_vid', 'post', '' );
		$db->query( 'UPDATE ' .TABLE . '_categories SET viewcat='.$new_vid.'  ,time_edit='.NV_CURRENTTIME.', user_edit='.$admin_info['userid'].' where id='.$id );
		print_r( json_encode( array('status'=>'OK') ) );
		die();
		
	}
	if ( $mod == 'numlinks' ) {
		$id = $nv_Request->get_int( 'id', 'post', '' );
		$new_vid = $nv_Request->get_int( 'new_vid', 'post', '' );
		$db->query( 'UPDATE ' .TABLE . '_categories SET numlinks='.$new_vid.'  ,time_edit='.NV_CURRENTTIME.', user_edit='.$admin_info['userid'].' where id='.$id );
		print_r( json_encode( array('status'=>'OK') ) );
		die();
		
	}		
	
	
	// khu vực dưới là test
	
	if($mod == 'test_admin')
	{
		//send_mail_payment_fail(626);
		//xulythanhtoanthanhcong(630, '');
		//$order = get_info_order(647);
		//send_email_order_cancel($order);
		//update_time_add_order(643);
		//send_mail_order_delivered($order);
		//update_time_edit_order(643);
		
		//$a = get_info_store($order['store_id'])['email'];
		$max = (int)$config_setting['max_price_ghn'];
		
		$a = var_dump($max);
		print_r($a);die;
		
	}
