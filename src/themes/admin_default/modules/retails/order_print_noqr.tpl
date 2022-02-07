<!-- BEGIN: main -->
<style type="text/css">
	body{
		background: #fff;
	}
	.wrap_img_logo_buu_dien{
		height: 10vh;
		overflow: hidden;
		padding: 10px;
	}
	.wrap_img_logo_buu_dien img{
		height: 100%;
		object-fit: contain;
	}
	.wrap_img_logo_diwali{
		height: 10vh;
		overflow: hidden;
		padding: 10px;
	}
	.wrap_img_logo_diwali img{
		height: 100%;
		object-fit: contain;
	}
	.wrap_img_logo_diwali_qr{
		height: 9vh;
		overflow: hidden;
		padding: 0px;
		padding-right: 10px;
		float: right;

	}
	.wrap_img_logo_diwali_qr img{
		height: 100%;
		width: 100%;
		object-fit: fill;
	}
	.nopd{
		padding: 0px !important;
	}
	.header_prin_info_noqr{
		display: grid;
		padding: 10px;
	}

	.img_qr{
		padding: 10px;
		border-left: dashed 1px #000;
		height: 100%;
	}
	.img_qr img{
		position: absolute;
		width: 20vh;
		top: 6vh;
		left: 0px;
		height: 10vh;
		transform: rotate(-90deg);
		object-fit: fill;
		max-width: 100vh;
	}
	.chu_ky_print{
		border: solid 1px #dcdcdc;
		height: 23vh;
	}
	.from_people{
		padding-top: 0px;
		padding-bottom: 5px;
		font-weight: 500 !important;
	}
	.address_people_send{
		padding-right: 5px;
	}
	.them_pd{
		padding: 10px;
	}
	.font_weight_text{
		font-weight: 500 !important;
	}
	.content_product_send{
		height: 17vh;

	}
	p{
		margin-bottom: 0px;
	}
	.chu_ky_print1{
		font-size: 14px;
		font-weight: 600;
		padding: 5px;
		text-align: center;
	}
	.chu_ky_print2{
		padding-left: 10px;
		padding-right: 10px;
	}
	.tien_hang_can_lay{
		font-weight: 700;
		font-size: 20px;
		text-align: center;
		padding: 5px;
		text-transform: uppercase;
	}
	.cach_ra{
		padding-bottom: 0px;
		padding-top: 0px;
	}
	.product_tychinh{
		font-weight: 500;
	}
	.name_people_send{
		line-height: 14px;
	}
	.address_people_send{
		line-height: 14px;
	}
	.sdt_people_send{
		line-height: 14px;
	}






	.info_invoice{
		text-transform: uppercase;
		font-weight: 600;
		text-align: center;
		font-size: 18px;
	}
	.info_extend{
		text-align: right;
	}
	.table_prin_noqr{
		padding-top: 10px;
	}
	.info_invoice_time{
		text-align: center;

	}
	.header_prin_info_noqr1{
		margin-top: 5px;
		border: solid 1px #dcdcdc;
	}
	.day_ra_1_dong td{
		white-space: nowrap;
		background: #f2f2f2;
	}
</style>
<div class="container" style="height: 99vh; border: solid 2px #000; margin: auto;">
	<div class="header_prin_info_noqr header_prin_info_noqr1" style="height: 10vh;">
		<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopd">
			<p class="info_invoice">Thông tin đơn hàng</p>
			<p class="info_invoice_time">{DATA.time_add}</p>
		</div>
	</div>
	<div class="header_prin_info_noqr" style="height: 23vh;">
		<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopd">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopd" style="height: 100%;">
				<p class="from_people" style="font-weight: 600 !important; text-transform: uppercase;">
					Thông tin người bán:
				</p>
				<p class="name_people_send">
					{INFO_SHOP.name_send}
				</p>

				<p class="address_people_send">
					<span>{INFO_SHOP.address},</span>
				</p>
				
				<p class="sdt_people_send">
					{INFO_SHOP.phone_send}
				</p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopd font_weight_text" >
				<p class="from_people" style="font-weight: 600 !important;text-transform: uppercase;">
					Thông tin người mua:
				</p>
				<p class="name_people_send">
					{DATA.order_name}
				</p>
				<p class="address_people_send">
					<span>
						{DATA.address}
					</span>
				</p>
				<p class="sdt_people_send">
					{DATA.phone}
				</p>
			</div>
		</div>
	</div>
	<div class="header_prin_info_noqr nopd" style="height: 23vh;border-bottom: 0px;">
		<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopd">
			<div class="content_product_send">
				<div class="table_prin_noqr">
					
					<table class="table table-bordered">
						<thead>
							<tr class="day_ra_1_dong">
								<td class="text-center"><strong>SẢN PHẨM</strong></td>
								<td class="text-center"><strong>SỐ LƯỢNG</strong></td>
								<td class="text-center"><strong>ĐƠN GIÁ</strong></td>
								<td class="text-center"><strong>TỔNG TIỀN</strong></td>
							</tr>
						</thead>
						<tbody>
							<!-- BEGIN: product -->
							<tr>
								<td colspan="1" class="text-left">
									{PRODUCT.stt}. {PRODUCT.name_product}
								</td>
								
								<td colspan="1" class="text-center">
									{PRODUCT.quantity}
								</td>
								<td colspan="1" class="text-right">
									{PRODUCT.price}
								</td>
								<td colspan="1" class="text-right">
									{PRODUCT.total}
								</td>
							</tr>
							<!-- END: product -->
						</tbody>

					</table>
					

				</div>
				<div class="info_extend">
					<p>
						Nhà vận chuyển: {DATA.transporters_name}
					</p>
					<p>
						Tổng tiền hàng: {DATA.total_product} VND
					</p>
					<p>
						Phí vận chuyển: {DATA.fee_transport} VND
					</p>
					<p>
						Số tiền cần thanh toán: {DATA.total} VND
					</p>
					
				</div>
			</div>
			
		</div>
	</div>

</div>
<!-- END: main -->