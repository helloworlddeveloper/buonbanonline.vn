<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS Holdings <contact@tms.vn>
 * @Copyright (C) 2020 TMS Holdings. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 21 Dec 2020 09:08:19 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$product_id = $nv_Request->get_int( 'id', 'post,get' ,0);
$row = array();
$error = array();
$row['warehouse_product_import_id'] = $nv_Request->get_int('warehouse_product_import_id', 'post,get', 0);
if($row['warehouse_product_import_id']==0){
	$row['product_id']=$product_id;
}

if ($nv_Request->isset_request('submit', 'post')) {
	 $row['title'] = $nv_Request->get_title('title', 'post', '');
	 $row['product_id'] = $nv_Request->get_title('product_id', 'post', '');
	 $row['product1'] = $nv_Request->get_typed_array('product', 'post', 'array');
	 $row['store_id']=get_info_product($row['product_id'])['store_id'];
	 $row['warehouse_id'] =get_info_warehouse_store($row['store_id'])['id'];
	 $row['total_price']=0;
	 $row['total_amount']=0;
	 $row['product']=array();
	 $row['product1'] = $nv_Request->get_typed_array('product', 'post', 'array');
	 $row['amount'] = $nv_Request->get_title('amount', 'post', 0);
	 $row['price'] = $nv_Request->get_title('price', 'post', 0);
	 $row['price']=str_replace(',','',$row['price']);
	 $row['unit_currency'] = $nv_Request->get_title('unit_currency', 'post', 0);
	 foreach($row['product1'] as $key => $value){
		$value['price']=str_replace(',','',$value['price']);
		$row['total_price'] = $row['total_price'] + $value['price']*get_info_currency($value['unit_currency'])['exchange'];
		$row['total_amount'] = $row['total_amount'] + $value['amount'];
		$row['product'][$key]['amount']=$value['amount'];
		$row['product'][$key]['price']=$value['price'];
		$row['product'][$key]['unit_currency']=$value['unit_currency'];
	 }
	 if(count($row['product'])==0){
		 $row['total_amount'] = $row['total_amount'] + $row['amount'];
		 $row['total_price'] = $row['total_price'] + $row['price']*get_info_currency($row['unit_currency'])['exchange'];
	 }

	 if(empty($row['title'])){
		 $error[] = 'Vui lòng nhập nội dung nhập kho';
	 }
	 if (empty($error)) {
        try {
            if (empty($row['warehouse_product_import_id'])) {
                $row['time_add'] = NV_CURRENTTIME;
                $row['user_add'] = $admin_info['userid'];
				$warehouse_product_import_id=$db->query('SELECT max(warehouse_product_import_id) FROM ' . TABLE. '_warehouse_import')->fetchColumn();
				if(empty($warehouse_product_import_id)){
					$id_next=1;
				}else{
					$id_next=$warehouse_product_import_id+1;
				}
				$row['warehouse_product_import_code']=$config_setting['raw_import_product_prefix'].'00000'.$id_next;
                $stmt = $db->prepare('INSERT INTO ' . TABLE . '_warehouse_import(warehouse_product_import_code,store_id,warehouse_id,title,time_add,user_add,total_price,total_amount) VALUES (:warehouse_product_import_code,:store_id,:warehouse_id,:title,:time_add,:user_add,:total_price,:total_amount)');
                $stmt->bindParam(':time_add', $row['time_add'], PDO::PARAM_INT);
				$stmt->bindParam(':store_id', $row['store_id'], PDO::PARAM_INT);
				$stmt->bindParam(':warehouse_id', $row['warehouse_id'], PDO::PARAM_INT);
                $stmt->bindParam(':user_add', $row['user_add'], PDO::PARAM_INT);
				$stmt->bindParam(':total_price', $row['total_price'], PDO::PARAM_INT);
				$stmt->bindParam(':total_amount', $row['total_amount'], PDO::PARAM_INT);
				$stmt->bindParam(':warehouse_product_import_code', $row['warehouse_product_import_code'], PDO::PARAM_STR);
				
			}else{
				 $stmt = $db->prepare('UPDATE ' . TABLE . '_warehouse_import SET title=:title WHERE warehouse_product_import_id=' . $row['warehouse_product_import_id']);
			}
			$stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
			$exc = $stmt->execute();
			 if ($exc) {
                $nv_Cache->delMod($module_name);
                if (empty($row['warehouse_product_import_id'])) {
					$row['warehouse_product_import_id']=$db->query('SELECT max(warehouse_product_import_id) FROM ' . TABLE. '_warehouse_import')->fetchColumn();
					 if(count($row['product'])==0){
						 $db->query('INSERT INTO '. TABLE.'_warehouse_import_item(warehouse_product_import_id,product_id,classify_value_product_id ,price_import,amount,unit_currency) VALUES('.$row['warehouse_product_import_id'].','.$row['product_id'].',0,'.$row['price'].','.$row['amount'].','.$row['unit_currency'].')');
						 $check=$db->query('SELECT count(*) FROM '. TABLE.'_inventory_product where warehouse_id='.$row['warehouse_id'].' and product_id='.$row['product_id'].' and classify_value_product_id =0')->fetchColumn();
						 if($check==0){
							$db->query('INSERT INTO '. TABLE.'_inventory_product(store_id,warehouse_id,product_id,classify_value_product_id,amount,amount_delivery) VALUES('.$row['store_id'].','.$row['warehouse_id'].','.$row['product_id'].',0,'.$row['amount'].',0)');
						}else{
							$amount_old=$db->query('SELECT amount FROM '. TABLE.'_inventory_product where warehouse_id='.$row['warehouse_id'].' and product_id='.$row['product_id'].' and classify_value_product_id =0')->fetchColumn();
							$amount_new = $amount_old + $row['amount'];
							$db->query('UPDATE '. TABLE.'_inventory_product SET amount='.$amount_new.' where warehouse_id='.$row['warehouse_id'].' and product_id='.$row['product_id'].' and classify_value_product_id=0');
						}
					 }else{
						 foreach($row['product'] as $key => $value){
							$db->query('INSERT INTO '. TABLE.'_warehouse_import_item(warehouse_product_import_id,product_id,classify_value_product_id ,price_import,amount,unit_currency) VALUES('.$row['warehouse_product_import_id'].','.$row['product_id'].','.$key.','.$value['price'].','.$value['amount'].','.$value['unit_currency'].')');
						 }
						 foreach($row['product'] as $key => $value){
							$check=$db->query('SELECT count(*) FROM '. TABLE.'_inventory_product where warehouse_id='.$row['warehouse_id'].' and product_id='.$row['product_id'].' and classify_value_product_id ='.$key)->fetchColumn();
							if($check==0){
								$db->query('INSERT INTO '. TABLE.'_inventory_product(store_id,warehouse_id,product_id,classify_value_product_id,amount,amount_delivery) VALUES('.$row['store_id'].','.$row['warehouse_id'].','.$row['product_id'].','.$key.','.$value['amount'].',0)');
							}else{
								$amount_old=$db->query('SELECT amount FROM '. TABLE.'_inventory_product where warehouse_id='.$row['warehouse_id'].' and product_id='.$row['product_id'].' and classify_value_product_id ='.$key)->fetchColumn();
								$amount_new = $amount_old + $value['amount'];
								$db->query('UPDATE '. TABLE.'_inventory_product SET amount='.$amount_new.' where warehouse_id='.$row['warehouse_id'].' and product_id='.$row['product_id'].' and classify_value_product_id='.$key);
							}
						 }
					 }
					 nv_insert_logs(NV_LANG_DATA, $module_name, 'Add warehouse_import', ' ', $admin_info['userid']);
				}else{
					  nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit warehouse_import', 'ID: ' . $row['warehouse_product_import_id'], $admin_info['userid']);
				}
			 }
			 nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=product');
		}catch(PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
	 }else{
		$info_product=get_info_product($row['product_id']);
		$info_product['alias'] = NV_MY_DOMAIN .'/'.get_info_category($info_product['categories_id'])['alias'].'/'.$info_product['alias'];
	 }
}else{
	$info_product=get_info_product($product_id);
	$info_product['alias'] = NV_MY_DOMAIN .'/'.get_info_category($info_product['categories_id'])['alias'].'/'.$info_product['alias'];
	$row['warehouse_id']=0;
}

$xtpl = new XTemplate('product_import_warehouse.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('info_product', $info_product);
$xtpl->assign('text', 'Nhập kho ngày: '.date('d-m-Y',NV_CURRENTTIME));

$list_classify=get_full_classify($info_product['id']);
$list_unit_currency=get_full_unit_currency();
$list_warehouse=get_warehouse_store($info_product['store_id']);
foreach($list_warehouse as $value){
	$xtpl->assign('warehouse_id', array(
		'key' => $value['id'],
		'title' => $value['name_warehouse'],
		'selected' => ($value['id'] == $row['warehouse_id']) ? ' selected="selected"' : ''));
	$xtpl->parse('main.warehouse_id');
}      
$data_array=array();
$data_array1=array();

if(!empty($list_classify)){
	foreach($list_classify as $key=>$value){
		$list_classify_value=get_full_classify_value($value['id']);
		foreach($list_classify_value as $classify_value){
			if(count($list_classify)==2){
				if($key==0){
					$data_array[]=$classify_value;
				}else{
					$data_array1[]=$classify_value;
				}
			}else{
				$data_array[]=$classify_value;
			}
		}
		$xtpl->assign('info_classify', $value);
		$xtpl->parse('main.classify.loop');
	}
	if(count($list_classify)==2){
		foreach($data_array as $classify_id_value1){
			foreach($data_array1 as $classify_id_value2){
				$list_classify_value_product=get_full_classify_value_product($classify_id_value1['id'],$classify_id_value2['id']);
				foreach($list_classify_value_product as $value_product){
					$value_product['name1']=$classify_id_value1['name'];
					$value_product['name2']=$classify_id_value2['name'];
					$xtpl->assign('info_product', $value_product);
					$xtpl->parse('main.classify.classify_value_2.classify_id_value1.classify_id_value2.loop');
				}
				foreach($list_unit_currency as $value){
					$xtpl->assign('unit_currency', array(
								'key' => $value['id'],
								'title' => $value['name_currency'].' ('.$value['symbol'].')',
								'selected' => ($value['id'] == 0) ? ' selected="selected"' : ''));
					$xtpl->parse('main.classify.classify_value_2.classify_id_value1.classify_id_value2.unit_currency');
				}      
				$xtpl->parse('main.classify.classify_value_2.classify_id_value1.classify_id_value2');
			}
			$xtpl->parse('main.classify.classify_value_2.classify_id_value1');
		}
		$xtpl->parse('main.classify.classify_value_2');
	}else{
		foreach($data_array as $classify_id_value1){
			$list_classify_value_product=get_full_classify_value_product($classify_id_value1['id'],0);
			if(!empty($list_classify_value_product)){
				foreach($list_classify_value_product as $value_product){
					$value_product['name1']=$classify_id_value1['name'];
					if(!empty($classify_id_value2)){
						$value_product['name2']=$classify_id_value2['name'];
					}
					$xtpl->assign('info_product', $value_product);
					$xtpl->parse('main.classify.classify_value_1.classify_id_value1.loop');
				}
				foreach($list_unit_currency as $value){
						$xtpl->assign('unit_currency', array(
									'key' => $value['id'],
									'title' => $value['name_currency'].' ('.$value['symbol'].')',
									'selected' => ($value['id'] == 0) ? ' selected="selected"' : ''));
						$xtpl->parse('main.classify.classify_value_1.classify_id_value1.unit_currency');
				}      
				$xtpl->parse('main.classify.classify_value_1.classify_id_value1');
			}
		}
		$xtpl->parse('main.classify.classify_value_1');
	}
	$xtpl->parse('main.classify');
}else{
	foreach($list_unit_currency as $value){
		$xtpl->assign('unit_currency', array(
			'key' => $value['id'],
			'title' => $value['name_currency'].' ('.$value['symbol'].')',
			'selected' => ($value['id'] == "") ? ' selected="selected"' : ''));
		$xtpl->parse('main.no_classify.unit_currency');
	}      
	$xtpl->parse('main.no_classify');
}
$page_title = $lang_module['product_import_warehouse'];

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
