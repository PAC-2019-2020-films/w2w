<?php
    
    checkAdmin();

?>
    <!-- *************** FLASHBAG *************** -->
    <div class="flashBag">
        <?php
            \w2w\Utils\Utils::echoMessage();
        ?>
    </div>
    <!-- *************** END FLASHBAG *************** -->

    <!-- *************** ADD TAG *************** -->
    <div class="container-fluid addCategory">

        <button class="btn btn-primary float-right" type="button" data-toggle="collapse" data-target="#addTag"
                aria-expanded="false" aria-controls="collapse" id="toggleAddTagForm">
            <i class="fas fa-plus"></i>
            Ajouter un Tag
        </button>

        <div class="collapse" id="addTag">
            <div>
                <div class="bg-light rounded p-2">
                    <h3 class="m-auto"> Ajouter un Tag </h3>
                    <hr>
                    <form class="form" action="../category/category-add.php" id="addTagForm" method="post"
                          enctype="multipart/form-data">

                        <div class="form-row">
                            <input type="text" class="form-control mb-4" placeholder="Name" name="nameTag">
                        </div>

                        <div class="form-row">
                            <input placeholder="Description" type="text" id="description" name="description" class="form-control mb-4 h-auto">
                        </div>

                        <div class="form-group m-auto">
                            <div class="col-xs-12">
                                <input type="submit" class="btn btn-primary btn-sm" value="Add Tag" id="btnAddTag">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <!-- *************** END ADD TAG *************** -->
    
    <!-- *************** TAGS LIST *************** -->
    <div class="container">
        <h2>Liste des tags</h2>
        
        <table id="tag_list" class="table table-striped">
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
    </div>
    <!-- *************** END TAGS LIST *************** -->
    
    
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


