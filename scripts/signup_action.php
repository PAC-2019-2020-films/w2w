<?php

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

// Check that the user is not already logged in

if (isset($_SESSION['user'])) {
    header('location: ' . 'account/index.php');
}

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
        $user = new \w2w\Model\User(null, $userName, $email, 0, $password, $firstName, $lastName, $createdAt, null, null, null, null, $role);

//    Save the user in the Database
        try {
            $userDAO->save($user);
        } catch (\Doctrine\ORM\ORMException $e) {
            $_SESSION['errorMessage'] = "error while saving user";
            header('location: ' . $_SERVER['HTTP_REFERER']);
        } catch (UniqueConstraintViolationException $uniqueConstraintViolationException) {
            $_SESSION['errorMessage'] = "error while saving user";
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }

//        Generate and save the User Token
        $tokenValue = bin2hex(openssl_random_pseudo_bytes(16));
        $expireAt = $createdAt->modify("+1 day");

        $token = new \w2w\Model\AuthenticationToken(null, $email, $tokenValue, $expireAt, null, null, $user);

        $tokenDAO->save($token);

//        Send Confirmation email
//            1. Generate url pointing to the script where the validation will take place and passing the token as a GET argument
        $url = "http://w2w.localhost/validate_email.php?token=" . $tokenValue;

//            2. Set the email headers
        $headers = [
            'From' => 'donotreply@whattowatch.com',
            'MINE-Version' => '1.0',
            'Content-Type' => 'text/html; charset-utf-8',
            'X-Mailer' => 'PHP/' . phpversion()
        ];

//            3. Set the message to be displayed in the email and link the url
        $message = 'Thank you for registering at whattowatch.com! Click this link to validate your account (this link is only available for the next 24 hours) : '
            . '<a href=' . $url . '>Validate your account!</a>';

//            4. Send the email
        try {
            mail($email, 'What to Watch : Your Account Validation', $message, $headers);
        } catch (Exception $e) {
            die($e);
        }

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