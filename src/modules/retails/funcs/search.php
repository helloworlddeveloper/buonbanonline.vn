<?php
$mod = $nv_Request->get_string('mod', 'post, get', 0);
// hiển thị các sản phẩm gợi ý khi tìm kiếm
if($mod=="suggest"){
	$key_word=$nv_Request->get_string('key_word', 'get,post','');
	
	// chuyển từ tiếng việt có dấu về không dấu
	$key_word = vn_to_str($key_word);
	
	$per_page = 10;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );

	
	$key_word = $db->dblikeescape($key_word);
	if($key_word){
		$where .= ' AND (name_product like "%' . $key_word . '%" OR keyword like "%' . $key_word . '%" OR barcode like "%' . $key_word . '%" OR ecngcode like "%' . $key_word . '%")';
	}

	$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( '' . TABLE . '_product ')
	->where( '1 = 1 and inhome = 1 and status = 1 ' . $where );
	$sth = $db->prepare( $db->sql() );

	
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select( '*' )
	->order( 'number_order DESC' )
	->limit( $per_page )
	->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	$sth->execute();
	//print_r($db->sql());
	//die($db->sql()) ;

	$list_info_shop = $db->query('SELECT t1.*, t2.username FROM ' . TABLE . '_seller_management t1 INNER JOIN ' . $db_config['prefix'] . '_users t2 ON t1.userid = t2.userid WHERE t1.company_name LIKE "%' . $key_word . '%" AND t1.status = 1 LIMIT 1')->fetchALl();
	$num_items = $num_items + count($list_info_shop);


	$contents = nv_theme_retail_suggest_search( $sth,$list_info_shop,$key_word );
	
	die($contents);

}


if(true){
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=search';
	$per_page = 36;
	$page = $nv_Request->get_int('page', 'post,get', 0);
	if($page==0){
		$page_new=1;
	}else{
		$page_new=$page;
	}
	
	$where = '';
	$orderby = array();
	
	// keyword
	$q = $nv_Request->get_title( 'q', 'get', '');  
	// chuyển từ tiếng việt có dấu về không dấu
	$q = vn_to_str($q);
	
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
	
	if(!empty($q))
	{
		$where .= ' AND (t1.name_product like "%'. $q .'%" OR t1.keyword like "%'. $q .'%")';
		$base_url .= '&q=' . urlencode($q);
	}
	
	if($brand)
	{
		$where .= ' AND t1.brand ='. $brand;
		$base_url .= '&brand=' . $brand;
	}
	
	if($catalogy_child)
	{
		$where .= ' AND (t2.id='.$catalogy_child.' OR t2.parrent_id='.$catalogy_child.')' ;
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
	
	$data = array();
	
	$db->sqlreset()
	->select('COUNT(*)')
	->from('' . TABLE . '_product t1')
	->join('INNER JOIN ' . TABLE . '_categories t2 ON t1.categories_id = t2.id')
	->where('t1.status=1 AND t1.inhome = 1 '. $where);

	$sth = $db->prepare($db->sql());
 
	$sth->execute();
	$num_items = $sth->fetchColumn();
	$db->select('t1.id,t1.image,t1.alias,t1.name_product,t1.star,t1.price,t1.price_special,t1.number_order,free_ship')
	->order($orderby_sql)
	->limit($per_page)
	->offset(($page_new - 1) * $per_page);
	$sth = $db->prepare($db->sql());
	$sth->execute();
	
	$data = $sth->fetchAll();
	
	
	
	$list_category_parrent = get_list_full_category_lev1();
	
	
	 
	$contents = nv_theme_retailshops_viewcat_grid_search($data,$per_page,$page_new,$num_items,$base_url,$list_category_parrent,$page,$q);
	
	$page_title = 'Tìm kiếm';
	
	
	if($page==0){
		include NV_ROOTDIR . '/includes/header.php';
		echo nv_site_theme($contents);
		include NV_ROOTDIR . '/includes/footer.php';	
	}else{
		echo $contents;
	}
}
