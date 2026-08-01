<?php
// setup.php - Run once to create tables and seed data
// Access: http://localhost/FYP-G1/backend/setup.php

// Connect without selecting a DB so we can create it if needed
$conn = @new mysqli("localhost", "root", "");
if ($conn->connect_error) {
    die("Cannot connect to MySQL: " . $conn->connect_error);
}
$conn->query("CREATE DATABASE IF NOT EXISTS `farmease` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db("farmease");
$conn->set_charset("utf8mb4");

$errors = [];
$success = [];

// ─────────────────────────────────────────────
// Helper
// ─────────────────────────────────────────────
function run($conn, $sql, &$errors, &$success, $label) {
    if ($conn->query($sql)) {
        $success[] = "OK: $label";
    } else {
        $errors[] = "FAIL ($label): " . $conn->error;
    }
}

// Map old-code filenames to standard hyphenated assets/ folder paths
function mapAssetPath($originalPath) {
    if (!$originalPath) return '';
    if (str_starts_with($originalPath, 'http')) return $originalPath;
    
    $filename = basename($originalPath);
    
    // Explicit mapping to match frontend/assets/ files exactly
    $map = [
        'maizeintro.jpg'       => 'maize-intro.jpg',
        'maizesoil.jpg'        => 'maize-soil.jpg',
        'maizesowing.jpg'      => 'maize-sowing.jpg',
        'maizefertilizer.jpg'  => 'maize-fertilizer.jpg',
        'maizepest.jpg'        => 'maize-pest.jpg',
        'maizeharvesting.jpg'  => 'maize-harvesting.jpg',
        
        'riceintro.jpeg'       => 'rice-intro.jpeg',
        'ricesoil.jpeg'        => 'rice-soil.jpeg',
        'ricesowing.jpeg'      => 'rice-sowing.jpeg',
        'ricefertilizer.jpeg'  => 'rice-fertilizer.jpeg',
        'ricepests.jpeg'       => 'rice-pests.jpeg',
        'riceharvesting.jpeg'  => 'rice-harvesting.jpeg',
        
        'potatointro.jpeg'     => 'potato-intro.jpeg',
        'potatosoil.jpeg'      => 'potato-soil.jpeg',
        'potatosowing.jpg'     => 'potato-sowing.jpg',
        'potatofertilizer.jpg' => 'potato-fertilizer.jpg',
        'potatopest.jpg'       => 'potato-pest.jpg',
        'potatoharvesting.jpg' => 'potato-harvesting.jpg',
        
        'image.jpeg'           => 'image.jpeg',
        'soil.jpg'             => 'soil.jpg',
        'sowing.jpg'           => 'sowing.jpg',
        'fertilizer.jpg'       => 'fertilizer.jpg',
        'pests.jpg'            => 'pests.jpg',
        'harvesting.jpg'       => 'harvesting.jpg',
        
        'climate.jpg'          => 'climate.jpg',
    ];
    
    if (isset($map[$filename])) {
        return 'assets/' . $map[$filename];
    }
    
    // Normalization fallback
    $clean = strtolower($filename);
    foreach (['maize', 'rice', 'potato', 'wheat'] as $c) {
        if (str_starts_with($clean, $c)) {
            $rest = substr($clean, strlen($c));
            if ($rest && !str_starts_with($rest, '-')) {
                $clean = $c . '-' . $rest;
            }
            break;
        }
    }
    return 'assets/' . $clean;
}

// ─────────────────────────────────────────────
// 1. CREATE TABLES
// ─────────────────────────────────────────────

$tables = [

'admin_users' => "CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

'farm_data' => "CREATE TABLE IF NOT EXISTS `farm_data` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `lang` VARCHAR(5) NOT NULL,
  `title` VARCHAR(255),
  `subtitle` VARCHAR(255),
  `btn_crop_info` VARCHAR(255),
  `btn_calculator` VARCHAR(255),
  `btn_helpline` VARCHAR(255),
  `switch_language` VARCHAR(50),
  `about_heading` VARCHAR(255),
  `about_p1` TEXT,
  `about_p2` TEXT,
  `about_p3` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

'agri_cost' => "CREATE TABLE IF NOT EXISTS `agri_cost` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `crop_key` VARCHAR(20) NOT NULL UNIQUE,
  `name_en` VARCHAR(255),
  `name_ur` VARCHAR(255),
  `desc_en` VARCHAR(255),
  `desc_ur` VARCHAR(255),
  `details_en` TEXT,
  `details_ur` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

'crops' => "CREATE TABLE IF NOT EXISTS `crops` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `name_en` VARCHAR(200) NOT NULL,
  `name_ur` VARCHAR(200) DEFAULT '',
  `desc_en` TEXT DEFAULT NULL,
  `desc_ur` TEXT DEFAULT NULL,
  `thumbnail` VARCHAR(300) DEFAULT '',
  `video_1` VARCHAR(100) DEFAULT '',
  `video_2` VARCHAR(100) DEFAULT '',
  `video_3` VARCHAR(100) DEFAULT '',
  `video_4` VARCHAR(100) DEFAULT '',
  `sort_order` INT DEFAULT 0,
  `images` LONGTEXT NULL,
  `sections_en` LONGTEXT NULL,
  `sections_ur` LONGTEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"

];

foreach ($tables as $name => $sql) {
    run($conn, $sql, $errors, $success, "Create table $name");
}

// Ensure JSON columns exist on older crops tables
foreach (['images','sections_en','sections_ur'] as $col) {
    $chk = $conn->query("SHOW COLUMNS FROM crops LIKE '$col'");
    if ($chk && $chk->num_rows === 0) {
        run($conn, "ALTER TABLE crops ADD COLUMN `$col` LONGTEXT NULL", $errors, $success, "Add crops.$col");
    }
}

// Set up directory path to old-code JSON files (optional seed source)
$jsonDir = __DIR__ . '/../old-code/json/';

// ─────────────────────────────────────────────
// 2. SEED ADMIN USER
// ─────────────────────────────────────────────

$conn->query("DELETE FROM `admin_users` WHERE username='admin'");
$hash = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO `admin_users` (username, password_hash) VALUES (?, ?)");
$stmt->bind_param('ss', $u, $h);
$u = 'admin'; $h = $hash;
if ($stmt->execute()) {
    $success[] = "OK: Seed admin user";
} else {
    $errors[] = "FAIL (Seed admin user): " . $stmt->error;
}
$stmt->close();

// ─────────────────────────────────────────────
// 3. SEED FARM DATA (Homepage configuration)
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `farm_data`");
$farmDataFile = $jsonDir . 'farmdata.json';
if (file_exists($farmDataFile)) {
    $farmData = json_decode(file_get_contents($farmDataFile), true);
    if (isset($farmData['languages'])) {
        $stmt = $conn->prepare("INSERT INTO `farm_data`
            (lang,title,subtitle,btn_crop_info,btn_calculator,btn_helpline,switch_language,about_heading,about_p1,about_p2,about_p3)
            VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssssss', $lang,$title,$subtitle,$bci,$bcalc,$bhel,$sw,$ah,$ap1,$ap2,$ap3);
        
        foreach ($farmData['languages'] as $lang => $d) {
            $title = $d['title'] ?? '';
            $subtitle = $d['subtitle'] ?? '';
            $bci = $d['buttons']['cropInfo'] ?? '';
            $bcalc = $d['buttons']['calculator'] ?? '';
            $bhel = $d['buttons']['helpline'] ?? '';
            $sw = $d['switchLanguage'] ?? '';
            $ah = $d['about']['heading'] ?? '';
            $ap1 = $d['about']['p1'] ?? '';
            $ap2 = $d['about']['p2'] ?? '';
            $ap3 = $d['about']['p3'] ?? '';
            if ($stmt->execute()) {
                $success[] = "OK: Seed farm_data lang=$lang from farmdata.json";
            } else {
                $errors[] = "FAIL (farm_data $lang): " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        $errors[] = "FAIL: farmdata.json has invalid structure.";
    }
} else {
    $errors[] = "FAIL: farmdata.json not found in old-code.";
}

// ─────────────────────────────────────────────
// 4. SEED CROPS (single table with JSON columns)
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `crops`");

$seedCrops = [
    ['rice','Rice','چاول','A staple food crop grown in flooded fields, requiring plenty of water','ایک بنیادی غذائی فصل جو پانی سے بھری زمین میں اگائی جاتی ہے','assets/rice-intro.jpeg','Viwf1t9fPnE','7b11tw1_Cwc','jipf6SHHbgo','8dhOfYHTd3c',1],
    ['potato','Potato','آلو','A versatile tuber crop grown in well-drained soil','ایک قیمتی جڑ والی فصل جو خشک زمین میں اگائی جاتی ہے','assets/potato-intro.jpeg','U4ELFalfACQ','f7UeErCV7NU','8_TQet5wYCo','kPNFH4pqx5w',2],
    ['wheat','Wheat','گندم','A primary cereal crop grown in temperate regions','ایک اہم اناجی فصل جو معتدل علاقوں میں اگائی جاتی ہے','assets/image.jpeg','NbR-b39dtnY','6Lq-WHw0lWo','U0AHbKHYBnA','qS6BSCaUhyo',3],
    ['maize','Maize','مکئی','A popular maize grown in warm climates, used for food and animal feed','ایک مقبول فصل جو گرم علاقوں میں اگائی جاتی ہے اور خوراک کے لیے استعمال ہوتی ہے','assets/maize-intro.jpg','Ar0OQZ-eVy0','XNmATrP8b9Q','Xu8DMz8LBx0','5KQDwCdKytY',4],
];

$stmtCrops = $conn->prepare("INSERT INTO `crops`
  (slug,name_en,name_ur,desc_en,desc_ur,thumbnail,video_1,video_2,video_3,video_4,sort_order,images,sections_en,sections_ur)
  VALUES (?,?,?,?,?,?,?,?,?,?,?,'[]','[]','[]')");
$stmtCrops->bind_param('ssssssssssi', $slug,$name_en,$name_ur,$desc_en,$desc_ur,$thumbnail,$v1,$v2,$v3,$v4,$sort_order);

foreach ($seedCrops as $row) {
    [$slug,$name_en,$name_ur,$desc_en,$desc_ur,$thumbnail,$v1,$v2,$v3,$v4,$sort_order] = $row;
    if ($stmtCrops->execute()) {
        $success[] = "OK: Seed crop $slug";
    } else {
        $errors[] = "FAIL (crop $slug): " . $stmtCrops->error;
    }
}
$stmtCrops->close();
$success[] = "NOTE: For full gallery/sections data, import farmease.sql then run docs/migrate_crops_single_table.php";

// ─────────────────────────────────────────────
// 5. SEED AGRI COST
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `agri_cost`");
$agriFile = $jsonDir . 'agri.json';
if (file_exists($agriFile)) {
    $agriData = json_decode(file_get_contents($agriFile), true);
    if (is_array($agriData)) {
        $stmt = $conn->prepare("INSERT INTO `agri_cost` (crop_key,name_en,name_ur,desc_en,desc_ur,details_en,details_ur) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssss', $ck,$ne,$nu,$de,$du,$den,$dur);
        
        foreach ($agriData as $ck => $d) {
            $ne = str_replace(['<b>', '</b>'], '', $d['name_en'] ?? '');
            $nu = str_replace(['<b>', '</b>'], '', $d['name_ur'] ?? '');
            $de = str_replace(['<b>', '</b>'], '', $d['desc_en'] ?? '');
            $du = str_replace(['<b>', '</b>'], '', $d['desc_ur'] ?? '');
            $den = $d['details_en'] ?? '';
            $dur = $d['details_ur'] ?? '';
            
            if ($stmt->execute()) {
                $success[] = "OK: Seed agri_cost $ck from agri.json";
            } else {
                $errors[] = "FAIL (agri_cost $ck): " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        $errors[] = "FAIL: agri.json has invalid structure.";
    }
} else {
    $errors[] = "INFO: agri.json not found — seed AgriCost from farmease.sql if needed.";
}

// ─────────────────────────────────────────────
// OUTPUT RESULTS
// ─────────────────────────────────────────────
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>FarmEase Setup</title>
<style>
  body { font-family: monospace; background: #f0f4f0; padding: 20px; }
  h1   { color: #043915; }
  .ok  { color: #2e7d32; }
  .err { color: #c62828; font-weight: bold; }
  .box { background: #fff; border: 1px solid #c8e6c9; border-radius: 6px; padding: 20px; max-width: 800px; }
  .summary { margin-top: 16px; font-size: 1.1em; }
</style>
</head>
<body>
<div class="box">
  <h1>FarmEase Database Setup (Hyphenated Assets Synced)</h1>
  <?php foreach ($success as $msg): ?>
    <div class="ok">&#10003; <?= htmlspecialchars($msg) ?></div>
  <?php endforeach; ?>
  <?php foreach ($errors as $msg): ?>
    <div class="err">&#10007; <?= htmlspecialchars($msg) ?></div>
  <?php endforeach; ?>
  <div class="summary">
    <?php if (empty($errors)): ?>
      <strong style="color:#043915">All done! <?= count($success) ?> operations completed successfully.</strong><br>
      <a href="login.php" style="color:#4CAF50">Go to Admin Login &rarr;</a>
    <?php else: ?>
      <strong style="color:#c62828"><?= count($errors) ?> error(s) occurred. Check the output above.</strong>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
