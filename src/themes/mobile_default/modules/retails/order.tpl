<!-- BEGIN: main -->

<script>
    var tongphivanchuyen = 0;
    var tongvoucher = 0;
    const isEmpty = sel => ![...document.querySelectorAll(sel)].some(el => el.innerHTML.trim() !== "");
</script>

<style>
    .modal-backdrop.show {
        display: none;
    }

    .modal-open {
        overflow: inherit;
        padding-right: inherit !important;
    }

    .list_voucher_order {
        max-height: 350px;
        overflow: scroll;
    }

    .coupons_voucher_wallet .coupons_right:before {
        content: '';
        width: 16px;
        height: 16px;
        position: absolute;
        bottom: -13px;
        background: white;
        border-radius: 50%;
        left: 4px;
    }

    .coupons_voucher_wallet .coupons_right:after {
        content: '';
        width: 16px;
        height: 16px;
        position: absolute;
        top: -13px;
        background: white;
        border-radius: 50%;
        left: 4px;
    }

    .coupons_voucher_wallet .coupons_left:before {
        width: 16px;
        height: 16px;
        bottom: -10px;
        -webkit-box-shadow: inset 0px 1px 1px 1px rgba(214, 214, 214, 1);
        -moz-box-shadow: inset 0px 1px 4px 1px rgba(214, 214, 214, 1);
        box-shadow: inset 0px 1px 4px 1px rgba(214, 214, 214, 1);
    }

    .coupons_voucher_wallet .coupons_left:after {
        width: 16px;
        height: 16px;
        bottom: -10px;
        -webkit-box-shadow: inset 0px 1px 1px 1px rgba(214, 214, 214, 1);
        -moz-box-shadow: inset 0px 1px 4px 1px rgba(214, 214, 214, 1);
        box-shadow: inset 0px 1px 4px 1px rgba(214, 214, 214, 1);
        transform: rotate(180deg);
    }

    .modal-content {
        border: 0;
        -webkit-box-shadow: 0px 1px 4px 1px rgba(214, 214, 214, 1);
        -moz-box-shadow: 0px 1px 4px 1px rgba(214, 214, 214, 1);
        box-shadow: 0px 1px 4px 1px rgba(214, 214, 214, 1);
    }

    .coupons_voucher_wallet {
        -webkit-box-shadow: 0px 1px 4px 1px rgba(214, 214, 214, 1);
        -moz-box-shadow: 0px 1px 4px 1px rgba(214, 214, 214, 1);
        box-shadow: 0px 1px 4px 1px rgba(214, 214, 214, 1);
    }

    .coupons_voucher_wallet .coupons_left {
        background: none;
    }
</style>

<div class=" pb-2 bg_white">
    <div class="login pt-2 text-center">
        <!-- <a href="{CART}"><i class="fa fa-long-arrow-left pt-2 pl-3 float-left" aria-hidden="true" style="font-size: 25px; line-height: 30px;"></i></a> -->
        <p class="fs_18 mt-3">Thanh Toán</p>
    </div>
</div>

<!-- BEGIN: address_list -->
<section class="address px-3 pb-2 mt-2 bg_white payment_address">
    <div class=" row py-2 align-items-center">
        <div class="change_address col-8 d-flex pl-0">
            <img src="/themes/mobile_default/chonhagiau/images/icon/address.svg	">
            <p class="fs_14 pl-2 mb-0">Địa chỉ nhận hàng</p>
        </div>
        <div id="change_address" class="text-right col-4"><img
                src="/themes/mobile_default/chonhagiau/images/icon/pen.svg"></div>
    </div>
    <div class="pl-4 pt-1">
        <p class="fs_14 mb-0 pb-1">{ADDRESS.name} - {ADDRESS.phone} </p>
        <p class="text_gray_color mb-0">{ADDRESS.address}</p>
    </div>
</section>
<!-- END: address_list -->

<div class="row payment_addressChange bg_white rounded-lg p-3 my-3 {address_other}">
    <div class="change_address col-8 d-flex pl-0">
        <i class="fa fa-map-marker secondary_text fa-2x" aria-hidden="true"></i>
        <p class="fs_14 pt-2 pl-2 mb-0"> Địa chỉ nhận hàng</p>
    </div>
    <!-- BEGIN: address_list1 -->
    <div class="payment_addressChange_item1 mt-2">
        <p class="fs_14 mb-0 pb-1">
            <label class="ecng_label_radio">
                <input onchange="change_address({ADDRESS.id},{ADDRESS.userid})" type="radio" name="radio"
                    {ADDRESS.checked}>
                <span class="checkmark"></span>
            </label>
            {ADDRESS.name} - {ADDRESS.phone}
        </p>
        <p class="text_gray_color w-75 mb-0">{ADDRESS.address}</p>
    </div>
    <!-- END: address_list1 -->
    <div class="payment_addressChange_save mt-3">
        <a href="{LINK_ADDRESS}" class="btn_ecng botton_add_address {show_address}">+ Thêm địa chỉ mới</a>
        <!--  Thêm địa chỉ mua hàng không cần đăng nhập -->
        <!-- BEGIN: address_no_login -->
        <div class="row">
            <div class="col-12">
                <p class="fs_14 d-flex flex-column">
                    <span class="text-break">{FULL_NAME}</span>
                    <span class="text-break">{FULL_ADDRESS}</span>
                    <span class="">{FULL_PHONE}</span>
                    <span class="text-break">{FULL_EMAIL}</span>
                </p>
            </div>
        </div>
        <a href="{LINK_ADDRESS}" class="col-1 text-center secondary_text">Thay đổi địa chỉ</a>

        <!-- END: address_no_login -->
    </div>
</div>


