<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="form-horizontal">
        <input type="hidden" name="id" value="{ROW.id}" />
        <div class="col-md-19 col-sm-20">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover full">
                    <colgroup>
                        <col class="w200" />
                        <col />
                    </colgroup>
                    <tbody>
                        <tr>
                            <td colspan="3" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                                <strong>
                                    {LANG.info_product}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <strong>
                                        Cửa hàng
                                    </strong>
                                    <span class="red">(*)</span>
                                </label>
                            </td>
                            <td colspan="2">
                             <select class="form-control store_id" name="store_id" {readonly} required="" oninvalid="setCustomValidity('Vui lòng chọn cửa hàng')" oninput="setCustomValidity('')" >
                               <option value="" ></option>
                               <!-- BEGIN: store_id -->
                               <option value="{store_id.key}" {store_id.selected}>
                                {store_id.title}
                            </option>
                            <!-- END: store_id -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <strong>
                                {LANG.barcode}
                            </strong>
                            <span class="red">(*)</span>
                        </label>
                    </td>
                    <td colspan="2">
                        <div class="input-group col-sm-24 col-md-24">
                            <input {readonly} class="form-control" type="text" name="barcode" value="{ROW.barcode}"
                            oninvalid="setCustomValidity(nv_required)"
                            oninput="setCustomValidity('')" />
                            <span class="input-group-addon {pointer}" id="{random_num}"
                            style="padding: 1px 10px;">
                            <i class="fa fa-random"></i>
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        <strong>
                            {LANG.name_product}
                        </strong>
                        <span class="red">(*)</span>
                    </label>
                    <td colspan="2">
                        <input class="form-control" type="text" name="name_product"
                        value="{ROW.name_product}" onchange="nv_get_alias('id_alias')" required="required"
                        oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <strong>
                                {LANG.alias}
                            </strong>
                            <span class="red">(*)</span>
                        </label>
                    </td>
                    <td colspan="2">
                        <div class="col-sm-23 col-md-23">
                            <input class="form-control" type="text" name="alias" value="{ROW.alias}"
                            id="id_alias" required="required" oninvalid="setCustomValidity(nv_required)"
                            oninput="setCustomValidity('')" />
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <i class="fa fa-refresh fa-lg icon-pointer"
                            onclick="nv_get_alias('id_alias');">&nbsp;</i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <strong>
                                {LANG.categories_id}
                            </strong>
                            <span class="red">(*)</span>
                        </label>
                    </td>
                    <td colspan="2">
                        <div class="col-sm-19 col-md-20">
							<select class="form-control categories_id select2" name="categories_id">
							  <option value="0">-- Chọn danh mục --</option>
							   <!-- BEGIN: parent_loop -->
							   <option value="{pcatid_i}" {pselect}>
								{ptitle_i}
							  </option>
							  <!-- END: parent_loop -->
							</select>
							
                        </div>
                        <div class="col-sm-5 col-md-4">
                            <select class="form-control unit_id" name="unit_id">
                                <!-- BEGIN: unit_id -->
                                <option value="{unit_id.key}" {unit_id.selected}>
                                    {unit_id.title}
                                </option>
                                <!-- END: unit_id -->
                            </select>
                        </div>
                    </td>
                </tr>
                <tr id="box_brand" class="hidden">
                    <td>
                        <label>
                            <strong>
                                {LANG.select_brand}
                            </strong>
                            <span class="red">(*)</span>
                        </label>
                    </td>
                    <td colspan="2">
                     <div class="col-sm-24 col-md-24">
                        <select class="form-control" name="brand" id="brand" required="required">
                            <!-- BEGIN: brand -->
                            <option value="{STATUS.id}" {STATUS.selected}>
                                {STATUS.title}
                            </option>
                            <!-- END: brand -->
                        </select>
                    </div>
                </td>
            </tr>
            <tr id="box_origin" class="hidden">
                <td>
                    <label>
                        <strong>
                            {LANG.select_origin}
                        </strong>
                        <span class="red">(*)</span>
                    </label>
                </td>
                <td colspan="2">

                    <div class="col-sm-24 col-md-24">
                      <select class="form-control " name="origin" id="origin" required="required">
                        <!-- BEGIN: origin -->
                        <option value="{STATUS.id}" {STATUS.selected}>
                            {STATUS.title}
                        </option>
                        <!-- END: origin -->
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    <strong>
                        {LANG.weight_product}
                    </strong>
                    <span class="red">(*)
                    </span>
                </label>
            </td>
            <td colspan="2">
                <div class="col-sm-19 col-md-20">
                    <input class="form-control" type="number" min="0" onkeypress="return isNumberKey(event)" step="0.01" name="weight_product"
                    value="{ROW.weight_product}" required="required"
                    oninvalid="setCustomValidity('Vui lòng nhập số')"
                    oninput="setCustomValidity('')" />
                </div>
                <div class="col-sm-5 col-md-4">
                    <select class="form-control unit_weight" name="unit_weight">
                        <!-- BEGIN: unit_weight -->
                        <option value="{unit_weight.key}" {unit_weight.selected}>
                            {unit_weight.title}
                        </option>
                        <!-- END: unit_weight -->
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    <strong>Kích thước sản phẩm</strong>
                    <span class="red">(*)</span>
                </label>
            </td>
            <td colspan="2">
                <div class="col-sm-8 col-md-8">
                    <div class="col-sm-14 col-md-14">
                        <input class="form-control" type="number" min="0" onkeypress="return isNumberKey(event)"  step="0.01" name="length_product"
                        value="{ROW.length_product}" placeholder="{LANG.length_product}"
                        oninput="setCustomValidity('')" />
                    </div>
                    <div class="col-sm-10 col-md-10">
                        <select class="form-control unit_length" name="unit_length">
                            <!-- BEGIN: unit_length -->
                            <option value="{unit_length.key}" {unit_length.selected}>

                                {unit_length.title}
                            </option>
                            <!-- END: unit_length -->
                        </select>
                    </div>
                </div>
                <div class="col-sm-8 col-md-8">
                    <div class="col-sm-14 col-md-14">
                        <input class="form-control" type="number" min="0" onkeypress="return isNumberKey(event)"  step="0.01" name="width_product"
                        value="{ROW.width_product}" placeholder="{LANG.width_product}"                        
                        oninput="setCustomValidity('')" />
                    </div>
                    <div class="col-sm-10 col-md-10">
                        <select class="form-control unit_width" name="unit_width">
                            <!-- BEGIN: unit_width -->
                            <option value="{unit_width.key}" {unit_width.selected}>
                                {unit_width.title}
                            </option>
                            <!-- END: unit_width -->
                        </select>
                    </div>
                </div>
                <div class="col-sm-8 col-md-8">
                    <div class="col-sm-14 col-md-14">
                        <input class="form-control" type="number" min="0" onkeypress="return isNumberKey(event)"  step="0.01" name="height_product"
                        value="{ROW.height_product}" placeholder="{LANG.height_product}"                      
                        oninput="setCustomValidity('')" />
                    </div>
                    <div class="col-sm-10 col-md-10">
                        <select class="form-control unit_height" name="unit_height">
                            <!-- BEGIN: unit_height -->
                            <option value="{unit_height.key}" {unit_height.selected}>
                                {unit_height.title}
                            </option>
                            <!-- END: unit_height -->
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr id="price_no1" class="{classify_check}">
           <td>
            <label>
                <strong>
                    Giá sản phẩm
                </strong>
            </label>
        </td>
        <td colspan="2">
           <input class="form-control" type="text" name="price" value="{ROW.price}" placeholder="Giá sản phẩm (giá thường)"  onkeyup="this.value=FormatNumber(this.value);" oninput="setCustomValidity('')" />
       </td>
   </tr>

