<?php
// Shared config for admin pages
session_start();
require_once __DIR__ . "/conn.php";

function requireLogin() {
    if (empty($_SESSION['admin'])) {
        header("Location: ../login.php");
        exit;
    }
}
