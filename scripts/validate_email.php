<?php

global $user;
/*
 * Logs out the user if connected and displays to login page with the authentication attached in order to validate the account
 * */

if ($user){
    require "logout_action.php";
}

// Get the token
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    require 'login.php';
} else {
    header("location:" . 'homepage.php');
}

