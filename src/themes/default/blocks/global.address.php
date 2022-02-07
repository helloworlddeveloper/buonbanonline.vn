<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 04 May 2014 12:41:32 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_menu_theme_address')) {
    /**
     * nv_menu_theme_social_config()
     *
     * @param mixed $module
     * @param mixed $data_block
     * @param mixed $lang_block
     * @return
     */
	 
    function nv_menu_theme_address_config($module, $data_block, $lang_block)
    {
		$html .= '<div class="form-group">';
        $html .= '	<label class="control-label col-sm-6">TB.bộ công thương:</label>';
        $html .= '	<div class="col-sm-18"><input type="text" name="config_bocongthuong" class="form-control" value="' . $data_block['bocongthuong'] . '"/></div>';
        $html .= '</div>';
		
		$html .= '<div class="form-group">';
        $html .= '	<label class="control-label col-sm-6">Nói không với hàng giả:</label>';
        $html .= '	<div class="col-sm-18"><input type="text" name="config_nofake" class="form-control" value="' . $data_block['nofake'] . '"/></div>';
        $html .= '</div>';
		
        return $html;
    }

    /**
     * nv_menu_theme_social_submit()
     *
     * @param mixed $module
     * @param mixed $lang_block
     * @return
     */
    function nv_menu_theme_address_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config']['bocongthuong'] = $nv_Request->get_title('config_bocongthuong', 'post');
        $return['config']['nofake'] = $nv_Request->get_title('config_nofake', 'post');
        return $return;
    }

    /**
     * nv_menu_theme_address()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_menu_theme_address($block_config)
    {
        global $global_config, $site_mods, $lang_global;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks/global.address.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.address.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.address.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('LANG', $lang_global);
        $xtpl->assign('BLOCK_THEME', $block_theme);
        $xtpl->assign('DATA', $block_config);
        
		if (!empty($block_config['bocongthuong'])) {
            $xtpl->parse('main.bocongthuong');
        }if (!empty($block_config['nofake'])) {
            $xtpl->parse('main.nofake');
        }
        if (isset($site_mods['feeds'])) {
            $xtpl->assign('FEEDS_HREF', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=feeds');
            $xtpl->parse('main.feeds');
			}
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_menu_theme_address($block_config);
}
