<!-- BEGIN: main -->
<style>
	@import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700;900&display=swap');
</style>
<h2 class="title_landing px-2 m-0" style="color:#444444">Giá Shock Hôm Nay</h2>
<div class="row">
	<!-- BEGIN: product -->
	<div class="col-6 p-2 product_landingpage" id="product_suggest">
		<div class="item product_suggest">
		<a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}">
			<div class="card rounded shadow-sm border-0">
				<div class="card-body p-0">
					<img src="{NV_BASE_SITEURL}themes/default/chonhagiau/images/no_image.svg"
					data-src="{LOOP_PRODUCT.image}" class="img-fluid suggest_img d-block mx-auto rounded-top lazy" alt="{LOOP_PRODUCT.name_product}" style="object-fit: contain;">
					<div class="px-2 name_price-shock">
						<span class="product_card_name text_limited pt-1">{LOOP_PRODUCT.name_product}</span>
						<img class="w-50 py-1" src="{NV_BASE_SITEURL}themes/default/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" class="product_card_star">
						<p class="m-0">{LOOP_PRODUCT.price}</p>
						<!-- BEGIN: price_special -->
						<p class="text-muted m-0" style="text-decoration: line-through">
						{price_special}</p>
						<!-- END: price_special -->
						
					</div>
					<div class="p-2">
						<button class="w-100 btn_landing text_white py-1">Mua ngay</button>
					</div>
				</div>
			</div>
		</a>
	</div>
	</div>
	<!-- END: product -->
</div>
<!-- END: main -->