<tr id="classify" class="{classify_check2}">
  <td colspan="3" id="classify_list">
   <!-- BEGIN: edit_product2 -->
   <!-- BEGIN: classify -->
   <div class="table-responsive" id="classifyfull_{key_classify}">
      <table class="table table-striped table-bordered table-hover full">
       <tbody id="classify_1">
        <tr>
         <td style="font-size:15px;font-weight:bold">
            Nhóm phân loại 222
        </td>
        <td>
          <button type="button" class="form-control" onclick="remove_classify({key_classify})">
            Xóa
        </button>
    </td>
</tr>
<tr>
 <td colspan="2">
  <div class="table-responsive">
   <table class="table table-striped table-bordered table-hover full">
    <colgroup>
     <col class="w200"><col>
 </colgroup>
 <tbody id="classify_list_group_{key_classify}">
     <tr>
      <td>
        Tên phân loại
    </td>
    <td colspan="2">
       <input class="form-control" name="classify[{key_classify}][name]" oninvalid="setCustomValidity('Vui lòng nhập tên phân loại')" required="required" oninput="setCustomValidity('')" onkeyup="change_name_group({key_classify},this)" value="{LOOP_classify.name}" />
   </td>
</tr>
<!-- BEGIN: classify_value -->
<!-- BEGIN: classify_value_first -->
<tr id="classify_list_group_value_{key_classify}_{key_classify_value}">
    <td>
        Phân loại hàng
    </td>
    <td>
     <input class="form-control" name="classify[{key_classify}][value][{key_classify_value}]" required="required" oninvalid="setCustomValidity('Vui lòng nhập phân loại')" oninput="setCustomValidity('')" onchange="change_value_name_group({key_classify},this,{key_classify_value})" value="{LOOP_classify_value}" />
 </td>
 <td>
     <button class="form-control" type="button" onclick="remove_value_name_group({key_classify},{key_classify_value})">
        Xóa
    </button>
