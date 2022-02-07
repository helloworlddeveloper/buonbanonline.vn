<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="row">
<div class="col-md-8 col-sm-12 col-xs-24 col-lg-8">
<div class="wallet-bank-add">
<div class="wallet-bank-text-add"id="tms_sea_id"><i class="fa fa-plus-square" aria-hidden="true"></i><br/>Thêm tài khoản ngân hàng</div>
</div>
</div>
 <!-- BEGIN: loop -->
<div class="col-md-8 col-sm-12 col-xs-24 col-lg-8">
<div class="wallet-bank">
<div class="wallet-bank-title">{VIEW.acount_bankid}</div>
<div class="wallet-bank-text"> {VIEW.acount_name}</div>
<div class="wallet-bank-text">{VIEW.acount_number} </div>
<div class="wallet-bank-text">{VIEW.acount_bankbranch} <a class="wallet-bank-delete" href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></div>
</div>
</div>
<!-- END: loop -->
</div>
<div style="clear:both"></div>

<!-- END: view -->

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->

<div class="panel panel-default" id="tms_sea"style="display: none;">
<div class="panel-body">
<form class="form-horizontal" action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{ROW.id}" />


	
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