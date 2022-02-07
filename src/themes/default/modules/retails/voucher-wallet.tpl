<!-- BEGIN: main -->

<div class="bg_white p-3 rounded">
	<div class="row py-2">
		<div class="col-6">
			<h2 class="fs_16">Voucher của tôi</h3>
		</div>
		<div class="col-6 text-right">
			<span class="border-right pr-2">Lịch sử</span>
			<span class="pl-1"><a class="secondary_text" href="">Nhận thêm phiếu giảm giá</a></span>
		</div>
	</div>
	
	<div class="row bg_gray rounded p-4">
		<div class="d-flex col-12 justify-content-center align-items-center">
			<span class="fs_18">Mã Voucher</span>
			<input class="form-control w-50 mx-3 py-4" type="text" placeholder="Nhập mã của bạn">
			<button class="btn" style="background-color: rgb(196, 196, 196); padding:10px 30px">Lưu</button>
		</div>
	</div>
	
	<div class="row m-0 rounded">
		<div class="col-2 py-3 text-center font-weight-bold tab_active" style="cursor:pointer" status_id="0" onclick="list(0)">
			Chợ Nhà Giàu
		</div>
		<div class="col-2 py-3 font-weight-bold text-center" style="cursor:pointer" status_id="1"  onclick="list(1)" >
			Shop
		</div>
	</div>
	
	
	<div id="tab_voucher"></div>

</div>



<script type="text/javascript">
	list(0);
	
	function list(status) {
		<!-- alert(123); -->
		$.ajax({               
			type: "GET", 
			url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=voucher-wallet&mod=load_voucher',
			data: {
				status:status,
			},
			beforeSend: function() {
				
			},	               
			complete: function() {
				
			},                 
			success: function(res) {
				$('#tab_voucher').html(res);
			},                 
			error: function(xhr, ajaxOptions, thrownError) {
				
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}                  
		}); 
	}
	
</script>

<!-- END: main -->