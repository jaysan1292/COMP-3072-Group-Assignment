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
			<?php /* See aProfessor.php and aClasses.php */ ?>
			<?php admin_init_timeoff_request(); global $requests; foreach($requests as $request): ?>
			<tr class="success">
				<td><?=$request['Professor']?></td>
				<td><?=$request['Date']?></td>
				<td><?=$request['Reason']?></td>
				<td><a href="#" class="decision" data-type="select" data-pk="1" data-url="" data-original-title="Make a decision"></a></td>
			</tr>
			<?php endforeach; ?>
			<!-- <tr class="warning">
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
			</tr> -->

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
		value: 3,
		source: [
		{value: 1, text: 'Approved'},
		{value: 2, text: 'Declined'},
		{value: 3, text: 'Under Review'}
		]
	});
});
</script>
