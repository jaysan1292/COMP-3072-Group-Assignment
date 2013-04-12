<?php
require_once 'php/global.php';

function send_to_login_page($errmsg = '') {
    // Have a javascript form which will POST to the login page with the given error message.
    ?>
    <form name="_form" method="POST" action="<?=ROOT_DIR?>/index.php">
        <input type="hidden" name="errmsg" value="<?=$errmsg?>"/>
    </form>
    <script type="text/javascript">
        document._form.submit();
    </script>
    <?php
    die;
}

$user = $_POST['username'];
$pass = $_POST['password'];

// TODO: Set cookie to remember user login info
@$remember = (boolean) $_POST['remember'];

try {
    $auth = new Authenticator;
    $success = $auth->authenticateUser($user, $pass, $login);
} catch(PDOException $e) {
    send_to_login_page('Couldn\'t connect to authentication server. Please try again later.');
}

if($success) {
    session_start();
    session_regenerate_id(true);
    $_SESSION['current_user'] = $login;
    $_SESSION['logged_in'] = TRUE;

    if($login->isAdmin) {
        redirect_to_page(ADMIN_PAGE);
    } else {
        redirect_to_page(HOME_PAGE);
    }
} else {
    // TODO: I really don't like the fact that the message is sent in the query string... it's a little thing, but it's too easy for the user to modify :p

    // Redirect to login screen, with an error message
    send_to_login_page('Incorrect username or password.');
}
