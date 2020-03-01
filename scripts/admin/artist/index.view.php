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
            <a href="/admin/artist/add.php">Ajouter un artist</a>
        <button>

    </div>
    <!-- *************** END ADD TAG *************** -->
    
    <!-- *************** TAGS LIST *************** -->
    <div class="container">
        <h2>Liste des artists</h2>
        
        <table id="tag_list" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col" class="text-center">Editer</th>
                <th scope="col" class="text-center">Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if (isset($artists) && is_array($artists) && count($artists) > 0) : ?>
                    <?php foreach ($artists as $artist) : ?>
                        <tr>
                            <th scope="row" class="tag_id">
                                <p><?php echo escape($artist->getId()); ?></p>
                            </th>
                            <td class="tag_name">
                                <p><?php echo escape($artist->getFirstName()); ?></p>
                            </td>
                            <td class="tag_name">
                                <p><?php echo escape($artist->getLastName()); ?></p>
                            </td>
                            <td class="text-center">
                                <a href="/admin/artist/edit.php?id=<?php echo escape($artist->getId()); ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="/admin/artist/delete.php?id=<?php echo escape($artist->getId()); ?>">
                                    <i class="fa fa-trash" data-target="#modal-delete-tag" data-toggle="modal"
                                       data-tagid="<?php echo escape($artist->getId()); ?>"></i>
                                </a>
                            </td>
                        
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- *************** END TAGS LIST *************** -->
    
    

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


