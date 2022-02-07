<?php

if (!defined('NV_IS_USER')) {
    echo '<script language="javascript">';
    echo 'alert("Vui lòng đăng nhập để thực hiện chức năng này");window.location = "'.NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users' . '&' . NV_OP_VARIABLE . '=login'.'"';
    echo '</script>';
}
$mod = $nv_Request->get_string( 'mod', 'get,post', '' );
if($mod=='delete_wishlist'){

	$product_id = $nv_Request->get_int('product_id', 'post,get', 0);
    $db->query('DELETE FROM '.TABLE.'_wishlist WHERE product_id='. $product_id .' AND userid = ' . $user_info['userid']);
    $json[] = ['status'=>"OK", 'text'=>"Sửa đánh giá thành công!"];
    print_r(json_encode($json[0]));die(); 
    die();
}
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;


$per_page = 8;
$page = $nv_Request->get_int('page', 'post,get', 0);
if($page==0){
    $page_new=1;
}else{
    $page_new=$page;
}

$where = '';

$q = $nv_Request->get_title('s', 'post,get');

if(!empty($q))
{
	$where = ' AND t1.name_product LIKE "%'. $q .'%"';
}

$db->sqlreset()
->select('COUNT(*)')
->from('' . TABLE . '_product t1')
->join('INNER JOIN ' . TABLE . '_wishlist t2 ON t1.id = t2.product_id')
->where('t2.userid = '.$user_info['userid'] . $where );
$sth = $db->prepare($db->sql());

$sth->execute();
$num_items = $sth->fetchColumn();
$db->select('t1.*')
->order('weight DESC')
->limit($per_page)
->offset(($page_new - 1) * $per_page);
$sth = $db->prepare($db->sql());

$sth->execute();

// gọi hàm xử lý
$contents = nv_theme_wish_list($sth,$per_page,$page_new,$num_items,$base_url, $q);
$page_title = "Sản phẩm yêu thích";
$array_mod_title[] = array(
		'catid' => 0,
		'title' => $page_title,
		'link' => NV_MY_DOMAIN .'/'.$op.'/'
	);



if ($nv_Request->isset_request('s', 'get')) {
	echo $contents;
}
else
{
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
}	

