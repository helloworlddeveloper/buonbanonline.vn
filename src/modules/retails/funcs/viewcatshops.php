<?php
	$mod = $nv_Request->get_string('mod', 'post, get', 0);
	$id = $nv_Request->get_int('id', 'get','');
	
	if($mod=="follow"){
		
		if (!defined('NV_IS_USER')) {
			// lấy thông tin link chi tiết sản phẩm lưu vào SESSION
			$info_shop = get_info_shop($id);
			$alias_shop = get_info_user($info_shop['userid'])['username'];
			$link_shop =nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias_shop, true );
			$_SESSION['back_link'] = $link_shop;
			//print_r($_SESSION['back_link']);die;
			print_r( json_encode( array( 'status'=>'ERROR','link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login',true) ) ) );
			die();
			}else{
			$check = $db->query('SELECT count(*) FROM ' . TABLE . '_follow WHERE shop_id = ' . $id . ' AND user_id = ' . $user_info['userid'])->fetchColumn();
			if($check == 0){
				$db->query('INSERT INTO ' . TABLE . '_follow(user_id,shop_id,time_add) VALUES ('.$user_info['userid'].','.$id.','.NV_CURRENTTIME.')');
				
				$json[] = ['status'=>'OK', 'text'=>'Theo dõi shop thành công'];
				}else{
				$json[] = ['status'=>'KO', 'text'=>'Bạn đã theo dõi shop này rồi'];
			}
			print_r(json_encode($json[0]));die(); 
		}
	}
	if($mod=="un_follow"){
		
		if (!defined('NV_IS_USER') or !$global_config['allowuserlogin']) {
			$json[] = ['status'=>'KO', 'text'=>'Bạn vui lòng đăng nhập để sử dụng chức năng!'];
			print_r(json_encode($json[0]));die(); 
		}
		
		$id=$nv_Request->get_int('id', 'get','');
		$check = $db->query('SELECT count(*) FROM ' . TABLE . '_follow WHERE shop_id = ' . $id . ' AND user_id = ' . $user_info['userid'])->fetchColumn();
		if($check != 0){
			$db->query('DELETE FROM ' . TABLE . '_follow WHERE shop_id = ' . $id . ' AND user_id = ' . $user_info['userid']);
			$json[] = ['status'=>'OK', 'text'=>'Bỏ theo dõi shop thành công'];
			}else{
			$json[] = ['status'=>'KO', 'text'=>'Bạn chưa theo dõi shop này'];
		}
		
		print_r(json_encode($json[0]));die(); 
	}
	
	if($mod=="save_voucher"){
		$voucher_id = $nv_Request->get_int('voucher_id', 'get, post','');
		if (!defined('NV_IS_USER')) {
			print_r( json_encode( array( 'status'=>'ERROR','link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login',true) ) ) );
			die();
			}else{
			$check_voucher_shop = $db->query('SELECT COUNT(id) FROM ' . TABLE . '_voucher_shop WHERE store_id = '. $_SESSION["shop_id"] . ' AND id = ' . $voucher_id )->fetchColumn();
			
			if($check_voucher_shop){
				
				$check_voucher_wallet = $db->query('SELECT COUNT(id) FROM ' . TABLE . '_voucher_wallet WHERE userid = '. $user_info["userid"] . ' AND voucherid = ' . $voucher_id )->fetchColumn();
				
				if($check_voucher_wallet){
					$json = ['status'=>'KO', 'text'=>'Lưu voucher thất bại'];
					print_r(json_encode($json));die();
				}
				}else{
				$json = ['status'=>'KO', 'text'=>'Lưu voucher thất bại'];
				print_r(json_encode($json));die(); 
			}
			
			
			
			$sql = 'INSERT INTO ' . TABLE . '_voucher_wallet (voucherid, userid, type_voucher, time_add) VALUES (:voucherid, :userid, :type_voucher, :time_add)';
			
			$data_insert = array();
			$data_insert['voucherid'] = $voucher_id;
			$data_insert['userid'] = $user_info['userid'];
			$data_insert['type_voucher'] = 1;
			$data_insert['time_add'] = NV_CURRENTTIME;
			$id = $db->insert_id($sql, 'id', $data_insert);
			
			// print_r($id);die;
			if($id){
				//trừ số lượng
				$db->query('UPDATE ' . TABLE . '_voucher_shop SET usage_limit_quantity = usage_limit_quantity - 1 WHERE id =' . $voucher_id);
				
				$json = ['status'=>'OK', 'text'=>'Lưu voucher thành công'];
				print_r(json_encode($json));die(); 
				}else{
				$json = ['status'=>'KO', 'text'=>'Lưu voucher thất bại'];
				print_r(json_encode($json));die(); 
			}
			
		}
		
	}
	
	if(true){
		
		$info_shop = get_info_shop($shop_id);
		
		$info_shop['follow'] = $db->query('SELECT count(*) FROM ' . TABLE . '_follow WHERE shop_id = ' . $shop_id)->fetchColumn();
		$info_shop['time_add'] = date('d-m-Y', $info_shop['time_add']);
		$info_shop['number_product'] = $db->query('SELECT count(*) FROM ' . TABLE . '_product WHERE inhome = 1 AND store_id = ' . $shop_id)->fetchColumn();
		
		//sprint_r($info_shop['follow']);die;
		$page_title = $info_shop['company_name'];
		$array_mod_title[] = array(
		'title' => $page_title,
		);
		
		$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias_detail;
		$per_page = 36;
		$page = $nv_Request->get_int('page', 'post,get', 0);
		if($page==0){
			$page_new=1;
			}else{
			$page_new=$page;
		}
		
		$where = '';
		$orderby = array();
		
		// thuong hieu
		$brand = $nv_Request->get_int( 'brand', 'post,get', 0);
		
		// danh muc con
		$catalogy_child = $nv_Request->get_int( 'catalogy_child', 'post,get', 0);
		//print_r($catalogy_child);
		// sp pho bien = 1, sp yeu thich = 2
		$categoryFilter = $nv_Request->get_int( 'categoryFilter', 'post,get', 0);
		
		// gia thap den cao = 1, cao xuong thap = 2
		$categoryFilter_price = $nv_Request->get_int( 'categoryFilter_price', 'post,get', 0);
		
		// loc theo sao
		$categoryFilter_star = $nv_Request->get_int( 'categoryFilter_star', 'post,get', 0);
		
		if($brand)
		{
			$where .= ' AND t1.brand ='. $brand;
			$base_url .= '&brand=' . $brand;
		}
		
		if($catalogy_child)
		{
			$where .= ' AND t1.categories_id='.$catalogy_child ;
			$base_url .= '&catalogy_child=' . $catalogy_child;
		}
		
		
		//sp pho bien = 1
		if($categoryFilter == 1)
		{
			$orderby[] = 't1.number_view DESC';
			$base_url .= '&categoryFilter=' . $categoryFilter;
		}
		
		
		//sp yeu thich = 2
		if($categoryFilter == 2)
		{
			$orderby[] = 't1.number_like DESC';
			$base_url .= '&categoryFilter=' . $categoryFilter;
		}
		
		//sp moi = 3
		if($categoryFilter == 3) 
		{
			$orderby[] = 't1.time_add DESC';
			$base_url .= '&categoryFilter=' . $categoryFilter;
		}
		
		//gia thap den cao = 1
		if($categoryFilter_price == 1)
		{
			$orderby[] = 't1.price ASC';
			$base_url .= '&categoryFilter_price=' . $categoryFilter_price;
		}
		
		//gia thap den cao = 2
		if($categoryFilter_price == 2)
		{
			$orderby[] = 't1.price DESC';
			$base_url .= '&categoryFilter_price=' . $categoryFilter_price;
		}
		
		if($categoryFilter_star)
		{
			$where .= ' AND t1.star >='. $categoryFilter_star;
			$base_url .= '&categoryFilter_star=' . $categoryFilter_star;
		}
		
		
		$orderby_sql = '';
		if(empty($orderby))
		{
			$orderby_sql = 't1.number_order DESC, t1.star DESC, t1.number_like DESC, t1.number_view DESC, t1.time_add DESC';
		}
		else
		{
			$orderby_sql = implode(',', $orderby );
		}
		
		
		
		$db->sqlreset()
		->select('COUNT(*)')
		->from('' . TABLE . '_product t1')
		->where('store_id = ' . $shop_id . ' AND inhome = 1'. $where);
		
		$sth = $db->prepare($db->sql());
		//print_r($db->sql());die();
		$sth->execute();
		$num_items = $sth->fetchColumn();
		$db->select('t1.id,t1.image,t1.alias,t1.name_product,t1.star,t1.price,t1.price_special,t1.number_order,free_ship')
		->order($orderby_sql)
		->limit($per_page)
		->offset(($page_new - 1) * $per_page);
		$sth = $db->prepare($db->sql());
		$sth->execute();
		
		
		
		$list_category_parrent = get_list_full_category_shop($shop_id);
		
		$getbrand_all = getbrand_all_store($shop_id);
		
		$data = $sth->fetchAll();
		
		//danh sách voucher 
		
		$list_voucher = $db->query('SELECT * FROM ' . TABLE . '_voucher_shop WHERE store_id = ' . $shop_id . ' AND status = 1 ORDER BY time_to ASC' )->fetchAll();
		
		$contents = shops_info($data,$per_page,$page_new,$num_items,$cat_info,$base_url,$list_category_parrent,$getbrand_all,$page,$info_shop,$list_voucher);
		
		$description = !empty($cat_info['description']) ? $cat_info['description'] : $cat_info['name'];
		
		if($cat_info['parrent_id']>0){
			
			$array_mod_title[] = array(
			'catid' => get_info_category($cat_info['parrent_id'])['id'],
			'title' => get_info_category($cat_info['parrent_id'])['name'],
			'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.get_info_category($cat_info['parrent_id'])['alias'].'/'
			);
			
		}
		$array_mod_title[] = array(
		'catid' => $cat_info['id'],
		'title' => $cat_info['name'],
		'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.$cat_info['alias'].'/'
		);
		if($page==0){
			include NV_ROOTDIR . '/includes/header.php';
			echo nv_site_theme($contents);
			include NV_ROOTDIR . '/includes/footer.php';	
			}else{
			echo $contents;
		}
	}
