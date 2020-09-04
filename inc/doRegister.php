<?php

require_once 'bootstrap.php';

$username = request()->get('username');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

if ($password != $confirmPassword) {
    $session->getFLashBag()->add('error', 'Passwords do NOT match');
    redirect('/register.php');
}

$user = findUserByUsername($username);

if(!empty($user)){
    $session->getFLashBag()->add('error', 'Username Already Exists.');
    redirect('/register.php');
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$user = createUser($username, $hashed);
$session->getFlashBag()->add('success', 'User Added');
saveUserData($user);
