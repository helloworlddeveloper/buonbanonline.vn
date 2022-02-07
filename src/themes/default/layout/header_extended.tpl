<header class="primary_bg">
	<div class="container">
		<div class="row">
			<div class="col-2  pb-1">
				<div class="row align-items-center">
					<div class="col-8 col-md-9">
						<div class="logo">
							<a title="{SITE_NAME}" href="{THEME_SITE_HREF}">
								<img class="img-fluid" src="{LOGO_SRC}" alt="{SITE_NAME}">
							</a>
						</div>
					</div>
					<div class="col-4 col-md-3 ">
						[CATEGORY]
					</div>
				</div>
			</div>
			
			<div class="col-10 pb-1">
				<div class="row pt-1">
					<div class="col-md-12">
						<div class="header_top pt-1">
							<ul class="nav justify-content-end header_top_menu">
								<li class="nav-item header_notifi pr-2">
									[NOTIFICATION]
								</li>
								<li class="nav-item pl-3">
									<a href="https://banhang.chonhagiau.com/" target="_blank" class="nav-link secondary_text"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="14" height="14" x="0" y="0" viewBox="0 0 96 96" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g xmlns="http://www.w3.org/2000/svg" id="_02-shop" data-name="02-shop"><g id="Glyph"><path d="m95.983 32h-95.983v4a8 8 0 0 0 8 8h12a8 8 0 0 0 8-8 8 8 0 0 0 8 8h24a8 8 0 0 0 8-8 8 8 0 0 0 8 8h12a8 8 0 0 0 8-8v-4z" fill="#e1a208" data-original="#000000" style="" class=""/><path d="m95.017 28-7.171-25.1a4 4 0 0 0 -3.846-2.9h-18.321l5.6 28z" fill="#e1a208" data-original="#000000" style="" class=""/><path d="m30.321 0h-18.321a4 4 0 0 0 -3.846 2.9l-7.171 25.1h23.738z" fill="#e1a208" data-original="#000000" style="" class=""/><path d="m57.521 0h-19.042l-5.6 28h30.242z" fill="#e1a208" data-original="#000000" style="" class=""/><path d="m76 48a11.953 11.953 0 0 1 -8-3.063 11.953 11.953 0 0 1 -8 3.063h-24a11.953 11.953 0 0 1 -8-3.063 11.953 11.953 0 0 1 -8 3.063h-12a11.922 11.922 0 0 1 -4-.7v44.7a4 4 0 0 0 4 4h8v-36a4 4 0 0 1 4-4h20a4 4 0 0 1 4 4v36h44a4 4 0 0 0 4-4v-44.7a11.922 11.922 0 0 1 -4 .7zm4 24a4 4 0 0 1 -4 4h-20a4 4 0 0 1 -4-4v-12a4 4 0 0 1 4-4h20a4 4 0 0 1 4 4z" fill="#e1a208" data-original="#000000" style="" class=""/></g></g></g></svg> Kênh người bán</a>
								</li>
								[LOGIN]
								
							</ul>
						</div>
					</div>
				</div>
				
				<!-- header top  -->
				<div class="row mt-2 d-flex align-items-center">
					[SEARCH]
					<div class="col-md-2 text-center">
						[CART]
					</div>
				</div>
			</div>
		</div>
		<!-- top header  -->
		<!-- container  -->
	</div>
</header>
<!-- header  -->
<section class=" text-center category shadow-sm">
			<div class="container">
				[CATEGORY_LV1]
			</div>
</section>
<div class="container">
	<!-- BEGIN: breadcrumbs -->
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item ">
				<a href="{THEME_SITE_HREF}" title="Trang chủ" class="secondary_text">Trang chủ</a> 
			</li>
			<!-- BEGIN: loop -->
			<li class="breadcrumb-item active">
				<svg width="10" height="10" viewBox="0 0 11 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.408325 15.775L1.88333 17.25L10.1333 9L1.88333 0.75L0.408325 2.225L7.18332 9L0.408325 15.775Z" fill="#ADADAD"></path>
				</svg>
				<a href="{BREADCRUMBS.link}" title="{BREADCRUMBS.title}"><span class="txt">{BREADCRUMBS.title}</span></a>
			</li>
			<!-- END: loop -->
		</ol>
	</nav>
	<!-- END: breadcrumbs -->
<script>
	$(document).ready(function(){
		$('.breadcrumb .breadcrumb-item a').eq(3).removeAttr("href");
	});
	
</script>