<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movies = $movieDAO->findAll();



?>

<div class="flashBag">
    <?php
    \w2w\Utils\Utils::echoMessage();
    ?>
</div>

<div class="container-fluid movie_list">
    <h2>Liste des films</h2>

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
                        <a href="movie-edit.php?id=<?php echo escape($movie->getId()); ?>"><i
                                    class="fas fa-edit"></i></a>
                    </td>
                    <td class="text-center">
                        <i class="fa fa-trash" data-target="#modal-delete-movie" data-toggle="modal"  data-movieid="<?php echo escape($movie->getId()); ?>"></i>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

</div>

<!-- ****************** Delete movie confirm box ****************** -->
<div class="modal fade" id="modal-delete-movie" tabindex="-1" role="dialog" aria-labelledby="modal-delete-movie"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletetitle">Supprimer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                <form action="movie-delete.php" method="post" id="deleteMovieForm" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" class="modalMovieId" name="id"/>
                        <input type="hidden" id="confirm" name="confirm" value="confirm"/>
                        <label for="submitDelete">Etes-vous sur de vouloir supprimer ce film? cette action est
                            irréversible!</label>
                        <input id="submitDeleteMovie" type="submit" class="btn btn-primary" value="Supprimer ?"  data-dismiss="modal"/>
                        <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ****************** END Delete movie confirm box ****************** -->

<script>
    $(document).ready(function () {
        $('#movie_list').DataTable({
            "columns": [
                null,
                null,
                null,
                null,
                {"orderable": false},
                null,
                {"orderable": false},
                {"orderable": false},
            ],
            "order": [[1, "asc"]]
        });
    });

</script>
