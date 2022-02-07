<!-- BEGIN: main -->
<div class="swiper-container" id="home_block_shop_list">
	<div class="tms_defaul_title">
		<h2>
			<a href="/thoi-trang-nam/" title="GIAN HÀNG NỔI BẬT">
				GIAN HÀNG NỔI BẬT
			</a>
		</h2>
	</div>

	<div class="swiper-wrapper" style="width: 100% !important;">
		<!-- BEGIN: loop -->
		<div  class="swiper-slide">
			<div  class="home_block_shop_list">
				<div  class="home_block_shop_list_img">
					<a title="{DATA.note}" href="{DATA.link}">
						<img src="{DATA.image}" alt="{DATA.title_trim}" title="{DATA.title_trim}" style="border-radius: 100%;height: 100%;">
					</a>
				</div>
				<h3>
					<a title="{DATA.note}" href="{DATA.link}"{DATA.target}>
						{DATA.company_name}
					</a>
				</h3>
			</div>	
		</div>
		<!-- END: loop -->
	</div>

</div>

<script>
	var swiper = new Swiper('#home_block_shop_list', {
		
		autoplay: {
			delay: 4500,
			disableOnInteraction: true,
		},
		
		navigation: {
			nextEl: '<div class="swiper-button-next"></div>',
			prevEl: '<div class="swiper-button-prev"></div>	',
		},

		breakpoints: {
			5000: {
				slidesPerColumn: 2,
				slidesPerView: 4,
				slidesPerGroup: 4,
			},
			2000: {
				slidesPerColumn: 2,
				slidesPerView:6,
				slidesPerGroup: 1,
			},
			1024: {
				slidesPerColumn: 2,
				slidesPerView: 8,
				slidesPerGroup: 1,
			},
			768: {
				slidesPerColumn: 2,
				slidesPerView: 6,
				slidesPerGroup: 1,
			},
			640: {
				slidesPerColumn: 2,
				slidesPerView: 5,
				slidesPerGroup: 1,
			},
			450: {
				slidesPerColumn: 2,
				slidesPerView: 4,
				slidesPerGroup: 1,

			}
		},
	});
</script>
<!-- END: main -->