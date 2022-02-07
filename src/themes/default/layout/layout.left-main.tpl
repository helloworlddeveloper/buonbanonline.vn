<!-- BEGIN: main -->
{FILE "header_only.tpl"}
{FILE "header_extended.tpl"}

<div class="container">
        <div class="row my-3">
            <div class="col-md-3 col-xl-2">
              [USER]
			</div>
            <div class="col-md-9 col-xl-10">
				<div class="content_main_page">
					[TOP]
				   {MODULE_CONTENT}
				</div>
            </div>
        </div>
</div>
	
{FILE "footer_extended.tpl"}
{FILE "footer_only.tpl"}
<!-- END: main -->