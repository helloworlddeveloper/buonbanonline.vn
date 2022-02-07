<?php
	
$mod = $nv_Request->get_string( 'mod', 'get,post', '' );

// xử lý loading sản phẩm mới ngoài trang chủ
if ($nv_Request->isset_request('load_product_new', 'post')) {
	$page = $nv_Request->get_int( 'page_loading', 'post', 0 );
	$limit = $nv_Request->get_int( 'limit_loading', 'post', 0 );
	$content = '';

	
	// lấy danh sách sản phẩm mới ra 
	$db->select( 'id,image,alias,name_product,star,price,price_special,number_order,free_ship' )
	->from( TABLE . '_product' )
	->where('inhome = 1 and id IN (SELECT product_id FROM ' . TABLE . '_inventory_product where amount>0 )')
	->order( 'number_order DESC, star DESC, number_like DESC, number_view DESC, time_add DESC' )
	->limit( $limit )
	->offset( ( $page - 1 ) * $limit );
	$sth = $db->prepare( $db->sql() );
	
	
	$list = $db->query($db->sql())->fetchAll();
	
	if(!empty($list))
	{
		$xtpl = new XTemplate('global.product_new.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
		
		$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
		$xtpl->assign('BLOCK_THEME', $global_config['module_theme']);
		
		foreach ($list as $key => $value_product) {
			
			$value_product['number_order']=number_format($value_product['number_order']);
			
			$value_product['price_format'] = number_format( $value_product['price'] ).'đ';
			
			$value_product['alias'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value_product['alias'].'-'.$value_product['id'], true );
			
			if (!empty($value_product['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value_product['image'] )) {
				$value_product['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $value_product['image'] ;
				}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				$value_product['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $value_product['image'] ;
			}
			$value_product['price'] = $value_product['price'] ? $value_product['price'] : $value_product['price_special'];
			$xtpl->assign( 'LOOP_PRODUCT', $value_product);
			
			if($value_product['price_special'] and $value_product['price'] < $value_product['price_special'])
			{		
				$price_special = number_format( $value_product['price_special'] ).'đ';
				$xtpl->assign( 'price_special', $price_special);
				$xtpl->parse( 'product_loading.product.price_special' );
			}
			if($value_product['free_ship'])
			{		
				$xtpl->parse( 'product_loading.product.free_ship' );
			}
			
			$xtpl->parse( 'product_loading.product' );
		}
		
		$xtpl->parse('product_loading');
		$content = $xtpl->text('product_loading');
		
	}
	
	die($content);
}


if ($nv_Request->isset_request('load_product_home', 'get')) {
	
	$per_page = $nv_Request->get_int( 'per_page', 'get,post', 0 );
	$page = $nv_Request->get_int( 'page', 'get,post', 0 );
	
	$catalogy = $nv_Request->get_int( 'catalogy', 'get,post', 0 );
	$store_id = $nv_Request->get_int( 'store_id', 'get,post', 0 );
	
	$where = '';
	
	if($catalogy)
	{
		$where .= ' AND categories_id ='. $catalogy;
	}
	
	if($store_id)
	{
		$where .= ' AND store_id ='. $store_id;
	}
	
	$json = array();
	$json['readmore'] = 0;
	$json['content'] = '';
	
	if($per_page and $page)
	{
		$db->sqlreset()
		->select('COUNT(*)')
		->from( NV_PREFIXLANG . '_' . $module_data . '_product')
		->where('inhome = 1');
		
		
		$sth = $db->prepare($db->sql());
		
		$sth->execute();
		$num_items = $sth->fetchColumn();
		
		$db->select('id,image,alias,name_product,star,price,price_special,number_order,free_ship')
		//->order('number_order DESC, star DESC, number_like DESC, number_view DESC, time_add DESC')
		->order('rand()')
		->limit($per_page)
		->offset(($page - 1) * $per_page);
		
		$data = $db->query($db->sql())->fetchAll();
		$json['readmore'] = count($data);
		$json['content'] = content_product_ajax($data);
		
		
		
		}
	
	print_r(json_encode($json));die;
	
}





// xu ly phan trang comment rate product rate_comment
if($mod=='rate_comment')
{
	$page = $nv_Request->get_int( 'page', 'get,post', 0);
	$product_id = $nv_Request->get_int( 'product_id', 'get,post', 0);
	
	die(comment_rate_product($product_id, $page));
	
}


// lấy số lượng tồn kho của sản phẩm
function lay_ton_kho_sp($product_id, $warehouse_id, $classify_id_value1, $classify_id_value2 )
{
	global $module_name;
	// lấy giá sản phẩm theo thuộc tính
	$price = get_price_classify($product_id,$classify_id_value1,$classify_id_value2);
	
	if($classify_id_value1==0){
		$info_product=array();
		}else{
		$info_product=get_info_classify_value_product_classify_id_value1_classify_id_value2($classify_id_value1,$classify_id_value2);
	}
	$store_id = get_info_product( $product_id )['store_id'];
	if(count($info_product)>0){
		if(get_info_classify_value_product_classify_id_value1_classify_id_value2($classify_id_value1,$classify_id_value2)['status']==1){
			
			$number_product = get_info_invetory_group( $product_id, $warehouse_id, $info_product['id'])['amount'];
			}else{
			$number_product = -1;
		}
		}else{
		$number_product=get_info_invetory_no($product_id,$warehouse_id)[0]['amount'];
	}
	
	
	
	if ( !empty( $_SESSION[$module_name . '_cart'][$store_id][$warehouse_id] ) ) {
		foreach ( $_SESSION[$module_name . '_cart'][$store_id][$warehouse_id] as $value_session_cart ) {									
			if ( $value_session_cart['product_id'] == $product_id && $value_session_cart['classify_value_product_id'] == $info_product['id'] ) {
				
				$number_product = $number_product - $value_session_cart['num'];
			}
		}
		
	}
	if ( empty( $number_product ) ) {
		$number_product = 0;
	}		
	return $number_product;
	
}


if($mod=='getinfoclassproduct')
{
	$product_id = $nv_Request->get_int( 'product_id', 'get,post', 0 );
	$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'get,post', 0 );
	$classify_id_value1 = $nv_Request->get_int( 'classify_id_value1', 'get,post', 0 );
	$classify_id_value2 = $nv_Request->get_int( 'classify_id_value2', 'get,post', 0 );
	
	// lấy thông tin giá, giá niêm yết, tồn kho sản phẩm theo thuộc tính
	$info_product = get_price_classify_new($product_id,$warehouse_id,$classify_id_value1,$classify_id_value2);
	
	print_r(json_encode($info_product));die;
	
}



if($mod=='pay_vnpay_customer'){
	$order_code = $nv_Request->get_string( 'order_code', 'get', '' );
	$id = $nv_Request->get_int( 'id', 'get', '' );
	$vnp_TransactionNo=$order_code;
	$vnp_OrderInfo='Thanh toán giao dịch '.$vnp_TransactionNo.' vào thời gian '.date('d-m-Y H:i',NV_CURRENTTIME);
	$info_order=get_info_order($id);
	$vnp_ReturnUrl= 'https://'.$_SERVER['HTTP_HOST'].nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op.'&mod=update_order_vnpay&list_order='.$id);
	$check_vnpay=send_vnpay($info_order['total'],$vnp_OrderInfo,$config_setting['website_code_vnpay'],$vnp_TransactionNo,$config_setting['checksum_vnpay'],$vnp_ReturnUrl,'171.226.0.17');
	$contents1 = array(
	'status' => 'OK_VNPAY',
	'link' => $check_vnpay
	);
	print_r( json_encode( $contents1 ) );
	die();
}
if($mod=='update_order_vnpay'){
	
	$config_form_khach = $db->query('SELECT config_value FROM ' . TABLE . '_config WHERE config_name = "form_email_khach"')->fetchColumn();
	$config_form_nha_ban = $db->query('SELECT config_value FROM ' . TABLE . '_config WHERE config_name = "form_email_nha_ban"')->fetchColumn();
	$list_order = explode(',',$nv_Request->get_string( 'list_order', 'get', '' ));
	$vnp_ResponseCode = $nv_Request->get_string( 'vnp_ResponseCode', 'get', '' );
	$status_name=get_info_status_vnpay($vnp_ResponseCode)['name'];
	if($vnp_ResponseCode=='00'){
		foreach($list_order as $value){
			$db->query('UPDATE '.TABLE.'_order SET status_payment_vnpay=1, payment='.get_info_order($value)['total'].' where id='.$value); 
			$info_order=get_info_order($value);
			$list_product=$db->query('SELECT t1.*,t2.image FROM '.TABLE.'_order_item t1 INNER JOIN ' . TABLE . '_product t2 ON t1.product_id = t2.id where t1.order_id='.$value)->fetchAll();
			$content_ip='Hiện có 1 đơn hàng mới vào thời gian '.date('d/m/y H:i',NV_CURRENTTIME);
			if(!empty($user_info)){
				$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$user_info['userid'].','.$info_order['store_id'].','.$db->quote($content_ip).','.NV_CURRENTTIME.','.$value.',"listorder")');
				$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$user_info['userid'].','.$info_order['store_id'].','.$db->quote($content_ip).','.NV_CURRENTTIME.','.$value.',"listorder")');
				}else{
				$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,0,'.$info_order['store_id'].','.$db->quote($content_ip).','.NV_CURRENTTIME.','.$value.',"listorder")');
				$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,0,'.$info_order['store_id'].','.$db->quote($content_ip).','.NV_CURRENTTIME.','.$value.',"listorder")');
			}
			$content='Đơn hàng mới được khởi tạo';
			if(!empty($user_info)){
				$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$value.',-1,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
				}else{
				$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$value.',-1,'.$db->quote($content).','.NV_CURRENTTIME.',0)');
			}
			// Gui mail thong bao den khach hang
			
			$data_order['id'] = $value;
			$info_order=get_info_order($value);
			
			$info_shop = $db->query('SELECT * FROM ' . TABLE . '_seller_management WHERE id = ' . $info_order['store_id'])->fetch();
			
			$data_order['order_code'] = $info_order['order_code'];
			
			$email_contents = call_user_func('email_new_order_payment_khach', $data_order, $list_product, $info_order,$config_form_khach,$info_shop);
			$email_title = 'Thư thông báo đơn hàng thành công';
			nv_sendmail(array($global_config['site_name'], $global_config['site_email']), $info_order['email'], sprintf($email_title, $info_order['order_code']), $email_contents);
			
			// Gui mail thong bao den nhà bán hàng
			$data_order['id'] = $value;
			$info_order=get_info_order($value);
			$data_order['order_code'] = $info_order['order_code'];
			$email_contents = call_user_func('email_new_order_payment', $data_order, $list_product, $info_order);
			$email_title = 'Thư thông báo đơn hàng thành công';
			nv_sendmail(array($global_config['site_name'], $global_config['site_email']), get_info_store($info_order['store_id'])['email'], sprintf($email_title, $info_order['order_code']), $email_contents);
			echo '<script language="javascript">';
			echo 'alert("'.$status_name.'"); window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '='.$module_name . '&' . NV_OP_VARIABLE . '=ordercustomer',true).'"';
			echo '</script>';
		}
		}else{
		foreach($list_order as $value){
			$data_order['id'] = $value;
			$info_order=get_info_order($value);
			$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item t1 INNER JOIN ' . TABLE . '_product t2 ON t1.product_id = t2.id where t1.order_id='.$value)->fetchAll();
			$data_order['order_code'] = $info_order['order_code'];
			$email_contents = call_user_func('dathangchuathanhtoan', $data_order, $list_product, $info_order,$config_form_khach);
			
			$email_title = 'Thư thông báo đơn hàng chưa thanh toán';
			nv_sendmail(array($global_config['site_name'], $global_config['site_email']), $info_order['email'], sprintf($email_title, $info_order['order_code']), $email_contents);
			$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ', thanh toán chưa thành công, sau 3 ngày đơn hàng sẽ tự hủy nếu không được thanh toán';
			
			$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_user(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,0,'.$info_order['userid'].','.$db->quote($content_ip).','.NV_CURRENTTIME.','.$info_order['id'].',"listorder")');
		}
		
		echo '<script language="javascript">';
		echo 'alert("'.$status_name.'"); window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '='.$module_name . '&' . NV_OP_VARIABLE . '=ordercustomer',true).'"';
		echo '</script>';
	}
	include NV_ROOTDIR . '/includes/header.php';
	include NV_ROOTDIR . '/includes/footer.php';
	die;
}
if($mod=='get_account_bank'){
	$q = $nv_Request->get_string( 'q', 'post', '' );
	$list_bank = get_list_account_bank_select2( $q ,$user_info['userid']);
	foreach ( $list_bank as $result ) {
		$name_bank=$result['acount_number'].' - '.$result['name_bank'].' - '.$result['acount_name'];
		$json[] = ['id'=>$result['id'], 'text'=>$name_bank];
	}
	print_r( json_encode( $json ) );
	die();
}
if($mod=='load_category_shop'){
	$shop_id_user = $nv_Request->get_string('shop_id', 'get,post', '');
	$shop_id = get_id_shop_from_user_id($shop_id_user);
	
	$list_category = $db->query('SELECT * FROM ' . TABLE . '_categories where parrent_id = 0')->fetchAll();
	$contents = nv_theme_view_category_shop($list_category,$shop_id);
	$json[] = ['status'=>"OK", 'text'=>$contents];
	print_r(json_encode($json[0]));die(); 
	
}
if($mod=='load_comment_detail'){
	$per_page = 5;
	$id = $nv_Request->get_int('id', 'get,post', 0);
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=ajax&amp;id=' . $id . '&amp;mod=load_comment_detail';
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	$num_items =  $db->query("SELECT count(*) FROM " .TABLE."_rate WHERE product_id = " . $id) -> fetchColumn();
	
	$list_rate =  $db->query("SELECT * FROM " .TABLE."_rate WHERE product_id = " . $id . ' LIMIT ' . $per_page . ' offset ' . ($page_new - 1) * $per_page) -> fetchAll();
	$contents = nv_theme_retail_load_comment($list_rate,$page_new,$per_page,$base_url,$num_items,$page);
	print_r($contents);die();
}
if($mod=='get_link'){
	$title = $nv_Request->get_string('title', 'get,post', '');
	$link = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=search', true );
	
	$json[] = ['status'=>"OK", 'text'=>$link];
	print_r(json_encode($json[0]));die(); 
}
if($mod=='load_product'){
	
	$sort_price = $nv_Request->get_int('sort_price', 'get,post', 0);
	$category_id = $nv_Request->get_string('category_id', 'get,post', '');
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	$sort_id = $nv_Request->get_int('sort', 'get,post', 0);
	$shop_id = $nv_Request->get_int('shop_id', 'get,post', 0);
	
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	if($sort==1){
		$sort = ' t1.number_view DESC ';
		}else if($sort==2){
		$sort = ' t1.time_add DESC ';
		}else{
		$sort = ' t1.number_order DESC ';
	}
	if($sort_price == 1){
		$sort .= ', t1.price_sort ASC ';
		}else{
		$sort .= ', t1.price_sort DESC ';
	}
	
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;mod=load_product_phan_trang_inshop&amp;category_id=' . $category_id . '&amp;shop_id=' . $shop_id . '&amp;sort=' . $sort_id;
	//phantrangajax//
	$per_page = $config_setting['number_product'];
	$page = $nv_Request->get_int('page', 'post,get', 1);
	
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	if($category_id>0){
		$where_category=' AND ( t1.categories_id = ' . $category_id . ' OR t2.parrent_id = ' . $category_id . ')';
		}else{
		$where_category='';
	}
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
	->where('t1.status=1 AND t2.status = 1 AND t1.store_id = ' . $shop_id. $where_category.' and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount > 0 )');
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.*')
	->order($sort)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	
	$contents = shops_info_list_products($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$shop_id,$sort_price);
	$json[] = ['status'=>"OK", 'text'=>$contents];
	print_r(json_encode($json[0]));die(); 
	
}

