<?php $user = $_SESSION['current_user']; ?>
<div id="profile" class="row-fluid">
    <div class="span12">
        <div class="widget no-margin">
            <div class="widget-body">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span3">
                            <div class="thumbnail">
                                <img alt="300x200" src="img/hero-image.jpg">
                                <div class="caption">
                                    <span class="name"> <?=$_SESSION['current_user'] ?> </span> <br>
                                    <span class="e_id"> <?="Employee " . $user->id?> </span>
                                </div>
                            </div>
                        </div>
                        <div class="span9">
                            <?php if(!is_post_var_empty('message')): ?>
                            <div class="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?=$_POST['message']?>
                            </div>
                            <?php endif; ?>
                            <form id="timeoff-form" action="request.php" method="POST">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="40%">Request a Time-Off/Vacation</td>
                                            <td>
                                                <style type="text/css">
                                                /* Yup. CSS block in the middle of a form. See if I give a shit. */
                                                .req-form-label { width:50px !important; }
                                                </style>
                                                <div class="input-append input-prepend date" id="timeoff-start">
                                                    <span class="add-on req-form-label">From: </span>
                                                    <input class="input-xlarge" name="timeoff-start" type="text"/>
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                </div>
                                                <div class="input-append input-prepend date" id="timeoff-end">
                                                    <span class="add-on req-form-label">To: </span>
                                                    <input class="input-xlarge" name="timeoff-end" type="text"/>
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                </div>
                                                <div class="input-prepend" id="timeoff-reason">
                                                    <span class="add-on req-form-label">Reason: </span>
                                                    <input class="input-xlarge" name="timeoff-reason" type="text" style="width:296px;" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input class="btn btn-success pull-right" type="submit" value="Send Request"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <form class="form-inline">
                                <table id="user" class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="40%">Contact Number:</td>
                                            <td>
                                                <div class="input-prepend">
                                                    <span class="add-on">#</span>
                                                    <input id="contact-number"
                                                           class="input-xlarge"
                                                           name="contact-number"
                                                           type="text"
                                                           placeholder="Phone Number"
                                                           value="<?=$user->contact?>" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>E-mail Address:</td>
                                            <td>
                                                <div class="input-prepend">
                                                    <span class="add-on"><i class="icon-envelope"></i></span>
                                                    <input id="email"
                                                           class="input-xlarge"
                                                           name="email"
                                                           type="text"
                                                           placeholder="Email"
                                                           value="<?=$user->email?>" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Department:</td>
                                            <td>
                                                <?=professor_get_current_department()['Name']?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Courses:</td>
                                            <?php
                                            professor_init_courses();
                                            global $professor_courses;
                                            $used = array();
                                            ?>
                                            <td>
                                                <?php if(professor_has_courses()): ?>
                                                <ul class="unstyled">
                                                    <?php foreach($professor_courses as $course): if(!in_array($course['CourseCode'], $used)): ?>
                                                    <li><?="$course[CourseCode]: $course[CourseDescription]"?></li>
                                                    <?php $used[] = $course['CourseCode']; endif; endforeach; ?>
                                                </ul>
                                                <?php else: ?>
                                                You are not assigned to any courses yet.
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <button id="save-btn" class="btn btn-primary pull-right" type="submit" name="profile">Save changes</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function($) {
    var tmp = new Date();
    var now = new Date(tmp.getFullYear(), tmp.getMonth(), tmp.getDate(), 0, 0, 0, 0);

    var tfStart = $('#timeoff-start input').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(e) {
        if(e.date.valueOf() > tfEnd.date.valueOf()) {
            console.log(e.date.valueOf() > tfEnd.date.valueOf());
            var newdate = new Date(e.date);
            newdate.setDate(newdate.getDate() + 1);
            tfEnd.setValue(newdate);
        }
        tfStart.hide();
        $('#timeoff-end input')[0].focus();
    }).data('datepicker');
    var tfEnd = $('#timeoff-end input').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date.valueOf() <= tfStart.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(e) {
        tfEnd.hide();
        $('#timeoff-reason input').focus();
    }).data('datepicker');
});
</script>
