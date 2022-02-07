<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS Holdings <contact@tms.vn>
 * @Copyright (C) 2020 TMS Holdings. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 21 Dec 2020 09:08:19 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$row['warehouse_product_import_id'] = $nv_Request->get_int('warehouse_product_import_id', 'post,get', 0);
$row['warehouse_product_import_code'] = $nv_Request->get_title('warehouse_product_import_code', 'post,get', '');
$row['user_add'] = $nv_Request->get_title('user_add', 'post,get', '');
$row['time_add'] = $nv_Request->get_title('time_add', 'post,get', '');
$row['name_warehouse'] = $nv_Request->get_title('name_warehouse', 'post,get', '');
$row['list_product']=get_list_item_warehouse_import($row['warehouse_product_import_id']);
$row['total_price'] = $nv_Request->get_title('total_price', 'post,get', '');
$row['total_amount'] = $nv_Request->get_title('total_amount', 'post,get', '');

$xtpl = new XTemplate('warehouse_import_view.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
foreach($row['list_product'] as $key_list=>$value){
	if($value['classify_value_product_id']>0){
		$classify_value_product_id=get_info_classify_value_product($value['classify_value_product_id']);
		$classify_id_value1=get_info_classify_value($classify_value_product_id['classify_id_value1']);
		$classify_id_value2=get_info_classify_value($classify_value_product_id['classify_id_value2']);
		$name_classify_id_value1=get_info_classify($classify_id_value1['classify_id'])['name_classify'].' '.$classify_id_value1['name'];
		if(!empty($classify_id_value2['classify_id'])){
			$name_classify_id_value2=get_info_classify($classify_id_value2['classify_id'])['name_classify'].' '.$classify_id_value2['name'];
			$name_group=$name_classify_id_value1.', '.$name_classify_id_value2;
		}else{
			$name_group=$name_classify_id_value1;
		}
		$value['name_product']=$value['name_product'].' ('.$name_group.')';
	}else{
		$name_group='';
	}
	$value['amount']=number_format($value['amount']);
	$value['price']=number_format($value['price_import']).' '.get_info_currency($value['unit_currency'])['symbol'];
	$value['price_exchange']=number_format($value['price_import']*get_info_currency($value['unit_currency'])['exchange']).' VND';
	$xtpl->assign('info_product', $value);
	$xtpl->assign('key_list', $key_list+1);
	$xtpl->parse('main.product');
}
$xtpl->assign('total_amount', number_format($row['total_amount']));
$xtpl->assign('total_price_exchange', number_format($row['total_price']).' VND');

$page_title = $lang_module['warehouse_import_view'].' với mã nhập kho '.$row['warehouse_product_import_code'];
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';