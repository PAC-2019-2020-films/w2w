
<!-- start of image de siege de cinema -->
<div class="page-title " style="background :url('/uploads/salle_cinema.jpg');">

    <div class="container">

        <h2 class="clearfix xavier pt-5" ">liste des films</h2>
        <!-- Film info -->
    </div>

</div>
<!-- end of image de siege de cinema -->
    <div class="pt-4" style="background-color: #f6f8fe">
        <div class="container movie_list">
            <div class="dominique">

                    <?php foreach ($movies as $movie) : ?>
                        <div class="row p-4">
                            <!-- TODO : aligner en responsive -->
                            <div class="col-md-2 text-center">
                                <img class="img-responsive" src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" alt=""
                                     style="max-width: 100px">
                            </div>
                            <div class="col-md-7 laura">
                                <h4><a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a></h4>
                            </div>
                            <div class="col-md-3 laura" >
                                <h5><a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getRating()->getName()); ?></a></h5>


                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>



    <?php

if ($maxPages > 1) {
    ?>
    <ul class="pagination">
        <li class="page-item<?php if ($page == 1) { ?>  disabled <?php } ?>">
            <a href="all_movies.php?page=<?= $prevPage < 1 ? 1 : $prevPage ?>" class="page-link "> << </a></li>
        <?php
        for ($i = 1; $i <= $maxPages; $i++) {
            ?>
            <li><a href="all_movies.php?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
            <?php
        }
        ?>
        <li class="page-item<?php if ($page == $maxPages) { ?>  disabled <?php } ?>">
            <a href="all_movies.php?page=<?= $nextPage > $maxPages ? $maxPages : $nextPage ?>" class="page-link">
                >>
            </a></li>
    </ul>
    <?php

} ?>

