<?php
require_once __DIR__ . '/../config.php';
requireLogin();

$conn->query("CREATE TABLE IF NOT EXISTS crops (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) NOT NULL UNIQUE,
  name_en VARCHAR(200) NOT NULL,
  name_ur VARCHAR(200) DEFAULT '',
  thumbnail VARCHAR(300) DEFAULT '',
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
$conn->query("CREATE TABLE IF NOT EXISTS crop_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  crop_id INT NOT NULL,
  image_path VARCHAR(300) NOT NULL,
  caption VARCHAR(200) DEFAULT '',
  caption_ur VARCHAR(200) DEFAULT '',
  sort_order INT DEFAULT 0
)");
// Add caption_ur to existing tables if missing
@$conn->query("ALTER TABLE crop_images ADD COLUMN caption_ur VARCHAR(200) DEFAULT '' AFTER caption");
// Add video columns to crops if missing
@$conn->query("ALTER TABLE crops ADD COLUMN video_1 VARCHAR(100) DEFAULT ''");
@$conn->query("ALTER TABLE crops ADD COLUMN video_2 VARCHAR(100) DEFAULT ''");
@$conn->query("ALTER TABLE crops ADD COLUMN video_3 VARCHAR(100) DEFAULT ''");
@$conn->query("ALTER TABLE crops ADD COLUMN video_4 VARCHAR(100) DEFAULT ''");
$conn->query("CREATE TABLE IF NOT EXISTS crop_sections (
  id INT AUTO_INCREMENT PRIMARY KEY,
  crop_id INT NOT NULL,
  lang CHAR(2) DEFAULT 'en',
  heading VARCHAR(300) DEFAULT '',
  content TEXT,
  sort_order INT DEFAULT 0
)");

function ciDir() {
    $d = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'frontend'
       . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($d)) @mkdir($d, 0777, true);
    return $d;
}
function ciUp($field) {
    if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) return null;
    $name = uniqid('img_') . '.' . $ext;
    return move_uploaded_file($_FILES[$field]['tmp_name'], ciDir() . DIRECTORY_SEPARATOR . $name)
        ? 'assets/uploads/' . $name : null;
}
function ciDel($path) {
    if (!$path || str_starts_with($path, 'http')) return;
    $full = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'frontend'
          . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    if (is_file($full)) @unlink($full);
}
function imgUrl($path) {
    if (!$path) return '';
    return str_starts_with($path, 'http') ? $path : '../../frontend/' . $path;
}

global $conn;
$action = $_POST['_action'] ?? '';

