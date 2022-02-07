<!-- BEGIN: main -->

<link rel="stylesheet" href="https://banhang.chonhagiau.com/themes/default/banhang/css/style.css">
<link rel="stylesheet" href="https://banhang.chonhagiau.com/themes/default/banhang/css/shops.css">
<link rel="stylesheet" href="https://banhang.chonhagiau.com/themes/default/banhang/css/home.css">



<!-- BEGIN: view -->
<div class="content_products_item">
    <div class="d-flex justify-content-between mb-4">
        <div class="fs_20">Sản phẩm ({num_items})</div>
	</div>	
		<div class="well mt-4" id="tms_sea">
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
								Cửa hàng
							</span>
							<select name="store_id" class="form-control input-sm store_id">
								<option value="0">Chọn tất cả</option>
								<!-- BEGIN: store_id -->
								<option value="{store_id.key}" {store_id.selected}>{store_id.title}
								</option>
								<!-- END: store_id -->
							</select>
						</div>
					</div>
				</div>
				
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<input class="form-control" type="text" value="{Q}" name="q" maxlength="255"
                        placeholder="Tên sản phẩm" />
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
		</form>
	</div>
    <div class="manage_product bg_white">
        <div class="manage_product_header bg-light">
            <div class="row d-flex align-items-center p-4 text-center">
                <div class="col-md-10 d-flex align-items-center justify-content-start">
                    Tên Sản phẩm
				</div>
                <div class="col-md-4 text-left">Danh mục</div>
                <div class="col-md-2 col-auto">
                    Trạng thái
				</div>
                <div class="col-md-2">
                    SL tồn kho
				</div>
				<div class="col-md-2">
                    Ngày thêm
				</div>
                <div class="col-md-4">
                    Thao tác
				</div>
			</div>
		</div>
		
        <!-- BEGIN: loop -->
        <div class="manage_product_item border-bottom">
            <div class="row d-flex align-items-center p-4 text-center">
                <div class="col-md-12 d-flex align-items-center justify-content-start">
                    <img src="{VIEW.image}" class="width_50" alt="{VIEW.name_product}" />
					<a href="{VIEW.alias}" target="_blank">
						<div class="ml-3">{VIEW.name_product} </div>
					</a>
				</div>
                <div class="col-md-4 text-left">{VIEW.categories_id}</div>
                <div class="col-md-2 col-auto">
                    <label class="ecng_label_checkbox">
                        <input id="change_status_{VIEW.id}" value="{VIEW.id}" type="checkbox" {CHECK} onclick="nv_change_status({VIEW.id});" />
                        <span class="ecng_checkmark"></span>
					</label>
				</div>
				
                <div class="col-md-2">
                    <!-- BEGIN: no_classify -->
						{warehouse}
                    <!-- END: no_classify -->
					
                    <!-- BEGIN: classify -->
					<div>{warehouse}</div>
                    <button type="button" class="btn_none secondary_text" data-toggle="modal" data-target="#view_classify{VIEW.id}">Xem chi tiết</button>
                    <!-- The Modal -->
                    <div class="modal fade" id="view_classify{VIEW.id}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Phân loại hàng</h4>
                                    <button type="button" class="close" data-dismiss="modal">×</button>
								</div>
                                <div class="modal-body">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th class="text-left">Phân loại</th>
                                                <th>Giá bán</th>
                                                <th>Giá niêm yết</th>
                                                <th>SL tồn kho</th>
											</tr>
										</thead>
                                        <tbody>
                                            <!-- BEGIN: classify_loop -->
                                            <tr>
                                                <td class="text-left capitalize">{classfic.ten_rutgon}</td>
                                                <td>{classfic.price}</td>
                                                <td>{classfic.price_special}</td>
                                                <td>{classfic.sl_tonkho}</td>
											</tr>
                                            <!-- END: classify_loop -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                    <!-- END: classify -->
				</div>
				
				<div class="col-md-4">
					{VIEW.time_add}
				</div>
				
                <div class="col-md-4">
                    <a href="{VIEW.link_edit}#edit" class="btn_ecng_outline mr-3">Xem</a>
				<a title="Xóa sản phẩm" href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);" class="btn_gray" style="color:red; border:1px solid red" >Xóa</a>
				</div>
			</div>
		</div>
        <!-- END: loop -->
	</div>
</div>

<!-- BEGIN: generate_page -->
<div class="container text-center">
    <div >
        <tr>
            <td class="text-center" colspan="12">{NV_GENERATE_PAGE}</td>
		</tr>
	</div>
</div>
<!-- END: generate_page -->



<!-- END: view -->

<script type="text/javascript">
	$(document).ready(function(){	
		$('#click').on('click', function(){
		  var date_tu = new Date($('#date_tu').val());
		  day = date_tu.getDate();
		  month = date_tu.getMonth() + 1;
		  year = date_tu.getFullYear();
		  
		  var date_den = new Date($('#date_den').val());
		  day2 = date_den.getDate();
		  month2 = date_den.getMonth() + 1;
		  year2 = date_den.getFullYear();

		  alert("Từ ngày " + [day, month, year].join('/') + "Đến ngày " + [day2, month2, year2].join('/'));
		});
	});
	
    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=product&nocache=' + new Date().getTime(), 'change_status=1&id='+id, function(res) {
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
	
    $("select[name=sea_flast]").change(function () {
        var time_from = "";
        var time_to = "";
        var time = $("select[name=sea_flast]").val();
        if (time == 1) {
            time_from = "{HOMNAY}";
            time_to = "{HOMNAY}";
			} else if (time == 2) {
            time_from = "{HOMQUA}";
            time_to = "{HOMQUA}";
			} else if (time == 3) {
            time_from = "{TUANNAY.from}";
            time_to = "{TUANNAY.to}";
			} else if (time == 4) {
            time_from = "{TUANTRUOC.from}";
            time_to = "{TUANTRUOC.to}";
			} else if (time == 5) {
            time_from = "{THANGNAY.from}";
            time_to = "{THANGNAY.to}";
			} else if (time == 6) {
            time_from = "{THANGTRUOC.from}";
            time_to = "{THANGTRUOC.to}";
			} else if (time == 7) {
            time_from = "{NAMNAY.from}";
            time_to = "{NAMNAY.to}";
			} else if (time == 8) {
            time_from = "{NAMTRUOC.from}";
            time_to = "{NAMTRUOC.to}";
			} else if (time == 9) {
            time_from = "Không chọn";
            time_to = "Không chọn";
			} else if (time == 0) {
            time_from = "";
            time_to = "";
		}
        $("#ngaytu").val(time_from);
        $("#ngayden").val(time_to);
	});
    $("#tms_sea_id").click(function () {
        $("#tms_sea").toggle();
	});
    $("#ngaytu,#ngayden").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
        showOtherMonths: true,
	});
    $('[data-toggle="tooltip"]').tooltip();
   
	
	$('.select2').select2();
</script>

<style>
	.manage_product_item.border-bottom img {
    margin-right: 10px;
}
.d-flex {
    display: flex;
    vertical-align: middle;
    align-items: center;
}
.border-bottom {
    border-bottom: 1px solid #dee2e6!important;
}
.p-4 {
    padding: 1.5rem!important;
}
.pagination>li:first-child>a, .pagination>li:first-child>span,.pagination>li:last-child>a, .pagination>li:last-child>span{
    border-radius: 50%;
}
.pagination>.disabled>span, .pagination>.disabled>span:hover, .pagination>.disabled>span:focus, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus{border:none}
</style>

<!-- END: main -->
