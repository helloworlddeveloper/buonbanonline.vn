<!-- BEGIN: main -->

<div class="panel panel-default">
<div class="panel-body">
<h1>{LANG.withdrawal}</h1>
		
<form class="form-horizontal" action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{ROW.id}" />
  <!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error --> 
<div class="alert alert-danger">
		<div class="form-group">
		<label class="control-label col-md-8">{LANG.totalmoney}:</label>
		<div class="col-md-13"><span class="form-control"disabled="disabled"><strong>{TOTALMONEY}</strong></span>
		</div>
		</div>
		<div class="form-group">
		<label class="control-label col-md-8">{LANG.totalwithdrawal}:</label>
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
				 <label class="control-label col-md-8"><strong>{LANG.acount_bank}</strong> <span class="red">(*)</span></label>
				 <div class="col-md-13">
				 <select class="form-control bank_id" name="bank_id" {readonly} required="" oninvalid="setCustomValidity('Vui lòng ngân hàng')" oninput="setCustomValidity('')" >
		
			   <!-- BEGIN: acount_bank -->
				<option value="{ACBANK.key}" {ACBANK.selected}>{ACBANK.title}</option>
			   <!-- END: acount_bank -->
				</select>
				</div>
		</div>

<div class="form-group">
                <label class="control-label col-md-8">
                    {LANG.customer_money} <i class="text-danger">(*)</i>:
                </label>
                <div class="col-md-13">
                    <div class="row">
                        <div class="col-md-16">
                         <input class="form-control" type="text" name="money_out" id="money_out" value="{ROW.money_out}" required="required" onkeyup="this.value=FormatNumber(this.value);" placeholder="1,000,000 VND" />
                        </div>
                        <div class="col-md-8">
                          <label class="control-label">{MONEY_UNIT}</label>
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
                    <textarea class="textarea form-control form-control-fullwidth" name="transaction_info">Yêu cầu rút tiền về tài khoản ngân hàng </textarea>
                </div>
            </div>
    
           


	
    <div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>
<script type="text/javascript" data-show="after" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
//<![CDATA[

$('.bank_id').select2({
    placeholder: "Mời bạn chọn ngân hàng"
})
</script>
<!-- END: main -->