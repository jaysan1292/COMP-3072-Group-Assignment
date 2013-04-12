<form class="form-inline">
	<table class="table table-condensed">
		<tbody>
			<tr>
				<th>Professor</th>
				<th>Contact Number</th>
				<th>Email Address</th>
				<th>Course(s)</th>
				<th>EmployeeID</th>
				<th>Department</th>
			</tr>
			<?php /* Same deal as aClasses.php, but with professors instead. */ ?>
			<?php admin_init_professors(); global $professors; foreach($professors as $professor): ?>
			<tr class="success">
				<td><?=$professor['Name']?></td>
				<td><?=$professor['ContactNumber']?></td>
				<td><?=$professor['EmailAddress']?></td>
				<td>getCourses()</td>
				<td><?=$professor['EmployeeId']?></td>
				<td><a href="#" class="department" data-type="select" data-pk="1" data-url="" data-original-title="Make a department"></a></td>
			</tr>
			<?php endforeach; ?>
			<!-- <tr class="warning">
				<td>Professor 2</td>
				<td>getContact()</td>
				<td>getEmail()</td>
				<td>getCourses()</td>
				<td>getEmployeeID()</td>
				<td><a href="#" class="department" data-type="select" data-pk="1" data-url="" data-original-title="Make a department"></a></td>
			</tr>
			<tr class="error">
				<td>Professor 3</td>
				<td>getContact()</td>
				<td>getEmail()</td>
				<td>getCourses()</td>
				<td>getEmployeeID()</td>
				<td><a href="#" class="department" data-type="select" data-pk="1" data-url="" data-original-title="Make a department"></a></td>
			</tr>
			<tr class="info">
				<td>Professor 4</td>
				<td>getContact()</td>
				<td>getEmail()</td>
				<td>getCourses()</td>
				<td>getEmployeeID()</td>
				<td ><a href="#" class="department" data-type="select" data-pk="1" data-url="" data-original-title="Make a department"></a></td>
			</tr> -->


<div class="pagination pagination-centered">
  <ul>
    <li class="disabled"><a href="#">&laquo;</a></li>
    <li class="active"><a href="#">1</a></li>
  	<li><a href="#">2</a></li>
  	<li><a href="#">3</a></li>
  	<li><a href="#">4</a></li>
  	<li><a href="#">5</a></li>
  </ul>
</div>

		</tbody>
	</table>
	<div>
		<button id="save-btn" class="btn btn-primary">Update Changes</button>
	</div>
</form>

<form class="form-inline">
	<table class="table table-condensed">
		<tbody>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Employee ID</th>
				<th>Course(s)</th>
			</tr>
			<tr>
				<td><input class="input-medium" type="text" placeholder=".input-medium"></td>
				<td><input class="input-medium" type="text" placeholder=".input-medium"></td>
				<td><input class="input-medium" type="text" placeholder=".input-medium"></td>
				<td>
					<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox1" value="option1"> 1
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox2" value="option2"> 2
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 3
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 4
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 5
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 6
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 7
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 8
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 9
</label>
<label class="checkbox inline">
  <input type="checkbox" id="inlineCheckbox3" value="option3"> 10
</label>
				</td>
			</tr>
		</tbody>
	</table>

	<div>
		<button id="save-btn" class="btn btn-primary">Add New User</button>
	</div>
</form>


<script>
$(function(){
	$.fn.editable.defaults.mode = 'inline';
	var source = [
		<?php admin_init_departments(); global $departments; foreach($departments as $department): ?>
		{value: <?=$department['Id']?>, text: "<?=$department['Name']?>"},
		<?php endforeach; ?>
	];
	$('.department').each(function(){
		$(this).editable({
			value: $(this).data('pk'),
			source: source
		});
	});
});
</script>
