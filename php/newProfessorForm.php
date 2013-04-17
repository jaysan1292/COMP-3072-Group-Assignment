<div class="row-fluid">
    <div class="span6 offset3">
        <?php if(!is_post_var_empty('error-message')): ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?=$_POST['error-message']?>
        </div>
        <script type="text/javascript">
            $('#admin-nav a[href="#aProfessor"]').tab('show');
            $('#professor-nav a[href="#professor-new"]').tab('show');
        </script>
        <?php endif; ?>
        <form class="form-horizontal" method="POST" action="addprof.php">
            <fieldset>
                <legend>Add New Professor</legend>
                <!-- First Name -->
                <div class="control-group">
                    <label class="control-label" for="first-name">First Name</label>
                    <div class="controls">
                        <input type="text" name="first-name" placeholder="First Name"/>
                    </div>
                </div>
                <!-- Last Name -->
                <div class="control-group">
                    <label class="control-label" for="last-name">Last Name</label>
                    <div class="controls">
                        <input type="text" name="last-name" placeholder="Last Name" />
                    </div>
                </div>
                <!-- Department -->
                <div class="control-group">
                    <label class="control-label" for="department">Department</label>
                    <div class="controls">
                        <select name="department">
                            <?php admin_init_departments(); global $departments; foreach($departments as $dept): ?>
                            <option value="<?=$dept['Id']?>"><?=$dept['Name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="control-group">
                    <div class="controls">
                        <button id="save-btn" type="submit" class="btn btn-primary" name="new-user">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
