<!-- BEGIN: main -->
<div class="content_ordercustomer">
	
	<div class="mt-4">
		<div class="p-1 bg-light rounded rounded-lg shadow-sm mb-4">
			<div class="input-group">
				<div class="input-group-prepend">
					<button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
				</div>
				<input type="search" placeholder="Nhập từ khóa tìm kiếm" aria-describedby="button-addon2" class="form-control border-0 bg-light input_search_order">
			</div>
		</div>
	</div>
	<!-- search  -->
	<script>
		
		$('#all').load(nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer_no_payment&status_search=-1&payment=0');
		
		
			
		$('#button-addon2').click(function(){
			
			var q = $('.input_search_order').val();
			
			$('#all').load(nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer_no_payment&q='+ q);
		});
		$('.input_search_order').on("keypress", function(e) {
			if (e.keyCode == 13) {
				$('#button-addon2').click();
			}
		});
		
		
	</script>
	<!-- Tab panes -->
	<div class="tabcontent" style="min-height:260px">
		<div id="all" class="active">
			
		</div>
	</div>
	<!-- Tab panes -->
	
	
	
</div>
<!-- END: main -->
