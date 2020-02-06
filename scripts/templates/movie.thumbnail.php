<?php
/**
 *
 * vignette de film dans une liste de films (Vertical)
 *
 */
?>

<div class="movie-box">
    <div class="image-movie">
        <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" class="img-fluid" alt="" />
        <a class="overlay" href="/movie.php?id=<?php echo escape($movie->getId()); ?>">
            <div class="text"><i class="far fa-play-circle"></i></div>
        </a>
    </div>

    <div class="movie-desc">
        <span class="note small"><i class="fas fa-star"></i> 8</span>
        <h4><a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo $movie->getTitle(); ?></a></h4>
    </div>

</div>

