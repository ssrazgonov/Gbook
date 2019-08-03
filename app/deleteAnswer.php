<?php

session_start();
define("ROLE_ADMIN", 222);
require 'config/db.php';

if (isset($_SESSION['user']) && $_SESSION['user']['role'] == ROLE_ADMIN) {
    if (isset($_REQUEST['answer_id'])) {

        if (deleteAnswer($_REQUEST['answer_id'], $db)) {
            updateComment($_REQUEST['answer_id'], $db);
            echo json_encode(['message' => "Ответ удален"]);
        } else {
            echo json_encode(['error' => "Ошибка удаления"]);
        }
    }
} else {
    echo json_encode(['error' => "Действие запрещено"]);
}

function deleteAnswer($answer_id, $db)
{
    $query = $db->prepare("DELETE FROM answer WHERE id = :id ");
    $query->bindValue(':id', $answer_id);
    return $query->execute();
}

function updateComment($answer_id, $db)
{
    $query = $db->prepare("UPDATE comment SET answer_id = NULL WHERE answer_id = :answer_id");
    $query->bindValue(':answer_id', $answer_id);
    return $query->execute();
}
