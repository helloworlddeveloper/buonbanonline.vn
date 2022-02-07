<!-- BEGIN: main -->
<!-- BEGIN: view -->

<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w100">{LANG.weight}</th>
					<th class=" text-center">{LANG.photo}</th>
                    <th class=" text-center">{LANG.name}</th>
                    <th class=" text-center">{LANG.phone}</th>
					<th class=" text-center">{LANG.email}</th>	
                    <th class="w100 text-center">{LANG.active}</th>
                    <th class="w150">&nbsp;</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="7">{NV_GENERATE_PAGE}</td>
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
                    
                    <td class="text-center"> <img alt="{VIEW.title}" src="{VIEW.image}" height="50"> </td>
					<td class="text-center"> {VIEW.title} </td>
					<td class="text-center"> {VIEW.phone} </td>
					<td class="text-center"> {VIEW.email} </td>
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
	<input type="hidden" name="bid" value="{ROW.bid}" />
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.photo}</strong></label>
        <div class="col-sm-19 col-md-20">
            <div class="input-group">
            <input class="form-control" type="text" name="image" value="{ROW.image}" id="id_image" />
            <span class="input-group-btn">
                <button class="btn btn-default selectfile_image" type="button" >
                <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
            </button>
            </span>
        </div>
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.title}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="title" value="{ROW.title}" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.phone}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="phone" value="{ROW.phone}" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.email}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="email" value="{ROW.email}" />
        </div>
    </div>
   
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.skyper}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="skyper" value="{ROW.skyper}" />
        </div>
    </div>
   
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.zalo}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="zalo" value="{ROW.zalo}" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.facebook}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="facebook" value="{ROW.facebook}" />
        </div>
    </div>
   



   
    <div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>

<script type="text/javascript">
//<![CDATA[
    $(".selectfile_image").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{CURRENT}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

  
    function nv_change_weight(id) {
        var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
        var new_vid = $('#id_weight_' + id).val();
		var bid ='{BID}';
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=support_content&nocache=' + new Date().getTime(), 'ajax_action=1&id=' + id + '&bid=' + bid + '&new_vid=' + new_vid, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(nv_is_change_act_confirm[2]);
            }
            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=support_content&bid=' + bid;
            return;
        });
        return;
    }


    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
			var bid ='{BID}';
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=support_content&nocache=' + new Date().getTime(), 'change_status=1&id='+id, function(res) {
                var r_split = res.split('_');
                if (r_split[0] != 'OK') {
                    alert(nv_is_change_act_confirm[2]);
                }
			 window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=support_content&bid=' + bid;
            return;	
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