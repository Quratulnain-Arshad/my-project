<?php
// Crop list API — all data from single `crops` table
require_once __DIR__ . '/../conn.php';

header('Content-Type: application/json; charset=utf-8');

$meta = [
    'en' => [
        'title'           => 'Crop Information',
        'subtitle'        => 'Select a crop to learn more',
        'switch_language' => 'اردو',
    ],
    'ur' => [
        'title'           => 'فصل کی معلومات',
        'subtitle'        => 'مزید جاننے کے لیے فصل منتخب کریں',
        'switch_language' => 'English',
    ],
];

$sw = $conn->query("SELECT lang, switch_language FROM farm_data");
if ($sw) {
    while ($row = $sw->fetch_assoc()) {
        if (!empty($row['switch_language'])) {
            $meta[$row['lang']]['switch_language'] = $row['switch_language'];
        }
    }
}

$cropsList = $conn->query("SELECT * FROM crops ORDER BY sort_order, name_en")->fetch_all(MYSQLI_ASSOC);

$output = ['languages' => []];

foreach (['en', 'ur'] as $lang) {
    $isUrdu = ($lang === 'ur');
    $crops = [];

    foreach ($cropsList as $c) {
        $crops[] = [
            'name'  => $isUrdu ? ($c['name_ur'] ?: $c['name_en']) : $c['name_en'],
            'desc'  => $isUrdu ? ($c['desc_ur'] ?: $c['desc_en'] ?: '') : ($c['desc_en'] ?? ''),
            'image' => $c['thumbnail'],
            'link'  => 'crop.php?slug=' . urlencode($c['slug']),
        ];
    }

    $output['languages'][$lang] = [
        'title'          => $meta[$lang]['title'],
        'subtitle'       => $meta[$lang]['subtitle'],
        'crops'          => $crops,
        'switchLanguage' => $meta[$lang]['switch_language'],
    ];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
