<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS <contact@tms.vn>
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 19 Feb 2021 09:11:21 GMT
 */

if (!defined('NV_ADMIN'))
    die('Stop!!!');

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_admins (admin_id, gid, add_time, update_time) VALUES('41', '0', '1612407578', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_admins (admin_id, gid, add_time, update_time) VALUES('45', '0', '1612507050', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_bank (bank_id, bank_code, name_bank, user_add, time_add, user_edit, time_edit, status, weight) VALUES('1', 'MB', 'Ngân Hàng Quân Đội MBANK', '1', '1609402982', '', '', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_bank (bank_id, bank_code, name_bank, user_add, time_add, user_edit, time_edit, status, weight) VALUES('2', 'NCB', 'Ngân Hàng Quốc Dân', '2', '1613703780', '', '', '1', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_bank_acount (id, acount_userid, acount_cccd, acount_date_range, acount_issued_by, acount_name, acount_number, acount_bankid, acount_bankbranch, user_add, time_add, user_edit, time_edit, status, weight) VALUES('1', '1', '042090000304', '10/10/2020', 'Cục Cảnh Sát', 'PHAN NGỌC ANH', '3030151588888', '1', 'Bắc Sài Gòn', '1', '1609403038', '', '', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_bank_acount (id, acount_userid, acount_cccd, acount_date_range, acount_issued_by, acount_name, acount_number, acount_bankid, acount_bankbranch, user_add, time_add, user_edit, time_edit, status, weight) VALUES('2', '1', '042090000304', '10/10/2019', 'Cục Cảnh Sát', 'Phan Ngọc Anh', '4040151588888', '1', 'Bắc Sài Gòn', '1', '1611390890', '', '', '1', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_bank_acount (id, acount_userid, acount_cccd, acount_date_range, acount_issued_by, acount_name, acount_number, acount_bankid, acount_bankbranch, user_add, time_add, user_edit, time_edit, status, weight) VALUES('3', '2', '236126126216', '12/02/1994', 'HCM', 'NGUYEN VAN A', '9704198526191432198', '2', 'NCB QUANG TRUNG', '2', '1613703902', '', '', '1', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_exchange (id, money_unit, than_unit, exchange_from, exchange_to, time_update, status) VALUES('1', 'USD', 'VND', '1', '22675', '1312000118', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_exchange (id, money_unit, than_unit, exchange_from, exchange_to, time_update, status) VALUES('2', 'VND', 'USD', '22675', '1', '1439725873', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money (userid, password, created_time, created_userid, status, money_unit, money_in, money_out, money_total, note, tokenkey) VALUES('1', '', '1609402896', '0', '1', 'VND', '510626345', '5525475', '505100870', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money (userid, password, created_time, created_userid, status, money_unit, money_in, money_out, money_total, note, tokenkey) VALUES('2', '', '1609550094', '0', '1', 'VND', '516805848', '2287605', '514518243', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money (userid, password, created_time, created_userid, status, money_unit, money_in, money_out, money_total, note, tokenkey) VALUES('3', '', '1612495875', '0', '1', 'VND', '50000', '0', '50000', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money (userid, password, created_time, created_userid, status, money_unit, money_in, money_out, money_total, note, tokenkey) VALUES('54', '', '1613636259', '0', '1', 'VND', '0', '0', '0', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money (userid, password, created_time, created_userid, status, money_unit, money_in, money_out, money_total, note, tokenkey) VALUES('55', '', '1613636460', '0', '1', 'VND', '0', '0', '0', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money_sys (id, code, currency) VALUES('704', 'VND', 'Vietnam Dong')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('1', 'exchange', '1', '', 'Giỏ hàng', 'E000001', '200000', 'VND', 'Q9BYI9P1I3SQPB48H1GQ', 'a:2:{s:2:\"op\";s:7:\"payment\";s:8:\"querystr\";s:73:\"order_id=1&payment=1&wpreturn=1&checksum=96f8a3d0428d1c9db163c047b349cedb\";}', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:66:\"order_id=1&updateorder=1&checksum=96f8a3d0428d1c9db163c047b349cedb\";}', '1609549919', '0', '0', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('2', 'exchange', '2', '', 'Giỏ hàng', 'E000001', '200000', 'VND', 'H8LNGZ2NBFLILMT7QAN0', 'a:2:{s:2:\"op\";s:7:\"payment\";s:8:\"querystr\";s:73:\"order_id=1&payment=1&wpreturn=1&checksum=96f8a3d0428d1c9db163c047b349cedb\";}', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:66:\"order_id=1&updateorder=1&checksum=96f8a3d0428d1c9db163c047b349cedb\";}', '1609549943', '0', '4', 'WP0000000006', '1609550112')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('3', 'exchange', '3', '', 'Giỏ hàng', 'E000003', '200000', 'VND', 'U08JN01W05EE2SPWNG8U', 'a:2:{s:2:\"op\";s:7:\"payment\";s:8:\"querystr\";s:73:\"order_id=3&payment=1&wpreturn=1&checksum=af2c362e8f577c199d035e3087545692\";}', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:66:\"order_id=3&updateorder=1&checksum=af2c362e8f577c199d035e3087545692\";}', '1609560987', '0', '0', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('4', 'exchange', '4', '', 'Giỏ hàng', 'E000004', '100000', 'VND', 'L7ITB21V1JUEVQ9F6FX0', 'a:2:{s:2:\"op\";s:7:\"payment\";s:8:\"querystr\";s:73:\"order_id=4&payment=1&wpreturn=1&checksum=86b212770b770cdc5a5954780e4e8080\";}', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:66:\"order_id=4&updateorder=1&checksum=86b212770b770cdc5a5954780e4e8080\";}', '1609561112', '0', '4', 'WP0000000007', '1609561122')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('5', 'exchange', '5', '', 'Giỏ hàng', 'E000005', '100000', 'VND', 'K7DY1S87UDCQRO0GMFQ1', 'a:2:{s:2:\"op\";s:7:\"payment\";s:8:\"querystr\";s:73:\"order_id=5&payment=1&wpreturn=1&checksum=523fc6b5c947ffd160ab4f110f4f61ca\";}', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:66:\"order_id=5&updateorder=1&checksum=523fc6b5c947ffd160ab4f110f4f61ca\";}', '1609587243', '0', '0', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('6', 'exchange', '6', '', 'Giỏ hàng', 'E000005', '100000', 'VND', 'O8KGXULATKP8U7FG5SM5', 'a:2:{s:2:\"op\";s:7:\"payment\";s:8:\"querystr\";s:73:\"order_id=5&payment=1&wpreturn=1&checksum=523fc6b5c947ffd160ab4f110f4f61ca\";}', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:66:\"order_id=5&updateorder=1&checksum=523fc6b5c947ffd160ab4f110f4f61ca\";}', '1609587281', '0', '0', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('7', 'exchange', '7', '', 'Giỏ hàng', 'E000006', '100000', 'VND', 'U5FRG9D46ZSIZ37GK1T7', 'a:2:{s:2:\"op\";s:7:\"payment\";s:8:\"querystr\";s:73:\"order_id=6&payment=1&wpreturn=1&checksum=90ae7f9e7924975c338cbf3676773b6e\";}', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:66:\"order_id=6&updateorder=1&checksum=90ae7f9e7924975c338cbf3676773b6e\";}', '1609725101', '0', '0', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('8', 'retails', '11', '', 'Thanh toán đơn hàng ngày 04/01/2021 16:23', 'Thanh toán đơn hàng ngày 04/01/2021 16:23', '7830594', 'VND', 'N632BPMJ6HNZF95Q64E0', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1609752212', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('9', 'retails', '12', '', 'Thanh toán đơn hàng ngày 04/01/2021 16:24', 'Thanh toán đơn hàng ngày 04/01/2021 16:24', '1017295', 'VND', 'P5SC5LWNVYXWL31W9N43', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1609752299', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('10', 'retails', '13', '', 'Thanh toán đơn hàng ngày 04/01/2021 16:26', 'Thanh toán đơn hàng ngày 04/01/2021 16:26', '1017295', 'VND', 'M4W05V8HQVL2CMYQF2JU', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1609752402', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('11', 'retails', '14', '', 'Thanh toán đơn hàng ngày 04/01/2021 16:33', 'Thanh toán đơn hàng ngày 04/01/2021 16:33', '1017295', 'VND', 'Q1042AIH3513RN65Q5H0', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1609752785', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('12', 'retails', '16', '', 'Thanh toán đơn hàng ngày 21/01/2021 14:42', 'Thanh toán đơn hàng ngày 21/01/2021 14:42', '168325', 'VND', 'I1YQ1J06MSE7E51WX17T', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1611214942', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('13', 'retails', '20', '', 'Thanh toán đơn hàng ngày 17/02/2021 15:28', 'Thanh toán đơn hàng ngày 17/02/2021 15:28', '50100', 'VND', 'Q616SQD6WH658UV23MVX', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1613550494', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('14', 'retails', '26', '', 'Thanh toán đơn hàng ngày 19/02/2021 08:52', 'Thanh toán đơn hàng ngày 19/02/2021 08:52', '114455', 'VND', 'F611LU0YB3TT4KOP7441', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1613699574', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('15', 'retails', '27', '', 'Thanh toán đơn hàng ngày 19/02/2021 08:56', 'Thanh toán đơn hàng ngày 19/02/2021 08:56', '81595', 'VND', 'X1FOWY8M5GR55E8S781W', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1613699802', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_orders (id, order_mod, order_id, order_message, order_object, order_name, money_amount, money_unit, secret_code, url_back, url_admin, add_time, update_time, paid_status, paid_id, paid_time) VALUES('16', 'retails', '28', '', 'Thanh toán đơn hàng ngày 19/02/2021 08:58', 'Thanh toán đơn hàng ngày 19/02/2021 08:58', '53015', 'VND', 'A59CE722BXQKYX3Z13JS', 'a:2:{s:2:\"op\";s:5:\"order\";s:8:\"querystr\";s:0:\"\";}', 'a:2:{s:2:\"op\";s:0:\"\";s:8:\"querystr\";s:0:\"\";}', '1613699927', '0', '4', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment (payment, paymentname, domain, active, weight, config, discount, discount_transaction, images_button, bodytext, term, currency_support, allowedoptionalmoney, active_completed_email, active_incomplete_email) VALUES('ATM', 'Thanh toán qua ATM', 'http://nukeviet.vn', '1', '1', 'YToxOntzOjE1OiJjb21wbGV0ZW1lc3NhZ2UiO3M6MTQwOiJUaMO0bmcgdGluIGPhu6dhIGLhuqFuIMSRw6MgxJHGsOG7o2MgZ2hpIG5o4bqtbi4gQ2jDum5nIHTDtGkgc-G6vSBraeG7g20gdHJhIGdpYW8gZOG7i2NoIG7DoHkgdHJvbmcgdGjhu51pIGdpYW4gc-G7m20gbmjhuqV0LiBYaW4gY-G6o20gxqFuISI7fQ,,', '2', '0', '/themes/default/images/wallet/pay-amt.jpg', '', '', 'VND', '1', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment (payment, paymentname, domain, active, weight, config, discount, discount_transaction, images_button, bodytext, term, currency_support, allowedoptionalmoney, active_completed_email, active_incomplete_email) VALUES('manual', 'Thanh toán tại công ty', 'http://nukeviet.vn', '1', '4', 'YToxOntzOjE1OiJjb21wbGV0ZW1lc3NhZ2UiO3M6MTM2OiJC4bqhbiDEkcOjIGzhu7FhIGNo4buNbiBow6xuaCB0aOG7qWMgdGhhbmggdG_DoW4gdHLhu7FjIHRp4bq_cCwgdnVpIGzDsm5nIMSR4bq_biBjw7RuZyB0eSDEkeG7gyBu4bqhcCB0aeG7gW4gdsOgIGhvw6BuIHThuqV0IHRoYW5oIHRvw6FuIjt9', '0', '0', '/themes/default/images/wallet/pay-manual.png', '', '', 'VND', '1', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment (payment, paymentname, domain, active, weight, config, discount, discount_transaction, images_button, bodytext, term, currency_support, allowedoptionalmoney, active_completed_email, active_incomplete_email) VALUES('onepaydomestic', 'Cổng thanh toán nội địa OnePay', 'http://www.onepay.vn/', '1', '2', 'YToxMDp7czoxMjoidnBjX01lcmNoYW50IjtzOjY6Ik9ORVBBWSI7czoxNDoidnBjX0FjY2Vzc0NvZGUiO3M6ODoiRDY3MzQyQzIiO3M6MTE6InZwY19WZXJzaW9uIjtzOjE6IjIiO3M6MTE6InZwY19Db21tYW5kIjtzOjM6InBheSI7czoxMDoidnBjX0xvY2FsZSI7czoyOiJ2biI7czoyMzoidmlydHVhbFBheW1lbnRDbGllbnRVUkwiO3M6NDA6Imh0dHBzOi8vbXRmLm9uZXBheS52bi9vbmVjb21tLXBheS92cGMub3AiO3M6MTM6InNlY3VyZV9zZWNyZXQiO3M6MzI6IkEzRUZERkFCQTg2NTNERjIzNDJFOERBQzI5QjUxQUYwIjtzOjExOiJRdWVyeURSX3VybCI7czo0MjoiaHR0cDovL210Zi5vbmVwYXkudm4vb25lY29tbS1wYXkvVnBjZHBzLm9wIjtzOjg6InZwY19Vc2VyIjtzOjQ6Im9wMDEiO3M6MTI6InZwY19QYXNzd29yZCI7czo4OiJvcDEyMzQ1NiI7fQ,,', '1', '1600', 'https://onepay.vn/onecomm-pay/img/onepay_logo.png', '', '', 'VND', '1', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment (payment, paymentname, domain, active, weight, config, discount, discount_transaction, images_button, bodytext, term, currency_support, allowedoptionalmoney, active_completed_email, active_incomplete_email) VALUES('vnpay', 'VNPAYQR', 'https://vnpay.vn/', '1', '5', 'YToxMDp7czoxMToidm5wX1RtbkNvZGUiO3M6ODoiMkU2RlNQVkwiO3M6MTQ6InZucF9IYXNoU2VjcmV0IjtzOjMyOiJNREFFSkhYVE1XV1ZIUklBREhaSkZaQ1VMRFdUUUxSWiI7czo3OiJ2bnBfVXJsIjtzOjQ5OiJodHRwOi8vc2FuZGJveC52bnBheW1lbnQudm4vcGF5bWVudHYyL3ZwY3BheS5odG1sIjtzOjExOiJ2bnBfVmVyc2lvbiI7czo1OiIyLjAuMCI7czoxMToidm5wX0NvbW1hbmQiO3M6MzoicGF5IjtzOjEyOiJ2bnBfQ3VyckNvZGUiO3M6MzoiVk5EIjtzOjk6InZucF9JUElQTiI7czoxMzoiMTQuMTYwLjg3LjEyNCI7czo4OiJJUE5BbGVydCI7czoxOiIxIjtzOjEzOiJJUE5BbGVydEVtYWlsIjtzOjA6IiI7czoxMjoiSVBOQWxlcnROb3RpIjtzOjE6IjEiO30,', '2.2', '0', '/themes/default/images/wallet/pay-vnpay.jpg', '', '', 'VND', '1', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment (payment, paymentname, domain, active, weight, config, discount, discount_transaction, images_button, bodytext, term, currency_support, allowedoptionalmoney, active_completed_email, active_incomplete_email) VALUES('vnptepay', 'VNPT EBAY', 'http://vnptepay.com.vn/', '1', '3', 'YTo2OntzOjExOiJtX1BhcnRuZXJJRCI7czoxMDoiY2hhcmdpbmcwMSI7czo2OiJtX01QSU4iO3M6OToicGFqd3RsemNiIjtzOjEwOiJtX1VzZXJOYW1lIjtzOjEwOiJjaGFyZ2luZzAxIjtzOjY6Im1fUGFzcyI7czo5OiJnbXd0d2pmd3MiO3M6MTM6Im1fUGFydG5lckNvZGUiO3M6NToiMDA0NzciO3M6MTA6IndlYnNlcnZpY2UiO3M6ODQ6Imh0dHA6Ly9jaGFyZ2luZy10ZXN0Lm1lZ2FwYXkubmV0LnZuOjEwMDAxL0NhcmRDaGFyZ2luZ0dXX1YyLjAvc2VydmljZXMvU2VydmljZXM_d3NkbCI7fQ,,', '0', '0', 'http://vnptepay.com.vn/public/theme/images/logo.png', '', '', 'VND', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment_discount (payment, revenue_from, revenue_to, provider, discount) VALUES('vnptepay', '1', '1000000', 'FPT', '10')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment_discount (payment, revenue_from, revenue_to, provider, discount) VALUES('vnptepay', '1', '1000000', 'MGC', '10')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment_discount (payment, revenue_from, revenue_to, provider, discount) VALUES('vnptepay', '1', '1000000', 'VMS', '10')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment_discount (payment, revenue_from, revenue_to, provider, discount) VALUES('vnptepay', '1', '1000000', 'VNP', '10')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment_discount (payment, revenue_from, revenue_to, provider, discount) VALUES('vnptepay', '1', '1000000', 'VTC', '10')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_payment_discount (payment, revenue_from, revenue_to, provider, discount) VALUES('vnptepay', '1', '1000000', 'VTT', '10')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('1', '1609402887', '1', 'VND', '10000000', '10000000', '', '0', '10000000', '1', '0', '0', '1', 'Phan Ngọc Anh', 'info@tms.vn', '0904999955', '0904999955', '', '', '-1', '4', '1609402896', '0904999955', '', 'manual', '', '297184c102f403860dd8672f85994bf7', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('2', '1609403126', '2', 'VND', '5011000', '5000000', '11000', '0', '5011000', '1', '0', '0', '1', 'PHAN NGỌC ANH', 'info@tms.vn', '0904999955', '', '', '', '-1', '6', '1609403142', 'Yêu cầu rút tiền về tài khoản  3030151588888 Ngân Hàng Quân Đội MBANK ,Chi nhánh: Bắc Sài Gòn', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('3', '1609549986', '1', 'VND', '500000000', '500000000', '', '0', '500000000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'thanhdat@tms.vn', '', '', '', '', '-1', '4', '1609549986', 'test', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('4', '1609549997', '1', 'VND', '500000000', '500000000', '', '0', '500000000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'thanhdat@tms.vn', '', '', '', '', '-1', '4', '1609549997', 'test', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('5', '1609550094', '1', 'VND', '500000000', '500000000', '', '0', '500000000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'thanhdat@tms.vn', '', '', '', '', '-1', '4', '1609550094', 'test', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('6', '1609550112', '-1', 'VND', '200000', '200000', '', '0', '200000', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1609550112', 'Thanh toán Giỏ hàng E000001', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('7', '1609561122', '-1', 'VND', '100000', '100000', '', '0', '100000', '1', '0', '0', '1', '', '', '', '', '', '', '-1', '4', '1609561122', 'Thanh toán Giỏ hàng E000004', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('8', '1609587260', '-1', 'VND', '0', '100000', '', '0', '100000', '1', '0', '5', '1', 'Phan Ngọc Anh', 'info@tms.vn', '', '', '', '', '-1', '0', '0', 'Thanh toán đơn hàng mã số DH0000000005', '', 'vnpay', '', '9090a3c046ab7c45569966844545e946', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('9', '1609587285', '-1', 'VND', '0', '100000', '', '1601600', '-1501600', '1', '0', '6', '1', 'Phan Ngọc Anh', 'info@tms.vn', '', '', '', '', '-1', '0', '0', 'Thanh toán đơn hàng mã số DH0000000006', '', 'onepaydomestic', '', 'a0413c86cdeca09c7dba8c15af79567a', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('10', '1609752146', '1', 'VND', '7830594', '7830594', '', '0', '7830594', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1609752146', '2', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('11', '1609752212', '1', 'VND', '7830594', '7830594', '', '0', '7830594', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1609752212', '2', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('12', '1609752299', '1', 'VND', '1017295', '1017295', '', '0', '1017295', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1609752299', '2', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('13', '1609752402', '-1', 'VND', '1017295', '1017295', '', '0', '1017295', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1609752402', 'Thanh toán đơn hàng ngày 04/01/2021 16:26', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('14', '1609752785', '-1', 'VND', '1017295', '1017295', '', '0', '1017295', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1609752785', 'Thanh toán đơn hàng ngày 04/01/2021 16:33', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('15', '1611137557', '1', 'VND', '50000', '50000', '', '0', '50000', '1', '0', '0', '1', 'Phan Ngọc Anh', 'info@tms.vn', '7687686', 'fdgdf', '', '', '-1', '0', '0', 'fdgdf', '', 'vnpay', '', '362be2e828dda1d987c6a4663e766682', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('16', '1611214942', '-1', 'VND', '168325', '168325', '', '0', '168325', '1', '0', '0', '1', '', '', '', '', '', '', '-1', '4', '1611214942', 'Thanh toán đơn hàng ngày 21/01/2021 14:42', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('17', '1612490612', '1', 'VND', '1000000', '1000000', '', '0', '1000000', '39', '0', '0', '39', 'Lee Sin', 'vfsdai13@gmail.com', '0564321326', '17 Bạch Đằng', '', '', '-1', '1', '1612490612', '8645', 'a:7:{s:12:\"atm_sendbank\";s:13:\"fsdfgrfadsb g\";s:9:\"atm_fracc\";s:14:\"78658765324387\";s:8:\"atm_time\";s:10:\"12:21:2121\";s:9:\"atm_toacc\";s:10:\"5461323783\";s:12:\"atm_recvbank\";s:19:\"fwerq gfas re ưera\";s:14:\"atm_filedepute\";s:83:\"samsung galaxy s21 ultra black 400x400.jpg|0ac90db448997dc22809a436f49b8541de5784a1\";s:12:\"atm_filebill\";s:82:\"realme c15 xanh duong 600x600 600x600.jpg|690a5e4e3925909fbf6cf8da424805b2853c5484\";}', 'ATM', '', '56ec6a44c15b6f026785c3f7cb1cca7e', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('18', '1612495616', '1', 'VND', '500000000', '500000000', '', '0', '500000000', '1', '0', '0', '38', 'Phan Anh', 'anhnhim123@gmail.com', '', '', '', '', '-1', '4', '1612495616', 'giao dịch na&#91;pj tiền', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('19', '1612495821', '1', 'VND', '50000', '50000', '', '0', '50000', '3', '0', '0', '3', 'Cảnh Bình', 'thachcanhbinh@gmail.com', '0384756475', 'dfsdf', '', '', '-1', '4', '1612495875', 'vcbfcvbfc', '', 'manual', '', '8b2766ab6a060d0e18219a7acf774aa6', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('20', '1613550494', '-1', 'VND', '50100', '50100', '', '0', '50100', '1', '0', '0', '1', '', '', '', '', '', '', '-1', '4', '1613550494', 'Thanh toán đơn hàng ngày 17/02/2021 15:28', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('21', '1613641553', '1', 'VND', '74350', '74350', '', '0', '74350', '2', '0', '0', '48', '', '', '', '', '', '', '-1', '4', '1613641553', 'Cộng tiền thanh toán đơn hàng với mã đơn hàng TMS000011', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('22', '1613641771', '1', 'VND', '74350', '74350', '', '0', '74350', '48', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1613641771', 'Cộng tiền thanh toán đơn hàng với mã đơn hàng TMS000011', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('23', '1613641996', '1', 'VND', '74350', '74350', '', '0', '74350', '48', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1613641996', 'Cộng tiền thanh toán đơn hàng với mã đơn hàng TMS000011', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('24', '1613642753', '1', 'VND', '626345', '626345', '', '0', '626345', '1', '0', '0', '1', '', '', '', '', '', '', '-1', '4', '1613642753', 'Cộng tiền thanh toán đơn hàng với mã đơn hàng TMS00009', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('25', '1613642859', '1', 'VND', '23750', '23750', '', '0', '23750', '48', '0', '0', '1', '', '', '', '', '', '', '-1', '4', '1613642859', 'Cộng tiền thanh toán đơn hàng với mã đơn hàng DHT00001', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('26', '1613699574', '-1', 'VND', '114455', '114455', '', '0', '114455', '1', '0', '0', '1', '', '', '', '', '', '', '-1', '4', '1613699574', 'Thanh toán đơn hàng ngày 19/02/2021 08:52', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('27', '1613699802', '-1', 'VND', '81595', '81595', '', '0', '81595', '1', '0', '0', '1', '', '', '', '', '', '', '-1', '4', '1613699802', 'Thanh toán đơn hàng ngày 19/02/2021 08:56', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('28', '1613699927', '-1', 'VND', '53015', '53015', '', '0', '53015', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1613699927', 'Thanh toán đơn hàng ngày 19/02/2021 08:58', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('29', '1613700111', '1', 'VND', '53015', '53015', '', '0', '53015', '2', '0', '0', '2', '', '', '', '', '', '', '-1', '4', '1613700111', 'Cộng tiền đơn hàng hủy với mã đơn hàng TMS000014', '', '', '', '', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('30', '1613703062', '1', 'VND', '500000', '500000', '', '0', '500000', '1', '0', '0', '1', 'Phan Ngọc Anh', 'info@tms.vn', '0904999955', 'fdfg', '', '', '-1', '0', '0', 'dsdf', '', 'vnpay', '', 'fffcd6356b262d9947baf28823be277e', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('31', '1613703089', '1', 'VND', '500000', '500000', '', '0', '500000', '1', '0', '0', '1', 'Phan Ngọc Anh', 'info@tms.vn', '0904999955', 'fdfg', '', '', '-1', '0', '0', 'dsdf', '', 'vnpay', '', '2eb32f00d31a67936d270fcccb4debe5', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('32', '1613724911', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', 'a543501a3c708a6f17e9446618459607', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('33', '1613724964', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', 'e820cb5d889dcc00728f1f16a21a8722', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('34', '1613724993', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', 'c0448ebb9e2888dff6994ee9754ac7f8', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('35', '1613725030', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', 'ca09d7904f0c6fc7ca79326d6849e766', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('36', '1613725101', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', 'd1f90d1a3011d86afbd04468487ef8b2', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('37', '1613725173', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '775187abee6cab033fe397516cdb2f2a', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('38', '1613725259', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '28d25dab795dd77edd80a15caabf5b67', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('39', '1613725285', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'test', '', 'vnpay', '', '09f75d59fffb1a9fcd37ded690d22c5b', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('40', '1613725332', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', 'a88698b7c5f5fa1d9437662c46d849f1', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('41', '1613725353', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '564164b8d778a946973a4a77d8512d80', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('42', '1613725376', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '6b07ba01b0ce86528c0be24286ddb124', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('43', '1613725408', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '490a31a0bae8acfbd54273588c3f6c6e', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('44', '1613725432', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '06e586635b31222ee91ee2f9dc397c1a', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('45', '1613725471', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '7b6ca21553c459d4a3737519b0b2c012', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('46', '1613725483', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '3784dfed39aec8b6acef2c655e447246', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('47', '1613725525', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '374a3720abfa4be4a17b4fc44a57975a', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('48', '1613725640', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '104cac1ffd1db6efb959b29f44747022', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('49', '1613725660', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '75e6630b065164d36f8cf21c9d352308', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('50', '1613725699', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '9dab31b2acfa8ac2809b0eab2f06ba99', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('51', '1613725738', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '662bf94afe8edb04128c0c97de95d572', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('52', '1613725760', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '9d006f063eae5e68711c3caeaa78dd24', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('53', '1613725770', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', 'efe37ea50c0a4088784a68a2fc0b741c', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_transaction (id, created_time, status, money_unit, money_total, money_net, money_fees, money_discount, money_revenue, userid, adminid, order_id, customer_id, customer_name, customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time, transaction_info, transaction_data, payment, provider, tokenkey, is_expired) VALUES('54', '1613725795', '1', 'VND', '50000', '50000', '', '0', '50000', '2', '0', '0', '2', 'Đặng Thành Đạt', 'bnhthach@gmail.com', '0374973039', '950/43 Nguyễn Kiệm', '', '', '-1', '0', '0', 'Nạp tiền vào tài khoản qua cổng vnpay', '', 'vnpay', '', '60df34d6cbb0004a63717b8b211caf45', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_withdrawal (id, transaction_id, userid, acount_cccd, acount_date_range, acount_issued_by, acount_name, acount_number, acount_bankid, acount_bankbranch, weight) VALUES('1', '2', '1', '042090000304', '10/10/2020', 'Cục Cảnh Sát', 'PHAN NGỌC ANH', '3030151588888', 'Ngân Hàng Quân Đội MBANK', 'Bắc Sài Gòn', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_withdrawal (id, transaction_id, userid, acount_cccd, acount_date_range, acount_issued_by, acount_name, acount_number, acount_bankid, acount_bankbranch, weight) VALUES('2', '', '1', '042090000304', '10/10/2020', 'Cục Cảnh Sát', 'PHAN NGỌC ANH', '3030151588888', 'Ngân Hàng Quân Đội MBANK', 'Bắc Sài Gòn', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_withdrawal (id, transaction_id, userid, acount_cccd, acount_date_range, acount_issued_by, acount_name, acount_number, acount_bankid, acount_bankbranch, weight) VALUES('3', '', '1', '042090000304', '10/10/2020', 'Cục Cảnh Sát', 'PHAN NGỌC ANH', '3030151588888', 'Ngân Hàng Quân Đội MBANK', 'Bắc Sài Gòn', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
