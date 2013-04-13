<?php $user = $_SESSION['current_user']; ?>
<div id="profile" class="row-fluid">
	<div class="span12">
		<div class="widget no-margin">
			<div class="widget-body">
				<div class="container-fluid">

					<div class="row-fluid">
						<div class="span3">
							<div class="thumbnail">
								<img alt="300x200" src="img/hero-image.jpg">
								<div class="caption">
									<span class="name"> <?=$_SESSION['current_user'] ?> </span> <br>
									<span class="e_id"> <?="Employee " . $user->id?> </span>
								</div>
							</div>
						</div>
						<div class="span9">
							<form class="form-inline">
								<table id="user" class="table table-bordered table-striped">
									<tbody>
									<caption>**Click text to Edit**</caption>
										<tr>
											<td width="40%">Contact Number:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="contact_number" data-type="text"><?=$user->contact?></a></td>
										</tr>
										<tr>
											<td>E-mail Address:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="email" data-type="email"><?=$user->email?></a></td>
										</tr>
										<tr>
											<td>Department:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="department" data-type="select"><?=$user->department?></a></td>
										</tr>
										<tr>
											<td>Courses:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="courses" data-type="checklist"></a></td>
										</tr>
										<tr>
											<td>Request a Time-Off/Vacation</td>
											<td>
												<label for="date1">From:</label>
												<input type="text" id="date1" data-format="DD-MM-YYYY" data-template="D MMM YYYY" name="date" value="<?php echo date("d-m-Y"); ?>">
												<br>
												<label for="date2">To: &nbsp;&nbsp;&nbsp;</label>
												<input type="text" id="date2" data-format="DD-MM-YYYY" data-template="D MMM YYYY" name="date" value="<?php echo date("d-m-Y"); ?>">
												<br>
												<a href="#" class="myeditable editable editable-click editable-empty" id="book_off_reason" data-type="textarea" placeholder="Request a Time-Off Here"><?= "Reason:"?></a>
											</td>
										</tr>
									</tbody>
								</table>

								<div>
									<button id="save-btn" class="btn btn-primary">Save changes</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
<?php
professor_init_courses();
professor_init_departments();
global $professor_courses, $departments;
?>
$(function(){
	$.fn.editable.defaults.mode = 'inline';
	$('#contact_number').editable({
		url: '',
		title: 'Contact Info:'
	});
	$('#email').editable({
		url: '',
		title: 'Email Address:'
	});
	// $('#department').editable({
	// 	url: '',
	// 	title: 'Department:'
	// });
	$('#department').editable({
		<?php $d = professor_get_current_department(); ?>
		value: <?=$d['Id']?>,
		source: [
		<?php foreach($departments as $dept): ?>
		{value: <?=$dept['Id']?>, text: "<?=$dept['Name']?>"},
		<?php endforeach; ?>
		]
	});
	$('#courses').editable({
		<?php
		$ids = array();
		foreach($professor_courses as $course) {
			if(!in_array($course['CourseId'], $ids)) {
				$ids[] = $course['CourseId'];
				$values[] = '{value: '.$course['CourseId'].', text: "'.$course['CourseCode'].': '.$course['CourseDescription'].'"}';
			}
		}
		?>
        value: [<?=implode(',', $ids)?>],
        source: [
        	<?=implode(',', $values)?>
        ]
    });
	$('#book_off_reason').editable({
        url: 'post.php',
        title: 'Enter comments',
        rows: 5
    });
    $('#date1').combodate({
    minYear: 2013,
    maxYear: 2050,
    });
	$('#date2').combodate({
    minYear: 2013,
    maxYear: 2050,
    });
});
</script>
