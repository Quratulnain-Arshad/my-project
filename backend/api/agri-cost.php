<?php
// AgriCost API — returns cost/profit text for each crop
require_once __DIR__ . '/../conn.php';

header('Content-Type: application/json; charset=utf-8');

$result = $conn->query("SELECT * FROM agri_cost ORDER BY crop_key ASC");
$output = [];

while ($row = $result->fetch_assoc()) {
    $output[$row['crop_key']] = [
        'name_en'    => strip_tags($row['name_en'] ?? ''),
        'name_ur'    => strip_tags($row['name_ur'] ?? ''),
        'desc_en'    => strip_tags($row['desc_en'] ?? ''),
        'desc_ur'    => strip_tags($row['desc_ur'] ?? ''),
        'details_en' => strip_tags($row['details_en'] ?? ''),
        'details_ur' => strip_tags($row['details_ur'] ?? ''),
    ];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
