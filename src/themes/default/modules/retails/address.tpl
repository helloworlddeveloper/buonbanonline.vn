<!-- BEGIN: main -->

 <div class="bg_white" style="min-height: 378px">
 
				
<!-- BEGIN: view -->
	<div class="d-flex justify-content-between p-4">
		<div class=" fs_20">Địa Chỉ Nhận Hàng</div>
	   <a href="{address}" class="btn_ecng_outline" onclick="newDoc()">+ Thêm địa chỉ</a>
	</div>
	 <!-- BEGIN: loop --> 
   <div class="address_info px-4 my-3">
		<div class="row border p-2">
			<div class="col-md-8 col-xl-9">
				<p class="mb-1">
					<span class="text_gray_color">Họ và tên</span>
					<span class="mx-4">{VIEW.name}</span>
					<!-- BEGIN: default -->
					<span class="secondary_text"><i class="fa fa-check" aria-hidden="true"></i> Địa chỉ mặc định</span>
					<!-- END: default -->
				</p>
				<p class="text_gray_color mb-1">
					{VIEW.address}
				</p>
				<p class="text_gray_color mb-0">
					Số Điện Thoại: {VIEW.phone}
				</p>
			</div>
			<div class="col-md-4 col-xl-3 p-2">
				<div class="d-flex justify-content-between align-items-start mb-3">
					<a class="btn_none text_gray_color" href="{VIEW.link_edit}">Chỉnh sửa</a>
					<!-- BEGIN: delete -->
					<a onclick="return confirm(nv_is_del_confirm[0]);" href="{VIEW.link_delete}" class="btn_none text_red mr-3">Xóa</a>
					<!-- END: delete -->
				</div>
				<!-- BEGIN: set_default -->
				<button onclick="set_default({VIEW.id})" class="btn_ecng_outline">Đặt làm địa chỉ mặc định</button>
				<!-- END: set_default -->
			</div>
		</div>
	</div>
	 <!-- END: loop -->
<!-- END: view -->


<!-- BEGIN: edit -->
	<div class="d-flex justify-content-between p-4">
		<div class=" fs_20">Địa Chỉ Nhận Hàng</div>
                   
	</div>


