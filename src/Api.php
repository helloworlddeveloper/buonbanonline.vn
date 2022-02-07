<?php
define('NV_SYSTEM', true);
// thay doi 67
define('NV_ROOTDIR', pathinfo(str_replace(DIRECTORY_SEPARATOR, '/', __file__), PATHINFO_DIRNAME));

require NV_ROOTDIR . '/includes/mainfile.php';
require NV_ROOTDIR . '/includes/core/user_functions.php';
define('TABLE',   $db_config['dbsystem']. '.'.NV_PREFIXLANG. '_retails');

class restful_api {
	protected $method   = '';
	protected $endpoint = '';
	protected $params   = array();
	protected $file     = null;

	public function __construct(){
		$this->_input();
		$this->_process_api();
	}

	private function _process_api(){

		if (method_exists($this, $this->endpoint)){
			$this->{$this->endpoint}();
		}
		else {
			$this->response(500, 'Không tìm thấy');
		}
	}
	private function _input(){
		header("Access-Control-Allow-Orgin: *");
		header("Access-Control-Allow-Methods: *");
		$this->params = explode('/', trim($_SERVER['PATH_INFO'],'/'));
		$this->endpoint = array_shift($this->params);

		// Lấy method của request
		$method         = $_SERVER['REQUEST_METHOD'];
		$allow_method   = array('GET', 'POST', 'PUT', 'DELETE');

		if (in_array($method, $allow_method)){
			$this->method = $method;
		}
		// Nhận thêm dữ liệu tương ứng theo từng loại method
		switch ($this->method) {

		case 'POST':				
			$this->params = $_POST;
			break;
		case 'GET':				
			$this->params = $_POST;
			break;
		case 'PUT':
			$this->file    = file_get_contents("php://input");
			break;

		case 'DELETE':
			// Không cần nhận, bởi params đã được lấy từ url
			break;

		default:
			$this->response(500, 'Không tìm thấy');
			break;
		}
		

	}

	protected function response($status_code, $data = NULL){
		header($this->_build_http_header_string($status_code));
		header("Content-Type: application/json");
		if($status_code!=200){
			echo  json_encode($data);
		}else{
			echo json_encode($data);
		}
		die();
	}
	private function _build_http_header_string($status_code){
		$status = array(
		200 => 'OK',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		500 => 'Internal Server Error'
		);
		return "HTTP/1.1 " . $status_code . " " . $status[$status_code];
	}
}
class api extends restful_api {
	function __construct(){
		parent::__construct();
	}

