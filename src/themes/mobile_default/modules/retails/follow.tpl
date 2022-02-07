<!-- BEGIN: main -->


<div id="follow">
	
	<div class=" bd_b_1 bg_white">
		<div class="resign text-center px-2">
			<p class="fs_18 mb-0 py-3">Shop đã theo dõi</p>
		</div>
	</div>
	
	<form id="search_follow" class="mt-2">
		<div class="p-1 bg-light rounded rounded-lg shadow-sm mb-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<button type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
				</div>
				<input type="text" id="search_follow" value="{Q}" name="s" maxlength="255" placeholder="Tìm kiếm theo" class="form-control border-0 bg-light ">
			</div>
		</div>
	</form>
	<!-- BEGIN: view -->
	
	
	
	<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
		<div id="list_follow_none" class="bg_white w-100 h-auto rounded text-center" style="min-height: 72.2vh">
			
			<div class="list_follow">
				<!-- BEGIN: no_data -->
					<div class="p-4 fs_12 text-center">Không tìm thấy kết quả!</div>
				<!-- END: no_data -->
				<!-- BEGIN: loop -->
				<div class="row p-2 m-0 bd_b_1" style="min-height: 74px;">
					<div class="col-2 pl-2">
						<a class=" fs_16 d-flex justify-content-center align-items-center w-100 h-100" href="{VIEW.alias}" style="max-height: 75px">
							<img class="rounded" src="{VIEW.avatar_image}" alt="{VIEW.company_name}" title="{VIEW.company_name}" style="max-height: 100%; max-width: 100%; object-fit: cover;">
						</a>
					</div>
					<div class="col-7  d-flex align-items-center">
						<a class="pl-3 fs_14 font-weight-bold" href="{VIEW.alias}">
							{VIEW.company_name}
						</a>
					</div>	
					<div class="col-3 pr-2 d-flex text-right align-items-center justify-content-end ">
						<a class="btn btn-outline-danger" href="{VIEW.link_delete}">
							Bỏ theo dõi
						</a>
					</div>
				</div>
				<!-- END: loop -->
			</div>
		</div>
		<script>
			
			$("#search_follow").submit(function(e) {
				e.preventDefault();
				$.ajax({
					type: "GET",
					url: nv_base_siteurl + 'index.php' + '?'  + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +'=follow',
					data: $('#search_follow').serialize(), 
					success: function(res)
					{
						$('#follow').html(res);
					}
				});
			});
			
		</script>
		
	</form>
	<!-- BEGIN: generate_page -->
	<div class="text-center d-flex justify-content-center bg_white pagi_follow">
		{NV_GENERATE_PAGE}
	</div>
	<!-- END: generate_page -->
	
	<script>
			//set vị trí phân trang 
			var a = $('.pagi_follow').find('ul').length;
			if(a > 0){
				$('#list_follow_none').css({'min-height' : '65.1vh'})
			}
			
			<!-- var b = $('.list_follow').find('.btn-outline-danger').length; -->
			<!-- console.log(b); -->
			<!-- if( b == 0){ -->
				<!-- window.location.replace("https://chonhagiau.com/follow/"); -->
			<!-- } -->
	</script>
	<!-- END: view -->
</div>

<!-- END: main -->