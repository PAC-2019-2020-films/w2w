<div class="header-page">
    <div class="container">
        <h2 class="header-page-tile">Liste des films</h2>
    </div>
</div>
<div class="dark-bg pb-4">
    <div class="container">
        <div class="light-bg p-4">
            <div class="row ">
                <div class="col-lg-4">
                    <h3 class="h5">Catégories</h3>
                    <!-- TODO : filter by category  -->
                    <span class="line-title"><hr/></span>
                    <h3 class="h5">Genre</h3>
                    <!-- TODO : filter by tags  -->
                    <span class="line-title"><hr/></span>
                    <h3 class="h5">Par Note</h3>
                    <!-- TODO : filter by year  -->
                    <span class="line-title"><hr/></span>
                    <h3 class="h5">Par années</h3>
                    <!-- TODO : filter by year  -->
                    <span class="line-title"><hr/></span>
                </div>
                <div class="col-md-8 ">
                    <div class="sorting-bar">
                        <p class="small"><?php echo $nombreFilm; ?> résultats trouvés </p>

                        <!-- TODO : requete de tri -->
                        <form method="get">
                            <select class="custom-select" id="">
                                <option>De A à Z</option>
                                <option>De Z à A</option>
                                <option>Date d'ajout</option>
                                <option>Plus populaires</option>
                                <option>Meilleure note</option>
                            </select>

                        </form>

                    </div>

                    <?php foreach ($movies as $movie) : ?>
                        <div class="list-movie">
                            <div class="list-movie-img">
                                <img class="img-responsive"
                                     src="/uploads/<?php echo escape($movie->getPoster()); ?>.jpg" alt=""
                                >

                            </div>
                            <div class="list-movie-desc">
                                <h4 class="h5">
                                    <a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a>
                                </h4>

                            </div>
                            <div class="list-movie-rating">
                                <p class="small">
                                    <?php

                                    if ($movie->hasRating()) {
                                        echo escape($movie->getRating()->getName());
                                    } else {
                                        echo "pas encore noté";
                                    } ?>

                                </p>
                            </div>


                        </div>
                    <?php endforeach; ?>

                    <?php

                    if ($maxPages > 1) {
                        ?>


                        <ul class="pagination  ">
                            <li class="page-item<?php if ($page == 1) { ?>  disabled <?php } ?>">
                                <a href="all_movies.php?page=<?= $prevPage < 1 ? 1 : $prevPage ?>" class="page-link"> <<
                                    PRÉCÉDENTE </a>
                            </li>
                            <?php
                            for ($i = 1; $i <= $maxPages; $i++) {
                                ?>
                                <li><a href="all_movies.php?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
                                <?php
                            }
                            ?>
                            <li class="page-item<?php if ($page == $maxPages) { ?>  disabled <?php } ?>">
                                <a href="all_movies.php?page=<?= $nextPage > $maxPages ? $maxPages : $nextPage ?>"
                                   class="page-link">
                                    SUIVANTE >>
                                </a></li>
                        </ul>
                        <?php

                    } ?>
                </div>

            </div>

        </div>
    </div>
</div>