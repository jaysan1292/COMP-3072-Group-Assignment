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
				<td><a href="#" class="decision" data-type="select" data-pk="<?=$request['StatusId']?>" data-url="" data-original-title="Make a decision"></a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

<div>
	<button id="save-btn" class="btn btn-primary">Update Changes</button>
</div>
</form>

<script>
$(function(){
	$.fn.editable.defaults.mode = 'inline';
	var source = [
		<?php admin_init_timeoff_statuses(); global $timeoff_statuses; foreach($timeoff_statuses as $status): ?>
		{value: <?=$status['Id']?>, text: "<?=$status['Name']?>"},
		<?php endforeach; ?>
	];
	$('.decision').each(function(){
		$(this).editable({
			value: $(this).data('pk'),
			source: source
		});
	});
});
</script>
