<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS Holdings <contact@tms.vn>
 * @Copyright (C) 2020 TMS Holdings. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 21 Dec 2020 09:08:19 GMT
 */

if (!defined('NV_ADMIN'))
    die('Stop!!!');


$submenu['listorder']=$lang_module['order'];


$submenu['auditing'] = $lang_module['auditing'];
$submenu['order_punish_complain'] = $lang_module['order_punish_complain'];


$product=array();
$product['product_add']=$lang_module['product_add'];
$product['product_disable']=$lang_module['product_disable'];
$submenu['product']= array( 'title' => $lang_module['product'], 'submenu' => $product );

$submenu['category']=$lang_module['category'];

$seller_management=array();
$seller_management['seller_management_add']=$lang_module['seller_management_add'];
$submenu['seller_management']= array( 'title' => $lang_module['seller_management'], 'submenu' => $seller_management );

$voucher = array();
$voucher['voucher_add'] = $lang_module['voucher_add'];
$submenu['voucher'] = array('title' => $lang_module['voucher'], 'submenu' => $voucher );


$complain = array();
$complain['order_not_received'] = $lang_module['order_not_received'];
$complain['order_seller_delivery_failed'] = $lang_module['order_seller_delivery_failed'];
$submenu['complain_list'] = array('title' => $lang_module['complain'], 'submenu' => $complain );

//$submenu['order_not_received']=$lang_module['order_not_received'];
$submenu['transporters']=$lang_module['transporters'];
$submenu['static']=$lang_module['static'];
$submenu['customer']=$lang_module['customer'];
$submenu['registercontact']=$lang_module['registercontact'];
$submenu['order_punish_list']=$lang_module['order_punish_list'];
$submenu['vnpay_refund']=$lang_module['vnpay_refund'];
$submenu['history_vnpay']=$lang_module['history_vnpay'];
$submenu['history_vnpos']=$lang_module['history_vnpos'];





$config=array();
$config['unit']=$lang_module['unit'];
$config['brand']=$lang_module['brand'];
$config['origin']=$lang_module['origin'];
$config['unit_weight']=$lang_module['unit_weight'];
$config['unit_length']=$lang_module['unit_length'];
$config['unit_currency']=$lang_module['unit_currency'];
$config['block']=$lang_module['block'];
$config['tabs']=$lang_module['tabs'];
$config['bank']=$lang_module['bank'];
$config['status_vnpos']=$lang_module['status_vnpos'];
$config['status_ghn']=$lang_module['status_ghn'];
$config['status_error_ghn']=$lang_module['status_error_ghn'];
$config['complain_status']=$lang_module['complain_status'];
$config['penalize']=$lang_module['penalize'];
$config['payport']=$lang_module['setup_payment'];
$submenu['config']= array( 'title' => $lang_module['config'], 'submenu' => $config );