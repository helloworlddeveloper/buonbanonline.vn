<!-- BEGIN: main -->

<!-- BEGIN: enibal_other_image_category -->
<section class="category_slider mb-3 ">
	<div class="owl-carousel owl-theme" id="category_slider">
		<!-- BEGIN: other_image_category -->
		<div class="item">
			<a href="{DATA_IMG.link}"><img src="{DATA_IMG.img}" title="{DATA_IMG.title}" alt="{DATA_IMG.title}"></a>
		</div>
		<!-- END: other_image_category -->
	</div>
</section>
<!-- END: enibal_other_image_category -->

<!-- BEGIN: enibal_brand -->
<section class="bg_white mb-3 brand">
	<div class="owl-carousel owl-theme p-2" id="brand">
		
		<div class="item all_brand">
			<a branid="0" style="font-size:12px" class="brand_active">Tất cả</a>
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
		<div catid="0" class="item all_category_child secondary_text">
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
	
	<div id="price" class="mx-2 d-flex justify-content-between align-items-center rounded py-2 position-relative" name="categoryfilter_price">
		<div class="mb-0 text_primary pl-2 secondary_text" id="categoryFilter_price" value="0">Giá</div>
		<i class="fa fa-caret-down pr-2 secondary_text" aria-hidden="true"></i>
		<ul id="price_content" class="position-absolute pl-0 mt-1 bg_white w-100">
			<li class="py-2 pl-2" value="0">Giá</li>
			<li class="py-2 pl-2" value="1" categoryFilter_price="1">Giá thấp đến cao</li>
			<li class="py-2 pl-2" value="2" categoryFilter_price="2">Giá cao đến thấp</li>
		</ul>
	</div>
	<div id="rate" class=" mx-2 d-flex justify-content-between align-items-center rounded py-2 position-relative">
		<div class="mb-0 text_primary pl-2 secondary_text" id="categoryFilter_star" value="0">Tất cả</div>
		<i class="fa fa-caret-down pr-2 secondary_text" aria-hidden="true"></i>
		<ul id="star" class=" position-absolute pl-0 bg_white mt-1 w-100">
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
	load_ajax_product();
	$("ul#price_content li").click(function() {
		var a = $(this).val();
		$('#categoryFilter_price').attr('value', a);
		$("#categoryFilter_price").text($(this).text());
		load_ajax_product();
		$('#price_content').css({"height": "0", "visibility": "hidden"});
		$('#price_content li').css({"height": "initial", "visibility": "hidden"});
	});
	$("ul#star li").click(function() {
		var a = $(this).val();
		$('#categoryFilter_star').attr('value', a);
		$("#categoryFilter_star").text($(this).text());
		load_ajax_product();
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
	
	
	$('#brand .item,#categoryChill .item, .categoryFilter  .group_product_item').click(function(){
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
	
</section>
<!-- END: main -->
