<?php

/*
 * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
 * Các bước thực hiện:
 * Kiểm tra checksum 
 * Tìm giao dịch trong database
 * Kiểm tra tình trạng của giao dịch trước khi cập nhật
 * Cập nhật kết quả vào Database
 * Trả kết quả ghi nhận lại cho VNPAY
 */


$inputData = array();
$returnData = array();
$data = $_REQUEST;
foreach ($data as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

$vnp_SecureHash = $inputData['vnp_SecureHash'];
unset($inputData['vnp_SecureHashType']);
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . '&' . $key . "=" . $value;
    } else {
        $hashData = $hashData . $key . "=" . $value;
        $i = 1;
    }
}
$vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
$vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
$vnp_HashSecret = $config_setting['checksum_vnpay'];
$secureHash = hash('sha256',$vnp_HashSecret . $hashData);

$order_text = $inputData['vnp_TxnRef'];


if(!$order_text)
{
	$returnData['RspCode'] = '01';
    $returnData['Message'] = 'Order not found';
	echo json_encode($returnData);die;
}


// tính tổng tiền thanh toán
$tongtien_thanhtoan = $db->query('SELECT sum(total) FROM ' . TABLE . '_order WHERE id IN('. $order_text .')')->fetchColumn(); 


$check_orderid = $db->query('SELECT id FROM ' . TABLE . '_order WHERE id IN('. $order_text .')')->fetchColumn(); 

$check_thanhtoan = $db->query('SELECT id FROM ' . TABLE . '_order WHERE status_payment_vnpay = 0 AND id IN('. $order_text .')')->fetchColumn(); 

$vnp_Amount = $inputData['vnp_Amount'];
$vnp_Amount = (int)$vnp_Amount / 100;

$reponse_vnpay = false;

try {
    // checksum
    if ($secureHash == $vnp_SecureHash) {
		// check OrderId
        if ($check_orderid) {
            // check amount
			if($tongtien_thanhtoan && $tongtien_thanhtoan == $vnp_Amount ){
				if ($check_thanhtoan) {
                // check Status
						
                        if ($inputData['vnp_ResponseCode'] == '00') {
							
							if(xulythanhtoanthanhcong($order_text, $inputData))
							{
								$reponse_vnpay = true;
								$returnData['RspCode'] = '00';
								$returnData['Message'] = 'Confirm Success';
							}
							else
							{
								$returnData['RspCode'] = '99';
								$returnData['Message'] = 'Unknow error';
							}
                        }
						elseif ($inputData['vnp_ResponseCode'] == '02')
						{
							$returnData['RspCode'] = '02';
							$returnData['Message'] = 'Order already confirmed';
						}
						elseif ($inputData['vnp_ResponseCode'] == '04')
						{
							$returnData['RspCode'] = '04';
							$returnData['Message'] = 'Invalid amount';
						}
						elseif ($inputData['vnp_ResponseCode'] == '01')
						{
							$returnData['RspCode'] = '01';
							$returnData['Message'] = 'Order not found';
						}
						elseif ($inputData['vnp_ResponseCode'] == '97')
						{
							$returnData['RspCode'] = '97';
							$returnData['Message'] = 'Invalid signature';
						}
						elseif ($inputData['vnp_ResponseCode'] == '99')
						{
							$returnData['RspCode'] = '99';
							$returnData['Message'] = 'Unknow error';
						}
						elseif ($inputData['vnp_ResponseCode'] == '24')
						{
							$returnData['RspCode'] = '24';
							$returnData['Message'] = 'Cancel';
						}
						elseif ($inputData['vnp_ResponseCode'] == '06')
						{
							$returnData['RspCode'] = '06';
							$returnData['Message'] = 'Unsuccessful';
						}
                    
                } else {
						$returnData['RspCode'] = '02';
						$returnData['Message'] = 'Order already confirmed';
                }
            }
            else
            {	
				$returnData['RspCode'] = '04';
				$returnData['Message'] = 'Invalid Amount';
				
            }
        } else {
            $returnData['RspCode'] = '01';
            $returnData['Message'] = 'Order not found';
        }
    } else {
        $returnData['RspCode'] = '97';
        $returnData['Message'] = 'Invalid signature';
    }
} catch (Exception $e) {
    $returnData['RspCode'] = '99';
    $returnData['Message'] = 'Unknow error';
}
//Trả lại VNPAY theo định dạng JSON

payment($order_text,$inputData,$returnData);

// xử lý thêm

$vnp_ReturnUrl = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=payment';

foreach ($data as $key => $value) {
	if($key == 'language' or $key == 'nv' or $key == 'op')
	{
		continue;
	}
	$vnp_ReturnUrl .= '&'. $key .'=' . $value;
}

//nv_redirect_location($vnp_ReturnUrl);
// kết thúc
 
if($reponse_vnpay)
{
	$returnData['RspCode'] = '00';
	$returnData['Message'] = 'Confirm Success';
}else{
	send_mail_payment_fail($order_text);
}

echo json_encode($returnData);
