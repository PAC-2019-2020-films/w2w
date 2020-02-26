<?php
    global $user;
    checkAdmin();
    
    if (isset($_SESSION['emailVerified']) && !$_SESSION['emailVerified']) {
        \w2w\Utils\Utils::message($_SESSION['emailVerified'], '', 'Remember to validate your email adress. Click here to receive another confirmation email.');
    }


?>


<main class="container">
    <!--Galerie-->
    <section id="actionItems" class="user">
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
                <div>
                        <img src="../../assets/img/user_page/delete_on.png" style="width:100px" alt="delete" class="bottom">
                        <img src="../../assets/img/user_page/delete.png" style="width:100px" alt="delete" class="top" data-target="#modal-delete-account" data-toggle="modal">
                </div>
            </div>
            <div class="column">
                <div id="categoryActions" class="actionsIcons">
                    <img src="../../assets/img/user_page/categories_on.png" style="width:100px" alt="categories"
                         class="bottom">
                    <img src="../../assets/img/user_page/categories.png" style="width:100px" alt="categories"
                         class="top">
                </div>
            </div>
            <div class="column">
                <div id="tagActions" class="actionsIcons">
                    <img src="../../assets/img/user_page/tags_on.png" style="width:100px" alt="tags" class="bottom">
                    <img src="../../assets/img/user_page/tags.png" style="width:100px" alt="tags" class="top">
                </div>
            </div>
            <div class="column">
                <div id="movieActions" class="actionsIcons">
                    <img src="../../assets/img/user_page/movies_on.png" style="width:100px" alt="movies" class="bottom">
                    <img src="../../assets/img/user_page/movies.png" style="width:100px" alt="movies" class="top">
                </div>
            </div>
            <div class="column">
                <div id="userActions" class="actionsIcons">
                    <img src="../../assets/img/user_page/movies_on.png" style="width:100px" alt="movies" class="bottom">
                    <img src="../../assets/img/user_page/movies.png" style="width:100px" alt="movies" class="top">
                </div>
            </div>
        
        </div>
    </section>
    
    <!--End Galerie-->
    <div id="actions"></div>
    
    <div class="modal fade" id="modal-delete-account" tabindex="-1" role="dialog" aria-labelledby="modal-delete-account"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginlabel">Supprimer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <p>Etes-vous sur de vouloir supprimer votre compte? Cette action est irréversible!</p>
                    <a class="btn btn-primary" href="../account/delete_account.php?id=<?php echo escape($user->getId())?>">
                        oui</a>
                    <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> nah</button>
                </div>
            </div>
        </div>
    </div>
</main>
