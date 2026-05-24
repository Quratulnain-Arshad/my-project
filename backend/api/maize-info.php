<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$result = $conn->query("SELECT lang, title, heading, content FROM crop_details WHERE crop='maize' ORDER BY lang ASC, section_order ASC");
$output = [];
while ($r = $result->fetch_assoc()) {
    $lang = $r['lang'];
    if (!isset($output[$lang])) {
        $output[$lang] = ['title' => $r['title'], 'sections' => []];
    }
    $output[$lang]['sections'][] = ['heading' => $r['heading'], 'content' => $r['content']];
}
echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
