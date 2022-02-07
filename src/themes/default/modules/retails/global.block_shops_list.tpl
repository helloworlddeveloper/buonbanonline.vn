<!-- BEGIN: main -->
<div class="bg_white my-4 pb-3 px-3" id="home_block_shop_list">
	<div class="tms_defaul_title">
			<h4 class="secondary_text py-3">
				Gian hàng nổi bật
			</h4>
	</div>

	<div class="owl-carousel owl-theme" id="list_shop_hot">
		<!-- BEGIN: loop -->
		<div  class="item p-2">
			<a href="{DATA.link}">
				<div  class="home_block_shop_list rounded d-flex align-items-center">
					<img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/no_image.svg"
					data-src="{DATA.avatar_image}" class="max_w_h lazy" src="{DATA.avatar_image}">
					
				</div>	
				<div class="home_block_shop_text">
					<p class="d-block text-center fw_500 m-0">{DATA.company_name}</p>
				</div>
			</a>
		</div>
		<!-- END: loop -->
	</div>

</div>


<script>
	$(document).ready(function(){
		var max = 0;
		var item = $('#list_shop_hot .owl-item .item');
		<!-- $('#list_shop_hot .owl-item .item a') -->
		item.each(function() {
			var current_var = $(this);
			console.log(current_var.height());
			if (current_var.height() > max) {
				max = current_var.height();
			}
		});
		item.height(max);
	});
	
	
	<!-- $('#list_shop_hot .owl-item .item').css({ -->
		<!-- 'min-height' : max, -->
	<!-- }) -->
	
	
	
	$('#list_shop_hot').owlCarousel({
    loop:false,
    margin:10,
	dots: false,
	<!-- nav: true, -->
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:8
        }
    }
})
</script>
<!-- END: main -->