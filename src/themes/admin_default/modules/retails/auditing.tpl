<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<div class="well">
    <form class="form_search" action="{NV_BASE_ADMINURL}index.php" method="get">
        <input type="hidden" name="{NV_LANG_VARIABLE}"  value="{NV_LANG_DATA}" />
        <input type="hidden" name="{NV_NAME_VARIABLE}"  value="{MODULE_NAME}" />
        <input type="hidden" name="{NV_OP_VARIABLE}"  value="{OP}" />
        <div class="row">			
			<div class="col-xs-24 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <div class="input-group" style="width:100%">
                        <span class="input-group-addon w100">
                            Cửa hàng
						</span>
                        <select name="store_id" class="select2 form-control input-sm store_id">
							<option value="0">Chọn tất cả</option>
                            <!-- BEGIN: store_id -->
                            <option value="{store_id_list.key}" {store_id_list.selected}>{store_id_list.title}
							</option>
                            <!-- END: store_id -->
						</select>
					</div>
				</div>
			</div>
			<div class="col-xs-20 col-sm-10 col-md-10 col-lg-10">
                <div class="form-group">
					<div class="input-group" style="width:100%">
						<span class="input-group-addon w100">
                            Trạng thái
						</span>
						<select class="form-control input-sm status" id="status" name="status">
							<option value="0" {SELECT_SUCCESS}>Đơn hàng thành Công</option>
							<option value="1" {SELECT_DELIVERING}>Đang giao & đợi xác nhận</option>
							<option value="2" {SELECT_FAIL}>Đơn hàng thất bại</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-24 col-sm-6 col-md-6 col-lg-6">
				<div class="p-1 bg-light rounded rounded-lg shadow-sm">
					<select class="form-control border-0 bg-light" id="sea_flast" name="sea_flast">
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
			<div class="col-xs-24 col-sm-6 col-md-6 col-lg-6">
				<div class="p-1 bg-light rounded rounded-lg shadow-sm">
					<input id="ngaytu" name="ngay_tu" value="{ngay_tu}" type="search" placeholder="Từ ngày" aria-describedby="button-addon2" class="form-control border-0 bg-light" />
				</div>
			</div>
			<div class="col-xs-24 col-sm-6 col-md-6 col-lg-6">
				<div class="p-1 bg-light rounded rounded-lg shadow-sm">
					<input id="ngayden" name="ngay_den" value="{ngay_den}" type="search" placeholder="Đến ngày" aria-describedby="button-addon2" class="form-control border-0 bg-light" />
				</div>
			</div>
			
			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					<button class="btn btn-primary export_file" type="button"  >
						Xuất file excel
					</button>
					<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
				</div>
			</div>
		</div>
	</form>
</div>

</br>

<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
				<tr>
					<th class="w30">{LANG.weight}</th>
					<th>Seller</th>
					<th>Tổng giá trị sản phẩm</th>
					<th>Phí vận chuyển</th>
					<th>Phí sàn</th>
					<th>Phí VNPAY</th>
					<th>BHHH & phí chênh lệch</th>
					<th>Voucher</th>
					<th>Phí phạt</th>
					<th>ECNG thu hộ & nhận</th>
					<th>Seller nhận</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td>{weight}</td>
					<td><a href="{VIEW.link}" title="Xem chi tiết" target="_blank">{info_store.company_name}</a></td>
					<td><a href="{VIEW.link_total_product}" target="_blank">{VIEW.sum_total_product_format}</a></td>
					<td>{VIEW.ship_format}</td>
					<td>{VIEW.phisan_format} </td>
					<td>{VIEW.vnpay_format}</td>
					<td>{VIEW.insurance_format}</td>
					<td>{VIEW.voucher_format}</td>
					<td>{VIEW.phi_phat_format}</td>
					<td>{VIEW.ecng_nhan_format}</td>
					<td>{VIEW.seller_nhan_format}</td>
				</tr>
				<!-- END: loop -->
				
				<tr style="color: red;font-weight: 700;font-size: 16px;">
					<td colspan="2" class="text-center">
						Tổng tiền
					</td>
					<td>{sum_total_product}</td>
					<td>{ship}</td>
					<td>{phisan} </td>
					<td>{vnpay}</td>
					<td>{insurance}</td>
					<td>{voucher}</td>
					<td>{phi_phat}</td>
					<td>{ecng_nhan}</td>
					<td>{seller_nhan}</td>
				</tr>
				
			</tbody>
		</table>
		<!-- BEGIN: generate_page -->
		<div class="text-right">
			<tr>
				<td class="text-center" style="float: right" colspan="8">{NV_GENERATE_PAGE}</td>
			</tr>
		</div>
		<!-- END: generate_page -->
	</div>
</form>

<script>
	
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
	
	//<![CDATA[
	$("#ngaytu,#ngayden").datepicker({
	dateFormat : "dd-mm-yy",
	changeMonth : true,
	changeYear : true,
	showOtherMonths : true,
	});
	
	
	$(".export_file").on('click', function(e) {
	e.preventDefault();  
	
	$.ajax({               
	type: "GET",
	url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=is_download',
	data: $('.form_search').serialize(),
	beforeSend: function() {
	
	},	               
	complete: function() {
	
	},                 
	success: function(res) {
	
	window.location.href = res;     
	
	},                 
	error: function(xhr, ajaxOptions, thrownError) {
	
	console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}                  
	});                    
	}); 
	
</script>

<!-- END: main -->