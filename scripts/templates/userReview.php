<?php
    global $user;
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
        
        <?php if ($user) {
            ?>
            <div class="reportReview">
                <button class="btn btn-primary" data-target="#modal-report-review" data-toggle="modal">Report</button>
            </div>
            
            <?php
        }
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

<!-- *************** REPORT REVIEW MODAL *************** -->
<div class="modal fade" id="modal-report-review" tabindex="-1" role="dialog"
     aria-labelledby="modal-report-review"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-report-review">Signalez un abus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                <form action="../account/send-report.php" method="post" id="reportReviewForm"
                      enctype="multipart/form-data">
                    <div>
                        <input type="hidden" class="reviewReportId" name="id" value="<?=$userReview->getId()?>"/>
                        <input type="hidden" name="movieId" value="<?=$userReview->getMovie()->getId()?>">
                        <textarea name="reportContent" id="reportContent" cols="30" rows="10" placeholder="Explication du probleme"></textarea>
                        <input id="submitReport" type="submit" class="btn btn-primary" value="Envoyer"/>
                        <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- *************** END REPORT REVIEW MODAL *************** -->
