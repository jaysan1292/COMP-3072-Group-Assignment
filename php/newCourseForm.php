<?php
if(!is_post_var_empty('course-code')) {
    ?><script type="text/javascript">$('#admin-nav a[href="#aClasses"]').tab('show')</script><?php
}
?>

<div class="row">
    <div class="span6 offset2">
        <form class="form-horizontal" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <fieldset>
                <legend>Add New Course</legend>
            </fieldset>
        </form>
    </div>
</div>
