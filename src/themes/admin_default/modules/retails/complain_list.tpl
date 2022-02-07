<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="well">
<form method="POST">
    <div class="row">
        <div class="col-xs-24 col-md-6">
            <div class="form-group">
                <input class="form-control" type="text" value="{search.q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
            </div>
        </div>
		<div class="col-xs-24 col-md-6">
            <div class="form-group">
                <select class="form-control" name="status_complain">
					<option value=""> -- Chọn trạng thái --</option>
					<!-- BEGIN: status_complain -->
					<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
					<!-- END: status_complain -->
				</select>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
            </div>
        </div>
    </div>
</form>
</div>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
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
                    <td> <a href="{VIEW.link_view_order}" title="Thông tin đơn hàng">{VIEW.order_id}</a> </td>
                    <td> {VIEW.product_id} </td>
                    <td class="text-center"> {VIEW.status} </td>
                    <td class="text-center"> 
						<!-- BEGIN: status_next -->
						<a class="btn btn-primary" href="#" title="{VIEW.status_next}" onclick="status_next({complain_id});"> {title_status}</a> 
						<!-- END: status_next -->
					</td>
                    <td class="text-center"> {VIEW.time_edit} </td>
                    <td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}#edit">Xem</a> - <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></td>
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
			$.ajax({               
				type: "POST",      
				dataType: 'json',  
				url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=complain_list',
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

</script>

<!-- END: main -->