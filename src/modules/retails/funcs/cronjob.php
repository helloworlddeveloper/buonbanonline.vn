<?php	
$mod = $nv_Request->get_string( 'mod', 'get,post', '' );
	
//cập nhật tự động xác nhận đơn hàng đã nhận trong vòng 24h nếu khách không bấm đã nhận đơn (nếu đơn không có khiếu nại)
if($mod=='update_order_received_t7XoHCIC2Wqpuh@'){

	$db->query('UPDATE ' . TABLE . '_order t1 SET t1.status = 7 WHERE t1.status = 3 AND NOT EXISTS (SELECT t2.order_id FROM ' . TABLE . '_order_not_received t2 WHERE t1.id = t2.order_id AND t2.status = 0)');
	print_r(ok);die;
}