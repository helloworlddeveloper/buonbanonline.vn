<!-- BEGIN: main -->
<div class="nv-fullbg">
    <form id="contact_validate" method="post" action="{ACTION_FILE}" onsubmit="return nv_validForm(this);">
        <!-- BEGIN: cats -->
        <div class="form-group pt-3 mb-3 position-relative">
						<p class="text_gray_color mb-0 pb-1">Chủ đề(*)</p>
			<div id="topic" class="d-flex justify-content-between align-items-center rounded py-2 position-relative border mb-3">
                <div class="mb-0 pl-2"><i class="fa fa-folder-open secondary_text mr-2" aria-hidden="true" ></i><span>Chủ đề bạn quan tâm</span></div>
                <i class="fa fa-angle-down pr-2"></i>
                <ul id="topic_content" class="position-absolute d-none pl-0 bg_white w-100">
				<!-- BEGIN: select_option_loop -->
				<!--	{SELECTNAME} --!>
				<!-- END: select_option_loop -->
                    <li class="py-2 pl-2 bg_white text_primary disabled" >Chủ đề bạn quan tâm</li>
                    <li class="py-2 pl-2 bg_white text_primary "> Tư vấn </li>
                    <li class="py-2 pl-2 bg_white text_primary "> Khiếu nại, phản ánh </li>
                    <li class="py-2 pl-2 bg_white text_primary "> Đề nghị hợp tác </li>
                    <li class="py-2 pl-2 bg_white text_primary "> Thông báo lỗi </li>
                    <li class="py-2 pl-2 bg_white text_primary "> Góp ý cải tiến </li>
                </ul>
            </div>
			<p id="topic_error" class="mb-0 pt-2 position-absolute" style="color: red; display: none; bottom: -23px">Vui lòng chọn chủ đề</p>
        </div>
        <!-- END: cats -->
		<p class="text_gray_color mb-0 pb-1 pt-2">Tiêu đề(*)</p>
        <div class="input-group form-group bg_white border rounded-lg p-1 mb-20 input_ecng mb-3 position-relative d-flex align-items-center pl-2">
                <i class="fa fa-file secondary_text"></i>
            <input type="text" maxlength="255" class="form-control border-0 " value="{CONTENT.ftitle}" name="ftitle" placeholder="Nhập {LANG.title}" data-pattern="/^(.){3,}$/"  required />
        </div>
        <!-- BEGIN: iguest -->
		<p class="text_gray_color mb-0 pb-1 pt-2">Họ và tên(*)</p>
        <div class="form-group bg_white border rounded-lg p-1 input_ecng mb-20 mb-3 position-relative pl-2">
            <div class="input-group d-flex align-items-center">
                <em class="secondary_text fa fa-user fa-lg fa-horizon "></em>
                <input  type="text" maxlength="100" value="" name="fname" class="form-control  border-0" placeholder="Nhập {LANG.fullname}" data-pattern="/^(.){3,}$/" onkeypress="nv_validErrorHidden(this);" required />
            </div>
        </div>
		<p class="text_gray_color mb-0 pb-1 pt-2">Email(*)</p>
        <div class="form-group bg_white border rounded-lg p-1 mb-20 input_ecng mb-3 position-relative pl-2">
            <div class="input-group d-flex align-items-center">
					<em class="secondary_text fa fa-envelope fa-lg fa-horizon"></em>
                <input type="email" maxlength="60" value="" name="femail" class="form-control  border-0" placeholder="Nhập {LANG.email}" onkeypress="nv_validErrorHidden(this);" data-mess="{LANG.error_email}" required />
            </div>
        </div>
        <!-- END: iguest -->
        <!-- BEGIN: iuser -->
		<p class="text_gray_color mb-0 pb-1 pt-2">Họ và tên(*)</p>
        <div class="form-group bg_white border rounded-lg p-1 mb-20 input_ecng mb-3 position-relative pl-2"> 
            <div class="input-group d-flex align-items-center">
				<em class="secondary_text  fa fa-user fa-lg fa-horizon pr-2"></em>
                <input type="text" maxlength="100" value="{CONTENT.fname}" name="fname" class="form-control border-0  disabled" disabled="disabled" placeholder="Nhập {LANG.fullname}" data-pattern="/^(.){3,}$/" onkeypress="nv_validErrorHidden(this);" data-mess="{LANG.error_fullname}" style="margin-left: 6px"  required
                />
            </div>
        </div>
		<p class="text_gray_color mb-0 pb-1 pt-2">Email(*)</p>
        <div class="form-group bg_white border rounded-lg p-1 mb-20 input_ecng mb-3 position-relative pl-2">
            <div class="input-group d-flex align-items-center">
				<em class="secondary_text fa fa-envelope fa-fix fa-lg fa-horizon pr-2"></em>
                <input type="email" maxlength="60" value="{CONTENT.femail}" name="femail" class="form-control border-0  disabled" disabled="disabled" placeholder="Nhập {LANG.email}" onkeypress="nv_validErrorHidden(this);" data-mess="{LANG.error_email}" required />
            </div>
        </div>
        <!-- END: iuser -->
		<p class="text_gray_color mb-0 pb-1 pt-2">Số điện thoại(*)</p>
        <div class="form-group bg_white border rounded-lg p-1 mb-20 input_ecng mb-3 position-relative pl-2">
            <div class="input-group d-flex align-items-center">
				<em class="secondary_text fa fa-phone fa-lg fa-horizon"></em>
                <input type="text" maxlength="60" value="{CONTENT.fphone}" name="fphone" class="form-control border-0 " placeholder="Nhập {LANG.phone}" onkeypress="nv_validErrorHidden(this);" data-mess="{LANG.error_phone}" required />
            </div>
        </div>
		<p class="text_gray_color mb-0 pb-1 pt-2">Nội dung(*)</p>
        <div class="form-group position-relative mb-5">
            <div class="">
                <textarea cols="8" rows="8" name="fcon" class="form-control " maxlength="1000" placeholder="{LANG.content}" onkeypress="nv_validErrorHidden(this);" data-mess="{LANG.error_content}" required ></textarea>
            </div>
        </div>
		<!-- BEGIN: captcha -->
		<div class="form-group mt-5">
            <div class="middle text-right clearfix">
                <img width="{GFX_WIDTH}" height="{GFX_HEIGHT}" title="{LANG.captcha}" alt="{LANG.captcha}" src="{NV_BASE_SITEURL}index.php?scaptcha=captcha&t={NV_CURRENTTIME}" class="captchaImg display-inline-block">
                <em onclick="change_captcha('.fcode');" title="{GLANG.captcharefresh}" class="fa fa-pointer fa-refresh margin-left margin-right"></em>
                <input type="text" placeholder="{LANG.captcha}" maxlength="{NV_GFX_NUM}" value="" name="fcode" class="fcode required form-control display-inline-block" style="width:100px;" data-pattern="/^(.){{NV_GFX_NUM},{NV_GFX_NUM}}$/" onkeypress="nv_validErrorHidden(this);" data-mess="{LANG.error_captcha}"/>
            </div>
		</div>
        <!-- END: captcha -->
        <!-- BEGIN: recaptcha -->
        <div class="form-group">
            <div class="middle text-center clearfix">
                <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                <script type="text/javascript">
                nv_recaptcha_elements.push({
                    id: "{RECAPTCHA_ELEMENT}",
                    btn: $('[type="submit"]', $('#{RECAPTCHA_ELEMENT}').parent().parent().parent().parent())
                })
                </script>
            </div>
        </div>
        <!-- END: recaptcha -->
		
        <div class="text-center form-group">
		<input type="hidden" name="checkss" value="{CHECKSS}" />
            <input id="send_contact" type="submit" value="{LANG.sendcontact}" name="btsend" class="btn btn_ecng" style="width: 100px;"/>
        </div>
    </form>
    <div class="contact-result alert"></div>
</div>

<script>

$('#topic').click(function(){
		$('#topic_content').toggleClass('d-block');
		//$('ul#topic_content li').toggleClass('active_topic_li');
	});
	
</script>
<!-- END: main -->
