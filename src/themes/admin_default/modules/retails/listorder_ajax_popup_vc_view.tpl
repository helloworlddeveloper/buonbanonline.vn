<!-- BEGIN: main -->

<div class="p-4 text-center">
	<div class="fs_18 mb-3">Gửi hàng {VANCHUYEN} cho đơn hàng <span class="secondary_text">{VIEW.order_code}</span></div>
	<div class="row mt-4 border-top border-warning">
		<div class="thongtinpriceship">
			Phí vận chuyển: {tranposter_fee}
			<!-- BEGIN: old -->
			<div>Phí thu hộ trước đó: {total_code_old}</div>
			<div>Tổng thu hộ: {total}</div>
			<!-- END: old -->
		</div>
		</br>
		<div class="col-6 pt-3 border-right border-warning">
			<p class="fs_18">Thông tin người gửi</p>
			<p>{VIEW.warehouse_name}</p>
			<p>{VIEW.phone_warehouse}</p>
			<p>{VIEW.address_warehouse}</p>
		</div>
		<div class="col-6 pt-3">
			<p class="fs_18">Thông tin người nhận</p>
			<p>{VIEW.order_name}</p>
			<p>{VIEW.phone}</p>
			<p>{VIEW.address_receive}</p>
		</div>
	</div>
	<div class="mt-4 text-center">
		<button class="btn_gray mr-3" class="close" data-dismiss="modal">Hủy</button>
		
	</div>
</div>

<!-- END: main -->
