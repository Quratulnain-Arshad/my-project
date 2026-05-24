<?php
require_once __DIR__ . '/../config.php';
requireLogin();

function tableExists($conn, $table) {
    $r = $conn->query("SHOW TABLES LIKE '$table'");
    return $r && $r->num_rows > 0;
}

$hasGuides  = tableExists($conn, 'crop_guides');
$hasDetails = tableExists($conn, 'crop_details');

$defaults = [
    'wheat'  => ['Wheat',  'گندم', 'assets/image.jpeg',        2],
    'rice'   => ['Rice',   'چاول', 'assets/rice-intro.jpeg',   1],
    'potato' => ['Potato', 'آلو',  'assets/potato-intro.jpeg', 3],
    'maize'  => ['Maize',  'مکئی', 'assets/maize-intro.jpg',   4],
];

$log    = [];
$action = $_POST['_action'] ?? '';

if ($action === 'migrate') {
    // ── Step 1: ensure all 4 crops exist in crops table ──────────────
    foreach ($defaults as $slug => [$nameEn, $nameUr, $thumb, $sort]) {
        $sEsc = $conn->real_escape_string($slug);
        $row  = $conn->query("SELECT id FROM crops WHERE slug='$sEsc'")->fetch_assoc();
        if (!$row) {
            $nEsc  = $conn->real_escape_string($nameEn);
            $nuEsc = $conn->real_escape_string($nameUr);
            $tEsc  = $conn->real_escape_string($thumb);
            $conn->query("INSERT INTO crops (slug,name_en,name_ur,thumbnail,sort_order) VALUES ('$sEsc','$nEsc','$nuEsc','$tEsc',$sort)");
            $log[] = ['ok', "Added crop: $nameEn (slug=$slug)"];
        } else {
            $log[] = ['skip', "Crop $slug already exists (id=" . $row['id'] . ")"];
        }
    }

    // ── Build slug→crop_id map ────────────────────────────────────────
    $cropIds = [];
    foreach ($defaults as $slug => $_) {
        $sEsc = $conn->real_escape_string($slug);
        $row  = $conn->query("SELECT id FROM crops WHERE slug='$sEsc'")->fetch_assoc();
        if ($row) $cropIds[$slug] = (int)$row['id'];
    }

    // ── Step 2: migrate crop_guides → crop_images ────────────────────
    if ($hasGuides) {
        $keys = ['intro','climate','soil','sowing','fertilizer','pests','harvest'];
        foreach ($cropIds as $slug => $cid) {
            $existing = (int)$conn->query("SELECT COUNT(*) FROM crop_images WHERE crop_id=$cid")->fetch_row()[0];
            if ($existing > 0) {
                $log[] = ['skip', "Images for $slug skipped (already has $existing)"];
                continue;
            }
            $sEsc = $conn->real_escape_string($slug);
            $g    = $conn->query("SELECT * FROM crop_guides WHERE crop='$sEsc' AND lang='en'")->fetch_assoc();
            if (!$g) { $log[] = ['warn', "No crop_guides data for $slug"]; continue; }
            $sort = 0;
            foreach ($keys as $k) {
                $img   = $g['img_'.$k]     ?? '';
                $label = $g['section_'.$k] ?? ucfirst($k);
                if (!$img) continue;
                $iEsc = $conn->real_escape_string($img);
                $lEsc = $conn->real_escape_string($label);
                $conn->query("INSERT INTO crop_images (crop_id,image_path,caption,sort_order) VALUES ($cid,'$iEsc','$lEsc',$sort)");
                $sort++;
            }
            $log[] = ['ok', "Migrated $sort images for $slug"];
        }
    } else {
        $log[] = ['warn', 'crop_guides table not found — skipping image migration'];
    }

    // ── Step 3: migrate crop_details → crop_sections ─────────────────
    if ($hasDetails) {
        foreach ($cropIds as $slug => $cid) {
            $existing = (int)$conn->query("SELECT COUNT(*) FROM crop_sections WHERE crop_id=$cid")->fetch_row()[0];
            if ($existing > 0) {
                $log[] = ['skip', "Sections for $slug skipped (already has $existing)"];
                continue;
            }
            $sEsc = $conn->real_escape_string($slug);
            $rows = $conn->query("SELECT * FROM crop_details WHERE crop='$sEsc' ORDER BY lang, section_order")->fetch_all(MYSQLI_ASSOC);
            if (empty($rows)) { $log[] = ['warn', "No crop_details data for $slug"]; continue; }
            foreach ($rows as $d) {
                $lang = $d['lang'] === 'urdu' ? 'ur' : 'en';
                $h    = $conn->real_escape_string(trim($d['heading']));
                $c    = $conn->real_escape_string($d['content'] ?? '');
                $ord  = (int)$d['section_order'];
                $conn->query("INSERT INTO crop_sections (crop_id,lang,heading,content,sort_order) VALUES ($cid,'$lang','$h','$c',$ord)");
            }
            $log[] = ['ok', "Migrated " . count($rows) . " sections for $slug"];
        }
    } else {
        $log[] = ['warn', 'crop_details table not found — skipping section migration'];
    }

    // ── Step 4: fix agri_cost names (strip <b> tags) ─────────────────
    $conn->query("UPDATE agri_cost SET
        name_en = REPLACE(REPLACE(name_en,'<b>',''),'</b>',''),
        name_ur = REPLACE(REPLACE(name_ur,'<b>',''),'</b>','')");
    $log[] = ['ok', 'Cleaned HTML tags from agri_cost names'];
}

// Preview counts
$preview = [];
foreach ($defaults as $slug => [$nameEn]) {
    $sEsc = $conn->real_escape_string($slug);
    $crop = $conn->query("SELECT id FROM crops WHERE slug='$sEsc'")->fetch_assoc();
    $cid  = $crop ? (int)$crop['id'] : null;
    $imgs = $cid ? (int)$conn->query("SELECT COUNT(*) FROM crop_images WHERE crop_id=$cid")->fetch_row()[0] : 0;
    $secs = $cid ? (int)$conn->query("SELECT COUNT(*) FROM crop_sections WHERE crop_id=$cid")->fetch_row()[0] : 0;
    $gImg = 0;
    if ($hasGuides) {
        $g = $conn->query("SELECT * FROM crop_guides WHERE crop='$sEsc' AND lang='en'")->fetch_assoc();
        if ($g) foreach(['intro','climate','soil','sowing','fertilizer','pests','harvest'] as $k) { if (!empty($g['img_'.$k])) $gImg++; }
    }
    $gSec = $hasDetails ? (int)$conn->query("SELECT COUNT(*) FROM crop_details WHERE crop='$sEsc'")->fetch_row()[0] : 0;
    $preview[$slug] = compact('nameEn','cid','imgs','secs','gImg','gSec');
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Migrate Old Data</title>
<?php include __DIR__ . '/partials/head-styles.php'; ?>
<style>
.log-entry{padding:7px 12px;border-radius:6px;margin-bottom:6px;font-size:.88rem;display:flex;gap:8px;align-items:flex-start}
.log-ok{background:#e8f5e9;color:#2e7d32}
.log-skip{background:#f5f5f5;color:#666}
.log-warn{background:#fff8e1;color:#e65100}
.preview-table td,.preview-table th{padding:8px 12px;border:1px solid #e0e0e0;font-size:.85rem}
.preview-table{border-collapse:collapse;width:100%;margin-top:10px}
.preview-table th{background:#f5f5f5;font-weight:600}
.c-ok{color:#2e7d32;font-weight:600}.c-warn{color:#e65100;font-weight:600}
</style>
</head><body>
<div class="layout">
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<main class="content">
  <div class="page-header">
    <h1>Migrate Old Crop Data</h1>
    <a href="crop-info.php" class="btn btn-outline">← Crop Info</a>
  </div>

  <?php if (!empty($log)): ?>
  <div class="card">
    <h2>Migration Results</h2>
    <?php foreach ($log as [$type, $msg]): ?>
    <div class="log-entry log-<?= $type ?>">
      <?= $type === 'ok' ? '✔' : ($type === 'warn' ? '⚠' : '→') ?>
      <?= htmlspecialchars($msg) ?>
    </div>
    <?php endforeach; ?>
    <div style="margin-top:14px">
      <a href="crop-info.php" class="btn btn-primary">Go to Crop Info →</a>
    </div>
  </div>
  <?php endif; ?>

  <div class="card">
    <h2>Current Status</h2>
    <table class="preview-table">
      <tr><th>Crop</th><th>In crops table</th><th>crop_images</th><th>From crop_guides</th><th>crop_sections</th><th>From crop_details</th></tr>
      <?php foreach ($preview as $slug => $p): ?>
      <tr>
        <td><strong><?= $p['nameEn'] ?></strong></td>
        <td class="<?= $p['cid'] ? 'c-ok' : 'c-warn' ?>"><?= $p['cid'] ? 'Yes (id='.$p['cid'].')' : 'MISSING' ?></td>
        <td class="<?= $p['imgs'] > 0 ? 'c-ok' : 'c-warn' ?>"><?= $p['imgs'] ?> images</td>
        <td><?= $p['gImg'] ?> available</td>
        <td class="<?= $p['secs'] > 0 ? 'c-ok' : 'c-warn' ?>"><?= $p['secs'] ?> sections</td>
        <td><?= $p['gSec'] ?> available</td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <div class="card">
    <h2>Run Migration</h2>
    <p style="color:#555;margin-bottom:14px;font-size:.9rem">This will:
      <ul style="margin:8px 0 0 20px;font-size:.87rem;color:#555;line-height:1.9">
        <li>Add <strong>Wheat</strong> and <strong>Rice</strong> to the crops table if missing</li>
        <li>Copy images from <code>crop_guides</code> → <code>crop_images</code> (skips crops that already have images)</li>
        <li>Copy sections from <code>crop_details</code> → <code>crop_sections</code> (skips crops that already have sections)</li>
        <li>Clean up <code>&lt;b&gt;</code> HTML tags from AgriCost crop names</li>
      </ul>
    </p>
    <form method="POST">
      <input type="hidden" name="_action" value="migrate">
      <button type="submit" class="btn btn-primary">Run Migration Now</button>
    </form>
  </div>
</main></div></body></html>
