<!-- Admin's Update Function -->

<h4>Admin's Update Function</h4>

<form class="form-inline">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Code Description</th>
                <th>Course CRN</th>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Section</th>
            </tr>
        </thead>
        <tbody>
            <?php /* Fuck it, I'm tired. This will be an associative array, not a class object. */ ?>
            <?php admin_init_courses(); global $courses; foreach($courses as $course): ?>
            <tr>
                <td><?=$course['CourseCode']?></td>
                <td><?=$course['CourseDescription']?></td>
                <td><?=$course['CRN']?></td>
                <td><?=$course['RoomNumber']?></td>
                <td><?=$course['RoomType']?></td>
                <!-- <td><a href="#" class="sect" data-type="select" data-pk="<?=$course['SectionId']?>" data-url="" data-original-title="Select Class Section"></a></td> -->
                <td>
                    <?php
                    admin_init_course_sections();
                    global $sections;
                    ?>
                    <select class="input-small">
                        <?php foreach($sections as $section): ?>
                        <option <?=$course['SectionId'] != $section['Id'] ? "" : "selected"?> value="<?=$section['Id']?>"><?=$section['Name']?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <button id="save-btn" class="btn btn-primary">Update Changes</button>
    </div>
</form>
