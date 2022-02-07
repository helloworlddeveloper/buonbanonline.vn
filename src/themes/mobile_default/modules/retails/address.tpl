<!-- BEGIN: main -->
	
	<!-- BEGIN: view -->
	<header class="bd_b_1 bg_white">
        <div class="login text-center">
            <p class="fs_18 py-3 mb-0">Địa Chỉ Nhận Hàng</p>
        </div>
    </header>
	<section>
		<div class="address bg_white  p-3 mb-1">
		 <a href="{address}" class="d-flex align-items-center">
			<i class="fa fa-plus-circle secondary_text fa-2x" aria-hidden="true"></i>
			<span class="secondary_text fs_12 px-3">Thêm địa chỉ mới</span>
		 </a>
		</div>
       
    </section>
   <!-- BEGIN: loop -->
    <section class="p-3 bg_white mb-2">
        <table class="table mb-0">
            <tbody>
                <tr>
                    <td class="border-0 p-0 fs_14 w-50">{VIEW.name}</td>
					<!-- BEGIN: default -->
                    <td class="border-0 p-0 fs_10 secondary_text fa fa-check" aria-hidden="true">Địa chỉ mặc định</td>
                    <!-- END: default -->
					<td class="border-0 p-0 fs_12 text_gray_color text-right" colspan="2" ><a href="{VIEW.link_edit}">Chỉnh sửa</a></td>
					<!-- BEGIN: delete -->
					<td class="border-0 p-0 fs_12 text_gray_color text-right" colspan="2" ><a onclick="return confirm(nv_is_del_confirm[0]);" href="{VIEW.link_delete}" >Xóa</a></td>
					<!-- END: delete -->
					
				</tr>
            </tbody>
        </table>
		<!-- <div class="d-flex"> -->
			<!-- <div class="w-"></div> -->
			<!-- <div></div> -->
		<!-- </div> -->
        <p class="mb-0 pt-2 text_gray_color">{VIEW.phone}</p>
        <p class="mb-1 pt-2 text_gray_color w-75">{VIEW.address}</p>
		
		<!-- BEGIN: set_default -->
		<button onclick="set_default({VIEW.id},{VIEW.userid})" class="btn_ecng_outline">Đặt làm địa chỉ mặc định</button>
		<!-- END: set_default -->
		
	
    </section>
				 <!-- END: loop -->
	 
	<!-- END: view -->
    
	<!-- BEGIN: edit -->

	

	<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">

	<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>

	<!-- BEGIN: error -->
	<div class="alert alert-warning">{ERROR}</div>
	<!-- END: error -->
	<header class=" pb-2 bd_b_1 bg_white">
        <div class="login pt-2 text-center">
            <p class="fs_18 mt-2">Địa Chỉ Nhận Hàng</p>
        </div>
    </header>
    <div class="bg_white" id="">
    
        <form id="form_add_address" class="form-horizontal px-1" action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />
			
			
			<div class="input-group mb-4 p-1 input_ecng" >
				<div >Họ & tên</div>
					<div class="input_error_noIcon">
						<input type="text" name="name" value="{ROW.name}" class="form-control form-control-underlined" placeholder="Nhập họ tên" required="required">
					</div>
			</div>
			<div class="input-group mb-4 p-1 input_ecng {show_email}" >
				<div >Email</div>
					<div class="input_error_noIcon">
						<input type="text" name="email" value="{ROW.email}" class="form-control form-control-underlined" placeholder="Nhập email" required="required">
					</div>
			</div>
			<div class="input-group mb-4 p-1 input_ecng" >
				<div>Số điện thoại</div>
					<div class="input_error_noIcon">
						<input  name="phone" maxlength="10" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="{ROW.phone}" class="form-control form-control form-control-underlined" placeholder="Nhập số điện thoại" required="required">
				</div>
			</div>
			
           
        
        <div class="mb-4 h-50 p-1">
            <div>Chọn tỉnh thành</div>
                <div class="input_error_noIcon">
					<select id="province_id" name="province_id" onchange="change_province_order(this)"  required="required" class="form-control border-0">
					<option value="" >
						Tỉnh thành
					</option>
					 <!-- BEGIN: province_id -->
					 <option value="{STATUS.provinceid}" {STATUS.selected}>
						{STATUS.title}
					</option>
					<!-- END: province_id -->
					</select>				
				</div>
		</div>
    <div class="mb-4 h-50 p-1">
		<div>Chọn quận huyện</div>
		 
				<div class="input_error_select">
					<select id="district_id" name="district_id" onchange="change_district_order(this)"  class="form-control border-0" {DIS} >
					 <!-- BEGIN: district_id -->
					 <option value="{STATUS.districtid}" {STATUS.selected}>
						{STATUS.title}
					</option>
					<!-- END: district_id -->
					</select>
				</div>
		
	</div>
	
	<div class="px-2 pb-4">
			 <div>Chọn phường, xã</div>
		 
			<div class="input_error_select">
				<select id="ward_id" name="ward_id" class="form-control border-0" {DIS}>
				 <!-- BEGIN: ward_id -->
				 <option value="{STATUS.wardid}" {STATUS.selected}>
					{STATUS.title}
				</option>
				<!-- END: ward_id -->
				</select>
			</div>	
	</div>
	
	<div class="input-group mb-4 p-1 input_ecng mb-3" >
		<div>Số nhà, tên đường</div>
			<div class="input_error_noIcon">
				<input  type="text" class="form-control form-control form-control-underlined" name="maps_address" id="maps_address" placeholder="Nhập địa chỉ" value="{AD}">
		</div>
	</div>
	

<!-- BEGIN: view1 -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 10px;">
<div class="input_error_noIcon">		
    <input type="checkbox" id="status" name="status" value="1">
	</div>
    <label for="status"> 
       Đặt làm địa chỉ mặc định
   </label>

   
</div>
<!-- END: view1 -->


<div class="form-group" style="text-align: center">
    <input class="btn_ecng w-100 p-3 fs_16 {show_submit1}" name="submit" type="submit" value="{LANG.save}" />
    <!-- Lưu địa chỉ không cần login -->
    <input id="submit_no_login" class="btn_ecng w-100 p-3 fs_16 {show_submit}" name="submit" type="submit" value="{LANG.save}" />
</div>
</form>



    <script>
        $("#form_add_address").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 4,
                },

                phone: {
                    required: true,
                    sdt: true,
                },
                email: {
                    required: true,
                    email: true,
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
                    minlength: "Vui lòng nhập ít nhất 4 ký tự ",
                },
                email: {
                    required: "Vui lòng nhập email",
                    email:"Email chưa nhập đúng định dạng"
                },
                phone: {
                    required: "Chưa nhập số điện thoại",
                    // sdt: true,
                },
                maps_address: {
                    required: "Vui lòng nhập địa chỉ",
                    minlength: "Vui lòng nhập ít nhất 4 ký tự ",
                },
                province_id: {
                    required: "Chưa nhập tỉnh / thành phố",
                },
                district_id: {
                    required: "Chưa nhập quận / huyện",
                },
                ward_id: {
                    required: "Chưa nhập phường / xã",
                }

            }
        });
    </script>
    <!-- header  -->
	<script type="text/javascript">
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
<script>
	
	function set_default(id, userid){
        $.ajax({
            type : 'POST',
            url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=set_default&id=' + id + '&userid=' + userid,
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