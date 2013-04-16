<div class="row-fluid">
    <form class="">
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
                    <td>
                        <?php
                        admin_init_departments();
                        global $departments;
                        ?>
                        <select class="input-medium">
                            <?php foreach($departments as $dept): ?>
                            <option <?=$professor['DepartmentId'] != $dept['Id'] ? "" : "selected"?> value="<?=$dept['Id']?>"><?=$dept['Name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>


            </tbody>
        </table>
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
        <button id="save-btn" class="btn btn-primary pull-right">Update Changes</button>
    </form>
</div>
<div class="row">
    <div class="span6 offset2">
        <form class="form-horizontal">
            <fieldset>
                <legend>Add New User</legend>
                <div class="control-group">
                    <label class="control-label" for="first-name">First Name</label>
                    <div class="controls">
                        <input type="text" name="first-name" placeholder="First Name"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="last-name">Last Name</label>
                    <div class="controls">
                        <input type="text" name="last-name" placeholder="Last Name" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="department">Department</label>
                    <div class="controls">
                        <select>
                            <?php admin_init_departments(); global $departments; foreach($departments as $dept): ?>
                            <option value="<?=$dept['Id']?>"><?=$dept['Name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button id="save-btn" type="submit" class="btn btn-primary" value="new-user">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
