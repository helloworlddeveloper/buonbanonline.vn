<?php

$mod = $nv_Request->get_title( 'mod', 'get', '' );

if ( $mod == 'complain' ) {
	$id_order = $nv_Request->get_int('id_order', 'post', 0);
	$product_id = $nv_Request->get_int('product_id', 'post', 0);
	$id = $nv_Request->get_int('id_complain', 'post', 0);
	$text = $nv_Request->get_title('content_feedback_'.$id, 'post', '');
	$userid_complain = $nv_Request->get_title('userid_complain', 'post', '');
	
	$info_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id = ' . $id_order)->fetch();
	$db->query('UPDATE ' . TABLE . '_complain SET status = 2 WHERE id = ' . $id);
	$db->query("INSERT INTO " . TABLE . "_feedback (id_complain, content, time_add, user_id)
	VALUES ( 
	" . intval($id) . ",
	'" . $text . "',
	" . NV_CURRENTTIME . ",
	" . $admin_info['userid'] . ")");
	$content_ip= $admin_info['username'] . ' đã phản hồi khiếu nại đơn hàng vào lúc ' . date('d/m/y H:i',NV_CURRENTTIME) . '(' . $info_order['order_code'] . ')';
	
	$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_user(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type,order_id) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$admin_info['userid'].',' . $userid_complain .','.$db->quote($content_ip).','.NV_CURRENTTIME.',' . $info_order['store_id'] . ',"complain", ' . $id_order . ')');
	$json[] = ['status'=>'OK', 'text'=>'Thêm khiếu nại thành công!'];
	print_r( json_encode( $json[0] ) );
	die();
	
}


$id = $nv_Request->get_title( 'id', 'post,get' );

$info_order = get_info_order( $id );

$store_id = $info_order['store_id'];
$warehouse_id = $info_order['warehouse_id'];

//print_r($info_order);die;
$info_store = get_info_store( $store_id );
$info_warehouse = get_info_warehouse( $warehouse_id );
$info_warehouse['address'] = $info_warehouse['address'];

if($info_order['payment_method']==0){
	$info_order['payment_method']='Thanh toán khi nhận hàng';
	}else{
	$info_order['payment_method']='Thanh toán qua ví tiền';
}

$info_order['shop_id']=get_info_store($info_order['store_id'])['userid'];
//check voucher
if(!$info_order['status_payment_vnpay']){
	
	$check_voucher = check_voucher_shop($info_order['voucherid'], $info_order['shop_id'], $info_order['userid']);
	
	$arr = json_decode($check_voucher, true);
	
	if($arr['status'] == 'ERROR'){
		$info_order['total'] = $info_order['total'] + $info_order['voucher_price'];
		$info_order['voucher_price'] = 0;
	}
}

if($info_order['transporters_id']){
	$info_order['transporters_name']=get_info_transporters($info_order['transporters_id'])['name_transporters'];
}else{
	$info_order['transporters_name'] = $lang_module['tranposter_tugiao'];
}

$info_order['status']=get_info_order_status($info_order['status'])['name'];
$info_order['total_product']=number_format($info_order['total_product']).'đ';
$info_order['total']=number_format($info_order['total']).'đ';
$info_order['fee_transport']=number_format($info_order['fee_transport']).'đ';
$info_order['voucher_price']=number_format($info_order['voucher_price']).'đ';

$info_order['address'] = $info_order['address'];
$info_order['total_discount']=number_format($db->query('SELECT sum(discount) FROM '.TABLE.'_order_item where order_id='.$info_order['id'])->fetchColumn());
$per_page = 20;
$page = $nv_Request->get_int( 'page', 'post,get', 1 );
$db->sqlreset()
->select( 'COUNT(*)' )
->from( '' . TABLE . '_order_item t1' )
->join( 'INNER JOIN ' . TABLE . '_product t2 ON t1.product_id = t2.id' )
->where( 't1.order_id='.$id );

$sth = $db->prepare( $db->sql() );

$sth->execute();
$num_items = $sth->fetchColumn();

$db->select( 't1.*,t2.name_product,t2.barcode' )
->order( 't1.id DESC' )
->limit( $per_page )
->offset( ( $page - 1 ) * $per_page );
$sth = $db->prepare( $db->sql() );

