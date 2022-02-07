<!-- BEGIN: main -->
<!-- BEGIN: slider -->
<div class="panel panel-default">
	<div class="panel-heading">{LANG.slider}</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					
					
					<thead>
						<tr>
							<th class="w100">{LANG.weight}</th>
							<th class="w200">{LANG.cat_title}</th>
							<th>{LANG.description}</th>
						</tr>
					</thead>
					<tbody>
						<!-- BEGIN: loop -->
							<tr>
								<td class="text-center">{VIEW.weight}</td>
								<td> <a href="{VIEW.add_content}" title="Thêm nội dung slider"><strong>{VIEW.title}</strong></a></td>
								<td>{VIEW.item} - <strong>{VIEW.description}</strong></td>
							</tr>
						<!-- END: loop -->
					</tbody>
				</table>
			</div>   
	</div>
</div>
<!-- END: slider -->
         
<!-- BEGIN: support -->
<div class="panel panel-default">
	<div class="panel-heading">{LANG.support}</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
				
					<thead>
						<tr>
							<th class="w100">{LANG.weight}</th>
							<th class="w200">{LANG.cat_title}</th>
							<th>{LANG.description}</th>
						</tr>
					</thead>
					<tbody>
						<!-- BEGIN: loop -->
							<tr>
								<td class="text-center">{VIEW.weight}</td>
								<td> <a href="{VIEW.add_content}" title="Thêm nội dung support"><strong>{VIEW.title}</strong></a></td>
								<td>{VIEW.item} - <strong>{VIEW.description}</strong> </td>
							</tr>
						<!-- END: loop -->
					</tbody>
				</table>
			</div>   
	</div>
</div>
<!-- END: support -->  
	
	
<!-- END: main -->