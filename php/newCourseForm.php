<?php
// The form values are filled using either the value attribute or with Javascript if necessary using
// this array. If there is a problem with the data, this array is filled with the values sent via
// $_POST and then the form is re-populated with the data that was sent
$form_defaults = array (
  'course-code'  => '',
  'course-name'  => '',
  'crn'          => '',
  'professor'    => '0',
  'lab-day'      => '',
  'lab-time'     => '0',
  'lab-room'     => '0',
  'lecture-day'  => '',
  'lecture-time' => '0',
  'lecture-room' => '0',
  'new-course'   => '', // array_combine requires the same number of elements
);

if(isset($_POST['new-course'])) {
    // Show the page we're on currently if this is a POST
    ?>
    <script type="text/javascript">
    $('#admin-nav a[href="#aClasses"]').tab('show');
    $('#class-nav a[href="#class-new"]').tab('show');
    </script>
    <?php

    function check_room_available($roomid, $day, $time) {
        $rooms = admin_get_room_classes($roomid);
        $day = day_string_to_db($day);

        // For each class in the given room
        foreach($rooms as $room) {
            // If it takes place on the same day at the same time
            if(intval($day) == intval($room['Day']) && intval($time) == intval($room['StartTime'])) {
                // It's taken
                return false;
            }
        }
        // It's not taken
        return true;
    }

    function run_check() {
        // Bring these variables into scope
        global $form_defaults, $general_message, $lab_message, $lecture_message;

        // Check if all of our fields have been filled out
        if(!is_post_var_empty('course-code') && !is_post_var_empty('course-name') &&
           !is_post_var_empty('crn') && !is_post_var_empty('professor') &&
           !is_post_var_empty('lab-day') && !is_post_var_empty('lab-time') &&
           !is_post_var_empty('lab-room') && !is_post_var_empty('lecture-day') &&
           !is_post_var_empty('lecture-time') && !is_post_var_empty('lecture-room')) {
            $valid = true;

            // Validate the course code
            if(!preg_match('/[A-Z]{4}[0-9]{4}/', $_POST['course-code'])) {
                $valid = false;
                $general_message = 'Course code must follow the pattern ABCD1234.';
            }

            // Validate CRN
            if(!preg_match('/[0-9]{5}/', $_POST['crn'])) {
                $valid = false;
                // $general_message may have been set before, in which case we should append our error message to it.
                $msg = 'CRN must be 5 digits, and contain only numeric characters.';
                if(isset($general_message)) {
                    $general_message = "$general_message<br>$msg";
                } else {
                    $general_message = $msg;

                }
            }

            // Check if the lab classroom is available
            if(!check_room_available($_POST['lab-room'], $_POST['lab-day'], $_POST['lab-time'])) {
                $lab_message = 'Sorry, that room is already taken on that day and time.';
                $valid = false;
            }

            // Check if the lecture classroom is available
            if(!check_room_available($_POST['lecture-room'], $_POST['lecture-day'], $_POST['lecture-time'])) {
                $lecture_message = 'Sorry, that room is already taken on that day and time.';
                $valid = false;
            }

            // If the form is not valid, replace the values in $form_defaults with the values in $_POST.
            if(!$valid) $form_defaults = array_combine(array_keys($form_defaults), array_values($_POST));
            return $valid;
        } else {
            // The number of values in $_POST probably won't match the number of values in
            // $form_defaults (and therefore won't work), so use array_walk instead.
            array_walk($form_defaults, function(&$value, $key) {
                @$value = $_POST[$key];
            });
            $general_message = 'All fields are required.';
            return false;
        }
    }

    if(run_check()) {
        // Hey, the form checked out alright! Let's add it to the database.
    }
}
?>
<div class="row">
    <div class="span6 offset2">
        <form class="form-horizontal" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <fieldset>
                <legend>General</legend>
                <?php if(isset($general_message)): ?>
                <div class="alert alert-error" id="general-message">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$general_message?>
                </div>
                <?php endif; ?>
                <!-- Course Code -->
                <div class="control-group">
                    <label class="control-label" for="course-code">Course Code</label>
                    <div class="controls">
                        <input type="text" name="course-code" placeholder="Course Code" value="<?=$form_defaults['course-code']?>"/>
                    </div>
                </div>
                <!-- Course Name -->
                <div class="control-group">
                    <label class="control-label" for="course-name">Course Name</label>
                    <div class="controls">
                        <input type="text" name="course-name" placeholder="Course Name" value="<?=$form_defaults['course-name']?>"/>
                    </div>
                </div>
                <!-- CRN -->
                <div class="control-group">
                    <label class="control-label" for="crn">CRN</label>
                    <div class="controls">
                        <input type="text" name="crn" placeholder="CRN" value="<?=$form_defaults['crn']?>"/>
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
                        <script type="text/javascript">$('select[name=professor]').val('<?=$form_defaults['professor']?>')</script>
                    </div>
                </div>
            </fieldset>
            <!-- Course Details -->
            <fieldset>
                <legend>Lab Information</legend>
                <?php if(isset($lab_message)): ?>
                <div class="alert alert-error" id="lab-message">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$lab_message?>
                </div>
                <?php endif; ?>
                <!-- Day -->
                <div class="control-group">
                    <label class="control-label" for="lab-day">Day</label>
                    <div class="controls">
                        <label class="radio"><input type="radio" name="lab-day" value="monday"/>Monday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="tuesday"/>Tuesday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="wednesday"/>Wednesday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="thursday"/>Thursday</label>
                        <label class="radio"><input type="radio" name="lab-day" value="friday"/>Friday</label>
                        <script type="text/javascript">$('input[name=lab-day][value=<?=$form_defaults['lab-day']?>]').prop('checked',true);</script>
                    </div>
                </div>
                <!-- Time -->
                <div class="control-group">
                    <label class="control-label" for="lab-time">Time</label>
                    <div class="controls">
                        <select name="lab-time">
                            <option value="0">-- Select Time --</option>
                            <?php for($time = 800; $time <= 1800; $time += 200): ?>
                            <option value="<?=$time?>"><?=time24_to_string($time)?> to <?=time24_to_string($time + 200)?></option>
                            <?php endfor; ?>
                        </select>
                        <script type="text/javascript">$('select[name=lab-time]').val('<?=$form_defaults['lab-time']?>')</script>
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
                        <script type="text/javascript">$('select[name=lab-room]').val('<?=$form_defaults['lab-room']?>')</script>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Lecture Information</legend>
                <?php if(isset($lecture_message)): ?>
                <div class="alert alert-error" id="lecture-message">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?=$lecture_message?>
                </div>
                <?php endif; ?>
                <!-- Day -->
                <div class="control-group">
                    <label class="control-label" for="lecture-day">Day</label>
                    <div class="controls">
                        <label class="radio"><input type="radio" name="lecture-day" value="monday"/>Monday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="tuesday"/>Tuesday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="wednesday"/>Wednesday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="thursday"/>Thursday</label>
                        <label class="radio"><input type="radio" name="lecture-day" value="friday"/>Friday</label>
                        <script type="text/javascript">$('input[name=lecture-day][value=<?=$form_defaults['lecture-day']?>]').prop('checked',true);</script>
                    </div>
                </div>
                <!-- Time -->
                <div class="control-group">
                    <label class="control-label" for="lecture-time">Time</label>
                    <div class="controls">
                        <select name="lecture-time">
                            <option value="0">-- Select Time --</option>
                            <?php for($time = 800; $time <= 1800; $time += 200): ?>
                            <option value="<?=$time?>"><?=time24_to_string($time)?> to <?=time24_to_string($time + 200)?></option>
                            <?php endfor; ?>
                        </select>
                        <script type="text/javascript">$('select[name=lecture-time]').val('<?=$form_defaults['lecture-time']?>')</script>
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
                        <script type="text/javascript">$('select[name=lecture-room]').val('<?=$form_defaults['lecture-room']?>')</script>
                    </div>
                </div>
            </fieldset>
            <!-- Submit Button -->
            <div class="control-group">
                <div class="controls">
                    <button id="save-btn" type="submit" class="btn btn-primary" name="new-course">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
