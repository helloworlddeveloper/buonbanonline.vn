<!-- BEGIN: main -->
<!-- BEGIN: view -->

<div class="well">
<form method="POST">
    <div class="row">
        <div class="col-xs-5 col-md-5">
            <div class="form-group">
                <input class="form-control" type="text" value="{search.q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
            </div>
        </div>
		<div class="col-xs-5 col-md-5">
            <div class="form-group">
                <select class="form-control" name="status_complain">
					<option value=""> -- Chọn trạng thái --</option>
					<!-- BEGIN: status_complain -->
					<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
					<!-- END: status_complain -->
				</select>
            </div>
        </div>
        <div class="col-xs-2 col-md-2">
            <div class="form-group text-center">
                <input class="btn btn_ecng" type="submit" value="{LANG.search_submit}" />
            </div>
        </div>
    </div>
</form>
</div>

<!-- BEGIN: no_data -->
		Không tìm thấy khiếu nại!
<!-- END: no_data -->

<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w100">{LANG.number}</th>
                    <th>{LANG.order_id}</th>
                    <th>{LANG.product_id}</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Xử lý</th>
                    <th class="text-center">Ngày</th>
                    <th class="w150">&nbsp;</th>
				</tr>
			</thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="4">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td> {VIEW.number} </td>
                    <td> <a href="{VIEW.link_view_order}" title="Thông tin đơn hàng">{VIEW.order_code}</a> </td>
                    <td> {VIEW.product_id} </td>
                    <td class="text-center"> {VIEW.status} </td>
                    <td class="text-center"> 
						<!-- BEGIN: status_next -->
						<a class="btn btn-primary" href="#" title="{VIEW.status_next}" onclick="status_next({complain_id});"> {title_status}</a> 
						<!-- END: status_next -->
						
						
						<!-- BEGIN: vandon -->
						<a class="btn btn_ecng" href="{link_vandon}" title="{VIEW.status_next}"> {title_status}</a> 
						<!-- END: vandon -->
						
						<!-- BEGIN: await -->
						Đang chờ xử lý
						<!-- END: await -->
					</td>
                    <td class="text-center"> {VIEW.time_edit} </td>
                    <td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}">Xem</a></td>
				</tr>
                <!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->


<script>
	
	function status_next(complain_id)
	{
		
		var r = confirm("Bạn đã chắc chắn chưa?!");
		if (r == true) {
			$.ajax({               
				type: "POST",      
				dataType: 'json',  
				url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=complain',
				data: {complain_id_ajax : complain_id},
				success: function(json) {
					if( json['status'] == 'OK' )
					{              
						alert('Cập nhật trạng thái thành công!');
						location.reload();
					} 
					else
					{alert('Cập nhật trạng thái thất bại!');}
					
				},                 
				error: function(xhr, ajaxOptions, thrownError) {
					
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}                  
			}); 
		} 
		
		
	}
	
</script>

<!-- END: main -->