p<?php
/**
 * script de vue (affichage du résultat) de la page d'accueil du site
 */
?>

<!-- Carousel 4 Latest Reviews
================================================== -->
<div id="reviewsCarousel" class="carousel slide carousel-fade" data-ride="carousel">

    <div class="carousel-inner">

        <?php if (isset($lastMoviesSlider) && is_array($lastMoviesSlider)) : ?>

            <?php foreach ($lastMoviesSlider as $index => $movie) :
                ?>
                <div class="carousel-item <?php
                if ($index == 0) {
                    echo 'active';
                }
                ?>">
                    <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-big.jpg"  alt="<?php echo $movie->getTitle(); ?>">

                    <div class="carousel-caption text-left">
                        <!-- Tags des films -->
                        <?php echo template("movie.tags.php", ["movie" => $movie]); ?>
                        <h2 class="clearfix pt-3"><?php echo $movie->getTitle(); ?></h2>
                        <!-- Film info -->
                        <?php echo template("movie.data.php", ["movie" => $movie]); ?>
                        <p><a class="btn btn-lg btn-secondary" href="movie.php?id=<?php echo escape($movie->getId()); ?>" role="button">Lire notre critique</a></p>
                    </div>


                </div>

            <?php endforeach; ?>


        <?php endif; ?>
    </div>
    <a class="carousel-control-prev" href="#reviewsCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#reviewsCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>




<!-- Liste Films préféré par les utilisateurs ce mois-ci
                                       ================================================== -->
<section class="dark-bg ">

    <div class="container ">
        <div class="flex-wrap">
            <div class="flex-left">
                <h3>What to watch  now</h3>

                <p class="subtitle small">Vos films préférés ce mois-ci</p>
                <div class="line-title"><hr/></div>
            </div>
            <div class="flex-right">
                <p class="view-more">
                    <a href="#">En voir plus <i class="fas fa-angle-right"></i></a>
                </p>

            </div>
        </div>
        <div class="movies-list">
            <div class="row">
                <?php if (isset($popularMovies) && is_array($popularMovies)) :
                    ?>

                    <?php foreach ($popularMovies as $movie) : ?>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                        <?php echo template("movie.thumbnail.php", ["movie" => $movie]); ?>
                    </div>
                <?php endforeach; ?>

                <?php endif; ?>

            </div>
        </div>
    </div>

</section>
<!--Dernières reviews de w2W
                                       ================================================== -->
<section>
    <div class="container">
        <div class="flex-wrap">
            <div class="flex-left">
                <h3>What to watch  reviews</h3>

                <p class="subtitle small">Nos dernières critiques</p>
                <div class="line-title"><hr/></div>
            </div>
            <div class="flex-right">
                <p class="view-more">
                    <a href="/movies.php">En voir plus <i class="fas fa-angle-right"></i></a>
                </p>

            </div>
        </div>

        <div class="movies-list">
            <div class="movies-list">
                <div class="row">
                    <?php if (isset($lastMovies) && is_array($lastMovies)) :
                        ?>

                        <?php foreach ($lastMovies as $movie) : ?>
                        <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                            <?php echo template("movie.thumbnail.php", ["movie" => $movie]); ?>
                        </div>
                    <?php endforeach; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

</section>
<!-- Top 5 par W2W ce mois-ci
                                       ================================================== -->
<section class="light-bg">
    <div class="container">
        <div class="flex-wrap">
            <div class="flex-left">
                <h3>What Top Watch Top 5</h3>

                <p class="subtitle small">Nos 5 films favoris ce mois-ci</p>
                <div class="line-title"><hr/></div>
            </div>
            <div class="flex-right">
                <p class="view-more">
                    <a href="#">En voir plus <i class="fas fa-angle-right"></i></a>
                </p>

            </div>
        </div>
        <div class="row top-movie">
            <div class="col-lg-6">


                <?php if (isset($firstPopularMovie) && is_array($firstPopularMovie)) :
                    ?>

                    <?php foreach ($firstPopularMovie as $index => $movie) : ?>

                    <?php echo template("movie.topbox.php", ["movie" => $movie, 'index' => $index]); ?>
                <?php endforeach;
                    ?>

                <?php endif; ?>
            </div>

            <div class="col-lg-6">
                <div class="row">

                    <?php if (isset($w2wPopularMovie) && is_array($w2wPopularMovie)) :
                        ?>
                        <?php
                        foreach ($w2wPopularMovie as $index => $movie) :

                            if ($index != 0) :
                                ?>

                                <div class="col-lg-6">
                                    <?php echo template("movie.topbox.php", ["movie" => $movie, 'index' => $index]); ?>
                                </div>
                            <?php
                            endif;
                        endforeach;
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>