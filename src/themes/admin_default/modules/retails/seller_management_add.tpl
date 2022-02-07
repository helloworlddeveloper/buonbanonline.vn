<!-- BEGIN: main -->
<style>
	.select2-container{
		width: 100% !important
	}
</style>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/js/bds_google_maps.js"></script>
<input type="hidden" id="maps_appid" value="AIzaSyB0SOamEOOpjGpVd3zIM3d3mlDkfNJozVY" />

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<input type="hidden" name="id" value="{ROW.id}" />
			<input type="hidden" name="userid" value="{ROW.userid}" />
			<p class="text-center" style="font-weight:bold;font-size:20px">
				Thông tin tài khoản
			</p>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						Tên đăng nhập
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control lowercase" {check} type="text" name="username" value="{ROW.username}" required="required" oninvalid="setCustomValidity('{LANG.validate_username}')" oninput="setCustomValidity('')" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>Email</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control lowercase" type="email" name="email" value="{ROW.email}" required="required" oninvalid="setCustomValidity('{LANG.validate_email}')" oninput="setCustomValidity('')" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						Số điện thoại
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control" type="tel" maxlength="11" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="phone" id="phone" maxlength="11" value="{ROW.phone}" required="required"  />
				</div>
			</div>
			<!-- BEGIN: edit -->
			<p class="text-center" style="font-weight:bold;font-size:20px">

				Bỏ trống trường mật khẩu nếu không muốn thay đổi
			</p>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>Mật khẩu</strong>
				</label>
				<div class="col-sm-19 col-md-20">
					<input autocomplete="false" readonly onfocus="this.removeAttribute('readonly');"  class="form-control" type="password" name="password" value="{ROW.password}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>Nhập lại mật khẩu</strong>
				</label>
				<div class="col-sm-19 col-md-20">
					<input autocomplete="false" readonly onfocus="this.removeAttribute('readonly');"  class="form-control" type="password" name="password2" value="{ROW.password2}" />
				</div>
			</div>
			<!-- END: edit -->
			<!-- BEGIN: noedit2 -->
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>Mật khẩu</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control" type="password" name="password" value="{ROW.password1}" required="required"   />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>Nhập lại mật khẩu</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control" type="password" name="password2" value="{ROW.password2}" required="required"  />
				</div>
			</div>
			<!-- END: noedit2 -->
			<p class="text-center" style="font-weight:bold;font-size:20px">
				Thông tin gian hàng
			</p>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						{LANG.company_name}
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control" type="text" name="company_name" value="{ROW.company_name}" required="required" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						{LANG.store_code}
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control uppercase" type="text" name="store_code" value="{ROW.store_code}" required="required" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						{LANG.company_code}
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control uppercase" type="text" name="company_code" value="{ROW.company_code}" required="required" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>{LANG.address_seller}</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<div class="col-md-6">
						<select class="form-control province_id_shop" required oninvalid="setCustomValidity('{LANG.validate_province_id}')" oninput="setCustomValidity('')"  name="province_id_shop">
						</select>
					</div>
					
					<div class="col-md-6">
						<select class="form-control district_id_shop" required oninvalid="setCustomValidity('{LANG.validate_district_id}')" oninput="setCustomValidity('')"  name="district_id_shop">
						</select>
					</div>
					<div class="col-md-6">
						<select class="form-control ward_id_shop" required oninvalid="setCustomValidity('{LANG.validate_ward_id}')" oninput="setCustomValidity('')"  name="ward_id_shop">
						</select>
					</div>
					<div class="col-md-6">
						<input class="form-control" type="text" name="address_shop" value="{ROW.address}" placeholder="Địa chỉ ngắn gọn" required="required" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_address}')" oninput="setCustomValidity('')" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>{LANG.name}</strong>
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control" type="text" name="name" value="{ROW.name}" required="required"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						Số điện thoại người đại diện
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control" type="tel"  maxlength="11" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="phone_representative" value="{ROW.phone_representative}" required="required"  oninput="this.setCustomValidity('')" oninvalid="setCustomValidity('{LANG.validate_phone}')" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						Email người đại diện
					</strong>
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<input class="form-control lowercase" type="email" name="email_representative" value="{ROW.email_representative}" required="required" oninvalid="setCustomValidity('{LANG.validate_email}')" oninput="setCustomValidity('')" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						Mô tả shop
					</strong>
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<textarea name="description_shop" rows="5" class="form-control">{ROW.description_shop}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						{LANG.image_before}
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<div class="input-group">
						<input class="form-control" type="text" name="image_before" value="{ROW.image_before}" id="id_image_before" required oninvalid="this.setCustomValidity(this.willValidate?'':'{LANG.validate_image_before_business_license}')" oninput="setCustomValidity('')" />
						<span class="input-group-btn">
							<button class="btn btn-default selectfile" type="button" >
								<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
							</button>
						</span>
					</div>
					<img src="{ROW.image_before}" style="height: 70px;width: 70px;">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						{LANG.image_after}
					</strong>
				</label>
				<div class="col-sm-19 col-md-20">
					<div class="input-group">
						<input class="form-control" type="text" name="image_after" value="{ROW.image_after}" id="id_image_after"/>
						<span class="input-group-btn">
							<button class="btn btn-default selectfile2" type="button" >
								<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
							</button>
						</span>
					</div>
					<img src="{ROW.image_after}" style="height: 70px;width: 70px;">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						Ảnh đại diện
					</strong> 
					<span class="red">(*)</span>
				</label>
				<div class="col-sm-19 col-md-20">
					<div class="input-group">
						<input class="form-control" type="text" name="avatar_image" value="{ROW.avatar_image}" id="avatar_image" required oninvalid="this.setCustomValidity(this.willValidate?'':'Vui lòng chọn ảnh đại diện')" oninput="setCustomValidity('')" />
						<span class="input-group-btn">
							<button class="btn btn-default selectfile3" type="button" >
								<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
							</button>
						</span>
					</div>
					<img src="{ROW.avatar_image}" style="height: 70px;width: 70px;">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>
						Ảnh bìa
					</strong> 
				</label>
				<div class="col-sm-19 col-md-20">
					<div class="input-group">
						<input class="form-control" type="text" name="cover_image" value="{ROW.cover_image}" id="cover_image"/>
						<span class="input-group-btn">
							<button class="btn btn-default selectfile4" type="button" >
								<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
							</button>
						</span>
					</div>
					<img src="{ROW.cover_image}" style="height: 70px;width: 70px;">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label">
					<strong>Hình ảnh</strong>
				</label>
				<div class="col-sm-19 col-md-20">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="customFields">
							<tbody id="addslider">
								<!-- BEGIN: image_banner -->
								<tr >
									<td>
										<img src="{IMG_BANNER}" style="height:60px;width: 80px;float: left; margin-right:10px;"/>
										<input value="{IMG_BANNER}" name="img[]" id="img1_{IMG_BANNER_ID}" class="form-control" style="width:55%; margin-bottom:3px;" maxlength="255"/>
										<input value="{LANG.select_img}" name="selectslider" onclick="nv_open_browse( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=img1_{IMG_BANNER_ID}&path={NV_UPLOADS_DIR}/{MODULE_NAME}&currentpath={UPLOAD_CURRENT_BLOCK}&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; " type="button" class="btn btn-info"/>
										<input type="button" class="btn btn-info" value="Xóa" onclick="nv_remove_slider({TMS.id});"/>    
									</td>
								</tr>
								<!-- END: image_banner -->		


							</table>

						</div>

						<div class="row text-center">
							<a onclick="add_slider();" class="btn btn-danger ">
								Thêm hình ảnh
							</a> 
						</div>
						<script type="text/javascript">
							var file_selectfile = 'Chọn hình ảnh';
							var nv_base_adminurl = '{NV_BASE_ADMINURL}';
							var file_dir = '{NV_UPLOADS_DIR}/{MODULE_NAME}';
							var currentpath = '{UPLOAD_CURRENT_CAT}';
							var file_items_slider = '{TMS_STT}';
							//Number items other images
							function add_slider() {
								var newitem = "<tr id=\"delslider_" + file_items_slider + "\">";
								newitem += "<td><span style=\"height:60px;width: 80px;float: left; margin-right:10px;\"/></span><input class=\"form-control\" value=\"\" name=\"img[]\" id=\"img_" + file_items_slider + "\" style=\"width :72%; margin-bottom:3px;\" maxlength=\"255\" />&nbsp;<input type=\"button\" class=\"btn btn-info\" value=\"" + file_selectfile + "\" name=\"selectfile\" onclick=\"nv_open_browse( '" + nv_base_adminurl + "index.php?" + nv_name_variable + "=upload&popup=1&area=img_" + file_items_slider + "&path=" + currentpath + "&type=file&currentpath=" + currentpath + "', 'NVImg', 850, 400, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" /> <input type=\"button\" class=\"btn btn-info\" value=\"Xóa\" onclick=\"nv_remove_slider(" + file_items_slider + ");\"/></td></tr>";
								$("#addslider").append(newitem);
								file_items_slider++;
							}
							function nv_remove_slider( id ) { $('#delslider_'+id).remove();}
						</script> 
					</div>

				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-4 control-label">
						<strong>
							{LANG.bank_id}
						</strong> 
						<span class="red">(*)</span>
					</label>
					<div class="col-sm-19 col-md-20">
						<select class="form-control bank_id" name="bank_id">
							<option value=""> --- </option>
							<!-- BEGIN: select_bank_id -->
							<option value="{OPTION.key}" {OPTION.selected}>
								{OPTION.title}
							</option>
							<!-- END: select_bank_id -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-4 control-label">
						<strong>
							{LANG.branch_id}
						</strong> 
						<span class="red">(*)</span>
					</label>
					<div class="col-sm-19 col-md-20">
						<input class="form-control" type="text" name="branch_name" value="{ROW.branch_name}" required="required" oninvalid="setCustomValidity('{LANG.validate_branch_id}')" oninput="setCustomValidity('')" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_name}</strong> <span class="red">(*)</span></label>
					<div class="col-sm-19 col-md-20">
						<input class="form-control" type="text" name="acount_name" value="{ROW.acount_name}" required="required" oninvalid="setCustomValidity('{LANG.validate_acount_name}')" oninput="setCustomValidity('')" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.acount_number}</strong> <span class="red">(*)</span></label>
					<div class="col-sm-19 col-md-20">
						<input class="form-control" type="text" name="acount_number" value="{ROW.acount_number}" required="required" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_acount_number}')" oninput="setCustomValidity('')" />
					</div>
				</div>
				<p class="text-center" style="font-weight:bold;font-size:20px">Thông tin kho hàng</p>
				<div class="controls table-controls">
					<table id="poTable" class="table items table-striped table-bordered table-condensed table-hover sortable_table">
						<thead>
							<tr>
								<th class="text-center">Tên kho hàng</th>
								<th class="text-center">Tên người gởi</th>
								<th class="text-center">Số điện thoại người gởi </th>
								<th class="text-center">Địa chỉ người gởi</th>
							</tr>
						</thead>
						<tbody class="ui-sortable warehouse">
							<!-- BEGIN: add_warehouse -->
							<tr id="warehouse_list">
								<td>
									<input class="form-control hidden" type="text" name="warehouse_id" value="{ROW1.warehouse_id}"  />
									<input class="form-control" type="text" name="name_warehouse" value="{ROW1.name_warehouse}" required="required" placeholder="Tên kho hàng" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_name_warehouse}')" oninput="setCustomValidity('')" />
								</td>
								<td>
									<input class="form-control" type="text" name="name_send" placeholder="Tên người gởi" value="{ROW1.name_send}" required="required" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_name_send}')" oninput="setCustomValidity('')" />
								</td>
								<td>
									<input class="form-control" type="tel"  maxlength="11" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="phone_send" placeholder="Số điện thoại người gởi" value="{ROW1.phone_send}" required="required"  oninput="this.setCustomValidity('')" oninvalid="setCustomValidity('{LANG.validate_phone}')" />
								</td>
								<td>
									<div class="col-md-6">
										<select class="form-control province_id" required oninvalid="setCustomValidity('{LANG.validate_province_id}')" oninput="setCustomValidity('')"  name="province_id" >
										</select>
									</div>
									<div class="col-md-6">
										<select class="form-control district_id" required oninvalid="setCustomValidity('{LANG.validate_district_id}')" oninput="setCustomValidity('')"  name="district_id">
										</select>
									</div>
									<div class="col-md-6">
										<select class="form-control ward_id" required oninvalid="setCustomValidity('{LANG.validate_ward_id}')" oninput="setCustomValidity('')"  name="ward_id"> 
										</select>
									</div>
									<div class="col-md-6">
										<input class="form-control address" type="text" name="address" value="{ROW1.address}"  placeholder="Địa chỉ ngắn gọn" required="required" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_address}')" oninput="setCustomValidity('')" />

									</div>
									
								</td>
							</tr>
							<!-- END: add_warehouse -->
							
							<!-- BEGIN: edit_warehouse -->
							<script>
								var warehouse=[]
							</script>
							

							<tr id="warehouse_list">
								<td>
									<input class="form-control hidden" type="text" name="warehouse_id" value="{ROW1.warehouse_id}"  />
									<input class="form-control" type="text" name="name_warehouse" value="{ROW1.name_warehouse}" required="required" placeholder="Tên kho hàng" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_name_warehouse}')" oninput="setCustomValidity('')" />
								</td>
								<td>
									<input class="form-control" type="text" name="name_send" placeholder="Tên người gởi" value="{ROW1.name_send}" required="required" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_name_send}')" oninput="setCustomValidity('')" />
								</td>
								<td>
									<input class="form-control" type="tel"  maxlength="11" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="phone_send" placeholder="Số điện thoại người gởi" value="{ROW1.phone_send}" required="required"  oninput="this.setCustomValidity('')" oninvalid="setCustomValidity('{LANG.validate_phone}')" />
								</td>
								<td>
									<div class="col-md-6">
										<select class="form-control province_id" required oninvalid="setCustomValidity('{LANG.validate_province_id}')" oninput="setCustomValidity('')"  name="province_id" >
										</select>
									</div>
									<div class="col-md-6">
										<select class="form-control district_id" required oninvalid="setCustomValidity('{LANG.validate_district_id}')" oninput="setCustomValidity('')"  name="district_id">
										</select>
									</div>
									<div class="col-md-6">
										<select class="form-control ward_id" required oninvalid="setCustomValidity('{LANG.validate_ward_id}')" oninput="setCustomValidity('')"  name="ward_id"> 
										</select>
									</div>
									<div class="col-md-6">
										<input class="form-control address" type="text" name="address" value="{ROW1.address}"  placeholder="Địa chỉ ngắn gọn" required="required" pattern=".+" oninvalid="setCustomValidity('{LANG.validate_address}')" oninput="setCustomValidity('')" />

									</div>
									
								</td>
							</tr>
							<script>
								//warehouse.push({"id":{key}})
								$('.province_id').select2({
									placeholder: "Mời bạn chọn thành phố",
									ajax: {
										url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
										'=ajax&mod=get_province',
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
									}
								})
								$(".province_id").select2("trigger", "select", {
									data: { id: {ROW1.province_id}, text: '{ROW1.province_name}'}
								});
								$(".district_id").select2("trigger", "select", {
									data: { id: {ROW1.district_id}, text: '{ROW1.district_name}'}
								});
								$(".ward_id").select2("trigger", "select", {
									data: { id: {ROW1.ward_id}, text: '{ROW1.ward_name}'}
								});

								$('.province_id').select2({
									placeholder: "Mời bạn chọn thành phố",
									ajax: {
										url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
										'=ajax&mod=get_province',
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
									}
								})
							</script>
							

							<!-- END: edit_warehouse -->
						</tbody>

					</table>
				</div>
				<div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
			</form>
		</div></div>

		<script type="text/javascript">
			<!-- BEGIN: add_warehouse_js -->
			$('.province_id').select2({
				placeholder: "Mời bạn chọn thành phố",
				ajax: {
					url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
					'=ajax&mod=get_province',
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
				}
			})

			$('.district_id').select2({
				placeholder: "Mời bạn chọn quận"
			})

			$('.ward_id').select2({
				placeholder: "Mời bạn chọn phường xã"
			})
			//
			$('.province_id_shop').select2({
				placeholder: "Mời bạn chọn thành phố",
				ajax: {
					url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
					'=ajax&mod=get_province',
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
				}
			})

			$('.district_id_shop').select2({
				placeholder: "Mời bạn chọn quận _shop"
			})

			$('.ward_id_shop').select2({
				placeholder: "Mời bạn chọn phường xã _shop"
			})
			<!-- END: add_warehouse_js -->

			$('.bank_id').select2({
				placeholder: "Mời bạn chọn ngân hàng"
			})
