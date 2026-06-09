<?php $cur = basename($_SERVER['PHP_SELF']); ?>
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-wrap">
      <i class="fa-solid fa-leaf"></i>
      FarmEase
    </div>
    <p>Admin Panel</p>
  </div>

  <div class="sidebar-section-label">Main</div>
  <nav>
    <a href="index.php" class="<?= $cur==='index.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>

    <div class="sidebar-section-label" style="padding-top:10px">Content</div>
    <a href="home-content.php" class="<?= $cur==='home-content.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-house"></i> Home Content
    </a>
    <a href="crop-info.php" class="<?= $cur==='crop-info.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-seedling"></i> Crop Info
    </a>
    <a href="agri-cost.php" class="<?= $cur==='agri-cost.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-coins"></i> AgriCost Data
    </a>

  </nav>

  <div class="sidebar-footer">
    <a href="../logout.php">
      <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
  </div>
</aside>

<!-- Fixed top bar (injected globally — no need to touch individual pages) -->
<div class="admin-topbar">
  <div class="topbar-user">
    <i class="fa-solid fa-circle-user"></i>
    <?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?>
  </div>
  <a href="../../frontend/index.php" target="_blank" class="topbar-btn topbar-btn-view">
    <i class="fa-solid fa-eye"></i> View Site
  </a>
  <a href="../logout.php" class="topbar-btn topbar-btn-logout">
    <i class="fa-solid fa-right-from-bracket"></i> Logout
  </a>
</div>
