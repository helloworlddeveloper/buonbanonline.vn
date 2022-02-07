<!-- BEGIN: main -->
<style>
	@import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700;900&display=swap');
</style>
<h2 class="title_landing py-3 m-0" style="color:#444444">Giá Shock Hôm Nay</h2>
<div class="row">
	<!-- BEGIN: product -->
	<div class="col-2 pb-3 product_landingpage" id="product_suggest">
		<div class="item">
			<a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}">
				<div class="card rounded shadow-sm border-0">
					<div class="card-body p-0">
						<div class="position-relative">
						<img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/no_image.svg"
						data-src="{LOOP_PRODUCT.image}" class="img-fluid shock_img d-block mx-auto rounded-top lazy" alt="{LOOP_PRODUCT.name_product}" style="object-fit: contain;">
						<!-- BEGIN: free_ship -->
						<div class="position-absolute w-100 h-100" style="top:0">
							<img class="w-75 position-absolute icon_freeship_frams" style="bottom:-1px; left:1px" src="/themes/default/chonhagiau/images/icon_freeship.svg">
						</div>
						<!-- END: free_ship -->
					</div>
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