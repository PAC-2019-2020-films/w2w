<?php
/*
  Infos du film
 */
?>

<p class="movies-data">
    <span class="year"><?php echo $movie->getYear(); ?></span>

    <span class="rating"><?php if ($movie->hasRating()) echo $movie->getRating()->getName(); ?></span>

    <span class="categories">
        <?php echo escape($movie->getCategory()->getName()); ?>
    </span>
</p>
