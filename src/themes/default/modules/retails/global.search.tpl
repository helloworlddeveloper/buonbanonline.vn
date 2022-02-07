<!-- BEGIN: main -->

<script src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/chonhagiau/js/autofill.js"></script>  



<div class="col-10 search_suggest_home">
	<form>
	<input autocomplete="off" id="input_s" name="input_s" type="text" class="form-control header_search" placeholder="Tìm Kiếm" value="{q}" data-toggle="dropdown"/>
	<button id="search_pro" class="btn btn_search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
	</form>
</div>
<script type="text/javascript">
	
	$('input[name=\'input_s\']').autofill({
		'source': function(request, response) {
			suggest()
		}
	})
	
	$('#search_pro').on( "click", function(event) {
		event.preventDefault();
		var key_word = $("input[name='input_s']").val();
		key_word = encodeURIComponent(key_word);
		window.location.href = 'https://chonhagiau.com/search/?q=' + key_word;
	});
	
	function suggest(){
		var key_word = $("input[name='input_s']").val();
		
		if(true){
			$.ajax({
				type : 'POST',
				url: nv_base_siteurl + 'index.php?' + nv_name_variable + '=retails&' + nv_fc_variable + '=search&mod=suggest',
				data : {key_word : key_word},
				success : function(res){
					$('.scrollable-menu').html(res);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}
	
	
</script>
<!-- END: main -->