<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<div class="panel panel-default" id="add_address">
    <div class="panel-body">
        <form class="form-horizontal" action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" id="form_add_address">
            <input type="hidden" name="id" value="{ROW.id}" />
			<div class="row">			  
			  <div class="col-9 p-4">
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Họ và tên(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 border rounded-lg  input_ecng">
							<div class="input_error_noIcon">
								<input type="text" name="name" value="{ROW.name}" class="form-control bg-none border-0 " required="required"  maxlength="45">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row {show_email} ">
					<label for="staticEmail" class="col-3 col-form-label">Email(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 border rounded-lg  input_ecng">
							<div class="input_error_noIcon">
								<input type="text" name="email" value="{ROW.email}" onkeypress="validErrorHidden(this);" data-mess="{GLANG.email_empty}" class="form-control bg-none border-0 required" required="required"  maxlength="100">
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Số điện thoại(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 border rounded-lg  input_ecng">
							<div class="input_error_noIcon">
								<input name="phone" maxlength="10" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="{ROW.phone}" class="form-control bg-none border-0 " required="required">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Chọn tỉnh thành(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 rounded-lg  input_ecng">
							<div class="input_error_noIcon w-100">
								<select id="province_id" name="province_id" required="required" class="form-control">
								<!-- BEGIN: province_id -->
									<option value="{STATUS.provinceid}" {STATUS.selected}>
									{STATUS.title}
									</option>
								<!-- END: province_id -->
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Chọn quận, huyện(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 rounded-lg  input_ecng">
							<div class="input_error_noIcon w-100">
								<select id="district_id" name="district_id" required="required" class="form-control" {DIS} >
								 <!-- BEGIN: district_id -->
								 <option value="{STATUS.districtid}" {STATUS.selected}>
									{STATUS.title}
								</option>
								<!-- END: district_id -->
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Chọn phường, xã(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 rounded-lg  input_ecng">
							<div class="input_error_noIcon w-100">
								<select id="ward_id" name="ward_id"  required="required" class="form-control" {DIS}>
								 <!-- BEGIN: ward_id -->
								 <option value="{STATUS.wardid}" {STATUS.selected}>
									{STATUS.title}
								</option>
								<!-- END: ward_id -->
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Số nhà, tên đường(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 border rounded-lg  input_ecng">
							<div class="input_error_noIcon">
								<input type="text" name="maps_address" id="maps_address" placeholder="Nhập địa chỉ" value="{AD}" class="form-control bg-none border-0 " required="required"  maxlength="150">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row {show_submit1}">
					<div class="col-3">
					</div>
					<div class="col-9 d-flex">
					
					<label class="ecng_label_checkbox">
                        <input {checked} type="checkbox" value="1" name="status">
                        <span class="ecng_checkmark"></span>
					</label>
						<div class="ml-3">
								Đặt làm địa chỉ mặc định
						</div>
					</div>
				</div>
			  </div>
			</div>

<!-- BEGIN: view1 -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 10px;">
    <input type="checkbox" id="status" name="status" value="1">
    <label for="status"> 
       Đặt làm địa chỉ mặc định
   </label>
</div>
<!-- END: view1 -->




<div class="form-group pb-4" style="text-align: center">
    <input class="btn_ecng {show_submit1}" name="submit" type="submit" value="{LANG.save}" />
    <!-- Lưu địa chỉ không cần login -->
    <input id="submit_no_login" class="btn_ecng {show_submit}" name="submit" type="submit" value="{LANG.save}" />
</div>
</form>
</div>
</div>

<script type="text/javascript">


        $("#form_add_address").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 4,
                },
                email: {
                    required: true,
                    email: true,
                },

                phone: {
                    required: true,
                    sdt: true,
                },
                maps_address: {
                    required: true,
                    minlength: 4,
                },

                province_id: {
                    required: true,
                },
                district_id: {
                    required: true,
                },
                ward_id: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Vui lòng nhập tên",
                    minlength: "Vui lòng nhập ít nhất 4 ký tự "
                },
                email: {
                    required: "Vui lòng nhập email",
                    email:"Email chưa nhập đúng định dạng"
                },

                phone: {
                    required: "Vui lòng nhập số điện thoại",
                    // sdt: true,
                },
                maps_address: {
                    required: "Vui lòng nhập địa chỉ",
                    minlength: "Vui lòng nhập ít nhất 4 ký tự ",
					
                },
                province_id: {
                    required: "Vui lòng nhập tỉnh / thành phố",
                },
                district_id: {
                    required: "Vui lòng nhập quận / huyện",
                },
                ward_id: {
                    required: "Vui lòng nhập phường / xã",
                }

            }
        });
		
	
    $('#province_id').select2({
        placeholder:'Chọn tỉnh thành',
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=province_id',
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
    }).on('change', function (e) {
        document.getElementById("district_id").disabled = false; 
        document.getElementById("ward_id").disabled = false; 
        var province_id = $('#province_id').val();
        $('#district_id').empty();
        $('#ward_id').empty();
        $('#district_id').select2({
            placeholder:'Chọn quận huyện',
            ajax: {
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=district_id&province_id=' + province_id,
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
        }).on('change', function (e) {
            var district_id = $('#district_id').val();
            $('#ward_id').empty();
            $('#ward_id').select2({
                placeholder:'Chọn xã phường',
                ajax: {
                    url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=ward_id&district_id=' + district_id,
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
            })
        })
    });

    $('#district_id').select2({

    }).on('change', function (e) {
        var district_id = $('#district_id').val();
        $('#ward_id').empty();
        $('#ward_id').select2({
            placeholder:'Chọn xã phường',
            ajax: {
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=ward_id&district_id=' + district_id,
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
        })
    })
    $('#ward_id').select2({

    })
    async function change_address_order(a){
        var province_name = $('#province_id').find('option:selected').text();
        var district_name = $('#district_id').find('option:selected').text();
        var ward_name = $('#ward_id').find('option:selected').text();
        var address = $('#address').val();
        var address_full = ''
        if(address !=''){
         address_full = address
         if(ward_name!=''){
            address_full = await address_full +','+ward_name
        }
        if(district_name!=''){
            address_full = await address_full +', '+district_name
        }
        if(province_name!=''){
            address_full = await address_full +', '+province_name
        }
    }else{
     if(ward_name!=''){
        address_full = await ward_name
    }
    if(district_name!=''){
        address_full = await address_full +', '+district_name
    }
    if(province_name!=''){
       address_full = await address_full +', '+province_name
   }
}
document.getElementById('maps_address').value = await address_full
initializeMap();
}
async function change_ward_order(a){
    var province_name = $('#province_id').find('option:selected').text();
    var district_name = $('#district_id').find('option:selected').text();
    var ward_name = $('#ward_id').find('option:selected').text();
    var address = $('#address').val();
    var address_full='';

    if(address !=''){
     address_full = address
     if(ward_name!=''){
        address_full = await address_full +', '+ward_name
    }
    if(district_name!=''){
        address_full = await address_full +', '+district_name
    }
    if(province_name!=''){
        address_full = await address_full +', '+province_name
    }
}else{
 if(ward_name!=''){
    address_full = await ward_name
}
if(district_name!=''){
    address_full = await address_full +', '+district_name
}
if(province_name!=''){
   address_full = await address_full +', '+province_name
}
}
document.getElementById('maps_address').value = await address_full
initializeMap();
}
</script>
<!-- END: edit -->


</div>

<script>
	
	function set_default(id){
        $.ajax({
            type : 'POST',
            url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=set_default&id=' + id,
            success : function(res){
                res2=JSON.parse(res);
                if(res2.status=="OK"){
                    location.reload();
                    
                }else{
                    alert('Có lỗi xảy ra!');
                    
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    $("#submit_no_login").click(function(e) {
			e.preventDefault();
			$.ajax({               
                type: "GET", 
                dataType:'JSON',
                url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=address_no_login',
                data: $('#form_add_address').serialize(),
                beforeSend: function() {
                    
                },	               
                complete: function() {
                    
                },                 
                success: function(res) {
                    if(res.status == 'OK'){
                        window.location = res.link;
                    }else{
                        alert(res.mess);
                    }
                    //window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=retails' . '&' . NV_OP_VARIABLE . '=order',true).'";
                    // window.location = "'.nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=retails' . '&' . NV_OP_VARIABLE . '=address&id=0',true).'";
                },                 
                error: function(xhr, ajaxOptions, thrownError) {
                    
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }                  
		    }); 
	});
	
</script>
       
<!-- END: main -->