<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS Holdings <contact@tms.vn>
 * @Copyright (C) 2020 TMS Holdings. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 21 Dec 2020 09:08:19 GMT
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$module_version = array(
    'name' => 'retails',
    'modfuncs' => 'main,detail,search,ajax,viewcat,cart,order,vieworder,ordercustomer,viewcatshops,follow,wishlist,address,vnpay_inp,payment,categories,re-payment,complain,complain-list,complain-view,complain-vandon,cronjob,landingpage,product-shock,voucher-wallet,check-order',
    'change_alias' => 'main,detail,search,viewcat,cart,order,vieworder,ordercustomer,viewcatshops,follow,wishlist,cronjob,landingpage,product-shock,voucher-wallet,check-order',
    'submenu' => 'ordercustomer,address,follow, wishlist,address,landingpage,product-shock,voucher-wallet,check-order',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.3.03',
    'date' => 'Mon, 21 Dec 2020 09:08:19 GMT',
    'author' => 'TMS Holdings (contact@tms.vn)',
    'uploads_dir' => array(
        $module_upload,
        $module_upload . '/business_license',
        $module_upload . '/transporters',
        $module_upload . '/tab',
        $module_upload . '/' . date('Y_m')
    ),
    'note' => ''
);
