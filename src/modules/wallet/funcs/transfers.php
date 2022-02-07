<?php

/**
 * @Project WALLET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2018 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Friday, March 9, 2018 6:24:54 AM
 */

if (!defined('NV_IS_MOD_WALLET')) {die('Stop!!!');}
 
		$page_title = $lang_module['titleSmsNap'];
		$payment= 'ATM'; 
        // Nạp qua các cổng thanh toán, cần yêu cầu đăng nhập thành viên
        //$row_payment = $global_array_payments[$payment];
		$currency_support=('VND');
        $row_payment['currency_support'] = explode(',', $currency_support);
        $payment_config = unserialize(nv_base64_decode('YToxOntzOjE1OiJjb21wbGV0ZW1lc3NhZ2UiO3M6MTQwOiJUaMO0bmcgdGluIGPhu6dhIGLhuqFuIMSRw6MgxJHGsOG7o2MgZ2hpIG5o4bqtbi4gQ2jDum5nIHTDtGkgc-G6vSBraeG7g20gdHJhIGdpYW8gZOG7i2NoIG7DoHkgdHJvbmcgdGjhu51pIGdpYW4gc-G7m20gbmjhuqV0LiBYaW4gY-G6o20gxqFuISI7fQ,,'));
        $payment_config['paymentname'] = 'Rút tiền';
		$row_payment['payment'] = 'ATM';
        $payment_config['domain'] = NV_MY_DOMAIN;
		$row_payment['allowedoptionalmoney']=1;
        $post = array();
		//print_r($row_payment['currency_support']);die;
		
        if (!defined('NV_IS_USER')) {
            $linkdirect = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=users&amp;" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_redirect_encrypt($client_info['selfurl']);
            $contents = nv_theme_alert($lang_module['no_account'], $lang_module['payment_login'], 'info', $linkdirect, $lang_module['payment_login_wait']);
            include NV_ROOTDIR . '/includes/header.php';
            echo nv_site_theme($contents);
            include NV_ROOTDIR . '/includes/footer.php';
        }

	$sql = "SELECT money_total,money_unit FROM " . MODULE_WALLET . "_money where userid=".$user_info['userid']."";
    $sth = $db->prepare($sql);
    $sth->execute();
    $money_total_info = $sth->fetch();



        /**
         * Xác định loại tiền mà cổng này hỗ trợ nạp
         * Nếu cổng này không cho nạp tùy ý thì chỉ lấy ra những loại tiền có cấu hình mốc nạp
         */
        $array_money_unit = [];
        foreach ($row_payment['currency_support'] as $currency) {
            if (isset($global_array_money_sys[$currency]) and (!empty($row_payment['allowedoptionalmoney']) or !empty($module_config[$module_name]['minimum_amount'][$currency]))) {
                $array_money_unit[$currency] = $currency;
            }
        }
        if (empty($array_money_unit)) {
            $redict_link = nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name, true);
            redict_link($lang_module['recharge_error_message'], $lang_module['recharge_error_message_back'], $redict_link);
        }

        
            $error = "";
            $checkss = $nv_Request->get_title('checkss', 'post', '');

            if ($checkss == md5($payment . $global_config['sitekey'] . session_id())) {
                $post['customer_name'] = $nv_Request->get_title('customer_name', 'post', '');
                $post['customer_email'] = $nv_Request->get_title('customer_email', 'post', '');
                $post['customer_phone'] = $nv_Request->get_title('customer_phone', 'post', '');
                $post['customer_address'] = $nv_Request->get_title('customer_address', 'post', '');
                $post['customer_info'] =$nv_Request->get_title('customer_info', 'post', '');
				$post['userid_receiver'] =$nv_Request->get_int('userid_receiver', 'post', '');


                $post['transaction_info'] = $nv_Request->get_title('transaction_info', 'post', '').' '.get_info_user($post['userid_receiver'])['username'].' - '.get_info_user($post['userid_receiver'])['first_name'].' - '.get_info_user($post['userid_receiver'])['email'];
                $post['check_term'] = $nv_Request->get_int('check_term', 'post, get', 0);

                if ($global_config['captcha_type'] == 2) {
                    $fcode = $nv_Request->get_title('g-recaptcha-response', 'post', '');
                } else {
                    $fcode = $nv_Request->get_title('capchar', 'post', '');
                }
				$post['minimum'] = $module_config[$module_name]['minimum'];
				$post['money_fees'] = $module_config[$module_name]['withdrawal_fees'];
                $post['money_amount'] = $nv_Request->get_title('money_amount', 'post', '');
                $post['money_other'] = $nv_Request->get_title('money_other', 'post', '');

                if (sizeof($array_money_unit) == 1) {
                    $post['money_unit'] = current($array_money_unit);
                } else {
                    $post['money_unit'] = $nv_Request->get_title('money_unit', 'post', '');
                    if (!isset($array_money_unit[$post['money_unit']])) {
                        $post['money_unit'] = '';
                    }
                }

                $money_amount = floatval(str_replace(array(" ", ","), "", $post['money_amount']));
                if ($post['money_unit'] == 'VND') {
                    $money_amount = intval($money_amount);
                }
                $money_other = floatval(str_replace(array(" ", ","), "", $post['money_other']));
                if ($post['money_unit'] == 'VND') {
                    $money_other = intval($money_other);
                }
                $post['money_amount'] = $money_amount;
                $post['money_other'] = $money_other;

                $money = empty($post['money_amount']) ? $post['money_other'] : $post['money_amount'];

                $check_valid_email = nv_check_valid_email($post['customer_email']);

                if (empty($post['customer_name'])) {
                    $post['customer_name'] = $user_info['username'];
                }

                // Kiểm tra mức tiền nhỏ nhất
                $minimum_amount = !empty($module_config[$module_name]['minimum_amount'][$post['money_unit']]) ? explode(',', $module_config[$module_name]['minimum_amount'][$post['money_unit']]) : array();
                $minimum_amount = empty($minimum_amount) ? 0 : $minimum_amount[0];

               
                if (!empty($post['customer_email']) and !empty($check_valid_email)) {
                    $error = $check_valid_email;
                } 
				elseif (empty($post['money_unit'])) {
                    $error = $lang_module['payclass_error_money_unit'];
                }  
				elseif (empty($post['userid_receiver'])) {
                    $error = $lang_module['payclass_error_acount_bank'];
                } 
				elseif ($money_total_info['money_total'] - $money < $post['minimum']) {
                        $error = sprintf($lang_module['error_money_withdrawal2'], number_format($money_total_info['money_total']-$post['minimum']) . ' ' . $post['money_unit']);
                   
                } 
				elseif ($money <= 0 or ($minimum_amount > 0 and $money < $minimum_amount)) {
                    if ($minimum_amount > 0) {
                        $error = sprintf($lang_module['error_money_withdrawal1'], get_display_money($minimum_amount) . ' ' . $post['money_unit']);
                    } else {
                        $error = $lang_module['error_money_withdrawal'];
                    }
                }
				elseif ($post['check_term'] != 1 and !empty($row_payment['term'])) {
                    $error = $lang_module['error_check_term'];
                } elseif (!nv_capcha_txt($fcode)) {
                    $error = ($global_config['captcha_type'] == 2 ? $lang_global['securitycodeincorrect1'] : $lang_global['securitycodeincorrect']);
                } else {
                    $money = get_db_money($money, $post['money_unit']);
                    $post['customer_id'] = $post['userid'] = $user_info['userid'];
                    $post['money_total'] = $money; // Số tiền sẽ trừ vào tài khoản thành viên
                    $post['money_net'] = $money; // Số tiền thành viên thực hiện nạp
  
                    $post['money_revenue'] = $money; // Lợi nhuận thu được
					
                    /**
                     * Phí giao dịch
                     */
               
                    $post['money_revenue'] = get_db_money($post['money_net'] - $post['money_fees'], $post['money_unit']);
					
					
					
                    if (isset($module_config[$module_name]['recharge_rate'][$post['money_unit']])) {
                        $post['money_total'] = $post['money_total'] * $module_config[$module_name]['recharge_rate'][$post['money_unit']]['r'] / $module_config[$module_name]['recharge_rate'][$post['money_unit']]['s'];
                        $post['money_total'] = get_db_money($post['money_total'], $post['money_unit']);
                    }

                    // Tạo ngẫu nhiên một khóa xem như là Private key để tính checksum
                    $post['tokenkey'] = md5($global_config['sitekey'] . $post['userid'] . NV_CURRENTTIME . $post['customer_id'] . $post['money_net'] . $post['money_unit'] . $payment . nv_genpass());

                    // Thông tin giao dịch mặc định nếu khách không nhập
                    if (empty($post['transaction_info'])) {
                        $post['transaction_info'] = sprintf($lang_module['note_pay_gate'], $payment);
                    }

                  
                    // Lưu vào giao dịch (Giao dịch này là chưa thanh toán, sau này thanh toán nếu thành công hay thất bại sẽ cập nhật lại chỗ này)
                    $post['id'] = $db->insert_id("INSERT INTO " . MODULE_WALLET . "_transaction (
                        created_time, status, money_unit, money_total, money_net, money_fees, money_revenue, userid, userid_receiver, adminid, customer_id, customer_name,
                        customer_email, customer_phone, customer_address, customer_info, transaction_id, transaction_type, transaction_status, transaction_time,
                        transaction_info, transaction_data, payment, provider, tokenkey
                    ) VALUES (
                        " . NV_CURRENTTIME . ", 3, " . $db->quote($post['money_unit']) . ", " . $post['money_total'] . ", " . $post['money_net'] . ", " . $post['money_fees'] . ", 
                        " . $post['money_revenue'] . ", " . $post['userid'] . ", " . $post['userid_receiver'] . ", 0, " . $post['customer_id'] . ", " . $db->quote($post['customer_name']) . ",
                        " . $db->quote($post['customer_email']) . ", " . $db->quote($post['customer_phone']) . ", " . $db->quote($post['customer_address']) . ",
                        " . $db->quote($post['customer_info']) . ", '', -1, 0, 0, " . $db->quote($post['transaction_info']) . ", " . $db->quote($post['transaction_data']) . ",
                        " . $db->quote($payment) . ", '', " . $db->quote($post['tokenkey']) . "
                    )", 'id');

                    if (empty($post['id'])) {
                        $error = $lang_module['payclass_error_save_transaction'];
                    } else {
                        // Noi dung gui cho cong thanh toan
                        $post['transaction_code'] = vsprintf('GD%010s', $post['id']);
                        $post['transaction_info'] = sprintf($lang_module['transaction_info'], $post['transaction_code'], NV_SERVER_NAME);
                        $post['ReturnURL'] = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=complete&payment=" . $payment, true);

                        $url = '';
                        $error = '';
                        require_once NV_ROOTDIR . "/modules/" . $module_file . "/payment/" . $payment . ".checkout_url.php";

                        // Nếu có lỗi thì thông báo lỗi
                        if (!empty($error)) {
                            redict_link($error, $lang_module['cart_back'], NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name);
                        }

                        if (!empty($url)) {
                            Header("Location: " . $url);
                            die();
                        } else {
                            nv_redirect_location(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name);
                        }
                    }
                }
            } else {
                $post['customer_name'] = $user_info['full_name'];
                $post['customer_email'] = $user_info['email'];
				if(!empty($user_info['phone'])){
					$post['customer_phone'] = $user_info['phone'];
				}else{
					$post['customer_phone']='';
				}
                $post['money_fees'] = $module_config[$module_name]['withdrawal_fees'];  $post['minimum'] = $module_config[$module_name]['minimum'];
                $post['customer_address'] = '';
                $post['userid_receiver'] = 0;
                $post['money_amount'] = 0;
                $post['money_other'] = 0;
                $post['money_unit'] = '';
                $post['check_term'] = 0;
                $post['transaction_info'] = nv_substr($nv_Request->get_title('info', 'get', ''), 0, 250);

                /*
                 * Xử lý khi có số tiền nạp vào từ URL dạng ?amount=100000-VND
                 * Check xem cổng thanh toán nạp được loại tiền đó không
                 * Check xem có cấu hình giá trị nhỏ nhất nạp không
                 */
                $pay_amount = $nv_Request->get_title('amount', 'get', '');
                $pay_money = '';
                if (preg_match('/^([0-9\.]+)\-([A-Z]{3})$/', $pay_amount, $m)) {
                    if (!isset($global_array_money_sys[$m[2]])) {
                        $pay_amount = 0;
                    } else {
                        $pay_money = $m[2];
                        $pay_amount = $m[1];
                    }
                } else {
                    $pay_amount = 0;
                }
                if (!empty($pay_amount) and in_array($pay_money, $row_payment['currency_support'])) {
                    $post['money_unit'] = $pay_money;
                    $list_money = array_filter(explode(',', $module_config[$module_name]['minimum_amount'][$post['money_unit']]));
                    if (in_array($pay_amount, $list_money)) {
                        $post['money_amount'] = $pay_amount;
                    } elseif (empty($list_money) or min($list_money) <= $pay_amount) {
                        $post['money_other'] = $pay_amount;
                    }
                }

                if (empty($post['money_amount']) and empty($post['money_other'])) {
                    reset($array_money_unit);
                    $post['money_unit'] = current($array_money_unit);
                    if (!empty($module_config[$module_name]['minimum_amount'][$post['money_unit']])) {
                        $list_money = explode(',', $module_config[$module_name]['minimum_amount'][$post['money_unit']]);
                        $post['money_amount'] = number_format($money_total_info['money_total']- $post['minimum']);
						 $post['money_amount_min'] = number_format($list_money[0]);
                    }
                }

              
            }

            $post['checkss'] = md5($payment . $global_config['sitekey'] . session_id());
            $post['error'] = $error;

            if ($post['money_amount'] <= 0) {
                $post['money_amount'] = '';
            }
            if ($post['money_other'] <= 0) {
                $post['money_other'] = '';
            }
			$list_user=$db->query('SELECT * FROM '.NV_USERS_GLOBALTABLE.' WHERE active =1' )->fetchAll();

            $page_title = $module_info['site_title'];
            $key_words = $module_info['keywords'];
	
            $contents = nv_theme_wallet_transfers($row_payment, $post, $array_money_unit,$money_total_info,$list_user);
        
    

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
