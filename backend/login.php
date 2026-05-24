<?php
require_once __DIR__ . '/conn.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['admin'])) {
    header('Location: admin/index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';
    $res = $conn->query("SELECT password_hash FROM admin_users WHERE username='$username' LIMIT 1");
    $row = $res->fetch_assoc();
    if ($row && password_verify($password, $row['password_hash'])) {
        $_SESSION['admin'] = true;
        $_SESSION['admin_user'] = $username;
        header('Location: admin/index.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FarmEase Admin — Sign In</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Poppins', sans-serif; min-height: 100vh; display: flex; }

/* ── Left branding panel ── */
.brand {
  width: 44%;
  background: linear-gradient(160deg, #021f0a 0%, #043915 40%, #1b5e20 75%, #2e7d32 100%);
  padding: 52px 48px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: #fff;
  position: relative;
  overflow: hidden;
}
.brand::before {
  content: '';
  position: absolute;
  bottom: -80px;
  right: -80px;
  width: 320px;
  height: 320px;
  border-radius: 50%;
  background: rgba(255,255,255,.04);
}
.brand::after {
  content: '';
  position: absolute;
  top: -50px;
  left: -50px;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background: rgba(255,255,255,.03);
}
.brand-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1.5rem;
  font-weight: 800;
  margin-bottom: 40px;
  letter-spacing: .5px;
}
.brand-logo i { color: #69f0ae; font-size: 1.8rem; }
.brand h2 { font-size: 2rem; font-weight: 700; margin-bottom: 10px; }
.brand p { color: #a5d6a7; font-size: .92rem; line-height: 1.6; margin-bottom: 36px; }
.feature-list { list-style: none; display: flex; flex-direction: column; gap: 14px; }
.feature-list li {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: .88rem;
  color: #c8e6c9;
}
.feature-list li i { color: #69f0ae; width: 16px; text-align: center; }

/* ── Right form panel ── */
.form-side {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f9fbf9;
  padding: 40px 24px;
}
.form-box { width: 100%; max-width: 400px; }

.form-box h1 {
  font-size: 1.75rem;
  font-weight: 700;
  color: #043915;
  margin-bottom: 6px;
}
.form-box .sub {
  color: #777;
  font-size: .88rem;
  margin-bottom: 32px;
}

.error-box {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #ffebee;
  color: #c62828;
  border: 1px solid #ef9a9a;
  border-radius: 8px;
  padding: 11px 14px;
  font-size: .85rem;
  margin-bottom: 20px;
}

.field { margin-bottom: 18px; }
.field label {
  display: block;
  font-size: .78rem;
  font-weight: 600;
  color: #444;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: .5px;
}
.input-wrap { position: relative; }
.input-wrap i {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #aaa;
  font-size: .85rem;
  pointer-events: none;
}
.input-wrap input {
  width: 100%;
  padding: 11px 14px 11px 40px;
  border: 1.5px solid #d4ebd4;
  border-radius: 8px;
  font-size: .92rem;
  font-family: 'Poppins', sans-serif;
  background: #fff;
  outline: none;
  transition: border-color .2s, box-shadow .2s;
}
.input-wrap input:focus {
  border-color: #4CAF50;
  box-shadow: 0 0 0 3px rgba(76,175,80,.12);
}

.btn-login {
  width: 100%;
  padding: 13px;
  background: #043915;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: .95rem;
  font-weight: 700;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  margin-top: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition: background .2s, transform .15s;
  letter-spacing: .3px;
}
.btn-login:hover { background: #1b5e20; transform: translateY(-1px); }

.login-footer {
  text-align: center;
  margin-top: 28px;
  font-size: .72rem;
  color: #bbb;
}

@media (max-width: 700px) {
  .brand { display: none; }
  .form-side { background: linear-gradient(135deg, #043915, #2e7d32); }
  .form-box {
    background: #fff;
    padding: 36px 28px;
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,.25);
  }
}
</style>
</head>
<body>

<div class="brand">
  <div class="brand-logo">
        <img src="../frontend/assets/about-bottom-img.png" alt="FarmEase" width="32" height="32" style="object-fit:contain">
   
    <!-- <i class="fa-solid fa-leaf"></i> -->
    FarmEase
  </div>
  <h2>Admin Portal</h2>
  <p>Manage your agricultural platform — crop guides, bilingual content, cost data and more.</p>
  <ul class="feature-list">
    <li><i class="fa-solid fa-circle-check"></i> Edit crop guides &amp; detailed sections</li>
    <li><i class="fa-solid fa-circle-check"></i> Upload section images</li>
    <li><i class="fa-solid fa-circle-check"></i> Update English &amp; Urdu content</li>
    <li><i class="fa-solid fa-circle-check"></i> Manage AgriCost &amp; profit data</li>
    <li><i class="fa-solid fa-circle-check"></i> Changes reflect on site instantly</li>
  </ul>
</div>

<div class="form-side">
  <div class="form-box">
    <h1>Sign In</h1>
    <p class="sub">Enter your admin credentials to continue</p>

    <?php if ($error): ?>
    <div class="error-box">
      <i class="fa-solid fa-circle-exclamation"></i>
      <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="field">
        <label>Username</label>
        <div class="input-wrap">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="username" placeholder="admin"
                 value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                 required autofocus autocomplete="username">
        </div>
      </div>
      <div class="field">
        <label>Password</label>
        <div class="input-wrap">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" placeholder="••••••••"
                 required autocomplete="current-password">
        </div>
      </div>
      <button type="submit" class="btn-login">
        <i class="fa-solid fa-right-to-bracket"></i>
        Sign In to Admin Panel
      </button>
    </form>

    <p class="login-footer">FarmEase Admin Panel &copy; <?= date('Y') ?> &mdash; Authorized Access Only</p>
  </div>
</div>

</body>
</html>
