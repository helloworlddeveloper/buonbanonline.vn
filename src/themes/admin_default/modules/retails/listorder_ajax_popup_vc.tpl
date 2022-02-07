<!-- BEGIN: main -->

<div class="p-4 text-center">
	<div class="fs_18 mb-3">Gửi hàng {VANCHUYEN} cho đơn hàng <span class="secondary_text">{VIEW.order_code}</span></div>
	<div class="row mt-4 border-top border-warning">
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
	<!-- BEGIN: khaigia_vnpost -->
		<div class="row">
		<div class="col-6">
			<label class="ecng_label_radio">
				<input type="radio" id="hinhthucthugom" checked = "checked" name="hinhthucthugom"  value="1">
				<span class="checkmark"></span>
			</label>
			Thu gom tận nơi
		</div>	
		<div class="col-6">
			<label class="ecng_label_radio">
				<input type="radio" id="hinhthucthugom"  name="hinhthucthugom" value="2">
				<span class="checkmark"></span>
			</label> Gửi hàng tại bưu cục
		</div>	
		
	</div>
	<div class="row mt-3">
		<div class="col-6">
			<label class="ecng_label_checkbox">
				<input type="checkbox" name="khaigia"  value="1"> 
				<span class="ecng_checkmark"></span>
				<span class="pl-4" style="font-size:14px">Khai giá</span>
			</label>
		</div>	
		<div class="col-6">
			Phí khai giá : <span id="check_khaigia"></span>
		</div>	
	</div>
	<div class="mt-4 text-center">
		<button class="btn_gray mr-3" class="close" data-dismiss="modal">Hủy</button>
		<button onclick="{send_vanchuyen}({VIEW.id},{VIEW.store_id})" class="btn_ecng">Gửi</button>
	</div>
	<!-- END: khaigia_vnpost -->
	
	<!-- BEGIN: khaigia_ghn -->
		<div class="row">
		<div class="col-6">
			<label class="ecng_label_radio">
				<input type="radio" id="hinhthucthugom" checked = "checked" name="hinhthucthugom"  value="1">
				<span class="checkmark"></span>
			</label>
			Thu gom tận nơi
		</div>	
		<div class="col-6">
			<label class="ecng_label_radio">
				<input type="radio" id="hinhthucthugom"  name="hinhthucthugom" value="2">
				<span class="checkmark"></span>
			</label> Gửi hàng tại bưu cục
		</div>	
		
	</div>
	<div class="row mt-3">
		<div class="col-6">
			<label class="ecng_label_checkbox">
				<input type="checkbox" name="khaigia"  value="1"> 
				<span class="ecng_checkmark"></span>
				<span class="pl-4" style="font-size:14px">Khai giá</span>
			</label>
		</div>	
		<div class="col-6">
			<span id="check_khaigia"></span>
			<span id="check_ship"></span>
		</div>	
	</div>
	<div class="mt-4 text-left">
		<p class="mb-0">
			Giá trị hàng hóa là căn cứ xác định giá trị bồi thường nếu xảy ra sự cố (giá trị bồi thường tối đa 5,000,000đ). Toàn bộ đơn hàng của GHN bắt buộc đóng phí khai giá hàng hóa, mức phí như sau:
		</p>
		<p class="mb-0">
		+Giá trị hàng hóa <= 3,000,000đ: Miễn phí.
		</p>
		<p>
		+Giá trị hàng hóa > 3,000,000đ (tối đa là 5,000,000đ): Phí khai giá hàng hóa là 0,5% giá trị hàng hóa.
		</p>
	</div>
	<div class="mt-4 text-center">
		<button class="btn_gray mr-3" class="close" data-dismiss="modal">Hủy</button>
		<button onclick="{send_ghn}({VIEW.id},{VIEW.store_id})" class="btn_ecng">Gửi</button>
	</div>
	<!-- END: khaigia_ghn -->
</div>

<!-- END: main -->
