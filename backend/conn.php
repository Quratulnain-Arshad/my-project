<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @new mysqli("localhost", "root", "", "farmease");
if ($conn->connect_error) {
    // If called from api/ return JSON error, otherwise plain text
    if (strpos($_SERVER['SCRIPT_FILENAME'] ?? '', '/api/') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'DB not set up. Visit /backend/setup.php first.']);
        exit;
    }
    die("DB error: " . $conn->connect_error . " — run /backend/setup.php first.");
}
$conn->set_charset("utf8mb4");
