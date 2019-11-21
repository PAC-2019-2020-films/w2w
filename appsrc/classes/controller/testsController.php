<?php
namespace controller;

class testsController extends BaseController
{
    
    protected $layout = "layouts/layout.tests";
    
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
