<!-- BEGIN: main -->
	<!-- BEGIN: province -->
		<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>PROVINCE_ID</th>
							<th>ProvinceName</th>

						</tr>
					</thead>

					<tbody>
						<!-- BEGIN: loop -->
						<tr>
							<td> {VIEW.PROVINCE_ID} </td>
							<td><a href="{VIEW.alias}"> {VIEW.PROVINCE_NAME} </a></td>
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
							<th>DISTRICT_ID</th>
							<th>DISTRICT_NAME</th>

						</tr>
					</thead>

					<tbody>
						<!-- BEGIN: loop -->
						<tr>
							<td> {VIEW.DISTRICT_ID} </td>
							<td><a href="{VIEW.alias}"> {VIEW.DISTRICT_NAME} </a></td>
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
							<th>WARDS_ID</th>
							<th>WARDS_NAME</th>

						</tr>
					</thead>

					<tbody>
						<!-- BEGIN: loop -->
						<tr>
							<td> {VIEW.WARDS_ID} </td>
							<td>{VIEW.WARDS_NAME}</td>
						</tr>
						<!-- END: loop -->
					</tbody>
				</table>
			</div>
		</form>
	<!-- END: ward -->
<!-- END: main -->