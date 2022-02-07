<!-- BEGIN: main -->
<div class="header_cart">
    <a href="{LINK_CART}">
        <img class="" style="width:30px" src="/themes/default/chonhagiau/images/giohang.svg" />
		<span class="header_cart_number">{count_cart}</span>
    </a>
	<!-- BEGIN: cart -->
    <div class="cart_view">
        <table class="my-2" style="width: 100%;">
		<!-- BEGIN: loop -->
            <tr>
                <td>
                    <a href="{LOOP_INFO_PRODUCT.alias}">
						<div class="cart_view_img beauty_img">
						<img class="max_w_h" src="{LOOP_INFO_PRODUCT.image}" alt="{LOOP_INFO_PRODUCT.name_product}" />
						</div>
					</a>
                </td>
                <td class="cart_view_name text_limited"><a href="{LOOP_INFO_PRODUCT.alias}">{LOOP_INFO_PRODUCT.name_product}</a></td>
                <td class="cart_view_amount text_gray_color">SL: {LOOP_INFO_PRODUCT.quantity}</td>
                <td class="cart_view_price text-ecng">{LOOP_INFO_PRODUCT.total}đ</td>
                <td><button onclick="delete_product_cart({key_store},{key_product},{key_warehouse});" class="cart_view_btn"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
            </tr>
		<!-- END: loop -->
        </table>
        <div class="cart_view_bottom pb-2 px-2 d-flex justify-content-between row">
			<div class="col-xs-6 col-sm-6 col-md-6">
			<!-- BEGIN: con -->
            <span class="text_gray_color">Còn {con} sp khác</span>
			<!-- END: con -->
			
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 text-right">
            <a href="{LINK_CART}" class="btn btn_ecng">Xem Giỏ Hàng</a>
			</div>
        </div>
    </div>
	<!-- END: cart -->
</div>

<script>
	function delete_product_cart(key_store,key_product,key_warehouse)
	{
		if(key_store > 0)
		{
			$.post(nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '={MODULE_NAME}&' + nv_fc_variable + '=ajax&mod=remove_cart&key_store='+key_store+'&key_product='+key_product+'&key_warehouse='+key_warehouse,
			function(res) {
				location.reload();
			});
				
		}
	} 
</script>

<!-- END: main -->
