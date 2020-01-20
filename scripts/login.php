<?php
global $user;

if ($user != null) {
    echo "Déjà connecté.";
    return;
}


if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
}
unset($_SESSION['message']);


?>
<form method="post" action="/login_action.php">
    <input type="text" name="email" placeholder="email"/>
    <input type="password" name="password" placeholder="password"/>
   <?php if (isset($token)){ ?> <input type="hidden" name="token" value="<?= $token ?>" <?php } ?> >
    <input type="submit" value="login"/>
</form>
