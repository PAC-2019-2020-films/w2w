<?php

checkAdmin();

use \w2w\DAO\DAOFactory;
use \w2w\Utils\PosterManager;

$posterManager = new PosterManager();
$orphanPosters = $posterManager->orphanPosters();
$missingPosters = $posterManager->missingPosters();

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$moviesWithNoPoster = $movieDAO->findWithNoPoster();

?>

<h2>Affiches orphelines</h2>
<p>Fichiers présents dans le répertoire des affiches sans correspondre au champ "poster" d'un film.</p>
<ul>
<?php if (is_array($orphanPosters)) : ?>
    <?php foreach ($orphanPosters as $url) : ?>
    <li><a href="<?php echo escape($url); ?>"><?php echo escape(basename($url)); ?></a></li>
    <?php endforeach; ?>    
<?php endif; ?>
</ul>


<h2>Affiches manquantes</h2>
<p>Fichiers manquant dans le répertoire des affiches alors que la propriété "poster" d'un film pointe dessus.</p>
<ul>
<?php if (is_array($missingPosters)) : ?>
    <?php foreach ($missingPosters as $url) : ?>
    <li><a href="<?php echo escape($url); ?>"><?php echo escape(basename($url)); ?></a></li>
    <?php endforeach; ?>    
<?php endif; ?>
</ul>


<h2>Films sans affiche configurée</h2>
<p>Films dont la propriété "poster" est nulle ou vide.</p>
<ul>
<?php if (is_array($moviesWithNoPoster)) : ?>
    <?php foreach ($moviesWithNoPoster as $movie) : ?>
    <li><a href="<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a></li>
    <?php endforeach; ?>    
<?php endif; ?>
</ul>
