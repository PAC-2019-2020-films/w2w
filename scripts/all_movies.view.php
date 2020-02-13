<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movies = $movieDAO->findAll();


?>
<!-- start of image de siege de cinema -->
<div class="page-title " style="background :url('/uploads/salle_cinema.jpg');">

    <div class="container">

        <h2 class="clearfix xavier pt-5" ">liste des films</h2>
        <!-- Film info -->
    </div>

</div>
<!-- end of image de siege de cinema -->
<div style="background-color: #f6f8fe">
<div class="container movie_list">
<div class="dominique">
        <?php if (isset($movies) && is_array($movies) && count($movies) > 0) : ?>
            <?php foreach ($movies as $movie) : ?>
    <div class="row p-3">
        <!-- TODO : aligner en responsive -->
                <div class="col-md-2 text-center">
                    <img class="img-responsive" src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" alt=""
                         style="max-width: 100px">
                </div>
                <div class="col-md-7 laura">
                    <h4><a href="/admin/movie-edit.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a></h4>
                </div>
                <div class="col-md-3 laura" >
                    <h5><a href="/admin/movie-edit.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getRating()->getName()); ?></a></h5>
                </div>
    </div>
            <?php endforeach; ?>
        <?php endif; ?>
</div>
</div>
</div>