</td>
</tr>
<!-- END: classify_value_first -->
<!-- BEGIN: classify_value_next -->
<tr id="classify_list_group_value_{key_classify}_{key_classify_value}">
    <td></td>
    <td>
     <input class="form-control" name="classify[{key_classify}][value][{key_classify_value}]" required="required" oninvalid="setCustomValidity('Vui lòng nhập phân loại')" oninput="setCustomValidity('')" onchange="change_value_name_group({key_classify},this,{key_classify_value})" value="{LOOP_classify_value}" />
 </td>
 <td>
     <button class="form-control" type="button" onclick="remove_value_name_group({key_classify},{key_classify_value})">
        Xóa
    </button>
</td>
</tr>
<!-- END: classify_value_next -->
<!-- END: classify_value -->
</tbody>
<tfoot>
 
</tfoot>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<!-- END: classify -->
<!-- END: edit_product2 -->
<!-- BEGIN: edit_product -->
<!-- BEGIN: classify -->
<div class="table-responsive" id="classifyfull_{key_classify}">
  <table class="table table-striped table-bordered table-hover full">
   <tbody id="classify_1">
    <tr>
     <td style="font-size:15px;font-weight:bold">
        Nhóm phân loại
    </td>
    <td>
    </td>
</tr>
<tr>
 <td colspan="2">
  <div class="table-responsive">
   <table class="table table-striped table-bordered table-hover full">
    <colgroup>
     <col class="w200"><col>
 </colgroup>
 <tbody id="classify_list_group_{key_classify}">
     <tr>
      <td>
        Tên phân loại
    </td>
    <td colspan="2">
       <input class="form-control" name="classify[{key_classify}][name]" oninvalid="setCustomValidity('Vui lòng nhập tên phân loại')" required="required" oninput="setCustomValidity('')" onkeyup="change_name_group({key_classify},this)" value="{LOOP_classify.name_classify}" />
   </td>
</tr>
<!-- BEGIN: classify_value -->
<!-- BEGIN: classify_value_first -->
<tr id="classify_list_group_value_{key_classify}_{LOOP_classify_value.id}">
    <td>Phân loại hàng</td>
    <td>
     <input class="form-control" name="classify[{key_classify}][value][{LOOP_classify_value.id}]" required="required" oninvalid="setCustomValidity('Vui lòng nhập phân loại')" oninput="setCustomValidity('')" onchange="change_value_name_group({key_classify},this,{LOOP_classify_value.id})" value="{LOOP_classify_value.name}" />
 </td>
 <td>
 </td>
</tr>
<!-- END: classify_value_first -->
<!-- BEGIN: classify_value_next -->
<tr id="classify_list_group_value_{key_classify}_{LOOP_classify_value.id}">
    <td></td>
    <td>
     <input class="form-control" name="classify[{key_classify}][value][{LOOP_classify_value.id}]" required="required" oninvalid="setCustomValidity('Vui lòng nhập phân loại')" oninput="setCustomValidity('')" onchange="change_value_name_group({key_classify},this,{LOOP_classify_value.id})" value="{LOOP_classify_value.name}" />
 </td>
 <td>
 </td>
