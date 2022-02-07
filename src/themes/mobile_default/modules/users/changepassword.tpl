<!-- BEGIN: main -->
<div class="item_change_password bg_white ">
<div class="contact-result mb-0 alert" style="display:none"></div>

<header class="bd_b_1 bg_white">
	<div class="resign text-center px-2">
		<p class="fs_18 mb-0 py-3">Thay đổi mật khẩu</p>
	</div>
</header>

	<div class=" p-3 text-center">
		<form method="post" id="change_password">						   
					<div class="input-group mb-4 p-1 input_ecng">
						<div class="input_error_noIcon">
							<input type="password" name="password_old" class="form-control form-control form-control-underlined" placeholder="Mật khẩu cũ">
						</div>
					</div>                                                                                                                                                      
					<div class="input-group mb-4 p-1 input_ecng">
						<div class="input_error_noIcon">
							<input type="password" name="password_new" id="password_new" class="form-control form-control-underlined " placeholder="Mật khẩu mới">
						</div>
					</div>
					
					<div class="input-group mb-4  p-1 input_ecng">
						<div class="input_error_noIcon">
							<input type="password" name="re_password_new" aria-describedby="button-addon4" class="form-control form-control-underlined " placeholder="Nhập lại mật khẩu mới">
						</div>
					</div>
																																				   <div class="text-center pb-2">
					 <button type="submit" class="btn_ecng w-100 fs_16 p-3">Lưu</button>
					 </div>               		   			
					 </div>               		   			
		</form>
</div>

<script>
	$("#change_password").validate({
    rules: {
        password_old: {
            required: true,
            minlength: 6,
        },

        password_new: {
            required: true,
            minlength: 6,

        },
        re_password_new: {
            equalTo: "#password_new"
        }

    },
    messages: {
        password_old: {
            required: "Chưa nhập mật khẩu cũ",
            minlength: "Mật khẩu phải ít nhất 6 ký tự ",
        },
        password_new: {
            required: "Vui lòng nhập mật khẩu",
            minlength: "Mật khẩu phải trên 6 ký tự",
        },
        re_password_new: {
            equalTo: "Nhập lại mật khẩu không chính xác"
        }
    },	
	submitHandler: function(){
		$.ajax({
				type : 'POST',
				url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=changepassword&mod=change_password',
				data: $('#change_password').serialize(),
				dataType: "json",
				beforeSend: function() { 
					thongbao_xuly('Hệ thống đang xử lý... Vui lòng đợi trong giây lát!');
					$('#change_password .btn_ecng').prop('disabled', true);
				},	
				complete: function() {

					$('#change_password .btn_ecng').prop('disabled', false);

				},
				success : function(res){
					console.log(res);
					if (res.status == "error")
					{
						$('#change_password').find("[name=\"" + res.input + "\"]").focus();
						thongbao(res.mess);
					}
					if(res.status == "ok")
					{
						thongbao('Bạn đã thay đổi mật khẩu thành công!');
						
					}
				}
			});	
	}
	
	
});

	function thongbao_xuly(message)
	{
		$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-info").show();
				setTimeout(function(){ 
				$('.contact-result').hide();
				}, 5000);
	}
	function thongbao(message)
	{
		$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-info").show();
				setTimeout(function(){ 
				$('.contact-result').hide();
				}, 5000);
	}


</script>
       
<!-- END: main -->
