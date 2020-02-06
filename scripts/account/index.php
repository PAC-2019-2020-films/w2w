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
<main class="container">
    <!--Galerie-->
    <section id="galerie">
        <div class="row">
            <div class="col-md-12">
                <h3>Utilisateur</h3>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <img src="../../assets/img/user_page/reviews.png" style="width:75%" alt="reviews">
                <img src="../../assets/img/user_page/movies.png" style="width:75%" alt="movies">
                <img src="assets/img/user_page/Galerie3.jpeg" style="width:100%" alt="galerie03">
            </div>
            <div class="column">
                <img src="../../assets/img/user_page/profile.png" style="width:75%" alt="profile">
                <img src="../../assets/img/user_page/categories.png" style="width:75%" alt="categories">
                <img src="assets/img/user_page/Galerie7.jpeg" style="width:100%" alt="galerie07">
            </div>
            <div class="column">
                <img src="../../assets/img/user_page/delete.png" style="width:75%" alt="delete">
                <img src="../../assets/img/user_page/tags.png" style="width:75%" alt="tags">
                <img src="assets/img/user_page/Galerie11.jpeg" style="width:100%" alt="galerie11">

            </div>
            <div class="col-md-12 padding"></div>
        </div>
    </section>
    <!--End Galerie-->
</main>