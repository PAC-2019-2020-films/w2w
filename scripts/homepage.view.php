<?php

/**
 * script de vue (affichage du résultat) de la page d'accueil du site
 */


?>

<?php if (isset($allMovies) && is_array($allMovies)) : ?>
<!-- start of carousel -->
<section id="carousel">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <img src="/assets/img/movies/carousel/<?php echo $allMovies[$camol[0]]->getId(); ?>.jpg" class="d-block w-100 movie_affiche" alt="...">
                <div class="carousel-caption movie_title row">
                    <?php echo $allMovies[$camol[0]]->getTitle();?>
                </div>

                <div class="carousel-caption movie_data">
                    <a class="movie_data" href="#"><?php echo $allMovies[$camol[0]]->getYear();?></a> <!-- un lien vers tout les films sortis en 2018 -->
                    <span class="movie_data">|</span>
                    <a class=" movie_data" href="http://www.google.be"><?php echo $allMovies[$camol[0]]->getCategory() ;?></a> <!-- un lien vers tout les films sortis de la catégorie -->
                    <span class="movie_data">|</span>
                </div>

                <div>
                    <a class="carousel-caption movie_review" href="#">SEE OUR REVIEW</a> <!-- un lien vers la fiche du film -->
                </div>
            </div>

            <div class="carousel-item">
                <img src="/assets/img/movies/carousel/<?php echo $allMovies[$camol[1]]->getId(); ?>.jpg" class="d-block w-100 movie_affiche" alt="...">
                <div class="carousel-caption movie_title row">
                    <?php echo $allMovies[$camol[1]]->getTitle();?>
                </div>

                <div class="carousel-caption movie_data">
                    <a class="movie_data" href="#"><?php echo $allMovies[$camol[1]]->getYear();?></a> <!-- un lien vers tout les films sortis en 2018 -->
                    <span class="movie_data">|</span>
                </div>

                <div>
                    <a class="carousel-caption movie_review" href="#">SEE OUR REVIEW</a> <!-- un lien vers la fiche du film -->
                </div>
            </div>

            <div class="carousel-item">
                <img src="/assets/img/movies/carousel/<?php echo $allMovies[$camol[2]]->getId(); ?>.jpg" class="d-block w-100 movie_affiche" alt="...">
                <div class="carousel-caption movie_title row">
                    <?php echo $allMovies[$camol[2]]->getTitle();?>
                </div>

                <div class="carousel-caption movie_data">
                    <a class="movie_data" href="#"><?php echo $allMovies[$camol[2]]->getYear();?></a> <!-- un lien vers tout les films sortis en 2018 -->
                    <span class="movie_data">|</span>
                </div>

                <div>
                    <a class="carousel-caption movie_review" href="#">SEE OUR REVIEW</a> <!-- un lien vers la fiche du film -->
                </div>
            </div>

            <div class="carousel-item">
                <img src="/assets/img/movies/carousel/<?php echo $allMovies[$camol[3]]->getId(); ?>.jpg" class="d-block w-100 movie_affiche" alt="...">
                <div class="carousel-caption movie_title row">
                    <?php echo $allMovies[$camol[3]]->getTitle();?>
                </div>

                <div class="carousel-caption movie_data">
                    <a class="movie_data" href="#"><?php echo $allMovies[$camol[3]]->getYear();?></a> <!-- un lien vers tout les films sortis en 2018 -->
                    <span class="movie_data">|</span>
                </div>

                <div>
                    <a class="carousel-caption movie_review" href="#">SEE OUR REVIEW</a> <!-- un lien vers la fiche du film -->
                </div>
            </div>

            <div class="carousel-item">
                <img src="/assets/img/movies/carousel/<?php echo $allMovies[$camol[4]]->getId(); ?>.jpg" class="d-block w-100 movie_affiche" alt="...">
                <div class="carousel-caption movie_title row">
                    <?php echo $allMovies[$camol[4]]->getTitle();?>
                </div>

                <div class="carousel-caption movie_data">
                    <a class="movie_data" href="#"><?php echo $allMovies[$camol[4]]->getYear();?></a> <!-- un lien vers tout les films sortis en 2018 -->
                    <span class="movie_data">|</span>
                    <a class=" movie_data" href="http://www.google.be"><?php echo $allMovies[$camol[4]]->getCategory() ;?></a> <!-- un lien vers tout les films sortis de la catégorie -->
                    <span class="movie_data">|</span>
                </div>

                <div>
                    <a class="carousel-caption movie_review" href="#">SEE OUR REVIEW</a> <!-- un lien vers la fiche du film -->
                </div>
            </div>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
<!-- end CAROUSEL -->
<?php endif; ?>

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






