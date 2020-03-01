<?php
/*
  Infos du film
 */
?>

<p class="movies-data" >
    <span class="year">
        <a style="color:white;" href="/movies.php?year=<?php echo escape($movie->getYear()); ?>"><?php echo escape($movie->getYear()); ?></a>
    </span>

    <span class="rating">
        <?php if ($movie->hasRating()) : ?>
        <a style="color:white;" href="/movies.php?rating=<?php echo escape($movie->getRating()->getId()); ?>"><?php echo escape($movie->getRating()->getName()); ?></a>
        <?php endif; ?>
    </span>

    <span class="categories">
        <a style="color:white;" href="/movies.php?category=<?php echo escape($movie->getCategory()->getId()); ?>"><?php echo escape($movie->getCategory()->getName()); ?></a>
    </span>
</p>
