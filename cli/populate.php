<?php

use Fr\Log\Loggable;
use w2w\Model\Category;
use w2w\Model\Message;
use w2w\Model\Movie;
use w2w\Model\Rating;
use w2w\Model\Review;
use w2w\Model\Role;
use w2w\Model\Tag;
use w2w\Model\User;
use w2w\Service\ScriptService;

# delete or comment following line if in production env !
define("FR_ENV", "development");

require __DIR__ . "/../appsrc/bootstrap.php";


/**
 * classe qui remplit la bdd avec les données d'un fichier xml
 */
class DBPopulator
{
    use Loggable;
    protected $xml;
    protected $service;

    public function __construct($configFilePath = FR_APPPATH . "/cli/populate.xml")
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



$dbp = new DBPopulator();
$dbp->run();
