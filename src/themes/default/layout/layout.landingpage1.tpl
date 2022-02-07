<!-- BEGIN: main -->
{FILE "header_only.tpl"}
{FILE "header_landing.tpl"}

<style>
	@import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700;900&display=swap');
</style>
<div class="landing_bg pb-3">
	<div class="container_landing">
		<section class="banner_top pb-3">
			[BANNER_LANDING_TOP]
		</section>
		
		<section class="pb-3">
			<div class="d-flex justify-content-between align-items-center pb-3">
				<h2 class="title_landing">Giá Shock Hôm Nay</h2>
				<span><a href="https://chonhagiau.com/block/product-shock/" class="landing_more">Xem thêm</a></span>
			</div>
			<div class="row product_slider_landing">
				[LANDING_PRICE_SHOCK]
			</div>
		</section>
		
		<section class="banner_center">
			<div class="row justify-content-between">
				[BANNER_LANDING_CENTER_1]
				[BANNER_LANDING_CENTER_2]
				[BANNER_LANDING_CENTER_3]
			</div>
			
		</section>
		
		<div class="sub_banner position-relative">
			[SUB_BANNER_LANDING]
			<h2 class="title_landing">Sản Phẩm Freeship</h2>
		</div>
		
		<section>
			<div class="row product_slider_landing">
				[LANDING_PRODUCT_FREESHIP]
			</div>
		</section>
		
		<section class="banner_bottom pt-3">
			<div class="row">
				[BANNER_LANDING_BOTTOM]
			</div>
		</section>
		
		<div class="sub_banner position-relative">
			[SUB_BANNER_LANDING]
			<h2 class="title_landing">Gợi Ý Hôm Nay</h2>
		</div>
		
		
		<section>
			<div class="row">
				[LANDING_PRODUCT_SUGGEST]
			</div>
		</section>
		
</div>
{FILE "footer_extended_landing.tpl"}
{FILE "footer_only.tpl"}
<!-- END: main -->