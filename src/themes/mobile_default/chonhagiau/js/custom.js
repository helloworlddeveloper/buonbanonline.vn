
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
// thông báo đỏ
function notifi_error(message) {
	$('.notifi_error').html(message).addClass("text_red").show();
}
//thông báo dialog
function notifi_screen(message) {
	$('.notifi_screen').html(message);
	$('#notifi_screen').modal('show');
	$('#notifi_screen #modal_content').click(function() {
		$('#notifi_screen').modal('hide');
	});
}

function thongbao1(message) {
	$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-warning").show();
	setTimeout(function() {
		$('.contact-result').hide();
	}, 20000);
}
//

$('#price_shock').owlCarousel({
	loop: false,
    autoplay: false,
    nav: true,
    dots: false,
	margin:6,
	items: 3,
	slideBy:3,
});
$('#product_freeship').owlCarousel({
	loop: true,
    autoplay: true,
    nav: true,
    dots: false,
	margin:6,
	items: 3,
	slideBy:3,
});


$('#category').owlCarousel({
	loop: true,
	margin: 8,
	nav: false,
	dots: false,
	autoplay:true,
	autoplayHoverPause:true,
	slideBy:5,
	responsive: {
		0: {
			items: 5
		},
		600: {
			items: 5
		},
		1000: {
			items: 7
		}
	}
});
// danh mục sản phẩm 
$('#banner_top').owlCarousel({
	loop: true,
	margin: 0,
	nav: false,
	dots: true,
	autoplay:true,
	autoplayTimeout:3000,
	items: 1,
});
$('#slider_mobile_ads1').owlCarousel({
	loop: true,
	margin: 5,
	nav: false,
	dots: true,
	autoplay:true,
	autoplayTimeout:4000,
	items: 3,
});
$('#productDetail_img').owlCarousel({
	loop: false,
	margin: 0,
	nav: false,
	dots: true,
	items: 1,
});
// banner home & danh mục
$('#product_hot').owlCarousel({
	loop: false,
	margin: 5,
	nav: false,
	dots: false,
	responsive: {
		0: {
			items: 3
		},
		600: {
			items: 4
		},
		800: {
			items: 5
		}
	}
});
/*
	$('#history_order').owlCarousel({
	loop:false,
	margin:5,
	nav:false,
	dots:false,
	autoWidth:true,
	})
*/


$('#categoryChill').owlCarousel({
	margin: 10,
	loop: false,
	nav: true,
	dots: false,
	autoWidth: true,
	responsive: {
		0: {
			items: 5
		},
		600: {
			items: 6
		},
		1000: {
			items: 7
		}
	}
})
$('#brand').owlCarousel({
	loop: false,
	margin: 10,
	nav: true,
	slideBy:2,
	dots: false,
	autoplayHoverPause: true,
	responsive: {
		0: {
			items: 4
		},
		600: {
			items: 4
		},
		1000: {
			items: 7
		}
	}
});
$('#voucher_shop').owlCarousel({
    margin: 2,
    loop: false,
    nav: true,
    dots: false,
	stagePadding: 20,
	slideBy:3,
    items: 1
});

// brand
$('#brand .item a').click(function() {
	$('#brand').find('.brand_active').removeClass('brand_active')
	$(this).addClass('brand_active');
	
});

$('.dropdown-item').click(function() {
	var html = $(this).html();
	console.log(html);
	$('#categoryFilter_star').html(html);
});

//footer
$('footer li').click(function() {
	$('footer').find('.secondary_text').removeClass('secondary_text');
	$(this).addClass('secondary_text');
});


function thongbao_xuly(message) {
	
	$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-info").show();
	setTimeout(function() {
		$('.contact-result').hide();
	}, 300000);
}

function thongbao(message) {
	
	$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-info").show();
	setTimeout(function() {
		$('.contact-result').hide();
	}, 3000);
}


// Form 
$("#login").validate({
	rules: {
		email: {
			required: true,
			
		},
		password: {
			required: true,
		},
		
	},
	messages: {
		email: {
			required: "Vui lòng nhập tên đăng nhập",
		},
		
		password: {
			required: "Vui lòng nhập mật khẩu",
		}
	},
	submitHandler: function() {
		login_validForm_user()
	}
	
});


function login_validForm_user() {
	console.log($('#login').serialize());
	$.ajax({
		type: 'POST',
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=login',
		data: $('#login').serialize(),
		dataType: "json",
		success: function(res) {
			console.log(res);
			if (res.status == "error") {
				$('#login').find("[name=\"" + res.input + "\"]").focus();
				
				notifi_error(res.mess);
				
				
			}
			
			
			if (res.status == "ok") {
				thongbao('Đăng nhập thành công!');
				if(res.back_link != '')
				{
					window.location.href = res.back_link;
				}
				else
				{
					window.location.href = nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=personal';
				}
			}
			
			
		}
		
	});
	
}

