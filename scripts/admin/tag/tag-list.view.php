
<?php

checkAdmin();

?>

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
        //                \w2w\Utils\Utils::dump($categories);
        if (isset($tags) && count($tags) > 0) : ?>
            <?php foreach ($tags as $tag) : ?>
                <tr>
                    <th scope="row">
                        <a href="/admin/tag/category-edit.php?id=<?php echo escape($tag->getId()); ?>"><?php echo escape($tag->getId()); ?></a>
                    </th>
                    <td>
                        <a href="/admin/tag/category-edit.php?id=<?php echo escape($tag->getId()); ?>"><?php echo escape($tag->getName()); ?></a>
                    </td>
                    <td>
                        <?php echo escape($tag->getDescription()); ?>
                    </td>
                    <td class="text-center">
                        <a href="/admin/tag/category-edit.php?id=<?php echo escape($tag->getId()); ?>">
                            <i class="fas fa-edit"></i></a>
                    </td>
                    <td class="text-center">
                        <i class="fa fa-trash" data-target="#modal-delete-tag" data-toggle="modal" data-tagid="<?php echo escape($tag->getId()); ?>"></i>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

</div>


<!-- ****************** Delete movie confirm box ****************** -->
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
            <div class="modal-body" id="">
                <form action="tag-delete.php" method="post" id="deleteTagForm" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" class="modalTagId" name="id" />
                        <input type="hidden" id="confirm" name="confirm" value="confirm"/>
                        <label  for="submitDelete">Etes-vous sur de vouloir supprimer ce tag? cette action est irréversible!</label>
                        <input id="submitDelete" type="submit" class="btn btn-primary" value="Supprimer ?"/>
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
        $('#tag_list').DataTable({
            "columns": [
                null,
                null,
                null,
                {"orderable": false},
                {"orderable": false},
            ],
            "order":[[1, "asc"]]
        });
    });

</script>
<?php
/* ****************** END DATATABLES ****************** */


