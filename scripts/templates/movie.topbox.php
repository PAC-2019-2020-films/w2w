<?php
/* Box Top 5 - W2W on homepage */
?>


<div class="movie-box <?php if(isset($index) && $index == 0 ) echo "first-movie"; ?>">
    <div class="number-box">
        <?php if(isset($index)) echo  intval($index) + 1; ?>
    </div>
    <div class="image-movie">

        <!-- A verifier
        <img src="<?/*= IMG_PATH_MOVIES . escape($movie->getPoster()); */?>-medium.jpg" class="img-fluid" alt="" />-->
        <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" class="img-fluid" alt="" />

        <a class="overlay" href="/movie.php?id=<?php echo escape($movie->getId()); ?>">
            <div class="text"><i class="far fa-play-circle"></i></div>
        </a>
    </div>
    <h5>
        <a class="overlay" href="/movie.php?id=<?php echo escape($movie->getId()); ?>">
            <?php echo $movie->getTitle(); ?>
        </a>
    </h5>
</div>


