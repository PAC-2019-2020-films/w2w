<?php

checkAdmin();

?>
    <div class="header-dasboard ">
        <div>
            <h1 class="small text-uppercase">Dashboard</h1>
            <h2 class="h4 font-weight-normal">Liste des tags</h2>
        </div>

    </div>


    <div class="bg-white movie_list p-4">

        <!-- *************** TAGS LIST *************** -->


        <table id="tag_list" class="table table-striped text-center">
            <thead>
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
            if (isset($tags) && count($tags) > 0) : ?>
                <?php foreach ($tags as $tag) : ?>
                    <tr>
                        <th scope="row" class="tag_id">
                            <p><?php echo escape($tag->getId()); ?></p>
                        </th>
                        <td class="tag_name">
                            <p><?php echo escape($tag->getName()); ?></p>
                        </td>
                        <td class="tag_description">
                            <p><?php echo escape($tag->getDescription()); ?></p>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-edit"></i>
                        </td>
                        <td class="text-center">
                            <i class="fa fa-trash" data-target="#modal-delete-tag" data-toggle="modal"
                               data-tagid="<?php echo escape($tag->getId()); ?>"></i>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- *************** END TAGS LIST *************** -->


        <!-- *************** ADD TAG *************** -->

        <h3 class="h6 font-weight-normal my-4">Ajouter un Tag </h3>
        <hr/>
                <!-- *************** FLASHBAG *************** -->
        <div class=" flashBag">
        <?php
        \w2w\Utils\Utils::echoMessage();
        ?>
    </div>
    <!-- *************** END FLASHBAG *************** -->
    <form class="form" action="../category/category-add.php" id="addTagForm" method="post"
          enctype="multipart/form-data">

        <div class="form-row">
            <input type="text" class="form-control mb-4" placeholder="Name" name="nameTag">
        </div>

        <div class="form-row">
            <input placeholder="Description" type="text" id="description" name="description"
                   class="form-control mb-4 h-auto">
        </div>

        <div class="form-group m-auto">
            <div class="col-xs-12">
                <input type="submit" class="btn btn-primary btn-sm" value="&plus; Ajouter un tag" id="btnAddTag">
            </div>
        </div>
    </form>

    <!-- *************** END ADD TAG *************** -->

    </div>

    <!-- ****************** Delete tag confirm box ****************** -->
    <div class="modal fade" id="modal-delete-tag" tabindex="-1" role="dialog" aria-labelledby="modal-delete-tag"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletetitle">Supprimer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="tag-delete.php" method="post" id="deleteTagForm" enctype="multipart/form-data">
                        <div>
                            <input type="hidden" class="modalTagId" name="id"/>
                            <input type="hidden" id="confirm" name="confirm" value="confirm"/>
                            <label for="submitDelete">Etes-vous sur de vouloir supprimer ce tag? cette action est
                                irréversible!</label>
                            <input id="submitDelete" type="submit" class="btn btn-primary" value="Supprimer ?"/>
                            <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ****************** END Delete tag confirm box ****************** -->

<?php

/* ****************** DATATABLES ****************** */
?>
    <script>

        $(document).ready(function () {
            $('#tag_list').DataTable({
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


