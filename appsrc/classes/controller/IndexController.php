<?php

namespace controller;

use w2w\DAO\CategoryDAO;
use w2w\Model\Artist;
use w2w\Model\Category;
use w2w\Model\Movie;
use w2w\Model\User;
use w2w\Service\ArtistAdminService;
use w2w\Service\CategoryAdminService;
use w2w\Service\CategoryPublicService;
use w2w\Service\MovieAdminService;

class IndexController extends BaseController
{

    public function action_index()
    {
        $movies = $this->getPublicService()->getMoviesAll();
        $tags = $this->getPublicService()->getTags();
        $categories = $this->getPublicService()->getCategories();
        $viewData = [
            "movies" => $movies,
            "tags" => $tags,
            "categories" => $categories,
        ];
        return $this->forgeView("index", $viewData);
    }

    public function action_contact()
    {
        $this->setLayoutTitle("Contact");
        return "contact...";
    }






    /**
     * connexion de l'utilisateur
     * 
     * C'est l'id du User qui est stocké dans la session, pas l'objet User lui-même,
     * pour des raisons techniques liées aux risques de sérialisation/désérialisation d'objets Doctrine :
     * https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/cookbook/entities-in-session.html
     * 
     * (un $em->merge() pourrait sans doute régler le pb, mais osef, surtout que ça devient incompatible avec les DAO de type PDO)
     */
    public function action_login()
    {
        if ($this->hasUser()) {
            # utilisateur déjà connecté
            return sprintf("À quoi bon tout ça, %s ?", $this->getUser()->getUserName());
        }
        if ($this->isPost()) {
            # requête HTTP avec méthode POST, en principe envoyée par le formulaire de connexion
            $email = $this->getParameter("email");
            $password = $this->getParameter("password");
            if ($email && $password) {
                $user = $this->getPublicService()->login($email, $password);
                if ($user instanceof User) {
                    \Fr\Session::getSession()->set("user", $user->getId());
                    $this->setLayoutProperty("user", $user);
                    return \Fr\Config::get("login.message", "Welcome.");
                    #return sprintf("You are logged in as %s, role=%s.", $user->getUserName(), $user->getRole()->getName());
                }
            }
            return "Quelque chose a merdé, visiblement.";
        } else {
            # requête HTTP avec méthode GET, affichage du formulaire de connexion
            $this->setLayoutTitle("login");
            return $this->forgeView("login");
        }
    }

    /**
     * déconnexion de l'utilisateur
     */
    public function action_logout()
    {
        if (! $this->hasUser()) {
            # utilisateur déjà non connecté
            return "You must be kidding.";
        }
        if ($this->isPost()) {
            # requête HTTP avec méthode POST, en principe envoyée par le formulaire de déconnexion
            # destruction session
            \Fr\Session::destroy();
            if (\Fr\Config::get("logout.redirect", false)) {
                # redirection HTTP vers racine du serveur
                header("Location: /");
                exit();
            } else {
                # simple message de confirmation
                $this->setUser(null);
                $this->setLayoutProperty("user", null);
                return \Fr\Config::get("logout.message", "You are logged out.");
            }
        } else {
            # requête HTTP avec méthode GET, affichage du formulaire de déconnexion
            $this->setLayoutTitle("logout");
            return $this->forgeView("logout");
        }
    }

}
