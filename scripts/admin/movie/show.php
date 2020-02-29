<?php

use \w2w\DAO\DAOFactory;
use \w2w\Utils\FlashManager;
use \w2w\Utils\PosterManager;

checkAdmin();


$id = param("id");
$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);

if (! $movie) {
    $flashManager =  new FlashManager();
    $flashManager->error("Film non trouvé (#$id)");
    return;
}

$posterManager = new PosterManager();

?>
<style>
a.vignette {
    display:block;
    margin:auto 5px 5px 5px;
    position:relative;
    width:160px;
    height:160px;
    overflow:hidden;
    text-align:center;
    border:outset 1px #000;
}
a.vignette img {
    max-width:100%;
    max-height:100%;
}
a.vignette > div {
    position:absolute;left:0;bottom:0;width:100%;height:33%;background:#08060e;color:#fff;opacity:0.85;
}
a.vignette:hover > div { display:none; }
    
</style>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h5><?php echo escape($movie->getTitle()); ?></h5>
            <ul>
                <li>Id : <?php echo escape($movie->getId()); ?></li>
                <li>Titre : <?php echo escape($movie->getTitle()); ?></li>
                <li>description : <?php echo escape($movie->getDescription()); ?></li>
                <li>Année : <?php echo escape($movie->getYear()); ?></li>
                <li>Affiche : <?php echo escape($movie->getPoster()); ?></li>
                <?php if ($category = $movie->getCategory()) : ?>
                <li>Catégorie : <?php echo escape($category->getName()); ?></li>
                <?php endif; ?>
                <?php if ($rating = $movie->getRating()) : ?>
                <li>Rating : <?php echo escape($rating->getName()); ?></li>
                <?php endif; ?>
                <li>Tags :
                    <ul>
                        <?php foreach ($movie->getTags() as $tag) : ?>
                        <li><?php echo escape($tag->getName()); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li>Réalisateurs :
                    <ul>
                        <?php foreach ($movie->getDirectors() as $director) : ?>
                        <li><?php echo escape($director->getFirstName()); ?> <?php echo escape($director->getLastName()); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li>Acteurs :
                    <ul>
                        <?php foreach ($movie->getActors() as $actor) : ?>
                        <li><?php echo escape($actor->getFirstName()); ?> <?php echo escape($actor->getLastName()); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
            <a href="/admin/movie/edit.php?id=<?php echo escape($movie->getId()); ?>" class="btn btn-primary">Editer</a>
        </div>
        <div class="col-md-4">
                <a class="vignette" href="/uploads/<?php echo escape($movie->getPoster()); ?>.jpg">
                    <div>
                        Thumbnail
                        <br/>
                        <small><?php echo escape(sprintf("%0.1f K", $posterManager->getThumbnailSize($movie) / 1024)); ?></small>
                        -
                        <small><?php echo escape($posterManager->getThumbnailDimensions($movie)); ?></small>
                    </div>
                    <img src="/uploads/<?php echo escape($movie->getPoster()); ?>.jpg" alt=""/>
                </a>
                <a class="vignette" href="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg">
                    <div>
                        Medium
                        <br/>
                        <small><?php echo escape(sprintf("%0.1f K", $posterManager->getMediumSize($movie) / 1024)); ?></small>
                        -
                        <small><?php echo escape($posterManager->getMediumDimensions($movie)); ?></small>
                    </div>
                    <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" alt=""/>
                    </a>
                <a class="vignette" href="/uploads/<?php echo escape($movie->getPoster()); ?>-big.jpg">
                    <div>
                        Big
                        <br/>
                        <small><?php echo escape(sprintf("%0.1f K", $posterManager->getBigSize($movie) / 1024)); ?></small>
                        -
                        <small><?php echo escape($posterManager->getBigDimensions($movie)); ?></small>
                    </div>
                    <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-big.jpg" alt=""/>
                </a>
        </div>
    </div><!-- end .row -->
</div><!-- end .container -->

