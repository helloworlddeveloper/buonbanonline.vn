<!-- BEGIN: main -->
<div class="content_ordercustomer">
	
	<div class="row m-0 rounded bg_white history_header">
		<div class="col-2 py-3 text-center tab_active" style="cursor:pointer" status_id="-1" onclick="list(this)">
			Tất cả
		</div>
		<div class="col-2 py-3 text-center" style="cursor:pointer" status_id="1"  onclick="list(this)" >
			Đã xác nhận
		</div>
		<div class="col-2 py-3 text-center" style="cursor:pointer" status_id="2"  onclick="list(this)" >
			Đang Giao Hàng
		</div>
		<div class="col-2 py-3 text-center" style="cursor:pointer" status_id="3"  onclick="list(this)" >
			Đã Giao
		</div>
		<div class="col-2 py-3 text-center" style="cursor:pointer" status_id="4"  onclick="list(this)" >
			Đã Hủy
		</div>
		<div class="col-2 py-3 text-center" style="cursor:pointer" status_id="5"  onclick="list(this)" >
			Trả/Hoàn tiền
		</div>
	</div>
	<div class="mt-3">
		<div class="p-1 bg-light rounded rounded-lg shadow-sm mb-4">
			<form id="search_order">
				<div class="input-group">
					<div class="input-group-prepend">
						<button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
					</div>
					<input type="search" placeholder="Nhập từ khóa tìm kiếm" aria-describedby="button-addon2" class="form-control border-0 bg-light input_search_order">
				</div>
			</form>
		</div>
	</div>
	<!-- search  -->
	<script>
		
		$('#all').load(nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer&status_search=-1');
		
		$('#button-addon2').click(function(){
			var q = $('.input_search_order').val();
			var status = $('.history_header div').attr('status_id');
			$('#all').load(nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer&status_search='+status+'&q='+ q);
			
		});
		
		function list(a) {
			$('.history_header').find('.tab_active').removeClass('tab_active');
			
			$(a).addClass('tab_active');
			
			var status = $(a).attr('status_id');
			var q = $('.input_search_order').val();
			
			$('#all').load(nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer&status_search='+status+'&q='+ q);
		} 
		$("#search_order").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: "GET",
				url: nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer&q='+ q,
				data: $('#search_order').serialize(), 
				
			});
		});
		
	</script>
	<!-- Tab panes -->
	<div id="ordercustomer" class="tabcontent rounded" style="min-height: 220px">
		<div id="all" class="active ">
			
		</div>
	</div>
	<!-- Tab panes -->
	
	
	
</div>

<!-- END: main -->