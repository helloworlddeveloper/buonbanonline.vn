<!-- BEGIN: main --> 

<!-- BEGIN: nodata --> 
	<li>
           Không tìm thấy kết quả!
    </li>   
<!-- END: nodata --> 

<!-- BEGIN: data -->
		<!-- BEGIN: shop -->
		<li>
            <a title="{SHOP.company_name}" class="text_black pl-2 py-2 d-block w-100 h-100" href="{SHOP.alias}"><span class="secondary_text"><i class="fa fa-diamond" aria-hidden="true"></i> Cửa hàng </span> {SHOP.company_name}</a>
		</li>
		<!-- END: shop -->
		
		<!-- BEGIN: loop -->
		<li> 
            <a class="text_black pl-2 py-2 d-block w-100 h-100" href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">{LOOP_PRODUCT.name_product}</a>
		</li>
		<!-- END: loop -->

<!-- BEGIN: data -->

<!-- END: main -->