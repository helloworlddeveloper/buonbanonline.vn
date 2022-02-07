
<!-- BEGIN: noproduct -->
<div class="d-flex align-items-center justify-content-center  bg_white" style="min-height:400px" >
	<div class="text-center">
		<img src="/themes/default/chonhagiau/images/gio_hang_rong.png" style="width:200px" alt="">
		<p class="secondary_text fs_16 my-3">Giỏ hàng của bạn đang rỗng </p>
		<a href="{HOME}" class="btn_ecng w-100">Tiếp tục mua sắm</a>
	</div>
</div>
<!-- END: noproduct -->

<!-- BEGIN: main -->
<script>
	var store=[]
</script>
<div id="ProductContent" class="ProductContent_cart">
    <div class="bg_white mb-3 secondary_text rounded-lg text-center">
		<p class="fs_24 secondary_text py-3"> Giỏ hàng của bạn</p>
	</div>
    <form action="" method="post" enctype="multipart/form-data" id="check_disable">
        <input type="hidden" name="action" value="update">            
		<div class="cart_header bg_white p-3 mb-3">				
			<div class="row text-center fs_16">
				<div class="col-5 d-flex align-items-center ">						
					<input class="ip_check" type="checkbox" id="check_all" {status_check_store_all}
					onchange="checkall(this)">
					<label for="check_all" class="lb_check mb-0"></label>
					
					<div class="ml-3">
						Sản phẩm
					</div>
				</div>
				<div class="col-2">Đơn giá
				</div>
				<div class="col-2"> Số lượng
				</div>
				<div class="col-2">Thành tiền
				</div>
				<div class="col-1">Thao tác
				</div>
			</div>                                     
		</div>
		<!-- BEGIN: store -->
		<div class="bg_white mb-3">
			<div class="d-flex px-5 pt-3">
				<div class="cart-item__cell-checkbox">
					<input class="ip_check" type="checkbox" id="store_{info_store.id}" {status_check_store} name="store_{info_store.id}"
					onchange="check_store(this,{info_store.id})">
					<label for="store_{info_store.id}" class="lb_check">
					</label>
				</div>
				<a class="" href="{ALIAS_STORE}">
					<span style="margin-left: 5px;">Cửa hàng: <span class="secondary_text">{info_store.company_name}</span>
					</span>
				</a>
			</div>
			
            <!-- BEGIN: warehouse -->
			<!-- BEGIN: loop -->
			<div class="row mt-3 text-center align-items-center pb-2">
				<div class="col-2 d-flex align-items-center justify-content-end">
					<div class="mr-2">
						<input class="ip_check_product ip_check store_{info_store.id}_{key_warehouse}_{key_product} store_id_{info_store.id}" onchange="check_product({info_store.id},{key_product},{key_warehouse},this)" {status_check} type="checkbox" id="store_{info_store.id}_{key_warehouse}_{key_product}">
						<label for="store_{info_store.id}_{key_warehouse}_{key_product}" class="lb_check">
						</label>
					</div>
					<a href="{LOOP_INFO_PRODUCT.alias}" class="d-flex justify-content-center align-items-center width_80 beauty_img">
						<img src="{LOOP_INFO_PRODUCT.image}" alt="{LOOP_INFO_PRODUCT.name_product}" title="{LOOP_INFO_PRODUCT.name_product}" class="max_w_h" >
					</a>             
				</div>
				
				<div class="col-3 text-left">				
					<a href="{LOOP_INFO_PRODUCT.alias}" class="cart-item-overview__name" alt="{LOOP_INFO_PRODUCT.name_product}" title="{LOOP_INFO_PRODUCT.name_product}">
						<p class="mb-0 text_limited"> {LOOP_INFO_PRODUCT.name_product}</p>
					</a>
					<p class="mb-0 text_gray_color">{LOOP_INFO_PRODUCT.name_group}</p>         
				</div>
				<div class="col-2">	
					{LOOP_INFO_PRODUCT.price_format}đ
				</div>
				<div class="col-2">
					<div class="number-input">
						<a onclick="update_cart_down( {key_store},{key_product},{key_warehouse},this)"></a>
						<input onchange="update_cart( {key_store},{key_product},{key_warehouse},this)" class="plus" max="{LOOP_INFO_PRODUCT.number_inventory_max}" class="quantity" min="1" name="quantity" value="{LOOP_INFO_PRODUCT.quantity}" type="number">
						<a onclick="update_cart_up( {key_store},{key_product},{key_warehouse},this)" class="plus"></a>
					</div>
				</div>
				<script>
				</script>
				<div class="col-2">
					<div class="secondary_text">
						{LOOP_INFO_PRODUCT.total}đ
					</div>
				</div>
				<div class="col-1 text-center">
                    <button type="button" data-toggle="tooltip" class="cart-item__action" onclick="remove_cart({key_store},{key_product},{key_warehouse});" title="Xóa">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
					
				</div>
			</div>
			
			
			
			<script>
				store.push({store_id:{key_store},key_warehouse:{key_warehouse},key_product:{key_product},total:{LOOP_INFO_PRODUCT.total_input}});
				document.getElementById("quantity_{key_store}_{key_warehouse}_{key_product}").addEventListener("keyup", function(e) {if (e.target.value > {LOOP_INFO_PRODUCT.number_inventory_max}) {this.value = {LOOP_INFO_PRODUCT.number_inventory_max}} else if (e.target.value.length && e.target.value <= 0) {this.value = 1;}})
			</script>
			<!-- END: loop -->
			<!-- END: warehouse -->
		</div>
		<!-- END: store -->
		
		
		
		<div class="cart_payment mb-3  bg_white ">
            <div class="row d-flex pl-3 p-4  align-items-center">
                <div class="col-3 d-flex align-items-center">
                    <div class="d-flex">
                        <div class="cart-item__cell-checkbox">
							<input class="ip_check" type="checkbox" id="check_all2" {status_check_store_all} onchange="checkall2(this)">
							<label for="check_all" class="lb_check"></label>
						</div>
						<a class="cart-page-shop-header__shop-name">
							<span>Chọn tất cả</span>
						</a>
					</div>
				</div>
                <div class="col-9 text-right">
                    <p class="d-inline mr-3"><span class="tong_tien_hang" style="padding: 5px;">
						Tổng tiền hàng:
						<span class="secondary_text fs_20" id="total_no">
							{total}</span> <span class="secondary_text fs_20">đ</span>
					</span>
					</p>
					
					<button onclick="thanhtoan_cart(event);" class="btn_ecng padding10">
						Thanh toán
					</button>
				</div>
			</div>
		</div>
		
	</form>
</div>

<script>
	$(document).ready(function(){
			var btn_dis = function(){
				var ch = $('input.ip_check_product:checked').length;
				if(ch == 0){
					$('button.btn_ecng.padding10').prop('disabled', true);
					$('button.btn_ecng.padding10').css({
							"background-color" : "#c4c4c4",
							"border" : "none"
					});
				}
				else{
					$('button.btn_ecng.padding10').prop('disabled', false);
					$('button.btn_ecng.padding10').css({
							"background-color" : "#e1a208",
							"border" : "solid 1px #e1a208"
					});
				}
			};
			setInterval(btn_dis, 50);
	});
	
	function thanhtoan_cart(e)
	{
		e.preventDefault();  
		var count_checked = $('input.ip_check_product:checked').length;
		
		if(count_checked == 0)
		{
			alert('Giỏ hàng không có sản phẩm');
		}
		else
		{
			window.location.href = '{LINK_ORDER}'
		}
	}

</script>
<!-- END: main -->