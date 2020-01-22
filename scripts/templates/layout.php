<?php
/*
 * layout général, par défaut, du site
 */

global $user;

$headTitle = isset($headTitle) ? $headTitle : "Welcome on what to watch";


?><!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title><?php echo escape($headTitle); ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/nav_foot_li.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
</head>

<body>
<!-- start of NavBar -->
<?php include($_SERVER['DOCUMENT_ROOT'].'/scripts/templates/include/navbar.php') ?>
<!-- end of NavBar -->
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
<?php include($_SERVER['DOCUMENT_ROOT'].'/scripts/templates/include/footer.php') ?>
<!-- end of footer -->

<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