if ($action === 'create') {
    $slug  = $conn->real_escape_string(preg_replace('/[^a-z0-9_-]/', '-', strtolower(trim($_POST['slug']))));
    $nEn   = $conn->real_escape_string($_POST['name_en']);
    $nUr   = $conn->real_escape_string($_POST['name_ur'] ?? '');
    $sort  = (int)($_POST['sort_order'] ?? 0);
    $thumb = $conn->real_escape_string(ciUp('thumbnail') ?? '');
    if ($conn->query("INSERT INTO crops (slug,name_en,name_ur,thumbnail,sort_order) VALUES ('$slug','$nEn','$nUr','$thumb',$sort)")) {
        $newId = $conn->insert_id;
        header("Location: crop-info.php?view=edit&id=$newId&msg=created");
    } else {
        header("Location: crop-info.php?view=new&msg=slug_taken");
    }
    exit;

} elseif ($action === 'update_basic') {
    $cid   = (int)$_POST['crop_id'];
    $slug  = $conn->real_escape_string(preg_replace('/[^a-z0-9_-]/', '-', strtolower(trim($_POST['slug']))));
    $nEn   = $conn->real_escape_string($_POST['name_en']);
    $nUr   = $conn->real_escape_string($_POST['name_ur'] ?? '');
    $sort  = (int)($_POST['sort_order'] ?? 0);
    $thumb = ciUp('thumbnail');
    if ($thumb) {
        $cur = $conn->query("SELECT thumbnail FROM crops WHERE id=$cid")->fetch_assoc();
        ciDel($cur['thumbnail'] ?? '');
        $tEsc = $conn->real_escape_string($thumb);
        $conn->query("UPDATE crops SET slug='$slug',name_en='$nEn',name_ur='$nUr',thumbnail='$tEsc',sort_order=$sort WHERE id=$cid");
    } else {
        $conn->query("UPDATE crops SET slug='$slug',name_en='$nEn',name_ur='$nUr',sort_order=$sort WHERE id=$cid");
    }
    header("Location: crop-info.php?view=edit&id=$cid&msg=saved");
    exit;

} elseif ($action === 'add_image') {
    $cid     = (int)$_POST['crop_id'];
    $sort    = (int)($_POST['sort_order'] ?? 0);
    $cap     = $conn->real_escape_string($_POST['caption'] ?? '');
    $capUr   = $conn->real_escape_string($_POST['caption_ur'] ?? '');
    $added   = 0;
    $files   = $_FILES['image_file'] ?? [];
    $count   = is_array($files['name']) ? count($files['name']) : 0;
    $dir     = ciDir();
    for ($i = 0; $i < $count; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
        $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) continue;
        $name = uniqid('img_') . '.' . $ext;
        if (move_uploaded_file($files['tmp_name'][$i], $dir . DIRECTORY_SEPARATOR . $name)) {
            $pEsc = $conn->real_escape_string('assets/uploads/' . $name);
            $conn->query("INSERT INTO crop_images (crop_id,image_path,caption,caption_ur,sort_order) VALUES ($cid,'$pEsc','$cap','$capUr'," . ($sort + $added) . ")");
            $added++;
        }
    }
    header("Location: crop-info.php?view=edit&id=$cid&msg=img_added&tab=images");
    exit;

} elseif ($action === 'del_image') {
    $imgId = (int)$_POST['image_id'];
    $cid   = (int)$_POST['crop_id'];
    $row   = $conn->query("SELECT image_path FROM crop_images WHERE id=$imgId")->fetch_assoc();
    if ($row) ciDel($row['image_path']);
    $conn->query("DELETE FROM crop_images WHERE id=$imgId");
    header("Location: crop-info.php?view=edit&id=$cid&msg=img_deleted&tab=images");
    exit;

} elseif ($action === 'save_sections') {
    $cid  = (int)$_POST['crop_id'];
    $lang = ($_POST['lang'] ?? 'en') === 'ur' ? 'ur' : 'en';
    $conn->query("DELETE FROM crop_sections WHERE crop_id=$cid AND lang='$lang'");
    $headings = $_POST['heading'] ?? [];
    $contents = $_POST['content'] ?? [];
    foreach ($headings as $i => $h) {
        $h = $conn->real_escape_string($h);
        $c = $conn->real_escape_string($contents[$i] ?? '');
        $conn->query("INSERT INTO crop_sections (crop_id,lang,heading,content,sort_order) VALUES ($cid,'$lang','$h','$c',$i)");
    }
    header("Location: crop-info.php?view=edit&id=$cid&msg=sections_saved&tab=$lang");
    exit;

} elseif ($action === 'delete_crop') {
    $cid  = (int)$_POST['crop_id'];
    $imgs = $conn->query("SELECT image_path FROM crop_images WHERE crop_id=$cid")->fetch_all(MYSQLI_ASSOC);
    foreach ($imgs as $img) ciDel($img['image_path']);
    $cur = $conn->query("SELECT thumbnail FROM crops WHERE id=$cid")->fetch_assoc();
    if ($cur) ciDel($cur['thumbnail'] ?? '');
    $conn->query("DELETE FROM crop_images WHERE crop_id=$cid");
    $conn->query("DELETE FROM crop_sections WHERE crop_id=$cid");
    $conn->query("DELETE FROM crops WHERE id=$cid");
    header("Location: crop-info.php?msg=deleted");
    exit;

} elseif ($action === 'save_videos') {
    $cid = (int)$_POST['crop_id'];
    // Helper: extract 11-char YouTube ID from URL or raw ID
    function getYoutubeId($url) {
        $url = trim($url);
        if (!$url) return '';
        // youtu.be/ID
        if (preg_match('~youtu\.be/([A-Za-z0-9_-]{11})~', $url, $m)) return $m[1];
        // ?v=ID or &v=ID
        if (preg_match('~[?&]v=([A-Za-z0-9_-]{11})~', $url, $m)) return $m[1];
        // embed/ID
        if (preg_match('~/embed/([A-Za-z0-9_-]{11})~', $url, $m)) return $m[1];
        // Raw 11-char ID
        if (preg_match('~^[A-Za-z0-9_-]{11}$~', $url)) return $url;
        return '';
    }
    $v1 = $conn->real_escape_string(getYoutubeId($_POST['video_1'] ?? ''));
    $v2 = $conn->real_escape_string(getYoutubeId($_POST['video_2'] ?? ''));
    $v3 = $conn->real_escape_string(getYoutubeId($_POST['video_3'] ?? ''));
    $v4 = $conn->real_escape_string(getYoutubeId($_POST['video_4'] ?? ''));
    $conn->query("UPDATE crops SET video_1='$v1', video_2='$v2', video_3='$v3', video_4='$v4' WHERE id=$cid");
    header("Location: crop-info.php?view=edit&id=$cid&msg=videos_saved&tab=videos");
    exit;
}

