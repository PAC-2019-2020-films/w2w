<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:27
 */

namespace w2w\Service;


use \w2w\DAO\MovieDAO;
use \w2w\DAO\CategoryDAO;
use \w2w\DAO\RatingDAO;
use \w2w\DAO\ReviewDAO;
use \w2w\DAO\UserDAO;
use \w2w\DAO\RoleDAO;
use \w2w\DAO\MovieActorDAO;
use \w2w\DAO\MovieDirectorDAO;
use \w2w\DAO\MovieTagsDAO;

use \w2w\Model\Artist;
use \w2w\Model\Category;
use \w2w\Model\Movie;
use \w2w\Model\Rating;
use \w2w\Model\Review;
use \w2w\Model\Role;
use \w2w\Model\Tag;
use \w2w\Model\User;

class PublicService extends BaseService
{

    /**
     * PublicService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function login($email, $password)
    {
        if ($user = $this->getUserDAO()->findByEmail($email)) {
            if (password_verify($password, $user->getPasswordHash())) {
                return $user;
            }
        }
        return false;
    }



    /**
     * @param int $id
     * @return User
     */
    public function getUserById(int $id)
    {
        return $this->getUserDAO()->find($id);
    }

    /**
     * getUserByMail
     * @param string $mail
     * @return User
     */
    public function getUserByMail(string $mail)
    {
        return $this->getUserDAO()->findByEmail($mail);
    }

    /**
     * getUserByUserName
     * @param string $userName
     * @return User
     */
    public function getUserByUserName(string $userName)
    {
        return $this->getUserDAO()->findByUserName($userName);
    }




    public function getMoviesAll()
    {
        return $this->getMovieDAO()->findAll();
    }

    public function getCategories()
    {
        return $this->getCategoryDAO()->findAll();
    }

    public function getTags()
    {
        return $this->getTagDAO()->findAll();
    }

}
