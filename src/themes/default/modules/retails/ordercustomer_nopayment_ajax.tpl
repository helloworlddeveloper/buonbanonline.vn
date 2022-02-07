<!-- BEGIN: main -->

<!-- BEGIN: no_product -->
<div class="no_product" style="min-height: 300px"><p class="fs_16 mb-3 bg_white text-center font-weight-normal">Không tìm thấy kết quả!</p></div>
<!-- END: no_product -->
<div id="item_order_customer">
<!-- BEGIN: loop -->
<div class="history bg_white px-3 mb-1">
	<div class="history_header d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
		<div class="history_header_shop">
			<a class="d-flex align-items-center" title="{VIEW.store_name}" href="{VIEW.alias_shop}">
				<div class="beauty_img" style="width: 35px; height: 35px;">
					<img class="max_w_h rounded" src="{VIEW.avatar_image_store}" class="rounded-circle" alt="">
				</div>
				
				<span class="ml-3"> {VIEW.store_name}</span>
			</a>
		</div>
		<span href="#" class="secondary_text ">{VIEW.order_status}</span>
	</div>
	<p class="mb-0">Mã đơn hàng: <a href="{VIEW.link_view}" class="secondary_text" style="text-decoration: underline;">{VIEW.order_code}</a>  - <span class="text_gray_color">{VIEW.time_add} </span></p>
	<div class="history_product border-bottom pb-2">
		<!-- BEGIN: product -->
		<div class="row d-flex align-items-center py-2">
			<div class="col-md-2 col-xl-1">
				<a class="beauty_img width_80" title="{product.name_product}" href="{product.alias_product}"><img src="{product.image}" class="max_w_h" alt=""></a>
			</div>
			<div class="col-md-7">
				<div class="cartName px-3">
					
						<p class="mb-0"><a title="{product.name_product}" href="{product.alias_product}">{product.name_product}</a></p>
				   
					<p class="text_gray_color mb-0">{product.name_group}</p>
				</div>
			</div>

			<div class="col-md-1 col-xl-2 text-center">
				x {product.quantity}
			</div>
			<div class="col-md-2 secondary_text text-center">{product.price}đ</div>
		</div>
		<!-- END: product -->
	</div>
	<div class="history_option w-100 d-flex justify-content-end align-items-center">
		<p class="fs_18 pt-3">Tổng số tiền: <span class="secondary_text">{VIEW.total}đ</span></p>

		
	</div>
	<!-- BEGIN: repayment -->
		<div class="mb-3 pt-3 border-top">
			<div class="total_repayment d-flex justify-content-end fs_18 bg_white pb-3">
				<div class="total_price_repayment secondary_text my-2 mr-3">{total_payment}đ</div>
				<div class="vnpay_repayment"><span class="btn btn_ecng " onclick="repayment('{id_order}',{tongtien});">Thanh toán lại</span></div>
			</div>				
		</div>
	<!-- END: repayment -->
</div>
<!-- END: loop -->

<div class="clear"></div>
<!-- BEGIN: generate_page -->
		<nav class="text-center">
			{NV_GENERATE_PAGE}
		</nav>
<!-- END: generate_page -->
			
</div>

<script>								
	// rating 		
		$('.rate_star li').on('mouseover', function() {
			var onStar = parseInt($(this).data('value'), 10);


			$(this).parent().children('li.star').each(function(e) {
				if (e < onStar) {
					$(this).addClass('hover');
				} else {
					$(this).removeClass('hover');
				}
			});

		}).on('mouseout', function() {
			$(this).parent().children('li.star').each(function(e) {
				$(this).removeClass('hover');
			});
		});
		/*click */
		$('.rate_star li').on('click', function() {
			var onStar = parseInt($(this).data('value'), 10);
			var stars = $(this).parent().children('li.star');
			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}
			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}
		});
			
	function button_rate_product(order_id)
	{	
		var arr_product_id = [];
		var arr_classify_value_product_id = [];
		var arr_star = [];
		var arr_comment = [];
		
		var flag = false;
		
		$('#cmt_product' + order_id + ' .cmt_product_item').each(function(){
			var product_id = $(this).attr('product_id');
			arr_product_id.push(product_id);
			
			var classify_value_product_id = $(this).attr('classify_value_product_id');
			arr_classify_value_product_id.push(classify_value_product_id);
			
			var star = $(this).find('li.selected').length;
			if(star == 0)
			{
				thongbao1('Bạn chưa chọn số sao!');
				flag = true;
				return false;
			}
			else
			{
				arr_star.push(star);
			}
			
			var comment = $(this).find('textarea').val();
			if(comment == '')
			{
				thongbao1('Bạn chưa nhập đánh giá!');
				flag = true;
				return false;
			}
			else
			{
				arr_comment.push(comment);
			}										
		});		
		if(flag)
		{
			return false;
		}
		
		$.ajax({
			  type : 'GET',
			  url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=vieworder&mod=rate',
			  data: {id_order_ajax : order_id, arr_product_ajax : arr_product_id, arr_classify_ajax : arr_classify_value_product_id, arr_star_ajax : arr_star, arr_comment_ajax : arr_comment },
			  complete: function() {
					$('#submit_rated').prop('disabled', true);
					$('#submit_rated').addClass('btn_gray').removeClass('btn_ecng');
					
				},
			  success : function(res){
				res2=JSON.parse(res);
				console.log(res2);
				
				if(res2.status=="OK"){
				  alert(res2.text);
				  location.reload();
			  }else{
				  thongbao('Có lỗi xảy ra!')
			  }
			  },
			  error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		
		})
		
	}
	
	
	
</script>			
			
<!-- END: main -->