$view = $_GET['view'] ?? '';
$id   = (int)($_GET['id'] ?? 0);
$msg  = $_GET['msg'] ?? '';
$tab  = $_GET['tab'] ?? 'basic';

$crop = null;
$images = [];
$secEn = [];
$secUr = [];
if ($view === 'edit' && $id) {
    $crop   = $conn->query("SELECT * FROM crops WHERE id=$id")->fetch_assoc();
    if (!$crop) { header("Location: crop-info.php"); exit; }
    $images = $conn->query("SELECT * FROM crop_images WHERE crop_id=$id ORDER BY sort_order")->fetch_all(MYSQLI_ASSOC);
    $secEn  = $conn->query("SELECT * FROM crop_sections WHERE crop_id=$id AND lang='en' ORDER BY sort_order")->fetch_all(MYSQLI_ASSOC);
    $secUr  = $conn->query("SELECT * FROM crop_sections WHERE crop_id=$id AND lang='ur' ORDER BY sort_order")->fetch_all(MYSQLI_ASSOC);
}

$allCrops = $conn->query("SELECT * FROM crops ORDER BY sort_order, name_en")->fetch_all(MYSQLI_ASSOC);

$msgMap = [
    'created'       => 'Crop created successfully.',
    'saved'         => 'Basic info saved.',
    'img_added'     => 'Image uploaded.',
    'img_deleted'   => 'Image deleted.',
    'sections_saved'=> 'Sections saved.',
    'videos_saved'  => 'YouTube videos saved.',
    'deleted'       => 'Crop deleted.',
    'slug_taken'    => 'Slug already taken — choose a different one.',
];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Crop Info</title>
<?php include __DIR__ . '/partials/head-styles.php'; ?>
<style>
.img-grid{display:flex;flex-wrap:wrap;gap:12px;margin-top:10px}
.img-card{position:relative;border:1px solid #c8e6c9;border-radius:8px;overflow:hidden;width:140px}
.img-card img{width:140px;height:100px;object-fit:cover;display:block}
.img-card .cap{font-size:.75rem;padding:4px 6px;color:#555;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.img-card .del-btn{position:absolute;top:4px;right:4px;background:rgba(198,40,40,.85);color:#fff;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:.9rem;line-height:24px;text-align:center;padding:0}
.sec-block{background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;padding:14px;margin-bottom:12px;position:relative}
.sec-block .rm-sec{position:absolute;top:10px;right:10px;background:#c62828;color:#fff;border:none;border-radius:4px;padding:3px 9px;cursor:pointer;font-size:.8rem}
.tab-strip{display:flex;gap:0;border-bottom:2px solid #4caf50;margin-bottom:16px}
.tab-strip button{padding:8px 20px;border:none;background:none;cursor:pointer;font-size:.9rem;color:#555;border-radius:6px 6px 0 0;transition:background .15s}
.tab-strip button.active{background:#4caf50;color:#fff;font-weight:600}
.tab-pane{display:none}.tab-pane.show{display:block}
.crop-list-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;margin-top:10px}
.crop-card{border:1px solid #c8e6c9;border-radius:10px;overflow:hidden;background:#fff;box-shadow:0 1px 4px rgba(0,0,0,.07)}
.crop-card img{width:100%;height:130px;object-fit:cover;background:#e8f5e9}
.crop-card .cc-body{padding:12px}
.crop-card .cc-name{font-weight:600;font-size:1rem;color:#043915}
.crop-card .cc-slug{font-size:.78rem;color:#888;margin-bottom:10px}
.crop-card .cc-actions{display:flex;gap:8px}
</style>
</head><body>
<div class="layout">
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<main class="content">

<?php if ($view === 'new'): ?>
<!-- ====== NEW CROP PAGE ====== -->
<div class="page-header">
  <h1>Add New Crop</h1>
  <a href="crop-info.php" class="btn btn-outline">← Back</a>
</div>
<?php if ($msg === 'slug_taken'): ?>
<div class="alert alert-error">⚠ That slug is already taken. Choose a different one.</div>
<?php endif; ?>
<div class="card">
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="create">
    <div class="form-grid">
      <div class="form-group">
        <label>Crop Name (English) *</label>
        <input type="text" name="name_en" required placeholder="e.g. Wheat">
      </div>
      <div class="form-group">
        <label>Crop Name (اردو)</label>
        <input type="text" name="name_ur" dir="rtl" placeholder="e.g. گندم">
      </div>
      <div class="form-group">
        <label>Slug (URL key) *</label>
        <input type="text" name="slug" required placeholder="e.g. wheat" id="slugInput">
        <small style="color:#777">Lowercase letters, numbers, hyphens only</small>
      </div>
      <div class="form-group">
        <label>Sort Order</label>
        <input type="number" name="sort_order" value="0">
      </div>
    </div>
    <div class="form-group" style="margin-top:12px">
      <label>Thumbnail Image</label>
      <input type="file" name="thumbnail" accept="image/*">
    </div>
    <div class="btn-group" style="margin-top:16px">
      <button type="submit" class="btn btn-primary">Create Crop →</button>
      <a href="crop-info.php" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
<script>
document.querySelector('input[name="name_en"]').addEventListener('input', function(){
  const s = document.getElementById('slugInput');
  if (!s.dataset.manual) s.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
});
document.getElementById('slugInput').addEventListener('input', function(){ this.dataset.manual = '1'; });
</script>

<?php elseif ($view === 'edit' && $crop): ?>
<!-- ====== EDIT CROP PAGE ====== -->
<div class="page-header">
  <h1>Edit: <?= htmlspecialchars($crop['name_en']) ?></h1>
  <a href="crop-info.php" class="btn btn-outline">← All Crops</a>
</div>
<?php if ($msg && isset($msgMap[$msg])): ?>
<div class="alert alert-success">✔ <?= $msgMap[$msg] ?></div>
<?php endif; ?>

<div class="tab-strip">
  <button class="<?= $tab==='basic'?'active':'' ?>" onclick="showTab('basic')">Basic Info</button>
  <button class="<?= $tab==='images'?'active':'' ?>" onclick="showTab('images')">Images (<?= count($images) ?>)</button>
  <button class="<?= $tab==='en'?'active':'' ?>" onclick="showTab('en')">Sections EN (<?= count($secEn) ?>)</button>
  <button class="<?= $tab==='ur'?'active':'' ?>" onclick="showTab('ur')">Sections UR (<?= count($secUr) ?>)</button>
  <button class="<?= $tab==='videos'?'active':'' ?>" onclick="showTab('videos')">📹 Videos</button>
</div>

<!-- TAB: Basic Info -->
<div id="tab-basic" class="tab-pane <?= $tab==='basic'?'show':'' ?>">
<div class="card">
  <h2>Basic Information</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="update_basic">
    <input type="hidden" name="crop_id" value="<?= $crop['id'] ?>">
    <div class="form-grid">
      <div class="form-group">
        <label>Crop Name (English) *</label>
        <input type="text" name="name_en" value="<?= htmlspecialchars($crop['name_en']) ?>" required>
      </div>
      <div class="form-group">
        <label>Crop Name (اردو)</label>
        <input type="text" name="name_ur" dir="rtl" value="<?= htmlspecialchars($crop['name_ur']) ?>">
      </div>
      <div class="form-group">
        <label>Slug</label>
        <input type="text" name="slug" value="<?= htmlspecialchars($crop['slug']) ?>" required>
        <small style="color:#777">Used in URLs and links</small>
      </div>
      <div class="form-group">
        <label>Sort Order</label>
        <input type="number" name="sort_order" value="<?= (int)$crop['sort_order'] ?>">
      </div>
    </div>
    <div class="form-group" style="margin-top:12px">
      <label>Thumbnail</label>
      <?php if ($crop['thumbnail']): ?>
        <img src="<?= htmlspecialchars(imgUrl($crop['thumbnail'])) ?>" class="img-preview" style="max-width:160px;max-height:110px;border-radius:6px;border:1px solid #c8e6c9;display:block;margin-bottom:6px">
        <small style="color:#666">Upload new to replace</small>
      <?php endif; ?>
      <input type="file" name="thumbnail" accept="image/*" style="margin-top:6px">
    </div>
    <div class="btn-group" style="margin-top:14px">
      <button type="submit" class="btn btn-primary">💾 Save Basic Info</button>
    </div>
  </form>
</div>
<div class="card" style="border-color:#ffcdd2">
  <h2 style="color:#c62828">Delete Crop</h2>
  <p style="color:#555;font-size:.9rem">This permanently deletes the crop, all its images, and all its sections.</p>
  <form method="POST" onsubmit="return confirm('Delete this crop and ALL its data? This cannot be undone.')">
    <input type="hidden" name="_action" value="delete_crop">
    <input type="hidden" name="crop_id" value="<?= $crop['id'] ?>">
    <button type="submit" class="btn btn-danger">🗑 Delete Crop</button>
  </form>
</div>
</div>

<!-- TAB: Images -->
<div id="tab-images" class="tab-pane <?= $tab==='images'?'show':'' ?>">
<div class="card">
  <h2>Image Gallery</h2>
  <div class="img-grid">
    <?php foreach ($images as $img): ?>
    <div class="img-card">
      <img src="<?= htmlspecialchars(imgUrl($img['image_path'])) ?>" alt="">
      <div class="cap">EN: <?= htmlspecialchars($img['caption'] ?: '—') ?></div>
      <div class="cap" dir="rtl" style="text-align:right;color:#1a5276">UR: <?= htmlspecialchars($img['caption_ur'] ?: '—') ?></div>
      <form method="POST" style="display:inline" onsubmit="return confirm('Delete this image?')">
        <input type="hidden" name="_action" value="del_image">
        <input type="hidden" name="image_id" value="<?= $img['id'] ?>">
        <input type="hidden" name="crop_id" value="<?= $crop['id'] ?>">
        <button class="del-btn" title="Delete">✕</button>
      </form>
    </div>
    <?php endforeach; ?>
  </div>
  <?php if (empty($images)): ?><p style="color:#888;margin-top:10px">No images yet.</p><?php endif; ?>
</div>
<div class="card">
  <h2>Upload Images</h2>
  <form method="POST" enctype="multipart/form-data" id="uploadForm">
    <input type="hidden" name="_action" value="add_image">
    <input type="hidden" name="crop_id" value="<?= $crop['id'] ?>">
    <div class="form-group" style="margin-bottom:12px">
      <label>Select Images <span style="color:#888;font-size:.8rem;font-weight:400">(hold Ctrl / Cmd to pick multiple)</span></label>
      <div id="dropZone" style="border:2px dashed #a5d6a7;border-radius:10px;padding:28px 20px;text-align:center;cursor:pointer;transition:background .2s;background:#f9fdf9">
        <div style="font-size:2rem;margin-bottom:6px">📁</div>
        <div id="dropLabel" style="color:#555;font-size:.9rem">Click to choose images or drag &amp; drop here</div>
        <div id="fileCount" style="margin-top:6px;font-size:.82rem;color:#4caf50;font-weight:600"></div>
      </div>
      <input type="file" name="image_file[]" id="imageFileInput" accept="image/*" multiple required
             style="display:none">
    </div>
    <div id="previewGrid" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:12px"></div>
    <div class="form-grid" style="margin-bottom:12px">
      <div class="form-group">
        <label>Caption (English) <span style="color:#888;font-size:.8rem;font-weight:400">(applied to all selected)</span></label>
        <input type="text" name="caption" placeholder="e.g. Wheat harvesting">
      </div>
      <div class="form-group">
        <label>Caption (اردو) <span style="color:#888;font-size:.8rem;font-weight:400">(اردو عنوان)</span></label>
        <input type="text" name="caption_ur" dir="rtl" placeholder="مثلاً گندم کی کٹائی">
      </div>
      <div class="form-group">
        <label>Start Sort Order</label>
        <input type="number" name="sort_order" value="<?= count($images) ?>">
      </div>
    </div>
    <div class="btn-group">
      <button type="submit" class="btn btn-primary" id="uploadBtn">⬆ Upload</button>
    </div>
  </form>
</div>
<script>
(function(){
  const zone  = document.getElementById('dropZone');
  const input = document.getElementById('imageFileInput');
  const label = document.getElementById('dropLabel');
  const count = document.getElementById('fileCount');
  const prev  = document.getElementById('previewGrid');
  const btn   = document.getElementById('uploadBtn');

  zone.addEventListener('click', () => input.click());
  zone.addEventListener('dragover', e => { e.preventDefault(); zone.style.background = '#e8f5e9'; });
  zone.addEventListener('dragleave', () => { zone.style.background = '#f9fdf9'; });
  zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.style.background = '#f9fdf9';
    const dt = new DataTransfer();
    Array.from(e.dataTransfer.files).forEach(f => { if (f.type.startsWith('image/')) dt.items.add(f); });
    input.files = dt.files;
    updatePreview();
  });
  input.addEventListener('change', updatePreview);

  function updatePreview() {
    const files = Array.from(input.files);
    count.textContent = files.length ? files.length + ' image' + (files.length > 1 ? 's' : '') + ' selected' : '';
    btn.textContent = files.length > 1 ? '⬆ Upload ' + files.length + ' Images' : '⬆ Upload';
    prev.innerHTML = '';
    files.forEach(f => {
      const url = URL.createObjectURL(f);
      const div = document.createElement('div');
      div.style.cssText = 'position:relative;width:80px;height:80px;border-radius:6px;overflow:hidden;border:1px solid #c8e6c9';
      div.innerHTML = `<img src="${url}" style="width:100%;height:100%;object-fit:cover">
        <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,.45);color:#fff;font-size:.6rem;padding:2px 4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${f.name}</div>`;
      prev.appendChild(div);
    });
  }
})();
</script>
</div>

<!-- TAB: English Sections -->
<div id="tab-en" class="tab-pane <?= $tab==='en'?'show':'' ?>">
<div class="card">
  <h2>🇬🇧 English Sections</h2>
  <form method="POST" id="form-en">
    <input type="hidden" name="_action" value="save_sections">
    <input type="hidden" name="crop_id" value="<?= $crop['id'] ?>">
    <input type="hidden" name="lang" value="en">
    <div id="secs-en">
      <?php foreach ($secEn as $i => $s): ?>
      <div class="sec-block">
        <button type="button" class="rm-sec" onclick="rmSec(this)">Remove</button>
        <div class="form-group">
          <label>Section Heading</label>
          <input type="text" name="heading[]" value="<?= htmlspecialchars($s['heading']) ?>" placeholder="e.g. Soil Requirements">
        </div>
        <div class="form-group" style="margin-top:8px">
          <label>Content</label>
          <textarea name="content[]" style="min-height:120px"><?= htmlspecialchars($s['content']) ?></textarea>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="btn-group" style="margin-top:12px">
      <button type="button" class="btn btn-outline" onclick="addSec('secs-en')">+ Add Section</button>
      <button type="submit" class="btn btn-primary">💾 Save English Sections</button>
    </div>
  </form>
</div>
</div>

<!-- TAB: Urdu Sections -->
<div id="tab-ur" class="tab-pane <?= $tab==='ur'?'show':'' ?>">
<div class="card">
  <h2>🇵🇰 Urdu Sections</h2>
  <form method="POST" id="form-ur">
    <input type="hidden" name="_action" value="save_sections">
    <input type="hidden" name="crop_id" value="<?= $crop['id'] ?>">
    <input type="hidden" name="lang" value="ur">
    <div id="secs-ur">
      <?php foreach ($secUr as $i => $s): ?>
      <div class="sec-block">
        <button type="button" class="rm-sec" onclick="rmSec(this)">Remove</button>
        <div class="form-group">
          <label>سیکشن کا عنوان</label>
          <input type="text" name="heading[]" dir="rtl" value="<?= htmlspecialchars($s['heading']) ?>" placeholder="مثلاً مٹی کی ضروریات">
        </div>
        <div class="form-group" style="margin-top:8px">
          <label>مواد</label>
          <textarea name="content[]" dir="rtl" style="min-height:120px;text-align:right"><?= htmlspecialchars($s['content']) ?></textarea>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="btn-group" style="margin-top:12px">
      <button type="button" class="btn btn-outline" onclick="addSec('secs-ur','ur')">+ Add Section</button>
      <button type="submit" class="btn btn-primary">💾 Save Urdu Sections</button>
    </div>
  </form>
</div>
</div>

<!-- TAB: Videos -->
<div id="tab-videos" class="tab-pane <?= $tab==='videos'?'show':'' ?>">
<div class="card">
  <h2>📹 YouTube Videos</h2>
  <p style="color:#666;font-size:.88rem;margin-bottom:16px">Paste full YouTube URLs or just the 11-character video IDs. Up to 4 videos per crop.</p>
  <form method="POST">
    <input type="hidden" name="_action" value="save_videos">
    <input type="hidden" name="crop_id" value="<?= $crop['id'] ?>">
    <?php
    $vidLabels = ['Video 1','Video 2','Video 3','Video 4'];
    $vidFields = ['video_1','video_2','video_3','video_4'];
    foreach ($vidFields as $i => $field):
        $val = htmlspecialchars($crop[$field] ?? '');
        $youtubePreview = $val ? 'https://img.youtube.com/vi/' . $val . '/mqdefault.jpg' : '';
    ?>
    <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:18px;padding:14px;background:#f9fdf9;border:1px solid #c8e6c9;border-radius:8px">
      <?php if ($youtubePreview): ?>
      <a href="https://youtu.be/<?= $val ?>" target="_blank" style="flex-shrink:0">
        <img src="<?= $youtubePreview ?>" alt="thumbnail" style="width:120px;height:68px;object-fit:cover;border-radius:6px;border:1px solid #ccc">
      </a>
      <?php else: ?>
      <div style="width:120px;height:68px;background:#e8f5e9;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#a5d6a7;font-size:1.8rem;flex-shrink:0">▶</div>
      <?php endif; ?>
      <div style="flex:1">
        <label style="font-weight:600;font-size:.9rem;color:#333"><?= $vidLabels[$i] ?></label>
        <input type="text" name="<?= $field ?>" value="<?= $val ?>"
               placeholder="e.g. https://youtu.be/NbR-b39dtnY  or  NbR-b39dtnY"
               style="margin-top:6px;width:100%;padding:8px 10px;border:1px solid #c8e6c9;border-radius:6px;font-size:.9rem">
        <?php if ($val): ?>
        <small style="color:#4caf50">✔ ID: <code><?= $val ?></code></small>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
    <div class="btn-group" style="margin-top:8px">
      <button type="submit" class="btn btn-primary">💾 Save Videos</button>
    </div>
  </form>
</div>
</div>

<script>
function showTab(t) {
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('show'));
  document.querySelectorAll('.tab-strip button').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + t).classList.add('show');
  event.currentTarget.classList.add('active');
}
function addSec(containerId, dir) {
  const isUr = dir === 'ur';
  const d = document.createElement('div');
  d.className = 'sec-block';
  d.innerHTML = `<button type="button" class="rm-sec" onclick="rmSec(this)">Remove</button>
    <div class="form-group">
      <label>${isUr ? 'سیکشن کا عنوان' : 'Section Heading'}</label>
      <input type="text" name="heading[]" ${isUr ? 'dir="rtl"' : ''} placeholder="${isUr ? 'مثلاً مٹی کی ضروریات' : 'e.g. Soil Requirements'}">
    </div>
    <div class="form-group" style="margin-top:8px">
      <label>${isUr ? 'مواد' : 'Content'}</label>
      <textarea name="content[]" style="min-height:120px${isUr ? ';text-align:right' : ''}" ${isUr ? 'dir="rtl"' : ''}></textarea>
    </div>`;
  document.getElementById(containerId).appendChild(d);
}
function rmSec(btn) {
  if (confirm('Remove this section?')) btn.closest('.sec-block').remove();
}
</script>

<?php else: ?>
<!-- ====== CROP LIST PAGE ====== -->
<div class="page-header">
  <h1>Crop Info</h1>
  <a href="crop-info.php?view=new" class="btn btn-primary">+ Add New Crop</a>
</div>
<?php if ($msg && isset($msgMap[$msg])): ?>
<div class="alert alert-success">✔ <?= $msgMap[$msg] ?></div>
<?php endif; ?>

<div class="crop-list-grid">
  <?php foreach ($allCrops as $c): ?>
  <div class="crop-card">
    <?php if ($c['thumbnail']): ?>
    <img src="<?= htmlspecialchars(imgUrl($c['thumbnail'])) ?>" alt="">
    <?php else: ?>
    <div style="width:100%;height:130px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;color:#a5d6a7;font-size:2.5rem">🌱</div>
    <?php endif; ?>
    <div class="cc-body">
      <div class="cc-name"><?= htmlspecialchars($c['name_en']) ?></div>
      <div class="cc-slug">/<?= htmlspecialchars($c['slug']) ?></div>
      <div class="cc-actions">
        <a href="crop-info.php?view=edit&id=<?= $c['id'] ?>" class="btn btn-outline btn-sm">Edit</a>
        <form method="POST" style="display:inline" onsubmit="return confirm('Delete <?= htmlspecialchars($c['name_en']) ?>?')">
          <input type="hidden" name="_action" value="delete_crop">
          <input type="hidden" name="crop_id" value="<?= $c['id'] ?>">
          <button class="btn btn-danger btn-sm">Delete</button>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <?php if (empty($allCrops)): ?>
  <div style="grid-column:1/-1;text-align:center;padding:40px;color:#888">
    <div style="font-size:3rem;margin-bottom:10px">🌱</div>
    <p>No crops yet. <a href="crop-info.php?view=new">Add the first one →</a></p>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>

</main></div></body></html>