if($mod=='load_product_phan_trang_inshop'){
	
	$sort_price = $nv_Request->get_int('sort_price', 'get,post', 0);
	$category_id = $nv_Request->get_string('category_id', 'get,post', '');
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	$sort_id = $nv_Request->get_int('sort', 'get,post', 0);
	$shop_id = $nv_Request->get_int('shop_id', 'get,post', 0);
	
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	if($sort==1){
		$sort = ' t1.number_view DESC ';
		}else if($sort==2){
		$sort = ' t1.time_add DESC ';
		}else{
		$sort = ' t1.number_order DESC ';
	}
	if($sort_price == 1){
		$sort .= ', t1.price_min ASC ';
		}else{
		$sort .= ', t1.price_min DESC ';
	}
	
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;mod=load_product_phan_trang_inshop&amp;category_id=' . $category_id . '&amp;shop_id=' . $shop_id . '&amp;sort=' . $sort_id;
	//phantrangajax//
	$per_page = $config_setting['number_product'];
	$page = $nv_Request->get_int('page', 'post,get', 1);
	
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
	->where('t1.status=1 AND t2.status = 1 AND t1.store_id = ' . $shop_id. $where_category.' and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount > 0 )');
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.*')
	->order($sort)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	
	$contents = nv_theme_retail_product_phan_trang_in_shop($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$shop_id,$sort_price);
	print_r($contents);die();
	
}
if($mod=='load_product_type_cat'){
	
	$brand_filt = $nv_Request->get_int('brand', 'get,post', 0);
	$category_child = $nv_Request->get_int('category_child', 'get,post', 0);
	$price_from = $nv_Request->get_string('price_from', 'get,post', 0);
	$origin = $nv_Request->get_string('origin_list', 'get,post', 0);
	$origin = $nv_Request->get_array('origin_list', 'get,post', '');
	$brand = $nv_Request->get_array('brand_list', 'get,post', '');
	$category_id = $nv_Request->get_int('category_id', 'get,post', 0);
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	
	$alias = $nv_Request->get_string('alias', 'get,post', '');
	$brand_list = $nv_Request->get_string('brand_chuoi', 'get,post', '');
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	if($sort==1){
		$sort = ' number_view DESC ';
		}else if($sort==2){
		$sort = ' time_add DESC ';
		}else if($sort==3){
		$sort = ' number_order DESC ';
		}else if($sort==4){
		$sort = ' price_sort ASC ';
		}else if($sort==5){
		$sort = ' price_sort DESC ';
		}else{
		$sort = '';
	}
	if($brand_filt){
		$where .= ' AND brand = ' . $brand_filt . ' ';
	}
	
	
	if($price_from && $price_to){
		$where .= ' AND(  (t1.price_sort >= '.$price_from.' AND t1.price_sort <= '.$price_to . '))';
		}else if(!$price_from && !$price_to){
		
		}else if($price_from && !$price_to){
		$where .= ' AND(  (t1.price_sort >= ' . $price_from . '))';
		}else if(!$price_from && $price_to){
		$where .= ' AND(  (t1.price_sort < ' . $price_to . '))';
	}
	if($brand){
		
		$brand_stt = 1;
		
		foreach ($brand as $key => $value) {
			if($value){
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value)->fetch();
				if($info_brand){
					if($brand_stt==1){
						if(count($brand)==1){
							$where .= ' AND(  (t4.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t4.id=' . $value . ')';
						}
						}else if($brand_stt==count($brand)){
						$where .= ' OR (t4.id=' . $value . '))';
						}else{
						$where .= ' OR (t4.id=' . $value . ')';
					}
				}
			}
			$brand_stt ++;
		}
	}
	
	if(count($origin)>0){
		$origin_stt = 1;
		foreach ($origin as $key => $value) {
			if($value){
				$info_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE id = ' . $value)->fetch();
				if($info_origin){
					if($origin_stt==1){
						if(count($origin)==1){
							$where .= ' AND(  (t3.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t3.id=' . $value . ')';
						}
						}else if($origin_stt==count($origin)){
						$where .= ' OR (t3.id=' . $value . '))';
						}else{
						$where .= ' OR (t3.id=' . $value . ')';
					}
				}
			}
			$origin_stt ++;
		}
	}
	
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias;
	
	//phantrangajax//
	$per_page = $config_setting['number_product'];
	$page = $nv_Request->get_int('page', 'post,get', 0);
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_product')
	->where('categories_id IN (SELECT id FROM '.TABLE.'_categories where  id = ' . $category_id . ' OR parrent_id = ' . $category_id . ') ' . $where . ' and status=1  and id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0) group by categories_id');
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('categories_id');
	$sth = $db->prepare($db->sql());
	$sth->execute();
	$table_data=array();
	while( $value_categories = $sth -> fetch() ) {
		if($category_child != 0){
			if($value_categories['categories_id'] == $category_child){
				$table_data[$value_categories['categories_id']]['categories_id']=$value_categories['categories_id'];
				$table_data[$value_categories['categories_id']]['name_categories']=get_info_category($value_categories['categories_id'])['name'];
				$table_data[$value_categories['categories_id']]['limit']=get_info_category($value_categories['categories_id'])['numlinks'];
				
				$table_data[$value_categories['categories_id']]['number_product']=$db->query('SELECT count(*) FROM ' . TABLE . '_product where categories_id='.$value_categories['categories_id'] .  $where . ' and status=1  and id IN (SELECT product_id FROM ' . TABLE . '_inventory_product where amount > 0)')->fetchColumn();
				
				$table_data[$value_categories['categories_id']]['list_product']=$db->query('SELECT * FROM ' . TABLE . '_product where categories_id='.$value_categories['categories_id'] .  $where . ' and status=1  and id IN (SELECT product_id FROM ' . TABLE . '_inventory_product where amount > 0) ORDER BY ' . $sort . ' limit ' . $table_data[$value_categories['categories_id']]['limit'])->fetchAll();
			}
			}else{
			$table_data[$value_categories['categories_id']]['categories_id']=$value_categories['categories_id'];
			$table_data[$value_categories['categories_id']]['name_categories']=get_info_category($value_categories['categories_id'])['name'];
			$table_data[$value_categories['categories_id']]['limit']=get_info_category($value_categories['categories_id'])['numlinks'];
			$table_data[$value_categories['categories_id']]['number_product']=$db->query('SELECT count(*) FROM ' . TABLE . '_product where categories_id='.$value_categories['categories_id'] .  $where . ' and status=1  and id IN (SELECT product_id FROM ' . TABLE . '_inventory_product where amount > 0)')->fetchColumn();
			
			$table_data[$value_categories['categories_id']]['list_product']=$db->query('SELECT * FROM ' . TABLE . '_product where categories_id='.$value_categories['categories_id'] .  $where . ' and status=1  and id IN (SELECT product_id FROM ' . TABLE . '_inventory_product where amount > 0) ORDER BY ' . $sort . ' limit ' . $table_data[$value_categories['categories_id']]['limit'])->fetchAll();
			
		}
		
	}
	
	$contents = nv_theme_retail_sort_product_in_view_type_cat($table_data,$per_page,$page_new,count($table_data),$base_url,$category_id,$shop_id,$sort_price,$category_child,$brand_filt,$brand_list);
	$json[] = ['status'=>"OK", 'text'=>$contents];
	print_r(json_encode($json[0]));die(); 
	
}

if($mod=='load_produc_category_phantrang_type'){
	
	$brand_filt = $nv_Request->get_int('brand', 'get,post', 0);
	$price_from = $nv_Request->get_string('price_from', 'get,post', 0);
	$origin = $nv_Request->get_string('origin_list', 'get,post', 0);
	$origin = $nv_Request->get_array('origin_list', 'get,post', '');
	$brand = $nv_Request->get_array('brand_list', 'get,post', '');
	$category_id = $nv_Request->get_int('categories_id', 'get,post', 0);
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	$alias = $nv_Request->get_string('alias', 'get,post', '');
	$brand_list = $nv_Request->get_string('brand_chuoi', 'get,post', '');
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	if($sort==1){
		$sort = ' t1.number_view DESC ';
		}else if($sort==2){
		$sort = ' t1.time_add DESC ';
		}else if($sort==3){
		$sort = ' t1.number_order DESC ';
		}else if($sort==4){
		$sort = ' t1.price_sort ASC ';
		}else if($sort==5){
		$sort = ' t1.price_sort DESC ';
		}else{
		$sort = '';
	}
	
	
	if($brand_filt){
		$where .= ' AND brand = ' . $brand_filt . ' ';
	}
	
	
	if($price_from && $price_to){
		$where .= ' AND(  (t1.price_sort >= '.$price_from.' AND t1.price_sort <= '.$price_to . '))';
		}else if(!$price_from && !$price_to){
		
		}else if($price_from && !$price_to){
		$where .= ' AND(  (t1.price_sort >= ' . $price_from . '))';
		}else if(!$price_from && $price_to){
		$where .= ' AND(  (t1.price_sort < ' . $price_to . '))';
	}
	if($brand){
		
		$brand_stt = 1;
		
		foreach ($brand as $key => $value) {
			if($value){
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value)->fetch();
				if($info_brand){
					if($brand_stt==1){
						if(count($brand)==1){
							$where .= ' AND(  (t4.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t4.id=' . $value . ')';
						}
						}else if($brand_stt==count($brand)){
						$where .= ' OR (t4.id=' . $value . '))';
						}else{
						$where .= ' OR (t4.id=' . $value . ')';
					}
				}
			}
			$brand_stt ++;
		}
	}
	
	if(count($origin)>0){
		$origin_stt = 1;
		foreach ($origin as $key => $value) {
			if($value){
				$info_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE id = ' . $value)->fetch();
				if($info_origin){
					if($origin_stt==1){
						if(count($origin)==1){
							$where .= ' AND(  (t3.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t3.id=' . $value . ')';
						}
						}else if($origin_stt==count($origin)){
						$where .= ' OR (t3.id=' . $value . '))';
						}else{
						$where .= ' OR (t3.id=' . $value . ')';
					}
				}
			}
			$origin_stt ++;
		}
	}
	
	
	
	//phantrangajax//
	$per_page = $nv_Request->get_int('limit', 'post,get', 0);
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_produc_category_phantrang_type&categories_id=' . $category_id . '&brand=' . $brand . '&limit=' . $per_page;
	$page = $nv_Request->get_int('page', 'post,get', 0);
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_product')
	->where('categories_id='.$category_id . $where . ' and status=1  and id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0)');
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('*')
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	
	$sth = $db->prepare($db->sql());
	$sth->execute();
	
	$contents = nv_theme_phantrang_type_product($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$sort_price);
	echo $contents;
	die;
	
}
if($mod=='load_product_cat'){
	
	$brand_filt = $nv_Request->get_int('brand', 'get,post', 0);
	$category_child = $nv_Request->get_int('category_child', 'get,post', 0);
	$price_from = $nv_Request->get_string('price_from', 'get,post', 0);
	$origin = $nv_Request->get_string('origin_list', 'get,post', 0);
	$origin = $nv_Request->get_array('origin_list', 'get,post', '');
	$brand = $nv_Request->get_array('brand_list', 'get,post', '');
	$category_id = $nv_Request->get_int('category_id', 'get,post', 0);
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	$alias = $nv_Request->get_string('alias', 'get,post', '');
	$brand_list = $nv_Request->get_string('brand_chuoi', 'get,post', '');
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ajax&mod=load_product_cat_phan_trang&brand=' . $brand_filt . '&category_child=' . $category_child . '&category_id=' . $category_id . '&sort=' . $sort . '&brand_chuoi=' . $brand_list;
	if($sort==1){
		$sort = ' t1.number_view DESC ';
		}else if($sort==2){
		$sort = ' t1.time_add DESC ';
		}else if($sort==3){
		$sort = ' t1.number_order DESC ';
		}else if($sort==4){
		$sort = ' t1.price_sort ASC ';
		}else if($sort==5){
		$sort = ' t1.price_sort DESC ';
		}else{
		$sort = '';
	}
	
	
	if($brand_filt){
		$where .= ' AND( t1.brand = ' . $brand_filt . ' )';
	}
	
	
	if($price_from && $price_to){
		$where .= ' AND(  (t1.price_sort >= '.$price_from.' AND t1.price_sort <= '.$price_to . '))';
		}else if(!$price_from && !$price_to){
		
		}else if($price_from && !$price_to){
		$where .= ' AND(  (t1.price_sort >= ' . $price_from . '))';
		}else if(!$price_from && $price_to){
		$where .= ' AND(  (t1.price_sort < ' . $price_to . '))';
	}
	if($brand){
		
		$brand_stt = 1;
		
		foreach ($brand as $key => $value) {
			if($value){
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value)->fetch();
				if($info_brand){
					if($brand_stt==1){
						if(count($brand)==1){
							$where .= ' AND(  (t4.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t4.id=' . $value . ')';
						}
						}else if($brand_stt==count($brand)){
						$where .= ' OR (t4.id=' . $value . '))';
						}else{
						$where .= ' OR (t4.id=' . $value . ')';
					}
				}
			}
			$brand_stt ++;
		}
	}
	
	if(count($origin)>0){
		$origin_stt = 1;
		foreach ($origin as $key => $value) {
			if($value){
				$info_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE id = ' . $value)->fetch();
				if($info_origin){
					if($origin_stt==1){
						if(count($origin)==1){
							$where .= ' AND(  (t3.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t3.id=' . $value . ')';
						}
						}else if($origin_stt==count($origin)){
						$where .= ' OR (t3.id=' . $value . '))';
						}else{
						$where .= ' OR (t3.id=' . $value . ')';
					}
				}
			}
			$origin_stt ++;
		}
	}
	
	//phantrangajax//
	$per_page = $config_setting['number_product'];
	$page = $nv_Request->get_int('page', 'post,get', 0);
	
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	
	
	if($category_child != 0){
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('t1.categories_id = ' . $category_child . ' ' . $where .' and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )');
		}else{
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('(t2.id='.$category_id.' OR t2.parrent_id='.$category_id.') and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )' . ' ' . $where );
	}
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.*')
	->order($sort)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$contents = nv_theme_retail_sort_product_in_view_cat($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$shop_id,$sort_price,$category_child,$brand_filt,$brand_list);
	$json[] = ['status'=>"OK", 'text'=>$contents];
	print_r(json_encode($json[0]));die(); 
	
}
if($mod=='load_product_cat_phan_trang'){
	
	$brand_filt = $nv_Request->get_int('brand', 'get,post', 0);
	$category_child = $nv_Request->get_int('category_child', 'get,post', 0);
	$price_from = $nv_Request->get_string('price_from', 'get,post', 0);
	$origin = $nv_Request->get_string('origin_list', 'get,post', 0);
	$origin = $nv_Request->get_array('origin_list', 'get,post', '');
	$brand = $nv_Request->get_array('brand_list', 'get,post', '');
	$category_id = $nv_Request->get_int('category_id', 'get,post', 0);
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	
	$alias = $nv_Request->get_string('alias', 'get,post', '');
	$brand_list = $nv_Request->get_string('brand_chuoi', 'get,post', '');
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ajax&mod=load_product_cat_phan_trang&brand=' . $brand_filt . '&category_child=' . $category_child . '&category_id=' . $category_id . '&sort=' . $sort . '&brand_chuoi=' . $brand_list;
	if($sort==1){
		$sort = ' t1.number_view DESC ';
		}else if($sort==2){
		$sort = ' t1.time_add DESC ';
		}else if($sort==3){
		$sort = ' t1.number_order DESC ';
		}else if($sort==4){
		$sort = ' t1.price_sort ASC ';
		}else if($sort==5){
		$sort = ' t1.price_sort DESC ';
		}else{
		$sort = '';
	}
	
	
	if($brand_filt){
		$where .= ' AND( t1.brand = ' . $brand_filt . ' )';
	}
	
	
	if($price_from && $price_to){
		$where .= ' AND(  (t1.price_sort >= '.$price_from.' AND t1.price_sort <= '.$price_to . '))';
		}else if(!$price_from && !$price_to){
		
		}else if($price_from && !$price_to){
		$where .= ' AND(  (t1.price_sort >= ' . $price_from . '))';
		}else if(!$price_from && $price_to){
		$where .= ' AND(  (t1.price_sort < ' . $price_to . '))';
	}
	if($brand){
		
		$brand_stt = 1;
		
		foreach ($brand as $key => $value) {
			if($value){
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value)->fetch();
				if($info_brand){
					if($brand_stt==1){
						if(count($brand)==1){
							$where .= ' AND(  (t4.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t4.id=' . $value . ')';
						}
						}else if($brand_stt==count($brand)){
						$where .= ' OR (t4.id=' . $value . '))';
						}else{
						$where .= ' OR (t4.id=' . $value . ')';
					}
				}
			}
			$brand_stt ++;
		}
	}
	
	if(count($origin)>0){
		$origin_stt = 1;
		foreach ($origin as $key => $value) {
			if($value){
				$info_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE id = ' . $value)->fetch();
				if($info_origin){
					if($origin_stt==1){
						if(count($origin)==1){
							$where .= ' AND(  (t3.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t3.id=' . $value . ')';
						}
						}else if($origin_stt==count($origin)){
						$where .= ' OR (t3.id=' . $value . '))';
						}else{
						$where .= ' OR (t3.id=' . $value . ')';
					}
				}
			}
			$origin_stt ++;
		}
	}
	
	//phantrangajax//
	$per_page = $config_setting['number_product'];
	$page = $nv_Request->get_int('page', 'post,get', 0);
	
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	
	
	if($category_child != 0){
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('t1.categories_id = ' . $category_child . ' ' . $where .' and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )');
		}else{
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('(t2.id='.$category_id.' OR t2.parrent_id='.$category_id.') and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )' . ' ' . $where );
	}
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.*')
	->order($sort)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$contents = nv_theme_retail_sort_product_in_view_cat($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$shop_id,$sort_price,$category_child,$brand_filt,$brand_list);
	echo $contents;
	die;
	
}

