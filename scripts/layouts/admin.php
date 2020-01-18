<?php

$headTitle = isset($headTitle) ? $headTitle : "admin";
$headerTitle = isset($headerTitle) ? $headerTitle : "admin";

?><!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/> 
        <title><?php echo htmlentities($headTitle); ?></title>
        <script src="/js/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/general.css"/>
        <link rel="shortcut icon" type="image/x-icon"  href="/icon.ico" >
        <style type="text/css">
            html, body {
                background:red;
                color:#000;
            }
        </style>
    </head>
    <body>
        <header>
            <h1><?php echo $this->escape($headerTitle); ?></h1>
        </header>
        <main>
			<?php if (isset($content)) echo $content; ?>
		</main>
        <footer>
            {exec_time} s - {exec_mem_usage} Mo
        </footer>
    </body>
</html>
