<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 13 May 2021 03:38:52 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');


/*


// xử lý thêm bigdata
$row = $db->query('SELECT * FROM ' . TABLE .'_product WHERE id =71')->fetch();

// thông tin kho của sản phẩm
$inventory = $db->query('SELECT * FROM ' . TABLE .'_inventory_product WHERE product_id  =71')->fetch();

for($i = 400000; $i < 500000; $i++)
{
	$sql = 'INSERT INTO ' . TABLE . '_product(price_sort,origin, brand,store_id,barcode, name_product, alias, categories_id, unit_id, unit_weight, weight_product, length_product, width_product, height_product,unit_length,unit_height,unit_width,image, other_image, description, bodytext, keyword, tag_title, tag_description, time_add, user_add, weight, status,inhome,allowed_rating,showprice,price_min,price_max,price,price_special) VALUES (:price_sort,:origin, :brand,:store_id,:barcode, :name_product, :alias, :categories_id, :unit_id, :unit_weight,:weight_product, :length_product, :width_product, :height_product,:unit_length,:unit_height,:unit_width, :image, :other_image, :description, :bodytext, :keyword, :tag_title, :tag_description, :time_add, :user_add, :weight, :status,:inhome,:allowed_rating,:showprice,:price_min,:price_max,:price,:price_special)';
	
			$data_insert = array();
			
			$data_insert['price_sort']= $row['price_sort'];
			$data_insert['origin']= $row['origin'];
			$data_insert['brand']= $row['brand'];
			$data_insert['store_id']= $row['store_id'];
			$data_insert['barcode']= $row['barcode'];
			$data_insert['name_product']= 'name_product_' . $i;
			$data_insert['alias'] = 'alias_' . $i;
			$data_insert['categories_id'] = $row['categories_id'];
			$data_insert['unit_id'] = $row['unit_id'];
			$data_insert['unit_weight'] = $row['unit_weight'];
			$data_insert['weight_product'] = $row['weight_product'];
			$data_insert['length_product'] = $row['length_product'];
			$data_insert['width_product'] = $row['width_product'];
			$data_insert['height_product'] = $row['height_product'];
			$data_insert['unit_length'] = $row['unit_length'];
			$data_insert['unit_height'] = $row['unit_height'];
			$data_insert['unit_width'] = $row['unit_width'];
			$data_insert['image'] = $row['image'];
			$data_insert['other_image'] = $row['other_image'];
			$data_insert['description'] = $row['description'];
			$data_insert['bodytext'] = $row['bodytext'];
			$data_insert['keyword'] = $row['keyword'];
			$data_insert['tag_title'] = $row['tag_title'];
			$data_insert['tag_description'] = $row['tag_description'];
			$data_insert['time_add'] = $row['time_add'];
			$data_insert['user_add'] = $row['user_add'];
			$data_insert['weight'] = $row['weight'];
			$data_insert['status'] = $row['status'];
			$data_insert['inhome'] = $row['inhome'];
			$data_insert['allowed_rating'] = $row['allowed_rating'];
			$data_insert['showprice'] = $row['showprice'];
			$data_insert['price_min'] = $row['price_min'];
			$data_insert['price_max'] = $row['price_max'];
			$data_insert['price'] = $row['price'];
			$data_insert['price_special'] = $row['price_special'];
			
			
            $product_id = $db->insert_id( $sql, 'id', $data_insert );
			
			
			
			// thêm vào kho
			$stmt = $db->prepare('INSERT INTO ' . TABLE . '_inventory_product(store_id, warehouse_id, product_id, classify_value_product_id, amount, amount_delivery) VALUES (:store_id, :warehouse_id, :product_id, :classify_value_product_id, :amount, :amount_delivery)');
			
			$inventory['classify_value_product_id'] = 0;
			$inventory['amount'] = 100;
			
			$stmt->bindParam(':store_id', $inventory['store_id'], PDO::PARAM_INT);
            $stmt->bindParam(':warehouse_id', $inventory['warehouse_id'], PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':classify_value_product_id', $inventory['classify_value_product_id'], PDO::PARAM_INT);
            $stmt->bindParam(':amount', $inventory['amount'], PDO::PARAM_INT);
            $stmt->bindParam(':amount_delivery', $inventory['amount_delivery'], PDO::PARAM_INT);
			
			$exc = $stmt->execute();
			
		
			
}

// kết thúc


  die(ok);
  


// xử lý thêm bigdata
$row = $db->query('SELECT * FROM ' . TABLE .'_order WHERE id = 134')->fetch();

$products = $db->query('SELECT * FROM ' . TABLE .'_order_item WHERE order_id = 134')->fetchAll();



for($i = 0; $i < 100000; $i++)
{
	$sql = 'INSERT INTO ' . TABLE . '_order ( userid,order_code,store_id,warehouse_id,order_name,email,phone,province_id,district_id,ward_id,address,transporters_id,total_product,fee_transport,total,note,time_add,status,payment,total_weight,total_height,total_width,total_length,payment_method,lat,lng) VALUES (:userid,:order_code,:store_id,:warehouse_id,:order_name,:email,:phone,:province_id,:district_id,:ward_id,:address,:transporters_id,:total_product,:fee_transport,:total,:note,:time_add,0,:payment,:total_weight,:total_height,:total_width,:total_length,:payment_method,:lat,:lng)';

					$order_code = $row['order_code'] . '_' . $i;
					$data_insert = array();
					$data_insert['userid']=$row['userid'];
					$data_insert['order_code'] = $order_code;
					$data_insert['store_id'] = $row['store_id'];
					$data_insert['warehouse_id'] = $row['warehouse_id'];
					$data_insert['order_name'] = $row['order_name'];
					$data_insert['email'] = $row['email'];
					$data_insert['phone'] = $row['phone'];
					$data_insert['province_id'] = $row['province_id'];
					$data_insert['district_id'] = $row['district_id'];
					$data_insert['ward_id'] = $row['ward_id'];
					$data_insert['address'] = $row['address'];
					$data_insert['transporters_id'] = $row['transporters_id'];
					$data_insert['total_product'] = $row['total_product'];
					$data_insert['fee_transport'] = $row['fee_transport'];
					$data_insert['total'] = $row['total'];
					$data_insert['note'] = $row['note'];
					$data_insert['time_add'] = NV_CURRENTTIME;
					$data_insert['total_weight'] = $row['total_weight'];
					$data_insert['total_height'] =  $row['total_height'];
					$data_insert['total_width'] = $row['total_width'];
					$data_insert['total_length'] = $row['total_length'];
					$data_insert['payment_method'] = $row['payment_method'];
					$data_insert['lat'] = $row['lat'];
					$data_insert['lng'] = $row['lng'];
					$data_insert['payment'] = 0;

					$order_id = $db->insert_id( $sql, 'id', $data_insert );
			
		// thêm sản phẩm đặt 
		
		foreach($products as $product)
		{
			$db->query( 'INSERT INTO ' . TABLE . '_order_item(order_id,product_id,weight,length,height,width,price,classify_value_product_id,quantity,total) VALUES('.$order_id.','.$product['product_id'].','.$product['weight'].','.$product['length'].','.$product['height'].','.$product['width'].','.$product['price'].','.$product['classify_value_product_id'].','.$product['quantity'].','.$product['total'].')' );
		}
		
		//print_r($order_id);die;
}

// kết thúc


die(ok);
  
  
*/ 