if($mod=='load_product_cat_list'){
	
	$brand_filt = $nv_Request->get_int('brand', 'get,post', 0);
	$category_child = $nv_Request->get_int('category_child', 'get,post', 0);
	$price_from = $nv_Request->get_string('price_from', 'get,post', 0);
	$origin = $nv_Request->get_string('origin_list', 'get,post', 0);
	$origin = $nv_Request->get_array('origin_list', 'get,post', '');
	$brand = $nv_Request->get_array('brand_list', 'get,post', '');
	$category_id = $nv_Request->get_int('category_id', 'get,post', 0);
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	$alias = $nv_Request->get_string('alias', 'get,post', '');
	$brand_list = $nv_Request->get_string('brand_chuoi', 'get,post', '');
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ajax&mod=load_product_cat_list_phan_trang&brand=' . $brand_filt . '&category_child=' . $category_child . '&category_id=' . $category_id . '&sort=' . $sort . '&brand_chuoi=' . $brand_list;
	if($sort==1){
		$sort = ' t1.number_view DESC ';
		}else if($sort==2){
		$sort = ' t1.time_add DESC ';
		}else if($sort==3){
		$sort = ' t1.number_order DESC ';
		}else if($sort==4){
		$sort = ' t1.price_sort ASC ';
		}else if($sort==5){
		$sort = ' t1.price_sort DESC ';
		}else{
		$sort = '';
	}
	
	
	if($brand_filt){
		$where .= ' AND( t1.brand = ' . $brand_filt . ' )';
	}
	
	
	if($price_from && $price_to){
		$where .= ' AND(  (t1.price_sort >= '.$price_from.' AND t1.price_sort <= '.$price_to . '))';
		}else if(!$price_from && !$price_to){
		
		}else if($price_from && !$price_to){
		$where .= ' AND(  (t1.price_sort >= ' . $price_from . '))';
		}else if(!$price_from && $price_to){
		$where .= ' AND(  (t1.price_sort < ' . $price_to . '))';
	}
	if($brand){
		
		$brand_stt = 1;
		
		foreach ($brand as $key => $value) {
			if($value){
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value)->fetch();
				if($info_brand){
					if($brand_stt==1){
						if(count($brand)==1){
							$where .= ' AND(  (t4.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t4.id=' . $value . ')';
						}
						}else if($brand_stt==count($brand)){
						$where .= ' OR (t4.id=' . $value . '))';
						}else{
						$where .= ' OR (t4.id=' . $value . ')';
					}
				}
			}
			$brand_stt ++;
		}
	}
	
	if(count($origin)>0){
		$origin_stt = 1;
		foreach ($origin as $key => $value) {
			if($value){
				$info_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE id = ' . $value)->fetch();
				if($info_origin){
					if($origin_stt==1){
						if(count($origin)==1){
							$where .= ' AND(  (t3.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t3.id=' . $value . ')';
						}
						}else if($origin_stt==count($origin)){
						$where .= ' OR (t3.id=' . $value . '))';
						}else{
						$where .= ' OR (t3.id=' . $value . ')';
					}
				}
			}
			$origin_stt ++;
		}
	}
	
	
	
	//phantrangajax//
	$per_page = $config_setting['number_product'];
	$page = $nv_Request->get_int('page', 'post,get', 0);
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	
	if($category_child != 0){
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('t1.categories_id = ' . $category_child . ' ' . $where .' and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )');
		}else{
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('(t2.id='.$category_id.' OR t2.parrent_id='.$category_id.') and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )' . ' ' . $where );
	}
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.*')
	->order($sort)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$contents = nv_theme_retail_sort_product_in_view_cat_list($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$shop_id,$sort_price,$category_child,$brand_filt,$brand_list);
	$json[] = ['status'=>"OK", 'text'=>$contents];
	print_r(json_encode($json[0]));die(); 
	
}
if($mod=='load_product_cat_list_phan_trang'){
	
	$brand_filt = $nv_Request->get_int('brand', 'get,post', 0);
	$category_child = $nv_Request->get_int('category_child', 'get,post', 0);
	$price_from = $nv_Request->get_string('price_from', 'get,post', 0);
	$origin = $nv_Request->get_string('origin_list', 'get,post', 0);
	$origin = $nv_Request->get_array('origin_list', 'get,post', '');
	$brand = $nv_Request->get_array('brand_list', 'get,post', '');
	$category_id = $nv_Request->get_int('category_id', 'get,post', 0);
	$sort = $nv_Request->get_int('sort', 'get,post', 0);
	$alias = $nv_Request->get_string('alias', 'get,post', '');
	$brand_list = $nv_Request->get_string('brand_chuoi', 'get,post', '');
	$page_title = $module_info['site_title'];
	$key_words = $module_info['keywords'];
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ajax&mod=load_product_cat_list_phan_trang&brand=' . $brand_filt . '&category_child=' . $category_child . '&category_id=' . $category_id . '&sort=' . $sort . '&brand_chuoi=' . $brand_list;
	if($sort==1){
		$sort = ' t1.number_view DESC ';
		}else if($sort==2){
		$sort = ' t1.time_add DESC ';
		}else if($sort==3){
		$sort = ' t1.number_order DESC ';
		}else if($sort==4){
		$sort = ' t1.price_sort ASC ';
		}else if($sort==5){
		$sort = ' t1.price_sort DESC ';
		}else{
		$sort = '';
	}
	
	
	if($brand_filt){
		$where .= ' AND( t1.brand = ' . $brand_filt . ' )';
	}
	
	
	if($price_from && $price_to){
		$where .= ' AND(  (t1.price_sort >= '.$price_from.' AND t1.price_sort <= '.$price_to . '))';
		}else if(!$price_from && !$price_to){
		
		}else if($price_from && !$price_to){
		$where .= ' AND(  (t1.price_sort >= ' . $price_from . '))';
		}else if(!$price_from && $price_to){
		$where .= ' AND(  (t1.price_sort < ' . $price_to . '))';
	}
	if($brand){
		
		$brand_stt = 1;
		
		foreach ($brand as $key => $value) {
			if($value){
				$info_brand = $db->query('SELECT * FROM ' . TABLE . '_brand WHERE id = ' . $value)->fetch();
				if($info_brand){
					if($brand_stt==1){
						if(count($brand)==1){
							$where .= ' AND(  (t4.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t4.id=' . $value . ')';
						}
						}else if($brand_stt==count($brand)){
						$where .= ' OR (t4.id=' . $value . '))';
						}else{
						$where .= ' OR (t4.id=' . $value . ')';
					}
				}
			}
			$brand_stt ++;
		}
	}
	
	if(count($origin)>0){
		$origin_stt = 1;
		foreach ($origin as $key => $value) {
			if($value){
				$info_origin = $db->query('SELECT * FROM ' . TABLE . '_origin WHERE id = ' . $value)->fetch();
				if($info_origin){
					if($origin_stt==1){
						if(count($origin)==1){
							$where .= ' AND(  (t3.id=' . $value . '))';
							}else{
							$where .= ' AND(  (t3.id=' . $value . ')';
						}
						}else if($origin_stt==count($origin)){
						$where .= ' OR (t3.id=' . $value . '))';
						}else{
						$where .= ' OR (t3.id=' . $value . ')';
					}
				}
			}
			$origin_stt ++;
		}
	}
	
	
	
	//phantrangajax//
	$per_page = $config_setting['number_product'];
	$page = $nv_Request->get_int('page', 'post,get', 0);
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	//phantrangajax//
	
	if($category_child != 0){
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('t1.categories_id = ' . $category_child . ' ' . $where .' and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )');
		}else{
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
		->where('(t2.id='.$category_id.' OR t2.parrent_id='.$category_id.') and t1.status=1  and t1.id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )' . ' ' . $where );
	}
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.*')
	->order($sort)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$contents = nv_theme_retail_sort_product_in_view_cat_list($sth,$per_page,$page_new,$num_items,$base_url,$category_id,$shop_id,$sort_price,$category_child,$brand_filt,$brand_list);
	echo $contents;
	die();
	
}


