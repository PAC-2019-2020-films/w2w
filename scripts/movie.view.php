<?php



if (isset($movie) && $movie instanceof \w2w\Model\Movie) : ?>

    <div class="header header-movie" >
        <div class="header-bg">
            <img src="/uploads/<?php echo $movie->getPoster(); ?>-big.jpg" class="d-block w-100 movie_affiche"
                 alt="...">
            <div class="header-caption">
                <div class="movie-tags ">
                    <?php echo template("movie.tags.php", ["movie" => $movie]); ?>
                </div>
                <h2 class="clearfix pt-1"><?php echo $movie->getTitle(); ?></h2>
                <!-- Film info -->
                <?php echo template("movie.data.php", ["movie" => $movie]); ?>
            </div>
        </div>
    </div>

    <div class="movie-content py-5">

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="movie-box dark-bg ">
                        <img src="/uploads/<?php echo escape($movie->getPoster()); ?>-medium.jpg" class=" w-100 img-fluid"
                             alt=""/>

                        <ul class="movie-infos list-unstyled px-4 py-4 movies-data">
                            <li class="text-left"><span class="text-secondary">Année de sortie : </span><?php echo $movie->getYear(); ?> </li>

                            <li><span class="text-secondary">De :</span>
                                <?php foreach ($movie->getDirectors() as $director) : ?>
                                    <?php echo escape($director->getFirstName()); ?>
                                    <?php echo escape($director->getLastName()); ?>
                                <?php endforeach; ?>
                            </li>

                            <li><span class="text-secondary">Avec :</span>
                                <?php
                                $arrActors = $movie->getActors();
                                foreach ($movie->getActors() as $actor) : ?>
                                    <?php echo escape($actor->getFirstName()); ?>
                                    <?php echo escape($actor->getLastName());
                                     if($actor !== end($arrActors)) {
                                         echo ',';
                                     }
                                    ?>

                                <?php endforeach; ?>
                            </li>

                        </ul>


                    </div>
                </div>

                <div class="col-md-8 info-film px-5 py-4 light-bg">
                    <?php


                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-' . $_SESSION['message']['type'] . '" role="alert">' . $_SESSION['message']['msg'] . '</div>';
                    }
                    unset($_SESSION['message']);

                    ?>
                    <h3 class="mb-2 h4">Synopsis</h3>
                    <span class="line-title"><hr/></span>
                    <p>
                        <?php echo $movie->getDescription(); ?>
                    </p>
                    <div class="flex-wrap mb-4">
                        <div class="flex-left">
                            <h4 class="rating-title">W2W</h4>
                            <?php
                            if ($adminReview) {
                                echo $adminReview->getRating()->getName();
                            } else {
                                /**
                                 * TODO : aucune review format
                                 */
                                echo "Pas encore d'évaluation de w2w";
                            }
                            ?>
                        </div>
                        <div class="flex-center">
                            <h4 class="rating-title">Utilisateurs</h4>
                            <?php
                            if ($averageUserRating) {
                                echo $averageUserRating->getName();
                            } else {
                                echo "Pas encore d'évaluation utilisateur";
                            }
                            ?>
                        </div>
                        <div class="flex-right">

                        </div>
                    </div>

                    <hr/>

                    <h3 class="h6 mt-4">L'avis de w2w </h3>
                    <span class="line-title"><hr/></span>
                    <p>
                        <?php
                        if ($adminReview) {
                            echo template("userReview.php", ["userReview" => $adminReview]);
                        } else {
                            /**
                             * TODO : aucune review format
                             */
                            echo "Aucune review de w2w.";
                        }
                        ?>
                    </p>

                    <h5 class="mt-3 h6">L'avis des utilisateurs</h5>

                    <span class="line-title"><hr/></span>

                    <?php

                    if (!$hasAlreadyReviewed) {
                        ?>
                        <div class="form_user-review light-bg mb-3">

                            <?php if (!isset($_SESSION["user"])) {
                                ?>
                                <!--                            <a href="authentication/login.php" class="btn-sm btn-primary  d-inline-block">Rédigez votre critique</a>-->
                                <a class="btn-sm btn-primary py-2 " data-target="#modal-login" data-toggle="modal"> <i class="fas fa-pencil-alt"></i> Rédigez votre critique</a>

                            <?php } else {
                                ?>
                                <form action="account/review-add.php" method="post" id="insert-review-user"
                                      class="form-group">

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

                                    <textarea name="comment" id="comment" cols="80" rows="10" title="" class="form-control"
                                              placeholder=""></textarea>


                                    <script>
                                        CKEDITOR.replace('comment');
                                    </script>
                                    <input type="hidden" name="movieId" value="<?= $movie->getId() ?>">

                                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Envoyer</button>

                                </form>
                                <hr/>

                                <?php
                            }
                            ?>

                        </div>

                        <?php
                    }

                    ?>

                    <?php
                    if (!$movie->getReviews()) {
                        /**
                         * TODO : aucune review format
                         */
                        echo "Aucune review utilisateur.";
                    } else {
                        foreach ($movie->getReviews() as $userReview) {
//                                    Afficher la review sauf si c'est la review admin
                            if (!$movie->getAdminReview() || $movie->getAdminReview()->getId() != $userReview->getId())
                                echo template("userReview.php", ["userReview" => $userReview]);
                        }
                    }
                    ?>

                </div>
            </div>


        </div>
    </div>


<?php

endif;