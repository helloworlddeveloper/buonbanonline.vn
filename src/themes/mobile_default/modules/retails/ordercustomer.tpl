<!-- BEGIN: main -->
<div class="content_ordercustomer">
	
	<div class="history_header mb-2">			
		<div class="d-flex justify-content-between px-2 bg_white" id="history_order">
			<div class="item first_item_order py-2 active_order"  status_id="-1"  onclick="list(this)">
				<a class="w-100 h-100" href="#">Tất cả</a>
			</div>
			<div class="item  py-2"  status_id="1" onclick="list(this)">
				<a  href="#">Đã xác nhận</a>
			</div>
			<div class="item py-2" status_id="2" onclick="list(this)">
				<a  href="#">Đang Giao Hàng</a>
			</div>
			<div class="item py-2" status_id="3" onclick="list(this)">
				<a  href="#">Đã Giao</a>
			</div>
			<div class="item py-2" status_id="4" onclick="list(this)" >
				<a href="#">Đã Hủy</a>
			</div>	
			<div class="item py-2" status_id="5" onclick="list(this)" >
				<a href="#">Trả/Hoàn tiền</a>
			</div>	
		</div>				
	</div>
	<div class="mt-2">
		<form id="search_order">
			<div class="p-1 bg-light rounded rounded-lg shadow-sm mb-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
					</div>
					<input type="search" placeholder="Tìm kiếm theo" aria-describedby="button-addon2" class="form-control border-0 bg-light input_search_order">
				</div>
			</div>
		</form>
	</div>
	
	<script>
		$('#history_order .item a').css({
			"color" : "#918f8f"
		})
		// mới vào nó load tất cả đơn hàng trước nk
		$('#all').load(nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer&status_search=-1');
		
		$('#button-addon2').click(function(){
			
			var q = $('.input_search_order').val();
			
			var status = $('.history_header #history_order .item').attr('status_id');
			
			$('#all').load(nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order_customer&status_search='+status+'&q='+ q);
			
		});
		
		function list(a) {
			
			$('.history_header #history_order').click(function() {
				$('.history_header').find('.active_order').removeClass('active_order');
				$(a).addClass('active_order');
			});
			$('#history_order .active_order').find('.text_gray_color').removeClass('.text_gray_color').addClass('text_black')
			
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
		<div class="tabcontent">
			<div id="all" class="active">
				
			</div>
		</div>
		<!-- Tab panes -->
		
		
		
	</div>
	
<!-- END: main -->