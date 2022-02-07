<!-- BEGIN: product_loading -->
<div class="row ">
	<!-- BEGIN: product -->
	<div class="col-6">
		<a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">
            <div class="bg_white mr-1 mt-1">
                <div class="p-2">
					<div class="position-relative" id="cart_img">
						<img alt="{LOOP_PRODUCT.name_product}" src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/no_image.svg" data-src="{LOOP_PRODUCT.image}" class="lazy"/>
						<!-- BEGIN: free_ship -->
								<div class="position-absolute picture_frames w-100 h-100">
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg" />
								</div>
								<!-- END: free_ship -->
						
					</div>	
                    <div class="name_product_new_item height_32 text_limited">
						 <p class="product_card_name text_limited">{LOOP_PRODUCT.name_product}</p>
					</div>
					<div class="price_product_item fs_16 secondary_text my-1">
					
						
						<p class="secondary_text product_hot_price fs_18 mb-2 mb-md-1 ">{LOOP_PRODUCT.price_format}</p>
						<!-- BEGIN: price_special -->
						
						<p class="price_special mb-2 fs_14 mb-md-1 font-weight-normal">
							{price_special}
						</p>
						
						<!-- END: price_special -->
						
						
						
					</div>
                    
                    <div class="d-flex justify-content-between">
                        <img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" class="height_14 img-fluid d-inline" alt="Đánh giá" />
					</div>
				</div>
				
			</div>
		</a>
		
	</div>
	<!-- END: product -->
</div>
<!-- END: product_loading -->

<!-- BEGIN: main -->
<div class="bg_white secondary_text font-weight-bold px-2 py-3 fs_16">
	Sản phẩm mới
</div>
<div id="result_products_new">
    <div class="row mt-1">
		<!-- BEGIN: product -->
        <div class="col-6">
            <a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">
				<div class="bg_white mr-1 mt-1">
					<div class="p-2">
						<div class="position-relative" id="cart_img">
							<img alt="{LOOP_PRODUCT.name_product}" src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/no_image.svg" data-src="{LOOP_PRODUCT.image}" class="lazy"/>
							<!-- BEGIN: free_ship -->
								<div class="position-absolute picture_frames w-100 h-100">
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg" />
								</div>
								<!-- END: free_ship -->
						</div>	
						<div class="name_product_new_item height_32 text_limited">
							<p class="product_card_name text_limited">{LOOP_PRODUCT.name_product}</p>
						</div>
						
						<div class="price_product_item fs_16 secondary_text my-1">
							<p class="secondary_text product_hot_price fs_18 mb-2 mb-md-1 ">{LOOP_PRODUCT.price_format}</p>
							
							
							<!-- BEGIN: price_special -->
							<p class="price_special mb-2 mb-md-1">
								{price_special}
							</p>
							<!-- END: price_special -->
						</div>
						
						<div class="d-flex justify-content-between">
							<img src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" class="height_14 img-fluid d-inline" alt="Đánh giá" />
						</div>
					</div>
				</div>
			</a>	
		</div>
		<!-- END: product -->
		
	</div>
</div>

<br/>
<input type="hidden" name="page_product_new" value="1" />
<div class="loadmore text-center"></div>

<script>
	
	// Biến dùng kiểm tra nếu đang gửi ajax thì ko thực hiện gửi thêm
	var is_busy = false;
	
	// Biến lưu trữ rạng thái phân trang 
	var stopped = false;
	
	function loadmore_jquery(id_result,url_loading,limit)
	{
		var page = parseInt($('input[name=page_product_new]').val());
		if(page > 0)
		{
			$.ajax({               
				type: "POST", 
				url: url_loading,
				data: {load_product_new : '1', page_loading : page, limit_loading : limit},
				beforeSend: function() {
					$('.loadmore').addClass('loader');
				},	               
				complete: function() {
					$('.loadmore').removeClass('loader');
				},                 
				success: function(res) {
					if(res != '')
					{
						page = page + 1;
						$('input[name=page_product_new]').val(page);
						$(id_result).append(res);
						
					}
					else
					{
						$('input[name=page_product_new]').val('0');
						$('.loadmore').html('Không tìm thấy sản phẩm!');
						
						stopped = true;
					}
					
					is_busy = false;
					
				},                 
				error: function(xhr, ajaxOptions, thrownError) {
					
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}  
					
			});
		}
	}
	
	var currentscrollHeight = 0;
	
	$(window).scroll(function(){
		
		const scrollHeight = $(document).height();
		const scrollPos = Math.floor($(window).height() + $(window).scrollTop());
		const isBottom = scrollHeight - 100 < scrollPos;
		if (isBottom && currentscrollHeight < scrollHeight) {
			
			// Nếu đang gửi ajax thì ngưng
			if (is_busy == true){
				return false;
			}
			
			// Nếu hết dữ liệu thì ngưng
			if (stopped == true){
				return false;
			}
			
			// Thiết lập đang gửi ajax
			is_busy = true;
			
			var id_result = '#result_products_new';
			var url = nv_base_siteurl + 'index.php?' + nv_name_variable + '={MODULE_NAME}&' + nv_fc_variable + '=ajax';
			var limit = 40;
			
			loadmore_jquery(id_result,url,limit);
			
			currentscrollHeight = scrollHeight;
			
		}
		
	});
	
</script>

<!-- END: main -->