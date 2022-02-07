<!-- BEGIN: main -->


<div class="panel panel-default panel_complain">
	<div class="panel-head">
		Hoàn thành thông tin khiếu nại
	</div>
	<div class="panel-body">
		<form class="form-horizontal form_complain" action="#" method="post">
			<input type="hidden" name="id" value="{ROW.id}" />
			<input type="hidden" name="order_id" value="{ROW.order_id}" />
			
			
			<div class="form-group">
				<label class="col-sm-12 col-md-12 control-label"><strong>Thông tin sản phẩm</strong></label>
				<div class="col-sm-12 col-md-12">
					<!-- BEGIN: loop_send -->
					<div class="thongtinsanpham_complain">
						<input checked="checked" style="height: 20px;width: 20px;position: relative;top: 5px;margin-right: 10px;" type="checkbox" name="products[]" value="{VIEW.id_product}" /> <label>{VIEW.name_product} {VIEW.name_group}</label> - Số lượng <input type="number" name="numbers[]" min="1" max="{VIEW.quantity}" value="{VIEW.quantity}" />
						<input type="hidden" name="classify_value_product_id[]" value="{VIEW.classify_value_product_id}" />
					</div>
					<!-- END: loop_send -->
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-12 col-md-12 control-label"><strong>Hình ảnh 6 mặt sản phẩm</strong></label>
				<div class="col-sm-12 col-md-12">
					
					<div class="panel-heading">
						Chọn hình ảnh (tối đa 3000 x 3000)
					</div> 
					<div class="panel-body">
						<div class="content_image_main">
							<!-- BEGIN: data_image -->
							<div id="item_image_main{stt}" stt_img="{stt}" class="item_image_main">
								<label for="input_file_image{stt}">
									<div class="item_image_main_span">
										<!-- BEGIN: add -->
										+
										<!-- END: add -->
										
										<!-- BEGIN: loop -->
										<span class="pip"><img class="imageThumb" src="{src_image}"/><input type="hidden" value="{homeimgfile}" name="array_image_pro[]" /><span onclick='remove_image(this)' class="remove"><i class="fa fa-trash" aria-hidden="true"></i></span></span>
										
										<!-- END: loop -->
									</div>
									<input multiple id="input_file_image{stt}" onchange="upload_image_main(event, {stt});" class="d-none" type="file" accept="image/*" name="array_image[]"/>
								</label>
							</div>
							<!-- END: data_image -->	
						</div>
					</div>
					
				</div>
			</div>
			
			<div class="clear"></div></br>
			<div class="form-group">
				<label class="col-sm-7 control-label"><strong>Video quay 6 mặt sản phẩm (tối đa 20M)</strong></label>
				<div class="col-sm-4">
					<input id="file" accept="video/mp4,video/x-m4v,video/*" type="file" name="video" value="{ROW.video}" />
				</div>
			</div>
			</br>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.reason}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-19 col-md-20">
					<textarea class="form-control" style="height:100px;" cols="75" rows="5" name="reason">{ROW.reason}</textarea>
				</div>
			</div>
			<div class="form-group" style="text-align: center"><input class="btn btn-primary button_send_complain" name="submit" type="submit" value="Gửi yêu cầu" /></div>
		</form>
	</div></div>
	
	<script>
		
		$('.button_send_complain').click(function(){
			event.preventDefault();
			
			
			// thông tin sản phẩm products
			var flag = false;
			var array_product = [];
			$.map($('input[name="products[]"]'), function(el) {
				array_product.push($(el).val());
				if($(el).prop("checked") == true){
					flag = true;
				}
			});
			
			if(!flag)
			{
				alert('Chưa chọn sản phẩm khiếu nại!');
				return false;
			}
			
			
			// thông tin số lượng sản phẩm khiếu nại numbers
			// thông tin sản phẩm products
			var flag = false;
			var array_number = [];
			$.map($('input[name="numbers[]"]'), function(el) {
				array_number.push($(el).val());
				
				if($(el).val() < 1){
					flag = true;
				}
			});
			
			var array_classify_value_product_id = [];
			$.map($('input[name="classify_value_product_id[]"]'), function(el) {
				array_classify_value_product_id.push($(el).val());
			});
			
			if(flag)
			{
				alert('Số lượng sản phẩm không đúng!');
				return false;
			}
			
			// hình ảnh sản phẩm
			var flag = 0;
			$.map($('input[type=hidden][name="array_image_pro[]"]'), function(el) {
				if(el.value != '')
				{
					flag++;
				}
			});
			
			
			var video = $('input[name=video]').val();
			
			if(flag < 6 && video == '')
			{
				alert('Chưa upload đủ 6 hình hoặc video quay 6 mặt sản phẩm!');
				return false;
			}
			
			if (video != '' && !isVideo(video)) {
				alert('Video không đúng định dạng!');
				return false;
			}
			
			if($('textarea[name=reason]').val() == '')
			{
				alert('Chưa nhập lý do!');
				return false;
			}
			
			
			// xử lý lại thông tin sản phẩm
			var products = [];
			var numbers = [];
			var classify_value_product_id = [];
			var i = 0;
			$.map($('input[name="products[]"]'), function(el) {
				if($(el).prop("checked") == true){
					products.push(array_product[i]);
					numbers.push(array_number[i]);
					classify_value_product_id.push(array_classify_value_product_id[i]);
				}
				
				i++;
			});
			
			
			
			var form_data = new FormData($('.form_complain')[0]);
			
			form_data.append('thongtin_sp', products);
			form_data.append('numbers', numbers);
			form_data.append('classify_value_product_id', classify_value_product_id);
			
			
			$.ajax({               
				type: "POST",      
				dataType: 'json',  
				url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=complain&add_complain=1',
                cache: false,
                contentType: false,
                processData: false,
				data: form_data,
				beforeSend: function() {
					$('form input[type=submit]').prop('disabled', true);
				},	               
				complete: function() {
				},                 
				success: function(json) {
				
					$('form input[type=submit]').prop('disabled', false);
					console.log(json);
					if(json['status'] == 'OK')
					{
						alert(json['mess']);
						window.location.href = json['link'];
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
			
		});
		
		
		function isVideo(filename) {
			var ext = getExtension(filename);
			switch (ext.toLowerCase()) {
				case 'avi':
				case 'flv':
				case 'wmv':
				case 'mov':
				case 'mp4':
				case 'mpeg':
				case 'divx':
				case '3gp':
				case 'xvid':
				case 'h.264':
				// etc
				return true;
			}
			return false;
		}
		
		function getExtension(filename) {
			var parts = filename.split('.');
			return parts[parts.length - 1];
		}
		
		// xử lý hình ảnh
		
		function upload_image_main(e, id) {
			
			var ext = $('#input_file_image'+id).val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Không phải file ảnh!');
				return;
			}
			
			var files = e.target.files;
			
			if(files.length > 7)
			{
				alert('Số lượng hình ảnh không được phép vượt quá 7!');
				return false;
			}
			
			
			// xóa cảnh báo upload hình ảnh trước đó cảnh báo nếu có
			$('.content_image_main .error_image_product').removeClass('error_image_product');
			
			
			return Promise.all([].map.call(files, function (file) {
				return new Promise(function (resolve, reject) {
					var reader = new FileReader();
					
					reader.onloadend = function () {
						
						var image = new Image();
						image.src = reader.result;
						image.onload = function () {
							var height = this.height;
							var width = this.width;
							var size = (file.size/1024);
							resolve({ url: reader.result, width : width, height : height, size : size});
							
						};
						
						
					};
					
					reader.readAsDataURL(file);
				});
				})).then(function (results) {
				
				var stt = id;
				
				$.each(results , function (index, result){
					
					
					if(result.width > 3000 || result.height > 3000)
					{
						alert('Kích thước không vượt quá 3000px');
						return true;
					}
					
					if(result.size > 2048)
					{
						alert('Dung lượng không vượt quá 2M');
						return true;
					}
					
					id = stt;
					
					$("#item_image_main" + id + ' .item_image_main_span').html("<span class=\"pip\">" +
					"<img class=\"imageThumb\" src=\"" + result.url + "\"/>" +
					"<input type=\"hidden\" value="+ result.url +" name=\"array_image_pro[]\" />" +
					"<span onclick='remove_image(this)' class=\"remove\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></span>" +
					"</span>");
					
					stt = stt + 1;
					
					if(stt > 7)
					{
						stt = 1;
					}
					
					
				});
				return results;
			});
			
			
		}
		
		
		function remove_image(a)
		{
			event.preventDefault()
			
			$(a).parent().parent().parent().find('input[type=file]').val('');
			$(a).parent().parent().html('+');
			$(a).parent(".pip").remove();
		}
		
	</script>
	<!-- END: main -->										