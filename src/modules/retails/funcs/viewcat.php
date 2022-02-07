<?php


if(true){
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $cat_info['alias'];
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
	
	// sp pho bien = 1, sp yeu thich = 2, sp mới = 3
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
		$cat_all_lev = get_parent_category($catalogy_child);
		$where .= ' AND t1.categories_id IN('. implode(',', $cat_all_lev) .')';
		$base_url .= '&catalogy_child=' . $catalogy_child;
	}
	else
	{
		$cat_all_lev = get_parent_category($cat_info['id']);
		//print_r($cat_all_lev);
		$where .= ' AND t1.categories_id IN('. implode(',', $cat_all_lev) .')';		
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
	->where('t1.inhome = 1'. $where);
	
	$sth = $db->prepare($db->sql());
	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.id,t1.image,t1.alias,t1.name_product,t1.star,t1.price,t1.price_special,t1.number_order,free_ship')
	->order($orderby_sql)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	$sth = $db->prepare($db->sql());
		
	//print_r($db->sql());
	
	$sth->execute();
	if($cat_info['keyword']){
		$key_words = $cat_info['keyword'];
	}
	if($cat_info['description']){
		$description = $cat_info['description'];
	}
	
	$list_category_parrent = get_list_category($cat_info['id']);
	
	$data = $sth->fetchAll();

	$contents = nv_theme_retailshops_viewcat_grid($data,$per_page,$page_new,$num_items,$cat_info,$base_url,$list_category_parrent,$page);
	
	$page_title = $cat_info['name'];
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
