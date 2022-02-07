<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 23 Dec 2020 04:14:15 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
$currentpathblock = NV_UPLOADS_DIR . '/' . $module_upload . '/block';
if (!file_exists($currentpathblock)) {
    nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $module_upload. '/block/' , true);
}

if ($nv_Request->isset_request('submit', 'post')) {
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['keyword'] = $nv_Request->get_title('keyword', 'post', '');
    $row['description_block'] = $nv_Request->get_title('description_block', 'post', '');
    $row['bodytext'] = $nv_Request->get_editor('bodytext', '', NV_ALLOWED_HTML_TAGS);

    $row['tag_title'] = $nv_Request->get_title('tag_title', 'post', '');
    $row['tag_description'] = $nv_Request->get_title('tag_description', 'post', '');



	$titleblock = $nv_Request->get_typed_array('titleblock', 'post', 'string');
	$link = $nv_Request->get_typed_array('link', 'post', 'string');
    $img = $nv_Request->get_typed_array('img', 'post', 'string');
	$array_other = array( );
	foreach( $titleblock as $key=>$value )
	{ 	
        $title_tmp = $titleblock[$key];
        $link_tmp = $link[$key];
        $img_tmp = $img[$key];

		if( !empty( $value )  )
		{
			$array_other[] = $title_tmp .';' . $link_tmp. ';' . $img_tmp;
		}
	}
	$row['other'] = implode( '|', $array_other );


    if (empty($row['title'])) {
        $error[] = $lang_module['error_required_title'];
    }

    if (empty($error)) {
		 
	 
        try {
			
            if (empty($row['id'])) {
                $row['time_add'] = NV_CURRENTTIME;
                $row['user_add'] = $admin_info['userid'];

                $stmt = $db->prepare('INSERT INTO ' . TABLE . '_block (title, keyword, description_block, bodytext, other,tag_title, tag_description, time_add, user_add, weight, status) VALUES (:title, :keyword, :description_block, :bodytext, :other,:tag_title, :tag_description, :time_add, :user_add, :weight, :status)');

                $stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
                $stmt->bindParam(':user_add', $row['user_add'], PDO::PARAM_INT);
                
                $weight = $db->query('SELECT max(weight) FROM ' . TABLE . '_block')->fetchColumn();
                $weight = intval($weight) + 1;
                $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);

                $stmt->bindValue(':status', 1, PDO::PARAM_INT);


            } else {
                $stmt = $db->prepare('UPDATE ' . TABLE . '_block SET title = :title, keyword = :keyword, description_block = :description_block, bodytext = :bodytext, other = :other,   tag_title = :tag_title, tag_description = :tag_description, user_edit='.$admin_info['userid'].',time_edit='.NV_CURRENTTIME.' WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
            $stmt->bindParam(':keyword', $row['keyword'], PDO::PARAM_STR);
            $stmt->bindParam(':description_block', $row['description_block'], PDO::PARAM_STR);
            $stmt->bindParam(':bodytext', $row['bodytext'], PDO::PARAM_STR, strlen($row['bodytext']));
			$stmt->bindParam(':other', $row['other'], PDO::PARAM_STR, strlen($row['other']));
            $stmt->bindParam(':tag_title', $row['tag_title'], PDO::PARAM_STR);
            $stmt->bindParam(':tag_description', $row['tag_description'], PDO::PARAM_STR);

            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['id'])) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Block', ' ', $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Block', 'ID: ' . $row['id'], $admin_info['userid']);
                }
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=block');
            }
        } catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . TABLE . '_block WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['id'] = 0;
    $row['title'] = ''; 
    $row['keyword'] = '';
    $row['description_block'] = '';
    $row['bodytext'] = '';
    $row['tag_title'] = '';
    $row['tag_description'] = '';
}

if( !empty( $row['other'] ) ){$option_product = explode( '|', $row['other'] );}else{$option_product = array( );}

if (defined('NV_EDITOR'))
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';

$row['bodytext'] = nv_htmlspecialchars(nv_editor_br2nl($row['bodytext']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['bodytext'] = nv_aleditor('bodytext', '100%', '300px', $row['bodytext']);
} else {
    $row['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $row['bodytext'] . '</textarea>';
}

$xtpl = new XTemplate('block_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('UPLOAD_CURRENT', $module_upload.'/block/');
$xtpl->assign('UPLOAD_CURRENT_BLOCK', $currentpathblock);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

$option_items = 0;
if( !empty( $option_product ) )
{
    $op_tmp = array();
	foreach( $option_product as $key=>$value )
	{
		$op_tmp = explode( ';', $value );
		$data_option_product = array(
            'id' => $option_items,
			'title' => $op_tmp[0],
			'link' => $op_tmp[1],
			'img' => $op_tmp[2]
		);
		$xtpl->assign( 'TMS', $data_option_product );
		$xtpl->parse( 'main.img' );
		++$option_items;
	}

}
$xtpl->assign( 'TMS_STT', $option_items );




if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
if($row['id']==0){
	$page_title = $lang_module['block_add'];
}else{
	$page_title = $lang_module['block_edit'];
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
