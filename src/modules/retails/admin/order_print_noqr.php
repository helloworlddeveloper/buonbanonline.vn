<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANGDINHTU (dlinhvan@gmail.com)
 * @Copyright (C) 2013 Webdep24.com. All rights reserved
 * @Blog http://dangdinhtu.com
 * @Developers http://developers.dangdinhtu.com/
 * @License GNU/GPL version 2 or any later version
 * @Createdate  Mon, 20 Oct 2014 14:00:59 GMT
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );


$page_title = 'IN PHIẾU ĐƠN HÀNG';

$order_id = $nv_Request->get_int( 'order_id', 'post,get', 0 );
$order_status_id = $nv_Request->get_int( 'order_status_id', 'post,get', 0 );
$action = $nv_Request->get_string('action', 'post,get', 0 );
$order_info = $db->query('SELECT * FROM '.TABLE.'_order WHERE id = ' . (int)$order_id )->fetch();
if( empty( $order_info ) ) Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=order' );

$order_info['reward'] = 0;


$link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=';

$dataContent = array();
$dataContent['order_id'] = $order_id;
$dataContent['invoice_prefix'] = $order_info['order_code'];
$dataContent['order_name'] = $order_info['order_name'];
$dataContent['address'] = $order_info['address'].', '.get_info_ward( $order_info['ward_id'] )['title'].', '.get_info_district( $order_info['district_id'] )['title'].', '.get_info_province( $order_info['province_id'] )['title'];
$dataContent['phone'] = $order_info['phone'];
$dataContent['fee_transport'] = number_format($order_info['fee_transport']);
$dataContent['total'] = number_format($order_info['total']);
$dataContent['total_product'] = number_format($order_info['total_product']);
$dataContent['transporters_name']=get_info_transporters($order_info['transporters_id'])['name_transporters'];
$info_warehouse = get_info_warehouse( $order_info['warehouse_id'] );
$info_warehouse['address'] = $info_warehouse['address'].', '.get_info_ward( $info_warehouse['ward_id'] )['title'].', '.get_info_district( $info_warehouse['district_id'] )['title'].', '.get_info_province( $info_warehouse['province_id'] )['title'];
$dataContent['time_add'] =date('d-m-Y H:i',$order_info['time_add']);
$xtpl = new XTemplate( 'order_print_noqr.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'DATA', $dataContent );
$xtpl->assign( 'INFO_SHOP', $info_warehouse );
$order_product_query = $db->query('SELECT t1.*,t2.name_product FROM ' . TABLE . '_order_item t1 INNER JOIN '.TABLE.'_product t2 ON t1.product_id=t2.id WHERE order_id = ' . (int)$order_id )->fetchAll();
$stt=1;
foreach($order_product_query as $view){
	$view['stt']=$stt++;
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
	$view['price']=number_format($view['price']);
	$view['total']=number_format($view['total']);
	$xtpl->assign( 'PRODUCT', $view );

	$xtpl->parse( 'main.product' );
}
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );


if($action =='createinvoiceno'){
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents,false );
	include NV_ROOTDIR . '/includes/footer.php';
	// echo json_encode( $json );
	exit();
}else{
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}
