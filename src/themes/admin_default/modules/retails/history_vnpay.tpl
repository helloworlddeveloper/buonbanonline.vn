<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="well">
<form action="{NV_BASE_ADMINURL}index.php" method="get">
    <input type="hidden" name="{NV_LANG_VARIABLE}"  value="{NV_LANG_DATA}" />
    <input type="hidden" name="{NV_NAME_VARIABLE}"  value="{MODULE_NAME}" />
    <input type="hidden" name="{NV_OP_VARIABLE}"  value="{OP}" />
    <div class="row">
        <div class="col-xs-24 col-md-6">
            <div class="form-group">
                <input class="form-control" type="text" value="{Q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
            </div>
        </div>
    </div>
</form>
</div>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
					<th>{LANG.vnp_transactionno}</th>
					<th style="width:200px">{LANG.vnp_txnref}</th>
                    <th style="width:150px">{LANG.name_register}</th>
                    <th>{LANG.email_register}</th>
                    <th>{LANG.phone_register}</th>
                    <th>{LANG.userid}</th>
                    <th>{LANG.price_vnpay}</th>
                    <th>{LANG.vnp_cardtype}</th>
                    <th>{LANG.vnp_bankcode}</th>
                    <th>{LANG.vnp_responsedode}</th>
                    <th>{LANG.status}</th>
					<th>{LANG.vnp_paydate}</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="13">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
					<td> {VIEW.vnp_transactionno} </td>
					<td> {VIEW.vnp_txnref} </td>
                    <td> {VIEW.name_register} </td>
                    <td> {VIEW.email_register} </td>
                    <td> {VIEW.phone_register} </td>
                    <td> {VIEW.userid} </td>
                    <td> {VIEW.price} </td>
                    <td> {VIEW.vnp_cardtype} </td>
                    <td> {VIEW.vnp_bankcode} </td>
                    <td> {VIEW.vnp_responsedode} </td>
                    <td> {VIEW.status} </td>
					<td> {VIEW.addtime} </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->


<!-- END: main -->