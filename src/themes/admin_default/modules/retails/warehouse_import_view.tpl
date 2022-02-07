<!-- BEGIN: main -->
<div class="col-sm-24  col-md-24  col-lg-24">
    <div class="col-sm-24  col-md-24  col-lg-6">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" style="width:130px">Mã nhập kho:</span>
                <span class="form-control disabled" style="min-width:200px">{ROW.warehouse_product_import_code}</span>
            </div>
        </div>
	 </div>	
	 <div class="col-sm-24  col-md-24  col-lg-6">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" style="width:130px">Thông tin kho hàng:</span>
                <span class="form-control disabled" style="min-width:200px">{ROW.name_warehouse}</span>
            </div>
        </div>
	 </div>	
	 <div class="col-sm-24  col-md-24  col-lg-6">
		 <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" style="width:130px">Thời gian thêm</span>
                <span class="form-control disabled" style="min-width:200px">{ROW.time_add}</span>
            </div>
        </div>
	</div>
	<div class="col-sm-24  col-md-24  col-lg-6">
		 <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" style="width:130px">Người thêm:</span>
                <span class="form-control disabled" style="min-width:200px">{ROW.user_add}</span>
            </div>
        </div>
	</div>
</div>
<div class="controls table-controls">
	<table id="poTable" class="table items table-striped table-bordered table-condensed table-hover sortable_table">
		<thead>
			<tr>
				<td colspan="5" style="background: #3ea00b;color: #fff;text-transform: uppercase;text-align:center;font-size:17px">
                   <strong>
                        {LANG.info_product}
                   </strong>
                </td>
			</tr>
			<tr>
				<th class="text-center">STT</a></th>
				<th class="text-center">Tên sản phẩm</th>
				<th class="text-center">Giá nhập (chưa quy đổi)</th>
				<th class="text-center">Giá nhập (Đã quy đổi)</th>	
				<th class="text-center">Số lượng</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: product -->
			<tr class="text-center">
				<td>{key_list}</td>
				<td>{info_product.name_product}</td>
				<td>{info_product.price}</td>
				<td>{info_product.price_exchange}</td>
				<td>{info_product.amount}</td>
			</tr>
			<!-- END: product -->
		</tbody>
		<tfoot>	
			<tr>
				<td colspan="3" class="text-right" style="font-size:15px; font-weight:bold">Tổng cộng </td>
				<td class="text-center" style="color:red; font-weight:bold">{total_price_exchange}</td>
				<td class="text-center" style="color:red; font-weight:bold">{total_amount}</td>
			</tr>
		</tfoot>
	</table>
</div>	
<!-- END: main -->