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

'crop_info' => "CREATE TABLE IF NOT EXISTS `crop_info` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `lang` VARCHAR(5) NOT NULL,
  `name` VARCHAR(100),
  `description` TEXT,
  `image_url` TEXT,
  `link_page` VARCHAR(100),
  `sort_order` INT DEFAULT 0
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

'crop_guides' => "CREATE TABLE IF NOT EXISTS `crop_guides` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `crop` VARCHAR(20) NOT NULL,
  `lang` VARCHAR(5) NOT NULL,
  `title` VARCHAR(255),
  `section_intro` VARCHAR(255),
  `section_climate` VARCHAR(255),
  `section_soil` VARCHAR(255),
  `section_sowing` VARCHAR(255),
  `section_fertilizer` VARCHAR(255),
  `section_pests` VARCHAR(255),
  `section_harvest` VARCHAR(255),
  `img_intro` VARCHAR(255),
  `img_climate` VARCHAR(255),
  `img_soil` VARCHAR(255),
  `img_sowing` VARCHAR(255),
  `img_fertilizer` VARCHAR(255),
  `img_pests` VARCHAR(255),
  `img_harvest` VARCHAR(255),
  `lang_btn` VARCHAR(50),
  `next_btn` VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

'crop_details' => "CREATE TABLE IF NOT EXISTS `crop_details` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `crop` VARCHAR(20) NOT NULL,
  `lang` VARCHAR(20) NOT NULL,
  `title` VARCHAR(255),
  `section_order` INT DEFAULT 0,
  `heading` VARCHAR(255),
  `content` LONGTEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

'crops' => "CREATE TABLE IF NOT EXISTS `crops` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `name_en` VARCHAR(200) NOT NULL,
  `name_ur` VARCHAR(200) DEFAULT '',
  `thumbnail` VARCHAR(300) DEFAULT '',
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

'crop_images' => "CREATE TABLE IF NOT EXISTS `crop_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `crop_id` INT NOT NULL,
  `image_path` VARCHAR(300) NOT NULL,
  `caption` VARCHAR(200) DEFAULT '',
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

'crop_sections' => "CREATE TABLE IF NOT EXISTS `crop_sections` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `crop_id` INT NOT NULL,
  `lang` CHAR(2) DEFAULT 'en',
  `heading` VARCHAR(300) DEFAULT '',
  `content` TEXT,
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"

];

foreach ($tables as $name => $sql) {
    run($conn, $sql, $errors, $success, "Create table $name");
}

// Set up directory path to old-code JSON files
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
// 4. SEED CROP INFO & CROPS
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `crop_info`");
$conn->query("TRUNCATE TABLE `crops`");

$cropInfoFile = $jsonDir . 'cropinfo.json';
if (file_exists($cropInfoFile)) {
    $cropInfoData = json_decode(file_get_contents($cropInfoFile), true);
    if (isset($cropInfoData['languages'])) {
        // Collect crops combined by slug for crops table
        $cropsMap = [];
        if (isset($cropInfoData['languages']['en']['crops'])) {
            foreach ($cropInfoData['languages']['en']['crops'] as $idx => $c) {
                $link = $c['link'] ?? '';
                $slug = str_replace('.html', '', basename($link));
                $cropsMap[$slug] = [
                    'slug' => $slug,
                    'name_en' => $c['name'] ?? '',
                    'name_ur' => '',
                    'thumbnail' => $c['image'] ?? '',
                    'sort_order' => $idx + 1
                ];
            }
        }
        
        if (isset($cropInfoData['languages']['ur']['crops'])) {
            foreach ($cropInfoData['languages']['ur']['crops'] as $c) {
                $link = $c['link'] ?? '';
                $slug = str_replace('.html', '', basename($link));
                if (isset($cropsMap[$slug])) {
                    $cropsMap[$slug]['name_ur'] = $c['name'] ?? '';
                }
            }
        }
        
        // Match standard local thumbnails
        $localThumbs = [
            'wheat'  => 'assets/image.jpeg',
            'rice'   => 'assets/rice-intro.jpeg',
            'potato' => 'assets/potato-intro.jpeg',
            'maize'  => 'assets/maize-intro.jpg',
        ];
        
        // Insert into crops table
        $stmtCrops = $conn->prepare("INSERT INTO `crops` (slug, name_en, name_ur, thumbnail, sort_order) VALUES (?, ?, ?, ?, ?)");
        $stmtCrops->bind_param('ssssi', $slug, $name_en, $name_ur, $thumbnail, $sort_order);
        
        foreach ($cropsMap as $slug => $c) {
            $name_en = $c['name_en'];
            $name_ur = $c['name_ur'];
            $thumbnail = $localThumbs[$slug] ?? $c['thumbnail'];
            $sort_order = $c['sort_order'];
            if ($stmtCrops->execute()) {
                $success[] = "OK: Seed crops table (slug=$slug) from cropinfo.json";
            } else {
                $errors[] = "FAIL (crops table slug=$slug): " . $stmtCrops->error;
            }
        }
        $stmtCrops->close();
        
        // Insert into crop_info (legacy table)
        $stmtCropInfo = $conn->prepare("INSERT INTO `crop_info` (lang, name, description, image_url, link_page, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtCropInfo->bind_param('sssssi', $lang, $name, $desc, $img, $lnk, $ord);
        
        foreach (['en', 'ur'] as $lang) {
            if (isset($cropInfoData['languages'][$lang]['crops'])) {
                foreach ($cropInfoData['languages'][$lang]['crops'] as $idx => $c) {
                    $name = $c['name'] ?? '';
                    $desc = $c['desc'] ?? '';
                    $link = $c['link'] ?? '';
                    $slug = str_replace('.html', '', basename($link));
                    $img = $localThumbs[$slug] ?? $c['image'] ?? '';
                    $lnk = str_replace('.html', '.php', $link);
                    $ord = $idx + 1;
                    if ($stmtCropInfo->execute()) {
                        $success[] = "OK: Seed crop_info $lang $name from cropinfo.json";
                    } else {
                        $errors[] = "FAIL (crop_info $lang $name): " . $stmtCropInfo->error;
                    }
                }
            }
        }
        $stmtCropInfo->close();
    } else {
        $errors[] = "FAIL: cropinfo.json has invalid structure.";
    }
} else {
    $errors[] = "FAIL: cropinfo.json not found in old-code.";
}

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
            // Strip HTML <b> tags to keep formatting clean
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
    $errors[] = "FAIL: agri.json not found in old-code.";
}

