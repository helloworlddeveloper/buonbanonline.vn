
<!-- BEGIN: noproduct -->
	<div class="text-center cartshop_empty">
        <img src="/themes/default/chonhagiau/images/gio_hang_rong1.png" style="width:200px" alt="">
        <p class="secondary_text fs_16 mt-3 mb-4">Giỏ hàng của bạn đang rỗng </p>
        <a href="{HOME}" class="btn_ecng">Tiếp tục mua sắm</a>
    </div>
<!-- END: noproduct -->

<!-- BEGIN: main -->
<script>
	var store=[]
</script>

<div class="h-auto" style="margin-bottom:65px">
        <header class=" pb-2 bg_white">
            <div class="login pt-2 text-center">
                <p class="fs_18 mt-3">Giỏ hàng</p>
            </div>
        </header>
		
		<!-- BEGIN: store -->
        <section class="shop_name bg_white mb-1 pt-3 mt-2">
            <div class="row bd_b_1 pl-3">
                <div class="cart-item__cell-checkbox">
                                <input class="ip_check" type="checkbox" id="store_{info_store.id}" {status_check_store} name="store_{info_store.id}"
                                onchange="check_store(this,{info_store.id})">
                                <label for="store_{info_store.id}" class="lb_check">
                                </label>
                </div>
                <div class="col-11 text_black fs_18 ml-2">
                    <span>{info_store.company_name}</span>
                </div>
            </div>
			
			<!-- BEGIN: warehouse -->
			<!-- BEGIN: loop -->
            <div class="row pb-3 pt-3 pl-3 align-items-center">
                <div class="mr-2">
                    <input class="ip_check_product ip_check store_{info_store.id}_{key_warehouse}_{key_product} store_id_{info_store.id}" onchange="check_product({info_store.id},{key_product},{key_warehouse},this)" {status_check} type="checkbox" id="store_{info_store.id}_{key_warehouse}_{key_product}">
                    <label for="store_{info_store.id}_{key_warehouse}_{key_product}" class="lb_check">
                </label>
                </div>
                <div class="col-3">
                    <a class="beauty_img width_80" href="{LOOP_INFO_PRODUCT.alias}"><img class="max_w_h rounded" src="{LOOP_INFO_PRODUCT.image}" alt="{LOOP_INFO_PRODUCT.name_product}"></a>
                </div>
                <div class="col-7 pl-2">
                    <p class="mb-1 fs_14 text_black">{LOOP_INFO_PRODUCT.name_product}</p>
                    <p class="mb-1 text_gray_color capitalize">{LOOP_INFO_PRODUCT.name_group}</p>
                    <p class="mb-1 secondary_text">{LOOP_INFO_PRODUCT.price_format}đ</p>
                    <div class="number-input">
                        <button onclick="update_cart_down( {key_store},{key_product},{key_warehouse},this)"></button>
                        <input onchange="update_cart( {key_store},{key_product},{key_warehouse},this)" class="plus" max="{LOOP_INFO_PRODUCT.number_inventory_max}" class="quantity" min="1" name="quantity" value="{LOOP_INFO_PRODUCT.quantity}" type="number">
                        <button onclick="update_cart_up( {key_store},{key_product},{key_warehouse},this)" class="plus"></button>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button onclick="remove_cart({key_store},{key_product},{key_warehouse});" title="Xóa" class="btn_none fs_24 text_gray_color">&times;</button>
                </div>
            </div>
			
			<script>
			 store.push({store_id:{key_store},key_warehouse:{key_warehouse},key_product:{key_product},total:{LOOP_INFO_PRODUCT.total_input}});
			 document.getElementById("quantity_{key_store}_{key_warehouse}_{key_product}").addEventListener("keyup", function(e) {if (e.target.value > {LOOP_INFO_PRODUCT.number_inventory_max}) {this.value = {LOOP_INFO_PRODUCT.number_inventory_max}} else if (e.target.value.length && e.target.value <= 0) {this.value = 1;}})
			</script>
            <!-- END: loop -->
			<!-- END: warehouse -->
		</section>
		<!-- END: store -->
</div>

<div style="height: 60px;">

</div>

<footer style="z-index: 99999;" class="bg_white fixed-bottom py-4 px-4 shadow_footer">
        <div class="d-flex row  align-items-center">
            <label class="col-4 fs_14 pt-1">
                <div class="cart-item__cell-checkbox d-flex align-items-center py-2">
					<input class="ip_check" type="checkbox" id="check_all" {status_check_store_all}
								onchange="checkall(this)"/>
								
							<input class="ip_check" type="checkbox" id="check_all2" {status_check_store_all} onchange="checkall2(this)"/>
							<label for="check_all" class="lb_check mb-0"></label>
							<a class="cart-page-shop-header__shop-name pl-2">
									<span>Chọn tất cả</span>
							</a>
				</div>
                
            </label>
            <p class="col-8 fs_14 text-right mb-0">Tổng tiền:
                <span class="secondary_text fs_18"><span id="total_no">{total}</span>đ</span>
            </p>
        </div>
        <div class="">
            <button onclick="thanhtoan_cart(event);"  class="text-center btn_ecng d-block w-100 p-3 fs_18">Tiến hành đặt hàng</button>
        </div>
</footer>


<script>
	
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