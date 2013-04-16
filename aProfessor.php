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
                        <td><?=$professor['Department']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>
<?php include 'php/newProfessorForm.php';
