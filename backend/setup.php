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

];

foreach ($tables as $name => $sql) {
    run($conn, $sql, $errors, $success, "Create table $name");
}

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
// 3. SEED FARM DATA
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `farm_data`");

$farmData = [
    'en' => [
        'title'          => 'Welcome to FarmEase',
        'subtitle'       => 'A Bilingual Farming Support System',
        'btn_crop_info'  => 'Crop Information',
        'btn_calculator' => 'AgriCost and Profit guide',
        'btn_helpline'   => 'Contact with experts',
        'switch_language'=> 'اردو',
        'about_heading'  => 'About Us',
        'about_p1'       => 'Our project is a user-friendly agricultural platform that provides accurate and organized information about different crops, including costs and farming details. It is designed to help farmers and students easily access important knowledge in one place.',
        'about_p2'       => 'With a simple interface and bilingual support, the platform ensures accessibility for a wider audience.',
        'about_p3'       => 'This project aims to promote smart farming and improve decision-making through the use of technology.',
    ],
    'ur' => [
        'title'          => 'فارم ایز میں خوش آمدید',
        'subtitle'       => 'دو لسانی زرعی معاون نظام',
        'btn_crop_info'  => 'فصل کی معلومات',
        'btn_calculator' => 'زرعی لاگت اورمنافع گائیڈ',
        'btn_helpline'   => 'ماہرین سے رابطہ',
        'switch_language'=> 'English',
        'about_heading'  => 'ہمارے بارے میں',
        'about_p1'       => 'ہمارا پروجیکٹ ایک صارف دوست زرعی پلیٹ فارم ہے جو مختلف فصلوں کے بارے میں درست اور منظم معلومات فراہم کرتا ہے، جیسے کہ اخراجات اور کاشتکاری کی تفصیلات۔ یہ کسانوں اور طلباء کو ایک جگہ پر اہم معلومات آسانی سے حاصل کرنے میں مدد کے لیے بنایا گیا ہے۔',
        'about_p2'       => 'سادہ انٹرفیس اور دو لسانی سہولت کے ساتھ، یہ پلیٹ فارم وسیع تر سامعین کے لیے قابل رسائی ہے۔',
        'about_p3'       => 'یہ پروجیکٹ ٹیکنالوجی کے استعمال سے ذہین زراعت کو فروغ دینے اور بہتر فیصلہ سازی کا مقصد رکھتا ہے۔',
    ],
];

