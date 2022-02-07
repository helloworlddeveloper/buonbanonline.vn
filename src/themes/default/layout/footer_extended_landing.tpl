
</div>
<footer class="bg_white m-0">
	<div class="container">
		<div class="row d-flex justify-content-between pt-3">
			<div>
				[CONTACT_FOOTER]	
				<!-- BEGIN: theme_type -->
				<div class="theme-change">
					<!-- BEGIN: loop -->
					<!-- BEGIN: other -->
					<a href="{STHEME_TYPE}" rel="nofollow" title="{STHEME_INFO}"><i class="fa fa-{STHEME_ICON}"></i></a>
					<!-- END: other -->
					<!-- BEGIN: current -->
					<span title="{LANG.theme_type_select}: {STHEME_TITLE}"><i class="fa fa-{STHEME_ICON}"></i></span>
					<!-- END: current -->
					<!-- END: loop -->
				</div>
				<!-- END: theme_type -->
				
			
			</div>
			<div >
				[ECNG]
			</div>
			<div>
				[CSKH]
			</div>
			<div >
				[TRANSPORT]
			</div>
			<div>
					[SOCIAL]
				</div>
			
		</div>
	</div>
	<div class="container-fluid">
		<hr/>
	</div>
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				[ADDRESS]
			</div>
		</div>
	</div>
	
</footer>
<!-- The Modal -->


<div  id="notifi_screen">
	<div class="modal-content" id="modal_content" style="border: 0;background: rgb(51 51 51 / 90%);">
		<div class="modal-body text-center text_white  p-4" style=" border-radius:2px">
			<img src="{NV_SITE_BASEURL}/themes/{TEMPLATE}/chonhagiau/images/tick.png" alt="" class="img-fluid">
			<div class="notifi_screen mt-2 ">
			</div>
		</div>
	</div>
</div>


<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/lazyload.min.js"></script>

<script>
    $(document).ready(function(){
	
	new LazyLoad({
	effect : "fadeIn"
	});
	
	$(document).bind('DOMNodeInserted', function(e) {
	new LazyLoad({
	effect : "fadeIn"
	});
	});
	
	}); 
    
	
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0GYTL8W4MT"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0GYTL8W4MT');
</script>