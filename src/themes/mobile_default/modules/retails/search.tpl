<!-- BEGIN: main -->

<!-- BEGIN: enibal_brand -->
<section class="bg_white mb-2 brand mx-2">
	<div class="owl-carousel owl-theme p-2" id="brand">
		
		<div class="item all_brand">
			<a branid="0" class="fs_14"><p class="mb-0 fs_12">Tất cả</p></a>
		</div>
		<!-- BEGIN: brand -->
		<div class="item">
			<a branid="{BRAND.id}" class=""><img class="img-fluid" src="{BRAND.logo}" alt="{BRAND.title}"></a>
		</div>
		<!-- END: brand -->
	</div>
</section>
<!-- END: enibal_brand -->

<!-- BEGIN: category_check -->
<section class="bg_white mb-2 mx-2 p-2 rounded-lg categoryChill">
	<div class="owl-carousel owl-theme" id="categoryChill">
		<div catid="0" class="item all_category_child">
			<a>Tất cả</a>
		</div>
		<!-- BEGIN: category_child -->
		<div catid="{CHILD.id}" class="item">
			<a>{CHILD.name}</a>
		</div>
		<!-- END: category_child -->
	</div>
	
</section>
<!-- END: category_check -->

<section class="categoryFilter mx-2 p-2">
	<button type="button" class="btn_ecng" data-toggle="modal" data-target="#myModal"><i class="fa fa-filter" aria-hidden="true"></i> Lọc sản phẩm</button>
	
	
	<!-- The Modal -->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Sắp xếp sản phẩm theo</h4>
					
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">					
					<div class="d-flex align-items-center justify-content-around mb-3">
						<button value="1" class="group_product_item btn_ecng_outline px-2">Sản phẩm phổ biến</button>
						<button value="2" class="group_product_item btn_ecng_outline px-2">Sản phẩm yêu thích</button>
						<button value="3" class="group_product_item btn_ecng_outline px-2">Sản phẩm mới</button>
					</div>
					<!-- <div class="d-flex align-items-center justify-content-around"> -->
					<!-- <select class="form-control border_ecng secondary_text" name="categoryfilter_price" style="width:40%"> -->
					<!-- <option value="0">Giá</option> -->
					<!-- <option value="1" categoryFilter_price="1">Giá thấp đến cao</option> -->
					<!-- <option value="2" categoryFilter_price="2">Giá cao đến thấp</option>                                      -->
					<!-- </select> -->
					
					<!-- <select class="form-control border_ecng secondary_text" id="categoryFilter_star" style="width:40%"> -->
					<!-- <option value="0" class="item_star" >Tất cả</option> -->
					<!-- <option value="5" class="item_star" >5 sao</option> -->
					<!-- <option value="4" class="item_star" >4 sao trở lên</option> -->
					<!-- <option value="3" class="item_star" >3 sao trở lên</option> -->
					<!-- <option value="2" class="item_star" >2 sao trở lên</option> -->
					<!-- <option value="1" class="item_star" >1 sao trở lên</option>					                                  -->
					<!-- </select> -->
					<!-- </div> -->
					
					<div class="d-flex justify-content-around">
						<div id="price" class="mx-2 d-flex justify-content-between align-items-center rounded py-2 position-relative" name="categoryfilter_price">
							<div class="mb-0 text_primary pl-2 secondary_text" id="categoryFilter_price" value="0">Giá</div>
							<i class="fa fa-caret-down pr-2 secondary_text" aria-hidden="true"></i>
							<ul id="price_content" class="position-absolute pl-0 bg_white w-100">
								<li class="py-2 pl-2" value="0">Giá</li>
								<li class="py-2 pl-2" value="1" categoryFilter_price="1">Giá thấp đến cao</li>
								<li class="py-2 pl-2" value="2" categoryFilter_price="2">Giá cao đến thấp</li>
							</ul>
						</div>
						<div id="rate" class=" mx-2 d-flex justify-content-between align-items-center rounded py-2 position-relative">
							<div class="mb-0 text_primary pl-2 secondary_text" id="categoryFilter_star" value="0">Tất cả</div>
							<i class="fa fa-caret-down pr-2 secondary_text" aria-hidden="true"></i>
							<ul id="star" class=" position-absolute pl-0 bg_white w-100">
								<li class="py-2 pl-2" value="0" >Tất cả</li>
								<li class="py-2 pl-2" value="5">5 sao</li>
								<li class="py-2 pl-2" value="4">4 sao trở lên</li>
								<li class="py-2 pl-2" value="3">3 sao trở lên</li>
								<li class="py-2 pl-2" value="2">2 sao trở lên</li>
								<li class="py-2 pl-2" value="1">1 sao trở lên</li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn_gray" data-dismiss="modal">Đóng</button>
				</div>
				
				
			</div>
		</div>
	</div>
	
	
	
	
</section>

