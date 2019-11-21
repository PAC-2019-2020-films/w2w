<?php
namespace controller\admin;

use \controller\BaseAdminController;

/**
 * contrôleur pour gestion des Utilisateurs par les admins
 * 
 */
class userController extends BaseAdminController
{
    
    public function action_index()
    {
        $this->setLayoutTitle("admin/user");
        return $this->forgeView("admin/user_list");
    }
    
}