	function updateVNPOSTHook(){ 
		global $module_name,$db,$db_config;
		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		$headers = apache_request_headers();
		$input['module']='retails';
		$data=json_decode($input['Data'],true);
		$status_id=$data['OrderStatusId'];
		$ItemCode=$data['ItemCode'];
		$order_id=$db->query('SELECT id FROM '.TABLE.'_order where shipping_code="'.$ItemCode.'"')->fetchColumn();
		if($status_id==100){
			$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchAll();
			foreach($list_product as $value){
				$percent_discount=$db->query('SELECT t2.percent_discount FROM '.TABLE.'_product t1 INNER JOIN '.TABLE.'_categories t2 ON t1.categories_id=t2.id where t1.id='.$value['product_id'])->fetchColumn();
				$discount=$value['total']*$percent_discount/100;
				
				$db->query('UPDATE '.TABLE.'_order_item SET discount='.$discount.' where id='.$value['id']);
			} 
			$db->query('UPDATE '.TABLE.'_order SET status=3 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái đã giao';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}else if($status_id==170){
			$db->query('UPDATE '.TABLE.'_order SET status=4 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái thất bại';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}		
		$this->response(200, array(
			"response"=>200,
			"mess"=>'Cập nhật thành công'
		));

	}
	function updateGHNHook(){ 
		global $module_name,$db,$db_config;
		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		$headers = apache_request_headers();
		$input['module']='retails';
		$status_id=$input['Status'];
		$ItemCode=$input['OrderCode'];
		$order_id=$db->query('SELECT id FROM '.TABLE.'_order where shipping_code="'.$ItemCode.'"')->fetchColumn();
		if($status_id=='delivered'){
			$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchAll();
			foreach($list_product as $value){
				$percent_discount=$db->query('SELECT t2.percent_discount FROM '.TABLE.'_product t1 INNER JOIN '.TABLE.'_categories t2 ON t1.categories_id=t2.id where t1.id='.$value['product_id'])->fetchColumn();
				$discount=$value['total']*$percent_discount/100;
				
				$db->query('UPDATE '.TABLE.'_order_item SET discount='.$discount.' where id='.$value['id']);
			} 
			$db->query('UPDATE '.TABLE.'_order SET status=3 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái đã giao';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}else if($status_id=='returned'){
			$db->query('UPDATE '.TABLE.'_order SET status=4 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái thất bại';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}		
		$this->response(200, array(
			"response"=>200,
			"mess"=>'Cập nhật thành công'
		));

	}
	function updateVIETTELHook(){ 
		global $module_name,$db,$db_config;
		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		$headers = apache_request_headers();
		$input['module']='retails';
		$data=$input['DATA'];
		$status_id=$data['ORDER_STATUS'];
		$ItemCode=$data['ORDER_NUMBER'];
		$order_id=$db->query('SELECT id FROM '.TABLE.'_order where shipping_code="'.$ItemCode.'"')->fetchColumn();
		if($status_id==501){
			$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchAll();
			foreach($list_product as $value){
				$percent_discount=$db->query('SELECT t2.percent_discount FROM '.TABLE.'_product t1 INNER JOIN '.TABLE.'_categories t2 ON t1.categories_id=t2.id where t1.id='.$value['product_id'])->fetchColumn();
				$discount=$value['total']*$percent_discount/100;
				
				$db->query('UPDATE '.TABLE.'_order_item SET discount='.$discount.' where id='.$value['id']);
			} 
			$db->query('UPDATE '.TABLE.'_order SET status=3 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái đã giao';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}else if($status_id==504){
			$db->query('UPDATE '.TABLE.'_order SET status=4 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái thất bại';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}		
		$this->response(200, array(
			"response"=>200,
			"mess"=>'Cập nhật thành công'
		));

	}
	function updateGHTKHook(){ 
		global $module_name,$db,$db_config;
		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		$headers = apache_request_headers();
		$input['module']='retails';
		$status_id=$input['status_id'];
		$ItemCode=$input['label_id'];
		$order_id=$db->query('SELECT id FROM '.TABLE.'_order where shipping_code="'.$ItemCode.'"')->fetchColumn();
		if($status_id==6){
			$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchAll();
			foreach($list_product as $value){
				$percent_discount=$db->query('SELECT t2.percent_discount FROM '.TABLE.'_product t1 INNER JOIN '.TABLE.'_categories t2 ON t1.categories_id=t2.id where t1.id='.$value['product_id'])->fetchColumn();
				$discount=$value['total']*$percent_discount/100;
				
				$db->query('UPDATE '.TABLE.'_order_item SET discount='.$discount.' where id='.$value['id']);
			} 
			$db->query('UPDATE '.TABLE.'_order SET status=3 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái đã giao';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}else if($status_id==9){
			$db->query('UPDATE '.TABLE.'_order SET status=4 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái thất bại';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}		
		$this->response(200, array(
			"response"=>200,
			"mess"=>'Cập nhật thành công'
		));
	}
	function updateAHAMOVEHook(){ 
		global $module_name,$db,$db_config;
		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		$headers = apache_request_headers();
		$input['module']='retails';
		$status_id=$input['status'];
		$ItemCode=$input['_id'];
		$order_id=$db->query('SELECT id FROM '.TABLE.'_order where shipping_code="'.$ItemCode.'"')->fetchColumn();
		if($status_id=='COMPLETED'){
			$list_product=$db->query('SELECT * FROM '.TABLE.'_order_item where order_id='.$order_id)->fetchAll();
			foreach($list_product as $value){
				$percent_discount=$db->query('SELECT t2.percent_discount FROM '.TABLE.'_product t1 INNER JOIN '.TABLE.'_categories t2 ON t1.categories_id=t2.id where t1.id='.$value['product_id'])->fetchColumn();
				$discount=$value['total']*$percent_discount/100;
				
				$db->query('UPDATE '.TABLE.'_order_item SET discount='.$discount.' where id='.$value['id']);
			} 
			$db->query('UPDATE '.TABLE.'_order SET status=3 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái đã giao';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}else if($status_id == 'FAILED'||$status_id == 'CANCELLED'){
			$db->query('UPDATE '.TABLE.'_order SET status=4 where shipping_code="'.$ItemCode.'"');
			$content='Đơn hàng chuyển sang trạng thái thất bại';
			$db->query('INSERT INTO '.TABLE.'_logs_order(order_id,status_id_old,content,time_add,user_add) VALUES('.$order_id.',2,"'.$content.'",'.NV_CURRENTTIME.',-2)');
		}		
		$this->response(200, array(
			"response"=>200,
			"mess"=>'Cập nhật thành công'
		));
	}
}

$user_api = new api();