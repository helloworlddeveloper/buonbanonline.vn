<!-- BEGIN: main -->
<!-- BEGIN: view -->

<div class="panel panel-default">
	<div class="panel-heading">
    <h3 class="panel-title" style="float:left"><i class="fa fa-list"></i> {LANG.transporters}</h3> 
    <div class="pull-right">
     <button title="Ẩn /Hiện tìm kiếm"id="tms_sea_id" data-toggle="tooltip" data-placement="top"class="btn btn-success btn-sm"><i class="fa fa-search" aria-hidden="true"></i></button> 
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
                            Trạng thái
                        </span>
                        <select id="status_search" name="status_search" class="form-control input-sm">
                            <!-- BEGIN: status_filt -->
                            <option value="{status_filt.id}" {status_filt.selected}>{status_filt.text}
                            </option>
                            <!-- END: status_filt -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
                <div class="form-group">
                    <input class="form-control" type="text" value="{Q}" name="q" maxlength="255"
                        placeholder="Tên nhà vận chuyển, ký hiệu nhà vận chuyển" />
                </div>
            </div>
            <div class="col-sm-24  col-md-24  col-lg-4">
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
                    <th class="w100">{LANG.weight}</th>
                    <th class="text-center">{LANG.name_transporters}</th>
                    <th class="text-center">{LANG.symbol_transporters}</th>
                    <th class="text-center">{LANG.image}</th>
                    <th class="text-center">Hổ trợ phí vận chuyển</th>
					<th class="text-center">Thời gian dự kiến giao hàng</th>
					<th class="text-center">Khối lượng tối đa (g)</th>
					<th class="text-center">Chiều dài tối đa (cm)</th>
					<th class="text-center">Chiều rộng tối đa (cm)</th>
					<th class="text-center">Chiều cao tối đa (g)</th>
                    <th class="text-center">{LANG.time_edit}</th>
                    <th class="text-center">{LANG.user_edit}</th>
                    <th class="w100 text-center">{LANG.active}</th>
                    <th class="w150">&nbsp;</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="11">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr class="text-center">
                    <td>
                        <select class="form-control" id="id_weight_{VIEW.id}" onchange="nv_change_weight('{VIEW.id}');">
							<!-- BEGIN: weight_loop -->
								<option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
							<!-- END: weight_loop -->
						</select>
					</td>
                    <td> {VIEW.name_transporters} </td>
                    <td> {VIEW.symbol_transporters} </td>
                    <td><img src="{VIEW.image}" style="height:100px;max-width:300px" class="img-thumbnail" /> </td>
                    <td> {VIEW.money} </td>
					<td> {VIEW.description} </td>
					<td> {VIEW.max_weight} </td>
					<td> {VIEW.max_length} </td>
					<td> {VIEW.max_width} </td>
					<td> {VIEW.max_height} </td>
                    <td> {VIEW.time_edit} </td>
                    <td> {VIEW.user_edit} </td>
                    <td class="text-center"><input type="checkbox" name="status" id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" /></td>
                    <td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}#edit">{LANG.edit}</a></td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<!-- BEGIN: edit -->
<div class="panel panel-default">
<div class="panel-body">
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{ROW.id}" />
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.name_transporters}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="name_transporters" value="{ROW.name_transporters}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.symbol_transporters}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="symbol_transporters" value="{ROW.symbol_transporters}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
	 <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Thời gian dự kiến giao hàng</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="description" value="{ROW.description}" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Khối lượng tối đa (gram)</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="max_weight" value="{ROW.max_weight}" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Chiều dài tối đa (cm)</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="max_length" value="{ROW.max_length}" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Chiều rộng tối đa (cm)</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="max_width" value="{ROW.max_width}" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Chiều cao tối đa (cm)</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="max_height" value="{ROW.max_height}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.image}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <div class="input-group">
            <input class="form-control" type="text" name="image" value="{ROW.image}" id="id_image" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
            <span class="input-group-btn">
                <button class="btn btn-default selectfile" type="button" >
                <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
            </button>
            </span>
        </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Hổ trợ phí vận chuyển</strong></label>
        <div class="col-sm-19 col-md-20">
			<div class="col-sm-4 col-md-5">
				<select class="form-control" name="type">
				   <!-- BEGIN: type -->
					 <option value="{type.key}" {type.selected}>{type.title}</option>
					<!-- END: type -->
				</select>
			</div>
			<div class="col-sm-20 col-md-19">
				<input class="form-control" type="text" name="money" value="{ROW.money}" required="required" placeholder="Số tiền hổ trợ" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
			</div>
        </div>
    </div>
   
    <div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>
<!-- END: edit -->

<script type="text/javascript">
//<![CDATA[
    $(".selectfile").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/transporters";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    function nv_change_weight(id) {
        var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
        var new_vid = $('#id_weight_' + id).val();
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=transporters&nocache=' + new Date().getTime(), 'ajax_action=1&id=' + id + '&new_vid=' + new_vid, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(nv_is_change_act_confirm[2]);
            }
            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=transporters';
            return;
        });
        return;
    }


    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=transporters&nocache=' + new Date().getTime(), 'change_status=1&id='+id, function(res) {
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
//]]>
</script>
<!-- END: main -->