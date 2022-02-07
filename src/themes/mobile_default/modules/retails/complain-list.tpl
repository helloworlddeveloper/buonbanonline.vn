<!-- BEGIN: main -->
<!-- BEGIN: view -->

<div class="well">
<form method="POST">
    <div class="row mt-3">
		<div class="col-12">
            <div class="form-group m-2">
                <select class="form-control" name="status_complain">
					<option value=""> -- Chọn trạng thái --</option>
					<!-- BEGIN: status_complain -->
					<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
					<!-- END: status_complain -->
				</select>
            </div>
        </div>
		<div class="col-9">
            <div class="form-group m-2">
                <input class="form-control" type="text" value="{search.q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
            </div>
        </div>
        <div class="col-3 text-center" style="line-height: 40px;">
            <div class="form-group m-0">
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
		
		<!-- BEGIN: loop -->
		<div class="row mb-3 bg_white m-2 p-2 rounded">
			
			<div class="col-6"><a class="font-weight-bold" href="{VIEW.link_view_order}" title="Thông tin đơn hàng">{VIEW.order_code}</a> </div>
			<div class="col-6 text-right">{VIEW.time_edit} </div>
			<div class="col-8 mt-3">{VIEW.product_id}</div>
			<div class="col-4 mt-3 text-right"><a class="secondary_text" href="{VIEW.link_edit}">Xem chi tiết</a></div>
			<div class="col-5 d-flex align-items-center mt-3">Xử lý: </div>
			<div class="col-7 mt-3 text-right">
				<!-- BEGIN: status_next -->
						<a class="btn btn_ecng" href="#" title="{VIEW.status_next}" onclick="status_next({complain_id});">{title_status}</a> 
						<!-- END: status_next -->
						
						
						<!-- BEGIN: vandon -->
						<a class="btn btn_ecng" href="{link_vandon}" title="{VIEW.status_next}">   {title_status}</a> 
						<!-- END: vandon -->
						
						<!-- BEGIN: await -->
						Đang chờ xử lý
						<!-- END: await -->
				
			</div>
			<div class="col-3 mt-3">Trạng thái: </div>
			<div class="col-9 mt-3 text-right">{VIEW.status}</div>
			
		</div>
		<!-- END: loop -->
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