<?php
session_start();
define("ROLE_ADMIN", 222);

require 'config/db.php';

if ($_REQUEST['action'] == 'loginBySecret') {
    $user = getUserByUsername($_REQUEST['username'], $db);
    if (!empty($user) && validateSecret($_REQUEST['secret'], $user)) {
        echo json_encode([$user]);
        $_SESSION['user']['username'] = $user['username'];
    } else {
        echo json_encode(['error' => 'user not found']);
    }
}

function getUserByUsername($username, $db)
{
    $query = $db->prepare("SELECT * FROM user WHERE username = :username");
    $query->bindValue(':username', $username);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

function validateSecret($secret, $user)
{
    return $secret == $user['password'];
}