</tr>
<!-- END: classify_value_next -->
<!-- END: classify_value -->
</tbody>
<tfoot>

</tfoot>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<!-- END: classify -->
<!-- END: edit_product -->
</td>
</tr>
<tr id="classify_product" class="{classify_check2}">
    <td colspan="3" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
        <strong>
            Danh sách phân loại hàng
        </strong>
    </td>
</tr>
<tr id="classify_product2" class="{classify_check2}">
  <td colspan="3" >
   <div class="table-responsive">
       <table class="table table-striped table-bordered table-hover full">
        <thead>
         <tr id="classify_product2_list">
          <!-- BEGIN: edit_classify_product2 -->
          <!-- BEGIN: classify -->
          <th id="name_classify_product2_{key_classify}">
             {LOOP_classify.name_classify}
         </th>
         <!-- END: classify -->
         <th>Giá sản phẩm (giá thường)</th>
         <!-- END: edit_classify_product2 -->
         <!-- BEGIN: edit_classify_product2_2 -->
         <!-- BEGIN: classify -->
         <th id="name_classify_product2_{key_classify}">
             {LOOP_classify.name}
         </th>
         <!-- END: classify -->
         <th>Giá sản phẩm (giá thường)</th>
         <!-- END: edit_classify_product2_2 -->
         <th class="w100"></th>
     </tr>
 </thead>
 <tbody id="data_classify_product2_list">
     <!-- BEGIN: edit_data_classify_product2_list_2 -->
     <!-- BEGIN: one -->
     <tr id="data_classify_product2_list_{LOOP_PRODUCT.id1_old}">
         <td id="data_classify_product2_list_name_{LOOP_PRODUCT.id1_old}">
          {LOOP_PRODUCT.id1}
          <input hidden="" name="product[{LOOP_PRODUCT.id1_old}][id1]" value="{LOOP_PRODUCT.id1_old}" /> 
      </td>
      <td>
          <input class="form-control" name="product[{LOOP_PRODUCT.id1_old}][price]" placeholder="Giá sản phẩm (giá thường)" required="required" oninvalid="setCustomValidity('Vui lòng nhập giá sản phẩm')" oninput="setCustomValidity('')" value="{LOOP_PRODUCT.price}" onkeyup="this.value=FormatNumber(this.value);" />
      </td>
      
      <td class="text-center">
          <div class="i-checks">
           <label class="toggle" for="change_status_2">
            <input hidden type="text" name="change_status[{product_classify_value_product_id}]" id="text_{product_classify_value_product_id}" value="{status}" />	
            <div class="icheckbox_square-green checked" style="position: relative;">
             <input type="checkbox" value="{status}" {status_checked} id="change_status_{product_classify_value_product_id}" />
             <div class="slider" onclick="change_status(this,'change_status_{product_classify_value_product_id}','text_{product_classify_value_product_id}')"></div>
         </div>
     </label>
 </div>
</td>
</tr>
<!-- END: one -->
<!-- BEGIN: two -->
<tr id="data_classify_product2_list_{LOOP_PRODUCT.id1_old}_{LOOP_PRODUCT.id2_old}">
 <td id="data_classify_product2_list_name_{LOOP_PRODUCT.id1_old}_{LOOP_PRODUCT.id2_old}_id1">
  {LOOP_PRODUCT.id1}
  <input hidden="" name="product[{LOOP_PRODUCT.id1_old}_{LOOP_PRODUCT.id2_old}][id1]" value="{LOOP_PRODUCT.id1_old}" /> 
</td>
<td id="data_classify_product2_list_name_{LOOP_PRODUCT.id1_old}_{LOOP_PRODUCT.id2_old}_id2">
  {LOOP_PRODUCT.id2}
  <input hidden="" name="product[{LOOP_PRODUCT.id1_old}_{LOOP_PRODUCT.id2_old}][id2]" value="{LOOP_PRODUCT.id2_old}" /> 
</td>
<td>
  <input class="form-control" name="product[{LOOP_PRODUCT.id1_old}_{LOOP_PRODUCT.id2_old}][price]" placeholder="Giá sản phẩm (giá thường)" required="required" oninvalid="setCustomValidity('Vui lòng nhập giá sản phẩm')" oninput="setCustomValidity('')" value="{LOOP_PRODUCT.price}" onkeyup="this.value=FormatNumber(this.value);" />
