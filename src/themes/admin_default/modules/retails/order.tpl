<!-- BEGIN: main -->

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title" style="float:left"><i class="fa fa-list"></i> {LANG.order}</h3> 
		<div class="pull-right">
			<button title="Ẩn /Hiện tìm kiếm"id="tms_sea_id" data-toggle="tooltip" data-placement="top"class="btn btn-success btn-sm"><i class="fa fa-search" aria-hidden="true"></i></button> 
		</div>
		<div style="clear:both"></div>
	</div>
	<div class="well" id="tms_sea">
		<form action="{NV_BASE_ADMINURL}index.php" id="formsearch" method="get">
			<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
			<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
			<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
			<div class="row">
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								Tìm kiếm nhanh
							</span>
							<select class="form-control link_flast" id="sea_flast" name="sea_flast">
								<option value="0">
									-- Chọn thời gian --
								</option>
								<option value="1" {SELECT1}>Ngày hôm nay</option>
								<option value="2" {SELECT2}>Ngày hôm qua</option>
								<option value="3" {SELECT3}>Tuần này</option>
								<option value="4" {SELECT4}>Tuần trước</option>
								<option value="5" {SELECT5}>Tháng này</option>
								<option value="6" {SELECT6}>Tháng trước</option>
								<option value="7" {SELECT7}>Năm này</option>
								<option value="8" {SELECT8}>Năm trước</option>
								<option value="9" {SELECT9}>Toàn thời gian
								</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								hoặc {LANG.ngay_tu}
							</span>
							<input id="ngaytu" type="text" maxlength="255" class="form-control disabled" value="{ngay_tu}"
                            name="ngay_tu" placeholder="{LANG.ngay_tu}">
						</div>
					</div>
					
				</div>
				
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-8">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								{LANG.ngay_den}
							</span>
							<input id="ngayden" type="text" maxlength="255" class="form-control disabled" value="{ngay_den}"
                            name="ngay_den" placeholder="{LANG.ngay_den}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-6">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								Cửa hàng
							</span>
							<select name="store_id" class="form-control input-sm store_id">
								<option value="0">Chọn tất cả</option>
								<!-- BEGIN: store_id -->
								<option value="{store_id_list.key}" {store_id_list.selected}>{store_id_list.title}
								</option>
								<!-- END: store_id -->
							</select>
						</div>
					</div>
				</div>
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-6">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								Người mua
							</span>
							<select name="customer_id" class="form-control input-sm customer_id">
								<option value="0">Chọn tất cả</option>
								<!-- BEGIN: customer_id -->
								<option value="{customer_id.key}" {customer_id.selected}>{customer_id.title}
								</option>
								<!-- END: customer_id -->
							</select>
						</div>
					</div>
				</div>
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-6">
					<div class="form-group">
						<div class="input-group" style="width:100%">
							<span class="input-group-addon w100">
								Chuyên mục hàng hóa
							</span>
							<select name="categories_id" class="form-control input-sm categories_id"></select>
						</div>
					</div>
				</div>
				<div class="col-xs-24 col-sm-12  col-md-12  col-lg-6">
					<div class="form-group">
						<input class="form-control" type="text" value="{Q}" name="q" maxlength="255"
                        placeholder="Mã đơn hàng" />
					</div>
				</div>
				<div class="col-sm-24  col-md-24  col-lg-6">
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
						<button class="btn btn-primary export_file" type="button"  >
							Xuất file excel
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="tms_home_cat">
	<div class="tms_home_cat_tab">
		<ul>
			<li class="active">
				<a onclick="list(-2)" role="tab"data-toggle="tab">
					<span>Tất cả</span> <span id="count_{LOOP.status_id}">({SUM_ORDER} đơn)</span>
				</a>
			</li> 
			<!-- BEGIN: status -->
			<li class="{active}">
				<a onclick="list({LOOP.status_id})" role="tab"data-toggle="tab">
					<span>{LOOP.name}</span> <span id="count_{LOOP.status_id}">({LOOP.count_order} đơn)</span>
				</a>
			</li> 
			
			<!-- END: status -->
			
		</ul>
	</div>
