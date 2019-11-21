<?php
namespace controller\account;

use \controller\BaseUserController;

/**
 * contrôleur pour gestion des Review du compte
 * 
 */
class reviewController extends BaseUserController
{
    
    public function action_index()
    {
        $this->setLayoutTitle("account/review");
        return $this->forgeView("account/review_list");
    }
    
}
