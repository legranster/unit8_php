<?php

function findUserByUsername($username)
{
    global $db;

    try {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();

    } catch (\Exception $e) {
        throw $e;
    }
}

function findUserById($userId)
{
    global $db;

    try {
        $query = "SELECT * FROM users WHERE id = :userId";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetch();

    } catch (\Exception $e) {
        throw $e;
    }
}

function createUser($username, $password)
{
    global $db;

    try {
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return findUserByUsername($username);
    } catch (\Exception $e) {
        throw $e;
    }
}

function updatePassword($password, $userId)
{
    global $db;

    try {
        $query = 'UPDATE users SET password = :password WHERE id = :userId';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          return true;
        } else {
          return false;
        }
    } catch (\Exception $e) {
        throw $e;
    }

    return true;
}
