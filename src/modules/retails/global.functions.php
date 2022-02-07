<?php

	// lấy tất cả category đưa vào redis
	function get_payment_all()
	{
		global $db, $module_name, $module_upload;
		
		$list_payment = $db->query('SELECT * FROM ' . TABLE .'_payment WHERE active = 1 ORDER BY weight ASC')->fetchAll();
		
		
		$arr_temp = array();
		
		foreach($list_payment as $value)
		{
			$arr_temp[$value['payment']] = $value;
		}
		
		return $arr_temp;
	}
	
	




	define('NV_TABLE_USER', $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_users');
	define('IDSITE', $global_config['idsite']);
	define('TABLE', $db_config['dbsystem'] . '.' . NV_PREFIXLANG . '_' . $module_name);
	define('NV_TABLE_PROVINCE', $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_location_province');
	define('NV_TABLE_DISTRICT', $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_location_district');
	define('NV_TABLE_WARD', $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_location_ward');
	define('NV_TABLE_WALLET', $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_wallet');
	
	// trạng thái order
	$sql = "SELECT * FROM " . TABLE . "_status_order ORDER BY weight ASC";
	$global_status_order = $nv_Cache->db($sql, 'status_id', $module_name);
	
	// trạng thái vận chuyển vnpost 
	$sql = "SELECT * FROM " . TABLE . "_status_vnpos";
	$global_status_vnpos = $nv_Cache->db($sql, 'id_status', $module_name);
	// trạng thái vận chuyển GHN
	$global_status_ghn = $nv_Cache->db("SELECT * FROM " . TABLE . "_status_ghn", 'name_status_ghn', $module_name);
	// trạng thái lỗi vận chuyển GHN
	$global_status_error_ghn = $nv_Cache->db("SELECT * FROM " . TABLE . "_status_error_ghn", 'code_status_ghn', $module_name);
	
	
	// trạng thái khiếu nại
	$sql = "SELECT * FROM " . TABLE . "_complain_status WHERE status = 1 ORDER BY weight ASC";
	$global_status_complain = $nv_Cache->db($sql, 'weight', $module_name);
	
	// lấy tất cả địa chỉ
	$global_location = json_decode($redis->get('location_all'),true);	
	
	// lấy tất cả tỉnh thành
	$global_province = json_decode($redis->get('location_province'),true);	
	
	// lấy tất cả quận huyện
	$global_district = json_decode($redis->get('location_district'),true);
	
	// lấy tất cả xã phường
	$global_ward = json_decode($redis->get('location_ward'),true);

	// lấy tất cả cổng thanh toán
	if(!$redis->exists('catalogy_main'))
	{
		$payport = get_payment_all();
		$redis->set('payport', json_encode($payport));	
	}
	$global_payport = json_decode($redis->get('payport'),true);
	//$redis->delete('catalogy_main');
	if(!$redis->exists('catalogy_main'))
	{
		$catalogys = get_categories_all();
		$redis->set('catalogy_main', json_encode($catalogys));	
	}
	
	$global_catalogys = json_decode($redis->get('catalogy_main'),true);	
	
	// danh mục đa cấp đưa hết vào redis lev theo cấp
	
	//$redis->delete('catalogy_main_all_lev');
	
	
	if(!$redis->exists('catalogy_main_all_lev'))
	{
		$catalogys = get_categories_all_lev(0);
		$redis->set('catalogy_main_all_lev', json_encode($catalogys));	
	}
	
	
	//Tự tạo thêm thư mục theo ngày tháng
	if (!is_dir(NV_ROOTDIR . '/uploads/' . $module_upload . '/' . date('Y_m')))
	{
		nv_mkdir(NV_ROOTDIR . '/uploads/' . $module_upload, date('Y_m'));
		$upload_dir = 'uploads/' . $module_upload . '/' . date('Y_m');
		$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_upload_dir(dirname,time) VALUES(' . $db->quote($upload_dir) . ',' . NV_CURRENTTIME . ')');
	}
	
	// lọc từ có dấu thành không dấu
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
	
	//Làm tròn tiền lên x,000
	
	function rounding($number){
		
		$mod = $number%1000;
		if($mod>0){
			$thuong = ceil($number / 1000);
			$number = $thuong*1000;
		}
		return $number;
	}
	
	//full địa chỉ ngắn gọn + xã + huyện + tỉnh
	
	function get_full_address($ward_id, $district_id, $province_id){
		
		if($ward_id){
			$ward_id = get_info_ward($ward_id)['title'];
		}
		if($district_id){
			$district_id = get_info_district($district_id)['title'];
		}
		if($province_id){
			$province_id = get_info_province($province_id)['title'];
		}
		
		$address = ' , ' . $ward_id . ' , '. $district_id . ' , ' . $province_id;
		return $address;
	}
	
	function mess_error($mess)
	{
		$array = array();
		
		$array['status'] = 'ERROR';
		$array['mess'] = $mess;
		
		print_r(json_encode($array));die;
	}
	//thêm lịch sử sự kiện admin xử lý
	
	function insert_history_admin($userid = 0, $content = ''){
		global $db;
		$sql = 'INSERT INTO ' . TABLE . '_history_admin_ecng (userid, content, time_add) VALUES (:userid, :content, :time_add)';
		$data_insert = array();
		$data_insert['userid'] = $userid;
		$data_insert['content'] = $content;
		$data_insert['time_add'] = NV_CURRENTTIME;
		
		$id = $db->insert_id($sql, 'id', $data_insert);
	}
	
	//tổng tiền hàng của shop
	function total_price_shop($warehouse)
	{
		$tong = 0;
		foreach($warehouse as $product)
		{	
			if($product['status_check']){
				$tong += $product['num'] * $product['price'];
			}
		}
		return $tong;
		
	}
	
	//check voucher order
	
	function check_voucher_order($shop_id, $voucherid){
		global $db, $user_info;
		$today = NV_CURRENTTIME;
		
		$voucher = $db->query('SELECT id FROM ' . TABLE . '_voucher_shop WHERE status = 1 AND usage_limit_quantity > 0 AND store_id = ' . $shop_id . ' AND time_from < ' . $today . ' AND time_to > ' . $today . ' AND id = ' . $voucherid . '  UNION SELECT t2.id FROM ' . TABLE . '_voucher_wallet t1 INNER JOIN ' . TABLE . '_voucher_shop t2 ON t2.id = t1.voucherid WHERE t1.userid = ' . $user_info['userid'] . '  AND t2.time_from < ' . $today . ' AND t2.time_to > ' . $today . ' AND t1.status = 1 AND t2.id = ' . $voucherid)->fetchColumn();
		
		return $voucher;
		
	}
	//chọn voucher giảm giá tối ưu nhất
	function voucher_price_optimal($product_id, $total_price_shop, $shop_id, $array_voucher_use){
		global $db, $user_info;
		$today = NV_CURRENTTIME;
		//lay danh sach voucher cua shop còn sài đc và từ ví

		$list_voucher = $db->query('SELECT id, voucher_name, type_discount, discount_price, maximum_discount, minimum_price, time_to, list_product FROM ' . TABLE . '_voucher_shop WHERE status = 1 AND usage_limit_quantity > 0 AND store_id = ' . $shop_id . ' AND (FIND_IN_SET(' . $product_id . ', list_product) OR FIND_IN_SET(0, list_product)) AND time_from < ' . $today . ' AND time_to > ' . $today . ' AND minimum_price <= ' . $total_price_shop . '  UNION SELECT t2.id, t2.voucher_name, t2.type_discount, t2.discount_price, t2.maximum_discount, t2.minimum_price, t2.time_to, t2.list_product FROM ' . TABLE . '_voucher_wallet t1 INNER JOIN ' . TABLE . '_voucher_shop t2 ON t2.id = t1.voucherid WHERE t1.userid = ' . $user_info['userid'] . ' AND (FIND_IN_SET(' . $product_id . ', list_product) OR FIND_IN_SET(0, list_product)) AND t2.time_from < ' . $today . ' AND t2.time_to > ' . $today . ' AND t1.status = 1  AND minimum_price <= ' . $total_price_shop . ' AND t2.store_id = ' . $shop_id)->fetchAll();
		
		foreach($list_voucher as $voucher){
			$price = 0;
			if($voucher['type_discount'])
			{
				$price = $total_price_shop * $voucher['discount_price'] / 100;
				$price = floor($price);
				if($voucher['maximum_discount']){
					if($price > $voucher['maximum_discount']){
						$price = $voucher['maximum_discount'];
					}
				}
				
			}
			else
			{	
				$price = $voucher['discount_price'];
			}

			if($price > $total_price_shop){
				$price = $total_price_shop;
			}
			
			$array_product = array();
			$array_product[] = $product_id;
			if($array_voucher_use[$voucher['id']])
			{
				foreach($array_voucher_use[$voucher['id']]['product_id'] as $pro)
				{
					$array_product[] = $pro;
				}
			}
			
			$array_voucher_use[$voucher['id']] = array('price' => $price, 'voucherid' => $voucher['id'],'product_id' => $array_product, 'voucher_name' => $voucher['voucher_name'], 'time_to' => $voucher['time_to'], 'type_discount' => $voucher['type_discount'], 'maximum_discount' => $voucher['maximum_discount'], 'minimum_price' => $voucher['minimum_price'], 'list_product' => $voucher['list_product'], 'discount_price' => $voucher['discount_price'] );
			
		}

		return $array_voucher_use;
	
	}
	
	//check voucher
	function check_voucher ($voucher_code, $voucher_id, $shop_id){
		
		global $db, $db_config, $module_name, $user_info;
		
		$where = '' ;
		if(!$voucher_code and !$voucher_id){
			$json = ['status'=>'ERROR', 'mess'=>'Có lỗi không đủ tham số'];
			return json_encode($json);
		}
		if($voucher_code){
			$where = ' AND voucher_code = ' .  $db->quote($voucher_code); 
		}
		if($voucher_id){
			$where = ' AND id = ' . $voucher_id ; 
		}
		
		if(empty($shop_id)){
			$json = ['status'=>'ERROR', 'mess'=>'Có lỗi không có shop'];
			return json_encode($json);
		}
		
		$today = NV_CURRENTTIME;
		
		// $check_voucher = $db->query('SELECT * FROM ' . TABLE . '_voucher WHERE userid = ' . $shop_id . ' AND status = 1 ' . $where )->fetch();
		
		if(!$check_voucher['id'])
		{
			$json = ['status'=>'ERROR', 'mess'=>'Voucher không tồn tại!'];
			return json_encode($json);
		}
		
		$check_voucher_used = $db->query('SELECT COUNT(id) FROM ' . TABLE . '_order_voucher WHERE userid = ' . $user_info['userid'] . ' AND status = 1 AND voucherid = ' . $check_voucher['id'])->fetchColumn();
		
		if($check_voucher_used > 0){
			$json = ['status'=>'ERROR', 'mess'=>'Bạn đã sử dụng Voucher này rồi'];
			return json_encode($json);
		}
		
		if(!$check_voucher){
			$json = ['status'=>'ERROR', 'mess'=>'Voucher không tồn tại'];
			return json_encode($json);
			
			}else{
			if( $today <= $check_voucher['time_from'] || $today > $check_voucher['time_to'] ){
				$json = ['status'=>'ERROR', 'mess'=>'Voucher không nằm trong thời gian hoạt động'];
				return json_encode($json);
				}elseif($check_voucher['usage_limit_quantity'] < 1){
				$json = ['status'=>'ERROR', 'mess'=>'Voucher đã hết lượt sử dụng'];
				return json_encode($json);
				}else{
				$json = ['status'=>'OK', 'voucher_price'=>$check_voucher['discount_price'], 'voucher_name'=>$check_voucher['voucher_name'], 'minimum_price'=>$check_voucher['minimum_price'], 'voucher_code'=>$check_voucher['voucher_code'], 'voucher_id'=>$check_voucher['id']];
				
			}
		}
		
		
		return json_encode($json);
		
	}
	//check voucher
	//check voucher
	function check_voucher_shop ($voucher_id, $shop_id, $userid){
		
		global $db, $db_config, $module_name, $user_info;
		
		
		if(empty($shop_id)){
			$json = ['status'=>'ERROR', 'mess'=>'Có lỗi không có shop'];
			return json_encode($json);
		}
		
		$today = NV_CURRENTTIME;
		
		$check_voucher = $db->query('SELECT * FROM ' . TABLE . '_voucher WHERE userid = ' . $shop_id . ' AND status = 1 AND id = ' . $voucher_id )->fetch();
		
		if(!$check_voucher['id'])
		{
			$json = ['status'=>'ERROR', 'mess'=>'Có lỗi không lấy được thông tin voucher'];
			return json_encode($json);
		}
		
		$check_voucher_used = $db->query('SELECT COUNT(id) FROM ' . TABLE . '_order_voucher WHERE userid = ' . $userid . ' AND status = 1 AND voucherid = ' . $check_voucher['id'])->fetchColumn();
		
		if($check_voucher_used > 0){
			$json = ['status'=>'ERROR', 'mess'=>'Bạn đã sử dụng Voucher này rồi'];
			return json_encode($json);
		}
		
		if(!$check_voucher){
			$json = ['status'=>'ERROR', 'mess'=>'Voucher không tồn tại'];
			return json_encode($json);
			
			}else{
			if( $today <= $check_voucher['time_from'] || $today > $check_voucher['time_to'] ){
				$json = ['status'=>'ERROR', 'mess'=>'Voucher không nằm trong thời gian hoạt động'];
				return json_encode($json);
				}elseif($check_voucher['usage_limit_quantity'] < 1){
				$json = ['status'=>'ERROR', 'mess'=>'Voucher đã hết lượt sử dụng'];
				return json_encode($json);
				}else{
				$json = ['status'=>'OK', 'voucher_price'=>$check_voucher['discount_price'], 'voucher_name'=>$check_voucher['voucher_name'], 'minimum_price'=>$check_voucher['minimum_price'], 'voucher_code'=>$check_voucher['voucher_code']];
				
			}
		}
		
		
		return json_encode($json);
		
	}
	//check voucher
	function nv_insert_notification_shop($userid, $store_id, $content_ip, $order_id, $type)
	{
		global $db, $db_config, $module_name;
		
		$db->query('INSERT INTO '. $db_config['dbsystem'] . '.'. $db_config['prefix'] .'_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('. $db->quote(NV_LANG_DATA) .',1,'. $db->quote($module_name) .',0,0,'. $userid .','. $store_id .','. $db->quote($content_ip) .','. NV_CURRENTTIME .','. $order_id .',"'. $type .'")');
		
		return true;
		
	}
	
	function nv_insert_notification_user($userid, $userid_order, $content_ip, $order_id, $type)
	{
		global $db, $db_config, $module_name;
		
		$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_user(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$userid.',' . $userid_order .','.$db->quote($content_ip).','.NV_CURRENTTIME.',' . $order_id . ',"order")');
		
		return true;
		
	}
	
	function nv_insert_notification_ecng($userid, $store_id, $content_ip, $order_id, $type)
	{
		global $db, $db_config, $module_name, $user_info;
		
		$db->query('INSERT INTO '. $db_config['dbsystem'] . '.'. $db_config['prefix'] .'_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('. $db->quote(NV_LANG_DATA) .',1,'. $db->quote($module_name) .',0,0,'. $userid .','. $store_id .','. $db->quote($content_ip) .','. NV_CURRENTTIME .','. $order_id .',"'. $type .'")');
		
		return true;
		
	}
	
	function check_login(){
		if (!defined('NV_IS_USER')) {
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
	}
	
	//kiểm tra user đã đăng nhập chưa và đơn hàng này có phải của user đó k
	function check_order($order_id){
		global $db, $user_info;
		if (!defined('NV_IS_USER')) {
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		if(!$order_id)
		{
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
		
		$check_order = $db->query("SELECT id FROM " . TABLE . "_order WHERE userid = ". $user_info['userid'] ." AND id = " . $order_id)->fetchColumn();
		if(!$check_order){
			print_r( json_encode( array('status'=>'ERROR' ) ));
			die();
		}
	}
	
	function check_store_order_id($order_id)
	{
		global $db, $module_name, $user_info;
		
		$flag = false;
		
		if (!defined('NV_IS_USER')) {
			// nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users');
			$user_info['userid'] = 0;
		}
		
		if($order_id)
		{
			$flag = $db->query("SELECT id FROM " . TABLE . "_order where userid = ". $user_info['userid'] ." AND id=" . $order_id)->fetchColumn();
		}
		
		// if(!$flag)
		// {
		// 	// nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ordercustomer');
		// }
		
		return $flag;
	}
	
	// cập nhật trạng thái đơn hàng khi vnpost cập nhật trạng thái
	function update_order_send_vnpost($order_id, $status,$content)
	{
		global $db, $db_config;
		
		$update_status_payment_vnpay = $db->query('UPDATE ' . TABLE . '_order SET status = '. $status .' WHERE id =' . $order_id);
		
		// lưu lại lịch sử đơn hàng
		history_order($order_id, $status, $content);
		
		return true;
		
	}
	
	// ghi nhận lịch sử trạng thái đơn hàng
	function history_order($order_id, $status,$content)
	{
		global $db, $db_config, $user_info, $admin_info;
		
		$user_add = 0;
		
		if(isset($user_info['userid']) and $user_info['userid'])
		$user_add = $user_info['userid'];
		
		if(isset($admin_info['userid']) and $admin_info['userid'])
		$user_add = $admin_info['userid'];
		
		$db->query('INSERT INTO ' . TABLE . '_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $order_id . ','. $status .',' . $db->quote($content) . ',' . NV_CURRENTTIME . ','. $user_add .')');
		
		return true;
	}
	
	// cập nhật trạng thái lịch sử vnpost
	function update_history_vnpost($item_code, $order_id, $status)
	{
		global $db, $db_config;
		
		$update_status_payment_vnpay = $db->query('UPDATE ' . TABLE . '_history_vnpos SET vnpost_status = '. $status .' WHERE order_id =' . $order_id .' AND item_code = "'. $item_code .'"');
		
		return true;
		
	}
	
	function update_time_edit_order($order_id)
	{
		global $db;
		if(!$order_id){
			return false;
		}
		$db->query('UPDATE ' . TABLE . '_order SET time_edit = ' . NV_CURRENTTIME . ' WHERE id = ' . $order_id );
		return true;
	}
	
	function update_time_add_order($order_id)
	{
		global $db;
		if(!$order_id){
			return false;
		}
		
		$db->query('UPDATE ' . TABLE . '_order SET time_add = ' . NV_CURRENTTIME . ' WHERE id = ' . $order_id );
		return true;
	}
	
	// xử lý thanh toán vnpay thành công
	function xulythanhtoanthanhcong($order_text, $inputData)
	{
		global $db, $db_config, $user_info, $module_name, $lang_module,$global_payport;
		
		$list_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id IN(' . $order_text . ')')->fetchAll();
		
		// cập nhật kho hàng sau khi thanh toán thành công
		foreach ($list_order as $order)
		{
			//update voucher 
			
			// $update_voucher = $db->query('UPDATE ' . TABLE . '_voucher SET usage_limit_quantity = usage_limit_quantity - 1 WHERE id = ' . $order['voucherid']);
			
			$update_order_voucher = $db->query('UPDATE ' . TABLE . '_order_voucher SET status =  1 WHERE order_id = ' . $order['id']);
			
			// lấy danh sách sản phẩm của đơn hàng
			$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
			//print_r($list_product);die;
			foreach ($list_product as $product)
			{
				// cập nhật kho sau khi thanh toán thành công
				
				$where = '';
				
				if($product['classify_value_product_id'])
				{
					$where .= ' AND id=' . $product['classify_value_product_id'];
				}
				
				$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET sl_tonkho = sl_tonkho - '. $product['quantity'] .' WHERE product_id =' . $product['product_id'] . $where);
				
				$db->query('UPDATE ' . TABLE . '_product SET number_order = number_order + '. $product['quantity'] .' WHERE id = ' . $product['product_id']);
				
			}
			
			// gửi thông báo email về cho khách hàng, cửa hàng
			$content_ip = 'Hiện có 1 đơn hàng mới';
			if (!empty($user_info))
			{
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,' . $user_info['userid'] . ',' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,' . $user_info['userid'] . ',' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
			}
			else
			{
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,0,' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,0,' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
			}
			
			$content = 'Đơn hàng mới đã xác nhận';
			if (!empty($user_info))
			{
				
				$db->query('INSERT INTO ' . TABLE . '_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $order['id'] . ',1,' . $db->quote($content) . ',' . NV_CURRENTTIME . ',' . $user_info['userid'] . ')');
			}
			else
			{	
				$db->query('INSERT INTO ' . TABLE . '_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $order['id'] . ',1,' . $db->quote($content) . ',' . NV_CURRENTTIME . ',1)');
			}
			
			// cập nhật thông tin đơn hàng thanh toán thành công status_payment_vnpay = 1
			
			$update_status_payment_vnpay = $db->query('UPDATE ' . TABLE . '_order SET status_payment_vnpay = 1, status = 1, payment =' . $order['total'] . ', vnpay_code ="'. $inputData['vnp_TransactionNo'] .'" WHERE id =' . $order['id']);
			
			update_time_add_order($order['id']);
			
			if($order['transporters_id'])
			{
				$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
			}
			else
			{
				$order['name_transporters'] = $lang_module['tranposter_tugiao'];
			}
			
			
			// Gui mail thong bao den khach hang
			$data_order['id'] = $order['id'];
			$info_order = $order;
			$info_order['payment_method_name'] = $global_payport[$info_order['payment_method']]['paymentname'];
			$data_order['order_code'] = $order['order_code'];
			
			$email_title = $lang_module['order_email_title'];
			$email_contents = call_user_func('email_new_order_payment_khach', $data_order, $list_product, $info_order);
			
			
			
			nv_sendmail(array(
            $global_config['site_name'],
            $global_config['site_email']
			) , $order['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
			
			
			// Gui mail thong bao den nhà bán hàng
			$email_contents = call_user_func('email_new_order_payment', $data_order, $list_product, $info_order);
			$email_title = $lang_module['order_email_title'];
			
			nv_sendmail(array(
            $global_config['site_name'],
            $global_config['site_email']
			) , get_info_store($order['store_id'])['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
			
		}
		
		return true;
	}
	
	function payment($order_text, $inputData, $returnData)
	{
		global $db, $db_config, $user_info, $module_name, $lang_module;
		
		// lấy thông tin đăng ký
		$info = $db->query('SELECT * FROM ' . TABLE . '_order  WHERE id IN('. $order_text .')')->fetch();
		
		if(empty($info))
		{
			return false;
		}
		
		// lấy thông tin order code
		$array_order = array();
		if(!empty($order_text))
		{
			$list_order = $db->query('SELECT order_code FROM ' . TABLE .'_order WHERE id IN('. $order_text .')')->fetchAll();
			foreach($list_order as $order)
			{
				$array_order[] = $order['order_code'];
			}
		}
		
		$row['vnp_txnref'] = implode(' - ',$array_order);
		
		$row['price'] = $inputData['vnp_Amount']/100;
		$row['name_register'] = $info['order_name'];
		$row['email_register'] = $info['email'];
		$row['phone_register'] = $info['phone'];
		$row['userid'] = $info['userid'];
		$row['vnp_orderinfo'] = $inputData['vnp_OrderInfo'];
		$row['vnp_responsedode'] = $returnData['RspCode'];
		$row['vnp_transactionno'] = $inputData['vnp_TransactionNo'];
		$row['vnp_bankcode'] = $inputData['vnp_BankCode'];
		$row['vnp_cardtype'] = $inputData['vnp_CardType'];
		$row['vnp_paydate'] = $inputData['vnp_PayDate'];
		$row['status'] = $returnData['Message'];
		
		$row['addtime'] = NV_CURRENTTIME;
		
		$stmt = $db->prepare('INSERT INTO ' . TABLE . '_history_vnpay (price, name_register, email_register, phone_register, userid, vnp_txnref, vnp_orderinfo, vnp_responsedode, vnp_transactionno, vnp_bankcode, vnp_cardtype, vnp_paydate, status, addtime) VALUES (:price, :name_register, :email_register, :phone_register, :userid, :vnp_txnref, :vnp_orderinfo, :vnp_responsedode, :vnp_transactionno, :vnp_bankcode, :vnp_cardtype, :vnp_paydate, :status, :addtime)');
		
		$stmt->bindParam(':addtime', $row['addtime'], PDO::PARAM_INT);
		
		$stmt->bindParam(':price', $row['price'], PDO::PARAM_STR);
		$stmt->bindParam(':name_register', $row['name_register'], PDO::PARAM_STR);
		$stmt->bindParam(':email_register', $row['email_register'], PDO::PARAM_STR);
		$stmt->bindParam(':phone_register', $row['phone_register'], PDO::PARAM_STR);
		$stmt->bindParam(':userid', $row['userid'], PDO::PARAM_INT);
		$stmt->bindParam(':vnp_txnref', $row['vnp_txnref'], PDO::PARAM_STR);
		$stmt->bindParam(':vnp_orderinfo', $row['vnp_orderinfo'], PDO::PARAM_STR);
		$stmt->bindParam(':vnp_responsedode', $row['vnp_responsedode'], PDO::PARAM_STR);
		$stmt->bindParam(':vnp_transactionno', $row['vnp_transactionno'], PDO::PARAM_STR);
		$stmt->bindParam(':vnp_bankcode', $row['vnp_bankcode'], PDO::PARAM_STR);
		$stmt->bindParam(':vnp_cardtype', $row['vnp_cardtype'], PDO::PARAM_STR);
		$stmt->bindParam(':vnp_paydate', $row['vnp_paydate'], PDO::PARAM_STR);
		$stmt->bindParam(':status', $row['status'], PDO::PARAM_STR);
		
		$exc = $stmt->execute();
		
	}
	
	// cập nhật trạng thái đơn hàng
	function update_status_order($order_id, $status, $userid)
	{
		global $db, $global_status_order;
		
		if(!$order_id or $status < 0)
		{
			return false;
		}
		
		
		// cập nhật order
		$db->query('UPDATE ' . TABLE . '_order SET status = '. $status .' WHERE id ='. $order_id);
		
		// lưu lại lịch sử cập nhật order
		$content='Chuyển trạng thái đơn hàng sang '. $global_status_order[$status]['name'];
		$db->query('INSERT INTO '. TABLE .'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('. $order_id .','. $status .','.$db->quote($content).','. NV_CURRENTTIME .','. $userid .')');
		
		
		return true;
	}
	
	
	// cập nhật trạng thái vnpost
	function update_status_vnpost($order_id, $item_code, $vnpost_status, $userid)
	{
		global $db;
		
		if(empty($item_code) or $vnpost_status < 0)
		return false;
		
		
		// lấy id trạng thái ItemCode trong lịch sử đã tồn tại chưa. nếu chưa có mới lưu lại thông tin lịch sử vận đơn. trạng thái không được trùng nhau
		$id_vndon = $db->query('SELECT id FROM ' . TABLE .'_history_vnpos_detail WHERE status_vnpost = '. $vnpost_status .' AND itemcode="'. $item_code .'"')->fetchColumn();
		
		if($id_vndon)
		return false;
		
		// cập nhật thông tin history vnpost, userid_edit, vnpost_status = 60 hủy
		$db->query('UPDATE ' . TABLE . '_history_vnpos SET userid_edit = '. $userid .', vnpost_status = '. $vnpost_status .' WHERE item_code = "' . $item_code .'"');
		
		// cập nhật lịch sử chi tiết vnpost
		$db->query('INSERT INTO '. TABLE .'_history_vnpos_detail(order_id,itemcode,status_vnpost,user_add,addtime) VALUES('. $order_id .',"'. $item_code .'", '. $vnpost_status .' , '. $userid .','. NV_CURRENTTIME .')');
		
		
		
		return true;
	}
	
	
	// update hủy đơn vnpost , cập nhật trạng thái order
	function update_huy_vnpost($info_order)
	{
		global $db, $admin_info;
		
		// cập nhật vnpost
		// hủy trạng thái vận đơn = 60
		$vnpost_status = 60;
		update_status_vnpost($info_order['id'], $info_order['shipping_code'], $vnpost_status, $admin_info['userid']);
		
		// hủy vận đơn trạng thái đơn hàng về lại 1 đã xác nhận đơn hàng.
		$status = 1;
		// kiểm tra $info_order['id'] có giao hàng thất bại lần nào chưa nếu có thì status = 6.
		$check_giaohang_thatbai = $db->query('SELECT id FROM '. TABLE .'_logs_order WHERE status_id_old = 6 AND order_id = '. $info_order['id'])->fetchColumn();
		
		if($check_giaohang_thatbai)
		{
			$status = 6;
		}
		
		update_status_order($info_order['id'], $status, $admin_info['userid']);
		
		// thông báo hủy vận chuyển vnpost cho shop
		$content_ip = 'Hủy vận chuyển đơn hàng ' . $info_order['order_code'] . ' vnpost';
		nv_insert_notification_shop($admin_info['userid'], $info_order['store_id'], $content_ip, $info_order['id'], "order");
		//ghi lịch su admin
		$reason = $admin_info['username'] . ' đã hủy gửi hàng VNPOST' ;
		insert_history_admin($admin_info['userid'], $reason);
		
		return true;
	}
	
	
	
	function check_info_order_vnpost_history($shipping_code)
	{
		global $db;
		$list_status = $db->query('SELECT * FROM '. TABLE .'_history_vnpos_detail WHERE itemcode ="'. $shipping_code .'" ORDER BY addtime ASC')->fetchAll();
		return $list_status;
	}
	
	function check_info_order_ghn_history($shipping_code)
	{
		global $db;
		$list_status = $db->query('SELECT status, time_add, warehouse, reason_code FROM '. TABLE .'_history_ghn_detail WHERE order_code_ghn ="'. $shipping_code .'" ORDER BY time_add ASC')->fetchAll();
		return $list_status;
	}
	
	
	// cập nhật mã vận đơn vnpost vào database
	function update_vnpost_hoantra_hang($info_order, $order_vnpost, $array_pro)
	{
		global $db, $user_info, $global_status_complain;
		
		// ghi lại lịch sử tạo vận đơn
		$row['order_id'] = $info_order['id'];
		$row['order_code'] = $info_order['order_code'];
		
		// xử lý danh sách sản phẩm trong đơn hàng
		$row['name_products'] = '';
		
		foreach($arr_pro as $pro)
		{
			if(!$title_product)
			$row['name_products'] = get_info_product($pro['product_id'])['name_product'];
			else
			$row['name_products'] = $row['name_products'] . ', ' . get_info_product($pro['product_id'])['name_product'];
		}
		
		
		$row['id_vnpost'] = $order_vnpost['Id'];
		$row['total_weight_convert'] = $order_vnpost['WeightConvert'];
		$row['total_weight'] = $order_vnpost['WeightEvaluation'];
		$row['total_length'] = $order_vnpost['LengthEvaluation'];
		$row['total_width'] = $order_vnpost['WidthEvaluation'];
		$row['total_height'] = $order_vnpost['HeightEvaluation'];
		$row['total_moeny'] = $order_vnpost['OrderAmountEvaluation'];
		$row['tinhthanh_gui'] = $order_vnpost['SenderProvinceId'];
		$row['quanhuyen_gui'] = $order_vnpost['SenderDistrictId'];
		$row['address_gui'] = $order_vnpost['SenderAddress'];
		$row['phone_gui'] = $order_vnpost['SenderTel'];
		$row['name_gui'] = $order_vnpost['SenderFullname'];
		$row['userid_shop'] = $info_order['store_id']; 
		$row['tinhthanh_nhan'] = $order_vnpost['ReceiverProvinceId'];
		$row['quanhuyen_nhan'] = $order_vnpost['ReceiverDistrictId'];
		$row['address_nhan'] = $order_vnpost['ReceiverAddress'];
		$row['phone_nhan'] = $order_vnpost['ReceiverTel'];
		$row['name_nhan'] = $order_vnpost['ReceiverFullname'];
		
		$row['item_code'] = $order_vnpost['ItemCode'];
		
		// Cước dịch vụ cộng thêm VAS tạm tính
		$row['tongcuocdichvucongthem'] = $order_vnpost['VasFreightEvaluation'];
		
		$row['tongcuocbaogomdvct'] = $order_vnpost['TotalFreightIncludeVatEvaluation'];
		
		$row['cuoc_phi'] = $row['tongcuocbaogomdvct'] - $row['tongcuocdichvucongthem'];
		
		
		
		$row['hinhthuc_vc'] = $order_vnpost['ServiceName'];
		
		/*
			Trạng thái null do đơn hàng mới tạo
			20: Đã tạo
			70: Thu gom thành công
			91: Phát chưa thành công
		*/
		$row['vnpost_status'] = $order_vnpost['OrderStatusId'];
		
		$row['customer_code'] = $order_vnpost['CustomerCode'];
		
		$row['date_add'] = NV_CURRENTTIME;
		
		$row['doisoat'] = 0;
		
		$row['cod'] = $order_vnpost['CodAmountEvaluation'];
		
		$stmt = $db->prepare('INSERT INTO ' . TABLE . '_history_vnpos (order_id, id_vnpost, order_code, name_products, total_weight_convert, total_weight, total_length, total_width, total_height, total_moeny, tinhthanh_gui, quanhuyen_gui, address_gui, phone_gui, name_gui, userid_add, tinhthanh_nhan, quanhuyen_nhan, address_nhan, phone_nhan, name_nhan, item_code, cuoc_phi, tongcuocdichvucongthem, tongcuocbaogomdvct, hinhthuc_vc, vnpost_status, customer_code, date_add, doisoat,cod) VALUES (:order_id, :id_vnpost, :order_code, :name_products, :total_weight_convert, :total_weight, :total_length, :total_width, :total_height, :total_moeny, :tinhthanh_gui, :quanhuyen_gui, :address_gui, :phone_gui, :name_gui, :userid_add, :tinhthanh_nhan, :quanhuyen_nhan, :address_nhan, :phone_nhan, :name_nhan, :item_code, :cuoc_phi, :tongcuocdichvucongthem, :tongcuocbaogomdvct, :hinhthuc_vc, :vnpost_status, :customer_code, :date_add, :doisoat,:cod)');
		
		$stmt->bindParam(':order_id', $row['order_id'], PDO::PARAM_INT);
		$stmt->bindParam(':id_vnpost', $row['id_vnpost'], PDO::PARAM_STR);
		$stmt->bindParam(':order_code', $row['order_code'], PDO::PARAM_STR);
		$stmt->bindParam(':name_products', $row['name_products'], PDO::PARAM_STR, strlen($row['name_products']));
		$stmt->bindParam(':total_weight_convert', $row['total_weight_convert'], PDO::PARAM_STR);
		$stmt->bindParam(':total_weight', $row['total_weight'], PDO::PARAM_STR);
		$stmt->bindParam(':total_length', $row['total_length'], PDO::PARAM_STR);
		$stmt->bindParam(':total_width', $row['total_width'], PDO::PARAM_STR);
		$stmt->bindParam(':total_height', $row['total_height'], PDO::PARAM_STR);
		$stmt->bindParam(':total_moeny', $row['total_moeny'], PDO::PARAM_STR);
		$stmt->bindParam(':tinhthanh_gui', $row['tinhthanh_gui'], PDO::PARAM_INT);
		$stmt->bindParam(':quanhuyen_gui', $row['quanhuyen_gui'], PDO::PARAM_INT);
		$stmt->bindParam(':address_gui', $row['address_gui'], PDO::PARAM_STR);
		$stmt->bindParam(':phone_gui', $row['phone_gui'], PDO::PARAM_STR);
		$stmt->bindParam(':name_gui', $row['name_gui'], PDO::PARAM_STR);
		$stmt->bindParam(':userid_add', $user_info['userid'], PDO::PARAM_INT);
		$stmt->bindParam(':tinhthanh_nhan', $row['tinhthanh_nhan'], PDO::PARAM_INT);
		$stmt->bindParam(':quanhuyen_nhan', $row['quanhuyen_nhan'], PDO::PARAM_INT);
		$stmt->bindParam(':address_nhan', $row['address_nhan'], PDO::PARAM_STR);
		$stmt->bindParam(':phone_nhan', $row['phone_nhan'], PDO::PARAM_STR);
		$stmt->bindParam(':name_nhan', $row['name_nhan'], PDO::PARAM_STR);
		$stmt->bindParam(':item_code', $row['item_code'], PDO::PARAM_STR);
		$stmt->bindParam(':cuoc_phi', $row['cuoc_phi'], PDO::PARAM_STR);
		$stmt->bindParam(':tongcuocdichvucongthem', $row['tongcuocdichvucongthem'], PDO::PARAM_STR);
		$stmt->bindParam(':tongcuocbaogomdvct', $row['tongcuocbaogomdvct'], PDO::PARAM_STR);
		$stmt->bindParam(':hinhthuc_vc', $row['hinhthuc_vc'], PDO::PARAM_STR);
		$stmt->bindParam(':vnpost_status', $row['vnpost_status'], PDO::PARAM_INT);
		$stmt->bindParam(':customer_code', $row['customer_code'], PDO::PARAM_STR);
		$stmt->bindParam(':date_add', $row['date_add'], PDO::PARAM_INT);
		$stmt->bindParam(':doisoat', $row['doisoat'], PDO::PARAM_INT);
		$stmt->bindParam(':cod', $row['cod'], PDO::PARAM_STR);
		
		$exc = $stmt->execute();
		
		
		// cập nhật trạng thái khiếu nại thành trạng thái mới
		// kiểm tra đơn hàng có phải của cửa hàng này không
		$weight = $db->query('SELECT status FROM '. TABLE .'_complain WHERE order_id = ' . $row['order_id'])->fetchColumn();
		
		if(!$weight)
		{
			return false;
		}
		
		
		
		$weight_next = $weight + 1;
		
		if(isset($global_status_complain[$weight_next]))
		{
			// cập nhật trạng thái mới
			$time_edit = NV_CURRENTTIME;
			
			$db->query('UPDATE '. TABLE .'_complain SET status = "'. $weight_next .'", time_edit = "'. $time_edit .'" WHERE order_id = ' . $row['order_id']);
			
		}
		else
		{
			return false;
		}
		
		
		// xử lý thông tin sau khi tạo vận đơn thành công status=2 đang giao hàng.
		$db->query('UPDATE '. TABLE .'_order SET status=2, shipping_code='.$db->quote($order_vnpost['ItemCode']).' where id='. $row['order_id']);
		$content='Chuyển sang đơn vị vận chuyển VNPOST Thành Công';
		$db->query('INSERT INTO '. TABLE .'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('. $row['order_id'] .',5,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
		
		// lưu lịch lịch sử vận đơn
		$db->query('INSERT INTO '. TABLE .'_history_vnpos_detail(order_id,itemcode,status_vnpost,user_add,addtime) VALUES('. $info_order['id'] .',"'. $order_vnpost['ItemCode'] .'", '. $order_vnpost['OrderStatusId'] .' ,'. $user_info['userid'] .','. NV_CURRENTTIME .')');
		
		// gửi thông báo đến shop đã lên đơn hàng vnpost
		$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ' đã lên đơn vận chuyển vnpost (Trả hàng)';
		nv_insert_notification_shop($user_info['userid'], $info_order['store_id'], $content_ip, $info_order['id'], "order");
		
		return true;
		
	}
	
	
	// cập nhật mã vận đơn vnpost vào database
	function update_vnpost($info_order, $order_vnpost)
	{
		global $db, $admin_info;
		
		// ghi lại lịch sử tạo vận đơn
		$row['order_id'] = $info_order['id'];
		$row['order_code'] = $info_order['order_code'];
		
		// xử lý danh sách sản phẩm trong đơn hàng
		$array_products = get_list_products_order($info_order['id']);
		
		$array_tam = array();
		foreach ($array_products as $product)
		{
			$array_tam[] = $product['name_product'];
		}
		
		$row['name_products'] = implode(', ', $array_tam);
		
		$row['id_vnpost'] = $order_vnpost['Id'];
		$row['total_weight_convert'] = $order_vnpost['WeightConvert'];
		$row['total_weight'] = $order_vnpost['WeightEvaluation'];
		$row['total_length'] = $order_vnpost['LengthEvaluation'];
		$row['total_width'] = $order_vnpost['WidthEvaluation'];
		$row['total_height'] = $order_vnpost['HeightEvaluation'];
		$row['total_moeny'] = $order_vnpost['OrderAmountEvaluation'];
		$row['tinhthanh_gui'] = $order_vnpost['SenderProvinceId'];
		$row['quanhuyen_gui'] = $order_vnpost['SenderDistrictId'];
		$row['address_gui'] = $order_vnpost['SenderAddress'];
		$row['phone_gui'] = $order_vnpost['SenderTel'];
		$row['name_gui'] = $order_vnpost['SenderFullname'];
		$row['userid_shop'] = $info_order['store_id'];
		$row['tinhthanh_nhan'] = $order_vnpost['ReceiverProvinceId'];
		$row['quanhuyen_nhan'] = $order_vnpost['ReceiverDistrictId'];
		$row['address_nhan'] = $order_vnpost['ReceiverAddress'];
		$row['phone_nhan'] = $order_vnpost['ReceiverTel'];
		$row['name_nhan'] = $order_vnpost['ReceiverFullname'];
		
		$row['item_code'] = $order_vnpost['ItemCode'];
		
		// Cước dịch vụ cộng thêm VAS tạm tính
		$row['tongcuocdichvucongthem'] = $order_vnpost['VasFreightEvaluation'];
		
		$row['tongcuocbaogomdvct'] = $order_vnpost['TotalFreightIncludeVatEvaluation'];
		
		$row['cuoc_phi'] = $row['tongcuocbaogomdvct'] - $row['tongcuocdichvucongthem'];
		
		
		
		$row['hinhthuc_vc'] = $order_vnpost['ServiceName'];
		
		/*
			Trạng thái null do đơn hàng mới tạo
			20: Đã tạo
			70: Thu gom thành công
			91: Phát chưa thành công
		*/
		$row['vnpost_status'] = $order_vnpost['OrderStatusId'];
		
		$row['customer_code'] = $order_vnpost['CustomerCode'];
		
		$row['date_add'] = NV_CURRENTTIME;
		
		$row['doisoat'] = 0;
		
		$row['cod'] = $order_vnpost['CodAmountEvaluation'];
		
		$stmt = $db->prepare('INSERT INTO ' . TABLE . '_history_vnpos (order_id, id_vnpost, order_code, name_products, total_weight_convert, total_weight, total_length, total_width, total_height, total_moeny, tinhthanh_gui, quanhuyen_gui, address_gui, phone_gui, name_gui, userid_add, tinhthanh_nhan, quanhuyen_nhan, address_nhan, phone_nhan, name_nhan, item_code, cuoc_phi, tongcuocdichvucongthem, tongcuocbaogomdvct, hinhthuc_vc, vnpost_status, customer_code, date_add, doisoat,cod) VALUES (:order_id, :id_vnpost, :order_code, :name_products, :total_weight_convert, :total_weight, :total_length, :total_width, :total_height, :total_moeny, :tinhthanh_gui, :quanhuyen_gui, :address_gui, :phone_gui, :name_gui, :userid_add, :tinhthanh_nhan, :quanhuyen_nhan, :address_nhan, :phone_nhan, :name_nhan, :item_code, :cuoc_phi, :tongcuocdichvucongthem, :tongcuocbaogomdvct, :hinhthuc_vc, :vnpost_status, :customer_code, :date_add, :doisoat,:cod)');
		
		$stmt->bindParam(':order_id', $row['order_id'], PDO::PARAM_INT);
		$stmt->bindParam(':id_vnpost', $row['id_vnpost'], PDO::PARAM_STR);
		$stmt->bindParam(':order_code', $row['order_code'], PDO::PARAM_STR);
		$stmt->bindParam(':name_products', $row['name_products'], PDO::PARAM_STR, strlen($row['name_products']));
		$stmt->bindParam(':total_weight_convert', $row['total_weight_convert'], PDO::PARAM_STR);
		$stmt->bindParam(':total_weight', $row['total_weight'], PDO::PARAM_STR);
		$stmt->bindParam(':total_length', $row['total_length'], PDO::PARAM_STR);
		$stmt->bindParam(':total_width', $row['total_width'], PDO::PARAM_STR);
		$stmt->bindParam(':total_height', $row['total_height'], PDO::PARAM_STR);
		$stmt->bindParam(':total_moeny', $row['total_moeny'], PDO::PARAM_STR);
		$stmt->bindParam(':tinhthanh_gui', $row['tinhthanh_gui'], PDO::PARAM_INT);
		$stmt->bindParam(':quanhuyen_gui', $row['quanhuyen_gui'], PDO::PARAM_INT);
		$stmt->bindParam(':address_gui', $row['address_gui'], PDO::PARAM_STR);
		$stmt->bindParam(':phone_gui', $row['phone_gui'], PDO::PARAM_STR);
		$stmt->bindParam(':name_gui', $row['name_gui'], PDO::PARAM_STR);
		$stmt->bindParam(':userid_add', $admin_info['userid'], PDO::PARAM_INT);
		$stmt->bindParam(':tinhthanh_nhan', $row['tinhthanh_nhan'], PDO::PARAM_INT);
		$stmt->bindParam(':quanhuyen_nhan', $row['quanhuyen_nhan'], PDO::PARAM_INT);
		$stmt->bindParam(':address_nhan', $row['address_nhan'], PDO::PARAM_STR);
		$stmt->bindParam(':phone_nhan', $row['phone_nhan'], PDO::PARAM_STR);
		$stmt->bindParam(':name_nhan', $row['name_nhan'], PDO::PARAM_STR);
		$stmt->bindParam(':item_code', $row['item_code'], PDO::PARAM_STR);
		$stmt->bindParam(':cuoc_phi', $row['cuoc_phi'], PDO::PARAM_STR);
		$stmt->bindParam(':tongcuocdichvucongthem', $row['tongcuocdichvucongthem'], PDO::PARAM_STR);
		$stmt->bindParam(':tongcuocbaogomdvct', $row['tongcuocbaogomdvct'], PDO::PARAM_STR);
		$stmt->bindParam(':hinhthuc_vc', $row['hinhthuc_vc'], PDO::PARAM_STR);
		$stmt->bindParam(':vnpost_status', $row['vnpost_status'], PDO::PARAM_INT);
		$stmt->bindParam(':customer_code', $row['customer_code'], PDO::PARAM_STR);
		$stmt->bindParam(':date_add', $row['date_add'], PDO::PARAM_INT);
		$stmt->bindParam(':doisoat', $row['doisoat'], PDO::PARAM_INT);
		$stmt->bindParam(':cod', $row['cod'], PDO::PARAM_STR);
		
		$exc = $stmt->execute();
		
		// xử lý thông tin sau khi tạo vận đơn thành công status=2 đơn hàng đang giao
		$db->query('UPDATE '. TABLE .'_order SET status=2, shipping_code='.$db->quote($order_vnpost['ItemCode']).' where id='. $row['order_id']);
		$content='Chuyển sang đơn vị vận chuyển VNPOST Thành Công';
		$db->query('INSERT INTO '. TABLE .'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('. $row['order_id'] .',2,'.$db->quote($content).','.NV_CURRENTTIME.','.$admin_info['userid'].')');
		//lich su admin
		$reason = $admin_info['username'] . ' đã gửi hàng VNPOST' ;
		insert_history_admin($admin_info['userid'], $reason);
		// lưu lịch lịch sử vận đơn
		$db->query('INSERT INTO '. TABLE .'_history_vnpos_detail(order_id,itemcode,status_vnpost,user_add,addtime) VALUES('. $info_order['id'] .',"'. $order_vnpost['ItemCode'] .'", '. $order_vnpost['OrderStatusId'] .' ,'. $admin_info['userid'] .','. NV_CURRENTTIME .')');
		
		// gửi thông báo đến shop đã lên đơn hàng vnpost
		$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ' đã lên đơn vận chuyển vnpost';
		nv_insert_notification_shop($admin_info['userid'], $info_order['store_id'], $content_ip, $info_order['id'], "order");
		
		return true;
		
	}
	
	// lay danh sach san pham trong order_id
	function get_list_products_order($order_id)
	{
		global $db, $db_config, $module_data, $module_upload, $module_name;
		
		if (!$order_id) return false;
		
		$list_products = $db->query("SELECT t1.id as itemid, t1.price, t1.classify_value_product_id, t1.quantity, t2.id, t2.name_product, t2.image, t2.alias FROM " . TABLE . "_order_item t1, " . TABLE . "_product t2  WHERE t1.product_id = t2.id AND t1.order_id =" . $order_id)->fetchAll();
		
		$array_product = array();
		
		foreach ($list_products as $view)
		{
			if ($view['classify_value_product_id'] > 0)
			{
				$classify_value_product_id = get_info_classify_value_product($view['classify_value_product_id']);
				$classify_id_value1 = get_info_classify_value($classify_value_product_id['classify_id_value1']);
				$name_classify_id_value1 = get_info_classify($classify_id_value1['classify_id']) ['name_classify'] . ' ' . $classify_id_value1['name'];
				if ($classify_value_product_id['classify_id_value2'] > 0)
				{
					$classify_id_value2 = get_info_classify_value($classify_value_product_id['classify_id_value2']);
					$name_classify_id_value2 = get_info_classify($classify_id_value2['classify_id']) ['name_classify'] . ' ' . $classify_id_value2['name'];
					$name_group = $name_classify_id_value1 . ', ' . $name_classify_id_value2;
				}
				else
				{
					$name_group = $name_classify_id_value1;
				}
				$view['name_group'] = '( ' . $name_group . ' )';
			}
			
			if (!empty($view['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $view['image']))
			{
				$view['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $view['image'];
			}
			else
			{
				$server = 'banhang.' . $_SERVER["SERVER_NAME"];
				$view['image'] = 'https://' . $server . NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $view['image'];
			}
			
			$view['price'] = number_format($view['price']);
			$view['quantity'] = number_format($view['quantity']);
			
			$view['alias_product'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $view['alias'].'-'.$view['id'], true );
			
			
			$array_product[] = $view;
			
		}
		
		return $array_product;
	}
	
	// get form add address
	function form_address()
	{
		
	}
	
	function lamtronstar($rate)
	{
		$chan = floor($rate);
		$le = (($rate * 10) % 10) / 10;
		
		if ($le > 0)
		{
			if ($le <= 0.5)
			{
				$chan = $chan + 0.5;
			}
			else
			{
				$chan = $chan + 1;
			}
		}
		
		return $chan;
		
	}
	
	
	function get_price_classify_new($product_id,$warehouse_id,$classify_id_value1,$classify_id_value2)
	{
		global $db, $module_data;
		
		if(!$product_id)
		return array();
		
		$result = $db->query('SELECT id, price, price_special, sl_tonkho FROM ' . TABLE .'_product_classify_value_product WHERE status = 1 AND product_id ='. $product_id .' AND classify_id_value1 ='. $classify_id_value1 .' AND classify_id_value2 =' . $classify_id_value2)->fetch();
		
		$store_id = get_info_product($product_id)['store_id'];
		
		
		if(isset($_SESSION[$module_data . '_cart'][$store_id][$warehouse_id]) and $result['id'])
		{
			foreach($_SESSION[$module_data . '_cart'][$store_id][$warehouse_id] as $product)
			{
				
				// kiểm tra id sản phẩm, thuộc tính sản phẩm
				if($product['product_id'] == $product_id)
				{
					// không có thuộc tính
					if(!$product['classify_value_product_id'])
					{
						$result['sl_tonkho'] = $result['sl_tonkho'] - $product['num'];
					}
					elseif($result['id'] == $product['classify_value_product_id'])
					{
						$result['sl_tonkho'] = $result['sl_tonkho'] - $product['num'];
					}
					
				}
				
			}
		}
		
		
		if($result)
		{
			// không có thuộc tính
			if($classify_id_value1 == $classify_id_value2)
			{
				$result['id'] = 0;
			}
			
			$result['price_format'] = number_format( $result['price'] );
			$result['price_special_format'] = number_format( $result['price_special'] );
			$result['sl_tonkho_format'] = number_format( $result['sl_tonkho'] );
			$result['status'] = 'OK';
		}
		else
		$result['status'] = 'ERROR';
		
		return $result;
		
	}
	
	// lấy giá theo thuộc tính sản phẩm
	function get_price_classify($product_id, $classify_id_value1, $classify_id_value2)
	{
		global $db, $db_config, $module_data;
		
		if (!$product_id) return 0;
		
		// số lượng thuộc tính sản phẩm
		$number_class = $db->query("SELECT count(id) as count FROM " . TABLE . "_product_classify WHERE product_id =" . $product_id)->fetchColumn();
		
		$where = '';
		
		if ($number_class == 0)
		{
			$price = $db->query("SELECT price FROM " . TABLE . "_product WHERE id =" . $product_id)->fetchColumn();
		}
		else
		{
			if ($number_class == 1 and $classify_id_value1)
			{
				$where .= ' AND classify_id_value1=' . $classify_id_value1;
				$price = $db->query("SELECT price FROM " . TABLE . "_product_classify_value_product WHERE 1=1" . $where)->fetchColumn();
			}
			elseif ($number_class == 2 and $classify_id_value1 and $classify_id_value2)
			{
				$where .= ' AND classify_id_value1=' . $classify_id_value1;
				$where .= ' AND classify_id_value2=' . $classify_id_value2;
				$price = $db->query("SELECT price FROM " . TABLE . "_product_classify_value_product WHERE 1=1" . $where)->fetchColumn();
			}
			
		}
		
		return $price;
		
	}
	
	function total_star_product($id)
	{
		global $db, $db_config, $module_data;
		
		if (!$id) return 0;
		
		$count = $db->query("SELECT count(*) as count FROM " . TABLE . "_rate WHERE product_id = " . $id)->fetchColumn();
		
		return $count;
		
	}
	
	function get_product_select2($q, $category_id)
	{
		global $db, $db_config, $module_data, $user_info;
		$list = $db->query('SELECT t1.product_id FROM ' . TABLE . '_category_shop_item t1 INNER JOIN ' . TABLE . '_product t2 ON t1.product_id = t2.id INNER JOIN ' . TABLE . '_seller_management t3 ON t3.id = t2.store_id WHERE t3.userid = ' . $user_info['userid'] . ' AND t1.id_category_shop IN (' . $category_id . ')')->fetchAll();
		$list_id = '';
		$i = 1;
		foreach ($list as $key => $value)
		{
			if ($i < count($list))
			{
				$list_id .= $value['product_id'] . ',';
			}
			else
			{
				$list_id .= $value['product_id'];
			}
			$i++;
		}
		if ($list_id)
		{
			$list_product = $db->query('SELECT t1.* FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_seller_management t2 ON t1.store_id = t2.id WHERE name_product LIKE "%' . $q . '%" AND t2.userid = ' . $user_info['userid'] . ' AND t1.id NOT IN (' . $list_id . ') ORDER BY t1.time_add ')->fetchAll();
		}
		else
		{
			$list_product = $db->query('SELECT t1.* FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_seller_management t2 ON t1.store_id = t2.id WHERE name_product LIKE "%' . $q . '%" AND t2.userid = ' . $user_info['userid'] . ' ORDER BY t1.time_add ')->fetchAll();
		}
		
		return $list_product;
	}
	function nv_delete_other_images_tmp($path, $thumb)
	{
		
		if (file_exists($thumb))
		{
			@nv_deletefile($thumb);
		}
		
		if (file_exists($path))
		{
			$deleted = @nv_deletefile($path);
			$result = $deleted[0] ? true : false;
			
			return $result;
		}
	}
	
	function validUserLog($array_user, $remember, $opid, $current_mode = 0)
	{
		global $db, $global_config, $nv_Request, $lang_module, $global_users_config, $module_name, $client_info;
		
		$remember = intval($remember);
		$checknum = md5(nv_genpass(10));
		$user = array(
        'userid' => $array_user['userid'],
        'current_mode' => $current_mode,
        'checknum' => $checknum,
        'checkhash' => md5($array_user['userid'] . $checknum . $global_config['sitekey'] . $client_info['browser']['key']) ,
        'current_agent' => NV_USER_AGENT,
        'last_agent' => $array_user['last_agent'],
        'current_ip' => NV_CLIENT_IP,
        'last_ip' => $array_user['last_ip'],
        'current_login' => NV_CURRENTTIME,
        'last_login' => intval($array_user['last_login']) ,
        'last_openid' => $array_user['last_openid'],
        'current_openid' => $opid
		);
		
		$stmt = $db->prepare("UPDATE " . NV_TABLE_USER . " SET
		checknum = :checknum,
		last_login = " . NV_CURRENTTIME . ",
		last_ip = :last_ip,
		last_agent = :last_agent,
		last_openid = :opid,
		remember = " . $remember . "
		WHERE userid=" . $array_user['userid']);
		
		$stmt->bindValue(':checknum', $checknum, PDO::PARAM_STR);
		$stmt->bindValue(':last_ip', NV_CLIENT_IP, PDO::PARAM_STR);
		$stmt->bindValue(':last_agent', NV_USER_AGENT, PDO::PARAM_STR);
		$stmt->bindValue(':opid', $opid, PDO::PARAM_STR);
		$stmt->execute();
		$live_cookie_time = ($remember) ? NV_LIVE_COOKIE_TIME : 0;
		
		$nv_Request->set_Cookie('nvloginhash', json_encode($user) , $live_cookie_time);
		
		if (!empty($global_users_config['active_user_logs']))
		{
			$log_message = $opid ? ($lang_module['userloginviaopt'] . ' ' . $opid) : $lang_module['st_login'];
			nv_insert_logs(NV_LANG_DATA, $module_name, '[' . $array_user['username'] . '] ' . $log_message, ' Client IP:' . NV_CLIENT_IP, 0);
		}
	}
	//phantrangajax//
	function nv_generate_page_viewcat($base_url, $num_items, $per_page, $on_page, $add_prevnext_text = true, $onclick = false, $js_func_name = 'nv_urldecode_ajax', $containerid = 'generate_page', $full_theme = true)
	{
		global $lang_global;
		// Round up total page
		$total_pages = ceil($num_items / $per_page);
		if ($total_pages < 2)
		{
			
			return '';
		}
		
		if (!is_array($base_url))
		{
			$amp = preg_match('/\?/', $base_url) ? '&amp;' : '?';
			$amp .= 'page=';
		}
		else
		{
			$amp = $base_url['amp'];
			$base_url = $base_url['link'];
		}
		
		$page_string = '';
		
		if ($total_pages > 10)
		{
			$init_page_max = ($total_pages > 3) ? 3 : $total_pages;
			
			for ($i = 1;$i <= $init_page_max;++$i)
			{
				$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
			}
			
			if ($total_pages > 3)
			{
				if ($on_page > 1 and $on_page < $total_pages)
				{
					if ($on_page > 5)
					{
						$page_string .= '<li class="disabled"><span>...</span></li>';
					}
					
					$init_page_min = ($on_page > 4) ? $on_page : 5;
					$init_page_max = ($on_page < $total_pages - 4) ? $on_page : $total_pages - 4;
					
					for ($i = $init_page_min - 1;$i < $init_page_max + 2;++$i)
					{
						$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
						$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
						$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
					}
					
					if ($on_page < $total_pages - 4)
					{
						$page_string .= '<li class="disabled"><span>...</span></li>';
					}
				}
				else
				{
					$page_string .= '<li class="disabled"><span>...</span></li>';
				}
				
				for ($i = $total_pages - 2;$i < $total_pages + 1;++$i)
				{
					$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
					$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
					$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
				}
			}
		}
		else
		{
			for ($i = 1;$i < $total_pages + 1;++$i)
			{
				$href = ($i > 1) ? $base_url . $amp . $i : $base_url . '&page=1';
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
			}
		}
		
		if ($add_prevnext_text)
		{
			if ($on_page > 1)
			{
				$href = ($on_page > 2) ? $base_url . $amp . ($on_page - 1) : $base_url . '&page=1';
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string = "<li><a " . $href . " title=\"" . $lang_global['pageprev'] . "\">&laquo;</a></li>" . $page_string;
			}
			else
			{
				$page_string = '<li class="disabled"><a href="#">&laquo;</a></li>' . $page_string;
			}
			
			if ($on_page < $total_pages)
			{
				$href = ($on_page) ? $base_url . $amp . ($on_page + 1) : $base_url . '&page=1';
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li><a ' . $href . ' title="' . $lang_global['pagenext'] . '">&raquo;</a></li>';
			}
			else
			{
				$page_string .= '<li class="disabled"><a href="#">&raquo;</a></li>';
			}
		}
		
		if ($full_theme !== true)
		{
			return $page_string;
		}
		
		return '<ul class="pagination">' . $page_string . '</ul>';
	}
	
	function nv_generate_page_wishlist($base_url, $num_items, $per_page, $on_page, $add_prevnext_text = true, $onclick = false, $js_func_name = 'nv_urldecode_ajax', $containerid = 'generate_page', $full_theme = true)
	{
		global $lang_global;
		// Round up total page
		$total_pages = ceil($num_items / $per_page);
		if ($total_pages < 2)
		{
			
			return '';
		}
		
		if (!is_array($base_url))
		{
			$amp = preg_match('/\?/', $base_url) ? '&amp;' : '?';
			$amp .= 'page=';
		}
		else
		{
			$amp = $base_url['amp'];
			$base_url = $base_url['link'];
		}
		
		$page_string = '';
		
		if ($total_pages > 10)
		{
			$init_page_max = ($total_pages > 3) ? 3 : $total_pages;
			
			for ($i = 1;$i <= $init_page_max;++$i)
			{
				$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
			}
			
			if ($total_pages > 3)
			{
				if ($on_page > 1 and $on_page < $total_pages)
				{
					if ($on_page > 5)
					{
						$page_string .= '<li class="disabled"><span>...</span></li>';
					}
					
					$init_page_min = ($on_page > 4) ? $on_page : 5;
					$init_page_max = ($on_page < $total_pages - 4) ? $on_page : $total_pages - 4;
					
					for ($i = $init_page_min - 1;$i < $init_page_max + 2;++$i)
					{
						$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
						$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
						$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
					}
					
					if ($on_page < $total_pages - 4)
					{
						$page_string .= '<li class="disabled"><span>...</span></li>';
					}
				}
				else
				{
					$page_string .= '<li class="disabled"><span>...</span></li>';
				}
				
				for ($i = $total_pages - 2;$i < $total_pages + 1;++$i)
				{
					$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
					$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
					$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
				}
			}
		}
		else
		{
			for ($i = 1;$i < $total_pages + 1;++$i)
			{
				$href = ($i > 1) ? $base_url . $amp . $i : $base_url . '&page=1';
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
			}
		}
		
		if ($add_prevnext_text)
		{
			if ($on_page > 1)
			{
				$href = ($on_page > 2) ? $base_url . $amp . ($on_page - 1) : $base_url . '&page=1';
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string = "<li><a " . $href . " title=\"" . $lang_global['pageprev'] . "\">&laquo;</a></li>" . $page_string;
			}
			else
			{
				$page_string = '<li class="disabled"><a href="#">&laquo;</a></li>' . $page_string;
			}
			
			if ($on_page < $total_pages)
			{
				$href = ($on_page) ? $base_url . $amp . ($on_page + 1) : $base_url . '&page=1';
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li><a ' . $href . ' title="' . $lang_global['pagenext'] . '">&raquo;</a></li>';
			}
			else
			{
				$page_string .= '<li class="disabled"><a href="#">&raquo;</a></li>';
			}
		}
		
		if ($full_theme !== true)
		{
			return $page_string;
		}
		
		return '<ul class="pagination">' . $page_string . '</ul>';
	}
	//phantrangajax//
	$list_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE status = 1')
    ->fetchAll();
	$list_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE status = 1')
    ->fetchAll();
	
	
	
	function get_brand_select2_cat($q, $cat_id)
	{
		global $db, $db_config, $module_data;
		
		$array_total = get_all_category_parent_childrent($cat_id);
		
		$where = '';
		if($array_total)
		{
			$where = ' AND id IN('. implode(',', $array_total) .')';
		}
		
		$list_brand = $db->query('SELECT brand FROM ' . TABLE . '_categories WHERE status = 1'. $where)->fetchAll();
		
		$list = array();
		
		foreach($list_brand as $brand)
		{
			if($brand['brand'])
			{
				
				$list_brand_item = explode('|', $brand['brand']);
				
				foreach ($list_brand_item as $key => $value)
				{
					$brand_list = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id =' . $value)->fetch();
					$list[$key] = $brand_list;
					
				}
			}
			
		}
		
		return $list;
	}
	
	
	// lấy tất cả parent_id và childrent
	function get_all_category_parent_childrent($catid)
	{
		$list_parent_catid = list_parent_catid_all($catid);
		$list_childrent_catid = list_childrent_catid($catid);
		
		$array_total = array_merge($list_parent_catid, $list_childrent_catid);
		$array_total = array_unique($array_total);
		
		return $array_total;
		
	}
	
	
	// lấy danh sách parent nhánh catid
	function list_parent_catid_all($id)
	{
		global $db, $module_data, $db_config, $list_parent_catid;
		
		if ($id)
		{
			$list_parent_catid[] = $id;
			
			$parrent_id = $db->query('SELECT parrent_id FROM ' . TABLE . '_categories WHERE id =' . $id)->fetchColumn();
			
			if ($parrent_id)
			{
				list_parent_catid_all($parrent_id);
			}
		}
		
		return $list_parent_catid;
		
	}
	
	
	// lấy danh sách childrent nhánh catid
	function list_childrent_catid($id)
	{
		global $db, $module_data, $db_config, $list_childrent_catid;
		
		if ($id)
		{
			$list_childrent_catid[] = $id;
			
			$array_parrent = $db->query('SELECT id FROM ' . TABLE . '_categories WHERE parrent_id =' . $id)->fetchAll();
			
			foreach($array_parrent as $parrent_id)
			{
				if ($parrent_id['id'])
				{
					list_childrent_catid($parrent_id['id']);
				}
			}
		}
		
		return $list_childrent_catid;
		
	}
	
	
	function get_origin_select2_cat($q)
	{
		global $db, $db_config, $module_data;
		
		// danh sách thương hiệu
		$where = '';
		if(!empty($q))
		{
			$where .= ' AND title like "%'. $q .'%"';
		}
		
		$data = $db->query('SELECT id, title FROM ' . TABLE . '_origin WHERE status = 1'. $where .' ORDER BY weight ASC')->fetchAll();
		
		return $data;
		
	}
	
	
	
	function get_info_account_bank($id)
	{
		global $db, $db_config, $module_data;
		$list = $db->query('SELECT t1.*,t2.bank_code FROM ' . NV_TABLE_WALLET . '_bank_acount t1 INNER JOIN ' . NV_TABLE_WALLET . '_bank t2 ON t1.acount_bankid=t2.bank_id where t1.id=' . $id)->fetch();
		return $list;
	}
	function get_list_account_bank_select2($q, $userid)
	{
		global $db, $db_config, $module_data;
		$list_brand = $db->query('SELECT t1.*,t2.name_bank FROM ' . NV_TABLE_WALLET . '_bank_acount t1 INNER JOIN ' . NV_TABLE_WALLET . '_bank t2 ON t1.acount_bankid=t2.bank_id  WHERE (t1.acount_name LIKE "%' . $q . '%" OR t1.acount_number LIKE "%' . $q . '%" OR t1.acount_bankbranch LIKE "%' . $q . '%" OR t2.name_bank LIKE "%' . $q . '%") and t1.acount_userid=' . $userid)->fetchAll();
		return $list_brand;
	}
	
	function get_brand_select2($q)
	{
		global $db, $db_config, $module_data;
		
		$list_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE title LIKE "%' . $q . '%" ORDER BY title')->fetchAll();
		return $list_brand;
	}
	function get_origin_select2($q)
	{
		global $db, $db_config, $module_data;
		
		$list_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE title LIKE "%' . $q . '%" ORDER BY weight')->fetchAll();
		return $list_origin;
	}
	
	function get_province_select2($q)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . NV_TABLE_PROVINCE . " where title like '%" . str_replace(' ', '%', $q) . "%' and countryid=1 ORDER BY weight ASC")->fetchAll();
		
		return $list;
	}
	function get_district_select2($q, $provinceid)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . NV_TABLE_DISTRICT . " where title like '%" . str_replace(' ', '%', $q) . "%' and provinceid=" . $provinceid)->fetchAll();
		
		return $list;
	}
	function get_warehouse_select2($q, $sell_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_warehouse where name_warehouse like '%" . str_replace(' ', '%', $q) . "%' and sell_id=" . $sell_id . " and status=1")->fetchAll();
		
		return $list;
	}
	function get_list_warehouse($sell_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_warehouse where sell_id=" . $sell_id . " and status=1")->fetchAll();
		
		return $list;
	}
	function get_full_classify($product_id)
	{
		global $db;
		$list = $db->query("SELECT t1.* FROM " . TABLE . "_product_classify t1 INNER JOIN  " . TABLE . "_product_classify_value t2 ON t1.id=t2.classify_id INNER JOIN " . TABLE . "_product_classify_value_product t3 ON (t2.id=t3.classify_id_value1 OR t2.id=t3.classify_id_value2) where t1.product_id=" . $product_id . " and t3.status=1 group by t1.id")->fetchAll();
		
		return $list;
	}
	function get_full_classify_value($classify_id)
	{
		global $db;
		$list = $db->query("SELECT t1.* FROM " . TABLE . "_product_classify_value t1 INNER JOIN " . TABLE . "_product_classify_value_product t2 ON (t1.id=t2.classify_id_value1 OR t1.id=t2.classify_id_value2) where t1.classify_id=" . $classify_id . " and t2.status=1 group by t1.id")->fetchAll();
		
		return $list;
	}
	function get_full_classify_value_product($classify_id_value1, $classify_id_value2)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_product_classify_value_product where classify_id_value1=" . $classify_id_value1 . " and classify_id_value2=" . $classify_id_value2 . " and status=1")->fetchAll();
		
		return $list;
	}
	function get_info_classify_value_product($id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_product_classify_value_product where id=" . $id)->fetch();
		
		return $list;
	}
	function get_info_classify_value_product_classify_id_value1_classify_id_value2($classify_id_value1, $classify_id_value2)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_product_classify_value_product where classify_id_value1=" . $classify_id_value1 . " and classify_id_value2=" . $classify_id_value2)->fetch();
		
		return $list;
	}
	function get_info_classify_value_product_classify_id_value1($classify_id_value1)
	{
		global $db;
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_product_classify_value_product where classify_id_value1=" . $classify_id_value1 . " and status=1")->fetchColumn();
		
		return $list;
	}
	function get_info_classify_value_product_classify_id_value2($classify_id_value2)
	{
		global $db;
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_product_classify_value_product where classify_id_value2=" . $classify_id_value2 . " and status=1")->fetchColumn();
		
		return $list;
	}
	
	function get_info_classify($id)
	{
		global $db;
		if(!$id)
		return ;
		$list = $db->query("SELECT * FROM " . TABLE . "_product_classify where id=" . $id)->fetch();
		
		return $list;
	}
	function get_info_classify_value($id)
	{
		global $db;
		
		if(!$id)
		return array();
		
		$list = $db->query("SELECT * FROM " . TABLE . "_product_classify_value where id=" . $id)->fetch();
		return $list;
	}
	function get_info_ward($wardid)
	{
		if(!$wardid)
		return array();
		
		global $db;
		$list = $db->query("SELECT * FROM " . NV_TABLE_WARD . " WHERE wardid = " . $wardid)->fetch();
		return $list;
	}
	function get_info_order($id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_order where id=" . $id)->fetch();
		return $list;
	}
	function convert_vi_to_en($str)
	{
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
		$str = preg_replace("/(đ)/", "d", $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
		$str = preg_replace("/(Đ)/", "D", $str);
		
		$str = str_replace(" ", "", str_replace("&*#39;", "", $str));
		return $str;
	}
	function get_id_shop_from_user_id($id)
	{
		global $db;
		$id = $db->query("SELECT id FROM " . TABLE . "_seller_management where userid=" . $id)->fetchColumn();
		return $id;
	}
	function get_info_order_status($id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_status_order where status_id=" . $id)->fetch();
		return $list;
	}
	function get_full_order_status()
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_status_order WHERE status = 1 ORDER BY weight ASC")
        ->fetchAll();
		return $list;
	}
	function get_count_order_customer($status_id, $userid, $ngay_tu, $ngay_den, $q)
	{
		global $db;
		$where = '';
		if ($ngay_tu > 0 and $ngay_den > 0)
		{
			$where .= ' AND time_add >= ' . $ngay_tu . ' AND time_add <= ' . $ngay_den;
		}
		if (!empty($q))
		{
			$where .= ' AND (order_code LIKE "%" "' . $q . '" "%")';
		}
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_order where status=" . $status_id . " and userid=" . $userid . $where)->fetchColumn();
		
		return $list;
	}
	function get_full_customer()
	{
		global $db;
		$list = $db->query("SELECT t1.*, t2.last_name FROM " . TABLE . "_customer t1 INNER JOIN " . NV_TABLE_USER . " t2 on t1.userid=t2.userid where t1.status=1 ")
        ->fetchAll();
		return $list;
	}
	
	function get_count_order_customer_time_add($status_id, $userid, $ngay_tu, $ngay_den)
	{
		global $db;
		$where = '';
		$ngay_tu = strtotime($ngay_tu);
		
		$ngay_den = strtotime('+23 hour 59 minutes', strtotime($ngay_den));
		
		if ($ngay_tu > 0 and $ngay_den > 0)
		{
			$where .= ' AND time_add >= ' . $ngay_tu . ' AND time_add <= ' . $ngay_den;
		}
		else if ($ngay_tu > 0)
		{
			$where .= ' AND time_add >= ' . $ngay_tu;
		}
		else if ($ngay_den > 0)
		{
			$where .= ' AND time_add <= ' . $ngay_den;
		}
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_order where status=" . $status_id . ' and userid=' . $userid . $where)->fetchColumn();
		return $list;
	}
	function get_count_order($status_id, $store_id, $warehouse_id, $ngay_tu, $ngay_den, $customer_id = 0, $categories_id = 0)
	{
		global $db;
		$where = '';
		
		if ($ngay_tu > 0 and $ngay_den > 0)
		{
			$where .= ' AND t1.time_add >= ' . $ngay_tu . ' AND t1.time_add <= ' . $ngay_den;
		}
		if ($customer_id > 0)
		{
			$where .= ' AND t1.userid =' . $customer_id;
		}
		if ($categories_id > 0)
		{
			$where .= ' AND t2.product_id IN (SELECT id FROM ' . TABLE . '_product where categories_id=' . $categories_id . ')';
		}
		if ($store_id == 0)
		{
			$list = $db->query("SELECT count(DISTINCT t1.id) FROM " . TABLE . "_order t1 INNER JOIN " . TABLE . "_order_item t2 ON t1.id=t2.order_id where t1.status=" . $status_id . $where)->fetchColumn();
		}
		else
		{
			if ($warehouse_id == 0)
			{
				$list = $db->query("SELECT count(DISTINCT t1.id) FROM " . TABLE . "_order t1 INNER JOIN " . TABLE . "_order_item t2 ON t1.id=t2.order_id where t1.status=" . $status_id . " and t1.store_id=" . $store_id . $where)->fetchColumn();
			}
			else
			{
				$list = $db->query("SELECT count(DISTINCT t1.id) FROM " . TABLE . "_order t1 INNER JOIN " . TABLE . "_order_item t2 ON t1.id=t2.order_id where t1.status=" . $status_id . " and t1.store_id=" . $store_id . " and t1.warehouse_id=" . $warehouse_id . $where)->fetchColumn();
			}
		}
		return $list;
	}
	function check_status_transporters_shop($sell_id, $transporters_id)
	{
		global $db;
		$list = $db->query("SELECT status FROM " . TABLE . "_transporters_shop where sell_id=" . $sell_id . ' and transporters_id=' . $transporters_id)->fetchColumn();
		return $list;
	}
	function count_transporters_shop($sell_id, $transporters_id)
	{
		global $db;
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_transporters_shop where sell_id=" . $sell_id . ' and transporters_id=' . $transporters_id)->fetchColumn();
		return $list;
	}
	function get_info_district($districtid)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . NV_TABLE_DISTRICT . " where districtid=" . $districtid)->fetch();
		return $list;
	}
	function get_info_province($provinceid)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . NV_TABLE_PROVINCE . " where provinceid=" . $provinceid)->fetch();
		return $list;
	}
	function get_info_warehouse($store_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_warehouse where id=" . $store_id)->fetch();
		return $list;
	}
	function get_info_warehouse_store($store_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_warehouse where sell_id=" . $store_id)->fetch();
		return $list;
	}
	function get_ward_select2($q, $districtid)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . NV_TABLE_WARD . " where title like '%" . str_replace(' ', '%', $q) . "%' and districtid=" . $districtid)->fetchAll();
		
		return $list;
	}
	
	function get_bank_select2($q)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_bank where name_bank like '%" . str_replace(' ', '%', $q) . "%' OR bank_code like '%" . str_replace(' ', '%', $q) . "%'")->fetchAll();
		
		return $list;
	}
	function get_info_group($group_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_group where id=" . $group_id)->fetch();
		return $list;
	}
	function get_info_transporters($transporters_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_transporters where id=" . $transporters_id)->fetch();
		return $list;
	}
	
	function get_info_user_fullname($userid)
	{
		global $db;
		
		$last_name = $db->query("SELECT last_name FROM " . NV_TABLE_USER . " where userid=" . $userid)->fetchColumn();
		
		return $last_name;
	}
	
	function get_info_user($userid)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . NV_TABLE_USER . " where userid=" . $userid)->fetch();
		
		return $list;
	}
	function get_info_user_shops_username($username)
	{
		global $db;
		$list = $db->query("SELECT t2.*, t1.userid as userid_shop FROM " . NV_TABLE_USER . " t1 INNER JOIN " . TABLE . "_seller_management t2 ON t1.userid = t2.userid where t1.username=" . $db->quote($username))->fetch();
		
		return $list;
	}
	function get_info_bank($bank_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_bank where bank_id=" . $bank_id)->fetch();
		
		return $list;
	}
	function count_category($id)
	{
		global $db;
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_categories where parrent_id=" . $id)->fetchColumn();
		
		return $list;
	}
	
	function count_product_block($id)
	{
		global $db;
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_block_id where bid=" . $id)->fetchColumn();
		return $list;
	}
	function count_product_cat($id)
	{
		global $db;
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_product where categories_id=" . $id)->fetchColumn();
		return $list;
	}
	function count_product_cat_shop($id, $store_id)
	{
		global $db;
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_product where categories_id=" . $id . " and store_id=" . $store_id)->fetchColumn();
		return $list;
	}
	
	function count_group($id)
	{
		global $db;
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_group where parrent_id=" . $id)->fetchColumn();
		return $list;
	}
	function get_categories_select2($q, $idsite, $parrent_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories where name like '%" . str_replace(' ', '%', $q) . "%' and status=1 and idsite=0 and parrent_id=" . $parrent_id .' ORDER BY weight ASC')->fetchAll();
		
		return $list;
	}
	function get_full_product_classify_sellect2($q)
	{
		global $db;
		
		$list = $db->query("SELECT t1.*,t1.price as price_product_classify_value_product,t1.price_special as price_special_product_classify_value_product ,t4.* FROM " . TABLE . "_product_classify_value_product t1 INNER JOIN " . TABLE . "_product_classify_value t2 ON (t1.classify_id_value1=t2.id OR t1.classify_id_value2=t2.id) INNER JOIN " . TABLE . "_product_classify t3 ON t2.classify_id=t3.id INNER JOIN " . TABLE . "_product t4 ON t3.product_id=t4.id where t1.status=1 and (t4.name_product like '%" . str_replace(' ', '%', $q) . "%' OR t3.name_classify like '%" . str_replace(' ', '%', $q) . "%' OR t2.name like '%" . str_replace(' ', '%', $q) . "%') group by t1.id limit 30")->fetchAll();
		
		return $list;
	}
	function get_info_product_classify($id)
	{
		global $db;
		
		$list = $db->query("SELECT t1.*,t1.price as price_product_classify_value_product,t1.price_special as price_special_product_classify_value_product ,t4.* FROM " . TABLE . "_product_classify_value_product t1 INNER JOIN " . TABLE . "_product_classify_value t2 ON (t1.classify_id_value1=t2.id OR t1.classify_id_value2=t2.id) INNER JOIN " . TABLE . "_product_classify t3 ON t2.classify_id=t3.id INNER JOIN " . TABLE . "_product t4 ON t3.product_id=t4.id where t1.id=" . $id)->fetch();
		
		return $list;
	}
	function get_categories_select2_full($q, $idsite)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories where name like '%" . str_replace(' ', '%', $q) . "%' and status=1 and  idsite=0")->fetchAll();
		
		return $list;
	}
	function get_categories_select_2($q)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories where name like '%" . str_replace(' ', '%', $q) . "%' and status=1")->fetchAll();
		
		return $list;
	}
	function get_full_unit_weight()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_unit_weight where status=1")
        ->fetchAll();
		
		return $list;
	}
	function get_full_unit()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_unit where status=1")
        ->fetchAll();
		
		return $list;
	}
	function get_full_unit_currency()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_unit_currency where status=1")
        ->fetchAll();
		
		return $list;
	}
	function get_info_currency($currency_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_unit_currency where id=" . $currency_id)->fetch();
		
		return $list;
	}
	function get_info_unit_length($currency_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_unit_length where id=" . $currency_id)->fetch();
		
		return $list;
	}
	function get_info_unit_weight($currency_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_unit_weight where id=" . $currency_id)->fetch();
		
		return $list;
	}
	function get_full_transporters($store_id)
	{
		global $db;
		$list = $db->query("SELECT t1.* FROM " . TABLE . "_transporters t1 LEFT JOIN " . TABLE . "_transporters_shop t2 ON t1.id=t2.transporters_id where t2.status=1 and t2.sell_id=" . $store_id . " and t1.status = 1 GROUP BY t1.id ORDER BY t1.weight ASC")->fetchAll();
		return $list;
	}
	function get_full_block()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_block where status=1")
        ->fetchAll();
		
		return $list;
	}
	function get_full_unit_length()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_unit_length where status=1")
        ->fetchAll();
		
		return $list;
	}
	function get_full_group($parrent_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_group where parrent_id=" . $parrent_id)->fetchAll();
		
		return $list;
	}
	function get_full_store()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_seller_management where status=1")
        ->fetchAll();
		
		return $list;
	}
	function get_info_category($categories_id)
	{
		global $db;
		
		if(!$categories_id)
		return array();
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories where id=" . $categories_id)->fetch();
		
		return $list;
	}
	function get_info_user_login($userid)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_seller_management where userid=" . $userid . " and status=1")->fetch();
		return $list;
	}
	
	function get_list_category($parrent_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories where parrent_id=" . $parrent_id)->fetchAll();
		
		return $list;
	}
	function get_list_full_category()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories")
        ->fetchAll();
		return $list;
	}
	
	function get_list_full_category_lev1()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories WHERE parrent_id = 0")
        ->fetchAll();
		return $list;
	}
	
	// danh mục sản phẩm theo cửa hàng shop
	function get_list_full_category_shop($shop_id)
	{
		global $db;
		
		$list = $db->query("SELECT t1.id FROM " . TABLE . "_categories t1, " . TABLE . "_product t2 WHERE t1.id = t2.categories_id AND t2.store_id =" . $shop_id . ' AND t2.inhome = 1 GROUP BY t2.categories_id')->fetchAll();
		
		$arr = array();
		foreach ($list as $catid)
		{
			$arr[] = $catid['id'];
		}
		
		$list_new = array();
		
		if (!empty($arr))
		{
			$list_new = $db->query("SELECT * FROM " . TABLE . "_categories WHERE id IN(" . implode(',', $arr) . ") ORDER BY weight ASC")->fetchAll();
		}
		return $list_new;
		
	}
	
	// lấy tất cả thương hiệu của cửa hàng này ra
	function getbrand_all_store($shop_id)
	{
		global $db;
		
		$list = $db->query("SELECT brand FROM " . TABLE . "_product WHERE status = 1 AND store_id =" . $shop_id . ' GROUP BY brand')->fetchAll();
		
		$getcatid_all = array();
		foreach ($list as $brand)
		{
			$getcatid_all[] = $brand['brand'];
		}
		
		return $getcatid_all;
		
	}
	
	function get_info_shop($shop_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_seller_management where id=" . $shop_id)->fetch();
		return $list;
	}
	function get_full_category_home_not_parrent()
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories where inhome=1 and parrent_id=0")
        ->fetchAll();
		
		return $list;
	}
	function get_info_category_alias($alias)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_categories where alias=" . $db->quote($alias))->fetch();
		
		return $list;
	}
	
	function getbrand_all($getcatid_all)
	{
		global $db;
		if (!$getcatid_all) return array();
		
		$list = $db->query("SELECT brand FROM " . TABLE . "_categories where id IN(" . implode(',', $getcatid_all) . ") ")->fetchAll();
		
		$arr = array();
		
		foreach ($list as $brand)
		{
			$arr_br = explode('|', $brand['brand']);
			foreach ($arr_br as $br)
			{
				if (!in_array($br, $arr) and !empty($br)) $arr[] = $br;
			}
		}
		
		return $arr;
	}
	
	function getcatid_all($id)
	{
		global $db;
		
		$where = '';
		
		if($id)
		$where = " AND parrent_id=" . $id ;	
		
		$list = $db->query("SELECT id FROM " . TABLE . "_categories where 1=1" . $where . ' ORDER BY weight ASC')->fetchAll();
		
		$arr = array();
		$arr[] = $id;
		
		foreach ($list as $catid)
		{
			$arr[] = $catid['id'];
		}
		
		return $arr;
		
	}
	function get_info_category_shop_alias($alias)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_category_shop where alias=" . $db->quote($alias))->fetch();
		return $list;
	}
	function get_name_store($store_id)
	{
		global $db;
		$list = $db->query("SELECT company_name FROM " . TABLE . "_seller_management where id=" . $store_id)->fetchColumn();
		return $list;
	}
	
	function get_info_store($store_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_seller_management where id=" . $store_id)->fetch();
		return $list;
	}
	function get_info_store_userid($userid)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_seller_management where userid=" . $userid)->fetch();
		
		return $list;
	}
	function get_info_status_order_ghn($status_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_status_order_ghn where status=" . $db->quote($status_id))->fetch();
		
		return $list;
	}
	function get_info_status_vnpay($status_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_status_vnpay where status_id=" . $db->quote($status_id))->fetch();
		
		return $list;
	}
	
	function get_info_status_order_ghtk($status_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_status_order_ghtk where status=" . $db->quote($status_id))->fetch();
		
		return $list;
	}
	
	function check_block_id($bid, $product_id)
	{
		global $db;
		
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_block_id where bid=" . $bid . " and product_id=" . $product_id)->fetchColumn();
		
		return $list;
	}
	function get_info_product($product_id)
	{
		global $db, $module_name;
		
		if(!$product_id)
		return false;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_product where id=" . $product_id)->fetch();
		
		$list['link'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $list['alias'].'-'.$list['id'], true );
		
		return $list;
	}
	function get_list_product_cat($catid)
	{
		global $db;
		
		$list = $db->query("SELECT t1.* FROM " . TABLE . "_product t1 INNER JOIN " . TABLE . "_categories t2 ON t1.categories_id=t2.id where t2.id=" . $catid . " OR t2.parrent_id=" . $catid)->fetchAll();
		
		return $list;
	}
	function get_info_product_alias($alias)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_product where alias=" . $db->quote($alias))->fetch();
		
		return $list;
	}
	function get_warehouse_store($sell_id)
	{
		global $db;
		$list = $db->query("SELECT * FROM " . TABLE . "_warehouse where status=1 and sell_id=" . $sell_id)->fetchAll();
		
		return $list;
	}
	function get_count_warehouse_store($sell_id)
	{
		global $db;
		$list = $db->query("SELECT count(*) FROM " . TABLE . "_warehouse where status=1 and sell_id=" . $sell_id)->fetchColumn();
		
		return $list;
	}
	function get_list_item_warehouse_import($warehouse_product_import_id)
	{
		global $db;
		$list = $db->query("SELECT t1.*,t2.name_product, t2.barcode FROM " . TABLE . "_warehouse_import_item t1 INNER JOIN " . TABLE . "_product t2 ON t1.product_id=t2.id where warehouse_product_import_id=" . $warehouse_product_import_id)->fetchAll();
		
		return $list;
	}
	function get_info_brand($brand)
	{
		global $db;
		
		if(!$brand)
		return array();
		
		$list = $db->query("SELECT * FROM " . TABLE . "_brand where id=" . $brand . " and status=1")->fetch();
		return $list;
	}
	function get_info_orgin($origin)
	{
		global $db;
		
		if(!$origin)
		return array();
		
		$list = $db->query("SELECT title FROM " . TABLE . "_origin where id=" . $origin . " and status=1")->fetch();
		return $list;
	}
	
	function get_info_invetory($product_id, $warehouse_id)
	{
		global $db;
		
		$list = $db->query("SELECT t1.*,t2.status FROM " . TABLE . "_inventory_product t1 INNER JOIN " . TABLE . "_product_classify_value_product t2 ON t1.classify_value_product_id=t2.id where t1.product_id=" . $product_id . " and t1.warehouse_id=" . $warehouse_id)->fetchAll();
		
		return $list;
	}
	function get_info_invetory_no($product_id, $warehouse_id)
	{
		global $db;
		
		$list = $db->query("SELECT * FROM " . TABLE . "_inventory_product where amount > 0 and product_id=" . $product_id . " and warehouse_id=" . $warehouse_id)->fetchAll();
		
		return $list;
	}
	
	function get_info_invetory_group($product_id, $classify_value_product_id)
	{
		global $db;
		
		if(!$product_id)
		return array();
		
		if($classify_value_product_id)
		$where .= ' AND id =' . $classify_value_product_id;
		
		
		// lấy giá theo thuộc tính sản phẩm
		
		$result = $db->query("SELECT price, price_special, sl_tonkho FROM " . TABLE . "_product_classify_value_product WHERE product_id =". $product_id . $where)->fetch();
		
		return $result;
	}
	
	// tính phí ship khi đặt hàng phía back-end trước khi lưu vào database
	function get_free_ship_vnpost($warehouse_id, $weight_product, $length_product, $width_product, $height_product, $total, $province_id, $district_id, $transporters_id )
	{
		global $config_setting;
		
		if(!$weight_product and !$length_product and !$width_product and !$height_product)
		{
			return 0;
		}
		
		$province_id_vnpost_receive = get_info_province( $province_id )['vnpostid'];
		
		$district_id_vnpost_receive = get_info_district( $district_id )['vnpostid'];
		
		$info_warehouse = get_info_warehouse( $warehouse_id );
		
		$province_id_vnpost_send = get_info_province( $info_warehouse['province_id'] )['vnpostid'];
		$district_id_vnpost_send = get_info_district( $info_warehouse['district_id'] )['vnpostid'];
		
		if($transporters_id==5){
			$weight_quydoi=($length_product*$width_product*$height_product)/5000;
			}else{
			$weight_quydoi=($length_product*$width_product*$height_product)/6000;
		}
		
		if($weight_product<=($weight_quydoi*1000)){
			$weight_quydoi2=($weight_quydoi*1000);
			}else{
			$weight_quydoi2=$weight_product;
		}
		
		/*
			Mã dịch vụ cộng thêm *: DichVuCongThemId
			1: Khai giá 
			2: Báo Phát 
			3: COD 
			4: DichVuHoaDon
		*/
		$Dichvucongthem[] = array(
		'DichVuCongThemId'=>1,
		'TrongLuongQuyDoi'=> $weight_quydoi2,
		'SoTienTinhCuoc'=>$total,
		'MaTinhGui'=> $province_id_vnpost_send,
		'MaTinhNhan'=> $district_id_vnpost_send
		);
		$code_transporters = get_info_transporters( $transporters_id )['code_transporters'];
		
		// ThuCuocNguoiNhan True: Nếu có thu tiền COD, False: Không thu COD
		$ThuCuocNguoiNhan = false;
		
		$fee = get_price_vnpost( $code_transporters, $province_id_vnpost_send, $district_id_vnpost_send, $province_id_vnpost_receive, $district_id_vnpost_receive, $ThuCuocNguoiNhan, $Dichvucongthem, $length_product, $width_product, $height_product, $weight_product );
		
		if ( empty( $fee ) ) {
			
			return( array() );
			
			} else {
			if ( get_info_transporters( $transporters_id )['type'] == 0 ) {
				$tranposter_fee = $fee['TongCuocSauVAT']+get_info_transporters( $transporters_id )['money'];
				} else {
				$tranposter_fee = $fee['TongCuocSauVAT']-get_info_transporters( $transporters_id )['money'];
				if ( $tranposter_fee<0 ) {
					$tranposter_fee = 0;
				}
			} 
			
			// cộng thêm phí vận chuyển hệ thống sàn thương mại
			$tranposter_fee = $tranposter_fee + (($tranposter_fee * $config_setting['percent_of_ship'])/100);
			
			//print_r($phi_san_ship);die;
			
			
			$mod = $tranposter_fee%1000;
			if($mod>0){
				$thuong = ceil($tranposter_fee / 1000);
				$tranposter_fee=$thuong*1000;
			}
			
			// phí bảo hiểm seller chịu
			$fee_seller = $fee['TongCuocDichVuCongThem'];
			$mod = $fee_seller%1000;
			if($mod>0){
				$thuong = ceil($fee_seller / 1000);
				$fee_seller=$thuong*1000;
			}
		}
		/*
			$arr_fee = array();
			$arr_fee['fee'] = $tranposter_fee;
			$arr_fee['fee_seller'] = $fee_seller;
		*/
		return( $tranposter_fee );
	}
	
	function get_info_product_edit_product($product_id)
	{
		global $db;
		$list = $db->query("SELECT group_list FROM " . TABLE . "_product where id=" . $product_id)->fetchColumn();
		
		return $list;
	}
	function ag_weekday($agtoday)
	{
		//print_r($a); die;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		//print_r($a);die;
		$weekday = date('l', $agtoday);
		
		$weekday = strtolower($weekday);
		switch ($weekday)
		{
			case 'monday':
            $weekday = 2;
			break;
			case 'tuesday':
            $weekday = 3;
			break;
			case 'wednesday':
            $weekday = 4;
			break;
			case 'thursday':
            $weekday = 5;
			
			break;
			case 'friday':
            $weekday = 6;
			
			break;
			case 'saturday':
            $weekday = 7;
			break;
			default:
            $weekday = 8;
			break;
		}
		return $weekday;
	}
	
	$agtoday = ag_weekday(NV_CURRENTTIME);
	
	function nv_get_week_from_time($time)
	{
		$week = 1;
		$year = date('Y', $time);
		$real_week = array(
        $week,
        $year
		);
		$time_per_week = 86400 * 7;
		$time_start_year = mktime(0, 0, 0, 1, 1, $year);
		$time_first_week = $time_start_year - (86400 * (date('N', $time_start_year) - 1));
		
		$addYear = true;
		$num_week_loop = nv_get_max_week_of_year($year) - 1;
		
		for ($i = 0;$i <= $num_week_loop;$i++)
		{
			$week_begin = $time_first_week + $i * $time_per_week;
			$week_next = $week_begin + $time_per_week;
			
			if ($week_begin <= $time and $week_next > $time)
			{
				$real_week[0] = $i + 1;
				$addYear = false;
				break;
			}
		}
		if ($addYear)
		{
			$real_week[1] = $real_week[1] + 1;
		}
		
		return $real_week;
	}
	
	/**
		* nv_get_max_week_of_year()
		*
		* @param mixed $year
		* @return
	*/
	function nv_get_max_week_of_year($year)
	{
		$time_per_week = 86400 * 7;
		$time_start_year = mktime(0, 0, 0, 1, 1, $year);
		$time_first_week = $time_start_year - (86400 * (date('N', $time_start_year) - 1));
		
		if (date('Y', $time_first_week + ($time_per_week * 53) - 1) == $year)
		{
			return 53;
		}
		else
		{
			return 52;
		}
	}
	
	function nv_generate_page2($base_url, $num_items, $per_page, $on_page, $add_prevnext_text = true, $onclick = false, $js_func_name = 'nv_urldecode_ajax', $containerid = 'generate_page', $full_theme = true)
	{
		global $lang_global;
		
		// Round up total page
		$total_pages = ceil($num_items / $per_page);
		if ($total_pages < 2)
		{
			return '';
		}
		
		if (!is_array($base_url))
		{
			$amp = preg_match('/\?/', $base_url) ? '&amp;' : '?';
			$amp .= 'page2=';
		}
		else
		{
			$amp = $base_url['amp'];
			$base_url = $base_url['link'];
		}
		
		$page_string = '';
		
		if ($total_pages > 10)
		{
			$init_page_max = ($total_pages > 3) ? 3 : $total_pages;
			
			for ($i = 1;$i <= $init_page_max;++$i)
			{
				$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
			}
			
			if ($total_pages > 3)
			{
				if ($on_page > 1 and $on_page < $total_pages)
				{
					if ($on_page > 5)
					{
						$page_string .= '<li class="disabled"><span>...</span></li>';
					}
					
					$init_page_min = ($on_page > 4) ? $on_page : 5;
					$init_page_max = ($on_page < $total_pages - 4) ? $on_page : $total_pages - 4;
					
					for ($i = $init_page_min - 1;$i < $init_page_max + 2;++$i)
					{
						$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
						$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
						$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
					}
					
					if ($on_page < $total_pages - 4)
					{
						$page_string .= '<li class="disabled"><span>...</span></li>';
					}
				}
				else
				{
					$page_string .= '<li class="disabled"><span>...</span></li>';
				}
				
				for ($i = $total_pages - 2;$i < $total_pages + 1;++$i)
				{
					$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
					$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
					$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
				}
			}
		}
		else
		{
			for ($i = 1;$i < $total_pages + 1;++$i)
			{
				$href = ($i > 1) ? $base_url . $amp . $i : $base_url;
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li' . ($i == $on_page ? ' class="active"' : '') . '><a' . ($i == $on_page ? ' href="#"' : ' ' . $href) . '>' . $i . '</a></li>';
			}
		}
		
		if ($add_prevnext_text)
		{
			if ($on_page > 1)
			{
				$href = ($on_page > 2) ? $base_url . $amp . ($on_page - 1) : $base_url;
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string = "<li><a " . $href . " title=\"" . $lang_global['pageprev'] . "\">&laquo;</a></li>" . $page_string;
			}
			else
			{
				$page_string = '<li class="disabled"><a href="#">&laquo;</a></li>' . $page_string;
			}
			
			if ($on_page < $total_pages)
			{
				$href = ($on_page) ? $base_url . $amp . ($on_page + 1) : $base_url;
				$href = !$onclick ? "href=\"" . $href . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($href)) . "','" . $containerid . "')\"";
				$page_string .= '<li><a ' . $href . ' title="' . $lang_global['pagenext'] . '">&raquo;</a></li>';
			}
			else
			{
				$page_string .= '<li class="disabled"><a href="#">&raquo;</a></li>';
			}
		}
		
		if ($full_theme !== true)
		{
			return $page_string;
		}
		
		return '<ul class="pagination">' . $page_string . '</ul>';
	}
	
	$list_config_retails1 = $nv_Cache->db('SELECT config_name, config_value FROM ' . TABLE . '_config', '', 'retails');
	$Config_retails = array();
	foreach ($list_config_retails1 as $values)
	{
		$Config_retails[$values['config_name']] = $values['config_value'];
	}
	
	$list_config_retails = $Config_retails;
	
	$list_config_retails_sys1 = $nv_Cache->db('SELECT config_name, config_value FROM ' . $db_config['prefix'] . '_config', '', '');
	$Config_sys = array();
	foreach ($list_config_retails_sys1 as $values)
	{
		$Config_sys[$values['config_name']] = $values['config_value'];
	}
	
	$list_config_retails_sys = $Config_sys;
	
	function getConfig($module)
	{
		global $nv_Cache, $site_mods, $db_config;
		
		$list = $nv_Cache->db('SELECT config_name, config_value FROM ' . TABLE . '_config', '', $module);
		$Config = array();
		foreach ($list as $values)
		{
			$Config[$values['config_name']] = $values['config_value'];
		}
		unset($list);
		
		return $Config;
	}
	function get_data($url, $token)
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'h-token:' . $token,
        'Token:' . $token
		));
		
		$result = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($result, true);
		
		return $data;
	}
	
	function get_data_ahamove($url){
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://apistg.ahamove.com/v1/partner/register_account?mobile=0833081888&name=Ch%25E1%25BB%25A3+Nh%25C3%25A0+Gi%25C3%25A0u&address=H%25E1%25BB%2593+Ch%25C3%25AD+Minh&api_key=55f359a75c2ac74d8713893ecf50a9e521f41def',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		));
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		return $response;
		
	}
	
	function get_data_print_pdf($url, $token)
	{
		header("Content-Type: application/pdf");
		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'h-token:' . $token,
        'Token:' . $token
		));
		$result = curl_exec($ch);
		
		curl_close($ch);
		
		return $result;
	}
	
	
	function post_data_test($url, $param_array, $token)
	{
		
		$json = json_encode($param_array);
		// URL có chứa hai thông tin name và diachi
		$curl = curl_init($url);
		
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json) . '',
        'h-token:' . $token,
        'Token:' . $token
		));
		
		//print_r($json);die;
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($curl);
		
		$data = json_decode($result, true);
		
		curl_close($curl);
		
		return $data;
		
	}

	//viettel post
	function login_viettel_post()
	{
		global $config_setting;
		$url = 'https://partner.viettelpost.vn/v2/user/Login';
		$param = array(
        "USERNAME" => $config_setting['username_vtpost'],
        "PASSWORD" => $config_setting['password_vtpost']
		);
		$data = post_data($url, $param, '');
		
		return $data;
	}

	function create_warehouse_viettelpost($phone, $name, $address, $ward_id)
	{
		$url = 'https://partner.viettelpost.vn/v2/user/registerInventory';
		$param = array(
        "PHONE" => $phone,
        "NAME" => $name,
        "ADDRESS" => $address,
        "WARDS_ID" => $ward_id
		);
		$token = login_viettel_post();
		$data = post_data($url, $param, $token['data']['token']);
		return $data;
	}
	//viettel post
	
	function post_data($url, $param_array, $token)
	{
		$json = json_encode($param_array);
		// URL có chứa hai thông tin name và diachi
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json) . '',
        'h-token:' . $token,
        'Token:' . $token
		));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		$data = json_decode($result, true);
		curl_close($curl);
		return $data;
	}
	function get_token_vnpost()
	{
		global $config_setting;
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain . "/MobileAuthentication/GetAccessToken";
		
		$param = array(
        'TenDangNhap' => $config_setting['username_vnpost'],
        'MatKhau' => $config_setting['password_vnpost']
		);
		
		$data = post_data($url, $param, '');
		$result = $data['Token'];
		
		return $result;
	}
	
	
	function get_price_vnpost($MaDichVu, $MaTinhGui, $MaQuanGui, $MaTinhNhan, $MaQuanNhan, $ThuCuocNguoiNhan, $LstDichVuCongThem, $length_product, $width_product, $height_product, $weight_product)
	{
		$url = 'https://donhang.vnpost.vn/api/api/TinhCuoc/TinhTatCaCuoc';
		if ($ThuCuocNguoiNhan == true)
		{
			$param = array(
            "MaDichVu" => $MaDichVu,
            "MaTinhGui" => $MaTinhGui,
            "MaQuanGui" => $MaQuanGui,
            "MaTinhNhan" => $MaTinhNhan,
            "MaQuanNhan" => $MaQuanNhan,
            "Dai" => $length_product,
            "Rong" => $width_product,
            "Cao" => $height_product,
            "KhoiLuong" => $weight_product,
            "ThuCuocNguoiNhan" => $ThuCuocNguoiNhan,
            "LstDichVuCongThem" => $LstDichVuCongThem
			);
		}
		else
		{
			if (count($LstDichVuCongThem) > 0)
			{
				$param = array(
                "MaDichVu" => $MaDichVu,
                "MaTinhGui" => $MaTinhGui,
                "MaQuanGui" => $MaQuanGui,
                "MaTinhNhan" => $MaTinhNhan,
                "MaQuanNhan" => $MaQuanNhan,
                "Dai" => $length_product,
                "Rong" => $width_product,
                "Cao" => $height_product,
                "KhoiLuong" => $weight_product,
                "ThuCuocNguoiNhan" => $ThuCuocNguoiNhan,
                "LstDichVuCongThem" => $LstDichVuCongThem
				);
			}
			else
			{
				$param = array(
                "MaDichVu" => $MaDichVu,
                "MaTinhGui" => $MaTinhGui,
                "MaQuanGui" => $MaQuanGui,
                "MaTinhNhan" => $MaTinhNhan,
                "MaQuanNhan" => $MaQuanNhan,
                "Dai" => $length_product,
                "Rong" => $width_product,
                "Cao" => $height_product,
                "ThuCuocNguoiNhan" => $ThuCuocNguoiNhan,
                "KhoiLuong" => $weight_product
				);
			}
		}
		
		$token = get_token_vnpost();
		$data = post_data($url, $param, $token);
		//print_r($param);die; 
		return $data;
	}
	function barcode($itemcode)
	{
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain . "/Order/GetBarCode?itemCode=" . $itemcode;
		$token = get_token_vnpost();
		$data = get_data($url, $token);
		
		return $data;
	}
	function get_province_ghn()
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/master-data/province';
		$param = array(
        'token' => $config_setting['token_ghn']
		);
		$data = post_data($url, $param, $config_setting['token_ghn']);
		
		return $data;
	}
	function get_district_ghn($province_id)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/master-data/district';
		$param = array(
        'token' => $config_setting['token_ghn'],
        'province_id' => $province_id
		);
		$data = post_data($url, $param, $config_setting['token_ghn']);
		
		return $data;
	}
	function get_ward_ghn($district_id)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/master-data/ward';
		$param = array(
        'token' => $config_setting['token_ghn'],
        'district_id' => $district_id
		);
		
		$data = post_data($url, $param, $config_setting['token_ghn']);
		
		return $data;
	}
	function get_province_vt()
	{
		global $config_setting;
		$url = 'https://partner.viettelpost.vn/v2/categories/listProvinceById?provinceId=-1';
		
		$data = get_data($url, '');
		
		return $data;
	}
	function get_district_vt($province_id)
	{
		global $config_setting;
		$url = 'https://partner.viettelpost.vn/v2/categories/listDistrict?provinceId=' . $province_id;
		
		$data = get_data($url, '');
		
		return $data;
	}
	function get_ward_vt($district_id)
	{
		global $config_setting;
		$url = 'https://partner.viettelpost.vn/v2/categories/listWards?districtId=' . $district_id;
		
		$data = get_data($url, '');
		
		return $data;
	}
	function create_store_ghn($district_id, $ward_code, $name, $phone, $address)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/shop/register';
		$param = array(
        "district_id" => (int)$district_id,
        "ward_code" => (string)$ward_code,
        "name" => $name,
        "phone" => str_replace('-', '', $phone) ,
        "address" => $address
		);
		
		$data = post_data($url, $param, $config_setting['token_ghn']);
		return $data;
	}
	function get_service_ghn($shop_id, $district_from, $district_to)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/shipping-order/available-services';
		$param = array(
        "shop_id" => (int)$shop_id,
        "from_district" => (int)$district_from,
        "to_district" => (int)$district_to
		);
		
		$data = post_data_ghn($url, $param);
		return $data;
	}
	
	function post_data_ghn($url, $param)
	{
		global $config_setting;
		$json = json_encode($param);
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $json ,
		CURLOPT_HTTPHEADER => array(
		'token: ' . $config_setting['token_ghn'] ,
		'Content-Type: application/json'
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($response, true);
		return $data;
	}
	
	function get_price_ghn_2($service_type_id, $shop_id, $to_district_id, $to_ward_code, $height, $length, $weight, $width, $insurance_value, $from_district_id)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/shipping-order/fee';
		$param = array(
        "service_type_id" => (int)$service_type_id,
        "shop_id" => $shop_id,
        "from_district_id" => (int)$from_district_id,
        "to_district_id" => (int)$to_district_id,
        "to_ward_code" => (string)($to_ward_code) ,
        "height" => (int)$height,
        "length" => (int)$length,
        "weight" => (int)$weight,
        "width" => (int)$width,
        "insurance_value" => (int)$insurance_value,
        "coupon" => null
		);
		$data = post_data($url, $param, $config_setting['token_ghn']);
		
		return $data;
	}
	function get_price_ghn($service_id, $shop_id, $to_district_id, $to_ward_code, $height, $length, $weight, $width, $insurance_value, $from_district_id)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/shipping-order/fee';
		$param = array(
        "service_id" => (int)$service_id,
        "shop_id" => (int)$shop_id,
        "from_district_id" => (int)$from_district_id,
        "to_district_id" => (int)$to_district_id,
        "to_ward_code" => (string)($to_ward_code) ,
        "height" => (int)$height,
        "length" => (int)$length,
        "weight" => (int)$weight,
        "width" => (int)$width,
        "insurance_value" => (int)$insurance_value,
        "coupon" => null
		);
		$data = post_data($url, $param, $config_setting['token_ghn']);
		
		return $data;
	}
	
	
	function ghn_cancel($shop_id, $ship_code){
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/switch-status/cancel';
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
		"order_codes":["' . $ship_code . '"]
		}',
		CURLOPT_HTTPHEADER => array(
		'ShopId:' . $shop_id,
		'Token: ' . $config_setting['token_ghn'],
		'Content-Type: application/json'
		),
		));
		
		$result = curl_exec($curl);
		$data = json_decode($result, true);
		curl_close($curl);
		return $data;
		
	}
	//tính lại phí vận chuyển GHN
	
	function get_free_ship_ghn($service_id, $weight_product, $length_product, $width_product, $height_product, $total, $province_id, $district_id, $ward_id, $transporters_id, $shop_id )
	{
		global $config_setting;
		
		if(!$weight_product and !$length_product and !$width_product and !$height_product)
		return 0;
		
		$ward_id_ghn_receive = get_info_ward( $ward_id )['ghnid'];
		$district_id_ghn_receive = get_info_district( $district_id )['ghnid'];
		$info_warehouse = get_info_warehouse_store( $shop_id );
		$province_id_ghn_send = get_info_province( $info_warehouse['province_id'] )['ghnid'];
		$district_id_ghn_send = get_info_district( $info_warehouse['district_id'] )['ghnid'];
		$shop_id = $info_warehouse['shops_id_ghn'];
		$fee = get_price_ghn_2( $service_id, $shop_id, $district_id_ghn_receive, $ward_id_ghn_receive, $height_product, $length_product, $weight_product, $width_product, 0,$district_id_ghn_send );
		$tranposter_fee = $fee['data']['total'];
		
		
		if ( empty( $tranposter_fee ) ) {
			
			return( array() );
			}else{
			// cộng thêm phí vận chuyển hệ thống sàn thương mại
			$tranposter_fee = $tranposter_fee + (($tranposter_fee * $config_setting['percent_of_ship'])/100);
			
			$mod = $tranposter_fee%1000;
			if($mod>0){
				$thuong = ceil($tranposter_fee / 1000);
				$tranposter_fee=$thuong*1000;
			}
		}
		return $tranposter_fee;
	}
	function search_store_ghn($client_phone)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/shop/all';
		$param = array(
        "offset" => 0,
        "limit" => 50,
        "client_phone" => $client_phone
		);
		$data = post_data($url, $param, $config_setting['token_ghn']);
		
		return $data;
	}
	function get_price_ghtk($pick_address, $pick_province, $pick_district, $province, $district, $address, $weight, $transport, $deliver_option)
	{
		global $config_setting;
		$url = $config_setting['url_ghtk'] . '/services/shipment/fee';
		
		$param = array(
		"pick_address" => $pick_address,
		"pick_province" => $pick_province,
		"pick_district" => $pick_district,
		"address" => $address,
		"province" => $province,
		"district" => $district,
		"weight" => $weight,
		"transport" => $transport,
		"deliver_option" => $deliver_option
		);
		$data = post_data($url, $param, $config_setting['token_ghtk']);
		
		return $data;
	}
	function get_token_ahamove()
	{
		global $config_setting;
		$url = $config_setting['url_ahamove'] . '/v1/partner/register_account?mobile=0833081888&name=Chợ+Nhà+Giàu&address=Hồ+Chí+Minh&api_key=' . $config_setting['token_ahamove'];
		$data = get_data_ahamove($url);
		return $data;
	}
	
	function get_price_ahamove($token, $lat_send, $lng_send, $address_send, $short_address_send, $name_send, $lat_receive, $lng_receive, $address_receive, $name_receive, $service_id)
	{
		global $db, $config_setting;
		$address_send = str_replace(' ', '+', $address_send);
		$short_address_send = str_replace(' ', '+', $short_address_send);
		$name_send = str_replace(' ', '+', $name_send);
		$address_receive = str_replace(' ', '+', $address_receive);
		$name_receive = str_replace(' ', '+', $name_receive);
		$path = '[{"lat":' . $lat_send . ',"lng":' . $lng_send . ',"address":"' . $address_send . '","short_address":"' . $short_address_send . '","name":"' . $name_send . '","remarks":"call+me"},{"lat":' . $lat_receive . ',"lng":' . $lng_receive . ',"address":"' . $address_receive . '","name":"' . $name_receive . '"}]';
		$url = $config_setting['url_ahamove'] . '/v1/order/estimated_fee?token=' . $token . '&order_time=0&path=' . $path . '&service_id=' . $service_id . '&requests=[]&payment_method=BALANCE';
		$data = get_data($url, '');
		return $data;
	}
	function get_price_viettelpost($PRODUCT_PRICE, $MONEY_COLLECTION, $ORDER_SERVICE, $SENDER_PROVINCE, $SENDER_DISTRICT, $RECEIVER_PROVINCE, $RECEIVER_DISTRICT, $PRODUCT_TYPE, $NATIONAL_TYPE, $PRODUCT_WEIGHT, $PRODUCT_WIDTH, $PRODUCT_HEIGHT, $PRODUCT_LENGTH)
	{
		
		$url = 'https://partner.viettelpost.vn/v2/order/getPrice';
		$param = array(
        "PRODUCT_WEIGHT" => $PRODUCT_WEIGHT,
        "PRODUCT_PRICE" => $PRODUCT_PRICE,
        "MONEY_COLLECTION" => $MONEY_COLLECTION,
        "ORDER_SERVICE_ADD" => "",
        "ORDER_SERVICE" => $ORDER_SERVICE,
        "SENDER_PROVINCE" => $SENDER_PROVINCE,
        "SENDER_DISTRICT" => $SENDER_DISTRICT,
        "RECEIVER_PROVINCE" => $RECEIVER_PROVINCE,
        "RECEIVER_DISTRICT" => $RECEIVER_DISTRICT,
        "PRODUCT_TYPE" => $PRODUCT_TYPE,
        "NATIONAL_TYPE" => $NATIONAL_TYPE,
        "PRODUCT_WIDTH" => $PRODUCT_WIDTH,
        "PRODUCT_HEIGHT" => $PRODUCT_HEIGHT,
        "PRODUCT_LENGTH" => $PRODUCT_LENGTH
		);
		$token = login_viettel_post();
		
		$data = post_data($url, $param, $token['data']['token']);
		
		return $data;
	}
	function GetListBuuCucByXaHuyenTinh($MaTinhThanh, $MaQuanHuyen)
	{
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain . "/BuuCuc/GetListBuuCucByXaHuyenTinh";
		$param = array(
        "MaTinhThanh" => $MaTinhThanh,
        "MaQuanHuyen" => $MaQuanHuyen
		);
		
		$data = post_data($url, $param, '');
		
		return $data;
	}
	
	
	// hủy đơn hàng vnpost
	function cancel_tranpost_vnpost($id_vnpost)
	{
		$url = 'https://donhang.vnpost.vn/api/api/Order/CancelOrder?orderId=' . $id_vnpost;
		
		$token = get_token_vnpost();
		
		$data = post_data_mothod($url, $token);
		
		return json_decode($data,true);
	}
	
	
	function post_data_mothod($url, $token)
	{ 
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_HTTPHEADER => array(
		'Content-Length: 0',
		'h-token: ' . $token
		),
		));
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		return $response;
		
	}
	
	function send_vnpost($OrderCode, $PackageContent, $ServiceName, $SenderFullname, $SenderAddress, $SenderTel, $SenderProvinceId, $SenderDistrictId, $SenderWardId, $ReceiverFullname, $ReceiverAddress, $ReceiverTel, $ReceiverProvinceId, $ReceiverDistrictId, $ReceiverWardId, $CodAmountEvaluation, $PickupPoscode, $weight_product, $length_product, $width_product, $height_product, $total_money, $IsReceiverPayFreight = false)
	{
		$url = 'https://donhang.vnpost.vn/api/api/Order/CreateOrder';
		
		/*
			Hình thức thu gom *
			- 1: Pickup - Thu gom tận nơi
			- 2: Dropoff - Gửi hàng tại bưu cục
			
			IsPackageViewable boolean Có cho xem hàng hay không
			
			CodAmountEvaluation Tiền thu hộ COD
			
			IsReceiverPayFreight Cộng thêm cước vào tiền thu hộ  COD
			
			OrderAmountEvaluation tổng tiền > 0 là sử dụng dịch vụ khai báo giá
			
		*/
		$PickupType = 1;
		//$CodAmountEvaluation = 0;
		
		if ($PickupType == 1)
		{
			$param = array(
            "OrderCode" => $OrderCode,
            "VendorId" => 1,
            "PickupType" => $PickupType,
            "IsPackageViewable" => false,
            "PackageContent" => $PackageContent,
            "ServiceName" => $ServiceName,
            "SenderFullname" => $SenderFullname,
            "SenderAddress" => $SenderAddress,
            "SenderTel" => $SenderTel,
            "SenderProvinceId" => $SenderProvinceId,
            "SenderDistrictId" => $SenderDistrictId,
            "SenderWardId" => $SenderWardId,
            "ReceiverFullname" => $ReceiverFullname,
            "ReceiverAddress" => $ReceiverAddress,
            "ReceiverTel" => $ReceiverTel,
            "ReceiverProvinceId" => $ReceiverProvinceId,
            "ReceiverDistrictId" => $ReceiverDistrictId,
            "ReceiverWardId" => $ReceiverWardId,
            "ShipperTel" => "",
            "CodAmountEvaluation" => $CodAmountEvaluation,
            "WeightEvaluation" => $weight_product,
            "WidthEvaluation" => $width_product,
            "LengthEvaluation" => $length_product,
            "HeightEvaluation" => $height_product,
            "IsReceiverPayFreight" => $IsReceiverPayFreight,
            "OrderAmountEvaluation" => $total_money,
            "SenderAddressType" => 1
			);
			
		}
		
		$token = get_token_vnpost();
		
		$data = post_data_test($url, $param, $token);
		
		return $data;
		
	}
	

	function send_viettelpost($PRODUCT_PRICE, $MONEY_COLLECTION, $ORDER_SERVICE_ADD, $ORDER_SERVICE, $SENDER_PROVINCE, $SENDER_DISTRICT, $SENDER_WARD, $SENDER_LATITUDE, $SENDER_LONGITUDE, $RECEIVER_PROVINCE, $RECEIVER_DISTRICT, $PRODUCT_TYPE, $ORDER_NUMBER, $GROUPADDRESS_ID, $CUS_ID, $SENDER_FULLNAME, $SENDER_ADDRESS, $SENDER_PHONE, $RECEIVER_FULLNAME, $RECEIVER_ADDRESS, $RECEIVER_PHONE, $PRODUCT_NAME, $PRODUCT_DESCRIPTION, $PRODUCT_QUANTITY, $ORDER_PAYMENT, $list_item, $PRODUCT_WEIGHT, $PRODUCT_LENGTH, $PRODUCT_WIDTH, $PRODUCT_HEIGHT, $RECEIVER_WARD, $RECEIVER_LATITUDE, $RECEIVER_LONGITUDE)
	{
		
		$url = 'https://partner.viettelpost.vn/v2/order/createOrder';
		$param = array(
        "ORDER_NUMBER" => $ORDER_NUMBER,
        "GROUPADDRESS_ID" => $GROUPADDRESS_ID,
        "CUS_ID" => $CUS_ID,
        "DELIVERY_DATE" => '',
        "SENDER_FULLNAME" => $SENDER_FULLNAME,
        "SENDER_ADDRESS" => $SENDER_ADDRESS,
        "SENDER_PHONE" => $SENDER_PHONE,
        "SENDER_EMAIL" => '',
        "SENDER_PROVINCE" => $SENDER_PROVINCE,
        "SENDER_DISTRICT" => $SENDER_DISTRICT,
        "SENDER_WARD" => $SENDER_WARD,
        "SENDER_LATITUDE" => "",
        "SENDER_LONGITUDE" => "",
        "RECEIVER_FULLNAME" => $RECEIVER_FULLNAME,
        "RECEIVER_ADDRESS" => $RECEIVER_ADDRESS,
        "RECEIVER_MAIL" => '',
        "RECEIVER_PHONE" => $RECEIVER_PHONE,
        "RECEIVER_PROVINCE" => $RECEIVER_PROVINCE,
        "RECEIVER_DISTRICT" => $RECEIVER_DISTRICT,
        "RECEIVER_WARD" => $RECEIVER_WARD,
        "RECEIVER_LATITUDE" => "",
        "RECEIVER_LONGITUDE" => "",
        "PRODUCT_NAME" => $PRODUCT_NAME,
        "PRODUCT_DESCRIPTION" => $PRODUCT_DESCRIPTION,
        "PRODUCT_QUANTITY" => $PRODUCT_QUANTITY,
        "PRODUCT_PRICE" => $PRODUCT_PRICE,
        "PRODUCT_WEIGHT" => $PRODUCT_WEIGHT,
        "PRODUCT_LENGTH" => $PRODUCT_LENGTH,
        "PRODUCT_WIDTH" => $PRODUCT_WIDTH,
        "PRODUCT_HEIGHT" => $PRODUCT_HEIGHT,
        "PRODUCT_TYPE" => $PRODUCT_TYPE,
        "ORDER_PAYMENT" => $ORDER_PAYMENT,
        "ORDER_SERVICE" => $ORDER_SERVICE,
        "ORDER_SERVICE_ADD" => $ORDER_SERVICE_ADD,
        "ORDER_VOUCHER" => '',
        "ORDER_NOTE" => '',
        "MONEY_COLLECTION" => $MONEY_COLLECTION,
        "MONEY_TOTALFEE" => 0,
        "MONEY_FEECOD" => 0,
        "MONEY_FEEVAS" => 0,
        "MONEY_FEEINSURRANCE" => 0,
        "MONEY_FEE" => 0,
        "MONEY_FEEOTHER" => 0,
        "MONEY_TOTALVAT" => 0,
        "MONEY_TOTAL" => 0,
        "LIST_ITEM" => $list_item,
		);
		$token = login_viettel_post();
		
		$data = post_data($url, $param, $token['data']['token']);
		return $data;
	}
	function get_info_product_ghtk($q)
	{
		global $config_setting;
		$url = $config_setting['url_ghtk'] . '/services/kho-hang/thong-tin-san-pham?term=' . $q;
		$data = get_data($url, $config_setting['token_ghtk']);
		return $data;
	}
	
	function send_ghtk($products, $order_code, $pick_name, $pick_address, $pick_province, $pick_district, $pick_ward, $pick_tel, $tel, $name, $address, $province, $district, $ward, $pick_money, $value, $transport, $deliver_option)
	{
		global $config_setting;
		$url = $config_setting['url_ghtk'] . '/services/shipment/order/?ver=1.5';
		if ($transport == '')
		{
			$param = array(
            "products" => $products,
            "order" => array(
			"id" => $order_code,
			"pick_name" => $pick_name,
			"pick_address" => $pick_address,
			"pick_province" => $pick_province,
			"pick_district" => $pick_district,
			"pick_ward" => $pick_ward,
			"pick_tel" => $pick_tel,
			"tel" => $tel,
			"name" => $name,
			"address" => $address,
			"province" => $province,
			"district" => $district,
			"ward" => $ward,
			"hamlet" => "Khác",
			"is_freeship" => 1,
			"pick_money" => $pick_money,
			"note" => "",
			"value" => $value,
			"deliver_option" => $deliver_option
            )
			);
		}
		else
		{
			$param = array(
            "products" => $products,
            "order" => array(
			"id" => $order_code,
			"pick_name" => $pick_name,
			"pick_address" => $pick_address,
			"pick_province" => $pick_province,
			"pick_district" => $pick_district,
			"pick_ward" => $pick_ward,
			"pick_tel" => $pick_tel,
			"tel" => $tel,
			"name" => $name,
			"address" => $address,
			"province" => $province,
			"district" => $district,
			"ward" => $ward,
			"hamlet" => "Khác",
			"is_freeship" => 1,
			"pick_money" => $pick_money,
			"note" => "",
			"value" => $value,
			"transport" => $transport,
			"deliver_option" => $deliver_option
            )
			);
		}
		$data = post_data($url, $param, $config_setting['token_ghtk']);
		
		return $data;
	}
	function send_ghn($shop_id, $to_name, $to_phone, $to_address, $to_ward_code, $to_district_id, $content, $weight, $length, $width, $height, $insurance_value, $service_id, $required_note, $items, $pick_station_id,$cod_amount, $payment_type_id)
	{
		
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/shipping-order/create';
		$param = array(
        
        'to_name' => (string)$to_name,
        'to_phone' => (string)$to_phone,
        'return_address' => (string)$config_setting['address_ecng'],
        'to_address' => (string)$to_address,
        'to_ward_code' => (string)$to_ward_code,
        'to_district_id' => (int)$to_district_id,
        'content' => (string)$content,
        'weight' => (int)$weight,
        'length' => (int)$length,
        'width' => (int)$width,
        'height' => (int)$height,
        'pick_station_id' => (int)$pick_station_id,
        'insurance_value' => (int)$insurance_value,
        'service_type_id' => (int)$service_id,
        'payment_type_id' => (int)$payment_type_id,
        'note' => 'Vui lòng gọi trước khi giao hàng',
        'required_note' => (string)$required_note,
        'items' => $items,
        'cod_amount' => (int)$cod_amount
		);
		
		$data = post_data_send_ghn($url, $param, $shop_id);
		
		return $data;
	}
	
	function update_ghn_admin($info_order, $order_ghn){
		global $db, $admin_info;
		
		$order_id = $info_order['id'];
		$ghn_code = $order_ghn['code'];
		$ghn_order_code = $order_ghn['data']['order_code'];
		$ghn_fee_service = $order_ghn['data']['fee']['main_service'];
		$ghn_fee_insurance = $order_ghn['data']['fee']['insurance'];
		$ghn_fee_total = $order_ghn['data']['total_fee'];
		$ghn_message = $order_ghn['message'];
		
		$today = NV_CURRENTTIME;
		
		$stmt = $db->prepare('INSERT INTO ' . TABLE . '_history_ghn (order_id , user_add, code, order_code, main_service, insurance, total_fee, message, time_add ) VALUES (:order_id, :user_add, :code, :order_code, :main_service, :insurance, :total_fee, :message, :time_add )');
		
		$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
		$stmt->bindParam(':user_add', $admin_info['userid'], PDO::PARAM_INT);
		$stmt->bindParam(':code', $ghn_code, PDO::PARAM_INT);
		$stmt->bindParam(':order_code', $ghn_order_code, PDO::PARAM_STR);
		$stmt->bindParam(':main_service', $ghn_fee_service, PDO::PARAM_INT);
		$stmt->bindParam(':insurance', $ghn_fee_insurance, PDO::PARAM_INT);
		$stmt->bindParam(':total_fee', $ghn_fee_total, PDO::PARAM_INT);
		$stmt->bindParam(':message', $ghn_message, PDO::PARAM_STR);
		$stmt->bindParam(':time_add', $today, PDO::PARAM_INT);
		$exc = $stmt->execute();
		
		
		// xử lý thông tin sau khi tạo vận đơn thành công status = 2 đơn hàng đang giao
		$db->query('UPDATE '. TABLE .'_order SET status = 2, shipping_code = ' . $db->quote($ghn_order_code) . ' , time_edit = ' . $today . ' WHERE id = '. $info_order['id']);
		//ghi log
		$content = $admin_info[''] . ' đã lên đơn vận chuyển GHN'; 
		history_order($info_order['id'], 1, $content);
		// gửi thông báo đến shop đã lên đơn hàng GHN
		$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ' đã lên đơn vận chuyển GHN';
		nv_insert_notification_shop($admin_info['userid'], $info_order['store_id'], $content_ip, $info_order['id'], "order");
		return true;
	}
	
	function update_ghn_error_admin($info_order, $order_ghn){
		global $db, $admin_info;
		
		$order_id = $info_order['id'];
		$ghn_code = $order_ghn['code'];
		$ghn_message = $order_ghn['message'];
		$today = NV_CURRENTTIME;
		
		$stmt = $db->prepare('INSERT INTO ' . TABLE . '_history_ghn (order_id, user_add ,code, message, time_add ) VALUES (:order_id, :user_add, :code, :message, :time_add )');
		
		$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
		$stmt->bindParam(':user_add', $admin_info['userid'], PDO::PARAM_INT);
		$stmt->bindParam(':code', $ghn_code, PDO::PARAM_INT);
		$stmt->bindParam(':message', $ghn_message, PDO::PARAM_STR);
		$stmt->bindParam(':time_add', $today, PDO::PARAM_INT);
		$exc = $stmt->execute();
		
		return true;
	}
	
	function post_data_send_ghn($url, $param_array, $shop_id)
	{
		global $config_setting;
		$json = json_encode($param_array);
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $json,
		CURLOPT_HTTPHEADER => array(
		'ShopId: ' . (int)$shop_id,
		'Token: ' . $config_setting['token_ghn'],
		'Content-Type: application/json'
		),
		));
		
		$result = curl_exec($curl);
		$data = json_decode($result, true);
		curl_close($curl);
		
		return $data;
		
	}
	
	
	
	function post_data1($url, $param_array, $token)
	{
		$json = json_encode($param_array);
		// URL có chứa hai thông tin name và diachi
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json) . '',
        'h-token:' . $token,
        'Token:' . $token
		));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		$data = json_decode($result, true);
		curl_close($curl);
		return $data;
		
	}
	function send_ahamove($path, $service_id, $items, $payment_method)
	{
		global $db, $config_setting;
		$token = get_token_ahamove();
		$url = $config_setting['url_ahamove'] . '/v1/order/create?token=' . $token['token'] . '&order_time=0&path=' . json_encode($path) . '&service_id=' . $service_id . '&requests=[]&image=[]&remarks=' . urlencode("Gọi tôi khi đến") . '&idle_until=0&items=' . json_encode($items) . '&payment_method=' . $payment_method;
		$data = get_data($url, $token['token']);
		return $data;
	}
	function check_info_order_vnpost($LstItemCode)
	{
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain . "/Order/TraCuuDanhSachBuuGuiBCCP";
		$param = array(
        'LstItemCode' => $LstItemCode
		);
		$token = get_token_vnpost();
		$data = post_data($url, $param, $token);
		return $data;
	}
	function check_info_order_vnpost_2($LstItemCode)
	{
		$domain = 'https://donhang.vnpost.vn/api/api';
		$url = $domain . "/Order/TraCuuBuuGuiBCCP";
		$param = array(
        "ItemCode" => $LstItemCode
		);
		$token = get_token_vnpost();
		$data = post_data($url, $param, $token);
		return $data;
	}
	function check_info_order_ghn($order_code, $shop_id)
	{
		global $config_setting;
		$url = $config_setting['url_ghn'] . '/v2/shipping-order/detail';
		$param = array(
        'token' => $config_setting['token_ghn'],
        'order_code' => $order_code,
        'shop_id' => $shop_id
		);
		$data = post_data($url, $param, $config_setting['token_ghn']);
		return $data;
	}
	function check_info_order_ghtk($order_code)
	{
		global $config_setting;
		$url = $config_setting['url_ghtk'] . '/services/shipment/v2/' . $order_code;
		$data = get_data($url, $config_setting['token_ghtk']);
		return $data;
	}
	function check_info_order_ahamove($order_code)
	{
		global $config_setting;
		$token = get_token_ahamove();
		$url = $config_setting['url_ahamove'] . '/v1/order/shared_link?token=' . $token['token'] . '&order_id=' . $order_code;
		$data = get_data($url, '');
		return $data;
	}
	function cancel_tranpost_ahamove($order_code, $comment)
	{
		global $config_setting;
		$token = get_token_ahamove();
		$url = $config_setting['url_ahamove'] . '/v1/order/cancel?token=' . $token['token'] . '&order_id=' . $order_code . '&comment=' . urlencode($comment);
		$data = get_data($url, '');
		return $data;
	}
	function send_vnpay($vnp_amount, $vnp_OrderInfo, $vnp_TmnCode, $vnp_TransactionNo, $vnp_HashSecret, $vnp_ReturnUrl, $vnp_IpAddr)
	{
		global $config_setting;
		$inputData = array(
        "vnp_Version" => "2.0.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => (int)$vnp_amount * 100,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis') ,
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => 'vn',
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_ReturnUrl" => $vnp_ReturnUrl,
        "vnp_TxnRef" => $vnp_TransactionNo,
		);
		ksort($inputData);
		$hashdata = "";
		$i = 0;
		foreach ($inputData as $key => $value)
		{
			if ($i == 1)
			{
				$hashdata .= '&' . $key . "=" . $value;
			}
			else
			{
				$hashdata .= $key . "=" . $value;
				$i = 1;
			}
			$query .= urlencode($key) . "=" . urlencode($value) . '&';
		}
		$vnp_Url = $vnp_Url . "?" . $query;
		if (isset($vnp_HashSecret))
		{
			$vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
			$vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
		}
		$url = 'https://pay.vnpay.vn/vpcpay.html' . $vnp_Url;
		return $url;
	}
	function print_ghtk($order_code)
	{
		global $config_setting;
		$url = $config_setting['url_ghtk'] . '/services/label/' . $order_code;
		$data = get_data_print_pdf($url, $config_setting['token_ghtk']);
		return $data;
	}
	$config_setting = getConfig($module_name);
	
	// xử lý lưu thông tin danh mục sản phẩm vào redis cached
	
	// lấy tất cả category đưa vào redis
	function get_categories_all()
	{
		global $db, $module_name, $module_upload;
		
		$list_category = $db->query('SELECT id, name, alias, image, other_image, brand FROM ' . TABLE .'_categories WHERE status = 1 AND inhome = 1 ORDER BY weight ASC')->fetchAll();
		
		
		$arr_temp = array();
		
		foreach($list_category as $value)
		{
			// tạo link
			$value['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value['alias'], true );
			
			// danh sách subcatid
			$arr_subcatid = $db->query('SELECT id FROM ' . TABLE .'_categories WHERE status = 1 AND inhome = 1 AND parrent_id =' . $value['id'] .' ORDER BY weight ASC')->fetchAll();
			
			$value['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $value['image'];
			$value['other_image'] = category_other_img($value['other_image']);
			
			$value['brand'] = brand_category($value['brand']);
			
			$value['numsubcat'] = 0;
			$value['subcatid'] = '';
			
			if($arr_subcatid)
			{			
				$arr_sub = array();
				foreach($arr_subcatid as $catid)
				{
					$arr_sub[] = $catid['id'];
				}
				
				$value['numsubcat'] = count($arr_sub);
				$value['subcatid'] = implode(',', $arr_sub);
				
			}
			
			$arr_temp[$value['id']] = $value;
		}
		
		return $arr_temp;
	}
	
	
	
	
	
	function category_other_img($other_image)
	{
		
		if(empty($other_image))
		return array();
		
		
		
		$other_image_ar = explode('|', $other_image);
		
		foreach ($other_image_ar as $key => $value) 
		{	
			$ar = explode(';',$value);
			
			if($ar[1] and isset($ar[1]))
			$other_image_ar[$key] = $ar[1];
			
		}
		
		
		
		return $other_image_ar;
		
		
	}
	
	function brand_category($brand_string)
	{
		global $db, $module_upload;
		
		$arr = array();
		
		if(empty($brand_string))
		{
			return $arr;
		}
		
		$arr_br = explode('|', $brand_string);
		
		
		if(!empty($arr_br) and !empty($brand_string))
		{
			$list_brand = $db->query('SELECT id, title, logo FROM ' . TABLE . '_brand WHERE id IN('. implode(',',$arr_br).') AND status =1 ORDER BY weight ASC')->fetchAll();
			
			foreach($list_brand as $brand)
			{
				$brand['logo'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $brand['logo'];
					
				$arr[] = $brand;
			}
			
		}
		
		return $arr;
	}
	
	
	function origin_category($origin_string)
	{
		global $db, $module_upload;
		
		$arr = array();
		
		if(empty($origin_string))
		{
			return $arr;
		}
		
		$arr_br = explode('|', $origin_string);
		
		
		if(!empty($arr_br) and !empty($origin_string))
		{
			$list_origin = $db->query('SELECT id, title FROM ' . TABLE . '_origin WHERE id IN('. implode(',',$arr_br).') AND status =1 ORDER BY weight ASC')->fetchAll();
			
			foreach($list_origin as $origin)
			{
				$arr[] = $origin;
			}
			
		}
		
		return $arr;
	}
	
	
	function get_parent_category($id)
	{
		
		if(!$id)
		return array();
		
		$all_catid = get_all_catid($id);
		
		return $all_catid;
		
	}
	
	function get_all_catid($id)
	{
		global $get_all_catid, $global_catalogys;
		
		if(!$id)
		return false;
		
		
		$get_all_catid[] = $id;
		
		
		if($global_catalogys[$id]['numsubcat'] > 0)
		{	
			$arr_temp = explode(',', $global_catalogys[$id]['subcatid']);
			
			foreach($arr_temp as $value)
			{	
				get_all_catid($value);
			}
		}
		
		return $get_all_catid;
	}
	
	
	
	// lấy tất cả thương hiệu của danh mục
	function getbrand_all_redis($id)
	{
		if(!$id)
		return array();
		
		$all_brand = get_all_brand($id);
		return $all_brand;
	}
	
	
	function get_all_brand($id)
	{
		global $get_all_brand, $global_catalogys;
		
		if(!$id)
		return false;
		
		$arr_brand = $global_catalogys[$id]['brand'];
		foreach($arr_brand as $brand)
		{
			$get_all_brand[$brand['id']] = $brand;
		}
		
		
		if($global_catalogys[$id]['numsubcat'] > 0)
		{	
			$arr_catid = explode(',', $global_catalogys[$id]['subcatid']);
			
			foreach($arr_catid as $value)
			{	
				get_all_brand($value);
			}
		}
		
		return $get_all_brand;
		
	}
	
	
	// danh sách danh mục con cấp 1 của danh mục hiện tại
	function getcategory_child_lev1_redis($id)
	{
		global $global_catalogys;
		
		if(!$id)
		return false;
		
		$arr_temp = array();
		
		if($global_catalogys[$id]['numsubcat'] > 0)
		{	
			$arr_catid = explode(',', $global_catalogys[$id]['subcatid']);
			
			foreach($arr_catid as $value)
			{	
				$tam = array();
				$tam['id'] = $value;
				$tam['name'] = $global_catalogys[$value]['name'];
				$tam['alias'] = $global_catalogys[$value]['alias'];
				
				$arr_temp[] = $tam;
			}
		}
		
		
		return $arr_temp;
		
	}
	
	// danh mục sản phẩm đa cấp html
	function category_html_select($catid)
	{
		$lev = '';
		$arr_select = category_html($catid, $lev);
		
		return $arr_select;
	}
	
	
	function category_html($catid, $lev)
	{
		global $db, $global_catalogys, $array_select;
		
		$parrent_id = $db->query('SELECT parrent_id FROM '. TABLE .'_categories WHERE id ='. $catid)->fetchColumn();
		
		if($parrent_id == 0)
		{
			$lev = '';
		}
		else
		{
			$lev .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		
		if(isset($global_catalogys[$catid]['name']) and !empty($global_catalogys[$catid]['name']))
		{
			$arr = array();
			$arr['id'] = $catid;
			$arr['text'] = $lev . ' ' . $global_catalogys[$catid]['name']. ' ' . $lev;
			
			$array_select[$catid] = $arr;
		}
		
		$list_lev0 = $db->query('SELECT id, name FROM ' . TABLE .'_categories WHERE status = 1 AND parrent_id = '. $catid .' ORDER BY weight ASC')->fetchAll();
		
		foreach($list_lev0 as $item)
		{	
			category_html($item['id'], $lev);
		}
		
		return $array_select;
	}
	
	
	
	function get_categories_all_lev($id)
	{
		global $db, $module_upload, $module_name;
		
		$arr_cata = array();
		
		$categorys = $db->query('SELECT id, name, alias, image, other_image, brand, parrent_id FROM ' . TABLE .'_categories WHERE status = 1 AND inhome = 1 AND parrent_id =' . $id .' ORDER BY weight ASC')->fetchAll();
		
		
		foreach($categorys as $category)
		{
			
			// tạo link
			$category['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $category['alias'], true );
			
			// lấy danh sách con
			$category['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $category['image'];
			$category['other_image'] = category_other_img($category['other_image']);
			
			$category['brand'] = brand_category($category['brand']);
			
			$category['sub'] = get_categories_all_lev($category['id']);
			$arr_cata[$category['id']] = $category;
			
		}
		
		return $arr_cata;
		
	}
	
	
	// conver_data_img_to_png
	
	function conver_data_img_to_png($img, $file_source, $file_thumb)
	{
		$arr = ['data:image/gif;base64','data:image/png;base64','data:image/jpg;base64','data:image/jpeg;base64'];
		
		$img = str_replace($arr, '', $img);
		
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file_name_img = uniqid() . NV_CURRENTTIME . '.png';
		$file = $file_source . '/' . $file_name_img;
		$success = file_put_contents($file, $data);
		$kq = $success ? $file_name_img : false;
		
		// tạo hình ảnh thumb upload
		if($kq and $file_thumb)
		{
			$width = 300;
			$height = 300;
			$thumb_quality = 100;
			
			$createImage = new NukeViet\Files\Image($file, NV_MAX_WIDTH, NV_MAX_HEIGHT);
			
			if (($createImage->fileinfo['width'] < $width) OR ($createImage->fileinfo['height'] < $height)) 
			{
				$width = $createImage->fileinfo['width'];
				$height = $createImage->fileinfo['height'];
			}
			
			$createImage->resizeXY($width, $height);
			$createImage->save($file_thumb, $file_name_img, $thumb_quality);
			$createImage->close();
		}
		
		
		// trả về tên hình ảnh
		return $kq;
	}			
	
	function send_email_order_cancel($order)
	{
		global $db, $lang_module;
		
		
		// lấy danh sách sản phẩm của đơn hàng
		$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
		
		if($order['transporters_id'])
		{
			$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
		}
		else
		{
			$order['name_transporters'] = $lang_module['tranposter_tugiao'];
		}
		
		
		// Gui mail thong bao den khach hang
		$data_order['id'] = $order['id'];
		$info_order = $order;
		$data_order['order_code'] = $order['order_code'];
		$info_shop = $db->query('SELECT * FROM ' . TABLE . '_seller_management WHERE id = ' . $order['store_id'])->fetch();
		
		$email_title = 'Thông báo đơn hàng hủy';
		$email_contents = call_user_func('email_order_cancel_khach', $data_order, $list_product, $info_order);
		
		
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , $order['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		// Gui mail thong bao den nhà bán hàng
		$email_contents = call_user_func('email_order_cancel_seller', $data_order, $list_product, $info_order);
		$email_title = 'Thông báo đơn hàng hủy';
		
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , get_info_store($order['store_id'])['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		return true;
		
	}
	//gửi mail cho khách thông báo thanh toán thất bại
	function send_mail_payment_fail($order_text)
	{
		global $db, $db_config, $lang_module;
		
		$list_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id IN(' . $order_text . ')')->fetchAll();
		foreach ($list_order as $order)
		{	
			
			// lấy danh sách sản phẩm của đơn hàng
			$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
			
			if($order['transporters_id'])
			{
				$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
			}
			else
			{
				$order['name_transporters'] = $lang_module['tranposter_tugiao'];
			}
			// Gui mail thong bao den khach hang
			$data_order['id'] = $order['id'];
			$info_order = $order;
			$data_order['order_code'] = $order['order_code'];
			
			$email_title = $lang_module['order_email_title'];
			$email_contents = call_user_func('email_payment_fail', $data_order, $list_product, $info_order);
			
			nv_sendmail(array(
			$global_config['site_name'],
			$global_config['site_email']
			) , $order['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
			
		}
		
		return true;
	}
	
	//gửi mail cho khách và seller thông báo đơn hàng giao thành công
	function send_mail_order_delivered($order)
	{
		global $db, $db_config, $lang_module;
		
		// lấy danh sách sản phẩm của đơn hàng
		$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
		
		if($order['transporters_id'])
		{
			$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
		}
		else
		{
			$order['name_transporters'] = $lang_module['tranposter_tugiao'];
		}
		
		
		// Gui mail thong bao den khach hang
		$data_order['id'] = $order['id'];
		$info_order = $order;
		$data_order['order_code'] = $order['order_code'];
		$info_shop = $db->query('SELECT * FROM ' . TABLE . '_seller_management WHERE id = ' . $order['store_id'])->fetch();
		
		$email_title = 'Thông báo đơn hàng giao thành công';
		$email_contents = call_user_func('email_order_delivered_khach', $data_order, $list_product, $info_order);
		
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , $order['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		// Gui mail thong bao den nhà bán hàng
		$email_contents = call_user_func('email_order_delivered_seller', $data_order, $list_product, $info_order);
		$email_title = 'Thông báo đơn hàng giao thành công';
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , get_info_store($order['store_id'])['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		return true;
	}
	
	//gửi mail cho admin và seller thông báo đơn hàng giao thành công nhưng khách chưa nhận được
	function send_mail_order_not_received($order)
	{
		global $db, $db_config, $lang_module, $config_setting;
		
		// lấy danh sách sản phẩm của đơn hàng
		$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
		
		if($order['transporters_id'])
		{
			$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
		}
		else
		{
			$order['name_transporters'] = $lang_module['tranposter_tugiao'];
		}
		
		
		// Gui mail thong bao den khach seller
		$data_order['id'] = $order['id'];
		$info_order = $order;
		$data_order['order_code'] = $order['order_code'];
		$info_shop = $db->query('SELECT * FROM ' . TABLE . '_seller_management WHERE id = ' . $order['store_id'])->fetch();
		
		$email_title = 'Thông báo đơn hàng bị khiếu nại';
		$email_contents = call_user_func('email_order_not_received_seller', $data_order, $list_product, $info_order);
		
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , get_info_store($order['store_id'])['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		// Gui mail thong bao den nhà bán hàng
		$email_contents = call_user_func('email_order_not_received_admin', $data_order, $list_product, $info_order);
		$email_title = 'Thông báo đơn hàng bị khiếu nại';
		nv_sendmail(array(
		$global_config['site_name'],
		$global_config['site_email']
		) , $config_setting['email_get_not_received'], sprintf($email_title, $data_order['order_code']) , $email_contents);
		
		return true;
	}
	
	
	// hoàn trả tiền vnpay
	function vnpay_refund($info_order)
	{
		global $db, $user_info, $config_setting;
		
		//$info_order = get_info_order($order_id);
		
		if(!$info_order['vnpay_code'])
		return true;
		
		// lấy thông tin thanh toán
		$history_vnpay = $db->query('SELECT price, name_register, vnp_paydate FROM ' . TABLE .'_history_vnpay WHERE vnp_transactionno = '. $info_order['vnpay_code'])->fetch();
		
		
		// hoàn tiền toàn phần 02, hoàn tiền 1 phần 03
		if($info_order['total'] == $history_vnpay['price'])
		{
			$vnp_TransactionType = '02';
		}
		else
		{
			$vnp_TransactionType = '03';
		}
		
		
		$amount = ($history_vnpay["price"]) * 100;
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$inputData = array(
		"vnp_Version" => '2.0.0',
		"vnp_TransactionType" => $vnp_TransactionType,
		"vnp_Command" => "refund",
		"vnp_CreateBy" => $history_vnpay["name_register"],
		"vnp_TmnCode" => $config_setting['website_code_vnpay'],
		"vnp_TxnRef" => $info_order['id'],
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
		
		// lưu thông tin lịch sử hoàn tiền vnpay
		$row['time_add'] = NV_CURRENTTIME;
		
		$stmt = $db->prepare('INSERT INTO ' . TABLE . '_vnpay_refund (order_id, responsecode, message, user_add, time_add) VALUES (:order_id, :responsecode, :message, :user_add, :time_add)');
		
		$stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
		$stmt->bindParam(':order_id', $info_order['id'], PDO::PARAM_INT);
		$stmt->bindParam(':responsecode', $inputData['vnp_ResponseCode'], PDO::PARAM_STR);
		$stmt->bindParam(':message', $inputData['vnp_Message'], PDO::PARAM_STR);
		$stmt->bindParam(':user_add', $user_info['userid'], PDO::PARAM_INT);
		
		$exc = $stmt->execute();
		
		return true;
		
	}
	// xử lý thanh toán vnpay thành công test
	function xulythanhtoanthanhcong_test($order_text, $inputData)
	{
		global $db, $db_config, $user_info, $module_name, $lang_module;
		
		$list_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id IN(' . $order_text . ')')->fetchAll();
		
		// cập nhật kho hàng sau khi thanh toán thành công
		foreach ($list_order as $order)
		{
			//update voucher 
			
			$update_voucher = $db->query('UPDATE ' . TABLE . '_voucher SET usage_limit_quantity = usage_limit_quantity - 1 WHERE id = ' . $order['voucherid']);
			
			$update_order_voucher = $db->query('UPDATE ' . TABLE . '_order_voucher SET status =  1 WHERE order_id = ' . $order['id']);
			
			// lấy danh sách sản phẩm của đơn hàng
			$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
			//print_r($list_product);die;
			foreach ($list_product as $product)
			{
				// cập nhật kho sau khi thanh toán thành công
				
				$where = '';
				
				if($product['classify_value_product_id'])
				{
					$where .= ' AND id=' . $product['classify_value_product_id'];
				}
				
				$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET sl_tonkho = sl_tonkho - '. $product['quantity'] .' WHERE product_id =' . $product['product_id'] . $where);
				
				$db->query('UPDATE ' . TABLE . '_product SET number_order = number_order + '. $product['quantity'] .' WHERE id = ' . $product['product_id']);
				
			}
			
			// gửi thông báo email về cho khách hàng, cửa hàng
			$content_ip = 'Hiện có 1 đơn hàng mới';
			if (!empty($user_info))
			{	
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,' . $user_info['userid'] . ',' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,' . $user_info['userid'] . ',' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
			}
			else
			{	
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,0,' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,0,' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
			}
			
			$content = 'Đơn hàng mới đã xác nhận';
			if (!empty($user_info))
			{
				
				$db->query('INSERT INTO ' . TABLE . '_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $order['id'] . ',1,' . $db->quote($content) . ',' . NV_CURRENTTIME . ',' . $user_info['userid'] . ')');
			}
			else
			{	
				$db->query('INSERT INTO ' . TABLE . '_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $order['id'] . ',1,' . $db->quote($content) . ',' . NV_CURRENTTIME . ',1)');
			}
			
			// cập nhật thông tin đơn hàng thanh toán thành công status_payment_vnpay = 1
			
			$update_status_payment_vnpay = $db->query('UPDATE ' . TABLE . '_order SET status_payment_vnpay = 1, status = 1, payment =' . $order['total'] . ', vnpay_code ="'. $inputData['vnp_TransactionNo'] .'" WHERE id =' . $order['id']);
			
			update_time_add_order($order['id']);
			
			if($order['transporters_id'])
			{
				$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
			}
			else
			{
				$order['name_transporters'] = $lang_module['tranposter_tugiao'];
			}
			
			
			// Gui mail thong bao den khach hang
			$data_order['id'] = $order['id'];
			$info_order = $order;
			$data_order['order_code'] = $order['order_code'];
			
			$email_title = $lang_module['order_email_title'];
			$email_contents = call_user_func('email_new_order_payment_khach', $data_order, $list_product, $info_order);
			
			
			
			nv_sendmail(array(
            $global_config['site_name'],
            $global_config['site_email']
			) , $order['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
			
			
			// Gui mail thong bao den nhà bán hàng
			$email_contents = call_user_func('email_new_order_payment', $data_order, $list_product, $info_order);
			$email_title = $lang_module['order_email_title'];
			
			nv_sendmail(array(
            $global_config['site_name'],
            $global_config['site_email']
			) , get_info_store($order['store_id'])['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
			
		}
		
		return true;
	}
	function xulythanhtoanthanhcong_recieve($order_text, $inputData)
	{
		global $db, $db_config, $user_info, $module_name, $lang_module, $global_payport;
		
		$list_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id IN(' . $order_text . ')')->fetchAll();
		
		// cập nhật kho hàng sau khi thanh toán thành công
		foreach ($list_order as $order)
		{
			//update voucher 
			
			//$update_voucher = $db->query('UPDATE ' . TABLE . '_voucher SET usage_limit_quantity = usage_limit_quantity - 1 WHERE id = ' . $order['voucherid']);
			
			$update_order_voucher = $db->query('UPDATE ' . TABLE . '_order_voucher SET status =  1 WHERE order_id = ' . $order['id']);
			
			// lấy danh sách sản phẩm của đơn hàng
			$list_product = $db->query('SELECT product_id, quantity, classify_value_product_id, quantity, price FROM ' . TABLE . '_order_item WHERE order_id =' . $order['id'])->fetchAll();
			//print_r($list_product);die;
			foreach ($list_product as $product)
			{
				// cập nhật kho sau khi thanh toán thành công
				
				$where = '';
				
				if($product['classify_value_product_id'])
				{
					$where .= ' AND id=' . $product['classify_value_product_id'];
				}
				
				$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET sl_tonkho = sl_tonkho - '. $product['quantity'] .' WHERE product_id =' . $product['product_id'] . $where);
				
				$db->query('UPDATE ' . TABLE . '_product SET number_order = number_order + '. $product['quantity'] .' WHERE id = ' . $product['product_id']);
				
			}
			
			// gửi thông báo email về cho khách hàng, cửa hàng
			$content_ip = 'Hiện có 1 đơn hàng mới';
			if (!empty($user_info))
			{	
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,' . $user_info['userid'] . ',' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,' . $user_info['userid'] . ',' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
			}
			else
			{	
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,0,' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
				$db->query('INSERT INTO ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES (' . $db->quote(NV_LANG_DATA) . ',1,' . $db->quote($module_name) . ',0,0,0,' . $order['store_id'] . ',' . $db->quote($content_ip) . ',' . NV_CURRENTTIME . ',' . $order['id'] . ',"order")');
			}
			
			$content = 'Đơn hàng mới đã xác nhận';
			if (!empty($user_info))
			{
				
				$db->query('INSERT INTO ' . TABLE . '_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $order['id'] . ',1,' . $db->quote($content) . ',' . NV_CURRENTTIME . ',' . $user_info['userid'] . ')');
			}
			else
			{	
				$db->query('INSERT INTO ' . TABLE . '_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES(' . $order['id'] . ',1,' . $db->quote($content) . ',' . NV_CURRENTTIME . ',1)');
			}
			
			
			if($order['transporters_id'])
			{
				$order['name_transporters'] = $db->query('SELECT name_transporters FROM ' . TABLE . '_transporters WHERE id =' . $order['transporters_id'])->fetchColumn();
			}
			else
			{
				$order['name_transporters'] = $lang_module['tranposter_tugiao'];
			}
			
			
			// Gui mail thong bao den khach hang
			$data_order['id'] = $order['id'];
			$info_order = $order;
			$info_order['payment_method_name'] = $global_payport[$info_order['payment_method']]['paymentname'];
			$data_order['order_code'] = $order['order_code'];
			
			$email_title = $lang_module['order_email_title'];
			$email_contents = call_user_func('email_new_order_payment_khach', $data_order, $list_product, $info_order);
			
			
			
			nv_sendmail(array(
            $global_config['site_name'],
            $global_config['site_email']
			) , $order['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
			
			
			// Gui mail thong bao den nhà bán hàng
			$email_contents = call_user_func('email_new_order_payment', $data_order, $list_product, $info_order);
			$email_title = $lang_module['order_email_title'];
			
			nv_sendmail(array(
            $global_config['site_name'],
            $global_config['site_email']
			) , get_info_store($order['store_id'])['email'], sprintf($email_title, $data_order['order_code']) , $email_contents);
			
		}
		
		return true;
	}
function GetInfoOrderByID($order_code)
{
	global $db;
	$list = array();
	$sth = $db->query("SELECT * FROM " . TABLE . "_order where id IN (" . $order_code .")");
	while($row = $sth->fetch()){
		$list[$row['id']] = $row;
	}
	
	
	return $list;
}	
function PaymentMethod(){

}
function GetPaymentMethodOrder($order_code){
	global $db;
	$order = explode(",",$order_code);

	$orders = $db->query('SELECT * FROM ' . TABLE . '_order where id IN (' . $order_code . ' )')->fetchAll(); 
	
	$max_i = count($orders);
	$flag = false;
	if(count($order) > 1 && $max_i > 1){
		$flags = array();
		for($i = 0;$i<($max_i-1);$i++){
			$flags[$i] = 0;
			if(  $orders[$i+1]['time_add'] == $orders[$i]['time_add'] && $orders[$i+1]['payment_method'] == $orders[$i]['payment_method']){
				$flags[$i] = 1;
				
			}
			
		}
		if(in_array(0,$flags) == 0 ){
			$flag = true;
		}

	}elseif(count($order) == 1 && $max_i == 1) {
		$flag = true;
	}
	if($flag == false){
		nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
	}
	$payment_method = $orders[0]['payment_method'];
	return $payment_method;
}

function CheckPaymentOrder($payment_method,$order_code,$inputData){
	$error = array();
	if($payment_method == 'vnpay'){
		if ($inputData['vnp_ResponseCode'] == '02')
		{
			$error[] = 'Đơn hàng đã được xác nhận!';
		}
		elseif ($inputData['vnp_ResponseCode'] == '04')
		{
			$error[] = 'Số tiền không hợp lệ!';
		}
		elseif ($inputData['vnp_ResponseCode'] == '01')
		{
			$error[] = 'Không tìm thấy giao dịch xác nhận!';
		}
		elseif ($inputData['vnp_ResponseCode'] == '97')
		{
			$error[] = 'Chữ ký không hợp lệ!';
		}
		elseif ($inputData['vnp_ResponseCode'] == '99')
		{
			$error[] = 'Lỗi hệ thống khác!';
		}
		elseif ($inputData['vnp_ResponseCode'] == '24')
		{
			$error[] = 'Giao dịch không thành công!';
		}
	}
	
	return $error;
}
function GetPaymentStatus($payment_method,$order_code,$errors,$inputData){
	global $db;
	$status = false;

	if(empty($errors)){
		//$_SESSION[$module_name . '_' . $payment_method] = true;
		if($payment_method == 'vnpay'){
				$vnp_SecureHash = $inputData['vnp_SecureHash'];
				unset($inputData['vnp_SecureHashType']);
				unset($inputData['vnp_SecureHash']);
				ksort($inputData);
				$i = 0;
				$hashData = "";
				foreach ($inputData as $key => $value)
				{
					if ($i == 1)
					{
						$hashData = $hashData . '&' . $key . "=" . $value;
					}
					else
					{
						$hashData = $hashData . $key . "=" . $value;
						$i = 1;
					}
				}
				$vnp_HashSecret = $config_setting['checksum_vnpay'];

				$order_text = $inputData['vnp_TxnRef'];
				
				if(!$order_text)
				{
					$returnData['RspCode'] = '01';
					$returnData['Message'] = 'Order not found!';
				}
				

				// tính tổng tiền thanh toán
				$sum_total_payment = $db->query('SELECT sum(total) FROM ' . TABLE . '_order WHERE id IN('. $order_text .')')->fetchColumn(); 

				//print_r($tongtien_thanhtoan);die;

				$check_orderid = $db->query('SELECT id FROM ' . TABLE . '_order WHERE userid ='. $user_info['userid'] .' AND id IN('. $order_text .')')->fetchColumn(); 

				$check_payment = $db->query('SELECT id FROM ' . TABLE . '_order WHERE status_payment_vnpay = 1 AND id IN('. $order_text .')')->fetchColumn(); 

			
				$secureHash = hash('sha256', $vnp_HashSecret . $hashData);
				//print_r($id_order);die;
			
				$vnp_Amount = $inputData['vnp_Amount'];
				$vnp_Amount = (int)$vnp_Amount / 100;

				// checksum
				//print_r($vnp_SecureHash);die;
				if ($secureHash == $vnp_SecureHash)
				{
					// check OrderId
					if ($check_orderid)
					{
						if($tongtien_thanhtoan && $tongtien_thanhtoan == $vnp_Amount ){
							// check Status
							if ($check_payment) {
								
									if ($inputData['vnp_ResponseCode'] == '00')
									{
										$status = true;
									
									}
									
								
							} else {
								$error[] = 'Thanh toán thất bại!';
							}
						}
						else
						{
							$error[] = 'Số tiền không hợp lệ!';
						}
						

					}
					else
					{
						$error[] = 'Đơn hàng không tìm thấy!';
					}
				}
				else
				{
					$error[] = 'Chữ ký không hợp lệ!';
				}

				// ket thuc xu ly chuan
		}elseif($payment_method == 'recieve'){
			$db->query('UPDATE ' . TABLE . '_order SET status = 1  WHERE id IN (' . $order_code . ')');
			// tính tổng tiền thanh toán
				$sum_total_payment = $db->query('SELECT sum(total) FROM ' . TABLE . '_order WHERE id IN('. $order_code .')')->fetchColumn(); 

			$status = true;
			//$inputData = array();
			//$inputData['order_code'] = $nv_Request->get_title('order_code', 'get', '', 1);

		}
		
	}
	$data=array();
	$data['status'] = $status;
	$data['sum_total_payment'] = $sum_total_payment;
	return $data;
	
}