<script>
		// payment 
		$('#change_address').click(function() {
			$('.payment_address').hide();
			$('.payment_addressChange').show();
			//Cách đều các thành phần địa chỉ
			var max = 0;
			var items = $('p#address_name_ing');
			var a= items.length;
			//console.log(a)
			$.each(items, function(){
				var current_vari = $(this);
				if(current_vari.width() > max){
					max = current_vari.width();
				}
			})
			//console.log(max);
			items.width(max);
			
		});
		
		$('.botton_add_address').click(function(){
			$.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order&mod=add_address_ajax', function(res) {
				
			});
		});
		
		function change_address(id, userid){
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
		
	</script>


<div class="panel panel-default panel_add_thong_tin hidden">
    <span>
        <p>
            Tên người mua<sup>(*)</sup>
        </p>
        <input id="b_name" name="order_name1" class="form-control" value="{ADDRESS_DF.name}">
    </span>
    <span>
        <p>
            Email <sup>(*)</sup>
        </p>
        <input id="b_email" type="email" name="order_email1" onchange="check_email_error(this)"
            value="{EMAIL_USER}" class="form-control">
    </span>
    <span>
        <p>
            Số điện thoại<sup>(*)</sup>
        </p>
        <input id="b_phone" name="order_phone1" class="form-control" onchange="check_phone_error(this)"
            value="{ADDRESS_DF.phone}">
    </span>
    <div class="row">
        <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
            <p>
                Địa chỉ nhận hàng<sup>(*)</sup>
            </p>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 padding_for_select">
                <input type="" name="province_id" value="{ADDRESS_DF.province_id}">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 padding_for_select">
                <input type="" name="district_id" value="{ADDRESS_DF.district_id}">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 padding_for_select">
                <input type="" name="ward_id" value="{ADDRESS_DF.ward_id}">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 padding_for_select">
                <input type="text" name="address" id="address" class="form-control" value="{ADDRESS_DF.address}"
                    placeholder="Địa chỉ ngắn gọn" />
            </div>
            <input type="text" name="lat" id="lat" class="form-control hidden" value="{ADDRESS_DF.lat}" />
            <input type="text" name="lng" id="lng" class="form-control hidden" value="{ADDRESS_DF.lng}" />
        </div>
    </div>
</div>

<!-- BEGIN: store -->
<section class="shop_bill px-3 pt-2 py-4 mt-2 bg_white">
    <span class="fs_14 fw_500">Thông tin đơn hàng</span>
    <div class="d-flex pt-3 bg_white">
        <p class="fs_14 mb-0 font-weight-bold"><img class="pr-2"
                src="/themes/mobile_default/chonhagiau/images/icon/store.svg">{info_store.company_name}</p>

    </div>
    <!-- BEGIN: warehouse -->
    <!-- BEGIN: loop -->
    <div class="row mt-3 pb-1 d-flex align-items-center">
        <div class="col-2">
            <a class="beauty_img width_60" href="{LOOP_INFO_PRODUCT.alias}">
                <img class="max_w_h rounded" src="{LOOP_INFO_PRODUCT.image}" alt="{LOOP_INFO_PRODUCT.name_product}" />
            </a>
        </div>
        <div class="col-10 pl-2">
            <span class="mb-1 fs_12 text_black pt-2">
                <a href="{LOOP_INFO_PRODUCT.alias}">
                    {LOOP_INFO_PRODUCT.name_product}
                </a>
            </span>
            <p class="mb-1 fs_12 text_black capitalize">{LOOP_INFO_PRODUCT.name_group}</p>
            <div class="d-flex pt-1">
                <p class="mb-1 w-50 text_gray_color">Số lượng: <span class="font-weight-bold"
                        style="color:#000000">{LOOP_INFO_PRODUCT.quantity}</span> </p>
                <p class="secondary_text w-50 text-right fs_14 mb-0">{LOOP_INFO_PRODUCT.price_format}đ</p>
            </div>
        </div>
    </div>
    <!-- END: loop -->
    <input type="hidden" id="total_price_one_shop_{info_store.userid}" value="{total_price_one_shop}">

    <!-- test -->
    <!-- voucher -->
    <div class="row align-items-center">
        <span hidden id="voucherid_choosed_{info_store.id}">{voucherid_optimal}</span>
        <span hidden id="price_choosed_{info_store.id}">{max_price_voucher_value}</span>
        <div class="w-100 pt-2 pb-3 position-relative">
            <div class="text-right">
                <span id="max_price_voucher_{info_store.id}"
                    class="{border} secondary_text p-1">{max_price_voucher}</span>
                <span id="select_voucher_{info_store.id}" class="pl-2 secondary_text" style="cursor:pointer"
                    data-toggle="modal" data-target="#voucher_modal_{info_store.id}">
                    Chọn Voucher
                </span>
            </div>
            <!-- modal voucher -->
            <div class="modal fade p-1" data-toggle="modal"
                style="position: absolute;right:-18px;top:25px;left:none;height: initial;left: initial;width: 360px;"
                id="voucher_modal_{info_store.id}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            {info_store.company_name} Voucher
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body list_voucher_order">

                            <div id="list_voucher_shop_{info_store.id}">
                            </div>

                            <!-- BEGIN: voucher_shop_not -->
                            Không có voucher
                            <!-- END: voucher_shop_not -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
			$(document).click(function () {
				$('.modal').modal('hide');
			});
			$('.modal-content').click(function(e)
			{
				e.stopPropagation();          
			});
			$('.close').click(function () {
				$('.modal').modal('hide');
			});
			$( document ).ready(function() {
				sum_voucher_{info_store.id}({info_store.id});
			});
			var list_voucher_{info_store.id} = [];
			<!-- BEGIN: voucher_shop_js -->
			
			var product = [];
			<!-- BEGIN: product_id -->
			product.push('{product_id_voucher}');
			<!-- END: product_id -->
			
			
			list_voucher_{info_store.id}.push({'voucherid':'{VOUCHER.voucherid}','voucher_name':'{VOUCHER.voucher_name}','time_to':'{VOUCHER.time_to}','type_discount':'{VOUCHER.type_discount}','maximum_discount':'{VOUCHER.maximum_discount}','minimum_price':'{VOUCHER.minimum_price}','list_product':'{VOUCHER.list_product}','discount_price':'{VOUCHER.discount_price}','price':'{VOUCHER.price}','status':'{VOUCHER.status}','product_id':product});
			<!-- END: voucher_shop_js -->
			//console.log(list_voucher_{info_store.id});
			//load list voucher ra trước
			show_list_voucher_{info_store.id}({info_store.id});
			//tính tổng voucher đã giảm được
			
			
			function sum_voucher_{info_store.id}(store_id){
				var price_voucher = $('#price_choosed_'+ store_id ).text();
				tongvoucher = Number(tongvoucher) + Number(price_voucher);
				sum_phivanchuyen();
				hien();
			}
			$('#voucher_modal_{info_store.id}').on('shown.bs.modal', function (e) {
				show_list_voucher_{info_store.id}({info_store.id})
			})
			//'
			
			function show_list_voucher_{info_store.id}(store_id){
				var content = '';
				
				$.map( list_voucher_{info_store.id}, function(giatri, chiso) {
					
					content += '<div class="mb-3 coupons_voucher_wallet rounded d-flex" style="height:100px">';
					content += '<div class="coupons_left w-25">';
					content += '<div class="pl-2">';
					content += '<img class="img-fluid rounded" src="/ch-nha-giau/src/uploads/logo_ecng_1.png" alt=""/>';
					content += '</div>';
					content += '<div class="coupons_left-border">';
					content += '</div>';
					content += '</div>';
					content += '<div class="coupons_right pl-4 py-3 w-75 position-relative rounded">';
					content += '<div class="d-flex justify-content-between">';
					content += '<div>';
					
					content += '<span class="fs_12">Giảm '+ giatri["discount_price"] +' tất cả đơn giá của bạn</span>';
					content += '</div>';
					content += '</div>';
					if( giatri["maximum_discount"] > 0 ){
						content += '<span class="text_gray_color"> Giảm tối đa ' + format_number(Number(giatri["maximum_discount"])) + 'đ </span>';
					}
					else{
						content += '<span class="text_gray_color">&ensp;</span>';
					}
					content += '<div class="d-flex w-100 h-50 pr-2 justify-content-between align-items-end">';
					content += '<span class="fs_12"> HSD: ' + giatri["time_to"] +'</span>';
					
					var ojb = JSON.stringify(giatri).replace(/"/g, '&quot;');
					<!-- content += '<p>'+ giatri["list_product"] +'</p>'; -->
					if(giatri["status"] == 1){
						content += '<button id="btn_voucher_'+ store_id +'" class="fs_12 text-white border-0 rounded" style="background:#e1a208" onclick="remove_choose_voucher_' + store_id + '(' + giatri["voucherid"] + ','+ store_id +')">Bỏ chọn</button>';
						}else{
						content += '<button class="fs_12 text-white border-0 rounded" style="background:#e1a208" onclick="apply_voucher_'+ store_id +'('+ ojb + ','+ store_id + ','+ chiso +');">Áp dụng</button>';	
					}
					content += '</div>';
					content += '</div>';
					content += '</div>';
					
					
					
					<!-- content += '<p>' + giatri["voucher_name"] +'</p>'; -->
					<!-- content += '<p> HSD '+ giatri["time_to"] +'</p>'; -->
					
					<!-- content += '<p> Giảm '+ giatri["discount_price"] +'</p>'; -->
					<!-- if(giatri["maximum_discount"] > 0){ -->
					<!-- content += '<p> Giảm tối đa ' + format_number(Number(giatri["maximum_discount"])) + 'đ' +'</p>'; -->
					<!-- } -->
					
					<!-- content += '<p> Đơn tối thiểu ' + format_number(Number(giatri["minimum_price"])) + 'đ' +'</p>'; -->
					
					<!-- var ojb = JSON.stringify(giatri).replace(/"/g, '&quot;'); -->
					<!-- content += '<p>'+ giatri["list_product"] +'</p>'; -->
					<!-- if(giatri["status"] == 1){ -->
					<!-- content += '<button onclick="remove_choose_voucher_' + store_id + '(' + giatri["voucherid"] + ','+ store_id +')">Bỏ chọn</button>'; -->
					<!-- }else{ -->
					<!-- content += '<button onclick="apply_voucher_'+ store_id +'('+ ojb + ','+ store_id + ','+ chiso +');">Áp dụng</button>';	 -->
					<!-- } -->
				});	
				$('#list_voucher_shop_' + store_id).html(content);
				
			}
			
			
			function apply_voucher_{info_store.id}(value, store_id, chiso){
				//đổi thông tin session voucherid
				$.ajax({
					type : 'GET',
					url : nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=apply_voucher_shop',
					dataType: "json",
					data:{
						voucherid: value.voucherid,
						product_id: value.product_id,
						store_id: store_id,
						total_price_one_shop: {total_price_one_shop},
					},
					beforeSend: function() { 
						$('#btn_voucher_'+store_id).prop('disabled', true);
						
					},	
					complete: function() {
						$('#btn_voucher_'+store_id).prop('disabled', false);
					},
					success : function(res){
						if (res.status == "OK")
						{
							//cap nhat tat ca status = 0
							updateAll_status_{info_store.id}(value.voucherid);
							//var as = JSON.parse(value.product_id);
							list_voucher_{info_store.id}.unshift({'voucherid':'' + value.voucherid + '','voucher_name':'' + value.voucher_name + '','time_to':'' + value.time_to + '','type_discount':'' + value.type_discount + '','maximum_discount':'' + value.maximum_discount + '','minimum_price':'' + value.minimum_price + '','list_product':'' + value.list_product + '','discount_price':'' + value.discount_price + '','price':'' + value.price + '','product_id':'' + value.product_id + '','status':'' + 1 + ''});
							//đóng modal
							$('#voucher_modal_'+ store_id).modal('hide');
							//xóa voucher đã chọn
							remove_voucher_{info_store.id}(chiso);
							//tính tiền lại
							var price_voucher_old = $('#price_choosed_'+ store_id ).text();
							tongvoucher = Number(tongvoucher) + Number(value.price) - Number(price_voucher_old);
							sum_phivanchuyen();
							hien();
							//thay đổi các chỉ số
							$('#voucherid_choosed_'+ store_id ).text(value.voucherid);
							$('#price_choosed_'+ store_id ).text(value.price);
							$('#max_price_voucher_'+ store_id ).html('-' + format_number(Number(value.price)) + 'đ');
							//cập nhật
							show_list_voucher_{info_store.id}(store_id);
						}
						else 
						{
							alert('Xin vui lòng thử lại');
						}
					}
					
				});
				
			}
			
			function updateAll_status_{info_store.id}(voucherid){
				objIndex = list_voucher_{info_store.id}.findIndex((obj => obj.voucherid > 1));
				list_voucher_{info_store.id}[objIndex].status = "0";
				
			}
			
			function remove_voucher_{info_store.id}(item){
				list_voucher_{info_store.id}.splice(item + 1, 1);
			}
			
			function remove_choose_voucher_{info_store.id}(voucherid, store_id){
				
				$.ajax({
					type : 'GET',
					url : nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=remove_voucher_shop',
					dataType: "json",
					data:{
						store_id: store_id
					},
					beforeSend: function() { 
						//$('#apply_'+shop_id).prop('disabled', true);
					},	
					complete: function() {
						//$('#apply_'+shop_id).prop('disabled', false);
					},
					success : function(res){
						if (res.status == "OK")
						{
							//cập nhật status =0
							objIndex = list_voucher_{info_store.id}.findIndex((obj => obj.voucherid == voucherid));
							list_voucher_{info_store.id}[objIndex].status = "0";
							$('#voucher_modal_'+ store_id).modal('hide');
							
							//tính tiền lại
							var price_voucher_old = $('#price_choosed_'+ store_id ).text();
							tongvoucher = Number(tongvoucher)  - Number(price_voucher_old);
							sum_phivanchuyen();
							hien();
							//thay đổi các chỉ số
							$('#voucherid_choosed_'+ store_id ).text(0);
							$('#price_choosed_'+ store_id ).text(0);
							$('#max_price_voucher_'+ store_id ).html('');
							//cập nhật
							show_list_voucher_{info_store.id}(store_id);
						}
						else 
						{
							alert('Xin vui lòng thử lại');
						}
					}
					
				});
			}
			
		</script>


    <div class="note d-flex justify-content-between align-items-center" style="background:#F9F9F9">
        <p class="fs_14 m-0 pl-2">Ghi chú:</p>
        <input id="note_product_{info_store.id}_{key_warehouse}" style="background:#F9F9F9; height:50px"
            class="text-right pr-1 w-50 border-0 " type="text" placeholder="Ghi chú cho cửa hàng" name=""
            aria-describedby="button-addon4" class="border-0 w-75">

    </div>
    <div class="fs_14 mt-2 p-2 shadow-sm" style="background:#F9F9F9">
        <div class="mb-2">Đơn vị vận chuyển</div>
        <div class="d-flex justify-content-between">
            <!-- BEGIN: transporters -->
            <div class="col-6" id="text_phivanchuyen_{info_store.id}_{key_warehouse}">
                <p class="mb-0 font-weight-bold text_gray_color" id="method_transfer_{info_store.id}_{key_warehouse}"><i
                        class="fa fa-spinner fa-spin" aria-hidden="true"></i></p>

            </div>
            <div class="col-md-2 secondary_text text-right">
                <span id="shipping_price_{info_store.id}_{key_warehouse}"></span>
                <input class="hidden transporter_store_active" id="transporter_first_{info_store.id}_{key_warehouse}"
                    value="{transporter_first}" />
                đ
            </div>

            <div class="col-md-2 text-right">
                <button class="btn_none secondary_text" data-toggle="modal"
                    data-target="#transporter_{info_store.id}_{key_warehouse}"
                    id="button_change_method_tranfer_{info_store.id}_{key_warehouse}">Thay đổi</button>
            </div>
            <script>			
							$( document ).ready(function() {
								
								
								if(transporter_{info_store.id} == ''){
									shop_tu_giao({info_store.id}, {key_warehouse});
								}
								
								
								function shop_tu_giao(store_id, warehouse_id){
									if(transporter_{info_store.id} == ''){
										$('#shipping_price_' + store_id + '_' + warehouse_id).html('{self_transport_price_max}');
										$("#button_change_method_tranfer_" + store_id + "_" + warehouse_id).html('');
										$("#method_transfer_" + store_id + "_" + warehouse_id).html('<p class="mb-0 text-center text_gray_color" >Cửa hàng giao sản phẩm</p>');
										tongphivanchuyen = tongphivanchuyen + {self_transport_price_max_value};
										
										sum_phivanchuyen();
									}
								}
								
								load_tranposter_next({info_store.id},{key_warehouse},{total_weight},{total_width},{total_length},{total_height},{total_warehouse},transporter_{info_store.id});
								
							});
						</script>
            <!-- END: transporters -->
            <!-- BEGIN: notransporters_loop -->
            <p>Đơn hàng này của bạn đã vượt mức cho phép về khối lượng và kích thước không thể vận chuyển</p>
            <!-- END: notransporters_loop -->

            <!-- modal vận chuyển  -->
            <div class="modal fade" id="transporter_{info_store.id}_{key_warehouse}">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4">
                        <div class="modal-header pt-0">
                            <h5 class="modal-title" id="">Chọn đơn vận chuyển</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="" id="">
                            <div id="tranposter_next_{info_store.id}_{key_warehouse}"></div>
                            <div class="payment_ship_save text-right hidden">
                                <button class="btn_ecng">Lưu</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- thêm vận chuyển  -->


        </div>
    </div>

    <script>
			
			var transporter_{info_store.id} = [];
			<!-- BEGIN: transporters_loop_js -->
			transporter_{info_store.id}.push({"id":{CARRIER.id},"name_transporters":"{CARRIER.name_transporters}","description":"{CARRIER.description}"});
			<!-- END: transporters_loop_js -->
			console.log(transporter_{info_store.id});
		</script>

    <!-- END: warehouse -->

</section>

<!-- END: store -->

<section>
    <input type="hidden" checked name="payment_method" id="payment_method" value="">
    <div class="pb-2 pt-3 px-3 bg_white my-2">
        <p class="fs_14 fw_500 mb-1">Phương thức thanh toán</p>
        <div class="mt-4">
            <!-- BEGIN: payment -->
            <div class="d-flex mr-5">
                <label class="ecng_label_radio m-0" onclick="change_payment_method('{PAYMENT.payment}')">
                    <input value="{PAYMENT.payment}" type="radio" name="gender" {checked}>
                    <span class="checkmark mt-2"></span>
                    <p class="fs_16 pl-2"><img src="{PAYMENT.images_button}"><span class="d-inline-block"
                            style="padding-top: 0.1rem;padding-left: 0.5rem;">{PAYMENT.paymentname}</span></p>
                </label>
            </div>
            <!-- END: payment -->
        </div>
    </div>
    <table class="table bg_white mb-0">
        <tbody>
            <tr class="fs_14 text_gray_color pt-3  ">
                <td class="text_gray_color border-0">
                    Tạm tính
                    <input hidden="" type="number" name="total_merchandise" id="total_merchandise" value="{total}">
                </td>
                <td class="text-right text_black border-0">{total_format}đ</td>
            </tr>
            <tr class="fs_14 text_gray_color pt-3">
                <td class="text_gray_color border-0">Phí vận chuyển</td>
                <td class="text-right text_black fs_14 border-0"><span id="tongphivanchuyen"><i
                            class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>đ</td>
            </tr>
            <tr class="row_voucher">
                <td class="text_gray_color border-0">Voucher</td>
                <td class="float-right border-0">-<span id="tongvoucher"><i class="fa fa-spinner fa-spin"
                            aria-hidden="true"></i></span>đ</td>

            </tr>
        </tbody>
    </table>
</section>

<div class="bg_white p-2 mt-2 mb-5 pb-4">
    <a href="https://chonhagiau.com/ecng/quy-dinh-va-hinh-thuc-thanh-toan.html" target="_blank"> Khi nhấn vào "Thanh
        toán" đồng nghĩa bạn đã kiểm tra kỹ đơn hàng và đồng ý với <span class="secondary_text">các điều khoản của ECNG
        </span>
    </a>
    <div class="fw_500 primary_text pt-2">Khi bạn thanh toán đơn hàng là bạn đã ủng hộ <span style="color:#1358B9">{children_fund}</span> tổng giá trị đơn hàng này vào quỹ  “ <span class="secondary_text">QUỸ BẢO TRỢ TRẺ EM VIỆT NAM</span> ”</div>
</div>

<div style="height:65px">
</div>

</div>

<div style="z-index: 9999;" class="bg_white fixed-bottom py-4 px-4 shadow_footer">
    <div class="d-flex justify-content-between">
        <p class="fs_14 font-weight-bold">Tổng thanh toán</p>
        <span class="secondary_text fs_18"><span id="tongtienchinhxac">{total_format}</span> đ</span>
    </div>
    <div class="">
        <button onclick="order_product_check_out()" class="btn_ecng d-block w-100 p-3 fs_18">Thanh Toán</button>
    </div>
</div>

<script>
	function change_payment(){
		var input_checked =  $(".ecng_label_radio input[type='radio']:checked").val();
		$('#payment_method').val(input_checked);
	};
	change_payment();
	function nv_carrier_change(store_id,warehouse_id,a)
	{ 
		
		$('#method_transfer_'+store_id+'_'+warehouse_id).html(a.title);
		$('#method_time_'+store_id+'_'+warehouse_id).html(a.title2);
		var transporter_first=document.getElementById('transporter_first_'+store_id+'_'+warehouse_id)
		transporter_first.setAttribute("value",a.value);
		var price = document.getElementById('phivanchuyen_'+store_id+'_'+warehouse_id+'_'+a.value).textContent;
		
		var price_old = (document.getElementById("shipping_price_"+store_id+"_"+warehouse_id).textContent).split(" ")[0]
		document.getElementById("shipping_price_"+store_id+"_"+warehouse_id).textContent = price;
		price_old = Number(price_old.replaceAll(",", ""));
		if(Number.isNaN(price_old)){
			price_old=0;
		}
		
		price_new = Number(price.split(" ")[0].replaceAll(",", ""));
		if(Number.isNaN(price_new)){
			price_new=0;
		}
		
		tongphivanchuyen = Number(tongphivanchuyen) - Number(price_old) + Number(price_new);
		sum_phivanchuyen(); 
		
		$('#transporter_'+ store_id +'_'+ warehouse_id).modal('toggle');
	}
	function load_data_tranposter_next(store_id,warehouse_id,transporter_id,name_transporters,description,phivanchuyen){
		var transporter_first = document.getElementById('transporter_first_'+store_id+'_'+warehouse_id).value;
		var checked = '';
		var onclick = 'onclick="nv_carrier_change('+store_id+','+warehouse_id+',this)"';
		
		if(transporter_id==transporter_first){
			checked = 'checked=checked';
		}
		
		$("#tranposter_next_"+store_id+"_"+warehouse_id).append('<div class="row mb-1"><div class="col-1"><label class="ecng_label_radio"><input name="carrier['+store_id+']['+warehouse_id+']" value='+transporter_id+' title="'+name_transporters+'" title2="'+description +'"' + onclick +' '+ checked +' type="radio" name="radio"><span class="checkmark"></span></label></div><div class="col-8"><p class="fs_16 mb-0">'+name_transporters+'</p><span class="text_gray_color content_'+store_id+'_'+warehouse_id+'">'+description+'</span></div><div class="col-3 text-right secondary_text"><span id="phivanchuyen_'+store_id+'_'+warehouse_id+'_'+transporter_id+'">'+phivanchuyen+' </span>đ</div></div>');
		
		sum_phivanchuyen();
	}
	
	function load_tranposter_next(store_id,warehouse_id,total_weight,total_width,total_length,total_height,total_warehouse,transporter_store){
		
		var province_id = $('input[name=province_id]').val();
		var district_id = $('input[name=district_id]').val();
		var ward_id = $('input[name=ward_id]').val();
		var lat = document.getElementById('lat').value;address
		var lng = document.getElementById('lng').value;
		var address = document.getElementById('address').value;
		if(isEmpty("#tranposter_next_"+store_id+"_"+warehouse_id)==true){
			
			transporter_store.forEach((element,index)=>{
				
				if(element.id == 5 || element.id  == 4){
					
					$.ajax({
						type : 'POST',
						url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax' + '&mod=get_transport_fee_vnpost',
						dataType: "json",
						data:{weight: Number(total_weight),
							length : Number(total_length),
							width : Number(total_width),
							height : Number(total_height),
							province_id : province_id,
							district_id : district_id,
							shops_id : warehouse_id,
							total : Number(total_warehouse),
							transporters_id : element.id,
							lat : lat, 
							lng : lng
						},
						beforeSend: function() { 
							//
						},	
						complete: function() {
							
						},
						success : function(res){
							//
							//console.log(res);
							if(Number(res)==-1){
								load_data_tranposter_next(store_id,warehouse_id,element.id,element.name_transporters,element.description,'Miến phí vận chuyển');
								}else{
								load_data_tranposter_next(store_id,warehouse_id,element.id,element.name_transporters,element.description,format_number(Number(res)));
								
							}
						}
						
					})
					}else if(element.id  == 3){
					
					$.ajax({
						type : 'GET',
						url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax' + '&mod=get_transport_fee_ghn',
						dataType: "json",
						data:{weight: Number(total_weight),
							length : Number(total_length),
							width : Number(total_width),
							height : Number(total_height),
							province_id : province_id,
							ward_id : ward_id,
							district_id : district_id,
							shops_id : store_id,
							warehouse_id : warehouse_id,
							total : Number(total_warehouse),
							transporters_id : element.id,
							lat : lat, 
							lng : lng
						},
						beforeSend: function() { 
							
						},	
						complete: function() {
							
						},
						success : function(res){
							//console.log(res);
							if(Number(res.fee)==-1){
								}else{
								if(Number(res.fee)==0){
									load_data_tranposter_next(store_id,warehouse_id,element.id,element.name_transporters,element.description,'0')
									}else{
									load_data_tranposter_next(store_id,warehouse_id,element.id,element.name_transporters,element.description,format_number(Number(res.fee)));
									$('.content_'+store_id+'_'+warehouse_id  +'').html(res.mess);
								}
							}
						}
						
					})
					
				}
			})
			
		}
	}
	function get_transport_fee(vitri,warehouse_id,store_id,total_weight,total_width,total_length,total_height,total_warehouse,transporter_store){
		
		var province_id = $('input[name=province_id]').val();
		var district_id = $('input[name=district_id]').val();
		var ward_id = $('input[name=ward_id]').val();
		var address = $('input[name=address]').val();
		var lat = document.getElementById('lat').value;
		
		var lng = document.getElementById('lng').value;
		var address = document.getElementById('address').value;
		var transporter_first=document.getElementById('transporter_first_'+store_id+'_'+warehouse_id);
		transporter_store.forEach((element,index)=>{
			
			if(index==vitri){
				if(element.id == 5 || element.id  == 4){ 
					
					$.ajax({
						type : 'POST',
						url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax' + '&mod=get_transport_fee_vnpost',
						dataType: "json",
						data:{weight: Number(total_weight),
							length : Number(total_length),
							width : Number(total_width),
							height : Number(total_height),
							province_id : province_id,
							district_id : district_id,
							ward_id : ward_id,
							address : address,
							shops_id : warehouse_id, 
							warehouse_id : warehouse_id, 
							total : Number(total_warehouse),
							transporters_id : element.id,
							lat : lat, 
							lng : lng
						},
						beforeSend: function() { 
							
						},	
						complete: function() {
							
						},
						success : function(res){
							//console.log(res);
							if(Number(res)==-1){
								if(vitri+1==transporter.length){
									$('#shipping_price_'+store_id+'_'+warehouse_id).html('Đơn hàng của bạn hiện không có nhà vận chuyển nào đáp ứng được. Vui lòng tách đơn');
									$('#text_phivanchuyen_'+store_id+'_'+warehouse_id).addClass('hidden');
									$('#button_change_method_tranfer').addClass('hidden');
									}else{
									get_transport_fee(index+1,warehouse_id,store_id,total_weight,total_width,total_length,total_height,total_warehouse,transporter_store);
								}
								}else{
								$('#shipping_price_'+store_id+'_'+warehouse_id).html('Đang cập nhật cước phí tạm tính, vui lòng đợi chút');
								$('#method_transfer_'+store_id+'_'+warehouse_id).html(element.name_transporters);
								$('#method_time_'+store_id+'_'+warehouse_id).html(element.description);
								transporter_first.setAttribute("value",element.id);
								
								if(Number(res)==0){
									$('#shipping_price_'+store_id+'_'+warehouse_id).html('0');
									tongphivanchuyen = tongphivanchuyen + 0;
									sum_phivanchuyen();
									}else{
									$('#shipping_price_'+store_id+'_'+warehouse_id).html(format_number(Number(res)));
									tongphivanchuyen = tongphivanchuyen + Number(res);
									sum_phivanchuyen();
								}
							}
						}
						
					})
					}
					if(element.id == 2){ 
					
						$.ajax({
							type : 'GET',
							url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax' + '&mod=get_transport_fee_ghtk',
							dataType: "json",
							data:{weight: Number(total_weight),
								length : Number(total_length),
								width : Number(total_width),
								height : Number(total_height),
								province_id : province_id,
								district_id : district_id,
								shops_id : store_id, 
								warehouse_id : warehouse_id, 
								total : Number(total_warehouse),
								transporters_id : element.id,
								lat : lat, 
								lng : lng
							},
							beforeSend: function() { 
								
							},	
							complete: function() {
								
							},
							success : function(res){
								//console.log(res);
								if(Number(res)==-1){
									if(vitri+1==transporter.length){
										$('#shipping_price_'+store_id+'_'+warehouse_id).html('Đơn hàng của bạn hiện không có nhà vận chuyển nào đáp ứng được. Vui lòng tách đơn');
										$('#text_phivanchuyen_'+store_id+'_'+warehouse_id).addClass('hidden');
										$('#button_change_method_tranfer').addClass('hidden');
										}else{
										get_transport_fee(index+1,warehouse_id,store_id,total_weight,total_width,total_length,total_height,total_warehouse,transporter_store);
									}
									}else{
									$('#shipping_price_'+store_id+'_'+warehouse_id).html('Đang cập nhật cước phí tạm tính, vui lòng đợi chút');
									$('#method_transfer_'+store_id+'_'+warehouse_id).html(element.name_transporters);
									$('#method_time_'+store_id+'_'+warehouse_id).html(element.description);
									transporter_first.setAttribute("value",element.id);
									
									if(Number(res)==0){
										$('#shipping_price_'+store_id+'_'+warehouse_id).html('0');
										tongphivanchuyen = tongphivanchuyen + 0;
										sum_phivanchuyen();
										}else{
										$('#shipping_price_'+store_id+'_'+warehouse_id).html(format_number(Number(res)));
										tongphivanchuyen = tongphivanchuyen + Number(res);
										sum_phivanchuyen();
									}
								}
							}
							
						})
					}
					else if(element.id  == 3 ){
					
					$.ajax({
						type : 'GET',
						url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax' + '&mod=get_transport_fee_ghn',
						dataType: "json",
						data:{weight: Number(total_weight),
							length : Number(total_length),
							width : Number(total_width),
							height : Number(total_height),
							province_id : province_id,
							ward_id : ward_id,
							district_id : district_id,
							shops_id : store_id,
							warehouse_id : warehouse_id, 
							total : Number(total_warehouse),
							transporters_id : element.id,
							lat : lat, 
							lng : lng
						},
						beforeSend: function() { 
							$('#button-payment-method').prop('disabled', true);
						},	
						complete: function() {
							$('#button-payment-method').prop('disabled', false);
						},
						success : function(res){
							//console.log(res);
							if(Number(res.fee)==-1){
								if(vitri+1==transporter.length){
									$('#shipping_price_'+store_id+'_'+warehouse_id).html('Đơn hàng của bạn hiện không có nhà vận chuyển nào đáp ứng được. Vui lòng tách đơn')
									$('#text_phivanchuyen_'+store_id+'_'+warehouse_id).addClass('hidden');
									$('#button_change_method_tranfer').addClass('hidden');
									}else{
									get_transport_fee(index+1,warehouse_id,store_id,total_weight,total_width,total_length,total_height,total_warehouse);
								}
								}else{
								transporter_first.setAttribute("value",element.id)
								$('#shipping_price_'+store_id+'_'+warehouse_id).html('Đang cập nhật cước phí tạm tính, vui lòng đợi chút')
								$('#method_transfer_'+store_id+'_'+warehouse_id).html(element.name_transporters)
								$('#method_time_'+store_id+'_'+warehouse_id).html(res.mess)
								if(Number(res.fee)==0){
									$('#shipping_price_'+store_id+'_'+warehouse_id).html('0')
									}else{
									$('#shipping_price_'+store_id+'_'+warehouse_id).html(format_number(Number(res.fee)));
									tongphivanchuyen = tongphivanchuyen + Number(res.fee);
									//$('#method_time_'+store_id+'_'+warehouse_id ).html(res.mess);
									sum_phivanchuyen();
								}
							}
						}
						
					})
					
				}
			}
		})
		
	}
</script>
<script> 
	
	get_free_warehouse();
	async function get_free_warehouse(){
		tongphivanchuyen = await 0;
		<!-- BEGIN: storejs -->
		<!-- BEGIN: warehousejs -->
		get_transport_fee(0,{key_warehouse},{info_store.id},{total_weight},{total_width},{total_length},{total_height},{total_warehouse},transporter_{info_store.id})
		<!-- END: warehousejs -->
		<!-- END: storejs -->
		
	} 
	function sum_phivanchuyen(){
		var total_merchandise = document.getElementById('total_merchandise').value;
		
		$('#tongphivanchuyen').html(format_number(tongphivanchuyen));
		$('#tongvoucher').html(format_number(tongvoucher));
		
		$('#tongtienchinhxac').html(format_number(Number(total_merchandise) + Number(tongphivanchuyen) - Number(tongvoucher)));
		
	}
	
	function number_transport()
	{
		var arr_transport = [];
		$('.transporter_store_active').each(function(){
			if(arr_transport.indexOf($(this).val()) == -1)
			{
				arr_transport.push($(this).val());
			}
		})
		
		$('.number_transport').html(arr_transport.length);
	}
	
	function order_product_check_out(){
		var list_transporters = [];
		var order_name=$('input[name=order_name1]').val();
		var order_email=$('input[name=order_email1]').val();
		var order_phone=$('input[name=order_phone1]').val();
		var lat=$('input[name=lat]').val();
		var lng=$('input[name=lng]').val();
		var address=$('input[name=address]').val();
		var province_name = $('input[name=province_id]').val();
		var district_name = $('input[name=district_id]').val();
		var ward_name = $('input[name=ward_id]').val();
		var payment_method = $('#payment_method').val();
		// var payment_method = document.getElementsByName('payment_method');
		//var total_merchandise = document.getElementById('total_merchandise').value;
		//var total_full = Number(total_merchandise) + Number(tongphivanchuyen);
		//for (var i = 0, length = payment_method.length; i < length; i++) {
			//if (payment_method[i].checked) {
				//payment_method = payment_method[i].value;
				//break;
			//}
		//};
		
		
		if(order_name==''){
			alert('Vui lòng nhập họ và tên')
			}else if(order_email==''){
			alert('Vui lòng nhập email')
			}else if(!IsEmail(order_email)){
			alert('Email không hợp lệ')
			}else if(!Phonenumber(order_phone)){
			alert('Số điện thoại không hợp lệ')
			}else if(order_phone==''){
			alert('Vui lòng nhập số điện thoại')
			}else if(province_name == ''){
			alert('Vui lòng chọn thành phố')
			}else if(district_name == ''){
			alert('Vui lòng chọn quận')
			}else if(ward_name == ''){
			alert('Vui lòng chọn phường')
			}else if(address == ''){
			alert('Vui lòng nhập địa chỉ ngắn gọn')
			}else{
			var error = 0;
			<!-- BEGIN: storejsorder -->
			<!-- BEGIN: warehousejs -->
			var transporters_id = document.getElementById('transporter_first_{key_store}_{key_warehouse}').value;
			var note_product = document.getElementById('note_product_{key_store}_{key_warehouse}').value;
			
			if(transporters_id == ''){
				transporters_id = 0;
			}
			
			var fee = (document.getElementById("shipping_price_{key_store}_{key_warehouse}").textContent).split(" ")[0];
			fee = Number(fee.replaceAll(",", ""));
			
			if(Number.isNaN(fee)){
				fee = 0;
			}
			
			list_transporters.push({'store_id':{key_store}, 'store_userid':{store_userid},'warehouse_id':{key_warehouse},'transporters_id':Number(transporters_id),'fee':fee,'note_product':note_product,'total_product':{total_warehouse},'total_weight':{total_weight},'total_width':{total_width},'total_length':{total_length},'total_height':{total_height}});
			
			<!-- END: warehousejs -->
			<!-- END: storejsorder -->
			
			if(error==1){
				alert('Vui lòng đợi tính phí vận chuyển')
				}else if(error==2){
				alert('Có 1 đơn hàng của 1 shop đã vượt mức cho phép về khối lượng và kích thước. Vui lòng tách đơn rồi đặt lại')
				}else if(error==4){
				alert('Vui lòng nhập lại mật khẩu để thanh toán')
				}else if(error==5){
				}else{
				$("#button-payment-method").attr("disabled", true);
				$("#button-payment-method").html("Đang xử lý");
				$("#button-payment-method").addClass("no_action");
				
				//console.log(nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=add_order&order_name=' + order_name+'&order_email='+order_email+'&order_phone='+order_phone+'&address='+address+'&province_id='+province_name+'&district_id='+district_name+'&ward_id='+ward_name+'&list_transporters='+JSON.stringify(list_transporters)+'&lat='+lat+'&lng='+lng);
				
				$.ajax({
					type : 'GET',
					url : nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=add_order',
					dataType: "json",
					data:{
						order_name: order_name,
						order_email : order_email,
						order_phone : order_phone,
						address : address,
						province_id : province_name,
						ward_id : ward_name,
						district_id : district_name,
						list_transporters : list_transporters, 
						payment_method : payment_method, 
						lat : lat, 
						lng : lng
					},
					beforeSend: function() { 
						
					},	
					complete: function() {
						
					},
					success : function(res){
						
						if (res.status != 'OK') {
							if(res.status=='error'){
								$("#button-payment-method").attr("disabled", false);
								$("#button-payment-method").html("Đặt hàng");
								$("#button-payment-method").removeClass("no_action");
								alert(res.mess);
								}else if(res.status=='OK_VNPAY'){
								location.href = res.link
								}else if(res.status=='OK_RECIEVE'){
								location.href = res.link.replace("&amp;", "&");
								}else if(res.status=='error_password_money'){
								$("#button-payment-method").attr("disabled", false);
								$("#button-payment-method").html("Đặt hàng");
								$("#button-payment-method").removeClass("no_action");
								alert(res.mess)
								}else{
								$('.error_thongbao').html("");
								res.error.forEach(element=>{
									$('.error_thongbao').append(element);
								})
							}
							} else {
							alert(res.mess);
							location.href=res.link;
						}
					}
					
				})
			}
		}
	}
	function check_email_error(a){
		var email=$(a).val();
		if(!IsEmail(email)){
			alert('Email không hợp lệ')
		}
	}
	function check_phone_error(a){
		var phone=$(a).val();
		if(!Phonenumber(phone)){
			alert('Số điện thoại không hợp lệ')
		}
	};
	
	function hien(){
		if(tongvoucher > 0){
			$(".row_voucher").show();
			}else{
			$(".row_voucher").hide();
		};
	};
	
	if(tongvoucher > 0){
		$(".row_voucher").show();
		}else{
		$(".row_voucher").hide();
	};
	function change_payment_method(payment_method){
		$('#payment_method').val(payment_method);
	};
</script>
{* <script>
    get_free_warehouse();
    async function get_free_warehouse() {
        tongphivanchuyen = await 0;
        !--BEGIN: storejs-- >
            <
            !--BEGIN: warehousejs-- >
            get_transport_fee(0,{key_warehouse},{info_store.id},{total_weight},{total_width},{total_length},{total_height},{total_warehouse},transporter_{info_store.id})
            <
            !--END: warehousejs-- >
            <
            !--END: storejs-- >

    }

    function sum_phivanchuyen() {
        var total_merchandise = document.getElementById('total_merchandise').value;

        $('#tongphivanchuyen').html(format_number(tongphivanchuyen));
        $('#tongvoucher').html(format_number(tongvoucher));

        $('#tongtienchinhxac').html(format_number(Number(total_merchandise) + Number(tongphivanchuyen) - Number(
            tongvoucher)));

    }

    function number_transport() {
        var arr_transport = [];
        $('.transporter_store_active').each(function() {
            if (arr_transport.indexOf($(this).val()) == -1) {
                arr_transport.push($(this).val());
            }
        })

        $('.number_transport').html(arr_transport.length);
    }



    function order_product_check_out() {
        var list_transporters = [];
        var order_name = $('input[name=order_name1]').val();
        var order_email = $('input[name=order_email1]').val();
        var order_phone = $('input[name=order_phone1]').val();
        var lat = $('input[name=lat]').val();
        var lng = $('input[name=lng]').val();
        var address = $('input[name=address]').val();
        var province_name = $('input[name=province_id]').val();
        var district_name = $('input[name=district_id]').val();
        var ward_name = $('input[name=ward_id]').val();
        var payment_method = document.getElementsByName('payment_method');
        var total_merchandise = document.getElementById('total_merchandise').value;
        var total_full = Number(total_merchandise) + Number(tongphivanchuyen);
        for (var i = 0, length = payment_method.length; i < length; i++) {
            if (payment_method[i].checked) {
                payment_method = payment_method[i].value;
                break;
            }
        };

        if (order_name == '') {
            alert('Vui lòng nhập họ và tên')
        } else if (order_email == '') {
            alert('Vui lòng nhập email')
        } else if (!IsEmail(order_email)) {
            alert('Email không hợp lệ')
        } else if (!Phonenumber(order_phone)) {
            alert('Số điện thoại không hợp lệ')
        } else if (order_phone == '') {
            alert('Vui lòng nhập số điện thoại')
        } else if (province_name == '') {
            alert('Vui lòng chọn thành phố')
        } else if (district_name == '') {
            alert('Vui lòng chọn quận')
        } else if (ward_name == '') {
            alert('Vui lòng chọn phường')
        } else if (address == '') {
            alert('Vui lòng nhập địa chỉ ngắn gọn')
        } else {
            var error = 0; <
            !--BEGIN: storejsorder-- >
                <
                !--BEGIN: warehousejs-- >
                var transporters_id=document.getElementById('transporter_first_{key_store}_{key_warehouse}').value;
                var note_product=document.getElementById('note_product_{key_store}_{key_warehouse}').value;
                if (transporters_id == '') {
                    transporters_id = 0;
                }

            var fee = (document.getElementById("shipping_price_{key_store}_{key_warehouse}").textContent).split(" ")[0];
            fee = Number(fee.replaceAll(",", ""));


            if (Number.isNaN(fee)) {
                fee = 0;
            }

            list_transporters.push({'store_id':{key_store}, 'store_userid':{store_userid},'warehouse_id':{key_warehouse},'transporters_id':Number(transporters_id),'fee':fee,'note_product':note_product,'total_product':{total_warehouse},'total_weight':{total_weight},'total_width':{total_width},'total_length':{total_length},'total_height':{total_height}});

            <
            !--END: warehousejs-- >
                <
                !--END: storejsorder-- >

                if (error == 1) {
                    alert('Vui lòng đợi tính phí vận chuyển')
                } else if (error == 2) {
                alert(
                    'Có 1 đơn hàng của 1 shop đã vượt mức cho phép về khối lượng và kích thước. Vui lòng tách đơn rồi đặt lại'
                )
            } else if (error == 4) {
                alert('Vui lòng nhập lại mật khẩu để thanh toán')
            } else if (error == 5) {} else {
                $("#button-payment-method").attr("disabled", true);
                $("#button-payment-method").html("Đang xử lý");
                $("#button-payment-method").addClass("no_action");

                //console.log(nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&mod=add_order&order_name=' + order_name+'&order_email='+order_email+'&order_phone='+order_phone+'&address='+address+'&province_id='+province_name+'&district_id='+district_name+'&ward_id='+ward_name+'&list_transporters='+JSON.stringify(list_transporters)+'&lat='+lat+'&lng='+lng);

                $.ajax({
                    type: 'POST',
                    url: nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=' + nv_module_name + '&' +
                        nv_fc_variable + '=ajax&mod=add_order',
                    dataType: "json",
                    data: {
                        order_name: order_name,
                        order_email: order_email,
                        order_phone: order_phone,
                        address: address,
                        province_id: province_name,
                        ward_id: ward_name,
                        district_id: district_name,
                        list_transporters: list_transporters,
                        lat: lat,
                        lng: lng
                    },
                    beforeSend: function() {

                    },
                    complete: function() {

                    },
                    success: function(res) {
                        console.log(res);
                        if (res.status != 'OK') {
                            if (res.status == 'error') {
                                $("#button-payment-method").attr("disabled", false);
                                $("#button-payment-method").html("Đặt hàng");
                                $("#button-payment-method").removeClass("no_action");
                                alert(res.mess);
                            } else if (res.status == 'OK_VNPAY') {
                                location.href = res.link
                            } else if (res.status == 'error_password_money') {
                                $("#button-payment-method").attr("disabled", false);
                                $("#button-payment-method").html("Đặt hàng");
                                $("#button-payment-method").removeClass("no_action");
                                alert(res.mess)
                            } else {
                                $('.error_thongbao').html("");
                                res.error.forEach(element => {
                                    $('.error_thongbao').append(element);
                                })
                            }
                        } else {
                            alert(res.mess);
                            //location.href=res.link;
                        }
                    }

                })
            }
        }
    }

    function check_email_error(a) {
        var email = $(a).val();
        if (!IsEmail(email)) {
            alert('Email không hợp lệ')
        }
    }

    function check_phone_error(a) {
        var phone = $(a).val();
        if (!Phonenumber(phone)) {
            alert('Số điện thoại không hợp lệ')
        }
    };

    function hien() {
        if (tongvoucher > 0) {
            $(".row_voucher").show();
        } else {
            $(".row_voucher").hide();
        };
    };

    if (tongvoucher > 0) {
        $(".row_voucher").show();
    } else {
        $(".row_voucher").hide();
    };

</script> *}



<!-- END: main -->