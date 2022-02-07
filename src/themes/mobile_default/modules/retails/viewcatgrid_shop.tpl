<!-- BEGIN: main -->

<div class="p-2 primary_bg">
	<div class="row mb-2">
		<div class="col-8 d-flex align-items-center">
			<div class="beauty_img width_60">
				<img class="max_w_h rounded mb-0" src="{info_shop.avatar_image}" alt=""> 
			</div> 
			
			<p class="fs_16 text_white mb-0 pl-2">{info_shop.company_name}</p>
			
		</div>
		<div class="col-4 d-flex align-items-center justify-content-end pr-2">
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
							$('.number_follow').html(a)
							
							}else{
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
				}
		}
	</script>
	
	<div class="row">
		<div class="col-4 text-center">
			<div class="secondary_text">
				{info_shop.number_product}
			</div>
			<div class="text_gray_color">Sản phẩm</div>
		</div>
		<div class="col-4 text-center border-right border-left">
			<div class="secondary_text number_follow">
				{info_shop.follow}
			</div>
			<div class="text_gray_color">Người theo dõi</div>
		</div>
		<div class="col-4 text-center">
			<div class="secondary_text">
				{info_shop.time_add}
			</div>
			<div class="text_gray_color">Ngày tham gia</div>
		</div>
	</div>
</div>

<!-- BEGIN: voucher -->
<section class="voucher p-2">
	<div class="pb-3 fs_14 fw_700">
		Mã giảm giá
	</div>
	<div class="owl-carousel owl-theme position-relative" id="voucher_shop">
		<!-- BEGIN: voucher_loop -->
		<div class="row">
			<div class="bg_white coupons_voucher rounded d-flex" style="width:95%">
				<div class="coupons_left position-relative w-75 p-3 rounded">
					<div class=" text-truncate" style="max-width:250px">{VOUCHER.voucher_name}</div>
					
					<h4 class="secondary_text mt-2" style="font-size:12px;">Giảm {VOUCHER.discount_price} tất cả đơn hàng</h4>
					<span class="text_gray_color">
						<!-- BEGIN: maximum_discount -->
							<div class="">Giảm tối đa {maximum_discount}</div>
						<!-- END: maximum_discount -->
					</span>
					<span class="text_gray_color" style="font-size:11px">{VOUCHER_APPLY}</span>
					<div class="d-flex pt-2 position-absolute" style="bottom:10px">
						<span style="font-size:10px">HSD: {VOUCHER.time_to}</span>
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
							<img class="img-fluid" src="/themes/default/chonhagiau/images/save_voucher.png">
							<!-- END: saved -->
							
							<!-- BEGIN: not_voucher -->
							<img class="img-fluid" src="/themes/default/chonhagiau/images/voucher_over.png">
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
					$('#voucher_'+ voucher_id).html('<button  class="btn_gray">Đã lưu</button>');
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

<!-- BEGIN: enibal_brand -->
<section class="bg_white my-2 brand mx-2">
	<div class="owl-carousel owl-theme p-2" id="brand">
		<div class="item all_brand brand_active">
			<a branid="0" class="fs_14">Tất cả</a>
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
<section class="bg_white mb-2 p-2 rounded-lg categoryChill">
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

<section class="categoryFilter mx-2 p-2">
	<button type="button" class="btn_ecng" data-toggle="modal" data-target="#myModal"><i class="fa fa-filter" aria-hidden="true"></i> Lọc sản phẩm</button>			 
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">				  					
				<div class="modal-header">
					<h4 class="modal-title">Sắp xếp sản phẩm theo</h4>					  
				</div>										
				<div class="modal-body">					
					<div class="d-flex align-items-center justify-content-around mb-3">
						<button value="1" class="group_product_item btn_ecng_outline px-2">Sản phẩm phổ biến</button>
						<button value="2" class="group_product_item btn_ecng_outline px-2">Sản phẩm yêu thích</button>
						<button value="3" class="group_product_item btn_ecng_outline px-2">Sản phẩm mới</button>
					</div>
					
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
				<div class="modal-footer">
					<button type="button" class="btn_gray" data-dismiss="modal">Đóng</button>
				</div>					
			</div>
		</div>
	</div>                                    			
</section>
<script>
	
	//Xử lý show/hide lọc giá & sao
	
	load_ajax_product();
	
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
	$('#brand .item').click(function(){
		load_ajax_product();
	});
	$('.categoryChill #categoryChill .item').click(function(){
		
		// active				
		$('#categoryChill').find('.secondary_text').removeClass('secondary_text');
		$(this).addClass('secondary_text');							
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


<section class="product mt-1" id="ProductContent">
	
</section>
<input type="hidden" name="page_product_new" value="2" />
<div class="loadmore text-center"></div>

<!-- END: main -->
