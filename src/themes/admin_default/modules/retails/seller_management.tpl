<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="panel panel-default">
	<div class="panel-heading">
        <h3 class="panel-title" style="float:left">
            <i class="fa fa-list"></i> 
            {LANG.seller_management}
		</h3> 
        <div class="pull-right">
			<button title="Ẩn /Hiện tìm kiếm"id="tms_sea_id" data-toggle="tooltip" data-placement="top"class="btn btn-success btn-sm">
				<i class="fa fa-search" aria-hidden="true"></i>
			</button> 
			<a href="{seller_management_add}" data-toggle="tooltip" data-placement="top" title="{LANG.seller_management_add}" class="btn btn-success btn-sm">
				<i class="fa fa-plus-circle" aria-hidden="true"></i>
			</a>
		</div>
		<div style="clear:both"></div>
	</div>
	<div class="well" id="tms_sea">
		<form action="{NV_BASE_ADMINURL}index.php" id="formsearch" method="get">
			<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
			<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
			<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
			<div class="row">
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								Tìm kiếm nhanh
							</span>
							<select class="form-control link_flast" id="sea_flast" name="sea_flast">
								<option value="0">
									-- Chọn thời gian --
								</option>
								<option value="1" {SELECT1}>Ngày hôm nay</option>
								<option value="2" {SELECT2}>Ngày hôm qua</option>
								<option value="3" {SELECT3}>Tuần này</option>
								<option value="4" {SELECT4}>Tuần trước</option>
								<option value="5" {SELECT5}>Tháng này</option>
								<option value="6" {SELECT6}>Tháng trước</option>
								<option value="7" {SELECT7}>Năm này</option>
								<option value="8" {SELECT8}>Năm trước</option>
								<option value="9" {SELECT9}>Toàn thời gian
								</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								hoặc {LANG.ngay_tu}
							</span>
							<input id="ngaytu" type="text" maxlength="255" class="form-control disabled" value="{ngay_tu}"
							name="ngay_tu" placeholder="{LANG.ngay_tu}">
						</div>
					</div>
					
				</div>
				
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								{LANG.ngay_den}
							</span>
							<input id="ngayden" type="text" maxlength="255" class="form-control disabled" value="{ngay_den}"
							name="ngay_den" placeholder="{LANG.ngay_den}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-6">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								Ngân hàng
							</span>
							<select class="form-control bank_id" name="bank_id"></select>
						</div>
					</div>
				</div>
				
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-6">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								Trạng thái
							</span>
							<select id="status_search" name="status_search" class="form-control input-sm">
								<!-- BEGIN: status_filt -->
								<option value="{status_filt.id}" {status_filt.selected}>
									{status_filt.text}
								</option>
								<!-- END: status_filt -->
							</select>
						</div>
					</div>
				</div>
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<input class="form-control" type="text" value="{Q}" name="q" maxlength="255"
						placeholder="Tên doanh nghiệp, số điện thoại người đại diện, mã số thuế, email người đại diện, tên người đại diện,..." />
					</div>
				</div>
				<div class="col-sm-24  col-md-24  col-lg-4">
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
						<button class="btn btn-primary export_file" type="button"  >
							Xuất file excel
						</button>
					</div>
					
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
                    <th class="w100 text-center" style="vertical-align:middle">
                        {LANG.weight}
					</th>
                    <th class="text-center" style="vertical-align:middle">
                        Tên đăng nhập
					</th>
                    <th class="text-center" style="vertical-align:middle">{LANG.company_name}
					</th>
                    <th class="text-center" style="vertical-align:middle">
                        Giấy phép kinh doanh
					</th>
                    <th class="text-center" style="vertical-align:middle"> 
                        Thông tin ngân hàng 
					</th>
                    <th class="text-center" style="vertical-align:middle"> 
                        Thông tin kho hàng 
					</th>
					<th class="text-center" style="vertical-align:middle"> 
						Tổng tiền đơn hàng
					</th>
					<th class="text-center" style="vertical-align:middle"> 
						Tổng tiền thanh toán cho người bán
					</th>
					<th class="text-center" style="vertical-align:middle"> 
						Tổng tiền đã thanh toán cho người bán
					</th>
					<th class="text-center" style="vertical-align:middle"> 
						Còn lại
					</th>
                    <th class="text-center" style="vertical-align:middle"> 
                        Yêu cầu kích hoạt
					</th>
					<th class="text-center" style="vertical-align:middle"> 
                        Shop nổi bật
					</th>
                    <th class="text-center" class="w100 text-center">
                        Kích hoạt
					</th>
                    <th class="w150">&nbsp;</th>
				</tr>
			</thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="24">
                        {NV_GENERATE_PAGE}
					</td>
				</tr>
			</tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr class="text-center">
                    <td style="vertical-align:middle">
                        <select class="form-control" id="id_weight_{VIEW.id}" onchange="nv_change_weight('{VIEW.id}');">
							<!-- BEGIN: weight_loop -->
							<option value="{WEIGHT.key}"{WEIGHT.selected}>
								{WEIGHT.title}
							</option>
							<!-- END: weight_loop -->
						</select>
					</td>
					<td style="vertical-align:middle"> 
						{VIEW.username} 
					</td>
					<td style="vertical-align:middle"> 
						<p>
							{VIEW.company_name} (Địa chỉ: {VIEW.address})
						</p>
						<p>
							Mã doanh nghiệp: {VIEW.company_code} 
						</p>
						<p>
							Họ tên người đại diện: {VIEW.name} 
						</p>
						<p>
							Số điện thoại người đại diện: {VIEW.phone} 
						</p>
						<p>
							Email người đại diện: {VIEW.email} 
						</p>
					</td>
					<td style="vertical-align:middle">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image_before_{VIEW.id}">
							Mặt trước
						</button>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image_after_{VIEW.id}">
							Mặt sau
						</button>
						<div id="image_before_{VIEW.id}" class="modal fade" role="dialog">
							<div class="modal-dialog" >
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">
											<p class="text-center" style="font-size:15px;font-weight:bold">
												Giấy phép kinh doanh mặt trước {VIEW.username}
											</p>
										</h4>
									</div>
									<div class="modal-body">
										<p>
											<img class="img-responsive text-center"  style="width:100%" src="{VIEW.image_before}" />
										</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Đóng
										</button>
									</div>
								</div>
								
							</div>
						</div>
						<div id="image_after_{VIEW.id}" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">
											<p class="text-center" style="font-size:15px;font-weight:bold">Giấy phép kinh doanh mặt sau {VIEW.username}
											</p>
										</h4>
									</div>
									<div class="modal-body">
										<p>
											<img class="img-responsive text-center"  style="width:100%" src="{VIEW.image_after}" />
										</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Đóng
										</button>
									</div>
								</div>
								
							</div>
						</div>
					</td>
					<td style="vertical-align:middle"> 
						<p>
							Ngân hàng: {VIEW.bank_id} ({VIEW.bank_code}) 
						</p>
						<p>
							Chi nhánh: {VIEW.branch_name} 
						</p>
						
						<p>
							Tên chủ thẻ:{VIEW.acount_name} 
						</p>
						<p>
							Số tài khoản: {VIEW.acount_number}  
						</p>
					</td>
					<td style="vertical-align:middle">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#warehouse_{VIEW.id}">
							Xem
						</button>
						<div id="warehouse_{VIEW.id}" class="modal fade" role="dialog">
							<div class="modal-dialog" style="width: 100%;max-width: 1200px">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">
											<p class="text-center" style="font-size:15px;font-weight:bold">Thông tin kho hàng của doanh nghiệp {VIEW.company_name}
											</p>
										</h4>
									</div>
									<div class="modal-body" id="form_detail_{VIEW.id}">
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
									</div>
								</div>
								
							</div>
						</div>
						
					</td>
					<td style="vertical-align:middle">{VIEW.total_order}</td>
					<td style="vertical-align:middle">{VIEW.total_order_discount}</td>
					<td style="vertical-align:middle">{VIEW.total_order_plus}</td>
					<td style="vertical-align:middle">{VIEW.remaining_order}</td>
					<td> 
						<!-- BEGIN: require -->
						<span class="red">
							{VIEW.reason}  
						</span>
						<span style="color: blue;">
							({VIEW.time_require})
						</span>
						<!-- END: require -->
						<!-- BEGIN: no_require -->
						
						<!-- END: no_require -->
					</td>
					<!-- check active shop hot  -->
					<td class="text-center">
						<input type="checkbox" name="seller_hot" id="change_seller_hot_{VIEW.id}" value="{VIEW.id}" {CHECK_SELLER_HOT} onclick="nv_change_seller_hot({VIEW.id});" />
					</td>
					<!-- check active shops -->
					<td class="text-center">
						<input type="checkbox" name="status" id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" />
					</td>
					<td class="text-center">
						<i class="fa fa-edit fa-lg">&nbsp;</i> 
						<a href="{VIEW.link_edit}#edit">
							{LANG.edit}
						</a>
					</td>
				</tr>
				<script>
					
					$('#form_detail_{VIEW.id}').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_warehouse&sell_id={VIEW.id}')
				</script>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->

