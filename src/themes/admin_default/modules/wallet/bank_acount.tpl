<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="panel panel-default">
	<div class="panel-heading">
    <h3 class="panel-title" style="float:left"><i class="fa fa-list"></i> {LANG.bank}</h3> 
    <div class="pull-right">
     <button title="Ẩn /Hiện tìm kiếm" id="tms_sea_id" data-toggle="tooltip" data-placement="top"class="btn btn-success btn-sm"><i class="fa fa-search" aria-hidden="true"></i></button> 
   </div>
   <div style="clear:both"></div>
 </div>
<div class="well" id="tms_sea" >
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
                        placeholder="Tên ngân hàng" />
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
                    <th>{LANG.acount_userid}</th> 
					<th>{LANG.bank_code}</th>
                    <th>{LANG.bank}</th>
                    <th>{LANG.user_add}</th>
                    <th>{LANG.time_add}</th>
                    <th>{LANG.user_edit}</th>
                    <th>{LANG.time_edit}</th>
                    <th class="w100 text-center">{LANG.active}</th>
                    <th class="w150">&nbsp;</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="9">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td>
                        <select class="form-control" id="id_weight_{VIEW.id}" onchange="nv_change_weight('{VIEW.id}');">
                        <!-- BEGIN: weight_loop -->
                            <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                        <!-- END: weight_loop -->
                    </select>
                </td>
                    <td>{LANG.acount_userid}: {VIEW.acount_userid} {VIEW.acount_first_name}<br/>
					{LANG.acount_phone}: {VIEW.acount_phone}<br/>{LANG.acount_regdate}: {VIEW.acount_regdate}</td>
                    <td>{LANG.acount_name}: {VIEW.acount_name}<br/>
					{LANG.acount_cccd}: {VIEW.acount_cccd}<br/>
					{LANG.acount_date_range}: {VIEW.acount_date_range} <br/>
					{LANG.acount_issued_by}: {VIEW.acount_issued_by} <br/>
					</td>
                    <td> {LANG.acount_number}: {VIEW.acount_number} 
					<br/>{LANG.acount_bankid}: {VIEW.acount_bankid} <br/>
					{LANG.acount_bankbranch}: {VIEW.acount_bankbranch}
					</td>
                    <td> {VIEW.user_add} </td>
                    <td> {VIEW.time_add} </td>
                    <td> {VIEW.user_edit} </td>
                    <td> {VIEW.time_edit} </td>
                    <td class="text-center"><input type="checkbox" name="status" id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" /></td>
                    <td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}#edit">{LANG.edit}</a> - <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></td>
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
<div class="panel panel-default">
<div class="panel-body">
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{ROW.id}" />

	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_userid}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
		 <select class="form-control acount_userid" name="acount_userid" {readonly} required="" oninvalid="setCustomValidity('Vui lòng chọn khách hàng')" oninput="setCustomValidity('')" >
		<option value="" > -- Vui lòng chọn khách hàng --</option>
       <!-- BEGIN: acount_userid -->
		<option value="{USER.key}" {USER.selected}>{USER.title}</option>
       <!-- END: acount_userid -->
        </select>
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_name}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="acount_name" value="{ROW.acount_name}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_cccd}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="acount_cccd" value="{ROW.acount_cccd}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_date_range}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="acount_date_range" value="{ROW.acount_date_range}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_issued_by}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="acount_issued_by" value="{ROW.acount_issued_by}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_number}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="acount_number" value="{ROW.acount_number}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>

	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_bankid}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
		 <select class="form-control acount_bankid" name="acount_bankid" {readonly} required="" oninvalid="setCustomValidity('Vui lòng ngân hàng')" oninput="setCustomValidity('')" >
		<option value="" > -- --</option>
       <!-- BEGIN: acount_bankid -->
		<option value="{BANK.key}" {BANK.selected}>{BANK.title}</option>
       <!-- END: acount_bankid -->
        </select>
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_bankbranch}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="acount_bankbranch" value="{ROW.acount_bankbranch}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
	
    <div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>

<script type="text/javascript">
//<![CDATA[

$('.acount_bankid').select2({
    placeholder: "Mời bạn chọn ngân hàng"
})

    function nv_change_weight(id) {
        var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
        var new_vid = $('#id_weight_' + id).val();
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=bank&nocache=' + new Date().getTime(), 'ajax_action=1&id=' + id + '&new_vid=' + new_vid, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(nv_is_change_act_confirm[2]);
            }
            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=bank';
            return;
        });
        return;
    }


    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=bank&nocache=' + new Date().getTime(), 'change_status=1&id='+id, function(res) {
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