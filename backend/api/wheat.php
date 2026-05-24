<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

function assetUrl($path) {
    if (empty($path)) return '';
    if (preg_match('#^https?://#i', $path)) return $path;
    $frontendRoot = realpath(__DIR__ . '/../../frontend');
    $clean = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, ltrim($path, '/\\'));
    $full = $frontendRoot ? $frontendRoot . DIRECTORY_SEPARATOR . $clean : '';
    $url = str_replace(DIRECTORY_SEPARATOR, '/', ltrim($clean, DIRECTORY_SEPARATOR));
    if ($full && is_file($full)) $url .= '?v=' . filemtime($full);
    return $url;
}

$result = $conn->query("SELECT * FROM crop_guides WHERE crop='wheat' ORDER BY lang ASC");
$output = [];
while ($r = $result->fetch_assoc()) {
    $output[$r['lang']] = [
        'title'      => $r['title'],
        'intro'      => $r['section_intro'],
        'climate'    => $r['section_climate'],
        'soil'       => $r['section_soil'],
        'sowing'     => $r['section_sowing'],
        'fertilizer' => $r['section_fertilizer'],
        'pests'      => $r['section_pests'],
        'harvest'    => $r['section_harvest'],
        'next'       => $r['next_btn'],
        'langBtn'    => $r['lang_btn'],
        'images'     => [
            'intro'      => assetUrl($r['img_intro']),
            'climate'    => assetUrl($r['img_climate']),
            'soil'       => assetUrl($r['img_soil']),
            'sowing'     => assetUrl($r['img_sowing']),
            'fertilizer' => assetUrl($r['img_fertilizer']),
            'pests'      => assetUrl($r['img_pests']),
            'harvest'    => assetUrl($r['img_harvest']),
        ],
    ];
}
echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
