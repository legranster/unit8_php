<?php

require_once 'bootstrap.php';

$user = findUserByUsername(request()->get('username'));

if(empty($user)){
    $session->getFlashBag()->add('error', 'Username not found');
    redirect('/login.php');
}

if (!password_verify(request()->get('password'), $user['password'])){
    $session->getFlashBag()->add('error', 'Incorrect Password');
    redirect('/login.php');
}

saveUserData($user);