<!-- BEGIN: main -->

<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="w100 text-center">{LANG.number}</th>
					<th class="text-center" style="vertical-align:middle">{LANG.order_code}</th>
					<th class="text-center" style="vertical-align:middle">{LANG.store_id}</th>
					
					<th class="text-center" style="vertical-align:middle">{LANG.order_name}</th>
					<th class="text-center" style="vertical-align:middle">Số điện thoại người mua</th>
					
					<th class="text-center" style="vertical-align:middle">{LANG.total_product}</th>
					<th class="text-center" style="vertical-align:middle">{LANG.fee_transport}</th>
					<th class="text-center" style="vertical-align:middle">{LANG.total}</th>
					<th class="text-center" style="vertical-align:middle">Số tiền đã thanh toán</th>
					<th class="text-center" style="vertical-align:middle">Thanh toán</th>
					<th class="text-center" style="vertical-align:middle">Thời gian tạo đơn hàng</th>
					<th class="w150">&nbsp;</th>
				</tr>
			</thead>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td class="text-center" colspan="16">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
			<tbody>
				<!-- BEGIN: loop -->
				<tr class="text-center">
					<td> {VIEW.number} </td>
					<td> {VIEW.order_code} </td>
					<td> {VIEW.store_name} </td>
					<td> {VIEW.order_name} </td>
					<td> {VIEW.phone} </td>
					<td> {VIEW.total_product} </td>
					<td> {VIEW.fee_transport} </td>
					<td> {VIEW.total} </td>
					<td> {VIEW.payment} </td>
					<td> {VIEW.thanhtoan} </td>
					<td> {VIEW.time_add} </td>
					<td class="text-center">
						<div><a href="{VIEW.link_view}">{LANG.view}</a></div>
						
						<div><a href="{VIEW.link_phat}">Phạt</a></div> 
						
						<!-- BEGIN: status0 -->
						<p><button class="btn btn-primary" type="button" onclick="change_status({VIEW.id},1,{VIEW.status})">{LANG.change_order0}</button></p>
						<!-- END: status0 -->
						<!-- BEGIN: print_shipping_code -->
						
						
						<span class="wrap_admin_button ">
							<button type="button" style="margin: 3px;padding: 3px" id="button-invoice_vnpost_{VIEW.id}" data-loading-text="Đang nạp..." data-toggle="tooltip" title="In phiếu bán hàng" class="admin_button btn btn-primary">
								In phiếu vận chuyển
							</button>
						</span>
						
						<script type="text/javascript">
							$(document).delegate('#button-invoice_vnpost_{VIEW.id}', 'click', function() {
								var printWindow = window.open( script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order_print&action=createinvoiceno&order_id={VIEW.id}&nocache=' + new Date().getTime(), 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
								printWindow.addEventListener('load', function(){
									printWindow.print();
								}, true);
								
							});
						</script>
						<!-- END: print_shipping_code -->
						<!-- BEGIN: status_cancel -->
						<p>
							<button class="btn btn-primary" type="button" onclick="change_status_cancel({VIEW.id})">
								Hủy đơn
							</button>
						</p>
						<!-- END: status_cancel -->
						
						
						<!-- BEGIN: hoantien -->
						<button onclick="order_hoantien({VIEW.id})" type="button" class="btn btn-primary">Hoàn tiền</button>
						<!-- END: hoantien -->
						
						
						<!-- BEGIN: vnpost_cancel -->
						<button onclick="vnpost_cancel({VIEW.id})" type="button" class="btn btn-primary">Hủy giao hàng VNPOST</button>
						<!-- END: vnpost_cancel -->
						
						<!-- BEGIN: vnpost -->
						<button onclick="popup_vanchuyen({VIEW.id},{VIEW.store_id},{VIEW.transporters_id})" type="button" class="btn btn-primary">Gửi hàng VNPOST</button>
						<!-- END: vnpost -->
						
						<!-- BEGIN: ghn -->
						<button onclick="popup_vanchuyen({VIEW.id},{VIEW.store_id},{VIEW.transporters_id})" type="button" class="btn_ecng">Gởi hàng GHN</button>
						<!-- END: ghn -->
						<!-- BEGIN: ghn_cancel -->
						<button onclick="ghn_cancel({VIEW.id},{VIEW.store_id})" type="button" class="btn_ecng mr-2">Hủy đơn GHN</button>
						<!-- END: ghn_cancel -->
						
						<!-- BEGIN: vnpost_reupload -->
						<button onclick="view_popup_vanchuyen({VIEW.id},{VIEW.store_id})" type="button" class="btn btn-primary">Check cước VNPOST</button>
						
						<button onclick="popup_vanchuyen({VIEW.id},{VIEW.store_id})" type="button" class="btn btn-primary">Gởi lại VNPOST</button>
						<!-- END: vnpost_reupload -->
						
						<!-- BEGIN: tu_giao_xac_nhan_dang_giao -->
						<button onclick="shipping({VIEW.id})" type="button" class="btn_ecng" style="padding: 5px 10px;">Xác nhận giao hàng</button>
						<!-- END: tu_giao_xac_nhan_dang_giao -->
						<!-- BEGIN: tu_giao_xac_nhan_da_giao -->
						<button onclick="delivered({VIEW.id})" type="button" class="btn_ecng" style="padding: 5px 10px;">Giao hàng thành công</button>
						<!-- END: tu_giao_xac_nhan_da_giao -->
						<p>
							<span class="wrap_admin_button ">
								<button type="button" style="margin: 3px;padding: 3px" id="button-invoice_{VIEW.id}" data-loading-text="Đang nạp..." data-toggle="tooltip" title="In phiếu bán hàng" class="admin_button btn btn-primary">
									In phiếu bán hàng
								</button>
							</span>
						</p>
						<script type="text/javascript">
							$(document).delegate('#button-invoice_{VIEW.id}', 'click', function() {
								var printWindow = window.open( script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order_print_noqr&action=createinvoiceno&order_id={VIEW.id}&nocache=' + new Date().getTime(), 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
								printWindow.addEventListener('load', function(){
									printWindow.print();
								}, true);
								
							});
						</script>
					</td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>

<div class="modal fade" id="idmodals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			
		</div>
	</div>
</div>

<!-- END: main -->
