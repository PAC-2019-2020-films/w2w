<?php

$headTitle = isset($headTitle) ? $headTitle : "w2w";
$headerTitle = isset($headerTitle) ? $headerTitle : "what2watch";

//$links = [
//    "/",
//    "/contact",
//    "/login",
//    "/logout",
//];


?><!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/> 
        <title><?php echo htmlentities($headTitle); ?></title>
        <!--<script src="/js/jquery.js"></script>-->
        <link rel="stylesheet" type="text/css" href="/css/general.css"/>
        <link rel="shortcut icon" type="image/x-icon"  href="/icon.ico" >
        <style type="text/css">
            html, body {
                background:#ffa;
                color:#000;
                margin:0;padding:0;
            }
            header {
                background:#aaa;
            }
        </style>
    </head>
    <body>
        <header>
            <h1><?php echo $this->escape($headerTitle); ?></h1>
            <?php if (isset($user)) : ?>
                [connected as : <?php echo htmlentities($user->getUserName()); ?>
                <?php if ($user->isRoot()) : ?>
                (root)
                <?php elseif ($user->isAdmin()) : ?>
                (admin)
                <?php endif; ?>
                ]
                
                
            <?php else: ?>
                (guest)
            <?php endif; ?>
            <div>
                <?php foreach ($links as $link) : ?>
                <a href="<?php echo htmlentities($link); ?>"><?php echo htmlentities($link); ?></a>
                <?php endforeach; ?>
            </div>
            <hr/>
        </header>
        <main>
			<?php if (isset($content)) echo $content; ?>
		</main>
        <footer>
            <hr/>
            (default layout)
            été a > b où ça
        </footer>
    </body>
</html>
