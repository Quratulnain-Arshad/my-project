<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

function stripTags($s) { return strip_tags($s ?? ''); }

$result = $conn->query("SELECT * FROM agri_cost ORDER BY crop_key ASC");
$output = [];
while ($r = $result->fetch_assoc()) {
    $output[$r['crop_key']] = [
        'name_en'    => stripTags($r['name_en']),
        'name_ur'    => stripTags($r['name_ur']),
        'desc_en'    => stripTags($r['desc_en']),
        'desc_ur'    => stripTags($r['desc_ur']),
        'details_en' => stripTags($r['details_en']),
        'details_ur' => stripTags($r['details_ur']),
    ];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
