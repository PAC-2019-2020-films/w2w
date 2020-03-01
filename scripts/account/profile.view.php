<h1 class="small text-uppercase">Dashboard</h1>
<h2 class="h4 font-weight-normal">Modifier mon profil</h2>
<div class="bg-white p-4">


    <!-- *************** FLASHBAG *************** -->
    <div class="flashBag">
        <?php
        \w2w\Utils\Utils::echoMessage();
        ?>
    </div>
    <!-- *************** END FLASHBAG *************** -->

    <!-- *************** UPDATE PROFILE FORM *************** -->
    <form action="profile-update.php" method="post" id="profileForm">
        <div class="form-group row">
            <div class="col-lg-3">
                <label for="username" class=""> Mon nom d'utilisateur : </label>
            </div>
            <div class="col-lg-9">
                <input name="username" class="form-control" placeholder="Username" type="text" id="username"
                       value="<?= $user->getUserName() ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-3">
                <label for="email"> Mon email : </label>
            </div>
            <div class="col-lg-9">
                <input name="email" class="form-control" placeholder="Email" type="email" id="email"
                       value="<?= $user->getEmail() ?>">
            </div>
        </div>


        <div class="form-group row">
            <div class="col-lg-3">
                <label for="firstName"> Mon nom : </label>
            </div>
            <div class="col-lg-9">
                <input name="firstName" class="form-control" placeholder="mon nom" type="text" id="firstName"
                       value="<?= $user->getFirstName() ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-3">
                <label for="lastName"> Mon prenom : </label>
            </div>
            <div class="col-lg-9">
                <input name="lastName" class="form-control" placeholder="mon prénom" type="text" id="lastName"
                       value="<?= $user->getLastName() ?>">
            </div>
        </div>

        <div class="form-group">

            <label> Compte créé le : <?= $user->getCreatedAt()->format("Y-m-d") ?> </label>
        </div>

        <div class="form-group">
            <label> Nombre de critiques publiées : <?= $user->getNumberReviews() ?>  </label>
        </div>


        <div class="form-group text-right">
            <input type="submit" class="btn btn-primary" value="Mettre à jour mes informations"/>
        </div>
    </form>
    <!-- *************** END UPDATE PROFILE FORM *************** -->
    <hr/>
    <!-- *************** UPDATE PASSWORD FORM *************** -->
    <h4 class="h6 font-weight-normal my-4">Modifier mon mot de passe</h4>

    <form action="password-update.php" method="post">
        <div class="form-group">
            <input type="password" placeholder="nouveau mot de passe" class="form-control" name="newPassword"/>
        </div>
        <div class="form-group">
            <input type="password" placeholder="confirmer nouveau mot de passe" class="form-control"
                   name="newPasswordConfirm"/>
        </div>

        <div class="form-group">
            <input type="password" placeholder="Entrez votre mot de passe actuel" class="form-control" name="password"/>
        </div>

        <div class="form-group text-right">
            <input type="submit" class="btn btn-primary" value="Modifier mon mot de passe"/>
        </div>
    </form>
    <!-- *************** END UPDATE PASSWORD FORM *************** -->


</div>