<!-- BEGIN: main -->

<!-- BEGIN: enibal_brand -->
<section class="bg_white mb-3 brand">
	<div class="owl-carousel owl-theme p-2" id="brand">
		
		<div class="item all_brand">
			<a branid="0" class="">Tất cả</a>
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
<section class="bg_white mb-3 p-2 rounded-lg categoryChill">
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
<section class="categoryFilter bg_white py-3 mb-3 d-flex align-items-center ">
	<div class="ml-2">Sắp xếp theo</div>	   
	<button value="1" class="group_product_item btn_ecng_outline mx-2 px-2">Phổ biến</button>
	<button value="2" class="group_product_item btn_ecng_outline mx-2 px-2">Yêu thích</button>
	<button value="3" class="group_product_item btn_ecng_outline mx-2 px-2">Mới nhất</button>
	<!--   <div class="mx-2">
		<select class="form-control border_ecng secondary_text px-2" name="categoryfilter_price">
		<option value="0">Giá</option>
		<option value="1" categoryFilter_price="1">Giá thấp đến cao</option>
		<option value="2" categoryFilter_price="2">Giá cao đến thấp</option>                                     
		</select>
		</div>
		
		<div class="mx-2">
		<select class="form-control border_ecng secondary_text " id="categoryFilter_star">
		<option value="0" class="item_star">Tất cả</option>
		<option value="5" class="item_star">5 sao</option>
		<option value="4" class="item_star">4 sao trở lên</option>
		<option value="3" class="item_star">3 sao trở lên</option>
		<option value="2" class="item_star">2 sao trở lên</option>
		<option value="1" class="item_star">1 sao trở lên</option>					                                 
		</select>
	</div> -->
	<div id="price" class="mx-2 d-flex justify-content-between align-items-center rounded position-relative" name="categoryfilter_price" style="padding: 5px 0px">
		<div class="mb-0 text_primary pl-2 secondary_text" id="categoryFilter_price" value="0">Giá</div>
		<i class="fa fa-caret-down pr-2 secondary_text" aria-hidden="true"></i>
		<ul id="price_content" class="position-absolute pl-0 bg_white w-100">
			<li class="py-2 pl-2" value="0">Giá</li>
			<li class="py-2 pl-2" value="1" categoryFilter_price="1">Giá thấp đến cao</li>
			<li class="py-2 pl-2" value="2" categoryFilter_price="2">Giá cao đến thấp</li>
		</ul>
	</div>
	<div id="rate" class=" mx-2 d-flex justify-content-between align-items-center rounded position-relative" style="padding: 5px 0px">
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
</section>

<script>
	$("ul#price_content li").click(function() {
		var a = $(this).val();
		$('#categoryFilter_price').attr('value', a);
		$("#categoryFilter_price").text($(this).text());
		$('#price_content').css({"height": "0", "visibility": "hidden"});
		$('#price_content li').css({"height": "initial", "visibility": "hidden"});
	});
	$("ul#star li").click(function() {
		var a = $(this).val();
		$('#categoryFilter_star').attr('value', a);
		$("#categoryFilter_star").text($(this).text());
		$('#star').css({"height": "0", "visibility": "hidden"});
		$('#star li').css({"height": "initial", "visibility": "hidden"});
	});
	$("#price").hover(function(){
		$('#price_content').css({"height": "104px", "visibility": "visible"});
		$('#price_content li').css({"height": "initial", "visibility": "visible"});
		}, function(){
		$('#price_content').css({"height": "0", "visibility": "hidden"});
		$('#price_content li').css({"height": "initial", "visibility": "hidden"});
	});
	$("#rate").hover(function(){
		$('#star').css({"height": "206px", "visibility": "visible"});
		$('#star li').css({"height": "initial", "visibility": "visible"});
		}, function(){
		$('#star').css({"height": "0", "visibility": "hidden"});
		$('#star li').css({"height": "initial", "visibility": "hidden"});
	});
	
	$('#brand .item,#categoryChill .item, #price_content li, .categoryFilter  .group_product_item, #star li').click(function(){
		load_ajax_product();
	});
	
	function load_ajax_product()
	{
		var brand = $('#brand .item .brand_active').attr('branid');
		var catalogy_child = $('#categoryChill .secondary_text').attr('catid');
		var categoryFilter = $('.categoryFilter .group_product_item.btn_ecng').val();
		var categoryFilter_price = $('#categoryFilter_price').attr('value');
		var categoryFilter_star = $('#categoryFilter_star').attr('value');
		
		
		
		var page = 1;
		
		//console.log('{URL}?page=' + page +'&brand=' + brand +'&catalogy_child='+catalogy_child+'&categoryFilter='+categoryFilter+'&categoryFilter_price='+categoryFilter_price+'&categoryFilter_star='+categoryFilter_star);
		$.ajax({
			type : 'POST',
			url : '{URL}',
			data: {page : page, brand : brand, catalogy_child : catalogy_child, categoryFilter : categoryFilter, categoryFilter_price : categoryFilter_price, categoryFilter_star : categoryFilter_star},
			success : function(res){
				
				$('#ProductContent').html(res);
			}
			
		});
	}
	
	
	
</script>



<section class="productCategory mb-3" id="ProductContent">
	<!-- BEGIN: no_product -->
	<div class="no_product">Không tìm thấy sản phẩm!</div>
	<!-- END: no_product -->
	<!-- BEGIN: product -->
	<div class="row">
		<!-- BEGIN: loop -->
		<div class="col-md-2 mb-10">
			<a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}" class="product_card_link">
				<div class="bg_white product_card">
					<div class="product_card_img position-relative">
						<img src="{LOOP_PRODUCT.image}"  alt="{LOOP_PRODUCT.name_product}" />
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
							<p class="price_special mb-2 mb-md-1 fw_500">
								{price_special}
							</p>
							<!-- END: price_special -->
							
						</div>
						<div class="pb-2">
							<img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/chonhagiau/images/icon/{LOOP_PRODUCT.star}star.svg" alt="" class="product_card_star" />
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
	
</section>

<!-- END: main -->
