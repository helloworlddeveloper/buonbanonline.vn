<!-- BEGIN: main -->

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<div class="panel panel-default">
<div class="panel-body">
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{ROW.id}" />
	<input type="hidden" name="userid" value="{ROW.userid}" />
	<p class="text-center" style="font-weight:bold;font-size:20px">Bỏ trống trường mật khẩu nếu không muốn thay đổi</p>
		<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>Mật khẩu</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="password" name="password"  pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$" oninput="this.setCustomValidity('')" value="{ROW.password}" oninvalid="setCustomValidity('{LANG.validate_pass}')"  />
        </div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>Nhập lại mật khẩu</strong> </label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="password" name="password2"  pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$" oninput="this.setCustomValidity('')" value="{ROW.password2}" oninvalid="setCustomValidity('{LANG.validate_pass}')"  />
        </div>
	</div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Họ và tên đệm</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="first_name" value="{ROW.last_name}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Tên</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="last_name" value="{ROW.first_name}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Email</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="email" name="email" value="{ROW.email}" required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.phone}</strong> <span class="red">(*)</span></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="phone" value="{ROW.phone}" maxlength="10"  required="required" oninvalid="setCustomValidity(nv_required)" oninput="setCustomValidity('')" onkeyup="this.value=this.value.replace(/[^\d]/,'')" />
        </div>
    </div>
    <div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>

<!-- END: main -->