<?php

require_once 'bootstrap.php';
requireAuth();

$currentPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmPassword = request()->get('confirm_password');

if ($newPassword != $confirmPassword) {
    $session->getFlashBag()->add('error', 'New passwords do not match');
    redirect('/account.php');
}

$user = getAuthenticatedUser();

if (empty($user)) {
    $session->getFlashBag()->add('error', 'Some Error Occurred. Try again.');
    redirect('/account.php');
}

if (!password_verify($currentPassword, $user['password'])) {
    $session->getFlashBag()->add('error', 'Current Password is incorrect.');
    redirect('/account.php');
}

$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

if (!updatePassword($hashed, $user['id'])){
    $session->getFlashBag()->add('error', 'Could not update password. Please try again.');
    redirect('/account.php');
}

$session->getFlashBag()->add('success', 'Password Updated');
redirect('/account.php');