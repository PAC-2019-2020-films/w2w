




<?php
    checkAdmin();
    
    if (isset($_SESSION['emailVerified'])) {
        \w2w\Utils\Utils::message($_SESSION['emailVerified'], '', 'Remember to validate your email adress. Click here to receive another confirmation email.');
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
            <div class="column">
                <a href="category-list.php">
                    <img src="../../assets/img/user_page/categories_on.png" style="width:100px" alt="categories" class="bottom">
                    <img src="../../assets/img/user_page/categories.png" style="width:100px" alt="categories" class="top">
                </a>
            </div>
            <div class="column">
                <a href="tag-list.php"></a>
                <img src="../../assets/img/user_page/tags_on.png" style="width:100px" alt="tags" class="bottom">
                <img src="../../assets/img/user_page/tags.png" style="width:100px" alt="tags" class="top">
            </div>
            <div class="column">
                <a href="movie-list.php">
                    <img src="../../assets/img/user_page/movies_on.png" style="width:100px" alt="movies" class="bottom">
                    <img src="../../assets/img/user_page/movies.png" style="width:100px" alt="movies" class="top">
                </a>
            </div>
            <li><a href="/admin/user-list.php">Liste des utilisateurs</a></li>
            <div class="col-md-12 padding"></div>
        </div>
    </section>
    <!--End Galerie-->
</main>