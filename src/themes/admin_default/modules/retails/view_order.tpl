<!-- BEGIN: main -->
<div id="productcontent">
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" style="float:left">
                    <i class="fa fa-list"></i>
                    THÔNG TIN ĐƠN HÀNG
				</h3>
				
                <div style="clear:both"></div>
			</div>
		</div>
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading  no-print">
                        <h3 class="panel-title">
                            <i class="fa fa-user fa-fw"></i> 
                            Thông tin người bán hàng
						</h3>
					</div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 1%;">
                                    <button data-toggle="tooltip" title=""
                                    class="btn btn-info btn-xs" data-original-title="Cửa hàng">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									{info_store.company_name}
								</td>
							</tr>
							<tr>
								<td style="width: 1%;">
									<button data-toggle="tooltip" title=""
									class="btn btn-info btn-xs" data-original-title="Họ và tên người đại diện">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									{info_store.name}
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Số điện thoại người đại diện">
										<i
										class="fa fa-phone fa-fw"></i>
									</button>
								</td>
								<td>
									{info_store.phone}
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Địa chỉ email">
										<i class="fa fa-envelope-o"></i>
									</button>
								</td>
								<td>
									{info_store.email}
								</td>
							</tr>
						</tbody>
						
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading  no-print">
						<h3 class="panel-title">
							<i class="fa fa-user fa-fw"></i> 
							Thông tin kho hàng gởi
						</h3>
					</div>
					<table class="table">
						<tbody>
							<tr>
								<td style="width: 1%;">
									<button data-toggle="tooltip" title=""
									class="btn btn-info btn-xs" data-original-title="Kho hàng">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									{info_warehouse.name_warehouse}
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Thông tin người gởi">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									{info_warehouse.name_send}
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Số điện thoại người gởi">
										<i
										class="fa fa-phone fa-fw"></i>
									</button>
								</td>
								<td>
									{info_warehouse.phone_send}
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Địa chỉ lấy hàng">
										<i
										class="fa fa-address-book-o"></i>
									</button>
								</td>
								<td>
									{info_warehouse.address}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading  no-print">
						<h3 class="panel-title">
							<i class="fa fa-user fa-fw"></i>
							Thông tin khách hàng
						</h3>
					</div>
					<table class="table">
						<tbody>
							<tr>
								<td style="width: 1%;">
									<button data-toggle="tooltip" title=""
									class="btn btn-info btn-xs" data-original-title="Tên khách hàng">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									{info_order.order_name}
								</td>
							</tr>
							
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Số điện thoại khách hàng">
										<i
										class="fa fa-phone fa-fw"></i>
									</button>
								</td>
								<td>
									{info_order.phone}
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Email khách hàng">
										<i class="fa fa-envelope-o"></i>
									</button>
								</td>
								<td>
									{info_order.email}
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Địa chỉ khách hàng">
										<i
										class="fa fa-address-book-o"></i>
									</button>
								</td>
								<td>
									{DIACHI}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading  no-print">
						<h3 class="panel-title">
							<i class="fa fa-user fa-fw"></i> 
							Thông tin khác
						</h3>
					</div>
					<table class="table">
						<tbody>
							<tr>
								<td style="width: 1%;">
									<button data-toggle="tooltip" title=""
									class="btn btn-info btn-xs" data-original-title="Phương thức thanh toán">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									Trạng thái đơn hàng: 
									<span class="to_mau">
										{info_order.status}
									</span>
								</td>
							</tr>
							<tr>
								<td style="width: 1%;">
									<button data-toggle="tooltip" title=""
									class="btn btn-info btn-xs" data-original-title="Phương thức thanh toán">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									Phương thức thanh toán: 
									<span class="to_mau">
										{info_order.payment_method}
									</span>
								</td>
							</tr>
							
							
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Tổng cộng">
										
										<i
										class="fa fa-address-book-o"></i>
									</button>
								</td>
								<td>
									Tổng tiền: 
									<span class="price_final">
										{info_order.total}
									</span>
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Tổng cộng">
										<i
										class="fa fa-address-book-o"></i>
									</button>
								</td>
								<td>
									Voucher: 
									<span class="price_final">
										{info_order.voucher_price}
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading  no-print">
						<h3 class="panel-title">
							<i class="fa fa-user fa-fw"></i> 
							Thông tin vận chuyển
						</h3>
					</div>
					<table class="table">
						<tbody>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Nhà vận chuyển">
										<i
										class="fa fa-user fa-fw"></i>
									</button>
								</td>
								<td>
									Nhà vận chuyển: 
									<span class="to_mau">
										{info_order.transporters_name}
									</span>
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Mã vận chuyển">
										<i
										class="fa fa-address-book-o"></i>
									</button>
								</td>
								<td>
									Mã vận chuyển:  
									<span class="to_mau">{info_order.shipping_code}
									</span>
								</td>
							</tr>
							<tr>
								<td>
									<button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
									data-original-title="Phí vận chuyển">
										<i
										class="fa fa-address-book-o"></i>
									</button>
								</td>
								<td>
									Phí vận chuyển:  
									<span class="to_mau">
										{info_order.fee_transport}
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title" style="float:left">
				<i class="fa fa-list"></i> 
				THÔNG TIN SẢN PHẨM
			</h3>
			
			<div style="clear:both"></div>
		</div>
	</div>
	<!-- BEGIN: view -->
	<form
	action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}"
	method="post">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="w100 text-center">
							{LANG.number}
						</th>
						<th class="text-center">
							Tên sản phẩm
						</th>
						<th class="text-center">
							Mã sản phẩm
						</th>
						<th class="text-center">
							Số lượng
						</th>
						<th class="text-center">
							Đơn giá
						</th>
						<th class="text-center">
							Tổng tiền
						</th>
						
					</tr>
				</thead>
				<!-- BEGIN: generate_page -->
				<tfoot>
					<tr>
						<td class="text-center" colspan="12">
							{NV_GENERATE_PAGE}
						</td>
					</tr>
				</tfoot>
				<!-- END: generate_page -->
				<tbody>
					<!-- BEGIN: loop -->
					<tr class="text-center">
						<td> 
							{VIEW.number} 
						</td>
						<td> 
							{VIEW.name_product} 
						</td>
						<td> 
							{VIEW.barcode} 
						</td>
						<td> 
							{VIEW.quantity} 
						</td>
						<td> 
							{VIEW.price} 
						</td>
						<td> 
							{VIEW.total} 
						</td>
						
					</tr>
					
					<!-- END: loop -->
					
				</tbody>
			</table>
		</div>
	</form>
	
	<!-- END: view -->
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title" style="float:left">
				<i class="fa fa-list"></i>
				Lịch sử chuyển trạng thái đơn hàng
			</h3>
			
			<div style="clear:both">
				
			</div>
		</div>
	</div>
	<form
	action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}"
	method="post">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="w100 text-center">
							{LANG.number}
						</th>
						<th class="text-center">
							Người chuyển
						</th>
						<th class="text-center">
							Nội dung
						</th>
						<th class="text-center">
							Thời gian chuyển
						</th>
						
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN: logs_order -->
					<tr class="text-center">
						<td> 
							{LOOP_LOGS.number} 
						</td>
						<td>
							{LOOP_LOGS.user_add} 
						</td>
						<td> 
							{LOOP_LOGS.content} 
						</td>
						<td> 
							{LOOP_LOGS.time_add} 
						</td>
						
					</tr>
					
					<!-- END: logs_order -->
					
				</tbody>
			</table>
		</div>
	</form>	
	
	
	
	<div class="row">
		<div class="col-sm-8">
			<ul class="timeline">
				<!-- BEGIN: post -->
					<li>
					<span class="secondary_text">{post.addtime}:</span>
					
					<span>{post.status_vnpost} </span>
					</li>
				<!-- END: post -->
				<!-- BEGIN: ghn -->
				<li>
					<span class="secondary_text">{LOOP_GHN.status_ghn}</span>
					<span style="float: right;">{LOOP_GHN.time_add}</span>
					<p style="margin-top: 15px;">{LOOP_GHN.warehouse} {LOOP_GHN.status_error_ghn}</p>
				</li>
				<!-- END: ghn -->
			</ul>
		</div>
	</div>
	
</div>

<!-- END: main -->