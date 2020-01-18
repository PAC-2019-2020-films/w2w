<?php

/*
 * affichage d'un film... à modifier à volonté par le designer
 */

?>


<?php if (isset($movie) && $movie instanceof \w2w\Model\Movie) : ?>
    <?php echo escape($movie); ?>
<?php endif; ?>

