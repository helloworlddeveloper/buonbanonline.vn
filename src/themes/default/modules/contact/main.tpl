<!-- BEGIN: main -->
<div class="page bg_white" style="border-radius: 10px; padding: 0.75em 1.5em;">
    <!-- BEGIN: bodytext -->
			<div class="pt-2" style="font-size: 36px; line-height: 24px; font-weight: 500;">Liên Hệ Chợ Nhà Giàu</div>
    <div class="well pt-4 text_gray_color">{CONTENT.bodytext}</div>
    <!-- END: bodytext -->
    <div class="row mt-5">
        <div class="col-6 pr-5">
		<p class="text_gray_color fs_16	">Thông tin liên hệ</p>
		<img src="{NV_SITE_BASEURL}/themes/default/chonhagiau/images/logo.png" style="width : 383px;">
            <!-- BEGIN: dep -->
            <div class="panel panel-default pr-5">
                <div class="panel-body bg_gray  rounded pl-3 py-2 mb-3 " style="width : 383px;">
					<p class="mb-0 ">{DEP.full_name}</p>
                    <!-- BEGIN: phone -->
                    <p class="pt-2">
                        <em class="secondary_text pr-2 fa fa-phone fa-horizon "></em>{LANG.phone}: <span>
                            <!-- BEGIN: item -->
                            <!-- BEGIN: comma -->&nbsp; <!-- END: comma -->
                            <!-- BEGIN: href -->
                            <a href="tel:{PHONE.href}" class="black">
                                <!-- END: href -->{PHONE.number}<!-- BEGIN: href2 -->
                        </a>
                        <!-- END: href2 -->
                            <!-- END: item -->
                        </span>
                    </p>
                    <!-- END: phone -->
                    <!-- BEGIN: email -->
                    <p>
                        <em class="secondary_text pr-2 fa fa-envelope fa-horizon margin-right"></em>{LANG.email}: <span>
                            <!-- BEGIN: item -->
                            <!-- BEGIN: comma -->&nbsp; <!-- END: comma -->
                            <a href="mailto:{EMAIL}" class="black">{EMAIL}</a>
                        <!-- END: item -->
                        </span>
                    </p>
                    <!-- END: email -->
                </div>
            </div>
            <!-- END: dep -->
        </div>
		
        <div class="col-6">
            <div class="panel panel-primary rounded" style="border : solid 1px #ADADAD">
                <div class="panel-heading fs_20 pl-2 pt-3">{GLANG.feedback}</div>
                <div class="panel-body loadContactForm px-2 py-2">{FORM}</div>
            </div>
        </div>
    </div>
</div>
<!-- END: main -->