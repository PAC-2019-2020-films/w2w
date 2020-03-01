<?php
global $user;
checkAdmin();

if (isset($_SESSION['emailVerified']) && !$_SESSION['emailVerified']) {
    \w2w\Utils\Utils::message($_SESSION['emailVerified'], '', 'Remember to validate your email adress. Click here to receive another confirmation email.');
}


?>


<div id="dashboard" >
    <div class="d-flex align-items-stretch">
        <!--Menu -->
        <div id="actionItems" class="dark-bg user w-25 px-4 py-5 align-items-stretch">

            <h2 class="small text-uppercase mb-2">Menu</h2>

                <ul class="list-unstyled mt-4">
                    <li  class="pb-3">
                        <a href="/admin/"> <i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="py-3">
                        <a href="#"  id="profileActions">
                            <i class="fas fa-user"></i> Profil
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  id="movieActions">
                            <i class="fas fa-film"></i> Films
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  id="reviewActions">
                            <i class="fas fa-pen-square"></i> Reviews
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  id="categoryActions">
                            <i class="fas fa-list"></i> Catégories
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  id="tagActions">
                            <i class="fas fa-tags"></i> Tags
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  id="userActions">
                            <i class="fas fa-users-cog"></i> Utilisateurs
                        </a>
                    </li>

                    <li class="py-3">
                        <a href="#"  id="messageActions">
                            <i class="fas fa-envelope"></i> Messages
                        </a>
                    </li>
                    <li class="py-3">
                        <a href="#"  data-target="#modal-delete-account" data-toggle="modal">
                            <i class="fas fa-times-circle"></i> Supprimer mon compte
                        </a>
                    </li>

                </ul>


        </div>

        <!--Content -->
        <div id="actions" class="p-2 w-75 align-self-stretch  m-4">
            <h1 class="small text-uppercase">Dashboard</h1>
            <h3 class="h4 font-weight-normal">Vue d'ensemble</h3>
            <hr/>
            <div class="row">

                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="h6">Bienvenue !</h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">
                                <?= $user->getUserName(); ?>
                            </p>
                            <p>
                                <?= $user->getRole()->getName(); ?>

                            </p>

                        </div>


                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h class="h5 font-weight-normal">Derniers films ajoutés</h>
                <hr/>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modal-delete-account" tabindex="-1" role="dialog" aria-labelledby="modal-delete-account"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginlabel">Supprimer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <p>Etes-vous sur de vouloir supprimer votre compte? Cette action est irréversible!</p>
                    <a class="btn btn-primary"
                       href="../account/delete_account.php?id=<?php echo escape($user->getId()) ?>">
                        oui</a>
                    <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> nah</button>
                </div>
            </div>
        </div>
    </div>
</div>
