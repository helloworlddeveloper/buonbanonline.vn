<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS <contact@tms.vn>
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 19 Feb 2021 09:11:34 GMT
 */

if (!defined('NV_ADMIN'))
    die('Stop!!!');

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank (bank_id, bank_code, name_bank, user_add, time_add, user_edit, time_edit, status, weight) VALUES('2', 'BIDV', 'Ngân hàng Đầu tư và Phát triển Việt Nam', '2', '1608544231', '1', '1608606280', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank (bank_id, bank_code, name_bank, user_add, time_add, user_edit, time_edit, status, weight) VALUES('5', 'ACB', 'Ngân hàng Á Châu', '1', '1608711886', '1', '1608711928', '1', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank (bank_id, bank_code, name_bank, user_add, time_add, user_edit, time_edit, status, weight) VALUES('6', 'TPBank', 'Ngân hàng Tiên Phong', '1', '1608711896', '1', '1608711921', '1', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block (id, title, keyword, description_block, bodytext, other, tag_title, tag_description, time_add, user_add, time_edit, user_edit, weight, status) VALUES('2', 'Sản phẩm mới', '', '', '', '1;https://tmscity.com/;/uploads/retails/block/cad6ab2220f9e4c603be4f55aa9e81cc.png.jpg|2;https://tmscity.com/;/uploads/retails/block/9d43dc256769ee598e65644270417790.png.jpg|3;https://tmscity.com/;/uploads/retails/block/d17f3da92028a14ba68a43b27a91b0e1.png.jpg|4;https://tmscity.com/;/uploads/retails/block/1613697479.jpg', 'Sản phẩm mới', 'Sản phẩm mới', '1608714309', '2', '1613697486', '1', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_id (id, bid, product_id) VALUES('14', '2', '6')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_id (id, bid, product_id) VALUES('15', '2', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_id (id, bid, product_id) VALUES('12', '2', '7')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_id (id, bid, product_id) VALUES('11', '2', '8')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_id (id, bid, product_id) VALUES('10', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_brand (id, title, time_add, time_edit, logo, description, status, weight, alias) VALUES('1', 'Nhang Mộc', '1613535271', '1613569550', 'band/logo_nhangmoc.png', '', '1', '1', 'nhang-moc')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_brand (id, title, time_add, time_edit, logo, description, status, weight, alias) VALUES('2', 'Diwali', '1613612054', '', 'band/logo.png', '', '1', '2', 'diwali')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_brand (id, title, time_add, time_edit, logo, description, status, weight, alias) VALUES('3', 'Fluke', '1613613249', '', '', '', '1', '3', 'fluke')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_brand (id, title, time_add, time_edit, logo, description, status, weight, alias) VALUES('4', 'SamSung', '1613613256', '', '', '', '1', '4', 'samsung')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_brand (id, title, time_add, time_edit, logo, description, status, weight, alias) VALUES('5', 'Apple', '1613613270', '', '', '', '1', '5', 'apple')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('2', 'Thời Trang Nam', 'thoi-trang-nam', '0', '5', 'thời trang nam', 'cat/1612407759.png', '1;https://tmscity.com/admin/;/uploads/retails/cat/banner-ngang-1200x200px-dothucongmynghe.jpg|2;https://tmscity.com/admin/;/uploads/retails/cat/category-banner-winter-10-off-1200x200px.jpg', 'mô tả<br />
&nbsp;', '0', '6', '1', '0', '10', '0', '1', '1608714043', '2', '1613621137', '1', '1', '', '1|2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('3', 'Thời Trang Nữ', 'Thoi-Trang-Nu', '0', '5', '', 'icon_nav_5.png', '', '', '0', '6', '1', '0', '10', '0', '1', '1608714053', '1', '1613569256', '2', '1', '3', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('4', 'Điện Thoại & Phụ Kiện', 'dien-thoai-phu-kien', '14', '5', '', '800-300-800x300.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '10', '0', '1', '1608714057', '35', '1612365382', '3', '1', '9|10|11|12|13|14|15|16|17', '1|2|3|4|5|6|7')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('5', 'Thiết Bị Điện Tử', 'thiet-bi-dien-tu', '14', '5', '', '', '', '', '0', '6', '1', '1', '10', '0', '1', '1608714068', '35', '1612361969', '4', '1', '3|4|6|8|9|12', '1|2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('6', 'Máy tính & Laptop', 'may-tinh-laptop', '14', '5', '', '', '', '', '0', '6', '1', '1', '10', '0', '1', '1608714088', '35', '1612361904', '5', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('10', 'Phụ Kiện Thời Trang', 'phu-kien-thoi-trang', '0', '5', '', '1612413533.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '25', '1610348923', '1', '1613569258', '9', '1', '4', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('11', 'Mỹ Phẩm', 'my-pham', '0', '5', '', '', '', '', '0', '6', '1', '0', '4', '0', '25', '1610349001', '1', '1613569259', '10', '1', '4|18', '1|3|6')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('12', 'Trang Sức', 'trang-suc', '0', '5', '', '', '', '', '0', '6', '1', '0', '4', '0', '25', '1610349030', '1', '1613569260', '11', '1', '4', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('13', 'Đồng Hồ | Mắt Kính', 'dong-ho-mat-kinh', '0', '5', '', '1612413392.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '25', '1610349075', '1', '1613569261', '12', '1', '4', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('14', 'Điện thoại và phụ kiện', 'dien-thoai-va-phu-kien', '0', '5', '', '800-300-800x300-1_1.png', '', '<img alt=\"\" height=\"376\" src=\"/uploads/retails/2021_01/cn1.png\" width=\"368\" />', '0', '6', '1', '0', '4', '0', '25', '1610349094', '3', '1612412501', '13', '1', '3|4|8|9|12|13|14|16|17', '1|2|3|4|6|7')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('15', 'Nhà Cửa Và Đời Sống', 'nha-cua-va-doi-song', '0', '5', '', '1612412956.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '25', '1610349116', '1', '1613569264', '14', '1', '3', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('16', 'Xe', 'xe', '0', '5', '', '', '', '', '0', '6', '1', '0', '4', '0', '25', '1610349134', '1', '1613569266', '15', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('17', 'Dịch Vụ', 'dich-vu', '0', '5', '', '', '', '', '0', '6', '1', '0', '4', '0', '25', '1610349148', '1', '1613569267', '16', '1', '4', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('18', 'Thực Phẩm Cao Cấp', 'thuc-pham-cao-cap', '0', '5', '', '', '', '', '0', '6', '1', '0', '4', '0', '25', '1610349171', '1', '1613569268', '17', '1', '4', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('19', 'Bất Động Sản', 'bat-dong-san', '0', '5', '', '', '', '', '0', '6', '1', '0', '4', '0', '25', '1610349216', '1', '1613569269', '18', '1', '3', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('20', 'Thú Cưng', 'thu-cung', '0', '5', '', '', '', '', '0', '6', '1', '0', '4', '0', '25', '1610349226', '1', '1613569270', '19', '1', '3', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('28', 'Mẹ Và Bé', 'me-va-be', '0', '5', 'mẹ và bé', '1612412807.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612412829', '1', '1613569273', '24', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('22', 'Áo thun', 'ao-thun-nam', '2', '5', 'trên', 'kisspng-handset-telephone-call-mobile-phones-voip-phone-tel-eacute-fono-5b46e70a322dc6.0346030415313733222055.jpg', '', 'ádsa', '2', '6', '1', '1', '4', '0', '3', '1611297556', '1', '1612418199', '20', '1', '3', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('24', 'Sữa dưỡng ẩm', 'Sua-duong-am', '11', '5', '', '', '', 'Nội dung', '2', '6', '1', '1', '4', '0', '3', '1611368408', '3', '1611377827', '21', '1', '3|4', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('46', 'Áo sơ mi', 'ao-so-mi-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418208', '', '', '42', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('47', 'Áo khoác & Áo vest', 'ao-khoac-ao-vest-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418217', '', '', '43', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('29', 'Thiết Bị ĐiệnGia Dụng', 'thiet-bi-diengia-dung', '0', '5', '', '1612413579.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612412897', '1', '1613569274', '25', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('26', 'Tablet', 'tablet', '14', '5', '', 'iphone_logo.png', '', 'ewfads', '0', '6', '1', '1', '4', '0', '35', '1612362200', '', '', '22', '1', '3|6|7|8|9|13', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('27', 'Phụ Kiện', 'phu-kien', '14', '5', '', '', '', 'dffadsc', '0', '6', '1', '1', '4', '0', '35', '1612362237', '', '', '23', '1', '3|6|8|13|14|16', '2|3|5|7')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('30', 'Máy Tính & Laptop', 'may-tinh-laptop', '0', '5', '', '1612413082.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413094', '1', '1613569275', '26', '1', '9|12|13', '1|2|3|4|5|6|7')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('31', 'Sức Khỏe Và Sắc Đẹp', 'suc-khoe-va-sac-dep', '0', '5', 'sức khỏe và sắc đẹp', '1612413178.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413188', '1', '1613569276', '27', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('32', 'Máy Ảnh - Máy Quay Phim', 'may-anh-may-quay-phim', '0', '5', 'Máy Ảnh - Máy Quay Phim', '1612413258.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413269', '1', '1613569277', '28', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('33', 'Giày Dép Nữ', 'giay-dep-nu', '0', '5', '', '1612413323.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413342', '1', '1613569278', '29', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('34', 'Túi Ví', 'tui-vi', '0', '5', '', '1612413440.png', '', 'Nội dun chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413447', '1', '1613569279', '30', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('35', 'Giày Dép Nam', 'giay-dep-nam', '0', '5', 'Giày Dép Nam', '1612413489.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413503', '1', '1613569282', '31', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('36', 'Bách Hóa Online', 'bach-hoa-online', '0', '5', 'Bách Hóa Online', '1612413650.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413659', '1', '1613569285', '32', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('37', 'Thể Thao & Du Lịch', 'the-thao-du-lich', '0', '5', 'Thể Thao & Du Lịch', '1612413709.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413717', '1', '1613569286', '33', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('38', 'Voucher Và Dịch Vụ', 'voucher-va-dich-vu', '0', '5', 'Voucher Và Dịch Vụ', '1612413766.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413779', '1', '1613569287', '34', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('39', 'Ô Tô - Xe Máy - Xe Đạp', 'o-to-xe-may-xe-dap', '0', '5', 'Ô Tô - Xe Máy - Xe Đạp', '1612413839.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413852', '1', '1613569288', '35', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('40', 'Nhà Sách Online', 'nha-sach-online', '0', '5', 'Nhà Sách Online', '1612413944.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413953', '1', '1613569290', '36', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('41', 'Đồ Chơi', 'do-choi', '0', '5', 'Đồ Chơi', '1612413987.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612413995', '1', '1613569292', '37', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('42', 'Giặt Giũ & Chăm Sóc Nhà Cửa', 'giat-giu-cham-soc-nha-cua', '0', '5', 'Giặt Giũ & Chăm Sóc Nhà Cửa', '1612414065.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612414073', '1', '1613569293', '38', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('43', 'Chăm Sóc Thú Cưng', 'cham-soc-thu-cung', '0', '5', 'Chăm Sóc Thú Cưng', '1612414110.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612414119', '1', '1613569294', '39', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('44', 'Thời Trang Trẻ Em', 'thoi-trang-tre-em', '0', '5', 'Thời Trang Trẻ Em', '1612414157.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612414165', '1', '1613569295', '40', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('45', 'Sản Phẩm Khác', 'san-pham-khac', '0', '5', 'Sản Phẩm Khác', '1612414211.png', '', 'Nội dung chi tiết', '0', '6', '1', '0', '4', '0', '3', '1612414218', '1', '1613569296', '41', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('48', 'Áo nỉ/ Áo len', 'ao-ni-ao-len-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418225', '', '', '44', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('49', 'Đồ bộ/ Đồ mặc nhà', 'do-bo-do-mac-nha-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418231', '', '', '45', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('50', 'Đồ đôi', 'do-doi-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418237', '', '', '46', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('51', 'Quần', 'quan-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418244', '', '', '47', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('52', 'Balo/ Túi/ Ví', 'balo-tui-vi-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418250', '', '', '48', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('53', 'Mắt kính', 'mat-kinh-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418256', '', '', '49', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('54', 'Phụ kiện nam', 'phu-kien-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418264', '', '', '50', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('55', 'Đồ Trung Niên', 'do-nam-trung-nien', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418271', '', '', '51', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('56', 'Trang Sức Nam', 'trang-suc-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418276', '', '', '52', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('57', 'Thắt Lưng', 'that-lung-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418282', '', '', '53', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('58', 'Đồ lót', 'do-lot-nam', '2', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1612418289', '', '', '54', '1', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('59', 'Thờ cúng', 'tho-cung', '15', '5', '', '', 'Nhang mộc tài lộc;https://sieusan.com/Nhang-Moc-Tai-Loc-30cm-Loai-79-Cay-3/;/uploads/retails/cat/tai_loc_lon_3.jpg', '', '0', '6', '1', '0', '4', '0', '1', '1613535314', '1', '1613569509', '55', '1', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_categories (id, name, alias, parrent_id, percent_discount, keyword, image, other_image, description, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add, user_edit, time_edit, weight, status, brand, origin) VALUES('60', 'Nội Thất', 'noi-that', '15', '5', '', '', '', '', '0', '6', '1', '1', '4', '0', '1', '1613611393', '1', '1613612067', '56', '1', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_category_shop (id, title, weight, status, time_add, time_edit, id_shop, alias, parentid, description, image) VALUES('1', 'Nhang Mộc Tài Lộc - Nhang Trầm Xanh Sạch', '1', '1', '1613549332', '', '48', 'nhang-moc-tai-loc-nhang-tram-xanh-sach-shop', '0', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_category_shop_item (id, id_category_shop, product_id, time_add) VALUES('1', '1', '1', '1613549338')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_category_shop_item (id, id_category_shop, product_id, time_add) VALUES('2', '1', '3', '1613549340')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_category_shop_item (id, id_category_shop, product_id, time_add) VALUES('3', '1', '2', '1613549344')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_follow (id, shop_id, time_add, user_id) VALUES('13', '7', '1613617087', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_follow (id, shop_id, time_add, user_id) VALUES('18', '1', '1613617410', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory_product (id, store_id, warehouse_id, product_id, classify_value_product_id, amount, amount_delivery) VALUES('1', '1', '1', '1', '0', '95', '5')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory_product (id, store_id, warehouse_id, product_id, classify_value_product_id, amount, amount_delivery) VALUES('2', '1', '1', '3', '0', '88', '11')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory_product (id, store_id, warehouse_id, product_id, classify_value_product_id, amount, amount_delivery) VALUES('3', '1', '1', '2', '0', '99', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory_product (id, store_id, warehouse_id, product_id, classify_value_product_id, amount, amount_delivery) VALUES('4', '7', '7', '4', '0', '10', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory_product (id, store_id, warehouse_id, product_id, classify_value_product_id, amount, amount_delivery) VALUES('5', '7', '7', '5', '0', '10', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('1', '1', '-1', 'Đơn hàng mới được khởi tạo', '1613550494', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('2', '2', '-1', 'Đơn hàng mới được khởi tạo', '1613552274', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('3', '1', '0', 'Đơn hàng chuyển sang trạng thái đã xác nhận', '1613553773', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('4', '1', '1', 'Chuyển sang đơn vị vận chuyển VNPOST Thành Công', '1613553844', '48')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('5', '1', '2', 'Đơn hàng chuyển sang trạng thái thành công', '1613553851', '48')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('6', '3', '-1', 'Đơn hàng mới được khởi tạo', '1613612219', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('7', '2', '0', 'Đơn hàng chuyển sang trạng thái đã xác nhận', '1613614432', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('8', '4', '-1', 'Đơn hàng mới được khởi tạo', '1613615280', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('9', '5', '-1', 'Đơn hàng mới được khởi tạo', '1613616088', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('14', '6', '0', 'sddssf', '1613622411', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('15', '5', '0', 'ewrwef', '1613622498', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('13', '6', '-1', 'Đơn hàng mới được khởi tạo', '1613622379', '48')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('12', '1', '2', 'Đơn hàng chuyển sang trạng thái đã giao', '1613619142', '-2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('16', '4', '0', 'sdfsdf', '1613622576', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('17', '7', '-1', 'Đơn hàng mới được khởi tạo', '1613622634', '48')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('18', '7', '0', 'sdfdsfs', '1613622642', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('19', '8', '-1', 'Đơn hàng mới được khởi tạo', '1613622693', '48')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('20', '8', '0', 'sds', '1613622702', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('21', '3', '0', 'Đơn hàng chuyển sang trạng thái đã xác nhận', '1613623203', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('22', '9', '-1', 'Đơn hàng mới được khởi tạo', '1613623246', '48')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('23', '9', '0', 'Đơn hàng chuyển sang trạng thái đã xác nhận', '1613623272', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('24', '9', '1', 'sad', '1613623632', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('25', '10', '-1', 'Đơn hàng mới được khởi tạo', '1613631472', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('26', '11', '-1', 'Đơn hàng mới được khởi tạo', '1613635652', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('27', '11', '2', 'Đơn hàng chuyển sang trạng thái đã giao', '1613637935', '-2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('34', '9', '2', 'Đơn hàng chuyển sang trạng thái đã giao', '1613643824', '-2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('33', '1', '3', 'Đơn hàng đã được thanh toán cho người bán', '1613642859', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('32', '9', '3', 'Đơn hàng đã được thanh toán cho người bán', '1613642753', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('31', '11', '3', 'Đơn hàng đã được thanh toán cho người bán', '1613641996', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('35', '8', '2', 'Đơn hàng chuyển sang trạng thái đã giao', '1613644394', '-2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('36', '10', '2', 'Đơn hàng chuyển sang trạng thái đã giao', '1613697635', '-2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('37', '12', '-1', 'Đơn hàng mới được khởi tạo', '1613699574', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('38', '12', '0', 'Đơn hàng chuyển sang trạng thái đã xác nhận', '1613699639', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('39', '12', '1', 'Chuyển sang đơn vị vận chuyển VNPOST Thành Công', '1613699654', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('40', '13', '-1', 'Đơn hàng mới được khởi tạo', '1613699802', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('41', '13', '0', 'f', '1613699810', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('42', '14', '-1', 'Đơn hàng mới được khởi tạo', '1613699927', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('43', '14', '0', 's', '1613700111', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('44', '15', '-1', 'Đơn hàng mới được khởi tạo', '1613706315', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('45', '15', '0', 'sdfds', '1613706328', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('46', '16', '-1', 'Đơn hàng mới được khởi tạo', '1613706389', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('47', '16', '0', 'sadad', '1613706470', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('48', '17', '-1', 'Đơn hàng mới được khởi tạo', '1613719986', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('49', '18', '-1', 'Đơn hàng mới được khởi tạo', '1613720174', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('50', '19', '-1', 'Đơn hàng mới được khởi tạo', '1613720240', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('51', '20', '-1', 'Đơn hàng mới được khởi tạo', '1613720297', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('52', '21', '-1', 'Đơn hàng mới được khởi tạo', '1613720389', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('53', '22', '-1', 'Đơn hàng mới được khởi tạo', '1613720433', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('54', '23', '-1', 'Đơn hàng mới được khởi tạo', '1613720495', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('55', '24', '-1', 'Đơn hàng mới được khởi tạo', '1613721117', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_logs_order (id, order_id, status_id_old, content, time_add, user_add) VALUES('56', '25', '-1', 'Đơn hàng mới được khởi tạo', '1613722227', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('1', '1', 'DHT00001', '1', '1', 'Phan Ngọc Anh', 'info@tms.vn', '0904999955', '70', '7270', '72780', '950/43 Nguyễn Kiệm', '10.8243596', '106.6793723', '5', '25000', '400', '1', '6', '30', '50100', '1', '25100', 'ED775524561VN ', '50100', '', '', '1613550494', '3', '1', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('2', '2', 'DHT00002', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '70', '7270', '72710', '12515', '10.8273911', '106.6838929', '5', '25000', '400', '1', '6', '30', '0', '0', '25100', '', '50100', '', '', '1613552274', '4', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('3', '3', 'TMS00003', '1', '1', 'thạch cảnh bình', 'thachcanhbinh@gmail.com', '0283746546', '18', '1883', '18830', 'địa chỉ ngắn gọn', '20.8023739', '106.6980211', '5', '15000', '200', '1', '5', '30', '0', '0', '23285', '', '38285', 'lưu ý cho người bán', '', '1613612219', '3', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('5', '3', 'TMS00005', '1', '1', 'sadasdsadsa', 'sadsadsajfsaj@gmail.com', '435435435435', '16', '1632', '16327', 'địa chỉ', '20.9121135', '106.0904721', '5', '15000', '200', '1', '5', '30', '0', '0', '25155', '', '40155', '', '', '1613616088', '3', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('4', '3', 'TMS00004', '1', '1', 'sadsadsa', 'sadasdsa@gmail.com', '43543543543', '16', '1622', '16242', 'sdfdsf', '20.7352204', '106.0433901', '5', '15000', '200', '1', '5', '30', '0', '0', '25155', '', '40155', 'sdfds', '', '1613615280', '3', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('6', '48', 'TMS00006', '7', '7', 'sdfdsfsdf', 'sdfsdfsdfd@gmail.com', '43543543545', '18', '1851', '18517', 'rgrdgbrd', '20.8220411', '106.653783', '5', '550000', '5000', '5', '35', '160', '0', '0', '67215', '', '617215', 'dsfdsfdsf', '', '1613622379', '3', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('7', '48', 'TMS00007', '7', '7', 'sadsadsad', 'asdsadsad@gmail.com', '42343243243', '17', '1754', '17542', 'sdcdscf', '20.8650335', '106.3375493', '5', '550000', '5000', '5', '35', '160', '0', '0', '76345', '', '626345', '', '', '1613622634', '3', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('8', '48', 'TMS00008', '7', '7', 'sdfsdfdsfsd', 'sdfdsfds@gmial.cin', '435345435', '20', '2075', '20776', 'sadsa', '20.9191199', '106.8119382', '5', '550000', '5000', '5', '35', '160', '0', '0', '67215', '5FALX6NA', '617215', '', '', '1613622693', '3', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('9', '48', 'TMS00009', '7', '7', 'sadsadsadsa', 'sadsafdsgfdg@gmail.com', '43543543554', '17', '1754', '17542', 'fgvfdv', '20.8650335', '106.3375493', '5', '550000', '5000', '5', '35', '160', '0', '0', '76345', '10345381626', '626345', '', '', '1613623246', '3', '1', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('10', '3', 'TMS000010', '1', '1', 'adasdsadsads', 'sadsadsadsa@gmail.com', '435345345435', '20', '2075', '20773', 'retretert', '20.9069323', '106.7983639', '5', '30000', '400', '2', '10', '60', '0', '0', '26915', 'S1.A1.17373471', '56915', 'retretr', '', '1613631472', '3', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('11', '2', 'TMS000011', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '42000', '700', '2', '11', '70', '0', '0', '34450', 'EE778630768VN', '76450', '', '', '1613635652', '3', '1', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('12', '1', 'TMS000012', '1', '1', '089980089', 'info@tms.vn', '0900099444', '10', '1424', '15346', '434b', '21.1262106', '105.6676471', '5', '75000', '1200', '3', '18', '90', '114455', '1', '39455', 'CA496407426VN', '114455', '', '', '1613699574', '2', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('13', '1', 'TMS000013', '1', '1', '545654', '45@gmail.com', '34534', '16', '1622', '16242', 'fdgdfgdf', '20.7352204', '106.0433901', '5', '45000', '600', '3', '15', '90', '81595', '1', '36595', '', '81595', '', '', '1613699802', '4', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('14', '2', 'TMS000014', '1', '1', 'Đặng Thành Đạt', 'stata@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '1', '28015', '', '53015', '', '', '1613699927', '4', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('15', '3', 'TMS000015', '1', '1', 'sadsadsa', 'sadsad@gmail.com', '43543543545', '16', '1632', '16320', 'sadsad', '20.9455817', '106.0434449', '5', '40000', '600', '2', '11', '60', '0', '0', '36595', '', '76595', '', '', '1613706315', '4', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('16', '3', 'TMS000016', '1', '1', 'dfgsdf', 'sdfdsfds@gmial.cin', '0384756475', '17', '1731', '17327', 'địa chỉ', '20.9094037', '106.5186355', '5', '15000', '200', '1', '5', '30', '0', '0', '25155', '', '40155', '', '', '1613706389', '4', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('17', '2', 'TMS000017', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '15000', '200', '1', '5', '30', '38725', '2', '23725', '', '38725', '', '', '1613719986', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('18', '2', 'TMS000018', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613720174', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('19', '2', 'TMS000019', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '15000', '200', '1', '5', '30', '38725', '2', '23725', '', '38725', '', '', '1613720240', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('20', '2', 'TMS000020', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '0', '0', '28015', '', '53015', '', '', '1613720297', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('21', '2', 'TMS000021', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613720389', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('22', '2', 'TMS000022', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613720433', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('23', '2', 'TMS000023', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613720495', '0', '0', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('24', '2', 'TMS000024', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1251559', '105.6614372', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613721117', '0', '0', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status, plus_money, status_payment_vnpay) VALUES('25', '2', 'TMS000025', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613722227', '0', '0', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('1', '1', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '1250')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('2', '2', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('3', '3', '1', '200', '30', '1', '5', '15000', '0', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('4', '4', '1', '200', '30', '1', '5', '15000', '0', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('5', '5', '1', '200', '30', '1', '5', '15000', '0', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('6', '6', '5', '5000', '160', '5', '35', '550000', '0', '1', '550000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('7', '7', '5', '5000', '160', '5', '35', '550000', '0', '1', '550000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('8', '8', '5', '5000', '160', '5', '35', '550000', '0', '1', '550000', '27500')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('9', '9', '5', '5000', '160', '5', '35', '550000', '0', '1', '550000', '27500')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('10', '10', '1', '400', '60', '2', '10', '15000', '0', '2', '30000', '1500')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('11', '11', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '1250')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('12', '11', '2', '300', '40', '1', '5', '17000', '0', '1', '17000', '850')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('13', '12', '3', '1200', '90', '3', '18', '25000', '0', '3', '75000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('14', '13', '1', '600', '90', '3', '15', '15000', '0', '3', '45000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('15', '14', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('16', '15', '1', '200', '30', '1', '5', '15000', '0', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('17', '15', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('18', '16', '1', '200', '30', '1', '5', '15000', '0', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('19', '17', '1', '200', '30', '1', '5', '15000', '0', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('20', '18', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('21', '19', '1', '200', '30', '1', '5', '15000', '0', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('22', '20', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('23', '21', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('24', '23', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('25', '24', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_order_item (id, order_id, product_id, weight, length, height, width, price, classify_value_product_id, quantity, total, discount) VALUES('26', '25', '3', '400', '30', '1', '6', '25000', '0', '1', '25000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('1', 'Việt Nam', '', '1613535297', '', '1', '1', 'viet-nam')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('2', 'Hàn Quốc', '', '1613612215', '', '2', '1', 'han-quoc')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('3', 'Mỹ', '', '1613612316', '', '3', '1', 'my')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('4', 'Pháp', '', '1613612322', '', '4', '1', 'phap')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('5', 'Nhật', '', '1613612328', '', '5', '1', 'nhat')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('37', 'China / Malaysia', '', '1613613018', '', '36', '1', 'china-malaysia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('7', 'Thái Lan', '', '1613612367', '', '6', '1', 'thai-lan')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('8', 'Singapore', '', '1613612385', '', '7', '1', 'singapore')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('9', 'Cuba', '', '1613612838', '', '8', '1', 'cuba')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('10', 'Ai Cập', '', '1613612842', '', '9', '1', 'ai-cap')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('11', 'Ailen', '', '1613612849', '', '10', '1', 'ailen')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('12', 'ALBANIA', '', '1613612859', '', '11', '1', 'albania')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('13', 'Ấn Độ', '', '1613612863', '', '12', '1', 'an-do')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('14', 'Ấn Độ / Indonesia', '', '1613612868', '', '13', '1', 'an-do-indonesia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('15', 'Anh', '', '1613612871', '', '14', '1', 'anh')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('16', 'Anh, Việt Nam', '', '1613612875', '', '15', '1', 'anh-viet-nam')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('17', 'Áo', '', '1613612879', '', '16', '1', 'ao')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('18', 'argentina', '', '1613612888', '', '17', '1', 'argentina')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('19', 'Australia', '', '1613612897', '', '18', '1', 'australia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('20', 'Ba Lan', '', '1613612900', '', '19', '1', 'ba-lan')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('21', 'Baltic', '', '1613612904', '', '20', '1', 'baltic')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('22', 'Bangladesh', '', '1613612909', '', '21', '1', 'bangladesh')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('23', 'Belarus', '', '1613612931', '', '22', '1', 'belarus')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('24', 'Bỉ', '', '1613612935', '', '23', '1', 'bi')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('25', 'Bồ Đào Nha', '', '1613612938', '', '24', '1', 'bo-dao-nha')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('26', 'BONAIRE, SAINT EUSTATIUS AND SABA', '', '1613612943', '', '25', '1', 'bonaire-saint-eustatius-and-saba')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('27', 'Brazil', '', '1613612947', '', '26', '1', 'brazil')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('28', 'Brazil - Uruquay', '', '1613612951', '', '27', '1', 'brazil-uruquay')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('29', 'Bulgaria', '', '1613612955', '', '28', '1', 'bulgaria')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('30', 'Bulgary', '', '1613612959', '', '29', '1', 'bulgary')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('31', 'Campuchia', '', '1613612963', '', '30', '1', 'campuchia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('32', 'Canada', '', '1613612967', '', '31', '1', 'canada')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('33', 'Canada và các nước khác hợp tác sản xuất', '', '1613612972', '', '32', '1', 'canada-va-cac-nuoc-khac-hop-tac-san-xuat')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('34', 'Chi Lê / Đan Mạch / Indonesia / Việt Nam', '', '1613612976', '', '33', '1', 'chi-le-dan-mach-indonesia-viet-nam')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('35', 'Chile', '', '1613612980', '', '34', '1', 'chile')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('36', 'China', '', '1613613000', '1613613015', '35', '1', 'china')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('38', 'China / Singapore', '', '1613613022', '', '37', '1', 'china-singapore')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('39', 'China / Vietnam', '', '1613613026', '', '38', '1', 'china-vietnam')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('40', 'Columbia', '', '1613613032', '', '39', '1', 'columbia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('41', 'Cộng Hòa Fiji', '', '1613613036', '', '40', '1', 'cong-hoa-fiji')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('42', 'Cộng hòa Séc', '', '1613613043', '', '41', '1', 'cong-hoa-sec')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('43', 'Cộng hòa Síp', '', '1613613046', '', '42', '1', 'cong-hoa-sip')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('44', 'Costa Rica', '', '1613613051', '', '43', '1', 'costa-rica')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('45', 'Croatia', '', '1613613107', '', '44', '1', 'croatia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('46', 'Dubai', '', '1613613111', '', '45', '1', 'dubai')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('47', 'Estonia', '', '1613613114', '', '46', '1', 'estonia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_origin (id, title, description, time_add, time_edit, weight, status, alias) VALUES('48', 'Georgia', '', '1613613118', '', '47', '1', 'georgia')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('1', '1', 'SP885267685', 'Nhang Mộc Tài Lộc 30cm Loại 39 Cây', 'Nhang-Moc-Tai-Loc-30cm-Loai-39-Cay', '59', '5', '2', '200', '30', '5', '1', '1', '1', '1', '2021_02/huong-nhang-tram-sach-the-nho.jpg', '', 'Không cay mắt không xộc mũi. Không hóa chất, không hương liệu độc hại<br />
Nguồn nguyên liệu đến 99,9% từ thiên nhiên.Mùi trầm hương tự nhiên xanh sạch<br />
Thích hợp cho phòng kín máy lạnh không gian khoảng 25m2. Dành cho khách hàng đốt nhiều nhất là công ty, cửa hàng<br />
Thành phần: bột trầm hương, keo thực vât&nbsp;(keo cây bời lời),&nbsp;tăm tre nhập khẩu.', '<h2>Nhang Trầm sạch là gì?</h2>
Từ lâu chúng ta đã quen sử dụng nhang để thắp hương trên bàn thờ tổ tiên, bàn thờ ông địa trong các ngôi nhà hay tại các văn phòng, cửa hàng, cơ quan làm việc. Và loại nhang thường hay sử dụng đó lại chính là loại nhang có tẩm hóa chất độc hại, vì vậy mùi hương sau khi đốt thường lưu lại rất lâu nhưng ngược lại, nó gây ảnh hưởng không nhỏ tới sức khỏe cũng như sinh hoạt của con người.<br />
Với mong muốn sử dụng một loại nhang an toàn, thời gian gần đây mọi người rất quan tâm đến sản phẩm nhang sạch. Vậy nhang trầm sạch là gì?<br />
Nhang Trầm sạch là một loại nhang được sản xuất dựa trên dây chuyền, công nghệ tiên tiến, với thành phần hoàn toàn từ các nguyên liệu có sẵn trong tự nhiên như bột trầm hương, keo thực vật và tăm tre nhập khẩu. Đặc biệt không dùng đến hóa chất hay hương liệu độc hại, nhờ đó mà nhang sạch có mùi trầm thơm tự nhiên, chứ không phải là mùi thơm hắc như nhang có tẩm hóa chất.<br />
&nbsp;<br />
<img alt=\"nhang trầm sạch\" height=\"450\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_1.jpg\" title=\"nhang trầm sạch\" width=\"800\" /><br />
&nbsp;
<h2>Lợi ích khi sử dụng nhang sạch</h2>
Vì nhang trầm&nbsp;sạch được sản xuất hoàn toàn từ trầm hương tự nhiên, không hóa chất, không hương liệu độc hại và phải trải qua quá trình sản xuất, kiểm định gắt gao để cho ra đời những sản phẩm nhang chất lượng. Cho nên sử dụng nhang sạch chúng ta hoàn toàn có thể yên tâm về mặt sức khỏe, &nbsp;khi không gây ra ảnh hưởng nghiêm trọng nào về mắt, da và đường hô hấp. Đặc biệt an toàn với những người bị viêm xoang, dị ứng hay đối tựơng bà bầu, trẻ nhỏ và người già.<br />
Bên cạnh đó, mùi hương từ nhang sạch tỏa ra là mùi trầm thơm tự nhiên, nhẹ dịu nên luôn mang đến cảm giác thư giãn, thỏai mái và dễ chịu. Nhất là khi sử dụng nhang ở những nơi đông người như văn phòng làm việc, cửa hàng hay các buổi hành lễ cũng như trong không gian phòng kín, phòng lạnh. &nbsp;
<blockquote><img alt=\"tai loc lon 3\" height=\"371\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc.jpg\" title=\"tai loc lon 3\" width=\"1000\" /><br />
&nbsp;<br />
Nhang Mộc là nhà sản xuất và cung cấp Nhang Trầm Thượng Hạng cho người tiêu dùng trong và ngoài nước. Nhang Mộc tự hào mang đến cho bạn một giải pháp thực sự về một dòng “Nhang Sạch” không những chất lượng cao với hương thơm nhẹ nhàng, êm dịu, mà còn đem lại rất nhiều lợi ích cho sức khỏe người tiêu dùng.<br />
<br />
<strong>Nguồn nguyên liệu tự nhiên</strong><br />
Sản phẩm của Nhang Mộc được làm từ 100% trầm hương tự nhiên. Nguyên liệu được tuyển chọn những cây trầm có điều kiện và sức khỏe tốt nhất. Đảm bảo cho ra những sản phẩm với chất lượng cao nhất.<br />
<br />
<strong>Chất lượng luôn được đặt lên hàng đầu</strong><br />
Những sản phẩm được Nhang Mộc tạo ra, trước khi xuất xưởng để đến tay người tiêu dùng đều được trải qua quá trình thẩm định và kiểm định chuyên nghiệp từ độ mùi, trọng lượng, chất lượng bột nhang, tăm nhang cho đến bao bì.<br />
<br />
<strong>Quy trình sản xuất tiên tiến</strong><br />
Nhang Mộc phát triển quy trình sản xuất dựa trên những công nghệ khoa học – kỹ thuật tiên tiến. Nhang Mộc tự tin sản phẩm của mình có thể làm hài lòng tất cả tầng lớp người tiêu dùng.</blockquote>

<h2>Nhang Trầm Sạch: Nhang mộc tài lộc&nbsp;cầu tài lộc, tiền bạc cho công ty cửa hàng</h2>

<p>Theo phong tục của người Việt Nam, “có thờ có thiêng, có kiêng có lành” nên hầu hết ở các công ty, cửa hàng đều có bàn thờ Ông Địa – Thần Tài. Việc thắp nhang vào mỗi buổi sáng để cầu việc làm ăn thuận lợi là điều cần thiết. Tuy nhiên, để đảm bảo sức khỏe cũng như cầu tài lộc thì nên cân nhắc sử dụng nhang mộc tài lộc.</p>
<img alt=\"Nhang mộc tài lộc: cầu tài lộc, tiền bạc cho công ty cửa hàng\" height=\"400\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_4.jpg\" title=\"Nhang mộc tài lộc: cầu tài lộc, tiền bạc cho công ty cửa hàng\" width=\"800\" />
<p>&nbsp;</p>

<h2>Lý do nên sử dụng nhang mộc tài lộc</h2>

<p>Trong văn hóa thờ cúng, việc sử dụng nhang là một điều cần thiết. Tuy nhiên, các loại nhang được bày bán trên thị trường hiện nay, hầu hết đều là nhang được tẩm hóa chất độc hại. Vì vậy khi đốt rất khó ngửi và gây ảnh hưởng không tốt tới sức khỏe của con người.<br />
Đặc biệt ở khu vực cửa hàng hay các công ty là nơi sử dụng nhang mỗi ngày. Đây là nơi tập trung nhiều người qua lại, mua bán và làm việc. Việc đốt nhang có tẩm hóa chất độc hại dù với mục đích cầu tài lộc, nhưng có thể gây nên những ảnh hưởng nghiêm trọng tới sức khỏe cũng như ảnh hưởng đến hiệu quả làm việc. Vì vậy, các chủ cửa hàng, chủ công ty nên lưu ý trong việc chọn nhang. Tốt nhất nên sử dụng nhang được làm từ thảo mộc như nhang mộc tài lộc.</p>
<img alt=\"Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc\" height=\"440\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_3.jpg\" title=\"Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc\" width=\"660\" />
<p>&nbsp;</p>

<h2>Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc</h2>

<p>Nhang mộc là sản phẩm nhang sạch không chỉ được người tiêu dùng trong nước, mà cả người tiêu dùng nước ngoài rất ưa chuộng. Bởi đây là sản phẩm nhang được làm hoàn toàn từ nguyên liệu tự nhiên như: bột trầm hương, keo thực vật (keo cây bời lời) và tăm tre nhập khẩu. Vì vậy, mang đến mùi hương rất dễ chịu dù có thắp nhang ở trong phòng lạnh, đóng kín với diện tích hẹp.<br />
Đối với các cửa hàng hay công ty có nhu cầu thắp nhang vào mỗi buổi sáng để cầu tài lộc, thì sản phẩm nhang mộc tài lộc là lựa chọn không thể nào hoàn hảo hơn. Không chỉ mang ý nghĩa cầu tài lộc, tiền bạc cho công việc làm ăn, buôn bán trong ngày gặp may mắn và thuận lợi. Nhang mộc tài lộc lại không chứa hóa chất hay hương liệu độc hại, khi thắp không hề cay mắt hay xộc mũi, do đó không gây cảm giác khó chịu hay ảnh hưởng tới sức khỏe, tinh thần của mọi người ở xung quanh.<br />
Với mùi thơm nhẹ nhàng và êm dịu do nhang mộc tài lộc mang lại, nhân viên trong công ty tập trung làm việc, khách trong cửa hàng thoải mái đi lại, mua sắm. Nhờ đó cũng có thể góp phần nâng cao hiệu suất làm việc, doanh thu cho công ty hay cửa hàng.<br />
Xu hướng sử dụng nhang sạch đang ngày càng phát triển. Vì vậy, đối với những người làm ăn, kinh doanh như các công ty hay chủ cửa hàng, những người có nhu cầu sử dụng nhang nhiều nên sử dụng nhang mộc tài lộc, vừa mang ý nghĩa cầu tài lộc vừa an toàn cho sức khỏe lại vừa phù hợp với văn hóa thờ cúng của người Việt Nam.<br />
&nbsp;</p>
<img alt=\"Nhang mộc tài lộc\" height=\"480\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_2.jpg\" title=\"Nhang mộc tài lộc\" width=\"720\" />', '', '', '', '1', '1', '1', '87', '0', '0', '1613550029', '1', '1613637559', '3', '1', '1', '0', '1', '1', '17000', '15000', '4', '1', '1613643143', '1', '15000', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('2', '1', 'SP658196056', 'Nhang Mộc Tài Lộc 40cm Loại 39 Cây', 'Nhang-Moc-Tai-Loc-40cm-Loai-39-Cay', '59', '4', '2', '300', '40', '5', '1', '1', '1', '1', '2021_02/huong-nhang-tram-sach-the-nho.jpg', '', '&nbsp;<br />
Không cay mắt không xộc mũi. Không hóa chất, không hương liệu độc hại<br />
Nguồn nguyên liệu đến 99,9% từ thiên nhiên.Mùi trầm hương tự nhiên xanh sạch<br />
Thích hợp cho phòng kín máy lạnh không gian khoảng 25m2. Dành cho khách hàng đốt nhiều nhất là công ty, cửa hàng<br />
Thành phần: bột trầm hương, keo thực vât&nbsp;(keo cây bời lời),&nbsp;tăm tre nhập khẩu.<br />
&nbsp;', '<h2>&nbsp;Nhang Trầm sạch là gì?</h2>
Từ lâu chúng ta đã quen sử dụng nhang để thắp hương trên bàn thờ tổ tiên, bàn thờ ông địa trong các ngôi nhà hay tại các văn phòng, cửa hàng, cơ quan làm việc. Và loại nhang thường hay sử dụng đó lại chính là loại nhang có tẩm hóa chất độc hại, vì vậy mùi hương sau khi đốt thường lưu lại rất lâu nhưng ngược lại, nó gây ảnh hưởng không nhỏ tới sức khỏe cũng như sinh hoạt của con người.<br />
Với mong muốn sử dụng một loại nhang an toàn, thời gian gần đây mọi người rất quan tâm đến sản phẩm nhang sạch. Vậy nhang trầm sạch là gì?<br />
Nhang Trầm sạch là một loại nhang được sản xuất dựa trên dây chuyền, công nghệ tiên tiến, với thành phần hoàn toàn từ các nguyên liệu có sẵn trong tự nhiên như bột trầm hương, keo thực vật và tăm tre nhập khẩu. Đặc biệt không dùng đến hóa chất hay hương liệu độc hại, nhờ đó mà nhang sạch có mùi trầm thơm tự nhiên, chứ không phải là mùi thơm hắc như nhang có tẩm hóa chất.<br />
&nbsp;<br />
<img alt=\"nhang trầm sạch\" height=\"450\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_1.jpg\" title=\"nhang trầm sạch\" width=\"800\" /><br />
&nbsp;
<h2>Lợi ích khi sử dụng nhang sạch</h2>
Vì nhang trầm&nbsp;sạch được sản xuất hoàn toàn từ trầm hương tự nhiên, không hóa chất, không hương liệu độc hại và phải trải qua quá trình sản xuất, kiểm định gắt gao để cho ra đời những sản phẩm nhang chất lượng. Cho nên sử dụng nhang sạch chúng ta hoàn toàn có thể yên tâm về mặt sức khỏe, &nbsp;khi không gây ra ảnh hưởng nghiêm trọng nào về mắt, da và đường hô hấp. Đặc biệt an toàn với những người bị viêm xoang, dị ứng hay đối tựơng bà bầu, trẻ nhỏ và người già.<br />
Bên cạnh đó, mùi hương từ nhang sạch tỏa ra là mùi trầm thơm tự nhiên, nhẹ dịu nên luôn mang đến cảm giác thư giãn, thỏai mái và dễ chịu. Nhất là khi sử dụng nhang ở những nơi đông người như văn phòng làm việc, cửa hàng hay các buổi hành lễ cũng như trong không gian phòng kín, phòng lạnh. &nbsp;
<blockquote><img alt=\"tai loc lon 3\" height=\"371\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc.jpg\" title=\"tai loc lon 3\" width=\"1000\" /><br />
&nbsp;<br />
Nhang Mộc là nhà sản xuất và cung cấp Nhang Trầm Thượng Hạng cho người tiêu dùng trong và ngoài nước. Nhang Mộc tự hào mang đến cho bạn một giải pháp thực sự về một dòng “Nhang Sạch” không những chất lượng cao với hương thơm nhẹ nhàng, êm dịu, mà còn đem lại rất nhiều lợi ích cho sức khỏe người tiêu dùng.<br />
<br />
<strong>Nguồn nguyên liệu tự nhiên</strong><br />
Sản phẩm của Nhang Mộc được làm từ 100% trầm hương tự nhiên. Nguyên liệu được tuyển chọn những cây trầm có điều kiện và sức khỏe tốt nhất. Đảm bảo cho ra những sản phẩm với chất lượng cao nhất.<br />
<br />
<strong>Chất lượng luôn được đặt lên hàng đầu</strong><br />
Những sản phẩm được Nhang Mộc tạo ra, trước khi xuất xưởng để đến tay người tiêu dùng đều được trải qua quá trình thẩm định và kiểm định chuyên nghiệp từ độ mùi, trọng lượng, chất lượng bột nhang, tăm nhang cho đến bao bì.<br />
<br />
<strong>Quy trình sản xuất tiên tiến</strong><br />
Nhang Mộc phát triển quy trình sản xuất dựa trên những công nghệ khoa học – kỹ thuật tiên tiến. Nhang Mộc tự tin sản phẩm của mình có thể làm hài lòng tất cả tầng lớp người tiêu dùng.</blockquote>

<h2>Nhang Trầm Sạch: Nhang mộc tài lộc&nbsp;cầu tài lộc, tiền bạc cho công ty cửa hàng</h2>

<p>Theo phong tục của người Việt Nam, “có thờ có thiêng, có kiêng có lành” nên hầu hết ở các công ty, cửa hàng đều có bàn thờ Ông Địa – Thần Tài. Việc thắp nhang vào mỗi buổi sáng để cầu việc làm ăn thuận lợi là điều cần thiết. Tuy nhiên, để đảm bảo sức khỏe cũng như cầu tài lộc thì nên cân nhắc sử dụng nhang mộc tài lộc.</p>
<img alt=\"Nhang mộc tài lộc: cầu tài lộc, tiền bạc cho công ty cửa hàng\" height=\"400\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_4.jpg\" title=\"Nhang mộc tài lộc: cầu tài lộc, tiền bạc cho công ty cửa hàng\" width=\"800\" />
<p>&nbsp;</p>

<h2>Lý do nên sử dụng nhang mộc tài lộc</h2>

<p>Trong văn hóa thờ cúng, việc sử dụng nhang là một điều cần thiết. Tuy nhiên, các loại nhang được bày bán trên thị trường hiện nay, hầu hết đều là nhang được tẩm hóa chất độc hại. Vì vậy khi đốt rất khó ngửi và gây ảnh hưởng không tốt tới sức khỏe của con người.<br />
Đặc biệt ở khu vực cửa hàng hay các công ty là nơi sử dụng nhang mỗi ngày. Đây là nơi tập trung nhiều người qua lại, mua bán và làm việc. Việc đốt nhang có tẩm hóa chất độc hại dù với mục đích cầu tài lộc, nhưng có thể gây nên những ảnh hưởng nghiêm trọng tới sức khỏe cũng như ảnh hưởng đến hiệu quả làm việc. Vì vậy, các chủ cửa hàng, chủ công ty nên lưu ý trong việc chọn nhang. Tốt nhất nên sử dụng nhang được làm từ thảo mộc như nhang mộc tài lộc.</p>
<img alt=\"Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc\" height=\"440\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_3.jpg\" title=\"Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc\" width=\"660\" />
<p>&nbsp;</p>

<h2>Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc</h2>

<p>Nhang mộc là sản phẩm nhang sạch không chỉ được người tiêu dùng trong nước, mà cả người tiêu dùng nước ngoài rất ưa chuộng. Bởi đây là sản phẩm nhang được làm hoàn toàn từ nguyên liệu tự nhiên như: bột trầm hương, keo thực vật (keo cây bời lời) và tăm tre nhập khẩu. Vì vậy, mang đến mùi hương rất dễ chịu dù có thắp nhang ở trong phòng lạnh, đóng kín với diện tích hẹp.<br />
Đối với các cửa hàng hay công ty có nhu cầu thắp nhang vào mỗi buổi sáng để cầu tài lộc, thì sản phẩm nhang mộc tài lộc là lựa chọn không thể nào hoàn hảo hơn. Không chỉ mang ý nghĩa cầu tài lộc, tiền bạc cho công việc làm ăn, buôn bán trong ngày gặp may mắn và thuận lợi. Nhang mộc tài lộc lại không chứa hóa chất hay hương liệu độc hại, khi thắp không hề cay mắt hay xộc mũi, do đó không gây cảm giác khó chịu hay ảnh hưởng tới sức khỏe, tinh thần của mọi người ở xung quanh.<br />
Với mùi thơm nhẹ nhàng và êm dịu do nhang mộc tài lộc mang lại, nhân viên trong công ty tập trung làm việc, khách trong cửa hàng thoải mái đi lại, mua sắm. Nhờ đó cũng có thể góp phần nâng cao hiệu suất làm việc, doanh thu cho công ty hay cửa hàng.<br />
Xu hướng sử dụng nhang sạch đang ngày càng phát triển. Vì vậy, đối với những người làm ăn, kinh doanh như các công ty hay chủ cửa hàng, những người có nhu cầu sử dụng nhang nhiều nên sử dụng nhang mộc tài lộc, vừa mang ý nghĩa cầu tài lộc vừa an toàn cho sức khỏe lại vừa phù hợp với văn hóa thờ cúng của người Việt Nam.<br />
&nbsp;</p>
<img alt=\"Nhang mộc tài lộc\" height=\"480\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_2.jpg\" title=\"Nhang mộc tài lộc\" width=\"720\" />', '', '', '', '1', '1', '1', '15', '5000', '13000', '1613550317', '1', '1613638957', '3', '2', '1', '0', '1', '1', '19000', '17000', '0', '0', '1613643167', '1', '17000', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('3', '1', 'SP985803895', 'Nhang Mộc Tài Lộc 30cm Loại 79 Cây', 'Nhang-Moc-Tai-Loc-30cm-Loai-79-Cay', '59', '4', '2', '400', '30', '6', '1', '1', '1', '1', '2021_02/nhang_moc_tai_loc_600x600_1.jpg', '', '&nbsp;<br />
Không cay mắt không xộc mũi. Không hóa chất, không hương liệu độc hại<br />
Nguồn nguyên liệu đến 99,9% từ thiên nhiên.Mùi trầm hương tự nhiên xanh sạch<br />
Thích hợp cho phòng kín máy lạnh không gian khoảng 25m2. Dành cho khách hàng đốt nhiều nhất là công ty, cửa hàng<br />
Thành phần: bột trầm hương, keo thực vât&nbsp;(keo cây bời lời),&nbsp;tăm tre nhập khẩu.<br />
&nbsp;', '&nbsp;
<h2>Nhang Trầm sạch là gì?</h2>
Từ lâu chúng ta đã quen sử dụng nhang để thắp hương trên bàn thờ tổ tiên, bàn thờ ông địa trong các ngôi nhà hay tại các văn phòng, cửa hàng, cơ quan làm việc. Và loại nhang thường hay sử dụng đó lại chính là loại nhang có tẩm hóa chất độc hại, vì vậy mùi hương sau khi đốt thường lưu lại rất lâu nhưng ngược lại, nó gây ảnh hưởng không nhỏ tới sức khỏe cũng như sinh hoạt của con người.<br />
Với mong muốn sử dụng một loại nhang an toàn, thời gian gần đây mọi người rất quan tâm đến sản phẩm nhang sạch. Vậy nhang trầm sạch là gì?<br />
Nhang Trầm sạch là một loại nhang được sản xuất dựa trên dây chuyền, công nghệ tiên tiến, với thành phần hoàn toàn từ các nguyên liệu có sẵn trong tự nhiên như bột trầm hương, keo thực vật và tăm tre nhập khẩu. Đặc biệt không dùng đến hóa chất hay hương liệu độc hại, nhờ đó mà nhang sạch có mùi trầm thơm tự nhiên, chứ không phải là mùi thơm hắc như nhang có tẩm hóa chất.<br />
&nbsp;<br />
<img alt=\"nhang trầm sạch\" height=\"450\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_1.jpg\" title=\"nhang trầm sạch\" width=\"800\" /><br />
&nbsp;
<h2>Lợi ích khi sử dụng nhang sạch</h2>
Vì nhang trầm&nbsp;sạch được sản xuất hoàn toàn từ trầm hương tự nhiên, không hóa chất, không hương liệu độc hại và phải trải qua quá trình sản xuất, kiểm định gắt gao để cho ra đời những sản phẩm nhang chất lượng. Cho nên sử dụng nhang sạch chúng ta hoàn toàn có thể yên tâm về mặt sức khỏe, &nbsp;khi không gây ra ảnh hưởng nghiêm trọng nào về mắt, da và đường hô hấp. Đặc biệt an toàn với những người bị viêm xoang, dị ứng hay đối tựơng bà bầu, trẻ nhỏ và người già.<br />
Bên cạnh đó, mùi hương từ nhang sạch tỏa ra là mùi trầm thơm tự nhiên, nhẹ dịu nên luôn mang đến cảm giác thư giãn, thỏai mái và dễ chịu. Nhất là khi sử dụng nhang ở những nơi đông người như văn phòng làm việc, cửa hàng hay các buổi hành lễ cũng như trong không gian phòng kín, phòng lạnh. &nbsp;
<blockquote><img alt=\"tai loc lon 3\" height=\"371\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc.jpg\" title=\"tai loc lon 3\" width=\"1000\" /><br />
&nbsp;<br />
Nhang Mộc là nhà sản xuất và cung cấp Nhang Trầm Thượng Hạng cho người tiêu dùng trong và ngoài nước. Nhang Mộc tự hào mang đến cho bạn một giải pháp thực sự về một dòng “Nhang Sạch” không những chất lượng cao với hương thơm nhẹ nhàng, êm dịu, mà còn đem lại rất nhiều lợi ích cho sức khỏe người tiêu dùng.<br />
<br />
<strong>Nguồn nguyên liệu tự nhiên</strong><br />
Sản phẩm của Nhang Mộc được làm từ 100% trầm hương tự nhiên. Nguyên liệu được tuyển chọn những cây trầm có điều kiện và sức khỏe tốt nhất. Đảm bảo cho ra những sản phẩm với chất lượng cao nhất.<br />
<br />
<strong>Chất lượng luôn được đặt lên hàng đầu</strong><br />
Những sản phẩm được Nhang Mộc tạo ra, trước khi xuất xưởng để đến tay người tiêu dùng đều được trải qua quá trình thẩm định và kiểm định chuyên nghiệp từ độ mùi, trọng lượng, chất lượng bột nhang, tăm nhang cho đến bao bì.<br />
<br />
<strong>Quy trình sản xuất tiên tiến</strong><br />
Nhang Mộc phát triển quy trình sản xuất dựa trên những công nghệ khoa học – kỹ thuật tiên tiến. Nhang Mộc tự tin sản phẩm của mình có thể làm hài lòng tất cả tầng lớp người tiêu dùng.</blockquote>

<h2>Nhang Trầm Sạch: Nhang mộc tài lộc&nbsp;cầu tài lộc, tiền bạc cho công ty cửa hàng</h2>

<p>Theo phong tục của người Việt Nam, “có thờ có thiêng, có kiêng có lành” nên hầu hết ở các công ty, cửa hàng đều có bàn thờ Ông Địa – Thần Tài. Việc thắp nhang vào mỗi buổi sáng để cầu việc làm ăn thuận lợi là điều cần thiết. Tuy nhiên, để đảm bảo sức khỏe cũng như cầu tài lộc thì nên cân nhắc sử dụng nhang mộc tài lộc.</p>
<img alt=\"Nhang mộc tài lộc: cầu tài lộc, tiền bạc cho công ty cửa hàng\" height=\"400\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_4.jpg\" title=\"Nhang mộc tài lộc: cầu tài lộc, tiền bạc cho công ty cửa hàng\" width=\"800\" />
<p>&nbsp;</p>

<h2>Lý do nên sử dụng nhang mộc tài lộc</h2>

<p>Trong văn hóa thờ cúng, việc sử dụng nhang là một điều cần thiết. Tuy nhiên, các loại nhang được bày bán trên thị trường hiện nay, hầu hết đều là nhang được tẩm hóa chất độc hại. Vì vậy khi đốt rất khó ngửi và gây ảnh hưởng không tốt tới sức khỏe của con người.<br />
Đặc biệt ở khu vực cửa hàng hay các công ty là nơi sử dụng nhang mỗi ngày. Đây là nơi tập trung nhiều người qua lại, mua bán và làm việc. Việc đốt nhang có tẩm hóa chất độc hại dù với mục đích cầu tài lộc, nhưng có thể gây nên những ảnh hưởng nghiêm trọng tới sức khỏe cũng như ảnh hưởng đến hiệu quả làm việc. Vì vậy, các chủ cửa hàng, chủ công ty nên lưu ý trong việc chọn nhang. Tốt nhất nên sử dụng nhang được làm từ thảo mộc như nhang mộc tài lộc.</p>
<img alt=\"Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc\" height=\"440\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_3.jpg\" title=\"Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc\" width=\"660\" />
<p>&nbsp;</p>

<h2>Nhang mộc tài lộc: mang ý nghĩa cầu tài lộc, tiền bạc</h2>

<p>Nhang mộc là sản phẩm nhang sạch không chỉ được người tiêu dùng trong nước, mà cả người tiêu dùng nước ngoài rất ưa chuộng. Bởi đây là sản phẩm nhang được làm hoàn toàn từ nguyên liệu tự nhiên như: bột trầm hương, keo thực vật (keo cây bời lời) và tăm tre nhập khẩu. Vì vậy, mang đến mùi hương rất dễ chịu dù có thắp nhang ở trong phòng lạnh, đóng kín với diện tích hẹp.<br />
Đối với các cửa hàng hay công ty có nhu cầu thắp nhang vào mỗi buổi sáng để cầu tài lộc, thì sản phẩm nhang mộc tài lộc là lựa chọn không thể nào hoàn hảo hơn. Không chỉ mang ý nghĩa cầu tài lộc, tiền bạc cho công việc làm ăn, buôn bán trong ngày gặp may mắn và thuận lợi. Nhang mộc tài lộc lại không chứa hóa chất hay hương liệu độc hại, khi thắp không hề cay mắt hay xộc mũi, do đó không gây cảm giác khó chịu hay ảnh hưởng tới sức khỏe, tinh thần của mọi người ở xung quanh.<br />
Với mùi thơm nhẹ nhàng và êm dịu do nhang mộc tài lộc mang lại, nhân viên trong công ty tập trung làm việc, khách trong cửa hàng thoải mái đi lại, mua sắm. Nhờ đó cũng có thể góp phần nâng cao hiệu suất làm việc, doanh thu cho công ty hay cửa hàng.<br />
Xu hướng sử dụng nhang sạch đang ngày càng phát triển. Vì vậy, đối với những người làm ăn, kinh doanh như các công ty hay chủ cửa hàng, những người có nhu cầu sử dụng nhang nhiều nên sử dụng nhang mộc tài lộc, vừa mang ý nghĩa cầu tài lộc vừa an toàn cho sức khỏe lại vừa phù hợp với văn hóa thờ cúng của người Việt Nam.<br />
&nbsp;</p>
<img alt=\"Nhang mộc tài lộc\" height=\"480\" src=\"/uploads/retails/2021_02/Nhang-Moc-Tai-Loc_2.jpg\" title=\"Nhang mộc tài lộc\" width=\"720\" />', '', '', '', '1', '1', '1', '169', '0', '0', '1613550398', '1', '1613637631', '3', '3', '1', '1', '1', '1', '30000', '25000', '5', '1', '1613611314', '0', '25000', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('4', '7', 'SP621720820', 'Giá kệ gỗ chữ a 2 tầng treo quần áo  dài 88cm rộng 40cm cao 160cm', 'Gia-ke-go-chu-a-2-tang-treo-quan-ao-dai-88cm-rong-40cm-cao-160cm', '60', '4', '2', '6000', '160', '38', '5', '1', '1', '1', '2021_02/gia-ke-go-treo-quan-ao-chu-a-2-tang-gia-re.png', '', 'Giá kệ gỗ chữ a 2 tầng treo quần áo &nbsp;dài 88cm rộng 40cm cao 160cm', 'Giá kệ gỗ chữ a 2 tầng treo quần áo &nbsp;dài 88cm rộng 40cm cao 160cm', '', '', '', '1', '1', '1', '10', '0', '0', '1613611534', '1', '1613611928', '1', '4', '1', '0', '0', '0', '550000', '0', '0', '0', '0', '0', '550000', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('5', '7', 'SKU680877153', 'Giá kệ gỗ chữ a 1 tầng treo quần áo  dài 88cm rộng 40cm cao 160cm', 'Gia-ke-go-chu-a-1-tang-treo-quan-ao-dai-88cm-rong-40cm-cao-160cm', '60', '4', '2', '5000', '160', '35', '5', '1', '1', '1', '2021_02/gia-ke-go-treo-quan-ao-chu-a-1-tang-tai-tphcm.png', '', 'Giá kệ gỗ chữ a 1 tầng treo quần áo &nbsp;dài 88cm rộng 40cm cao 160cm', 'Giá kệ gỗ chữ a 1 tầng treo quần áo &nbsp;dài 88cm rộng 40cm cao 160cm', '', '', '', '1', '1', '1', '6', '0', '0', '1613612079', '1', '', '', '5', '1', '0', '2', '1', '550000', '0', '5', '1', '0', '0', '550000', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('6', '7', 'SKU914180027', 'Giá kệ gỗ chữ a 1 tầng và vuông 5 tầng dài 128cm rộng 40cm cao 160cm', 'Gia-ke-go-chu-a-1-tang-va-vuong-5-tang-dai-128cm-rong-40cm-cao-160cm', '60', '4', '2', '11000', '160', '38', '12', '1', '1', '1', '2021_02/combo-ke-go-chu-a-1tang-vuong-5-tang.png', '', 'Giá kệ gỗ chữ a 1 tầng và vuông 5 tầng dài 128cm rộng 40cm cao 160cm', 'Giá kệ gỗ chữ a 1 tầng và vuông 5 tầng dài 128cm rộng 40cm cao 160cm', '', '', '', '1', '1', '1', '12', '0', '0', '1613613869', '1', '1613637625', '3', '6', '1', '0', '2', '1', '1350000', '1150000', '0', '0', '0', '0', '1150000', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('7', '7', 'SKU178851497', 'Giá kệ gỗ chữ a 1 tầng và gương 3 tầng dài 130cm rộng 40cm cao 160cm', 'Gia-ke-go-chu-a-1-tang-va-guong-3-tang-dai-130cm-rong-40cm-cao-160cm', '60', '4', '2', '16000', '160', '40', '14', '1', '1', '1', '2021_02/gia-ke-go-treo-quan-ao-chu-a-1-tang-guong-3-tang.png', '', 'Giá kệ gỗ chữ a 1 tầng và gương 3 tầng dài 130cm rộng 40cm cao 160cm', 'Giá kệ gỗ chữ a 1 tầng và gương 3 tầng dài 130cm rộng 40cm cao 160cm', '', '', '', '1', '1', '1', '7', '0', '0', '1613613969', '1', '1613637611', '3', '7', '1', '0', '2', '1', '1650000', '1450000', '0', '0', '0', '0', '1450000', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, store_id, barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product, unit_length, unit_height, unit_width, image, other_image, description, bodytext, keyword, tag_title, tag_description, inhome, allowed_rating, showprice, number_view, price_min, price_max, time_add, user_add, time_edit, user_edit, weight, status, number_order, brand, origin, price, price_special, star, number_rate, time_push, mode_push, price_sort, number_like) VALUES('8', '7', 'SKU454105136', 'Giá kệ gỗ chữ a 2 tầng và vuông 5 tầng 128cm rộng 40cm cao 160cm', 'Gia-ke-go-chu-a-2-tang-va-vuong-5-tang-128cm-rong-40cm-cao-160cm', '60', '4', '2', '13000', '160', '38', '12', '1', '1', '1', '2021_02/gia-ke-go-chu-a-2-tang-vuong-5-tang.png', '', 'Giá kệ gỗ chữ a 2 tầng và vuông 5 tầng 128cm rộng 40cm cao 160cm', 'Giá kệ gỗ chữ a 2 tầng và vuông 5 tầng 128cm rộng 40cm cao 160cm', '', '', '', '1', '1', '1', '7', '0', '0', '1613614077', '1', '1613637606', '3', '8', '1', '0', '2', '1', '1350000', '1150000', '0', '0', '0', '0', '1150000', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product_classify (id, name_classify, product_id, status) VALUES('1', 'sdafsaf', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product_classify_value (id, classify_id, name, status) VALUES('1', '1', 'ádsad', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product_classify_value (id, classify_id, name, status) VALUES('2', '1', 'sadsadsa', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product_classify_value_product (id, classify_id_value1, classify_id_value2, price, price_special, status) VALUES('1', '1', '0', '17000', '13000', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product_classify_value_product (id, classify_id_value1, classify_id_value2, price, price_special, status) VALUES('2', '2', '0', '11000', '5000', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_push_product (id, product_id) VALUES('1', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_push_product (id, product_id) VALUES('2', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_push_product (id, product_id) VALUES('3', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_push_product (id, product_id) VALUES('4', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_push_product (id, product_id) VALUES('5', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_push_product (id, product_id) VALUES('6', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rate (id, product_id, content, image, status, time_add, time_edit, userid, star, other_image) VALUES('1', '3', 'Không cay mắt không xộc mũi. Không hóa chất, không hương liệu độc hại
Nguồn nguyên liệu đến 99,9% từ thiên nhiên', '', '1', '1613553898', '', '1', '5', '2021_02/cau-tai-locdung-nhang-tai-loc.c4d65e5d87c1a5a6261a0082563c87a6.jpg|2021_02/nhang-tram-sach.d68887eb62ebc7bafb5ad892919b44e2.jpg|2021_02/nhang-tram-sach_1.1b7663ccddfbba71a405f122e117f95c.jpg')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rate (id, product_id, content, image, status, time_add, time_edit, userid, star, other_image) VALUES('5', '1', 'dsfdsfsdf', '', '2', '1613632598', '1613633846', '3', '4', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('1', '48', 'Nhang Mộc', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '', 'Phan Ngọc Anh', '0904-999-955', 'nhangmoc@gmail.com', 'unnamed.png', 'unnamed.png', '2', 'Phan Ngọc Anh', '0311222', 'Gò Vấp', '1', '1', '1613535042', '', '', '1', '1', '/tai_loc_lon_3.jpg', 'logo_nhangmoc.png', '', 'Nhang Mộc là nhà sản xuất và cung cấp Nhang Trầm Thượng Hạng cho người tiêu dùng trong và ngoài nước. Nhang Mộc tự hào mang đến cho bạn một giải pháp thực sự về một dòng “Nhang Sạch” không những chất lượng cao với hương thơm nhẹ nhàng, êm dịu, mà còn đem lại rất nhiều lợi ích cho sức khỏe người tiêu dùng.')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('2', '49', 'Freshet - Thiết Bị Lọc Nước', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '2', '1', '1613556109', '', '', '1', '2', '', 'logo_locnuoc.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('3', '18', 'Trà Việt', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'TraViet.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('4', '20', 'Nội Thất Hàn Quốc', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'Leesys.png', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('5', '21', 'Gạch Men Tiến Lịch', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'tienlich.png', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('6', '22', 'Resolver', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'Resolver.png', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('7', '1', 'TMS Retail', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'TMSRetail.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('8', '24', 'vietnam Esports', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'vietnam-esports.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('9', '25', 'Voda', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'Voda-Logo.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('10', '35', 'Studysea', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'Studysea.png', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('11', '27', 'FOURPLUS', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'fourplus.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('12', '28', 'RENCORE', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'rencore.png', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('13', '29', 'Orange Heating Supplies', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'OrangeHeatingSupplies.png', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('14', '30', 'Knudra', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'Knudra.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('15', '31', 'Hồ Gia Trang', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'ho-gia-trang.png', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('18', '50', 'tên doanh nghiệp', 'địa chỉ ngắn gọn', '20', '2086', '20889', 'jkgashdfshag', 'họ tên người đạigfd', '0374-957-684', 'sdflkdsgfsdkjgf@gmail.com', 'binh.jpg', '1-15948998699171250460902.jpg', '2', 'Tên chủ thẻ', '043875523984637', 'Chi nhánh quận 11', '17', '50', '1613635344', '', '', '0', '3', '', '', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('17', '33', 'TMS Bình Dương', '950/54  Nguyễn Kiệm', '70', '7270', '72780', '0904-999-955', 'Phan Ngọc Anh', '0904-999-954', 'freshetdaiien@gmail.com', 'unnamed-1.png', 'unnamed.png', '2', '1', '1', '1', '', '1', '1613556109', '', '', '1', '2', '', 'logo_tmsbinhduong.jpg', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('19', '51', 'Tên doanh nghiệp một', 'dsfsfsf', '18', '1871', '18710', 'sdfsdfsdfds', 'Họ têndfsdfsd', '0374-859-787', 'emailtendangnhap@gmail.com', 'gai-xinh-tha-thinh-bang-nu-hon-ngot-ngao-nhieu-nam-sinh-hi-hung-cho-doi-va-cai-ket-cuoi-ra-nuoc-mat-dspl-1.jpg', 'gai-xinh-tha-thinh-bang-nu-hon-ngot-ngao-nhieu-nam-sinh-hi-hung-cho-doi-va-cai-ket-cuoi-ra-nuoc-mat-dspl-1.jpg', '5', 'thạch cảnh bình', '043875523984637', 'chi nhánh quận 12', '18', '51', '1613635572', '', '', '0', '4', '', '', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_seller_management (id, userid, company_name, address, province_id, district_id, ward_id, tax_code, name, phone, email, image_before, image_after, bank_id, acount_name, acount_number, branch_name, store, user_add, time_add, user_edit, time_edit, status, weight, cover_image, avatar_image, image_banner, description_shop) VALUES('20', '55', 'tên doanh nghiệp', 'fdgfdgfd', '18', '1851', '18519', 'sdfgdfhgfdg', 'Họ tên người đại diện', '0374-826-374', 'sfgfhgjhkhgj@gmail.com', 'binh.jpg', 'cohoangxuan-15940942708281465977546.jpg', '2', 'tên chủ thẻ', '043875523984637', 'Chi nhánh', '19', '55', '1613636460', '', '', '0', '5', '', '', '', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('1', '1', 'DHT00001', '1', '1', 'Phan Ngọc Anh', 'info@tms.vn', '0904999955', '70', '7270', '72780', '950/43 Nguyễn Kiệm', '10.8243596', '106.6793723', '5', '25000', '400', '1', '6', '30', '50100', '1', '25100', 'ED775524561VN ', '50100', '', '', '1613550494', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('2', '2', 'DHT00002', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '70', '7270', '72710', '12515', '10.8273911', '106.6838929', '5', '25000', '400', '1', '6', '30', '0', '0', '25100', '', '50100', '', '', '1613552274', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('3', '3', 'TMS00003', '1', '1', 'thạch cảnh bình', 'thachcanhbinh@gmail.com', '0283746546', '18', '1883', '18830', 'địa chỉ ngắn gọn', '20.8023739', '106.6980211', '5', '15000', '200', '1', '5', '30', '0', '0', '23285', '', '38285', 'lưu ý cho người bán', '', '1613612219', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('4', '3', 'TMS00004', '1', '1', 'sadsadsa', 'sadasdsa@gmail.com', '43543543543', '16', '1622', '16242', 'sdfdsf', '20.7352204', '106.0433901', '5', '15000', '200', '1', '5', '30', '0', '0', '25155', '', '40155', 'sdfds', '', '1613615280', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('5', '3', 'TMS00005', '1', '1', 'sadasdsadsa', 'sadsadsajfsaj@gmail.com', '435435435435', '16', '1632', '16327', 'địa chỉ', '20.9121135', '106.0904721', '5', '15000', '200', '1', '5', '30', '0', '0', '25155', '', '40155', '', '', '1613616088', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('6', '48', 'TMS00006', '7', '7', 'sdfdsfsdf', 'sdfsdfsdfd@gmail.com', '43543543545', '18', '1851', '18517', 'rgrdgbrd', '20.8220411', '106.653783', '5', '550000', '5000', '5', '35', '160', '0', '0', '67215', '', '617215', 'dsfdsfdsf', '', '1613622379', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('7', '48', 'TMS00007', '7', '7', 'sadsadsad', 'asdsadsad@gmail.com', '42343243243', '17', '1754', '17542', 'sdcdscf', '20.8650335', '106.3375493', '5', '550000', '5000', '5', '35', '160', '0', '0', '76345', '', '626345', '', '', '1613622634', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('8', '48', 'TMS00008', '7', '7', 'sdfsdfdsfsd', 'sdfdsfds@gmial.cin', '435345435', '20', '2075', '20776', 'sadsa', '20.9191199', '106.8119382', '5', '550000', '5000', '5', '35', '160', '0', '0', '67215', '5FALX6NA', '617215', '', '', '1613622693', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('9', '48', 'TMS00009', '7', '7', 'sadsadsadsa', 'sadsafdsgfdg@gmail.com', '43543543554', '17', '1754', '17542', 'fgvfdv', '20.8650335', '106.3375493', '5', '550000', '5000', '5', '35', '160', '0', '0', '76345', '10345381626', '626345', '', '', '1613623246', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('10', '3', 'TMS000010', '1', '1', 'adasdsadsads', 'sadsadsadsa@gmail.com', '435345345435', '20', '2075', '20773', 'retretert', '20.9069323', '106.7983639', '5', '30000', '400', '2', '10', '60', '0', '0', '26915', 'S1.A1.17373471', '56915', 'retretr', '', '1613631472', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('11', '2', 'TMS000011', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '42000', '700', '2', '11', '70', '0', '0', '34450', 'EE778630768VN', '76450', '', '', '1613635652', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('12', '1', 'TMS000012', '1', '1', '089980089', 'info@tms.vn', '0900099444', '10', '1424', '15346', '434b', '21.1262106', '105.6676471', '5', '75000', '1200', '3', '18', '90', '114455', '1', '39455', 'CA496407426VN', '114455', '', '', '1613699574', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('13', '1', 'TMS000013', '1', '1', '545654', '45@gmail.com', '34534', '16', '1622', '16242', 'fdgdfgdf', '20.7352204', '106.0433901', '5', '45000', '600', '3', '15', '90', '81595', '1', '36595', '', '81595', '', '', '1613699802', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('14', '2', 'TMS000014', '1', '1', 'Đặng Thành Đạt', 'stata@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '1', '28015', '', '53015', '', '', '1613699927', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('15', '3', 'TMS000015', '1', '1', 'sadsadsa', 'sadsad@gmail.com', '43543543545', '16', '1632', '16320', 'sadsad', '20.9455817', '106.0434449', '5', '40000', '600', '2', '11', '60', '0', '0', '36595', '', '76595', '', '', '1613706315', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('16', '3', 'TMS000016', '1', '1', 'dfgsdf', 'sdfdsfds@gmial.cin', '0384756475', '17', '1731', '17327', 'địa chỉ', '20.9094037', '106.5186355', '5', '15000', '200', '1', '5', '30', '0', '0', '25155', '', '40155', '', '', '1613706389', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('17', '2', 'TMS000017', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '15000', '200', '1', '5', '30', '38725', '2', '23725', '', '38725', '', '', '1613719986', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('18', '2', 'TMS000018', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613720174', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('19', '2', 'TMS000019', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '15000', '200', '1', '5', '30', '38725', '2', '23725', '', '38725', '', '', '1613720240', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('20', '2', 'TMS000020', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '0', '0', '28015', '', '53015', '', '', '1613720297', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('21', '2', 'TMS000021', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613720389', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('23', '2', 'TMS000023', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613720495', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('24', '2', 'TMS000024', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1251559', '105.6614372', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613721117', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_static_order (id, userid, order_code, store_id, warehouse_id, order_name, email, phone, province_id, district_id, ward_id, address, lat, lng, transporters_id, total_product, total_weight, total_height, total_width, total_length, payment, payment_method, fee_transport, shipping_code, total, note, link_check_ahamove_order, time_add, status) VALUES('25', '2', 'TMS000025', '1', '1', 'Thạch Cảnh Bình', 'bnhthach@gmail.com', '0374973039', '10', '1424', '15346', '12515', '21.1262106', '105.6676471', '5', '25000', '400', '1', '6', '30', '53015', '2', '28015', '', '53015', '', '', '1613722227', '0')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order (ìd, status_id, name) VALUES('1', '0', 'Mới tạo')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order (ìd, status_id, name) VALUES('2', '1', 'Đã xác nhận')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order (ìd, status_id, name) VALUES('3', '2', 'Đang giao hàng')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order (ìd, status_id, name) VALUES('4', '3', 'Đã giao')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order (ìd, status_id, name) VALUES('5', '4', 'Hủy')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order (ìd, status_id, name) VALUES('6', '5', 'Tiền đã nhận')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order (ìd, status_id, name) VALUES('7', '6', 'Trả hàng/Hoàn tiền')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('1', 'ready_to_pick', 'Đơn hàng được tạo thành công

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('2', 'picking', 'Nhân viên giao hàng đang trên đường lấy hàng

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('3', 'cancel	
', 'Đơn hàng bị hủy

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('4', 'money_collect_picking	
', 'Nhân viên giao hàng đang tương tác với chủ shop

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('5', 'picked', 'Nhân viên giao hàng đã lấy hàng thành công

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('6', 'storing', 'Đơn hàng đang được lưu tại kho GHN

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('7', 'transporting', 'Đơn hàng đang được chung chuyển

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('8', 'sorting', 'Đơn hàng đang được phân loại tại kho phân loại

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('9', 'delivering', 'Đơn hàng đang được giao tới người nhận

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('10', 'money_collect_delivering', 'Nhân viên giao hàng đang tương tác với người bán

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('11', 'delivered', 'Đơn hàng được giao thành công

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('12', 'delivery_fail', 'Đơn hàng giao thất bại

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('13', 'waiting_to_return', 'Đơn hàng đang trong hàng chờ hoàn trả (có thể giao lại trong 24/48h)

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('14', 'return', 'Đơn hàng đang đợi nhân viên giao hàng đến trả cho chủ shop sau 3 lần giao hàng lại thất bại

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('15', 'return_transporting', 'Đơn hàng đang được chung chuyển giữa các kho

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('16', 'return_sorting	
', 'Đơn hàng đang được phân loại tại kho phân loại của GHN

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('17', 'returning', 'Nhân viên giao hàng đang đi trả hàng

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('18', 'return_fail', 'Đơn hàng bị trả thất bại

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('19', 'returned', 'Đơn hàng được hoàn trả thành công

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('20', 'exception	
', 'Đơn hàng được xử lý ngoại lệ (trường hợp không đi đúng quy trình)

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('21', 'damage', 'Đơn hàng bị tác động làm hư hại

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghn (id, status, name) VALUES('22', 'lost	
', 'Đơn hàng bị mất

')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('1', '-1', 'Hủy đơn hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('2', '1', 'Chưa tiếp nhận
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('3', '2', 'Đã tiếp nhận')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('4', '3', 'Đã lấy hàng/Đã nhập kho
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('5', '4', 'Đã điều phối giao hàng/Đang giao hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('6', '5', 'Đã giao hàng/Chưa đối soát
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('7', '6', 'Đã đối soát
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('8', '7', 'Không lấy được hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('9', '8', 'Hoãn lấy hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('10', '9', 'Không giao được hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('11', '10', 'Delay giao hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('12', '11', 'Đã đối soát công nợ trả hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('13', '12', 'Đã điều phối lấy hàng/Đang lấy hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('14', '13', 'Đơn hàng bồi hoàn
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('15', '20', 'Đang trả hàng (COD cầm hàng đi trả)
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('16', '21', 'Đã trả hàng (COD đã trả xong hàng)
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('17', '123', 'Shipper báo đã lấy hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('18', '127', 'Shipper (nhân viên lấy/giao hàng) báo không lấy được hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('19', '128', 'Shipper báo delay lấy hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('20', '45', 'Shipper báo đã giao hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('21', '49', 'Shipper báo không giao được giao hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_order_ghtk (id, status, name) VALUES('22', '410', 'Shipper báo delay giao hàng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('1', '0', 'Giao dịch thành công')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('2', '1', 'Giao dịch đã tồn tại
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('3', '2', 'Merchant không hợp lệ (kiểm tra lại vnp_TmnCode)
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('4', '3', 'Dữ liệu gửi sang không đúng định dạng
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('5', '4', 'Khởi tạo GD không thành công do Website đang bị tạm khóa
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('6', '5', 'Giao dịch không thành công do: Quý khách nhập sai mật khẩu quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('7', '13', 'Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('8', '7', 'Giao dịch bị nghi ngờ là giao dịch gian lận
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('9', '9', 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('10', '10', 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('11', '11', 'Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('12', '12', 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('13', '51', 'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('14', '65', 'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('15', '8', 'Giao dịch không thành công do: Hệ thống Ngân hàng đang bảo trì. Xin quý khách tạm thời không thực hiện giao dịch bằng thẻ/tài khoản của Ngân hàng này.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('16', '99', 'Các lỗi khác (lỗi còn lại, không có trong danh sách mã lỗi đã liệt kê)
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('17', '91', 'Không tìm thấy giao dịch yêu cầu
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('19', '97', 'Chữ ký không hợp lệ
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('20', '93', 'Số tiền hoàn trả không hợp lệ. Số tiền hoàn trả phải nhỏ hơn hoặc bằng số tiền thanh toán.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('21', '94', 'Giao dịch đã được gửi yêu cầu hoàn tiền trước đó. Yêu cầu này VNPAY đang xử lý
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_status_vnpay (id, status_id, name) VALUES('22', '95', 'Giao dịch này không thành công bên VNPAY. VNPAY từ chối xử lý yêu cầu.
')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tabs (id, name_tabs, image, content_id, time_add, user_add, time_edit, user_edit, weight, status) VALUES('1', 'Chi tiết sản phẩm', '1200x630wa.png', '1', '1608709769', '2', '1608710769', '2', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tabs (id, name_tabs, image, content_id, time_add, user_add, time_edit, user_edit, weight, status) VALUES('2', 'Thảo luận', '1608710824.jpg', '2', '1608710593', '1', '1608710826', '2', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tabs (id, name_tabs, image, content_id, time_add, user_add, time_edit, user_edit, weight, status) VALUES('3', 'Đánh giá', 'icon-sinh-trac.gif', '3', '1608710599', '1', '1608710855', '2', '3', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('1', 'Đồng giá 25k (SGN-DG)', 'SGN-DG', 'SGN-DG', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732615', '2', '1', '3')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('2', 'Giao hàng tiết kiệm', '', 'GHTK', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', 'image_2020_10_15t12_43_10_022z-64.png', '0', '0', '1609732500', '2', '1', '13')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('3', 'Giao hàng nhanh (Standard)', '2', 'GHN', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', 'giao_hang_nhanh_toan_quoc_colorb7d18fe5_1594632551.png', '0', '0', '1609808550', '1', '1', '14')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('6', 'Viettel Post TMDT Bay', 'NCOD', 'Viettel Post', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', 'fot_payment2_logo_3_adeaafb66a984ecf9070f8f10d934158_large.png', '1', '0', '1609732528', '2', '1', '16')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('5', 'VNPOST Tiết Kiệm', 'BK', 'VNPOST', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '500000000', '16000000', '160000000', '160000000', 'buu-dien-vnpost-1280x720.png', '1', '0', '1612516302', '41', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('4', 'VNPOST Nhanh', 'EMS', 'VNPOST', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '5000', '160', '160', '160', 'buu-dien-vnpost-1280x720.png', '0', '0', '1613536023', '1', '1', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('7', 'Viettel Post TMDT Phát nhanh 2h', 'V02', 'Viettel Post', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', 'fot_payment2_logo_3_adeaafb66a984ecf9070f8f10d934158_large.png', '0', '0', '1609732537', '2', '1', '17')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('8', 'Viettel Post TMDT Bộ', 'LCOD', 'Viettel Post', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', 'fot_payment2_logo_3_adeaafb66a984ecf9070f8f10d934158_large.png', '1', '0', '1609732545', '2', '1', '18')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('9', 'Viettel Post TMDT Phát hôm sau', 'PHS', 'Viettel Post', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', 'fot_payment2_logo_3_adeaafb66a984ecf9070f8f10d934158_large.png', '1', '0', '1609732553', '2', '1', '19')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('11', 'Giao hàng nhanh (Express)', '1', 'GHN', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', 'giao_hang_nhanh_toan_quoc_colorb7d18fe5_1594632551.png', '1', '0', '1613536278', '1', '1', '15')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('13', 'Giao gần (SGN-EXPRESS)', 'SGN-EXPRESS', 'SGN-EXPRESS', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732482', '2', '1', '11')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('14', 'Siêu tốc (SGN-BIKE)', 'SGN-BIKE', 'SGN-BIKE', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732474', '2', '1', '10')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('15', 'Siêu rẻ (SGN-POOL)', 'SGN-POOL', 'SGN-POOL', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732647', '2', '1', '9')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('16', '4h (SGN-SAMEDAY)', 'SGN-SAMEDAY', 'SGN-SAMEDAY', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732643', '2', '1', '8')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('17', 'Giao gần (HAN-EXPRESS)', 'HAN-EXPRESS', 'HAN-EXPRESS', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732623', '2', '1', '5')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('18', 'Siêu tốc (HAN-BIKE)', 'HAN-BIKE', 'HAN-BIKE', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732628', '2', '1', '6')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('19', 'Siêu rẻ (HAN-POOL)', 'HAN-POOL', 'HAN-POOL', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732637', '2', '1', '7')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('20', '4h (HAN-SAMEDAY)', 'HAN-SAMEDAY', 'HAN-SAMEDAY', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732492', '2', '1', '12')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters (id, name_transporters, code_transporters, symbol_transporters, description, max_weight, max_length, max_width, max_height, image, type, money, time_edit, user_edit, status, weight) VALUES('21', 'Đồng giá 25k (HAN-DG)', 'HAN-DG', 'HAN-DG', 'Thời gian giao hàng khoảng 2 ngày HCM và  5 - 7 ngày toàn quốc', '50000', '160', '160', '160', '1550114191385-qa53mg.png', '1', '0', '1609732619', '2', '1', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('1', '1', '5', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('2', '1', '4', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('3', '1', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('4', '1', '21', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('5', '1', '17', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('6', '1', '18', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('7', '1', '19', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('8', '1', '16', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('9', '1', '15', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('10', '1', '14', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('11', '1', '13', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('12', '1', '20', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('13', '1', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('14', '1', '3', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('15', '1', '11', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('16', '1', '6', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('17', '1', '7', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('18', '1', '8', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('19', '1', '9', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('20', '7', '5', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('21', '7', '4', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('22', '7', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('23', '7', '21', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('24', '7', '17', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('25', '7', '18', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('26', '7', '19', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('27', '7', '16', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('28', '7', '15', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('29', '7', '14', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('30', '7', '9', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('31', '7', '8', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('32', '7', '7', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('33', '7', '6', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('34', '7', '11', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('35', '7', '3', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('36', '7', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('37', '7', '20', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_transporters_shop (id, sell_id, transporters_id, status) VALUES('38', '7', '13', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('4', 'Combo', '1608799147', '1', '1', '1608799152', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('5', 'Cái', '1611299308', '1', '', '', '3', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('6', 'Chiếc', '1611299311', '1', '1', '1611299316', '4', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('7', 'Đôi', '1612514908', '41', '', '', '2', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('8', 'Chai', '1612514935', '41', '', '', '5', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('9', 'Tuýp', '1612514960', '41', '', '', '6', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('10', 'Bộ', '1613612456', '1', '', '', '7', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('11', 'Hộp', '1613612461', '1', '', '', '8', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('12', 'Lít', '1613612467', '1', '', '', '9', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('13', 'M', '1613612470', '1', '', '', '10', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('14', 'Gram', '1613612476', '1', '', '', '11', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, name, time_add, user_add, time_edit, user_edit, weight, status) VALUES('15', 'Kg', '1613612480', '1', '', '', '12', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit_currency (id, name_currency, symbol, exchange, time_add, user_add, time_edit, user_edit, status, weight) VALUES('1', 'Vietnam Dong', 'đ', '1', '1608714257', '2', '1608952053', '2', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit_currency (id, name_currency, symbol, exchange, time_add, user_add, time_edit, user_edit, status, weight) VALUES('2', 'US Dollar', '$', '21000', '1608714262', '2', '1608952028', '2', '0', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit_currency (id, name_currency, symbol, exchange, time_add, user_add, time_edit, user_edit, status, weight) VALUES('4', 'Euro (EUR)', '€', '27994.43', '1608952360', '2', '1608952398', '2', '0', '4')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit_length (id, name_length, symbol, exchange, time_add, user_add, time_edit, user_edit, status, length) VALUES('1', 'Cm', 'cm', '1', '1608785942', '2', '1611301068', '1', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit_length (id, name_length, symbol, exchange, time_add, user_add, time_edit, user_edit, status, length) VALUES('2', 'Met', 'm', '100', '1608785955', '2', '1608799364', '1', '0', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit_weight (id, name_weight, symbol, exchange, time_add, user_add, time_edit, user_edit, status, weight) VALUES('2', 'Gram', 'g', '1', '1608708187', '2', '1608971919', '2', '1', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit_weight (id, name_weight, symbol, exchange, time_add, user_add, time_edit, user_edit, status, weight) VALUES('3', 'Kilogam', 'kg', '1000', '1608714236', '2', '1608971925', '2', '1', '2')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('1', '1', 'Nhang Mộc Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '1', '1613639814', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('2', '2', 'Freshet Gò Vấp', 'Phan Ngọc Anh', '0904-999-954', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1453354', '10.8243596', '106.6793723', '8770943', '358755', '1', '1613556109', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('3', '3', 'Nhang Mộc Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('4', '4', 'Nhang Mộc Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('5', '5', 'Nhang Mộc Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('6', '6', 'Nhang Mộc Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('7', '7', 'Nhang Mộc Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('8', '8', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('9', '9', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('10', '10', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('11', '11', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('12', '12', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('13', '13', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('14', '14', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('15', '15', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('16', '17', 'Gò Vấp', 'Phan Ngọc Anh', '0904-999-955', '950/43 Nguyễn Kiệm', '70', '7270', '72780', '1452803', '10.8243596', '106.6793723', '8769451', '358755', '1', '1613535042', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('17', '18', 'kh 1', 'thạch cảnh bình', '0374-957-684', 'địa chỉ tuyển dụng', '70', '7250', '72550', '1454171', '10.7973443', '106.687347', '8772829', '358755', '50', '1613635344', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('18', '19', 'kho quận 1', 'thạch cảnh bình', '0374-859-787', 'địa chỉ tuyển dụng', '70', '7270', '72850', '1454175', '10.8386779', '106.6652904', '8772832', '358755', '51', '1613635572', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse (id, sell_id, name_warehouse, name_send, phone_send, address, province_id, district_id, ward_id, shops_id_ghn, lat, lng, groupaddressId, cusId, user_add, time_add, user_edit, time_edit, status) VALUES('19', '20', 'kho quận 1', 'thạch cảnh bình', '0374-826-374', 'fdbgfdgfdgf', '70', '7270', '72770', '1454199', '10.8347203', '106.6394461', '8773111', '358755', '55', '1613636460', '', '', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import (warehouse_product_import_id, warehouse_product_import_code, store_id, warehouse_id, title, total_price, total_amount, time_add, user_add) VALUES('1', 'NK000001', '1', '1', 'Nhập kho ngày: 17-02-2021', '15000', '100', '1613550244', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import (warehouse_product_import_id, warehouse_product_import_code, store_id, warehouse_id, title, total_price, total_amount, time_add, user_add) VALUES('2', 'NK000002', '1', '1', 'Nhập kho ngày: 17-02-2021', '25000', '100', '1613550413', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import (warehouse_product_import_id, warehouse_product_import_code, store_id, warehouse_id, title, total_price, total_amount, time_add, user_add) VALUES('3', 'NK000003', '1', '1', 'Nhập kho ngày: 17-02-2021', '17000', '100', '1613550425', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import (warehouse_product_import_id, warehouse_product_import_code, store_id, warehouse_id, title, total_price, total_amount, time_add, user_add) VALUES('4', 'NK000004', '7', '7', 'Nhập kho ngày: 18-02-2021', '550000', '10', '1613611921', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import (warehouse_product_import_id, warehouse_product_import_code, store_id, warehouse_id, title, total_price, total_amount, time_add, user_add) VALUES('5', 'NK000005', '7', '7', 'Nhập kho ngày: 18-02-2021', '500000', '10', '1613612090', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import_item (id, warehouse_product_import_id, product_id, classify_value_product_id, price_import, amount, unit_currency) VALUES('1', '1', '1', '0', '15000', '100', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import_item (id, warehouse_product_import_id, product_id, classify_value_product_id, price_import, amount, unit_currency) VALUES('2', '2', '3', '0', '25000', '100', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import_item (id, warehouse_product_import_id, product_id, classify_value_product_id, price_import, amount, unit_currency) VALUES('3', '3', '2', '0', '17000', '100', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import_item (id, warehouse_product_import_id, product_id, classify_value_product_id, price_import, amount, unit_currency) VALUES('4', '4', '4', '0', '550000', '10', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_warehouse_import_item (id, warehouse_product_import_id, product_id, classify_value_product_id, price_import, amount, unit_currency) VALUES('5', '5', '5', '0', '500000', '10', '1')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}

try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('1', '3', '1613551451', '1', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('3', '2', '1613611768', '3', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('7', '7', '1613618556', '3', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('6', '8', '1613618351', '3', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('8', '6', '1613618590', '3', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('10', '4', '1613618660', '3', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('36', '8', '1613698479', '48', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('37', '7', '1613698484', '48', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('34', '2', '1613698473', '48', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('33', '3', '1613698427', '48', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('27', '7', '1613640820', '1', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('23', '5', '1613640812', '1', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('24', '6', '1613640813', '1', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('26', '8', '1613640818', '1', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
try {
    $db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_wishlist (id, product_id, time_add, userid, shop_id) VALUES('38', '6', '1613698486', '48', '')");
} catch (PDOException $e) {
    trigger_error($e->getMessage());
}
