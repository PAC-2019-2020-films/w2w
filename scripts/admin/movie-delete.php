<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$confirm = param("confirm");

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);

if (! $movie) {
    redirect("/admin/movie-list.php", "Movie #{$id} not found");
}

if ($confirm == "confirm") {
    $movieDAO->delete($movie);
    redirect("/admin/movie-list.php", "Film supprimé.");
}


?>



<form action="/admin/movie-delete.php" method="post">
    <div>
        <input type="hidden" id="id" name="id" value="<?php echo escape($movie->getId()); ?>"/> 
        <input type="hidden" id="confirm" name="confirm" value="confirm"/> 
        <input type="submit" value="Supprimer ?"/>
    </div>
</form>