$sth->execute();
$list_logs_order = $db->query('SELECT * FROM ' . TABLE . '_logs_order where order_id = ' . $id)->fetchAll();
$xtpl = new XTemplate( $op.'.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'info_store', $info_store );
$xtpl->assign( 'info_warehouse', $info_warehouse );
$xtpl->assign( 'info_order', $info_order );
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
if ( !empty( $q ) ) {
	$base_url .= '&q=' . $q;
}
$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
if ( !empty( $generate_page ) ) {
	$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
	$xtpl->parse( 'main.view.generate_page' );
}
$number = $page > 1 ? ( $per_page * ( $page - 1 ) ) + 1 : 1;
while ( $view = $sth->fetch() ) {
	$view['number'] = $number++;
	if($view['classify_value_product_id']>0){
		$classify_value_product_id=get_info_classify_value_product($view['classify_value_product_id']);
		$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
		$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
		if($classify_value_product_id['classify_id_value2']>0){
			$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
			$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
			$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
			}else{
			$name_group=$name_classify_id_value1;
		}
		$view['name_product']=$view['name_product'].'( '.$name_group.' )';
	}
	$view['total']=number_format($view['total']);
	$view['discount']=number_format($view['discount']);
	$view['price']=number_format($view['price']);
	$view['quantity']=number_format($view['quantity']);
	$xtpl->assign( 'VIEW', $view );
	
	$xtpl->parse( 'main.view.loop' );
	
}
$address = get_full_address($info_order['ward_id'], $info_order['district_id'], $info_order['province_id']);	
$address_full = $info_order['address'] . $address;

$xtpl->assign('DIACHI', $address_full);
$stt_logs=1;
foreach($list_logs_order as $value_logs){
	if($value_logs['status_id_old']==-1){
		$value_logs['status_id_old']='';
		}else{
		//$value_logs['status_id_old'] = get_info_order_status($value_logs['status_id_old'])['name'];
	}
	if($value_logs['user_add']>0){
		}if($value_logs['user_add'] == 3){
		$value_logs['user_add']='GHN';
		}else if($value_logs['user_add']== 4){
		$value_logs['user_add']='VNPOST';
	}else{
		$value_logs['user_add'] = get_info_user_fullname($value_logs['user_add']);
	}
	
	$value_logs['time_add']=date('H:i d/m/Y',$value_logs['time_add']);
	$value_logs['number']=$stt_logs++;
	$xtpl->assign( 'LOOP_LOGS', $value_logs );
	$xtpl->parse( 'main.logs_order' );
}


// lấy tất cả thông tin vận chuyển
$list_vnpost = $db->query('SELECT * FROM '. TABLE .'_history_vnpos_detail WHERE order_id ='. $id . ' ORDER BY id DESC')->fetchAll();

$stt = 1;

foreach($list_vnpost as $post)
{
	$post['status_vnpost'] = $global_status_vnpos[$post['status_vnpost']]['name_status_vnpost'];

	
	$post['addtime'] = date('d/m/Y - H:i',$post['addtime']);
	
	$xtpl->assign( 'stt', $stt );
	$stt++;
	$xtpl->assign( 'post', $post );
	$xtpl->parse( 'main.post' );
}
//thông tin vận chuyển GHN
$list_tracuu_ghn = check_info_order_ghn_history($info_order['shipping_code']);
foreach($list_tracuu_ghn as $value){
	$value['status_ghn'] = $global_status_ghn[$value['status']]['desc_status_ghn'];
	
	if($value['reason_code']){
		$value['status_error_ghn'] = $global_status_error_ghn[$value['reason_code']]['desc_status_ghn'];
		$value['status_error_ghn'] = '(' . $value['status_error_ghn'] . ')';
	}
	
	$value['time_add'] = date('d/m/Y - H:i',$value['time_add']);
	$xtpl->assign( 'LOOP_GHN', $value );
	$xtpl->parse( 'main.ghn' );
}


$xtpl->parse( 'main.view' );
$xtpl->parse( 'main.view1' );
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['vieworder'].' '.$info_order['order_code'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';