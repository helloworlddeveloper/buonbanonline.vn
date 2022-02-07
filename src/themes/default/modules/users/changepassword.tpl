<!-- BEGIN: main -->
<div class="contact-result alert mb-0"></div>
<div class="item_change_password bg_white rounded" style="min-height: 355px">
                <div class="px-4 pt-4 fs_20">Thay đổi mật khẩu</div>
                <div class="d-flex justify-content-center">
                    <div class="w-75 px-3 pt-3 text-center">
                        <form method="post" id="change_password">
                            <div class="form-row mb-4">
                                <label for="" class="col-4 col-form-label d-flex justify-content-end pr-5 align-items-center">Mật Khẩu Hiện Tại</label>
                                <div class="col-8">
                                    <div class="input-group border rounded-lg p-1 input_ecng">
                                        <div class="input_error_noIcon">
                                            <input type="password" name="password_old" aria-describedby="button-addon4" class="form-control bg-none border-0 ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <label for="" class="col-4 col-form-label d-flex justify-content-end pr-5 align-items-center">Mật Khẩu Mới</label>
                                <div class="col-8">
                                    <div class="input-group border rounded-lg p-1 input_ecng">
                                        <div class="input_error_noIcon">
                                            <input type="password" name="password_new" id="password_new" aria-describedby="button-addon4" class="form-control bg-none border-0 ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <label for="" class="col-4 col-form-label d-flex justify-content-end pr-5 align-items-center">Xác Nhận Mật Khẩu</label>
                                <div class="col-8">
                                    <div class="input-group border rounded-lg p-1 input_ecng">
                                        <div class="input_error_noIcon">
                                            <input type="password" name="re_password_new" aria-describedby="button-addon4" class="form-control bg-none border-0 ">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn_ecng mb-4">Lưu</button>
                        </form>
                    </div>
                </div>

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
