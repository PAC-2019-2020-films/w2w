
<?php
    if (isset($userReview)) {
        $ratingDAO = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
        $ratings = $ratingDAO->findAll();
        $movieId = param('id');
        ?>
        
        <div class="modal fade" id="modal-edit-review" tabindex="-1" role="dialog" aria-labelledby="modal-login"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editlabel">edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="">
                        <form action="account/review-edit.php" method="post" id="update-review-user">
                            <select name="rating" id="">
                                <?php
                                    foreach ($ratings as $rating) {
                                        ?>
                                        <option value="<?= $rating->getId() ?>"><?= $rating->getName() ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <textarea name="comment" id="updateComment" cols="80" rows="10" title="">
                                <?php
                                    echo escape($userReview->getContent());
                                ?>
                                
                            </textarea>
    
                            <script>
                                CKEDITOR.replace( 'updateComment' );
                            </script>
                            <input type="hidden" name="reviewId" value="<?php echo escape($userReview->getId()); ?>">
                            <input type="hidden" name="movieId" value="<?php echo escape($movieId); ?>">
                            <input type="submit" class="btn btn-primary">
                        </form>
                        <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    
    <?php }
