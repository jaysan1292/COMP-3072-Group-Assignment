<!-- Admin's Update Function -->
<?php
function status_color($status = 1) {
    switch($status) {
        case 1: return '';
        case 2: return 'class="success"';
        case 3: return 'class="error"';
    }
}
?>
<h4>Requests Status</h4>

<form class="form-inline">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Professor</th>
                <th>Date(s)</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php /* See aProfessor.php and aClasses.php */ ?>
            <?php admin_init_timeoff_request(); global $requests; foreach($requests as $request): ?>
            <tr <?=status_color($request['StatusId'])?>>
                <td><?=$request['Professor']?></td>
                <td><?=$request['Date']?></td>
                <td><?=$request['Reason']?></td>
                <td>
                    <?php
                    admin_init_timeoff_statuses();
                    global $timeoff_statuses;
                    ?>
                    <?php if(admin_timeoff_status_open($request)): ?>
                    <select class="input-medium" name="professor-<?=$request['Id']?>-status">
                        <?php foreach($timeoff_statuses as $status): ?>
                        <option <?=$request['StatusId'] != $status['Id'] ? "" : "selected"?> value="<?=$status['Id']?>"><?=$status['Name']?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php else: ?>
                    <?=$request['Status']?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <button id="save-btn" class="btn btn-primary">Update Changes</button>
    </div>
</form>
