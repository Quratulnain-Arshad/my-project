<?php
$slug = preg_replace('/[^a-z0-9_-]/', '', strtolower($_GET['slug'] ?? ''));
$title = ($slug ? ucfirst($slug) . ' — ' : '') . 'FarmEase';
$css = 'css/crop.css';
include 'includes/header.php';
?>

<div class="crop-hero">
  <button id="langToggle" class="lang-btn">اردو</button>
  <h1 id="cropTitle">Loading…</h1>
</div>

<div class="main-wrap">
  <div id="cropContent"></div>
</div>

<?php include 'includes/footer.php'; ?>
<script>window._cropSlug = <?= json_encode($slug) ?>;</script>
<script src="js/crop.js"></script>
</body>
</html>
