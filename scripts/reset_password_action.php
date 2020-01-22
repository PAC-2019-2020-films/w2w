<?php


//Make sure we're not accessing this page from wherever
if (isset($_SERVER['HTTP_REFERER'])) {
//    Remove the token part from the URL
    $referer = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], '?'));

    if ($referer === 'http://w2w.localhost/reset_password.php') {
        $password = param("password");
        $passwordConfirm = param("passwordConfirm");
        $token = param("token");

//        Input validation
        $rawInput = [
            'password' => ['password', $password, false],
            'passwordConfirm' => ['password', $passwordConfirm, false],
            'token' => ['alphanum', $token, false]
        ];

        if (\w2w\Utils\Utils::inputValidation($rawInput)) {
            if ($passwordConfirm === $password) {
                $tokenDAO = new \w2w\DAO\Doctrine\DoctrineAuthenticationTokenDAO();
                $authToken = $tokenDAO->findOneBy('token', $token);

                if ($authToken) {
                    $currDate = new DateTime("now", new DateTimeZone("Europe/Brussels"));

//                    If the token is still valid
                    if ($currDate < $authToken->getExpiresAt() || $authToken->getVerifiedAt()) {
//                           get the Token User
                        $user = $authToken->getUser();

//                        Hash and set the user new password
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        $user->setPasswordHash($passwordHash);

//                        Persist the user
                        $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
                        $userDAO->update($user);

//                        Update and persist the token
                        $authToken->setVerifiedAt($currDate);
                        $tokenDAO->update($authToken);

                        \w2w\Utils\Utils::message(true, 'Password changed!', '');
                        header("location:login.php");


                    } else {
                        \w2w\Utils\Utils::message(false, '', 'Link expired.');
                        header("location:login.php");
                    }

                } else {
                    \w2w\Utils\Utils::message(false, '', 'Invalid Token');
                    header("location:login.php");
                }

            } else {
                \w2w\Utils\Utils::message(false, '', 'Password do not match.');
                header("location: reset_password.php?token=" . $token);
            }
        } else {
            \w2w\Utils\Utils::message(false, '', 'Password invalid.');
            header("location: reset_password.php?token=" . $token);
        }

    } else {
        header("Location:homepage.php");
    }

} else {
    header("Location:homepage.php");
}