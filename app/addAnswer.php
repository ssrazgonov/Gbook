<?php
session_start();
define("ROLE_ADMIN", 222);
require 'config/db.php';

if (isset($_SESSION['user']) && $_SESSION['user']['role'] == ROLE_ADMIN ) {

    $query = $db->prepare("SELECT * FROM user WHERE username = :username");
    $query->bindValue(':username', $_SESSION['user']['username']);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!empty($_REQUEST['text'])) {
        $query = $db->prepare("INSERT INTO answer (author_id, text) VALUES (:userId, :text)");
        $query->bindValue(':userId', $user['id']);
        $query->bindValue(':text', $_REQUEST['text']);
        $query->execute();
        $id = (int) $db->lastInsertId();

        if (isset($id) && !empty($id)) {
            $query = $db->prepare("UPDATE comment SET answer_id = :answer_id WHERE id = :comment_id");
            $query->bindValue(':answer_id', $id);
            $query->bindValue(':comment_id', (int) $_REQUEST['commnetId']);

            if($query->execute()) {
                echo json_encode(['message' => "Запись добавлена"]);
            } else {
                echo json_encode(['error' => "Не удалось обновить комментарий"]);
            }


        } else {
            echo json_encode(['error' => "Не удалось сохранить ответ"]);
        }

    } else {
        echo json_encode(['error' => "Поле не заполнено"]);
    }
}

