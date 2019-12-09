<?php

namespace controller;

use w2w\DAO\CategoryDAO;
use w2w\Model\Artist;
use w2w\Model\Category;
use w2w\Model\Movie;
use w2w\Service\ArtistAdminService;
use w2w\Service\CategoryAdminService;
use w2w\Service\CategoryPublicService;
use w2w\Service\MovieAdminService;

class IndexController extends BaseController
{

    public function action_index()
    {
        return $this->forgeView("index");
    }

    public function action_contact()
    {
        $this->setLayoutTitle("Contact");
        return "contact...";
    }


    public function action_login()
    {
        $email = $this->getParameter("email");
        $password = $this->getParameter("password");
        if ($email && $password) {
            $user = $this->getPublicService()->login($email, $password);
            if ($user) {
                \Fr\Session::getSession()->set("user", $user);
                return sprintf("logged in as %s", $user->getUserName());
            }
        }
        $this->setLayoutTitle("login");
        return $this->forgeView("login");
    }

    public function action_logout()
    {
        if ($this->isPost()) {
            session_unset();
            session_destroy();
            header("Location: /");
        } else {
            $this->setLayoutTitle("logout");
            return $this->forgeView("logout");
        }
    }

}
