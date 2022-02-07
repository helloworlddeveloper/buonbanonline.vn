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
		background:red
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
	.header_prin_info{
		border-bottom: dashed 1px #000;
	}
	.header_prin_info{
		display: grid;
		padding: 10px;
	}
	.header_prin_info_final{
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
		margin-bottom: 7px;
		height: 15vh;
		overflow: hidden;
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
	.font_weight{
		font-weight: 600;
	}
	@page{
		margin: 2px;
	}
</style>
<div class="container" style="height: 99vh; border: solid 2px #000; margin: auto;">
	<div class="header_prin_info" style="height: 23vh;">
		<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopd">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopd">
				<div class="wrap_img_logo_diwali">
					<img src="{NV_BASE_SITEURL}uploads/logo_tms.png">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopd">
				<div class="wrap_img_logo_diwali_qr">
					<img src="data:image/png;base64,{DATA.barecode}" alt="{DATA.shipping_code}" class="bcimg">
				</div>
			</div>
		</div>
		<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopd">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 nopd">
				<div class="wrap_img_logo_buu_dien">
					<img src="{DATA.logo}">
				</div>
			</div>
			<div class="col-xs-16 col-sm-16 col-md-16 col-lg-16 nopd">
				<div class="info_ma_van_don">
					<p class="ma_van_don">
						<span>
							Mã vận đơn:
						</span>
						<span>
							{DATA.shipping_code}
						</span>
					</p>
					<p class="ma_van_don">
						<span>
							Đơn vị vận chuyển
						</span>
						<span>
							{DATA.transporters_name}
						</span>
					</p>
					<p class="ma_van_don">
						<span>
							Mã đơn hàng:
						</span>
						<span>
							{DATA.invoice_prefix}
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="header_prin_info" style="height: 23vh;">
		<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopd">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopd">
				<p class="from_people">
					Từ:
				</p>
				<p class="name_people_send">
					{INFO_SHOP.name_send}
				</p>

				<p class="address_people_send">
					<span>{INFO_SHOP.address}</span>
				</p>
				
				<p class="sdt_people_send">
					{INFO_SHOP.phone_send}
				</p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 nopd font_weight_text">
				<p class="from_people">
					Đến
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
	<div class="header_prin_info nopd" style="height: 23vh;">
		<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopd">
			<div class="col-xs-19 col-sm-19 col-md-19 col-lg-19 them_pd">
				<div class="content_product_send">
					<p class="font_weight">Nội dung hàng: (SL: {DATA.total_product} )</p>
					<!-- BEGIN: product -->
					<p>
						<span class="product_tychinh">
							{PRODUCT.STT}.{PRODUCT.name_product}
						</span>
						<span class="product_tychinh">
							, SL:{PRODUCT.quantity}
						</span>
					</p>
					<!-- END: product -->

					
				</div>
				<div class="content_product_send1">
					<p style="text-overflow: ellipsis;width: 100%;white-space: nowrap;
					overflow: hidden;">
					Một số sản phẩm có thể bị ẩn do danh sách quá dài
				</p>
			</div>
		</div>
		<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 nopd" style="height: 100%;">
			<div class="img_qr">
			<img src="data:image/png;base64,{DATA.barecode_1}" alt="{DISTRICT1}" class="bcimg">
				
			</div>
		</div>
	</div>
</div>
<div class="header_prin_info_final " style="height: 30vh;">
	<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<p>
				Tiền thu người nhận
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<p>
				Khối lượng tối đa: {DATA.total_weight}g.
			</p>
		</div>
	</div>
	<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<p class="tien_hang_can_lay">
				{DATA.total} VND
			</p>
			<p class="cach_ra">
				Chỉ dẫn giao hàng
			</p>
			<p class="cach_ra">
				- Chuyển hoàn sau 3 lần phát
			</p>
			<p class="cach_ra">
				- Lưu kho tối đa 5 ngày
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="chu_ky_print">
				<p class="chu_ky_print1">Chữ ký người nhận</p>
				<p class="chu_ky_print2">
					Xác nhận hàng nguyên vẹn không móp méo, bể/vỡ.
				</p>
			</div>
		</div>
	</div>
</div>
</div>
<!-- END: main -->