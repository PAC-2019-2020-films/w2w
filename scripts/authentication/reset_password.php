<?php


global $user;
/*
 * Logs out the user if connected and displays to login page with the account email validation token attached in order to validate the account
 */

if ($user) {
    require "logout_action.php";
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
}
unset($_SESSION['message']);

// Get the token
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    header("location:" . 'homepage.php');
}


?>

<div class="container mt-5 mb-5">
    <form method="post" action="reset_password_action.php">
        <div class="form-group">
            <label for="password">Choose a new password</label>
            <input type="password" class="form-control" id="password" aria-describedby="password"
                   placeholder="Choose a new password" name="password">
        </div>
        <div class="form-group">
            <label for="passwordConfirm">Confirm your password</label>
            <input type="password" class="form-control" id="passwordConfirm" aria-describedby="passwordConfirm"
                   placeholder="Confirm your password" name="passwordConfirm">
        </div>
        <input type="hidden" name="token" value="<?= $token ?>">

        <button type="submit" class="btn btn-primary">Reset My Password</button>
        <a href="http://w2w.localhost/" type="button" class="btn btn-secondary"> Cancel</a>
    </form>
</div>