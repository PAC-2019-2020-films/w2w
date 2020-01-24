<?php
checkUser();

if (isset($_SESSION['emailVerified'])){
    \w2w\Utils\Utils::message($_SESSION['emailVerified'], '', 'Remember to validate your email adress. Click here to receive another confirmation email.');
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
}
unset($_SESSION['message']);

?>
<h1>index partie compte utilisateur</h1>
