<!-- BEGIN: main -->

<!-- BEGIN: voucher -->

<div class="row mt-3">
	<!-- BEGIN: voucher_loop -->
	<div class="col-6 pb-3">
		<div class="bg_gray coupons_voucher_wallet rounded d-flex">
			<div class="coupons_left w-25 bg_gray">
				<div class="p-2">
					<img class="img-fluid rounded" src="https://banhang.chonhagiau.com/uploads/retails/shops/purelac/617ba48e722b31635493006.png" alt=""/>
				</div>
				<div class="coupons_left-border">
				</div>
			</div>
			<div class="coupons_right pl-4 p-3 w-75 position-relative rounded">
				<div class="d-flex justify-content-between">
					<div class="d-flex align-items-center">
						<img src="{VOUCHER.avt_store}" class="max_w_h rounded-circle" alt="{VOUCHER.voucher_name}"  style="width:40px">
						<span class="pl-2">{VOUCHER.voucher_name}</span>
					</div>
				</div>
				<h4 class="secondary_text mt-2" style="font-size:14px;">Giảm {VOUCHER.discount_price} tất cả đơn hàng</h4>
				<span class="text_gray_color">
					<!-- BEGIN: maximum_discount -->
					<div class="">Giảm tối đa {maximum_discount}</div>
					<!-- END: maximum_discount -->
				</span>
				<span class="text_gray_color fs_12">{VOUCHER_APPLY}</span>
				<div class="d-flex justify-content-between w-100 position-absolute align-items-center" style="bottom:10px">
					<span>HSD: {VOUCHER.time_to}</span>
					<button class="btn_ecng mr-5">Dùng ngay</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END: voucher_loop -->
</div>
<!-- END: voucher -->

<!-- BEGIN: not_voucher -->
<div class="mt-2">Không tìm thấy!</div>
<!-- BEGIN: not_voucher -->

<!-- END: main -->