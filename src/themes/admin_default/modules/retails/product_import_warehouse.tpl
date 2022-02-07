<!-- BEGIN: main -->
<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<input type="hidden" name="warehouse_product_import_id" value="{ROW.warehouse_product_import_id}">
			<input type="hidden" name="product_id" value="{ROW.product_id}">
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label"><strong>Nhập nội dung</strong> <span class="red">(*)</span></label>
				<div class="col-sm-19 col-md-20">
				   <input name="title" class="form-control" required oninvalid="setCustomValidity('Vui lòng điền nội dung')" oninput="setCustomValidity('')" value="{text}" type="text">
				</div>
			</div>
			
			<!-- BEGIN: classify -->
			<div class="controls table-controls">
				<table id="poTable" class="table items table-striped table-bordered table-condensed table-hover sortable_table">
					<thead>
						<tr>
							<th class="text-center" style="font-size:20px;font-weight:bold"><a href="{info_product.alias}">{info_product.name_product}</a></th>
						</tr>
						<tr>
							<th class="text-center"></th>
						</tr>
					</thead>
					<tbody class="ui-sortable">
						<tr>
							<td>
								<table id="poTable" class="table items table-striped table-bordered table-condensed table-hover sortable_table">
									<thead>
										<tr class="text-center">
											<!-- BEGIN: loop -->
												<th class="text-center w150">{info_classify.name_classify}</th>
											<!-- END: loop -->
											<th class="text-center w150">Số lượng muốn nhập</th>
											<th class="text-center w150">Giá nhập</th>
											<th class="text-center w150">Đơn vị tiền tệ</th>
											<th class="w100"></th>
										</tr>
									</thead>
									<tbody>
										<!-- BEGIN: classify_value_2 -->
											<!-- BEGIN: classify_id_value1 -->
												<!-- BEGIN: classify_id_value2 -->
													<tr class="text-center" id="group_list_{info_product.id}" >
														<!-- BEGIN: loop -->
															<td >{info_product.name1}</td>
															<td>{info_product.name2}</td>
														<!-- END: loop -->
														<td style="vertical-align:middle">
															<input class="form-control" name="product[{info_product.id}][amount]" type="number" value="1" />
														</td>
														<td style="vertical-align:middle">
															<input class="form-control" name="product[{info_product.id}][price]" required type="text" placeholder="Giá nhập" onkeyup="this.value=FormatNumber(this.value);" oninvalid="setCustomValidity('Vui lòng điền giá nhập')" oninput="setCustomValidity('')" />
														</td>
														<td style="vertical-align:middle">
																 <select class="form-control unit_currency_{info_product.id}" name="product[{info_product.id}][unit_currency]">
																	<!-- BEGIN: unit_currency -->
																		<option value="{unit_currency.key}" {unit_currency.selected}>
																		{unit_currency.title}</option>
																	<!-- END: unit_currency -->
																</select>
																<script>
																	$('.unit_currency_{info_product.id}').select2({width:"100%"})
																</script>
														</td>
														<td style="vertical-align:middle">
															<button type="button" class="btn btn-primary" onclick="remove_warehouse_list({info_product.id})">Xóa</button>
														</td>
													</tr>	
												<!-- END: classify_id_value2 -->
											<!-- END: classify_id_value1 -->
										<!-- END: classify_value_2 -->	
										<!-- BEGIN: classify_value_1 -->
											<!-- BEGIN: classify_id_value1 -->
													<tr class="text-center" id="group_list_{info_product.id}" >
														<!-- BEGIN: loop -->
															<td >{info_product.name1}</td>
														<!-- END: loop -->
														<td style="vertical-align:middle">
															<input class="form-control" name="product[{info_product.id}][amount]" type="number" value="1" />
														</td>
														<td style="vertical-align:middle">
															<input class="form-control" name="product[{info_product.id}][price]" required type="text" placeholder="Giá nhập" onkeyup="this.value=FormatNumber(this.value);" oninvalid="setCustomValidity('Vui lòng điền giá nhập')" oninput="setCustomValidity('')" />
														</td>
														<td style="vertical-align:middle">
																 <select class="form-control unit_currency_{info_product.id}" name="product[{info_product.id}][unit_currency]">
																	<!-- BEGIN: unit_currency -->
																		<option value="{unit_currency.key}" {unit_currency.selected}>
																		{unit_currency.title}</option>
																	<!-- END: unit_currency -->
																</select>
																<script>
																	$('.unit_currency_{info_product.id}').select2({width:"100%"})
																</script>
														</td>
														<td style="vertical-align:middle">
															<button type="button" class="btn btn-primary" onclick="remove_warehouse_list({info_product.id})">Xóa</button>
														</td>
													</tr>	
											<!-- END: classify_id_value1 -->
										<!-- END: classify_value_1 -->
									</tbody>
								
							
								
								</table>
							</td>
						</tr>
						<tr>
							<td class="text-center">
								<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
							</td>
						</tr>
					</tbody>
					<tfoot>
						
					</tfoot>
				</table>
			</div>
           <!-- END: classify -->
		   <!-- BEGIN: no_classify -->
				<div class="form-group">
					<div class="text-center" style="font-size:20px;font-weight:bold">
						<a href="{info_product.alias}">{info_product.name_product}</a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-4 control-label">
						<strong>Số lượng nhập</strong>
						<span class="red">(*)</span>
					</label>
					<div class="col-sm-19 col-md-20">
						<input class="form-control" name="amount" required oninvalid="setCustomValidity('Vui lòng nhập số lượng muốn nhập')" oninput="setCustomValidity('')" type="number" value="1" />
					</div>	
				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-4 control-label">
						<strong>Giá nhập</strong>
						<span class="red">(*)</span>
					</label>
					<div class="col-sm-19 col-md-20">
						<input class="form-control" name="price" required type="text" placeholder="Giá nhập" onkeyup="this.value=FormatNumber(this.value);" oninvalid="setCustomValidity('Vui lòng điền giá nhập')" oninput="setCustomValidity('')" />
					</div>	
				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-4 control-label">
						<strong>Đơn vị</strong>
						<span class="red">(*)</span>
					</label>
					<div class="col-sm-19 col-md-20">
						 <select class="form-control unit_currency" name="unit_currency">
							<!-- BEGIN: unit_currency -->
								<option value="{unit_currency.key}" {unit_currency.selected}>
									{unit_currency.title}</option>
							<!-- END: unit_currency -->
						 </select>
						 <script>
							$('.unit_currency').select2({width:"100%"})
						 </script>
					</div>	
				</div>
				<div class="form-group text-center">
					<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
				</div>
		   <!-- END: no_classify -->
		   
		</form>
	</div>
</div>
<script>
	$('.warehouse_id').select2({placeholder:'Mời bạn chọn kho hàng'})
</script>
<!-- END: main -->
