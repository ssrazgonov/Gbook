<?php
session_start();
define("ROLE_ADMIN", 222);

require 'config/db.php';

if ($_REQUEST['action'] == 'login' && !empty($_REQUEST['username'])) {

    $user = getUserByUsername($_REQUEST['username'], $db);

    if (!empty($user) && validatePassword($_REQUEST['password'], $user)) {
        
        echo json_encode([$user]);

        
        $_SESSION['user'] = $user;

    } else {
        echo json_encode(['error' => 'Пользователь не найден или пароль не верный']);
    }

} else {
    echo json_encode(['error' => 'Введите логин']);
}

function getUserByUsername($username, $db)
{
    $query = $db->prepare("SELECT * FROM user WHERE username = :username");
    $query->bindValue(':username', $username);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

function validatePassword($password, $user)
{
    return password_verify($password, $user['password']);
}