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
<!--<form method="post" action="/login_action.php">-->
<!--    <input type="text" name="email" placeholder="email"/>-->
<!--    <input type="password" name="password" placeholder="password"/>-->
<!--   -->
<!--    <input type="submit" value="login"/>-->
<!--</form>-->

<div class="card bg-light"  id="formLoginRequire">
    <article class="card-body mx-auto" style="max-width: 400px;">
        <h4 class="card-title mt-3 text-center">Log in</h4>

        <form action="login_action.php" method="post">

            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="email" class="form-control" placeholder="email" type="email">
            </div>
            <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="password" class="form-control" placeholder="password" type="password">
            </div>
            <!-- form-group// -->
            <?php if (isset($token)){ ?> <input type="hidden" name="token" value="<?= $token ?>" <?php } ?>

            <!-- form-group// -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </div>


        </form>
        <div class="form-group">
            <button class="btn btn-primary btn-block" id="resetPasswordModTrigger">Forgot Password</button>
        </div>

    </article>
</div>