//<![CDATA[
$(".selectfile").click(function() {
	var area = "id_image_before";
	var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
	var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/business_license";
	var type = "image";
	nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});

$(".selectfile2").click(function() {
	var area = "id_image_after";
	var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
	var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/business_license";
	var type = "image";
	nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
$(".selectfile3").click(function() {
	var area = "avatar_image";
	var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
	var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/shop";
	var type = "image";
	nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
$(".selectfile4").click(function() {
	var area = "cover_image";
	var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
	var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/shop";
	var type = "image";
	nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});

function nv_change_weight(id) {
	var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
	var new_vid = $('#id_weight_' + id).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=seller_management&nocache=' + new Date().getTime(), 'ajax_action=1&id=' + id + '&new_vid=' + new_vid, function(res) {
		var r_split = res.split('_');
		if (r_split[0] != 'OK') {
			alert(nv_is_change_act_confirm[2]);
		}
		window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=seller_management';
		return;
	});
	return;
}


function nv_change_status(id) {
	var new_status = $('#change_status_' + id).is(':checked') ? true : false;
	if (confirm(nv_is_change_act_confirm[0])) {
		var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=seller_management&nocache=' + new Date().getTime(), 'change_status=1&id='+id, function(res) {
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
<!-- BEGIN: editjs -->
$(".province_id_shop").select2("trigger", "select", {
	data: { id: {ROW.province_id}, text: '{ROW.province_name}'}
});
$(".district_id_shop").select2("trigger", "select", {
	data: { id: {ROW.district_id}, text: '{ROW.district_name}'}
});
$(".ward_id_shop").select2("trigger", "select", {
	data: { id: {ROW.ward_id}, text: '{ROW.ward_name}'}
});
$('html,body').animate({
	scrollTop: 0
}, 'fast');
<!-- END: editjs -->
</script>
<!-- END: main -->