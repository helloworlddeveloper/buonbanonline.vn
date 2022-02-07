<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/25/2010 18:6
 */

if (!defined('NV_SYSTEM')) {
    die('Stop!!!');
}

global $site_mods, $db_config, $client_info, $global_config, $module_file, $module_name, $user_info, $lang_global, $my_head, $admin_info, $blockID, $op;

$content = '';

if ($global_config['allowuserlogin']) {
    if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/users/block.user_button.tpl')) {
        $block_theme = $global_config['module_theme'];
    } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/users/block.user_button.tpl')) {
        $block_theme = $global_config['site_theme'];
    } else {
        $block_theme = 'default';
    }
    if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/css/users.css')) {
        $block_css = $global_config['module_theme'];
    } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/css/users.css')) {
        $block_css = $global_config['site_theme'];
    } else {
        $block_css = '';
    }
    if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/js/users.js')) {
        $block_js = $global_config['module_theme'];
    } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/js/users.js')) {
        $block_js = $global_config['site_theme'];
    } else {
        $block_js = 'default';
    }

    $xtpl = new XTemplate('block.user_button.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/users');

    if ($site_mods[$block_config['module']]['module_file'] != $module_file) {
        if (file_exists(NV_ROOTDIR . '/modules/users/language/' . NV_LANG_INTERFACE . '.php')) {
            include NV_ROOTDIR . '/modules/users/language/' . NV_LANG_INTERFACE . '.php';
        } else {
            include NV_ROOTDIR . '/modules/users/language/vi.php';
        }
        if (!empty($block_css)) {
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_css . '/css/users.css">';
        }
    } else {
        global $lang_module;
    }

    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('BLOCKID', $blockID);
    $xtpl->assign('BLOCK_THEME', $block_theme);
    $xtpl->assign('BLOCK_CSS', $block_css);
    $xtpl->assign('BLOCK_JS', $block_js);

    if (defined('NV_IS_USER')) {
        if (!empty($user_info['photo'])) {
            $avata = NV_BASE_SITEURL . $user_info['photo'];
        } else {
            $avata = NV_BASE_SITEURL . 'themes/' . $block_theme . '/images/users/no_avatar.png';
        }

        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
        $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
        $xtpl->assign('URL_LOGOUT', defined('NV_IS_ADMIN') ? 'nv_admin_logout' : 'bt_logout');
        $xtpl->assign('MODULENAME', $module_info['custom_title']);
        $xtpl->assign('AVATA', $avata);
        $xtpl->assign('USER', $user_info);
		
		if($module_name == 'retails')
		{
			if($op =='address')
			{
				$xtpl->assign('active_address', 'secondary_text');
			}
			elseif($op =='wishlist')
			{
				$xtpl->assign('active_love', 'secondary_text');
			}
			elseif($op =='follow')
			{
				$xtpl->assign('active_follow', 'secondary_text');
			}
			elseif($op =='ordercustomer')
			{
				$xtpl->assign('active_ordercustomer', 'secondary_text');
			}
			elseif($op =='re-payment')
			{
				$xtpl->assign('active_repayment', 'secondary_text');
			}
			elseif($op =='complain-list')
			{
				$xtpl->assign('active_complain', 'secondary_text');
			}
		}
		
		if($module_name == 'users')
		{
			if($op == 'changepassword')
			{
				$xtpl->assign('active_changepassword', 'secondary_text');
			}
			elseif($op == 'main')
			{
				$xtpl->assign('active_user', 'secondary_text');
			}
		}
		//print($module_name);die;
        
        $xtpl->assign('URL_MODULE', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users',true));
		
        $xtpl->assign('ADDRESS', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=address', true));
		
        $xtpl->assign('PASSWORD', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=changepassword', true));
		
        $xtpl->assign('LOVE', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=wishlist', true));
		
		$xtpl->assign('FOLLOW', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=follow', true));
		
        $xtpl->assign('HISTORY', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=ordercustomer', true));
		
        $xtpl->assign('REPAYMENT', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=re-payment', true));
		
        $xtpl->assign('COMPLAIN', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=retails&amp;' . NV_OP_VARIABLE . '=complain-list', true));

		 $xtpl->assign('LOSTPASS', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=lostpass', true));

        //$xtpl->assign('PASSWORD', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=avatar/upd', true));
		
       
      

        $xtpl->parse('signed');
        $content = $xtpl->text('signed');
    }
}
