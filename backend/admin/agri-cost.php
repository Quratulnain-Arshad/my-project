<?php
require_once __DIR__ . '/../config.php';
requireLogin();

$conn->query("CREATE TABLE IF NOT EXISTS agri_cost (
  id INT AUTO_INCREMENT PRIMARY KEY,
  crop_key VARCHAR(100) NOT NULL UNIQUE,
  name_en VARCHAR(200) DEFAULT '',
  name_ur VARCHAR(200) DEFAULT '',
  desc_en TEXT,
  desc_ur TEXT,
  details_en TEXT,
  details_ur TEXT
)");

// Strip legacy <b> / </b> tags left over from old rich-text editor
$conn->query("UPDATE agri_cost SET
    name_en    = REPLACE(REPLACE(REPLACE(name_en,   '<b>',''),'</b>',''),'<b ',''),
    name_ur    = REPLACE(REPLACE(REPLACE(name_ur,   '<b>',''),'</b>',''),'<b ',''),
    details_en = REPLACE(REPLACE(REPLACE(details_en,'<b>',''),'</b>',''),'<b ',''),
    details_ur = REPLACE(REPLACE(REPLACE(details_ur,'<b>',''),'</b>',''),'<b ',''),
    desc_en    = REPLACE(REPLACE(REPLACE(desc_en,   '<b>',''),'</b>',''),'<b ',''),
    desc_ur    = REPLACE(REPLACE(REPLACE(desc_ur,   '<b>',''),'</b>',''),'<b ','')
    WHERE name_en LIKE '%<b%' OR details_en LIKE '%<b%' OR desc_en LIKE '%<b%'");

$action = $_POST['_action'] ?? '';

if ($action === 'save') {
    $key   = $conn->real_escape_string($_POST['crop_key']);
    $nEn   = $conn->real_escape_string($_POST['name_en']);
    $nUr   = $conn->real_escape_string($_POST['name_ur']);
    $dEn   = $conn->real_escape_string($_POST['desc_en']);
    $dUr   = $conn->real_escape_string($_POST['desc_ur']);
    $dtEn  = $conn->real_escape_string($_POST['details_en']);
    $dtUr  = $conn->real_escape_string($_POST['details_ur']);
    $conn->query("INSERT INTO agri_cost (crop_key,name_en,name_ur,desc_en,desc_ur,details_en,details_ur)
        VALUES ('$key','$nEn','$nUr','$dEn','$dUr','$dtEn','$dtUr')
        ON DUPLICATE KEY UPDATE
        name_en='$nEn',name_ur='$nUr',desc_en='$dEn',desc_ur='$dUr',details_en='$dtEn',details_ur='$dtUr'");
    header("Location: agri-cost.php?crop=$key&msg=saved");
    exit;

} elseif ($action === 'add_new') {
    $key  = $conn->real_escape_string(preg_replace('/[^a-z0-9_-]/', '-', strtolower(trim($_POST['new_key']))));
    $name = $conn->real_escape_string(trim($_POST['new_name']));
    if ($key) {
        $conn->query("INSERT IGNORE INTO agri_cost (crop_key,name_en) VALUES ('$key','$name')");
    }
    header("Location: agri-cost.php?crop=$key&msg=added");
    exit;

} elseif ($action === 'delete') {
    $key = $conn->real_escape_string($_POST['crop_key']);
    $conn->query("DELETE FROM agri_cost WHERE crop_key='$key'");
    header("Location: agri-cost.php?msg=deleted");
    exit;
}

$msg     = $_GET['msg'] ?? '';
$entries = $conn->query("SELECT * FROM agri_cost ORDER BY crop_key")->fetch_all(MYSQLI_ASSOC);
$selKey  = $_GET['crop'] ?? ($entries[0]['crop_key'] ?? '');
$current = null;
foreach ($entries as $e) { if ($e['crop_key'] === $selKey) { $current = $e; break; } }

$msgMap = ['saved'=>'Saved successfully.','added'=>'Entry added.','deleted'=>'Deleted.'];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>AgriCost Data</title>
<?php include __DIR__ . '/partials/head-styles.php'; ?>
<style>
.ac-layout{display:grid;grid-template-columns:220px 1fr;gap:20px;align-items:start}
.ac-sidebar{background:#fff;border:1px solid #c8e6c9;border-radius:10px;overflow:hidden}
.ac-sidebar-head{background:#043915;color:#fff;padding:12px 16px;font-weight:600;font-size:.88rem}
.ac-entry{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-bottom:1px solid #f0f4f0;cursor:pointer;text-decoration:none;color:#333;font-size:.87rem;transition:background .15s}
.ac-entry:hover{background:#f5fdf5}
.ac-entry.active{background:#e8f5e9;color:#043915;font-weight:600;border-left:3px solid #4caf50}
.ac-entry .key-badge{font-size:.7rem;color:#888;background:#f5f5f5;border-radius:4px;padding:1px 6px;font-family:monospace}
.ac-add-form{padding:12px;border-top:1px solid #e0e0e0}
.ac-add-form input{width:100%;margin-bottom:6px;padding:7px 10px;border:1px solid #c8e6c9;border-radius:6px;font-size:.84rem}
.ac-add-form button{width:100%;padding:7px;background:#4caf50;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:.84rem;font-weight:600}
.ac-add-form button:hover{background:#388e3c}
.tall{min-height:200px}
@media(max-width:800px){.ac-layout{grid-template-columns:1fr}}
</style>
</head><body>
<div class="layout">
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<main class="content">
  <div class="page-header"><h1>AgriCost Data</h1></div>

  <?php if ($msg && isset($msgMap[$msg])): ?>
  <div class="alert alert-success">✔ <?= $msgMap[$msg] ?></div>
  <?php endif; ?>

  <?php if (empty($entries) && !$current): ?>
  <div class="card" style="text-align:center;padding:40px">
    <div style="font-size:2.5rem;margin-bottom:10px">💰</div>
    <p style="color:#888;margin-bottom:16px">No AgriCost entries yet. Add the first one below.</p>
  </div>
  <?php endif; ?>

  <div class="ac-layout">

    <!-- Left: Entry List -->
    <div>
      <div class="ac-sidebar">
        <div class="ac-sidebar-head">Cost Entries (<?= count($entries) ?>)</div>
        <?php foreach ($entries as $e): ?>
        <a href="?crop=<?= urlencode($e['crop_key']) ?>"
           class="ac-entry <?= $e['crop_key'] === $selKey ? 'active' : '' ?>">
          <span><?= htmlspecialchars($e['name_en'] ?: ucfirst($e['crop_key'])) ?></span>
          <span class="key-badge"><?= htmlspecialchars($e['crop_key']) ?></span>
        </a>
        <?php endforeach; ?>

        <!-- Add new entry form -->
        <form method="POST" class="ac-add-form">
          <input type="hidden" name="_action" value="add_new">
          <input type="text" name="new_name" placeholder="Display name (e.g. Wheat)" required>
          <input type="text" name="new_key"  placeholder="Key (e.g. wheat)" required
                 pattern="[a-zA-Z0-9_\-]+" title="Letters, numbers, hyphens only">
          <button type="submit">+ Add Entry</button>
        </form>
      </div>
    </div>

    <!-- Right: Edit Form -->
    <div>
      <?php if ($current): ?>
      <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
          <h2 style="margin:0">Edit: <?= htmlspecialchars($current['name_en'] ?: $current['crop_key']) ?></h2>
          <form method="POST" onsubmit="return confirm('Delete this entry?')" style="margin:0">
            <input type="hidden" name="_action" value="delete">
            <input type="hidden" name="crop_key" value="<?= htmlspecialchars($current['crop_key']) ?>">
            <button class="btn btn-danger btn-sm">🗑 Delete</button>
          </form>
        </div>
        <form method="POST">
          <input type="hidden" name="_action" value="save">
          <input type="hidden" name="crop_key" value="<?= htmlspecialchars($current['crop_key']) ?>">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <div>
              <h3 style="margin-bottom:12px;color:#043915;font-size:.95rem">🇬🇧 English</h3>
              <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="name_en" value="<?= htmlspecialchars($current['name_en']) ?>" placeholder="e.g. Wheat">
              </div>
              <div class="form-group" style="margin-top:10px">
                <label>Short Description</label>
                <textarea name="desc_en" style="min-height:80px"><?= htmlspecialchars($current['desc_en'] ?? '') ?></textarea>
              </div>
              <div class="form-group" style="margin-top:10px">
                <label>Full Cost Details</label>
                <textarea class="tall" name="details_en"><?= htmlspecialchars($current['details_en'] ?? '') ?></textarea>
                <small style="color:#777">Plain text with line breaks. Shown as-is on the frontend.</small>
              </div>
            </div>
            <div>
              <h3 style="margin-bottom:12px;color:#043915;font-size:.95rem">🇵🇰 اردو</h3>
              <div class="form-group">
                <label>نام</label>
                <input type="text" name="name_ur" dir="rtl" value="<?= htmlspecialchars($current['name_ur'] ?? '') ?>" placeholder="مثلاً گندم">
              </div>
              <div class="form-group" style="margin-top:10px">
                <label>مختصر تفصیل</label>
                <textarea name="desc_ur" dir="rtl" style="min-height:80px;text-align:right"><?= htmlspecialchars($current['desc_ur'] ?? '') ?></textarea>
              </div>
              <div class="form-group" style="margin-top:10px">
                <label>مکمل لاگت کی تفصیلات</label>
                <textarea class="tall" name="details_ur" dir="rtl" style="text-align:right"><?= htmlspecialchars($current['details_ur'] ?? '') ?></textarea>
              </div>
            </div>
          </div>
          <div class="btn-group" style="margin-top:16px">
            <button type="submit" class="btn btn-primary">💾 Save</button>
            <a href="../../frontend/agri-cost.php" target="_blank" class="btn btn-outline">
              <i class="fa-solid fa-eye"></i> Preview on Site
            </a>
          </div>
        </form>
      </div>

      <?php else: ?>
      <div class="card" style="text-align:center;padding:50px 20px;color:#aaa">
        <div style="font-size:2rem;margin-bottom:8px">←</div>
        <p>Select an entry from the left to edit it, or add a new one.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>

</main></div></body></html>
