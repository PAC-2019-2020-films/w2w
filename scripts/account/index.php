<?php
    //    Ensure that a user is logged in
    global $user;
    checkUser();
    
    //    Set a flashbag message regarding the verified status of the account if necessary
    if (isset($_SESSION['emailVerified']) && !$_SESSION['emailVerified']) {
        \w2w\Utils\Utils::message($_SESSION['emailVerified'], '', 'Remember to validate your email adress. Click <a href="http://w2w.localhost/authentication/generate_validation_mail.php">here</a> to receive another confirmation email.');
    }
    
    //    Display flashbag message
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
    }
    unset($_SESSION['message']);

?>


<main class="container">
    <!-- DASHBOARD -->
    <section id="galerie" class="user">
        <div class="row">
            <div class="col-lg-4 dark-bg">
                <ul class="list-unstyled mt-4">
                    <li class="py-3">
                        <a href="#"  id="profileActions">
                            <i class="fas fa-user"></i> Mon profil
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  id="reviewActions">
                            <i class="fas fa-pen-square"></i> Mes reviews
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  data-target="#modal-delete-account" data-toggle="modal">
                            <i class="fas fa-times-circle"></i> Supprimer mon compte
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-8 light-bg py-4 px-5">
                <h2 class="h4">Mon compte</h2>
                <span class="line-title"><hr/></span>

                <!--    DASHBOARD CONTENT -->
                <div id="actions">

                    <ul class="list-unstyled">
                        <li>
                            Compte créé le : <?= $user->getCreatedAt()->format("Y-m-d") ?>
                        </li>
                        <li>
                            Nombre de critiques publiées : <?= $user->getNumberReviews() ?>
                        </li>
                    </ul>


                </div>
                <!--    END DASHBOARD CONTENT -->
            </div>
        </div>

    </section>
    <!-- END DASHBOARD -->

    
    <!-- *************** MODAL DELETE ACCOUNT *************** -->
    <div class="modal fade" id="modal-delete-account" tabindex="-1" role="dialog" aria-labelledby="modal-delete-account"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supprimer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Etes-vous sur de vouloir supprimer votre compte? Cette action est irréversible!</p>
                    <a class="btn btn-primary" href="delete_account.php?id=<?php echo escape($user->getId()) ?>">
                        oui </a>
                    <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> nah</button>
                </div>
            </div>
        </div>
    </div>
    <!-- *************** END MODAL DELETE ACCOUNT *************** -->


</main>