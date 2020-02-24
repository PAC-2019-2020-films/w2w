
<!-- start of image de siege de cinema -->
<div class="page-title " style="background :url('/uploads/salle_cinema.jpg');">

    <div class="container">

        <h2 class="clearfix pt-5 placement_info_film">Liste des films</h2>
        <!-- Film info -->
    </div>



</div>
<!-- start of ligne bleue supérieure -->
        <div class=" mt-3 container">
            <div class=" row background_corps result_order ">
                <div class="col-md-8 ">
                <p class="py-2"><b><?php echo $nombreFilm;  ?> </b>films trouvés  au total</p>
                </div>
                <div class="col-md-4 text-right ">
                <span class="sorting"> Trier par :</span>

                    <!-- TODO : requete de tri -->

                <select class="checklist_sorting" id="exampleFormControlSelect1">
                    <option>Popularity Descending</option>
                    <option>Popularity Ascending</option>
                    <option>categorie</option>
                    <option>year</option>
                    <option>rating</option>
                </select>
                </div>
            </div>
        </div>
    </div>
<!-- end of ligne bleue supérieure -->
<!-- end of image de siege de cinema -->
    <div>
        <div class="container">
            <div class="affichage_1_2">

                    <?php foreach ($movies as $movie) : ?>
                        <div class="row p-4">
                            <div class="col-md-2 text-center">
                                <img class="img-responsive" src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" alt=""
                                     style="max-width: 100px">
                            </div>
                            <div class="col-md-7 placement_info_film">
                                <h4><a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a></h4>
                            </div>
                            <div class="col-md-3 placement_info_film" >
                                <h5><a href="/movie.php?id=<?php echo escape($movie->getId()); ?>">
                                        <?php

                                        if ($movie->hasRating()) {
                                            echo escape($movie->getRating()->getName());
                                        }
                                        else{
                                            echo "pas encore noté";
                                        }?>

                                    </a></h5>


                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>



    <?php

if ($maxPages > 1) {
    ?>
        <ul class="pagination pb-3 justify-content-center">
        <li class="page-item<?php if ($page == 1) { ?>  disabled <?php } ?>">
            <a href="all_movies.php?page=<?= $prevPage < 1 ? 1 : $prevPage ?>" class="page-link"  > << PRÉCÉDENTE </a></li>
        <?php
        for ($i = 1; $i <= $maxPages; $i++) {
            ?>
            <li><a href="all_movies.php?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
            <?php
        }
        ?>
        <li class="page-item<?php if ($page == $maxPages) { ?>  disabled <?php } ?>">
            <a href="all_movies.php?page=<?= $nextPage > $maxPages ? $maxPages : $nextPage ?>" class="page-link">
                 SUIVANTE >>
            </a></li>
    </ul>
    <?php

} ?>

        </div>
    </div>

