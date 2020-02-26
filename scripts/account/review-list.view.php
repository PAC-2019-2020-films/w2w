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

<?php
    if (isset($allReviews) && checkAdmin()) {
        ?>
        <div class="container-fluid category_list">
            <h2>Critiques des Utilisateurs</h2>
            <table id="user_review_list" class="table table-striped">
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
                    if (isset($allReviews) && count($allReviews) > 0) : ?>
                        <?php foreach ($allReviews as $review) : ?>
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
        
        <?php
    }
    
    
    require 'review-delete.view.php';
    
    
?>
    <div>
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
    </div>
<?php

