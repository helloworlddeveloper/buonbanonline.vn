<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS (contact@tms.vn)
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 01/01/2021 09:47
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$module_version = array(
    'name' => 'nvtools',
    'modfuncs' => 'main,theme,data,addfun,action,export_excel,block,themecopy,thememodulecp,compiler,copylang',
    'submenu' => 'main,theme,data,addfun,action,export_excel,block,themecopy,thememodulecp,compiler,copylang',
    'is_sysmod' => 0,
    'virtual' => 0,
    'version' => '4.0.24',
    'date' => 'Wed, 1 Nov 2021 4:50:45 GMT',
    'author' => 'TMS HOLDINGS (contact@tms.vn)',
    'uploads_dir' => array(
        $module_upload,
        $module_upload . '/compiler'
    ),
    'note' => 'Công cụ xây dựng site',
    'layoutdefault' => 'body:main,theme,data,addfun,themecopy,thememodulecp'
);
