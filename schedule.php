<div class="row-fluid">
    <div class="span7 pull-left">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>CRN</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Day</th>
                    <th>Start</th>
                    <th>Finish</th>
                </tr>
            </thead>
            <tbody>
                <?php professor_init_courses(); global $professor_courses; foreach($professor_courses as $course): ?>
                <tr>
                    <td><?=$course['CRN']?></td>
                    <td><?=$course['CourseCode']?></td>
                    <td><?=$course['CourseDescription']?></td>
                    <td>
                        <?php
                        $keys = array(
                            'Monday',
                            'Tuesday',
                            'Wednesday',
                            'Thursday',
                            'Friday',
                        );
                        $day = false;
                        foreach($keys as $key) {
                            if($course[$key]) {
                                $day = $key;
                            }
                        }
                        echo $day;
                        ?>
                    </td>
                    <td><?=time24_to_string($course['StartTime'])?></td>
                    <td><?=time24_to_string($course['FinishTime'])?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="span5 pull-right">
        <?php $schedule_img = ROOT_DIR.'/img/schedule.php'; ?>
        <a href="<?=$schedule_img?>"><img src="<?=$schedule_img?>"/></a>
    </div>
</div>
