<!-- BEGIN: main -->
{FILE "header_only.tpl"} 
{FILE "header_extended.tpl"}

<style>
	@import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700;900&display=swap');
</style>

<div class="landing_bg">
	
	<section class="banner_top px-2">
		[BANNER_LANDING_TOP]
	</section>
	
	<section class="px-2">
		<div class="d-flex justify-content-between">
			<h2 class="title_landing">Giá Shock Hôm Nay</h2>
			<span><a href="https://chonhagiau.com/block/product-shock/" class="landing_more">Xem thêm</a></span>
		</div>
		<div class="row product_slider_landing">
			[LANDING_PRICE_SHOCK]
		</div>
	</section>
	
	<section class="banner_center pb-2 px-2">
		<div class="d-flex justify-content-between">
			[BANNER_LANDING_CENTER_1]
			[BANNER_LANDING_CENTER_2]
			[BANNER_LANDING_CENTER_3]
		</div>
		
	</section>
	
	<div class="sub_banner position-relative px-2">
		[SUB_BANNER_LANDING]
		<h2 class="title_landing">Sản Phẩm Freeship</h2>
	</div>
	
	<section>
		<div class="row product_slider_landing px-2">
			[LANDING_PRODUCT_FREESHIP]
		</div>
	</section>
	
	<section class="banner_bottom px-2">
		<div class="row">
			[BANNER_LANDING_BOTTOM]
		</div>
	</section>
	
	<div class="sub_banner pt-1 position-relative px-2">
		[SUB_BANNER_LANDING]
		<h2 class="title_landing">Gợi Ý Hôm Nay</h2>
	</div>
	
	
	<section>
		<div class="row p-1 pb-3">
			[LANDING_PRODUCT_SUGGEST]
		</div>
	</section>
	
</div>

{FILE "footer_extended.tpl"} 
{FILE "footer_only.tpl"}

<!-- END: main -->
