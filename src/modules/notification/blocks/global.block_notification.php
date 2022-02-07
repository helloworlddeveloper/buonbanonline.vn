<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_block_notification')) {

    function nv_block_notification($block_config)
    {
        global $module_name, $module_info, $site_mods, $module_config, $lang_global, $global_config, $db, $user_info;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/block_notification.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        if ($module_name == $module) {
            return '';
        } elseif (file_exists(NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php')) {
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_INTERFACE . '.php';
        }
        
        $xtpl = new XTemplate('block_notification.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
        $xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
        $xtpl->assign('URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module);
		
		
		// NV_NOTIFICATION_GLOBALTABLE
        
        if (defined('NV_IS_USER')) {
			
			
			$db->sqlreset()
			->select('COUNT(*)')
			->from(NV_NOTIFICATION_USER)
			->where('language = "' . NV_LANG_DATA . '" AND (area = 1 OR area = 2)  AND (send_to = 0 OR send_to=' . $user_info['userid'] . ')');
			
			$all_pages = $db->query($db->sql())->fetchColumn();
			if($all_pages >= 10)
			{
				$xtpl->parse('main.readmore');
			}
			
			$xtpl->parse('main.user');
			
		}
		
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_notification($block_config);
}