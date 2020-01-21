<?php

use w2w\DAO\DAOFactory;
use w2w\DAO\ArtistDAO;
use w2w\DAO\AuthenticationTokenDAO;
use w2w\DAO\CategoryDAO;
use w2w\DAO\MessageDAO;
use w2w\DAO\MovieDAO;
use w2w\DAO\RatingDAO;
use w2w\DAO\ReportDAO;
use w2w\DAO\ReviewDAO;
use w2w\DAO\RoleDAO;
use w2w\DAO\TagDAO;
use w2w\DAO\UserDAO;
use w2w\Model\Artist;
use w2w\Model\AuthenticationToken;
use w2w\Model\Category;
use w2w\Model\Message;
use w2w\Model\Movie;
use w2w\Model\Rating;
use w2w\Model\Report;
use w2w\Model\Review;
use w2w\Model\Role;
use w2w\Model\Tag;
use w2w\Model\User;





/** 
 * Service créé pour le remplissage de la db dans le script 'populate.php' en cli
 * 
 * 
 * Copié-collé ici suite suppression des classes Service
 */
class ScriptService
{
    
    protected $daoFactory;
    protected $force = false;
    
    /**
     * ScriptService constructor.
     */
    public function __construct()
    {
    }
    

    
    public function info($msg)
    {
        echo sprintf("<INFO> %s\n", $msg);
    }





    protected function getDAOFactory(): DAOFactory
    {
        if (! $this->daoFactory) {
            $this->daoFactory = DAOFactory::getDAOFactory();
        }
        return $this->daoFactory;
    }
    
    protected function getArtistDAO(): ArtistDAO
    {
        return $this->getDAOFactory()->getArtistDAO();
    }
    
    protected function getAuthenticationTokenDAO(): AuthenticationTokenDAO
    {
        return $this->getDAOFactory()->getAuthenticationTokenDAO();
    }
    
    protected function getCategoryDAO(): CategoryDAO
    {
        return $this->getDAOFactory()->getCategoryDAO();
    }
    
    protected function getMessageDAO(): MessageDAO
    {
        return $this->getDAOFactory()->getMessageDAO();
    }
    
    protected function getMovieDAO(): MovieDAO
    {
        return $this->getDAOFactory()->getMovieDAO();
    }
    
    protected function getRatingDAO(): RatingDAO
    {
        return $this->getDAOFactory()->getRatingDAO();
    }
    
    protected function getReportDAO(): ReportDAO
    {
        return $this->getDAOFactory()->getReportDAO();
    }
    
    protected function getReviewDAO(): ReviewDAO
    {
        return $this->getDAOFactory()->getReviewDAO();
    }
    
    protected function getRoleDAO(): RoleDAO
    {
        return $this->getDAOFactory()->getRoleDAO();
    }
    
    protected function getTagDAO(): TagDAO
    {
        return $this->getDAOFactory()->getTagDAO();
    }
    
    protected function getUserDAO(): UserDAO
    {
        return $this->getDAOFactory()->getUserDAO();
    }



    public function addRole($id, $name, $desc)
    {
        if (! $this->force && ($role = $this->getRoleDAO()->find($id))) {
            $this->info("role already present (id='$id'), ignoring");
        } elseif (! $this->force && ($role = $this->getRoleDAO()->findByName($name))) {
            $this->info("role already present (name='$name'), ignoring");
        } else {
            $this->info("adding role ($id, $name, $desc)...");
            $role = new Role($id, $name, $desc);
            $this->getRoleDAO()->save($role);
        }
    }
    
    public function addUser($userName, $email, $emailVerified, $password, $firstName, $lastName, $createdAt, $updatedAt, $lastLoginAt, $banned, $numberReviews, $roleName)
    {
        if (! $this->force && ($user = $this->getUserDAO()->findByUserName($userName))) {
            $this->info("user already present (userName='$userName'), ignoring");
        } elseif (! $this->force && ($user = $this->getUserDAO()->findByEmail($email))) {
            $this->info("user already present (email='$email'), ignoring");
        } else {
            $this->info("adding user ($userName, $email)...");
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $role = $this->getRoleDAO()->findByName($roleName);
            $user = new User(null, $userName, $email, $emailVerified, $passwordHash, $firstName, $lastName, $createdAt, $updatedAt, $lastLoginAt, $banned, $numberReviews, $role);
            $this->info("adding user ($user)...");
            $this->getUserDAO()->save($user);
        }
    }

