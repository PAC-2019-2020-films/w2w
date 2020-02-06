<?php
?>


<div class="">
    
    <div class="userReviewInfo">
        <p>Par <?= $userReview->getUser()->getUsername() ?></p>
        <p>Le <?= $userReview->getCreatedAt()->format('Y-m-d') ?></p>
        <?php
            if ($userReview->getUpdatedAt()) {
                echo "edited*";
            }
        ?>
    </div>
    
    <div class="userReviewRating">
        <?= $userReview->getRating()->getName() ?>
    </div>
    
    <div class="userReviewContent">
        <?= $userReview->getContent() ?>
    </div>
    
    
    <?php
        if (isset($_SESSION['uid']) && $userReview->getUser()->getId() === $_SESSION['uid']) {
            ?>
            
            <div>
                <button class="btn btn-primary btn-account" data-target="#modal-edit-review" data-toggle="modal">Editer ma critique <i class="fas fa-edit"></i></button>
            </div>
            <?php
            require 'scripts/account/review-edit.view.php';
            ?>
            
            <div>
                <button class="btn btn-primary btn-account" data-target="#modal-delete-review" data-toggle="modal">Supprimer ma critique <i class="fas fa-trash"></i></button>
            </div>
            
            <?php
            require 'scripts/account/review-delete.view.php';
        }
    ?>

</div>

