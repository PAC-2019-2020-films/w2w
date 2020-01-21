<?php
/*
 * layout général, par défaut, du site
 */

global $user;

$headTitle = isset($headTitle) ? $headTitle : "Welcome on wath to watch";


?><!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title><?php echo escape($headTitle); ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
</head>

<body>
<!-- start of NavBar -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/"><img class="img-fluid" alt="logo" src="/assets/img/logo.png"> </a>
    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon align-self-center"></span>
    </button>
    <div class="collapse navbar-collapse row align-self-center" id="navbarNav">
            <div class="nav-item col-md-2 offset-md-0">
                <a class="nav-link" href="#">HOME</a>
            </div>
            <div class="nav-item col-md-2">
                <a class="nav-link " href="#">ABOUT</a>
            </div>
            <div class="nav-item col-md-2">
                <a class="nav-link" href="#">REVIEWS</a>
            </div>
            <div class="nav-item col-md-2">
                <a class="nav-link" href="#">MOVIES</a>
            </div>
            <div class="nav-item col-md-2">
                <a class="nav-link" href="#">TOP RATED</a>
            </div>
            <div class="nav-item col-md-2">
            <button type="button" class="button_account btn"><img class="account_img" src="/assets/img/my_account.png" width="40" height="40" href="" >My Account</img> </button>
            </div>
    </div>
</nav>
<!-- end of NavBar -->


<!-- start of EVENT -->
<section id="event" class="row">

    <!-- start TITLE of Event -->
    <div class="col-md-12 text-center ">
        <h2>bla bla bla bla .... </h2>
    </div>
    <div class="col-md-12 text-center header_event">
        <h4>re bla bla bla bla ....</h4>
    </div>
    <!-- end TITLE of Event -->
</section>



        <main>
            <?php
            /*
             * barre temporaire pour faire des tests 
             */
            ?>
            <style>
            nav.testnav {
                background:#999;
            }
            nav.testnav a {
                color:inherited;
            }
            </style>
            <nav class="testnav">
                <?php if (isset($user) && $user instanceof \w2w\Model\User) : ?>
                    user name : <i><?php echo escape($user->getUserName()); ?> &lt;<?php echo escape($user->getEmail()); ?>&gt;</i>
                    <a href="/account/">[account]</a>
                    <?php if ($user->isAdmin()) : ?>
                    <a href="/admin/">[admin]</a>
                    <?php endif; ?>
                    <?php if ($user->isRoot()) : ?>
                    <a href="/root/">[root]</a>
                    <?php endif; ?>
                    <a href="/logout.php">[logout]</a>
                <?php else: ?>
                    <a href="/login.php">[login]</a>
                <?php endif; ?>
                <a href="/contact.php">[contact]</a>
                <a href="/tests/">[tests]</a>
            </nav>
			<?php 
            /*
             * inserting page-specific content :
             */
            if (isset($content)) echo $content; 
            ?>
		</main>


<!-- start of Footer -->
<footer class="bg_gris">
    <div class="row">
        <tr>
        <div class="col-md-2 offset-md-1">
            <i class=""></i><a href=""><b><br>About</b><br><br></a>
            <i class=""></i><a href=""> About W2W <br></a>
            <i class=""></i><a href=""> Team <br></a>
            <i class=""></i><a href=""> Contact <br></a>
        </div>
        <div class="col-md-3">
                <div class="col-md-1 offset-md-1"><a href=""><b><br>Categories</b><br><br></a></div>
            <div class ="row">
                <div class=""><a href=""> Category 1 <br></a></div>
                <div class="offset-md-1"><a href=""> Category 6 <br></a></div>
            </div>
            <div class ="row">
                <div class=""><a href=""> Category 2 <br></a></div>
                <div class="offset-md-1"><a href=""> Category 7 <br></a></div>
            </div>

            <div class ="row">
                <div class=""><a href=""> Category 3 <br></a></div>
                <div class="offset-md-1"><a href=""> Category 8 <br></a></div>
            </div>
            <div class ="row">
                <div class=""><a href=""> Category 4 <br></a></div>
                <div class="offset-md-1"><a href=""> Category 9 <br></a></div>
            </div>
            <div class ="row">
                <div class=""><a href=""> Category 5 <br></a></div>
                <div class="offset-md-1"><a href=""> Category 10 <br></a></div>
            </div>
        </div>
        <div class="col-md-3">
            <i class=""></i><a href="#"><b><br>My Acccount</b><br><br></a>
            <i class=""></i><a href="#">Sign In<br></a>
            <i class=""></i><a href="#">My Account<br></a>
            <i class=""></i><a href="#">My Reviews<br></a>
        </div>
        <div class="col-md-3">
            <i class=""></i><a href="#"><b><br>Help</b><br><br></a>
            <i class=""></i><a href="#">FAQ<br></a>
            <i class=""></i><a href="#">Privacy Policy<br></a>
        </div>
    </div>
    <div class="row bg_gris">
        <div class="offset-md-1 col-md-1"> <br><br></div>
    </div>
    <div class="row bg_gris">
        <div class="offset-md-1 col-md-1"> <br><br></div>
    </div>
    <div class="row">
        <div class="offset-md-1 col-md-8">
            <img src="/assets/img/logo.png">
        </div>
        <div class="col-md-1">
            <a href="https://www.facebook.com/" target="_blank">
                <i class="fa fa2 fa-facebook" aria-hidden="true"></i>
            </a>
        </div>
        <div class="col-md-1">
            <a href="https://www.twiter.com/" target="_blank">
                <i class="fa fa2 fa-twitter" aria-hidden="true"></i>
            </a>
        </div>
        <div class="col-md-1">
            <i title="Sortez et allez boire un verre avec des amis" class="fa fa2 fa-coffee" aria-hidden="true"></i>
        </div>
    </div>
    <div class="row">
        <div class="copyright offset-md-1 col-md-10">(c) What2Watch. All rights reserved <br><br></div>
    </div>
</footer>
<!-- end of footer -->

<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/loginForm.js" type="module"></script>
</body>
</html>
