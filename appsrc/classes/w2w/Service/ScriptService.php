<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:27
 */

namespace w2w\Service;

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

class ScriptService extends BaseService
{
    
    protected $force = false;
    
    /**
     * UserService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        /*
        * TODO : CHECK FOR USER STATUS (ISUSER?(TRUE))
        */
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
