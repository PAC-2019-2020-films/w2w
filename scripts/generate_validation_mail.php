<?php


if (!isset($tokenDAO)) {
    $tokenDAO = new \w2w\DAO\Doctrine\DoctrineAuthenticationTokenDAO();
}

if (!isset($user)) {
    $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
    $user = $userDAO->findOneBy('email', $_SESSION["email"]);
}

if ($tokenExist = $tokenDAO->findOneBy('user', $user->getId())){
    $tokenDAO->delete($tokenExist);
}

//      Generate the User Token
$tokenValue = bin2hex(openssl_random_pseudo_bytes(16));
$tokenCreatedAt = new DateTime('now', new DateTimeZone('Europe/Brussels'));
$expireAt = $tokenCreatedAt->modify("+1 day");

$token = new \w2w\Model\AuthenticationToken(null, $user->getEmail(), $tokenValue, $expireAt, null, null, $user);

//      Save the user Token
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
    mail($user->getEmail(), 'What to Watch : Your Account Validation', $message, $headers);
    \w2w\Utils\Utils::message(false, '', 'Your account has not yet been verified. Check your mail or click <a href="http://w2w.localhost/generate_validation_mail.php">here</a> to receive a new validation email.');
    header("Location: account/index.php");
} catch (Exception $e) {
    die($e);
}