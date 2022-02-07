<!-- BEGIN: main -->

<div id="wishlist_item">
	<form id="search_wishlist">
		<div class="p-1 bg-light rounded rounded-lg shadow-sm mb-4">
			<div class="input-group">
				<div class="input-group-prepend">
						<button type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
				</div>
				<input class="form-control border-0 bg-light" type="text" value="{Q}" name="s" maxlength="255" placeholder="{LANG.search_title}" />
			</div>
		</div>
		
		
	</form>

	<!-- BEGIN: no_product -->
	<div class="pt-2 fs_16 mb-3 bg_white text-center" style="min-height: 331px">Không tìm thấy kết quả!</div>
	<!-- END: no_product -->
	
	<!-- BEGIN: product -->
	<div class="productLike bg_white p-3 mb-2 ">
		<div class="mb-2">
			<a href="{LOOP_PRODUCT.alias_store}"> <img src="{LOOP_PRODUCT.avatar_image}" class="rounded-circle" style="width: 35px; height: 35px; object-fit: contain;">
			<span class="ml-3">{LOOP_PRODUCT.store_name}</span>
			</a>
		</div>
		<div class="row align-items-center border-top pt-3">
			<div class="col-md-2 col-xl-2">
				<a class="d-flex justify-content-center align-items-center w-100 h-100" title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}"  style="max-height: 75px">
					<img src="{LOOP_PRODUCT.image}" style="max-width: 100%; max-height: 75px; object-fit: cover;" alt="">
				</a>
			</div>
			<div class="col-md-7 col-xl-8">
				<a title="{LOOP_PRODUCT.name_product}" href="{LOOP_PRODUCT.alias}">{LOOP_PRODUCT.name_product}</a>
			</div>
			<div class="col-md-3 col-xl-2 text-right"><button onclick="delete_wishlist({LOOP_PRODUCT.id});" class="btn btn-outline-danger">Bỏ thích</button></div>
		</div>
	</div>
	<!-- END: product -->
	
	<!-- BEGIN: generate_page -->
	<div class="text-center d-flex justify-content-center">
		{NV_GENERATE_PAGE}
	</div>
	<!-- END: generate_page -->
</div>

<script type="text/javascript">
	
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


<!-- END: main -->