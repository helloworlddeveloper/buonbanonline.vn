<?php 
$mod = $nv_Request->get_string( 'mod', 'get,post', '' );
if($mod=='check_password_wallet'){
	$password_wallet = $nv_Request->get_string( 'password_wallet', 'get,post', '' );
	$password=$db->query('SELECT password FROM ' . MODULE_WALLET . '_money where userid='.$user_info['userid'])->fetchColumn();
	$password_wallet1 = $crypt->validate_password($password_wallet, $password);
	if($password_wallet1 == 1){
		$_SESSION['password_wallet'] = $password;
		print_r( json_encode( array( "status"=>"OK","mess"=>'Nhập mật khẩu thành công')));
	}else{
		print_r( json_encode( array( "status"=>"ERROR","mess"=>'Mật khẩu không trùng khớp')));
	}
}