<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 04/18/2017 09:47
 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$payment = $nv_Request->get_string('id', 'post,get', '');
$value = $nv_Request->get_int('value', 'post,get', 0);

$table = TABLE . '_payment';
$contents = $lang_module['active_change_not_complete'];

if (! empty($payment)) {
    $stmt = $db->prepare('UPDATE ' . $table . ' SET is_= 0 ');
    $stmt->execute();
    $stmt = $db->prepare('UPDATE ' . $table . ' SET is_default=' . $value . ' WHERE payment= :payment');
    $stmt->bindParam(':payment', $payment, PDO::PARAM_STR);
    $content = "OK_" . $payment;
    $nv_Cache->delMod($payment);
}

$nv_Cache->delMod($module_name);

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';