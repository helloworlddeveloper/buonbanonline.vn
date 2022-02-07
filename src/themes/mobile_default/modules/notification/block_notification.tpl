<!-- BEGIN: main -->

<!-- BEGIN: user -->

<script>
	
		nv_get_notification(0)
		function nv_get_notification(timestamp) {
		$.ajax({
			type: 'POST',
			url: nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=notification&' + nv_fc_variable + '=main&mod=load_notification&nocache=' + new Date().getTime(),
			data: {
				'timestamp': timestamp
			},
			success: function(data) {
				if (data.data_from_file > 0) {
					$('.nav_item_footer i.fa.fa-bell-o.fa-lg').append('<span class="number_notification">'+ data.data_from_file +'</span>');
					$('.number_notification').addClass('active_notification');
				}
			},
			cache: false
		});
	}
			
</script>

<!-- END: user -->

<!-- END: main -->