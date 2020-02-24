<?php
    
    checkAdmin();

?>
    
    <div class="flashBag">
        <?php
            \w2w\Utils\Utils::echoMessage();
        ?>
    </div>
    
    <!--    <div class="container-fluid addCategory">-->
    <!--        -->
    <!--        <button class="btn btn-primary float-right" type="button" data-toggle="collapse" data-target="#addCategory"-->
    <!--                aria-expanded="false" aria-controls="collapse" id="toggleAddCatForm">-->
    <!--            <i class="fas fa-plus"></i>-->
    <!--            Ajouter une catégorie-->
    <!--        </button>-->
    <!--        -->
    <!--        <div class="collapse" id="addCategory">-->
    <!--            <div>-->
    <!--                <div class="bg-light rounded p-2">-->
    <!--                    <h3 class="m-auto"> Ajouter une nouvelle catégorie </h3>-->
    <!--                    <hr>-->
    <!--                    <form class="form" action="../category/category-add.php" id="addCatForm" method="post"-->
    <!--                          enctype="multipart/form-data">-->
    <!--                        -->
    <!--                        <div class="form-row">-->
    <!--                            <input type="text" class="form-control mb-4" placeholder="Name" name="nameCat">-->
    <!--                        </div>-->
    <!--                        -->
    <!--                        <div class="form-row">-->
    <!--                            <input placeholder="Description" type="text" id="description" name="description" class="form-control mb-4 h-auto">-->
    <!--                        </div>-->
    <!--                        -->
    <!--                        <div class="form-group m-auto">-->
    <!--                            <div class="col-xs-12">-->
    <!--                                <input type="submit" class="btn btn-primary btn-sm" value="Add category" id="btnAddCat">-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </form>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <hr>-->
    <!--        </div>-->
    <!--    </div>-->
    
    <div class="container-fluid user_list">
        <h2>Liste des utilisateurs</h2>
        <table id="user_list" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">User Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Date Inscription</th>
                <th scope="col">Role</th>
                <th scope="col" class="text-center">Bannir</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if (isset($users) && count($users) > 0) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <th scope="row" class="cat_id">
                                <p><?php echo escape($user->getId()); ?></p>
                            </th>
                            <td class="cat_name">
                                <p><?php echo escape($user->getUserName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($user->getFirstName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($user->getLastName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($user->getCreatedAt()->format('Y-m-d')); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($user->getRole()->getName()); ?></p>
                            </td>
                            <td class="text-center">
                                <i class="fa fa-ban"
                                    <?php
                                        if ($_SESSION['role'] <= $user->getRole()->getId()) {
                                            echo 'style="color : grey"';
                                        } else {
                                            ?>
                                            data-target="#modal-ban-user"
                                            data-toggle="modal"
                                            data-userid="<?php echo escape($user->getId()); ?>"
                                        <?php } ?>
                                >
                                </i>
                            </td>
                        
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    
    </div>
    
    
    <!-- ****************** Delete category confirm box ****************** -->
    <div class="modal fade" id="modal-ban-user" tabindex="-1" role="dialog"
         aria-labelledby="modal-ban-user"
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
            $('#user_list').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false}
                ],
                "order": [[1, "asc"]]
            });
        });
    
    </script>
<?php
/* ****************** END DATATABLES ****************** */


