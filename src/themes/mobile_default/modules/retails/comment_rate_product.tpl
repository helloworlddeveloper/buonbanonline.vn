<!-- BEGIN: main -->
<!-- BEGIN: rate_comment -->
<!-- BEGIN: loop -->  
                        <div class="rating_cmt_item mt-3">
                            <div class="media">
                                <img src="{comment.photo}" class="align-self-start rounded-circle mr-3 rating_cmt_item_avt" alt="...">
                                <div class="media-body pb-1">
                                    <h6 class="my-0">{comment.last_name} {comment.first_name}</h6>
									<!-- BEGIN: name_group -->  
									<div class="product_classif">{name_group}</div>
									<!-- END: name_group -->  
                                    <img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/chonhagiau/images/icon/{comment.star}star.svg" class="rate_product_star_detail mb-1" alt="{comment.last_name} {comment.first_name}">
                                    <p class="mb-1">{comment.content}</p>
                                </div>
                            </div>
                        </div>
<!-- END: loop --> 

			<div class="clear"></div>
<!-- END: rate_comment -->

			<!-- BEGIN: generate_page -->
								<nav class="text-right">
									{NV_GENERATE_PAGE}
								</nav>
			<!-- END: generate_page --> 


<!-- END: main -->