<!-- BEGIN: main -->
<table id="poTable" class="table items table-striped table-bordered table-condensed table-hover sortable_table">
	<thead>
		<tr>
			<th class="text-center">Tên kho hàng</th>
			<th class="text-center">Tên người gởi</th>
			<th class="text-center">Số điện thoại người gởi</th>
			<th class="text-center">Địa chỉ người gởi</th>
		</tr>
	</thead>
	<!-- BEGIN: generate_page_warehouse -->
       <tfoot>
             <tr>
                 <td class="text-center" colspan="24">{NV_GENERATE_PAGE_WAREHOUSE}</td>
              </tr>
       </tfoot>
    <!-- END: generate_page_warehouse -->
	<tbody>
		<!-- BEGIN: loop -->
			<tr class="text-center">
				<td>{LOOP.name_warehouse}</td>
				<td>{LOOP.name_send}</td>
				<td>{LOOP.phone_send}</td>
				<td>{LOOP.address_full}</td>
			</tr>
		<!-- END: loop -->
	</tbody>
</table>
<!-- END: main -->