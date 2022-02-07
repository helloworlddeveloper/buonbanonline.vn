<?php
	
	/**
		* @Project NUKEVIET 4.x
		* @Author VINADES.,JSC <contact@vinades.vn>
		* @Copyright (C) 2020 VINADES.,JSC. All rights reserved
		* @License GNU/GPL version 2 or any later version
		* @Createdate Thu, 24 Dec 2020 01:27:14 GMT
	*/
	
	if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
	$mod = $nv_Request->get_string('mod', 'post, get', 0);
	if ($mod == "brand") {
		$q = $nv_Request->get_string('q', 'get', '');
		$cat_id = $nv_Request->get_string('cat_id', 'get', '');
		$list = get_brand_select2_cat($q, $cat_id);
		foreach ($list as $result) {
			$json[] = ['id' => $result['id'], 'text' => $result['title']];
		}
		print_r(json_encode($json));
		die();
	}
	if ($mod == "origin") {
		$cat_id = $nv_Request->get_string('cat_id', 'get', '');
		$q = $nv_Request->get_string('q', 'get', '');
		$list = get_origin_select2_cat($q, $cat_id);
		
		foreach ($list as $result) {
			$json[] = ['id' => $result['id'], 'text' => $result['title']];
		}
		print_r(json_encode($json));
		die();
	}
	if ($nv_Request->isset_request('get_alias_title', 'post')) {
		$alias = $nv_Request->get_title('get_alias_title', 'post', '');
		$alias = change_alias($alias);
		die($alias);
	}
	if ($mod == 'get_categories') {
		$q = $nv_Request->get_string('q', 'post', '');
		$list_cat = category_html_select(0);
		//print_r($list_cat);die;
		if (count($list_cat) > 0) {
			foreach ($list_cat as $result) {
				$json[] = ['id' => $result['id'], 'text' => '<span>' . $result['text'] . '</span>'];
			}
			} else {
			$list_cat = get_categories_select2('', IDSITE, 0);
			foreach ($list_cat as $result) {
				$list_cat2 = get_categories_select2($q, IDSITE, $result['id']);
				if (count($list_cat2) > 0) {
					$json[] = ['id' => $result['id'], 'text' => '<span style="font-weight:bold">' . $result['name'] . '</span>'];
					foreach ($list_cat2 as $result2) {
						$json[] = ['id' => $result2['id'], 'text' => '<span>&emsp;' . $result2['name'] . '</span>'];
					}
				}
			}
		}
		print_r(json_encode($json));
		die();
	}
	$row = array();
	$error = array();
	$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
	
	
	
	//die('ok');
	if ($nv_Request->isset_request('add', 'get,post')) {
		
		$row['block'] = $nv_Request->get_typed_array('block', 'post', 'string');
		if($row['id'])
		{
			$db->query('DELETE FROM ' . TABLE. '_block_id where product_id='.$row['id']);
			foreach($row['block'] as $value){
				$db->query('INSERT INTO  ' . TABLE. '_block_id(bid,product_id) VALUES('.$value.','.$row['id'].')');
			}
		}
		
		$array = array();
		
		$array['status'] = 'OK';
		$array['mess'] = 'Thực hiện thành công!';
		
		print_r(json_encode($array));die;
		
		} elseif ($row['id'] > 0) {
		$row = $db->query('SELECT * FROM ' . TABLE . '_product WHERE id=' . $row['id'])->fetch();
		if (get_info_category($row['categories_id'])['parrent_id'] == 0) {
			$row['categories_name'] = '<span style="font-weight:bold">' . get_info_category($row['categories_id'])['name'] . '</span>';
			} else {
			$row['categories_name'] = '<span>&emsp;' . get_info_category($row['categories_id'])['name'] . '</span>';
		}
		$row['brand_name'] = get_info_brand($row['brand'])['title'];
		$row['origin_name'] = get_info_orgin($row['origin'])['title'];
		$row['price'] = number_format($row['price']);
		
		if (!$row['price_special'])
        $row['price_special'] = '';
		else
        $row['price_special'] = number_format($row['price_special']);
		
		
		
		
		// lấy thông tin tồn kho không có thuộc tính
		
		$row['warehouse'] = $db->query('SELECT sl_tonkho FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1 = 0 AND classify_id_value2 = 0 AND product_id =' . $row['id'])->fetchColumn();
		
		if (!$row['warehouse'])
        $row['warehouse'] = '';
		else
        $row['warehouse'] = number_format($row['warehouse']);
		
		
		
		$row['classify'] = $db->query('SELECT * FROM ' . TABLE . '_product_classify WHERE product_id=' . $row['id'])->fetchAll();
		$row['classify_error'] = array();
		if (empty($row)) {
			nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		}
		} else {
		$row['id'] = 0;
		$row['barcode'] = '';
		$row['name_product'] = '';
		$row['alias'] = '';
		$row['categories_id'] = 0;
		$row['weight_product'] = '';
		$row['length_product'] = '';
		$row['width_product'] = '';
		$row['height_product'] = '';
		$row['free_ship'] = 0;
		$row['self_transport'] = 0;
		$row['image'] = '';
		$row['description'] = '';
		$row['bodytext'] = '';
		$row['unit_weight'] = 0;
		$row['unit_id'] = 0;
		$row['unit_currency'] = 0;
		$row['unit_length'] = 0;
		$row['unit_width'] = 0;
		$row['unit_height'] = 0;
		$row['store_id'] = 0;
		$row['classify'] = array();
		$row['other_image'] = '';
		$row['inhome'] = 0;
		$row['allowed_rating'] = 0;
		$row['showprice'] = 0;
	}
	if (!empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['image'])) {
		$row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'. $row['image'];
	}
	if (defined('NV_EDITOR'))
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
	
	
	
	$row['bodytext'] = nv_htmlspecialchars(nv_editor_br2nl($row['bodytext']));
	if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
		$row['bodytext'] = nv_aleditor('bodytext', '100%', '300px', $row['bodytext']);
		} else {
		$row['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $row['bodytext'] . '</textarea>';
	}
	
	
	$row['description'] = nv_htmlspecialchars(nv_editor_br2nl($row['description']));
	if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
		$row['description'] = nv_aleditor('description', '100%', '300px', $row['description']);
		} else {
		$row['description'] = '<textarea style="width:100%;height:300px" name="description">' . $row['description'] . '</textarea>';
	}
	
	
	$xtpl = new XTemplate('product_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
	
	//print_r($xtpl);die;
	//print_r($global_config['nv_max_size']);die;
	
	$xtpl->assign('UPLOAD_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=upload&token=' . md5($nv_Request->session_id . $global_config['sitekey']));
	
	$xtpl->assign('list_product', nv_url_rewrite(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=product', true));
	
	
	$xtpl->assign('LANG', $lang_module);
	$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
	$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
	$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
	$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
	$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
	$xtpl->assign('MODULE_NAME', $module_name);
	$xtpl->assign('MODULE_UPLOAD', $module_upload);
	$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
	$xtpl->assign('OP', $op);
	
	
	// xuất ra thông tin keyword
	if ($row['keyword']) {
		$array_key = explode(',', $row['keyword']);
		$flag = false;
		foreach ($array_key as $keyword) {
			$xtpl->assign('keyword', $keyword);
			if ($flag) {
				$xtpl->parse('main.keyword.delete');
			}
			$flag = true;
			$xtpl->parse('main.keyword');
		}
	}
	
	
	$array_cat_list = category_html_select(0);
	
	//print_r($array_cat_list);die;
	
	foreach ($array_cat_list as $rows_i) {
		$sl = ($rows_i['id'] == $row['categories_id']) ? " selected=\"selected\"" : "";
		$xtpl->assign('pcatid_i', $rows_i['id']);
		$xtpl->assign('ptitle_i', $rows_i['text']);
		$xtpl->assign('pselect', $sl);
		$xtpl->parse('main.parent_loop');
	}
	
	
	if ($row['other_image'] || $row['image']) {
		$array_otherimage = array();
		$array_otherimage = explode(",", $row['other_image']);
		$list_image = array();
		$list_image[]['image'] = $row['image'];
		if ($row['other_image']) {
			foreach ($array_otherimage as $key => $value) {
				$list_image[]['image'] = $value;
			}
		}
		$i = 10;
		
		foreach ($list_image as $otherimage) {
			$otherimage['number'] = $i;
			$otherimage['filepath'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $otherimage['image'];
			
			$otherimage['homeimgfile'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $otherimage['image'];
			$otherimage['homeimgfile'] = str_replace(NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/', '', $otherimage['image']);
			$xtpl->assign('DATA', $otherimage);
			$xtpl->parse('main.data');
			$i++;
		}
	}
	
	
	// xuất thông tin hình ảnh chính, hình ảnh khác của sản phẩm
	
	
	for ($i = 0; $i <= 7; $i++) {
		$xtpl->assign('stt', $i);
		
		
		
		$SEVER ='/home/chonhagiau/banhang.chonhagiau.net/uploads';
		//print_r($SEVER  . '/' . $module_upload  . '/' . $list_image[$i]['image']);die;
		if (!empty($list_image[$i]['image']) and is_file($SEVER  . '/' . $module_upload  . '/' . $list_image[$i]['image'])) {
			
			//die('oks');
			
			$src_image = 'https://banhang.chonhagiau.com/'. 'assets' .'/'  . $module_name  . '/' . $list_image[$i]['image'];
			$homeimgfile = str_replace(NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/', '', $list_image[$i]['image']);
			//print_r($homeimgfile);die;
			$xtpl->assign('src_image', $src_image);
			$xtpl->assign('homeimgfile', $homeimgfile);
			
			$xtpl->parse('main.data_image.loop');
			} else {
			$xtpl->parse('main.data_image.add');
		}
		
		$xtpl->parse('main.data_image');
	}
	
	$xtpl->assign('MAXFILESIZEULOAD', $global_config['nv_max_size']);
	$xtpl->assign('MAXFILESIZE', nv_convertfromBytes($global_config['nv_max_size']));
	$xtpl->assign('UPLOAD_DIR', NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name);
	$xtpl->assign('MODULE_FILE', $module_name);
	$xtpl->assign('COUNT', count($list_image));
	$xtpl->assign('COUNT_UPLOAD', 7);
	
	
	
	if ($row['id']) {
		foreach ($list_brand as $value_list) {
			if ($row['brand'] == $value_list['id']) {
				$value_list["selected"] = "selected";
			}
			$xtpl->assign('STATUS', $value_list);
			$xtpl->parse('main.brand');
		}
		
		
		
		foreach ($list_origin as $value_list) {
			if ($row['origin'] == $value_list['id']) {
				$value_list["selected"] = "selected";
			}
			$xtpl->assign('STATUS', $value_list);
			$xtpl->parse('main.origin');
		}
		$list_cat = get_categories_select2_full("", IDSITE);
		
		foreach ($list_cat as $value_list) {
			if ($row['categories_id'] == $value_list['id']) {
				$value_list["selected"] = "selected";
			}
			$xtpl->assign('STATUS', $value_list);
			$xtpl->parse('main.categories_id');
		}
	}
	
	$xtpl->assign('ROW', $row);
	
	if ($row['free_ship']) {
		$xtpl->assign('free_ship_checked', 'checked=checked');
		} else {
		$xtpl->assign('free_ship_checked', '');
	}
	
	
	// self_transport
	if ($row['self_transport']) {
		$xtpl->assign('self_transport_checked', 'checked=checked');
		} else {
		$xtpl->assign('self_transport_checked', '');
	}
	
	
	
	
	if ($row['inhome'] == 1) {
		$xtpl->assign('check_inhome', 'checked=checked');
		} else {
		$xtpl->assign('check_inhome', '');
	}
	if ($row['allowed_rating'] == 1) {
		$xtpl->assign('check_allowed_rating', 'checked=checked');
		} else {
		$xtpl->assign('check_allowed_rating', '');
	}
	if ($row['showprice'] == 1) {
		$xtpl->assign('check_showprice', 'checked=checked');
		} else {
		$xtpl->assign('check_showprice', '');
	}
	if ($row['id'] > 0) {
		$xtpl->assign('readonly', 'readonly');
		$xtpl->assign('random_num', '');
		$xtpl->assign('pointer', '');
		} else {
		$xtpl->assign('readonly', '');
		$xtpl->assign('random_num', 'random_num');
		$xtpl->assign('pointer', 'pointer');
	}
	
	
	$xtpl->assign('raw_product_prefix', $raw_product_prefix);
	$xtpl->assign('currentpath', NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m'));
	$list_unit_weight = get_full_unit_weight();
	foreach ($list_unit_weight as $value) {
		$xtpl->assign('unit_weight', array(
        'key' => $value['id'],
        'title' => $value['name_weight'] . ' (' . $value['symbol'] . ')',
        'selected' => ($value['id'] == $row['unit_weight']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.unit_weight');
	}
	$list_unit = get_full_unit();
	foreach ($list_unit as $value) {
		$xtpl->assign('unit_id', array(
        'key' => $value['id'],
        'title' => $value['name'],
        'selected' => ($value['id'] == $row['unit_id']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.unit_id');
	}
	$list_unit_currency = get_full_unit_currency();
	
	
	$list_unit_length = get_full_unit_length();
	foreach ($list_unit_length as $value) {
		$xtpl->assign('unit_length', array(
        'key' => $value['id'],
        'title' => $value['name_length'] . ' (' . $value['symbol'] . ')',
        'selected' => ($value['id'] == $row['unit_length']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.unit_length');
	}
	foreach ($list_unit_length as $value) {
		$xtpl->assign('unit_width', array(
        'key' => $value['id'],
        'title' => $value['name_length'] . ' (' . $value['symbol'] . ')',
        'selected' => ($value['id'] == $row['unit_width']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.unit_width');
	}
	foreach ($list_unit_length as $value) {
		$xtpl->assign('unit_height', array(
        'key' => $value['id'],
        'title' => $value['name_length'] . ' (' . $value['symbol'] . ')',
        'selected' => ($value['id'] == $row['unit_height']) ? ' selected="selected"' : ''
		));
		$xtpl->parse('main.unit_height');
	}
	if (count($row['classify']) > 0) {
		$xtpl->assign('disabled_price', 'style="display:none"');
		
		// xử lý hiển thị danh sách thuộc tính
		
		// hiển thị tiêu đề thuộc tính
		
		$first = true;
		
		$array_data = array();
		$array_data1 = array();
		
		foreach ($row['classify'] as $key => $value) {
			
			$xtpl->assign('classify', $value);
			
			$row['classify_value'] = $db->query('SELECT * FROM ' . TABLE . '_product_classify_value WHERE classify_id=' . $value['id'])->fetchAll();
			
			$stt_classify_value = true;
			foreach ($row['classify_value'] as $classify_value) {
				
				$xtpl->assign('classify_value', $classify_value);
				
				
				// được phép xóa thuộc tính
				if (!$stt_classify_value) {
					$xtpl->parse('main.classify_title.classify_value.delete');
				}
				$stt_classify_value = false;
				
				// title thuộc tính
				$xtpl->parse('main.classify_title.classify_value');
				
				if ($first) {
					// thuộc tính hình ảnh nhóm 1
					$array_data[] = $classify_value;
					
					if (!empty($classify_value['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload  . '/' . $classify_value['image'])) {
						
						$src_image = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $classify_value['image'];
						$homeimgfile = str_replace(NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/', '', $classify_value['image']);
						
						$xtpl->assign('src_image', $src_image);
						$xtpl->assign('homeimgfile', $homeimgfile);
						
						$xtpl->parse('main.classify_title.edit_image_classify.image_classify.loop');
						} else {
						$xtpl->parse('main.classify_title.edit_image_classify.image_classify.add');
					}
					$xtpl->parse('main.classify_title.edit_image_classify.image_classify');
					} else {
					$array_data1[] = $classify_value;
				}
			}
			
			if ($first) {
				$xtpl->parse('main.classify_title.edit_image_classify');
			}
			
			$first = false;
			
			$xtpl->parse('main.classify_title');
			
			// tiêu đề thuộc tính sản phẩm tại bảng nhập giá
			$xtpl->parse('main.classify_title_table');
		}
		
		
		// trộn chung 2 thuộc tính sản phẩm với nhau
		
		$data_price = array();
		
		$index0 = 0;
		foreach ($array_data as $classify) {
			$xtpl->assign('index0', $index0);
			
			$first = true;
			
			$count_children = count($array_data1);
			
			$xtpl->assign('table_classify', $classify);
			
			
			if ($count_children) {
				$xtpl->assign('rowspan', 'rowspan=' . $count_children);
				
				$index1 = 0;
				
				foreach ($array_data1 as $classify1) {
					// có đầy đủ 2 thuộc tính
					
					$xtpl->assign('index1', $index1);
					
					$price = $db->query('SELECT price, price_special, sl_tonkho, status FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1=' . $classify['id'] . ' and classify_id_value2=' . $classify1['id'])->fetch();
					
					$classify1['price'] = number_format($price['price']);
					
					if (!$price['price_special'])
                    $classify1['price_special'] = '';
					else
                    $classify1['price_special'] = number_format($price['price_special']);
					
					$classify1['sl_tonkho'] = number_format($price['sl_tonkho']);
					
					if ($price['status']) {
						$classify1['checked'] = 'checked=checked';
						} else {
						$classify1['checked'] = '';
					}
					
					$data = array();
					$data['id1'] = $classify['id'];
					$data['id2'] = $classify1['id'];
					$data['price'] = $classify1['price'];
					$data['price_special'] = $classify1['price_special'];
					$data['sl_tonkho'] = $classify1['sl_tonkho'];
					$data['status'] = $price['status'];
					
					$data_price[] = $data;
					
					$xtpl->assign('table_classify1', $classify1);
					
					if ($first) {
						$xtpl->parse('main.classify_table.loop_classify');
					}
					
					$first = false;
					
					$xtpl->parse('main.classify_table');
					
					$index1++;
				}
				} else {
				$price = $db->query('SELECT price, price_special, sl_tonkho, status FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1=' . $classify['id'] . ' and classify_id_value2=0')->fetch();
				
				$classify1['price'] = number_format($price['price']);
				
				if (!$price['price_special'])
                $classify1['price_special'] = '';
				else
                $classify1['price_special'] = number_format($price['price_special']);
				
				$classify1['sl_tonkho'] = number_format($price['sl_tonkho']);
				
				if ($price['status']) {
					$classify1['checked'] = 'checked=checked';
					} else {
					$classify1['checked'] = '';
				}
				
				
				$data = array();
				$data['id1'] = $classify['id'];
				$data['id2'] = 0;
				$data['price'] = $classify1['price'];
				$data['price_special'] = $classify1['price_special'];
				$data['sl_tonkho'] = $classify1['sl_tonkho'];
				$data['status'] = $price['status'];
				
				$data_price[] = $data;
				
				$xtpl->assign('table_classify1', $classify1);
				
				$xtpl->parse('main.classify_table_one');
			}
			
			$index0++;
		}
		
		//print_r(json_encode($data_price));die;
		
		} else {
		$xtpl->assign('classify_class', 'hidden');
	}
	
	
	
	$xtpl->assign('data_price', json_encode($data_price));
	
	
	//noi bat
	$list_block=get_full_block();
	
	foreach($list_block as $value){
		if($row['id']>0){
			$list_block_id=check_block_id($value['id'],$row['id']);
			}else{
			if($row['block']==''){
				$list_block_id=0;
				}else{
				if(count($row['block'])>0){
					$list_block_id=$row['block'][$value['id']];
					}else{
					$list_block_id=0;
				}
			}
		}
		$xtpl->assign('block', array(
		'key' => $value['id'],
		'title' => $value['title'],
		'checked' => ($list_block_id >0) ? ' checked="checked"' : ''));
		$xtpl->parse('main.block');
	}
	
	if ($row['other_image'] != '') {
		$row['other_image'] = explode(' ,', $row['other_image']);
		
		foreach ($row['other_image'] as $key => $value) {
			if (!empty($value) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value)) {
				$value = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $value;
			}
			$xtpl->assign('LOOP', $value);
			$xtpl->assign('key', $key + 1);
			$xtpl->parse('main.edit_other_image.loop');
			$xtpl->parse('main.edit_other_imagejs.loop');
		}
		$xtpl->parse('main.edit_other_image');
		$xtpl->parse('main.edit_other_imagejs');
	}
	
	if ($row['categories_id'] > 0) {
		$xtpl->parse('main.edit');
		$xtpl->parse('main.edit2');
		} else {
		$xtpl->parse('main.no_edit');
	}
	
	if (!empty($error)) {
		$xtpl->assign('ERROR', implode('<br />', $error));
		$xtpl->parse('main.error');
	}
	if (empty($row['id'])) {
		$xtpl->parse('main.auto_get_alias');
	}
	
	$xtpl->parse('main');
	$contents = $xtpl->text('main');
	if ($row['id'] == 0) {
		$page_title = $lang_module['product_add'];
		} else {
		$page_title = $lang_module['product_edit'] . ' có mã vạch ' . $row['barcode'];
	}
	$array_mod_title[] = array(
    'catid' => 0,
    'title' => $lang_module['product'],
    'link' => NV_MY_DOMAIN . '/' . $module_name . '/product/'
	);
	if ($row['id'] == 0) {
		$array_mod_title[] = array(
        'catid' => 0,
        'title' => $page_title,
        'link' => NV_MY_DOMAIN . '/' . $module_name . '/' . $op . '/',
		);
		} else {
		$array_mod_title[] = array(
        'catid' => 0,
        'title' => $page_title,
        'link' => NV_MY_DOMAIN . '/' . $module_name . '/' . $op . '/?id=' . $row['id'],
		);
	}
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
