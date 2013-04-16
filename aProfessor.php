<form class="form-inline">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>EmployeeID</th>
                <th>Professor</th>
                <th>Contact Number</th>
                <th>Email Address</th>
                <th>Course(s)</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php /* Same deal as aClasses.php, but with professors instead. */ ?>
            <?php admin_init_professors(); global $professors; foreach($professors as $professor): ?>
            <tr>
                <td><?=$professor['EmployeeId']?></td>
                <td><?=$professor['Name']?></td>
                <td><?=$professor['ContactNumber']?></td>
                <td><?=$professor['EmailAddress']?></td>
                <td>getCourses()</td>
                <td><a href="#" class="department" data-type="select" data-pk="<?=$professor['DepartmentId']?>" data-url="" data-original-title="Make a department"></a></td>
            </tr>
            <?php endforeach; ?>


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
    <table class="table table-striped">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Employee ID</th>
                <th>Course(s)</th>
            </tr>
        </thead>
        <tbody>
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
