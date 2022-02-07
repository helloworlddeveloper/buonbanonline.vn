<!-- BEGIN: main -->
<div class="content_detail_order">
	<div class="info_order bg_white p-3">
		<p class="fs_16 font-weight-bold"><span class="text_gray_color">Đơn hàng {info_order.order_code}</span> - {info_order.status}</p> <p>Ngày mua: {info_order.time_add}</p>
		<div class="primary_text">Bạn vừa ủng hộ <span style="color:#1358B9">{children_fund}</span> tổng giá trị đơn
            hàng này vào quỹ “ <span class="secondary_text">QUỸ BẢO TRỢ TRẺ EM VIỆT NAM</span> ”</div>
		<div class="row">
			<div class="col-md-12">
				<div class="status_vnpost">
					<ul class="timeline" style="padding-left: 30px;">
						<!-- BEGIN: vnpost -->
						<li class="pl-0">
							<span class="secondary_text">{LOOP_TRACUU.addtime}:</span>
							
							<span class="pt-2">{LOOP_TRACUU.status_vnpost}</span>
						</li>
						<!-- END: vnpost -->
					</ul>
					<ul class="timeline">
						<!-- BEGIN: ghn -->
						<li>
							<span class="secondary_text">{LOOP_GHN.status_ghn}</span>
							<span class="float-right">{LOOP_GHN.time_add}</span>
							<p class="pt-2">{LOOP_GHN.warehouse} {LOOP_GHN.status_error_ghn}</p>
						</li>
						<!-- END: ghn -->
					</ul>
				</div>
			</div>
		</div>
		<div class="row px-2">
			<div class="col-md-7 p-4 border">
				<p>{info_order.order_name}</p>
				<p>{info_order.address}</p>
				<p class="mb-0">Điện thoại: {info_order.phone}</p>
			</div>
			<div class="col-md-5 p-4 border">
				<p>Giao Hàng: {info_order.transporters_name} #{info_order.shipping_code}</p>
				<p>Phí vận chuyển: {info_order.fee_transport} đ</p>
				<p class="mb-0">Phương Thức Thanh Toán: {info_order.status_payment_vnpay_title}</p>
			</div>
		</div>
	</div>
	<!-- BEGIN: view -->
	
	<div class="history bg_white px-3 my-3">
		<div class="history_header border-bottom  py-2 mb-3">
			<div class="history_header_shop">
				<a class="d-flex align-items-center" href="#">
					<div class="beauty_img" style="width: 30px; height: 30px;">
						<img src="{info_store.avatar_image}" class="max_w_h" alt="">
					</div>
					<span class="ml-3">  {info_store.company_name}</span>
				</a>
			</div>
			
		</div>
		
		<div class="history_product border-bottom pb-2">
			<!-- BEGIN: loop -->
			<div class="row d-flex align-items-center py-2">
				<div class="col-2 ">
					<a class="beauty_img width_60" href="#"><img src="{VIEW.image}" class="max_w_h" alt=""></a>
				</div>
				<div class="col-6">
					<div class="cartName px-2">
						<a href="#">
							<p class="mb-0">{VIEW.name_product}</p>
						</a>
						<p class="text_gray_color mb-0">{VIEW.name_group}</p>
					</div>
				</div>
				
				<div class="col-1 text-center">
					x {VIEW.quantity}
				</div>
				<div class="col-3 secondary_text text-center">{VIEW.price} đ</div>
			</div>
			<!-- END: loop -->
		</div>
		<div class="row">
			<div class="col-md-4 offset-md-8">
				<table class="table table-borderless mb-0">
					<tbody>
						<tr>
							<td class="text_gray_color">Tạm tính</td>
							<td class="float-right">{tamtinh}đ</td>
							
						</tr>
						<tr>
							<td class="text_gray_color">Phí vận chuyển</td>
							<td class="float-right">{info_order.fee_transport} đ</td>
							
						</tr>
						<!-- BEGIN: voucher -->
						<tr id="row_voucher">
							<td class="text_gray_color">Voucher</td>
							<td class="float-right" id="tongvoucher" >
								{info_order.voucher_price}đ
							</td>
						</tr>
						<!-- END: voucher -->
						<tr>
							<td class="mb-0">Tổng thanh toán</td>
							<td class="float-right fs_20 secondary_text mb-0">{info_order.total} đ</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		
		
		
	</div>
	
	<!-- END: view -->
	
	
</div>
<div style="hieght:10px">
</div>

<!-- END: main -->