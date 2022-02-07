<!-- BEGIN: main -->

<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<div class="panel panel-default">
<div class="panel-body">
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{ROW.id}" />
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.order_id}</strong></label>
        <div class="col-sm-19 col-md-20">
            <select class="form-control" name="order_id">
                <option value=""> --- </option>
                <!-- BEGIN: select_order_id -->
                <option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
                <!-- END: select_order_id -->
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.order_code}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="order_code" value="{ROW.order_code}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.name_products}</strong></label>
        <div class="col-sm-19 col-md-20">
            <textarea class="form-control" style="height:100px;" cols="75" rows="5" name="name_products">{ROW.name_products}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.total_weight_convert}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="total_weight_convert" value="{ROW.total_weight_convert}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.total_weight}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="total_weight" value="{ROW.total_weight}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.total_width}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="total_width" value="{ROW.total_width}" />
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.total_length}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="total_length" value="{ROW.total_length}" />
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.total_height}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="total_height" value="{ROW.total_height}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.total_moeny}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="total_moeny" value="{ROW.total_moeny}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.tinhthanh_gui}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="tinhthanh_gui" value="{ROW.tinhthanh_gui}" pattern="^[0-9]*$"  oninvalid="setCustomValidity(nv_digits)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.quanhuyen_gui}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="quanhuyen_gui" value="{ROW.quanhuyen_gui}" pattern="^[0-9]*$"  oninvalid="setCustomValidity(nv_digits)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.address_gui}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="address_gui" value="{ROW.address_gui}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.phone_gui}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="phone_gui" value="{ROW.phone_gui}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.name_gui}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="name_gui" value="{ROW.name_gui}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.userid_add}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="userid_add" value="{ROW.userid_add}" pattern="^[0-9]*$"  oninvalid="setCustomValidity(nv_digits)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.tinhthanh_nhan}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="tinhthanh_nhan" value="{ROW.tinhthanh_nhan}" pattern="^[0-9]*$"  oninvalid="setCustomValidity(nv_digits)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.quanhuyen_nhan}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="quanhuyen_nhan" value="{ROW.quanhuyen_nhan}" pattern="^[0-9]*$"  oninvalid="setCustomValidity(nv_digits)" oninput="setCustomValidity('')" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.address_nhan}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="address_nhan" value="{ROW.address_nhan}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.phone_nhan}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="phone_nhan" value="{ROW.phone_nhan}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.name_nhan}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="name_nhan" value="{ROW.name_nhan}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.id_vnpost}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="id_vnpost" value="{ROW.id_vnpost}" />
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.item_code}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="item_code" value="{ROW.item_code}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.cuoc_phi}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="cuoc_phi" value="{ROW.cuoc_phi}" />
        </div>
    </div>
	
	 <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.tongcuocdichvucongthem}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="tongcuocdichvucongthem" value="{ROW.tongcuocdichvucongthem}" />
        </div>
    </div>
	
	 <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.tongcuocbaogomdvct}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="tongcuocbaogomdvct" value="{ROW.tongcuocbaogomdvct}" />
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.hinhthuc_vc}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="hinhthuc_vc" value="{ROW.hinhthuc_vc}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.vnpost_status}</strong></label>
        <div class="col-sm-19 col-md-20">
            <select class="form-control" name="vnpost_status">
                <option value=""> --- </option>
                <!-- BEGIN: select_vnpost_status -->
                <option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
                <!-- END: select_vnpost_status -->
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.customer_code}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="customer_code" value="{ROW.customer_code}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.cod}</strong></label>
        <div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="cod" value="{ROW.cod}" />
        </div>
    </div>
	
	<div class="content_cuophi_thuctinh">
	<div class="thuctinh_vc">Giá trị thực tính {ROW.date_edit}</div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>Khối lượng thực tính</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="weight" value="{ROW.weight}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.weightconvert}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="weightconvert" value="{ROW.weightconvert}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.width}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="width" value="{ROW.width}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.length}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="length" value="{ROW.length}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.height}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="height" value="{ROW.height}" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.cuocphi_thuctinh}</strong></label>
        <div class="col-sm-19 col-md-20">
            <input class="form-control" type="text" name="cuocphi_thuctinh" value="{ROW.cuocphi_thuctinh}" />
        </div>
    </div>
	
	
	
	</div>
	
	
	
	
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.date_add}</strong></label>
        <div class="col-sm-19 col-md-20">
            <div class="input-group">
            <input class="form-control" type="text" name="date_add" value="{ROW.date_add}" id="date_add" pattern="^[0-9]{2,2}\/[0-9]{2,2}\/[0-9]{1,4}$" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="date_add-btn">
                        <em class="fa fa-calendar fa-fix"> </em>
                    </button> </span>
                </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.doisoat}</strong></label>
        <div class="col-sm-19 col-md-20">

            <!-- BEGIN: radio_doisoat -->
                <label><input class="form-control" type="radio" name="doisoat" value="{OPTION.key}" {OPTION.checked}>{OPTION.title} &nbsp;</label> 
            <!-- END: radio_doisoat -->
        </div>
    </div>
   
</form>
</div></div>

<!-- END: main -->