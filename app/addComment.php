<?php
session_start();

require 'config/db.php';

if (isset($_SESSION['user'])) {

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'add-comment') {


        $query = $db->prepare("SELECT * FROM user WHERE username = :username");
        $query->bindValue(':username', $_SESSION['user']['username']);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!empty($_REQUEST['text'])) {
            $query = $db->prepare("INSERT INTO comment (author_id, text) VALUES (:userId, :text)");
            $query->bindValue(':userId', $user['id']);
            $query->bindValue(':text', $_REQUEST['text']);

            if ($query->execute()) {
                echo json_encode(['message' => "Запись добавлена"]);
            } else {
                echo json_encode(['error' => "Не удалось сохранить"]);
            }

        } else {
            echo json_encode(['error' => "Поле не заполнено"]);
        }
    }
}

