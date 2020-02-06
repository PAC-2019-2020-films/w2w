<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$daoFactory = DAOFactory::getDAOFactory();
$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);

if (! $movie) {
    redirect("/admin/movie-list.php", "Movie #{$id} not found");
}

if ($category = $movie->getCategory()) {
    $category_id = $category->getId();
} else {
    $category_id = null;
}

echo template("admin/form.movie.php", [
    "action" =>"/admin/movie-update.php",
    "id" => $movie->getId(),
    "title" => $movie->getTitle(),
    "description" => $movie->getDescription(),
    "year" => $movie->getYear(),
    "poster" => $movie->getPoster(),
    "categories" => $categories,
    "category_id" => $category_id,
]);


?>


<br/><br/><br/>

<form action="/admin/movie-delete.php" method="get">
    <div>
        <input type="hidden" id="id" name="id" value="<?php echo escape($movie->getId()); ?>"/> 
        <input type="submit" value="Supprimer"/>
    </div>
</form>
