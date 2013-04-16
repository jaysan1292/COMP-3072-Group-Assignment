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
<h4>Open Requests</h4>

<form class="form-inline" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Professor</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Date Requested</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php /* See aProfessor.php and aClasses.php */ ?>
            <?php admin_init_timeoff_request(); global $requests; foreach($requests as $request): if(admin_timeoff_status_open($request)): ?>
            <tr <?=status_color($request['StatusId'])?>>
                <td><?=$request['Professor']?></td>
                <td><?=$request['Date']?></td>
                <td><?=$request['Reason']?></td>
                <td><?=$request['DateRequested']?></td>
                <td>
                    <?php
                    admin_init_timeoff_statuses();
                    global $timeoff_statuses;
                    ?>
                    <select class="input-medium" name="request-<?=$request['TimeOffId']?>">
                        <?php foreach($timeoff_statuses as $status): ?>
                        <option <?=$request['StatusId'] != $status['Id'] ? "" : "selected"?> value="<?=$status['Id']?>"><?=$status['Name']?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php else: ?>
            <?php $closed_requests[] = $request; ?>
            <?php endif; endforeach; ?>
        </tbody>
    </table>
    <button id="save-btn" class="btn btn-primary" type="submit">Update Changes</button>
</form>
<h4>Closed Requests</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Professor</th>
            <th>Date</th>
            <th>Reason</th>
            <th>Date Requested</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($closed_requests as $request): ?>
        <tr <?=status_color($request['StatusId'])?>>
            <td><?=$request['Professor']?></td>
            <td><?=$request['Date']?></td>
            <td><?=$request['Reason']?></td>
            <td><?=$request['DateRequested']?></td>
            <td><?=$request['Status']?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
