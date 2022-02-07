<!-- BEGIN: main --><!-- BEGIN: product -->
<div class="row mt-1">
	<!-- BEGIN: loop -->
	<div class="col-6">
	<a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">
		<div class="bg_white mr-1 mt-1">
			<div class="p-2">
					<div class="test-center position-relative" id="cart_img">
						<img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/chonhagiau/images/no_image.svg" data-src="{LOOP_PRODUCT.image}" class="lazy" alt="{LOOP_PRODUCT.name_product}" />
						<!-- BEGIN: free_ship -->
								<div class="position-absolute picture_frames w-100 h-100">
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg"  />
								</div>
								<!-- END: free_ship -->
					</div>
				<div class="height_32 text_limited">
					<p class="product_card_name text_limited">{LOOP_PRODUCT.name_product}</p>
				</div>
				<div class="d-flex justify-content-between my-1">
					
					<div class="price_product_item fs_18 font-weight-normal">
						<p class="secondary_text mb-2 mb-md-1">{LOOP_PRODUCT.price_format}</p>
						<!-- BEGIN: price_special -->
						<p class="price_special mb-2 mb-md-1 fs_14">
							{price_special}
						</p>
						<!-- END: price_special -->
						
					</div>
					<!-- <div class="">Đã bán <span class="secondary_text">{LOOP_PRODUCT.number_order}</span></div> -->
				</div>
				<img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" class="height_14 img-fluid d-inline mb-1" alt="">
				
			</div>
		</div>
		</a>
	</div>
	<!-- END: loop -->
</div>
<!-- END: product --><!-- END: main -->
