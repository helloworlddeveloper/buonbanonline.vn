<!-- BEGIN: main -->
<div class="row item_product_new_home">
	<!-- BEGIN: product -->
    <div class="col-2 mb-10"> 
        <a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}" class="product_card_link">
            <div class="bg_white product_card">
                <div class="product_card_img position-relative">
					<img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/no_image.svg" data-src="{LOOP_PRODUCT.image}" class="lazy" alt="{LOOP_PRODUCT.name_product}" />
					<!-- BEGIN: free_ship -->
								<div class="position-absolute picture_frames w-100 h-100">
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg" />
								</div>
								<!-- END: free_ship -->
				</div>
                <div class="product_card_body">
                    <p class="product_card_name text_limited pt-1">{LOOP_PRODUCT.name_product}</p>
					
					
					<div class="price_product_item pt-2">
						<p class="secondary_text product_hot_price mb-2 mb-md-1 fs_16 fw_500">{LOOP_PRODUCT.price_format}</p>
						<!-- BEGIN: price_special -->
						<p class="price_special mb-2 mb-md-1 fw_500">
							{price_special}
						</p>
						<!-- END: price_special -->						
						
					</div>
					
					
                    <div class="d-flex justify-content-between fs_12 pb-2">
                        <img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" alt="" class="product_card_star" />
                        <!-- <span class="fs_12"><span class="text_gray_color">Đã bán</span> <span class="secondary_text">{LOOP_PRODUCT.number_order}</span></span> -->
					</div>
				</div>
			</div>
		</a>
	</div> 
	<!-- END: product -->
	<div class="result_product_ajax row"></div>
</div>

<!-- BEGIN: readmore -->
<div class="clear"></div>
<div class="text-center pt-3 readmore_botton_product_new">
	<div class="botton_ajax">
		<button class="btn btn_ecng_outline">Xem Thêm</button>
	</div>
	<div class="loading d-none"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
</div>

<script>
	var per_page = '{per_page}';
	var page = '{page}';
	
	$('.btn_ecng_outline').click(function(){
		page = parseInt(page) + 1;
		$.ajax({
			type : 'POST',
			url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '={MODULE_NAME}&' + nv_fc_variable + '=ajax&load_product_home&per_page='+ per_page +'&page=' + page,
			dataType: 'json',
			beforeSend : function(){
				$('.readmore_botton_product_new .loading').show();
				$('.btn_ecng_outline').prop('disabled', true);
				
			},
			complete: function() {
				$('.readmore_botton_product_new .loading').hide();
				$('.btn_ecng_outline').prop('disabled', false);
			}, 
			success : function(res){
				
				if(res.content != '')
				{
					$('.result_product_ajax').append(res.content);
				}
				if(res.readmore == 0)
				{
					$('.btn_ecng_outline').hide();
				}
				
			}
			
		});
	});
</script>
<!-- END: readmore -->

<!-- END: main -->