</div>	
<div class="" id="form"></div>
<script>
	list({status_view_order});
	function list(status) {
		$('#form').load(script_name + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=ajax&mod=load_order&status_search='+status+'&ngay_tu={ngay_tu}'+'&ngay_den={ngay_den}'+'&sea_flast={sea_flast}'+'&q={Q}'+'&store_id={store_id}&warehouse_id={warehouse_id}&customer_id={customer_id_2}&categories_id={categories_id}');
	} 
	$('.store_id').select2({width:'100%'})	
	$('.customer_id').select2({width:'100%'})	
	
	$('.warehouse_id').select2({placeholder:'Mời bạn chọn kho hàng',width:'100%'})	
	$('select[name=store_id]').change(function(){
		var store_id = $(this).find('option:selected').val();
		$('.warehouse_id').empty();
		$('.warehouse_id').select2({
			placeholder:'Mời bạn chọn kho hàng',
			width:'100%',
			ajax: {
				url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=get_warhouse',
				dataType: 'json',
				method:'POST',
				delay: 250,
				data: function (params) {
					
					return {
						q: params.term,
						store_id:store_id
					};
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
	$('select[name=sea_flast]').change(function() {
		var time_from = "";
		var time_to = "";
		var time = $('select[name=sea_flast]').val();
		if (time == 1) {
			time_from = "{HOMNAY}"
			time_to = "{HOMNAY}"
			} else if (time == 2) {
			time_from = "{HOMQUA}"
			time_to = "{HOMQUA}"
			} else if (time == 3) {
			time_from = "{TUANNAY.from}"
			time_to = "{TUANNAY.to}"
			} else if (time == 4) {
			time_from = "{TUANTRUOC.from}"
			time_to = "{TUANTRUOC.to}"
			} else if (time == 5) {
			time_from = "{THANGNAY.from}"
			time_to = "{THANGNAY.to}"
			} else if (time == 6) {
			time_from = "{THANGTRUOC.from}"
			time_to = "{THANGTRUOC.to}"
			} else if (time == 7) {
			time_from = "{NAMNAY.from}"
			time_to = "{NAMNAY.to}"
			} else if (time == 8) {
			time_from = "{NAMTRUOC.from}"
			time_to = "{NAMTRUOC.to}"
			} else if (time == 9) {
			time_from = "Không chọn"
			time_to = "Không chọn"
			} else if (time == 0) {
			time_from = ""
			time_to = ""
		}
		$('#ngaytu').val(time_from);
		$('#ngayden').val(time_to); 
	})
	$("#tms_sea_id").click(function() {
		$("#tms_sea").toggle();
	});
	$("#ngaytu,#ngayden").datepicker({
		dateFormat: "dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		firstDay: 1,
		showOtherMonths: true,
	});
	$('.categories_id').select2({
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
	$(".categories_id").select2("trigger", "select", {
		data: { id: {categories_id}, text: '{categories_name}'}
	});
	$('.export_file').on('click', function(e) {
		var all = $(this).attr('data-all');	
		var form_data = $('#formsearch').serializeArray(); 
		form_data.push({ name: 'all', value: all });
		var ngaytu=document.getElementById('ngaytu').value
		var ngayden=document.getElementById('ngayden').value
		if(ngaytu=='' || ngayden==''){
			alert('Vui lòng chọn từ ngày, đến ngày')
			}else{
			$.ajax({
				url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&mod=is_download&nocache=' + new Date().getTime(),
				type: 'post',
				dataType: 'json',
				data: form_data,
				beforeSend: function() {
					$('.export_file i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('.export_file').prop('disabled', true);
					loading();
				},	
				complete: function() {
					$('.export_file i').replaceWith('<i class="fa fa-download"></i>');
					$('.export_file').prop('disabled', false);
				},
				success: function(json) {
					removeloading();
					if( json['error'] ) alert( json['error'] );  		
					if( json['link'] ) window.location.href= json['link'];  		
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
			e.preventDefault(); 	
		}
	});
</script>
<!-- END: main -->