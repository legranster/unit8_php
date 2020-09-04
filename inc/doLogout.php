<?php

require_once 'bootstrap.php';

$session->getFlashBag()->add('success', 'Successfully logged out');
$cookie = setAuthCookie('expired', 1);
redirect('/login.php', ['cookies' => [$cookie]]);