<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<div class="panel panel-default">
<div class="panel-body">
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{ROW.id}" />
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.title}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="title" value="{ROW.title}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.keyword}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="keyword" value="{ROW.keyword}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.description_block}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="description_block" value="{ROW.description_block}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.bodytext}</strong></label>
        <div class="col-sm-19 col-md-20">
{ROW.bodytext}        </div>
    </div>
	
    <div class="form-group">
	<label class="col-sm-5 col-md-4 control-label"><strong>Hình ảnh</strong></label>
	 <div class="col-sm-19 col-md-20">
   	<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="customFields">
			<thead>
				<tr>
					<th>Tên hình</th>
					<th>Liên kết</th>
					<th>Hình ảnh</th>
				</tr>
			</thead>
			<tbody id="addslider">
				<!-- BEGIN: img -->
				<tr  id="delslider_{TMS.id}">
					<td><input class=" form-control pull-left" type="text" name="titleblock[]" id="titleblock_{TMS.id}"  value="{TMS.title}" style="height: 60px; width: 100%"/></td>
					<td><input class=" form-control pull-left" type="text" name="link[]" id="link_{TMS.id}"  value="{TMS.link}" style="height: 60px; width: 100%"/></td>
					<td>
					<img src="{TMS.img}" style="height:60px;width: 80px;float: left; margin-right:10px;"/>
					<input value="{TMS.img}" name="img[]" id="img_{TMS.id}" class="form-control" style="width:55%; margin-bottom:3px;" maxlength="255"/>
					<input value="{LANG.select_img}" name="selectslider" onclick="nv_open_browse( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=img_{TMS.id}&path={NV_UPLOADS_DIR}/{MODULE_NAME}&currentpath={UPLOAD_CURRENT_BLOCK}&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; " type="button" class="btn btn-info"/>
					<input type="button" class="btn btn-info" value="Xóa" onclick="nv_remove_slider({TMS.id});"/>    
					</td>
				</tr>
			<!-- END: img -->		
				<tr  id="delslider_{TMS.id}"></tr>
				
		</table>
	
	</div>
			
    <div class="row text-center"><a onclick="add_slider();" class="btn btn-danger ">Thêm hình ảnh</a> </div>
		  <script type="text/javascript">
			var file_selectfile = 'Chọn hình ảnh';
			var nv_base_adminurl = '{NV_BASE_ADMINURL}';
			var file_dir = '{NV_UPLOADS_DIR}/{MODULE_NAME}';
			var currentpath = '{UPLOAD_CURRENT_BLOCK}';
			var file_items_slider = '{TMS_STT}';//Number items other images :))
			function add_slider() {
			var newitem = "<tr id=\"delslider_" + file_items_slider + "\"><td><input class=\"form-control\" value=\"\" name=\"titleblock[]\" id=\"titleblock_" + file_items_slider + "\" style=\"width :100%;height: 60px;\" maxlength=\"255\" /></td><td ><input class=\"form-control\" value=\"\" name=\"link[]\" id=\"link_" + file_items_slider + "\" style=\"width :100%;height: 60px;\" maxlength=\"255\" /></td>";
			newitem += "<td><span style=\"height:60px;width: 80px;float: left; margin-right:10px;\"/></span><input class=\"form-control\" value=\"\" name=\"img[]\" id=\"img_" + file_items_slider + "\" style=\"width :72%; margin-bottom:3px;\" maxlength=\"255\" />&nbsp;<input type=\"button\" class=\"btn btn-info\" value=\"" + file_selectfile + "\" name=\"selectfile\" onclick=\"nv_open_browse( '" + nv_base_adminurl + "index.php?" + nv_name_variable + "=upload&popup=1&area=img_" + file_items_slider + "&path=" + currentpath + "&type=file&currentpath=" + currentpath + "', 'NVImg', 850, 400, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" /> <input type=\"button\" class=\"btn btn-info\" value=\"Xóa\" onclick=\"nv_remove_slider(" + file_items_slider + ");\"/></td></tr>";
				$("#addslider").append(newitem);
				file_items_slider++;
			}
			function nv_remove_slider( id ) { $('#delslider_'+id).remove();}
			</script> 
    </div>
	
		</div>
	


    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.tag_title}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="tag_title" value="{ROW.tag_title}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.tag_description}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="tag_description" value="{ROW.tag_description}" />
        </div>
    </div>
    <div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>

<script type="text/javascript">
  var other_image = []

  <!-- BEGIN: edit_other_imagejs -->
  <!-- BEGIN: loop -->
  other_image.push({"id":{key}})
  <!-- END: loop -->
  <!-- END: edit_other_imagejs -->

  function add_otherimage(){
   var id_next
   if(other_image.length == 0){
    id_next=1
}else{
    id_next=other_image[other_image.length-1]['id']+1;
}
$('#other_image_list').append('<div id="other_image_tr_'+id_next+'" class="box_orther"><div colspan="3"><div class="input-group col-md-24 col-sm-24"><input class="form-control" type="text" name="other_link[]" id="id_link_'+id_next+'" style="width:50%" /><input class="form-control" type="text" name="other_image[]"style="width:50%" id="id_image_'+id_next+'"  /> <span class="input-group-btn"> <button class="btn btn-default selectfile_'+id_next+'" type="button"><em class="fa fa-folder-open-o fa-fix">&nbsp;</em></button><button type="button" class="btn btn-primary" onclick="remove_other_image('+id_next+')">Xóa</button></span></div></div></div>')
$(".selectfile_"+id_next).click(function() {
    var area = "id_image_"+id_next;
    var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/block/";
    var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/block/";
    var type = "image";
    nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    return false;
});
other_image.push({"id":id_next})
}

    $(".selectfile").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/block/";
        var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/block/";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
</script>
<!-- END: main -->