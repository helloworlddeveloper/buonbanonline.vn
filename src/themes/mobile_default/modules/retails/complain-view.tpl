<!-- BEGIN: main -->


<div class="panel panel-default panel_complain p-2 bg_white">
	<div class="panel-head py-3">
		<i class="fa fa-check secondary_text "></i> Hoàn thành thông tin khiếu nại
	</div>
	<div class="panel-body">
		<form class="form-horizontal form_complain" action="#" method="post">
			
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
			
			<!-- BEGIN: image -->
			<div class="form-group">
				<label class="col-sm-12 col-md-12 control-label"><strong>Hình ảnh 6 mặt sản phẩm</strong></label>
				<div class="col-sm-12 col-md-12">
					<div class="panel-body">
						<div class="content_image_main">
							<!-- BEGIN: data_image -->
							<div id="item_image_main{stt}" stt_img="{stt}" class="item_image_main">
								<label for="input_file_image{stt}">
									<div class="item_image_main_span">
										<!-- BEGIN: loop -->
										<span class="pip"><img class="imageThumb w-100" src="{src_image}"/></span>
										
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
				<label class="col-sm-7 control-label"><strong>Video quay 6 mặt sản phẩm </strong></label>
				<div class="col-sm-4">
					
					<video width="100%" height="240" controls>
						<source src="{ROW.images_video}" type="video/mp4">
					</video>
					
				</div>
			</div>
			<!-- END: images_video -->	
			
			</br>
			<div class="form-group">
				<label class="col-sm-19 col-md-20 control-label"><strong>{LANG.reason}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-19 col-md-20">
					{ROW.reason}
				</div>
			</div>
		
		</form>
	</div></div>
	
	
	<!-- END: main -->												