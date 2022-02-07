<!-- BEGIN: main -->
		<!-- BEGIN: category -->
		<div id="main_product">
		<div class="main_product_cat_title">
		<h2><a href="{LOOP_CAT.alias}" title="{LOOP_CAT.name}">{LOOP_CAT.name}</a></h2>
		<a class="link_product_more" href="{LOOP_CAT.alias}" title="{LOOP_CAT.name}">Xem Thêm <i class="fa fa-caret-right" aria-hidden="true"></i></a>
		</div>

		<div class="swiper-container" id="tms_cat_slider">
		<div class="swiper-wrapper">
				<!-- BEGIN: product -->
				<div div class="swiper-slide">
					<div class="product-hover">					
						<div class="ProductImage lazyload">
							<a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">
								<img class="lazy" src="{LOOP_PRODUCT.image}" alt="{LOOP_PRODUCT.name_product}">
							</a>
						</div>
						<div class="ProductPrice">
							<div class="ProductDetails">
								<a href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">{LOOP_PRODUCT.name_product}</a>
							</div>				
							<!-- BEGIN: one_price -->
							<div class="money">
								{PRICE}
							</div>
							<!-- END: one_price -->
							<!-- BEGIN: min_max_price -->
							<div class="money">
								{PRICE_MIN}
							</div>
							<div class="money">
								-
							</div>
							<div class="money">
								{PRICE_MAX}
							</div>
							<!-- END: min_max_price -->
							<!-- BEGIN: none_price -->
							<div class="money">
								Giá Liên Hệ
							</div>
							<!-- END: none_price -->
							<p class="wish_ed_in_home_1">
								<i class="fa fa-eye"></i> 
								{LOOP_PRODUCT.number_view}	
								<button style="padding: 0px;background: none; border: none;" onclick="wishlist({LOOP_PRODUCT.id})" title="Yêu thích">
									<i id="like_icon_{LOOP_PRODUCT.id}" class="fa fa-heart {LOOP_PRODUCT.color_wishlist}"></i>
									<input hidden="" type="" name="check_wishlist_{LOOP_PRODUCT.id}" value="{LOOP_PRODUCT.check_wishlist}">
									<input hidden="" type="" name="check_number_like_{LOOP_PRODUCT.id}" value="{LOOP_PRODUCT.like_number}">
								</button>
								
								<span id="quantity_like_{LOOP_PRODUCT.id}">
									{LOOP_PRODUCT.like_number}
								</span>
								<i class="fa fa-shopping-bag"></i>
								{LOOP_PRODUCT.number_order}
							</p>
						</div>
					</div>
				
					
				</div>
				<!-- END: product -->
			</div>
		</div>
</div>

		<!-- END: category -->



<script>
	var swiper = new Swiper('#tms_cat_slider', {
		slidesPerColumn: 1,
		autoplay: {
			delay: 3500,
			disableOnInteraction: false,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},

		breakpoints: {
			5000: {
				slidesPerView: 6,
				slidesPerGroup: 4,
			},
			2000: {
				slidesPerView: 6,
				slidesPerGroup: 1,
			},
			1400: {
				slidesPerView: 6,
				slidesPerGroup: 1,
			},
			1024: {

				slidesPerView: 5,
				slidesPerGroup: 1,
			},
			768: {

				slidesPerView: 4,
				slidesPerGroup: 1,
			},
			640: {

				slidesPerView: 3,
				slidesPerGroup: 1,
			},
			450: {
				slidesPerView: 2,
				slidesPerGroup: 1,

			}
		},
	});
</script>

<script>

	function click_menu(catid){
		$('#scroll_list_'+catid).addClass('active_list_product_left');
		<!-- BEGIN: category_js -->
		if({LOOP_CAT.id} != catid){
			$('#scroll_list_{LOOP_CAT.id}').removeClass('active_list_product_left');
		}
		<!-- END: category_js -->

	}



</script>
<!-- END: main -->