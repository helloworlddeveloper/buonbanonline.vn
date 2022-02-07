<?php
	
	/**
		* @Project TMS Holdings
		* @Author TMS Holdings <contact@tms.vn>
		* @Copyright (C) 2020 TMS Holdings. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Mon, 21 Dec 2020 09:48:26 GMT
	*/


	
	/*

// tool đồng bộ thêm đơn vị vận chuyển GHTK cho tất cả cửa hàng tự động bật
	$list_store = $db->query('SELECT id FROM ' . TABLE .'_seller_management')->fetchAll();
	
	$arr = array();
	
	foreach($list_store as $store)
	{
	// kiểm tra ghn có trong cấu hình cửa hàng này không
	$check_ghn = $db->query('SELECT id, sell_id FROM ' . TABLE .'_transporters_shop WHERE sell_id = '. $store['id'] .' AND transporters_id = 2' )->fetch();
	
	
	if(!$check_ghn)
	{
	$arr[] = $store;
	
	// thêm vào
	$db->query('INSERT INTO ' . TABLE . '_transporters_shop(sell_id,transporters_id,status) VALUES('. $store['id'] .',2,1)');
	
	}
	}
	
	print_r($arr);die;

	// xử lý xã phường, bỏ text số
	$list_ward = $db->query('SELECT wardid, title, type, alias FROM tms_location_ward WHERE alias like"%so-%"')->fetchAll();
	foreach($list_ward as $ward)
	{
		// xử lý lại title
		$ward['title_new'] = str_replace("Số ","",$ward['title']);
		// cập nhật
		$db->query('UPDATE tms_location_ward SET title ="'. $ward['title_new'] .'" WHERE wardid =' . $ward['wardid']);
		
	} 
	print_r(ok);die;
	
	
	// tạo ECNG 
	$list_product = $db->query('SELECT id, name_product, keyword FROM '. TABLE .'_product ORDER BY id ASC')->fetchAll();
	
	foreach($list_product as $product)
	{
		$product['name_product'] = trim(preg_replace("/\s+/"," ", $product['name_product']));
		$product['keyword'] = trim(preg_replace("/\s+/"," ", $product['keyword']));
		
		$db->query('UPDATE '. TABLE .'_product SET name_product ="'. $product['name_product'] .'", keyword ="'. $product['keyword'] .'" WHERE id =' . $product['id']);
	}
	
	die(ok);
	
	
		
		// tạo ID GHN tự động cho tất cả kho
		
		// lấy danh sách kho hàng
		
		$list_detail = $db->query('SELECT * FROM ' . TABLE .'_warehouse WHERE shops_id_ghn = 0')->fetchAll();
		
		
		
	$arr = array();
	
	foreach($list_detail as $value)
	{
	$shops_id_ghn_data = create_store_ghn(get_info_district($value['district_id'])['ghnid'],get_info_ward($value['ward_id'])['ghnid'],$value['name_send'],$value['phone_send'],$value['address']);
	
	$shops_id_ghn = $shops_id_ghn_data['data']['shop_id'];
	
	if($shops_id_ghn)
	{
	$arr[] = $shops_id_ghn_data;
	$db->query('UPDATE ' . TABLE . '_warehouse SET shops_id_ghn='.$db->quote($shops_id_ghn).' where id='.$value['id']);
	}
	}
	
	print_r($arr);die(ok);
	
	
	
	
	/*
	
	// tool đồng bộ thêm đơn vị vận chuyển GHN cho tất cả cửa hàng tự động bật
	$list_store = $db->query('SELECT id FROM ' . TABLE .'_seller_management')->fetchAll();
	
	$arr = array();
	
	foreach($list_store as $store)
	{
	// kiểm tra ghn có trong cấu hình cửa hàng này không
	$check_ghn = $db->query('SELECT id, sell_id FROM ' . TABLE .'_transporters_shop WHERE sell_id = '. $store['id'] .' AND transporters_id = 3' )->fetch();
	
	
	if(!$check_ghn)
	{
	$arr[] = $store;
	
	// thêm vào
	$db->query('INSERT INTO ' . TABLE . '_transporters_shop(sell_id,transporters_id,status) VALUES('. $store['id'] .',3,1)');
	
	}
	}
	
	print_r($arr);die;
	
	/*
	
	
	
	/*
	
	// đồng bộ hóa dữ liệu thuộc tính, sản phẩm tồn kho _product_classify_value_product
	
	$list_detail = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value_product WHERE classify_id_value1 = 0 AND classify_id_value2 = 0')->fetchAll();
	
	$arr = array();
	
	foreach($list_detail as $product)
	{
	// đếm có bao nhiêu dong
	$count = $db->query('SELECT count(id) as count FROM ' . TABLE .'_product_classify_value_product WHERE product_id ='. $product['product_id'])->fetchColumn();
	
	if($count > 1)
	{
	$arr[] = $product;
	}
	}
	
	print_r($arr);die;
	
	
	/*
	
	// xử lý hoàn trả tiền đơn hàng vnpay
	$id = 560;
	$order = get_info_order($id);
	// lấy thông tin thanh toán
	$history_vnpay = $db->query('SELECT * FROM ' . TABLE .'_history_vnpay WHERE vnp_transactionno = '. $order['vnpay_code'])->fetch();
	
	
	$amount = ($history_vnpay["price"]) * 100;
	$ipaddr = $_SERVER['REMOTE_ADDR'];
	$inputData = array(
	"vnp_Version" => '2.0.0',
	"vnp_TransactionType" => '02',
	"vnp_Command" => "refund",
	"vnp_CreateBy" => $history_vnpay["name_register"],
	"vnp_TmnCode" => $config_setting['website_code_vnpay1'],
	"vnp_TxnRef" => $id,
	"vnp_Amount" => $amount,
	"vnp_OrderInfo" => 'Hoan tien don hang',
	"vnp_TransDate" => $history_vnpay["vnp_paydate"],
	"vnp_CreateDate" => date('YmdHis'),
	"vnp_IpAddr" => $ipaddr
	);
	ksort($inputData);
	$query = "";
	$i = 0;
	$hashdata = "";
	foreach ($inputData as $key => $value) {
	if ($i == 1) {
	$hashdata .= '&' . $key . "=" . $value;
	} else {
	$hashdata .= $key . "=" . $value;
	$i = 1;
	}
	$query .= urlencode($key) . "=" . urlencode($value) . '&';
	}
	
	$vnp_apiUrl = 'https://merchant.vnpay.vn/merchant_webapi/merchant.html' . "?" . $query;
	if (isset($config_setting['checksum_vnpay'])) {
	$vnpSecureHash = hash('sha256', $config_setting['checksum_vnpay'].$hashdata);
	$vnp_apiUrl .= 'vnp_SecureHash=' . $vnpSecureHash;
	}
	
	//print_r($inputData);die;
	
	$ch = curl_init($vnp_apiUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$data = curl_exec($ch);
	curl_close($ch);
	
	
	$inputData = array();
	
	$array = explode('&',$data);
	
	
	
	foreach($array as $item)
	{
	$arr = explode('=',$item);
	$inputData[$arr[0]] = $arr[1];
	
	}
	
	print_r($inputData);die;
	
	die(ggggggg);
	
	
	// testttt
	
	
	// vnp_TransactionType = 2 hoàn trả tiền hoàn toàn, 1 hoàn trả 1 phần
	
	$amount = ($history_vnpay["price"]) * 100;
	$ipaddr = $_SERVER['REMOTE_ADDR'];
	$inputData = array(
	"vnp_Version" => '2.0.0',
	"vnp_TransactionType" => 2,
	"vnp_Command" => "refund",
	"vnp_CreateBy" => $history_vnpay["email_register"],
	"vnp_TmnCode" => $config_setting['website_code_vnpay'],
	"vnp_TxnRef" => $history_vnpay["vnp_txnref"],
	"vnp_Amount" => $amount,
	"vnp_OrderInfo" => 'Hoan tien don hang',
	"vnp_TransDate" => $history_vnpay["vnp_paydate"],
	"vnp_CreateDate" => date('YmdHis'),
	"vnp_IpAddr" => $ipaddr
	);
	ksort($inputData);
	$query = "";
	$i = 0;
	$hashdata = "";
	foreach ($inputData as $key => $value) {
	if ($i == 1) {
	$hashData = $hashData . '&' . $key . "=" . $value;
	} else {
	$hashData = $hashData . $key . "=" . $value;
	$i = 1;
	}
	$query .= urlencode($key) . "=" . urlencode($value) . '&';
	}
	
	$vnp_apiUrl = 'https://merchant.vnpay.vn/merchant_webapi/merchant.html' . "?" . $query;
	
	print_r($vnp_apiUrl);die;
	
	if (isset($config_setting['checksum_vnpay']))
	{
	$vnpSecureHash = hash('sha256', $config_setting['checksum_vnpay'] . $hashdata);
	$vnp_apiUrl .= 'vnp_SecureHash=' . $vnpSecureHash;
	}
	
	
	
	
	
	
	
	print_r($vnp_apiUrl);die;
	
	$ch = curl_init($vnp_apiUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$data = curl_exec($ch);
	curl_close($ch);
	echo $data;
	
	die(gggg);
	
	/*
	// đồng bộ 1 tk ít nhât 1 địa chỉ mặc định
	$list_user = $db->query('SELECT * FROM ' . TABLE .  '_address GROUP BY userid')->fetchAll();
	
	$update_len = array();
	$update_xun = array();
	
	foreach($list_user as $user)
	{
	// kiểm tra thông tin địa chỉ
	// lấy danh sách địa chỉ mặc định
	$count = $db->query('SELECT COUNT(*) as count FROM ' . TABLE .  '_address WHERE userid ='. $user['userid'] .' AND status = 1')->fetchColumn();
	
	
	if( $count == 0)
	{
	// cập nhật 1 đối tượng lên mặc định
	$db->query('UPDATE '. TABLE .'_address SET status = 1 WHERE id ='. $user['id']);
	$update_len[] = $user;
	}
	elseif($count > 1)
	{
	// cập nhật phần tử đầu tiên status về 0;
	$db->query('UPDATE '. TABLE .'_address SET status = 0 WHERE id ='. $user['id']);
	$update_xun[] = $user;
	}
	}
	
	print_r($update_len);
	print_r($update_xun);
	die;
	*/
	
	/*
		
		// xem chi tiết nội dung gửi email cho người bán
		// xử lý thanh toán vnpay thành công
		$order_text = 520;
		$inputData = array();
		function xulythanhtoanthanhcong_test($order_text, $inputData)
		{
		global $db, $db_config, $user_info, $module_name, $lang_module;
		
		$list_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id IN(' . $order_text . ')')->fetchAll();
		
		// cập nhật kho hàng sau khi thanh toán thành công
		foreach ($list_order as $order)
		{
		
		// lấy danh sách sản phẩm của đơn hàng
		$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
		
		
		// gửi thông báo email về cho khách hàng, cửa hàng
		
		
		$config_form_khach = $db->query('SELECT config_value FROM ' . TABLE . '_config WHERE config_name = "form_email_khach"')
		->fetchColumn();
		$config_form_nha_ban = $db->query('SELECT config_value FROM ' . TABLE . '_config WHERE config_name = "form_email_nha_ban"')
		->fetchColumn();
		
		$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
		
		// Gui mail thong bao den khach hang
		$data_order['id'] = $order['id'];
		$info_order = $order;
		$data_order['order_code'] = $order['order_code'];
		$info_shop = $db->query('SELECT * FROM ' . TABLE . '_seller_management WHERE id = ' . $order['store_id'])->fetch();
		
		$email_title = $lang_module['order_email_title'];
		$email_contents = call_user_func('email_new_order_payment_khach', $data_order, $list_product, $info_order, $config_form_khach, $info_shop);
		
		
		
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , $order['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		
		// Gui mail thong bao den nhà bán hàng
		$email_contents = call_user_func('email_new_order_payment', $data_order, $list_product, $info_order, $config_form_nha_ban, $info_shop);
		$email_title = $lang_module['order_email_title'];
		
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , 'vohoatoi147@gmail.com', sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		}
		
		return true;
		}
		
		xulythanhtoanthanhcong_test($order_text, $inputData);
		
		die(ffffff);
		
		
		
		
		
		
		
		function vn_to_str($str){
		
		$unicode = array(
		
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		
		'd'=>'đ',
		
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		
		'i'=>'í|ì|ỉ|ĩ|ị',
		
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		
		'D'=>'Đ',
		
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
		
		);
		
		foreach($unicode as $nonUnicode=>$uni){
		
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
		
		}
		
		return $str;
		
		}
		
		// cập nhật keyword cho tất cả sản phẩm
		$list_product = $db->query('SELECT id, name_product FROM '. TABLE .'_product ORDER BY id ASC')->fetchAll();
		
		foreach($list_product as $product)
		{
		$keyword = vn_to_str($product['name_product']);
		
		$db->query('UPDATE '. TABLE .'_product SET keyword ="'. $keyword .'" WHERE id =' . $product['id']);
		
		}
		
		
		/*
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_POSTFIELDS =>'{"district_id":3233}',
		CURLOPT_HTTPHEADER => array(
		'token: cbbabf40-8dd4-11eb-9035-ae038bcc764b',
		'Content-Type: application/json'
		),
		));
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		
		$data = json_decode($response, true);
		
		
		foreach($data['data'] as $row ){
		
		$check = $db->query('SELECT COUNT(wardid) FROM ' . NV_TABLE_WARD . ' WHERE ghnid =  ' . $row['WardCode'])->fetchColumn();
		if(!$check)
		{
		$aee = array();
		$aee['DistrictID'] = $row['DistrictID'];
		$aee['WardName'] = $row['WardName'];
		$aee['WardCode'] = $row['WardCode'];
		$array[] = $aee;
		}
		}
		
		print_r($array);die;
		
		
		
		
		/*
		
		
		
		// Cập nhật store_code 
		$seller_management = $db->query('SELECT id, company_code FROM ' . TABLE .'_seller_management')->fetchAll();
		foreach($seller_management as $seller)
		{
		
		$db->query('UPDATE ' . TABLE .'_seller_management SET store_code ="'. $seller['company_code'] .'" WHERE id ='. $seller['id']);
		}
		
		
		
		
		// làm sạch dữ liệu đặt hàng
		$db->query('DELETE FROM '. TABLE .'_order');
		$db->query('DELETE FROM '. TABLE .'_order_item');
		$db->query('DELETE FROM '. TABLE .'_order_voucher');
		$db->query('DELETE FROM '. TABLE .'_logs_order');
		$db->query('DELETE FROM '. TABLE .'_history_vnpay');
		$db->query('DELETE FROM '. TABLE .'_history_vnpos');
		
		
		
		
		// cập nhật chữ cái đầu viết hoa cho thuộc tính
		$list_product_classify_value = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value WHERE id = 355')->fetchAll();
		foreach($list_product_classify_value as $classify_value)
		{
		$classify_value['name'] = 'đỏ';  
		$name = Strtoupper($classify_value['name']);
		print_r($name);die;
		$db->query('UPDATE ' . TABLE .'_product_classify_value SET name ="'. $name .'" WHERE id ='. $classify_value['id']);
		}
		
		die(ok_chu);
		
		
		// cập nhật chữ cái đầu viết hoa cho thuộc tính
		$list_product_classify = $db->query('SELECT * FROM ' . TABLE .'_product_classify')->fetchAll();
		foreach($list_product_classify as $classify)
		{
		$name_classify = ucwords($classify['name_classify']);
		
		$db->query('UPDATE ' . TABLE .'_product_classify SET name_classify ="'. $name_classify .'" WHERE id ='. $classify['id']);
		}
		
		
		
		
		// cập nhật sell_id thành sell_userid warehouse
		$list_warehouse = $db->query('SELECT * FROM ' . TABLE .'_warehouse')->fetchAll();
		
		foreach($list_warehouse as $warehouse)
		{
		$sell_userid = $db->query('SELECT userid FROM ' . TABLE .'_seller_management WHERE id ='. $warehouse['sell_id'])->fetchColumn();
		
		// cập nhật
		$db->query('UPDATE ' . TABLE .'_warehouse SET sell_userid ='. $sell_userid .' WHERE id ='. $warehouse['id']);
		}
		
		die(ok);
		
		
		
		
		// chuyên mục không tồn tại
		
		$list_cat = array();
		
		$list_categories = $db->query('SELECT * FROM ' . TABLE .'_categories WHERE parrent_id > 0')->fetchAll();
		
		foreach($list_categories as $categories)
		{
		// kiểm tra chuyên mục cha có tồn tại hay không
		$check = $db->query('SELECT * FROM ' . TABLE .'_categories WHERE id ='. $categories['parrent_id'])->fetchColumn();
		
		if(!$check)
		{
		$list_cat[] = $categories['id'];
		
		$db->query('DELETE FROM ' . TABLE .'_categories WHERE id ='. $categories['id']);
		}
		}
		
		print_r($list_cat);die;
		
		
		
		$list_detail = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value_product')->fetchAll();
		
		foreach($list_detail as $product)
		{
		// lấy 2 thuộc tính
		$count = $db->query('SELECT count(*) as count FROM ' . TABLE .'_product_classify WHERE product_id =' . $product['product_id'])->fetchColumn();
		
		if($count == 0)
		{
		if(!$product['classify_id_value1'] and !$product['classify_id_value2'])
		{
		// xóa
		//$db->query('DELETE FROM ' . TABLE .'_product_classify_value_product WHERE id ='. $product['id']);
		}
		else
		{
		// sai
		print_r($product);die;
		}
		}
		}
		
		
		//
		
		
		
		$db->query("CREATE TABLE " . TABLE . "_order_voucher(
		id_voucher int(11) NOT NULL AUTO_INCREMENT,
		order_id int(11) NOT NULL,
		userid int(11) NOT NULL,
		time_use int(11) NOT NULL COMMENT 'Thời gian sử dụng',
		discount_price double NOT NULL COMMENT 'Số tiền giảm',
		time_add int(11) NULL COMMENT 'Thời gian thêm',
		status int(11) NULL,
		PRIMARY KEY (id_voucher)
		) ENGINE=MyISAM");
	*/
	
	/*
		
		$count = 0;
		// cập nhật company_name seller cho user
		$list_seller = $db->query('SELECT userid, company_name FROM '. TABLE .'_seller_management');
		
		foreach($list_seller as $seller)
		{ 
		// cập nhật thông tin
		$db->query('UPDATE '. NV_TABLE_USER .' SET last_name='.$db->quote($seller['company_name']).' where userid='.$seller['userid']);
		
		$count++;
		
		}
		
		print_r($count);die;
		
		
		
		// cập nhật kho cho sản phẩm không có thuộc tính
		
		$count = 0;
		
		
		$list_product_classify_value_product = $db->query('SELECT id, price, price_special, warehouse FROM '. TABLE .'_product');
		
		foreach($list_product_classify_value_product as $product)
		{
		
		// kiểm tra kho tồn tại chưa
		$product_classify = $db->query('SELECT * FROM ' . TABLE .'_product_classify WHERE product_id =' . $product['id'])->fetchAll();
		
		
		if(!$product_classify)
		{
		$check_store = $db->query('SELECT count(*) as count FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1 = 0 AND classify_id_value2 = 0 AND product_id =' . $product['id'])->fetchColumn();
		
		if(!$check_store)
		{
		
		$sql3 = 'INSERT INTO ' . TABLE . '_product_classify_value_product (product_id,classify_id_value1,classify_id_value2,price,price_special,sl_tonkho,status) VALUES (:product_id,:classify_id_value1,:classify_id_value2,:price,:price_special,:sl_tonkho,:status)';
		$data_insert2 = array();
		$data_insert2['product_id'] = $product['id'];
		$data_insert2['classify_id_value1'] = 0;
		$data_insert2['classify_id_value2'] = 0;
		$data_insert2['price'] = $product['price'];
		$data_insert2['price_special'] = $product['price_special'];
		$data_insert2['sl_tonkho']= $product['warehouse'];
		$data_insert2['status'] = 1;
		
		$db->insert_id($sql3, 'id', $data_insert2);
		}
		else
		{
		// cập nhật kho
		$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET price='.$product['price'].',price_special="'.$product['price_special'].'",sl_tonkho='.$product['warehouse'].',status=1 WHERE classify_id_value1=0 AND classify_id_value2=0 AND product_id ='. $product['id']);
		}
		
		$count++;
		}
		
		}
		
		print_r($count);die;
		
		
		
		// dọn dẹp thuộc tính _product_classify_value_product
		$db->query('DELETE FROM '. TABLE .'_product_classify_value_product WHERE product_id = 0');
		
		
		// dọn dẹp thuộc tính _product_classify_value_product
		$list_product_classify_value_product = $db->query('SELECT * FROM '. TABLE .'_product_classify_value');
		
		$count = 0;
		
		foreach($list_product_classify_value_product as $classify_value_product)
		{
		// kiểm tra id có tồn tại hay không
		$check = $db->query('SELECT count(*) as count FROM '. TABLE .'_product_classify_value_product WHERE classify_id_value1 ='. $classify_value_product['id'] .' OR classify_id_value2 ='. $classify_value_product['id'])->fetchColumn();
		if(!$check)
		{
		// không tồn tại, xóa
		$db->query('DELETE FROM '. TABLE .'_product_classify_value WHERE id = '. $classify_value_product['id']);
		
		$count++;
		}
		}
		
		
		// dọn dẹp thuộc tính _product_classify
		$list_product_classify = $db->query('SELECT * FROM '. TABLE .'_product_classify');
		
		$count = 0;
		
		foreach($list_product_classify as $classify_value)
		{
		// kiểm tra id có tồn tại hay không
		$check = $db->query('SELECT count(*) as count FROM '. TABLE .'_product_classify_value WHERE classify_id ='. $classify_value['id'])->fetchColumn();
		if(!$check)
		{
		// không tồn tại, xóa
		$db->query('DELETE FROM '. TABLE .'_product_classify WHERE id = '. $classify_value['id']);
		
		$count++;
		}
		}
		
		print_r($count);die;
		
		/*
		// cập nhật product_classify_value_product product_id
		$list_product = $db->query('SELECT id FROM '. TABLE .'_product')->fetchAll();
		
		foreach($list_product as $product)
		{
		// lấy giá theo thuộc tính sản phẩm
		$product_classify = $db->query('SELECT * FROM ' . TABLE .'_product_classify WHERE product_id =' . $product['id'])->fetchAll();
		
		if(count($product_classify))
		{		
		$array_product_classify = array();
		foreach($product_classify as $classify)
		{
		$array_product_classify[] = $classify['id'];
		}
		
		if($array_product_classify)
		{
		// lấy thuộc tính con 
		$product_classify_value = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value WHERE classify_id IN('. implode(',',$array_product_classify) .')')->fetchAll();
		
		if($product_classify_value)
		{
		$array_product_classify_value = array();
		foreach($product_classify_value as $classify_value)
		{
		$array_product_classify_value[] = $classify_value['id'];
		}
		
		if($array_product_classify_value)
		{
		// cập nhật product_id
		$db->query('UPDATE ' . TABLE .'_product_classify_value_product SET product_id ='. $product['id'] .' WHERE classify_id_value1 IN('. implode(',',$array_product_classify_value).') OR classify_id_value2 IN('. implode(',',$array_product_classify_value).')');
		
		}
		
		}
		}
		
		}
		}
		
		
		
		/*
		
		
		
		
		// cập nhật nhóm cửa hàng về groupid = 5
		
		$list_shop = $db->query('SELECT userid FROM '. TABLE .'_seller_management')->fetchAll();
		
		foreach($list_shop as $shop)
		{
		$db->query('UPDATE ' . NV_TABLE_USER .' SET group_id = 5, in_groups = 5 WHERE userid ='. $shop['userid']);
		}
		
		
		
		
		// tool cập nhật tài khoản thường
		
		$list_user = $db->query('SELECT userid, username FROM tms_users ORDER BY userid DESC')->fetchAll();
		
		foreach($list_user as $user)
		{
		$user['username'] = strtolower($user['username']);
		
		$db->query('UPDATE tms_users SET username ="'. $user['username'] .'" WHERE userid ='. $user['userid'] );
		
		}
		
		
		
		// cập nhật first_name qua last_name của module user
		
		$list_user = $db->query('SELECT userid, first_name, last_name FROM tms_users WHERE first_name != ""')->fetchAll();
		
		foreach($list_user as $user)
		{
		
		if(!empty($user['last_name']))
		{
		$db->query('UPDATE tms_users SET first_name = "" WHERE userid ='. $user['userid']);		
		}
		else
		{
		$db->query('UPDATE tms_users SET last_name = "'. $user['first_name'] .'", first_name = "" WHERE userid ='. $user['userid']);	
		}
		
		}
		
		
		
		// cập nhật giá, giá niêm yết cho tất cả sản phẩm
		
		$list_products = $db->query('SELECT id FROM ' . TABLE .'_product')->fetchAll();
		
		foreach($list_products as $item)
		{
		// lấy giá thuộc tính
		
		$product_classify = $db->query('SELECT * FROM ' . TABLE .'_product_classify WHERE product_id =' . $item['id'])->fetchAll();
		
		if($product_classify)
		{
		$array_product_classify = array();
		foreach($product_classify as $classify)
		{
		$array_product_classify[] = $classify['id'];
		}
		
		if($array_product_classify)
		{
		// lấy thuộc tính con 
		$product_classify_value = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value WHERE classify_id IN('. implode(',',$array_product_classify) .')')->fetchAll();
		
		if($product_classify_value)
		{
		$array_product_classify_value = array();
		foreach($product_classify_value as $classify_value)
		{
		$array_product_classify_value[] = $classify_value['id'];
		}
		
		if($array_product_classify_value)
		{
		$classify_value_product = $db->query('SELECT * FROM ' . TABLE .'_product_classify_value_product WHERE classify_id_value1 IN('. implode(',',$array_product_classify_value) .') OR classify_id_value2 IN('. implode(',',$array_product_classify_value) .')')->fetchAll();
		}
		
		$price = 0;
		$price_special = 0;
		
		foreach($classify_value_product as $value)
		{
		if($value['status'])
		{
		if($price == 0)
		{
		$price = $value['price'];
		$price_special = $value['price_special'];
		}
		elseif($value['price'] < $price)
		{
		$price = $value['price'];
		$price_special = $value['price_special'];
		}
		}
		}
		
		if($price)
		{
		// cập nhật giá price, price_special cho sản phẩm
		$db->query('UPDATE ' . TABLE .'_product SET price ='. $price .', price_special ='. $price_special .' WHERE id ='. $item['id']);
		}
		}
		}
		
		
		}
		}
		
		
		// đồng bộ dữ liệu số lượng tồn kho sản phẩm, thuộc tính sản phẩm
		
		$list_inventory_product = $db->query('SELECT * FROM ' . TABLE .'_inventory_product')->fetchAll();
		
		foreach($list_inventory_product as $item)
		{
		// không có thuộc tính
		if(!$item['classify_value_product_id'])
		{
		// cập nhật kho
		$db->query('UPDATE '. TABLE .'_product SET warehouse ='. $item['amount'] .' WHERE id ='. $item['product_id']);
		}
		else
		{
		// cập nhật kho theo thuộc tính
		$db->query('UPDATE '. TABLE .'_product_classify_value_product SET sl_tonkho ='. $item['amount'] .' WHERE id ='. $item['classify_value_product_id']);
		}
		
		
		}
		
		print_r($list_inventory_product);die;
		
	*/
	
die(ok);	