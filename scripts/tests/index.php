<?php

/*
 * code de traitement :
 ******************************************************************************/

use \w2w\DAO\DAOFactory;



$daoFactory = DAOFactory::getDAOFactory();

$movieDAO = $daoFactory->getMovieDAO();
$movies = $movieDAO->findAll();

$tagDAO = $daoFactory->getTagDAO();
$tags = $tagDAO->findAll();

$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();



/*
 * code de présentation : 
 ******************************************************************************/

?>



<?php if (isset($movies) && is_array($movies)) : ?>
<ol>
    <?php foreach ($movies as $movie) : ?>
    <?php echo template("movie.thumbnail.php", ["movie" => $movie]); ?>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($tags) && is_array($tags)) : ?>
<ol>
    <?php foreach ($tags as $tag) : ?>
    <li>
        <a href=""><?php echo escape($tag); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($categories) && is_array($categories)) : ?>
<ol>
    <?php foreach ($categories as $category) : ?>
    <li>
        <a href=""><?php echo escape($category); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>
