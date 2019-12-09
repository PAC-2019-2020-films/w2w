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



$data= <<<EOH
<data>
    <rating name="Chef d''oeuvre" desc="Chefs d'oeuvre" value="3"/>
    <rating name="Bon film" desc="Bons films" value="2"/>
    <rating name="Moyen" desc="Moyens" value="1"/>
    <rating name="Navet" desc="Navets" value="-1"/>

    <role id="1" name="user" desc="Simple ordinary user, can review movies."/>
    <role id="2" name="admin" desc="Admin user, can edit movies and moderate other users."/>
    <role id="3" name="root" desc="Super admin user, can grant or revoke admin status to other users."/>
    
    <user name="user" email="user@gmail.com"/>
    <user name="admin" email="admin@gmail.com" role="admin"/>
    <user name="root" email="root@gmail.com" role="root"/>
    <user name="Lea" email="lea@gmail.com" firstName="Lea" lastName="Nimaux"/>
    <user name="Luc" email="luc@gmail.com" firstName="Luc" lastName="Ratif"/>
    <user name="Raoul" email="raoul@gmail.com" firstName="Raoul" lastName="Gauvain"/>
    <user name="René" email="rene@gmail.com" firstName="René" lastName="Dupont" emailVerified="false"/>
    
    <tag name="biopic" desc="biopic movies..."/>
    <tag name="drama" desc="drama movies..."/>
    <tag name="crime" desc="crime movies..."/>
    <tag name="romance" desc="romance movies..."/>
    <tag name="western" desc="bang, bang"/>
    <tag name="sport" desc="sport movies..."/>
    <tag name="S-F" desc="S-F movies..."/>
    <tag name="Fantastic" desc="Fantastic movies..."/>
    <tag name="RomCom" desc="RomCom movies..."/>
    <tag name="History" desc="Histocrical movies..."/>
    
    <category name="En couple" desc="Films à voir à deux..."/>
    <category name="En famille" desc="Films à voir en famille..."/>
    <category name="Entre amis" desc="Films à voir entre amis..."/>
    <category name="Nawak" desc="N'importe quoi"/>

    <movie title="Bohemian Rhaposdy" desc="Biopic of F.Mercury" year="2018" poster="" category="Nawak" tags="biopic,drama">
        <review content="C'est génial." user="Raoul" rating="3"/>
        <review content="C'est naze, c'est plein de tarlouzes." user="René" rating="-1">
            <report message="René est un connard homophobe." user="Raoul"/>
        </review>
    </movie>
    <movie title="La Promesse" desc="drame social belgo-belge" year="2005" poster="" category="Nawak" tags="drama,crime,romance">
    </movie>
    <movie title="Le silence de Lorna" desc="" year="2008" poster="" category="Nawak" tags="drama">
    </movie>
    <movie title="Rosetta" desc="" year="1999" poster="" category="Nawak" tags="">
    </movie>
    <movie title="Million Dollar Baby" desc="" year="2004" poster="" category="Nawak" tags="drama,sport">
    </movie>
    <movie title="Unforgiven" desc="" year="1992" poster="" category="Nawak" tags="drama,western">
    </movie>
    <movie title="" desc="" year="" poster="" category="Nawak" tags="">
    </movie>

    <message firstName="Jules" lastName="Smith" email="jules.smith@gmail.com" content="C'est quoi, ce site de merde ?"/>
    <message firstName="Adélaïde" lastName="Deltoïde" email="adelaide.deltoide@gmail.com" content="Viens là que je te masse." createdAt="2019-12-06 12:11:10"/>
    <message firstName="Jacques" lastName="Uze" email="jacques.uze@gmail.com" content="Mon avocat vous contactera." treated="true"/>
    
    <authenticationToken email="rene@gmail.com" token="RTYKJHJHHJHKGH" user="René"/>
    <authenticationToken email="raoul@gmail.com" token="KJJHJHRTJHKGHK" newPassword="true" user="Raoul"/>
    
    <artist firstName="Jean-Pierre" lastName="Dardenne" director="La Promesse|Le silence de Lorna|Rosetta"/>
    <artist firstName="Luc"         lastName="Dardenne" director="La Promesse|Le silence de Lorna|Rosetta" />
    <artist firstName="Jérémie" lastName="Renier" actor="La Promesse"/>
    <artist firstName="Déborah" lastName="François" actor="La Promesse"/>
    <artist firstName="Olivier" lastName="Gourmet" actor="La Promesse|Rosetta"/>
    <artist firstName="Émilie" lastName="Dequenne" actor="Rosetta" director=""/>
    <artist firstName="Clint" lastName="Eastwood" actor="Million Dollar Baby|Unforgiven" director="Million Dollar Baby|Unforgiven"/>
    <artist firstName="Gene" lastName="Hackman" actor="Unforgiven"/>
    <artist firstName="Morgan" lastName="Freeman" actor="Unforgiven"/>
    <artist firstName="Hilary" lastName="Swank" actor="Million Dollar Baby"/>

</data>
EOH;

class DBPopulator
{
    use Loggable;
    protected $xml;
    protected $service;

    public function __construct($xmlString)
    {
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



$dbp = new DBPopulator($data);
$dbp->run();
