<?php
session_start();

require_once __DIR__ . "/conn.php";

function requireLogin() {
    if (empty($_SESSION['admin'])) {
        header("Location: ../login.php");
        exit;
    }
}

function jsonResponse($data) {
    header("Content-Type: application/json; charset=utf-8");
    header("Access-Control-Allow-Origin: *");
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
