<!-- Admin's Update Function -->

<h4>Admin's Update Function</h4>

<form class="form-inline">
	<table class="table table-condensed">
		<tbody>
			<tr>
				<th>Course Code</th>
				<th>Code Description</th>
				<th>Course CRN</th>
				<th>Room Number</th>
				<th>Room Type</th>
				<th>Section</th>
			</tr>
			<?php/* Fuck it, I'm tired. This will be an associative array, not a class object. */?>
			<?php admin_init_courses(); global $courses; foreach($courses as $course): ?>
			<tr class="success">
				<td><?=$course['CourseCode']?></td>
				<td><?=$course['CourseDescription']?></td>
				<td><?=$course['CRN']?></td>
				<td><?=$course['RoomNumber']?></td>
				<td><?=$course['RoomType']?></td>
				<!-- TODO: Figure this out >: -->
				<td><a href="#" class="sect" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Section"></a></td>
			</tr>
			<?php endforeach; ?>
			<!-- <tr class="warning">
				<td>getCourseCode()</td>
			 	<td>getCOurseDesc()</td>
				<td>getCRN()</td>
				<td>getRoomNumber()</td>
				<td>getRoomType()</td>
				<td><a href="#" class="sect" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Section"></a></td>
			</tr>
			<tr class="error">
				<td>getCourseCode()</td>
				<td>getCOurseDesc()</td>
				<td>getCRN()</td>
				<td>getRoomNumber()</td>
				<td>getRoomType()</td>
				<td><a href="#" class="sect" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Section"></a></td>
			</tr>
			<tr class="info">
				<td>getCourseCode()</td>
				<td>getCOurseDesc()</td>
				<td>getCRN()</td>
				<td>getRoomNumber()</td>
				<td>getRoomType()</td>
				<td><a href="#" class="sect" data-type="select" data-pk="1" data-url="" data-original-title="Select Class Section"></a></td>
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
	$('.sect').editable({
		value: 1,
		source: [
		{value: 1, text: 'T127-6A0'},
		{value: 2, text: 'T141-9C3'},
		{value: 3, text: 'T154-1P8'},
		{value: 4, text: 'T169-6T9'}
		]
	});
});
</script>