    public function addRating($name, $desc, $value)
    {
        if (! $this->force && ($rating = $this->getRatingDAO()->findByValue($value))) {
            $this->info("rating already present (value='$value'), ignoring");
        } elseif (! $this->force && ($rating = $this->getRatingDAO()->findByName($name))) {
            $this->info("rating already present (name='$name'), ignoring");
        } else {
            $this->info("adding rating ($name, $desc, $value)...");
            $rating = new Rating(null, $name, $desc, $value);
            $this->getRatingDAO()->save($rating);
        }
    }

    public function addTag($name, $desc)
    {
        if (! $this->force && ($tag = $this->getTagDAO()->findByName($name))) {
            $this->info("tag already present ('$name'), ignoring");
        } else {
            $this->info("adding tag ($name, $desc)...");
            $tag = new Tag(null, $name, $desc);
            $this->getTagDAO()->save($tag);
        }
    }

    public function addCategory($name, $desc)
    {
        if (! $this->force && ($category = $this->getCategoryDAO()->findByName($name))) {
            $this->info("category already present ('$name'), ignoring");
        } else {
            $this->info("adding category ($name, $desc)...");
            $tag = new Category(null, $name, $desc);
            $this->getCategoryDAO()->save($tag);
        }
    }
    
    public function addMovie($title, $desc, $year, $poster, $categoryName, $tagNames) : ?Movie
    {
        if (! $this->force && ($movie = $this->getMovieDAO()->findByTitle($title))) {
            $this->info("movie already present ('$title'), ignoring");
            return null;
        } else {
            $this->info("adding movie ($title, $desc, $year, $poster, $categoryName)...");
            $category = $this->getCategoryDAO()->findByName($categoryName);
            $movie = new Movie(null, $title, $desc, $year, $poster, $category);
            foreach ($tagNames as $tagName) {
                if ($tag = $this->getTagDAO()->findByName($tagName)) {
                    $movie->addTag($tag);
                }
            }
            $this->getMovieDAO()->save($movie);
            return $movie;
        }
    }
    
    /**
     * 
     * @todo compute real final rating of the movie after adding this new review and its rating
     */
    public function addReview($content, $createdAt, $updatedAt, $movie, $userName, $ratingValue) : ?Review
    {
        $user = $this->getUserDAO()->findByUserName($userName);
        $rating = $this->getRatingDAO()->findByValue($ratingValue);
        if (! $movie) {
            $this->info("adding review ($content, $movie, $user, $rating), no movie, ignoring");
        } elseif (! $user) {
            $this->info("adding review ($content, $movie, $user, $rating), no user, ignoring");
        } elseif (! $rating) {
            $this->info("adding review ($content, $movie, $user, $rating), no rating, ignoring");
        } else {
            $this->info("adding review ($content, $movie, $user, $rating)...");
            $review = new Review(null, $content, $createdAt, $updatedAt, $movie, $user, $rating);
            $this->getReviewDAO()->save($review);
            
            /*
             * !!!!!!!!!!!!!!!!!!
             * gives the movie the same rating as its last added review :
             * (temporary solution)
             */
            $movie->setRating($rating);
            $this->getMovieDAO()->update($movie);
            
            return $review;
        }
        return null;
    }
 
    public function addReport($message, $createdAt, $treated, $userName, $review): ?Report
    {
        $user = $this->getUserDAO()->findByUserName($userName);
        if (! $user) {
            $this->info("adding report ($message, $user, $review), no user, ignoring");
        } elseif (! $review) {
            $this->info("adding report ($message, $user, $review), no review, ignoring");
        } else {
            $this->info("adding report ($message, $user, $review)...");
            $report = new Report(null, $message, $createdAt, $treated, $user, $review);
            $this->getReportDAO()->save($report);
            return $report;
        }
        return null;
    }
 
    public function addMessage($firstName, $lastName, $email, $content, $createdAt, $treated): ?Message
    {
        $this->info("adding message ($firstName, $lastName, $email, $content, $treated)...");
        $message= new Message(null, $firstName, $lastName, $email, $content, $createdAt, $treated);
        $this->getMessageDAO()->save($message);
        return $message;
    }
    
    public function addAuthenticationToken($email, $token, $expiresAt, $verifiedAt, $newPassword, $userName): ?AuthenticationToken
    {
        $user = $this->getUserDAO()->findByUserName($userName);
        $authenticationToken = new AuthenticationToken(null, $email, $token, $expiresAt, $verifiedAt, $newPassword, $user);
        $this->getMessageDAO()->save($authenticationToken);
        return $authenticationToken;
    }
    
