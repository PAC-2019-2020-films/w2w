<?php


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

// Check that the user is not already logged in

if (isset($_SESSION['user'])) {
    header('location: ' . 'account/index.php');
}


if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] === 'http://w2w.localhost/authentication/signup.php') {

// Get the POST data

    $userName = param('userName');
    $firstName = param('firstName');
    $lastName = param('lastName');
    $email = param('email');
    $plainPassword = param('password');
    $plainPasswordConfirm = param('passwordConfirm');


// Check that the passwords match
    if ($plainPassword === $plainPasswordConfirm) {

//    Input validation
//    Prepare POST data for validation
        $rawInput = [
            'userName' => ['alphanum', $userName, false],
            'firstName' => ['alpha', $firstName, false],
            'lastName' => ['alpha', $lastName, false],
            'email' => ['email', $email, false],
            'password' => ['password', $plainPassword, false]
        ];

        if (\w2w\Utils\Utils::inputValidation($rawInput)) {

//        Hash password
            $password = password_hash($plainPassword, PASSWORD_DEFAULT);

//        Instantiate required DAO
            $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
            $roledDAO = new \w2w\DAO\Doctrine\DoctrineRoleDAO();
            $tokenDAO = new \w2w\DAO\Doctrine\DoctrineAuthenticationTokenDAO();

//        Set default role to "user"
            $role = $roledDAO->findOneBy('id', '1');
           

//        Set created_at
            try {
                $createdAt = new DateTime("now", new DateTimeZone('Europe/Brussels'));
            } catch (Exception $e) {
                /*
                * TODO : CLean up
                */
                die($e);
            }

            $createdAt->format("Y-m-d H:i:s");

//    Instantiate new User with POST data
            $user = new \w2w\Model\User(null, $userName, $email, 0, $password, $firstName, $lastName, $createdAt, null, null, false, 0, $role);

//    Save the user in the Database
            try {
                $userDAO->save($user);
            } catch (\Doctrine\ORM\ORMException $e) {
                \w2w\Utils\Utils::message(false, '', 'Error while saving user' . $e);
                header('location: ' . $_SERVER['HTTP_REFERER']);
            } catch (UniqueConstraintViolationException $uniqueConstraintViolationException) {
                \w2w\Utils\Utils::message(false, '', 'Error while saving user' . $e);
                header('location: ' . $_SERVER['HTTP_REFERER']);
            }

            require 'generate_validation_mail.php';

//    Redirect to login page
            \w2w\Utils\Utils::message(true, 'Account successfully created, you can now log into What2Whatch! Check your mail to validate your account !', 'Your account could not be created.');
            header('location:' . 'login.php');
        } else {
            \w2w\Utils\Utils::message(false, 'Account successfully created! Check your mail to verify your account!', 'Your account could not be created.');
            header('location: ' . 'signup.php');
        }

    } else {
        \w2w\Utils\Utils::message(false, 'Password Match', 'The passwords do not match.');
        header('location: ' . 'signup.php');
    }
} else {
    header('Location: signup.php');
};