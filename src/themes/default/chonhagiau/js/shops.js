//login
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

$('#category').owlCarousel({
    loop: true,
    autoplay: true,
    nav: false,
    dots: false,
	slideBy:5,
    responsive: {
        0: {
            items: 10
		}
	}
});
//danh muc
$('#banner-home').owlCarousel({
    loop: true,
    autoplay: true,
    nav: true,
    dots: true,
    responsive: {
        0: {
            items: 1
		}
	},
    navText: ['<i class="fa fa-chevron-left home_banner_left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right home_banner_right" aria-hidden="true"></i>']
});
// slider productHot 
var swiper = new Swiper('.swiper-container', {
    slidesPerView: 2,
    slidesPerColumn: 2,
    spaceBetween: 0,
    autoplay: {
        delay: 5000,
	},
	
});
// procuctCategory

$('#category_slider').owlCarousel({
    loop: true,
    dots: true,
    autoplay: true,
	nav:true,
    responsive: {
        0: {
            items: 1
		},
	}
});
$('#categoryChill').owlCarousel({
    margin: 20,
    loop: false,
    nav: true,
    dots: false,
    autoWidth: true,
    items: 7
});
$('#voucher_shop').owlCarousel({
    margin: 15,
    loop: false,
    nav: true,
    dots: false,
	stagePadding: 25,
	slideBy:3,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:3,
            nav:true,
            loop:false
        }
    }
});
$('#brand').owlCarousel({
    loop: false,
    margin: 10,
    nav: true,
    dots: false,
	slideBy:3,
    autoplayHoverPause: true,
    responsive:{
        700:{
            items:5
		},
        1024:{
            items:6
		},
        1100:{
            items:7
		}
	}
});
//Shop Hot
$("#list_shop_hot").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    dots: false,
	slideBy:4,
    autoplayHoverPause: true,
    responsive:{
        700:{
            items:5
		},
        1024:{
            items:6
		},
        1100:{
            items:8
		}
	}
});

// categogyChill 
$('#categoryChill .item').click(function() {
    $('#categoryChill').find('.secondary_text').removeClass('secondary_text');
    $(this).addClass('secondary_text');
});
// brand
$('#brand .item a').click(function() {
    $('#brand').find('.brand_active').removeClass('brand_active')
    $(this).addClass('brand_active');
});
// filter 
$('.categoryFilter .btn_ecng_outline').click(function() {
    $('.categoryFilter').find('.btn_ecng').removeClass('btn_ecng btn_ecng_outline').addClass('btn_ecng_outline');
    $(this).addClass('btn_ecng ');
});
// panigation
$('.paginationNumber ').click(function() {
    $('.pagination').find('.pagination_active').removeClass('pagination_active')
    $(this).addClass('pagination_active');
});

// productDetai_select 
$('.productDetail_classify_select label').click(function() {
    $(this).parent().find('.classify_active').removeClass('classify_active');
    $(this).addClass('classify_active');
});


// productDetai 
$('#productDetail').owlCarousel({
    loop: false,
    margin: 5,
    nav: true,
    dots: false,
	autoplayHoverPause:true,
	
    //mouseDrag: false,
    //pullDrag: false,
    touchDrag: false,
    responsive:{
        700:{
            items:4
		},
        1024:{
            items:4
		},
        1100:{
            items:5
		}
	},
    navText: ['<i class="fa fa-chevron-left productDetail_left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right productDetail_right" aria-hidden="true"></i>']
});
$('#productDetail_canLike,#productDetail_other').owlCarousel({
    loop: false,
    margin: 10,
    nav: false,
    dots: false,
    responsive: {
        0: {
            items: 6
		},
	}
});

// payment 
$('#change_address').click(function() {
    $('.payment_address').addClass('d-none');
    $('.payment_addressChange').removeClass('d-none')
});
$('#save_address').click(function() {
    $('.payment_address').removeClass('d-none');
    $('.payment_addressChange').addClass('d-none')
});


// error form 
$("#add_address").validate({
    rules: {
        name: {
            required: true,
            minlength: 4,
		},
		
        phone: {
            required: true,
            sdt: true,
		},
        address_short: {
            required: true,
            minlength: 4,
		},
	},
    messages: {
        name: {
            required: "Vui lòng nhập tên",
            minlength: "Vui lòng nhập ít nhất 4 ký tự ",
		},
		
        phone: {
            required: "Chưa nhập số điện thoại",
            // sdt: true,
		},
        address_short: {
            required: "Vui lòng nhập địa chỉ",
            minlength: "Vui lòng nhập ít nhất 4 ký tự ",
		},
		
	}
});
$.validator.addMethod("sdt", function(value, element) {
    return this.optional(element) || /(0+([1-9]+[0-9]{8})\b)/i.test(value);
}, "Số điện thoại không đúng định dạng");



// dashboard_user history header  
$('.history_header a').click(function() {
    $('.history_header').find('.btn_ecng').removeClass('btn_ecng').addClass('btn_gray');
    $(this).addClass('btn_ecng').removeClass('btn_gray');
});


// rating 
$(document).ready(function() {
	
	
    $('#stars li').on('mouseover', function() {
        var onStar = parseInt($(this).data('value'), 10);
		
		
        $(this).parent().children('li.star').each(function(e) {
            if (e < onStar) {
                $(this).addClass('hover');
				} else {
                $(this).removeClass('hover');
			}
		});
		
		}).on('mouseout', function() {
        $(this).parent().children('li.star').each(function(e) {
            $(this).removeClass('hover');
		});
	});
    /*click */
    $('#stars li').on('click', function() {
        var onStar = parseInt($(this).data('value'), 10);
        var stars = $(this).parent().children('li.star');
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
		}
        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
		}
	});
});

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
		}
		
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
		}
		
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
