<?php
require_once 'php/global.php';

// Make sure we're logged in
session_start();
if(!isset($_SESSION['current_user'])) {
    http_response_code(401); // Unauthorized
    die;
}

if(!isset($_POST['timeoff-start']) ||
   !isset($_POST['timeoff-end']) ||
   !isset($_POST['timeoff-reason'])) {
    http_response_code(400); // Bad Request
    die;
}

$params = array(
    'UserId'     => $_SESSION['current_user']->id,
    'StartDate'  => strtotime($_POST['timeoff-start']),
    'FinishDate' => strtotime($_POST['timeoff-end']),
    'Reason'     => $_POST['timeoff-reason'],
);

// func_die($params);

$db = DbProvider::openConnection();
$db->beginTransaction();

$cmd = $db->prepare('CALL CreateTimeOffRequest(?, FROM_UNIXTIME(?), FROM_UNIXTIME(?), ?)');
$cmd->bindParam(1, $params['UserId']);
$cmd->bindParam(2, $params['StartDate']);
$cmd->bindParam(3, $params['FinishDate']);
$cmd->bindParam(4, $params['Reason']);

$cmd->execute();

$db->commit();

$message = 'Successfully sent time-off request!';

?>
<form name="m" method="POST" action="professor.php">
    <input type="hidden" name="message" value="<?=$message?>" />
</form>
<script type="text/javascript">document.m.submit()</script>
