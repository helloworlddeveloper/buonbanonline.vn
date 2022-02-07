<!-- BEGIN: main -->
<div class="swiper-container" id="home_block_danhmuc">
	<div class="swiper-wrapper">
		<!-- BEGIN: loopcat1 -->
			<div  class="swiper-slide">
				<div  class="home_block_danhmuc_list">
					<div  class="home_block_danhmuc_list_img">
					<a title="{CAT1.note}" href="{CAT1.link}"{CAT1.target}>
					<!-- BEGIN: image --><img height="100px" src="{IMG}" alt="{CAT1.title_trim}" title="{CAT1.title_trim}"><!-- END: image -->
					</a>
					</div>
					<h3><a title="{CAT1.note}" href="{CAT1.link}"{CAT1.target}>{CAT1.title_trim}</a></h3>
				</div>	
			</div>
		<!-- END: loopcat1 -->
	</div>

</div>
<script>
	var swiper = new Swiper('#home_block_danhmuc', {
		
		autoplay: {
			delay: 4500,
			disableOnInteraction: false,
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
				slidesPerView:10,
				slidesPerGroup: 1,
			},
			1024: {
				slidesPerColumn: 2,
				slidesPerView: 10,
				slidesPerGroup: 1,
			},
			768: {
				slidesPerColumn: 2,
				slidesPerView: 6,
				slidesPerGroup: 1,
			},
			640: {
				slidesPerColumn: 2,
				slidesPerView: 4,
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