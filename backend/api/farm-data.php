<?php
// Home / header content API — farm_data + static How It Works / Features from JSON
require_once __DIR__ . '/../conn.php';

header('Content-Type: application/json; charset=utf-8');

// Static parts (How It Works, Features) from JSON file
$jsonFile = __DIR__ . '/../../frontend/json/farm-data.json';
$static = [];
if (file_exists($jsonFile)) {
    $json = json_decode(file_get_contents($jsonFile), true);
    $static = $json['languages'] ?? [];
}

// Dynamic parts from database
$result = $conn->query("SELECT * FROM farm_data ORDER BY lang ASC");
$output = ['languages' => []];

while ($row = $result->fetch_assoc()) {
    $lang = $row['lang'];
    $extra = $static[$lang] ?? [];

    $output['languages'][$lang] = [
        'title'          => $row['title'],
        'subtitle'       => $row['subtitle'],
        'buttons'        => [
            'cropInfo'   => $row['btn_crop_info'],
            'calculator' => $row['btn_calculator'],
            'helpline'   => $row['btn_helpline'],
        ],
        'switchLanguage' => $row['switch_language'],
        'about'          => [
            'heading' => $row['about_heading'],
            'p1'      => $row['about_p1'],
            'p2'      => $row['about_p2'],
            'p3'      => $row['about_p3'],
        ],
        'howItWorks'     => $extra['howItWorks'] ?? [],
        'features'       => $extra['features'] ?? [],
    ];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
