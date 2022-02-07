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
                <input class="form-control" type="text" value="{Q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
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
					<th>{LANG.item_code}</th>
                    <th>{LANG.name_gui}</th>
                    <th>{LANG.name_nhan}</th>
                    <th>{LANG.order_code}</th>
                    <th>{LANG.tongcuocbaogomdvct}</th>
                    <th>{LANG.hinhthuc_vc}</th>
                    <th>{LANG.vnpost_status}</th>
                    <th>{LANG.name_create}</th>
                    <th>{LANG.date_add}</th>
                    <th class="w100 text-center">{LANG.doisoat}</th>
                    <th class="w150">&nbsp;</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="12">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr class="item_loop_view {VIEW.class_red}">
                    <td> {VIEW.item_code} </td>
                    <td> {VIEW.name_gui} </td>
                    <td> {VIEW.name_nhan} </td>
                    <td> <a href="{VIEW.link_view_order}" title="Chi tiết đơn hàng">{VIEW.order_code}</a> </td>
                    <td>
						{VIEW.tongcuocbaogomdvct} 
						<!-- BEGIN: cuocphi_thuctinh -->
						- (thực tính: {cuocphi_thuctinh})
						<!-- END: cuocphi_thuctinh -->
					</td>
                    <td> {VIEW.hinhthuc_vc} </td>
                    <td> {VIEW.vnpost_status} </td>
                    <td> {VIEW.name_create} </td>
                    <td> {VIEW.date_add} </td>
                    <td class="text-center"><input type="checkbox" name="doisoat" id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" /></td>
                    <td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}#edit">Chi tiết</a></td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->

<script type="text/javascript">

    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=history_vnpos&nocache=' + new Date().getTime(), 'change_status=1&id='+id, function(res) {
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


//]]>
</script>
<!-- END: main -->