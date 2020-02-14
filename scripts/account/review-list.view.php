<?php

checkUser();

?>

    <div class="flashBag">
        <?php
        \w2w\Utils\Utils::echoMessage();
        ?>
    </div>

    <div class="container-fluid category_list">
        <h2>Mes critiques</h2>
        <table id="review_list" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Film</th>
                <th scope="col">Critique</th>
                <th scope="col">Rating</th>
                <th scope="col">Date</th>
                <th scope="col" class="text-center">Editer</th>
                <th scope="col" class="text-center">Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($reviews) && count($reviews) > 0) : ?>
                <?php foreach ($reviews as $review) : ?>
                    <tr>
                        <td class="review_movieName">
                            <p><?php echo escape($review->getMovie()->getTitle()); ?></p>
                        </td>
                        <td class="review_content">
                            <p><?php echo escape($review->getContent()); ?></p>
                        </td>
                        <td class="review_ratingName">
                            <p><?php echo escape($review->getRating()->getName()); ?></p>
                        </td>
                        <td class="review_date">
                            <p><?php echo escape($review->getCreatedAt()->format('Y-m-d')); ?></p>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-edit"></i>
                        </td>
                        <td class="text-center">
                            <i class="fa fa-trash" data-target="#modal-delete-review" data-toggle="modal"
                               data-revid="<?php echo escape($review->getId()); ?>"></i>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>


    <!-- ****************** Delete review confirm box ****************** -->
<!--    <div class="modal fade" id="modal-delete-review" tabindex="-1" role="dialog"-->
<!--         aria-labelledby="modal-delete-review"-->
<!--         aria-hidden="true">-->
<!--        <div class="modal-dialog" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <h5 class="modal-title" id="deletetitle">Supprimer</h5>-->
<!--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                        <span aria-hidden="true">&times;</span>-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="modal-body" id="">-->
<!--                    <form action="review-delete.php" method="post" id="deleteReviewForm"-->
<!--                          enctype="multipart/form-data">-->
<!--                        <div>-->
<!--                            <input type="hidden" class="modalCatId" name="id"/>-->
<!--                            <input type="hidden" id="confirm" name="confirm" value="confirm"/>-->
<!--                            <label for="submitDelete">Etes-vous sur de vouloir supprimer cette catégorie? cette action-->
<!--                                est-->
<!--                                irréversible!</label>-->
<!--                            <input id="submitDelete" type="submit" class="btn btn-primary" value="Supprimer ?"-->
<!--                                   data-dismiss="modal"/>-->
<!--                            <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Annuler</button>-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- ****************** END Delete review confirm box ****************** -->

<?php
require 'review-delete.view.php';

/* ****************** DATATABLES ****************** */
?>
    <script>
        $(document).ready(function () {
            $('#review_list').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false},
                    {"orderable": false},
                ],
                "order": [[3, "asc"]]
            });
        });

    </script>
<?php
/* ****************** END DATATABLES ****************** */


