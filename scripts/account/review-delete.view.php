
<!-- *************** MODAL DELETE REVIEW *************** -->
<div class="modal fade" id="modal-delete-review<?php echo escape($userReview->getId())?>" tabindex="-1" role="dialog" aria-labelledby="modal-delete-review"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Etes-vous sur de vouloir supprimer votre critique? Cette action est irréversible!</p>
                <a class="btn btn-primary modalRevId" href="/account/review-delete.php?id=<?php if (isset($userReview)) {
                    echo escape($userReview->getId());
                } ?>">
                    oui </a>
                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> nah</button>
            </div>
        </div>
    </div>
</div>
<!-- *************** END MODAL DELETE REVIEW *************** -->


