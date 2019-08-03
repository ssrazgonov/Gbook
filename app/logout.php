<?php
session_start();
if ($_SESSION['user']) {
    echo json_encode(['message' => "Выход"]);
    unset($_SESSION['user']);
}