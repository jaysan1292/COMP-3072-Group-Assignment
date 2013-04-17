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
        <?php if(professor_has_open_requests()): $requests = professor_get_open_requests(); ?>
        <div class="generic-list">
            <table class="table table-striped">
                <thead>
                    <tr>
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
        You have no open time-off requests.
        <?php endif; ?>
    </article>
    <article class="tab-pane" id="request-closed">
        <?php if(professor_has_closed_requests()): $closed_requests = professor_get_closed_requests(); ?>
        <div class="generic-list">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($closed_requests as $request): ?>
                    <tr <?=status_color($request['StatusId'])?>>
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
