<!-- BEGIN: main -->
<div class="px-3" >
	<div class="swiper mySwiper" style="overflow:hidden">
		<div class="swiper-wrapper">
			<!-- BEGIN: product -->
			<div class="swiper-slide">
				<a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}" class="text_black w-100">
					<div class="row mb-3 position-relative {BORDER} rounded-lg align-items-center mx-2 mx-md-1 product_hot_body">
						<div class="col-5 p-0 pr-2">
							<div class="product_hot_img beauty_img position-relative">
								<img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/no_image.svg"
								data-src="{LOOP_PRODUCT.image}" class="max_w_h h-100 lazy" alt="alt="
								{LOOP_PRODUCT.name_product}"">
								<!-- BEGIN: free_ship -->
								<div class="position-absolute w-100 h-100">
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg" />
								</div>
								<!-- END: free_ship -->
							</div>
						</div>
						<div class="col-7 px-2 px-md-1">
							
							<p class="product_hot_name fs_16 text_limited mb-2 mb-md-1" style="line-height:21px">{LOOP_PRODUCT.name_product}
								</p>
							<div class="price_product_item_nb pt-1">				
								<p class="secondary_text product_hot_pri ce mb-2 mb-md-1 fw_500">{LOOP_PRODUCT.price_format}</p>
								<!-- BEGIN: price_special -->
								<p class="price_special mb-2 mb-md-1">
									{price_special}
								</p>
								<!-- END: price_special -->
								
							</div>
							
							<img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg"
							class="product_hot_star" style="width:91px">
						</div>
						
					</div>
				</a>
			</div>
			<!-- END: product -->
		</div>
		<div class="swiper-pagination"></div>
	</div>
</div>


<script>
    var swiper = new Swiper('.mySwiper', {
		
		slidesPerView: 3,
		slidesPerColumn: 2,
		slidesPerGroup:3,
		spaceBetween: 0,
		speed:700,
		autoplay: {
			delay: 5000,
			disableOnInteraction: false
		},
	});
</script>

<!-- END: main -->
