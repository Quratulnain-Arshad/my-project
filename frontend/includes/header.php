<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'FarmEase') ?></title>
    <?php if (!empty($css)): ?>
    <link rel="stylesheet" href="<?= $css ?>">
    <?php endif; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    .site-nav{background:#043915;display:flex;align-items:center;justify-content:space-between;padding:0 24px;height:58px;position:sticky;top:0;z-index:999;box-shadow:0 2px 8px rgba(0,0,0,0.25)}
    .nav-brand{color:#fff;text-decoration:none;font-weight:700;font-size:1.05rem;display:flex;align-items:center;gap:8px;font-family:'Poppins',sans-serif}
    .nav-links{list-style:none;margin:0;padding:0;display:flex;gap:4px}
    .nav-links a{color:#c8e6c9;text-decoration:none;padding:7px 14px;border-radius:6px;font-size:.88rem;font-family:'Poppins',sans-serif;transition:background .2s,color .2s}
    .nav-links a:hover,.nav-links a.active{background:rgba(255,255,255,.15);color:#fff}
    @media(max-width:600px){.nav-links a{padding:6px 9px;font-size:.8rem}}
    </style>
</head>
<body>
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="site-nav">
  <a href="index.php" class="nav-brand">
    <img src="assets/about-bottom-img.png" alt="FarmEase" width="32" height="32" style="object-fit:contain">
    FarmEase
  </a>
  <ul class="nav-links">
    <li><a href="index.php" <?= $currentPage==='index.php'?'class="active"':'' ?>>Home</a></li>
    <li><a href="crop-info.php" <?= $currentPage==='crop-info.php'?'class="active"':'' ?>>Crop Info</a></li>
    <li><a href="agri-cost.php" <?= $currentPage==='agri-cost.php'?'class="active"':'' ?>>AgriCost</a></li>
    <li><a href="contact.php" <?= $currentPage==='contact.php'?'class="active"':'' ?>>Contact</a></li>
  </ul>
</nav>
