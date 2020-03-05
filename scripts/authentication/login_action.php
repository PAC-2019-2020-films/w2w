<?php
    
    global $user;
    
    if ($user != null) {
        header('location:' . $_SERVER['HTTP_REFERER']);
    }
    
    
    $email    = param("email");
    $password = param("password");
    $token    = param("token");
    
    if ($email && $password) {
        
        $daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
        $userDAO    = $daoFactory->getUserDAO();
        
        if ($user = $userDAO->findByEmail($email)) {
            
            if (password_verify($password, $user->getPasswordHash())) {
                if ($user->isBanned()) {
                    \w2w\Utils\Utils::message(false, '', 'Votre compte a été banni.');
                    header('location:../homepage.php');
                    exit();
                } else {
                    $_SESSION["user"]          = $user->getId();
                    $_SESSION["email"]         = $user->getEmail();
                    $_SESSION["uid"]           = $user->getId();
                    $_SESSION["role"]          = $user->getRole()->getId();
                    $_SESSION['emailVerified'] = $user->isEmailVerified();
                    
                    if (!$user->isEmailVerified()) {
                        \w2w\Utils\Utils::message(false, '', 'Your account has not yet been verified. Check your mail or click <a href="http://w2w.localhost/authentication/generate_validation_mail.php">here</a> to receive a new validation email.');
                    }

//              Validate the token
                    if ($token) {
                        $rawInput = [
                            'token' => ['alphanum', $token, null]
                        ];
                        
                        if (\w2w\Utils\Utils::inputValidation($rawInput)) {
//                  Get the tokenDAO
                            $tokenDAO = new \w2w\DAO\Doctrine\DoctrineAuthenticationTokenDAO();
//                  Find the matching token in the DB
                            $authToken = new \w2w\Model\AuthenticationToken();
                            $authToken = $tokenDAO->findOneBy('token', $token);
                            
                            if ($authToken) {
//                    Check that the token hasn't expired
                                $currDate = new DateTime("now", new DateTimeZone("Europe/Brussels"));
                                
                                if ($currDate < $authToken->getExpiresAt() || $authToken->getVerifiedAt()) {

//                    Check that the token refer to the same user that the one attempting to log in
                                    if ($authToken->getUser()->getId() === $user->getId()) {

//                  Get the current date and update the token object
                                        $verifiedAt = new DateTime("now", new DateTimeZone('Europe/Brussels'));
                                        $authToken->setVerifiedAt($verifiedAt);

//                  Persist the change in the database
                                        $tokenDAO->update($authToken);

//                    Update the user and persist in DB
                                        $user->setEmailVerified(true);
                                        $userDAO->update($user);
                                        
                                        \w2w\Utils\Utils::message(true, 'Account successfuly Verified', '');
                                        $_SESSION['emailVerified'] = $user->isEmailVerified();
                                    }
                                }
                            } else {
                                \w2w\Utils\Utils::message(false, '', 'Link has expired, Click <a href="http://w2w.localhost/authentication/generate_validation_mail.php">here</a> to receive a new one.');
                            }
                        } else {
                            \w2w\Utils\Utils::message(false, '', 'Link has expired, Click <a href="http://w2w.localhost/authentication/generate_validation_mail.php">here</a> to receive a new one.');
                        }
                    }
                    
                    if (strstr($_SERVER['HTTP_REFERER'], 'movie.php?id=')) {
                        $redirectLocation = $_SERVER['HTTP_REFERER'];
                    } else {
                        $redirectLocation = "../account/index.php";
                        if ($user->isAdmin()) {
                            $redirectLocation = "../admin/index.php";
                        }
                        if ($user->isRoot()) {
                            $redirectLocation = "../admin/index.php";
                        }
                    }
                    
                    header('location:' . $redirectLocation);
                    exit();
                }
            }
        }
    }
    
    if (isset($token)) {
        header("location: validate_email.php?token=" . $token);
        exit();
    } else {
        header("location: " . 'login.php');
        exit();
    }



