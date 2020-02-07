<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movies = $movieDAO->findAll();


?>
<script src="/assets/js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<div class="container-fluid">
    <h1>Liste des films</h1>

    <table id="movie_list" class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Titre</th>
            <th scope="col">Description</th>
            <th scope="col">Année</th>
            <th scope="col" class="text-center">Poster</th>
            <th scope="col">Category</th>
            <th scope="col" class="text-center">Editer</th>
            <th scope="col" class="text-center">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($movies) && is_array($movies) && count($movies) > 0) : ?>
            <?php foreach ($movies as $movie) : ?>
                <tr>
                    <th scope="row">
                        <a href="/admin/movie-edit.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getId()); ?></a>
                    </th>
                    <td>
                        <a href="/admin/movie-edit.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie->getTitle()); ?></a>
                    </td>
                    <td>
                        <?php echo escape($movie->getDescription()); ?>
                    </td>
                    <td>
                        <?php echo escape($movie->getYear()); ?>
                    </td>
                    <td class="text-center">
                        <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" alt=""
                             style="max-width: 50px">
                    </td>
                    <td>
                        <?php if ($category = $movie->getCategory()) echo escape($category->getName()); ?>
                    </td>
                    <td class="text-center">
                        <a href=""><i class="fas fa-edit"></i></a>
                    </td>
                    <td class="text-center">
                        <a href=""><i class="fa fa-trash"></i></a>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

</div>
<script>
    $(document).ready(function () {
        $.noConflict();
        $('#movie_list').DataTable({
            "columns" : [
                null,
                null,
                null,
                null,
                {"orderable": false},
                null,
                {"orderable": false},
                {"orderable": false},
            ]
        });
    });

</script>
