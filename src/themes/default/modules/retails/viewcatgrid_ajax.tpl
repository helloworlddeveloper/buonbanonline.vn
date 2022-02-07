<!-- BEGIN: main -->

<!-- BEGIN: no_product -->
<div class="no_product">Không tìm thấy sản phẩm!</div>
<!-- END: no_product -->

<!-- BEGIN: product -->
<div class="row">
	<!-- BEGIN: loop -->
	<div class="col-md-2 mb-10">
		<a href="{LOOP_PRODUCT.alias}" class="product_card_link">
			<div class="bg_white product_card">
				<div class="product_card_img position-relative">
					<img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/chonhagiau/images/no_image.svg" data-src="{LOOP_PRODUCT.image}" class="lazy" alt="{LOOP_PRODUCT.name_product}" />
					<!-- BEGIN: free_ship -->
					<div class="position-absolute picture_frames w-100 h-100">
						<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg" />
					</div>
					<!-- END: free_ship -->
				</div>
				<div class="product_card_body">
					<p class="product_card_name text_limited pt-1">{LOOP_PRODUCT.name_product}</p>
					
					<div class="price_product_item pt-2">
						<p class="secondary_text mb-2 mb-md-1 fs_16 fw_500">{LOOP_PRODUCT.price_format}</p>
						<!-- BEGIN: price_special -->
						<p class="price_special mb-2 mb-md-1">
							{price_special}
						</p>
						<!-- END: price_special -->
					</div>
					
					<div class="d-flex justify-content-between fs_12 pb-2 pt-1">
						<img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" alt="" class="product_card_star" />
						<!-- <span class="fs_12"><span class="text_gray_color">Đã bán </span> <span class="secondary_text">{LOOP_PRODUCT.number_order}</span></span> -->
					</div>
				</div>
			</div>
		</a>
	</div>
	<!-- END: loop -->
	
	
</div>
<!-- END: product -->

<!-- BEGIN: generate_page -->
<div class="clear"></div>
<nav class="text-center">
	{NV_GENERATE_PAGE}
</nav>
<!-- END: generate_page -->



<!-- END: main -->