</td>

<td class="text-center">
  <div class="i-checks">
   <label class="toggle" for="change_status_2">
    <input hidden type="text" name="change_status[{product_classify_value_product_id}]" id="text_{product_classify_value_product_id}" value="{status}" />	
    <div class="icheckbox_square-green checked" style="position: relative;">
     <input type="checkbox" value="{status}" {status_checked} id="change_status_{product_classify_value_product_id}" />
     <div class="slider" onclick="change_status(this,'change_status_{product_classify_value_product_id}','text_{product_classify_value_product_id}')"></div>
 </div>
</label>
</div>
</td>
</tr>
<!-- END: two -->
<!-- END: edit_data_classify_product2_list_2 -->
<!-- BEGIN: edit_data_classify_product2_list -->
<!-- BEGIN: loop -->
<tr id="data_classify_product2_list_{data_array_full.id1}_{data_array_full.id2}">
 <td id="data_classify_product2_list_name_{data_array_full.id1}_{data_array_full.id2}_id1">
  {data_array_full.name1}
  <input hidden="" name="product[{data_array_full.id1}_{data_array_full.id2}][id1]" value="{data_array_full.id1}" /> 
</td>
<td id="data_classify_product2_list_name_{data_array_full.id1}_{data_array_full.id2}_id2">
  {data_array_full.name2}
  <input hidden="" name="product[{data_array_full.id1}_{data_array_full.id2}][id2]" value="{data_array_full.id2}" /> 
</td>
<td>
  <input class="form-control" name="product[{data_array_full.id1}_{data_array_full.id2}][price]" placeholder="Giá sản phẩm (giá thường)" required="required" oninvalid="setCustomValidity('Vui lòng nhập giá sản phẩm')" oninput="setCustomValidity('')" value="{LOOP_PRODUCT.price}" onkeyup="this.value=FormatNumber(this.value);" />
</td>

<td class="text-center">
  <div class="i-checks">
   <label class="toggle" for="change_status_2">
    <input hidden type="text" name="change_status[{product_classify_value_product_id}]" id="text_{product_classify_value_product_id}" value="{status}" />	
    <div class="icheckbox_square-green checked" style="position: relative;">
     <input type="checkbox" value="{status}" {status_checked} id="change_status_{product_classify_value_product_id}" />
     <div class="slider" onclick="change_status(this,'change_status_{product_classify_value_product_id}','text_{product_classify_value_product_id}')"></div>
 </div>
</label>
</div>
</td>
</tr>
<!-- END: loop -->
<!-- END: edit_data_classify_product2_list -->
<!-- BEGIN: edit_data_classify_product2_list_1 -->
<!-- BEGIN: loop -->
<tr id="data_classify_product2_list_{data_array_full.id1}">
 <td id="data_classify_product2_list_name_{data_array_full.id1}_id1">
  {data_array_full.name1}
  <input hidden="" name="product[{data_array_full.id1}][id1]" value="{data_array_full.id1}" /> 
</td>
<td>
  <input class="form-control" name="product[{data_array_full.id1}][price]" placeholder="Giá sản phẩm (giá thường)" required="required" oninvalid="setCustomValidity('Vui lòng nhập giá sản phẩm')" oninput="setCustomValidity('')" value="{LOOP_PRODUCT.price}" onkeyup="this.value=FormatNumber(this.value);" />
</td>

<td class="text-center">
  <div class="i-checks">
   <label class="toggle" for="change_status_2">
    <input hidden type="text" name="change_status[{product_classify_value_product_id}]" id="text_{product_classify_value_product_id}" value="{status}" />	
    <div class="icheckbox_square-green checked" style="position: relative;">
     <input type="checkbox" value="{status}" {status_checked} id="change_status_{product_classify_value_product_id}" />
     <div class="slider" onclick="change_status(this,'change_status_{product_classify_value_product_id}','text_{product_classify_value_product_id}')"></div>
 </div>
</label>
</div>
</td>
</tr>
<!-- END: loop -->
<!-- END: edit_data_classify_product2_list_1 -->
</tbody>
</table>
</div>
</td>
</tr>
<tr>
    <td colspan="3" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
        <strong>
            {LANG.illustration}
        </strong>
    </td>
