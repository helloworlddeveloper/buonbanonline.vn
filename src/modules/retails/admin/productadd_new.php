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
if($mod=="brand"){
	$q=$nv_Request->get_string('q', 'get','');
	$cat_id=$nv_Request->get_string('cat_id', 'get','');
	$list = get_brand_select2_cat($q, $cat_id);
	foreach($list as $result){
		$json[] = ['id'=>$result['id'], 'text'=>$result['title']];
	}
	print_r(json_encode($json));die(); 
}
if($mod=="origin"){
	$cat_id=$nv_Request->get_string('cat_id', 'get','');
	$q=$nv_Request->get_string('q', 'get','');
	$list = get_origin_select2_cat($q,$cat_id);

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
if ( $mod == 'get_categories' ) {
	$q = $nv_Request->get_string( 'q', 'post', '' ); 
	$list_cat = category_html_select(0);
	//print_r($list_cat);die;
	if(count($list_cat)>0){
		foreach ( $list_cat as $result ) {
			$json[] = ['id'=>$result['id'], 'text'=>'<span>'.$result['text'].'</span>'];
		}
	}else{
		$list_cat = get_categories_select2( '',IDSITE,0 );
		foreach ( $list_cat as $result ) {
			$list_cat2 = get_categories_select2( $q, IDSITE, $result['id'] );
			if(count($list_cat2)>0){
				$json[] = ['id'=>$result['id'], 'text'=>'<span style="font-weight:bold">'.$result['name'].'</span>'];
				foreach ( $list_cat2 as $result2 ) {
					$json[] = ['id'=>$result2['id'], 'text'=>'<span>&emsp;'.$result2['name'].'</span>'];
				}
			}
		}
	}
	print_r( json_encode( $json ) );
	die();

}
$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
	$row['barcode'] = $nv_Request->get_title('barcode', 'post', '');
	$row['name_product'] = $nv_Request->get_title('name_product', 'post', '');
	$row['alias'] = $nv_Request->get_title('alias', 'post', '');
	$row['alias'] = (empty($row['alias'])) ? change_alias($row['title']) : change_alias($row['alias']);
	$row['categories_id'] = $nv_Request->get_int('categories_id', 'post', 0);
	$row['unit_weight'] = $nv_Request->get_int('unit_weight', 'post', 0);
	$row['unit_id'] = $nv_Request->get_int('unit_id', 'post', 0);
	$row['unit_currency'] = $nv_Request->get_int('unit_currency', 'post', 0);
	$row['weight_product'] = $nv_Request->get_title('weight_product', 'post', '');
	$row['length_product'] = $nv_Request->get_title('length_product', 'post', '');
	$row['width_product'] = $nv_Request->get_title('width_product', 'post', '');
	$row['height_product'] = $nv_Request->get_title('height_product', 'post', '');
	$row['unit_length'] = $nv_Request->get_title('unit_length', 'post', '');
	$row['unit_width'] = $nv_Request->get_title('unit_width', 'post', '');
	$row['unit_height'] = $nv_Request->get_title('unit_height', 'post', '');
	$row['image'] = $nv_Request->get_title('image', 'post', '');
	$row['other_image2'] = $nv_Request->get_typed_array('other_image', 'post', 'string');
	$row['block'] = $nv_Request->get_typed_array('block', 'post', 'string');
	$row['group'] = $nv_Request->get_typed_array('group', 'post', 'array');
	$row['keyword'] = $nv_Request->get_title('keyword', 'post', '');
	$row['inhome'] = $nv_Request->get_title('inhome', 'post', 0);
	$row['allowed_rating'] = $nv_Request->get_title('allowed_rating', 'post', 0);
	$row['showprice'] = $nv_Request->get_title('showprice', 'post', 0);
	$row['store_id'] = $nv_Request->get_title('store_id', 'post', '');
	$row['tag_title'] = $nv_Request->get_title('tag_title', 'post', '');
	$row['tag_description'] = $nv_Request->get_title('tag_description', 'post', '');
	$row['other_image']='';
	$row['brand'] = $nv_Request->get_int('brand', 'post', 0);
	$row['origin'] = $nv_Request->get_int('origin', 'post', 0);
	$row['price'] = $nv_Request->get_string('price', 'post', 0);
	$row['classify'] = $nv_Request->get_typed_array('classify', 'post', 'array');
	$row['product_old'] = $nv_Request->get_typed_array('product', 'post', 'array');
	$row['change_status'] = $nv_Request->get_typed_array('change_status', 'post', 'string');
	$row['product']=array();
	$row['price_min']=0;
	$row['price_max']=0;
	$row['classify_error']=$row['classify'];
	
	foreach($row['product_old'] as $value){
		if($row['id']==0){
			$i=1;
			$value['id1_old']=$value['id1'];
			$value['id2_old']=$value['id2'];
			foreach($row['classify'] as $key=>$value_classify){
				if($i==1){
					$value['id1']=$value_classify['value'][$value['id1']];
				}else{
					if(count($row['classify'])>1){
						$value['id2']=$value_classify['value'][$value['id2']];
					}else{
						$value['id2']='';
					}
				}
				$i++;
			}
		}else{
			$value['id1_old']=$value['id1'];
			$i=1;
			foreach($row['classify'] as $key=>$value_classify){
				if($i==1){
					$value['id1']=$value_classify['value'][$value['id1']];
				}else{
					if(count($row['classify'])>1){
						$value['id2_old']=$value['id2'];
						if(!empty($value_classify['value'][$value['id2']])){
							$value['id2']=$value_classify['value'][$value['id2']];
						}
					}else{
						$value['id2']='';
					}
				}
				$i++;
				
			}
			
			
		}
		$value['price']=str_replace(',','',$value['price']);
		if($value['price']< 1000){
			$error[] = 'Giá thường không thể nhỏ hơn 1000';
		}
			if(empty($value['price_special'])){
					$value['price_special']=0;
					if($row['price_min']==0){
						$row['price_min']=$value['price'];
					}else{
						if($value['price']<$row['price_min']){
							$row['price_min']=$value['price'];
						}
					}
					if($value['price']>$row['price_max']){
						$row['price_max']=$value['price'];
					}
			}else{
				$value['price_special']=str_replace(',','',$value['price_special']);
				if($value['price_special'] >= $value['price']){
					$error[] = 'Giá đặc biệt phải nhỏ hơn giá thường';
				}else{
					if($row['price_min']==0){
						$row['price_min']=$value['price_special'];
					}else{
						if($value['price_special']<$row['price_min']){
							$row['price_min']=$value['price_special'];
						}
					}
					if($value['price_special']>$row['price_max']){
						$row['price_max']=$value['price_special'];
					}
				}
			}
		$row['product'][]=$value;
	}
	if(empty($row['price'])){
		$row['price']=0;
	}else{
		$row['price']=str_replace(',','',$row['price']);
	}
	$row['price_special'] = $nv_Request->get_string('price_special', 'post', 0);
	if(empty($row['price_special'])){
		$row['price_special']=0;
	}else{
		$row['price_special']=str_replace(',','',$row['price_special']);
	}
	if(count($row['classify'])==0){
		if($row['price'] < 1000){
			$error[] = 'Giá thường không thể nhỏ hơn 1000';
		}else{
			if($row['price_special'] >= $row['price']){
				$error[] = 'Giá đặc biệt phải nhỏ hơn giá thường';
			}
		}
	}
	if(get_info_category($row['categories_id'])['parrent_id']==0){
		$row['categories_name']='<span style="font-weight:bold">'.get_info_category($row['categories_id'])['name'].'</span>';
	}else{
		$row['categories_name']='<span>&emsp;'.get_info_category($row['categories_id'])['name'].'</span>';
	}

	
	$row['description'] = $nv_Request->get_editor('description', '', NV_ALLOWED_HTML_TAGS);
	$row['bodytext'] = $nv_Request->get_editor('bodytext', '', NV_ALLOWED_HTML_TAGS);
	if($row['id'] == 0){
		$check_barcode=$db->query('SELECT count(*) FROM '.TABLE.'_product where barcode='.$db->quote($row['barcode']))->fetchColumn();
		if($check_barcode > 0){
			$error[] = $lang_module['error_exist_barcode'];
		}
	}
	if (empty($row['barcode'])) {
		$error[] = $lang_module['error_required_barcode'];
	} elseif (empty($row['name_product'])) {
		$error[] = $lang_module['error_required_name_product'];
	} elseif (empty($row['alias'])) {
		$error[] = $lang_module['error_required_alias'];
	} elseif (empty($row['categories_id'])) {
		$error[] = $lang_module['error_required_categories_id'];
	} elseif (empty($row['image'])) {
		$error[] = $lang_module['error_required_image'];
	} elseif (empty($row['description'])) {
		$error[] = $lang_module['error_required_description'];
	} elseif (empty($row['bodytext'])) {
		$error[] = $lang_module['error_required_bodytext'];
	}
	if($row['price_special'] != 0 ){
		$row['price_sort'] = $row['price_special'];
	}else{
		if($row['price_min'] != 0){
			$row['price_sort'] = $row['price_min'];
		}else{
			$row['price_sort'] = $row['price'];
		}
	}
	
	if (empty($error)) {
		if (is_file(NV_DOCUMENT_ROOT . $row['image']))     {
			$row['image'] = substr($row['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
		} else {
			$server = 'banhang.'.$_SERVER["SERVER_NAME"];
			if(!empty($row['image'])){
				$row['image'] = substr($row['image'], strlen('https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/'));
			}
		}
		foreach($row['other_image2'] as $value){
			if (is_file(NV_DOCUMENT_ROOT . $value))     {
				if($row['other_image']==''){
					$row['other_image'] = substr($value, strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
				}else{
					$row['other_image']=$row['other_image'].','.substr($value, strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
				}
			}else{
				$server = 'banhang.'.$_SERVER["SERVER_NAME"];
				if(!empty($value)){
					if($row['other_image']==''){
						$row['other_image'] = substr($value, strlen('https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/'));
					}else{
						$row['other_image']=$row['other_image'].','.substr($value, strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
					}
				}
			}
		}
		
		try {
			if (empty($row['id'])) {
				$row['time_add'] = NV_CURRENTTIME;
				$row['user_add'] = $admin_info['userid'];
				
				$stmt = $db->prepare('INSERT INTO ' . TABLE . '_product(price_sort,origin, brand,store_id,barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product,unit_length,unit_height,unit_width,image, other_image, description, bodytext, keyword, tag_title, tag_description, time_add, user_add, weight, status,inhome,allowed_rating,showprice,price_min,price_max,price,price_special) VALUES (:price_sort,:origin, :brand,:store_id,:barcode, :name_product, :alias, :categories_id, :unit_id, :unit_weight,:weight_product, :length_product, :width_product, :height_product,:unit_length,:unit_height,:unit_width, :image, :other_image, :description, :bodytext, :keyword, :tag_title, :tag_description, :time_add, :user_add, :weight, :status,:inhome,:allowed_rating,:showprice,:price_min,:price_max,:price,:price_special)');
				$stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
				$stmt->bindParam(':store_id', $row['store_id'], PDO::PARAM_INT);
				$stmt->bindParam(':user_add', $row['user_add'], PDO::PARAM_INT);
				$weight = $db->query('SELECT max(weight) FROM ' . TABLE . '_product')->fetchColumn();
				$weight = intval($weight) + 1;
				$stmt->bindParam(':weight', $weight, PDO::PARAM_INT);

				$stmt->bindValue(':status', 1, PDO::PARAM_INT);


			} else {
				$stmt = $db->prepare('UPDATE ' . TABLE . '_product SET price_sort = :price_sort,origin = :origin,brand = :brand, barcode = :barcode, name_product = :name_product, alias = :alias, categories_id = :categories_id, weight_product = :weight_product, length_product = :length_product, width_product = :width_product, height_product = :height_product, image = :image, description = :description, bodytext = :bodytext,tag_title=:tag_title,tag_description=:tag_description ,keyword=:keyword,unit_id=:unit_id,unit_weight=:unit_weight,other_image=:other_image,time_edit='.NV_CURRENTTIME.',user_edit='.$admin_info['userid'].',unit_length=:unit_length,unit_height=:unit_height,unit_width=:unit_width,inhome=:inhome,allowed_rating=:allowed_rating,showprice=:showprice,price_min=:price_min ,price_max=:price_max,price=:price,price_special=:price_special WHERE id=' . $row['id']);
			}
			
			$stmt->bindParam(':price_sort', $row['price_sort'], PDO::PARAM_STR);
			$stmt->bindParam(':barcode', $row['barcode'], PDO::PARAM_STR);
			$stmt->bindParam(':name_product', $row['name_product'], PDO::PARAM_STR);
			$stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
			$stmt->bindParam(':categories_id', $row['categories_id'], PDO::PARAM_INT);
			$stmt->bindParam(':weight_product', $row['weight_product'], PDO::PARAM_STR);
			$stmt->bindParam(':length_product', $row['length_product'], PDO::PARAM_STR);
			$stmt->bindParam(':width_product', $row['width_product'], PDO::PARAM_STR);
			$stmt->bindParam(':height_product', $row['height_product'], PDO::PARAM_STR);
			$stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
			$stmt->bindParam(':description', $row['description'], PDO::PARAM_STR, strlen($row['description']));
			$stmt->bindParam(':bodytext', $row['bodytext'], PDO::PARAM_STR, strlen($row['bodytext']));
			$stmt->bindParam(':unit_id', $row['unit_id'], PDO::PARAM_INT);
			$stmt->bindParam(':unit_weight', $row['unit_weight'], PDO::PARAM_INT);
			$stmt->bindParam(':unit_length', $row['unit_length'], PDO::PARAM_INT);
			$stmt->bindParam(':unit_width', $row['unit_width'], PDO::PARAM_INT);
			$stmt->bindParam(':unit_height', $row['unit_height'], PDO::PARAM_INT);
			$stmt->bindParam(':inhome', $row['inhome'], PDO::PARAM_INT);
			$stmt->bindParam(':allowed_rating', $row['allowed_rating'], PDO::PARAM_INT);
			$stmt->bindParam(':showprice', $row['showprice'], PDO::PARAM_INT);
			$stmt->bindParam(':keyword', $row['keyword'], PDO::PARAM_STR);
			$stmt->bindParam(':tag_title', $row['tag_title'], PDO::PARAM_STR);
			$stmt->bindParam(':tag_description', $row['tag_description'], PDO::PARAM_STR);
			$stmt->bindParam(':other_image', $row['other_image'], PDO::PARAM_STR);
			$stmt->bindParam(':price_min', $row['price_min'], PDO::PARAM_STR);
			$stmt->bindParam(':price_max', $row['price_max'], PDO::PARAM_STR);
			$stmt->bindParam(':brand', $row['brand'], PDO::PARAM_INT);
			$stmt->bindParam(':origin', $row['origin'], PDO::PARAM_INT);
			$stmt->bindParam(':price', $row['price'], PDO::PARAM_INT);
			$stmt->bindParam(':price_special', $row['price_special'], PDO::PARAM_INT);
			$exc = $stmt->execute();
			if ($exc) {
				$nv_Cache->delMod($module_name);
				if (empty($row['id'])) {
					$product_id=$db->query('SELECT max(id) FROM ' . TABLE. '_product')->fetchColumn();
					foreach($row['block'] as $value){
						$db->query('INSERT INTO  ' . TABLE. '_block_id(bid,product_id) VALUES('.$value.','.$product_id.')');
					}
					foreach($row['classify'] as $value){
						$sql = 'INSERT INTO ' . TABLE .'_product_classify (name_classify,product_id,status) VALUES (:name_classify,:product_id,1)';
						$data_insert=array();
						$data_insert['name_classify'] = $value['name'];
						$data_insert['product_id']=$product_id;
						$classify_id = $db->insert_id($sql, 'id', $data_insert);
						foreach($value['value'] as $value_list){
							$sql2 = 'INSERT INTO ' . TABLE . '_product_classify_value (classify_id,name,status) VALUES (:classify_id,:name,1)';
							$data_insert2=array();
							$data_insert2['classify_id'] = $classify_id;
							$data_insert2['name']=$value_list;
							$classify_id_value = $db->insert_id($sql2, 'id', $data_insert2);
						}
					}
					foreach($row['product'] as $value){
						$classify_id_value1=$db->query('SELECT t2.id FROM  ' . TABLE . '_product_classify t1 INNER JOIN ' . TABLE . '_product_classify_value t2 ON t1.id=t2.classify_id where t1.product_id='.$product_id.' and t2.name='.$db->quote($value['id1']))->fetchColumn();
						if(!empty($value['id2'])){
							$classify_id_value2=$db->query('SELECT t2.id FROM  ' . TABLE . '_product_classify t1 INNER JOIN ' . TABLE . '_product_classify_value t2 ON t1.id=t2.classify_id where t1.product_id='.$product_id.' and t2.name='.$db->quote($value['id2']))->fetchColumn();
						}else{
							$classify_id_value2=0;
						}
						$sql3 = 'INSERT INTO ' .TABLE . '_product_classify_value_product (classify_id_value1,classify_id_value2,price,price_special,status) VALUES (:classify_id_value1,:classify_id_value2,:price,:price_special,1)';
						$data_insert2=array();
						$data_insert2['classify_id_value1'] = $classify_id_value1;
						$data_insert2['classify_id_value2']=$classify_id_value2;
						$data_insert2['price']=$value['price'];
						$data_insert2['price_special']=$value['price_special'];
						$classify_id_value_product = $db->insert_id($sql3, 'id', $data_insert2);
					}
					nv_insert_logs(NV_LANG_DATA, $module_name, 'Add Product', ' ', $admin_info['userid']);
				} else {
					$db->query('DELETE FROM ' . TABLE. '_block_id where product_id='.$row['id']);
					foreach($row['block'] as $value){
						$db->query('INSERT INTO  ' . TABLE. '_block_id(bid,product_id) VALUES('.$value.','.$row['id'].')');
					}
					foreach($row['change_status'] as $key=>$value){
						$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET status='.$value.' WHERE id=' . $key);
					}
					
					// xử lý cập nhật lại thuộc tính sản phẩm chính xác
					/*
					print_r($row['classify']);
					
					print_r($row['product']);
					
					die;
					*/
					
					// lấy danh sách thuộc tính cũ
					$list_classify_old = $db->query('SELECT id FROM ' . TABLE .'_product_classify WHERE product_id ='. $row['id'])->fetchAll();
					
					if(empty($list_classify_old))
					{
						// thuộc tính cũ không có. thêm mới hoàn toàn
						foreach($row['classify'] as $value){
						$sql = 'INSERT INTO ' . TABLE .'_product_classify (name_classify,product_id,status) VALUES (:name_classify,:product_id,1)';
						$data_insert=array();
						$data_insert['name_classify'] = $value['name'];
						$data_insert['product_id']=$row['id'];
						$classify_id = $db->insert_id($sql, 'id', $data_insert);
						
						
						foreach($value['value'] as $value_list){
							$sql2 = 'INSERT INTO ' . TABLE . '_product_classify_value (classify_id,name,status) VALUES (:classify_id,:name,1)';
							$data_insert2=array();
							$data_insert2['classify_id'] = $classify_id;
							$data_insert2['name']=$value_list;
							$classify_id_value = $db->insert_id($sql2, 'id', $data_insert2);
						}
						}
						
						// cập nhật giá thuộc tính
						foreach($row['product'] as $value){
							$classify_id_value1=$db->query('SELECT t2.id FROM  ' . TABLE . '_product_classify t1 INNER JOIN ' . TABLE . '_product_classify_value t2 ON t1.id=t2.classify_id where t1.product_id='.$row['id'].' and t2.name='.$db->quote($value['id1']))->fetchColumn();
							if(!empty($value['id2'])){
								$classify_id_value2=$db->query('SELECT t2.id FROM  ' . TABLE . '_product_classify t1 INNER JOIN ' . TABLE . '_product_classify_value t2 ON t1.id=t2.classify_id where t1.product_id='.$row['id'].' and t2.name='.$db->quote($value['id2']))->fetchColumn();
							}else{
								$classify_id_value2=0;
							}
							$sql3 = 'INSERT INTO ' .TABLE . '_product_classify_value_product (classify_id_value1,classify_id_value2,price,price_special,status) VALUES (:classify_id_value1,:classify_id_value2,:price,:price_special,1)';
							$data_insert2=array();
							$data_insert2['classify_id_value1'] = $classify_id_value1;
							$data_insert2['classify_id_value2']=$classify_id_value2;
							$data_insert2['price']=$value['price'];
							$data_insert2['price_special']=$value['price_special'];
							$classify_id_value_product = $db->insert_id($sql3, 'id', $data_insert2);
						}
						
					}
					else
					{
						// cập nhật lại thuộc tính
						// lọc id thuộc tính
						$classify_old_array = array();
						foreach($list_classify_old as $classify_old)
						{
							$classify_old_array[] = $classify_old['id'];
						}
						
						// lọc id thuộc tính
						$classify_current = array();
						$classify_value_current = array();
						foreach($row['classify'] as $key=>$value)
						{
							$classify_current[] = $key;
							
							if($value['value'])
							{
								foreach($value['value'] as $key_v => $value_v)
								{
									$classify_value_current[] = $key_v;
								}
							}
						}
						
						
						// xóa thuộc tính trước tầng 1
						foreach($classify_old_array as $key){
							
							
							if(is_numeric($key)){
								
							// lấy danh sách các thuộc tính con rad
							$list_con_classify = $db->query('SELECT id FROM ' . TABLE .'_product_classify_value WHERE classify_id ='. $key)->fetchAll();
							
							foreach($list_con_classify as $con_classify)
							{
								if(!in_array($con_classify['id'], $classify_value_current))
								{
								// xóa thuộc tính 1 classify_id_value1
								$db->query('DELETE FROM ' . TABLE .'_product_classify_value_product WHERE classify_id_value1 ='. $con_classify['id']);
										
								// xóa thuộc tính 2 classify_id_value2
								$db->query('DELETE FROM ' . TABLE .'_product_classify_value_product WHERE classify_id_value2 ='. $con_classify['id']);
										
								// xóa thuộc tính _product_classify_value luôn
								$db->query('DELETE FROM ' . TABLE .'_product_classify_value WHERE id ='. $con_classify['id']);
								}
							}
									
									
								if(!in_array($key, $classify_current ))
								{
									// xử lý xóa các thuộc tính classify
									$db->query('DELETE FROM ' . TABLE .'_product_classify WHERE id ='. $key);
									
								}
								
								
							}						
						}
						
						// xử lý cập nhật hay thêm thuộc tính mới tùy trường hợp
						
						foreach($row['classify'] as $key=>$value){
							if(is_numeric($key)){
								// đã tồn tại classify trên hệ thống nên cập nhật lại giá trị
								$check_classify=$db->query('SELECT count(*) FROM ' . TABLE . '_product_classify WHERE id=' .(int)$key)->fetchColumn();
								
								if($check_classify>0){
								$db->query('UPDATE ' . TABLE . '_product_classify SET name_classify='.$db->quote($value['name']).' WHERE id=' . $key);
								foreach($value['value'] as $key_list=>$value_list){

									$check_classify_value=$db->query('SELECT count(*) as count, t1.id FROM ' . TABLE . '_product_classify_value t1 INNER JOIN ' . TABLE . '_product_classify t2 ON t2.id=t1.classify_id WHERE t1.id=' .$key_list.' and t2.id='.$db->quote($key).' and t2.product_id='.$row['id'])->fetch();
									

									if($check_classify_value['count']==0){
										$sql2 = 'INSERT INTO ' . TABLE . '_product_classify_value (classify_id,name,status) VALUES (:classify_id,:name,1)';
										$data_insert2=array();
										$data_insert2['classify_id'] = $key;
										$data_insert2['name']=$value_list;
										$classify_id_value = $db->insert_id($sql2, 'id', $data_insert2);
									}else{
										$db->query('UPDATE ' . TABLE . '_product_classify_value SET name='.$db->quote($value_list).' WHERE id=' . $check_classify_value['id']);
									}
								}
							}
							else{
								$sql = 'INSERT INTO ' . TABLE .'_product_classify (name_classify,product_id,status) VALUES (:name_classify,:product_id,1)';
								$data_insert=array();
								$data_insert['name_classify'] = $value['name'];
								$data_insert['product_id']=$row['id'];
								$classify_id = $db->insert_id($sql, 'id', $data_insert);
								foreach($value['value'] as $value_list){
									$sql2 = 'INSERT INTO ' . TABLE . '_product_classify_value (classify_id,name,status) VALUES (:classify_id,:name,1)';
									$data_insert2=array();
									$data_insert2['classify_id'] = $classify_id;
									$data_insert2['name']=$value_list;
									$classify_id_value = $db->insert_id($sql2, 'id', $data_insert2);
								}
							}
								
							}
							else{
							$sql = 'INSERT INTO ' . TABLE .'_product_classify (name_classify,product_id,status) VALUES (:name_classify,:product_id,1)';
							$data_insert=array();
							$data_insert['name_classify'] = $value['name'];
							$data_insert['product_id']=$row['id'];
							$classify_id = $db->insert_id($sql, 'id', $data_insert);
							foreach($value['value'] as $value_list){
								$sql2 = 'INSERT INTO ' . TABLE . '_product_classify_value (classify_id,name,status) VALUES (:classify_id,:name,1)';
								$data_insert2=array();
								$data_insert2['classify_id'] = $classify_id;
								$data_insert2['name']=$value_list;
								$classify_id_value = $db->insert_id($sql2, 'id', $data_insert2);
							}
						}
						}
						
						
						// cập nhật giá thuộc tính
						foreach($row['product'] as $value){

						if(!empty($value['id2_old'])){
							$check=$db->query('SELECT count(*) FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1=' . $value['id1_old'].' and classify_id_value2='.$value['id2_old'])->fetchColumn();
							
							
							
							if($check==0){
								$classify_id_value1=$db->query('SELECT t2.id FROM  ' . TABLE . '_product_classify t1 INNER JOIN ' . TABLE . '_product_classify_value t2 ON t1.id=t2.classify_id where t1.product_id='.$row['id'].' and t2.name='.$db->quote($value['id1']))->fetchColumn();
								
								

								if(!empty($value['id2'])){
									$classify_id_value2=$db->query('SELECT t2.id FROM  ' . TABLE . '_product_classify t1 INNER JOIN ' . TABLE . '_product_classify_value t2 ON t1.id=t2.classify_id where t1.product_id='.$row['id'].' and t2.name='.$db->quote($value['id2']))->fetchColumn();
								}else{
									$classify_id_value2=0;
								}

								$sql3 = 'INSERT INTO ' .TABLE . '_product_classify_value_product (classify_id_value1,classify_id_value2,price,price_special,status) VALUES (:classify_id_value1,:classify_id_value2,:price,:price_special,1)';
								$data_insert2=array();
								$data_insert2['classify_id_value1'] = $classify_id_value1;
								$data_insert2['classify_id_value2']=$classify_id_value2;
								$data_insert2['price']=$value['price'];
								$data_insert2['price_special']=$value['price_special'];
								$classify_id_value_product = $db->insert_id($sql3, 'id', $data_insert2);
							}else{

								$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET price='.$value['price'].',price_special='.$value['price_special'].' WHERE classify_id_value1=' . $value['id1_old'].' and classify_id_value2='.$value['id2_old']);
							}
						}else{
							$check=$db->query('SELECT count(*) FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1=' . $value['id1_old'].' and classify_id_value2=0')->fetchColumn();

							if($check==0){
								$classify_id_value1=$db->query('SELECT t2.id FROM  ' . TABLE . '_product_classify t1 INNER JOIN ' . TABLE . '_product_classify_value t2 ON t1.id=t2.classify_id where t1.product_id='.$row['id'].' and t2.name='.$db->quote($value['id1']))->fetchColumn();

								$classify_id_value2=0;
								$sql3 = 'INSERT INTO ' .TABLE . '_product_classify_value_product (classify_id_value1,classify_id_value2,price,price_special,status) VALUES (:classify_id_value1,:classify_id_value2,:price,:price_special,1)';
								$data_insert2=array();
								$data_insert2['classify_id_value1'] = $classify_id_value1;
								$data_insert2['classify_id_value2']=$classify_id_value2;
								$data_insert2['price']=$value['price'];
								$data_insert2['price_special']=$value['price_special'];

								$classify_id_value_product = $db->insert_id($sql3, 'id', $data_insert2);
							}else{
								$db->query('UPDATE ' . TABLE . '_product_classify_value_product SET price='.$value['price'].',price_special='.$value['price_special'].' WHERE classify_id_value1=' . $value['id1_old'].' and classify_id_value2=0');
							}

						}
					}
						
					}
					// kết thúc xử lý cập nhật lại thuộc tính sản phẩm
					
					
					nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit Product', 'ID: ' . $row['id'], $admin_info['userid']);
				}
				nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=product');
			}
		} catch(PDOException $e) {
			trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }else{
    	if(get_info_category($row['categories_id'])['parrent_id']==0){
    		$row['categories_name']='<span style="font-weight:bold">'.get_info_category($row['categories_id'])['name'].'</span>';
    	}else{
    		$row['categories_name']='<span>&emsp;'.get_info_category($row['categories_id'])['name'].'</span>';
    	}
    	$row['brand_name']=get_info_brand($row['brand'])['title'];
    	$row['origin_name']=get_info_orgin($row['origin'])['title'];
		$server = 'banhang.'.$_SERVER["SERVER_NAME"];
		$row['image'] = substr($row['image'], strlen('https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/'));
    }
} elseif ($row['id'] > 0) {
	$row = $db->query('SELECT * FROM ' . TABLE . '_product WHERE id=' . $row['id'])->fetch();
	if(get_info_category($row['categories_id'])['parrent_id']==0){
		$row['categories_name']='<span style="font-weight:bold">'.get_info_category($row['categories_id'])['name'].'</span>';
	}else{
		$row['categories_name']='<span>&emsp;'.get_info_category($row['categories_id'])['name'].'</span>';
	}
	$row['brand_name']=get_info_brand($row['brand'])['title'];
	$row['origin_name']=get_info_orgin($row['origin'])['title'];
	$row['price']=number_format($row['price']);
	$row['price_special']=number_format($row['price_special']);
	$row['classify']=$db->query('SELECT * FROM ' . TABLE . '_product_classify WHERE product_id=' . $row['id'])->fetchAll();
	$row['classify_error']=array();
	if (empty($row)) {
		nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
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
	$row['image'] = '';
	$row['description'] = '';
	$row['bodytext'] = '';
	$row['unit_weight']=0;
	$row['unit_id']=0;
	$row['unit_currency']=0;
	$row['unit_length']=0;
	$row['unit_width']=0;
	$row['unit_height']=0;
	$row['store_id']=0;
	$row['classify']=array();
	$row['other_image']='';
	$row['block']='';
	$row['inhome']=1;
	$row['allowed_rating']=0;
	$row['showprice']=0;
}
if (!empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['image'])) {
	$row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'. $row['image'];
}else{
	$server = 'banhang.'.$_SERVER["SERVER_NAME"];
	$row['image']  ='https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $row['image'] ;
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



$xtpl = new XTemplate('product_add_new.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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


$array_cat_list = category_html_select(0);

foreach ($array_cat_list as $rows_i) {
	
    $sl = ($rows_i['id'] == $row['categories_id']) ? " selected=\"selected\"" : "";
    $xtpl->assign('pcatid_i', $rows_i['id']);
    $xtpl->assign('ptitle_i', $rows_i['text']);
    $xtpl->assign('pselect', $sl);
    $xtpl->parse('main.parent_loop');
}


if($row['id']){
	foreach ($list_brand as $value_list) {
		if($row['brand'] == $value_list['id']){
			$value_list["selected"] = "selected";
		}
		$xtpl->assign( 'STATUS', $value_list);
		$xtpl->parse( 'main.brand' );
	}

	foreach ($list_origin as $value_list) {
		if($row['origin'] == $value_list['id']){
			$value_list["selected"] = "selected";
		}
		$xtpl->assign( 'STATUS', $value_list);
		$xtpl->parse( 'main.origin' );
	}
	$list_cat = get_categories_select2_full("",IDSITE);

	foreach ($list_cat as $value_list) {
		if($row['categories_id'] == $value_list['id']){
			$value_list["selected"] = "selected";
		}
		$xtpl->assign( 'STATUS', $value_list);
		$xtpl->parse( 'main.categories_id' );
	}
}

$xtpl->assign('ROW', $row);
if($row['inhome']==1){
	$xtpl->assign('check_inhome', 'checked=checked');
}else{
	$xtpl->assign('check_inhome', '');
}
if($row['allowed_rating']==1){
	$xtpl->assign('check_allowed_rating', 'checked=checked');
}else{
	$xtpl->assign('check_allowed_rating', '');
}
if($row['showprice']==1){
	$xtpl->assign('check_showprice', 'checked=checked');
}else{
	$xtpl->assign('check_showprice', '');
}
if($row['id']>0){
	$xtpl->assign('readonly', 'readonly');
	$xtpl->assign('random_num', '');
	$xtpl->assign('pointer', '');
}else{
	$xtpl->assign('readonly', '');
	$xtpl->assign('random_num', 'random_num');
	$xtpl->assign('pointer', 'pointer');
}
$xtpl->assign('raw_product_prefix', $config_setting['raw_product_prefix']);
$xtpl->assign('currentpath', NV_UPLOADS_DIR .'/'.$module_upload. '/' . date('Y_m'));
$list_unit_weight=get_full_unit_weight();
foreach($list_unit_weight as $value){
	$xtpl->assign('unit_weight', array(
		'key' => $value['id'],
		'title' => $value['name_weight'].' ('.$value['symbol'].')',
		'selected' => ($value['id'] == $row['unit_weight']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.unit_weight');
}
$list_unit=get_full_unit();
foreach($list_unit as $value){
	$xtpl->assign('unit_id', array(
		'key' => $value['id'],
		'title' => $value['name'],
		'selected' => ($value['id'] == $row['unit_id']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.unit_id');
}
$list_unit_currency=get_full_unit_currency();

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

$list_unit_length=get_full_unit_length();
foreach($list_unit_length as $value){
	$xtpl->assign('unit_length', array(
		'key' => $value['id'],
		'title' => $value['name_length'].' ('.$value['symbol'].')',
		'selected' => ($value['id'] == $row['unit_length']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.unit_length');
}
foreach($list_unit_length as $value){
	$xtpl->assign('unit_width', array(
		'key' => $value['id'],
		'title' => $value['name_length'].' ('.$value['symbol'].')',
		'selected' => ($value['id'] == $row['unit_width']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.unit_width');
}
foreach($list_unit_length as $value){
	$xtpl->assign('unit_height', array(
		'key' => $value['id'],
		'title' => $value['name_length'].' ('.$value['symbol'].')',
		'selected' => ($value['id'] == $row['unit_height']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.unit_height');
}
$list_store=get_full_store();
foreach($list_store as $value){
	$xtpl->assign('store_id', array(
		'key' => $value['id'],
		'title' => $value['company_name'].' (Người đại diện: '.$value['name'].')',
		'selected' => ($value['id'] == $row['store_id']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.store_id');
}

if(count($row['classify'])>0){
	
	$xtpl->assign('classify_check', 'hidden');
	$xtpl->assign('classify_check2', '');
	if($row['id']>0){
		if(count($row['classify_error'])==0){
			if(count($row['classify'])<2){
				$xtpl->assign('classify_check3', '');
			}else{
				$xtpl->assign('classify_check3', 'hidden');
			}
			$data_array=array();
			$data_array1=array();
			foreach($row['classify'] as $key=>$value){
				$xtpl->assign('key_classify', $value['id']);
				$xtpl->assign('key_classify_no', $key);
				$row['classify_value']=$db->query('SELECT * FROM ' . TABLE . '_product_classify_value WHERE classify_id=' . $value['id'])->fetchAll();
				foreach($row['classify_value'] as $key_classify=>$classify_value){
					$xtpl->assign('key_classify_value', $key_classify+1);
					$xtpl->assign('LOOP_classify_value', $classify_value);
					if($key_classify==0){
						$xtpl->parse('main.edit_product.classify.classify_value.classify_value_first');
					}else{
						$xtpl->parse('main.edit_product.classify.classify_value.classify_value_next');
					}
					if($key==0){
						$data_array[]=$classify_value;
					}else{
						$data_array1[]=$classify_value;
					}
					$xtpl->parse('main.edit_product.classify.classify_value');
					$xtpl->parse('main.edit_productjs.classify.classify_value');
				}
				
				$xtpl->assign('LOOP_classify', $value);
				$xtpl->parse('main.edit_product.classify');
				$xtpl->parse('main.edit_classify_product2.classify');
				$xtpl->parse('main.edit_productjs.classify');
			}
			
			$xtpl->parse('main.edit_product');
			$xtpl->parse('main.edit_classify_product2');
			$data_array_full=array();
			foreach($data_array as $value){
				if(count($data_array1)>0){
					foreach($data_array1 as $value2){
						$data_array_full[]=array(
							"id1"=>$value['id'],
							"name1"=>$value['name'],
							"id2"=>$value2['id'],
							"name2"=>$value2['name'],
						);
					}
				}else{
					$data_array_full[]=array(
						"id1"=>$value['id'],
						"name1"=>$value['name'],
						"id2"=>0
					);
				}
			}
			foreach($data_array_full as $key=>$value){
				$xtpl->assign('data_array_full', $value);
				$xtpl->assign('key_full', $key);
				if($value['id2']>0){
					$row['classify_value_product']=$db->query('SELECT * FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1=' . $value['id1'].' and classify_id_value2=' . $value['id2'])->fetchAll();
					$row['status']=get_info_classify_value_product_classify_id_value1_classify_id_value2($value['id1'],$value['id2'])['status'];
					$xtpl->assign('product_classify_value_product_id', get_info_classify_value_product_classify_id_value1_classify_id_value2($value['id1'],$value['id2'])['id']);
					$xtpl->assign('status', $row['status']);
					if($row['status']==1){
						$row['status_checked']='checked';
					}else{
						$row['status_checked']='';
					}
					$xtpl->assign('status_checked', $row['status_checked']);
					foreach($row['classify_value_product'] as $key_value_product=>$value_product){
						$xtpl->assign('key_value_product', $key_value_product);
						$value_product['price']=number_format($value_product['price']);
						$value_product['price_special']=number_format($value_product['price_special']);
						$xtpl->assign('LOOP_PRODUCT', $value_product);
						$xtpl->parse('main.edit_data_classify_product2_list.loop');
					}
					$xtpl->parse('main.edit_data_classify_product2_list');
				}else{
					$row['classify_value_product']=$db->query('SELECT * FROM ' . TABLE . '_product_classify_value_product WHERE classify_id_value1=' . $value['id1'].' and classify_id_value2=0')->fetchAll();
					$row['status']=get_info_classify_value_product_classify_id_value1_classify_id_value2($value['id1'],0)['status'];
					$xtpl->assign('product_classify_value_product_id', get_info_classify_value_product_classify_id_value1_classify_id_value2($value['id1'],0)['id']);
					$xtpl->assign('status', $row['status']);
					if($row['status']==1){
						$row['status_checked']='checked';
					}else{
						$row['status_checked']='';
					}
					$xtpl->assign('status_checked', $row['status_checked']);
					foreach($row['classify_value_product'] as $key_value_product=>$value_product){
						$xtpl->assign('key_value_product', $key_value_product);
						$value_product['price']=number_format($value_product['price']);
						$value_product['price_special']=number_format($value_product['price_special']);
						$xtpl->assign('LOOP_PRODUCT', $value_product);
						$xtpl->parse('main.edit_data_classify_product2_list_1.loop');
					}
					$xtpl->parse('main.edit_data_classify_product2_list_1');
				}
			}
			$xtpl->parse('main.edit_productjs');
		}else{
			if(count($row['classify_error'])<2){
				$xtpl->assign('classify_check3', '');
			}else{
				$xtpl->assign('classify_check3', 'hidden');
			}
			foreach($row['product'] as $key=>$value_product){
				$xtpl->assign('key_full', $key);
				if($value_product['price']>0){
					$value_product['price']=number_format($value_product['price']);
				}
				if($value_product['price_special']>0){
					$value_product['price_special']=number_format($value_product['price_special']);
				}
				$xtpl->assign('LOOP_PRODUCT', $value_product);
				if(empty($value_product['id2'])){
					$row['status']=get_info_classify_value_product_classify_id_value1_classify_id_value2($value_product['id1_old'],0)['status'];
					$xtpl->assign('product_classify_value_product_id', get_info_classify_value_product_classify_id_value1_classify_id_value2($value_product['id1_old'],0)['id']);
					$xtpl->assign('status', $row['status']);
					if($row['status']==1){
						$row['status_checked']='checked';
					}else{
						$row['status_checked']='';
					}
					$xtpl->assign('status_checked', $row['status_checked']);
					$xtpl->parse('main.edit_data_classify_product2_list_2.one');
				}else{
					$row['status']=get_info_classify_value_product_classify_id_value1_classify_id_value2($value_product['id1_old'],$value_product['id2_old'])['status'];
					$xtpl->assign('product_classify_value_product_id', get_info_classify_value_product_classify_id_value1_classify_id_value2($value_product['id1_old'],$value_product['id2_old'])['id']);
					$xtpl->assign('status', $row['status']);
					if($row['status']==1){
						$row['status_checked']='checked';
					}else{
						$row['status_checked']='';
					}
					$xtpl->assign('status_checked', $row['status_checked']);
					$xtpl->parse('main.edit_data_classify_product2_list_2.two');
				}
				$xtpl->parse('main.edit_data_classify_product2_list_2');
			}
			
			foreach($row['classify_error'] as $key=>$value){
				$xtpl->assign('key_classify', $key);
				$xtpl->assign('LOOP_classify', $value);
				foreach($value['value'] as $key_classify_value=>$classify_value){
					$xtpl->assign('LOOP_classify_value', $classify_value);
					$xtpl->assign('key_classify_value', $key_classify_value);
					if($key_classify_value==1){
						$xtpl->parse('main.edit_product2.classify.classify_value.classify_value_first');
					}else{
						$xtpl->parse('main.edit_product2.classify.classify_value.classify_value_next');
					}
					$xtpl->parse('main.edit_product2.classify.classify_value');
					$xtpl->parse('main.edit_productjs_2.classify.classify_value');
				}
				$xtpl->parse('main.edit_product2.classify');
				$xtpl->parse('main.edit_classify_product2_2.classify');
				$xtpl->parse('main.edit_productjs_2.classify');
			}
			
			$xtpl->parse('main.edit_product2');
			$xtpl->parse('main.edit_classify_product2_2');
			$xtpl->parse('main.edit_productjs_2');
		}
	}else{
		if(count($row['classify'])<2){
			$xtpl->assign('classify_check3', '');
		}else{
			$xtpl->assign('classify_check3', 'hidden');
		}
		foreach($row['product'] as $key=>$value_product){
			$xtpl->assign('key_full', $key);
			$value_product['price']=number_format($value_product['price']);
			$value_product['price_special']=number_format($value_product['price_special']);
			$xtpl->assign('LOOP_PRODUCT', $value_product);
			if(empty($value_product['id2'])){
				$xtpl->parse('main.edit_data_classify_product2_list_2.one');
			}else{
				$xtpl->parse('main.edit_data_classify_product2_list_2.two');
			}
			$xtpl->parse('main.edit_data_classify_product2_list_2');
		}
		$row['classify_new']=array();
		foreach($row['classify'] as $key=>$value){
			$row['classify_new'][]=$value;
		}
		foreach($row['classify_new'] as $key=>$value){
			$xtpl->assign('key_classify', $key+1);
			$xtpl->assign('LOOP_classify', $value);
			foreach($value['value'] as $key_classify_value=>$classify_value){
				$xtpl->assign('LOOP_classify_value', $classify_value);
				$xtpl->assign('key_classify_value', $key_classify_value);
				if($key_classify_value==1){
					$xtpl->parse('main.edit_product2.classify.classify_value.classify_value_first');
				}else{
					$xtpl->parse('main.edit_product2.classify.classify_value.classify_value_next');
				}
				$xtpl->parse('main.edit_product2.classify.classify_value');
				$xtpl->parse('main.edit_productjs_2.classify.classify_value');
			}
			$xtpl->parse('main.edit_product2.classify');
			$xtpl->parse('main.edit_classify_product2_2.classify');
			$xtpl->parse('main.edit_productjs_2.classify');
		}
		$xtpl->parse('main.edit_product2');
		$xtpl->parse('main.edit_classify_product2_2');
		$xtpl->parse('main.edit_productjs_2');
	}
}else{
	$xtpl->assign('classify_check', '');
	$xtpl->assign('classify_check2', 'hidden');
	$xtpl->parse('main.no_edit_product');
}
if($row['other_image']!=''){
	$row['other_image']=explode(' ,',$row['other_image']);
	foreach($row['other_image'] as $key => $value){
		if (!empty($value) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $value)) {
			$value = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'. $value;
		}else{
			$server = 'banhang.'.$_SERVER["SERVER_NAME"];
			$value  ='https://'. $server .NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/' . $value;
		}
		$xtpl->assign('LOOP', $value);
		$xtpl->assign('key', $key+1);
		$xtpl->parse('main.edit_other_image.loop');
		$xtpl->parse('main.edit_other_imagejs.loop');
	}
	$xtpl->parse('main.edit_other_image');
	$xtpl->parse('main.edit_other_imagejs');
}

if($row['categories_id']>0){
	$xtpl->parse('main.edit');
	$xtpl->parse('main.edit2');
}else{
	$xtpl->parse('main.no_edit');
}

if (!empty($error)) {
	$xtpl->assign('ERROR', implode('<br />', $error));
	$xtpl->parse('main.error');
}
if (empty($row['id'])) {
	$xtpl->parse('main.auto_get_alias');
}
$xtpl->assign('CONFIG_SYS', $list_config_retails_sys);

$xtpl->parse('main');
$contents = $xtpl->text('main');
if($row['id']==0){
	$page_title = $lang_module['product_add'];
}else{
	$page_title = $lang_module['product_edit'].' có mã vạch '.$row['barcode'];
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
