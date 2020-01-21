<?php

/**
 * script de vue (affichage du résultat) de la page d'accueil du site
 */
?>

<h1>Welcome to w2w (index page).</h1>



<h2>Last movies :</h2>
<?php if (isset($lastMovies) && is_array($lastMovies)) : ?>
<ol>
    <?php foreach ($lastMovies as $movie) : ?>
    <?php echo template("movie.thumbnail.php", ["movie" => $movie]); ?>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<h2>Popular movies :</h2>
<?php if (isset($popularMovies) && is_array($popularMovies)) : ?>
<ol>
    <?php foreach ($popularMovies as $movie) : ?>
    <?php echo template("movie.thumbnail.php", ["movie" => $movie]); ?>
    <?php endforeach; ?>
</ol>
<?php endif; ?>






