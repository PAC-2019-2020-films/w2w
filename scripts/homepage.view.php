<?php

/**
 * script de vue (affichage du résultat) de la page d'accueil du site
 */
?>

<h1>Welcome to w2w (index page).</h1>



<?php if (isset($movies) && is_array($movies)) : ?>
<ol>
    <?php foreach ($movies as $movie) : ?>
    <?php echo template("movie.thumbnail.php", ["movie" => $movie]); ?>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($tags) && is_array($tags)) : ?>
<ol>
    <?php foreach ($tags as $tag) : ?>
    <li>
        <a href=""><?php echo escape($tag); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($categories) && is_array($categories)) : ?>
<ol>
    <?php foreach ($categories as $category) : ?>
    <li>
        <a href=""><?php echo escape($category); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>
