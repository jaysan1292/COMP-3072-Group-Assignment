<div class="row-fluid">
    <form class="form-inline">
        <div class="generic-list">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>CRN</th>
                        <th>Course Description</th>
                        <th>Course Type</th>
                        <th>Room Number</th>
                        <th>Professor</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    <?php /* Fuck it, I'm tired. This will be an associative array, not a class object. */ ?>
                    <?php admin_init_courses(); global $courses; foreach($courses as $course): ?>
                    <tr>
                        <td><?=$course['CourseCode']?></td>
                        <td><?=$course['CRN']?></td>
                        <td><?=$course['CourseDescription']?></td>
                        <td><?=$course['CourseType']?></td>
                        <td><?=$course['RoomNumber']?></td>
                        <td><?=$course['Professor']?></td>
                        <td><?=$course['Section']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>
<?php include 'php/newCourseForm.php'; ?>