<script type="text/javascript">
	
    $('.bank_id').select2({
        placeholder: "Mời bạn chọn ngân hàng",
        ajax: {
			url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
			'=ajax&mod=get_bank_search',
			dataType: 'json',
			delay: 250,
			data: function(params) {
				var query = {
					q: params.term
				}
				return query;
			},
			method: 'post',
			processResults: function(data) {
				return {
					results: data
				};
			},
			cache: true
		}
	})
	//<![CDATA[
	$(".selectfile").click(function() {
		var area = "id_image_before";
		var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
		var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
		var type = "image";
		nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
	
	$(".selectfile2").click(function() {
		var area = "id_image_after";
		var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
		var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
		var type = "image";
		nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
	
	function nv_change_weight(id) {
		var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
		var new_vid = $('#id_weight_' + id).val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=seller_management&nocache=' + new Date().getTime(), 'ajax_action=1&id=' + id + '&new_vid=' + new_vid, function(res) {
			var r_split = res.split('_');
			if (r_split[0] != 'OK') {
				alert(nv_is_change_act_confirm[2]);
			}
			window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=seller_management';
			return;
		});
		return;
	}
	
	
	function nv_change_status(id) {
		var new_status = $('#change_status_' + id).is(':checked') ? true : false;
		if (confirm(nv_is_change_act_confirm[0])) {
			var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=seller_management&change_status=1&id='+id, function(res) {
				var r_split = res.split('_');
				if (r_split[0] != 'OK') {
					alert(nv_is_change_act_confirm[2]);
				}
			});
		}
		else{
			$('#change_status_' + id).prop('checked', new_status ? false : true);
		}
		return;
	}
	
	function nv_change_seller_hot(id) {
		var new_seller_hot = $('#change_seller_hot_' + id).is(':checked') ? true : false;
		if (confirm(nv_is_change_act_confirm[0])) {
			var nv_timer = nv_settimeout_disable('change_seller_hot_' + id, 5000);
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=seller_management&change_seller_hot=1&id_seller_hot='+id, function(res) {
				
			});
		}
		else{
			$('#change_status_' + id).prop('checked', new_status ? false : true);
		}
		return;
	}
	$('select[name=sea_flast]').change(function() {
		var time_from = "";
		var time_to = "";
		var time = $('select[name=sea_flast]').val();
		if (time == 1) {
			time_from = "{HOMNAY}"
			time_to = "{HOMNAY}"
			} else if (time == 2) {
			time_from = "{HOMQUA}"
			time_to = "{HOMQUA}"
			} else if (time == 3) {
			time_from = "{TUANNAY.from}"
			time_to = "{TUANNAY.to}"
			} else if (time == 4) {
			time_from = "{TUANTRUOC.from}"
			time_to = "{TUANTRUOC.to}"
			} else if (time == 5) {
			time_from = "{THANGNAY.from}"
			time_to = "{THANGNAY.to}"
			} else if (time == 6) {
			time_from = "{THANGTRUOC.from}"
			time_to = "{THANGTRUOC.to}"
			} else if (time == 7) {
			time_from = "{NAMNAY.from}"
			time_to = "{NAMNAY.to}"
			} else if (time == 8) {
			time_from = "{NAMTRUOC.from}"
			time_to = "{NAMTRUOC.to}"
			} else if (time == 9) {
			time_from = "Không chọn"
			time_to = "Không chọn"
			} else if (time == 0) {
			time_from = ""
			time_to = ""
		}
		$('#ngaytu').val(time_from);
		$('#ngayden').val(time_to);
	})
	$("#tms_sea_id").click(function() {
		$("#tms_sea").toggle();
	});
	$("#ngaytu,#ngayden").datepicker({
		dateFormat: "dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		firstDay: 1,
		showOtherMonths: true,
	});
	$(".bank_id").select2("trigger", "select", {
		data: { id: {bank_id}, text: '{bank_name}' }
	});
	$('.export_file').on('click', function(e) {
		var all = $(this).attr('data-all');	
		var form_data = $('#formsearch').serializeArray(); 
		form_data.push({ name: 'all', value: all });
		
		$.ajax({
			url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=is_download&nocache=' + new Date().getTime(),
			type: 'post',
			dataType: 'json',
			data: form_data,
			beforeSend: function() {
				$('.export_file i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('.export_file').prop('disabled', true);
				loading();
			},	
			complete: function() {
				$('.export_file i').replaceWith('<i class="fa fa-download"></i>');
				$('.export_file').prop('disabled', false);
			},
			success: function(json) {
				removeloading();
				if( json['error'] ) alert( json['error'] );  		
				if( json['link'] ) window.location.href= json['link'];  		
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
		e.preventDefault(); 	
	});
	//]]>
</script>
<!-- END: main -->