</tr>
<tr>

    <td colspan="3">
        <div class="input-group col-sm-24 col-md-24">
            <input class="form-control" type="text" name="image" value="{ROW.image}"
            id="id_image" oninvalid="setCustomValidity(nv_required)"
            oninput="setCustomValidity('')" />
            <span class="input-group-btn">
                <button class="btn btn-default selectfile" type="button">
                    <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
                </button>
            </span>
        </div>
    </td>
</tr>
<tbody id="other_image_list">
   <!-- BEGIN: edit_other_image -->
   <!-- BEGIN: loop -->
   <tr id="other_image_tr_{key}">
      <td colspan="3">
       <div class="input-group col-md-24 col-sm-24">
        <input class="form-control" type="text" name="other_image[]" id="id_image_{key}" value="{LOOP}" /> <span class="input-group-btn">  
         <button class="btn btn-default selectfile_{key}" type="button">
          <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
      </button>
      <button type="button" class="btn btn-primary" onclick="remove_other_image({key})">Xóa</button>
  </span>
</div>
</td>
</tr>

<script>
  $(".selectfile_{key}").click(function() {
   var area = "id_image_{key}";
   var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
   var currentpath = "{currentpath}";
   var type = "image";
   nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
   return false;
});
  $('.unit_currency_{key}').select2({width:"100%"})
</script>
<!-- END: loop -->
<!-- END: edit_other_image -->
</tbody>

<tr>
    <td colspan="3" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
        <strong>
            {LANG.bodytext} <span>(*)</span>
        </strong>
    </td>
</tr>
<tr>
    <td colspan="3">
        {ROW.bodytext}
    </td>
</tr>
<tr>
    <td colspan="3" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
        <strong>
            {LANG.description_product} <span>(*)</span>
        </strong>
    </td>
</tr>
<tr>
    <td colspan="3">
        {ROW.description}
    </td>
</tr>

</tbody>

</table>
</div>
</div>
<div class="col-sm-4 col-md-5">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover full">

            <tbody>
                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            Sản phẩm thuộc các block
                        </strong>
                    </td>
                </tr>
                <!-- BEGIN: block -->
                <tr>
                    <td colspan="2">
                        <input type="checkbox" {block.checked} id="block_{block.key}" name="block[{block.key}]"
                        value="{block.key}" />
                        <label for="block_{block.key}"> 
                            {block.title}
                        </label>
                    </td>
                </tr>
                <!-- END: block -->
                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            Từ khóa dành cho máy chủ tìm kiếm
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input class="form-control" placeholder="Từ khóa dành cho máy chủ tìm kiếm"
                        type="text" name="keyword" value="{ROW.keyword}" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background: #3ea00b;color: #fff;text-transform: uppercase;">
                        <strong>
                            Tính năng mở rộng
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="checkbox" id="inhome" {check_inhome} name="inhome" value="1" />
                        <label for="inhome">
                            Hiển thị trên trang chủ
                        </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="checkbox" id="allowed_rating" {check_allowed_rating} name="allowed_rating" value="1" />
                        <label for="allowed_rating">
                            Cho phép đánh giá
                        </label>
                    </td>
                </tr>
                <tr class="hidden">
                    <td colspan="2">
                        <input type="checkbox" id="showprice" {check_showprice} name="showprice" value="1" />
                        <label for="showprice">
                            Cho phép hiển thị giá sản phẩm
                        </label>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
	
  $('.select2').select2();

  var other_image = []

  <!-- BEGIN: edit_other_imagejs -->
  <!-- BEGIN: loop -->
  other_image.push({"id":{key}})
  <!-- END: loop -->
  <!-- END: edit_other_imagejs -->
  <!-- BEGIN: insert_groupjs -->
  var group_list = [{"id":1}];
  <!-- END: insert_groupjs -->
  <!-- BEGIN: edit_groupjs -->
  var group_list = [];
  <!-- BEGIN: loop -->
  group_list.push({"id":{key_list}})
  <!-- END: loop -->
  <!-- END: edit_groupjs -->
  $('.unit_currency_1').select2({})
  $('.store_id').select2({placeholder:'Mời bạn chọn cửa hàng'})
  $('.unit_id').select2({})
  $('.unit_weight').select2({})
  $('.unit_length').select2({})
  $('.unit_width').select2({})
  $('.unit_height').select2({})
  function add_otherimage(){
    var id_next
    if(other_image.length == 0){
      id_next=1
  }else{
     id_next=other_image[other_image.length-1]['id']+1;
 }
 $('#other_image_list').append('<tr id="other_image_tr_'+id_next+'"><td colspan="3"><div class="input-group col-md-24 col-sm-24"><input class="form-control" type="text" name="other_image[]" id="id_image_'+id_next+'"  /> <span class="input-group-btn">  <button class="btn btn-default selectfile_'+id_next+'" type="button"><em class="fa fa-folder-open-o fa-fix">&nbsp;</em></button><button type="button" class="btn btn-primary" onclick="remove_other_image('+id_next+')">Xóa</button></span></div></td></tr>')
 $(".selectfile_"+id_next).click(function() {
    var area = "id_image_"+id_next;
    var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
    var currentpath = "{currentpath}";
    var type = "image";
    nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    return false;
});
 other_image.push({"id":id_next})
}

