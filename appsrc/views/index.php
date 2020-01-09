<?php

/**
 * Affichage du contenu de la page d'accueil
 * 
 * 
 * Les layouts (mise en page générale d'une page) sont dans FR_SRCPATH/views/layouts.
 * Pour pouvoir y insérer le contenu particulier d'une page, ils doivent contenir une ligne
 * de type "if (isset($content)) echo $content;"
 * 
 * Des templates (mise en page d'un élément répétitif d'une page à l'autre)
 * peuvent être définis dans FR_SRCPATH/views/templates
 * 
 * Exemple utilisation d'un template :
 *      - Fichier de définition du template :
 *          views/templates/movie.thumbnail.php
 *      - Appel du template dans une vue :
 *          <?php echo $this->template("movie.thumbnail", ["movie" => $movie]); ?>
 */

?>


<p>Welcome to w2w (index page).</p>



<?php if (isset($movies) && is_array($movies)) : ?>
<ol>
    <?php foreach ($movies as $movie) : ?>
    <?php echo $this->template("movie.thumbnail", ["movie" => $movie]); ?>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($tags) && is_array($tags)) : ?>
<ol>
    <?php foreach ($tags as $tag) : ?>
    <li>
        <a href=""><?php echo $this->escape($tag); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($categories) && is_array($categories)) : ?>
<ol>
    <?php foreach ($categories as $category) : ?>
    <li>
        <a href=""><?php echo $this->escape($category); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>
