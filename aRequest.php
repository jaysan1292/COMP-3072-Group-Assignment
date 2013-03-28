<!-- Admin's Update Function -->

<h4>Requests Status</h4>

<form class="form-inline">
	<table class="table table-condensed">
		<tbody> 
			<tr>         
				<th>Professor</th>
				<th>Date(s)</th>
				<th>Reason</th>
				<th>Status</th>
			</tr>
			<tr class="success">         
				<td>Professor 1</td>
				<td>getDates()</td>
				<td>getReason()</td>
				<td><a href="#" class="decision" data-type="select" data-pk="1" data-url="" data-original-title="Make a decision"></a></td>
			</tr>
			<tr class="warning">         
				<td>Professor 2</td>
				<td>getDates()</td>
				<td>getReason()</td>
				<td><a href="#" class="decision" data-type="select" data-pk="1" data-url="" data-original-title="Make a decision"></a></td>
			</tr>
			<tr class="error">         
				<td>Professor 3</td>
				<td>getDates()</td>
				<td>getReason()</td>
				<td><a href="#" class="decision" data-type="select" data-pk="1" data-url="" data-original-title="Make a decision"></a></td>
			</tr>
			<tr class="info">         
				<td>Professor 4</td>
				<td>getDates()</td>
				<td>getReason()</td>
				<td ><a href="#" class="decision" data-type="select" data-pk="1" data-url="" data-original-title="Make a decision"></a></td>
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
	$('.decision').editable({
		value: 1,    
		source: [
		{value: 1, text: 'Approved'},
		{value: 2, text: 'Declined'},
		{value: 3, text: 'Under Review'}
		]
	});
});
</script>
