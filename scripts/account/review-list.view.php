<?php

checkUser();

?>
    <div class="header-dasboard ">
        <div>
            <h1 class="small text-uppercase">Dashboard</h1>
            <h2 class="h4 font-weight-normal">Liste des critiques</h2>
        </div>

    </div>


    <div class="bg-white movie_list p-4">
        <h3 class="h6 font-weight-normal my-4">Mes critiques </h3>
        <div class="flashBag">
            <?php
            \w2w\Utils\Utils::echoMessage();
            ?>
        </div>

        <table id="review_list" class="table table-striped text-center mb-2">
            <thead>
            <tr>
                <th scope="col">Film</th>
                <th scope="col">Critique</th>
                <th scope="col">Rating</th>
                <th scope="col">Date</th>
                <th scope="col">Editer</th>
                <th scope="col">Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($reviews) && count($reviews) > 0) : ?>
                <?php foreach ($reviews as $userReview) : ?>
                    <tr>
                        <td class="review_movieName">
                            <p><?php echo escape($userReview->getMovie()->getTitle()); ?></p>
                        </td>
                        <td class="review_content">
                            <p><?php echo escape($userReview->getContent()); ?></p>
                        </td>
                        <td class="review_ratingName">
                            <p><?php echo escape($userReview->getRating()->getName()); ?></p>
                        </td>
                        <td class="review_date">
                            <p><?php echo escape($userReview->getCreatedAt()->format('Y-m-d')); ?></p>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-edit" data-target="#modal-edit-review" data-toggle="modal" data-revid="<?php echo escape($userReview->getId()); ?>"  data-revcontent="<?php echo escape($userReview->getContent()); ?>"  data-revrating="<?php echo escape($userReview->getRating()->getId()); ?>" data-revmovie="<?php echo escape($userReview->getMovie()->getId()); ?>"></i>
                        </td>
                        <td class="text-center">
                            <i class="fa fa-trash" data-target="#modal-delete-review" data-toggle="modal"
                               data-revid="<?php echo escape($userReview->getId()); ?>"></i>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <hr/>

        <?php
        if (isset($allReviews) && checkAdmin()) :
            ?>

            <h3 class="h6 font-weight-normal my-4">Critiques des Utilisateurs</h3>
            <table id="user_review_list" class="table table-striped text-center">
                <thead>
                <tr>
                    <th scope="col">Film</th>
                    <th scope="col">Critique</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Date</th>
                    <th scope="col"  >Editer</th>
                    <th scope="col"  >Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($allReviews) && count($allReviews) > 0) : ?>
                    <?php foreach ($allReviews as $userReview) : ?>
                        <tr>
                            <td class="review_movieName">
                                <p><?php echo escape($userReview->getMovie()->getTitle()); ?></p>
                            </td>
                            <td class="review_content">
                                <p><?php echo escape($userReview->getContent()); ?></p>
                            </td>
                            <td class="review_ratingName">
                                <p><?php echo escape($userReview->getRating()->getName()); ?></p>
                            </td>
                            <td class="review_date">
                                <p><?php echo escape($userReview->getCreatedAt()->format('Y-m-d')); ?></p>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-edit" data-target="#modal-edit-review" data-toggle="modal"  data-revid="<?php echo escape($userReview->getId()); ?>"  data-revcontent="<?php echo escape($userReview->getContent()); ?>"  data-revrating="<?php echo escape($userReview->getRating()->getId()); ?>" data-revmovie="<?php echo escape($userReview->getMovie()->getId()); ?>" ></i>
                            </td>
                            <td class="text-center">
                                <i class="fa fa-trash" data-target="#modal-delete-review" data-toggle="modal"
                                   data-revid="<?php echo escape($userReview->getId()); ?>"></i>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>


        <?php endif;
        $userReview = null;
        require 'review-delete.view.php';
        require 'review-edit.view.php';
        ?>
    </div>
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

            $('#user_review_list').DataTable({
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

