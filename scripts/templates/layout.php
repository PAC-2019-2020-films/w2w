<?php
/*
 * layout général, par défaut, du site
 */

global $user;

$headTitle = isset($headTitle) ? $headTitle : "W2W : What are you gonna watch now ?!";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo escape($headTitle); ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <!-- Custom styles for this template -->
    <link href="/assets/css/carousel.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5b034eec6e.js" crossorigin="anonymous"></script>

</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-xl">
            <div id="logo">
                <a class="navbar-brand" href="/">
                    <img alt="logo" src="/assets/img/logo-w2w.svg">  w2w</a>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarW2W" aria-controls="navbarW2W" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarW2W">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Accueil <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown07XL" data-toggle="dropdown" aria-expanded="false">Films</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown07XL">
                            <a class="dropdown-item" href="/reviews.php">Tous les films</a>
                            <a class="dropdown-item" href="#">Films les mieux notés</a>
                            <a class="dropdown-item" href="#">Films les plus populaires</a>
                            <a class="dropdown-item" href="#">Parcourir les films par genre</a>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Themes </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/tests/">TESTS </a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-md-0 mr-auto">
                    <input class="form-control" type="text" placeholder="Rechercher un film" aria-label="Search">
                </form>

                <?php if (isset($user) && $user instanceof \w2w\Model\User) : ?>
                    <i><?php echo escape($user->getUserName()); ?> &lt;<?php echo escape($user->getEmail()); ?>&gt;</i>
                    <a href="/account/">Mon compte</a>
                    <?php if ($user->isAdmin()) : ?>
                        <a href="/admin/">Dashboard</a>
                    <?php endif; ?>
                    <?php if ($user->isRoot()) : ?>
                        <a href="/root/">[root]</a>
                    <?php endif; ?>
                    <a class="btn btn-primary btn-account" href="/logout.php">Se déconnecter</a>
                <?php else: ?>
                    <a class="btn btn-primary btn-account" href="/login.php">Se connecter <i class="fas fa-sign-in-alt"></i></a>
                <?php endif; ?>


            </div>
        </div>
    </nav>
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
<footer >

    <div class="container ">
        <div class="flex-wrap mb-4">
            <div class="flex-left">
                <h5>W2W <span class="small">| What to watch</span></h5>
                <ul class="list-inline ">

                    <li> <a href="/about.php" target="_blank">A propos</a></li>
                    <li> <a href="/team.php" target="_blank">L'équipe</a></li>
                    <li> <a href="/movies.php" target="_blank">Les films</a></li>
                    <li> <a href="/contact.php" target="_blank">Nous contacter</a></li>
                    <li> <a href="/login.php" target="_blank">Se connecter</a></li>

                </ul>
            </div>
            <div class="flex-right">
                <h5>Suivez-nous</h5>
                <ul class="list-inline social-links">

                    <li> <a href="#" target="_blank"> 	<i class="fab fa-facebook-square"></i>  </a></li>
                    <li> <a href="#" target="_blank">  <i class="fab fa-twitter"></i> </a></li>
                    <li> <a href="#" target="_blank">  <i class="fab fa-youtube"></i> </a></li>
                    <li> <a href="#" target="_blank">  <i class="fas fa-film"></i> </a></li>

                </ul>
            </div>
        </div>



        <p class="copyright text-center">&copy; 2017-2019 What To Watch - All right Reserved </p>
    </div>

</footer>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
