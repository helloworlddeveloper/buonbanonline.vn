<!-- BEGIN: main -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>print</title>
	<meta http-equiv="Content-Language" content="vi" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	Đơn hàng {DATA.order_code} đã được đặt thành công! (Mẫu 4)
</body>
</html>
<div>
Thông tin cửa hàng
</div>
<div>
Tên cửa hàng: {SHOP.company_name}
</div>
<div>
<img src={SHOP.avatar_image} style="height: 70px;width:70px;"/>
</div>
<div>
Thông tin khách
</div>
<div>
{info_order.order_name}
</div>
<div>
{info_order.address}
</div>
<div>
Thông tin cửa hàng
</div>
<!-- BEGIN: data_product -->
<table class="rows" style="width:100%;border:1px solid #F5F5F5;">
	<tr class="bgtop" style="background:#CCCCCC;line-height:22px;">
		<td align="center" width="30px" style="padding:5px"> 
			{LANG.order_no_products}
		</td>
		<td class="prd" style="padding:5px"> 
			Hình
		</td>
		<td class="prd" style="padding:5px"> 
			Tên sản phẩm
		</td>
		<td class="prd" style="padding:5px"> 
			Thuộc tính
		</td>
		<td class="price" align="right" style="padding:5px"> 
			Giá sản phẩm
		</td>
		<td class="amount" align="center" width="60px" style="padding:5px"> 
			Số lượng sản phẩm 
		</td>
		<td class="unit" width="60" style="padding:5px">
			Thành tiền
		</td>
	</tr>
	<tbody>
		<!-- BEGIN: loop -->
		<tr {bg}> 
			<td align="center" style="padding:5px">
				{pro_no} 
			</td>
			<td class="prd" style="padding:5px"> 
			<img src="{image}" style="height: 70px;width:70px;"/>
				 
			</td>
			<td class="prd" style="padding:5px"> 
				{product_name} 
			</td>
			<td class="prd" style="padding:5px"> 
				{name_group} 
			</td>
			<td class="money" align="right" style="padding:5px">
				<strong>
					{product_price}
				</strong>
			</td>
			<td class="amount" align="center" style="padding:5px"> 
				{product_number}
			</td>
			<td class="unit" style="padding:5px"> 
				{product_total} 
			</td>
		</tr>
		<!-- END: loop -->
	</tbody>
</table>
<table class="rows" style="margin-top:2px;width:100%;border:1px solid #F5F5F5;">
	<tr>
		<td valign="top" style="padding:5px">
			<span style="font-style:italic;"> 
				Ghi chú đơn hàng : {info_order.note} 
			</span>
		</td>
		<td valign="top" style="padding:5px">
			<span style="font-style:italic;">
				Tổng tiền hàng : {info_order.total_product} 
			</span>
		</td>
		<td valign="top" style="padding:5px">
			<span style="font-style:italic;"> 
				Tổng phí vận chuyển : {info_order.fee_transport} 
			</span>
		</td>
		<td align="right" valign="top" style="padding:5px">
			Tổng cộng: 
			<strong id="total">
				{info_order.total}
			</strong> 
			{unit} 
		</td>
	</tr>
</table>
<!-- END: data_product -->
<!-- END: main -->