function nv_get_alias(id) {
   var title = strip_tags($("[name='name_product']").val());
   if (title != '') {
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=product_add&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title), function(res) {
     $("#"+id).val(strip_tags(res));
 });
}
return false;
}
$('#random_num').click(function() {
   $(this).parent('.input-group').children('input').val('{raw_product_prefix}' + generateCardNo(9));
});
$(".selectfile").click(function() {
   var area = "id_image";
   var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
   var currentpath = "{currentpath}";
   var type = "image";
   nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
   return false;
});
<!-- BEGIN: no_edit -->
$('#brand').select2();
$('#origin').select2();
<!-- END: no_edit -->

$('select[name=categories_id]').change(function() {
   var categories_id = $(this).find('option:selected').val();
   if(categories_id!={ROW.categories_id}){
      $("#brand").empty()
      $("#origin").empty()
  }
  $('#box_origin').removeClass('hidden');
  $('#box_brand').removeClass('hidden');
  $('#brand').select2({
    placeholder:"Chọn thương hiệu",
    ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=brand&cat_id='+categories_id,
        dataType: 'json',
        delay: 250,
        data: function (params) {
            var query = {
                q: params.term
            }
            return query;
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
}); 
  $('#origin').select2({
    placeholder:"Chọn xuất xứ", 
    ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=origin&cat_id='+categories_id,
        dataType: 'json',
        delay: 250,
        data: function (params) {
            var query = {
                q: params.term
            }
            return query;
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

})
<!-- BEGIN: edit2 -->
$('#brand').select2({
    placeholder:"Chọn thương hiệu",
    ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=brand&cat_id={ROW.categories_id}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            var query = {
                q: params.term
            }
            return query;
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});
$("#brand").select2("trigger", "select", {
   data: { id: {ROW.brand}, text: '{ROW.brand_name}'}
});
$('#box_origin').removeClass('hidden');
$('#box_brand').removeClass('hidden');
$('#origin').select2({
    placeholder:"Chọn xuất xứ", 
    ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=origin&cat_id={ROW.categories_id}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            var query = {
                q: params.term
            }
            return query;
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});
$("#origin").select2("trigger", "select", {
  data: { id: {ROW.origin}, text: '{ROW.origin_name}'}
});
<!-- END: edit2 -->
$('.categories_id11111').select2({
    placeholder: "<span>Mời bạn chọn chuyên mục sản phẩm</span>",
    ajax: {
      url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
      '={OP}&mod=get_categories', 
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
},
templateResult: function (d) { 
  return $(d.text); 
},
templateSelection: function (d) {
    return $(d.text); 
}
})
<!-- BEGIN: edit -->
$(".categories_id").select2("trigger", "select", {
  data: { id: {ROW.categories_id}, text: '{ROW.categories_name}'}
});
<!-- END: edit -->


function duyet_sanpham(id) {
        if (confirm(nv_is_change_act_confirm[0])) {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=product&change_status=1&id='+id, function(res) {
                var r_split = res.split('_');
                if (r_split[0] == 'OK') {
                    window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=product_disable';
                }
				else
				{
					alert('Duyệt sản phẩm thất bại!');
				}
            });
        }
        
        return;
}

</script>


<!-- END: main -->
