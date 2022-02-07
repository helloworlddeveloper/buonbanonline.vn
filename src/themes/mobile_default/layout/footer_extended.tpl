 <style> 
.modal-backdrop {
    /* bug fix - no overlay */    
    display: none;    
}
</style>
<footer class="bg_white fixed-bottom  px-4 shadow_footer">
	[MENU_FOOTER]

  <div class="modal fade" id="notifi_screen">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content" id="modal_content" style="background: rgb(51 51 51 / 90%);">
		<div class="modal-body text-center p-4">
			<img src="{NV_SITE_BASEURL}/themes/{TEMPLATE}/chonhagiau/images/tick.png" alt="" class="img-fluid">
			<div class="notifi_screen mt-2 text-white">
			</div>
		</div>
	  </div>
	</div>
  </div>
</footer>

	[NOTIFICATION]

<!-- Modal -->
<div class="modal fade" id="loading_modal" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div class="modal-dialog-loading" role="document">
    <div class="modal-content-loading" >
      <div class="modal-body-loading text-center">
        <div class="spinner-border text-primary"></div>
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