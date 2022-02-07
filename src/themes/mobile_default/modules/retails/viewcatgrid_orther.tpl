<!-- BEGIN: main -->

			<!-- BEGIN: product -->
            <div class="col-6">
			<a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">
                <div class="bg_white mr-1 mt-1">
                    <div class="p-2">
							<div class="test-center mb-2 position-relative" id="cart_img">
								<img class="max_w_h" src="{LOOP_PRODUCT.image}" alt="{LOOP_PRODUCT.name_product}">
								<!-- BEGIN: free_ship -->
								<div class="position-absolute picture_frames w-100 h-100" >
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg"  />
								</div>
								<!-- END: free_ship -->
							</div>	
							
							<div class="height_32 text_limited">{LOOP_PRODUCT.name_product}</div>
							<div class="d-flex justify-content-between">
                            <div class="price_product_item fs_16 secondary_text my-1">
					
						
						<p class="secondary_text product_hot_price fs_18 mb-2 mb-md-1 font-weight-normal">{LOOP_PRODUCT.price_format}</p>
						<!-- BEGIN: price_special -->
						
						<p class="price_special mb-2 fs_14 mb-md-1 font-weight-normal">
							{price_special}
						</p>
						
						<!-- END: price_special -->
						
						
						
					</div>
								
                        </div>
							<img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" class="height_14 img-fluid d-inline mt-1" alt="">
                        
                    </div>
                </div>
			</a>	
            </div>
			<!-- END: product -->

<!-- END: main -->