// ─────────────────────────────────────────────
// 6. SEED CROP GUIDES & CROP IMAGES
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `crop_guides`");
$conn->query("TRUNCATE TABLE `crop_images`");

$cropsList = ['rice', 'potato', 'wheat', 'maize'];
foreach ($cropsList as $crop) {
    $cropFile = $jsonDir . $crop . '.json';
    if (file_exists($cropFile)) {
        $cropData = json_decode(file_get_contents($cropFile), true);
        if (is_array($cropData)) {
            // Seed crop_guides
            $stmtGuide = $conn->prepare("INSERT INTO `crop_guides`
                (crop,lang,title,section_intro,section_climate,section_soil,section_sowing,section_fertilizer,section_pests,section_harvest,
                 img_intro,img_climate,img_soil,img_sowing,img_fertilizer,img_pests,img_harvest,lang_btn,next_btn)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmtGuide->bind_param('sssssssssssssssssss',
                $crop,$lang,$title,$si,$scl,$sso,$ssw,$sf,$sp,$sh,
                $ii,$icl,$iso,$isw,$ife,$ip,$iha,$lb,$nb);
            
            foreach (['en', 'ur'] as $lang) {
                if (isset($cropData[$lang])) {
                    $d = $cropData[$lang];
                    $title = $d['title'] ?? '';
                    $si = $d['intro'] ?? '';
                    $scl = $d['climate'] ?? '';
                    $sso = $d['soil'] ?? '';
                    $ssw = $d['sowing'] ?? '';
                    $sf = $d['fertilizer'] ?? '';
                    $sp = $d['pests'] ?? '';
                    $sh = $d['harvest'] ?? '';
                    
                    // Map paths to standard assets/... paths
                    $ii  = isset($d['images']['intro'])  ? mapAssetPath($d['images']['intro'])  : '';
                    $icl = isset($d['images']['climate'])? mapAssetPath($d['images']['climate']): '';
                    $iso = isset($d['images']['soil'])   ? mapAssetPath($d['images']['soil'])   : '';
                    $isw = isset($d['images']['sowing']) ? mapAssetPath($d['images']['sowing']) : '';
                    $ife = isset($d['images']['fertilizer'])? mapAssetPath($d['images']['fertilizer']): '';
                    $ip  = isset($d['images']['pests'])  ? mapAssetPath($d['images']['pests'])  : '';
                    $iha = isset($d['images']['harvest'])? mapAssetPath($d['images']['harvest']): '';
                    
                    $lb = $d['langBtn'] ?? '';
                    $nb = $d['next'] ?? '';
                    
                    if ($stmtGuide->execute()) {
                        $success[] = "OK: Seed crop_guides $crop/$lang from $crop.json";
                    } else {
                        $errors[] = "FAIL (crop_guides $crop/$lang): " . $stmtGuide->error;
                    }
                }
            }
            $stmtGuide->close();
            
            // Seed crop_images (new normalized table)
            $sEsc = $conn->real_escape_string($crop);
            $cropRow = $conn->query("SELECT id FROM crops WHERE slug='$sEsc'")->fetch_assoc();
            if ($cropRow) {
                $cid = (int)$cropRow['id'];
                
                $stmtImg = $conn->prepare("INSERT INTO `crop_images` (crop_id, image_path, caption, sort_order) VALUES (?, ?, ?, ?)");
                $stmtImg->bind_param('issi', $cid, $image_path, $caption, $sort_order);
                
                $keys = ['intro', 'climate', 'soil', 'sowing', 'fertilizer', 'pests', 'harvest'];
                $sort = 0;
                foreach ($keys as $k) {
                    $img = $cropData['en']['images'][$k] ?? '';
                    $caption = $cropData['en'][$k] ?? ucfirst($k);
                    if (!$img) continue;
                    
                    $image_path = mapAssetPath($img);
                    $sort_order = $sort;
                    if ($stmtImg->execute()) {
                        $success[] = "OK: Seed crop_images for $crop ($k) from $crop.json";
                        $sort++;
                    } else {
                        $errors[] = "FAIL (crop_images $crop $k): " . $stmtImg->error;
                    }
                }
                $stmtImg->close();
            } else {
                $errors[] = "WARN: Slug '$crop' not found in crops table — cannot seed crop_images.";
            }
            
        } else {
            $errors[] = "FAIL: $crop.json has invalid structure.";
        }
    } else {
        $errors[] = "FAIL: $crop.json not found in old-code.";
    }
}

// ─────────────────────────────────────────────
// 7. SEED CROP DETAILS & CROP SECTIONS
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `crop_details`");
$conn->query("TRUNCATE TABLE `crop_sections`");

foreach ($cropsList as $crop) {
    $infoFile = $jsonDir . $crop . 'info.json';
    if (file_exists($infoFile)) {
        $infoData = json_decode(file_get_contents($infoFile), true);
        if (is_array($infoData)) {
            // Seed crop_details
            $stmtDetails = $conn->prepare("INSERT INTO `crop_details` (crop,lang,title,section_order,heading,content) VALUES (?,?,?,?,?,?)");
            $stmtDetails->bind_param('sssiss', $crop,$lang,$title,$ord,$heading,$content);
            
            foreach (['english', 'urdu'] as $lang) {
                if (isset($infoData[$lang])) {
                    $group = $infoData[$lang];
                    $title = $group['title'] ?? '';
                    foreach ($group['sections'] as $idx => $sec) {
                        $ord = $idx + 1;
                        $heading = $sec['heading'] ?? '';
                        $content = $sec['content'] ?? '';
                        if ($stmtDetails->execute()) {
                            $success[] = "OK: Seed crop_details $crop/$lang section " . ($idx+1) . " from {$crop}info.json";
                        } else {
                            $errors[] = "FAIL (crop_details $crop/$lang s".($idx+1)."): " . $stmtDetails->error;
                        }
                    }
                }
            }
            $stmtDetails->close();
            
            // Seed crop_sections (new normalized table)
            $sEsc = $conn->real_escape_string($crop);
            $cropRow = $conn->query("SELECT id FROM crops WHERE slug='$sEsc'")->fetch_assoc();
            if ($cropRow) {
                $cid = (int)$cropRow['id'];
                
                $stmtSec = $conn->prepare("INSERT INTO `crop_sections` (crop_id, lang, heading, content, sort_order) VALUES (?, ?, ?, ?, ?)");
                $stmtSec->bind_param('isssi', $cid, $langCode, $heading, $content, $sort_order);
                
                foreach (['english' => 'en', 'urdu' => 'ur'] as $langName => $langCode) {
                    if (isset($infoData[$langName])) {
                        foreach ($infoData[$langName]['sections'] as $idx => $sec) {
                            $heading = $sec['heading'] ?? '';
                            $content = $sec['content'] ?? '';
                            $sort_order = $idx;
                            if ($stmtSec->execute()) {
                                $success[] = "OK: Seed crop_sections $crop/$langCode section " . ($idx+1) . " from {$crop}info.json";
                            } else {
                                $errors[] = "FAIL (crop_sections $crop/$langCode s".($idx+1)."): " . $stmtSec->error;
                            }
                        }
                    }
                }
                $stmtSec->close();
            } else {
                $errors[] = "WARN: Slug '$crop' not found in crops table — cannot seed crop_sections.";
            }
            
        } else {
            $errors[] = "FAIL: {$crop}info.json has invalid structure.";
        }
    } else {
        $errors[] = "FAIL: {$crop}info.json not found in old-code.";
    }
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
