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
									<span class="e_id"> <?= "Employee Number" ?> </span>
								</div>
							</div>
						</div>
						<script src="editecord.js"></script>
						<div class="span9">
							<form class="form-inline">
								<table id="user" class="table table-bordered table-striped">
									<tbody>
									<caption>**Click text to Edit**</caption> 
										<tr>         
											<td width="40%">Contact Number:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="contact_number" data-type="text"><?= "contact_number"?></a></td>
										</tr>
										<tr>         
											<td>E-mail Address:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="email" data-type="email"><?= "email"?></a></td>
										</tr>  
										<tr>         
											<td>Department:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="department" data-type="select"><?= "department"?></a></td>
										</tr>     
										<tr>         
											<td>Courses:</td>
											<td><a href="#" class="myeditable editable editable-click editable-empty" id="courses" data-type="checklist"></a></td>
										</tr>  
										<tr>         
											<td>Request a Time-Off/Vaction</td>
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