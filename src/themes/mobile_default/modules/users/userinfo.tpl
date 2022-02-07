<!-- BEGIN: main -->

<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<!-- 
<link  type="text/css"href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/cropper/cropper.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/cropper/cropper.min.js"></script>
 -->
 
 <link rel="stylesheet" href="{NV_BASE_SITEURL}themes/mobile_default/chonhagiau/css/cropper.css">
<script src="https://unpkg.com/dropzone"></script>
<script src="{NV_BASE_SITEURL}themes/mobile_default/chonhagiau/js/cropper.js"></script>

		<script src="https://unpkg.com/cropperjs"></script>
		<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<style>
.preview {
	overflow: hidden;
	width: 100px; 
	height: 100px;
	margin: 5px;
	border: 1px solid #e1a208;
}
</style>


<header class="bg_white pb-2 text-center ">
	<div class="px-3 bd_b_1">
		<div class="text-center py-3 px-3 fs_18 ">Thông tin tài khoản</div>
	</div>
	<div class="contact-result alert"></div>
	<div class="py-4 d-flex justify-content-center">
		<div class="position-relative " style="width: fit-content">
			<img src="{IMG.src}" id="uploaded_image" class="rounded-circle width_80"   alt="">
			<label class="bg_white position-absolute mb-0 text-center label_change_img" for="upload_image">
			<div class="overlay">
						<div class="btn text-center d-flex justify-content-center">Sửa</div>
					</div>
			<input type="file" name="image" accept="image/*" class="image d-none" id="upload_image"  />
		</label>
		</div>
		
	</div>
</header>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cắt hình</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="img-container">
					<div class="row">
						<div class="col-8">
							<img src="" id="sample_image" class="img-fluid" />
						</div>
						<div class="col-4">
							<div class="preview"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="crop" class="btn_ecng">Cắt</button>
				<button type="button" class="btn_gray" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>
<script>
	var $modal = $('#modal');
	var image = document.getElementById('sample_image');
	var cropper;
	
	$('#upload_image').change(function(event){
		$modal.modal({backdrop: 'static', keyboard: false});
		var ext = $('#upload_image').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Không phải file ảnh!');
			return;
		}
		var files = event.target.files;
		var done = function(url){
			image.src = url;
			$modal.modal('show');
		};
		//console.log(files);
		if(files && files.length > 0)
		{
			reader = new FileReader();
			
			reader.onload = function(event)
			{
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});
	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 1,
			viewMode: 3,
			dragMode:"move",
			preview:'.preview'
			
		});
	});
	$modal.on('hidden.bs.modal', function(){
		cropper.destroy();
		$('#upload_image').val('');
	});

	$('#crop').click(function(){
		canvas = cropper.getCroppedCanvas({
			width:100,
			height:100,
		});
		
		canvas.toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){
				var base64data = reader.result;
				$.ajax({
					method: 'POST',
					url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=users&' + nv_fc_variable + '=main&mod=change_image',
					data: {
                        haha: base64data
                    },

					success: function(data){	
						$modal.modal('hide');
						$('#uploaded_image').attr('src', data);
						console.log(data);
					}
				});
			};
		});
	
	});
</script>
<!-- header  -->
<section>
	<form action="" class="bg_white" id="user_info">
		<table class="table table-borderless ">
			<tbody>		
				<tr>
					<td class="d-flex" style="margin-top:8px">Họ và Tên</td>
					<td>
						<div class="input-group border rounded-lg input_ecng mb-1">
							<div class="input_error_noIcon">
								<input type="text" value="{USER.last_name}" name="last_name" aria-describedby="button-addon4" class="form-control bg-none border-0"  maxlength="40">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="d-flex" style="margin-top:8px">Email</td>
					<td>
						<div class="input-group border rounded-lg input_ecng mb-1">
							<div class="input_error_noIcon">
								<input type="text" value="{USER.email}" name="email" aria-describedby="button-addon4" class="form-control bg-none border-0" maxlength="40">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="d-flex" style="margin-top:8px">Số điện thoại</td>
					<td>
						<div class="input-group  border rounded-lg input_ecng mb-1">
							<div class="input_error_noIcon">
								<input type="text" value="{USER.phone}" maxlength="10" name="phone" id="sdt" aria-describedby="button-addon4" class="form-control bg-none border-0 ">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td style="padding-top: 12px">Giới Tính</td>
					<td class="d-flex">
						<div class="d-flex mr-5">
							<label class="ecng_label_radio">
								<input value="M" type="radio" name="gender" {USER.checked_m}>
								<span class="checkmark"></span>
							</label>
							<p class="fs_16 mb-0" style="padding-top: 1px"><span>Nam</span>
							</p>
						</div>
						<div class="d-flex">
							<label class="ecng_label_radio">
								<input value="F" {USER.checked_f} type="radio" name="gender" >
								<span class="checkmark"></span>
							</label>
							<p class="fs_16 mb-0"  style="padding-top: 1px"><span>Nữ</span>
							</p>
						</div>
					</td>
				</tr>
				<tr>
					<td class="d-flex" style="margin-top:8px">Ngày Sinh</td>
					<td>
						<div class="input-group  border rounded-lg  input_ecng">
							<div class="input_error_noIcon">
								<input id="birthday" type="text" value="{USER.birthday}" maxlength="10" name="birthday" aria-describedby="button-addon4" class="form-control bg-none border-0 ">
							</div>
						</div>
					</td>
				</tr>					
			</tbody>
		</table>
		<div class="text-center p-3">
			<button class="btn_ecng w-100 fs_16 py-2">Lưu</button>
		</div>
		
	</form>
</section>


<script>
	$("#birthday").datepicker({
	dateFormat : "dd/mm/yy",
	changeMonth : true,
	changeYear : true,
	showOtherMonths : true,
	yearRange: "-99:+0"
	});
</script>
<!-- END: main -->