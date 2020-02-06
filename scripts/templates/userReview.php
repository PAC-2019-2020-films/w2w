<?php
?>


<div class="userReviewInfo card mb-3">
    <div class="card-body">
        <p class="mb-0">Par <?= $userReview->getUser()->getUsername() ?> </p>
        <p class="small"> le <?= $userReview->getCreatedAt()->format('Y-m-d') ?></p>
        <?php
            if ($userReview->getUpdatedAt()) {
                echo "edited*";
            }
        ?>
        
        <div class="userReviewRating">
            <?= $userReview->getRating()->getName() ?>
        </div>
        
        <div class="userReviewContent">
            <?= $userReview->getContent() ?>
        </div>
        
        
        <?php
            if (isset($_SESSION['uid']) && $userReview->getUser()->getId() === $_SESSION['uid']) {
        ?>
        
        <div class="card-footer d-flex justify-content-between">
            <div>
                <button class="btn btn-primary btn-account" data-target="#modal-edit-review" data-toggle="modal">Editer ma critique <i class="fas fa-edit"></i></button>
            </div>
            <?php
                require 'scripts/account/review-edit.view.php';
            ?>
            
            <div>
                <button class="btn btn-primary btn-account" data-target="#modal-delete-review" data-toggle="modal">Supprimer ma critique <i class="fas fa-trash"></i></button>
            </div>
            
        </div>
        <p class="small mb-0">Vous ne pouvez rédiger qu'une critique par film</p>
    </div>
    
    
    <?php
        require 'scripts/account/review-delete.view.php';
        }
    ?>

</div>
</div>
