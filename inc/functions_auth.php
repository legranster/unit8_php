<?php

function isAuthenticated()
{
    return decodeAuthCookie();
}

function requireAuth()
{
    if (!isAuthenticated()) {
        global $session;
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/login.php');
    }
}

function getAuthenticatedUser()
{
    return findUserById(decodeAuthCookie('auth_user_id'));
}

function isOwner($ownerId)
{
    if(!isAuthenticated()){
        return false;
    }
    return $ownerId == decodeAuthCookie('auth_user_id');
}

function saveUserData($user)
{
    global $session;
    $session->getFlashBag()->add('success', 'Successfully logged in');
    $data = [
        'auth_user_id' => (int) $user['id']
    ];
    $expTime = time() + 3600;
    $cookie = setAuthCookie($data, $expTime);
    redirect('/', ['cookies' => [$cookie]]);
}

function setAuthCookie($data, $expTime)
{
    $cookie = new Symfony\Component\HttpFoundation\Cookie(
        'auth', 
        json_encode($data),
        $expTime,
        '/',
        'localhost',
        false,
        true
    );
    return $cookie;
}

function decodeAuthCookie($prop = null)
{
    $cookie = json_decode(request()->cookies->get('auth'));
    if ($prop === null) {
        return $cookie;
    }
    if (!isset($cookie->$prop)){
        return false;
    }
    return $cookie->$prop;
}