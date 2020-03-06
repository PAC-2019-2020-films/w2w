<?php
global $user;
?>


<div class="userReviewInfo mb-3">

    <p class="userReviewRating">
        <?= $userReview->getRating()->getName() ?>
    </p>

    <div class="userReviewContent">
        <?= $userReview->getContent() ?>
    </div>

    <p class="small mb-0 text-right">
        Par <?= $userReview->getUser()->getUsername() ?>
        le <?= $userReview->getCreatedAt()->format('d/m/Y') ?>

        <?php
        if ($userReview->getUpdatedAt()) {
            echo "edited*";
        }
        ?>

        <?php
        if ((isset($_SESSION['uid']) && $userReview->getUser()->getId() === $_SESSION['uid']) || ($user instanceof \W2w\Model\User && $user->getRole()->getId() > $userReview->getUser()->getRole()->getId())) {
            ?>

            <a href="" class="ml-2" data-target="#modal-edit-review<?php echo escape($userReview->getId()) ?>"
               data-toggle="modal"><i class="fas fa-edit"></i> Editer ma
                critique</a>
            <a href="" class="ml-2" data-target="#modal-delete-review<?php echo escape($userReview->getId()) ?>"
               data-toggle="modal"> <i class="fas fa-trash"></i> Supprimer ma
                critique</a>


            <?php
            require 'scripts/account/review-edit.view.php';
            ?>

            <?php
            require 'scripts/account/review-delete.view.php';

        } else {
            ?>

            <a href="#" class="ml-2" data-target="#modal-report-review<?php echo escape($userReview->getId()) ?>"
               data-toggle="modal"><i
                        class="fas fa-exclamation-circle"></i> Signaler </a>
            <?php
        }


        ?>
    </p>
</div>

<!-- *************** REPORT REVIEW MODAL *************** -->
<div class="modal fade" id="modal-report-review<?php echo escape($userReview->getId()) ?>" tabindex="-1" role="dialog"
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
                        <input type="hidden" class="reviewReportId" name="id" value="<?= $userReview->getId() ?>"/>
                        <input type="hidden" name="movieId" value="<?= $userReview->getMovie()->getId() ?>">
                        <textarea name="reportContent" id="reportContent" cols="30" rows="10"
                                  placeholder="Explication du probleme"></textarea>
                        <input id="submitReport" type="submit" class="btn btn-primary" value="Envoyer"/>
                        <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- *************** END REPORT REVIEW MODAL *************** -->
