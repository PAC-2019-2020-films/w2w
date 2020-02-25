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

    <script src="https://kit.fontawesome.com/5b034eec6e.js" crossorigin="anonymous"></script>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container">
            <div id="logo">
                <a class="navbar-brand" href="/">
                    <img alt="logo" src="/assets/img/logo-w2w.png">
                    w<span>2</span>w
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarW2W"
                    aria-controls="navbarW2W" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarW2W">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Accueil <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown07XL" data-toggle="dropdown"
                           aria-expanded="false">Films</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown07XL">
                            <a class="dropdown-item" href="/all_movies.php">Tous les films</a>
                            <a class="dropdown-item" href="#">Films les mieux notés</a>
                            <a class="dropdown-item" href="#">Films les plus populaires</a>
                            <a class="dropdown-item" href="#">Parcourir les films par genre</a>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Themes </a>
                    </li>

                </ul>
                <form class="form-inline my-2 my-md-0 mr-auto">
                    <input class="form-control" type="text" placeholder="Rechercher un film" aria-label="Search">
                </form>

                <?php if (isset($user) && $user instanceof \w2w\Model\User) : ?>
                    <i><?php echo escape($user->getUserName()); ?> &lt;<?php echo escape($user->getEmail()); ?>&gt;</i>
                    <?php if ($user->isAdmin()) : ?>
                        <a href="/admin/">Dashboard</a>
                    <?php else: ?>
                        <?php if ($user->isRoot()) : ?>
                            <a href="/root/">[root]</a>
                        <?php else: ?>
                            <a href="/account/">Mon compte</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a class="btn btn-primary btn-account" href="../authentication/logout_action.php">Se déconnecter</a>
                <?php else: ?>
                    <button class="btn btn-primary btn-account" data-target="#modal-login" data-toggle="modal">Se
                        connecter <i class="fas fa-sign-in-alt"></i></button>
                <?php endif; ?>


            </div>
        </div>

    </nav>

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
