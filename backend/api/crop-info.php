<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$conn->query("CREATE TABLE IF NOT EXISTS crops (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) NOT NULL UNIQUE,
  name_en VARCHAR(200) DEFAULT '',
  name_ur VARCHAR(200) DEFAULT '',
  thumbnail VARCHAR(300) DEFAULT '',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$metaRows = [];
$meta = $conn->query("SELECT lang, title, subtitle, switch_language FROM farm_data ORDER BY lang ASC");
if ($meta) {
    while ($r = $meta->fetch_assoc()) {
        $metaRows[$r['lang']] = $r;
    }
}

$cropsList = $conn->query("SELECT * FROM crops ORDER BY sort_order, name_en")->fetch_all(MYSQLI_ASSOC);

$output = ['languages' => []];
foreach (['en', 'ur'] as $lang) {
    $isUr = ($lang === 'ur');
    $crops = [];
    foreach ($cropsList as $c) {
        $crops[] = [
            'name'  => $isUr ? ($c['name_ur'] ?: $c['name_en']) : $c['name_en'],
            'desc'  => '',
            'image' => $c['thumbnail'],
            'link'  => 'crop.php?slug=' . urlencode($c['slug']),
        ];
    }
    $output['languages'][$lang] = [
        'title'          => $metaRows[$lang]['title']           ?? 'Crop Information',
        'subtitle'       => $metaRows[$lang]['subtitle']        ?? 'Select a crop to learn more',
        'crops'          => $crops,
        'switchLanguage' => $metaRows[$lang]['switch_language'] ?? ($isUr ? 'English' : 'اردو'),
    ];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
