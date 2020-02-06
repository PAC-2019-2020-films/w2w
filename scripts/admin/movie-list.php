<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movies = $movieDAO->findAll();



?>

<h1>Liste des films</h1>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Année</th>
            <th>Poster</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($movies) && is_array($movies) && count($movies) > 0) : ?>
            <?php foreach ($movies as $movie) : ?>
            <tr>
                <td>
                    <a href="/admin/movie-edit.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getId()); ?></a>
                </td>
                <td>
                    <a href="/admin/movie-edit.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a>
                </td>
                <td>
                    <?php echo escape($movie->getDescription()); ?>
                </td>
                <td>
                    <?php echo escape($movie->getYear()); ?>
                </td>
                <td>
                    <?php echo escape($movie->getPoster()); ?>
                </td>
                <td>
                    <?php if ($category = $movie->getCategory()) echo escape($category->getName()); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </ul>
    </tbody>
</table>
<ul>


