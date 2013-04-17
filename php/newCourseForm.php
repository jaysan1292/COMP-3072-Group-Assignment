<?php
if(!is_post_var_empty('course-code')) {
    ?><script type="text/javascript">$('#admin-nav a[href="#aClasses"]').tab('show')</script><?php
    func_die($_POST);
}
?>

<div class="row">
    <div class="span6 offset2">
        <h3>Add New Course</h3>
        <form class="form-horizontal" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <fieldset>
                <legend>General</legend>
                <!-- Course Code -->
                <div class="control-group">
                    <label class="control-label" for="course-code">Course Code</label>
                    <div class="controls">
                        <input type="text" name="course-code" placeholder="Course Code"/>
                    </div>
                </div>
                <!-- Course Name -->
                <div class="control-group">
                    <label class="control-label" for="course-name">Course Name</label>
                    <div class="controls">
                        <input type="text" name="course-name" placeholder="Course Name" />
                    </div>
                </div>
                <!-- CRN -->
                <div class="control-group">
                    <label class="control-label" for="crn">CRN</label>
                    <div class="controls">
                        <input type="text" name="crn" placeholder="CRN" />
                    </div>
                </div>
                <!-- Professor -->
                <div class="control-group">
                    <label class="control-label" for="professor">Professor</label>
                    <div class="controls">
                        <select name="professor">
                            <option value="0">-- Select Professor --</option>
                            <?php $profs = admin_get_available_professors(); foreach($profs as $prof): ?>
                            <option value="<?=$prof['EmployeeId']?>"><?=$prof['Name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            <!-- Course Details -->
            <fieldset>
                <legend>Lab Information</legend>
                <!-- Day -->
                <div class="control-group">
                    <label class="control-label" for="lab-day">Day</label>
                    <div class="controls">
                        <label class="radio"><input type="radio" name="lab-day" value="monday"/>Monday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="tuesday"/>Tuesday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="wednesday"/>Wednesday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="thursday"/>Thursday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="friday"/>Friday</label>
                    </div>
                </div>
                <!-- Time -->
                <div class="control-group">
                    <label class="control-label" for="lab-time">Time</label>
                    <div class="controls">
                        <select name="lab-time">
                            <option value="0">-- Select Time --</option>
                            <?php for($time = 800; $time <= 1800; $time += 200): ?>
                            <option value="<?=$time?>"><?=time24_to_string($time)?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <!-- Room -->
                <div class="control-group">
                    <label class="control-label" for="lab-room">Room</label>
                    <div class="controls">
                        <select name="lab-room">
                            <option value="0">-- Select Room --</option>
                            <?php $rooms = admin_get_rooms(); foreach($rooms as $room): ?>
                            <option value="<?=$room['Id']?>"><?=$room['Number']?> - <?=$room['Type']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Lecture Information</legend>
                <!-- Day -->
                <div class="control-group">
                    <label class="control-label" for="lecture-day">Day</label>
                    <div class="controls">
                        <label class="radio"><input type="radio" name="lecture-day" value="monday"/>Monday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="tuesday"/>Tuesday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="wednesday"/>Wednesday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="thursday"/>Thursday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="friday"/>Friday</label>
                    </div>
                </div>
                <!-- Time -->
                <div class="control-group">
                    <label class="control-label" for="lecture-time">Time</label>
                    <div class="controls">
                        <select name="lecture-time">
                            <option value="0">-- Select Time --</option>
                            <?php for($time = 800; $time <= 1800; $time += 200): ?>
                            <option value="<?=$time?>"><?=time24_to_string($time)?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <!-- Room -->
                <div class="control-group">
                    <label class="control-label" for="lecture-room">Room</label>
                    <div class="controls">
                        <select name="lecture-room">
                            <option value="0">-- Select Room --</option>
                            <?php $rooms = admin_get_rooms(); foreach($rooms as $room): ?>
                            <option value="<?=$room['Id']?>"><?=$room['Number']?> - <?=$room['Type']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            <!-- Submit Button -->
            <div class="control-group">
                <div class="controls">
                    <button id="save-btn" type="submit" class="btn btn-primary" value="new-course">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
