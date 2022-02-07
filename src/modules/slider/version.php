<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANGDINHTU (dlinhvan@gmail.com)
 * @Copyright (C) 2016 Nuke.vn - dangdinhtu.com. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate  Mon, 11 Jul 2016 23:00:00 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(  
	'name' => 'Slider', 
	'modfuncs' => 'main', 
	'submenu' => 'main', 
	'is_sysmod' => 0, 
	'virtual' => 1,  
	'version' => '4.0.29',  
	'date' => 'Mon, 11 Jul 2016 23:00:00 GMT',  
	'author' => 'DANGDINHTU (dlinhvan@gmail.com)',  
	'uploads_dir' => array(
		$module_name,
		$module_name.'/images',
		$module_name.'/thumbs',
		$module_name.'/temp'
	),  
	'note' => '' 
);