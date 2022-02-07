<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>


<div class="complain_vandon">
	<div class="thongtin_khachhang">
		
		<div class="form-group">
			<label class="col-sm-12 col-md-12 control-label"><strong>Thông tin sản phẩm</strong></label>
			<div class="col-sm-12 col-md-12">
				<!-- BEGIN: loop_send -->
				<div class="thongtinsanpham_complain">
					<input checked="checked" style="height: 20px;width: 20px;position: relative;top: 5px;margin-right: 10px;" type="checkbox" name="products[]" value="{VIEW.id_product}" /> <label>{VIEW.name_product} {VIEW.name_group}</label> - Số lượng {number}
				</div>
				<!-- END: loop_send -->
			</div>
		</div>
		
		
		<div class="panel panel-default">
			<div class="panel-heading">Thông tin người gửi</div>
			<div class="panel-body">
				
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
					<label for="staticEmail" class="col-3 col-form-label">Địa chỉ cụ thể(<span class="text_red">*</span>) </label>
					<div class="col-9">
						<div class="input-group mb-4 border rounded-lg  input_ecng">
							<div class="input_error_noIcon">
								<input type="text" name="address" placeholder="Nhập địa chỉ" value="{info_order.address}" class="form-control bg-none border-0 " required="required"  maxlength="70">
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">Thông tin người nhận</div>
			<div class="panel-body">
				
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Tên cửa hàng</label>
					<div class="col-9">
						<div class="input-group mb-4">
							{info_store.company_name}
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-3 col-form-label">Địa chỉ</label>
					<div class="col-9">
						<div class="input-group mb-4">
							{info_warehouse.address}
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
		
		<!-- BEGIN: seller1111 -->
		<div class="phivanchuyen">
			Phí vận chuyển: 
			<!-- BEGIN: seller -->
			Cửa hàng chịu
			<!-- END: seller -->
			
			<!-- BEGIN: khach_hang -->
			<span class="price_vc"></span>
			
			<script>
				
				$('#ward_id').change(function(){
				get_price_vn_vnpost({order_id});
				});
				
				function get_price_vn_vnpost(order_id)
				{
				var province_id = $('#province_id').val();					
				var district_id = $('#district_id').val();					
				var ward_id = $('#ward_id').val();					
				
				$.ajax({               
				type: "GET",      
				dataType: 'json',  
				url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=complain-vandon',
				data: {get_price_vc : 1, order_id_ajax : order_id, province_id : province_id, district_id : district_id, ward_id : ward_id},
				success: function(json) {
				
				console.log(json);
				if( json['status'] == 'OK' )
				{              
				$('.price_vc').html(json['price_format'] + ' đ');
				}
				else
				{
				alert(json['mess']);
				}
				
				},                 
				error: function(xhr, ajaxOptions, thrownError) {
				
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}                  
				});   
				}
			</script>
			<!-- END: khach_hang -->
			
			
		</div>
		<!-- END: seller1111 -->
		
	</div>
	
	<div class="button_xacnhan text-center"><button class="btn btn_ecng" onclick="send_vnpost_khieunai({order_id});">Lên đơn vận chuyển</button></div>
	
</div>



<script type="text/javascript">
	
	function send_vnpost_khieunai(order_id)
	{
		var province_id = $('#province_id').val();
		if(province_id == '')
		{
			alert('Chưa chọn tỉnh thành gửi!');
			return false;
		}
		
		var district_id = $('#district_id').val();
		if(district_id == '')
		{
			alert('Chưa chọn quận huyện gửi!');
			return false;
		}
		
		var ward_id = $('#ward_id').val();
		if(ward_id == '')
		{
			alert('Chưa chọn xã phường gửi!');
			return false;
		}
		
		var address = $('input[name=address]').val();
		if(address == '')
		{
			alert('Chưa nhập địa chỉ gửi!');
			$('input[name=address]').focus();
			return false;
		}
		
		$.ajax({               
			type: "GET",      
			dataType: 'json',  
			url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=complain-vandon',
			data: {send_vc_khieunai : 1, order_id_ajax : order_id, province_id : province_id, district_id : district_id, ward_id : ward_id, address : address},
			beforeSend: function() {
				$('.button_xacnhan').prop('disabled', true);
			},	               
			complete: function() {
				$('.button_xacnhan').prop('disabled', false);
			},                 
			success: function(json) {
				
				console.log(json);
				if( json['status'] == 'OK' )
				{              
					alert('Lên đơn vận chuyển thành công!');
					window.location.href = nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=complain-list';
				}
				else
				{
					alert(json['mess']);
				}
				
			},                 
			error: function(xhr, ajaxOptions, thrownError) {
				
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}                  
		});                    
		
	}
	
	$('#province_id').select2({
		placeholder:'Chọn tỉnh thành',
		ajax: {
			url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=address&mod=province_id',
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
                url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=address&mod=district_id&province_id=' + province_id,
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
                    url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=address&mod=ward_id&district_id=' + district_id,
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
                url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=address&mod=ward_id&district_id=' + district_id,
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
	
	
</script>

<!-- END: main -->										