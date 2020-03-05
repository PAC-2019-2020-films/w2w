<?php
    
    use \w2w\DAO\DAOFactory;
    use \w2w\Model\Role;
    use \w2w\Model\User;
    use \w2w\Utils\FlashManager;
    
    
    checkRoot();
    
    $id     = param("id");
    $roleId = param("role");
    
    $daoFactory = DAOFactory::getDAOFactory();
    $userDAO    = $daoFactory->getUserDAO();
    $user       = $userDAO->find($id);
    $roleDAO    = $daoFactory->getRoleDAO();
    $roles      = $roleDAO->findAll();
    $role       = $roleDAO->find($roleId);
    
    
    $flashManager = new FlashManager();
    
    if (!$user instanceof User) {
        redirectWarning("/admin/", "User not found (#$id)");
    }
    
    if (!$role instanceof Role) {
        redirectWarning("/admin/", "Role not found (#id)");
    }

# si l'utilisateur qu'on modifie est root et que son nouveau rôle n'est pas root :
    if ($user->isRoot() && $role->getName() != "root") {
        $rootRole  = $roleDAO->findByName("root");
        $rootUsers = $userDAO->findByRole($rootRole);
        # si il n'y a pas au moins un autre root en plus de celui-ci :
        if (count($rootUsers) < 2) {
            redirectWarning("/admin/", "You can't remove the last root user");
        }
    }
    
    $movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
    $movies   = $movieDAO->findAll();
    foreach ($movies as $movie) {
        if ($movie->getAdminReview() && $movie->getAdminReview()->getUser()->getId() === $user->getId()) {
            $movie->setAdminReview(null);
        }
    }
    
    
    $user->setRole($role);
    $userDAO->update($user);
    redirectSuccess("/admin/", "Modifié.");



