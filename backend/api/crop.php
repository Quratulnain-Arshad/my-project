<?php
// Crop detail API — returns one crop by slug (images, sections, videos)
require_once __DIR__ . '/../conn.php';

header('Content-Type: application/json; charset=utf-8');

$slug = strtolower(trim($_GET['slug'] ?? ''));
$slug = preg_replace('/[^a-z0-9_-]/', '', $slug);

if ($slug === '') {
    echo json_encode(['error' => 'slug required']);
    exit;
}

$safe = $conn->real_escape_string($slug);
$crop = $conn->query("SELECT * FROM crops WHERE slug='$safe'")->fetch_assoc();

if (!$crop) {
    echo json_encode(['error' => 'Crop not found']);
    exit;
}

$cropId = (int)$crop['id'];

// Gallery images
$images = $conn->query(
    "SELECT * FROM crop_images WHERE crop_id=$cropId ORDER BY sort_order"
)->fetch_all(MYSQLI_ASSOC);

$guide = [
    'en' => [
        'title'    => $crop['name_en'],
        'lang_btn' => 'اردو',
        'next_btn' => 'View Details',
        'sections' => [],
    ],
    'ur' => [
        'title'    => $crop['name_ur'],
        'lang_btn' => 'English',
        'next_btn' => 'تفصیل دیکھیں',
        'sections' => [],
    ],
];

foreach ($images as $img) {
    $guide['en']['sections'][] = [
        'key'   => 'img_' . $img['id'],
        'label' => $img['caption'] ?: '',
        'image' => $img['image_path'],
    ];
    $guide['ur']['sections'][] = [
        'key'   => 'img_' . $img['id'],
        'label' => $img['caption_ur'] ?: $img['caption'],
        'image' => $img['image_path'],
    ];
}

// Text sections (English + Urdu)
$details = [];
foreach (['en' => 'english', 'ur' => 'urdu'] as $lang => $key) {
    $rows = $conn->query(
        "SELECT * FROM crop_sections WHERE crop_id=$cropId AND lang='$lang' ORDER BY sort_order"
    )->fetch_all(MYSQLI_ASSOC);

    $sections = [];
    foreach ($rows as $r) {
        $sections[] = [
            'order'   => (int)$r['sort_order'],
            'heading' => $r['heading'],
            'content' => $r['content'],
        ];
    }

    $details[$key] = [
        'title'    => ($lang === 'en') ? $crop['name_en'] : $crop['name_ur'],
        'sections' => $sections,
    ];
}

// YouTube video IDs
$videos = [];
foreach (['video_1', 'video_2', 'video_3', 'video_4'] as $col) {
    if (!empty($crop[$col])) {
        $videos[] = $crop[$col];
    }
}

echo json_encode([
    'slug'      => $crop['slug'],
    'name'      => ['en' => $crop['name_en'], 'ur' => $crop['name_ur']],
    'thumbnail' => $crop['thumbnail'],
    'videos'    => $videos,
    'guide'     => $guide,
    'details'   => $details,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
