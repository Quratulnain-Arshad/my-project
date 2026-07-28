<?php
// Crop list API — returns all crops for Crop Info page
require_once __DIR__ . '/../conn.php';

header('Content-Type: application/json; charset=utf-8');

// Page title/subtitle (use fixed labels — farm_data is for Home page)
$meta = [
    'en' => [
        'title'          => 'Crop Information',
        'subtitle'       => 'Select a crop to learn more',
        'switch_language'=> 'اردو',
    ],
    'ur' => [
        'title'          => 'فصل کی معلومات',
        'subtitle'       => 'مزید جاننے کے لیے فصل منتخب کریں',
        'switch_language'=> 'English',
    ],
];

// Prefer switch label from farm_data if available
$sw = $conn->query("SELECT lang, switch_language FROM farm_data");
if ($sw) {
    while ($row = $sw->fetch_assoc()) {
        if (!empty($row['switch_language'])) {
            $meta[$row['lang']]['switch_language'] = $row['switch_language'];
        }
    }
}

// Crops + description (from crops table, fallback to old crop_info table)
$sql = "SELECT c.*,
            ci_en.description AS info_desc_en,
            ci_ur.description AS info_desc_ur
        FROM crops c
        LEFT JOIN crop_info ci_en
            ON ci_en.lang = 'en' AND ci_en.link_page LIKE CONCAT(c.slug, '%')
        LEFT JOIN crop_info ci_ur
            ON ci_ur.lang = 'ur' AND ci_ur.link_page LIKE CONCAT(c.slug, '%')
        ORDER BY c.sort_order, c.name_en";

$cropsList = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

$output = ['languages' => []];

foreach (['en', 'ur'] as $lang) {
    $isUrdu = ($lang === 'ur');
    $crops = [];

    foreach ($cropsList as $c) {
        // Use crops.desc_* first; if empty, use crop_info.description
        if ($isUrdu) {
            $desc = $c['desc_ur'] ?: ($c['info_desc_ur'] ?: ($c['desc_en'] ?: ($c['info_desc_en'] ?: '')));
        } else {
            $desc = $c['desc_en'] ?: ($c['info_desc_en'] ?: '');
        }

        $crops[] = [
            'name'  => $isUrdu ? ($c['name_ur'] ?: $c['name_en']) : $c['name_en'],
            'desc'  => $desc,
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