$stmt = $conn->prepare("INSERT INTO `farm_data`
    (lang,title,subtitle,btn_crop_info,btn_calculator,btn_helpline,switch_language,about_heading,about_p1,about_p2,about_p3)
    VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('sssssssssss', $lang,$title,$subtitle,$bci,$bcalc,$bhel,$sw,$ah,$ap1,$ap2,$ap3);

foreach ($farmData as $lang => $d) {
    $title=$d['title']; $subtitle=$d['subtitle'];
    $bci=$d['btn_crop_info']; $bcalc=$d['btn_calculator']; $bhel=$d['btn_helpline'];
    $sw=$d['switch_language']; $ah=$d['about_heading'];
    $ap1=$d['about_p1']; $ap2=$d['about_p2']; $ap3=$d['about_p3'];
    if ($stmt->execute()) {
        $success[] = "OK: Seed farm_data lang=$lang";
    } else {
        $errors[] = "FAIL (farm_data $lang): " . $stmt->error;
    }
}
$stmt->close();

// ─────────────────────────────────────────────
// 4. SEED CROP INFO
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `crop_info`");

$cropInfoData = [
    'en' => [
        ['Rice',   'A staple food crop grown in flooded fields, requiring plenty of water',                        'https://cdn.britannica.com/89/140889-050-EC3F00BF/Ripening-heads-rice-Oryza-sativa.jpg',              'rice.php',   1],
        ['Potato', 'A versatile tuber crop grown in well-drained soil',                                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdFq-FuA8g_OFpM9gHfolOwMppWlOyuPrDjA&s',  'potato.php', 2],
        ['Wheat',  'A primary cereal crop grown in temperate regions',                                             'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRyLD_CD4XW-_ktQUJRrT2kwBPbZKEFH7hrQ&s',  'wheat.php',  3],
        ['Maize',  'A popular maize grown in warm climates, used for food and animal feed',                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvsJXY7ZlO8BwoVoqu2eP4lI995BWaUYeExQ&s',  'maize.php',  4],
    ],
    'ur' => [
        ['چاول',  'ایک بنیادی غذائی فصل جو پانی سے بھری زمین میں اگائی جاتی ہے',                                'https://cdn.britannica.com/89/140889-050-EC3F00BF/Ripening-heads-rice-Oryza-sativa.jpg',              'rice.php',   1],
        ['آلو',   'ایک قیمتی جڑ والی فصل جو خشک زمین میں اگائی جاتی ہے',                                      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdFq-FuA8g_OFpM9gHfolOwMppWlOyuPrDjA&s',  'potato.php', 2],
        ['گندم',  'ایک اہم اناجی فصل جو معتدل علاقوں میں اگائی جاتی ہے',                                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRyLD_CD4XW-_ktQUJRrT2kwBPbZKEFH7hrQ&s',  'wheat.php',  3],
        ['مکئی', 'ایک مقبول فصل جو گرم علاقوں میں اگائی جاتی ہے اور خوراک کے لیے استعمال ہوتی ہے',            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvsJXY7ZlO8BwoVoqu2eP4lI995BWaUYeExQ&s',  'maize.php',  4],
    ],
];

$stmt = $conn->prepare("INSERT INTO `crop_info` (lang,name,description,image_url,link_page,sort_order) VALUES (?,?,?,?,?,?)");
$stmt->bind_param('sssssi', $lang,$name,$desc,$img,$lnk,$ord);

foreach ($cropInfoData as $lang => $crops) {
    foreach ($crops as $c) {
        [$name,$desc,$img,$lnk,$ord] = $c;
        if ($stmt->execute()) {
            $success[] = "OK: Seed crop_info $lang $name";
        } else {
            $errors[] = "FAIL (crop_info $lang $name): " . $stmt->error;
        }
    }
}
$stmt->close();

// ─────────────────────────────────────────────
// 5. SEED AGRI COST
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `agri_cost`");

$agriCost = [
    'wheat' => [
        'name_en'    => '<b>Wheat</b>',
        'name_ur'    => '<b>گندم</b>',
        'desc_en'    => 'Cost per Acre & Details',
        'desc_ur'    => 'فی ایکڑ لاگت اور تفصیل',
        'details_en' => "<b> Wheat</b>\nTotal Estimated Cost: 55,000 – 70,000 PKR\n\n<b>Breakdown:</b>\nSeed: 4,000 – 6,000\nLand preparation: 6,000 – 8,000\nFertilizer: 18,000 – 25,000\nIrrigation: 5,000 – 8,000\nSpray: 3,000 – 5,000\nLabor: 5,000 – 7,000\nHarvesting: 8,000 – 12,000\n\nYield: 35 – 45 Maund\nRate: 3,000 – 3,500\nIncome: 105,000 – 150,000\nProfit: 40,000 – 80,000\n\nLow cost, low risk, stable crop",
        'details_ur' => " <b>گندم</b>\nکل تخمینی لاگت: 55,000 – 70,000 روپے\n\n<b>تفصیل</b>\nبیج: 4,000 – 6,000\nزمین کی تیاری: 6,000 – 8,000\nکھاد: 18,000 – 25,000\nآبپاشی: 5,000 – 8,000\nاسپرے: 3,000 – 5,000\nمزدوری: 5,000 – 7,000\nکٹائی: 8,000 – 12,000\n\nپیداوار: 35 – 45 من\nریٹ: 3,000 – 3,500\nآمدن: 105,000 – 150,000\nمنافع: 40,000 – 80,000\n\nکم لاگت، کم خطرہ، مستحکم فصل",
    ],
    'maize' => [
        'name_en'    => '<b>Maize</b>',
        'name_ur'    => '<b>مکئی</b>',
        'desc_en'    => 'Cost per Acre & Details',
        'desc_ur'    => 'فی ایکڑ لاگت اور تفصیل',
        'details_en' => "<b>Maize</b>\nTotal Estimated Cost: 65,000 – 85,000 PKR\n\n<b>Breakdown:</b>\nHybrid Seed: 8,000 – 12,000\nLand preparation: 6,000 – 8,000\nFertilizer: 20,000 – 28,000\nIrrigation: 6,000 – 10,000\nSpray: 4,000 – 7,000\nLabor: 5,000 – 8,000\nHarvesting: 8,000 – 12,000\n\nYield: 60 – 100 Maund\nRate: 2,200 – 2,800\nIncome: 130,000 – 220,000\nProfit: 60,000 – 130,000\n\nModerate investment, good profit",
        'details_ur' => " <b>مکئی</b>\nکل تخمینی لاگت: 65,000 – 85,000 روپے\n\n<b>تفصیل</b>\nہائبرڈ بیج: 8,000 – 12,000\nزمین کی تیاری: 6,000 – 8,000\nکھاد: 20,000 – 28,000\nآبپاشی: 6,000 – 10,000\nاسپرے: 4,000 – 7,000\nمزدوری: 5,000 – 8,000\nکٹائی: 8,000 – 12,000\n\nپیداوار: 60 – 100 من\nریٹ: 2,200 – 2,800\nآمدن: 130,000 – 220,000\nمنافع: 60,000 – 130,000\n\nدرمیانی سرمایہ، اچھا منافع",
    ],
    'potato' => [
        'name_en'    => '<b>Potato</b>',
        'name_ur'    => '<b>آلو</b>',
        'desc_en'    => 'Cost per Acre & Details',
        'desc_ur'    => 'فی ایکڑ لاگت اور تفصیل',
        'details_en' => " <b>Potato</b>\nTotal Estimated Cost: 120,000 – 160,000 PKR\n<b>Breakdown:</b>\nSeed: 60,000 – 90,000\nLand preparation: 8,000 – 10,000\nFertilizer: 20,000 – 30,000\nIrrigation: 8,000 – 12,000\nSpray: 6,000 – 10,000\nLabor: 10,000 – 15,000\nHarvesting: 10,000 – 15,000\n\nYield: 250 – 350 Maund\nRate: 1,500 – 2,500\nIncome: 375,000 – 875,000\nProfit: 200,000 – 600,000\n\nHigh profit, high investment",
        'details_ur' => "<b> آلو</b>\nکل تخمینی لاگت: 120,000 – 160,000 روپے\n\n<b>تفصیل</b>\nبیج: 60,000 – 90,000\nزمین کی تیاری: 8,000 – 10,000\nکھاد: 20,000 – 30,000\nآبپاشی: 8,000 – 12,000\nاسپرے: 6,000 – 10,000\nمزدوری: 10,000 – 15,000\nکٹائی: 10,000 – 15,000\n\nپیداوار: 250 – 350 من\nریٹ: 1,500 – 2,500\nآمدن: 375,000 – 875,000\nمنافع: 200,000 – 600,000\n\nزیادہ منافع، زیادہ سرمایہ",
    ],
    'rice' => [
        'name_en'    => '<b>Rice</b>',
        'name_ur'    => '<b>چاول</b>',
        'desc_en'    => 'Cost per Acre & Details',
        'desc_ur'    => 'فی ایکڑ لاگت اور تفصیل',
        'details_en' => "<b>Rice</b>\nTotal Estimated Cost: 70,000 – 100,000 PKR\n\n<b>Breakdown:</b>\nNursery + Seed: 4,000 – 7,000\nLand preparation: 8,000 – 12,000\nFertilizer: 20,000 – 30,000\nIrrigation: 10,000 – 15,000\nSpray: 5,000 – 8,000\nLabor: 10,000 – 15,000\nHarvesting: 10,000 – 13,000\n\nYield: 50 – 70 Maund\nRate: 3,500 – 4,500\nIncome: 175,000 – 315,000\nProfit: 80,000 – 200,000\n\nHigh water & labor requirement",
        'details_ur' => " <b>چاول</b>\nکل تخمینی لاگت: 70,000 – 100,000 روپے\n\n<b>تفصیل</b>\nنرسری اور بیج: 4,000 – 7,000\nزمین کی تیاری: 8,000 – 12,000\nکھاد: 20,000 – 30,000\nآبپاشی: 10,000 – 15,000\nاسپرے: 5,000 – 8,000\nمزدوری: 10,000 – 15,000\nکٹائی: 10,000 – 13,000\n\nپیداوار: 50 – 70 من\nریٹ: 3,500 – 4,500\nآمدن: 175,000 – 315,000\nمنافع: 80,000 – 200,000\n\nزیادہ پانی اور محنت درکار",
    ],
];

$stmt = $conn->prepare("INSERT INTO `agri_cost` (crop_key,name_en,name_ur,desc_en,desc_ur,details_en,details_ur) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param('sssssss', $ck,$ne,$nu,$de,$du,$den,$dur);

foreach ($agriCost as $ck => $d) {
    $ne=$d['name_en']; $nu=$d['name_ur'];
    $de=$d['desc_en']; $du=$d['desc_ur'];
    $den=$d['details_en']; $dur=$d['details_ur'];
    if ($stmt->execute()) {
        $success[] = "OK: Seed agri_cost $ck";
    } else {
        $errors[] = "FAIL (agri_cost $ck): " . $stmt->error;
    }
}
$stmt->close();

// ─────────────────────────────────────────────
// 6. SEED CROP GUIDES
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `crop_guides`");

$cropGuides = [
    'maize' => [
        'en' => [
            'title'             => 'Maize - Complete Crop Guide',
            'section_intro'     => 'Introduction',
            'section_climate'   => 'Climate Requirement',
            'section_soil'      => 'Soil Requirement',
            'section_sowing'    => 'Sowing Time',
            'section_fertilizer'=> 'Fertilizer Schedule',
            'section_pests'     => 'Weeds, Pests and Diseases',
            'section_harvest'   => 'Harvesting',
            'img_intro'         => 'assets/maize-intro.jpg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/maize-soil.jpg',
            'img_sowing'        => 'assets/maize-sowing.jpg',
            'img_fertilizer'    => 'assets/maize-fertilizer.jpg',
            'img_pests'         => 'assets/maize-pest.jpg',
            'img_harvest'       => 'assets/maize-harvesting.jpg',
            'lang_btn'          => 'اردو',
            'next_btn'          => 'View Detail',
        ],
        'ur' => [
            'title'             => 'مکؑی - مکمل کاشتی رہنمائی',
            'section_intro'     => 'تعارف',
            'section_climate'   => 'آب و ہوا کی ضروریات',
            'section_soil'      => 'مٹی کی ضروریات',
            'section_sowing'    => 'بوائی کا وقت',
            'section_fertilizer'=> 'کھاد کا شیڈول',
            'section_pests'     => 'جڑی بوٹیاں، کیڑے اور بیماریاں',
            'section_harvest'   => 'کٹائی',
            'img_intro'         => 'assets/maize-intro.jpg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/maize-soil.jpg',
            'img_sowing'        => 'assets/maize-sowing.jpg',
            'img_fertilizer'    => 'assets/maize-fertilizer.jpg',
            'img_pests'         => 'assets/maize-pest.jpg',
            'img_harvest'       => 'assets/maize-harvesting.jpg',
            'lang_btn'          => 'English',
            'next_btn'          => 'تفصیل',
        ],
    ],
    'rice' => [
        'en' => [
            'title'             => 'Rice - Complete Crop Guide',
            'section_intro'     => 'Introduction',
            'section_climate'   => 'Climate Requirement',
            'section_soil'      => 'Soil Requirement',
            'section_sowing'    => 'Sowing Time',
            'section_fertilizer'=> 'Fertilizer Schedule',
            'section_pests'     => 'Weeds, Pests and Diseases',
            'section_harvest'   => 'Harvesting',
            'img_intro'         => 'assets/rice-intro.jpeg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/rice-soil.jpeg',
            'img_sowing'        => 'assets/rice-sowing.jpeg',
            'img_fertilizer'    => 'assets/rice-fertilizer.jpeg',
            'img_pests'         => 'assets/rice-pests.jpeg',
            'img_harvest'       => 'assets/rice-harvesting.jpeg',
            'lang_btn'          => 'اردو',
            'next_btn'          => 'View Detail',
        ],
        'ur' => [
            'title'             => 'چاول- مکمل کاشتی رہنمائی',
            'section_intro'     => 'تعارف',
            'section_climate'   => 'آب و ہوا کی ضروریات',
            'section_soil'      => 'مٹی کی ضروریات',
            'section_sowing'    => 'بوائی کا وقت',
            'section_fertilizer'=> 'کھاد کا شیڈول',
            'section_pests'     => 'جڑی بوٹیاں، کیڑے اور بیماریاں',
            'section_harvest'   => 'کٹائی',
            'img_intro'         => 'assets/rice-intro.jpeg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/rice-soil.jpeg',
            'img_sowing'        => 'assets/rice-sowing.jpeg',
            'img_fertilizer'    => 'assets/rice-fertilizer.jpeg',
            'img_pests'         => 'assets/rice-pests.jpeg',
            'img_harvest'       => 'assets/rice-harvesting.jpeg',
            'lang_btn'          => 'English',
            'next_btn'          => 'تفصیل',
        ],
    ],
    'potato' => [
        'en' => [
            'title'             => 'Potato - Complete Crop Guide',
            'section_intro'     => 'Introduction',
            'section_climate'   => 'Climate Requirement',
            'section_soil'      => 'Soil Requirement',
            'section_sowing'    => 'Sowing Time',
            'section_fertilizer'=> 'Fertilizer Schedule',
            'section_pests'     => 'Weeds, Pests and Diseases',
            'section_harvest'   => 'Harvesting',
            'img_intro'         => 'assets/potato-intro.jpeg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/potato-soil.jpeg',
            'img_sowing'        => 'assets/potato-sowing.jpg',
            'img_fertilizer'    => 'assets/potato-fertilizer.jpg',
            'img_pests'         => 'assets/potato-pest.jpg',
            'img_harvest'       => 'assets/potato-harvesting.jpg',
            'lang_btn'          => 'اردو',
            'next_btn'          => 'View Detail',
        ],
        'ur' => [
            'title'             => 'آلو - مکمل کاشتی رہنمائی',
            'section_intro'     => 'تعارف',
            'section_climate'   => 'آب و ہوا کی ضروریات',
            'section_soil'      => 'مٹی کی ضروریات',
            'section_sowing'    => 'بوائی کا وقت',
            'section_fertilizer'=> 'کھاد کا شیڈول',
            'section_pests'     => 'جڑی بوٹیاں، کیڑے اور بیماریاں',
            'section_harvest'   => 'کٹائی',
            'img_intro'         => 'assets/potato-intro.jpeg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/potato-soil.jpeg',
            'img_sowing'        => 'assets/potato-sowing.jpg',
            'img_fertilizer'    => 'assets/potato-fertilizer.jpg',
            'img_pests'         => 'assets/potato-pest.jpg',
            'img_harvest'       => 'assets/potato-harvesting.jpg',
            'lang_btn'          => 'English',
            'next_btn'          => 'تفصیل',
        ],
    ],
    'wheat' => [
        'en' => [
            'title'             => 'Wheat - Complete Crop Guide',
            'section_intro'     => 'Introduction',
            'section_climate'   => 'Climate Requirement',
            'section_soil'      => 'Soil Requirement',
            'section_sowing'    => 'Sowing Time',
            'section_fertilizer'=> 'Fertilizer Schedule',
            'section_pests'     => 'Weeds, Pests and Diseases',
            'section_harvest'   => 'Harvesting',
            'img_intro'         => 'assets/image.jpeg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/soil.jpg',
            'img_sowing'        => 'assets/sowing.jpg',
            'img_fertilizer'    => 'assets/fertilizer.jpg',
            'img_pests'         => 'assets/pests.jpg',
            'img_harvest'       => 'assets/harvesting.jpg',
            'lang_btn'          => 'اردو',
            'next_btn'          => 'View Detail',
        ],
        'ur' => [
            'title'             => 'گندم - مکمل کاشتی رہنمائی',
            'section_intro'     => 'تعارف',
            'section_climate'   => 'آب و ہوا کی ضروریات',
            'section_soil'      => 'مٹی کی ضروریات',
            'section_sowing'    => 'بوائی کا وقت',
            'section_fertilizer'=> 'کھاد کا شیڈول',
            'section_pests'     => 'جڑی بوٹیاں، کیڑے اور بیماریاں',
            'section_harvest'   => 'کٹائی',
            'img_intro'         => 'assets/image.jpeg',
            'img_climate'       => 'assets/climate.jpg',
            'img_soil'          => 'assets/soil.jpg',
            'img_sowing'        => 'assets/sowing.jpg',
            'img_fertilizer'    => 'assets/fertilizer.jpg',
            'img_pests'         => 'assets/pests.jpg',
            'img_harvest'       => 'assets/harvesting.jpg',
            'lang_btn'          => 'English',
            'next_btn'          => 'تفصیل',
        ],
    ],
];

$stmt = $conn->prepare("INSERT INTO `crop_guides`
    (crop,lang,title,section_intro,section_climate,section_soil,section_sowing,section_fertilizer,section_pests,section_harvest,
     img_intro,img_climate,img_soil,img_sowing,img_fertilizer,img_pests,img_harvest,lang_btn,next_btn)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('sssssssssssssssssss',
    $crop,$lang,$title,$si,$scl,$sso,$ssw,$sf,$sp,$sh,
    $ii,$icl,$iso,$isw,$ife,$ip,$iha,$lb,$nb);

foreach ($cropGuides as $crop => $langs) {
    foreach ($langs as $lang => $d) {
        $title=$d['title']; $si=$d['section_intro']; $scl=$d['section_climate'];
        $sso=$d['section_soil']; $ssw=$d['section_sowing']; $sf=$d['section_fertilizer'];
        $sp=$d['section_pests']; $sh=$d['section_harvest'];
        $ii=$d['img_intro']; $icl=$d['img_climate']; $iso=$d['img_soil'];
        $isw=$d['img_sowing']; $ife=$d['img_fertilizer']; $ip=$d['img_pests']; $iha=$d['img_harvest'];
        $lb=$d['lang_btn']; $nb=$d['next_btn'];
        if ($stmt->execute()) {
            $success[] = "OK: Seed crop_guides $crop/$lang";
        } else {
            $errors[] = "FAIL (crop_guides $crop/$lang): " . $stmt->error;
        }
    }
}
$stmt->close();

// ─────────────────────────────────────────────
// 7. SEED CROP DETAILS
// ─────────────────────────────────────────────

$conn->query("TRUNCATE TABLE `crop_details`");

$cropDetails = [

// ── MAIZE ──────────────────────────────────────────────────
'maize' => [
  'english' => [
    'title' => 'Maize Crop Information',
    'sections' => [
      [' Introduction', "Maize is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes wheat, rice, and barley. Maize is primarily grown for its grains, which are used for human food, animal feed, and industrial products like starch, oil, and biofuel.\n\n<b><u>Key Characteristics of Maize:</u></b>\n Warm-season crop (Kharif crop)\n Plant height: 150 to 300 cm (varies by variety)\nStem: solid and thick\n Leaves: long, broad, and green\n Root system: fibrous and deep\nGrain: rich in carbohydrates, oil, protein, vitamins, and minerals\n\n<b><u>Global Importance:</u></b>\n One of the top 3 staple crops (with wheat and rice)\nAnnual global production: 1100+ million tons\n Major producers: USA, China, Brazil, Argentina, India\n Widely used in food industry and livestock feed\n\n<b><u>Importance for Farmers:</u></b>\n High yield potential\n Used as food and fodder\nHigh demand in poultry feed industry\n Suitable for mechanized farming\nProvides stable and profitable income"],
      [' Climate Requirement', "Maize grows best in warm and moderately humid climates.\n\n<b><u>Temperature:</u></b>\nGermination: 18 to 25°C\n Vegetative growth: 25 to 30°C\n Grain filling: 20 to 25°C\nBelow 10°C → poor growth\n Above 35°C → heat stress and reduced yield\n\n<b><u>Rainfall & Moisture:</u></b>\n Total requirement: 500 to 800 mm\nNeeds adequate moisture during germination and flowering\n Water stress at tasseling stage → severe yield loss\n Excess water → root damage and diseases\n\n<b><u>Sunlight:</u></b>\n Requires full sunlight for optimal growth\n Low light reduces yield\n\n<b><u>Wind:</u></b>\n Strong winds may cause lodging (plants fall over)"],
      [' Soil Requirement', "Maize performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types:</u></b>\n Loam (ideal)\n Sandy loam\n Silt loam\n\n<b><u>Soil pH:</u></b>\n Ideal range: 5.5 to 7.5\n\n<b><u>Important Soil Properties:</u></b>\nGood drainage (avoid waterlogging)\n High fertility\n Adequate organic matter\n Proper soil aeration\n\n<b><u>Soil Preparation:</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and crop residues\nApply farmyard manure (8 to 10 tons/acre)\nLevel the land properly"],
      [' Sowing Time', "<b><u>Ideal Sowing Time :</u></b>\n Spring crop: January to February\n Kharif crop: June to July (best season)\n\n<b><u>Seed Selection:</u></b>\nUse certified, hybrid, and disease-free seeds\n Popular hybrids: Pioneer, Monsanto, Local approved hybrids\n\n<b><u>Seed Rate:</u></b>\n 20 to 25 kg per acre\n\n<b><u>Sowing Method:</u></b>\n Drill method (recommended)\nRow spacing: 60 to 75 cm\n Plant spacing: 20 to 25 cm\n Seed depth: 3 to 5 cm"],
      [' Fertilizer Schedule', "<b><u>Recommended Dose</u> (Per Acre)</b>:\n Urea: 2 bags\nDAP: 1 bag\n Potash: 1/2 bag\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\n1. Basal Dose (At Sowing): Full DAP, Full Potash, Half Urea, Zinc Sulfate\n2. First Irrigation (20 to 25 Days After Sowing): Apply 25% Urea\n3. Second Irrigation (40 to 45 Days After Sowing): Apply remaining 25% Urea\n\n<b><u>Nutrient Importance:</u></b>\n Nitrogen: Promotes leaf growth and yield\n Phosphorus: Enhances root development\nPotassium: Improves plant strength and disease resistance\n Zinc: Helps in better grain formation"],
      [' Weeds, Pests and Diseases', "<b>A.<u> Weeds:</u></b>\n Common Weeds: Grasses, Bathu (Chenopodium), Dela (Cyperus), Broadleaf weeds\n <b><u>Control:</u></b> Manual weeding at 20 to 30 days, Chemical control: Atrazine, Pendimethalin\n\n<b>B. <u>Pests:</u></b>\n Stem Borer: Feeds inside the stem, weakens the plant. <b><u>Control:</u></b> Chlorantraniliprole spray\n Fall Armyworm: Feeds on leaves, severe damage. <b><u>Control:</u></b> Emamectin Benzoate\n Aphids: Suck plant sap, reduce growth. <b><u>Control:</u></b> Imidacloprid\n\n<b>C.<u> Diseases:</u></b>\n Leaf Blight: Brown lesions on leaves. Control: Fungicide application\n Rust: Orange or brown powder on leaves. Control: Resistant varieties and fungicide spray\n Downy Mildew: Yellowing and stunted plants. Control: Seed treatment before sowing"],
      [' Harvesting', "<b><u>Harvesting Time:</u></b>\n 90 to 120 days after sowing\n\n<b><U>When to Harvest:</u></b>\nHusks turn dry\nGrains become hard\n Moisture content around 20 to 25%"],
    ],
  ],
  'urdu' => [
    'title' => 'مکئی کی فصل کی معلومات',
    'sections' => [
      [' تعارف', "مکئی دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوایسیا فیملی سے تعلق رکھتی ہے، جس میں گندم، چاول، اور جو شامل ہیں۔ مکئی بنیادی طور پر اپنے دانوں کے لیے اگائی جاتی ہے، جو انسانی غذا، جانوروں کے چارہ، اور صنعتی مصنوعات جیسے نشاستہ، تیل، اور بایوفیول میں استعمال ہوتے ہیں۔\n\n<b>مکئی کی اہم خصوصیات</b>\n- گرم موسم کی فصل (کھڑی فصل)\n- پودے کی اونچائی: 150 سے 300 سینٹی میٹر (نسل کے حساب سے مختلف)\n- تنے: مضبوط اور موٹے\n- پتے: لمبے، چوڑے اور سبز\n- جڑ کا نظام: ریشے دار اور گہرا\n- دانہ: کاربوہائیڈریٹس، تیل، پروٹین، وٹامنز اور معدنیات سے بھرپور\n\n<b>عالمی اہمیت</b>\n- تین اہم غذائی فصلوں میں سے ایک (گندم اور چاول کے ساتھ)\n- سالانہ عالمی پیداوار: 1100+ ملین ٹن\n- بڑے پیدا کرنے والے ممالک: امریکہ، چین، برازیل، ارجنٹینا، بھارت\n- خوراک کی صنعت اور جانوروں کے چارہ میں وسیع استعمال\n\n<b>کسانوں کے لیے اہمیت</b>\n- زیادہ پیداوار کی صلاحیت\n- خوراک اور چارہ کے لیے استعمال\n- پولٹری فیڈ انڈسٹری میں زیادہ طلب\n- مشینی کھیتی کے لیے موزوں\n- مستحکم اور منافع بخش آمدنی فراہم کرتی ہے"],
      ['موسمی تقاضے', "مکئی سب سے بہتر گرم اور معتدل نمی والے علاقوں میں اگتی ہے۔\n\n<b>درجہ حرارت</b>\n- اگنا: 18 سے 25°C\n- نشوونما: 25 سے 30°C\n- دانہ بھرنے کا مرحلہ: 20 سے 25°C\n- 10°C سے کم → کمزور نمو\n- 35°C سے زیادہ → حرارت کی شدت اور پیداوار میں کمی\n\n<b>بارش اور نمی</b>\n- کل ضرورت: 500 سے 800 ملی میٹر\n- اگنے اور پھولنے کے دوران مناسب نمی کی ضرورت\n- ٹیسلنگ مرحلے میں پانی کی کمی → شدید پیداوار کا نقصان\n- زیادہ پانی → جڑوں کو نقصان اور بیماریاں\n\n<b>روشنی</b>\n- مکمل دھوپ کی ضرورت\n- کم روشنی پیداوار کم کرتی ہے\n\n<b>ہوا</b>\n- شدید ہوائیں پودوں کو گرنے پر مجبور کر سکتی ہیں"],
      ['مٹی کے تقاضے', "مکئی بہترین زرخیز اور پانی نکالنے والی مٹی میں اگتی ہے۔\n\n<b>مٹی کی بہترین اقسام</b>\n- لوئم (مثالی)\n- ریتلی لوئم\n- سیلٹ لوئم\n\n<b> پی ایچ</b>\n- مثالی حد: 5.5 سے 7.5\n\n<b>اہم مٹی کی خصوصیات</b>\n- اچھی نکاسی (پانی جمع ہونے سے بچیں)\n- زیادہ زرخیزی\n- مناسب نامیاتی مادہ\n- مناسب ہوا دار مٹی\n\n<b>مٹی کی تیاری</b>\n- باریک بیج بچھانے کے لیے 2 سے 3 ہل چلائیں\n- گھاس اور فصل کے باقیات ہٹائیں\n- فارم یارڈ کھاد لگائیں (8 سے 10 ٹن فی ایکڑ)\n- زمین کو مناسب سطح پر لیول کریں"],
      [' بونے کا وقت', "<b>پاکستان میں بونے کا مثالی وقت</b>\n- بہاری فصل: جنوری سے فروری\n- کھڑی فصل: جون سے جولائی (سب سے بہترین موسم)\n\n<b>بیج کا انتخاب</b>\n- تصدیق شدہ، ہائبرڈ، اور بیماری سے پاک بیج استعمال کریں\n- مشہور ہائبرڈز: پائنیئر، مونسانٹو، مقامی منظور شدہ ہائبرڈز\n\n<b>بیج کی مقدار</b>\n- 20 سے 25 کلوگرام فی ایکڑ\n\n<b>بونے کا طریقہ</b>\n- ڈرل طریقہ (سفارش کی جاتی ہے)\n- قطار کا فاصلہ: 60 سے 75 سینٹی میٹر\n- پودے کا فاصلہ: 20 سے 25 سینٹی میٹر\n- بیج کی گہرائی: 3 سے 5 سینٹی میٹر"],
      ['کھادوں کا شیڈول', "<b>فی ایکڑ تجویز شدہ خوراک</b>\n- یوریا: 2 تھیلے\n- ڈی اے پی: 1 تھیلا\n- پوٹاش: 1/2 تھیلا\n- زنک سلفیٹ: 5 سے 10 کلوگرام\n- نامیاتی کھاد: 8 سے 10 ٹن\n\n<b>درخواست کا شیڈول</b>\n1. بنیادی خوراک (بونے کے وقت): مکمل ڈی اے پی، مکمل پوٹاش، نصف یوریا، زنک سلفیٹ\n2. پہلی آبپاشی (بونے کے 20 سے 25 دن بعد): 25% یوریا لگائیں\n3. دوسری آبپاشی (بونے کے 40 سے 45 دن بعد): باقی 25% یوریا لگائیں\n\n<b>غذائی اجزاء کی اہمیت</b>\n- نائٹروجن: پتوں کی نمو اور پیداوار کو فروغ دیتا ہے\n- فاسفورس: جڑوں کی ترقی کو بہتر بناتا ہے\n- پوٹاشیم: پودے کی مضبوطی اور بیماریوں کی مزاحمت بڑھاتا ہے\n- زنک: دانے کی بہتر تشکیل میں مدد دیتا ہے"],
      [' جڑی بوٹیاں، کیڑے اور بیماریاں', "<b> جڑی بوٹیاں</b>\n- عام جڑی بوٹیاں: گھاس، بٹھو ، دیلا ، چوڑی پتیاں والی جڑی بوٹیاں\n- کنٹرول: 20 سے 30 دن بعد ہاتھ سے صفائی، کیمیائی کنٹرول: ایٹرازین، پینڈیمیتھالین\n\n<b> کیڑے</b>\n- اسٹیم بورر: تنوں کے اندر کھاتے ہیں، پودے کو کمزور کرتے ہیں۔ کنٹرول: کلورانٹرانیل پروائل سپرے\n- فال آرمی ورم: پتوں کو کھاتا ہے، شدید نقصان۔ کنٹرول: ایما میکٹن بینزویٹ\n- افڈز: پودے کا رس چوستے ہیں، نمو کم کرتے ہیں۔ کنٹرول: امیڈاکلوپریڈ\n\n<b> بیماریاں</b>\n- لیف بلیٹ: پتوں پر بھوری دھبے۔ کنٹرول: فنگسائیڈ لگائیں\n- رسٹ: پتوں پر نارنجی یا بھوری پاؤڈر۔ کنٹرول: مزاحم اقسام اور فنگسائیڈ سپرے\n- ڈاؤنی میلڈیو: پیلے پن اور بوجھل پودے۔ کنٹرول: بونے سے پہلے بیج کا علاج"],
      ['فصل کاٹنے کا وقت', "<b>کٹائی کا وقت</b>\n- 90 سے 120 دن بعد بونے کے\n\n<b>کٹائی کے اشارے</b>\n- بھوسے خشک ہو جائیں\n- دانے سخت ہو جائیں\n- نمی تقریباً 20 سے 25%"],
    ],
  ],
],

// ── RICE ───────────────────────────────────────────────────
'rice' => [
  'english' => [
    'title' => 'Rice Crop Information',
    'sections' => [
      ['Introduction', "Rice is one of the world's most important cereal crops and a staple food for more than half of the global population. It belongs to the grass family. Rice farming is traditionally practiced in regions with high rainfall or where controlled irrigation is available.\n\n<b><u>Key Characteristics of Rice:</u></b>\nGrows best in standing water (paddy conditions).\nPlant height varies between 80 to 150 cm, depending on variety.\nHas a slender stem, long leaves, and a grain-bearing panicle.\nIts root system is fibrous, enabling it to survive in partially flooded fields.\n\n<b><u>Global Importance:</u></b>\nRice production exceeds 700 million tons globally.\nMain producers: China, India, Bangladesh, Vietnam, Thailand, Pakistan.\nIt is a major traded commodity and essential for food security.\n\n<b><u>Why Rice Is Important for Farmers:</u></b>\nHigh demand in both local and export markets.\nStable income source.\nSuitable for areas with abundant water.\nBy-products (bran, husk, straw) are also valuable."],
      ['Climate Requirement', "Rice is a tropical and subtropical crop that needs warm, moist conditions.\n\n<b><u>Temperature:</u></b>\nGermination: 16 to 40°C (optimum 25 to 35°C)\nTillering stage: 25 to 30°C\nReproductive stage: 20 to 25°C\nGrain filling: 20 to 30°C\nCold sensitivity: Below 18°C slows growth\n\n<b><u>Rainfall & Humidity:</u></b>\nRequires 1,000 to 2,000 mm of rainfall annually.\nBest humidity: 60 to 80%\nHigh humidity helps in photosynthesis and grain filling.\n\n<b><u>Sunlight:</u></b>\nRice requires 4 to 5 hours of direct sunlight daily.\nCloudy weather during flowering can reduce grain formation."],
      ['Soil Requirement', "Rice grows best in soils that can retain water.\n\n<b><u>Best Soil Types:</u></b>\nClay soil: excellent for water retention\nClay loam: good fertility and moisture holding\nSilty loam: supports strong vegetative growth\n\n<b><u>Soil pH</u></b>:\nIdeal pH: 5.5 to 7.0\nSlightly acidic soils are preferred.\n\n<b><u>Important Soil Properties:</u></b>\nSoil should be deep for strong roots.\nShould contain high organic matter.\nGood water retention is crucial for paddy conditions.\n\n<b><u>Soil Preparation:</u></b>\nFirst plowing to break clods\nFlooding of field\nPuddling (mixing soil and water to make a soft, level base)\nLevelling to ensure uniform water depth"],
      ['Sowing Time', "Rice can be grown through:\n\n<b>A.<u> Nursery </u>(Transplanting Method):</b>\nMost common method in Pakistan and Asia.\n\n<b><u>Sowing Time </u>(Kharif Season):</b>\nPunjab: May to June\nSindh: June to July\n\n<b><u>Nursery Duration:</u></b>\nSeedlings are raised for 25 to 30 days, then transplanted.\n\n<b>B.<u> Direct Seeding:</u></b>\nSeeds are sown directly into the field (either dry or wet seeding).\n\n<b><u>Advantages:</u></b>\nSaves labor\nFaster sowing\n\n<b><u>Seed Rate:</u></b>\nTransplanting: 5 to 8 kg/acre\nDirect seeding: 12 to 15 kg/acre"],
      ['Fertilizer Schedule', "Rice needs N (Nitrogen), P (Phosphorus), K (Potassium) in large amounts.\n\n<b><u>Recommended Dose</u> (General):</b>\nNitrogen (Urea): 100 to 150 kg/acre\nPhosphorus (DAP): 20 to 30 kg/acre\nPotassium (SOP or MOP): 20 to 25 kg/acre\nZinc Sulfate: 10 to 12 kg/acre (essential for tillering)\n\n<b><u>Application Schedule:</u></b>\n1. Basal Dose (before transplanting):\nDAP + SOP\nHalf dose of urea\n\n2. Tillering Stage (25 to 30 days after transplanting):\n25% urea\n\n3. Panicle Initiation Stage (45 to 55 days after transplanting):\nRemaining 25% urea\n\n<b><u>Why Fertilizer is Important?</u></b>\nNitrogen increases tillers (more branches)\nPhosphorus helps strong roots\nPotassium improves grain filling and disease resistance"],
      ['Weeds, Pests and Diseases', "<b>A.<u> Common Weeds:</u></b>\nCyperus rotundus (Dela)\nWater grass\nBarnyard grass\n\n<b><u>Weed Control:</u></b>\nPre-emergence herbicides (e.g., Butachlor)\nManual weeding\nMaintaining water level to suppress weeds\n\n<b>B.<u> Major Pests:</u></b>\nStem Borer: Whitish caterpillar that bores into stems. Damage: dead hearts, whiteheads\nLeaf Folder: Rolls leaves and feeds inside\nBrown Plant Hopper (BPH): Sucks sap, causes 'hopper burn'\n\n<b><u>Pest Control:</u></b>\nSpray Carbofuran, Imidacloprid, or Fipronil depending on pest\nMaintain water drainage to control BPH\n\n<b>C.<u> Major Diseases:</u></b>\nBlast Disease\nSheath Blight\nBacterial Leaf Blight (BLB)\n\n<b><u>Disease Control:</u></b>\nUse resistant varieties\nProper drainage\nFungicides: Tricyclazole, Propiconazole\nAvoid excessive nitrogen"],
      ['Harvesting', "<b><u>When to Harvest:</u></b>\nRice is ready for harvest when:\nGrains become golden yellow\nMoisture content is 20 to 24%\n80 to 90% grains are mature"],
    ],
  ],
  'urdu' => [
    'title' => 'چاول کی فصل کی  معلومات',
    'sections' => [
      ['تعارف', "چاول دنیا کی سب سے اہم غذائی اناج میں سے ایک ہے اور عالمی آبادی کے نصف سے زیادہ کے لیے بنیادی غذا ہے۔ یہ گھاس کے خاندان سے تعلق رکھتا ہے۔ چاول کی کاشت عام طور پر ان علاقوں میں کی جاتی ہے جہاں بارش زیادہ ہو یا پانی کی منظم آبپاشی دستیاب ہو۔"],
      ['چاول کی اہم خصوصیات', " کھڑے پانی (پڈی) میں بہترین نشوونما پاتا ہے۔\nپودے کی اونچائی 80 تا 150 سینٹی میٹر ہوتی ہے۔\nپتلا تنہ، لمبے پتے اور دانے والے پودے کی شاخیں ہوتی ہیں۔\n ریشے دار جڑیں جو پانی میں بھی زندہ رہ سکتی ہیں۔"],
      ['عالمی اہمیت', "عالمی سطح پر چاول کی سالانہ پیداوار 700 ملین ٹن سے زیادہ ہے۔ اہم پیدا کرنے والے ممالک: چین، بھارت، بنگلہ دیش، ویتنام، تھائی لینڈ، پاکستان۔ یہ ایک بڑی تجارتی فصل ہے اور غذائی تحفظ کے لیے ضروری ہے۔"],
      ['کسانوں کے لیے اہمیت', "مقامی اور برآمدی منڈیوں میں زیادہ طلب۔\nمستحکم آمدنی کا ذریعہ۔\n زیادہ پانی والے علاقوں کے لیے موزوں۔\n بھوسہ، چھلکا اور تنکے سمیت ذیلی مصنوعات بھی قیمتی ہیں۔"],
      ['موسمی تقاضے', "<b>درجہ حرارت</b><br/>\nاگنا:16 تا 40 سینٹی گریڈ\nٹلرنگ: 25 تا   30 سینٹی گریڈ\nتولیدی مرحلہ: 20 تا 25 سینٹی گریڈ\nدانے بھرنا: 20 تا 30 سینٹی گریڈ\nسردی حساسیت: 18سینٹی گریڈ سے کم ہونے پر نشوونما متاثر ہوتی ہے۔\n\n<b>بارش اور نمی</b><br/>\nسالانہ 1000 تا 2000 ملی میٹر بارش ضروری ہے ۔<br/>\n<b>روشنی</b><br/>\nروزانہ 4 تا 5 گھنٹے دھوپ ضروری ہے۔"],
      ['مٹی کے تقاضے', "<b>مٹیلی زمین بہترین۔</b><br/>\nمٹیلی دوڑ مناسب۔\nریتیلی دوڑ مضبوط سبزہ واری کے لیے اچھی۔\n\nپی ایچ: 5.5- 7.0\n\n<b>مٹی کی تیاری</b><br/>\nہل چلانا، کھیت میں پانی بھرنا، پلنگ کرنا اور سطح ہموار کرنا۔"],
      ['بونے کا وقت', "<b>نرسری طریقہ</b><br/>\nپنجاب: مئی تا جون\nسندھ: جون تا جولائی\nنرسری مدت: 25 تا 30 دن\nبیج مقدار: 5 تا 8 کلو فی ایکڑ\n\n<b>براہ راست بونا</b><br/>\nمحنت کم، تیز بونا\nبیج مقدار: 12 تا 15 کلو فی ایکڑ"],
      ['کھادوں کا شیڈول', "نائٹروجن: 100 تا 150 کلو فی ایکڑ\nفاسفورس: 20 تا 30 کلو فی ایکڑ\nپوٹاشیم: 20 تا 25 کلو فی ایکڑ\nزنک: 10 تا 12 کلو فی ایکڑ\n\n<b>شیڈول</b><br/>\nبیسل: ڈی-اے-پی+ ایس-او-پی + آدھی یوریا\nٹلرنگ: 25٪ یوریا\nپینیکل: باقی 25٪ یوریا"],
      ['جڑی بوٹیاں، کیڑے اور بیماریاں', "<b>جڑی بوٹیاں</b><br/>\n ڈیلا، واٹر گراس، بارن یارڈ گراس<br/>\n<b>جڑی بوٹیوں کا کنٹرول</b><br/>\nبوائی کے فوراً بعد پری ایمرجنس گھاس مار ادویات کا استعمال (جیسے بوٹا کلور)\nروایتی ہاتھ سے گوڈی یا نکائی\nکھیت میں مناسب پانی کی سطح برقرار رکھنا تاکہ جڑی بوٹیاں دب جائیں<br/>\n<b>بڑے نقصان دہ کیڑے</b><br/>\n<b>اسٹیم بوّر (تنے کا کیڑا)</b><br/>\nیہ سفید رنگ کا سنڈا تنا چیر کر اندر داخل ہو جاتا ہے"],
      ['فصل کاٹنے کا وقت', "دانے سنہری ہو جائیں، نمی 20 تا 24٪ ہو، اور 80 تا 90٪ دانے پک جائیں تو فصل تیار ہوتی ہے۔"],
    ],
  ],
],

// ── POTATO ─────────────────────────────────────────────────
'potato' => [
  'english' => [
    'title' => 'Potato Crop Information',
    'sections' => [
      ['Introduction', "Potato is one of the most important food crops in the world. It belongs to the Solanaceae family, which also includes tomato, chili, and eggplant. Potatoes are grown for their underground stems called tubers, which are rich in carbohydrates, vitamins, and minerals.\n\n<b><u>Key Characteristics of Potato:</u></b>\nGrows best in cool climates.\nPlant height generally 60 to 100 cm depending on variety.\nHas compound green leaves arranged spirally.\nTubers grow underground on stolons, not roots.\nShallow root system (80 to 120 cm).\n\n<b><u>Global Importance:</u></b>\nWorld production: More than 375 million tons annually.\nMajor producers: China, India, Russia, Ukraine, USA, Germany.\nPotatoes are the 4th most consumed food crop after rice, wheat, and maize.\n\n<b><u>Importance for Farmers:</u></b>\nHigh demand in markets and processing factories (chips, fries).\nShort duration crop (70 to 120 days).\nHigh yield per acre compared to other vegetables.\nCan be grown in many soil types and climates."],
      ['Climate Requirement', "Potatoes require cool, moist climatic conditions for best performance.\n\n<b><u>Temperature:</u></b>\nIdeal sprouting temperature: 15 to 20°C\nVegetative growth: 18 to 24°C\nTuber formation: 15 to 20°C\nPoor growth above: 30°C\nFrost can damage young plants.\n\n<b><u>Rainfall & Humidity:</u></b>\nTotal requirement: 500 to 700 mm during the crop cycle.\nHumidity: 60 to 80%\nHigh humidity encourages diseases, so ventilation is important.\n\n<b><u>Sunlight:</u></b>\nPotato requires 6 to 7 hours of sunlight per day.\nCloudy weather during tuber development reduces yield.\n\n<b><u>Wind:</u></b>\nStrong winds can damage potato foliage and reduce photosynthesis."],
      ['Soil Requirement', "Potatoes grow best in soils that are loose, fertile, and well-drained.\n\n<b><u>Best Soil Types:</u></b>\nSandy loam (ideal)\nLoam\nSilt loam\n\n<b><u>Soil pH:</u></b>\nIdeal pH: 5.2 to 6.5\nSlightly acidic soils reduce scab disease.\n\n<b><u>Important Soil Properties:</u></b>\nSoil must not be compact.\nShould be rich in organic matter.\nShould not have stones.\nMust hold moisture but not become waterlogged.\n\n<b><u>Soil Preparation:</u></b>\nDeep ploughing to break hardpan.\nApply 8 to 10 tons/acre well-decomposed farmyard manure.\nUse rotavator to make fine tilth.\nCreate raised beds or ridges.\nEnsure level land."],
      ['Sowing Time', "<b><u>Ideal Sowing Seasons:</u></b>\nAutumn to Winter Crop: October to December\nSpring Crop: January to February\n\n<b><u>Seed Tubers:</u></b>\nUse certified, disease-free tubers.\nWeight: 30 to 50 grams each.\nSprout length: 1 to 2 cm.\nCut large tubers and dry 24 hours.\n\n<b><u>Seed Rate:</u></b>\n700 to 1000 kg per acre.\n\n<b><u>Planting Method:</u></b>\nPlant 7 to 10 cm deep.\nRow spacing: 60 to 70 cm.\nPlant spacing: 20 to 25 cm.\nSprouts must face upward."],
      ['Fertilizer Schedule', "<b><u>Recommended Fertilizer Dose</u> (per acre):</b>\nUrea: 50 to 60 kg\nDAP: 45 to 50 kg\nPotash: 25 to 30 kg\nZinc Sulfate: 5 to 10 kg\nGypsum: 20 to 25 kg\nOrganic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\nBasal Dose: Full DAP, SOP, Zinc, Half Urea, Gypsum\nAfter 25-30 days: 25% Urea\nAfter 40-45 days: Remaining 25% Urea\n\n<b><u>Importance:</u></b>\nNitrogen: foliage growth\nPhosphorus: root development\nPotassium:tuber quality\nZinc: prevents stunted growth"],
      ['Weeds, Pests and Diseases', "<b><u>Weeds:</u></b>\nBathu, Dela, Wild mustard, Grasses\n<b>Control:</b> weeding + Metribuzin\n\n<b>Pests:</b>\nAphids:Imidacloprid\nCutworms:Chlorpyrifos\nWhiteflies: Thiamethoxam\n\n<b><u>Diseases:</u></b>\nLate Blight:Mancozeb, Ridomil\nEarly Blight: Mancozeb\nCommon Scab: moisture control"],
      [' Harvesting', "Harvest after 90 to 120 days.\nWhen vines turn yellow."],
    ],
  ],
  'urdu' => [
    'title' => 'آلو کی فصل کی معلومات',
    'sections' => [
      ['تعارف', "آلو دنیا کی سب سے اہم غذائی فصلوں میں سے ایک ہے۔ یہ سولانیسی خاندان سے تعلق رکھتا ہے جس میں ٹماٹر، مرچ اور بینگن بھی شامل ہیں۔ آلو زمین کے اندر اگنے والے تنوں جنہیں ٹبر (گانٹھیں) کہا جاتا ہے کے لیے کاشت کیا جاتا ہے، جو کاربوہائیڈریٹس، وٹامنز اور معدنیات سے بھرپور ہوتے ہیں۔"],
      ['موسمی تقاضے', "آلو کی بہترین پیداوار کے لیے ٹھنڈا اور مرطوب موسم ضروری ہوتا ہے۔\n\n<b>درجہ حرارت</b>\nاگاؤ کے لیے مثالی درجہ حرارت: 15 سے 20 ڈگری سینٹی گریڈ\nنشوونما کے لیے: 18 سے 24 ڈگری سینٹی گریڈ\nگانٹھ بننے کے لیے: 15 سے 20 ڈگری سینٹی گریڈ\n30 ڈگری سے زیادہ پر نشوونما متاثر ہوتی ہے\nپالا کم عمر پودوں کو نقصان پہنچا سکتا ہے"],
      ['مٹی کے تقاضے', "آلو کے لیے ڈھیلی، زرخیز اور اچھی نکاسی والی مٹی بہترین ہوتی ہے۔\n\n<b>بہترین مٹی کی اقسام</b>\nریتلی دوامی (سب سے بہتر)\nدوامی\nسلٹ دوامی\n\nپی ایچ: 5.2 سے 6.5 بہترین ہے"],
      ['بونے کا وقت', "<b>بوائی کے موزوں اوقات</b>\nاکتوبر سے دسمبر (اہم فصل)\nجنوری سے فروری (بہار کی فصل)\n\n<b>بیج گانٹھیں</b>\nمصدقہ اور بیماری سے پاک گانٹھیں استعمال کریں\nوزن: 30 سے 50 گرام\nانکر کی لمبائی: 1 سے 2 سینٹی میٹر"],
      ['کھادوں کا شیڈول', "<b>فی ایکڑ کھاد کی مقدار</b>\nیوریا: 50 سے 60 کلوگرام\nڈی اے پی: 45 سے 50 کلوگرام\nپوٹاش: 25 سے 30 کلوگرام\nزنک سلفیٹ: 5 سے 10 کلوگرام\nجپسم: 20 سے 25 کلوگرام\nنامیاتی کھاد: 8 سے 10 ٹن"],
      ['جڑی بوٹیاں، کیڑے اور بیماریاں', "<b>جڑی بوٹیاں</b>\nباتھو \nڈیلا \nجنگلی سرسوں\nگھاس\n\n<b>کیڑے</b>\nایفڈز: رس چوستے ہیں → پودا کمزور\nکنٹرول: امیڈاکلوپرڈ\n\nکٹ ورمز: تنے کو کاٹ دیتے ہیں\nکنٹرول: کلورپائریفوس"],
      ['فصل کاٹنے کا وقت', "جب پتے پیلے اور خشک ہو جائیں"],
    ],
  ],
],

// ── WHEAT ──────────────────────────────────────────────────
'wheat' => [
  'english' => [
    'title' => 'Wheat Crop Information',
    'sections' => [
      ['Introduction', "Wheat is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes rice, maize, and barley. Wheat is primarily grown for its grains, which are used to produce flour for bread, chapati, pasta, and many other food products.\n\n<b><u> Key Characteristics of Wheat</u></b>\n Cool-season crop (Rabi crop)\n Plant height: 60 to 120 cm (varies by variety)\nStem: hollow (except nodes)\n Leaves: long, narrow, and green\nRoot system: fibrous and moderately deep\nGrain: rich in carbohydrates, protein (gluten), vitamins, and minerals\n\n<b><u> Global Importance</u></b>\n One of the top 3 staple crops (with rice and maize)\n Annual global production: 750+ million tons\n Major producers: China, India, Russia, USA, France, Canada\n Staple food for over 35% of the world population\n\n <b><u>Importance for Farmers</u></b>\n High demand in local and global markets\n Essential food crop in Pakistan\nEasy to store compared to vegetables\n Mechanized farming possible\n Stable income crop"],
      ['Climate Requirement', "Wheat grows best in cool and dry climates.\n\n <b><u>Temperature</u></b>\n Germination: 12 to 25°C\n Tillering stage: 16 to 20°C\n Grain filling: 20 to 25°C\n Above 30°C during grain filling → reduces yield\n Frost can damage crop at flowering stage\n\n<b><u> Rainfall & Moisture</u></b>\n Total requirement: 300–500 mm\n Needs moisture during early growth and grain filling\n Excess rain → lodging and disease risk\n\n <b><u>Sunlight</u></b>\n Requires bright sunlight\n Clear weather during grain filling improves grain quality\n\n<b><u> Wind</u></b>\n Strong winds can cause lodging (plants fall down)"],
      ['Soil Requirement', "Wheat can grow in various soils but performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types</u></b>\nLoam (ideal)\n Clay loam\nSilt loam\n\n<b><u> Soil pH</u></b>\n Ideal range: 6.0 to 7.5\n\n <b><u>Important Soil Properties</u></b>\n Good drainage (no waterlogging)\n Moderate water-holding capacity\n Rich in organic matter\n Level field for uniform irrigation\n\n<b><u> Soil Preparation</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and previous crop residues\n Apply farmyard manure (5 to 8 tons/acre)\n Level land properly (laser leveling is best)"],
      [' Sowing Time', " <b><u>Ideal Sowing Time </u></b>\n Punjab & Sindh: 15 October to 30 November (best)\nLate sowing → lower yield\n\n <b><u>Seed Selection</u></b>\n Use certified, disease-free seeds\n Popular varieties:\n  Faisalabad-2008\n  Galaxy-2013\n  Punjab-2011\n\n <b><u>Seed Rate</u></b>\n 40 to 50 kg per acre\n\n <b><u>Sowing Method</u></b>\n Drill method (recommended)\n Row spacing: 9 to 12 inches\n Depth: 3 to 5 cm"],
      ['5. Fertilizer Schedule', "Wheat requires balanced nutrients for high yield.\n\n <b><u>Recommended Dose </u>(Per Acre)</b>\nFertilizer\n Urea: 80 to 100 kg\n DAP: 50 kg\nPotash (SOP/MOP): 25 to 30 kg\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 5 to 8 tons\n\n <b><u>Application Schedule</u></b>\n1. Basal Dose (At Sowing)\nFull DAP\nFull Potash\n Half Urea\n Zinc\n\n2. First Irrigation (20 to 25 Days)\n 25% Urea\n\n3. Second Irrigation (40 to 45 Days)\n Remaining 25% Urea\n\n<b><u> Nutrient Importance</u></b>\n Nitrogen: Leaf growth, tillering\nPhosphorus: Root development\n Potassium: Strength, disease resistance\n Zinc: Better grain formation"],
      ['6. Weeds, Pests and Diseases', "<b>A.<u> Weeds</u></b>\n Common Weeds\n Bathu (Chenopodium)\nWild oats (Jangli jai)\n Dela (Cyperus)\n Broadleaf weeds\n\n<b><u>Control</u></b>\nWeeding at 20 to 30 days\n Chemical control:\n  Isoproturon\n  Topik\n  Puma Super\n\n<b>B.<u> Pests</u></b>\n Aphids\n Damage: Sap sucking → weak plants\n Control: Imidacloprid\n\n Termites\n Damage: Attack roots and stems\n Control: Chlorpyrifos\n\n<b>C.<u> Diseases</u></b>\n Rust (Zang)\nTypes:\n Leaf rust\n Stem rust\n Stripe rust\n\nCause: Puccinia species\n\nSymptoms:\n Orange/yellow powder on leaves\n Reduced grain filling\n\nControl:\n Resistant varieties\n Fungicide spray (Tilt, Score)\n\n Smut\nBlack powder in grains\nControl: Seed treatment before sowing\n\n Powdery Mildew\n White powder on leaves\nControl: Fungicide spray"],
      ['7. Harvesting', " <b><u>Harvesting Time</u></b>\n April – May\n\n <b><u>When:</u></b>\n Crop turns golden yellow\n Grains become hard\n Moisture content ~12 to 14%"],
    ],
  ],
  'urdu' => [
    'title' => 'گندم کی فصل کی معلومات',
    'sections' => [
      ['تعارف', "گندم دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوئیسی خاندان سے تعلق رکھتی ہے، جس میں چاول، مکئی اور جو شامل ہیں۔ گندم بنیادی طور پر اس کے دانوں کے لیے اگائی جاتی ہے، جن سے آٹا، روٹی، چپاتی، پاستا اور دیگر غذائی مصنوعات تیار کی جاتی ہیں۔"],
      ['موسمی تقاضے', "گندم ٹھنڈے اور خشک موسم میں بہترین اگتی ہے۔\n\n <b>درجہ حرارت</b>\n اگاؤ: 12 سے 25 ڈگری سینٹی گریڈ\n ٹلرنگ مرحلہ: 16 سے 20 ڈگری سینٹی گریڈ\n دانہ بھرنے کا مرحلہ: 20 سے 25 ڈگری سینٹی گریڈ"],
      ['مٹی کے تقاضے', "گندم مختلف اقسام کی مٹی میں اگ سکتی ہے لیکن زرخیز اور اچھی نکاسی والی مٹی میں بہترین پیداوار دیتی ہے۔\n\n <b>بہترین مٹی کی اقسام</b>\n میرا  — سب سے بہتر\n چکنی میرا \n سلٹی میرا"],
      ['بونے کا وقت', "<b> موزوں کاشت کا وقت</b>\n پنجاب اور سندھ: 15 اکتوبر سے 30 نومبر (بہترین)\n دیر سے کاشت کرنے سے پیداوار کم ہو جاتی ہے\n\n<b>بیج کا انتخاب</b>\n تصدیق شدہ اور بیماری سے پاک بیج استعمال کریں"],
      ['کھادوں کا شیڈول', "گندم کو زیادہ پیداوار کے لیے متوازن غذائی اجزاء درکار ہوتے ہیں۔\n\n <b>سفارش کردہ مقدار (فی ایکڑ)</b>\n یوریا: 80 سے 100 کلوگرام\n ڈی اے پی: 50 کلوگرام\n پوٹاش (SOP/MOP): 25 سے 30 کلوگرام"],
      ['جڑی بوٹیاں، کیڑے اور بیماریاں', "<b> جڑی بوٹیاں</b>\n عام جڑی بوٹیاں\n- باتھو \nجنگلی جئی \n- ڈیلا \n- چوڑی پتوں والی جڑی بوٹیاں\n\n <b>کنٹرول</b>\nگوڈی 20سے30دن میں کریں\n<b> کیڑے</b>\n ایفڈز\n- نقصان: رس چوس کر پودوں کو کمزور کرتے ہیں\n دیمک\n- نقصان: جڑوں اور تنوں پر حملہ کرتے ہیں"],
      ['فصل کاٹنے کا وقت', "  اپریل سے مئی\nفصل سنہری پیلی ہو جائے\nدانے سخت ہو جائیں\n نمی تقریباً 12 سے 14 فیصد ہو"],
    ],
  ],
],

]; // end $cropDetails

$stmt = $conn->prepare("INSERT INTO `crop_details` (crop,lang,title,section_order,heading,content) VALUES (?,?,?,?,?,?)");
$stmt->bind_param('sssiss', $crop,$lang,$title,$ord,$heading,$content);

foreach ($cropDetails as $crop => $langGroups) {
    foreach ($langGroups as $lang => $group) {
        $title = $group['title'];
        foreach ($group['sections'] as $idx => $sec) {
            $ord     = $idx + 1;
            $heading = $sec[0];
            $content = $sec[1];
            if ($stmt->execute()) {
                $success[] = "OK: Seed crop_details $crop/$lang section " . ($idx+1);
            } else {
                $errors[] = "FAIL (crop_details $crop/$lang s".($idx+1)."): " . $stmt->error;
            }
        }
    }
}
$stmt->close();

// Fix link_page to .php in case DB was seeded with old .html values
$conn->query("UPDATE crop_info SET link_page='rice.php'   WHERE link_page='rice.html'");
$conn->query("UPDATE crop_info SET link_page='potato.php' WHERE link_page='potato.html'");
$conn->query("UPDATE crop_info SET link_page='wheat.php'  WHERE link_page='wheat.html'");
$conn->query("UPDATE crop_info SET link_page='maize.php'  WHERE link_page='maize.html'");
$success[] = "OK: link_page .html → .php migration";

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
  <h1>FarmEase Database Setup</h1>
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
