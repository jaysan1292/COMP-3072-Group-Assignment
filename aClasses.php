<!-- Admin's Update Function -->

<h4>Admin's Update Function</h4>

<form class="form-inline">
	<table class="table table-condensed">
		<tbody> 
			<tr>         
				<th>Class</th>
				<th>Status</th>
			</tr>
			<tr class="success">         
				<td>Course 1</td>
				<td><a href="#" class="status" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Status"></a></td>
			</tr>
			<tr class="warning">         
				<td>Course 2</td>
				<td><a href="#" class="status" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Status"></a></td>
			</tr>
			<tr class="error">         
				<td>Course 3</td>
				<td><a href="#" class="status" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Status"></a></td>
			</tr>
			<tr class="info">         
				<td>Course 4</td>
				<td ><a href="#" class="status" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Status"></a></td>
			</tr>

		</tbody>
	</table>

<div>
	<button id="save-btn" class="btn btn-primary">Update Changes</button>
</div>
</form>

<script>
$(function(){
	$.fn.editable.defaults.mode = 'inline';
	$('.status').editable({
		value: 1,    
		source: [
		{value: 1, text: 'In-Progress'},
		{value: 2, text: 'Delayed'},
		{value: 3, text: 'Canceled'},
		{value: 4, text: 'Moved'}
		]
	});
});
</script>
