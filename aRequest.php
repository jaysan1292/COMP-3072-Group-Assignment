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
<div class="center subnav">
    <ul class="nav nav-pills" id="request-nav">
        <li class="active"><a data-toggle="tab" href="#request-open">Open Requests</a></li>
        <li><a data-toggle="tab" href="#request-closed">Closed Requests</a></li>
    </ul>
</div>

<section class="tab-content">
    <article class="tab-pane active" id="request-open">
        <?php $matches = array_get_matches($_POST, '/^request-/'); ?>

        <?php if(count($matches) > 0):
            // We are now processing a POST request from this page
            $values = array();
            foreach ($matches as $key => $value) {
                sscanf($key, 'request-%d', $k);
                $values[$k] = $value;
            }

            $db = DbProvider::openConnection();
            $db->beginTransaction();

            foreach ($values as $key => $value) {
                $cmd = $db->prepare('CALL AdminUpdateTimeOffStatus(?, ?)');
                $cmd->bindParam(1, $key);
                $cmd->bindParam(2, $value);
                $cmd->execute();
            }

            $db->commit();
        ?>
        <div class="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Time-off requests updated successfully!
        </div>
        <script type="text/javascript">
            $('#admin-nav a[href="#aRequest"]').tab('show');
            setTimeout(function(){$('.alert').alert('close')}, 2500);
        </script>
        <?php endif; ?>
        <?php if(admin_has_open_requests()): $requests = admin_get_open_requests(); ?>
        <form class="form-inline" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <div class="generic-list">
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
                        <?php foreach($requests as $request): ?>
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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button id="save-btn" class="btn btn-primary" type="submit">Update Changes</button>
        </form>
        <?php else: ?>
        You have no open time-off requests.
        <?php endif; ?>
    </article>
    <article class="tab-pane" id="request-closed">
        <?php if(admin_has_closed_requests()): $closed_requests = admin_get_closed_requests(); ?>
        <div class="generic-list">
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
        </div>
        <?php else: ?>
        You have no closed time-off requests.
        <?php endif; ?>
    </article>
</section>
