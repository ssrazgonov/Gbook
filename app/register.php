<?php

define("ROLE_ADMIN", 222);

require 'config/db.php';

if ($_REQUEST['action'] == 'register' && !empty($_REQUEST['username'])) {

    $user['username'] = $_REQUEST['username'];

    if (!empty($_REQUEST['password'])) {

        $user['password'] = $_REQUEST['password'];

        if (addUser($user, $db)) {
            echo json_encode(['message' => 'Вы можете войти под своим логином и паролем']);
        } else {
            echo json_encode(['error' => 'Произошла ошибка регистрации']);
        }

    } else {
        echo json_encode(['error' => 'Введите пароль']);
    }

} else {
    echo json_encode(['error' => 'Введите логин']);
}

function addUser($user, $db)
{
    $query = $db->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
    $query->bindValue(':username', $user['username']);
    $query->bindValue(':password', password_hash($user['password'], PASSWORD_DEFAULT));

    return $query->execute();
}