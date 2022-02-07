<!-- BEGIN: main -->
<div class="bg_white mx-2 mt-2 bdr_8">
    <div class="p-3 secondary_text fs_14 font-weight-bold">Sản phẩm nổi bật</div>
	
    <div class="owl-carousel owl-theme pb-2" id="product_hot">
        <!-- BEGIN: product -->
        <div class="item text-center">
            <a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">
				<div class=" beauty_img width_80 m-auto position-relative">
					<img src="{LOOP_PRODUCT.image}" data-src="{LOOP_PRODUCT.image}" class="max_w_h bdr_5 w-auto lazy" alt="{LOOP_PRODUCT.name_product}" />
					<!-- BEGIN: free_ship -->
					<div class="position-absolute picture_frames w-100 h-100">
						<img class="position-absolute w-75" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg"  />
					</div>
					<!-- END: free_ship -->
				</div>
                
			</a>
            <div class="fs_12 mt-2 text_limited height_24">
				<p class="product_card_name text_limited">{LOOP_PRODUCT.name_product}</p>
			</div>
			<div class="my-1">
                <img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" class="height_14 w-75 d-inline mb-1 img-fluid" alt="{LOOP_PRODUCT.name_product}" />
			</div>
            
            <div class="fs_14 font-weight-bold secondary_text">
                <div class="price_product_item">
					<p class="secondary_text product_hot_price fs_18 mb-2 mb-md-1">{LOOP_PRODUCT.price_format}</p>
					
					
					<!-- BEGIN: price_special -->
					<p class="price_special mb-2 mb-md-1">
						{price_special}
					</p>
					<!-- END: price_special -->
				</div>
                
			</div>
		</div>
        <!-- END: product -->
	</div>
</div>

<!-- END: main -->
