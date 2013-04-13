<!-- Admin's Update Function -->

<h4>Admin's Update Function</h4>

<form class="form-inline">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <th>Course Code</th>
                <th>Code Description</th>
                <th>Course CRN</th>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Section</th>
            </tr>
            <?php /* Fuck it, I'm tired. This will be an associative array, not a class object. */ ?>
            <?php admin_init_courses(); global $courses; foreach($courses as $course): ?>
            <tr class="success">
                <td><?=$course['CourseCode']?></td>
                <td><?=$course['CourseDescription']?></td>
                <td><?=$course['CRN']?></td>
                <td><?=$course['RoomNumber']?></td>
                <td><?=$course['RoomType']?></td>
                <td><a href="#" class="sect" data-type="select" data-pk="<?=$course['SectionId']?>" data-url="" data-original-title="Select Class Section"></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<div>
    <button id="save-btn" class="btn btn-primary">Update Changes</button>
</div>
</form>

<script>
$(function(){
    $.fn.editable.defaults.mode = 'inline';
    var source = [
        <?php admin_init_course_sections(); global $sections; foreach($sections as $section): ?>
        {value: <?=$section['Id']?>, text: "<?=$section['Name']?>"},
        <?php endforeach; ?>
    ];
    $('.sect').editable({
        value: 1,
        source: source
    });
});
</script>
