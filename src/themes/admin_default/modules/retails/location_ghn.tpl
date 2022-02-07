<!-- BEGIN: main -->
	<!-- BEGIN: province -->
		<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ProvinceID</th>
							<th>ProvinceName</th>

						</tr>
					</thead>

					<tbody>
						<!-- BEGIN: loop -->
						<tr>
							<td> {VIEW.ProvinceID} </td>
							<td><a href="{VIEW.alias}"> {VIEW.ProvinceName} </a></td>
						</tr>
						<!-- END: loop -->
					</tbody>
				</table>
			</div>
		</form>
	<!-- END: province -->
	<!-- BEGIN: district -->
		<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>DistrictID</th>
							<th>DistrictName</th>

						</tr>
					</thead>

					<tbody>
						<!-- BEGIN: loop -->
						<tr>
							<td> {VIEW.DistrictID} </td>
							<td><a href="{VIEW.alias}"> {VIEW.DistrictName} </a></td>
						</tr>
						<!-- END: loop -->
					</tbody>
				</table>
			</div>
		</form>
	<!-- END: district -->
	<!-- BEGIN: ward -->
		<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>WardID</th>
							<th>WardName</th>

						</tr>
					</thead>

					<tbody>
						<!-- BEGIN: loop -->
						<tr>
							<td> {VIEW.WardCode} </td>
							<td>{VIEW.WardName}</td>
						</tr>
						<!-- END: loop -->
					</tbody>
				</table>
			</div>
		</form>
	<!-- END: ward -->
<!-- END: main -->