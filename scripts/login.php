<?php
global $user;

if ($user != null) {
    echo "Déjà connecté.";
    return;
}

?>
<form method="post" action="/login_action.php">
    <input type="text" name="email" placeholder="email"/>
    <input type="password" name="password" placeholder="password"/>
    <input type="submit" value="login"/>
</form>
