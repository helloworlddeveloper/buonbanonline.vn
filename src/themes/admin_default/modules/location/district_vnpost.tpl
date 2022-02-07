<!-- BEGIN: main -->


<div id="form">
	<!-- BEGIN: error -->
	<div class="alert alert-warning">{ERROR}</div>
	<!-- END: error -->

	<div class="panel panel-default">
		<div class="panel-body">
			<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&countryid={ROW.countryid}" method="post">
				<input type="hidden" name="districtid" value="{ROW.districtid}" />

	
				<div class="form-group" style="text-align: center">
					<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
				</div>
			</form>
		</div>
	</div>
</div>



<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
//<![CDATA[
	$("[name='title']").change(function() {
		nv_get_alias('id_alias');
	});
//]]>
</script>
<!-- END: auto_get_alias -->
<!-- END: main -->