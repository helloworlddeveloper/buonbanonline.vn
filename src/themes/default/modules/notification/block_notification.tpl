<!-- BEGIN: main -->

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.slimscroll.min.js"></script>
<div class="dropdown" id="notification-area">
	<span id="notification" style="display: none"></span>
	<a href="javascript:void(0);" class="dropdown-toggle secondary_text" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-bell secondary_text" aria-hidden="true" ></i> Thông báo</a>
	
	
	<div class="dropdown-menu notifi_home">
	
		<div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
			<div id="notification_load" style=" width: auto; max-height: : 100%;overflow-y: scroll;">
				<div class="notify_item clearfix">
					Vui lòng đăng nhập để xem thông báo!
				</div>
			</div>
			<div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 100%;">
			</div>
			<div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
			</div>
		</div>
		<div id="notification_waiting" style="display: none;">
			<div class="text-center">
				<i class="fa fa-spin fa-spinner"></i>
			</div>
		</div>
		
		<!-- BEGIN: readmore -->
		<div id="notification_more">
			<div class="text-center">
				<a href="{URL}">
					Xem tất cả
				</a>
			</div>
		</div>
		<!-- END: readmore -->
	</div>
	
</div>


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
					$('#notification').show().html(data.data_from_file);
				} else {
					$('#notification').hide();
				}
							// Load mỗi 30s một lần
							setTimeout(function() {
								nv_get_notification(0);
							}, 30000);
						},
						cache: false
					});
	}
	var page = 1;
	$('#notification_load').scroll(function() {
		if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
			page++;
			$('#notification_waiting').show();
			$.get(nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=notification&' + nv_fc_variable + '=main&ajax=1&page=' + page + '&nocache=' + new Date().getTime(), function(result) {
				$('#notification_load').append(result);
				$('#notification_waiting').hide();
			});
		}
	});

			// Notification
			$('#notification-area').on('show.bs.dropdown', function() {
				$.get(nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=notification&' + nv_fc_variable + '=main&ajax=1&nocache=' + new Date().getTime(), function(result) {
					notification_reset();
					$('#notification_load').html(result).slimScroll({
						height: '100%'
					});
					
					$('#notification_waiting').hide();
				});
			});

			$('#notification-area').on('show.bs.dropdown', function() {
				page = 1;
				$('#notification_load').html('');
				$('#notification_waiting').show();
			});

			// Hide notification
			$('.notify_item .ntf-hide').click(function(e) {
				e.preventDefault();
				var $this = $(this);
				$.ajax({
					type: 'POST',
					url: nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=notification&' + nv_fc_variable + '=main&nocache=' + new Date().getTime(),
					data: 'delete=1&id=' + $this.data('id'),
					success: function(data) {
						if (data == 'OK') {
							window.location.href = window.location.href;
						} else {
							alert(nv_is_change_act_confirm[2]);
						}
					}
				});
			});
			function notification_reset() {
				$.post(nv_base_siteurl + 'index.php' + '?' + nv_name_variable + '=notification&' + nv_fc_variable + '=main&nocache=' + new Date().getTime(), 'notification_reset=1', function(res) {
					$('#notification').hide();
				});
			}
</script>
		
<!-- END: user -->
		
<!-- END: main -->