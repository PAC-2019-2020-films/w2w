<?php
    checkUser();
    
    if (isset($_SESSION['emailVerified']) && !$_SESSION['emailVerified']) {
        \w2w\Utils\Utils::message($_SESSION['emailVerified'], '', 'Remember to validate your email adress. Click <a href="http://w2w.localhost/authentication/generate_validation_mail.php">here</a> to receive another confirmation email.');
    }
    
    if (isset($_SESSION['message'])) {

        echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
    }
    unset($_SESSION['message']);

?>


<main class="container">
    <!--Galerie-->
    <section id="galerie" class="user">
        <div class="row">
            <div class="col-md-12">
                <h3>Dashboard</h3>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <a href="profile.php">
                    <img src="../../assets/img/user_page/profile_on.png" style="width:100px" alt="profile" class="bottom">
                    <img src="../../assets/img/user_page/profile.png" style="width:100px" alt="profile" class="top">
                </a>
            </div>
            <div class="column">
                <a href="review_list.php">
                    <img src="../../assets/img/user_page/reviews_on.png" style="width:100px" alt="reviews" class="bottom">
                    <img src="../../assets/img/user_page/reviews.png" style="width:100px" alt="reviews" class="top">
                </a>
            </div>
            <div class="column">
                <a href="delete_account.php">
                    <img src="../../assets/img/user_page/delete_on.png" style="width:100px" alt="delete" class="bottom">
                    <img src="../../assets/img/user_page/delete.png" style="width:100px" alt="delete" class="top">
                </a>
            </div>
           
            <div class="col-md-12 padding"></div>
        </div>
    </section>
    <!--End Galerie-->
</main>