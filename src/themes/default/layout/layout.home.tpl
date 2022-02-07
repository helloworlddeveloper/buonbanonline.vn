<!-- BEGIN: main -->
{FILE "header_only.tpl"}
[FIREWORK]
{FILE "header_extended.tpl"}
        <section class="banner mt-3">
            <div class="row">
                <div class="col-md-2  pd-bottom">
                    [BANNER_LEFT]
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12 pd-center">
                            [BANNER_CENTER]
                        </div>
                    </div>
                    <!-- slider  -->
                    [BANNER_BOTTOM]
                </div>
                <div class="col-md-3">
                    [BANNER_RIGHT]
                    [BANNER_RIGHT1]
                </div>
            </div>
        </section>	
         [SP_NOIBAT]
        <!-- product hot  -->
        <section class="banner_down mb-10 mt-10">
            [BANNER_TOP]
        </section>
        <!-- product new  -->
		 <section class="mb-10 mt-10">
            [SHOPS_HOT]
        </section>
        <!-- product new  -->
		[SP_NEW]
        <!-- container  -->
{FILE "footer_extended.tpl"}
{FILE "footer_only.tpl"}
<!-- END: main -->