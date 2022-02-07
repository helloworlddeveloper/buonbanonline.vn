<!-- BEGIN: main -->

<!-- BEGIN: no_product -->
<div class="no_product">Không tìm thấy đơn hàng! </div>
<!-- END: no_product -->
<div id="item_order_customer">
	<!-- BEGIN: loop -->	
	<div class="history bg_white px-3 mb-2 " data-role="page" >
		<div class="history_header d-flex justify-content-between border-bottom  py-2 mb-3">
			<div class="history_header_shop">
				<a title="{VIEW.store_name}" href="{VIEW.alias_shop}">
					<img src="{VIEW.avatar_image_store}" class="rounded-circle" style="width: 25px; height: 25px;" alt="">
					<span class="ml-3"> {VIEW.store_name}</span>
				</a>
			</div>
			<span href="#" class="secondary_text ">{VIEW.order_status}</span>
		</div>
		<p class="mb-0">Mã đơn hàng: <a href="{VIEW.link_view}" class="secondary_text" style="text-decoration: underline;">{VIEW.order_code}</a> - <span class="text_gray_color">{VIEW.time_add_string} </span></p>
		<div class="history_product border-bottom pb-2">
			<!-- BEGIN: product -->
			<div class="row d-flex align-items-center py-2">
				<div class="col-2 ">
					<a title="{product.name_product}" href="{product.alias_product}"><img src="{product.image}" class="width_60" style="object-fit:contain" alt=""></a>
				</div>
				<div class="col-6">
					<div class="cartName px-2">
						<p class="mb-0"><a title="{product.name_product}" href="{product.alias_product}">{product.name_product}</a></p>
						<p class="text_gray_color mb-0">{product.name_group}</p>
					</div>
				</div>
				 
				<div class="col-1 text-center">
					x {product.quantity}
				</div>
				<div class="col-3 secondary_text text-center">{product.price} đ</div>
			</div>
			<!-- END: product -->
		</div>
		<div class="history_option text-right py-3">
			<p class="fs_18">Tổng số tiền: <span class="secondary_text">{VIEW.total} đ</span></p>
			
			<!-- BEGIN: complain -->
			<a href="{link_complain}" class="btn_ecng mr-2">Khiếu nại</a>
			<!-- END: complain -->
			
			<!-- BEGIN: status_cancel -->
			<button class="btn_ecng mr-2" type="button" onclick="change_status_cancel({VIEW.id},this)">Hủy đơn</button>
			<!-- END: status_cancel -->	
			
			<!-- BEGIN: received -->
			<button class="btn_ecng mr-2" type="button" onclick="change_status_received({VIEW.id})">Đã nhận được hàng</button>
			<!-- END: received -->	
			
			<!-- BEGIN: not_received -->
			<button class="btn_ecng_outline" type="button" onclick="change_status_not_received({VIEW.id})">Chưa nhận được hàng</button>
			<!-- END: not_received -->
			
			<!-- BEGIN: not_received_processing -->
			<button class="btn_gray" type="button" data-toggle="tooltip" data-placement="top" title="Đơn hàng của bạn đang xử lý">Chưa nhận được hàng</button>
			<!-- END: not_received_processing -->	
			
			<!-- BEGIN: rate -->
			<a href="#" class="btn_ecng" data-toggle="modal" data-target="#cmt_product{VIEW.id}">Đánh giá</a>
			
			<!-- The Modal -->
			<div class="modal fade" id="cmt_product{VIEW.id}">
				<div class="modal-dialog modal-dialog-centered ">
					<div class="modal-content">
						<div class="modal-header pb-0">
							<h4 class="modal-title">Đánh giá sản phẩm</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<!-- Modal body -->
						<div class="modal-body pt-0">
							<div>
								<!-- BEGIN: product_rate -->
								<div class="cmt_product_item mt-3 cmt_item{VIEW.id}" product_id="{product.id}" classify_value_product_id="{product.classify_value_product_id}">
									<div class="d-flex align-items-center py-2">
										<div class=" ">
											<a href="#"><img src="{product.image}" class="width_80" alt="" /></a>
										</div>
										<div class="px-3 text-left">
											<p class="mb-0">{product.name_product}</p>
											<p class="text_gray_color mb-0">{product.name_group}</p>
										</div>
									</div>
									<div class="rating-stars text-center">
										<ul id="stars" class="rate_star">
											<li class="star" title="Poor" data-value="1">
												<i class="fa fa-star fa-fw"></i>
											</li>
											<li class="star" title="Fair" data-value="2">
												<i class="fa fa-star fa-fw"></i>
											</li>
											<li class="star" title="Good" data-value="3">
												<i class="fa fa-star fa-fw"></i>
											</li>
											<li class="star" title="Excellent" data-value="4">
												<i class="fa fa-star fa-fw"></i>
											</li>
											<li class="star" title="WOW!!!" data-value="5">
												<i class="fa fa-star fa-fw"></i>
											</li>
										</ul>
									</div>
									<textarea class="form-control comment" rows="5" id="comment" style="resize: none;" name="text" maxlength="300" placeholder="Hãy đánh giá sản phẩm này nhé"></textarea>
									
								</div>
								<!-- END: product_rate -->
								
								<div class="row">
									<div class="col-6 text-left">
										<div class="contact-result alert"></div>
									</div>	
									<div class="col-6">
										<div class="text-right">
											<button class="btn_ecng mt-3 " id="submit_rated" onclick="button_rate_product('{VIEW.id}')">HOÀN THÀNH</button>
										</div>
									</div>														
								</div>
							</div>
						</div>
						
						<!-- modal body  -->
					</div>
				</div>
			</div>
			<!-- The Modal -->
			
			
			<!-- END: rate -->
			
		</div>
	</div>
	<!-- END: loop -->
	
	<div class="clear"></div>
	<!-- BEGIN: generate_page -->
	<nav class="text-center d-flex justify-content-center pagi_wishlist">
		{NV_GENERATE_PAGE}
	</nav>
	<!-- END: generate_page -->
	
</div>

<script>	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
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
	function thongbao1(message) {
		$('.contact-result').html(message).removeClass("alert-danger").addClass("alert-warning").show();
		setTimeout(function() {
			$('.contact-result').hide();
		}, 20000);
	}
</script>	


	<div class="modal fade" id="notifi_screen">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content" id="modal_content">
				<div class="modal-body text-center p-4">
					<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
				</div>
			</div>
		</div>
	</div>

<!-- END: main -->
