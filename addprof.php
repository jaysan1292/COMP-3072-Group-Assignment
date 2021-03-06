<?php

include 'php/global.php';

function generate_password($length = 8) {
    $chars = '1234567890abcdefghjkmnpqrstuvwxyzACDEFGHJKLMNPQRSTUVWXYZ';

    $len = strlen($chars);

    if($length > $len) $length = $len;

    $i = 0; $pass = '';
    while($i < $length) {
        $char = substr($chars, rand(0, $len - 1), 1);
        if(!strstr($pass, $char)) {
            $pass .= $char;
            $i++;
        }
    }

    return $pass;
}

// Make sure we're an admin first
if(!is_admin_logged_in()) {
    http_response_code(401); // Unauthorized
    die;
}

// Make sure all of the parameters are set
if(!isset($_POST['first-name']) || empty($_POST['first-name']) ||
   !isset($_POST['last-name']) || empty($_POST['last-name']) ||
   !isset($_POST['department']) || empty($_POST['department'])) {
    $message = 'All fields are required.';
    ?>
    <form name="m" method="POST" action="admin.php">
        <input type="hidden" name="error-message" value="<?=$message?>" />
    </form>
    <script type="text/javascript">document.m.submit()</script>
    <?php
    die;
}

$params = array(
    'FirstName'      => ucwords($_POST['first-name']),
    'LastName'       => ucwords($_POST['last-name']),
    'UserType'       => 1,
    'DepartmentId'   => (int)$_POST['department'],
    'Password'       => generate_password(),
);

$db = DbProvider::openConnection();
// For some strange reason, beginTransaction() and commit() were preventing the queries
// from succeeding. No error messages, even the AUTO_INCREMENT ID column was incrementing
// as expected. But it never saved the actual data.
// $db->beginTransaction();
$cmd = $db->prepare('CALL CreateUser(?, ?, ?, ?, ?)');
$cmd->bindParam(1, $params['FirstName'],    PDO::PARAM_STR);
$cmd->bindParam(2, $params['LastName'],     PDO::PARAM_STR);
$cmd->bindParam(3, $params['UserType'],     PDO::PARAM_INT);
$cmd->bindParam(4, $params['DepartmentId'], PDO::PARAM_INT);
$cmd->bindParam(5, $params['Password'],     PDO::PARAM_STR);

$cmd->execute();
$newid = $cmd->fetch()['NewId'];
// $db->commit();

$message = "Successfully added new professor! New Employee ID is <strong>$newid</strong>, and their new password is <strong>$params[Password]</strong>.";

?>
<form name="m" method="POST" action="admin.php">
    <input type="hidden" name="message" value="<?=$message?>" />
</form>
<script type="text/javascript">document.m.submit()</script>
