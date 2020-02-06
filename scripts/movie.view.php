<?php
    /*
     * Page d'un film - TO DO
     *
     */
    
    
    if (isset($_SESSION['message'])) {
        echo '
    <div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
    }
    unset($_SESSION['message']);
?>

<?php if (isset($movie) && $movie instanceof \w2w\Model\Movie) : ?>
    
    <div class="page-title " style="background :url('uploads/<?php echo $movie->getPoster(); ?>-big.jpg');">
        
        <div class="container">
            <?php echo template("movie.tags.php", ["movie" => $movie]); ?>
            <h2 class="clearfix pt-3"><?php echo $movie->getTitle(); ?></h2>
            <!-- Film info -->
            <?php echo template("movie.data.php", ["movie" => $movie]); ?>
        </div>
    
    </div>
    
    <div class="movie-content py-5">
        
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="movie-box dark-bg ">
                        <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" class="img-fluid"
                             alt=""/>
                        
                        <ul class="movie-infos list-unstyled px-4 py-4">
                            <li class="text-left">Année de sortie : <span
                                        class="text-right"> <?php echo $movie->getYear(); ?></span></li>
                            <li>Durée:</li>
                            
                            <li>De:
                            
                            </li>
                            <li>Genre:</li>
                            <li>Nationalité:</li>
                        </ul>
                    
                    </div>
                </div>
                <div class="col-md-8 info-film">
                    
                    <h3>Synopsis</h3>
                    
                    <p>
                        <?php echo $movie->getDescription(); ?>
                    </p>
                    <div class="flex-wrap">
                        <div class="flex-left">
                            <h4 class="rating-title">W2W</h4>
                        </div>
                        <div class="flex-center">
                            <h4 class="rating-title">Utilisateurs</h4>
                        
                        </div>
                        <div class="flex-right">
                        
                        </div>
                    </div>
                    <h3>L'avis de w2w </h3>
                    
                    <p class="subtitle small"></p>
                    <span class="line-title"><hr/></span>
                    
                    <p>
                        /*Insert Review w2w here*/
                    </p>
                    <span class="line-title"><hr/></span>
                    
                    <h3>Ce que les utilisateurs en pensent</h3>
                    <div class="user_reviews">
                        <?php
                            if (!$movie->getReviews()) {
                                /**
                                 * TODO : aucune review format
                                 */
                                echo "aucune review utilisateur.";
                            } else {
                                foreach ($movie->getReviews() as $userReview) {
                                    echo template("userReview.php", ["userReview" => $userReview]);
                                }
                            }
                        ?>
                    </div>
                    <?php
                        if (!$hasAlreadyReviewed) {
                            ?>
                            <div class="form_user-review mt-3">
                                <div class="line-title">
                                    <hr>
                                </div>
                                <h4>Et vous, qu'en pensez-vous ?</h4>
                                <form action="account/review-add.php" method="post" id="insert-review-user" class="form-group">
                                    <label for="rating">C'est un : </label>
                                    <select name="rating" id="rating" class="form-control mb-3">
                                        <?php
                                            foreach ($ratings as $rating) {
                                                ?>
                                                <option value="<?= $rating->getId() ?>"><?= $rating->getName() ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <textarea name="comment" id="comment" cols="80" rows="10" title="" class="form-control"></textarea>
                                    
                                    
                                    <script>
                                        CKEDITOR.replace('comment');
                                    </script>
                                    <input type="hidden" name="movieId" value="<?= $movie->getId() ?>">
                                    <?php if (isset($_SESSION["user"])) {
                                        ?>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Envoyer</button>
                                    
                                    <?php } else {
                                        ?>
                                        <a href="authentication/login.php" class="btn btn-primary btn-lg btn-block">Login to submit
                                            your own review</a>
                                        <?php
                                    }
                                    ?>
                                </form>
                            </div>
                </div>
                            <?php
                        }
                    
                    ?>
                </div>
            
            
            </div>
        </div>
    </div>

<?php

endif;