    public function addArtist($firstName, $lastName, $actorTitles, $directorTitles): ?Artist
    {
        if ($firstName || $lastName) {
            $artist = new Artist(null, $firstName, $lastName);
            if (is_array($actorTitles)) {
                foreach ($actorTitles as $title) {
                    if ($movie = $this->getMovieDAO()->findByTitle($title)) {
                        $movie->addActor($artist);
                    }
                }
            }
            if (is_array($directorTitles)) {
                foreach ($directorTitles as $title) {
                    if ($movie = $this->getMovieDAO()->findByTitle($title)) {
                        $movie->addDirector($artist);
                    }
                }
            }
            $this->getArtistDAO()->save($artist);
            return $artist;
        }
    }
 
    public function deleteAll()
    {
        (new \w2w\DAO\Doctrine\DoctrineGenericDAO(null))->exec("DELETE FROM movies_tags");
        (new \w2w\DAO\Doctrine\DoctrineGenericDAO(null))->exec("DELETE FROM movies_actors");
        (new \w2w\DAO\Doctrine\DoctrineGenericDAO(null))->exec("DELETE FROM movies_directors");
        $this->getMessageDAO()->deleteAll(true);
        $this->getArtistDAO()->deleteAll(true);
        $this->getReportDAO()->deleteAll(true);
        $this->getReviewDAO()->deleteAll(true);
        $this->getMovieDAO()->deleteAll(true);
        $this->getTagDAO()->deleteAll(true);
        $this->getCategoryDAO()->deleteAll(true);
        $this->getRatingDAO()->deleteAll(true);
        $this->getAuthenticationTokenDAO()->deleteAll(true);
        $this->getUserDAO()->deleteAll(true);
        $this->getRoleDAO()->deleteAll();
    }
    
}



/**
 * classe qui remplit la bdd avec les données d'un fichier xml
 */
class DBPopulator
{

    protected $xml;
    protected $service;

    public function __construct($configFilePath = FR_APPPATH . "/scripts-cli/populate.xml")
    {
        if (! is_file($configFilePath)) {
            throw new \Exception("xml data path not found");
        }
        $xmlString = file_get_contents($configFilePath);
        $this->xml = new \SimpleXMLElement($xmlString);
        if (! $this->xml) {
            echo "No correct xml string data, aborting\n";
            exit();
        }
        $this->service = new ScriptService();
    }
    
    public function attr($xmlElement, $attrName, $default = null)
    {
        if (isset($xmlElement[$attrName])) {
            return (string) $xmlElement[$attrName];
        }
        return $default;
    }
    
    
    
