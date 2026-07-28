<?php
// Database connection — simple for FYP
$conn = new mysqli("localhost", "root", "", "farmease");

if ($conn->connect_error) {
    die("Database connection failed. Import farmease.sql or run setup.php first.");
}

$conn->set_charset("utf8mb4");
