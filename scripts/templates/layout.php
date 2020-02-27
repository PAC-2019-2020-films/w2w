<?php
/*
 * layout général, par défaut, du site
 */

global $user;

$headTitle = isset($headTitle) ? $headTitle : "W2W - What are you gonna watch now ?!";
?>

<!doctype html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo escape($headTitle); ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/multi.min.css">
    <!-- Custom styles for this template -->
    <link href="/assets/css/carousel.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <script src="https://kit.fontawesome.com/ea5ad52db7.js" crossorigin="anonymous"></script>
    <!--    FA local fallback-->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <script src="https://cdn.ckeditor.com/4.13.1/basic/ckeditor.js"></script>


</head>
<body>
<header>
    <noscript>
        <style>
            .noscriptext {
                background: black;
                color: white;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
        <div class="noscriptext"><h1>Javascript is disabled in your browser. You might need it.</h1></div>
    </noscript>
    <!-- Menu -->
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg site-header">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarW2W"
                    aria-controls="navbarW2W" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div id="logo">
                <a class="navbar-brand" href="/">
                    <img alt="logo" src="/assets/img/logo-w2w.svg">
                    w<span>2</span>w
                </a>
            </div>


            <div class="collapse navbar-collapse" id="navbarW2W">
                <ul class="nav navbar-nav ">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Accueil <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMovies" data-toggle="dropdown"
                           aria-expanded="false">Films</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMovies">
                            <a class="dropdown-item" href="/movies.php">Tous les films</a>
                            <a class="dropdown-item" href="/categories.php">Par catégories</a>
                            <a class="dropdown-item" href="/tags.php">Par tags</a>
                            <a class="dropdown-item" href="/ratings.php">Par note</a>
                            <a class="dropdown-item" href="/movies.php">(Films les mieux notés)</a>
                            <a class="dropdown-item" href="/movies.php">(Films les plus populaires)</a>
                        </div>
                    </li>
                    <?php if (false) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownCategories" data-toggle="dropdown"
                           aria-expanded="false">Par catégorie</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownCategories">
                            <a class="dropdown-item" href="/movies.php">Tous les films</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownTags" data-toggle="dropdown"
                           aria-expanded="false">Par genre</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownTags">
                            <a class="dropdown-item" href="/movies.php">Tous les films</a>
                        </div>
                    </li>
                    <?php endif; ?>

                </ul>
            </div>

            <form class="search-form form-inline" action="/movies.php" method="get">
                <input name="keywords" class="form-control" type="text" placeholder="Rechercher un film..." aria-label="Search">
                <button type="submit" class="search-submit">
                    <i class="fas fa-search"></i> <span class="screen-reader-text">Search</span></button>
            </form>

            <?php if (isset($user) && $user instanceof \w2w\Model\User) : ?>
                <div class="collapse navbar-collapse" id="navbarW2W">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                               aria-expanded="false"><i class="fas fa-user-circle fa-2x"></i> <span
                                        class="user-account_name"> <?php echo escape($user->getUserName()); ?></span></a>
                            <div class="dropdown-menu">

                                <?php if ($user->isAdmin()) : ?>
                                    <a class="dropdown-item" href="/admin/">Dashboard</a>
                                <?php else: ?>
                                    <?php if ($user->isRoot()) : ?>
                                        <a class="dropdown-item" href="/root/">[root]</a>
                                    <?php else: ?>
                                        <a class="dropdown-item" href="/account/index.php">Mon compte</a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <a class="dropdown-item" href="../authentication/logout_action.php">Se
                                    déconnecter</a>
                            </div>
                        </li>

                    </ul>
                </div>
            <?php else: ?>
                <button class="btn btn-primary btn-account" data-target="#modal-login" data-toggle="modal">Se
                    connecter <i class="fas fa-sign-in-alt"></i></button>
            <?php endif; ?>

        </nav>
    </div>

    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginlabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="formLoginRequire">
                    <?php require "scripts/authentication/login.php" ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo '
    <div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
    }
    unset($_SESSION['message']);
    ?>
    <?php $flashManager = new \w2w\Utils\FlashManager();
    $flashManager->display(); ?>
</header>

<main role="main">

    <?php
    /*
     * inserting page-specific content :
     */
    if (isset($content))
        echo $content;
    ?>
    <!-- FOOTER -->
</main>
<footer>

    <div class="container ">
        <div class="flex-wrap mb-4">
            <div class="flex-left">
                <h5>W2W <span class="small">| What to watch</span></h5>
                <ul class="list-inline ">

                    <li><a href="/about.php" target="_blank">A propos</a></li>
                    <li><a href="/team.php" target="_blank">L'équipe</a></li>
                    <li><a href="/movies.php" target="_blank">Les films</a></li>
                    <li><a href="/contact.php" target="_blank">Nous contacter</a></li>

                    <?php if ($user && $user->isAdmin()) : ?>
                        <a href="/admin/">Mon Compte</a>
                    <?php else: ?>
                        <?php if ($user && $user->isRoot()) : ?>
                            <a href="/root/">Mon Compte</a>
                        <?php else: ?>
                            <a href="/account/">Mon Compte</a>
                        <?php endif; ?>
                    <?php endif; ?>


                </ul>
            </div>
            <div class="flex-right">
                <h5>Suivez-nous</h5>
                <ul class="list-inline social-links">

                    <li><a href="#" target="_blank"> <i class="fab fa-facebook-square"></i> </a></li>
                    <li><a href="#" target="_blank"> <i class="fab fa-twitter"></i> </a></li>
                    <li><a href="#" target="_blank"> <i class="fab fa-youtube"></i> </a></li>
                    <li><a href="#" target="_blank"> <i class="fas fa-film"></i> </a></li>

                </ul>
            </div>
        </div>

        <p class="copyright text-center">&copy; 2019 - <?php echo date("Y"); ?> What To Watch - All right Reserved </p>
    </div>

</footer>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script src="/assets/js/loginForm.js" type="module"></script>
<?php
if ($user) {
    ?>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script src="../../assets/js/adminDashboard.js"></script>
    <script src="../../assets/js/w2w.admin.movie.js"></script>
    <script src="../../assets/js/multi.min.js"></script>
    <?php
}
?>

</body>
</html>
