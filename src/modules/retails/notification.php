<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Apr 20, 2010 10:47:41 AM
 */


$lang_siteinfo = nv_get_lang_module($mod);

if($data['send_to'])
{
	// lấy tên cửa hàng
	
	$data['send_to'] = $db->query('SELECT company_name FROM tms_vi_retails_seller_management WHERE id ='. $data['send_to'])->fetchColumn();
	
	
}
else
{
	$data['send_to'] = '';
}

$data['title'] = sprintf("%s %s", $data['send_to'], $data['content']);