$("#register_form").validate({
	rules: {
		name: {
			required: true,
			minlength: 4,
		},
		email: {
			required: true,
			email: true,
		},
		phone: {
			required: true,
			sdt: true,
		},
		password: {
			required: true,
			minlength: 6,
			
		},
		re_password: {
			equalTo: "#register_password"
		}
		
	},
	messages: {
		name: {
			required: "Vui lòng nhập tên",
		},
		email: {
			required: "Vui lòng nhập email",
			email: "Email chưa đúng định dạng",
		},
		phone: {
			required: "Vui lòng nhập số điện thoại",
		},
		password: {
			required: "Vui lòng nhập mật khẩu",
			minlength: "Mật khẩu phải trên 6 ký tự",
		},
		re_password: {
			equalTo: "Nhập lại mật khẩu không chính xác"
		}
	},
	submitHandler: function() {
		submit_form_register(this)
	}
});
$.validator.addMethod("sdt", function(value, element) {
	return this.optional(element) || /(0+([1-9]+[0-9]{8})\b)/i.test(value);
}, "Số điện thoại không đúng định dạng");



function submit_form_register() {
	$.ajax({
		type: 'POST',
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=register',
		data: $('#register_form').serialize(),
		dataType: "json",
		beforeSend: function() {
			thongbao_xuly('Hệ thống đang xử lý... Vui lòng đợi trong giây lát!');
			$('#register_form .btn_ecng').prop('disabled', true);
		},
		complete: function() {
			
			$('#register_form .btn_ecng').prop('disabled', false);
			
		},
		success: function(res) {
			console.log(res);
			if (res.status == "error") {
				$('#register_form').find("[name=\"" + res.input + "\"]").focus();
				
				thongbao(res.mess);
				
				
			}
			if (res.status == "ok") {
				thongbao('Bạn đã đăng ký tài khoản thành công!');
				window.location.href = nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=personal';
			}
			
		}
		
	});
}

//Contact

$(document).ready(function(){
	$('#contact_validate').validate({
		rules: {
            femail: {
                required: true,
                email: true,
			},
            fcon: "required",
            faddress: "required",
            fphone: "required",
            fname: "required",
            ftitle: "required",
            fcat: "required",
		},
        messages: {
            femail: {
                required: "Vui lòng nhập email",
                email: "Email chưa đúng định dạng",
			},
            fcon: {
                required: "Vui lòng nhập nội dung",
			},
            faddress: {
                required: "Vui lòng nhập địa chỉ",
			},
            fphone: {
                required: "Vui lòng nhập số điện thoại",
			},
            fname: {
                required: "Vui lòng nhập họ và tên",
			},
            ftitle: {
                required: "Vui lòng nhập tiêu đề",
			},
		},
	});
	// Kiểm tra định dạng email
    $.validator.addMethod("email", function(value) {
        return (regex =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
                value
			));
	});
	
	$("ul#topic_content li").click(function() {
		$("#topic div span").text($(this).text())
	});
	$('#send_contact').click(function(){
		if($("#topic div span").text() == 'Chủ đề bạn quan tâm' ){
			$('#topic_error').css({
				'display' : 'block',
			});
			return;
		}
		else{
			$('#topic_error').css({
				'display' : 'none',
			});
		}
	})	
})

// productDetai
$('.productDetail_classify_select label').click(function() {
    $(this).parent().find('.classify_active').removeClass('classify_active');
    $(this).addClass('classify_active');
});
function change_quantity(a)
{
	var quantity = parseInt($(a).val());
	var max = parseInt($(a).attr('max'));
	if(quantity <= 0)
	{
		$(a).val(1);
	}
	
	if(quantity > max)
	{
		$(a).val(max);
	}
}

