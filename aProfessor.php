<div class="center subnav">
    <ul class="nav nav-pills" id="professor-nav">
        <li class="active"><a data-toggle="tab" href="#professor-list">All Professors</a></li>
        <li><a data-toggle="tab" href="#professor-new">New Professor</a></li>
    </ul>
</div>

<section class="tab-content">
    <article class="tab-pane active" id="professor-list">
        <div class="row-fluid">
            <?php if(!is_post_var_empty('message')): ?>
            <div class="alert alert-success">
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
                                <th>Schedule</th>
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
                                <td><a href="<?=ROOT_DIR?>/img/schedule.php?id=<?=$professor['EmployeeId']?>">Schedule</a>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </article>
    <article class="tab-pane" id="professor-new">
        <?php include 'php/newProfessorForm.php'; ?>
    </article>
</section>
