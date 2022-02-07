<!-- BEGIN: main -->

    <!-- BEGIN: loop -->
	<li class="media mt-2">
        <a href="{DATA.link}">
            <div class="media-body">
                <h6>{DATA.title} vào lúc {DATA.add_time}</h6>
            </div>
        </a>
	</li>						
	<!-- END: loop -->


<!-- BEGIN: generate_page -->
<div class="clearfix notification-pages">
    {GENERATE_PAGE}
</div>
<!-- END: generate_page -->

<!-- END: main -->

<!-- BEGIN: empty -->
<div class="alert alert-info">{LANG.notification_empty}</div>
<!-- END: empty -->