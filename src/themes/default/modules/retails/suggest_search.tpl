<!-- BEGIN: main --> 

<!-- BEGIN: nodata --> 
	<li>
           <a href="#" class="text_black p-2 w-100 d-block" href="{SHOP.alias}">Không tìm thấy kết quả!</a>
    </li>   
<!-- END: nodata --> 

<!-- BEGIN: data -->
		<!-- BEGIN: shop -->
		<li>
            <a title="{SHOP.company_name}" class="text_black p-2 w-100 d-block" href="{SHOP.alias}">
				<span class="secondary_text">
				<i class="fa fa-diamond" aria-hidden="true"></i> Cửa hàng </span> {SHOP.company_name}
			</a>
		</li>
		<!-- END: shop -->
		
		<!-- BEGIN: loop -->
		<li> 
            <a class="text_black d-block w-100 p-2" href="{LOOP_PRODUCT.alias}" title="{LOOP_PRODUCT.name_product}">{LOOP_PRODUCT.name_product}</a>
		</li>
		<!-- END: loop -->

<!-- BEGIN: data -->

<!-- END: main -->