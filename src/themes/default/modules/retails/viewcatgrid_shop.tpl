<!-- BEGIN: main -->
<section class="productDetail_shop bg_white rounded-sm mb-3">
	<div class="row">
		<div class="col-md-5 m-3 d-flex">
			<div class="beauty_img" style="width: 90px; height: 90px;">
				<img src="{info_shop.avatar_image}" class="max_w_h" alt="{info_shop.company_name}" >
			</div>
			<div class="productDetail_shop_info ml-3 mt-3">
				<p class="fs_20">{info_shop.company_name}</p>
				<button id="follow_shop_{info_shop.id}" onclick="follow({info_shop.id})" class="{FOLLOW.color_follow}">{FOLLOW.title_follow}</button>
				<input type="number" name="check_{info_shop.id}" value="{FOLLOW.check_follow}" hidden="">
			</div>
		</div>
		
		<script>
			function follow(shop_id) {
				var check = $("input[name=check_" + shop_id + "]").val();
				if(check == 0){
					$.ajax({
						type : 'POST',
						dataType: "JSON",
						url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=viewcatshops&mod=follow&id=' + shop_id,
						success : function(res2){
							//res2=JSON.parse(res);
							//console.log(res2)
							if(res2.status=="OK"){
								$('#follow_shop_'+shop_id).addClass('btn_ecng');
								$('#follow_shop_'+shop_id).removeClass('btn_ecng_outline');
								$('#follow_shop_'+shop_id).html('Bỏ theo dõi');
								$("input[name=check_" + shop_id + "]").val(1);
								var a = parseInt($('.number_follow').html());
								a++;
								$('.number_follow').html(a);
								}else{
								//console.log(res2);
								window.location.href = res2.link;
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
					}else if(check == 1){
					$.ajax({
						type : 'POST',
						dataType: "JSON",
						url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=viewcatshops&mod=un_follow&id=' + shop_id,
						success : function(res2){
							//res2=JSON.parse(res);
							if(res2.status=="OK"){
								$('#follow_shop_'+shop_id).addClass('btn_ecng_outline');
								$('#follow_shop_'+shop_id).removeClass('btn_ecng');
								
								$('#follow_shop_'+shop_id).html('Theo dõi');
								$("input[name=check_" + shop_id + "]").val(0);
								var a = parseInt($('.number_follow').html());
								a--;
								$('.number_follow').html(a)
								}else{
								alert("có lỗi xảy ra!, vui lòng kiểm tra lại!");
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					}); 
					}else{
					alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
				}
			}
		</script>
		<div class="col-md-6 d-flex align-items-center justify-content-around text-center">
			<div class="productDetail_shop_item mx-3">
				<p>Sản phẩm</p>
				<p class="secondary_text">{info_shop.number_product}</p>
			</div>
			<div class="productDetail_shop_item mx-3">
				<p>Người Theo Dõi </p>
				<p class="secondary_text number_follow">{info_shop.follow}</p>
			</div>
			<div class="productDetail_shop_item mx-3">
				<p>Ngày Tham Gia</p>
				<p class="secondary_text">{info_shop.time_add}</p>
			</div>
		</div>
	</div>
</section>

<!-- BEGIN: voucher -->
<section class="voucher mb-3">
	<div class="pb-3 fs_16 fw_700">
		Mã giảm giá
	</div>
	<div class="owl-carousel owl-theme position-relative" id="voucher_shop">
		<!-- BEGIN: voucher_loop -->
		<div class="row mb-3 pl-2">
			<div class="bg_white coupons_voucher rounded d-flex" style="width:95%">
				<div class="coupons_left position-relative w-75 p-3 rounded">
					<div class="">
						<div>{VOUCHER.voucher_name}</div>
					</div>
					<h4 class="secondary_text mt-2" style="font-size:14px;">Giảm {VOUCHER.discount_price} tất cả đơn hàng</h4>
					<span class="text_gray_color">
						<!-- BEGIN: maximum_discount -->
							<div class="">Giảm tối đa {maximum_discount}</div>
						<!-- END: maximum_discount -->
					</span>
					<span class="text_gray_color fs_12">{VOUCHER_APPLY}</span>
					<div class="d-flex pt-2 position-absolute" style="bottom:10px">
						<span class="expiry_date">HSD: {VOUCHER.time_to}</span>
					</div>
				</div>
				<div class="coupons_right">
					<div class="d-flex flex-column justify-content-around text-center h-100">
						<div>
							Giảm 
						</div>
						<div class="fs_16 font-weight-bold">
							{VOUCHER.discount_price}
						</div>
						<div>
							<!-- BEGIN: not_saved -->
							<div id="voucher_{VOUCHER.id}">
								<button onclick="save_voucher({VOUCHER.id})" class="{FOLLOW.color_follow} btn_ecng">Lưu</button>
							</div>
							<!-- END: not_saved -->
							
							<!-- BEGIN: saved -->
							<img src="/themes/default/chonhagiau/images/save_voucher.png">
							<!-- END: saved -->
							
							<!-- BEGIN: not_voucher -->
							<img src="/themes/default/chonhagiau/images/voucher_over.png">
							<!-- END: not_voucher -->
						</div>
					</div>
					<div class="coupons_right-border">
					</div>
				</div>
			</div>
			
			
		</div>
		<!-- END: voucher_loop -->
	</div>
</section>

<script>
	function save_voucher(voucher_id) {
		$.ajax({
			type : 'GET',
			dataType: "JSON",
			url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=viewcatshops&mod=save_voucher',
			data:{voucher_id:voucher_id,},
			success : function(res){
				if(res.status=="OK"){
					$('#voucher_'+ voucher_id).html('<img src="/themes/default/chonhagiau/images/save_voucher.png">');
					}else{
					alert("có lỗi xảy ra!, vui lòng kiểm tra lại!");
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
	
</script>
<!-- END: voucher -->

<!-- BEGIN: enibal_other_image_category -->
<section class="category_slider mb-3 ">
	<div class="owl-carousel owl-theme" id="category_slider">
		<!-- BEGIN: other_image_category -->
		<div class="item">
			<a href="#"><img src="{DATA_IMG}" title="{LOOP_CAT.name}" alt="{LOOP_CAT.name}"></a>
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
<section class="categoryFilter bg_white py-3 mb-3  d-flex align-items-center ">
	<div class="ml-2">Sắp xếp theo</div>	   
	<button value="1" class="group_product_item btn_ecng_outline mx-2 px-2">Phổ biến</button>
	<button value="2" class="group_product_item btn_ecng_outline mx-2 px-2">Yêu thích</button>
	<button value="3" class="group_product_item btn_ecng_outline mx-2 px-2">Mới nhất</button>
	
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
	$("#price").click(function(){
		$('#price_content').css({"height": "104px", "visibility": "visible"});
		$('#price_content li').css({"height": "initial", "visibility": "visible"});
		}, function(){
		$('#price_content').css({"height": "0", "visibility": "hidden"});
		$('#price_content li').css({"height": "initial", "visibility": "hidden"});
	});
	$("#rate").click(function(){
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
		
		console.log('{URL}');
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
