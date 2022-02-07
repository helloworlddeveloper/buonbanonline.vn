<!-- BEGIN: main -->

	<!-- BEGIN: product -->
    <div class="col-md-2 mb-10">
        <a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}" class="product_card_link">
            <div class="bg_white mr-1 mt-1 product_card">
                <div class="product_card_img position-relative">
					<img src="{LOOP_PRODUCT.image}"  alt="{LOOP_PRODUCT.name_product}" />
					<!-- BEGIN: free_ship -->
								<div class="position-absolute picture_frames w-100 h-100">
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg"  />
								</div>
								<!-- END: free_ship -->
                </div>
                <div class="product_card_body">
				
                   <p class="secondary_text product_hot_price fs_18 mb-2 mb-md-1 font-weight-normal">{LOOP_PRODUCT.price_format}</p>
						<!-- BEGIN: price_special -->
						
						<p class="price_special mb-2 fs_14 mb-md-1 font-weight-normal">
							{price_special}
						</p>
						
						<!-- END: price_special -->
                   
					
                    <div class="d-flex justify-content-between fs_12">
                        <img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" alt="" class="product_card_star" />
                        <span class="fs_12"><span class="text_gray_color">Đã bán</span> <span class="secondary_text">{LOOP_PRODUCT.number_order}</span></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
	<!-- END: product -->

<!-- END: main -->