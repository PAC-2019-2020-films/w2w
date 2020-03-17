<?php

checkAdmin();

?>

    <!-- *************** ADD CATEGORY *************** -->

    <div class="header-dasboard ">
        <div>
            <h1 class="small text-uppercase">Dashboard</h1>
            <h2 class="h4 font-weight-normal">Liste des catégories</h2>
        </div>

        <!-- *************** FLASHBAG *************** -->
        <div class="flashBag">
            <?php
            \w2w\Utils\Utils::echoMessage();
            ?>
        </div>
        <!-- *************** END FLASHBAG *************** -->


    </div>


    <div class="bg-white movie_list p-4">


        <!-- *************** LIST CATEGORIES *************** -->
        <div class="category_list mb-2">
            <table id="category_list" class="table table-striped text-center">
                <thead >
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Editer</th>
                    <th scope="col">Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($categories) && count($categories) > 0) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <th scope="row" class="cat_id">
                                <p><?php echo escape($category->getId()); ?></p>
                            </th>
                            <td class="cat_name">
                                <p><?php echo escape($category->getName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($category->getDescription()); ?></p>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-edit"></i>
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
        <!-- *************** END LIST CATEGORIES *************** -->

        <h3 class="h6 font-weight-normal my-4"> Ajouter une nouvelle catégorie </h3>
        <hr>

        <form class="form" action="../category/category-add.php" id="addCatForm" method="post"
              enctype="multipart/form-data">

            <div class="form-row">
                <input type="text" class="form-control mb-4" placeholder="Name" name="nameCat">
            </div>

            <div class="form-row">
                <input placeholder="Description" type="text" id="description" name="description"
                       class="form-control mb-4 h-auto">
            </div>

            <div class="form-group ">
                <div class="col-xs-12">
                    <input type="submit" class="btn btn-primary btn-sm" value="&plus; Ajouter une categorie" id="btnAddCat">
                </div>
            </div>
        </form>

        <!-- *************** END ADD CATEGORY *************** -->

    </div>


    <!-- ****************** Delete category confirm box ****************** -->
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
    <!-- ****************** END Delete category confirm box ****************** -->

    <!-- ****************** Delete dependencies confirm box ****************** -->
    <div id="warning-modal">


    </div>
    <!-- ****************** END Delete dependencies confirm box ****************** -->


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


