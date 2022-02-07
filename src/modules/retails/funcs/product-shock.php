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

	if (!defined('NV_IS_ADMIN'))
    die('Stop!!!');
	$page_title = 'Sản phẩm giá shock';
	
	$check_block_product = $db->query('SELECT id FROM '. TABLE .'_block WHERE keyword ="'. $array_op[1] .'"')->fetchColumn();
		
	$list_more_product_shock = 'SELECT t1.id,t1.image,t1.alias,t1.name_product,t1.star,t1.price,t1.price_special, free_ship FROM ' . TABLE . '_product t1 INNER JOIN ' . TABLE . '_block_id t2 ON t1.id = t2.product_id  WHERE t1.inhome = 1 AND t2.bid = ' . $check_block_product . ' ORDER BY rand() limit 30';
	
	$list = $db->query($list_more_product_shock)->fetchAll();
	

	$contents = nv_theme_more_product_shock($list_block_product,$block_bid,$list);
	

	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
