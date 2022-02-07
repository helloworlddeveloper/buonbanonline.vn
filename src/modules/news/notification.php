<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Apr 20, 2010 10:47:41 AM
 */


$lang_siteinfo = nv_get_lang_module($mod);

$data['title'] = $data['content'];
$data['link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $data['obid'];

if($data['obid'])
{
	$news = $db->query('SELECT t1.alias as rows_alias, t2.alias cat_alias FROM ' . NV_PREFIXLANG . '_' . $data['module'] . '_rows t1, ' . NV_PREFIXLANG . '_' . $data['module'] . '_cat t2 WHERE t1.catid = t2.catid AND t1.id='. $data['obid'])->fetch();
}
$data['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $data['module'] . '&amp;' . NV_OP_VARIABLE . '=' . $news['cat_alias'] . '/' . $news['rows_alias'] . '-' . $data['obid'], true );
