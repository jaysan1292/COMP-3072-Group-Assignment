<h4>Professor's View of Updates</h4>
	<table class="table table-striped">
		<tbody>
			<tr>
				<th>Course Code</th>
				<th>Course Name</th>
				<th>Room Number</th>
				<th>Course Type</th>
				<th>Room Size</th>
			</tr>
			<?php professor_init_courses(); global $professor_courses; foreach($professor_courses as $course): ?>
			<tr>
				<td><?=$course['CourseCode']?></td>
				<td><?=$course['CourseDescription']?></td>
				<td><?=$course['RoomNumber']?></td>
				<td><?=$course['CourseType']?></td>
				<td><?=$course['RoomSize']?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
