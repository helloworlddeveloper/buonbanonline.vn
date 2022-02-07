<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 23 Dec 2020 03:03:57 GMT
 */
 


if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
$mod = $nv_Request->get_string('mod', 'post, get', 0);
if($mod=="brand"){

    $q=$nv_Request->get_string('q', 'get','');
    $list = get_brand_select2($q);

    foreach($list as $result){
        $json[] = ['id'=>$result['id'], 'text'=>$result['title']];
    }
    print_r(json_encode($json));die(); 
}

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    die($alias);
}

$groups_list = nv_groups_list();

// Change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;

    $query = 'SELECT status FROM ' . TABLE . '_categories WHERE id=' . $id;
    $row = $db->query($query)->fetch();
    if (isset($row['status']))     {
        $status = ($row['status']) ? 0 : 1;
        $query = 'UPDATE ' . TABLE . '_categories SET status=' . intval($status) . ' WHERE id=' . $id;
        $db->query($query);
        $content = 'OK_' . $id;
    }
	
	// xóa cache redis danh mục
	$redis->delete('catalogy_main');
	$redis->delete('catalogy_main_all_lev');
	
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
}

if ($nv_Request->isset_request('ajax_action', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $new_vid = $nv_Request->get_int('new_vid', 'post', 0);
    $content = 'NO_' . $id;
    if ($new_vid > 0)     {
        $sql = 'SELECT id FROM ' . TABLE . '_categories WHERE id!=' . $id . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch())
        {
            ++$weight;
            if ($weight == $new_vid) ++$weight;             $sql = 'UPDATE ' . TABLE . '_categories SET weight=' . $weight . ' WHERE id=' . $row['id'];
            $db->query($sql);
        }
        $sql = 'UPDATE ' . TABLE . '_categories SET weight=' . $new_vid . ' WHERE id=' . $id;
        $db->query($sql);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $weight=0;
        $sql = 'SELECT weight FROM ' . TABLE . '_categories WHERE id =' . $db->quote($id);
        $result = $db->query($sql);
        list($weight) = $result->fetch(3);
        
        $db->query('DELETE FROM ' . TABLE . '_categories  WHERE id = ' . $db->quote($id));
        if ($weight > 0)         {
            $sql = 'SELECT id, weight FROM ' . TABLE . '_categories WHERE weight >' . $weight;
            $result = $db->query($sql);
            while (list($id, $weight) = $result->fetch(3))
            {
                $weight--;
                $db->query('UPDATE ' . TABLE . '_categories SET weight=' . $weight . ' WHERE id=' . intval($id));
            }
        }
		
		// xóa cache redis danh mục
		$redis->delete('catalogy_main');
		$redis->delete('catalogy_main_all_lev');
		
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete Category', 'ID: ' . $id, $admin_info['userid']);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$currentpathcat = NV_UPLOADS_DIR . '/' . $module_upload . '/cat';
if (!file_exists($currentpathcat)) {
    nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $module_upload. '/cat/' , true);
}


$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {

    $row['name'] = $nv_Request->get_title('name', 'post', '');
    $row['alias'] = $nv_Request->get_title('alias', 'post', '');
    $row['alias'] = (empty($row['alias'])) ? change_alias($row['title']) : change_alias($row['alias']);
    $row['keyword'] = $nv_Request->get_title('keyword', 'post', '');
	
    $row['percent_discount'] = $nv_Request->get_title('percent_discount', 'post', 0);
	$row['percent_discount']=str_replace(',','.',$row['percent_discount']);

	
    $row['image'] = $nv_Request->get_title('image', 'post', '');
    $row['parrent_id'] = $nv_Request->get_int('parrent_id', 'post', 0);
    $row['brand'] = $nv_Request->get_array('brand', 'post', '');

	
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
	$row['other_image'] = implode( '|', $array_other );
	


    $row['brand_list'] = '';
    $ii = 1;
    foreach ($row['brand'] as $key => $value) {
        if($ii<count($row['brand'])){
            $row['brand_list'] .= $value . '|';
        }else{
            $row['brand_list'] .= $value;
        }
        $ii++;
    }
  

    if (is_file(NV_DOCUMENT_ROOT . $row['image']))     {
        $row['image'] = substr($row['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
    } else {
        $row['image'] = '';
    }
    $row['description'] = $nv_Request->get_editor('description', '', NV_ALLOWED_HTML_TAGS);
    $row['viewdescriptionhtml'] = $nv_Request->get_int('viewdescriptionhtml', 'post', 0);

    $_groups_post = $nv_Request->get_array('groups_view', 'post', array());
    $row['groups_view'] = !empty($_groups_post) ? implode(',', nv_groups_post(array_intersect($_groups_post, array_keys($groups_list)))) : '';

    if (empty($row['name'])) {
        $error[] = $lang_module['error_required_name'];
    } elseif (empty($row['alias'])) {
        $error[] = $lang_module['error_required_alias'];
    }
	
	// kiểm tra dữ liệu đúng logic chưa. cấp cha
	if($row['id'] and $row['parrent_id'])
	{
		$list_childrent_catid = list_childrent_catid($row['id']);
		
		if(in_array($row['parrent_id'], $list_childrent_catid))
		{
			$error[] = 'Chuyên mục sản phẩm sai logic';
		}
	}
	
	
    if (empty($error)) {
 

     try {
        if (empty($row['id'])) {
            $row['inhome'] = 1;
            $row['viewcat'] = 1;
            $row['numlinks'] = 4;
            $row['idsite'] = 0;
            $row['user_add'] = $admin_info['userid'];
            $row['time_add'] = NV_CURRENTTIME;

            $stmt = $db->prepare('INSERT INTO ' . TABLE . '_categories (other_image,brand, name, alias, parrent_id, keyword, image, description, percent_discount, viewdescriptionhtml, groups_view, inhome, viewcat, numlinks, idsite, user_add, time_add,weight, status) VALUES (:other_image,:brand, :name, :alias, :parrent_id, :keyword, :image, :description, :percent_discount, :viewdescriptionhtml, :groups_view, :inhome, :viewcat, :numlinks, :idsite, :user_add, :time_add, :weight, :status)');

            $stmt->bindParam(':parrent_id', $row['parrent_id'], PDO::PARAM_INT);
            $stmt->bindParam(':inhome', $row['inhome'], PDO::PARAM_INT);
            $stmt->bindParam(':viewcat', $row['viewcat'], PDO::PARAM_INT);
            $stmt->bindParam(':numlinks', $row['numlinks'], PDO::PARAM_INT);
            $stmt->bindParam(':idsite', $row['idsite'], PDO::PARAM_INT);
            $stmt->bindParam(':user_add', $row['user_add'], PDO::PARAM_INT);
            $stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
            $weight = $db->query('SELECT max(weight) FROM ' . TABLE . '_categories')->fetchColumn();
            $weight = intval($weight) + 1;
            $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);

            $stmt->bindValue(':status', 1, PDO::PARAM_INT);


        } else {
            $stmt = $db->prepare('UPDATE ' . TABLE . '_categories SET other_image = :other_image, brand = :brand, name = :name, alias = :alias, keyword = :keyword, image = :image, description = :description, percent_discount = :percent_discount, viewdescriptionhtml = :viewdescriptionhtml, groups_view = :groups_view, user_edit='.$admin_info['userid'].',time_edit='.NV_CURRENTTIME.',parrent_id='.$row['parrent_id'].' WHERE id=' . $row['id']);
        }
		$stmt->bindParam(':other_image', $row['other_image'], PDO::PARAM_STR, strlen($row['other_image']));
        $stmt->bindParam(':name', $row['name'], PDO::PARAM_STR);
        $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
        $stmt->bindParam(':keyword', $row['keyword'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR, strlen($row['description']));
		$stmt->bindParam(':percent_discount', $row['percent_discount'], PDO::PARAM_STR);
        $stmt->bindParam(':viewdescriptionhtml', $row['viewdescriptionhtml'], PDO::PARAM_INT);
        $stmt->bindParam(':groups_view', $row['groups_view'], PDO::PARAM_STR);
        $stmt->bindParam(':brand', $row['brand_list'], PDO::PARAM_STR);
        

        $exc = $stmt->execute();
        if ($exc) {
			
			// xóa cache redis danh mục
			$redis->delete('catalogy_main');
			$redis->delete('catalogy_main_all_lev');
			
            $nv_Cache->delMod($module_name);
            if (empty($row['id'])) {
                nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Category', ' ', $admin_info['userid']);
            } else {
                nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Category', 'ID: ' . $row['id'], $admin_info['userid']);
            }
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=category&parrent_id='.$row['parrent_id']);
        }
    } catch(PDOException $e) {
        trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) { 

    $row = $db->query('SELECT * FROM ' . TABLE . '_categories WHERE id=' . $row['id'])->fetch();
	
	
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
} else {
    $row['id'] = 0;
    $row['name'] = '';
    $row['alias'] = '';
    $row['brand'] = '';
    $row['other_image'] = '';
    $row['keyword'] = '';
    $row['image'] = '';
    $row['description'] = '';
    $row['percent_discount'] = '';
    $row['viewdescriptionhtml'] = 0;
    $row['groups_view'] = '6';
    $row['parrent_id']= $nv_Request->get_int('parrent_id', 'get', 0);
}
if( !empty( $row['other_image'] ) ){$option_product = explode( '|', $row['other_image'] );}else{$option_product = array( );}


if (!empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['image'])) {
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'];
}
if (defined('NV_EDITOR'))
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';

$row['description'] = nv_htmlspecialchars(nv_editor_br2nl($row['description']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['description'] = nv_aleditor('description', '100%', '300px', $row['description']);
} else {
    $row['description'] = '<textarea style="width:100%;height:300px" name="description">' . $row['description'] . '</textarea>';
}

$sql = 'SELECT id, name,parrent_id FROM ' . TABLE. '_categories WHERE id !=' . $row['id'];
$result = $db->query($sql);
$array_cat_list = []; 
$array_cat_list[0] = array(
    '0',
    $lang_module['cat_sub_sl']
);

while (list ($catid_i, $title_i,$parrent_id) = $result->fetch(3)) {
    $xtitle_i = '';
    if ($parrent_id > 0) {
        $xtitle_i .= '&nbsp;';
        $xtitle_i .= '---';
    }
    $xtitle_i .= $title_i;
    $array_cat_list[] = array(
        $catid_i,
        $xtitle_i
    );
}
$xtpl = new XTemplate('category_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('UPLOAD_CURRENT', $module_upload.'/cat/');
$xtpl->assign('UPLOAD_CURRENT_CAT', $currentpathcat);


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



$row['brand'] = explode("|", $row['brand']);
foreach ($list_brand as $value_list) {
    foreach ($row['brand'] as $value) {
        if($value == $value_list['id']){
            $value_list["selected"] = "selected";
        }
    }
    $xtpl->assign( 'STATUS', $value_list);
    $xtpl->parse( 'main.brand' );
}

$xtpl->assign('ROW', $row);

/*
foreach ($array_cat_list as $index => $rows_i) {
    $sl = ($rows_i[0] == $row['parrent_id']) ? " selected=\"selected\"" : "";
    $xtpl->assign('pcatid_i', $rows_i[0]);
    $xtpl->assign('ptitle_i', $rows_i[1]);
    $xtpl->assign('pselect', $sl);
    $xtpl->parse('main.parent_loop');
}
*/

$array_cat_list = category_html_select(0);

if($array_cat_list)
{
	foreach ($array_cat_list as $rows_i) {
		
		$sl = ($rows_i['id'] == $row['parrent_id']) ? " selected=\"selected\"" : "";
		$xtpl->assign('pcatid_i', $rows_i['id']);
		$xtpl->assign('ptitle_i', $rows_i['text']);
		$xtpl->assign('pselect', $sl);
		$xtpl->parse('main.parent_loop');
	}
}

for ($i = 0; $i <= 2; $i++) {
    $xtpl->assign('VIEWDESCRIPTION', array(
        'value' => $i,
        'checked' => $row['viewdescriptionhtml'] == $i ? ' checked="checked"' : '',
        'title' => $lang_module['content_bodytext_display_' . $i]
    ));
    $xtpl->parse('main.viewdescriptionhtml');
}
$groups_view = explode(',', $row['groups_view']);
foreach ($groups_list as $_group_id => $_title) {
    $xtpl->assign('GROUPS_VIEW', array(
        'value' => $_group_id,
        'checked' => in_array($_group_id, $groups_view) ? ' checked="checked"' : '',
        'title' => $_title
    ));
    $xtpl->parse('main.groups_view');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}
if (empty($row['id'])) {
    $xtpl->parse('main.auto_get_alias');
}

if($row['other_image']!=''){
    $row['other_image']=explode('|',$row['other_image']);
    foreach($row['other_image'] as $key => $value){
        if (!empty($value) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value)) {
            $value = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $value;
        }
        $xtpl->assign('LOOP', $value);
        $xtpl->assign('key', $key+1);
        $xtpl->parse('main.edit_other_image.loop');
        $xtpl->parse('main.edit_other_imagejs.loop');
    }
    $xtpl->parse('main.edit_other_image');
    $xtpl->parse('main.edit_other_imagejs');
}



$xtpl->parse('main');
$contents = $xtpl->text('main');
if($row['id']==0){
	$page_title = $lang_module['category_add'];
}else{
	$page_title = $lang_module['category_edit'];
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
