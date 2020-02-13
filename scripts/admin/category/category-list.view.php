<?php

checkAdmin();

?>

    <div class="container-fluid addCategory">
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil
                anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
            </div>
        </div>

        <button class="btn btn-primary float-right" type="button" data-toggle="collapse" data-target="#addCategory"
                aria-expanded="false" aria-controls="collapse" id="toggleAddCatForm">
            <i class="fas fa-plus"></i>
            Ajouter une catégorie
        </button>

        <div class="collapse" id="addCategory">
            <div>
                <div class="bg-light rounded p-2">
                    <h3 class="m-auto"> Ajouter une nouvelle catégorie </h3>
                    <hr>
                    <form class="form" action="../category/category-add.php" id="addCatForm" method="post"
                          enctype="multipart/form-data">

                        <div class="form-row">
                            <input type="text" class="form-control mb-4" placeholder="Name" name="nameCat">
                        </div>

                        <div class="form-row">
                            <input placeholder="Description" type="text" id="description" name="description" class="form-control mb-4 h-auto">
                        </div>

                        <div class="form-group m-auto">
                            <div class="col-xs-12">
                                <input type="submit" class="btn btn-primary btn-sm" value="Add category" id="btnAddCat">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="container-fluid category_list">
        <h2>Liste des catégories</h2>
        <table id="category_list" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-center">Editer</th>
                <th scope="col" class="text-center">Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //                \w2w\Utils\Utils::dump($categories);
            if (isset($categories) && count($categories) > 0) : ?>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <th scope="row">
                            <a href="/admin/category/category-edit.php?id=<?php echo escape($category->getId()); ?>&context=ajax"><?php echo escape($category->getId()); ?></a>
                        </th>
                        <td>
                            <a href="/admin/category/category-edit.php?id=<?php echo escape($category->getId()); ?>&context=ajax"><?php echo escape($category->getName()); ?></a>
                        </td>
                        <td>
                            <?php echo escape($category->getDescription()); ?>
                        </td>
                        <td class="text-center">
                            <a href="/admin/category/category-edit.php?id=<?php echo escape($category->getId()); ?>&context=ajax">
                                <i class="fas fa-edit"></i></a>
                        </td>
                        <td class="text-center">
                            <i class="fa fa-trash" data-target="#modal-delete-category" data-toggle="modal"
                               data-catid="<?php echo escape($category->getId()); ?>"></i>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>


    <!-- ****************** Delete movie confirm box ****************** -->
    <div class="modal fade" id="modal-delete-category" tabindex="-1" role="dialog"
         aria-labelledby="modal-delete-category"
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
                    <form action="category-delete.php" method="post" id="deleteCategoryForm"
                          enctype="multipart/form-data">
                        <div>
                            <input type="hidden" class="modalCatId" name="id"/>
                            <input type="hidden" id="confirm" name="confirm" value="confirm"/>
                            <label for="submitDelete">Etes-vous sur de vouloir supprimer cette catégorie? cette action
                                est
                                irréversible!</label>
                            <input id="submitDelete" type="submit" class="btn btn-primary" value="Supprimer ?"
                                   data-dismiss="modal"/>
                            <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ****************** END Delete movie confirm box ****************** -->

<?php

/* ****************** DATATABLES ****************** */
?>
    <script>
        $(document).ready(function () {
            $('#category_list').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    {"orderable": false},
                    {"orderable": false},
                ],
                "order": [[1, "asc"]]
            });
        });

    </script>
<?php
/* ****************** END DATATABLES ****************** */


