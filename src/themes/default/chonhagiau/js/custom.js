//thông báo dialog

function notifi_screen(message) {
	$('#notifi_screen').show();
	$('.notifi_screen').html(message);
	$('#notifi_screen #modal_content').click(function() {
		$('#notifi_screen').hide();
	});
}
function thongbao_xuly(message) {
	$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-info").show();
	setTimeout(function() {
		$('.contact-result').hide();
	}, 300000);
}

function thongbao1(message) {
	$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-warning").show();
	setTimeout(function() {
		$('.contact-result').hide();
	}, 20000);
}
function notifi_error(message) {
	$('.notifi_error').html(message).addClass("text_red").show();	
}

// register
$(document).ready(function() {
    $('.modal_register').click(function() {
        $('#modal_login').modal()
        $('#modal_login').modal({
            keyboard: false
		})
        $('#modal_login').modal('show')
		
        // xóa active login
        $(".register_title a").tab('show');
	})
});

// Đăng nhập 
$(document).ready(function() {
    $('.modal_login').click(function() {
        $('#modal_login').modal();
        $('#modal_login').modal({
			keyboard: false
		}) // initialized with no keyboard
        $('#modal_login').modal('show')
		// xóa active login
        $(".login_title a").tab('show');
	})
});


// fogot pass 
$(document).ready(function() {
    $('.forgotpass').click(function() {
        $('#pass').modal()
        $('#forgotpass').modal({
            keyboard: false
		})
        $('#modal_login').modal('hide')
        $('#pass').modal('show')
	})
});


$(document).ready(function() {
    $("#login_form").validate({
        rules: {
            email: {
                required: true,
                email: true,
			},
            password: {
                required: true,
                minlength: 6,
			}
		},
        messages: {
            email: {
                required: "Vui lòng nhập email",
                email: "Email chưa đúng định dạng",
			},
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải trên 6 ký tự",
			}
		}
	});
	
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
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải trên 6 ký tự",
			},
            re_password: {
                equalTo: "Nhập lại mật khẩu không chính xác"
			}
		}
	});
    $.validator.addMethod("sdt", function(value, element) {
        return this.optional(element) || /(0+([1-9]+[0-9]{8})\b)/i.test(value);
	}, "Số điện thoại không đúng định dạng");
    $("#forgotPass_form").validate({
        rules: {
            email: {
                required: true,
                email: true,
			},
			
		},
        messages: {
            email: {
                required: "Vui lòng nhập email",
                email: "Email chưa đúng định dạng",
			},
			
		}
	});
});

$('#banner-home').owlCarousel({
    loop: true,
    autoplay: true,
    nav: false,
    dots: true,
    responsive: {
        0: {
            items: 1
		}
	},
    navText: ['<i class="fa fa-chevron-left home_banner_left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right home_banner_right" aria-hidden="true"></i>']
});
$('#price_shock').owlCarousel({
	loop: true,
    autoplay: true,
    nav: true,
    dots: false,
	margin:10,
	slideBy:6,
	responsive:{
		0:{
			items:1
		},
		600:{
			items:4
		},
		1000:{
			items:6
		}
	}
});
$('#product_freeship').owlCarousel({
	loop: true,
    autoplay: true,
    nav: true,
    dots: false,
	margin:10,
	slideBy:6,
	responsive:{
		0:{
			items:1
		},
		600:{
			items:4
		},
		1000:{
			items:6
		}
	}
});

$('#category').owlCarousel({
    loop: true,
    autoplay: true,
    nav: true,
    dots: false,
	slideBy:5,
    responsive:{
        700:{
            items:7
		},
        1024:{
            items:9
		},
        1100:{
            items:10
		}
	},
	navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>']
});
//danh muc

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

//detail.tpl (readmore)
$(document).ready(function(){
	var h_des =$('div#description').height();
	var h_spec =$('div#specifications').height();
	var show_opa_des = true;
	var show_opa_spec = true;
	//description
	if(h_des > 782){
		$('div#description').addClass('have_readmore');
		$('div#description').css({
			'padding-bottom' : "4rem",
			'padding-top' : "1rem"
		})
	}
	else{
		$('div#description').css({
			'padding-bottom' : "1rem",
			'padding-top' : "1rem"
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
			'padding-bottom' : "4rem",
			'padding-top' : "1rem"
		})
	}
	else{
		$('div#specifications').css({
			'padding-bottom' : "1rem",
			'padding-top' : "1rem"
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
		
	})
	
});

// menu da cap
$('#menu').click(function() {
	$('#menu #ul_cap1').toggleClass('d-block');
});
$("body").on("click", function (e) {
	$('#menu #ul_cap1').removeClass("d-block");
});
$('#menu').on("click", function (e) {
	e.stopPropagation();
});
$('#li_cap1 #li_cap1').click(function() {
	$('#ul_cap2').toggleClass('d-block');
});
$('#li_cap2').click(function() {
	$('#ul_cap3').toggleClass('d-block');
});

//modal order.tpl
$('.modal_null .close_md').click(function () {
    $('.modal_null').hide();
});

$(window).on('click', function (e) {
    if ($(e.target).is('.modal')) {
		$('.modal_null').hide();
	}
});







