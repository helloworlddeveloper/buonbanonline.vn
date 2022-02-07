<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2021 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Mon, 04 Jan 2021 09:28:10 GMT
	*/
	
	if (!defined('NV_IS_MOD_RETAILSHOPS'))
	die('Stop!!!');
	$mod = $nv_Request->get_title( 'mod', 'get', '' );
	
	
	//mod đánh giá sản phẩm
	if ( $mod == 'rate' ) {
		
		$arr_product = $nv_Request->get_array('arr_product_ajax', 'post,get', '');
		$arr_classify = $nv_Request->get_array('arr_classify_ajax', 'post,get', '');
		$arr_star = $nv_Request->get_array('arr_star_ajax', 'post,get', '');
		$arr_comment = $nv_Request->get_array('arr_comment_ajax', 'post,get', '');
		
		$id_order = $nv_Request->get_int('id_order_ajax', 'post,get', 0);
		
		/*
			$json[] = ['status'=>'OK1111', 'text'=>$arr_product];
			print_r( json_encode( $json[0] ) );
			die();
		*/
		
		foreach($arr_star as $star)
		{
			if(!$star)
			{
				$json[] = ['status'=>'NO', 'text'=>'Nostar'];
				print_r( json_encode( $json[0] ) );
				die();
			}
		}
		
		foreach($arr_comment as $comment)
		{
			if(!$comment)
			{
				$json[] = ['status'=>'NO', 'text'=>'Nocomment'];
				print_r( json_encode( $json[0] ) );
				die();
			}
		}
		
		
		if(!$id_order)
		{
			$json[] = ['status'=>'NO', 'text'=>'No'];
			print_r( json_encode( $json[0] ) );
			die();
		}
		
		// kiểm tra id_order đã nhập đánh giá chưa
		$check_danhgia = $db->query('SELECT id FROM '. TABLE .'_rate WHERE order_id =' . $id_order)->fetchColumn();
		if($check_danhgia)
		{
			$json[] = ['status'=>'NO', 'text'=>'No'];
			print_r( json_encode( $json[0] ) );
			die();
		}
		
		for($i = 0; $i < count($arr_product); $i++)
		{
			
			$product_id = $arr_product[$i];
			$classify_value_product_id = $arr_classify[$i];
			
			$star = $arr_star[$i];
			$text = $arr_comment[$i];
			
			$info_order = $db->query('SELECT * FROM ' . TABLE . '_order WHERE id = ' . $id_order)->fetch();
			;
			
			
			$sql = "INSERT INTO " . TABLE . "_rate (product_id, classify_value_product_id, content, status, time_add, userid, star, other_image, order_id)
			VALUES ( 
			" . intval($product_id) . ",
			" . intval($classify_value_product_id) . ",
			'" . $text . "',
			1,
			'" . NV_CURRENTTIME . "',
			'" . $user_info['userid'] . "',
			'" . $star . "',
			'" . $rowcontent['list_image'] . "',
			" . intval($id_order) . "
			)";
			$data_insert = [];
			$rowcontent['id'] = $db->insert_id($sql, 'id', $data_insert);
			
			
			$list_rate =  $db->query("SELECT * FROM " .TABLE."_rate WHERE product_id = " . $product_id) -> fetchAll();
			if($list_rate){
				$total_star = 0; 
				foreach ($list_rate as $key => $value) {
					$value['info_user'] = $db->query("SELECT * FROM " .$db_config['prefix']."_users WHERE userid = " . $value['userid']) -> fetch();
					$total_star = $value['star'] + $total_star;
				}
				
				$rate['rate'] = lamtronstar($total_star/(count($list_rate)));
				}else{
				$rate['rate'] = 0;
			}
			
			
			
			$sth = $db->prepare('UPDATE ' . TABLE . '_product SET star = ' . $rate['rate'] . ', number_rate = ' . count($list_rate) . ' WHERE id=' . $product_id);
			$sth->execute();
			
			$content_ip= $user_info['username'] . ' đã đánh giá đơn hàng vào lúc ' . date('d/m/y H:i',NV_CURRENTTIME) . '(' . $info_order['order_code'] . ')';
			$db->query('INSERT INTO '.$db_config['dbsystem']. '.'.$db_config['prefix'].'_notification_shop(language,area,module,admin_view_allowed,logic_mode ,send_from,send_to,content,add_time,obid,type,product_id) VALUES ('.$db->quote(NV_LANG_DATA) .',1,'.$db->quote($module_name).',0,0,'.$user_info['userid'].',' . $info_order['store_id'] .','.$db->quote($content_ip).','.NV_CURRENTTIME.',' . $info_order['store_id'] . ',"rate", ' . $product_id . ')');
			
		}
		
		$json[] = ['status'=>'OK', 'text'=>'Thêm đánh giá thành công!'];
		print_r( json_encode( $json[0] ) );
		die();
		
	}
	
	
	$id = $nv_Request->get_title( 'id', 'post,get' );
	if (!defined('NV_IS_USER')) {
		// echo '<script language="javascript">';
		// echo 'alert("Vui lòng đăng nhập trước để thực hiện chức năng này.");window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login',true).'"';
		// echo '</script>';
		}else{  
		if($id==0){
			echo '<script language="javascript">';
			echo 'alert("Chưa tìm thấy đơn hàng nào");window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=listorder',true).'"';
			echo '</script>';
		}
	}
	
	
	check_store_order_id($id);
	
	$info_order = get_info_order($id);

	
	$info_store = get_info_store( $info_order['store_id'] );
	// print_r(ok);die;
	$info_store['alias_shop'] = NV_MY_DOMAIN .'/'.get_info_user($info_store['userid'])['username'].'/';
	
	if($info_order['payment_method']==0){
		$info_order['payment_method']='Thanh toán khi nhận hàng';
		}else{
		$info_order['payment_method']='Thanh toán qua ví tiền';
	}
	
	if(!$info_order['status_payment_vnpay']){
		
		$check_voucher = check_voucher('', $info_order['voucherid'], $info_store['userid']);
		
		$arr = json_decode($check_voucher, true);
		
		if($arr['status'] == 'ERROR'){
			$info_order['total'] = $info_order['total'] + $info_order['voucher_price'];
			$info_order['voucher_price'] = 0;
		}
	}
	
	$info_order['status1'] = $info_order['status'];
	$info_order['transporters_name'] = get_info_transporters($info_order['transporters_id'])['name_transporters'];
	
	if($info_order['transporters_id'] == 0){
		$info_order['transporters_name'] = $lang_module['tranposter_tugiao'];
	}
	
	$info_order['status']=get_info_order_status($info_order['status'])['name'];
	$info_order['total_product']=number_format($info_order['total_product']);
	$info_order['total']=number_format($info_order['total']);
	$info_order['fee_transport']=number_format($info_order['fee_transport']);
	$info_order['voucher_price']=number_format($info_order['voucher_price']);
	
	$info_order['address'] = $info_order['address'];
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
	
	$db->select( 't1.*,t2.name_product, t2.alias, t2.id as id_product,t2.barcode, t2.image' )
	->order( 't1.id DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql());
	
	$sth->execute();
	$list_logs_order=$db->query('SELECT * FROM '.TABLE.'_logs_order where order_id='.$id)->fetchAll();
	$xtpl = new XTemplate( $op.'.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	
	$xtpl->assign('UPLOAD_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=upload&token=' . md5($nv_Request->session_id . $global_config['sitekey']));
	$array_config['maxfilesize'] = 10485760;
	$array_config['image_upload_size'] = 10485760;
	$xtpl->assign('MAXFILESIZEULOAD', $array_config['maxfilesize']);
	$xtpl->assign('MAXIMAGESIZEULOAD', explode('x', $array_config['image_upload_size']));
	$xtpl->assign('MAXFILESIZE', nv_convertfromBytes($array_config['maxfilesize']));
	$xtpl->assign('UPLOAD_IMG_SIZE', $array_config['image_upload_size']);
	$xtpl->assign('UPLOAD_DIR', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name);
	$xtpl->assign( 'MODULE_FILE', $module_name );
	$xtpl->assign('COUNT', 0);
	$xtpl->assign('COUNT_UPLOAD', 9);
	$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	
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
	$xtpl->assign( 'info_store', $info_store );
	$xtpl->assign( 'info_warehouse', $info_warehouse );
	$xtpl->assign( 'back_link', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ordercustomer',true));
	$xtpl->assign('children_fund', $config_setting['children_fund'] . '%');

	if($user_info['userid']){
		$info_order['check_rate'] = $db->query('SELECT count(*) FROM ' . TABLE . '_order t1 INNER JOIN ' . TABLE . '_order_item t2 ON t1.id = t2.order_id WHERE t2.product_id = ' . $info_order['id'] . ' AND t1.status = 3')->fetchColumn();
		$info_order['check_rate_st1'] = $db->query('SELECT count(*) FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_rate t2 ON t1.id = t2.product_id WHERE t2.product_id = ' . $info_order['id'] . ' AND t2.userid = ' .$user_info['userid'] . ' AND t2.status = 1')->fetchColumn();
		
		$info_order['info_rate'] = $db->query('SELECT t2.* FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_rate t2 ON t1.id = t2.product_id WHERE t2.product_id = ' . $info_order['id'] . ' AND t2.userid = ' .$user_info['userid'])->fetch();
		
		$info_order['check_rate_st2'] = $db->query('SELECT count(*) FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_rate t2 ON t1.id = t2.product_id WHERE t2.product_id = ' . $info_order['id'] . ' AND t2.userid = ' .$user_info['userid'] . ' AND t2.status = 2')->fetchColumn();
		
		
	}
	
	if($info_order['status_payment_vnpay'] and $info_order['payment'])
	{
		$info_order['status_payment_vnpay_title'] = 'VNPAY';
	}
	else
	{
		$info_order['status_payment_vnpay_title'] = 'Chưa thanh toán';
	}

	$info_order['time_add']=date('d-m-Y H:i',$info_order['time_add']);
	$xtpl->assign( 'info_order', $info_order );
	
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	if ( !empty( $q ) ) {
		$base_url .= '&q=' . $q;
	}
	$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
	if ( !empty( $generate_page ) ) {
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.view.generate_page' );
	}
	$number = $page > 1 ? ( $per_page * ( $page - 1 ) ) + 1 : 1;
	
	$tamtinh = 0;
	
	$i = 1;
	
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
			$view['name_group']= '( '.$name_group.' )';
		}
		$tamtinh = $tamtinh + $view['total'];
		$view['total']=number_format($view['total']);
		$view['price']=number_format($view['price']);
		$view['quantity']=number_format($view['quantity']);
		
		if (!empty($view['image'] ) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $view['image'] )) {
			$view['image']  = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
			}else{
			$server = 'banhang.'.$_SERVER["SERVER_NAME"];
			$view['image']  ='https://'. $server .NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload. '/' . $view['image'] ;
		}
		
		$view['alias_product'] =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $view['alias'].'-'.$view['id_product'], true );
		
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
		$list_product[] = $view;
		
		
	}
	
	$tamtinh=number_format($tamtinh);
	
	$xtpl->assign( 'tamtinh', $tamtinh );
	
	$stt_logs=1;
	foreach($list_logs_order as $value_logs){
		if($value_logs['status_id_old']==-1){
			$value_logs['status_id_old']='';
			}else{
			$value_logs['status_id_old']=get_info_order_status($value_logs['status_id_old'])['name'];
		}
		if($value_logs['user_add']>0){
			$value_logs['user_add']=get_info_user($value_logs['user_add'])['username'];
			}else{
			$value_logs['user_add']='Khách đặt hàng không có tài khoản';
		}
		$value_logs['time_add']=date('d/m/Y H:i',$value_logs['time_add']);
		$value_logs['number']=$stt_logs++;
		$xtpl->assign( 'LOOP_LOGS', $value_logs );
		$xtpl->parse( 'main.logs_order' );
	}
	
	
	if(!empty($info_order['shipping_code'])){
		if($info_order['transporters_id']==4 || $info_order['transporters_id']==5){
			$list_tracuu=check_info_order_vnpost_history($info_order['shipping_code']);
			foreach($list_tracuu as $value){
				$value['status_vnpost'] = $global_status_vnpos[$value['status_vnpost']]['name_status_vnpost'];
				$value['addtime'] = date('d/m/Y - H:i',$value['addtime']);
				$xtpl->assign( 'LOOP_TRACUU', $value );
				
				$xtpl->parse( 'main.vnpost' );
			}
			}elseif($info_order['transporters_id'] == 3){
			$list_tracuu_ghn = check_info_order_ghn_history($info_order['shipping_code']);
			
		
			foreach($list_tracuu_ghn as $value){
				//print_r($value);die;
				$value['status_ghn'] = $global_status_ghn[$value['status']]['desc_status_ghn'];

				if($value['reason_code']){
					$value['status_error_ghn'] = $global_status_error_ghn[$value['reason_code']]['desc_status_ghn'];
					$value['status_error_ghn'] = '(' . $value['status_error_ghn'] . ')';
				}
				
				$value['time_add'] = date('d/m/Y - H:i',$value['time_add']);
				$xtpl->assign( 'LOOP_GHN', $value );
				$xtpl->parse( 'main.ghn' );
			}
		}
	}
	
	
	
	if($info_order['status1']==3){
		foreach ($list_product as $key => $view) {
			
			$view['info_rate'] = $db->query('SELECT t2.* FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_rate t2 ON t1.id = t2.product_id WHERE t2.product_id = ' . $view['product_id'] . ' AND t2.userid = ' .$user_info['userid'] . ' AND t2.order_id = ' . $view['order_id'])->fetch();
			
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
			if($view['info_rate']){
				if($view['info_rate']['status'] == 1){
					$xtpl->assign( 'VIEW', $view );
					$xtpl->parse('main.view.rate.loop.edit_rate');
					}else{
					$xtpl->parse('main.view.rate.loop.edit_rated');
				}
				for ($i=5; $i >= 1 ; $i--) { 
					if($i == $view['info_rate']['star']){
						$checked = "checked";
						}else{
						$checked = "";
					}
					$xtpl->assign( 'VIEW', $view );
					$xtpl->assign('CHECKED', $checked);
					$xtpl->assign('STT', $i);
					$xtpl->parse('main.view.rate.loop.star');
				}
				$array_otherimage = explode("|", $view['info_rate']['other_image']);
				$list_image=array();
				foreach ($array_otherimage as $key => $value) {
					$list_image[]['image']=$value;
				}
				$y = 10;
				
				if ($view['info_rate']['other_image']) {
					foreach ($list_image as $otherimage) {
						$otherimage['number'] = $y;
						$otherimage['filepath'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $otherimage['image'];
						$otherimage['homeimgfile'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' .$otherimage['image'];
						$otherimage['homeimgfile'] = str_replace(NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/', '',$otherimage['image']);
						$xtpl->assign( 'VIEW', $view );
						$xtpl->assign('DATA', $otherimage);
						$xtpl->parse('main.view.rate.loop.data');
						$y ++;
					}
				}
				
				
				}else{
				$xtpl->assign( 'VIEW', $view );
				$xtpl->parse('main.view.rate.loop.no_star');
				$xtpl->parse('main.view.rate.loop.no_edit_rate');
			}
			
			
			$view['total']=$view['total'];
			$view['price']=$view['price'];
			$view['quantity']=number_format($view['quantity']);
			$xtpl->assign( 'COUNT_IMAGE', count($list_product));
			$xtpl->assign( 'VIEW', $view );
			$xtpl->parse( 'main.view.rate.loop' );
			
		}
		$xtpl->parse('main.view.rate');
	}
	
	
	if($info_order['voucherid']){
		$xtpl->parse( 'main.view.voucher' );
	}
	
	
	$xtpl->parse( 'main.view' );
	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
	
	$page_title = $lang_module['vieworder'].' '.$info_order['order_code'];
	$array_mod_title[] = array(
	'catid' => 0,
	'title' => 'Kiểm tra đơn hàng',
	'link' => NV_MY_DOMAIN .'/'. $module_name .'/ordercustomer/'
	);
	$array_mod_title[] = array(
	'catid' => 0,
	'title' => $page_title,
	'link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=vieworder&amp;id=' . $id,true)
	);
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';