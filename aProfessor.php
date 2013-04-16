<div class="row-fluid">
    <?php if(!is_post_var_empty('message')): ?>
    <div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=$_POST['message']?>
    </div>
    <?php endif; ?>
    <form>
        <div class="generic-list">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>EmployeeID</th>
                        <th>Professor</th>
                        <th>Contact Number</th>
                        <th>Email Address</th>
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
        </div>
        <button id="save-btn" class="btn btn-primary pull-right">Update Changes</button>
    </form>
</div>
<div class="row">
    <div class="span6 offset2">
        <form class="form-horizontal" method="POST" action="addprof.php">
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
                        <select name="department">
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
