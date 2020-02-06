<?php
use \w2w\DAO\DAOFactory;

checkAdmin();



$daoFactory = DAOFactory::getDAOFactory();
$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();



echo template("admin/form.movie.php", [
    "action" =>"/admin/movie-save.php",
    "categories" => $categories,
    /*"id" => $movie->getId(),
    "title" => $movie->getTitle(),
    "description" => $movie->getDescription(),
    "year" => $movie->getYear(),
    "poster" => $movie->getPoster(),*/
]);

return;
?>



<form action="/admin/movie-save.php" method="post">
    <div>
        <label for="title">
            <input type="text" id="title" name="title" value="<?php echo escape($movie->getTitle()); ?>"/>
        </label>
        <br/>
        <label for="description">
            <textarea id="description" name="description"><?php echo escape($movie->getDescription()); ?></textarea>
        </label>
        <br/>
        <label for="year">
            <input type="text" id="year" name="year" value="<?php echo escape($movie->getYear()); ?>"/>
        </label>
        <br/>
        <label for="poster">
            <input type="text" id="poster" name="poster" value="<?php echo escape($movie->getPoster()); ?>"/>
        </label>
        <br/>
        <input type="submit" value="modifier"/>
    </div>
</form>


