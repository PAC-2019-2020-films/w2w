<?php
/**
 *
 * vignette de film dans une liste de films (Vertical)
 *
 */
?>

<div class="movie-box">
    <div class="image-movie">
        <img src="/uploads/<?php echo escape($movie->getPoster()); ?>.jpg" class="img-fluid" alt=""/>
        <a class="overlay" href="/movie.php?id=<?php echo escape($movie->getId()); ?>">
            <div class="text"><i class="far fa-play-circle"></i></div>
        </a>
    </div>

    <div class="movie-description">
        <span class="movie-info small"><?php echo $movie->getYear(); ?>,</span>
        <?php
        $tags_movie = $movie->getTags();
        ?>

        <?php foreach ($tags_movie as $tag) : ?>
            <span class="movie-info">
            <?php echo escape($tag->getName()); ?>
            <?php if ($tag != end($tags_movie)) echo ','; ?>
         </span>
        <?php endforeach; ?>
    </div>
    <div class="movie-title">
        <h4><a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo $movie->getTitle(); ?></a></h4>
    </div>


</div>

