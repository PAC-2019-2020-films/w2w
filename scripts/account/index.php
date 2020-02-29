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
            <div class="col-md-12">
                <h3>Dashboard</h3>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <div id="profileActions" class="actionIcons">
                    <img src="../../assets/img/user_page/profile_on.png" style="width:100px" alt="profile"
                         class="bottom">
                    <img src="../../assets/img/user_page/profile.png" style="width:100px" alt="profile" class="top">
                </div>
            </div>
            <div class="column">
                <div id="reviewActions" class="actionIcons">
                    <img src="../../assets/img/user_page/reviews_on.png" style="width:100px" alt="reviews"
                         class="bottom">
                    <img src="../../assets/img/user_page/reviews.png" style="width:100px" alt="reviews" class="top">
                </div>
            </div>
            <div class="column">
                <a href="#" data-target="#modal-delete-account" data-toggle="modal">
                    <img src="../../assets/img/user_page/delete_on.png" style="width:100px" alt="delete" class="bottom">
                    <img src="../../assets/img/user_page/delete.png" style="width:100px" alt="delete" class="top">
                </a>
            </div>
            
            <div class="col-md-12 padding"></div>
        </div>
    </section>
    <!-- END DASHBOARD -->
    <!--    DASHBOARD CONTENT -->
    <div id="actions"></div>
    <!--    END DASHBOARD CONTENT -->
    
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