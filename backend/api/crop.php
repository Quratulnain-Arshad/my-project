<?php
// Crop detail API — one crop row; gallery titles auto-match section titles
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

$images = json_decode($crop['images'] ?? '[]', true);
if (!is_array($images)) $images = [];

$secEn = json_decode($crop['sections_en'] ?? '[]', true);
if (!is_array($secEn)) $secEn = [];

$secUr = json_decode($crop['sections_ur'] ?? '[]', true);
if (!is_array($secUr)) $secUr = [];

/** Normalize title for matching (Introduction ≈ "5. Introduction") */
function normTitle($s) {
    $s = mb_strtolower(trim(preg_replace('/\s+/u', ' ', $s ?? '')), 'UTF-8');
    $s = preg_replace('/^\d+[\.\)]\s*/u', '', $s);
    return $s;
}

/** Find section index by title; null if not found */
function findSectionIndex($sections, $title) {
    $n = normTitle($title);
    if ($n === '') return null;
    foreach ($sections as $i => $s) {
        if (normTitle($s['heading'] ?? '') === $n) return $i;
    }
    foreach ($sections as $i => $s) {
        $h = normTitle($s['heading'] ?? '');
        if ($h !== '' && (mb_strpos($h, $n) !== false || mb_strpos($n, $h) !== false)) {
            return $i;
        }
    }
    return null;
}

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

foreach ($images as $i => $img) {
    $captionEn = $img['caption'] ?? '';
    $captionUr = ($img['caption_ur'] ?? '') !== '' ? $img['caption_ur'] : $captionEn;

    // Match gallery title → section title (no duplicated text in DB)
    $enIdx = findSectionIndex($secEn, $captionEn);
    if ($enIdx === null && isset($secEn[$i])) $enIdx = $i;

    $urIdx = findSectionIndex($secUr, $captionUr);
    if ($urIdx === null && $enIdx !== null && isset($secUr[$enIdx])) $urIdx = $enIdx;
    if ($urIdx === null && isset($secUr[$i])) $urIdx = $i;

    $guide['en']['sections'][] = [
        'key'     => 'img_' . $i,
        'label'   => $captionEn,
        'image'   => $img['image'] ?? '',
        'content' => ($enIdx !== null) ? ($secEn[$enIdx]['content'] ?? '') : '',
    ];
    $guide['ur']['sections'][] = [
        'key'     => 'img_' . $i,
        'label'   => $captionUr,
        'image'   => $img['image'] ?? '',
        'content' => ($urIdx !== null) ? ($secUr[$urIdx]['content'] ?? '') : '',
    ];
}

$details = [
    'english' => ['title' => $crop['name_en'], 'sections' => []],
    'urdu'    => ['title' => $crop['name_ur'], 'sections' => []],
];

foreach ($secEn as $i => $s) {
    $details['english']['sections'][] = [
        'order'   => $i,
        'heading' => $s['heading'] ?? '',
        'content' => $s['content'] ?? '',
    ];
}
foreach ($secUr as $i => $s) {
    $details['urdu']['sections'][] = [
        'order'   => $i,
        'heading' => $s['heading'] ?? '',
        'content' => $s['content'] ?? '',
    ];
}

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
