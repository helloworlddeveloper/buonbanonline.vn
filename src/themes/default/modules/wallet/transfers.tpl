<!-- BEGIN: main -->
<h1 class="margin-bottom">
    {LANG.transfers}
</h1>
<!-- BEGIN: error -->
<div class="alert alert-danger">
    {DATA.error}
</div>
<!-- END: error -->




<form class="form-horizontal" method="post" action="{FORM_ACTION}"<!-- BEGIN: atm_form --> enctype="multipart/form-data"<!-- END: atm_form -->>

    <div class="panel panel-default">
        <div class="panel-body">
		<div class="alert alert-danger">
		<div class="form-group">
		<label class="control-label col-md-8">{LANG.totalmoney}:</label>
		<div class="col-md-13"><span class="form-control"disabled="disabled"><strong>{TOTALMONEY}</strong></span>
		</div>
		</div>
		<div class="form-group">
		<label class="control-label col-md-8">{LANG.totaltransfer}:</label>
		<div class="col-md-13"><span class="form-control"disabled="disabled"><strong>{WITHDRAWAL}</strong></span>
		</div>
		</div>
		<div class="form-group">
		<label class="control-label col-md-8">{LANG.money_fees}:</label>
		<div class="col-md-13"><span class="form-control"disabled="disabled"><strong>{FEES}</strong></span>
		</div>
		</div>
	    </div>
			   
            <div class="form-group">
                <label class="control-label col-md-8">
                    {LANG.customer_email}:
                </label>
                <div class="col-md-13">
                    <input class="form-control" type="text" name="customer_email" value="{DATA.customer_email}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-8">
                    {LANG.customer_phone}:
                </label>
                <div class="col-md-13">
                    <input class="form-control" type="text" name="customer_phone" value="{DATA.customer_phone}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-8">
                    {LANG.customer_address}:
                </label>
                <div class="col-md-13">
                    <input class="form-control" type="text" name="customer_address" value="{DATA.customer_address}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-8">
                    {LANG.customer_money} <i class="text-danger">(*)</i>:
                </label>
                <div class="col-md-13">
                    <div class="row">
                        <div class="col-md-16">
                          <input class="form-control" name="money_amount"onkeyup="this.value=FormatNumber(this.value);" type="text" value="{DATA.money_amount}"/>
                        </div>
                        <div class="col-md-8">
                            <!-- BEGIN: money_unit_text -->
                            <label class="control-label">{MONEY_UNIT}</label>
                            <!-- END: money_unit_text -->
                            <!-- BEGIN: money_unit_sel -->
                            <select class="form-control" name="money_unit" data-toggle="rechargeMUnit">
                                <!-- BEGIN: loop -->
                                <option value="{MONEY_UNIT}"{MONEY_UNIT_SELECTED}>{MONEY_UNIT}</option>
                                <!-- END: loop -->
                            </select>
                            <!-- END: money_unit_sel -->
                        </div>
						
                    </div>
                 <span class="help-block help-block-bottom">{MIN_MAX}</span>
                </div>
            </div>
		
			
            <div class="form-group">
                <label class="control-label col-md-8">
                    {LANG.customer_content}:
                </label>
                <div class="col-md-13">
                    <textarea class="textarea form-control form-control-fullwidth" name="transaction_info">Yêu cầu chuyển tiền sang ví tiền người dùng</textarea>
                </div>
            </div>
    
            <div class="form-group">
				 <label class="control-label col-md-8"><strong>{LANG.userid_receiver}</strong> <span class="red">(*)</span></label>
				 <div class="col-md-13">
				 <select class="form-control userid_receiver" name="userid_receiver" {readonly} required="" oninvalid="setCustomValidity('Vui lòng ngân hàng')" oninput="setCustomValidity('')" >
		
			   <!-- BEGIN: userid_receiver -->
				<option value="{USER.key}" {USER.selected}>{USER.title}</option>
			   <!-- END: userid_receiver -->
			  
				</select>
				</div>
			</div>
            <!-- BEGIN: captcha -->
            <div class="form-group">
                <label class="control-label col-xs-8">
                    {LANG.input_capchar}:
                </label>
                <div class="col-xs-6">
                    <input class="form-control" type="text" name="capchar" id="upload_seccode_iavim"/>
                </div>
                <div class="col-xs-8">
                    <img class="captchaImg" src="{SRC_CAPTCHA}" height="30px"/>
                    <img alt="{CAPTCHA_REFRESH}" src="{CAPTCHA_REFR_SRC}" width="16" height="16" class="refresh" onclick="change_captcha('#upload_seccode_iavim');"/>
                </div>
            </div>
            <!-- END: captcha -->
            <!-- BEGIN: recaptcha -->
            <div class="form-group">
                <label class="control-label col-md-8">{N_CAPTCHA}</label>
                <div class="col-md-16">
                    <div id="{RECAPTCHA_ELEMENT}"></div>
                    <script type="text/javascript">
                    nv_recaptcha_elements.push({
                        id: "{RECAPTCHA_ELEMENT}",
                        btn: $('[type="submit"]', $('#{RECAPTCHA_ELEMENT}').parent().parent().parent())
                    });
                    </script>
                </div>
            </div>
            <!-- END: recaptcha -->
            <div class="row">
                <div class="col-md-24 text-center">
                    <input type="hidden" name="checkss" value="{DATA.checkss}"/>
                    <input class="btn btn-primary" name="submit" type="submit" value="{LANG.customer_submit}"/>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- BEGIN: tmp_area -->
<div id="moneyUnitAmountTmp" class="hidden">
    <!-- BEGIN: unit -->
    <div id="moneyUnitAmountTmp{TMP_MONEY_UNIT}" data-minimum="{TMP_MINIMUM_AMOUNT}">
        <!-- BEGIN: select -->
        <select class="form-control" name="money_amount" data-toggle="rechargeAmount">
            <!-- BEGIN: loop -->
            <option value="{SELECT_AMOUNT.key}"{SELECT_AMOUNT.selected}>{SELECT_AMOUNT.title}</option>
            <!-- END: loop -->
            <!-- BEGIN: other --><option value="0">{LANG.amount_other}</option><!-- END: other -->
        </select>
        <!-- END: select -->
        <!-- BEGIN: input -->
        <input class="form-control" name="money_amount" type="text"/>
        <!-- END: input -->
    </div>
    <!-- END: unit -->
</div>
<!-- END: tmp_area -->
<script type="text/javascript" data-show="after" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
//<![CDATA[

$('.userid_receiver').select2({
    placeholder: "Mời bạn chọn tài khoản người nhận"
})
</script>
<!-- END: main -->