<script>
	
	//Xử lý show/hide lọc giá & sao
	
	$('#price').click(function(){
		$('ul#price_content').toggleClass('active_price');
		$('ul#price_content li').toggleClass('active_price_li');
	})
	$('#rate').click(function(){
		$('ul#star').toggleClass('active_rate');
		$('ul#star li').toggleClass('active_rate_li');
	})
	
	$("ul#price_content li").click(function() {
		var a = $(this).val();
		$('#categoryFilter_price').attr('value', a);
		$("#categoryFilter_price").text($(this).text());
		load_ajax_product();
	});
	$("ul#star li").click(function() {
		var a = $(this).val();
		$('#categoryFilter_star').attr('value', a);
		$("#categoryFilter_star").text($(this).text());
		load_ajax_product();
	});
	
	// Biến dùng kiểm tra nếu đang gửi ajax thì ko thực hiện gửi thêm
	var is_busy = false;
	
	// Biến lưu trữ rạng thái phân trang 
	var stopped = false;
	
	var currentscrollHeight = 0;		
	
	
	// select change
	<!-- $('select[name=categoryfilter_price],#categoryFilter_star').change(function(){ -->
	<!-- load_ajax_product(); -->
	<!-- }); -->
	
	//button click
	$('#brand .item,#categoryChill .item').click(function(){
		load_ajax_product();
	});
	
	// fillter 
	$('.categoryFilter .btn_ecng_outline').click(function() {
		$('.categoryFilter').find('.btn_ecng').removeClass('btn_ecng btn_ecng_outline').addClass('btn_ecng_outline');
		$(this).addClass('btn_ecng ');
		
		load_ajax_product();
		
	});
	
	function load_ajax_product()
	{
		var page = parseInt($('input[name=page_product_new]').val());
		if(page > 0)
		{
			var brand = $('#brand .item .brand_active').attr('branid');
			var catalogy_child = $('#categoryChill .secondary_text').attr('catid');
			var categoryFilter = $('.categoryFilter .group_product_item.btn_ecng').val();
			<!-- var categoryFilter_price = $('select[name=categoryfilter_price]').val(); -->
			<!-- var categoryFilter_star = $('#categoryFilter_star').val(); -->
			
			var categoryFilter_price = $('#categoryFilter_price').attr('value');
			var categoryFilter_star = $('#categoryFilter_star').attr('value');
			
			var page = 1;
			
			//console.log('{URL}?page=' + page +'&brand=' + brand +'&catalogy_child='+catalogy_child+'&categoryFilter='+categoryFilter+'&categoryFilter_price='+categoryFilter_price+'&categoryFilter_star='+categoryFilter_star);
			$.ajax({
				type : 'POST',
				url : '{URL}',
				data: {page : page, brand : brand, catalogy_child : catalogy_child, categoryFilter : categoryFilter, categoryFilter_price : categoryFilter_price, categoryFilter_star : categoryFilter_star},
				beforeSend: function() {
					//$('#loading_modal').modal('show');
				},               
				complete: function() {
					//$('#loading_modal').modal('hide');
				}, 
				success : function(res){
					$('#ProductContent').html(res);
					$('input[name=page_product_new]').val('2');
					currentscrollHeight = 0;
				}
				
			});
		}
	}
	
	// croll load products
	function loadmore_jquery()
	{
		var page = parseInt($('input[name=page_product_new]').val());
		
		if(page > 0)
		{
			var brand = $('#brand .item .brand_active').attr('branid');
			var catalogy_child = $('#categoryChill .secondary_text').attr('catid');
			var categoryFilter = $('.categoryFilter .group_product_item.btn_ecng').val();
			<!-- var categoryFilter_price = $('select[name=categoryfilter_price]').val(); -->
			<!-- var categoryFilter_star = $('#categoryFilter_star').val(); -->
			
			var categoryFilter_price = $('#categoryFilter_price').attr('value');
			var categoryFilter_star = $('#categoryFilter_star').attr('value');
			
			$.ajax({               
				type: "POST", 
				url : '{URL}',
				data: {page : page, brand : brand, catalogy_child : catalogy_child, categoryFilter : categoryFilter, categoryFilter_price : categoryFilter_price, categoryFilter_star : categoryFilter_star},
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
						$('#ProductContent').append(res);
						$('.loadmore').html('');
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
			
			loadmore_jquery();
			
			currentscrollHeight = scrollHeight;
		}
		
	});
	
	
</script>


<section class="product mt-1 " id="ProductContent">
	<!-- BEGIN: no_product -->
	<div class="no_product">Không tìm thấy sản phẩm!</div>
	<!-- END: no_product -->
	
	<!-- BEGIN: product -->
	<div class="row mt-1">
		<!-- BEGIN: loop -->
		<div class="col-6">
			<a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">
                <div class="bg_white mr-1 mt-1">
                    <div class="p-2">
						<div id="cart_img" class="test-center position-relative">
							<img src="{LOOP_PRODUCT.image}" class=" mb-2 max_w_h"  alt=""/>
							<!-- BEGIN: free_ship -->
								<div class="position-absolute picture_frames w-100 h-100" >
									<img class="position-absolute icon_freeship_frams" style="bottom:-1px; left:-2px" src="/themes/default/chonhagiau/images/icon_freeship.svg" />
								</div>
								<!-- END: free_ship -->
						</div>
                        <div class="height_32 text_limited">
							<p class="product_card_name text_limited">{LOOP_PRODUCT.name_product}</p>
						</div>
                        <div class="d-flex justify-content-between price_product_item my-1">
							
                            <div class="fs_18 secondary_text font-weight-normal">
								
								{LOOP_PRODUCT.price_format}
								
								<!-- BEGIN: one_price -->
								{PRICE}
								<!-- END: one_price -->
								<!-- BEGIN: min_max_price -->
								{PRICE_MIN}
								<!-- END: min_max_price -->
								<!-- BEGIN: price_special -->
								<p class="price_special mt-1 mb-md-1 font-weight-normal">
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
	<!-- END: product -->
	
</section>
<input type="hidden" name="page_product_new" value="2" />
<div class="loadmore text-center py-3"></div>
<!-- END: main -->
