<form action="{FORM_ACTION}" method="post" onsubmit="return lostpass_validForm(this);" autocomplete="off" novalidate>
    <div class="nv-info margin-bottom" data-default="{LANG.lostpass_info1}">{LANG.lostpass_info1}</div>
    <div class="form-detail">
        <div class="step1">
		
				<div class="py-2 mb-3">
                    <div class="input-group  p-1 rounded border d-flex align-items-center">
                        <input type="text" class="required form-control border-0 mr-3" placeholder="{GLANG.username_email}" value="" name="userField" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{LANG.lostpass_no_info1}">
                        <div class="input-group-append border-0 pr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
								<path d="M8 8.63635C10.21 8.63635 12 6.80567 12 4.54544C12 2.28521 10.21 0.454529 8 0.454529C5.79 0.454529 4 2.28521 4 4.54544C4 6.80567 5.79 8.63635 8 8.63635ZM8 10.6818C5.33 10.6818 0 12.0523 0 14.7727V16.8182H16V14.7727C16 12.0523 10.67 10.6818 8 10.6818Z" fill="#E1A208"/>
								</svg>
                        </div>
                    </div>
                </div>
                       
            <!-- BEGIN: captcha -->
            <div class="row">
                <div class="col-6">
                    <input type="text" style="width:100px;" class="bsec required form-control display-inline-block" name="nv_seccode" value="" maxlength="{GFX_MAXLENGTH}" placeholder="{GLANG.securitycode}" data-pattern="/^(.){{GFX_MAXLENGTH},{GFX_MAXLENGTH}}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.securitycodeincorrect}" />
				</div>	
				<div class="col-6 text-right">
					
					<img class="captchaImg display-inline-block" src="{SRC_CAPTCHA}" width="{GFX_WIDTH}" height="{GFX_HEIGHT}" alt="{N_CAPTCHA}" title="{N_CAPTCHA}" />
					<em class="fa fa-pointer fa-refresh margin-left margin-right" title="{CAPTCHA_REFRESH}" onclick="change_captcha('.bsec');"></em>
                </div>
            </div>
            <!-- END: captcha -->
            
            <!-- BEGIN: recaptcha -->
            <div class="form-group">
                <div class="middle text-right clearfix">
                    <div class="nv-recaptcha-default">
                        <div id="{RECAPTCHA_ELEMENT}"></div>
                        <input type="hidden" value="" name="gcaptcha_session"/>
                    </div>
                    <script type="text/javascript">
                    nv_recaptcha_elements.push({
                        id: "{RECAPTCHA_ELEMENT}",
                        btn: $('[type="submit"]', $('#{RECAPTCHA_ELEMENT}').parent().parent().parent().parent().parent())
                    })
                    </script>
                </div>
            </div>
            <!-- END: recaptcha -->
        </div>
        
        <div class="step2" style="display:none">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><em class="fa fa-pencil-square-o fa-lg"></em></span>
                    <input type="text" class="form-control" placeholder="{LANG.answer_question}" value="" name="answer" maxlength="255" onkeypress="validErrorHidden(this);" data-mess="{LANG.answer_empty}">
                </div>
            </div>
        </div>
        
        <div class="step3" style="display:none">
			<div class="input-group  p-1 rounded border mt-3">
				<input type="text" class="form-control border-0" placeholder="{LANG.lostpass_key}" value="" name="verifykey" maxlength="10" data-pattern="/^[a-zA-Z0-9]{10,10}$/" onkeypress="validErrorHidden(this);" data-mess="{LANG.lostpass_active_error}">
				<div class="input-group-append border-0">
					<button class="btn_none secondary_text btn" disabled><i class="fa fa-shield px-3" aria-hidden="true" style="font-size: 22px;"></i></button>
				</div>
			</div>
            
        </div>
        
        <div class="step4" style="display:none">
				<div class="pb-4 pt-3">
                    <div class="input-group  p-1 rounded border">
                        <input type="password" autocomplete="off" class="form-control border-0" placeholder="{LANG.pass_new}" value="" name="new_password" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.password_empty}">
                        <div class="input-group-append border-0">
                            <button class="btn_none secondary_text btn" disabled><i class="fa fa-lock px-3" aria-hidden="true" style="font-size: 22px;"></i></button>
                        </div>
                    </div>
                </div>
                <div class="pb-4 bd_b_1">
                    <div class="input-group  p-1 rounded border">
                        <input type="password" autocomplete="off" class="form-control border-0" placeholder="{LANG.pass_new_re}" value="" name="re_password" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.passwordsincorrect}">
                        <div class="input-group-append border-0">
                            <button class="btn_none secondary_text btn" disabled><i class="fa fa-lock px-3" aria-hidden="true" style="font-size: 22px;"></i></i></button>
                        </div>
                    </div>
                </div>
           
        </div>
        
        <div class="text-center mt-3">
             <input type="hidden" name="step" value="step1" />
             <input type="hidden" name="checkss" value="{DATA.checkss}" />
            <!-- BEGIN: redirect --><input name="nv_redirect" value="{REDIRECT}" type="hidden" /><!-- END: redirect -->
            <button class="bsubmit btn_ecng w-100 p-3 fs_16" type="submit">{LANG.lostpass_submit}</button>
       	</div>
    </div>
</form>