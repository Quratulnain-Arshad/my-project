<?php
require_once __DIR__ . '/../config.php';
requireLogin();

foreach (['crop_images','crop_sections'] as $tbl) {
    $conn->query("CREATE TABLE IF NOT EXISTS $tbl (id INT AUTO_INCREMENT PRIMARY KEY, crop_id INT NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

$counts = [];
foreach (['crops', 'agri_cost'] as $t) {
    $r = $conn->query("SELECT COUNT(*) FROM `$t`");
    $counts[$t] = $r ? (int)$r->fetch_row()[0] : 0;
}
$r = $conn->query("SELECT COUNT(*) FROM crop_images"); $counts['crop_images'] = $r ? (int)$r->fetch_row()[0] : 0;
$r = $conn->query("SELECT COUNT(*) FROM crop_sections"); $counts['crop_sections'] = $r ? (int)$r->fetch_row()[0] : 0;

$liveCards = $conn->query("SELECT id, slug, name_en AS name, thumbnail AS image_url FROM crops ORDER BY sort_order, name_en")->fetch_all(MYSQLI_ASSOC);
$dynCrops  = $conn->query("SELECT id, slug, name_en FROM crops ORDER BY sort_order, name_en")->fetch_all(MYSQLI_ASSOC);

$imgCounts = [];
$ir = $conn->query("SELECT crop_id, COUNT(*) as cnt FROM crop_images GROUP BY crop_id");
if ($ir) while ($row = $ir->fetch_assoc()) { $imgCounts[$row['crop_id']] = (int)$row['cnt']; }

$secCounts = [];
$sr = $conn->query("SELECT crop_id, COUNT(*) as cnt FROM crop_sections GROUP BY crop_id");
if ($sr) while ($row = $sr->fetch_assoc()) { $secCounts[$row['crop_id']] = (int)$row['cnt']; }

$admin = $_SESSION['admin_user'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard — FarmEase Admin</title>
<?php include __DIR__ . '/partials/head-styles.php'; ?>
<style>
.welcome-bar{background:linear-gradient(120deg,#043915,#2e7d32);color:#fff;border-radius:12px;padding:22px 28px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;gap:16px}
.welcome-bar h2{font-size:1.2rem;font-weight:700;margin-bottom:4px}
.welcome-bar p{font-size:.82rem;opacity:.85}
.welcome-actions{display:flex;gap:10px;flex-shrink:0}
.wb-btn{padding:8px 16px;border-radius:7px;font-size:.8rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .2s}
.wb-btn-white{background:#fff;color:#043915}.wb-btn-white:hover{background:#e8f5e9}
.wb-btn-ghost{background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3)}.wb-btn-ghost:hover{background:rgba(255,255,255,.28)}

.stat-colors { --c1:#e8f5e9;--c2:#e3f2fd;--c3:#fff8e1;--c4:#fce4ec;--c5:#f3e5f5; }
.stat-card:nth-child(1){border-left-color:#4caf50}.stat-card:nth-child(1) .stat-icon{background:#e8f5e9;color:#2e7d32}
.stat-card:nth-child(2){border-left-color:#2196f3}.stat-card:nth-child(2) .stat-icon{background:#e3f2fd;color:#1565c0}
.stat-card:nth-child(3){border-left-color:#ff9800}.stat-card:nth-child(3) .stat-icon{background:#fff8e1;color:#e65100}
.stat-card:nth-child(4){border-left-color:#e91e63}.stat-card:nth-child(4) .stat-icon{background:#fce4ec;color:#880e4f}
.stat-card:nth-child(5){border-left-color:#9c27b0}.stat-card:nth-child(5) .stat-icon{background:#f3e5f5;color:#4a148c}

.live-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;margin-top:14px}
.live-card{background:#f9fdf9;border:1px solid #d4ebd4;border-radius:10px;overflow:hidden;transition:box-shadow .2s}
.live-card:hover{box-shadow:0 4px 14px rgba(4,57,21,.12)}
.live-card img{width:100%;height:110px;object-fit:cover;display:block;background:#e8f5e9}
.live-card-body{padding:10px 12px}
.live-card-body h4{font-size:.84rem;font-weight:700;color:#043915;margin-bottom:3px}
.live-card-body p{font-size:.74rem;color:#666;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

.guide-row{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e8f5e9}
.guide-row:last-child{border-bottom:none}
.guide-name{font-weight:600;font-size:.86rem;text-transform:capitalize;color:#043915}
.badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:600}
.badge-ok{background:#e8f5e9;color:#2e7d32}
.badge-warn{background:#fff8e1;color:#e65100}

.flow-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:14px}
.flow-step{background:#f9fdf9;border:1px solid #d4ebd4;border-radius:10px;padding:18px 16px;text-align:center}
.flow-step .step-num{width:32px;height:32px;border-radius:50%;background:#043915;color:#fff;font-size:.8rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 10px}
.flow-step h4{font-size:.84rem;font-weight:700;color:#043915;margin-bottom:5px}
.flow-step p{font-size:.74rem;color:#666;line-height:1.5}
.flow-arrow{display:flex;align-items:center;justify-content:center;color:#4caf50;font-size:1.3rem}
@media(max-width:700px){.flow-steps{grid-template-columns:1fr}.welcome-bar{flex-direction:column}.welcome-actions{width:100%}}
</style>
</head>
<body>
<div class="layout">
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<main class="content">

  <!-- Welcome Banner -->
  <div class="welcome-bar">
    <div>
      <h2><i class="fa-solid fa-hand-wave"></i> Welcome back, <?= htmlspecialchars($admin) ?>!</h2>
      <p>Manage your FarmEase content. Changes you save here appear on the website immediately.</p>
    </div>
    <div class="welcome-actions">
      <a href="../../frontend/index.php" target="_blank" class="wb-btn wb-btn-white">
        <i class="fa-solid fa-eye"></i> View Live Site
      </a>
      <a href="../setup.php" class="wb-btn wb-btn-ghost">
        <i class="fa-solid fa-rotate"></i> Re-run Setup
      </a>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <a href="crop-info.php" class="stat-card">
      <div class="stat-icon"><i class="fa-solid fa-seedling"></i></div>
      <div class="stat-info">
        <div class="stat-num"><?= $counts['crops'] ?></div>
        <div class="stat-label">Crops</div>
      </div>
    </a>
    <a href="crop-info.php" class="stat-card">
      <div class="stat-icon"><i class="fa-solid fa-images"></i></div>
      <div class="stat-info">
        <div class="stat-num"><?= $counts['crop_images'] ?></div>
        <div class="stat-label">Crop Images</div>
      </div>
    </a>
    <a href="crop-info.php" class="stat-card">
      <div class="stat-icon"><i class="fa-solid fa-file-lines"></i></div>
      <div class="stat-info">
        <div class="stat-num"><?= $counts['crop_sections'] ?></div>
        <div class="stat-label">Detail Sections</div>
      </div>
    </a>
    <a href="agri-cost.php" class="stat-card">
      <div class="stat-icon"><i class="fa-solid fa-coins"></i></div>
      <div class="stat-info">
        <div class="stat-num"><?= $counts['agri_cost'] ?></div>
        <div class="stat-label">AgriCost Entries</div>
      </div>
    </a>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

    <!-- Live Crops Preview -->
    <div class="card">
      <h2><i class="fa-solid fa-seedling"></i> Crops <small style="font-weight:400;color:#888;font-size:.75rem;margin-left:6px">(what visitors see)</small></h2>
      <?php if (empty($liveCards)): ?>
        <p style="color:#999;font-size:.84rem">No crops yet. <a href="crop-info.php?view=new" style="color:#043915">Add the first one →</a></p>
      <?php else: ?>
      <div class="live-grid">
        <?php foreach ($liveCards as $card): ?>
        <div class="live-card">
          <?php if ($card['image_url']): ?>
            <img src="../../frontend/<?= htmlspecialchars($card['image_url']) ?>" alt="">
          <?php else: ?>
            <div style="height:110px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:1.5rem"><i class="fa-solid fa-leaf"></i></div>
          <?php endif; ?>
          <div class="live-card-body">
            <h4><?= htmlspecialchars($card['name']) ?></h4>
            <div style="font-size:.72rem;color:#888">/<?= htmlspecialchars($card['slug']) ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <div style="margin-top:14px">
        <a href="crop-info.php" class="btn btn-outline btn-sm"><i class="fa-solid fa-pen"></i> Manage Crops</a>
      </div>
    </div>

    <!-- Crop Status -->
    <div class="card">
      <h2><i class="fa-solid fa-book-open"></i> Crop Content Status</h2>
      <?php if (empty($dynCrops)): ?>
        <p style="color:#999;font-size:.84rem">No crops yet. <a href="crop-info.php?view=new" style="color:#043915">Add crops →</a></p>
      <?php else: ?>
      <?php foreach ($dynCrops as $c): ?>
      <div class="guide-row">
        <div>
          <div class="guide-name"><i class="fa-solid fa-leaf" style="color:#4caf50;margin-right:6px;font-size:.75rem"></i><?= htmlspecialchars($c['name_en']) ?></div>
          <div style="font-size:.72rem;color:#888;margin-top:2px">
            <?= $imgCounts[$c['id']] ?? 0 ?> images &bull; <?= $secCounts[$c['id']] ?? 0 ?> sections
          </div>
        </div>
        <div style="display:flex;gap:6px;align-items:center">
          <?php if (($imgCounts[$c['id']] ?? 0) > 0): ?>
            <span class="badge badge-ok"><i class="fa-solid fa-circle-check"></i> Has images</span>
          <?php else: ?>
            <span class="badge badge-warn"><i class="fa-solid fa-triangle-exclamation"></i> No images</span>
          <?php endif; ?>
          <a href="crop-info.php?view=edit&id=<?= $c['id'] ?>" class="btn btn-outline btn-sm"><i class="fa-solid fa-pen"></i></a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
      <div style="margin-top:14px">
        <a href="crop-info.php" class="btn btn-outline btn-sm"><i class="fa-solid fa-pen"></i> Manage All Crops</a>
      </div>
    </div>
  </div>

  <!-- Data Flow -->
  <div class="card">
    <h2><i class="fa-solid fa-arrow-right-arrow-left"></i> How Your Changes Show on the Website</h2>
    <div class="flow-steps">
      <div class="flow-step">
        <div class="step-num">1</div>
        <h4><i class="fa-solid fa-pen" style="color:#4caf50"></i> Edit in Admin</h4>
        <p>Use Crop Info or AgriCost in the sidebar to update data and click Save.</p>
      </div>
      <div class="flow-step">
        <div class="step-num">2</div>
        <h4><i class="fa-solid fa-database" style="color:#2196f3"></i> Saved to Database</h4>
        <p>Your changes are written to the MySQL database instantly. No file editing needed.</p>
      </div>
      <div class="flow-step">
        <div class="step-num">3</div>
        <h4><i class="fa-solid fa-globe" style="color:#4caf50"></i> Live on Website</h4>
        <p>When a visitor opens the frontend, the page fetches fresh data from the database and shows your latest content automatically.</p>
      </div>
    </div>
    <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap">
      <a href="../../frontend/index.php" target="_blank" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Home Page</a>
      <a href="../../frontend/crop-info.php" target="_blank" class="btn btn-outline"><i class="fa-solid fa-seedling"></i> Crop Info</a>
      <a href="../../frontend/agri-cost.php" target="_blank" class="btn btn-outline"><i class="fa-solid fa-coins"></i> AgriCost</a>
    </div>
  </div>

</main>
</div>
</body>
</html>