if($mod=='check_classify_id_value'){
	$classify_id_value1 = $nv_Request->get_int('classify_id_value1', 'get,post', 0);
	$classify_id_value2 = $nv_Request->get_int('classify_id_value2', 'get,post', 0);
	$product_id = $nv_Request->get_int('product_id', 'get,post', 0);
	$status=$db->query('SELECT t3.status FROM '.TABLE.'_product_classify t1 INNER JOIN '.TABLE.'_product_classify_value t2 ON t1.id=t2.classify_id INNER JOIN '.TABLE.'_product_classify_value_product t3 ON t3.classify_id_value1=t2.id where t1.product_id='.$product_id.' and classify_id_value1='.$classify_id_value1.' and classify_id_value2='.$classify_id_value2.' group by t1.id')->fetchColumn();
	print_r( json_encode( array('check_status'=>$status)));
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
if($mod=='upload'){
	
	if( isset( $_FILES['file'] ) and is_uploaded_file( $_FILES['file']['tmp_name'] ) )
	{
		$name_image = $_FILES['file']['name'];
		if( !file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . date('Y_m', NV_CURRENTTIME) ) )
		{
			nv_mkdir( NV_UPLOADS_REAL_DIR . '/' . $module_upload, date('Y_m', NV_CURRENTTIME) );
		}
		// Xoa file cu neu ton tai
		if( !empty( $name_image ) and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . date('Y_m', NV_CURRENTTIME) . '/' . $name_image ) )
		{
			nv_deletefile( NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . date('Y_m', NV_CURRENTTIME) . '/' . $name_image );
		}
		$file_allowed_ext = !empty( $array_config['upload_filetype'] ) ? $array_config['upload_filetype'] : $global_config['file_allowed_ext'];
		$upload = new NukeViet\Files\Upload( $file_allowed_ext, $global_config['forbid_extensions'], $global_config['forbid_mimes'], $array_config['maxfilesize'], NV_MAX_WIDTH, NV_MAX_HEIGHT );
		$upload_info= move_uploaded_file( $_FILES['file']['tmp_name'], NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . date('Y_m', NV_CURRENTTIME) . '/' . $name_image);
		$json[] = ['status'=>'OK', 'text'=>'/' . date('Y_m', NV_CURRENTTIME) . '/' . $name_image];
	}
	print_r(json_encode($json[0]));die(); 
}
if($mod=='rate_product'){
	$content = $nv_Request->get_string('content', 'get,post', '');
	$image = $nv_Request->get_string('image', 'get,post', '');
	$star = $nv_Request->get_int('star', 'get,post', 0);
	$id = 1;
	$db->query("INSERT INTO " . TABLE . "_rate (
	star, content, time_add, status, product_id, userid, image) VALUES (" . $star . ",'" . $content . "', " . NV_CURRENTTIME . ",1," . $id . "," . $user_info['userid'] . ",'" . $image . "')");
	$json[] = ['status'=>'OK', 'text'=>'Gửi đánh giá thành công!'];
	print_r(json_encode($json[0]));die(); 
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
if($mod=='send_ahamove'){
	$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
	$info_order=get_info_order($order_id);
	$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
	$info_warehouse['address_full'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
	$info_order['address_full'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
	$path=array();
	if($info_order['payment']==0){
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
	if($info_order['payment']==0){
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
		$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
		print_r( json_encode( array('status'=>'OK' ) ));
		die();
		}else{
		print_r( json_encode( array('status'=>'ERROR','mess'=>$order_ahamove['description'] ) ));
		die();
	}
}
if($mod=='send_ghn'){
	$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
	$view = $nv_Request->get_int('view', 'get,post', 0);
	if($view==0){
		$required_note='KHONGCHOXEMHANG';
		}else if($view==1){
		$required_note='CHOXEMHANGKHONGTHU';
		}else if($view==2){
		$required_note='CHOTHUHANG';
	}
	$info_order=get_info_order($order_id);
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
		"quantity" => $value['quantity'],
		"code" => $value['barcode']
		);
	} 
	$order_ghn=send_ghn($info_warehouse['shops_id_ghn'],$info_order['order_name'],$info_order['phone'],$info_order['address'],$ReceiverWardId,$ReceiverDistrictId,$PackageContent,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$info_order['total'],$ServiceName,$required_note,$list_item);
	$db->query('UPDATE '.TABLE.'_order SET status=2, shipping_code='.$db->quote($order_ghn['data']['order_code']).' where id='.$order_id);
	$content='Chuyển sang đơn vị vận chuyển GHN Thành Công';
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
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
	if($payment_method!=''){
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
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
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
	$order_viettelpost=send_viettelpost($info_order['total'],$info_order['total'],'',$ServiceName,$SenderProvinceId,$SenderDistrictId,$SenderWardId,$info_warehouse['lat'],$info_warehouse['lng'],$ReceiverProvinceId,$ReceiverDistrictId,"HH",$info_order['order_code'],$info_warehouse['groupaddressid'],$info_warehouse['cusid'],$info_warehouse['name_send'],$info_warehouse['address'],str_replace("-","",$info_warehouse['phone_send']),$info_order['order_name'],$info_order['address'],$info_order['phone'],$PackageContent,$PackageContent,$PRODUCT_QUANTITY,3,$list_item,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height'],$ReceiverWardId,$info_order['lat'],$info_order['lng']);
	$db->query('UPDATE '.TABLE.'_order SET status=2, shipping_code='.$db->quote($order_viettelpost['data']['ORDER_NUMBER']).' where id='.$order_id);
	$content='Chuyển sang đơn vị vận chuyển Viettel Post Thành Công';
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
}
if($mod=='send_vnpost'){
	$IsPackageViewable = $nv_Request->get_int('IsPackageViewable', 'get,post', 0);
	$PickupType = $nv_Request->get_int('PickupType', 'get,post', 0);
	$PickupPoscode = $nv_Request->get_int('PickupPoscode', 'get,post', 0);
	$order_id = $nv_Request->get_int('order_id', 'get,post', 0);
	$info_order=get_info_order($order_id); 
	$ServiceName=get_info_transporters($info_order['transporters_id'])['code_transporters'];
	$info_warehouse=get_info_warehouse($info_order['warehouse_id']);
	$info_warehouse['address'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
	$SenderProvinceId=get_info_province($info_warehouse['province_id'])['vnpostid'];
	$SenderDistrictId=get_info_district($info_warehouse['district_id'])['vnpostid'];
	$SenderWardId=get_info_ward($info_warehouse['ward_id'])['vnpostid'];
	$ReceiverProvinceId=get_info_province($info_order['province_id'])['vnpostid'];
	$ReceiverDistrictId=get_info_district($info_order['district_id'])['vnpostid'];
	$ReceiverWardId=get_info_ward($info_order['ward_id'])['vnpostid'];
	$PackageContent='Đơn hàng với mã đơn hàng '.$info_order['order_code'];
	$info_order['address'] = $info_order['address'].', '.get_info_ward( $info_order['ward_id'] )['title'].', '.get_info_district( $info_order['district_id'] )['title'].', '.get_info_province( $info_order['province_id'] )['title'];
	$order_vnpost=send_vnpost($info_order['order_code'],$PickupType,$IsPackageViewable,$PackageContent,$ServiceName, $info_warehouse['name_send'], $info_warehouse['address'], $info_warehouse['phone_send'],$SenderProvinceId,$SenderDistrictId, $SenderWardId, $info_order['order_name'], $info_order['address'], $info_order['phone'], $ReceiverProvinceId, $ReceiverDistrictId,$ReceiverWardId,$info_order['total'],$PickupPoscode,$info_order['total_weight'],$info_order['total_length'],$info_order['total_width'],$info_order['total_height']);
	$db->query('UPDATE '.TABLE.'_order SET status=2, shipping_code='.$db->quote($order_vnpost['ItemCode']).' where id='.$order_id);
	$content='Chuyển sang đơn vị vận chuyển VNPOST Thành Công';
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',1,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
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

if($mod =='change_status_received'){
	$order_id = $nv_Request->get_int('order_id', 'post,get' );
	
	check_order($order_id);
	$db->query('UPDATE '. TABLE .'_order SET status = 7 WHERE id = ' . $order_id);
	update_time_edit_order($order_id);
	//xóa khiểu nại chưa nhận hàng nếu có
	$db->query('DELETE FROM '. TABLE .'_order_not_received WHERE order_id = ' . $order_id);
	
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
}

if($mod =='change_status_not_received'){
	$order_id = $nv_Request->get_int('order_id', 'post,get' );
	
	check_order($order_id);
	$info_order = get_info_order($order_id);

	$sql = 'INSERT INTO ' . TABLE . '_order_not_received (userid, order_id, reason, time_add, status) VALUES (:userid, :order_id, :reason, :time_add, :status)';
	$data_insert = array();
	$data_insert['userid'] = $info_order['userid'];
	$data_insert['order_id'] = $info_order['id'];
	$data_insert['reason'] = 'Khách hàng chưa nhận được hàng';
	$data_insert['time_add'] = NV_CURRENTTIME;
	$data_insert['status'] = 0;
		
	$id = $db->insert_id($sql, 'id', $data_insert);
	
	if($id){
		send_mail_order_not_received($info_order);
	}
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
}


if($mod=='change_status_cancel'){
	$order_id = $nv_Request->get_title( 'order_id', 'post,get' );
	$content = $nv_Request->get_title( 'content', 'post,get','' ); 
	check_order($order_id);
	// cập nhật trạng thái đơn hàng = 4
	$db->query('UPDATE '. TABLE .'_order SET status = 4 where id = ' . $order_id);
	
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
	if($info_order['shipping_code'] and ($info_order['transporters_id'] == 4 or $info_order['transporters_id'] == 5))
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
	
	
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',4,'.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
	
	
	$content_ip = 'Đơn hàng ' . $info_order['order_code'] . ' đã bị hủy với lý do ' . $content;
	
	nv_insert_notification_ecng($user_info['userid'], $info_order['store_id'], $content_ip, $order_id, "order");
	
	nv_insert_notification_shop($user_info['userid'], $info_order['store_id'], $content_ip, $order_id, "order");
	
	$info_order['lydohuy'] = $content;
	send_email_order_cancel($info_order);
	
	// hoàn trả tiền vnpay
	vnpay_refund($info_order);
	
	print_r( json_encode( array('status'=>'OK' ) ));
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
	foreach($list_product as $value){
		$amount_delivery_old=$db->query('SELECT amount_delivery FROM '.TABLE.'_inventory_product where warehouse_id='.$warehouse_id.' and product_id='.$value['product_id'].' and classify_value_product_id='.$value['classify_value_product_id'])->fetchColumn();
		$amount_delivery_new=$amount_delivery_old-$value['quantity'];
		$db->query('UPDATE '.TABLE.'_inventory_product SET amount_delivery='.$amount_delivery_new.' where warehouse_id='.$warehouse_id.' and product_id='.$value['product_id'].' and classify_value_product_id='.$value['classify_value_product_id']);
		$number_order_old=$db->query('SELECT number_order FROM '.TABLE.'_product where id='.$value['product_id'])->fetchColumn();
		$number_order_new = $number_order_old + $value['quantity'];
		$db->query('UPDATE '.TABLE.'_product SET number_order='.$number_order_new.' where id='.$value['product_id']);
	}
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.','.$status_old.','.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
}
if($mod=='change_status'){
	$order_id = $nv_Request->get_title( 'order_id', 'post,get' );
	$status_new = $nv_Request->get_int( 'status_new', 'post,get' );
	$status_old = $nv_Request->get_int( 'status_old', 'post,get' );
	$db->query('UPDATE '.TABLE.'_order SET status='.$status_new.' where id='.$order_id);
	if($status_new==1){
		$content='Đơn hàng chuyển sang trạng thái đã xác nhận';
	}
	$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.','.$status_old.','.$db->quote($content).','.NV_CURRENTTIME.','.$user_info['userid'].')');
	print_r( json_encode( array('status'=>'OK' ) ));
	die();
}
if($mod=='load_order_customer'){
	check_login();
	$where = '';
	$q = $nv_Request->get_title( 'q', 'post,get' );
	$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );
	
	if(!$q and !$status_ft){
		print_r( json_encode( array('status'=>'ERROR' )));
		die();
	}
	$_SESSION[$module_data.'_status_view_order']=$status_ft;
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op.'&mod=load_order_customer';
	
	
	if($status_ft == 3){
		$where .= ' AND status IN(' . $status_ft . ',7)';
		$base_url .= '&status_search=' . $status_ft;
	}
	elseif ( $status_ft >- 1 ) {
		$where .= ' AND status ='.$status_ft;
		$base_url .= '&status_search=' . $status_ft;
	}
	
	
	if ( !empty( $q ) ) {
		$where .= ' AND (order_code LIKE "%" "'.$q. '" "%" OR order_name LIKE "%" "'.$q. '" "%" OR phone LIKE "%" "'.$q. '" "%" OR email LIKE "%" "'.$q. '" "%")';
		$base_url .= '&q=' . $q;
	}
	

	$per_page = 10;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_order')
	->where('( payment != 0 OR payment_method = "recieve" )  AND userid = '.$user_info['userid'] . $where);
	
	$sth = $db->prepare($db->sql());
	$sth->execute();
	$num_items = $sth->fetchColumn();
	
	$db->select('*')
	->order('id DESC')
	->limit($per_page)
	->offset(($page - 1) * $per_page);
	$sth = $db->prepare($db->sql());
	
	
	$sth->execute();
	$xtpl = new XTemplate('ordercustomer_ajax.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	
	if ( $ngay_tu > 0 )
	$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
	if ( $ngay_den > 0 )
	$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
	
	$generate_page = nv_generate_page_viewcat($base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'item_order_customer');
	if (!empty($generate_page)) {
		$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
		$xtpl->parse('main.generate_page');
	}
	$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
	
	if(!$num_items)
	{
		$xtpl->parse('main.no_product');
	}
	
	while ($view = $sth->fetch()) {
		$view['number'] = $number++;		
		$info_store = get_info_store($view['store_id']);
		$view['alias_shop'] = NV_MY_DOMAIN .'/'.get_info_user($info_store['userid'])['username'].'/';
		
		$view['store_name']=get_info_store($view['store_id'])['company_name'];
		$avatar_image_store = get_info_store($view['store_id'])['avatar_image'];
		$view['avatar_image_store'] = $avatar_image_store;
		
		// ten trang thai don hang
		$view['order_status'] = $global_status_order[$view['status']]['name'];
		
		// kiem tra don hang tai khoan nay da danh gia chua
		$check_rate = $db->query("SELECT id FROM " . TABLE ."_rate WHERE userid =". $user_info['userid']." AND order_id =" . $view['id']) -> fetchColumn();
		// lay thong tin san pham cua don hang
		$list_products = get_list_products_order($view['id']);
		
		foreach($list_products as $product)
		{
			$xtpl->assign('product', $product);
			$xtpl->parse('main.loop.product');
		}
		
		// cho phep danh gia don hang Đã giao
		
		if(($view['status'] == 7) and (!$check_rate))
		{
			
			foreach($list_products as $product)
			{
				$xtpl->assign('product', $product);
				$xtpl->assign('VIEW', $view);
				$xtpl->parse('main.loop.rate.product_rate');
			}
			
			$xtpl->parse('main.loop.rate');
		}
		
		// giao hàng thành công trong vòng 1 tuần, khách hàng có quyền khiếu nại
		if($view['status'] == 3)
		{
			
			// lấy ngày giao hàng thành công ra
			$ngay_giao_thanh_cong = $db->query('SELECT max(time_add) FROM ' . TABLE .'_logs_order WHERE status_id_old = 3 AND order_id ='. $view['id'])->fetchColumn();
			
			$songay = (NV_CURRENTTIME - $ngay_giao_thanh_cong)/86400;
			
			if($songay < 2000)
			{
				$link_complain = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '='. $module_name . '&' . NV_OP_VARIABLE . '=complain&order_id='. $view['id'],true);
				$xtpl->assign('link_complain', $link_complain);
				$xtpl->parse('main.loop.complain');
			}
			
		}
		
		$view['total_product'] = number_format($view['total_product']);
		$view['fee_transport'] = number_format($view['fee_transport']);
		$view['total'] = number_format($view['total']);
		$view['time_add_string'] = date('d-m-Y H:i',$view['time_add']);
		
		$view['link_view'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=vieworder&amp;id=' . $view['id'],true);
		$xtpl->assign('VIEW', $view);
		if($view['status'] == 3)
		{	
			$check_order_processing = $db->query('SELECT id FROM '  . TABLE . '_order_not_received WHERE userid = ' .$user_info['userid'] . ' AND status = 0 AND order_id = ' . $view['id'])->fetchColumn();
			if($check_order_processing){
				$xtpl->parse('main.loop.not_received_processing');
			}else{
				$xtpl->parse('main.loop.not_received');
			}
			$xtpl->parse('main.loop.received');
			
		}
		
		// cho phép hủy đơn hàng trong vòng 2h, khác trạng thái hủy đơn
		if((NV_CURRENTTIME - $view['time_add']) < 7200 and $view['status'] != 4)
		{//print_r($view['time_add']);die;
			$xtpl->parse('main.loop.status_cancel');
		}
		$xtpl->parse('main.loop');
	}
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['order'];
	echo $contents; die;
	
}


if($mod=='load_order_customer_no_payment'){
	check_login();
	$where = '';
	$q = $nv_Request->get_title( 'q', 'post,get' );
	
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op.'&mod=load_order_customer_no_payment';
	
	if ( !empty( $q ) ) {
		$where .= ' AND (order_code LIKE "%" "'.$q. '" "%" OR order_name LIKE "%" "'.$q. '" "%" OR phone LIKE "%" "'.$q. '" "%" OR email LIKE "%" "'.$q. '" "%")';
		$base_url .= '&q=' . $q;
	}
	
	$per_page = 7;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_order')
	->where('payment = 0 AND userid='.$user_info['userid'] . $where);
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	
	$db->select('*')
	->order('id DESC')
	->limit($per_page)
	->offset(($page - 1) * $per_page);
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$xtpl = new XTemplate('ordercustomer_nopayment_ajax.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
	
	if ( $ngay_tu > 0 )
	$xtpl->assign( 'ngay_tu', date( 'd-m-Y', $ngay_tu ) );
	if ( $ngay_den > 0 )
	$xtpl->assign( 'ngay_den', date( 'd-m-Y', $ngay_den ) );
	
	$generate_page = nv_generate_page_viewcat($base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'item_order_customer');
	if (!empty($generate_page)) {
		$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
		$xtpl->parse('main.generate_page');
	}
	$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
	
	if(!$num_items)
	{
		$xtpl->parse('main.no_product');
	}
	
	$data = $sth->fetchAll();
	
	$i = 0;
	//$tongtien = 0;
	$order_array = array();
	
	foreach ($data as $view) {
		$view['number'] = $number++;
		
		// tinhs tien voucher
		//don 1
		if($view['voucherid'])
		{
			$shop_id = get_info_store($view['store_id'])['userid'];
			
			$check_voucher = check_voucher('', $view['voucherid'], $shop_id);
			$arr = json_decode($check_voucher, true);
			
			if($arr['status'] == 'ERROR'){
				$update_voucher = $db->query('UPDATE ' . TABLE . '_order SET total = total + ' . $view['voucher_price'] . ' , voucherid = 0, voucher_price = 0 WHERE id = ' . $view['id'] . ' AND status_payment_vnpay = 0');
				$view['total'] = $view['total'] + $view['voucher_price'];
			}
		}
		//don++
		if(isset($data[$j]['voucherid']) and $data[$j]['voucherid'])
		{
			$shop_id = get_info_store($data[$j]['store_id'])['userid'];
			
			$check_voucher = check_voucher('',$data[$j]['voucherid'], $shop_id);
			$arr = json_decode($check_voucher, true);
			
			if($arr['status'] == 'ERROR'){
				$update_voucher = $db->query('UPDATE ' . TABLE . '_order SET total = total + ' . $data[$j]['voucher_price'] . ' , voucherid = 0, voucher_price = 0 WHERE id = ' . $data[$j]['id'] . ' AND status_payment_vnpay = 0');
				$data[$j]['total'] = $data[$j]['total'] + $data[$j]['voucher_price'];
			}
		}
		
		// tổng tiền thanh toán lại
		if(!$payment)
		{
			// lấy tổng tiền tại thời gian này
			$time_from = $view['time_add'] - 10;
			$time_to = $view['time_add'] + 10;
			
			$j = $i + 1;
			
			$order_array[] = $view['id'];
			
			if(($data[$j]['time_add'] >= $time_from) and ($data[$j]['time_add'] <= $time_to))
			{
				
				$tongtien += $view['total'] + $data[$j]['total'];
				
			}
			else
			{	
				$xtpl->assign('id_order', implode(',',$order_array));
				
				if($tongtien)
				{
					$total_payment = number_format($tongtien);
					$xtpl->assign('total_payment', $total_payment);
					$xtpl->assign('tongtien', $tongtien);
					
				}
				else
				{
					$total_payment = number_format($view['total']);
					$xtpl->assign('total_payment', $total_payment);
					$xtpl->assign('tongtien', $view['total']);
				}
				
				$tongtien = 0;
				$order_array = array();
				
				$xtpl->parse('main.loop.repayment');
			}
			
		}
		
		$i++;
		
		$info_store = get_info_store($view['store_id']);
		$view['alias_shop'] = NV_MY_DOMAIN .'/'.get_info_user($info_store['userid'])['username'].'/';
		//$view['alias_shop'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . get_info_user($info_store['userid'])['username'], true );
		$view['store_name']=get_info_store($view['store_id'])['company_name'];
		$avatar_image_store = get_info_store($view['store_id'])['avatar_image'];
		$view['avatar_image_store'] = $avatar_image_store;
		
		// ten trang thai don hang
		$view['order_status'] = $global_status_order[$view['status']]['name'];
		
		// kiem tra don hang tai khoan nay da danh gia chua
		$check_rate = $db->query("SELECT id FROM " . TABLE ."_rate WHERE userid =". $user_info['userid']." AND order_id =" . $view['id']) -> fetchColumn();
		
		
		// lay thong tin san pham cua don hang
		$list_products = get_list_products_order($view['id']);
		foreach($list_products as $product)
		{
			$xtpl->assign('product', $product);
			$xtpl->parse('main.loop.product');
			
			if(($view['status'] == 3) and (!$check_rate))
			{
				$xtpl->assign('VIEW', $view);
				$xtpl->parse('main.loop.rate.product_rate');
			}
		}
		
		// cho phep danh gia don hang Đã giao
		
		if(($view['status'] == 3) and (!$check_rate))
		{
			$xtpl->parse('main.loop.rate');
		}
		
		
		$view['total_product']=number_format($view['total_product']);
		$view['fee_transport']=number_format($view['fee_transport']);
		$view['total']=number_format($view['total']);
		$view['time_add']=date('d-m-Y H:i',$view['time_add']);
		
		$view['link_view'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=vieworder&amp;id=' . $view['id'],true);
		$xtpl->assign('VIEW', $view);
		if($view['status']==0){
			$xtpl->parse('main.loop.status_cancel');
		}	
		
		
		$xtpl->parse('main.loop');
	}
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['order'];
	echo $contents; die;
	
}


// xử lý thanh toán lại đơn hàng vnpay 
if($mod=='repayment'){
	$data['id_order'] = $nv_Request->get_title( 'id_order', 'post,get','');
	
	
	if(!$data['id_order'])
	{
		print_r( json_encode( array('status'=>'ERROR' ) ));
		die();
	}
	$list_order = $db->query('SELECT * FROM '. TABLE .'_order WHERE id IN('. $data['id_order'] .')')->fetchAll();
	
	//$total_full = 0;	
	foreach($list_order as $order){
		
		$shop_id = get_info_store($order['store_id'])['userid'];
		
		$check_voucher = check_voucher('', $order['voucherid'], $shop_id);
		$arr = json_decode($check_voucher, true);
		
		if($arr['status'] == 'ERROR'){
			$order['total'] = $order['total'] + $order['voucher_price'];
			
		}
		$total_full += $order['total'];
		
	}
	
	// trả về url thanh toán vnpay
	
	$list_order =  $db->query('SELECT order_code FROM '. TABLE .'_order WHERE userid =' . $user_info['userid'] . ' AND id IN('. $data['id_order'] .')')->fetchAll();
	
	$arrcode = array();
	foreach($list_order as $order)
	{
		$arrcode[] = $order['order_code'];
	}
	
	$order_full = $data['id_order'];
	$list_order_code = implode(',',$list_order_code);

	//Payment_port($order_full,$list_order_code,);
	$vnp_TransactionNo = $order_full;
	$vnp_OrderInfo = 'Thanh toan giao dich '.$list_order_code.' vao thoi gian '.date('d-m-Y H:i',NV_CURRENTTIME);
	
	$vnp_ReturnUrl= 'https://chonhagiau.com/retails/payment/';

	$check_payport = send_vnpay($total_full,$vnp_OrderInfo,$config_setting['website_code_vnpay'],$vnp_TransactionNo,$config_setting['checksum_vnpay'],$vnp_ReturnUrl,'171.226.0.17');
	$result = array(
	'status' => 'OK',
	'link' => $check_payport
	);
	print_r( json_encode($result));die;
	die();
	
	
}

if($mod=='load_order'){
	$where = '';
	$q = $nv_Request->get_title( 'q', 'post,get' );
	$sea_flast = $nv_Request->get_int( 'sea_flast', 'post,get' );
	$ngay_den = $nv_Request->get_title( 'ngay_den', 'post,get' );
	$ngay_tu = $nv_Request->get_title( 'ngay_tu', 'post,get' );
	$status_ft = $nv_Request->get_title( 'status_search', 'post,get', -1 );
	$_SESSION[$module_data.'_status_view_order']=$status_ft;
	$store_id = $nv_Request->get_int( 'store_id', 'post,get', 0 );
	$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'post,get', 0 );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op.'&mod=load_order&q='.$q.'&sea_flast='.$sea_flast.'&ngay_den='.$ngay_den.'&ngay_tu='.$ngay_tu.'&status_search='.$status_ft.'&store_id='.$store_id.'&warehouse_id='.$warehouse_id;
	
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
			
			$where .= ' AND time_add >= '. $ngay_tu . ' AND time_add <= '. $ngay_den;
			$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
		} else if ( $ngay_tu > 0 )
		{
			$where .= ' AND time_add >= '. $ngay_tu;
			$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
		} else if ( $ngay_den > 0 )
		{
			$where .= ' AND time_add <= '. $ngay_den;
			$base_url .= '&ngay_tu=' . date( 'd-m-Y', $ngay_tu ) .'&ngay_den='.date( 'd-m-Y', $ngay_den );
		}
		
	}
	if ( $status_ft>-1 ) {
		$where .= ' AND status ='.$status_ft;
		$base_url .= '&status_search=' . $status_ft;
	}
	if ( !empty( $q ) ) {
		$where .= ' AND (order_code LIKE "%" "'.$q. '" "%" OR order_name LIKE "%" "'.$q. '" "%" OR phone LIKE "%" "'.$q. '" "%" OR email LIKE "%" "'.$q. '" "%")';
		$base_url .= '&q=' . $q;
	}
	if($store_id>0){
		$where .= ' AND store_id ='.$store_id;
		$base_url .= '&store_id=' . $store_id;
	}
	if($warehouse_id>0){
		$where .= ' AND warehouse_id ='.$warehouse_id;
		$base_url .= '&warehouse_id=' . $warehouse_id;
	}
	
	$per_page = 10;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_order')
	->where('1=1'.$where);
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	
	$db->select('*')
	->order('id DESC')
	->limit($per_page)
	->offset(($page - 1) * $per_page);
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$xtpl = new XTemplate('order_ajax.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
		
		$info_store = get_info_store($view['store_id']);
		$view['alias_shop'] = NV_MY_DOMAIN .'/'. $module_name .'/'.get_info_user($info_store['userid'])['username'].'/';
		
		$view['store_name']=get_info_store($view['store_id'])['company_name'];
		$view['warehouse_name']=get_info_warehouse($view['warehouse_id'])['name_warehouse'];
		$view['phone_warehouse']=get_info_warehouse($view['warehouse_id'])['phone_send'];
		$info_warehouse = get_info_warehouse( $view['warehouse_id'] );
		$view['address_warehouse'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
		$view['address_receive'] = $view['address'].', '.get_info_ward( $view['ward_id'] )['title'].', '.get_info_district( $view['district_id'] )['title'].', '.get_info_province( $view['province_id'] )['title'];
		$view['transporters_name']=get_info_transporters($view['transporters_id'])['name_transporters'];
		$view['total_product']=number_format($view['total_product']);
		$view['fee_transport']=number_format($view['fee_transport']);
		$view['total']=number_format($view['total']);
		$view['time_add']=date('d-m-Y H:i',$view['time_add']);
		if($view['payment_method']=='recieve'){
			$view['payment_method']='Thanh toán khi nhận hàng';
			}else{
			$view['payment_method']='Thanh toán qua ví tiền';
		}
		$view['link_view'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=vieworder&amp;id=' . $view['id'].'&store_id='.$view['store_id'].'&warehouse_id='.$view['warehouse_id'],true);
		$xtpl->assign('VIEW', $view);
		if($view['status']==0){
			$xtpl->parse('main.loop.status0');
			}else if($view['status']==1){
			if($view['transporters_id']==4 || $view['transporters_id']==5){
				$xtpl->parse('main.loop.vnpost');
				}else if($view['transporters_id']==6 || $view['transporters_id']==7 || $view['transporters_id']==8|| $view['transporters_id']==9){
				$xtpl->parse('main.loop.viettelpost');
				}else if($view['transporters_id']==2){
				$xtpl->parse('main.loop.ghtk');
				}else if($view['transporters_id']==3 || $view['transporters_id']==11){
				$xtpl->parse('main.loop.ghn');
				}else{
				$xtpl->parse('main.loop.ahamove');
			}
			}else if($view['status']>1){
			if($view['transporters_id']==1||$view['transporters_id']>=15){
				$xtpl->assign('VIEW', $view);
				$xtpl->parse('main.loop.link_check_ahamove_order');
				}else{
				$xtpl->assign('VIEW', $view);
				$xtpl->parse('main.loop.no_link_check_ahamove_order');
			}
		}
		if($view['status']==2){
			$xtpl->parse('main.loop.status_success');
			}else if($view['status']<2){
			$xtpl->parse('main.loop.status_cancel');
		}
		$xtpl->parse('main.loop');
	}
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	
	$page_title = $lang_module['order'];
	echo $contents; die;
	
}

if($mod == 'add_voucher'){
	$voucher_code = $nv_Request->get_string( 'voucher_code', 'get,post', '' );
	$shop_id = $nv_Request->get_string( 'shop_id', 'get,post', '' );
	$voucher_pice_one_shop = $nv_Request->get_string( 'voucher_pice_one_shop', 'get,post', '' );
	$method = $nv_Request->get_string( 'method', 'get,post', 1 );
	
	if(empty($voucher_code)){
		$json = ['status'=>'ERROR', 'mess'=>'Chưa nhập voucher'];
		return json_encode($json);
	}
	
	
	if($_SESSION['shop'][$shop_id] == $voucher_code and $method and $voucher_code)
	{
		$json = ['status'=>'ERROR', 'mess'=>'Voucher đã tồn tại!'];
		print_r(json_encode($json));die();
	}
	if(empty($voucher_pice_one_shop)){
		$voucher_pice_one_shop =0;
	}
	$check = check_voucher($voucher_code, '', $shop_id);
	
	$arrr = json_decode($check,true);
	
	if($voucher_pice_one_shop){
		if($arrr['minimum_price'] > $voucher_pice_one_shop){
			$json = ['status'=>'ERROR', 'mess'=>'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng voucher'];
			print_r(json_encode($json));die();
		}	
	}
	
	
	if($method){
		$_SESSION['shop'][$shop_id] = $arrr['voucher_code'];
		$_SESSION['price'][$shop_id] = $arrr['voucher_price'];
		
		}else{
		$_SESSION['shop'][$shop_id] = '';
		
		$json = ['status'=>'OK', 'voucher_price'=>$_SESSION['price'][$shop_id]];
		print_r(json_encode($json));die();
	}
	//TRA KQ
	print_r($check);die();
	
	
}

if($mod == 'remove_voucher_shop'){
	if (!defined('NV_IS_USER')) {
		
		$contents1 = array(
		'status' => 'ERROR',
		'mess' => 'Vui lòng đăng nhập hệ thống'
		);
		print_r( json_encode($contents1));die;
		
		}else{
		$userid=$user_info['userid'];
	}
	$store_id = $nv_Request->get_int( 'store_id', 'get,post', '' );
	if(empty($store_id)){
		print_r( json_encode( array('status'=>'ERROR','mess'=>'Chưa nhập voucher' ) ));
		die();
	}
	
	unset($_SESSION['voucher_shop'][$store_id]);
	
	print_r( json_encode( array('status'=>'OK','mess'=>'Đổi voucher thành công' ) ));
	die();
}

if($mod == 'apply_voucher_shop'){
	if (!defined('NV_IS_USER')) {
		
		$contents1 = array(
		'status' => 'ERROR',
		'mess' => 'Vui lòng đăng nhập hệ thống'
		);
		print_r( json_encode($contents1));die;
		
		}else{
		$userid=$user_info['userid'];
	}
	
	$voucherid = $nv_Request->get_int( 'voucherid', 'get,post', '' );
	$store_id = $nv_Request->get_int( 'store_id', 'get,post', '' );
	$total_price_shop = $nv_Request->get_int( 'total_price_one_shop', 'get,post', '' );
	$list_product = $nv_Request->get_array( 'product_id', 'get,post', '' );
	$today = NV_CURRENTTIME;
	foreach($list_product as $key => $value){
		$list_product_voucher =  explode(',', $value);
	}
	
	
	//kt thông số đầu vào
	if(empty($voucherid) or empty($store_id) or empty($total_price_shop)){
		print_r( json_encode( array('status'=>'ERROR','mess'=>'Chưa nhập voucher' ) ));
		die();
	}
	$check_voucher = $db ->query('SELECT id FROM ' . TABLE . '_voucher_shop WHERE id = ' . $voucherid)->fetchColumn();
	if(!$check_voucher){
		print_r( json_encode( array('status'=>'ERROR','mess'=>'Chưa nhập voucher' ) ));
		die();
	}
	//check voucher từng sp
	$arr_product = array();
	if($list_product){
		foreach($list_product_voucher as $product_id){
			
			$voucher = $db->query('SELECT id, voucher_name, type_discount, discount_price, maximum_discount, minimum_price, time_to, list_product FROM ' . TABLE . '_voucher_shop WHERE status = 1 AND usage_limit_quantity > 0 AND store_id = ' . $store_id . '  AND (FIND_IN_SET(' . $product_id . ', list_product) OR FIND_IN_SET(0, list_product)) AND time_from < ' . $today . ' AND time_to > ' . $today . ' AND minimum_price <= ' . $total_price_shop . ' AND id = ' . $voucherid . ' UNION SELECT t2.id, t2.voucher_name, t2.type_discount, t2.discount_price, t2.maximum_discount, t2.minimum_price, t2.time_to, t2.list_product FROM ' . TABLE . '_voucher_wallet t1 INNER JOIN ' . TABLE . '_voucher_shop t2 ON t2.id = t1.voucherid WHERE t1.userid = ' . $user_info['userid'] . ' AND (FIND_IN_SET(' . $product_id . ', list_product) OR FIND_IN_SET(0, list_product)) AND t2.time_from < ' . $today . ' AND t2.time_to > ' . $today . ' AND minimum_price <= ' . $total_price_shop . ' AND t2.id = ' . $voucherid)->fetch();
			
			$voucher['price'] = 0;
			if($voucher['type_discount'])
			{
				$voucher['price'] = $total_price_shop * $voucher['discount_price'] / 100;
				$voucher['price'] = floor($voucher['price']);
				if($voucher['maximum_discount']){
					if($voucher['price'] > $voucher['maximum_discount']){
						$voucher['price'] = $voucher['maximum_discount'];
					}
				}
				
			}
			else
			{	
				$voucher['price'] = $voucher['discount_price'];
			}
			
			
			if($voucher['id']){
				array_push($arr_product, $product_id);
				$voucher['product_id'] = $arr_product;
			}
			
		}
		
		$_SESSION['voucher_shop'][$store_id] = $voucher;
		print_r( json_encode( array('status'=>'OK','mess'=>'Đổi voucher thành công' ) ));
		die();
	}
	
}


if ( $mod == 'add_order' ) {
	$order_name = $nv_Request->get_string( 'order_name', 'get,post', '' );
	$order_email = $nv_Request->get_string( 'order_email', 'get,post', '' );
	$order_phone = $nv_Request->get_string( 'order_phone', 'get,post', '' );
	$payment_method = $nv_Request->get_string( 'payment_method', 'get,post', '' );
	$address = $nv_Request->get_string( 'address', 'get,post', '' );
	$province_id = $nv_Request->get_int( 'province_id', 'get,post', 0 );
	$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	$ward_id = $nv_Request->get_int( 'ward_id', 'get,post', 0 );
	//$payment_method = 2;
	$total_full = 0;
	$lat = $nv_Request->get_string( 'lat', 'get,post', '' );
	$lng = $nv_Request->get_string( 'lng', 'get,post', '' );
	$list_transporters = $nv_Request->get_array( 'list_transporters', 'get,post', '' ) ;
	if (defined('NV_IS_USER')) {	
		$userid=$user_info['userid'];
	}	
	
	$error=array();
	$total_full_total = 0;
	$fee_transport_total = 0;
	foreach ( $list_transporters as $index => $value_transporters ) {
		//print_r($value_transporters);die;
		$total_product = 0;
		$total_weight = 0;
		$total_weight_ship = 0;
		$total_width = 0;
		$total_width_ship = 0;
		$total_length = 0;
		$total_length_ship = 0;
		$total_height = 0;
		$total_height_ship = 0;
		
		$total_voucher = 0;
		$tu_giao = false;
		foreach ( $_SESSION[$module_data . '_cart'][$value_transporters['store_id']][$value_transporters['warehouse_id']] as $key_product=>$value_product ) {
			
			if ( $value_product['status_check'] == 1 ) {
				
				
				// xử lý lại các thông tin của sản phẩm phía back-end
				$total_product = $total_product + ($value_product['num'] * $value_product['price']);
				
				$total_full = $total_full + ($value_product['num'] * $value_product['price']);
				
				$get_info_product = get_info_product($value_product['product_id']);
				
				$total_weight += $get_info_product['weight_product'] * $value_product['num'];
				
				if(!$get_info_product['free_ship']){
					$total_weight_ship += $get_info_product['weight_product'] * $value_product['num'];
				}
				//check tu giao
				
				if($get_info_product['self_transport']){
					$tu_giao = true;
					$value_transporters['transporters_id'] = 0;
				}
				
				$total_width_current = $get_info_product['width_product'];
				if($total_width_current > $total_width)
				$total_width = $total_width_current;
				
				if(!$get_info_product['free_ship']){
					$total_width_current = $get_info_product['width_product'];
					if($total_width_current > $total_width_ship)
					$total_width_ship = $total_width_current;
				}
				
				$total_length_current = $get_info_product['length_product'];
				if($total_length_current > $total_length)
				$total_length = $total_length_current;
				
				if(!$get_info_product['free_ship']){
					$total_width_current = $get_info_product['length_product'];
					if($total_width_current > $total_length_ship)
					$total_length_ship = $total_width_current;
				}
				
				$total_height += $get_info_product['height_product'] * $value_product['num'];
				if(!$get_info_product['free_ship']){
					$total_height_ship += $get_info_product['height_product'] * $value_product['num'];
				}
				// kết thúc xử lý lại
				
				
				$number_inventory_max=get_info_invetory_group($value_product['product_id'],$value_product['classify_value_product_id'])['sl_tonkho'];	
				
				if($value_product['num']>$number_inventory_max){
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
						$name_product = $get_info_product['name_product'].' ('.$name_group.')';
						}else{
						$name_product=$get_info_product['name_product'];
					}
					$error[]='Sản phẩm '.$name_product.' hiện chỉ còn '.number_format($number_inventory_max).' sản phẩm. Vui lòng quay lại giỏ hàng để thay đổi.';
				}		
			}
		}
		
		
		// kiem tra tu giao
		if($value_transporters['transporters_id'] == 0 and !$tu_giao)
		{
			$error[] = 'Lỗi không xác định nhà vận chuyển';
		}
		
		// xử lý lại tổng giá sản phẩm của đơn hàng phía back-end
		$list_transporters[$index]['total_product'] = $total_product;
		$list_transporters[$index]['total_weight'] = $total_weight;
		$list_transporters[$index]['total_width'] = $total_width;
		$list_transporters[$index]['total_length'] = $total_length;
		$list_transporters[$index]['total_height'] = $total_height;
		
		//tính phí vận chuyển đơn hàng.		
		if(!$tu_giao)
		{
			// có đơn vị vận chuyển
			$check_vc = $db->query('SELECT COUNT(t1.id) FROM ' . TABLE . '_transporters t1 INNER JOIN ' . TABLE . '_transporters_shop t2 ON t1.id = t2.transporters_id WHERE t1.status = 1 AND t2.status = 1 AND t2.sell_id = ' . $value_transporters['store_id'] . ' AND t1.id = ' . $value_transporters['transporters_id'])->fetchColumn();
			if($check_vc < 1){
				$contents1 = array(
				'status' => 'error',
				'mess' => 'Không có đơn vị vận chuyển!'
				);
				print_r( json_encode($contents1));die;
			}
			if($value_transporters['transporters_id'] == 4 || $value_transporters['transporters_id'] == 5){
				$free_ship = get_free_ship_vnpost($value_transporters['warehouse_id'], $total_weight_ship, $total_length_ship, $total_width_ship, $total_height_ship, $total_product, $province_id, $district_id, $value_transporters['transporters_id'] );
				}elseif($value_transporters['transporters_id'] == 3){
				$free_ship = $_SESSION['tranposter_fee'][$value_transporters['store_id']][3];
			}
			
		}
		else
		{
			// miễn phí vận chuyển
			$free_ship = $_SESSION['self_transport_price_shop'][$value_transporters['store_id']];
		}
		
		//kiểm tra lại voucher -> ok -> lấy trong SESSION ra 
			
		if($_SESSION['voucher_shop'][$value_transporters['store_id']]['voucherid']){
			$check_voucher = check_voucher_order($value_transporters['store_id'], $_SESSION['voucher_shop'][$value_transporters['store_id']]['voucherid']);
			if($check_voucher){
				$list_transporters[$index]['voucherid'] = $_SESSION['voucher_shop'][$value_transporters['store_id']]['voucherid'];
				$list_transporters[$index]['discount_price'] = $_SESSION['voucher_shop'][$value_transporters['store_id']]['price'];
				}else{
				$error[] = 'Voucher không khả dụng, vui lòng thử lại sau!';
			}
			
			}else{
			$list_transporters[$index]['voucherid'] = 0;
			$list_transporters[$index]['discount_price'] = 0;
		}
		
		// phí ship khách hàng chịu
		$list_transporters[$index]['fee'] = $free_ship;
		if(!$_SESSION['voucher_shop'][$value_transporters['store_id']]['price']){
			$_SESSION['voucher_shop'][$value_transporters['store_id']]['price'] = 0;
		}
		$total_full = $total_full + $free_ship - $_SESSION['voucher_shop'][$value_transporters['store_id']]['price'];
	}
	
	if(!$total_full)
	{
		$error[] = 'Lỗi không xác định';
	}
	//print_r($total_full);die;
	
	if(count($error)==0){
		$info_customer=array(
			'userid' => $userid,
			'order_name' => $order_name,
			'order_email' => $order_email,
			'order_phone' => $order_phone,
			'province_id' => $province_id,
			'district_id' => $district_id,
			'ward_id' => $ward_id,
			'address' => $address,
			'payment_method' => $payment_method,
			'lat' => $lat,
			'lng' => $lng
		);
		// add order
		$data = add_order($list_transporters,$info_customer);
		//unset( $_SESSION[$module_data . '_cart'] );

		// thanh toán vnpay
		if($payment_method == 'vnpay'){
			
			//$data = add_order($list_transporters,$info_customer);
			$list_order = $data['list_order'];
			$list_order_code = $data['list_order_code'];
			$order_full=implode(',',$list_order);
			$list_order_code=implode(',',$list_order_code);
			$vnp_TransactionNo=$order_full;
			$vnp_OrderInfo='Thanh toan giao dich '.$list_order_code.' vao thoi gian '.date('d-m-Y H:i',NV_CURRENTTIME);
			
			
			$vnp_ReturnUrl= nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=payment' , true );
			
			// lấy thông tin ip server
			$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
			
			$check_vnpay = send_vnpay($total_full,$vnp_OrderInfo,$config_setting['website_code_vnpay'],$vnp_TransactionNo,$config_setting['checksum_vnpay'],$vnp_ReturnUrl,$vnp_IpAddr);
			$contents1 = array(
			'status' => 'OK_VNPAY',
			'link' => $check_vnpay
			);
			
			print_r( json_encode($contents1));die;
			die();
		}elseif($payment_method == 'recieve'){
			
			$list_order = $data['list_order'];
			$list_order_code = $data['list_order_code'];
			$info_order = get_info_order($list_order[0]);
			$info_order['payment_method_name'] = $global_payport[$info_order['payment_method']]['paymentname'];
			$list_order=implode(',',$list_order);
			$list_order_code=implode(',',$list_order_code);
			
			xulythanhtoanthanhcong_recieve($list_order, $info_order);
			$contents1 = array(
				'status' => 'OK_RECIEVE',
				'link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=payment&amp;order_code=' , true ).$list_order
				);
				print_r( json_encode($contents1));die;
		}elseif($payment_method == 'momo'){
			require_once(NV_ROOTDIR.'/modules/retails/payment/momo.checkorders.php');
			/* $list_order = $data['list_order'];
			$list_order_code = $data['list_order_code'];
			
			$list_order=implode(',',$list_order);
			$list_order_code=implode(',',$list_order_code);
			unset( $_SESSION[$module_data . '_cart'] );
			
			//xulythanhtoanthanhcong_momo($list_order, $info_order);
			$contents1 = array(
				'status' => 'OK_MOMO',
				'link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=payment&amp;payment_method=recieve&amp;order_code='.$list_order , true )
				);
				print_r( json_encode($contents1));die; */
		}
	}else{
			
		$contents1 = array(
		'status' => 'error',
		'mess' => $error
		);
		print_r( json_encode($contents1));die;
	}
	
}

if ( $mod == 'address_no_login' ) {
	$row['address'] = $nv_Request->get_title('maps_address', 'get', '');
	$row['ward_id'] = $nv_Request->get_int('ward_id', 'get', 0);
	$row['district_id'] = $nv_Request->get_int('district_id', 'get', 0);
	$row['province_id'] = $nv_Request->get_int('province_id', 'get', 0);
	$row['phone'] = $nv_Request->get_title('phone', 'get', '');
	$row['name'] = $nv_Request->get_title('name', 'get', '');
	$row['email'] = $nv_Request->get_title('email', 'get', '');

	if(!$row['address']){
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Bạn chưa nhập địa chỉ!')));die();
	}
	else if (!$row['ward_id']){
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Bạn chưa nhập địa chỉ!')));die();
	}
	else if (!$row['district_id']){
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Bạn chưa nhập địa chỉ!')));die();
	}
	else if (!$row['province_id']){
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Bạn chưa nhập địa chỉ!')));die();
	}
	else if (!$row['phone']){
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Bạn chưa nhập số điện thoại!')));die();
	}
	else if (!$row['name']){
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Bạn chưa nhập tên!')));die();
	}
	else if (!$row['email']){
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Bạn chưa nhập email!')));die();
	}

	function email_validation($str) {
		return (!preg_match(
	"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) ? FALSE : TRUE;
	}
	if(!email_validation($row['email'])) {
		print_r( json_encode(array('status'=>'ERROR','mess'=>'Email không đúng định dạng!')));die();
	}


	$_SESSION['address_no_login'] = array(
		'address' => $row['address'],
		'ward_id' => $row['ward_id'],
		'district_id' => $row['district_id'],
		'province_id' => $row['province_id'],
		'phone' => $row['phone'],
		'name' => $row['name'],
		'email' => $row['email'],
	);
		
	print_r( json_encode(array('status'=>'OK','mess'=>'Lưu địa chỉ thành công','link'=> nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=order',true))));
	die();
}

if ( $mod == 'remove_cart' ) {
	$key_store = $nv_Request->get_int( 'key_store', 'get,post', 0 );
	$key_product = $nv_Request->get_int( 'key_product', 'get,post', 0 );
	$key_warehouse = $nv_Request->get_int( 'key_warehouse', 'get,post', 0 );
	unset( $_SESSION[$module_data . '_cart'][$key_store][$key_warehouse][$key_product] );
	if ( count( $_SESSION[$module_data . '_cart'][$key_store][$key_warehouse] ) == 0 ) {
		unset( $_SESSION[$module_data . '_cart'][$key_store][$key_warehouse] );
	}
	if ( count( $_SESSION[$module_data . '_cart'][$key_store] ) == 0 ) {
		unset( $_SESSION[$module_data . '_cart'][$key_store] );
	}
	print_r( json_encode( array('status'=>'OK','mess'=>'Xóa sản phẩm thành công' ) ));
	die();
}
if ( $mod == 'update_cart' ) {
	$key_store = $nv_Request->get_int( 'key_store', 'get,post', 0 );
	$key_product = $nv_Request->get_int( 'key_product', 'get,post', 0 );
	$quantity = $nv_Request->get_int( 'quantity', 'get,post', 0 );
	$key_warehouse = $nv_Request->get_int( 'key_warehouse', 'get,post', 0 );
	
	$classify_value_product_id = $_SESSION[$module_data . '_cart'][$key_store][$key_warehouse][$key_product]['classify_value_product_id'];
	
	$product_id = $_SESSION[$module_data . '_cart'][$key_store][$key_warehouse][$key_product]['product_id'];
	
	// lấy số lượng tồn kho của thuộc tính sản phẩm
	$sl_tonkho = get_info_invetory_group($product_id, $classify_value_product_id)['sl_tonkho'];
	
	if($quantity < 0)
	$quantity = 1;
	
	
	if($quantity > $sl_tonkho)
	{
		$quantity = $sl_tonkho;
	}
	
	
	$_SESSION[$module_data . '_cart'][$key_store][$key_warehouse][$key_product]['num'] = $quantity;
	print_r( json_encode( array( 'STATUS'=>'OK' ) ) );
	die();
}
if ( $mod == 'update_status_check' ) {
	$key_store = $nv_Request->get_int( 'key_store', 'get,post', 0 );
	$key_product = $nv_Request->get_int( 'key_product', 'get,post', 0 );
	$key_warehouse = $nv_Request->get_int( 'key_warehouse', 'get,post', 0 );
	$status_check = $nv_Request->get_int( 'status_check', 'get,post', 0 );
	$_SESSION[$module_data . '_cart'][$key_store][$key_warehouse][$key_product]['status_check'] = $status_check;
	
	print_r( json_encode( array( 'STATUS'=>'OK' ) ) );
	die();
}

if ( $mod == 'add_cart' ) {
		
	$product_id = $nv_Request->get_int( 'product_id', 'get,post', 0 );
	$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'get,post', 0 );
	
	if(!$product_id or !$warehouse_id)
	{
		print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Sản phẩm không tồn tại" ) ) );
		die();
	}
	
	$get_info_product = get_info_product($product_id);
	
	
	if (!defined('NV_IS_USER')) {
		
		// lấy thông tin link chi tiết sản phẩm lưu vào SESSION
		
		// $_SESSION['back_link'] = $get_info_product['link'];
		
		//print_r( json_encode( array( 'status'=>'ERROR_LOGIN','link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login',true) ) ) );
		// die();
		// $check_seller=$db->query('SELECT count(*) FROM '.TABLE.'_seller_management where userid='.$user_info['userid'])->fetchColumn();
		if($check_seller>0){
			print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Bạn đã là người bán nên không thể mua hàng. Vui lòng tạo lại tài khoản người mua" ) ) );
			die();
			}else{
			
			$classify_id_value1 = $nv_Request->get_int( 'classify_id_value1', 'get,post', 0 );
			$classify_id_value2 = $nv_Request->get_int( 'classify_id_value2', 'get,post', 0 );
			
			
			// lấy thông tin sản phẩm giá, giá niêm yết, sl tồn kho
			$info_product = get_price_classify_new($product_id,$warehouse_id,$classify_id_value1,$classify_id_value2);
			
			if(!$info_product)
			{
				print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Sản phẩm không tồn tại" ) ) );
				die();
			}
			
			// id thuộc tính chung
			$classify_value_product_id = $info_product['id'];
			if(!$classify_value_product_id)
			$classify_value_product_id = 0;
			
			// tính giá tiền
			$price = $info_product['price'];
			
			
			$quantity = $nv_Request->get_int( 'quantity', 'get,post', 0 );
			if($quantity <= 0)
			{
				print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Số lượng phải lớn hơn 0" ) ) );
				die();
			}
			
			
			// xử lý kiểm tra sản phẩm còn trong kho hay không
			if($quantity > $info_product['sl_tonkho'])
			{
				print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Số lượng trong kho không đủ" ) ) );
				die();
			}
			
			// kiem tra so luong ton kho
			// chua xu ly
			$exist = false;
			
			if(isset($_SESSION[$module_data . '_cart'][$get_info_product['store_id']][$warehouse_id]))
			{
				foreach ( $_SESSION[$module_data . '_cart'] as $key_store => $value_store ) {
					foreach ( $value_store as $key_warehouse => $value_warehouse ) {
						foreach ( $value_warehouse as $key_product => $value ) {
							if ( $value['product_id'] == $product_id && $value['classify_value_product_id'] == $classify_value_product_id ) {
								$value['num'] = $value['num'] + $quantity;
								$_SESSION[$module_data . '_cart'][$key_store][$key_warehouse][$key_product] = $value;
								$exist = true;
								break;
							}
						}
					}
				}
				
				
			}
			
			if(!$exist)
			{
				$_SESSION[$module_data . '_cart'][$get_info_product['store_id']][$warehouse_id][] = array(
				'product_id' => $product_id,
				'num' => $quantity,
				'price' => $price,
				'classify_value_product_id' => $classify_value_product_id,
				'weight_product' => $get_info_product['weight_product'],
				'weight_unit' => $get_info_product['unit_weight'],
				'length_product' => $get_info_product['length_product'],
				'unit_length' => $get_info_product['unit_length'],
				'width_product' => $get_info_product['width_product'],
				'unit_width' => $get_info_product['unit_width'],
				'height_product' => $get_info_product['height_product'],
				'unit_height' => $get_info_product['unit_height'],
				'name_product' => $get_info_product['name_product'],
				'alias' => $get_info_product['alias'],
				'image' => $get_info_product['image'],
				'free_ship' => $get_info_product['free_ship'],
				'self_transport' => $get_info_product['self_transport'],
				'status_check'=>1
				);
			}
			
			print_r( json_encode( array('status'=>'OK','mess'=>'Thêm sản phẩm vào giỏ hàng thành công' ) ));
			die();
		}
		
		}else{
		$check_seller=$db->query('SELECT count(*) FROM '.TABLE.'_seller_management where userid='.$user_info['userid'])->fetchColumn();
		if($check_seller>0){
			print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Bạn đã là người bán nên không thể mua hàng. Vui lòng tạo lại tài khoản người mua" ) ) );
			die();
			}else{
			
			$classify_id_value1 = $nv_Request->get_int( 'classify_id_value1', 'get,post', 0 );
			$classify_id_value2 = $nv_Request->get_int( 'classify_id_value2', 'get,post', 0 );
			
			
			// lấy thông tin sản phẩm giá, giá niêm yết, sl tồn kho
			$info_product = get_price_classify_new($product_id,$warehouse_id,$classify_id_value1,$classify_id_value2);
			
			if(!$info_product)
			{
				print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Sản phẩm không tồn tại" ) ) );
				die();
			}
			
			// id thuộc tính chung
			$classify_value_product_id = $info_product['id'];
			if(!$classify_value_product_id)
			$classify_value_product_id = 0;
			
			// tính giá tiền
			$price = $info_product['price'];
			
			
			$quantity = $nv_Request->get_int( 'quantity', 'get,post', 0 );
			if($quantity <= 0)
			{
				print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Số lượng phải lớn hơn 0" ) ) );
				die();
			}
			
			
			// xử lý kiểm tra sản phẩm còn trong kho hay không
			if($quantity > $info_product['sl_tonkho'])
			{
				print_r( json_encode( array( 'status'=>'ERROR_SELLER','mess' => "Số lượng trong kho không đủ" ) ) );
				die();
			}
			
			// kiem tra so luong ton kho
			// chua xu ly
			$exist = false;
			
			if(isset($_SESSION[$module_data . '_cart'][$get_info_product['store_id']][$warehouse_id]))
			{
				foreach ( $_SESSION[$module_data . '_cart'] as $key_store => $value_store ) {
					foreach ( $value_store as $key_warehouse => $value_warehouse ) {
						foreach ( $value_warehouse as $key_product => $value ) {
							if ( $value['product_id'] == $product_id && $value['classify_value_product_id'] == $classify_value_product_id ) {
								$value['num'] = $value['num'] + $quantity;
								$_SESSION[$module_data . '_cart'][$key_store][$key_warehouse][$key_product] = $value;
								$exist = true;
								break;
							}
						}
					}
				}
				
				
			}
			
			if(!$exist)
			{
				$_SESSION[$module_data . '_cart'][$get_info_product['store_id']][$warehouse_id][] = array(
				'product_id' => $product_id,
				'num' => $quantity,
				'price' => $price,
				'classify_value_product_id' => $classify_value_product_id,
				'weight_product' => $get_info_product['weight_product'],
				'weight_unit' => $get_info_product['unit_weight'],
				'length_product' => $get_info_product['length_product'],
				'unit_length' => $get_info_product['unit_length'],
				'width_product' => $get_info_product['width_product'],
				'unit_width' => $get_info_product['unit_width'],
				'height_product' => $get_info_product['height_product'],
				'unit_height' => $get_info_product['unit_height'],
				'name_product' => $get_info_product['name_product'],
				'alias' => $get_info_product['alias'],
				'image' => $get_info_product['image'],
				'free_ship' => $get_info_product['free_ship'],
				'self_transport' => $get_info_product['self_transport'],
				'status_check'=>1
				);
			}
			
			print_r( json_encode( array('status'=>'OK','mess'=>'Thêm sản phẩm vào giỏ hàng thành công' ) ));
			die();
		}
	}
}


if ( $mod == 'load_selling_product' ) {
	$categories_id = $nv_Request->get_string( 'catid', 'get,post', 0 );
	$cat_info = get_info_category( $categories_id );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_selling_product&catid='.$categories_id;
	$per_page = $cat_info['numlinks'];
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product t1' )
	->join( 'INNER JOIN ' . TABLE . '_categories t2 ON t2.id=t1.categories_id' )
	->where( '(t2.id='.$categories_id.' OR t2.parrent_id='.$categories_id.') and t1.inhome=1 and t1.status=1' );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( 't1.*' )
	->order( 't1.number_order DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$contents = nv_theme_retailshops_viewcat_ajax_main( $sth, $per_page, $page, $num_items, $cat_info, $base_url );
	echo nv_site_theme( $contents, false );
	die;
}
if ( $mod == 'load_selling_product_shops' ) {
	$categories_id = $nv_Request->get_string( 'catid', 'get,post', 0 );
	$store_id = $nv_Request->get_string( 'store_id', 'get,post', 0 );
	$cat_info = get_info_category( $categories_id );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_selling_product_shops&catid='.$categories_id.'&store_id='.$store_id;
	$per_page = $cat_info['numlinks'];
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product t1' )
	->join( 'INNER JOIN ' . TABLE . '_categories t2 ON t2.id=t1.categories_id' )
	->where( '(t2.id='.$categories_id.' OR t2.parrent_id='.$categories_id.') and t1.inhome=1 and t1.store_id='.$store_id.' and t1.status=1' );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( 't1.*' )
	->order( 't1.number_order DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$contents = nv_theme_retailshops_viewcat_ajax_main_shop( $sth, $per_page, $page, $num_items, $cat_info, $base_url );
	echo nv_site_theme( $contents, false );
	die;
}

if ( $mod == 'load_new_product' ) {
	$categories_id = $nv_Request->get_string( 'catid', 'get,post', 0 );
	$cat_info = get_info_category( $categories_id );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_new_product&catid='.$categories_id;
	$per_page = $cat_info['numlinks'];
	
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product t1' )
	->join( 'INNER JOIN ' . TABLE . '_categories t2 ON t2.id=t1.categories_id' )
	->where( '(t2.id='.$categories_id.' OR t2.parrent_id='.$categories_id.') and t1.inhome=1 and t1.status=1' );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( 't1.*' )
	->order( 't1.time_add DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$contents = nv_theme_retailshops_viewcat_ajax_main( $sth, $per_page, $page, $num_items, $cat_info, $base_url );
	echo nv_site_theme( $contents, false );
	die;
}
if ( $mod == 'load_new_product_shops' ) {
	$categories_id = $nv_Request->get_string( 'catid', 'get,post', 0 );
	$store_id = $nv_Request->get_string( 'store_id', 'get,post', 0 );
	$cat_info = get_info_category( $categories_id );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_new_product_shops&catid='.$categories_id.'&store_id='.$store_id;
	$per_page = $cat_info['numlinks'];
	
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product t1' )
	->join( 'INNER JOIN ' . TABLE . '_categories t2 ON t2.id=t1.categories_id' )
	->where( '(t2.id='.$categories_id.' OR t2.parrent_id='.$categories_id.') and t1.store_id='.$store_id.' and t1.inhome=1 and t1.status=1' );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( 't1.*' )
	->order( 't1.time_add DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$contents = nv_theme_retailshops_viewcat_ajax_main_shop( $sth, $per_page, $page, $num_items, $cat_info, $base_url );
	echo nv_site_theme( $contents, false );
	die;
}
if ( $mod == 'load_price_product' ) {
	$categories_id = $nv_Request->get_string( 'catid', 'get,post', 0 );
	$cat_info = get_info_category( $categories_id );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_price_product&catid='.$categories_id;
	$per_page = $cat_info['numlinks'];
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product t1' )
	->join( 'INNER JOIN ' . TABLE . '_categories t2 ON t2.id=t1.categories_id' )
	->where( '(t2.id='.$categories_id.' OR t2.parrent_id='.$categories_id.') and t1.inhome=1 and t1.status=1' );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( 't1.*' )
	->order( 't1.price_min ASC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$contents = nv_theme_retailshops_viewcat_ajax_main( $sth, $per_page, $page, $num_items, $cat_info, $base_url );
	echo nv_site_theme( $contents, false );
	die;
}
if ( $mod == 'load_price_product_shops' ) {
	$categories_id = $nv_Request->get_string( 'catid', 'get,post', 0 );
	$store_id = $nv_Request->get_string( 'store_id', 'get,post', 0 );
	$cat_info = get_info_category( $categories_id );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_price_product_shops&catid='.$categories_id.'&store_id='.$store_id;
	$per_page = $cat_info['numlinks'];
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product t1' )
	->join( 'INNER JOIN ' . TABLE . '_categories t2 ON t2.id=t1.categories_id' )
	->where( '(t2.id='.$categories_id.' OR t2.parrent_id='.$categories_id.') and t1.store_id='.$store_id.' and t1.inhome=1 and t1.status=1' );
	
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( 't1.*' )
	->order( 't1.price_min ASC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$contents = nv_theme_retailshops_viewcat_ajax_main_shop( $sth, $per_page, $page, $num_items, $cat_info, $base_url );
	echo nv_site_theme( $contents, false );
	die;
}
if ( $mod == 'load_product_category_viewcat' ) {
	$catid = $nv_Request->get_string( 'category_id', 'get,post', '' );
	$cat_info = get_info_category( $catid );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ajax&mod=load_product_category_viewcat&category_id='.$catid;
	$per_page = $cat_info['numlinks'];
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	
	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product' )
	->where( 'categories_id='.$catid.' and status=1 and id IN (SELECT product_id FROM '.TABLE.'_inventory_product where amount>0 )' );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( '*' )
	->order( 'weight DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );
	
	$sth->execute();
	$contents = nv_theme_retailshops_viewcat_ajax_type_product( $sth, $per_page, $page, $num_items, $cat_info, $base_url );
	echo nv_site_theme( $contents, false );
	die;
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
if ( $mod == 'get_transport_fee_viettelpost' ) {
	$weight_product = $nv_Request->get_int( 'weight', 'get,post', 0 );
	$length_product = $nv_Request->get_int( 'length', 'get,post', 0 );
	$width_product = $nv_Request->get_int( 'width', 'get,post', 0 );
	$height_product = $nv_Request->get_int( 'height', 'get,post', 0 );
	$total = $nv_Request->get_int( 'total', 'get,post', 0 );
	$province_id = $nv_Request->get_int( 'province_id', 'get,post', 0 );
	$province_id_viettelpost_receive = get_info_province( $province_id )['vtpid'];
	$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	$district_id_viettelpost_receive = get_info_district( $district_id )['vtpid'];
	$warehouse_id = $nv_Request->get_int( 'shops_id', 'get,post', 0 );
	$info_warehouse = get_info_warehouse( $warehouse_id );
	$province_id_viettelpost_send = get_info_province( $info_warehouse['province_id'] )['vtpid'];
	$district_id_viettelpost_send = get_info_district( $info_warehouse['district_id'] )['vtpid'];
	$transporters_id = $nv_Request->get_int( 'transporters_id', 'get,post', 0 );
	$code_transporters = get_info_transporters( $transporters_id )['code_transporters'];
	$fee = get_price_viettelpost( $total, $total, $code_transporters, $province_id_viettelpost_send, $district_id_viettelpost_send, $province_id_viettelpost_receive, $district_id_viettelpost_receive, 'HH', 1, $weight_product, $width_product, $height_product, $length_product );
	if ( $fee['error'] == 1 ) {
		$tranposter_fee = -1;
		} else {
		if ( get_info_transporters( $transporters_id )['type'] == 0 ) {
			$tranposter_fee = $fee['data']['MONEY_TOTAL']+get_info_transporters( $transporters_id )['money'];
			} else {
			$tranposter_fee = $fee['data']['MONEY_TOTAL']-get_info_transporters( $transporters_id )['money'];
			if ( $tranposter_fee<0 ) {
				$tranposter_fee = 0;
			}
		}
	}
	print_r( json_encode( $tranposter_fee ) );
	die;
}

if ( $mod == 'get_transport_fee_ghn' ) {
	$weight_product = $nv_Request->get_int( 'weight', 'get,post', 0 );
	$length_product = $nv_Request->get_int( 'length', 'get,post', 0 );
	$width_product = $nv_Request->get_int( 'width', 'get,post', 0 );
	$height_product = $nv_Request->get_int( 'height', 'get,post', 0 );
	$total = $nv_Request->get_int( 'total', 'get,post', 0 );
	$ward_id = $nv_Request->get_int( 'ward_id', 'get,post', 0 );
	$ward_id_ghn_receive = get_info_ward( $ward_id )['ghnid'];
	$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	$district_id_ghn_receive = get_info_district( $district_id )['ghnid'];
	$shops_id_session = $nv_Request->get_int( 'shops_id', 'get,post', 0 );
	$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'get,post', 0 );
	$info_warehouse = get_info_warehouse( $warehouse_id );
	$province_id_ghn_send = get_info_province( $info_warehouse['province_id'] )['ghnid'];
	$district_id_ghn_send = get_info_district( $info_warehouse['district_id'] )['ghnid'];
	$transporters_id = $nv_Request->get_int( 'transporters_id', 'get,post', 0 );
	$code_transporters = get_info_transporters( $transporters_id )['code_transporters'];
	$shop_id = $info_warehouse['shops_id_ghn'];

	$service = get_service_ghn($shop_id,$district_id_ghn_send,$district_id_ghn_receive);
	
	$service['code_message_value'];
	
	if($weight_product == 0 and $length_product == 0 and $width_product == 0 and $height_product == 0  ){
		$_SESSION['tranposter_fee'][$shops_id_session][3] = 0;
		print_r( json_encode( array('fee'=>0, 'mess'=>$service['code_message_value']) ) );
		die;
	}
	
	foreach($service['data'] as $data ){
		if($data['service_type_id']==$code_transporters){
			$service_id=$data['service_id'];
		}
	}
	
	
	$fee = get_price_ghn( $service_id, $shop_id, $district_id_ghn_receive, $ward_id_ghn_receive, $height_product, $length_product, $weight_product, $width_product, 0,$district_id_ghn_send );
	
	
	
	if($fee['code']==400){
		$fee = get_price_ghn_2( $code_transporters, $shop_id, $district_id_ghn_receive, $ward_id_ghn_receive, $height_product, $length_product, $weight_product, $width_product, 0,$district_id_ghn_send );
	}
	
	if($fee['code']==400 ) {
		$tranposter_fee = -1;
		} else {
		if ( get_info_transporters( $transporters_id )['type'] == 0 ) {
			$tranposter_fee = $fee['data']['total']+get_info_transporters( $transporters_id )['money'];
			} else {
			$tranposter_fee = $fee['data']['total']-get_info_transporters( $transporters_id )['money'];
			if ( $tranposter_fee<0 ) {
				$tranposter_fee = 0;
			}
		}
		$mod = $tranposter_fee%1000;
		if($mod>0){
			$thuong = ceil($tranposter_fee / 1000);
			$tranposter_fee=$thuong*1000;
		}
	}
	//print_r( json_encode( $tranposter_fee ) );
	$_SESSION['tranposter_fee'][$shops_id_session][3] = $tranposter_fee;
	
	print_r( json_encode( array('fee'=>$tranposter_fee, 'mess'=>$service['code_message_value']) ) );
	die;
	
	
}
if ( $mod == 'get_transport_fee_ghtk' ) {
	$weight_product = $nv_Request->get_int( 'weight', 'get,post', 0 );
	$province_id = $nv_Request->get_int( 'province_id', 'get,post', 0 );
	$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	$ward_id = $nv_Request->get_int( 'ward_id', 'get,post', 0 );
	$address = $nv_Request->get_string( 'address', 'get,post', 0 );
	$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'get,post', 0 );
	$info_warehouse = get_info_warehouse( $warehouse_id );
	if($weight_product == 0  ){
		$_SESSION['tranposter_fee'][$shops_id_session][2] = 0;
		print_r( json_encode( 0 ) );
		die;
	}
	//format thông tin
	$pick_province = $global_province[$info_warehouse['province_id']]['title'];
	$pick_district = $global_district[$info_warehouse['district_id']]['title'];
	$address_shop = explode(',', $info_warehouse['address']);
	$pick_address = $address_shop[0];
	//nhận
	$province = $global_province[$province_id]['title'];
	$district = $global_district[$district_id]['title'];
	$address = explode(',', $address);
	$address = $address[0];
	
	$fee = get_price_ghtk($pick_address, $pick_province, $pick_district, $province, $district, $address, $weight_product,'road','none');
	
	if ($fee['fee']['delivery']) {
		$tranposter_fee = $fee['fee']['fee'];
		// cộng thêm phí vận chuyển hệ thống sàn thương mại
		$tranposter_fee = $tranposter_fee + (($tranposter_fee * $config_setting['percent_of_ship'])/100);
		$tranposter_fee = rounding($tranposter_fee);
		$_SESSION['tranposter_fee'][$shops_id_session][2] = $tranposter_fee;
		} else {
			$tranposter_fee = -1;
	}
	print_r( json_encode( $tranposter_fee ) );
	die;
}
if ( $mod == 'get_transport_fee_ahamove_order' ) {
	$weight_product = $nv_Request->get_int( 'weight', 'get,post', 0 );
	$length_product = $nv_Request->get_int( 'length', 'get,post', 0 );
	$width_product = $nv_Request->get_int( 'width', 'get,post', 0 );
	$height_product = $nv_Request->get_int( 'height', 'get,post', 0 );
	$total = $nv_Request->get_int( 'total', 'get,post', 0 );
	$province_id = $nv_Request->get_int( 'province_id', 'get,post', 0 );
	$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	$ward_id = $nv_Request->get_int( 'ward_id', 'get,post', 0 );
	$address = $nv_Request->get_string( 'address', 'get,post', '' );
	$lat = $nv_Request->get_title( 'lat', 'get,post', 0 );
	$lng = $nv_Request->get_title( 'lng', 'get,post', 0 );
	$address_receive = $address;
	$token_list = get_token_ahamove();
	$token=$token_list['token'];
	$warehouse_id = $nv_Request->get_int( 'shops_id', 'get,post', 0 );
	$info_warehouse = get_info_warehouse( $warehouse_id );
	$lat_send = $info_warehouse['lat'];
	$lng_send = $info_warehouse['lng'];
	
	$address_send = $info_warehouse['address'];
	$name_send = $info_warehouse['name_send'];
	$transporters_id = $nv_Request->get_int( 'transporters_id', 'get,post', 0 );
	$code_transporters = get_info_transporters( $transporters_id )['code_transporters'];
	
	
	$arr['token'] = $token;
	$arr['lat_send'] = $lat_send;
	$arr['lng_send'] = $lng_send;
	$arr['address_send'] = $address_send;
	$arr['warehouse_id'] = $warehouse_id;
	$arr['info_warehouse'] = $info_warehouse;
	$arr['name_send'] = $name_send;
	$arr['lat'] = $lat;
	$arr['lng'] = $lng;
	$arr['address_receive'] = $address_receive;
	$fee = get_price_ahamove( $token, $lat_send, $lng_send, $address_send, $address_send, $name_send, $lat, $lng, $address_receive, '', $code_transporters );
	if ( empty( $fee['total_price'] ) ) {
		$tranposter_fee = -1;
		$mess = $fee['description'];
		} else {
		if ( get_info_transporters( $transporters_id )['type'] == 0 ) {
			$tranposter_fee = $fee['total_price']+get_info_transporters( $transporters_id )['money'];
			} else {
			$tranposter_fee = $fee['total_price']-get_info_transporters( $transporters_id )['money'];
			if ( $tranposter_fee<0 ) {
				$tranposter_fee = 0;
			}
		}
		$mod = $tranposter_fee%1000;
		if($mod>0){
			$thuong = ceil($tranposter_fee / 1000);
			$tranposter_fee=$thuong*1000;
		}
		$mess='';
	}
	
	print_r( json_encode( array('fee'=>$tranposter_fee,'mess'=>$mess) ) );
	die;
}
if ( $mod == 'get_transport_fee_ahamove' ) {
	$weight_product = $nv_Request->get_int( 'weight', 'get,post', 0 );
	$length_product = $nv_Request->get_int( 'length', 'get,post', 0 );
	$width_product = $nv_Request->get_int( 'width', 'get,post', 0 );
	$height_product = $nv_Request->get_int( 'height', 'get,post', 0 );
	$total = $nv_Request->get_int( 'total', 'get,post', 0 );
	$province_id = $nv_Request->get_int( 'province_id', 'get,post', 0 );
	$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	$ward_id = $nv_Request->get_int( 'ward_id', 'get,post', 0 );
	$address = $nv_Request->get_int( 'address', 'get,post', 0 );
	$token = $nv_Request->get_title( 'token_ahamove', 'get,post', '' );
	if ( $ward_id>0 ) {
		$lat_receive = get_info_ward( $ward_id )['lat'];
		$lng_receive = get_info_ward( $ward_id )['lng'];
		$address_receive = $address.', '.get_info_ward( $ward_id )['type'].' '.get_info_ward( $ward_id )['title'].', '.get_info_district( $district_id )['type'].' '.get_info_district( $district_id )['title'].', '.get_info_province( $province_id )['type'].' '.get_info_province( $province_id )['title'];
		} else {
		$lat_receive = get_info_district( $district_id )['lat'];
		$lng_receive = get_info_district( $district_id )['lng'];
		$address_receive = $address.', '.get_info_district( $district_id )['title'].', '.get_info_province( $province_id )['type'].' '.get_info_province( $province_id )['title'];
	}
	$warehouse_id = $nv_Request->get_int( 'shops_id', 'get,post', 0 );
	$info_warehouse = get_info_warehouse( $warehouse_id );
	$lat_send = $info_warehouse['lat'];
	$lng_send = $info_warehouse['lng'];
	$address_send = $info_warehouse['address'].','. get_info_ward( $info_warehouse['ward_id'] )['type'].' '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['type'].' '.get_info_province( $info_warehouse['province_id'] )['title'];
	$name_send = $info_warehouse['name_send'];
	$transporters_id = $nv_Request->get_int( 'transporters_id', 'get,post', 0 );
	$code_transporters = get_info_transporters( $transporters_id )['code_transporters'];
	$fee = get_price_ahamove( $token, $lat_send, $lng_send, $address_send, $address_send, $name_send, $lat_receive, $lng_receive, $address_receive, '', $code_transporters );
	
	if ( empty( $fee['total_pay'] ) ) {
		$tranposter_fee = -1;
		} else {
		if ( get_info_transporters( $transporters_id )['type'] == 0 ) {
			$tranposter_fee = $fee['total_pay']+get_info_transporters( $transporters_id )['money'];
			} else {
			$tranposter_fee = $fee['total_pay']-get_info_transporters( $transporters_id )['money'];
			if ( $tranposter_fee<0 ) {
				$tranposter_fee = 0;
			}
		}
	}
	print_r( json_encode( $tranposter_fee ) );
	die;
}


if ( $mod == 'get_transport_fee_vnpost' ) {
	$weight_product = $nv_Request->get_string( 'weight', 'get,post', 0 );
	$length_product = $nv_Request->get_string( 'length', 'get,post', 0 );
	$width_product = $nv_Request->get_string( 'width', 'get,post', 0 );
	$height_product = $nv_Request->get_string( 'height', 'get,post', 0 );
	$total = $nv_Request->get_int( 'total', 'get,post', 0 );
	
	
	
	$province_id = $nv_Request->get_int( 'province_id', 'get,post', 0 );
	
	
	$district_id = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	
	$warehouse_id = $nv_Request->get_int( 'shops_id', 'get,post', 0 );
	
	
	$info_warehouse = get_info_warehouse( $warehouse_id );
	
	
	$transporters_id = $nv_Request->get_int( 'transporters_id', 'get,post', 0 );
	
	
	// kiểm tra dữ liệu thỏa điều kiện
	if(!$weight_product and !$length_product and !$width_product and !$height_product)
	{
		print(0);die;
	}
	
	// tỉnh thành quận huyện nhận, gửi không có.
	if(!$province_id or !$district_id or !$info_warehouse['province_id'] or !$info_warehouse['district_id'])
	{
		print(0);die;
	}	
	
	
	$province_id_vnpost_receive = get_info_province( $province_id )['vnpostid'];
	$district_id_vnpost_receive = get_info_district( $district_id )['vnpostid'];
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
	
	//print_r($fee);die; 
	
	if ( empty( $fee ) ) {
		$tranposter_fee = -1;
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
	}
	print_r( json_encode( $tranposter_fee ) );
	die;
}
if ( $mod == 'tonkho' ) {
	$product_id = $nv_Request->get_int( 'product_id', 'get,post', 0 );
	$warehouse_id = $nv_Request->get_int( 'warehouse_id', 'get,post', 0 );
	$classify_id_value1 = $nv_Request->get_int( 'classify_id_value1', 'get,post', 0 );
	$classify_id_value2 = $nv_Request->get_int( 'classify_id_value2', 'get,post', 0 );
	if($classify_id_value1==0){
		$info_product=array();
		}else{
		$info_product=get_info_classify_value_product_classify_id_value1_classify_id_value2($classify_id_value1,$classify_id_value2);
	}
	$store_id = get_info_product( $product_id )['store_id'];
	if(count($info_product)>0){
		if(get_info_classify_value_product_classify_id_value1_classify_id_value2($classify_id_value1,$classify_id_value2)['status']==1){
			
			$number_product = get_info_invetory_group( $product_id, $warehouse_id, $info_product['id'])['amount'];
			}else{
			$number_product = -1;
		}
		}else{
		$number_product=get_info_invetory_no($product_id,$warehouse_id)[0]['amount'];
	}
	if ( !empty( $_SESSION[$module_name . '_cart'][$store_id][$warehouse_id] ) ) {
		foreach ( $_SESSION[$module_name . '_cart'][$store_id][$warehouse_id] as $value_session_cart ) {
			if ( $value_session_cart['product_id'] == $product_id && $value_session_cart['classify_value_product_id'] == $info_product['id'] ) {
				$number_product = $number_product - $value_session_cart['num'];
			}
		}
		
	}
	if ( empty( $number_product ) ) {
		$number_product = 0;
	}
	
	print_r(
	json_encode(
	array(
	'status'=>'OK',
	'name_warehouse'=>get_info_warehouse( $warehouse_id )['name_warehouse'],
	'number_product'=>$number_product
	)
	)
	);
	die();
	
}
	


// khu vực dưới là test

if($mod == 'testtt')
{
	$a =Array
	(
		'success' => '1',
		'message' => 'Các đơn hàng đã được add vào hệ thống GHTK thành công. Thông tin đơn hàng thành công được trả về trong trường success_orders.',
		'order' => Array
			(
				'partner_id' => 'ECNG0000643 - 09:19 27/01/2022',
				'label' => 'S20966001.SG30.M2.300071869',
				'area' => '2',
				'fee' => '27000',
				'insurance_fee' => '5000',
				'estimated_pick_time' => 'Sáng 2022-01-27',
				'estimated_deliver_time' => 'Chiều 2022-01-27',
				'products' => Array
					(
					),
	
				'status_id' => '2',
				'tracking_id' => '300071869',
				'sorting_code' => 'SG30.M2',
				'is_xfast' => '0',
				),
	
		'warning_message' => 'Việc vận chuyển hiện tại đang gặp khó khăn do tình hình dịch bệnh phức tạp, vì vậy thời gian giao hàng tới khách sẽ chậm hơn dự kiến.
	Mong Shop thông cảm và cân nhắc kỹ trước khi gửi hàng. GHTK xin lỗi vì sự bất tiện này.'
			);
	print_r($a['order']['label']);die;
	
}

die();