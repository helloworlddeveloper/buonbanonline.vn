<?php
	
	/**
		* @Project TMS HOLDINGS
		* @Author TMS Holdings <contact@tms.vn>
		* @Copyright (C) 2020 TMS Holdings. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Mon, 21 Dec 2020 09:08:19 GMT
	*/
	
	if (!defined('NV_IS_MOD_RETAILSHOPS'))
	die('Stop!!!');
	
	$per_page = 6;
	$key_words = $module_info['keywords'];
	$array_data = array();
	$array_data=get_info_product($id);
	//print_r($global_ward);die;
	if($array_data['inhome'] < 1 or $array_data['status'] == 0){
		echo '<script language="javascript">';
		echo 'window.location = "' . NV_BASE_SITEURL .'"';
		echo '</script>';
	}
	
	$number_view_new=$array_data['number_view']+1;
	$db->query('UPDATE '.TABLE.'_product SET number_view='.$number_view_new.' where id='.$id); 
	$array_data['number_view']=number_format($array_data['number_view']);
	
	$cat_all_lev = get_parent_category($array_data['categories_id']);
	
	$list_product_category = $db->query('SELECT id, image, alias, name_product, star, price, price_special, number_order,free_ship FROM ' . TABLE . '_product WHERE id != '. $id .' AND inhome = 1 AND categories_id IN('. implode(',', $cat_all_lev) .') ORDER BY number_order DESC, star DESC, number_like DESC, number_view DESC, time_add DESC limit ' . $per_page)->fetchAll();
	
	
	$list_classify=get_full_classify($array_data['id']);
	$array_data['classify']=array();
	foreach($list_classify as $value){
		$value['list_classify_value']=get_full_classify_value($value['id']);
		$array_data['classify'][]=$value;
	}
	
	
	$list_product_store = $db->query('SELECT id,image,alias,name_product,star,price,price_special,number_order,free_ship FROM ' . TABLE . '_product WHERE id != '. $id .' AND inhome = 1 AND store_id = ' . $array_data['store_id'] . ' ORDER BY number_order DESC, star DESC, number_like DESC, number_view DESC, time_add DESC limit ' . $per_page)->fetchAll();
	
	
	
	if($user_info['userid']){
		$array_data['check_rate'] = $db->query('SELECT count(*) FROM ' . TABLE . '_order t1 INNER JOIN ' . TABLE . '_order_item t2 ON t1.id = t2.order_id WHERE t2.product_id = ' . $array_data['id'] . ' AND t1.status = 3')->fetchColumn();
		$array_data['check_rate_st1'] = $db->query('SELECT count(*) FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_rate t2 ON t1.id = t2.product_id WHERE t2.product_id = ' . $array_data['id'] . ' AND t2.userid = ' .$user_info['userid'] . ' AND t2.status = 1')->fetchColumn();
		
		$array_data['info_rate'] = $db->query('SELECT t2.* FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_rate t2 ON t1.id = t2.product_id WHERE t2.product_id = ' . $array_data['id'] . ' AND t2.userid = ' .$user_info['userid'])->fetch();
		
		$array_data['check_rate_st2'] = $db->query('SELECT count(*) FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_rate t2 ON t1.id = t2.product_id WHERE t2.product_id = ' . $array_data['id'] . ' AND t2.userid = ' .$user_info['userid'] . ' AND t2.status = 2')->fetchColumn();
	}
	
	
	
	
	
	$page = $nv_Request->get_int('page', 'post,get', 1);
	if($page==0){
		$page_new=1;
		}else{
		$page_new=$page;
	}
	$num_items =  $db->query("SELECT count(*) FROM " .TABLE."_rate WHERE product_id = " . $array_data['id']) -> fetchColumn();
	$list_rate =  $db->query("SELECT * FROM " .TABLE."_rate WHERE product_id = " . $array_data['id'] . ' LIMIT ' . $per_page . ' offset ' . ($page_new - 1) * $per_page) -> fetchAll();
	
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=ajax&amp;id=' . $array_data['id'] . '&amp;mod=load_comment_detail';
	
	// đánh giá star
	if(!$array_data['star'])
	$array_data['star'] = 0;
	
	
	// đếm số lượt đánh giá
	$array_data['total_star'] = total_star_product($array_data['id']);
	
	
	// thông tin cửa hàng user_add store_id
	
	$info_store = get_info_store($array_data['store_id']);
	
	$info_store['alias'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . get_info_user($info_store['userid'])['username'], true );
	
	
	// tổng số sản phẩm của cửa hàng
	$info_store['number_product'] = $db->query('SELECT count(id) as count FROM ' . TABLE . '_product WHERE store_id='. $array_data['store_id'] .' AND inhome = 1')->fetchColumn();
	
	// tổng số người theo dõi cửa hàng
	$info_store['number_fllow'] = $db->query('SELECT count(id) as count FROM ' . TABLE . '_follow WHERE shop_id='. $array_data['store_id'])->fetchColumn();
	
	
	$info_store['time_add'] = date('d/m/Y',$info_store['time_add']);
	$info_store['number_fllow'] = number_format($info_store['number_fllow']);
	
	// rate comment
	$list_comment = comment_rate_product($array_data['id']);	 
	
	// hình ảnh sản phẩm theo thuộc tính
	$product_classify = $db->query('SELECT id FROM ' . TABLE .'_product_classify WHERE product_id =' . $array_data['id'])->fetchAll();
	
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
			$array_data['image_classify'] = $db->query('SELECT id, image FROM ' . TABLE .'_product_classify_value WHERE classify_id IN('. implode(',',$array_product_classify) .')')->fetchAll();
		}
		
	}
	
	
	
	$contents = nv_theme_retailshops_detail($array_data,$list_product_category,$list_product_store,$list_rate,$page_new,$per_page,$base_url,$num_items,$page,$info_store,$list_comment);
	
	
	$page_title = $array_data['name_product'];
	$page_title = !empty($array_data['tag_title']) ? $array_data['tag_title'] : $array_data['name_product'];
	$description = !empty($array_data['tag_description']) ? $array_data['tag_description'] : $array_data['description'];
	
	$get_info_category = get_info_category($array_data['categories_id']);
	$get_info_parrent_id = get_info_category($get_info_category['parrent_id']);
	
	if($get_info_category['parrent_id']>0){
		$array_mod_title[] = array(
		'catid' => $get_info_parrent_id['id'],
		'title' => $get_info_parrent_id['name'],
		'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.get_info_category($get_info_category['parrent_id'])['alias'].'/'
		);
	}
	$array_mod_title[] = array(
	'catid' => $array_data['categories_id'],
	'title' => $get_info_category['name'],
	'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.$get_info_category['alias'].'/'
	);
	
	$array_mod_title[] = array(
	'catid' => 0,
	'title' => $array_data['name_product'],
	'link' => NV_MY_DOMAIN .'/'. $module_name .'/'.$array_data['alias'].'/'
	);
	
	$server = 'banhang.'.$_SERVER["SERVER_NAME"];
	$meta_property['og:image'] = 'https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $array_data['image'] ;
	
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
