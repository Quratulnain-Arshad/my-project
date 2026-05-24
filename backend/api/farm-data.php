<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$result = $conn->query("SELECT * FROM farm_data ORDER BY lang ASC");
$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[$row['lang']] = $row;
}

$output = ['languages' => []];
foreach ($rows as $lang => $r) {
    $output['languages'][$lang] = [
        'title'          => $r['title'],
        'subtitle'       => $r['subtitle'],
        'buttons'        => [
            'cropInfo'   => $r['btn_crop_info'],
            'calculator' => $r['btn_calculator'],
            'helpline'   => $r['btn_helpline'],
        ],
        'switchLanguage' => $r['switch_language'],
        'about'          => [
            'heading'    => $r['about_heading'],
            'p1'         => $r['about_p1'],
            'p2'         => $r['about_p2'],
            'p3'         => $r['about_p3'],
        ],
    ];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
