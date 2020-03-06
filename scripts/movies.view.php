<?php
/**
 * Vue paginée pour toutes les listes de films
 *
 * (copie modifiée de "all_movies.view.php")
 */
?>

<div class="header-page">
    <div class="container">
        <h2 class="header-page-tile text-center">Tous les films</h2>
        <p class="text-center">
            Retrouvez tous les films notés sur W2W
        </p>
        <p class="small ">
            <span class="">
                <a href="/" class=" text-white">Accueil</a> &raquo;
            </span>
            <span class="">
                <a href="/movies.php" class=" text-white">Films</a>
            </span>
        </p>
    </div>
</div>
<div class="">
    <div class="container">
        <div class="light-bg p-4">
            <div class="row ">
                <div class="col-lg-3">
                    <div class="movie-tag p-2 mb-3">
                        <h3 class="h6 text-uppercase mb-0 ">Filtres</h3>
                    </div>
                    <h4 class="h6">Par Catégories</h4>
                    <span class="line-title"><hr/></span>
                    <ul class="list-unstyled small">
                        <?php
                            foreach ($categories as $category){
                                ?>
                                <li class="mb-2">
                                    <a href="/movies.php?category=<?php echo escape($category->getId()); ?>">
                                    <?php echo $category->getName(); ?>
                                    </a>
                                </li>
                                <?php
                            }
                        ?>
                    </ul>
                    <hr/>
                    <h4 class="h6">Par Genre</h4>
                    <span class="line-title"><hr/></span>
                    <ul class="list-unstyled small">
                        <?php
                        foreach ($tags as $tag){
                            ?>
                            <li class="mb-2">
                                <a href="/movies.php?tag=<?php echo escape($tag->getId()); ?>">
                                    <?php echo $tag->getName(); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <hr/>
                    <h4 class="h6">Par Note</h4>
                    <span class="line-title"><hr/></span>
                    <ul class="list-unstyled small">
                        <?php
                        foreach ($ratings as $rating){
                            ?>
                            <li class="mb-2">
                                <a href="/movies.php?rating=<?php echo escape($rating->getId()); ?>">
                                    <?php echo $rating->getName(); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="sorting-bar">
                        <p class="small"><?php echo $nombreFilm; ?> résultats trouvés </p>
                    </div>

                    <?php foreach ($movies as $movie) : ?>
                        <div class="list-movie d-flex align-items-center py-3">
                            <div class="list-movie-img pr-2">
                                <a href="/movie.php?id=<?php echo escape($movie->getId()); ?>">
                                    <img class="img-responsive"
                                         src="/uploads/<?php echo escape($movie->getPoster()); ?>.jpg" alt=""
                                    >
                                </a>
                            </div>
                            <div class="list-movie-desc px-3 small">
                                <p class="m-0">
                                    <a href="/movies.php?year=<?php echo escape($movie->getYear()); ?>"><?php echo escape($movie->getYear()); ?>
                                        &sol;

                                        <?php
                                        $tags_movie = $movie->getTags();
                                        ?>
                                        <?php foreach ($tags_movie as $tag) : ?>
                                            <a href="/movies.php?tag=<?php echo escape($tag->getId()); ?>" class="">
                                                <?php echo escape($tag->getName()); ?>
                                                <?php if ($tag != end($tags_movie)) echo ','; ?>
                                            </a>
                                        <?php endforeach; ?>
                                </p>
                                <h3 class="h6 font-weight-bold">
                                    <a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a>
                                </h3>
                                <p>
                                    <?php echo $movie->getDescription(); ?>
                                </p>
                                <p><b class="rating-title">Notre avis :</b>
                                    <span>
                                        <?php if ($movie->hasRating()) : ?>
                                            <a href="/movies.php?rating=<?php echo escape($movie->getRating()->getId()); ?>"><?php echo escape($movie->getRating()->getName()); ?></a>
                                                <?php else : ?>
                                            Sans avis
                                        <?php endif; ?>
                                   </span> à regarder <a
                                            href="/movies.php?category=<?php echo escape($movie->getCategory()->getId()); ?>"><?php echo escape($movie->getCategory()->getName()); ?></a>

                                </p>
                                <p class="">


                                </p>

                            </div>

                        </div>
                    <?php endforeach; ?>

                    <?php

                    if ($maxPages > 1) {
                        ?>


                        <ul class="pagination mt-3">
                            <li class="page-item<?php if ($page == 1) { ?>  disabled <?php } ?>">
                                <a href="<?= $baseUrl?>&amp;page=<?= $prevPage < 1 ? 1 : $prevPage ?>" class="page-link"> &leftarrow;
                                    Précédente </a>
                            </li>
                            <?php
                            for ($i = 1; $i <= $maxPages; $i++) {
                                ?>
                                <li><a href="<?= $baseUrl?>&amp;page=<?= $i ?>" class="page-link <?php if (isset($pageActive) && $pageActive == $i || !isset($pageActive) && $i == 1) { ?>  current <?php } ?>"><?= $i ?></a></li>
                                <?php
                            }
                            ?>
                            <li class="page-item<?php if ($page == $maxPages) { ?>  disabled <?php } ?>">
                                <a href="<?= $baseUrl?>&amp;page=<?= $nextPage > $maxPages ? $maxPages : $nextPage ?>"
                                   class="page-link">
                                    Suivante &rightarrow;
                                </a></li>
                        </ul>
                        <?php

                    } ?>
                </div>

            </div>

        </div>
    </div>
</div>