    public function run()
    {
        $root = $this->xml;
        $this->service->deleteAll();
        
        foreach ($root->rating as $element) {
            $name = $this->attr($element, "name");
            $desc = $this->attr($element, "desc");
            $value = $this->attr($element, "value");
            if ($name && $value) {
                $this->service->addRating($name, $desc, $value);
            }
        }
        
        foreach ($root->role as $element) {
            $id = $this->attr($element, "id");
            $name = $this->attr($element, "name");
            $desc = $this->attr($element, "desc");
            if ($id && $name) {
                $this->service->addRole($id, $name, $desc);
            }
        }
        
        foreach ($root->user as $element) {
            $userName = $this->attr($element, "name");
            $email = $this->attr($element, "email");
            $emailVerified = $this->attr($element, "emailVerified", true);
            $password = $this->attr($element, "password", $userName);
            $firstName = $this->attr($element, "firstName");
            $lastName = $this->attr($element, "lastName");
            $createdAt = $this->attr($element, "createdAt");
            $updatedAt = $this->attr($element, "updatedAt");
            $lastLoginAt = $this->attr($element, "lastLoginAt");
            $banned = $this->attr($element, "banned", false);
            $numberReviews = $this->attr($element, "numberReviews", 0);
            $roleName = $this->attr($element, "role", "user");
            if (strtolower($emailVerified) == "false") {
                $emailVerified = false;
            }
            if (! $password) {
                $password = $userName;
            }
            if (! $createdAt) {
                $createdAt = date("Y-m-d H:i:s");
            }
            $createdAt = new \DateTime($createdAt);
            if ($updatedAt) {
                $updatedAt = new \DateTime($$updatedAt);
            }
            if ($lastLoginAt) {
                $lastLoginAt = new \DateTime($lastLoginAt);
            }
            if ($userName && $email && $password) {
                $this->service->addUser($userName, $email, $emailVerified, $password, $firstName, $lastName, $createdAt, $updatedAt, $lastLoginAt, $banned, $numberReviews, $roleName);
            }
        }
        
        
        
        
        foreach ($root->tag as $element) {
            $name = $this->attr($element, "name");
            $desc = $this->attr($element, "desc");
            if ($name) {
                $this->service->addTag($name, $desc);
            }
        }
        foreach ($root->category as $element) {
            $name = $this->attr($element, "name");
            $desc = $this->attr($element, "desc");
            if ($name) {
                $this->service->addCategory($name, $desc);
            }
        }
        foreach ($root->movie as $element) {
            $title = $this->attr($element, "title");
            $desc = $this->attr($element, "desc");
            $year = $this->attr($element, "year");
            $poster = $this->attr($element, "poster");
            $category = $this->attr($element, "category");
            $tags = explode(",", $this->attr($element, "tags"));
            if ($title) {
                $movie = $this->service->addMovie($title, $desc, $year, $poster, $category, $tags);
                
                if ($movie) {
                    foreach ($element->review as $reviewElement) {
                        $content = $this->attr($reviewElement, "content");
                        $createdAt = $this->attr($reviewElement, "createdAt");
                        $updatedAt = $this->attr($reviewElement, "updatedAt");
                        $userName = $this->attr($reviewElement, "user");
                        $ratingValue = $this->attr($reviewElement, "rating");
                        if (! $createdAt) {
                            $createdAt = date("Y-m-d H:i:s");
                        }
                        $createdAt = new \DateTime($createdAt);
                        if ($updatedAt) {
                            $updatedAt = new \DateTime($updatedAt);
                        }
                        $review = $this->service->addReview($content, $createdAt, $updatedAt, $movie, $userName, $ratingValue);
                        
                        if ($review) {
                            foreach ($reviewElement->report as $reportElement) {
                                $message = $this->attr($reportElement, "message");
                                $userName = $this->attr($reportElement, "user");
                                $createdAt = $this->attr($reportElement, "createdAt");
                                $treated = $this->attr($reportElement, "treated", "false");
                                if (! $createdAt) {
                                    $createdAt = date("Y-m-d H:i:s");
                                }
                                $createdAt = new \DateTime($createdAt);
                                if (strtolower($treated) == "true") {
                                    $treated = true;
                                } else {
                                    $treated = false;
                                }
                                $report = $this->service->addReport($message, $createdAt, $treated, $userName, $review);
                            }
                        }
                    }
                }
            }
        }


        foreach ($root->message as $element) {
            $firstName = $this->attr($element, "firstName");
            $lastName = $this->attr($element, "lastName");
            $email = $this->attr($element, "email");
            $content = $this->attr($element, "content");
            $createdAt = $this->attr($element, "createdAt");
            $treated = $this->attr($element, "treated", "false");
            if (! $createdAt) {
                $createdAt = date("Y-m-d H:i:s");
            }
            $createdAt = new \DateTime($createdAt);
            if (strtolower($treated) == "true") {
                $treated = true;
            } else {
                $treated = false;
            }
            $message = $this->service->addMessage($firstName, $lastName, $email, $content, $createdAt, $treated);
        }

        foreach ($root->authenticationToken as $element) {
            $email = $this->attr($element, "email");
            $token = $this->attr($element, "token");
            $newPassword = $this->attr($element, "newPassword", "false");
            $expiresAt = $this->attr($element, "expiresAt");
            $verifiedAt = $this->attr($element, "verifiedAt");
            $userName = $this->attr($element, "user");
            if (! $expiresAt) {
                $expiresAt = date("Y-m-d H:i:s", time() + 15*24*3600);
            }
            $expiresAt = new \DateTime($expiresAt);
            if (strtolower($newPassword) == "true") {
                $newPassword = true;
            } else {
                $newPassword = false;
            }
            $this->service->addAuthenticationToken($email, $token, $expiresAt, $verifiedAt, $newPassword, $userName);
        }

        foreach ($root->artist as $element) {
            $firstName = $this->attr($element, "firstName");
            $lastName = $this->attr($element, "lastName");
            $actorTitles = explode("|", $this->attr($element, "actor"));
            $directorTitles = explode("|", $this->attr($element, "director"));
            $this->service->addArtist($firstName, $lastName, $actorTitles, $directorTitles);
        }
    }
    
}


/*******************************************************************************
 * 'main' :
 ******************************************************************************/
 
require __DIR__ . "/../index.php";

$dbp = new DBPopulator();
$dbp->run();
