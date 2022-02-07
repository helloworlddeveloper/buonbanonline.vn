<?php

/**
 * @Project NUKEVIET 4.x
 * @Author TMS <TMS@thuongmaiso.vn>
 * @Copyright (C) 2020 TMS. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Tue, 31 Mar 2020 02:34:09 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
	die('Stop!!!');

$page_title = $lang_module['config'];
$saveconfig = $nv_Request->get_int( 'saveconfig', 'post', 0 );
$mod = $nv_Request->get_string('mod', 'post, get', 0);

if($mod=="getform"){

	$id=$nv_Request->get_string('id', 'get','');
	$xtpl = new XTemplate($id . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/' . $module_file);
	$xtpl->assign('LANG', $lang_module);
	$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
	$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
	$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
	$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
	$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
	$xtpl->assign('MODULE_NAME', $module_name);
	$xtpl->assign('OP', $op);
	$xtpl->assign('DATA', $config_setting);
	for ($i=0; $i < 3; $i++) { 
		$xtpl->assign('pro_no', $i);
		$xtpl->parse('main.data_product.loop');
	}
	
	$xtpl->parse('main.data_product');
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	$json[] = ['status'=>'OK', 'text'=>$contents];
	print_r(json_encode($json[0]));die(); 
}
if($mod=="getformnhaban"){

	$id=$nv_Request->get_string('id', 'get','');
	$xtpl = new XTemplate($id . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/' . $module_file);
	$xtpl->assign('LANG', $lang_module);
	$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
	$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
	$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
	$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
	$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
	$xtpl->assign('MODULE_NAME', $module_name);
	$xtpl->assign('OP', $op);
	$xtpl->assign('DATA', $config_setting);
	for ($i=0; $i < 3; $i++) { 
		$xtpl->assign('pro_no', $i);
		$xtpl->parse('main.data_product.loop');
	}
	
	$xtpl->parse('main.data_product');
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	$json[] = ['status'=>'OK', 'text'=>$contents];
	print_r(json_encode($json[0]));die(); 
}

if( ! empty( $saveconfig ) )
{
	$config_setting = array();	
	$config_setting['raw_product_prefix'] = $nv_Request->get_string( 'raw_product_prefix', 'post', '' );
	$config_setting['username_vnpost'] = $nv_Request->get_string('username_vnpost', 'post', '');
	$config_setting['password_vnpost'] = $nv_Request->get_string('password_vnpost', 'post', '');
	$config_setting['token_ghn'] = $nv_Request->get_string('token_ghn', 'post', '');
	$config_setting['max_price_ghn'] = $nv_Request->get_string('max_price_ghn', 'post', '');
	$config_setting['token_ahamove'] = $nv_Request->get_string('token_ahamove', 'post', '');
	$config_setting['raw_import_product_prefix'] = $nv_Request->get_string('raw_import_product_prefix', 'post', '');
	$config_setting['inhome_viewcat']=$nv_Request->get_string('inhome_viewcat', 'post', 0);
	$config_setting['url_ghn'] = $nv_Request->get_string('url_ghn', 'post', '');
	$config_setting['url_ghtk'] = $nv_Request->get_string('url_ghtk', 'post', '');
	$config_setting['token_ghtk'] = $nv_Request->get_string('token_ghtk', 'post', '');
	$config_setting['number_product'] = $nv_Request->get_string('number_product', 'post', '');
	$config_setting['raw_order_prefix'] = $nv_Request->get_string('raw_order_prefix', 'post', '');
	$config_setting['number_product_push'] = $nv_Request->get_string('number_product_push', 'post', '');
	$config_setting['time_push_product'] = $nv_Request->get_string('time_push_product', 'post', '');
	$config_setting['website_code_vnpay'] = $nv_Request->get_string('website_code_vnpay', 'post', '');
	$config_setting['checksum_vnpay'] = $nv_Request->get_string('checksum_vnpay', 'post', '');
	$config_setting['percent_of_order_payment_discount'] = $nv_Request->get_string('percent_of_order_payment_discount', 'post', '');
	
	$config_setting['percent_of_ship'] = $nv_Request->get_string('percent_of_ship', 'post', '');
	$config_setting['email_get_not_received'] = $nv_Request->get_string('email_get_not_received', 'post', '');
	$config_setting['email_order_seller_delivery_failed'] = $nv_Request->get_string('email_order_seller_delivery_failed', 'post', '');
	$config_setting['email_seller_register'] = $nv_Request->get_string('email_seller_register', 'post', '');
	
	$config_setting['insurance'] = $nv_Request->get_string('insurance', 'post', 0);
	
	$config_setting['province_ecng'] = $nv_Request->get_int('province_ecng', 'post', '');
	$config_setting['district_ecng'] = $nv_Request->get_int('district_ecng', 'post', '');
	$config_setting['ward_ecng'] = $nv_Request->get_int('ward_ecng', 'post', '');
	$config_setting['address_ecng'] = $nv_Request->get_string('address_ecng', 'post', '');
	$config_setting['name_ecng'] = $nv_Request->get_string('name_ecng', 'post', '');
	$config_setting['phone_ecng'] = $nv_Request->get_string('phone_ecng', 'post', '');
	$config_setting['email_ecng'] = $nv_Request->get_string('email_ecng', 'post', '');

	$config_setting['form_email_khach'] = $nv_Request->get_string('form_khach', 'post', '');
	$config_setting['form_email_nha_ban'] = $nv_Request->get_string('form_nha_ban', 'post', '');
	$config_setting['url_ahamove'] = $nv_Request->get_string('url_ahamove', 'post', '');
	$config_setting['shop_id_ghn'] = $nv_Request->get_string('shop_id_ghn', 'post', '');
	$config_setting['voucher_maximum_percent'] = $nv_Request->get_string('voucher_maximum_percent', 'post', '');
	$config_setting['children_fund'] = $nv_Request->get_string('children_fund', 'post', '');
	//viettel post
	$config_setting['username_vtpost'] = $nv_Request->get_string('username_vtpost', 'post', '');
	$config_setting['password_vtpost'] = $nv_Request->get_string('password_vtpost', 'post', '');
	
	
	$config_setting['terms_of_use'] = $nv_Request->get_editor('terms_of_use', '', NV_ALLOWED_HTML_TAGS);
	$sth = $db_slave->prepare( 'UPDATE ' . TABLE . '_config SET config_value = :config_value WHERE config_name = :config_name');
	foreach( $config_setting as $config_name => $config_value )
	{
		$sth->bindParam( ':config_name', $config_name, PDO::PARAM_STR );
		$sth->bindParam( ':config_value', $config_value, PDO::PARAM_STR );
		$sth->execute();

	}
	$sth->closeCursor();


	$nv_Cache->delMod( $module_name );
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&rand=' . nv_genpass() );

	die();

}
if (defined('NV_EDITOR')) {
	require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$config_setting['terms_of_use'] = nv_htmlspecialchars(nv_editor_br2nl($config_setting['terms_of_use']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
	$config_setting['terms_of_use'] = nv_aleditor('terms_of_use', '100%', '300px', $config_setting['terms_of_use']);
} else {
	$config_setting['terms_of_use'] = '<textarea style="width:100%;height:300px" name="terms_of_use">' . $config_setting['terms_of_use'] . '</textarea>';
}

$xtpl = new XTemplate('config.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('DATA', $config_setting);
$list_email_form[] = array('id'=>'email_new_order_payment_khach', 'text'=>'Mẫu email 1');
$list_email_form[] = array('id'=>'email_new_order_payment_khach1', 'text'=>'Mẫu email 2');
$list_email_form[] = array('id'=>'email_new_order_payment_khach2', 'text'=>'Mẫu email 3');
$list_email_form[] = array('id'=>'email_new_order_payment_khach3', 'text'=>'Mẫu email 4');
$list_email_form[] = array('id'=>'email_new_order_payment_khach4', 'text'=>'Mẫu email 5');

$list_email_form_nha_ban[] = array('id'=>'email_new_order_payment', 'text'=>'Mẫu email 1');
$list_email_form_nha_ban[] = array('id'=>'email_new_order_payment1', 'text'=>'Mẫu email 2');
$list_email_form_nha_ban[] = array('id'=>'email_new_order_payment2', 'text'=>'Mẫu email 3');
$list_email_form_nha_ban[] = array('id'=>'email_new_order_payment3', 'text'=>'Mẫu email 4');
$list_email_form_nha_ban[] = array('id'=>'email_new_order_payment4', 'text'=>'Mẫu email 5');


 $list_province = get_province_select2('');

    foreach ($list_province as $value_list) {
        if($config_setting['province_ecng'] == $value_list['provinceid']){
            $value_list["selected"] = "selected";
        }
        $xtpl->assign( 'STATUS', $value_list);
        $xtpl->parse( 'main.province_id' );
    }

    $list_district = get_district_select2('',$config_setting['province_ecng']);

    foreach ($list_district as $value_list) {
        if($config_setting['district_ecng'] == $value_list['districtid']){
            $value_list["selected"] = "selected";
        }
        $xtpl->assign( 'STATUS', $value_list);
        $xtpl->parse( 'main.district_id' );
    }
    $list_ward = get_ward_select2('',$config_setting['district_ecng']);
    foreach ($list_ward as $value_list) {
        if($config_setting['ward_ecng'] == $value_list['wardid']){
            $value_list["selected"] = "selected";
        }
        $xtpl->assign( 'STATUS', $value_list);
        $xtpl->parse( 'main.ward_id' );
    }
	
	
foreach ($list_email_form_nha_ban as $key => $value) {
	if($config_setting['form_email_nha_ban'] == $value['id']){
		$value['check'] = 'selected';
	}else{
		$value['check'] = '';
	}
	$xtpl->assign('FORM1', $value);
	$xtpl->parse( 'main.form_nhaban' );
	}
foreach ($list_email_form as $key => $value) {
	if($config_setting['form_email_khach'] == $value['id']){
		$value['check'] = 'selected';
	}else{
		$value['check'] = '';
	}
	$xtpl->assign('FORM', $value);
	$xtpl->parse( 'main.form_khach' );
}


$inhome_viewcat[] = array( 'id'=>0, 'text'=>'Hiển thị dạng chuyên mục' );
$inhome_viewcat[] = array( 'id'=>1, 'text'=>'Hiển thị tất cả sản phẩm' );

foreach ( $inhome_viewcat as $filt_stt ) {
	if ( $filt_stt['id'] == $config_setting['inhome_viewcat'] ) {
		$filt_stt['selected'] = 'selected';
	}
	$xtpl->assign( 'inhome_viewcat', $filt_stt );
	$xtpl->parse( 'main.inhome_viewcat' );
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
