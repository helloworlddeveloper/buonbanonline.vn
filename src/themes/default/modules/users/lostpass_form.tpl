<form action="{FORM_ACTION}" method="post" onsubmit="return lostpass_validForm(this);" autocomplete="off" novalidate>
    <div class="nv-info margin-bottom" data-default="{LANG.lostpass_info1}">{LANG.lostpass_info1}</div>
    <div class="form-detail">
        <div class="step1">
		
				<div class="py-2 mb-3">
                    <div class="input-group  p-1 rounded border">
                        <input type="text" class="required form-control border-0" placeholder="{GLANG.username_email}" value="" name="userField" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{LANG.lostpass_no_info1}">
                        <div class="input-group-append border-0">
                            <span class=" secondary_text pt-1" ><i class="fa fa-user-circle px-3" style="font-size: 24px;"></i></span>
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
					<span class=" secondary_text pt-1" ><i class="fa fa-shield px-3" aria-hidden="true" style="font-size: 24px;"></i></span>
				</div>
			</div>
            
        </div>
        
        <div class="step4" style="display:none">
				<div class="pb-4 pt-3">
                    <div class="input-group  p-1 rounded border">
                        <input type="password" autocomplete="off" class="form-control border-0" placeholder="{LANG.pass_new}" value="" name="new_password" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.password_empty}" id="password">
                        <div class="input-group-append border-0">
						<span class="secondary_text pt-1 pointer" onclick="showHidePwd();"><i class="fa fa-lock px-3" aria-hidden="true" style="font-size: 22px;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="pb-4 bd_b_1">
                    <div class="input-group  p-1 rounded border">
                        <input type="password" autocomplete="off" class="form-control border-0" placeholder="{LANG.pass_new_re}" value="" name="re_password" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.passwordsincorrect}" id="repass">
                        <div class="input-group-append border-0">
                            <span class="secondary_text pt-1 pointer" onclick="showHidePwd1();"><i class="fa fa-lock px-3" aria-hidden="true" style="font-size: 22px;"></i></i></span>
                        </div>
                    </div>
                </div>
				<script>
				function showHidePwd() {
					var password = document.getElementById("password");
					if (password.type === "password") {
						password.type = "text";					
					} else {
						password.type = "password";
					}
				}
				function showHidePwd1() {
					var repass = document.getElementById("repass");
					if (repass.type === "password") {
						repass.type = "text";					
					} else {
						repass.type = "password";
						
					}
				}
				</script>
           
        </div>
        
        <div class="text-center mt-3">
             <input type="hidden" name="step" value="step1" />
             <input type="hidden" name="checkss" value="{DATA.checkss}" />
            <!-- BEGIN: redirect --><input name="nv_redirect" value="{REDIRECT}" type="hidden" /><!-- END: redirect -->
            <button class="bsubmit btn_ecng" type="submit">{LANG.lostpass_submit}</button>
       	</div>
    </div>
</form>