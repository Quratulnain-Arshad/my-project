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

$conn->query("CREATE TABLE IF NOT EXISTS crop_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  crop_id INT NOT NULL,
  image_path VARCHAR(300) NOT NULL,
  caption VARCHAR(200) DEFAULT '',
  caption_ur VARCHAR(200) DEFAULT '',
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$conn->query("ALTER TABLE crop_images ADD COLUMN IF NOT EXISTS caption_ur VARCHAR(200) DEFAULT ''");

$conn->query("CREATE TABLE IF NOT EXISTS crop_sections (
  id INT AUTO_INCREMENT PRIMARY KEY,
  crop_id INT NOT NULL,
  lang CHAR(2) DEFAULT 'en',
  heading VARCHAR(300) DEFAULT '',
  content TEXT,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$slug = preg_replace('/[^a-z0-9_-]/', '', strtolower($_GET['slug'] ?? ''));
if (!$slug) { echo json_encode(['error' => 'slug required']); exit; }

$sEsc = $conn->real_escape_string($slug);
$crop = $conn->query("SELECT * FROM crops WHERE slug='$sEsc'")->fetch_assoc();
if (!$crop) { echo json_encode(['error' => 'Crop not found']); exit; }

$cid = (int)$crop['id'];

// Image gallery — becomes the guide sections shown as cards
$images = $conn->query("SELECT * FROM crop_images WHERE crop_id=$cid ORDER BY sort_order")->fetch_all(MYSQLI_ASSOC);

$guideData = [
    'en' => [
        'title'    => $crop['name_en'] ?? '',
        'lang_btn' => 'اردو',
        'next_btn' => 'View Details',
        'sections' => array_map(fn($img) => [
            'key'   => 'img_' . $img['id'],
            'label' => $img['caption'] ?: '',
            'image' => $img['image_path'],
        ], $images),
    ],
    'ur' => [
        'title'    => $crop['name_ur'] ?? '',
        'lang_btn' => 'English',
        'next_btn' => 'تفصیل دیکھیں',
        'sections' => array_map(fn($img) => [
            'key'   => 'img_' . $img['id'],
            'label' => $img['caption_ur'] ?: $img['caption'],
            'image' => $img['image_path'],
        ], $images),
    ],
];

// Detail sections per language
$detailData = [];
foreach (['en' => 'english', 'ur' => 'urdu'] as $lang => $key) {
    $rows = $conn->query("SELECT * FROM crop_sections WHERE crop_id=$cid AND lang='$lang' ORDER BY sort_order")->fetch_all(MYSQLI_ASSOC);
    $detailData[$key] = [
        'title'    => ($lang == 'en' ? $crop['name_en'] : $crop['name_ur']) ?? '',
        'sections' => array_map(fn($r) => [
            'order'   => (int)$r['sort_order'],
            'heading' => $r['heading'],
            'content' => $r['content'],
        ], $rows),
    ];
}

echo json_encode([
    'slug'      => $crop['slug'],
    'name'      => ['en' => $crop['name_en'], 'ur' => $crop['name_ur']],
    'thumbnail' => $crop['thumbnail'],
    'videos'    => array_values(array_filter([
        $crop['video_1'] ?? '',
        $crop['video_2'] ?? '',
        $crop['video_3'] ?? '',
        $crop['video_4'] ?? ''
    ])),
    'guide'     => $guideData,
    'details'   => $detailData,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
