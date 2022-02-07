<!-- BEGIN: main -->

<script src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/js/autofill.js"></script>  
<div class="search_suggest_home">
	<form>
		<div class="input-group search_bar rounded-lg ">
			
			<input autocomplete="off" id="input_s" name="input_s" type="text" class="form-control header_search border-0" placeholder="Tìm Kiếm" value="{q}" data-toggle="dropdown"/>         
			<div class="input-group-prepend bg_white ">		
				<button id="search_pro" class="btn text-warning border-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>		
			</div>	
		</div>
	</form>
</div>
<script type="text/javascript">
	
	$('input[name=\'input_s\']').autofill({
		'source': function(request, response) {
			suggest()
		}
	});
	
	$('#search_pro').on( "click", function(event) {
		event.preventDefault();
		var key_word = $("input[name='input_s']").val();
		
		window.location.href = 'https://chonhagiau.com/search/?q=' + key_word;
	});
	
	
	function suggest(){
		var key_word = $("input[name='input_s']").val();
		key_word = encodeURIComponent(key_word);
		
		if(true){
			$.ajax({
				type : 'POST',
				url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=retails&' + nv_fc_variable + '=search&mod=suggest&key_word=' + key_word,
				success : function(res){
					$('.scrollable-menu').html(res);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
			}else{
			$('.header_search_list').html('<ul><li>	Không tìm thấy kết quả!</li></ul>');
		}
	}
	
	
</script>
<!-- END: main -->