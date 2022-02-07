<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS <contact@tms.vn>
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 19 Feb 2021 09:53:45 GMT
 */

if (!defined('NV_ADMIN'))
    die('Stop!!!');

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('1', '1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '{SSHA512}OFEpSckDHqt01ikVpOrn+KVYwlcSzTHvftoPi/8jTkA/PBTbN96w4NGMzwIEJ5xOHXbwuWCgB1Eevprcyklr2WVmNDc=', 'info@tms.vn', 'Phan Ngọc Anh', '', 'N', '', '0', '', '1608515732', 'admin', 'admin', '', '0', '1', '1,4', '1', '0', '', '81d6df817a96d4f7dd48a7c9babfc79b', '1613531135', '171.235.54.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '', '1609052048', '0', '0', '', '-3', 'SYSTEM', '0904999955')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('2', '2', 'tmsdat', '576f95db48001b6f62e7103f37019a7f', '{SSHA512}rtHX4aeLkh7u1eKopmOWdSshf1TVuAwdW/YNwqdqKuiy2dA+Zbet+dZc0wjO8c+Fz/la8XGzrt0cqSwSTymiTmE5NDM=', 'thanhdat@tms.vn', 'Đặng Thành Đạt', '', '', '', '0', '', '1608516743', 'tmsdat', 'tmsdat', '', '0', '1', '4,2', '1', '0', '', 'c4a5a964b00c80df976cf82183b6f917', '1613552563', '42.113.81.194', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('3', '2', 'tmsbinh', '57a8805a1c5e6abbfad3ada275da6df9', '{SSHA512}0QvVggj0vk8CgKgxYMVBnL5UwOSVjRssVBEd7Cf6CE9s3XCLyjZBff94EZZQjcNoWr1v7d6r9sZ6Q3S2nzCXZmJjMGM=', 'canhbinh@tms.vn', 'Cảnh Bình', '', '', '', '0', '', '1608516772', 'tmsbinh', 'tmsbinh', '', '0', '1', '4,2', '1', '0', '', 'e11ed100cc45b5db780c8eb6d18512e3', '1611904942', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('27', '0', 'canhbinh23', '01954282515999845bdadb074c0a6ad1', '{SSHA512}ARK/ckb5ZawE7BA1WQTYR1ISJLqFs9Xe3lkQUtE8A4ZTDoQRayDcqGvDIznsB3vCp9+cjdn8B8N+QfB//+yY4mM5YmM=', '', 'Nguyen Cong Quoc', '', 'M', '', '0', '', '1610702828', '', '', '', '0', '1', '', '1', '0', '', '67d79a303224960ca0753da2800adee7', '1612319653', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('18', '0', 'thachcanhbinh23', '7d5bfbd130858c588fc856adbf7d6405', '{SSHA512}u0kWe6E06RK6Vi3O0VDx6qVgrEOJIZQZNTdY+K+A4H+PxbO1mlBwSbEUZ6zl65WyceXg3ycKvBA07A7wLMOAD2NhNDM=', 'thachcanhbinh23@tms.vn', 'Thạch Cảnh Bình', '', 'M', '', '0', '', '1609379079', '', '', '', '0', '1', '', '1', '0', '', 'd9b38553656339e8866c831185bf5a8d', '1609379111', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('20', '0', 'thachcanhbinhtest23', '9f805ed695a28cb58064834ea2d960eb', '{SSHA512}wvd35F1YiYcS93RWmUZnXJHUsd92mt8kbm8JXGx8d/iYRu6Drn+CsgbyH4Vgca2H6ENz32mvxzGne6BLwN4xMjc3OGM=', 'thachcanhbinhtest23@tms.vn', 'Nguyen Cong Quoc', '', 'M', '', '0', '', '1609382937', '', '', '', '0', '1', '', '1', '0', '', 'e38bb09f5fa62e4f9266d8764a41208a', '1609919099', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('21', '0', 'thanhdat97', 'ec6fd5ddf69e0639e7547a5e2d9b6ee8', '{SSHA512}aCAZ95RLosFhjtgL0lTusaNXegPi+8QJIIeh7XGRTPplpRSgWYXKzKJfnQwXM3+2cKX5DkfAObnIMU/KRw48xDI1NzY=', 'thanhdat97@tms.vn', 'Đặng Thành Đạt', '', 'M', '', '0', '', '1609383141', '', '', '', '0', '1', '', '1', '0', '', '9b502be48aaeca25d3b12f2323a8431c', '1609928721', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0903-311-901')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('22', '2', 'thuytms', '48e98d7e9056c789395ba92f48650860', '{SSHA512}ZhUToLLTM+68b7EH5Wg9E2djVf0NtI0BK6flUwMQlBjpA96BZnLkK/aAb4c8GMKQmIclVQDI1EaVsOAICOqTuWY0Y2M=', 'thuthuy@tms.vn', 'Thủy', 'Thu', '', '', '0', '', '1609722614', 'thuytms', 'thuytms', '', '0', '1', '4,2', '1', '0', '', '15feababc6fc18d310c2543a02f34172', '1609722614', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('23', '0', 'nguoibanhang', 'dd1afad268d5f5b2a01472d101162b88', '{SSHA512}pny8qCM61uOI7cR0P5kgO8Efl0ZsGQ/wNorDBdBTKxn0Z6qg1EaiQeGyGOP5P88PC+zMjIAiGCRPUcbzh9X+MzE3ZTQ=', 'nguoibanhang@tms.vn', 'Phan Ngọc Anh', '', 'M', '', '0', '', '1609733840', '', '', '', '0', '1', '', '1', '0', '', '7e68c8499508e6e671e219f896583ee5', '1612319735', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0975-888-549')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('24', '0', 'binhthach111', 'e6119a385edf530ba3ce3a13845d560f', '{SSHA512}ACY0QsVSa4qmK+B7xzuCs/mMYcLrFqElRkLK/NHfSjcPTcn7MphWfpzw+CmeYaTlUmrvT89c4VgqhFas+NCBSDA5ZmE=', 'binhthach111@gmail.com', 'thạch cảnh bình', '', 'M', '', '0', '', '1610183158', '', '', '', '0', '1', '', '1', '0', '', '5b9bd71e71015bcefec60f85ce35b854', '1610183158', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/91.0.146 Chrome/85.0.4183.146 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-973-038')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('25', '2', 'diemtms', '6d072c8d45de7a086c7599214df5727b', '{SSHA512}FdOCW3AAIl4heYfVH3B/toJcYNVfiXEExOivKrsh0MN45sDOYQo2Z+SGFV57wFOqxA/E2Utj0Sdv0IM4fS8qkzk4NjU=', 'diemtms@gmail.com', 'diemtms', 'diemtms', '', '', '0', '', '1610412377', 'diemtms', 'diemtms', '', '0', '1', '4,2', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('36', '0', 'binhcanh123', '0b7758ee17871c264c371e60551f56ab', '{SSHA512}JWG4w1LaRcLoN0PC0am6HVBSSDXabsule3rxmYHj4kW7iMwZpt+TBWarB2yp8r2sqCENrtW2BfsWYsawiE2mSTk0ZGU=', 'binhcanh123@gmail.com', 'thạch cảnh bìnhsad', '', 'M', '', '0', '', '1611281590', '', '', '', '0', '1', '', '1', '0', '', 'f569469c8d46f48a9e09095087d3ae6e', '1611364938', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-658-475')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('28', '0', 'datmap', '12ec0b062ca1e58efe426634e5de8772', '{SSHA512}0Cm/ntcKfo4Wny1nHAt73Ny+MbvZmAwn7zMeaVn1lA61VZK2FhnMxon6rMxqGE60qI6JhdIHUBrb4/C7HGswWDhjMDY=', 'dangthandshdat@gmail.com', 'Hoạt động', '', 'M', '', '0', '', '1611131785', '', '', '', '0', '1', '', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '0', 'SYSTEM', '0274-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('29', '0', 'canhbinh21515', 'da8186e134a7cbd88a634ff9ad21f9fa', '{SSHA512}+c1ckKmU5Lm6hIoEwVH8cTEGDdOvREgyAXlCWs3DI1tcEI6YgSjUzWmUi6Q7ridD0iFjJ08EbyJwPC+QWEzpV2NhY2U=', 'canhbinh21515@gmail.com', 'Nguyen Cong Quoc', '', 'M', '', '0', '', '1611131938', '', '', '', '0', '1', '', '1', '0', '', 'dfbfe37ae8a02b1897c79d3e34897f60', '1611131938', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-797-301')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('30', '0', 'datmap12345', 'b83df13a08dca0bc6366b7d91c1ebbd7', '{SSHA512}v6ouxaWFajtcNNTsj0pJzTAb+7V8+WCsEWaAWn2oItUZoWDvbDW+rrYPG241h1/DiM5uhNxfnCF55M/u2UhqQmNkNmY=', 'dangthandsdfdsshdat@gmail.com', 'Hoạt động', '', 'M', '', '0', '', '1611133003', '', '', '', '0', '1', '', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '0', 'SYSTEM', '0274-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('31', '0', 'hangnguyen123', '07caec62c03d9a3d2e6c9ae5385ae7a9', '{SSHA512}xyrErT8PMhjIyuFBVjoyddc2J8k07kZFfysBH72NyjLaliJBuZSLddNXdKRAgR7mBI4y3yhX9aFmP/Y8N/i6TzhhMjc=', 'dangtasddshdat@gmail.com', 'Hoạt động', '', 'M', '', '0', '', '1611133295', '', '', '', '0', '1', '', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '0', 'SYSTEM', '0274-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('32', '0', 'datmap12345236526', '810a6e8e949237667cac602f16cd30d1', '{SSHA512}11iO/h1s4p03ZmBv6wL/2/J7Hv1GxLmyWfZetLs6gBog1QT4cWl20knCD887tIzoSPy83vB+YvyrUjb80qk7ujg5NDI=', 'dangthandshdat12515@gmail.com', 'Hoạt động', '', 'M', '', '0', '', '1611133363', '', '', '', '0', '1', '', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '0', 'SYSTEM', '0274-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('33', '0', 'datmap12345gfg', '670c08e1604889ce6da66f5e9f916156', '{SSHA512}d2v9uW0HkPRx0OFk//NGfOWS+qCiO/dpJYIbaSLOlqyNTxIiLicrbGUuYEWX6Kys8VFYQ/TM80Ndc8vSxA6+92JhMTQ=', 'dangthandshdatgdg@gmail.com', 'Hoạt động', '', 'M', '', '0', '', '1611133426', '', '', '', '0', '1', '', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '0', 'SYSTEM', '0274-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('34', '0', 'hangnguyen555', '9457b0f2c6c1e131869200404b8941bc', '{SSHA512}ARK/ckb5ZawE7BA1WQTYR1ISJLqFs9Xe3lkQUtE8A4ZTDoQRayDcqGvDIznsB3vCp9+cjdn8B8N+QfB//+yY4mM5YmM=', 'dangthansadsaddshdat@gmail.com', 'Hoạt động', '', 'M', '', '0', '', '1611133537', '', '', '', '0', '1', '', '1', '0', '', 'b7b743f3de3f5c76316e34c8078e898d', '1613610875', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-973-039')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('35', '2', 'tmscity', '84a5d8b2c2fce50c7a02d3c684a353de', '{SSHA512}q9f9VSD3/4LDdbTDZgYNhUVZMFoxwREmAFUGitjVEi12Nm/eOAT58lWs4Ug8RS8OwZUxQsKML4o9K8NgseU7rWM3NWY=', 'tmscity@tms.vn', 'tmscity', '', 'N', '', '0', '', '1611217020', 'tmscity', 'tmscity', '', '0', '1', '2,4', '1', '0', '', '', '0', '', '', '', '1612319275', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('37', '2', 'hangtms', '80d68d48a332158f30c982702df6ba84', '{SSHA512}GfRG0zNflDH8NQhnR2jWfMHCdU0CLM41CORoy+XxYnQeQRRYXIf5DxkBiUYE29Phc0s656ZFosvGrxUhB+QNU2FmNGQ=', 'thanhhang@tms.vn', 'hangtms', '', '', '', '0', '', '1611363993', 'hangtms', 'hangtms', '', '0', '1', '4,2', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('38', '0', 'taikhoanmau', '68c2691e0567021d698e4dbf7e50b821', '{SSHA512}koNP+JStaC2Yw2fbwQR5ctQnZz5xcMBOJyIZvTZ/hHRupg0EBrqQRPzx72AJzyR2VU+iJgqGD3Ul6G1IvrPDC2Y0MDM=', 'anhnhim123@gmail.com', 'Phan Anh', '', 'M', '', '0', '', '1612319945', '', '', '', '0', '1', '', '1', '0', '', '26ee454334d23cfff399c6ee6237b974', '1612494951', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0384-756-475')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('39', '4', 'leevansin', '31121d8c21fb5d8153be0d3175026238', '{SSHA512}lYCuP2xmB8l0eVTc+UNTyEOX8TRNg57DtBgR6+nr/eBDZ6jvwZiIsXLdMJAA46hsfE3i6ejcuX65SIZ9wllL3DRlOGE=', 'vohoatoi123@gmail.com', 'Sin', 'Lee', '', '', '0', '', '1612363820', 'Quê ngoại của bạn ở đâu', 'toi', '', '0', '1', '4', '1', '0', '', 'b356e01526c687f4a6016c97433e80ec', '1612497619', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.146 Safari/537.36', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('40', '0', 'vohoatoi147', 'ae5f5ed815157a2539fabcdb13770fe9', '{SSHA512}pSLo5LDz4/MpzLNCTJA1vaS88rw7o6StAX9d2YioeuF2OwKv00ZYLEGxQ/zlEDStx6F3zxUxbrzM0NAotY4z+mNhYmQ=', 'vohoatoi147@gmail.com', 'Nguyễn Văn A', '', 'M', '', '0', '', '1612367291', '', '', '', '0', '1', '', '1', '0', '', '71f6ef4c5a702241c276f6afbea3293f', '1612497663', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.146 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0416-432-532')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('41', '3', 'thanhcao', '92eb4dbc81a6cf5c63edca327dde8ac6', '{SSHA512}KFtuVTdWwlQxJm8Xpp9ol1bwob6GOJznRvQAJPP/lyQS9nk6gkIr25PzRaL2kj2hZA2E66RzcGZyX/sDQQbdhzdmYWU=', 'thanhcao@gmail.com', 'cao', 'thanh', 'N', '', '0', '', '1612407563', 'ban tne gi', 'cao', '', '0', '1', '3,4', '1', '0', '', 'f119c857b6e5b1fc88d1a139bbb6ce29', '1612420980', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36', '', '1612420966', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('46', '0', 'LaKa', '1440ed9245a9362264e38af2a774f162', '{SSHA512}IV45voNYgS+a9opMeQgvent6KYkg0IHRsFmE2gZJScOuJaHql1ILCjG/+jcyTH64LA1ww494tfkO7HjAOpxgxmMzMzk=', 'thanhcao.laka@gmail.com', 'Thanh Cao', 'Lê Thị', 'F', 'uploads/users/133365547_3567724409930874_999855634624491457_n_n0v5e1tc_46.png', '901558800', 'LaKa', '1612511528', '', '', '', '1', '1', '', '1', '0', 'W4CJPR6OIDT4YXPJ', '7839c6dc7c412ff19e27c86927f2588f', '1612511528', '42.113.189.136', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '1612512788', '0', '0', '', '0', 'SYSTEM', '0355-020-828')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('43', '0', 'binhthach12345678', 'c3b7b11a8e834bfd0b4964c03464f166', '{SSHA512}pmMezdxubicVXGr9aku/5GtgHZi5bsG1ArwkvX2ZUitD5cnL6jrkzG9YwKUjr6qGi0qCyHwawKshSmEn4LXiODRhMDU=', 'binhthach12345678@gmail.com', 'thachj canhr binhf', '', 'M', '', '0', '', '1612497908', '', '', '', '0', '1', '', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '0', 'SYSTEM', '5465-465-465')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('44', '0', 'binhthach12345678231421', '442e51807d1af8b0364f7616dd282bc4', '{SSHA512}YZN8UCKcZ38MXUBLfu3g0pd/lu8Gdvouvby6pLGhfB40O4DMnQcSiEj74RY2QsQfFoLCB6vyxiIzypnTkx1AMmNkY2E=', 'binhthach12dfssxzcsadsf345678@gmail.com', 'thachj canhr binhf', '', 'M', '', '0', '', '1612498109', '', '', '', '0', '1', '', '1', '0', '', '993d2dbcd5b98e63ff59c66d33fc46f9', '1612498109', '171.227.214.244', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0984-465-467')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('45', '3', 'thanhcao1', 'ba4c933c0be7e1eb08f9c4df18234e44', '{SSHA512}q44AznN6Mkzb09f4+hVet647JQQHjJL6VZThW5aXb86rZqslFIFi0cuijl6dXCix/UO6k8GG1eiWDMtSLq3tuGNiMmU=', 'vfsdai13@gmail.com', 'sa', 'ád', '', '', '0', '', '1612507034', 'Bạn biết gì về NukeViet 4?65132', 'dsa', '', '0', '1', '4,3', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('47', '4', 'Jaisy', '14d7b2408f4e02fe98aed6eef301621f', '{SSHA512}2CmmMGn+6Tlw4Wd6H7BytG/pbCtyVy6P5BpQO/IMSmtaIXv3MUZoMlaJCcFN4r46kdz3sYMFRU7XB7+W12c8Z2FjNDI=', 'baotran112381@gmail.com', 'Trân', 'Bảo', '', '', '1045501200', '', '1612512146', 'Bạn thích môn thể thao nào nhất', 'bóng rổ', '', '0', '1', '4', '1', '0', 'KOMDWVN2WHNRUD63', 'e2c709ec8d8ca4fdf7ee361364338dda', '1612574763', '42.113.189.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36', '', '1612577933', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('48', '4', 'nhangmoc', 'c900a9221e848e4f1930a2bb1de0081e', '{SSHA512}/OCtplBLj9z0jobuqIQB0QRvt0xDeIaZXvGSDx9FgZ6zAiBl35zIKIlyp3aKtsV67YjAkanBdUU8mfZ4/arcVzlkYTE=', 'nhangmoc@gmail.com', 'Phan Ngọc Anh', '', 'M', '', '0', '', '1613535042', 'nhangmoc', 'nhangmoc', '', '0', '1', '4', '1', '0', '', '19971d90be5853ad52dcb6b76a408e0e', '1613642809', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '', '1613535062', '0', '0', '', '0', 'SYSTEM', '0904-999-955')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('49', '0', 'freshet', '1b9c3b768e83d9cbd18cedf2d21f5fb0', '{SSHA512}nY/m+YCq0iuRCRM9m9QJ9pd9hnE76uUf4R0k31xBmjdmbtJhmjkSBHmmy2CIGcgwMj471sl+Xhr9DaiuKB6RyzBhNmM=', 'freshet@gmail.com', 'Phan Ngọc Anh', '', 'M', '', '0', '', '1613556109', '', '', '', '0', '1', '', '1', '0', '', '', '0', '', '', '', '0', '0', '0', '', '0', 'SYSTEM', '0904-999-955')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('50', '0', 'jgkdsfkjgfsjdgf', 'b52ad0846bd2a54da8426288da9840ce', '{SSHA512}jhj3ZBC5grJkDCbb0rBZGhbKw0f+9DV4ECqqF5WhKSicQhqYzDzp+EzXQ/+PL5AZO8IDnRmDMFSD87+YxcwN/GM4Y2Q=', 'sdflkdsgfsdkjgf@gmail.com', 'họ tên người đạigfd', '', 'M', '', '0', '', '1613635344', '', '', '', '0', '1', '', '1', '0', '', '90146078c91540d8186f74d026da62de', '1613635344', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-957-684')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('51', '0', 'tên đăng nhậpkkk', '445bcf1a24c1261e1fdac0a037ae5715', '{SSHA512}xi5RvZRsa0GukJNNSiDwnFJYMGHh6K+1LlapLqd3XdaomtTe6w5SLIjJb8wz6bpT+vKYrH+MU98cL5+Lk5dDc2M0NDI=', 'emailtendangnhap@gmail.com', 'Họ têndfsdfsd', '', 'M', '', '0', '', '1613635572', '', '', '', '0', '1', '', '1', '0', '', '4158d73041a817ccb1f5674c4a4d445a', '1613635572', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-859-787')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('52', '4', 'vinhasthas', 'f189e8919975e006f8c2808c4b30b442', '{SSHA512}k40FzFwd68H//O0t3r3Wk+Fiv/NUwzOQiAeHuMrCgXNKM2vHmtOzwrzR5Yf++0/qDfYgmHOiOrAW4HNcUx3qfzk4Zjk=', 'jhsgdflksvbhsd@gmai.com', 'thạch cảnh bình', 'thạch cảnh bình', '', '', '0', '', '1613635689', 'câu hỏi bảo mật', 'trả lời câu hỏi', '', '0', '1', '4', '1', '0', '', '6640c4a4257742f407d1eabc3c768d93', '1613635689', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('53', '4', 'sdfsdfsd', '8c71fb3f7593543f2ad180d31148a7cf', '{SSHA512}yTfRQmqYpzQrvSASoK7bLmo168eMFA2GaD3H9TrNlNEpBRxuzTXZHYx5faLD18MlqukV+RrJjQVY6XvvKd5wgDE5NDE=', 'sdfdsfsdf@gmail.com', 'sdfsdfsd', 'fdgsdfgdfbgfdg', '', '', '0', '', '1613636073', 'fdgfdbgngf', 'fdgfdhgfhbdf', '', '0', '1', '4', '1', '0', '', 'd7a022c5eda7a8cba4aaa2290bc7edc1', '1613636073', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('54', '4', 'sdfdsgfdhfdh', 'c92e70449f39d72cf3a2669ca6453de9', '{SSHA512}lpqgZBD0f9AC5gE5PpeF/kZPl54+jABraarJ/OIxl8ZyCMAPs3CpkIUqVNPopGj2vIWtMb9btNWWz7aZN9kHtTBjNjM=', 'sdgghgjdf@gmail.com', 'sdfjgsdfjsd', 'sdkjgfsdkjsd', '', '', '0', '', '1613636259', 'fdgfdgfdgfdg', 'fdgfdgfdg', '', '0', '1', '4', '1', '0', '', '2ca00cc406c4f5b821547ddca852e510', '1613636259', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '0', '0', '0', '', '-1', 'SYSTEM', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . " (userid, group_id, username, md5username, password, email, first_name, last_name, gender, photo, birthday, sig, regdate, question, answer, passlostkey, view_mail, remember, in_groups, active, active2step, secretkey, checknum, last_login, last_ip, last_agent, last_openid, last_update, idsite, safemode, safekey, email_verification_time, active_obj, phone) VALUES('55', '0', 'dsgfjdsgfkjsdhfdlskf', '6802079760f06d1bccc4cebfeb1156e9', '{SSHA512}9qwNkW3pmpVsJsb4jn19zCGjERpkwHDpeig60WFWbjg4dpHUCZCRwOLvese0IJk5MJDQPsr7ykYHQAF/iiMaCmMzYWI=', 'sdlkfutsdfjbvsmdn@gmail.com', 'Họ tên người đại diện', '', 'M', '', '0', '', '1613636460', '', '', '', '0', '1', '', '1', '0', '', 'b1dde8464541a81c1ba4c5e586683135', '1613636460', '171.226.0.17', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/93.0.148 Chrome/87.0.4280.148 Safari/537.36', '', '0', '0', '0', '', '0', 'SYSTEM', '0374-826-374')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_field (fid, field, weight, field_type, field_choices, sql_choices, match_type, match_regex, func_callback, min_length, max_length, required, show_register, user_editable, show_profile, class, language, default_value, is_system) VALUES('1', 'first_name', '1', 'textbox', '', '', 'none', '', '', '0', '100', '1', '1', '1', '1', 'input', 'a:1:{s:2:\"vi\";a:2:{i:0;s:4:\"Tên\";i:1;s:0:\"\";}}', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_field (fid, field, weight, field_type, field_choices, sql_choices, match_type, match_regex, func_callback, min_length, max_length, required, show_register, user_editable, show_profile, class, language, default_value, is_system) VALUES('2', 'last_name', '2', 'textbox', '', '', 'none', '', '', '0', '100', '0', '1', '1', '1', 'input', 'a:1:{s:2:\"vi\";a:2:{i:0;s:20:\"Họ và tên đệm\";i:1;s:0:\"\";}}', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_field (fid, field, weight, field_type, field_choices, sql_choices, match_type, match_regex, func_callback, min_length, max_length, required, show_register, user_editable, show_profile, class, language, default_value, is_system) VALUES('3', 'gender', '3', 'select', 'a:3:{s:1:\"N\";s:3:\"N/A\";s:1:\"M\";s:3:\"Nam\";s:1:\"F\";s:4:\"Nữ\";}', '', 'none', '', '', '0', '255', '0', '0', '1', '1', 'input', 'a:1:{s:2:\"vi\";a:2:{i:0;s:12:\"Giới tính\";i:1;s:0:\"\";}}', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_field (fid, field, weight, field_type, field_choices, sql_choices, match_type, match_regex, func_callback, min_length, max_length, required, show_register, user_editable, show_profile, class, language, default_value, is_system) VALUES('4', 'birthday', '4', 'date', 'a:1:{s:12:\"current_date\";i:0;}', '', 'none', '', '', '0', '0', '0', '0', '1', '1', 'input', 'a:1:{s:2:\"vi\";a:2:{i:0;s:22:\"Ngày tháng năm sinh\";i:1;s:0:\"\";}}', '0', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_field (fid, field, weight, field_type, field_choices, sql_choices, match_type, match_regex, func_callback, min_length, max_length, required, show_register, user_editable, show_profile, class, language, default_value, is_system) VALUES('5', 'sig', '5', 'textarea', '', '', 'none', '', '', '0', '1000', '0', '0', '1', '1', 'input', 'a:1:{s:2:\"vi\";a:2:{i:0;s:9:\"Chữ ký\";i:1;s:0:\"\";}}', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_field (fid, field, weight, field_type, field_choices, sql_choices, match_type, match_regex, func_callback, min_length, max_length, required, show_register, user_editable, show_profile, class, language, default_value, is_system) VALUES('6', 'question', '6', 'textbox', '', '', 'none', '', '', '3', '255', '1', '1', '1', '1', 'input', 'a:1:{s:2:\"vi\";a:2:{i:0;s:22:\"Câu hỏi bảo mật\";i:1;s:0:\"\";}}', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_field (fid, field, weight, field_type, field_choices, sql_choices, match_type, match_regex, func_callback, min_length, max_length, required, show_register, user_editable, show_profile, class, language, default_value, is_system) VALUES('7', 'answer', '7', 'textbox', '', '', 'none', '', '', '3', '255', '1', '1', '1', '1', 'input', 'a:1:{s:2:\"vi\";a:2:{i:0;s:22:\"Trả lời câu hỏi\";i:1;s:0:\"\";}}', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups (group_id, title, email, description, content, group_type, group_color, group_avatar, require_2step_admin, require_2step_site, is_default, add_time, exp_time, weight, act, idsite, numbers, siteus, config) VALUES('1', 'Super admin', '', 'Super Admin', '', '0', '', '', '0', '0', '0', '1608515697', '0', '1', '1', '0', '1', '0', 'a:7:{s:17:\"access_groups_add\";i:1;s:17:\"access_groups_del\";i:1;s:12:\"access_addus\";i:0;s:14:\"access_waiting\";i:0;s:13:\"access_editus\";i:0;s:12:\"access_delus\";i:0;s:13:\"access_passus\";i:0;}')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups (group_id, title, email, description, content, group_type, group_color, group_avatar, require_2step_admin, require_2step_site, is_default, add_time, exp_time, weight, act, idsite, numbers, siteus, config) VALUES('2', 'General admin', '', 'General Admin', '', '0', '', '', '0', '0', '0', '1608515697', '0', '2', '1', '0', '6', '0', 'a:7:{s:17:\"access_groups_add\";i:1;s:17:\"access_groups_del\";i:1;s:12:\"access_addus\";i:0;s:14:\"access_waiting\";i:0;s:13:\"access_editus\";i:0;s:12:\"access_delus\";i:0;s:13:\"access_passus\";i:0;}')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups (group_id, title, email, description, content, group_type, group_color, group_avatar, require_2step_admin, require_2step_site, is_default, add_time, exp_time, weight, act, idsite, numbers, siteus, config) VALUES('3', 'Module admin', '', 'Module Admin', '', '0', '', '', '0', '0', '0', '1608515697', '0', '3', '1', '0', '2', '0', 'a:7:{s:17:\"access_groups_add\";i:1;s:17:\"access_groups_del\";i:1;s:12:\"access_addus\";i:0;s:14:\"access_waiting\";i:0;s:13:\"access_editus\";i:0;s:12:\"access_delus\";i:0;s:13:\"access_passus\";i:0;}')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups (group_id, title, email, description, content, group_type, group_color, group_avatar, require_2step_admin, require_2step_site, is_default, add_time, exp_time, weight, act, idsite, numbers, siteus, config) VALUES('4', 'Users', '', 'Users', '', '0', '', '', '0', '0', '0', '1608515697', '0', '4', '1', '0', '9', '0', 'a:7:{s:17:\"access_groups_add\";i:1;s:17:\"access_groups_del\";i:1;s:12:\"access_addus\";i:0;s:14:\"access_waiting\";i:0;s:13:\"access_editus\";i:0;s:12:\"access_delus\";i:0;s:13:\"access_passus\";i:0;}')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups (group_id, title, email, description, content, group_type, group_color, group_avatar, require_2step_admin, require_2step_site, is_default, add_time, exp_time, weight, act, idsite, numbers, siteus, config) VALUES('7', 'New Users', '', 'New Users', '', '0', '', '', '0', '0', '0', '1608515697', '0', '5', '1', '0', '0', '0', 'a:7:{s:17:\"access_groups_add\";i:1;s:17:\"access_groups_del\";i:1;s:12:\"access_addus\";i:0;s:14:\"access_waiting\";i:0;s:13:\"access_editus\";i:0;s:12:\"access_delus\";i:0;s:13:\"access_passus\";i:0;}')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups (group_id, title, email, description, content, group_type, group_color, group_avatar, require_2step_admin, require_2step_site, is_default, add_time, exp_time, weight, act, idsite, numbers, siteus, config) VALUES('5', 'Guest', '', 'Guest', '', '0', '', '', '0', '0', '0', '1608515697', '0', '6', '1', '0', '0', '0', 'a:7:{s:17:\"access_groups_add\";i:1;s:17:\"access_groups_del\";i:1;s:12:\"access_addus\";i:0;s:14:\"access_waiting\";i:0;s:13:\"access_editus\";i:0;s:12:\"access_delus\";i:0;s:13:\"access_passus\";i:0;}')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups (group_id, title, email, description, content, group_type, group_color, group_avatar, require_2step_admin, require_2step_site, is_default, add_time, exp_time, weight, act, idsite, numbers, siteus, config) VALUES('6', 'All', '', 'All', '', '0', '', '', '0', '0', '0', '1608515697', '0', '7', '1', '0', '0', '0', 'a:7:{s:17:\"access_groups_add\";i:1;s:17:\"access_groups_del\";i:1;s:12:\"access_addus\";i:0;s:14:\"access_waiting\";i:0;s:13:\"access_editus\";i:0;s:12:\"access_delus\";i:0;s:13:\"access_passus\";i:0;}')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('1', '1', '1', '1', '0', '1608515732', '1608515732')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('2', '2', '0', '1', '0', '1608516749', '1608516749')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('2', '3', '0', '1', '0', '1608516777', '1608516777')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('2', '22', '0', '1', '0', '1609722630', '1609722630')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('2', '25', '0', '1', '0', '1610412382', '1610412382')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('2', '35', '0', '1', '0', '1611217025', '1611217025')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('2', '37', '0', '1', '0', '1611363998', '1611363998')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('3', '41', '0', '1', '0', '1612407578', '1612407578')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_groups_users (group_id, userid, is_leader, approved, data, time_requested, time_approved) VALUES('3', '45', '0', '1', '0', '1612507049', '1612507049')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('22')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('25')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('35')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('37')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('39')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('41')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('45')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('47')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('52')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('53')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_info (userid) VALUES('54')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_question (qid, title, lang, weight, add_time, edit_time) VALUES('1', 'Bạn thích môn thể thao nào nhất', 'vi', '1', '1274840238', '1274840238')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_question (qid, title, lang, weight, add_time, edit_time) VALUES('2', 'Món ăn mà bạn yêu thích', 'vi', '2', '1274840250', '1274840250')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_question (qid, title, lang, weight, add_time, edit_time) VALUES('3', 'Thần tượng điện ảnh của bạn', 'vi', '3', '1274840257', '1274840257')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_question (qid, title, lang, weight, add_time, edit_time) VALUES('4', 'Bạn thích nhạc sỹ nào nhất', 'vi', '4', '1274840264', '1274840264')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_question (qid, title, lang, weight, add_time, edit_time) VALUES('5', 'Quê ngoại của bạn ở đâu', 'vi', '5', '1274840270', '1274840270')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_question (qid, title, lang, weight, add_time, edit_time) VALUES('6', 'Tên cuốn sách &quot;gối đầu giường&quot;', 'vi', '6', '1274840278', '1274840278')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_question (qid, title, lang, weight, add_time, edit_time) VALUES('7', 'Ngày lễ mà bạn luôn mong đợi', 'vi', '7', '1274840285', '1274840285')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
