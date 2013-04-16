<!-- Admin's Update Function -->

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
            <tr>
                <td><?=$request['Professor']?></td>
                <td><?=$request['Date']?></td>
                <td><?=$request['Reason']?></td>
                <td>
                    <?php
                    admin_init_timeoff_statuses();
                    global $timeoff_statuses;
                    ?>
                    <select class="input-medium">
                        <?php foreach($timeoff_statuses as $status): ?>
                        <option <?=$request['StatusId'] != $status['Id'] ? "" : "selected"?> value="<?=$status['Id']?>"><?=$status['Name']?></option>
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
