<!-- BEGIN: main -->
 <!-- style="min-height: 87.1vh" -->
<div class="wishlist_item bg_white" id="wishlist_item">	

	<div class=" bd_b_1 bg_white">
		<div class="resign text-center px-2">
			<p class="fs_18 mb-0 py-3">Sản phẩm yêu thích</p>
		</div>
	</div>
	<form id="search_wishlist" action="" method="post">
		<div class="row mt-2">
            <div class="col-xs-24 col-md-6">
				<div class="p-1 bg-light rounded rounded-lg shadow-sm mb-2">
					<div class="input-group">
						<div class="input-group-prepend">
							<button class="btn btn-link text-warning" type="submit" value="{LANG.search_submit}" /><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
						<input class="form-control border-0 bg-light" type="text" value="{Q}" name="s" maxlength="255" placeholder="Tìm kiếm theo" />
					</div>
				</div>
			</div>

        </div>
	</form>
		                					
	<!-- BEGIN: no_product -->
	<div class="p-4 fs_12 mb-3 text-center">Không tìm thấy kết quả!</div>
	<!-- END: no_product -->
	
	<div class="productLike_list" style="min-height: 72.2vh">
	<!-- BEGIN: product -->
		<div class="productLike bg_white p-2 mb-1 bd_b_1">
			<div class="row align-items-center">
				<div class="col-2">
					<a class="beauty_img width_60" title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}"><img src="{LOOP_PRODUCT.image}"  alt="" class="max_w_h"></a>
				</div>
				<div class="col-7">
					<div class="pl-3"><a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}">{LOOP_PRODUCT.name_product}</a></div>
				</div>
				<div class="col-3 text-right"><button onclick="delete_wishlist({LOOP_PRODUCT.id});" class="btn btn-outline-danger">Bỏ thích</button></div>
			</div>
		</div>
	<!-- END: product -->
	</div>
	
	<!-- BEGIN: generate_page -->
	<div class="text-center d-flex justify-content-center pagi_wishlist">
		{NV_GENERATE_PAGE}
	</div>
	<!-- END: generate_page -->
</div>

<script type="text/javascript">
	var a = $('.pagi_wishlist').find('ul').length;
	if(a > 0){
		$('.productLike_list').css({'min-height' : '65.1vh'})
	}
	<!-- var b = $('.productLike').find('.btn-outline-danger').length; -->
	<!-- if( b == 0){ -->
		<!-- window.location.replace("https://chonhagiau.com/wishlist/"); -->
	<!-- } -->

	function delete_wishlist(product_id){
	
		$.ajax({
			type : 'POST',
			url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=wishlist&mod=delete_wishlist&product_id='+ product_id,
			success : function(res){
				res2=JSON.parse(res);
				console.log(res)
				if(res2.status=="OK"){
					location.reload();
					}else{
					alert("có lỗi xảy ra!, vui lòng kiểm tra lại!");
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		}); 
	}
	$("#search_wishlist").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=wishlist',
			data: $('#search_wishlist').serialize(), 
			success: function(res)
			{
				$('#wishlist_item').html(res);
			}
		});
	});
	
</script>

<!-- <script type="text/javascript"> -->
	<!-- function delete_wishlist(product_id){ -->
		
		<!-- var r = confirm("Bạn chắc chắn muốn xóa khỏi danh sách yêu thích!"); -->
		<!-- if (r == true) { -->
			<!-- $.ajax({ -->
				<!-- type : 'POST', -->
				<!-- url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=wishlist&mod=delete_wishlist&product_id='+ product_id, -->
				<!-- success : function(res){ -->
					<!-- res2=JSON.parse(res); -->
					<!-- console.log(res) -->
					<!-- if(res2.status=="OK"){ -->
						<!-- location.reload(); -->
						<!-- }else{ -->
						<!-- alert("có lỗi xảy ra!, vui lòng kiểm tra lại!"); -->
					<!-- } -->
				<!-- }, -->
				<!-- error: function(xhr, ajaxOptions, thrownError) { -->
					<!-- alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText); -->
				<!-- } -->
			<!-- });  -->
			
		<!-- } -->
	<!-- } -->
<!-- </script> -->


<!-- END: main -->