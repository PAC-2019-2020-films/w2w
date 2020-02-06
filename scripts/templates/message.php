<?php
/**
 * Page d'affichage de de message à l'utilisateur
 * 
 * si paramètres $delay et $url non nuls : redirection automatique vers l'url après $delay secondes
 * 
 * C'est sommaire niveau design...
 */
global $user;

$headTitle = isset($headTitle) ? $headTitle : "W2W - What are you gonna watch now ?!";

# delay (seconds) before redirecting
$delay = isset($delay) ? $delay : null;
$url = isset($url) ? $url : "/";
$msg = isset($msg) ? $msg : "Téléportation en cours...";

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if ($delay != null && $url != null) : ?>
    <meta http-equiv="refresh" content="<?php echo escape($delay); ?>; url=<?php echo escape($url); ?>">
    <?php endif; ?>
    <title><?php echo escape($headTitle); ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <!-- Custom styles for this template -->
    <link href="/assets/css/carousel.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,800,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5b034eec6e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/basic/ckeditor.js"></script>


</head>
<body>
<header>
    <main role="main">
        <style>
            .message-container {
                argin:100px 25px 25px 25px;
                text-align:center;
            }
            a.message {
                display:inline-block;
                margin:auto;
                padding:50px;
                color:#fff;background:rgb(15, 8, 38);
                text-align:center;
                border:outset 1px #000;
            }
        </style>
        <div class="alert message-container" role="alert">
            <a class="message" href="<?php echo escape($url); ?>"><?php echo escape($msg); ?></a>
        </div>
    </main>


<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/loginForm.js" type="module"></script>
</body>
</html>
