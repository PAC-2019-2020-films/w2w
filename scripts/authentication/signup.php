<?php



if (isset($_SESSION['user'])) {
//    TODO : SIgnal user he has to log out before potentialy creating a new account
    require 'logout_action.php';
//    header('location: ../account/index.php');
}


if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
}
unset($_SESSION['message']);

?>
<div class="container">
    <div class="mx-auto my-4 bg-light p-4" style="max-width: 400px;">
        <h4 class="">Rejoignez What2Whatch !</h4>
        <p>
            Créez-vous un compte gratuit et accédez à toutes les fonctionnalités de w2w !
        </p>
        <form action="signup_action.php" method="post">
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="userName" class="form-control" placeholder="Identifiant" type="text">
            </div>
            <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="firstName" class="form-control" placeholder="Prénom" type="text">
            </div>
            <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="lastName" class="form-control" placeholder="Nom" type="text">
            </div>
            <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                </div>
                <input name="email" class="form-control" placeholder="Email" type="email">
            </div>
            <!-- form-group// -->

            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input name="password" class="form-control" placeholder="Mot de passe" type="password">
            </div>
            <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input name="passwordConfirm" class="form-control" placeholder="Répéter le mot de passe" type="password">
            </div>
            <!-- form-group// -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Créer votre compte</button>
            </div>
            <!-- form-group// -->
            <p class="small text-right">Déjà un compte? <a class="text-secondary" href="login.php">Connectez-vous</a></p>
        </form>
    </div>
</div>
<!-- card.// -->

