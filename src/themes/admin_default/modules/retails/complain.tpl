<!-- BEGIN: main -->


<div class="panel panel-default panel_complain">
	<div class="panel-head">
		Thông tin khiếu nại
	</div>
	<div class="panel-body">
		<form class="form-horizontal form_complain" action="#" method="post">
			<input type="hidden" name="order_id" value="{VIEW.order_id}" />
			<div class="form-group">
				<label class="col-sm-24 col-md-24"><strong>Thông tin sản phẩm</strong></label>
				<div class="col-sm-24 col-md-24">
					<!-- BEGIN: loop_send -->
					<div class="thongtinsanpham_complain">
						<input {checked_product} style="margin-right: 10px;" type="checkbox" name="products[]" value="{VIEW.id_product}" /> <label>{VIEW.name_product} {VIEW.name_group}</label> - Số lượng <input type="number" name="numbers[]" min="1" max="{VIEW.quantity}" value="{product.number}" />
						<input type="hidden" name="classify_value_product_id[]" value="{VIEW.classify_value_product_id}" />
					</div>
					<!-- END: loop_send -->
				</div>
			</div>
			
			<!-- BEGIN: image -->
			<div class="form-group">
				<label class="col-sm-24 col-md-24"><strong>Hình ảnh 6 mặt sản phẩm</strong></label>
				<div class="col-sm-24 col-md-24">
					<div class="panel-body">
						<div class="content_image_main">
							<!-- BEGIN: data_image -->
							<div id="item_image_main{stt}" stt_img="{stt}" class="item_image_main">
								<label for="input_file_image{stt}">
									<div class="item_image_main_span">
										<!-- BEGIN: loop -->
										<span class="pip"><img class="imageThumb" src="{src_image}"/></span>
										
										<!-- END: loop -->
									</div>
								</label>
							</div>
							<!-- END: data_image -->	
						</div>
					</div>
					
				</div>
			</div>
			<!-- END: image -->
			
			
			
			<!-- BEGIN: images_video -->	
			<div class="clear"></div></br>
			<div class="form-group">
				<label class="col-sm-24"><strong>Video quay 6 mặt sản phẩm </strong></label>
				<div class="col-sm-24">
					
					<video width="320" height="240" controls>
						<source src="{ROW.images_video}" type="video/mp4">
					</video>
					
				</div>
			</div>
			<!-- END: images_video -->	
			
			</br>
			<div class="form-group">
				<label class="col-sm-24 col-md-24"><strong>{LANG.reason}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-24 col-md-24">
					{ROW.reason}
				</div>
			</div>
			
			<div class="form-group" style="text-align: center"><input class="btn btn-primary button_send_complain" name="submit" type="submit" value="Gửi yêu cầu" /></div>
			
		</form>
	</div>
	
	
</div>

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
				url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=complain&add_complain=1',
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
		
	
</script>


<!-- END: main -->												