$array_userid_users = array();
$_sql = 'SELECT username,userid FROM tms_users';
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_userid_users[$_row['userid']] = $_row;
}


$q = $nv_Request->get_title('q', 'post,get');

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . NV_PREFIXLANG . '_' . $module_data . '_history_vnpay');

    if (!empty($q)) {
        $db->where('price LIKE :q_price OR name_register LIKE :q_name_register OR email_register LIKE :q_email_register OR phone_register LIKE :q_phone_register OR userid LIKE :q_userid OR vnp_txnref LIKE :q_vnp_txnref OR vnp_orderinfo LIKE :q_vnp_orderinfo OR vnp_responsedode LIKE :q_vnp_responsedode OR vnp_transactionno LIKE :q_vnp_transactionno OR vnp_paydate LIKE :q_vnp_paydate OR status LIKE :q_status');
    }
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_price', '%' . $q . '%');
        $sth->bindValue(':q_name_register', '%' . $q . '%');
        $sth->bindValue(':q_email_register', '%' . $q . '%');
        $sth->bindValue(':q_phone_register', '%' . $q . '%');
        $sth->bindValue(':q_userid', '%' . $q . '%');
        $sth->bindValue(':q_vnp_txnref', '%' . $q . '%');
        $sth->bindValue(':q_vnp_orderinfo', '%' . $q . '%');
        $sth->bindValue(':q_vnp_responsedode', '%' . $q . '%');
        $sth->bindValue(':q_vnp_transactionno', '%' . $q . '%');
        $sth->bindValue(':q_vnp_paydate', '%' . $q . '%');
        $sth->bindValue(':q_status', '%' . $q . '%');
    }
    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('id DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    if (!empty($q)) {
        $sth->bindValue(':q_price', '%' . $q . '%');
        $sth->bindValue(':q_name_register', '%' . $q . '%');
        $sth->bindValue(':q_email_register', '%' . $q . '%');
        $sth->bindValue(':q_phone_register', '%' . $q . '%');
        $sth->bindValue(':q_userid', '%' . $q . '%');
        $sth->bindValue(':q_vnp_txnref', '%' . $q . '%');
        $sth->bindValue(':q_vnp_orderinfo', '%' . $q . '%');
        $sth->bindValue(':q_vnp_responsedode', '%' . $q . '%');
        $sth->bindValue(':q_vnp_transactionno', '%' . $q . '%');
        $sth->bindValue(':q_vnp_paydate', '%' . $q . '%');
        $sth->bindValue(':q_status', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate('history_vnpay.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
$xtpl->assign('ROW', $row);

$xtpl->assign('Q', $q);

if ($show_view) {
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
    if (!empty($q)) {
        $base_url .= '&q=' . $q;
    }
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
        $view['addtime'] = (empty($view['addtime'])) ? '' : nv_date('d/m/Y - H:i', $view['addtime']);
		if(isset($array_userid_users[$view['userid']]['username']))
        $view['userid'] = $array_userid_users[$view['userid']]['username'];
	
		$view['price']=number_format($view['price']);
		
		
		
        
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}


if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['history_vnpay'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