// dashboard user 
$("#user_info").validate({
    rules: {
        last_name: {
            required: true,
            minlength: 4,
		},
        email: {
            required: true,
            email: true,
		},
        phone: {
            required: true,
            sdt: true,
		},
        date: {
            required: true,
			
		},
        month: {
            required: true,
			
		},
        year: {
            required: true,
			
		},
		
	},
    messages: {
        last_name: {
            required: "Vui lòng nhập tên",
            minlength: "Vui lòng nhập ít nhất 4 ký tự ",
		},
        email: {
            required: "Vui lòng nhập email",
            email: "Email chưa đúng định dạng",
		},
        phone: {
            required: "Chưa nhập số điện thoại",
            // sdt: true,
		},
        date: {
            required: "Vui lòng nhập ngày",
		},
        month: {
            required: "Vui lòng nhập tháng",
		},
        year: {
            required: "Vui lòng nhập năm",
		},
		
	},
	submitHandler: function(){
		$.ajax({
			type : 'POST',
			url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=changepassword&mod=change_user',
			data: $('#user_info').serialize(),
			dataType: "json",
			beforeSend: function() { 
				thongbao_xuly('Hệ thống đang xử lý... Vui lòng đợi trong giây lát!');
				$('#user_info .btn_ecng').prop('disabled', true);
			},	
			complete: function() {
				
				$('#user_info .btn_ecng').prop('disabled', false);
				
			},
			success : function(res){
				console.log(res);
				if (res.status == "error")
				{
					$('#user_info').find("[name=\"" + res.input + "\"]").focus();
					thongbao(res.mess);
				}
				if(res.status == "ok")
				{
					thongbao('Cập nhật thông tin thành công!');
				}
			}
		});	
	}
	
	
});
$.validator.addMethod("sdt", function(value, element) {
    return this.optional(element) || /(0+([1-9]+[0-9]{8})\b)/i.test(value);
}, "Số điện thoại không đúng định dạng");



$(document).ready(function(){
	var h_des =$('div#description').height();
	var h_spec =$('div#specifications').height();
	var show_opa_des = true;
	var show_opa_spec = true;
	//description
	if(h_des > 782){
		$('div#description').addClass('have_readmore');
		$('div#description').css({
			'padding-bottom' : "4rem"
		})
	}
	else{
		$('div#description').css({
			'padding-bottom' : "1rem"
		})
		$('.readmore_des').hide();
		$('div#description .opacity_readmore').hide();
	}
	$('#btn_readmore_des').click(function(){
		show_opa_des = !show_opa_des;
		$('div#description').toggleClass('have_readmore');
		if(show_opa_des == true){
			$('div#description .opacity_readmore').show();
			$(this).text("Xem thêm");
		}
		else{
			$('div#description').addClass('pb-5');
			$('div#description .opacity_readmore').hide();
			$(this).text("Thu gọn");
		}
		
	})
	
	//specifications
	if(h_spec > 782){
		$('div#specifications').addClass('have_readmore');
		$('div#specifications').css({
			'padding-bottom' : "4rem"
		})
	}
	else{
		$('div#specifications').css({
			'padding-bottom' : "1rem"
		});
		$('div#specifications .opacity_readmore').hide();
		$('.readmore_spec').hide();
	}
	$('#btn_readmore_spec').click(function(){
		show_opa_spec = !show_opa_spec;
		$('div#specifications').toggleClass('have_readmore');
		if(show_opa_spec == true){
			$('div#specifications .opacity_readmore').show();
			$(this).text("Xem thêm");
		}
		else{
			$('div#specifications .opacity_readmore').hide();
			$(this).text("Thu gọn");
		}
		
	});
	
	
	
});
/*menu da cap*/
$(window).resize(function() {
    var w_li_a = $('.li_cap2 a.icon_right').prev().width();
	var w_li_cap2 = $('.li_cap2').width();
	
	$('.li_cap2 .icon_right').width(w_li_cap2 - w_li_a -2 );
});
$(document).ready(function(){
	$('#menu').addClass('edited_scroll');
	$('.ul_cap2').addClass('edited_scroll');
	
	var w_li_a = $('.li_cap2 a.icon_right').prev().width();
	var w_li_cap2 = $('.li_cap2').width();
	
	$('.li_cap2 .icon_right').width(w_li_cap2 - w_li_a -2 );
})



$('.active_li_cap1 .ul_cap2').addClass('active_ul_cap2');
$('.li_cap1').click(function() {
	//li cap 1
	$('.ul_cap1 li').removeClass('active_li_cap1');
	$(this).addClass('active_li_cap1');
	// ul cap 2
	$('.li_cap1 .ul_cap2').removeClass('active_ul_cap2');
	$(this).find('.ul_cap2').addClass('active_ul_cap2');
	
});
$('.li_cap2 .icon_right').click(function() {
	
	//active ul_cap3 của li_cap2 vừa click
	$(this).next().toggleClass('active_ul_cap3');
	$(this).find('i').toggleClass('rotate_icon');
	
	var a = $('.li_cap2').find('ul.active_ul_cap3').length;
	if (a > 0) {
		
		$('.li_cap2 .icon_right i').removeClass('rotate_icon');
		$(this).find('i').addClass('rotate_icon');
		$('.li_cap2 .ul_cap3').removeClass('active_ul_cap3');
		$(this).next().addClass('active_ul_cap3');
		
	}
	
});
