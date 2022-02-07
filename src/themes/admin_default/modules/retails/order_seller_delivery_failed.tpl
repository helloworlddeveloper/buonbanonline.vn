<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="well">
	<form action="{NV_BASE_ADMINURL}index.php" method="get">
		<input type="hidden" name="{NV_LANG_VARIABLE}"  value="{NV_LANG_DATA}" />
		<input type="hidden" name="{NV_NAME_VARIABLE}"  value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}"  value="{OP}" />
		<div class="row">
			<div class="col-xs-24 col-md-6">
				<div class="form-group">
					<input class="form-control" type="text" value="{Q}" name="q" maxlength="255" placeholder="Nhập mã đơn hàng" />
				</div>
			</div>
			<div class="col-xs-12 col-md-3">
				<div class="form-group">
					<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
				</div>
			</div>
		</div>
	</form>
	<ul class="nav nav-tabs" style="border:0">
		<li class="active"><a data-toggle="tab" href="#menu1">Chờ xử lý</a></li>
		<li><a data-toggle="tab" href="#menu2">Đã xử lý xong</a></li>
	</ul>
</div>
<div class="tab-content">
    <div id="menu1" style="margin-top:20px" class="tab-pane fade in active">
		<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<div class="table-responsive">
				<table class="table table-condensed">
					<thead>
						<tr style="background:#DADADA">
							
							<th>{LANG.order_code}</th>
							<th>{LANG.time_add}</th>
							<th>{LANG.complain_deadline}(48h)</th>
							<th>Lý do khiếu nại</th>
							<th class="w100 text-center">Thao tác</th>
							<th class="w150">&nbsp;</th>
						</tr>
					</thead>
					<!-- BEGIN: generate_page -->
					<tfoot>
						<tr>
							<td class="text-center" colspan="7">{NV_GENERATE_PAGE}</td>
						</tr>
					</tfoot>
					<!-- END: generate_page -->
					<tbody>
						<!-- BEGIN: loop -->
						<tr class="{COLOR}">
							<td> <a href="{VIEW.link_view}" target="_blank">{VIEW.order_code}</a> </td>
							<td> {VIEW.time_add} </td>
							<td> {VIEW.real_time_h}giờ:{VIEW.real_time_m}phút </td>
							<th >{VIEW.reason}</th>
							<td class="text-center" style="width:180px">	
								<a class="btn_ecng" href="{VIEW.link_renew_order}">Giao lại đơn hàng</a>
								</br>
								<a class="btn_ecng" type="button" href="{VIEW.link_delivery_failed_order}">Giao hàng thất bại</a>
							</td>
							
							<td class="text-center">
								<a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a>
							</td>
						</tr>
						<!-- END: loop -->
					</tbody>
				</table>
			</div>
		</form>
		
	</div>
    <div id="menu2" style="margin-top:20px" class="tab-pane fade">
		
		<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<div class="table-responsive">
				<table class="table table-condensed">
					<thead>
						<tr style="background:#DADADA">
							
							
							<th>{LANG.order_code}</th>
							<th>{LANG.time_add}</th>
							<th>{LANG.complain_deadline}(48h)</th>
							<th class="w100 text-center">Trạng thái</th>
							<th class="w150">&nbsp;</th>
						</tr>
					</thead>
					<!-- BEGIN: generate_page -->
					<tfoot>
						<tr>
							<td class="text-center" colspan="7">{NV_GENERATE_PAGE}</td>
						</tr>
					</tfoot>
					<!-- END: generate_page -->
					<tbody>
						
						<!-- BEGIN: loop1 -->
						<tr class="{COLOR}">
							<td> <a href="{VIEW.link_view}" target="_blank">{VIEW.order_code}</a> </td>
							<td> {VIEW.time_add} </td>
							<td> {VIEW.real_time_h}giờ:{VIEW.real_time_m}phút</td>
							<td class="text-center" style="width:180px">
								<button class="btn_gray" type="button" >Đã xử lý</button>
							</td>
							<td><a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></td>
							
						</tr>
						<!-- END: loop1 -->
					</tbody>
				</table>
			</div>
		</form>
		
		
	</div>
    
</div>
<!-- END: view -->

<!-- END: main -->