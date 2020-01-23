<?php

//Make sure we're not accessing this page from wherever
//if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] === 'http://w2w.localhost/authentication/login.php') {

//    Get the form data
    $email = param('email');

    $rawInput = [
        'email' => ['email', $email, false],
    ];


//    If the data are valid
    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
        $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
        $user = $userDAO->findOneBy('email', $email);


//        If the email adress matches a user :
        if ($user) {
//          Generate the User Token
            $tokenValue = bin2hex(openssl_random_pseudo_bytes(16));
            $tokenCreatedAt = new DateTime('now', new DateTimeZone('Europe/Brussels'));
            $expireAt = $tokenCreatedAt->modify("+1 day");

            $token = new \w2w\Model\AuthenticationToken(null, $user->getEmail(), $tokenValue, $expireAt, null, true, $user);

//      Save the user Token
            $tokenDAO = new \w2w\DAO\Doctrine\DoctrineAuthenticationTokenDAO();
            $tokenDAO->save($token);

//            Send the reset password email :
            $url = "http://w2w.localhost/authentication/reset_password.php?token=" . $tokenValue;
            $headers = [
                'From' => 'donotreply@whattowatch.com',
                'MINE-Version' => '1.0',
                'Content-Type' => 'text/html; charset-utf-8',
                'X-Mailer' => 'PHP/' . phpversion()
            ];

            $message = 'What2Watch password recovery to the rescue! Click this link to choose a new password (this link is only available for the next 24 hours) : '
                . '<a href=' . $url . '>Change your password</a>';

            try {
                mail($user->getEmail(), 'What to Watch : Reset your password', $message, $headers);
                \w2w\Utils\Utils::message(true, 'A email has been sent to your adress.', '');
                header("Location:login.php");
            } catch (Exception $e) {
                die($e);
            }

        } else {
            header('Location:login.php');
        }

    } else {
//        if the data are not valid : set a message, and redirect
        \w2w\Utils\Utils::message(false, '', 'Not a valid email adress.');
        header('Location:login.php');
    }

//} else {
//    header('Location:../homepage.php');
//}