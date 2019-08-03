<?php

session_start();
define("ROLE_ADMIN", 222);
require 'config/db.php';

if (isset($_SESSION['user']) && $_SESSION['user']['role'] == ROLE_ADMIN) {
    if (isset($_REQUEST['comment_id'])) {
        if (deleteComment($_REQUEST['comment_id'], $db)) {
            echo json_encode(['message' => "Комментарий удален"]);
        } else {
            echo json_encode(['error' => "Ошибка удаления"]);
        }
    }
}

function deleteComment($id, $db)
{

    $query = $db->prepare("DELETE FROM comment WHERE id = :id ");

    $query->bindValue(':id', $id);

    return $query->execute();
}
