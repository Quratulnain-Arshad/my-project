-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 09:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmease`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`) VALUES
(5, 'admin', '$2y$10$uxmzqC4pM1S/UZ7JZVkj.uqiMA0U7h8oAB7xI5ZIhlOj5iXlyOp82');

-- --------------------------------------------------------

--
-- Table structure for table `agri_cost`
--

CREATE TABLE `agri_cost` (
  `id` int(11) NOT NULL,
  `crop_key` varchar(20) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `name_ur` varchar(255) DEFAULT NULL,
  `desc_en` varchar(255) DEFAULT NULL,
  `desc_ur` varchar(255) DEFAULT NULL,
  `details_en` text DEFAULT NULL,
  `details_ur` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agri_cost`
--

INSERT INTO `agri_cost` (`id`, `crop_key`, `name_en`, `name_ur`, `desc_en`, `desc_ur`, `details_en`, `details_ur`) VALUES
(1, 'wheat', 'Wheat', 'گندم', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', '<b> Wheat</b>\nTotal Estimated Cost: 55,000 – 70,000 PKR\n\n<b>Breakdown:</b>\nSeed: 4,000 – 6,000\nLand preparation: 6,000 – 8,000\nFertilizer: 18,000 – 25,000\nIrrigation: 5,000 – 8,000\nSpray: 3,000 – 5,000\nLabor: 5,000 – 7,000\nHarvesting: 8,000 – 12,000\n\nYield: 35 – 45 Maund\nRate: 3,000 – 3,500\nIncome: 105,000 – 150,000\nProfit: 40,000 – 80,000\n\nLow cost, low risk, stable crop', ' <b>گندم</b>\nکل تخمینی لاگت: 55,000 – 70,000 روپے\n\n<b>تفصیل</b>\nبیج: 4,000 – 6,000\nزمین کی تیاری: 6,000 – 8,000\nکھاد: 18,000 – 25,000\nآبپاشی: 5,000 – 8,000\nاسپرے: 3,000 – 5,000\nمزدوری: 5,000 – 7,000\nکٹائی: 8,000 – 12,000\n\nپیداوار: 35 – 45 من\nریٹ: 3,000 – 3,500\nآمدن: 105,000 – 150,000\nمنافع: 40,000 – 80,000\n\nکم لاگت، کم خطرہ، مستحکم فصل'),
(2, 'maize', 'Maize', 'مکئی', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', '<b>Maize</b>\nTotal Estimated Cost: 65,000 – 85,000 PKR\n\n<b>Breakdown:</b>\nHybrid Seed: 8,000 – 12,000\nLand preparation: 6,000 – 8,000\nFertilizer: 20,000 – 28,000\nIrrigation: 6,000 – 10,000\nSpray: 4,000 – 7,000\nLabor: 5,000 – 8,000\nHarvesting: 8,000 – 12,000\n\nYield: 60 – 100 Maund\nRate: 2,200 – 2,800\nIncome: 130,000 – 220,000\nProfit: 60,000 – 130,000\n\nModerate investment, good profit', ' <b>مکئی</b>\nکل تخمینی لاگت: 65,000 – 85,000 روپے\n\n<b>تفصیل</b>\nہائبرڈ بیج: 8,000 – 12,000\nزمین کی تیاری: 6,000 – 8,000\nکھاد: 20,000 – 28,000\nآبپاشی: 6,000 – 10,000\nاسپرے: 4,000 – 7,000\nمزدوری: 5,000 – 8,000\nکٹائی: 8,000 – 12,000\n\nپیداوار: 60 – 100 من\nریٹ: 2,200 – 2,800\nآمدن: 130,000 – 220,000\nمنافع: 60,000 – 130,000\n\nدرمیانی سرمایہ، اچھا منافع'),
(3, 'potato', 'Potato', 'آلو', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', ' <b>Potato</b>\nTotal Estimated Cost: 120,000 – 160,000 PKR\n<b>Breakdown:</b>\nSeed: 60,000 – 90,000\nLand preparation: 8,000 – 10,000\nFertilizer: 20,000 – 30,000\nIrrigation: 8,000 – 12,000\nSpray: 6,000 – 10,000\nLabor: 10,000 – 15,000\nHarvesting: 10,000 – 15,000\n\nYield: 250 – 350 Maund\nRate: 1,500 – 2,500\nIncome: 375,000 – 875,000\nProfit: 200,000 – 600,000\n\nHigh profit, high investment', '<b> آلو</b>\nکل تخمینی لاگت: 120,000 – 160,000 روپے\n\n<b>تفصیل</b>\nبیج: 60,000 – 90,000\nزمین کی تیاری: 8,000 – 10,000\nکھاد: 20,000 – 30,000\nآبپاشی: 8,000 – 12,000\nاسپرے: 6,000 – 10,000\nمزدوری: 10,000 – 15,000\nکٹائی: 10,000 – 15,000\n\nپیداوار: 250 – 350 من\nریٹ: 1,500 – 2,500\nآمدن: 375,000 – 875,000\nمنافع: 200,000 – 600,000\n\nزیادہ منافع، زیادہ سرمایہ'),
(4, 'rice', 'Rice', 'چاول', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', '<b>Rice</b>\nTotal Estimated Cost: 70,000 – 100,000 PKR\n\n<b>Breakdown:</b>\nNursery + Seed: 4,000 – 7,000\nLand preparation: 8,000 – 12,000\nFertilizer: 20,000 – 30,000\nIrrigation: 10,000 – 15,000\nSpray: 5,000 – 8,000\nLabor: 10,000 – 15,000\nHarvesting: 10,000 – 13,000\n\nYield: 50 – 70 Maund\nRate: 3,500 – 4,500\nIncome: 175,000 – 315,000\nProfit: 80,000 – 200,000\n\nHigh water & labor requirement', ' <b>چاول</b>\nکل تخمینی لاگت: 70,000 – 100,000 روپے\n\n<b>تفصیل</b>\nنرسری اور بیج: 4,000 – 7,000\nزمین کی تیاری: 8,000 – 12,000\nکھاد: 20,000 – 30,000\nآبپاشی: 10,000 – 15,000\nاسپرے: 5,000 – 8,000\nمزدوری: 10,000 – 15,000\nکٹائی: 10,000 – 13,000\n\nپیداوار: 50 – 70 من\nریٹ: 3,500 – 4,500\nآمدن: 175,000 – 315,000\nمنافع: 80,000 – 200,000\n\nزیادہ پانی اور محنت درکار');

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `name_en` varchar(100) DEFAULT '',
  `name_ur` varchar(100) DEFAULT '',
  `desc_en` text DEFAULT NULL,
  `desc_ur` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT '',
  `video_1` varchar(100) DEFAULT '',
  `video_2` varchar(100) DEFAULT '',
  `video_3` varchar(100) DEFAULT '',
  `video_4` varchar(100) DEFAULT '',
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `slug`, `name_en`, `name_ur`, `desc_en`, `desc_ur`, `thumbnail`, `video_1`, `video_2`, `video_3`, `video_4`, `sort_order`) VALUES
(1, 'rice', 'Rice', 'چاول', NULL, NULL, 'assets/rice-intro.jpeg', '', '', '', '', 1),
(2, 'potato', 'Potato', 'آلو', NULL, NULL, 'assets/potato-intro.jpeg', '', '', '', '', 2),
(3, 'wheat', 'Wheat', 'گندم', NULL, NULL, 'assets/image.jpeg', '', '', '', '', 3),
(4, 'maize', 'Maize', 'مکئی', NULL, NULL, 'assets/maize-intro.jpg', '', '', '', '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `crop_details`
--

CREATE TABLE `crop_details` (
  `id` int(11) NOT NULL,
  `crop` varchar(20) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `section_order` int(11) DEFAULT 0,
  `heading` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_details`
--

INSERT INTO `crop_details` (`id`, `crop`, `lang`, `title`, `section_order`, `heading`, `content`) VALUES
(1, 'rice', 'english', 'Rice Crop Information', 1, 'Introduction', 'Rice is one of the world’s most important cereal crops and a staple food for more than half of the global population. It belongs to the grass family. Rice farming is traditionally practiced in regions with high rainfall or where controlled irrigation is available.\n\n<b><u>Key Characteristics of Rice:</u></b>\nGrows best in standing water (paddy conditions).\nPlant height varies between 80 to 150 cm, depending on variety.\nHas a slender stem, long leaves, and a grain-bearing panicle.\nIts root system is fibrous, enabling it to survive in partially flooded fields.\n\n<b><u>Global Importance:</u></b>\nRice production exceeds 700 million tons globally.\nMain producers: China, India, Bangladesh, Vietnam, Thailand, Pakistan.\nIt is a major traded commodity and essential for food security.\n\n<b><u>Why Rice Is Important for Farmers:</u></b>\nHigh demand in both local and export markets.\nStable income source.\nSuitable for areas with abundant water.\nBy-products (bran, husk, straw) are also valuable.'),
(2, 'rice', 'english', 'Rice Crop Information', 2, 'Climate Requirement', 'Rice is a tropical and subtropical crop that needs warm, moist conditions.\n\n<b><u>Temperature:</u></b>\nGermination: 16 to 40°C (optimum 25 to 35°C)\nTillering stage: 25 to 30°C\nReproductive stage: 20 to 25°C\nGrain filling: 20 to 30°C\nCold sensitivity: Below 18°C slows growth\n\n<b><u>Rainfall & Humidity:</u></b>\nRequires 1,000 to 2,000 mm of rainfall annually.\nBest humidity: 60 to 80%\nHigh humidity helps in photosynthesis and grain filling.\n\n<b><u>Sunlight:</u></b>\nRice requires 4 to 5 hours of direct sunlight daily.\nCloudy weather during flowering can reduce grain formation.'),
(3, 'rice', 'english', 'Rice Crop Information', 3, 'Soil Requirement', 'Rice grows best in soils that can retain water.\n\n<b><u>Best Soil Types:</u></b>\nClay soil: excellent for water retention\nClay loam: good fertility and moisture holding\nSilty loam: supports strong vegetative growth\n\n<b><u>Soil pH</u></b>:\nIdeal pH: 5.5 to 7.0\nSlightly acidic soils are preferred.\n\n<b><u>Important Soil Properties:</u></b>\nSoil should be deep for strong roots.\nShould contain high organic matter.\nGood water retention is crucial for paddy conditions.\n\n<b><u>Soil Preparation:</u></b>\nFirst plowing to break clods\nFlooding of field\nPuddling (mixing soil and water to make a soft, level base)\nLevelling to ensure uniform water depth'),
(4, 'rice', 'english', 'Rice Crop Information', 4, 'Sowing Time', 'Rice can be grown through:\n\n<b>A.<u> Nursery </u>(Transplanting Method):</b>\nMost common method in Pakistan and Asia.\n\n<b><u>Sowing Time </u>(Kharif Season):</b>\nPunjab: May to June\nSindh: June to July\n\n<b><u>Nursery Duration:</u></b>\nSeedlings are raised for 25 to 30 days, then transplanted.\n\n<b>B.<u> Direct Seeding:</u></b>\nSeeds are sown directly into the field (either dry or wet seeding).\n\n<b><u>Advantages:</u></b>\nSaves labor\nFaster sowing\n\n<b><u>Seed Rate:</u></b>\nTransplanting: 5 to 8 kg/acre\nDirect seeding: 12 to 15 kg/acre'),
(5, 'rice', 'english', 'Rice Crop Information', 5, 'Fertilizer Schedule', 'Rice needs N (Nitrogen), P (Phosphorus), K (Potassium) in large amounts.\n\n<b><u>Recommended Dose</u> (General):</b>\nNitrogen (Urea): 100 to 150 kg/acre\nPhosphorus (DAP): 20 to 30 kg/acre\nPotassium (SOP or MOP): 20 to 25 kg/acre\nZinc Sulfate: 10 to 12 kg/acre (essential for tillering)\n\n<b><u>Application Schedule:</u></b>\n1. Basal Dose (before transplanting):\nDAP + SOP\nHalf dose of urea\n\n2. Tillering Stage (25 to 30 days after transplanting):\n25% urea\n\n3. Panicle Initiation Stage (45 to 55 days after transplanting):\nRemaining 25% urea\n\n<b><u>Why Fertilizer is Important?</u></b>\nNitrogen increases tillers (more branches)\nPhosphorus helps strong roots\nPotassium improves grain filling and disease resistance'),
(6, 'rice', 'english', 'Rice Crop Information', 6, 'Weeds, Pests and Diseases', '<b>A.<u> Common Weeds:</u></b>\nCyperus rotundus (Dela)\nWater grass\nBarnyard grass\n\n<b><u>Weed Control:</u></b>\nPre-emergence herbicides (e.g., Butachlor)\nManual weeding\nMaintaining water level to suppress weeds\n\n<b>B.<u> Major Pests:</u></b>\nStem Borer: Whitish caterpillar that bores into stems. Damage: dead hearts, whiteheads\nLeaf Folder: Rolls leaves and feeds inside\nBrown Plant Hopper (BPH): Sucks sap, causes \'hopper burn\'\n\n<b><u>Pest Control:</u></b>\nSpray Carbofuran, Imidacloprid, or Fipronil depending on pest\nMaintain water drainage to control BPH\n\n<b>C.<u> Major Diseases:</u></b>\nBlast Disease\nSheath Blight\nBacterial Leaf Blight (BLB)\n\n<b><u>Disease Control:</u></b>\nUse resistant varieties\nProper drainage\nFungicides: Tricyclazole, Propiconazole\nAvoid excessive nitrogen'),
(7, 'rice', 'english', 'Rice Crop Information', 7, 'Harvesting', '<b><u>When to Harvest:</u></b>\nRice is ready for harvest when:\nGrains become golden yellow\nMoisture content is 20 to 24%\n80 to 90% grains are mature'),
(8, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 1, 'تعارف', 'چاول دنیا کی سب سے اہم غذائی اناج میں سے ایک ہے اور عالمی آبادی کے نصف سے زیادہ کے لیے بنیادی غذا ہے۔ یہ گھاس کے خاندان سے تعلق رکھتا ہے۔ چاول کی کاشت عام طور پر ان علاقوں میں کی جاتی ہے جہاں بارش زیادہ ہو یا پانی کی منظم آبپاشی دستیاب ہو۔'),
(9, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 2, 'چاول کی اہم خصوصیات', ' کھڑے پانی (پڈی) میں بہترین نشوونما پاتا ہے۔\nپودے کی اونچائی 80 تا 150 سینٹی میٹر ہوتی ہے۔\nپتلا تنہ، لمبے پتے اور دانے والے پودے کی شاخیں ہوتی ہیں۔\n ریشے دار جڑیں جو پانی میں بھی زندہ رہ سکتی ہیں۔'),
(10, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 3, 'عالمی اہمیت', 'عالمی سطح پر چاول کی سالانہ پیداوار 700 ملین ٹن سے زیادہ ہے۔ اہم پیدا کرنے والے ممالک: چین، بھارت، بنگلہ دیش، ویتنام، تھائی لینڈ، پاکستان۔ یہ ایک بڑی تجارتی فصل ہے اور غذائی تحفظ کے لیے ضروری ہے۔'),
(11, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 4, 'کسانوں کے لیے اہمیت', 'مقامی اور برآمدی منڈیوں میں زیادہ طلب۔\nمستحکم آمدنی کا ذریعہ۔\n زیادہ پانی والے علاقوں کے لیے موزوں۔\n بھوسہ، چھلکا اور تنکے سمیت ذیلی مصنوعات بھی قیمتی ہیں۔'),
(12, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 5, 'موسمی تقاضے', '<b>درجہ حرارت</b><br/>\nاگنا:16 تا 40 سینٹی گریڈ\nٹلرنگ: 25 تا   30 سینٹی گریڈ\nتولیدی مرحلہ: 20 تا 25 سینٹی گریڈ\nدانے بھرنا: 20 تا 30 سینٹی گریڈ\nسردی حساسیت: 18سینٹی گریڈ سے کم ہونے پر نشوونما متاثر ہوتی ہے۔\n\n<b>بارش اور نمی</b><br/>\nسالانہ 1000 تا 2000 ملی میٹر بارش ضروری ہے ۔<br/>\n<b>روشنی</b><br/>\nروزانہ 4 تا 5 گھنٹے دھوپ ضروری ہے۔'),
(13, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 6, 'مٹی کے تقاضے', '<b>مٹیلی زمین بہترین۔</b><br/>\nمٹیلی دوڑ مناسب۔\nریتیلی دوڑ مضبوط سبزہ واری کے لیے اچھی۔\n\nپی ایچ: 5.5- 7.0\n\n<b>مٹی کی تیاری</b><br/>\nہل چلانا، کھیت میں پانی بھرنا، پلنگ کرنا اور سطح ہموار کرنا۔'),
(14, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 7, 'بونے کا وقت', '<b>نرسری طریقہ</b><br/>\nپنجاب: مئی تا جون\nسندھ: جون تا جولائی\nنرسری مدت: 25 تا 30 دن\nبیج مقدار: 5 تا 8 کلو فی ایکڑ\n\n<b>براہ راست بونا</b><br/>\nمحنت کم، تیز بونا\nبیج مقدار: 12 تا 15 کلو فی ایکڑ'),
(15, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 8, 'کھادوں کا شیڈول', 'نائٹروجن: 100 تا 150 کلو فی ایکڑ\nفاسفورس: 20 تا 30 کلو فی ایکڑ\nپوٹاشیم: 20 تا 25 کلو فی ایکڑ\nزنک: 10 تا 12 کلو فی ایکڑ\n\n<b>شیڈول</b><br/>\nبیسل: ڈی-اے-پی+ ایس-او-پی + آدھی یوریا\nٹلرنگ: 25٪ یوریا\nپینیکل: باقی 25٪ یوریا'),
(16, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 9, 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b>جڑی بوٹیاں</b><br/>\n ڈیلا، واٹر گراس، بارن یارڈ گراس<br/>\n<b>جڑی بوٹیوں کا کنٹرول</b><br/>\nبوائی کے فوراً بعد پری ایمرجنس گھاس مار ادویات کا استعمال (جیسے بوٹا کلور)\nروایتی ہاتھ سے گوڈی یا نکائی\nکھیت میں مناسب پانی کی سطح برقرار رکھنا تاکہ جڑی بوٹیاں دب جائیں<br/>\n<b>بڑے نقصان دہ کیڑے</b><br/>\n<b>اسٹیم بوّر (تنے کا کیڑا)</b><br/>\nیہ سفید رنگ کا سنڈا تنا چیر کر اندر داخل ہو جاتا ہے<br/>\nنقصان\nپودے کے درمیان سے خشک ہونااور خوشے سفید پڑ جانا <br/>\nلیف <b>فولڈر (پتی لپیٹنے والا کیڑا)</b><br/>\nپتی کو لپیٹ کر اندر سے کھاتا ہے<br/>\nنقصان\nپتی کا سبز حصہ بُری طرح متاثر ہوتا ہے<br/>\n<b>براؤن پلانٹ ہوپر </b><br/>\nپودے کا رس چوستا ہے<br/>\nنقصان\nزیادہ حملہ ہو تو پورا کھیت جھلس کر بھورا ہو جاتا ہے<br/>\n<b>کیڑوں کا کنٹرول</b><br/>\nکیڑے کی نوعیت کے مطابق کاربوفیوران، امیڈاکلوپرڈ یا فیپرونل کا سپرے<br/>\n <b>بڑی بیماریاں</b><br/>\n<b>بلاسٹ بیماری</b>\nپتوں پر دھبے، اور خوشے کے اوپر والے حصے پر نیک بلاسٹ \nپیداوار میں واضح کمی<br/>\n<b>شیٹھ بلائٹ</b>\nیہ فنگس پودے کے نچلے پتوں اور غلاف پر حملہ کرتی ہے\nپودا کمزور ہو جاتا ہے اور دانہ صحیح نہیں بنتا<br/>\n<b>بیکٹیریل لیف بلائٹ</b>\nپتوں کا پیلا ہونا، سرے سے خشک ہونا\nپودا قبل از وقت بوڑھا ہو جاتا ہے<br/>\n<b>بیماریوں کا کنٹرول</b>\nبیماریوں کے خلاف مزاحمت رکھنے والی اقسام کا استعمال\nکھیت میں پانی کی نکاسی بہتر رکھنا\nضرورت پڑنے پر ٹریسائکلوزول یا پروپیکونازول کا سپرے\nضرورت سے زیادہ نائٹروجن (یوریا) ہرگز نہ ڈالیں\n'),
(17, 'rice', 'urdu', 'چاول کی فصل کی  معلومات', 10, 'فصل کاٹنے کا وقت', 'دانے سنہری ہو جائیں، نمی 20 تا 24٪ ہو، اور 80 تا 90٪ دانے پک جائیں تو فصل تیار ہوتی ہے۔'),
(18, 'potato', 'english', 'Potato Crop Information', 1, 'Introduction', 'Potato is one of the most important food crops in the world. It belongs to the Solanaceae family, which also includes tomato, chili, and eggplant. Potatoes are grown for their underground stems called tubers, which are rich in carbohydrates, vitamins, and minerals.\n\n<b><u>Key Characteristics of Potato:</u></b>\nGrows best in cool climates.\nPlant height generally 60 to 100 cm depending on variety.\nHas compound green leaves arranged spirally.\nTubers grow underground on stolons, not roots.\nShallow root system (80 to 120 cm).\n\n<b><u>Global Importance:</u></b>\nWorld production: More than 375 million tons annually.\nMajor producers: China, India, Russia, Ukraine, USA, Germany.\nPotatoes are the 4th most consumed food crop after rice, wheat, and maize.\n\n<b><u>Importance for Farmers:</u></b>\nHigh demand in markets and processing factories (chips, fries).\nShort duration crop (70 to 120 days).\nHigh yield per acre compared to other vegetables.\nCan be grown in many soil types and climates.'),
(19, 'potato', 'english', 'Potato Crop Information', 2, 'Climate Requirement', 'Potatoes require cool, moist climatic conditions for best performance.\n\n<b><u>Temperature:</u></b>\nIdeal sprouting temperature: 15 to 20°C\nVegetative growth: 18 to 24°C\nTuber formation: 15 to 20°C\nPoor growth above: 30°C\nFrost can damage young plants.\n\n<b><u>Rainfall & Humidity:</u></b>\nTotal requirement: 500 to 700 mm during the crop cycle.\nHumidity: 60 to 80%\nHigh humidity encourages diseases, so ventilation is important.\n\n<b><u>Sunlight:</u></b>\nPotato requires 6 to 7 hours of sunlight per day.\nCloudy weather during tuber development reduces yield.\n\n<b><u>Wind:</u></b>\nStrong winds can damage potato foliage and reduce photosynthesis.'),
(20, 'potato', 'english', 'Potato Crop Information', 3, 'Soil Requirement', 'Potatoes grow best in soils that are loose, fertile, and well-drained.\n\n<b><u>Best Soil Types:</u></b>\nSandy loam (ideal)\nLoam\nSilt loam\n\n<b><u>Soil pH:</u></b>\nIdeal pH: 5.2 to 6.5\nSlightly acidic soils reduce scab disease.\n\n<b><u>Important Soil Properties:</u></b>\nSoil must not be compact.\nShould be rich in organic matter.\nShould not have stones.\nMust hold moisture but not become waterlogged.\n\n<b><u>Soil Preparation:</u></b>\nDeep ploughing to break hardpan.\nApply 8 to 10 tons/acre well-decomposed farmyard manure.\nUse rotavator to make fine tilth.\nCreate raised beds or ridges.\nEnsure level land.'),
(21, 'potato', 'english', 'Potato Crop Information', 4, 'Sowing Time', '<b><u>Ideal Sowing Seasons:</u></b>\nAutumn to Winter Crop: October to December\nSpring Crop: January to February\n\n<b><u>Seed Tubers:</u></b>\nUse certified, disease-free tubers.\nWeight: 30 to 50 grams each.\nSprout length: 1 to 2 cm.\nCut large tubers and dry 24 hours.\n\n<b><u>Seed Rate:</u></b>\n700 to 1000 kg per acre.\n\n<b><u>Planting Method:</u></b>\nPlant 7 to 10 cm deep.\nRow spacing: 60 to 70 cm.\nPlant spacing: 20 to 25 cm.\nSprouts must face upward.'),
(22, 'potato', 'english', 'Potato Crop Information', 5, 'Fertilizer Schedule', '<b><u>Recommended Fertilizer Dose</u> (per acre):</b>\nUrea: 50 to 60 kg\nDAP: 45 to 50 kg\nPotash: 25 to 30 kg\nZinc Sulfate: 5 to 10 kg\nGypsum: 20 to 25 kg\nOrganic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\nBasal Dose: Full DAP, SOP, Zinc, Half Urea, Gypsum\nAfter 25-30 days: 25% Urea\nAfter 40-45 days: Remaining 25% Urea\n\n<b><u>Importance:</u></b>\nNitrogen: foliage growth\nPhosphorus: root development\nPotassium:tuber quality\nZinc: prevents stunted growth'),
(23, 'potato', 'english', 'Potato Crop Information', 6, 'Weeds, Pests and Diseases', '<b><u>Weeds:</u></b>\nBathu, Dela, Wild mustard, Grasses\n<b>Control:</b> weeding + Metribuzin\n\n<b>Pests:</b>\nAphids:Imidacloprid\nCutworms:Chlorpyrifos\nWhiteflies: Thiamethoxam\n\n<b><u>Diseases:</u></b>\nLate Blight:Mancozeb, Ridomil\nEarly Blight: Mancozeb\nCommon Scab: moisture control'),
(24, 'potato', 'english', 'Potato Crop Information', 7, ' Harvesting', 'Harvest after 90 to 120 days.\nWhen vines turn yellow.'),
(25, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 1, 'تعارف', 'آلو دنیا کی سب سے اہم غذائی فصلوں میں سے ایک ہے۔ یہ سولانیسی خاندان سے تعلق رکھتا ہے جس میں ٹماٹر، مرچ اور بینگن بھی شامل ہیں۔ آلو زمین کے اندر اگنے والے تنوں جنہیں ٹبر (گانٹھیں) کہا جاتا ہے کے لیے کاشت کیا جاتا ہے، جو کاربوہائیڈریٹس، وٹامنز اور معدنیات سے بھرپور ہوتے ہیں۔\n\n<b>آلو کی اہم خصوصیات</b>\nٹھنڈے موسم میں بہترین نشوونما پاتا ہے۔\nپودے کی اونچائی عام طور پر 60 سے 100 سینٹی میٹر ہوتی ہے، جو قسم پر منحصر ہے۔\nسبز مرکب پتے ہوتے ہیں جو گھومتی ترتیب میں لگے ہوتے ہیں۔\nگانٹھیں جڑوں پر نہیں بلکہ اسٹولونز پر زمین کے اندر بنتی ہیں۔\nجڑوں کا نظام سطحی ہوتا ہے (80 سے 120 سینٹی میٹر)۔\n\n<b>عالمی اہمیت</b>\nدنیا میں سالانہ پیداوار 375 ملین ٹن سے زیادہ ہے۔\nبڑے پیدا کرنے والے ممالک: چین، بھارت، روس، یوکرین، امریکہ، جرمنی۔\nآلو دنیا کی چوتھی سب سے زیادہ استعمال ہونے والی فصل ہے (چاول، گندم اور مکئی کے بعد)۔\n\n<b>کسانوں کے لیے اہمیت</b>\nمارکیٹ اور پراسیسنگ فیکٹریوں (چپس، فرائز) میں زیادہ مانگ۔\nکم دورانیہ والی فصل (70 سے 120 دن)۔\nدیگر سبزیوں کے مقابلے میں فی ایکڑ زیادہ پیداوار۔\nمختلف اقسام کی مٹی اور موسم میں کاشت کی جا سکتی ہے۔'),
(26, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 2, 'موسمی تقاضے', 'آلو کی بہترین پیداوار کے لیے ٹھنڈا اور مرطوب موسم ضروری ہوتا ہے۔\n\n<b>درجہ حرارت</b>\nاگاؤ کے لیے مثالی درجہ حرارت: 15 سے 20 ڈگری سینٹی گریڈ\nنشوونما کے لیے: 18 سے 24 ڈگری سینٹی گریڈ\nگانٹھ بننے کے لیے: 15 سے 20 ڈگری سینٹی گریڈ\n30 ڈگری سے زیادہ پر نشوونما متاثر ہوتی ہے\nپالا کم عمر پودوں کو نقصان پہنچا سکتا ہے\n\n<b>بارش اور نمی</b>\nکل ضرورت: 500 سے 700 ملی میٹر\nنمی: 60 سے 80 فیصد\nزیادہ نمی بیماریوں کو بڑھاتی ہے، اس لیے ہوا کا گزر ضروری ہے\n\n<b>دھوپ</b>\nروزانہ 6 سے 7 گھنٹے دھوپ ضروری ہے\nبادل والا موسم پیداوار کم کر دیتا ہے\n\n<b>ہوا</b>\nتیز ہوائیں پودے کو نقصان پہنچاتی ہیں اور ضیائی تالیف کم کرتی ہیں'),
(27, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 3, 'مٹی کے تقاضے', 'آلو کے لیے ڈھیلی، زرخیز اور اچھی نکاسی والی مٹی بہترین ہوتی ہے۔\n\n<b>بہترین مٹی کی اقسام</b>\nریتلی دوامی (سب سے بہتر)\nدوامی\nسلٹ دوامی\n\n<b>پی ایچ</b>\n5.2 سے 6.5 بہترین ہے\nہلکی تیزابی مٹی اسکیب بیماری کو کم کرتی ہے\n\n<b>اہم خصوصیات</b>\nمٹی سخت نہ ہو\nنامیاتی مادہ زیادہ ہو\nپتھر نہ ہوں (ورنہ گانٹھیں خراب ہوں گی)\nنمی برقرار رکھے لیکن پانی کھڑا نہ ہو\n\n<b>زمین کی تیاری</b>\nگہرا ہل چلائیں\n8 سے 10 ٹن فی ایکڑ گوبر کی کھاد ڈالیں\nروٹاویٹر سے باریک مٹی تیار کریں\nبیڈ یا کھیلیاں بنائیں\nزمین ہموار رکھیں'),
(28, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 4, 'بونے کا وقت', '<b>بوائی کے موزوں اوقات</b>\nاکتوبر سے دسمبر (اہم فصل)\nجنوری سے فروری (بہار کی فصل)\n\n<b>بیج گانٹھیں</b>\nمصدقہ اور بیماری سے پاک گانٹھیں استعمال کریں\nوزن: 30 سے 50 گرام\nانکر کی لمبائی: 1 سے 2 سینٹی میٹر\nبڑی گانٹھوں کو کاٹ کر 24 گھنٹے سکھائیں\n\n<b>بیج کی مقدار</b>\n700 سے 1000 کلوگرام فی ایکڑ\n\n<b>طریقہ کاشت</b>\n7 سے 10 سینٹی میٹر گہرائی میں لگائیں\nقطاروں کا فاصلہ: 60 سے 70 سینٹی میٹر\nپودوں کا فاصلہ: 20 سے 25 سینٹی میٹر\nانکر اوپر کی طرف ہونا چاہیے'),
(29, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 5, 'کھادوں کا شیڈول', '<b>فی ایکڑ کھاد کی مقدار</b>\nیوریا: 50 سے 60 کلوگرام\nڈی اے پی: 45 سے 50 کلوگرام\nپوٹاش: 25 سے 30 کلوگرام\nزنک سلفیٹ: 5 سے 10 کلوگرام\nجپسم: 20 سے 25 کلوگرام\nنامیاتی کھاد: 8 سے 10 ٹن\n\n<b>کھاد ڈالنے کا طریقہ</b>\nابتدائی مرحلہ: مکمل ڈی اے پی، پوٹاش، زنک، آدھی یوریا، جپسم\n25-30 دن بعد: 25 فیصد یوریا\n40-45 دن بعد: باقی 25 فیصد یوریا\n\n<b>اہمیت</b>\nنائٹروجن: پتوں کی بڑھوتری\nفاسفورس: جڑوں کی مضبوطی\nپوٹاشیم: گانٹھوں کا سائز اور معیار\nزنک: پودے کی بہتر نشوونما'),
(30, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 6, 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b>جڑی بوٹیاں</b>\nباتھو \nڈیلا \nجنگلی سرسوں\nگھاس\n\n<b>کنٹرول</b>\nپہلی گوڈی: 20 سے 25 دن\nدوسری گوڈی: 40 دن\nکیمیائی کنٹرول: میٹریبوزن\n\n<b>کیڑے</b>\nایفڈز: رس چوستے ہیں → پودا کمزور\nکنٹرول: امیڈاکلوپرڈ\n\nکٹ ورمز: تنے کو کاٹ دیتے ہیں\nکنٹرول: کلورپائریفوس / لیمبڈا سائیہالوترین\n\n:سفید مکھی\nوائرل بیماریاں پھیلاتی ہے\nکنٹرول: تھیامیٹھوکسام\n\n<b>بیماریاں</b>\n:لیٹ بلائٹ\nپتوں پر سیاہ دھبے\nکنٹرول: مینکوزیب، ریڈومل\n\n:ارلی بلائٹ\nگول دھبے\nکنٹرول: مینکوزیب\n\n:اسکیب\nکھردری سطح\nکنٹرول: نمی برقرار رکھیں'),
(31, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 7, 'فصل کاٹنے کا وقت', 'جب پتے پیلے اور خشک ہو جائیں'),
(32, 'wheat', 'english', 'Wheat Crop Information', 1, 'Introduction', 'Wheat is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes rice, maize, and barley. Wheat is primarily grown for its grains, which are used to produce flour for bread, chapati, pasta, and many other food products.\n\n<b><u> Key Characteristics of Wheat</u></b>\n Cool-season crop (Rabi crop)\n Plant height: 60 to 120 cm (varies by variety)\nStem: hollow (except nodes)\n Leaves: long, narrow, and green\nRoot system: fibrous and moderately deep\nGrain: rich in carbohydrates, protein (gluten), vitamins, and minerals\n\n<b><u> Global Importance</u></b>\n One of the top 3 staple crops (with rice and maize)\n Annual global production: 750+ million tons\n Major producers: China, India, Russia, USA, France, Canada\n Staple food for over 35% of the world population\n\n <b><u>Importance for Farmers</u></b>\n High demand in local and global markets\n Essential food crop in Pakistan\nEasy to store compared to vegetables\n Mechanized farming possible\n Stable income crop'),
(33, 'wheat', 'english', 'Wheat Crop Information', 2, 'Climate Requirement', 'Wheat grows best in cool and dry climates.\n\n <b><u>Temperature</u></b>\n Germination: 12 to 25°C\n Tillering stage: 16 to 20°C\n Grain filling: 20 to 25°C\n Above 30°C during grain filling → reduces yield\n Frost can damage crop at flowering stage\n\n<b><u> Rainfall & Moisture</u></b>\n Total requirement: 300–500 mm\n Needs moisture during early growth and grain filling\n Excess rain → lodging and disease risk\n\n <b><u>Sunlight</u></b>\n Requires bright sunlight\n Clear weather during grain filling improves grain quality\n\n<b><u> Wind</u></b>\n Strong winds can cause lodging (plants fall down)'),
(34, 'wheat', 'english', 'Wheat Crop Information', 3, 'Soil Requirement', 'Wheat can grow in various soils but performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types</u></b>\nLoam (ideal)\n Clay loam\nSilt loam\n\n<b><u|> Soil pH</u></b>\n Ideal range: 6.0 to 7.5\n\n <b><u>Important Soil Properties</u></b>\n Good drainage (no waterlogging)\n Moderate water-holding capacity\n Rich in organic matter\n Level field for uniform irrigation\n\n<b><u> Soil Preparation</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and previous crop residues\n Apply farmyard manure (5 to 8 tons/acre)\n Level land properly (laser leveling is best)'),
(35, 'wheat', 'english', 'Wheat Crop Information', 4, ' Sowing Time', ' <b><u>Ideal Sowing Time </u></b>\n Punjab & Sindh: 15 October to 30 November (best)\nLate sowing → lower yield\n\n <b><u>Seed Selection</u></b>\n Use certified, disease-free seeds\n Popular varieties:\n  Faisalabad-2008\n  Galaxy-2013\n  Punjab-2011\n\n <b><u>Seed Rate</u></b>\n 40 to 50 kg per acre\n\n <b><u>Sowing Method</u></b>\n Drill method (recommended)\n Row spacing: 9 to 12 inches\n Depth: 3 to 5 cm'),
(36, 'wheat', 'english', 'Wheat Crop Information', 5, '5. Fertilizer Schedule', 'Wheat requires balanced nutrients for high yield.\n\n <b><u>Recommended Dose </u>(Per Acre)</b>\nFertilizer\n Urea: 80 to 100 kg\n DAP: 50 kg\nPotash (SOP/MOP): 25 to 30 kg\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 5 to 8 tons\n\n <b><u>Application Schedule</u></b>\n1. Basal Dose (At Sowing)\nFull DAP\nFull Potash\n Half Urea\n Zinc\n\n2. First Irrigation (20 to 25 Days)\n 25% Urea\n\n3. Second Irrigation (40 to 45 Days)\n Remaining 25% Urea\n\n<b><u> Nutrient Importance</u></b>\n Nitrogen: Leaf growth, tillering\nPhosphorus: Root development\n Potassium: Strength, disease resistance\n Zinc: Better grain formation'),
(37, 'wheat', 'english', 'Wheat Crop Information', 6, '6. Weeds, Pests and Diseases', '<b>A.<u> Weeds</u></b>\n Common Weeds\n Bathu (Chenopodium)\nWild oats (Jangli jai)\n Dela (Cyperus)\n Broadleaf weeds\n\n<b><u>Control</u></b>\nWeeding at 20 to 30 days\n Chemical control:\n  Isoproturon\n  Topik\n  Puma Super\n\n<b>B.<u> Pests</u></b>\n Aphids\n Damage: Sap sucking → weak plants\n Control: Imidacloprid\n\n Termites\n Damage: Attack roots and stems\n Control: Chlorpyrifos\n\n<b>C.<u> Diseases</u></b>\n Rust (Zang)\nTypes:\n Leaf rust\n Stem rust\n Stripe rust\n\nCause: Puccinia species\n\nSymptoms:\n Orange/yellow powder on leaves\n Reduced grain filling\n\nControl:\n Resistant varieties\n Fungicide spray (Tilt, Score)\n\n Smut\nBlack powder in grains\nControl: Seed treatment before sowing\n\n Powdery Mildew\n White powder on leaves\nControl: Fungicide spray'),
(38, 'wheat', 'english', 'Wheat Crop Information', 7, '7. Harvesting', ' <b><u>Harvesting Time</u></b>\n April – May\n\n <b><u>When:</u></b>\n Crop turns golden yellow\n Grains become hard\n Moisture content ~12 to 14%'),
(39, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 1, 'تعارف', 'گندم دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوئیسی خاندان سے تعلق رکھتی ہے، جس میں چاول، مکئی اور جو شامل ہیں۔ گندم بنیادی طور پر اس کے دانوں کے لیے اگائی جاتی ہے، جن سے آٹا، روٹی، چپاتی، پاستا اور دیگر غذائی مصنوعات تیار کی جاتی ہیں۔\n\n<b> گندم کی اہم خصوصیات</b>\n سرد موسم کی فصل (ربیع کی فصل)\nپودے کی اونچائی: 60 سے 120 سینٹی میٹر (قسم کے مطابق مختلف)\nتنا: کھوکھلا ہوتا ہے (گرہوں کے علاوہ)\n پتے: لمبے، باریک اور سبز\nجڑوں کا نظام: ریشہ دار اور درمیانی گہرائی تک\n دانہ: کاربوہائیڈریٹس، پروٹین (گلوٹن)، وٹامنز اور معدنیات سے بھرپور\n\n <b>عالمی اہمیت</b>\n دنیا کی تین بڑی بنیادی غذائی فصلوں میں شامل (چاول اور مکئی کے ساتھ)\n سالانہ عالمی پیداوار: 750 ملین ٹن سے زیادہ\nبڑے پیدا کرنے والے ممالک: چین، بھارت، روس، امریکہ، فرانس، کینیڈا\n- دنیا کی 35 فیصد سے زائد آبادی کی بنیادی غذا\n\n<b> کسانوں کے لیے اہمیت</b>\n مقامی اور عالمی منڈیوں میں زیادہ طلب\n پاکستان کی بنیادی غذائی فصل\n- سبزیوں کے مقابلے میں ذخیرہ کرنا آسان\nمشینی کاشت ممکن\nمستحکم آمدنی دینے والی فصل'),
(40, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 2, 'موسمی تقاضے', 'گندم ٹھنڈے اور خشک موسم میں بہترین اگتی ہے۔\n\n <b>درجہ حرارت</b>\n اگاؤ: 12 سے 25 ڈگری سینٹی گریڈ\n ٹلرنگ مرحلہ: 16 سے 20 ڈگری سینٹی گریڈ\n دانہ بھرنے کا مرحلہ: 20 سے 25 ڈگری سینٹی گریڈ\n- دانہ بھرنے کے دوران 30 ڈگری سینٹی گریڈ سے زیادہ درجہ حرارت پیداوار کم کر دیتا ہے\n پھول آنے کے وقت کہر فصل کو نقصان پہنچا سکتی ہے\n\n <b>بارش اور نمی</b>\n کل ضرورت: 300 سے 500 ملی میٹر\nابتدائی بڑھوتری اور دانہ بھرنے کے وقت نمی ضروری ہوتی ہے\n زیادہ بارش سے فصل گرنے  اور بیماریوں کا خطرہ بڑھ جاتا ہے\n\n <b>دھوپ</b>\n تیز دھوپ ضروری ہے\n دانہ بھرنے کے دوران صاف موسم دانے کے معیار کو بہتر بناتا ہے\n\n<b> ہوا</b>\n تیز ہوائیں فصل کو گرا سکتی ہیں '),
(41, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 3, 'مٹی کے تقاضے', 'گندم مختلف اقسام کی مٹی میں اگ سکتی ہے لیکن زرخیز اور اچھی نکاسی والی مٹی میں بہترین پیداوار دیتی ہے۔\n\n <b>بہترین مٹی کی اقسام</b>\n میرا  — سب سے بہتر\n چکنی میرا \n سلٹی میرا \n\n <b>پی ایچ</b>\n مثالی حد: 6.0 سے 7.5\n\n <b>اہم خصوصیات</b>\n- پانی کے نکاس کا اچھا نظام (پانی کھڑا نہ ہو)\nدرمیانی پانی رکھنے کی صلاحیت\n نامیاتی مادہ سے بھرپور\nزمین ہموار ہو تاکہ آبپاشی یکساں ہو\n\n <b>مٹی کی تیاری</b>\n 2 سے 3 ہل چلا کر نرم بیج بستر تیار کریں\n جڑی بوٹیاں اور پچھلی فصل کی باقیات ختم کریں\n 5 سے 8 ٹن فی ایکڑ گوبر کی کھاد ڈالیں\nزمین کو اچھی طرح ہموار کریں (لیزر لیولنگ بہترین ہے)'),
(42, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 4, 'بونے کا وقت', '<b> موزوں کاشت کا وقت</b>\n پنجاب اور سندھ: 15 اکتوبر سے 30 نومبر (بہترین)\n دیر سے کاشت کرنے سے پیداوار کم ہو جاتی ہے\n\n<b>بیج کا انتخاب</b>\n تصدیق شدہ اور بیماری سے پاک بیج استعمال کریں\nمشہور اقسام:\n  فیصل آباد-2008\n  گلیکسی-2013\n  پنجاب-2011\n\n <b>بیج کی مقدار</b>\n 40 سے 50 کلوگرام فی ایکڑ\n\n <b>بوائی کا طریقہ</b>\n ڈرل طریقہ (سفارش کردہ)\nقطاروں کا فاصلہ: 9 سے 12 انچ\nگہرائی: 3 سے 5 سینٹی میٹر'),
(43, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 5, 'کھادوں کا شیڈول', 'گندم کو زیادہ پیداوار کے لیے متوازن غذائی اجزاء درکار ہوتے ہیں۔\n\n <b>سفارش کردہ مقدار (فی ایکڑ)</b>\nکھاد\n یوریا: 80 سے 100 کلوگرام\n ڈی اے پی: 50 کلوگرام\n پوٹاش (SOP/MOP): 25 سے 30 کلوگرام\n- زنک سلفیٹ: 5 سے 10 کلوگرام\n نامیاتی کھاد: 5 سے 8 ٹن\n\n <b>استعمال کا شیڈول</b>\n بوائی کے وقت \n- مکمل ڈی اے پی\n مکمل پوٹاش\nآدھی یوریا\n- زنک\n\nپہلی آبپاشی (20 سے 25 دن بعد)\n 25 فیصد یوریا\n\n دوسری آبپاشی (40 سے 45 دن بعد)\n باقی 25 فیصد یوریا\n\n <b>غذائی اجزاء کی اہمیت</b>\nنائٹروجن: پتوں کی بڑھوتری اور ٹلرنگ\n فاسفورس: جڑوں کی نشوونما\nپوٹاشیم: مضبوطی اور بیماریوں کے خلاف مزاحمت\nزنک: دانے کی بہتر تشکیل'),
(44, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 6, 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b> جڑی بوٹیاں</b>\n عام جڑی بوٹیاں\n- باتھو \nجنگلی جئی \n- ڈیلا \n- چوڑی پتوں والی جڑی بوٹیاں\n\n <b>کنٹرول</b>\nگوڈی 20سے30دن میں کریں\n<b> کیڑے</b>\n ایفڈز\n- نقصان: رس چوس کر پودوں کو کمزور کرتے ہیں\n دیمک\n- نقصان: جڑوں اور تنوں پر حملہ کرتے ہیں\n<b> بیماریاں</b>\n زنگ \nاقسام:\n لیف رسٹ\n اسٹیم رسٹ\nاسٹرائپ رسٹ\n<b>علامات</b>\n- پتوں پر نارنجی یا پیلے رنگ کا پاؤڈر\n دانہ بھرنے میں کمی\n\n<b>کنٹرول</b>\n مزاحم اقسام استعمال کریں\n فنگس کش اسپرے \n\n سموٹ \n دانوں میں سیاہ پاؤڈر\n کنٹرول: بوائی سے پہلے بیج کا ٹریٹمنٹ\n\n پاؤڈری میلڈیو\n پتوں پر سفید پاؤڈر\n کنٹرول: فنگس کش اسپرے'),
(45, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 7, 'فصل کاٹنے کا وقت', '  اپریل سے مئی\nفصل سنہری پیلی ہو جائے\nدانے سخت ہو جائیں\n نمی تقریباً 12 سے 14 فیصد ہو'),
(46, 'maize', 'english', 'Maize Crop Information', 1, ' Introduction', 'Maize is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes wheat, rice, and barley. Maize is primarily grown for its grains, which are used for human food, animal feed, and industrial products like starch, oil, and biofuel.\n\n<b><u>Key Characteristics of Maize:</u></b>\n Warm-season crop (Kharif crop)\n Plant height: 150 to 300 cm (varies by variety)\nStem: solid and thick\n Leaves: long, broad, and green\n Root system: fibrous and deep\nGrain: rich in carbohydrates, oil, protein, vitamins, and minerals\n\n<b><u>Global Importance:</u></b>\n One of the top 3 staple crops (with wheat and rice)\nAnnual global production: 1100+ million tons\n Major producers: USA, China, Brazil, Argentina, India\n Widely used in food industry and livestock feed\n\n<b><u>Importance for Farmers:</u></b>\n High yield potential\n Used as food and fodder\nHigh demand in poultry feed industry\n Suitable for mechanized farming\nProvides stable and profitable income'),
(47, 'maize', 'english', 'Maize Crop Information', 2, ' Climate Requirement', 'Maize grows best in warm and moderately humid climates.\n\n<b><u>Temperature:</u></b>\nGermination: 18 to 25°C\n Vegetative growth: 25 to 30°C\n Grain filling: 20 to 25°C\nBelow 10°C → poor growth\n Above 35°C → heat stress and reduced yield\n\n<b><u>Rainfall & Moisture:</u></b>\n Total requirement: 500 to 800 mm\nNeeds adequate moisture during germination and flowering\n Water stress at tasseling stage → severe yield loss\n Excess water → root damage and diseases\n\n<b><u>Sunlight:</u></b>\n Requires full sunlight for optimal growth\n Low light reduces yield\n\n<b><u>Wind:</u></b>\n Strong winds may cause lodging (plants fall over)'),
(48, 'maize', 'english', 'Maize Crop Information', 3, ' Soil Requirement', 'Maize performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types:</u></b>\n Loam (ideal)\n Sandy loam\n Silt loam\n\n<b><u>Soil pH:</u></b>\n Ideal range: 5.5 to 7.5\n\n<b><u>Important Soil Properties:</u></b>\nGood drainage (avoid waterlogging)\n High fertility\n Adequate organic matter\n Proper soil aeration\n\n<b><u>Soil Preparation:</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and crop residues\nApply farmyard manure (8 to 10 tons/acre)\nLevel the land properly'),
(49, 'maize', 'english', 'Maize Crop Information', 4, ' Sowing Time', '<b><u>Ideal Sowing Time :</u></b>\n Spring crop: January to February\n Kharif crop: June to July (best season)\n\n<b><u>Seed Selection:</u></b>\nUse certified, hybrid, and disease-free seeds\n Popular hybrids: Pioneer, Monsanto, Local approved hybrids\n\n<b><u>Seed Rate:</u></b>\n 20 to 25 kg per acre\n\n<b><u>Sowing Method:</u></b>\n Drill method (recommended)\nRow spacing: 60 to 75 cm\n Plant spacing: 20 to 25 cm\n Seed depth: 3 to 5 cm'),
(50, 'maize', 'english', 'Maize Crop Information', 5, ' Fertilizer Schedule', '<b><u>Recommended Dose</u> (Per Acre)</b>:\n Urea: 2 bags\nDAP: 1 bag\n Potash: 1/2 bag\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\n1. Basal Dose (At Sowing): Full DAP, Full Potash, Half Urea, Zinc Sulfate\n2. First Irrigation (20 to 25 Days After Sowing): Apply 25% Urea\n3. Second Irrigation (40 to 45 Days After Sowing): Apply remaining 25% Urea\n\n<b><u>Nutrient Importance:</u></b>\n Nitrogen: Promotes leaf growth and yield\n Phosphorus: Enhances root development\nPotassium: Improves plant strength and disease resistance\n Zinc: Helps in better grain formation'),
(51, 'maize', 'english', 'Maize Crop Information', 6, ' Weeds, Pests and Diseases', '<b>A.<u> Weeds:</u></b>\n Common Weeds: Grasses, Bathu (Chenopodium), Dela (Cyperus), Broadleaf weeds\n <b><u>Control:</u></b> Manual weeding at 20 to 30 days, Chemical control: Atrazine, Pendimethalin\n\n<b>B. <u>Pests:</u></b>\n Stem Borer: Feeds inside the stem, weakens the plant. <b><u>Control:</u></b> Chlorantraniliprole spray\n Fall Armyworm: Feeds on leaves, severe damage. <b><u>Control:</u></b> Emamectin Benzoate\n Aphids: Suck plant sap, reduce growth. <b><u>Control:</u></b> Imidacloprid\n\n<b>C.<u> Diseases:</u></b>\n Leaf Blight: Brown lesions on leaves. Control: Fungicide application\n Rust: Orange or brown powder on leaves. Control: Resistant varieties and fungicide spray\n Downy Mildew: Yellowing and stunted plants. Control: Seed treatment before sowing'),
(52, 'maize', 'english', 'Maize Crop Information', 7, ' Harvesting', '<b><u>Harvesting Time:</u></b>\n 90 to 120 days after sowing\n\n<b><U>When to Harvest:</u></b>\nHusks turn dry\nGrains become hard\n Moisture content around 20 to 25%'),
(53, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 1, ' تعارف', 'مکئی دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوایسیا فیملی سے تعلق رکھتی ہے، جس میں گندم، چاول، اور جو شامل ہیں۔ مکئی بنیادی طور پر اپنے دانوں کے لیے اگائی جاتی ہے، جو انسانی غذا، جانوروں کے چارہ، اور صنعتی مصنوعات جیسے نشاستہ، تیل، اور بایوفیول میں استعمال ہوتے ہیں۔\n\n<b>مکئی کی اہم خصوصیات</b>\n- گرم موسم کی فصل (کھڑی فصل)\n- پودے کی اونچائی: 150 سے 300 سینٹی میٹر (نسل کے حساب سے مختلف)\n- تنے: مضبوط اور موٹے\n- پتے: لمبے، چوڑے اور سبز\n- جڑ کا نظام: ریشے دار اور گہرا\n- دانہ: کاربوہائیڈریٹس، تیل، پروٹین، وٹامنز اور معدنیات سے بھرپور\n\n<b>عالمی اہمیت</b>\n- تین اہم غذائی فصلوں میں سے ایک (گندم اور چاول کے ساتھ)\n- سالانہ عالمی پیداوار: 1100+ ملین ٹن\n- بڑے پیدا کرنے والے ممالک: امریکہ، چین، برازیل، ارجنٹینا، بھارت\n- خوراک کی صنعت اور جانوروں کے چارہ میں وسیع استعمال\n\n<b>کسانوں کے لیے اہمیت</b>\n- زیادہ پیداوار کی صلاحیت\n- خوراک اور چارہ کے لیے استعمال\n- پولٹری فیڈ انڈسٹری میں زیادہ طلب\n- مشینی کھیتی کے لیے موزوں\n- مستحکم اور منافع بخش آمدنی فراہم کرتی ہے'),
(54, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 2, 'موسمی تقاضے', 'مکئی سب سے بہتر گرم اور معتدل نمی والے علاقوں میں اگتی ہے۔\n\n<b>درجہ حرارت</b>\n- اگنا: 18 سے 25°C\n- نشوونما: 25 سے 30°C\n- دانہ بھرنے کا مرحلہ: 20 سے 25°C\n- 10°C سے کم → کمزور نمو\n- 35°C سے زیادہ → حرارت کی شدت اور پیداوار میں کمی\n\n<b>بارش اور نمی</b>\n- کل ضرورت: 500 سے 800 ملی میٹر\n- اگنے اور پھولنے کے دوران مناسب نمی کی ضرورت\n- ٹیسلنگ مرحلے میں پانی کی کمی → شدید پیداوار کا نقصان\n- زیادہ پانی → جڑوں کو نقصان اور بیماریاں\n\n<b>روشنی</b>\n- مکمل دھوپ کی ضرورت\n- کم روشنی پیداوار کم کرتی ہے\n\n<b>ہوا</b>\n- شدید ہوائیں پودوں کو گرنے پر مجبور کر سکتی ہیں'),
(55, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 3, 'مٹی کے تقاضے', 'مکئی بہترین زرخیز اور پانی نکالنے والی مٹی میں اگتی ہے۔\n\n<b>مٹی کی بہترین اقسام</b>\n- لوئم (مثالی)\n- ریتلی لوئم\n- سیلٹ لوئم\n\n<b> پی ایچ</b>\n- مثالی حد: 5.5 سے 7.5\n\n<b>اہم مٹی کی خصوصیات</b>\n- اچھی نکاسی (پانی جمع ہونے سے بچیں)\n- زیادہ زرخیزی\n- مناسب نامیاتی مادہ\n- مناسب ہوا دار مٹی\n\n<b>مٹی کی تیاری</b>\n- باریک بیج بچھانے کے لیے 2 سے 3 ہل چلائیں\n- گھاس اور فصل کے باقیات ہٹائیں\n- فارم یارڈ کھاد لگائیں (8 سے 10 ٹن فی ایکڑ)\n- زمین کو مناسب سطح پر لیول کریں'),
(56, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 4, ' بونے کا وقت', '<b>پاکستان میں بونے کا مثالی وقت</b>\n- بہاری فصل: جنوری سے فروری\n- کھڑی فصل: جون سے جولائی (سب سے بہترین موسم)\n\n<b>بیج کا انتخاب</b>\n- تصدیق شدہ، ہائبرڈ، اور بیماری سے پاک بیج استعمال کریں\n- مشہور ہائبرڈز: پائنیئر، مونسانٹو، مقامی منظور شدہ ہائبرڈز\n\n<b>بیج کی مقدار</b>\n- 20 سے 25 کلوگرام فی ایکڑ\n\n<b>بونے کا طریقہ</b>\n- ڈرل طریقہ (سفارش کی جاتی ہے)\n- قطار کا فاصلہ: 60 سے 75 سینٹی میٹر\n- پودے کا فاصلہ: 20 سے 25 سینٹی میٹر\n- بیج کی گہرائی: 3 سے 5 سینٹی میٹر'),
(57, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 5, 'کھادوں کا شیڈول', '<b>فی ایکڑ تجویز شدہ خوراک</b>\n- یوریا: 2 تھیلے\n- ڈی اے پی: 1 تھیلا\n- پوٹاش: 1/2 تھیلا\n- زنک سلفیٹ: 5 سے 10 کلوگرام\n- نامیاتی کھاد: 8 سے 10 ٹن\n\n<b>درخواست کا شیڈول</b>\n1. بنیادی خوراک (بونے کے وقت): مکمل ڈی اے پی، مکمل پوٹاش، نصف یوریا، زنک سلفیٹ\n2. پہلی آبپاشی (بونے کے 20 سے 25 دن بعد): 25% یوریا لگائیں\n3. دوسری آبپاشی (بونے کے 40 سے 45 دن بعد): باقی 25% یوریا لگائیں\n\n<b>غذائی اجزاء کی اہمیت</b>\n- نائٹروجن: پتوں کی نمو اور پیداوار کو فروغ دیتا ہے\n- فاسفورس: جڑوں کی ترقی کو بہتر بناتا ہے\n- پوٹاشیم: پودے کی مضبوطی اور بیماریوں کی مزاحمت بڑھاتا ہے\n- زنک: دانے کی بہتر تشکیل میں مدد دیتا ہے'),
(58, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 6, ' جڑی بوٹیاں، کیڑے اور بیماریاں', '<b> جڑی بوٹیاں</b>\n- عام جڑی بوٹیاں: گھاس، بٹھو ، دیلا ، چوڑی پتیاں والی جڑی بوٹیاں\n- کنٹرول: 20 سے 30 دن بعد ہاتھ سے صفائی، کیمیائی کنٹرول: ایٹرازین، پینڈیمیتھالین\n\n<b> کیڑے</b>\n- اسٹیم بورر: تنوں کے اندر کھاتے ہیں، پودے کو کمزور کرتے ہیں۔ کنٹرول: کلورانٹرانیل پروائل سپرے\n- فال آرمی ورم: پتوں کو کھاتا ہے، شدید نقصان۔ کنٹرول: ایما میکٹن بینزویٹ\n- افڈز: پودے کا رس چوستے ہیں، نمو کم کرتے ہیں۔ کنٹرول: امیڈاکلوپریڈ\n\n<b> بیماریاں</b>\n- لیف بلیٹ: پتوں پر بھوری دھبے۔ کنٹرول: فنگسائیڈ لگائیں\n- رسٹ: پتوں پر نارنجی یا بھوری پاؤڈر۔ کنٹرول: مزاحم اقسام اور فنگسائیڈ سپرے\n- ڈاؤنی میلڈیو: پیلے پن اور بوجھل پودے۔ کنٹرول: بونے سے پہلے بیج کا علاج'),
(59, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 7, 'فصل کاٹنے کا وقت', '<b>کٹائی کا وقت</b>\n- 90 سے 120 دن بعد بونے کے\n\n<b>کٹائی کے اشارے</b>\n- بھوسے خشک ہو جائیں\n- دانے سخت ہو جائیں\n- نمی تقریباً 20 سے 25%');

-- --------------------------------------------------------

--
-- Table structure for table `crop_guides`
--

CREATE TABLE `crop_guides` (
  `id` int(11) NOT NULL,
  `crop` varchar(20) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `section_intro` varchar(255) DEFAULT NULL,
  `section_climate` varchar(255) DEFAULT NULL,
  `section_soil` varchar(255) DEFAULT NULL,
  `section_sowing` varchar(255) DEFAULT NULL,
  `section_fertilizer` varchar(255) DEFAULT NULL,
  `section_pests` varchar(255) DEFAULT NULL,
  `section_harvest` varchar(255) DEFAULT NULL,
  `img_intro` varchar(255) DEFAULT NULL,
  `img_climate` varchar(255) DEFAULT NULL,
  `img_soil` varchar(255) DEFAULT NULL,
  `img_sowing` varchar(255) DEFAULT NULL,
  `img_fertilizer` varchar(255) DEFAULT NULL,
  `img_pests` varchar(255) DEFAULT NULL,
  `img_harvest` varchar(255) DEFAULT NULL,
  `lang_btn` varchar(50) DEFAULT NULL,
  `next_btn` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_guides`
--

INSERT INTO `crop_guides` (`id`, `crop`, `lang`, `title`, `section_intro`, `section_climate`, `section_soil`, `section_sowing`, `section_fertilizer`, `section_pests`, `section_harvest`, `img_intro`, `img_climate`, `img_soil`, `img_sowing`, `img_fertilizer`, `img_pests`, `img_harvest`, `lang_btn`, `next_btn`) VALUES
(1, 'rice', 'en', 'Rice - Complete Crop Guide', 'Introduction', 'Climate Requirement', 'Soil Requirement', 'Sowing Time', 'Fertilizer Schedule', 'Weeds, Pests and Diseases', 'Harvesting', 'assets/rice-intro.jpeg', 'assets/climate.jpg', 'assets/rice-soil.jpeg', 'assets/rice-sowing.jpeg', 'assets/rice-fertilizer.jpeg', 'assets/rice-pests.jpeg', 'assets/rice-harvesting.jpeg', 'اردو', 'View Detail'),
(2, 'rice', 'ur', 'چاول- مکمل کاشتی رہنمائی', 'تعارف', 'آب و ہوا کی ضروریات', 'مٹی کی ضروریات', 'بوائی کا وقت', 'کھاد کا شیڈول', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 'کٹائی', 'assets/rice-intro.jpeg', 'assets/climate.jpg', 'assets/rice-soil.jpeg', 'assets/rice-sowing.jpeg', 'assets/rice-fertilizer.jpeg', 'assets/rice-pests.jpeg', 'assets/rice-harvesting.jpeg', 'English', 'تفصیل'),
(3, 'potato', 'en', 'Potato - Complete Crop Guide', 'Introduction', 'Climate Requirement', 'Soil Requirement', 'Sowing Time', 'Fertilizer Schedule', 'Weeds, Pests and Diseases', 'Harvesting', 'assets/potato-intro.jpeg', 'assets/climate.jpg', 'assets/potato-soil.jpeg', 'assets/potato-sowing.jpg', 'assets/potato-fertilizer.jpg', 'assets/potato-pest.jpg', 'assets/potato-harvesting.jpg', 'اردو', 'View Detail'),
(4, 'potato', 'ur', 'آلو - مکمل کاشتی رہنمائی', 'تعارف', 'آب و ہوا کی ضروریات', 'مٹی کی ضروریات', 'بوائی کا وقت', 'کھاد کا شیڈول', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 'کٹائی', 'assets/potato-intro.jpeg', 'assets/climate.jpg', 'assets/potato-soil.jpeg', 'assets/potato-sowing.jpg', 'assets/potato-fertilizer.jpg', 'assets/potato-pest.jpg', 'assets/potato-harvesting.jpg', 'English', 'تفصیل'),
(5, 'wheat', 'en', 'Wheat - Complete Crop Guide', 'Introduction', 'Climate Requirement', 'Soil Requirement', 'Sowing Time', 'Fertilizer Schedule', 'Weeds, Pests and Diseases', 'Harvesting', 'assets/image.jpeg', 'assets/climate.jpg', 'assets/soil.jpg', 'assets/sowing.jpg', 'assets/fertilizer.jpg', 'assets/pests.jpg', 'assets/harvesting.jpg', 'اردو', 'View Detail'),
(6, 'wheat', 'ur', 'گندم - مکمل کاشتی رہنمائی', 'تعارف', 'آب و ہوا کی ضروریات', 'مٹی کی ضروریات', 'بوائی کا وقت', 'کھاد کا شیڈول', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 'کٹائی', 'assets/image.jpeg', 'assets/climate.jpg', 'assets/soil.jpg', 'assets/sowing.jpg', 'assets/fertilizer.jpg', 'assets/pests.jpg', 'assets/harvesting.jpg', 'English', 'تفصیل'),
(7, 'maize', 'en', 'Maize - Complete Crop Guide', 'Introduction', 'Climate Requirement', 'Soil Requirement', 'Sowing Time', 'Fertilizer Schedule', 'Weeds, Pests and Diseases', 'Harvesting', 'assets/maize-intro.jpg', 'assets/climate.jpg', 'assets/maize-soil.jpg', 'assets/maize-sowing.jpg', 'assets/maize-fertilizer.jpg', 'assets/maize-pest.jpg', 'assets/maize-harvesting.jpg', 'اردو', 'View Detail'),
(8, 'maize', 'ur', 'مکؑی - مکمل کاشتی رہنمائی', 'تعارف', 'آب و ہوا کی ضروریات', 'مٹی کی ضروریات', 'بوائی کا وقت', 'کھاد کا شیڈول', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 'کٹائی', 'assets/maize-intro.jpg', 'assets/climate.jpg', 'assets/maize-soil.jpg', 'assets/maize-sowing.jpg', 'assets/maize-fertilizer.jpg', 'assets/maize-pest.jpg', 'assets/maize-harvesting.jpg', 'English', 'تفصیل');

-- --------------------------------------------------------

--
-- Table structure for table `crop_images`
--

CREATE TABLE `crop_images` (
  `id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `image_path` varchar(300) NOT NULL,
  `caption` varchar(200) DEFAULT '',
  `caption_ur` varchar(200) DEFAULT '',
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_images`
--

INSERT INTO `crop_images` (`id`, `crop_id`, `image_path`, `caption`, `caption_ur`, `sort_order`) VALUES
(1, 1, 'assets/rice-intro.jpeg', 'Introduction', 'تعارف', 0),
(2, 1, 'assets/climate.jpg', 'Climate Requirement', 'آب و ہوا کی ضروریات', 1),
(3, 1, 'assets/rice-soil.jpeg', 'Soil Requirement', 'مٹی کی ضروریات', 2),
(4, 1, 'assets/rice-sowing.jpeg', 'Sowing Time', 'بوائی کا وقت', 3),
(5, 1, 'assets/rice-fertilizer.jpeg', 'Fertilizer Schedule', 'کھاد کا شیڈول', 4),
(6, 1, 'assets/rice-pests.jpeg', 'Weeds, Pests and Diseases', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 5),
(7, 1, 'assets/rice-harvesting.jpeg', 'Harvesting', 'کٹائی', 6),
(8, 2, 'assets/potato-intro.jpeg', 'Introduction', 'تعارف', 0),
(9, 2, 'assets/climate.jpg', 'Climate Requirement', 'آب و ہوا کی ضروریات', 1),
(10, 2, 'assets/potato-soil.jpeg', 'Soil Requirement', 'مٹی کی ضروریات', 2),
(11, 2, 'assets/potato-sowing.jpg', 'Sowing Time', 'بوائی کا وقت', 3),
(12, 2, 'assets/potato-fertilizer.jpg', 'Fertilizer Schedule', 'کھاد کا شیڈول', 4),
(13, 2, 'assets/potato-pest.jpg', 'Weeds, Pests and Diseases', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 5),
(14, 2, 'assets/potato-harvesting.jpg', 'Harvesting', 'کٹائی', 6),
(15, 3, 'assets/image.jpeg', 'Introduction', 'تعارف', 0),
(16, 3, 'assets/climate.jpg', 'Climate Requirement', 'آب و ہوا کی ضروریات', 1),
(17, 3, 'assets/soil.jpg', 'Soil Requirement', 'مٹی کی ضروریات', 2),
(18, 3, 'assets/sowing.jpg', 'Sowing Time', 'بوائی کا وقت', 3),
(19, 3, 'assets/fertilizer.jpg', 'Fertilizer Schedule', 'کھاد کا شیڈول', 4),
(20, 3, 'assets/pests.jpg', 'Weeds, Pests and Diseases', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 5),
(21, 3, 'assets/harvesting.jpg', 'Harvesting', 'کٹائی', 6),
(22, 4, 'assets/maize-intro.jpg', 'Introduction', 'تعارف', 0),
(23, 4, 'assets/climate.jpg', 'Climate Requirement', 'آب و ہوا کی ضروریات', 1),
(24, 4, 'assets/maize-soil.jpg', 'Soil Requirement', 'مٹی کی ضروریات', 2),
(25, 4, 'assets/maize-sowing.jpg', 'Sowing Time', 'بوائی کا وقت', 3),
(26, 4, 'assets/maize-fertilizer.jpg', 'Fertilizer Schedule', 'کھاد کا شیڈول', 4),
(27, 4, 'assets/maize-pest.jpg', 'Weeds, Pests and Diseases', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 5),
(28, 4, 'assets/maize-harvesting.jpg', 'Harvesting', 'کٹائی', 6);

-- --------------------------------------------------------

--
-- Table structure for table `crop_info`
--

CREATE TABLE `crop_info` (
  `id` int(11) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `link_page` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_info`
--

INSERT INTO `crop_info` (`id`, `lang`, `name`, `description`, `image_url`, `link_page`, `sort_order`) VALUES
(1, 'en', 'Rice', 'A staple food crop grown in flooded fields, requiring plenty of water', 'assets/rice-intro.jpeg', 'rice.php', 1),
(2, 'en', 'Potato', 'A versatile tuber crop grown in well-drained soil', 'assets/potato-intro.jpeg', 'potato.php', 2),
(3, 'en', 'Wheat', 'A primary cereal crop grown in temperate regions', 'assets/image.jpeg', 'wheat.php', 3),
(4, 'en', 'Maize', 'A popular maize grown in warm climates, used for food and animal feed', 'assets/maize-intro.jpg', 'maize.php', 4),
(5, 'ur', 'چاول', 'ایک بنیادی غذائی فصل جو پانی سے بھری زمین میں اگائی جاتی ہے', 'assets/rice-intro.jpeg', 'rice.php', 1),
(6, 'ur', 'آلو', 'ایک قیمتی جڑ والی فصل جو خشک زمین میں اگائی جاتی ہے', 'assets/potato-intro.jpeg', 'potato.php', 2),
(7, 'ur', 'گندم', 'ایک اہم اناجی فصل جو معتدل علاقوں میں اگائی جاتی ہے', 'assets/image.jpeg', 'wheat.php', 3),
(8, 'ur', 'مکئی', 'ایک مقبول فصل جو گرم علاقوں میں اگائی جاتی ہے اور خوراک کے لیے استعمال ہوتی ہے', 'assets/maize-intro.jpg', 'maize.php', 4);

-- --------------------------------------------------------

--
-- Table structure for table `crop_sections`
--

CREATE TABLE `crop_sections` (
  `id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `lang` char(2) DEFAULT 'en',
  `heading` varchar(300) DEFAULT '',
  `content` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_sections`
--

INSERT INTO `crop_sections` (`id`, `crop_id`, `lang`, `heading`, `content`, `sort_order`) VALUES
(1, 1, 'en', 'Introduction', 'Rice is one of the world’s most important cereal crops and a staple food for more than half of the global population. It belongs to the grass family. Rice farming is traditionally practiced in regions with high rainfall or where controlled irrigation is available.\n\n<b><u>Key Characteristics of Rice:</u></b>\nGrows best in standing water (paddy conditions).\nPlant height varies between 80 to 150 cm, depending on variety.\nHas a slender stem, long leaves, and a grain-bearing panicle.\nIts root system is fibrous, enabling it to survive in partially flooded fields.\n\n<b><u>Global Importance:</u></b>\nRice production exceeds 700 million tons globally.\nMain producers: China, India, Bangladesh, Vietnam, Thailand, Pakistan.\nIt is a major traded commodity and essential for food security.\n\n<b><u>Why Rice Is Important for Farmers:</u></b>\nHigh demand in both local and export markets.\nStable income source.\nSuitable for areas with abundant water.\nBy-products (bran, husk, straw) are also valuable.', 0),
(2, 1, 'en', 'Climate Requirement', 'Rice is a tropical and subtropical crop that needs warm, moist conditions.\n\n<b><u>Temperature:</u></b>\nGermination: 16 to 40°C (optimum 25 to 35°C)\nTillering stage: 25 to 30°C\nReproductive stage: 20 to 25°C\nGrain filling: 20 to 30°C\nCold sensitivity: Below 18°C slows growth\n\n<b><u>Rainfall & Humidity:</u></b>\nRequires 1,000 to 2,000 mm of rainfall annually.\nBest humidity: 60 to 80%\nHigh humidity helps in photosynthesis and grain filling.\n\n<b><u>Sunlight:</u></b>\nRice requires 4 to 5 hours of direct sunlight daily.\nCloudy weather during flowering can reduce grain formation.', 1),
(3, 1, 'en', 'Soil Requirement', 'Rice grows best in soils that can retain water.\n\n<b><u>Best Soil Types:</u></b>\nClay soil: excellent for water retention\nClay loam: good fertility and moisture holding\nSilty loam: supports strong vegetative growth\n\n<b><u>Soil pH</u></b>:\nIdeal pH: 5.5 to 7.0\nSlightly acidic soils are preferred.\n\n<b><u>Important Soil Properties:</u></b>\nSoil should be deep for strong roots.\nShould contain high organic matter.\nGood water retention is crucial for paddy conditions.\n\n<b><u>Soil Preparation:</u></b>\nFirst plowing to break clods\nFlooding of field\nPuddling (mixing soil and water to make a soft, level base)\nLevelling to ensure uniform water depth', 2),
(4, 1, 'en', 'Sowing Time', 'Rice can be grown through:\n\n<b>A.<u> Nursery </u>(Transplanting Method):</b>\nMost common method in Pakistan and Asia.\n\n<b><u>Sowing Time </u>(Kharif Season):</b>\nPunjab: May to June\nSindh: June to July\n\n<b><u>Nursery Duration:</u></b>\nSeedlings are raised for 25 to 30 days, then transplanted.\n\n<b>B.<u> Direct Seeding:</u></b>\nSeeds are sown directly into the field (either dry or wet seeding).\n\n<b><u>Advantages:</u></b>\nSaves labor\nFaster sowing\n\n<b><u>Seed Rate:</u></b>\nTransplanting: 5 to 8 kg/acre\nDirect seeding: 12 to 15 kg/acre', 3),
(5, 1, 'en', 'Fertilizer Schedule', 'Rice needs N (Nitrogen), P (Phosphorus), K (Potassium) in large amounts.\n\n<b><u>Recommended Dose</u> (General):</b>\nNitrogen (Urea): 100 to 150 kg/acre\nPhosphorus (DAP): 20 to 30 kg/acre\nPotassium (SOP or MOP): 20 to 25 kg/acre\nZinc Sulfate: 10 to 12 kg/acre (essential for tillering)\n\n<b><u>Application Schedule:</u></b>\n1. Basal Dose (before transplanting):\nDAP + SOP\nHalf dose of urea\n\n2. Tillering Stage (25 to 30 days after transplanting):\n25% urea\n\n3. Panicle Initiation Stage (45 to 55 days after transplanting):\nRemaining 25% urea\n\n<b><u>Why Fertilizer is Important?</u></b>\nNitrogen increases tillers (more branches)\nPhosphorus helps strong roots\nPotassium improves grain filling and disease resistance', 4),
(6, 1, 'en', 'Weeds, Pests and Diseases', '<b>A.<u> Common Weeds:</u></b>\nCyperus rotundus (Dela)\nWater grass\nBarnyard grass\n\n<b><u>Weed Control:</u></b>\nPre-emergence herbicides (e.g., Butachlor)\nManual weeding\nMaintaining water level to suppress weeds\n\n<b>B.<u> Major Pests:</u></b>\nStem Borer: Whitish caterpillar that bores into stems. Damage: dead hearts, whiteheads\nLeaf Folder: Rolls leaves and feeds inside\nBrown Plant Hopper (BPH): Sucks sap, causes \'hopper burn\'\n\n<b><u>Pest Control:</u></b>\nSpray Carbofuran, Imidacloprid, or Fipronil depending on pest\nMaintain water drainage to control BPH\n\n<b>C.<u> Major Diseases:</u></b>\nBlast Disease\nSheath Blight\nBacterial Leaf Blight (BLB)\n\n<b><u>Disease Control:</u></b>\nUse resistant varieties\nProper drainage\nFungicides: Tricyclazole, Propiconazole\nAvoid excessive nitrogen', 5),
(7, 1, 'en', 'Harvesting', '<b><u>When to Harvest:</u></b>\nRice is ready for harvest when:\nGrains become golden yellow\nMoisture content is 20 to 24%\n80 to 90% grains are mature', 6),
(8, 1, 'ur', 'تعارف', 'چاول دنیا کی سب سے اہم غذائی اناج میں سے ایک ہے اور عالمی آبادی کے نصف سے زیادہ کے لیے بنیادی غذا ہے۔ یہ گھاس کے خاندان سے تعلق رکھتا ہے۔ چاول کی کاشت عام طور پر ان علاقوں میں کی جاتی ہے جہاں بارش زیادہ ہو یا پانی کی منظم آبپاشی دستیاب ہو۔', 0),
(9, 1, 'ur', 'چاول کی اہم خصوصیات', ' کھڑے پانی (پڈی) میں بہترین نشوونما پاتا ہے۔\nپودے کی اونچائی 80 تا 150 سینٹی میٹر ہوتی ہے۔\nپتلا تنہ، لمبے پتے اور دانے والے پودے کی شاخیں ہوتی ہیں۔\n ریشے دار جڑیں جو پانی میں بھی زندہ رہ سکتی ہیں۔', 1),
(10, 1, 'ur', 'عالمی اہمیت', 'عالمی سطح پر چاول کی سالانہ پیداوار 700 ملین ٹن سے زیادہ ہے۔ اہم پیدا کرنے والے ممالک: چین، بھارت، بنگلہ دیش، ویتنام، تھائی لینڈ، پاکستان۔ یہ ایک بڑی تجارتی فصل ہے اور غذائی تحفظ کے لیے ضروری ہے۔', 2),
(11, 1, 'ur', 'کسانوں کے لیے اہمیت', 'مقامی اور برآمدی منڈیوں میں زیادہ طلب۔\nمستحکم آمدنی کا ذریعہ۔\n زیادہ پانی والے علاقوں کے لیے موزوں۔\n بھوسہ، چھلکا اور تنکے سمیت ذیلی مصنوعات بھی قیمتی ہیں۔', 3),
(12, 1, 'ur', 'موسمی تقاضے', '<b>درجہ حرارت</b><br/>\nاگنا:16 تا 40 سینٹی گریڈ\nٹلرنگ: 25 تا   30 سینٹی گریڈ\nتولیدی مرحلہ: 20 تا 25 سینٹی گریڈ\nدانے بھرنا: 20 تا 30 سینٹی گریڈ\nسردی حساسیت: 18سینٹی گریڈ سے کم ہونے پر نشوونما متاثر ہوتی ہے۔\n\n<b>بارش اور نمی</b><br/>\nسالانہ 1000 تا 2000 ملی میٹر بارش ضروری ہے ۔<br/>\n<b>روشنی</b><br/>\nروزانہ 4 تا 5 گھنٹے دھوپ ضروری ہے۔', 4),
(13, 1, 'ur', 'مٹی کے تقاضے', '<b>مٹیلی زمین بہترین۔</b><br/>\nمٹیلی دوڑ مناسب۔\nریتیلی دوڑ مضبوط سبزہ واری کے لیے اچھی۔\n\nپی ایچ: 5.5- 7.0\n\n<b>مٹی کی تیاری</b><br/>\nہل چلانا، کھیت میں پانی بھرنا، پلنگ کرنا اور سطح ہموار کرنا۔', 5),
(14, 1, 'ur', 'بونے کا وقت', '<b>نرسری طریقہ</b><br/>\nپنجاب: مئی تا جون\nسندھ: جون تا جولائی\nنرسری مدت: 25 تا 30 دن\nبیج مقدار: 5 تا 8 کلو فی ایکڑ\n\n<b>براہ راست بونا</b><br/>\nمحنت کم، تیز بونا\nبیج مقدار: 12 تا 15 کلو فی ایکڑ', 6),
(15, 1, 'ur', 'کھادوں کا شیڈول', 'نائٹروجن: 100 تا 150 کلو فی ایکڑ\nفاسفورس: 20 تا 30 کلو فی ایکڑ\nپوٹاشیم: 20 تا 25 کلو فی ایکڑ\nزنک: 10 تا 12 کلو فی ایکڑ\n\n<b>شیڈول</b><br/>\nبیسل: ڈی-اے-پی+ ایس-او-پی + آدھی یوریا\nٹلرنگ: 25٪ یوریا\nپینیکل: باقی 25٪ یوریا', 7),
(16, 1, 'ur', 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b>جڑی بوٹیاں</b><br/>\n ڈیلا، واٹر گراس، بارن یارڈ گراس<br/>\n<b>جڑی بوٹیوں کا کنٹرول</b><br/>\nبوائی کے فوراً بعد پری ایمرجنس گھاس مار ادویات کا استعمال (جیسے بوٹا کلور)\nروایتی ہاتھ سے گوڈی یا نکائی\nکھیت میں مناسب پانی کی سطح برقرار رکھنا تاکہ جڑی بوٹیاں دب جائیں<br/>\n<b>بڑے نقصان دہ کیڑے</b><br/>\n<b>اسٹیم بوّر (تنے کا کیڑا)</b><br/>\nیہ سفید رنگ کا سنڈا تنا چیر کر اندر داخل ہو جاتا ہے<br/>\nنقصان\nپودے کے درمیان سے خشک ہونااور خوشے سفید پڑ جانا <br/>\nلیف <b>فولڈر (پتی لپیٹنے والا کیڑا)</b><br/>\nپتی کو لپیٹ کر اندر سے کھاتا ہے<br/>\nنقصان\nپتی کا سبز حصہ بُری طرح متاثر ہوتا ہے<br/>\n<b>براؤن پلانٹ ہوپر </b><br/>\nپودے کا رس چوستا ہے<br/>\nنقصان\nزیادہ حملہ ہو تو پورا کھیت جھلس کر بھورا ہو جاتا ہے<br/>\n<b>کیڑوں کا کنٹرول</b><br/>\nکیڑے کی نوعیت کے مطابق کاربوفیوران، امیڈاکلوپرڈ یا فیپرونل کا سپرے<br/>\n <b>بڑی بیماریاں</b><br/>\n<b>بلاسٹ بیماری</b>\nپتوں پر دھبے، اور خوشے کے اوپر والے حصے پر نیک بلاسٹ \nپیداوار میں واضح کمی<br/>\n<b>شیٹھ بلائٹ</b>\nیہ فنگس پودے کے نچلے پتوں اور غلاف پر حملہ کرتی ہے\nپودا کمزور ہو جاتا ہے اور دانہ صحیح نہیں بنتا<br/>\n<b>بیکٹیریل لیف بلائٹ</b>\nپتوں کا پیلا ہونا، سرے سے خشک ہونا\nپودا قبل از وقت بوڑھا ہو جاتا ہے<br/>\n<b>بیماریوں کا کنٹرول</b>\nبیماریوں کے خلاف مزاحمت رکھنے والی اقسام کا استعمال\nکھیت میں پانی کی نکاسی بہتر رکھنا\nضرورت پڑنے پر ٹریسائکلوزول یا پروپیکونازول کا سپرے\nضرورت سے زیادہ نائٹروجن (یوریا) ہرگز نہ ڈالیں\n', 8),
(17, 1, 'ur', 'فصل کاٹنے کا وقت', 'دانے سنہری ہو جائیں، نمی 20 تا 24٪ ہو، اور 80 تا 90٪ دانے پک جائیں تو فصل تیار ہوتی ہے۔', 9),
(18, 2, 'en', 'Introduction', 'Potato is one of the most important food crops in the world. It belongs to the Solanaceae family, which also includes tomato, chili, and eggplant. Potatoes are grown for their underground stems called tubers, which are rich in carbohydrates, vitamins, and minerals.\n\n<b><u>Key Characteristics of Potato:</u></b>\nGrows best in cool climates.\nPlant height generally 60 to 100 cm depending on variety.\nHas compound green leaves arranged spirally.\nTubers grow underground on stolons, not roots.\nShallow root system (80 to 120 cm).\n\n<b><u>Global Importance:</u></b>\nWorld production: More than 375 million tons annually.\nMajor producers: China, India, Russia, Ukraine, USA, Germany.\nPotatoes are the 4th most consumed food crop after rice, wheat, and maize.\n\n<b><u>Importance for Farmers:</u></b>\nHigh demand in markets and processing factories (chips, fries).\nShort duration crop (70 to 120 days).\nHigh yield per acre compared to other vegetables.\nCan be grown in many soil types and climates.', 0),
(19, 2, 'en', 'Climate Requirement', 'Potatoes require cool, moist climatic conditions for best performance.\n\n<b><u>Temperature:</u></b>\nIdeal sprouting temperature: 15 to 20°C\nVegetative growth: 18 to 24°C\nTuber formation: 15 to 20°C\nPoor growth above: 30°C\nFrost can damage young plants.\n\n<b><u>Rainfall & Humidity:</u></b>\nTotal requirement: 500 to 700 mm during the crop cycle.\nHumidity: 60 to 80%\nHigh humidity encourages diseases, so ventilation is important.\n\n<b><u>Sunlight:</u></b>\nPotato requires 6 to 7 hours of sunlight per day.\nCloudy weather during tuber development reduces yield.\n\n<b><u>Wind:</u></b>\nStrong winds can damage potato foliage and reduce photosynthesis.', 1),
(20, 2, 'en', 'Soil Requirement', 'Potatoes grow best in soils that are loose, fertile, and well-drained.\n\n<b><u>Best Soil Types:</u></b>\nSandy loam (ideal)\nLoam\nSilt loam\n\n<b><u>Soil pH:</u></b>\nIdeal pH: 5.2 to 6.5\nSlightly acidic soils reduce scab disease.\n\n<b><u>Important Soil Properties:</u></b>\nSoil must not be compact.\nShould be rich in organic matter.\nShould not have stones.\nMust hold moisture but not become waterlogged.\n\n<b><u>Soil Preparation:</u></b>\nDeep ploughing to break hardpan.\nApply 8 to 10 tons/acre well-decomposed farmyard manure.\nUse rotavator to make fine tilth.\nCreate raised beds or ridges.\nEnsure level land.', 2),
(21, 2, 'en', 'Sowing Time', '<b><u>Ideal Sowing Seasons:</u></b>\nAutumn to Winter Crop: October to December\nSpring Crop: January to February\n\n<b><u>Seed Tubers:</u></b>\nUse certified, disease-free tubers.\nWeight: 30 to 50 grams each.\nSprout length: 1 to 2 cm.\nCut large tubers and dry 24 hours.\n\n<b><u>Seed Rate:</u></b>\n700 to 1000 kg per acre.\n\n<b><u>Planting Method:</u></b>\nPlant 7 to 10 cm deep.\nRow spacing: 60 to 70 cm.\nPlant spacing: 20 to 25 cm.\nSprouts must face upward.', 3),
(22, 2, 'en', 'Fertilizer Schedule', '<b><u>Recommended Fertilizer Dose</u> (per acre):</b>\nUrea: 50 to 60 kg\nDAP: 45 to 50 kg\nPotash: 25 to 30 kg\nZinc Sulfate: 5 to 10 kg\nGypsum: 20 to 25 kg\nOrganic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\nBasal Dose: Full DAP, SOP, Zinc, Half Urea, Gypsum\nAfter 25-30 days: 25% Urea\nAfter 40-45 days: Remaining 25% Urea\n\n<b><u>Importance:</u></b>\nNitrogen: foliage growth\nPhosphorus: root development\nPotassium:tuber quality\nZinc: prevents stunted growth', 4),
(23, 2, 'en', 'Weeds, Pests and Diseases', '<b><u>Weeds:</u></b>\nBathu, Dela, Wild mustard, Grasses\n<b>Control:</b> weeding + Metribuzin\n\n<b>Pests:</b>\nAphids:Imidacloprid\nCutworms:Chlorpyrifos\nWhiteflies: Thiamethoxam\n\n<b><u>Diseases:</u></b>\nLate Blight:Mancozeb, Ridomil\nEarly Blight: Mancozeb\nCommon Scab: moisture control', 5),
(24, 2, 'en', ' Harvesting', 'Harvest after 90 to 120 days.\nWhen vines turn yellow.', 6),
(25, 2, 'ur', 'تعارف', 'آلو دنیا کی سب سے اہم غذائی فصلوں میں سے ایک ہے۔ یہ سولانیسی خاندان سے تعلق رکھتا ہے جس میں ٹماٹر، مرچ اور بینگن بھی شامل ہیں۔ آلو زمین کے اندر اگنے والے تنوں جنہیں ٹبر (گانٹھیں) کہا جاتا ہے کے لیے کاشت کیا جاتا ہے، جو کاربوہائیڈریٹس، وٹامنز اور معدنیات سے بھرپور ہوتے ہیں۔\n\n<b>آلو کی اہم خصوصیات</b>\nٹھنڈے موسم میں بہترین نشوونما پاتا ہے۔\nپودے کی اونچائی عام طور پر 60 سے 100 سینٹی میٹر ہوتی ہے، جو قسم پر منحصر ہے۔\nسبز مرکب پتے ہوتے ہیں جو گھومتی ترتیب میں لگے ہوتے ہیں۔\nگانٹھیں جڑوں پر نہیں بلکہ اسٹولونز پر زمین کے اندر بنتی ہیں۔\nجڑوں کا نظام سطحی ہوتا ہے (80 سے 120 سینٹی میٹر)۔\n\n<b>عالمی اہمیت</b>\nدنیا میں سالانہ پیداوار 375 ملین ٹن سے زیادہ ہے۔\nبڑے پیدا کرنے والے ممالک: چین، بھارت، روس، یوکرین، امریکہ، جرمنی۔\nآلو دنیا کی چوتھی سب سے زیادہ استعمال ہونے والی فصل ہے (چاول، گندم اور مکئی کے بعد)۔\n\n<b>کسانوں کے لیے اہمیت</b>\nمارکیٹ اور پراسیسنگ فیکٹریوں (چپس، فرائز) میں زیادہ مانگ۔\nکم دورانیہ والی فصل (70 سے 120 دن)۔\nدیگر سبزیوں کے مقابلے میں فی ایکڑ زیادہ پیداوار۔\nمختلف اقسام کی مٹی اور موسم میں کاشت کی جا سکتی ہے۔', 0),
(26, 2, 'ur', 'موسمی تقاضے', 'آلو کی بہترین پیداوار کے لیے ٹھنڈا اور مرطوب موسم ضروری ہوتا ہے۔\n\n<b>درجہ حرارت</b>\nاگاؤ کے لیے مثالی درجہ حرارت: 15 سے 20 ڈگری سینٹی گریڈ\nنشوونما کے لیے: 18 سے 24 ڈگری سینٹی گریڈ\nگانٹھ بننے کے لیے: 15 سے 20 ڈگری سینٹی گریڈ\n30 ڈگری سے زیادہ پر نشوونما متاثر ہوتی ہے\nپالا کم عمر پودوں کو نقصان پہنچا سکتا ہے\n\n<b>بارش اور نمی</b>\nکل ضرورت: 500 سے 700 ملی میٹر\nنمی: 60 سے 80 فیصد\nزیادہ نمی بیماریوں کو بڑھاتی ہے، اس لیے ہوا کا گزر ضروری ہے\n\n<b>دھوپ</b>\nروزانہ 6 سے 7 گھنٹے دھوپ ضروری ہے\nبادل والا موسم پیداوار کم کر دیتا ہے\n\n<b>ہوا</b>\nتیز ہوائیں پودے کو نقصان پہنچاتی ہیں اور ضیائی تالیف کم کرتی ہیں', 1),
(27, 2, 'ur', 'مٹی کے تقاضے', 'آلو کے لیے ڈھیلی، زرخیز اور اچھی نکاسی والی مٹی بہترین ہوتی ہے۔\n\n<b>بہترین مٹی کی اقسام</b>\nریتلی دوامی (سب سے بہتر)\nدوامی\nسلٹ دوامی\n\n<b>پی ایچ</b>\n5.2 سے 6.5 بہترین ہے\nہلکی تیزابی مٹی اسکیب بیماری کو کم کرتی ہے\n\n<b>اہم خصوصیات</b>\nمٹی سخت نہ ہو\nنامیاتی مادہ زیادہ ہو\nپتھر نہ ہوں (ورنہ گانٹھیں خراب ہوں گی)\nنمی برقرار رکھے لیکن پانی کھڑا نہ ہو\n\n<b>زمین کی تیاری</b>\nگہرا ہل چلائیں\n8 سے 10 ٹن فی ایکڑ گوبر کی کھاد ڈالیں\nروٹاویٹر سے باریک مٹی تیار کریں\nبیڈ یا کھیلیاں بنائیں\nزمین ہموار رکھیں', 2),
(28, 2, 'ur', 'بونے کا وقت', '<b>بوائی کے موزوں اوقات</b>\nاکتوبر سے دسمبر (اہم فصل)\nجنوری سے فروری (بہار کی فصل)\n\n<b>بیج گانٹھیں</b>\nمصدقہ اور بیماری سے پاک گانٹھیں استعمال کریں\nوزن: 30 سے 50 گرام\nانکر کی لمبائی: 1 سے 2 سینٹی میٹر\nبڑی گانٹھوں کو کاٹ کر 24 گھنٹے سکھائیں\n\n<b>بیج کی مقدار</b>\n700 سے 1000 کلوگرام فی ایکڑ\n\n<b>طریقہ کاشت</b>\n7 سے 10 سینٹی میٹر گہرائی میں لگائیں\nقطاروں کا فاصلہ: 60 سے 70 سینٹی میٹر\nپودوں کا فاصلہ: 20 سے 25 سینٹی میٹر\nانکر اوپر کی طرف ہونا چاہیے', 3),
(29, 2, 'ur', 'کھادوں کا شیڈول', '<b>فی ایکڑ کھاد کی مقدار</b>\nیوریا: 50 سے 60 کلوگرام\nڈی اے پی: 45 سے 50 کلوگرام\nپوٹاش: 25 سے 30 کلوگرام\nزنک سلفیٹ: 5 سے 10 کلوگرام\nجپسم: 20 سے 25 کلوگرام\nنامیاتی کھاد: 8 سے 10 ٹن\n\n<b>کھاد ڈالنے کا طریقہ</b>\nابتدائی مرحلہ: مکمل ڈی اے پی، پوٹاش، زنک، آدھی یوریا، جپسم\n25-30 دن بعد: 25 فیصد یوریا\n40-45 دن بعد: باقی 25 فیصد یوریا\n\n<b>اہمیت</b>\nنائٹروجن: پتوں کی بڑھوتری\nفاسفورس: جڑوں کی مضبوطی\nپوٹاشیم: گانٹھوں کا سائز اور معیار\nزنک: پودے کی بہتر نشوونما', 4),
(30, 2, 'ur', 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b>جڑی بوٹیاں</b>\nباتھو \nڈیلا \nجنگلی سرسوں\nگھاس\n\n<b>کنٹرول</b>\nپہلی گوڈی: 20 سے 25 دن\nدوسری گوڈی: 40 دن\nکیمیائی کنٹرول: میٹریبوزن\n\n<b>کیڑے</b>\nایفڈز: رس چوستے ہیں → پودا کمزور\nکنٹرول: امیڈاکلوپرڈ\n\nکٹ ورمز: تنے کو کاٹ دیتے ہیں\nکنٹرول: کلورپائریفوس / لیمبڈا سائیہالوترین\n\n:سفید مکھی\nوائرل بیماریاں پھیلاتی ہے\nکنٹرول: تھیامیٹھوکسام\n\n<b>بیماریاں</b>\n:لیٹ بلائٹ\nپتوں پر سیاہ دھبے\nکنٹرول: مینکوزیب، ریڈومل\n\n:ارلی بلائٹ\nگول دھبے\nکنٹرول: مینکوزیب\n\n:اسکیب\nکھردری سطح\nکنٹرول: نمی برقرار رکھیں', 5),
(31, 2, 'ur', 'فصل کاٹنے کا وقت', 'جب پتے پیلے اور خشک ہو جائیں', 6),
(32, 3, 'en', 'Introduction', 'Wheat is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes rice, maize, and barley. Wheat is primarily grown for its grains, which are used to produce flour for bread, chapati, pasta, and many other food products.\n\n<b><u> Key Characteristics of Wheat</u></b>\n Cool-season crop (Rabi crop)\n Plant height: 60 to 120 cm (varies by variety)\nStem: hollow (except nodes)\n Leaves: long, narrow, and green\nRoot system: fibrous and moderately deep\nGrain: rich in carbohydrates, protein (gluten), vitamins, and minerals\n\n<b><u> Global Importance</u></b>\n One of the top 3 staple crops (with rice and maize)\n Annual global production: 750+ million tons\n Major producers: China, India, Russia, USA, France, Canada\n Staple food for over 35% of the world population\n\n <b><u>Importance for Farmers</u></b>\n High demand in local and global markets\n Essential food crop in Pakistan\nEasy to store compared to vegetables\n Mechanized farming possible\n Stable income crop', 0),
(33, 3, 'en', 'Climate Requirement', 'Wheat grows best in cool and dry climates.\n\n <b><u>Temperature</u></b>\n Germination: 12 to 25°C\n Tillering stage: 16 to 20°C\n Grain filling: 20 to 25°C\n Above 30°C during grain filling → reduces yield\n Frost can damage crop at flowering stage\n\n<b><u> Rainfall & Moisture</u></b>\n Total requirement: 300–500 mm\n Needs moisture during early growth and grain filling\n Excess rain → lodging and disease risk\n\n <b><u>Sunlight</u></b>\n Requires bright sunlight\n Clear weather during grain filling improves grain quality\n\n<b><u> Wind</u></b>\n Strong winds can cause lodging (plants fall down)', 1),
(34, 3, 'en', 'Soil Requirement', 'Wheat can grow in various soils but performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types</u></b>\nLoam (ideal)\n Clay loam\nSilt loam\n\n<b><u|> Soil pH</u></b>\n Ideal range: 6.0 to 7.5\n\n <b><u>Important Soil Properties</u></b>\n Good drainage (no waterlogging)\n Moderate water-holding capacity\n Rich in organic matter\n Level field for uniform irrigation\n\n<b><u> Soil Preparation</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and previous crop residues\n Apply farmyard manure (5 to 8 tons/acre)\n Level land properly (laser leveling is best)', 2),
(35, 3, 'en', ' Sowing Time', ' <b><u>Ideal Sowing Time </u></b>\n Punjab & Sindh: 15 October to 30 November (best)\nLate sowing → lower yield\n\n <b><u>Seed Selection</u></b>\n Use certified, disease-free seeds\n Popular varieties:\n  Faisalabad-2008\n  Galaxy-2013\n  Punjab-2011\n\n <b><u>Seed Rate</u></b>\n 40 to 50 kg per acre\n\n <b><u>Sowing Method</u></b>\n Drill method (recommended)\n Row spacing: 9 to 12 inches\n Depth: 3 to 5 cm', 3),
(36, 3, 'en', '5. Fertilizer Schedule', 'Wheat requires balanced nutrients for high yield.\n\n <b><u>Recommended Dose </u>(Per Acre)</b>\nFertilizer\n Urea: 80 to 100 kg\n DAP: 50 kg\nPotash (SOP/MOP): 25 to 30 kg\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 5 to 8 tons\n\n <b><u>Application Schedule</u></b>\n1. Basal Dose (At Sowing)\nFull DAP\nFull Potash\n Half Urea\n Zinc\n\n2. First Irrigation (20 to 25 Days)\n 25% Urea\n\n3. Second Irrigation (40 to 45 Days)\n Remaining 25% Urea\n\n<b><u> Nutrient Importance</u></b>\n Nitrogen: Leaf growth, tillering\nPhosphorus: Root development\n Potassium: Strength, disease resistance\n Zinc: Better grain formation', 4),
(37, 3, 'en', '6. Weeds, Pests and Diseases', '<b>A.<u> Weeds</u></b>\n Common Weeds\n Bathu (Chenopodium)\nWild oats (Jangli jai)\n Dela (Cyperus)\n Broadleaf weeds\n\n<b><u>Control</u></b>\nWeeding at 20 to 30 days\n Chemical control:\n  Isoproturon\n  Topik\n  Puma Super\n\n<b>B.<u> Pests</u></b>\n Aphids\n Damage: Sap sucking → weak plants\n Control: Imidacloprid\n\n Termites\n Damage: Attack roots and stems\n Control: Chlorpyrifos\n\n<b>C.<u> Diseases</u></b>\n Rust (Zang)\nTypes:\n Leaf rust\n Stem rust\n Stripe rust\n\nCause: Puccinia species\n\nSymptoms:\n Orange/yellow powder on leaves\n Reduced grain filling\n\nControl:\n Resistant varieties\n Fungicide spray (Tilt, Score)\n\n Smut\nBlack powder in grains\nControl: Seed treatment before sowing\n\n Powdery Mildew\n White powder on leaves\nControl: Fungicide spray', 5),
(38, 3, 'en', '7. Harvesting', ' <b><u>Harvesting Time</u></b>\n April – May\n\n <b><u>When:</u></b>\n Crop turns golden yellow\n Grains become hard\n Moisture content ~12 to 14%', 6),
(39, 3, 'ur', 'تعارف', 'گندم دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوئیسی خاندان سے تعلق رکھتی ہے، جس میں چاول، مکئی اور جو شامل ہیں۔ گندم بنیادی طور پر اس کے دانوں کے لیے اگائی جاتی ہے، جن سے آٹا، روٹی، چپاتی، پاستا اور دیگر غذائی مصنوعات تیار کی جاتی ہیں۔\n\n<b> گندم کی اہم خصوصیات</b>\n سرد موسم کی فصل (ربیع کی فصل)\nپودے کی اونچائی: 60 سے 120 سینٹی میٹر (قسم کے مطابق مختلف)\nتنا: کھوکھلا ہوتا ہے (گرہوں کے علاوہ)\n پتے: لمبے، باریک اور سبز\nجڑوں کا نظام: ریشہ دار اور درمیانی گہرائی تک\n دانہ: کاربوہائیڈریٹس، پروٹین (گلوٹن)، وٹامنز اور معدنیات سے بھرپور\n\n <b>عالمی اہمیت</b>\n دنیا کی تین بڑی بنیادی غذائی فصلوں میں شامل (چاول اور مکئی کے ساتھ)\n سالانہ عالمی پیداوار: 750 ملین ٹن سے زیادہ\nبڑے پیدا کرنے والے ممالک: چین، بھارت، روس، امریکہ، فرانس، کینیڈا\n- دنیا کی 35 فیصد سے زائد آبادی کی بنیادی غذا\n\n<b> کسانوں کے لیے اہمیت</b>\n مقامی اور عالمی منڈیوں میں زیادہ طلب\n پاکستان کی بنیادی غذائی فصل\n- سبزیوں کے مقابلے میں ذخیرہ کرنا آسان\nمشینی کاشت ممکن\nمستحکم آمدنی دینے والی فصل', 0),
(40, 3, 'ur', 'موسمی تقاضے', 'گندم ٹھنڈے اور خشک موسم میں بہترین اگتی ہے۔\n\n <b>درجہ حرارت</b>\n اگاؤ: 12 سے 25 ڈگری سینٹی گریڈ\n ٹلرنگ مرحلہ: 16 سے 20 ڈگری سینٹی گریڈ\n دانہ بھرنے کا مرحلہ: 20 سے 25 ڈگری سینٹی گریڈ\n- دانہ بھرنے کے دوران 30 ڈگری سینٹی گریڈ سے زیادہ درجہ حرارت پیداوار کم کر دیتا ہے\n پھول آنے کے وقت کہر فصل کو نقصان پہنچا سکتی ہے\n\n <b>بارش اور نمی</b>\n کل ضرورت: 300 سے 500 ملی میٹر\nابتدائی بڑھوتری اور دانہ بھرنے کے وقت نمی ضروری ہوتی ہے\n زیادہ بارش سے فصل گرنے  اور بیماریوں کا خطرہ بڑھ جاتا ہے\n\n <b>دھوپ</b>\n تیز دھوپ ضروری ہے\n دانہ بھرنے کے دوران صاف موسم دانے کے معیار کو بہتر بناتا ہے\n\n<b> ہوا</b>\n تیز ہوائیں فصل کو گرا سکتی ہیں ', 1),
(41, 3, 'ur', 'مٹی کے تقاضے', 'گندم مختلف اقسام کی مٹی میں اگ سکتی ہے لیکن زرخیز اور اچھی نکاسی والی مٹی میں بہترین پیداوار دیتی ہے۔\n\n <b>بہترین مٹی کی اقسام</b>\n میرا  — سب سے بہتر\n چکنی میرا \n سلٹی میرا \n\n <b>پی ایچ</b>\n مثالی حد: 6.0 سے 7.5\n\n <b>اہم خصوصیات</b>\n- پانی کے نکاس کا اچھا نظام (پانی کھڑا نہ ہو)\nدرمیانی پانی رکھنے کی صلاحیت\n نامیاتی مادہ سے بھرپور\nزمین ہموار ہو تاکہ آبپاشی یکساں ہو\n\n <b>مٹی کی تیاری</b>\n 2 سے 3 ہل چلا کر نرم بیج بستر تیار کریں\n جڑی بوٹیاں اور پچھلی فصل کی باقیات ختم کریں\n 5 سے 8 ٹن فی ایکڑ گوبر کی کھاد ڈالیں\nزمین کو اچھی طرح ہموار کریں (لیزر لیولنگ بہترین ہے)', 2),
(42, 3, 'ur', 'بونے کا وقت', '<b> موزوں کاشت کا وقت</b>\n پنجاب اور سندھ: 15 اکتوبر سے 30 نومبر (بہترین)\n دیر سے کاشت کرنے سے پیداوار کم ہو جاتی ہے\n\n<b>بیج کا انتخاب</b>\n تصدیق شدہ اور بیماری سے پاک بیج استعمال کریں\nمشہور اقسام:\n  فیصل آباد-2008\n  گلیکسی-2013\n  پنجاب-2011\n\n <b>بیج کی مقدار</b>\n 40 سے 50 کلوگرام فی ایکڑ\n\n <b>بوائی کا طریقہ</b>\n ڈرل طریقہ (سفارش کردہ)\nقطاروں کا فاصلہ: 9 سے 12 انچ\nگہرائی: 3 سے 5 سینٹی میٹر', 3),
(43, 3, 'ur', 'کھادوں کا شیڈول', 'گندم کو زیادہ پیداوار کے لیے متوازن غذائی اجزاء درکار ہوتے ہیں۔\n\n <b>سفارش کردہ مقدار (فی ایکڑ)</b>\nکھاد\n یوریا: 80 سے 100 کلوگرام\n ڈی اے پی: 50 کلوگرام\n پوٹاش (SOP/MOP): 25 سے 30 کلوگرام\n- زنک سلفیٹ: 5 سے 10 کلوگرام\n نامیاتی کھاد: 5 سے 8 ٹن\n\n <b>استعمال کا شیڈول</b>\n بوائی کے وقت \n- مکمل ڈی اے پی\n مکمل پوٹاش\nآدھی یوریا\n- زنک\n\nپہلی آبپاشی (20 سے 25 دن بعد)\n 25 فیصد یوریا\n\n دوسری آبپاشی (40 سے 45 دن بعد)\n باقی 25 فیصد یوریا\n\n <b>غذائی اجزاء کی اہمیت</b>\nنائٹروجن: پتوں کی بڑھوتری اور ٹلرنگ\n فاسفورس: جڑوں کی نشوونما\nپوٹاشیم: مضبوطی اور بیماریوں کے خلاف مزاحمت\nزنک: دانے کی بہتر تشکیل', 4),
(44, 3, 'ur', 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b> جڑی بوٹیاں</b>\n عام جڑی بوٹیاں\n- باتھو \nجنگلی جئی \n- ڈیلا \n- چوڑی پتوں والی جڑی بوٹیاں\n\n <b>کنٹرول</b>\nگوڈی 20سے30دن میں کریں\n<b> کیڑے</b>\n ایفڈز\n- نقصان: رس چوس کر پودوں کو کمزور کرتے ہیں\n دیمک\n- نقصان: جڑوں اور تنوں پر حملہ کرتے ہیں\n<b> بیماریاں</b>\n زنگ \nاقسام:\n لیف رسٹ\n اسٹیم رسٹ\nاسٹرائپ رسٹ\n<b>علامات</b>\n- پتوں پر نارنجی یا پیلے رنگ کا پاؤڈر\n دانہ بھرنے میں کمی\n\n<b>کنٹرول</b>\n مزاحم اقسام استعمال کریں\n فنگس کش اسپرے \n\n سموٹ \n دانوں میں سیاہ پاؤڈر\n کنٹرول: بوائی سے پہلے بیج کا ٹریٹمنٹ\n\n پاؤڈری میلڈیو\n پتوں پر سفید پاؤڈر\n کنٹرول: فنگس کش اسپرے', 5),
(45, 3, 'ur', 'فصل کاٹنے کا وقت', '  اپریل سے مئی\nفصل سنہری پیلی ہو جائے\nدانے سخت ہو جائیں\n نمی تقریباً 12 سے 14 فیصد ہو', 6),
(46, 4, 'en', ' Introduction', 'Maize is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes wheat, rice, and barley. Maize is primarily grown for its grains, which are used for human food, animal feed, and industrial products like starch, oil, and biofuel.\n\n<b><u>Key Characteristics of Maize:</u></b>\n Warm-season crop (Kharif crop)\n Plant height: 150 to 300 cm (varies by variety)\nStem: solid and thick\n Leaves: long, broad, and green\n Root system: fibrous and deep\nGrain: rich in carbohydrates, oil, protein, vitamins, and minerals\n\n<b><u>Global Importance:</u></b>\n One of the top 3 staple crops (with wheat and rice)\nAnnual global production: 1100+ million tons\n Major producers: USA, China, Brazil, Argentina, India\n Widely used in food industry and livestock feed\n\n<b><u>Importance for Farmers:</u></b>\n High yield potential\n Used as food and fodder\nHigh demand in poultry feed industry\n Suitable for mechanized farming\nProvides stable and profitable income', 0),
(47, 4, 'en', ' Climate Requirement', 'Maize grows best in warm and moderately humid climates.\n\n<b><u>Temperature:</u></b>\nGermination: 18 to 25°C\n Vegetative growth: 25 to 30°C\n Grain filling: 20 to 25°C\nBelow 10°C → poor growth\n Above 35°C → heat stress and reduced yield\n\n<b><u>Rainfall & Moisture:</u></b>\n Total requirement: 500 to 800 mm\nNeeds adequate moisture during germination and flowering\n Water stress at tasseling stage → severe yield loss\n Excess water → root damage and diseases\n\n<b><u>Sunlight:</u></b>\n Requires full sunlight for optimal growth\n Low light reduces yield\n\n<b><u>Wind:</u></b>\n Strong winds may cause lodging (plants fall over)', 1),
(48, 4, 'en', ' Soil Requirement', 'Maize performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types:</u></b>\n Loam (ideal)\n Sandy loam\n Silt loam\n\n<b><u>Soil pH:</u></b>\n Ideal range: 5.5 to 7.5\n\n<b><u>Important Soil Properties:</u></b>\nGood drainage (avoid waterlogging)\n High fertility\n Adequate organic matter\n Proper soil aeration\n\n<b><u>Soil Preparation:</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and crop residues\nApply farmyard manure (8 to 10 tons/acre)\nLevel the land properly', 2),
(49, 4, 'en', ' Sowing Time', '<b><u>Ideal Sowing Time :</u></b>\n Spring crop: January to February\n Kharif crop: June to July (best season)\n\n<b><u>Seed Selection:</u></b>\nUse certified, hybrid, and disease-free seeds\n Popular hybrids: Pioneer, Monsanto, Local approved hybrids\n\n<b><u>Seed Rate:</u></b>\n 20 to 25 kg per acre\n\n<b><u>Sowing Method:</u></b>\n Drill method (recommended)\nRow spacing: 60 to 75 cm\n Plant spacing: 20 to 25 cm\n Seed depth: 3 to 5 cm', 3),
(50, 4, 'en', ' Fertilizer Schedule', '<b><u>Recommended Dose</u> (Per Acre)</b>:\n Urea: 2 bags\nDAP: 1 bag\n Potash: 1/2 bag\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\n1. Basal Dose (At Sowing): Full DAP, Full Potash, Half Urea, Zinc Sulfate\n2. First Irrigation (20 to 25 Days After Sowing): Apply 25% Urea\n3. Second Irrigation (40 to 45 Days After Sowing): Apply remaining 25% Urea\n\n<b><u>Nutrient Importance:</u></b>\n Nitrogen: Promotes leaf growth and yield\n Phosphorus: Enhances root development\nPotassium: Improves plant strength and disease resistance\n Zinc: Helps in better grain formation', 4),
(51, 4, 'en', ' Weeds, Pests and Diseases', '<b>A.<u> Weeds:</u></b>\n Common Weeds: Grasses, Bathu (Chenopodium), Dela (Cyperus), Broadleaf weeds\n <b><u>Control:</u></b> Manual weeding at 20 to 30 days, Chemical control: Atrazine, Pendimethalin\n\n<b>B. <u>Pests:</u></b>\n Stem Borer: Feeds inside the stem, weakens the plant. <b><u>Control:</u></b> Chlorantraniliprole spray\n Fall Armyworm: Feeds on leaves, severe damage. <b><u>Control:</u></b> Emamectin Benzoate\n Aphids: Suck plant sap, reduce growth. <b><u>Control:</u></b> Imidacloprid\n\n<b>C.<u> Diseases:</u></b>\n Leaf Blight: Brown lesions on leaves. Control: Fungicide application\n Rust: Orange or brown powder on leaves. Control: Resistant varieties and fungicide spray\n Downy Mildew: Yellowing and stunted plants. Control: Seed treatment before sowing', 5),
(52, 4, 'en', ' Harvesting', '<b><u>Harvesting Time:</u></b>\n 90 to 120 days after sowing\n\n<b><U>When to Harvest:</u></b>\nHusks turn dry\nGrains become hard\n Moisture content around 20 to 25%', 6),
(53, 4, 'ur', ' تعارف', 'مکئی دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوایسیا فیملی سے تعلق رکھتی ہے، جس میں گندم، چاول، اور جو شامل ہیں۔ مکئی بنیادی طور پر اپنے دانوں کے لیے اگائی جاتی ہے، جو انسانی غذا، جانوروں کے چارہ، اور صنعتی مصنوعات جیسے نشاستہ، تیل، اور بایوفیول میں استعمال ہوتے ہیں۔\n\n<b>مکئی کی اہم خصوصیات</b>\n- گرم موسم کی فصل (کھڑی فصل)\n- پودے کی اونچائی: 150 سے 300 سینٹی میٹر (نسل کے حساب سے مختلف)\n- تنے: مضبوط اور موٹے\n- پتے: لمبے، چوڑے اور سبز\n- جڑ کا نظام: ریشے دار اور گہرا\n- دانہ: کاربوہائیڈریٹس، تیل، پروٹین، وٹامنز اور معدنیات سے بھرپور\n\n<b>عالمی اہمیت</b>\n- تین اہم غذائی فصلوں میں سے ایک (گندم اور چاول کے ساتھ)\n- سالانہ عالمی پیداوار: 1100+ ملین ٹن\n- بڑے پیدا کرنے والے ممالک: امریکہ، چین، برازیل، ارجنٹینا، بھارت\n- خوراک کی صنعت اور جانوروں کے چارہ میں وسیع استعمال\n\n<b>کسانوں کے لیے اہمیت</b>\n- زیادہ پیداوار کی صلاحیت\n- خوراک اور چارہ کے لیے استعمال\n- پولٹری فیڈ انڈسٹری میں زیادہ طلب\n- مشینی کھیتی کے لیے موزوں\n- مستحکم اور منافع بخش آمدنی فراہم کرتی ہے', 0),
(54, 4, 'ur', 'موسمی تقاضے', 'مکئی سب سے بہتر گرم اور معتدل نمی والے علاقوں میں اگتی ہے۔\n\n<b>درجہ حرارت</b>\n- اگنا: 18 سے 25°C\n- نشوونما: 25 سے 30°C\n- دانہ بھرنے کا مرحلہ: 20 سے 25°C\n- 10°C سے کم → کمزور نمو\n- 35°C سے زیادہ → حرارت کی شدت اور پیداوار میں کمی\n\n<b>بارش اور نمی</b>\n- کل ضرورت: 500 سے 800 ملی میٹر\n- اگنے اور پھولنے کے دوران مناسب نمی کی ضرورت\n- ٹیسلنگ مرحلے میں پانی کی کمی → شدید پیداوار کا نقصان\n- زیادہ پانی → جڑوں کو نقصان اور بیماریاں\n\n<b>روشنی</b>\n- مکمل دھوپ کی ضرورت\n- کم روشنی پیداوار کم کرتی ہے\n\n<b>ہوا</b>\n- شدید ہوائیں پودوں کو گرنے پر مجبور کر سکتی ہیں', 1),
(55, 4, 'ur', 'مٹی کے تقاضے', 'مکئی بہترین زرخیز اور پانی نکالنے والی مٹی میں اگتی ہے۔\n\n<b>مٹی کی بہترین اقسام</b>\n- لوئم (مثالی)\n- ریتلی لوئم\n- سیلٹ لوئم\n\n<b> پی ایچ</b>\n- مثالی حد: 5.5 سے 7.5\n\n<b>اہم مٹی کی خصوصیات</b>\n- اچھی نکاسی (پانی جمع ہونے سے بچیں)\n- زیادہ زرخیزی\n- مناسب نامیاتی مادہ\n- مناسب ہوا دار مٹی\n\n<b>مٹی کی تیاری</b>\n- باریک بیج بچھانے کے لیے 2 سے 3 ہل چلائیں\n- گھاس اور فصل کے باقیات ہٹائیں\n- فارم یارڈ کھاد لگائیں (8 سے 10 ٹن فی ایکڑ)\n- زمین کو مناسب سطح پر لیول کریں', 2),
(56, 4, 'ur', ' بونے کا وقت', '<b>پاکستان میں بونے کا مثالی وقت</b>\n- بہاری فصل: جنوری سے فروری\n- کھڑی فصل: جون سے جولائی (سب سے بہترین موسم)\n\n<b>بیج کا انتخاب</b>\n- تصدیق شدہ، ہائبرڈ، اور بیماری سے پاک بیج استعمال کریں\n- مشہور ہائبرڈز: پائنیئر، مونسانٹو، مقامی منظور شدہ ہائبرڈز\n\n<b>بیج کی مقدار</b>\n- 20 سے 25 کلوگرام فی ایکڑ\n\n<b>بونے کا طریقہ</b>\n- ڈرل طریقہ (سفارش کی جاتی ہے)\n- قطار کا فاصلہ: 60 سے 75 سینٹی میٹر\n- پودے کا فاصلہ: 20 سے 25 سینٹی میٹر\n- بیج کی گہرائی: 3 سے 5 سینٹی میٹر', 3),
(57, 4, 'ur', 'کھادوں کا شیڈول', '<b>فی ایکڑ تجویز شدہ خوراک</b>\n- یوریا: 2 تھیلے\n- ڈی اے پی: 1 تھیلا\n- پوٹاش: 1/2 تھیلا\n- زنک سلفیٹ: 5 سے 10 کلوگرام\n- نامیاتی کھاد: 8 سے 10 ٹن\n\n<b>درخواست کا شیڈول</b>\n1. بنیادی خوراک (بونے کے وقت): مکمل ڈی اے پی، مکمل پوٹاش، نصف یوریا، زنک سلفیٹ\n2. پہلی آبپاشی (بونے کے 20 سے 25 دن بعد): 25% یوریا لگائیں\n3. دوسری آبپاشی (بونے کے 40 سے 45 دن بعد): باقی 25% یوریا لگائیں\n\n<b>غذائی اجزاء کی اہمیت</b>\n- نائٹروجن: پتوں کی نمو اور پیداوار کو فروغ دیتا ہے\n- فاسفورس: جڑوں کی ترقی کو بہتر بناتا ہے\n- پوٹاشیم: پودے کی مضبوطی اور بیماریوں کی مزاحمت بڑھاتا ہے\n- زنک: دانے کی بہتر تشکیل میں مدد دیتا ہے', 4),
(58, 4, 'ur', ' جڑی بوٹیاں، کیڑے اور بیماریاں', '<b> جڑی بوٹیاں</b>\n- عام جڑی بوٹیاں: گھاس، بٹھو ، دیلا ، چوڑی پتیاں والی جڑی بوٹیاں\n- کنٹرول: 20 سے 30 دن بعد ہاتھ سے صفائی، کیمیائی کنٹرول: ایٹرازین، پینڈیمیتھالین\n\n<b> کیڑے</b>\n- اسٹیم بورر: تنوں کے اندر کھاتے ہیں، پودے کو کمزور کرتے ہیں۔ کنٹرول: کلورانٹرانیل پروائل سپرے\n- فال آرمی ورم: پتوں کو کھاتا ہے، شدید نقصان۔ کنٹرول: ایما میکٹن بینزویٹ\n- افڈز: پودے کا رس چوستے ہیں، نمو کم کرتے ہیں۔ کنٹرول: امیڈاکلوپریڈ\n\n<b> بیماریاں</b>\n- لیف بلیٹ: پتوں پر بھوری دھبے۔ کنٹرول: فنگسائیڈ لگائیں\n- رسٹ: پتوں پر نارنجی یا بھوری پاؤڈر۔ کنٹرول: مزاحم اقسام اور فنگسائیڈ سپرے\n- ڈاؤنی میلڈیو: پیلے پن اور بوجھل پودے۔ کنٹرول: بونے سے پہلے بیج کا علاج', 5),
(59, 4, 'ur', 'فصل کاٹنے کا وقت', '<b>کٹائی کا وقت</b>\n- 90 سے 120 دن بعد بونے کے\n\n<b>کٹائی کے اشارے</b>\n- بھوسے خشک ہو جائیں\n- دانے سخت ہو جائیں\n- نمی تقریباً 20 سے 25%', 6);

-- --------------------------------------------------------

--
-- Table structure for table `farm_data`
--

CREATE TABLE `farm_data` (
  `id` int(11) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `btn_crop_info` varchar(255) DEFAULT NULL,
  `btn_calculator` varchar(255) DEFAULT NULL,
  `btn_helpline` varchar(255) DEFAULT NULL,
  `switch_language` varchar(50) DEFAULT NULL,
  `about_heading` varchar(255) DEFAULT NULL,
  `about_p1` text DEFAULT NULL,
  `about_p2` text DEFAULT NULL,
  `about_p3` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_data`
--

INSERT INTO `farm_data` (`id`, `lang`, `title`, `subtitle`, `btn_crop_info`, `btn_calculator`, `btn_helpline`, `switch_language`, `about_heading`, `about_p1`, `about_p2`, `about_p3`) VALUES
(1, 'en', 'Welcome to FarmEase', 'A Bilingual Farming Support System', 'Crop Information', 'AgriCost and Profit guide', 'Contact with experts', 'اردو', 'About Us', 'Our project is a user-friendly agricultural platform that provides accurate and organized information about different crops, including costs and farming details. It is designed to help farmers and students easily access important knowledge in one place.', 'With a simple interface and bilingual support, the platform ensures accessibility for a wider audience.', 'This project aims to promote smart farming and improve decision-making through the use of technology.'),
(2, 'ur', 'فارم ایز میں خوش آمدید', 'دو لسانی زرعی معاون نظام', 'فصل کی معلومات', 'زرعی لاگت اورمنافع گائیڈ', 'ماہرین سے رابطہ', 'English', 'ہمارے بارے میں', 'ہمارا پروجیکٹ ایک صارف دوست زرعی پلیٹ فارم ہے جو مختلف فصلوں کے بارے میں درست اور منظم معلومات فراہم کرتا ہے، جیسے کہ اخراجات اور کاشتکاری کی تفصیلات۔ یہ کسانوں اور طلباء کو ایک جگہ پر اہم معلومات آسانی سے حاصل کرنے میں مدد کے لیے بنایا گیا ہے۔', 'سادہ انٹرفیس اور دو لسانی سہولت کے ساتھ، یہ پلیٹ فارم وسیع تر سامعین کے لیے قابل رسائی ہے۔', 'یہ پروجیکٹ ٹیکنالوجی کے استعمال سے ذہین زراعت کو فروغ دینے اور بہتر فیصلہ سازی کا مقصد رکھتا ہے۔');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `agri_cost`
--
ALTER TABLE `agri_cost`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crop_key` (`crop_key`);

--
-- Indexes for table `crops`
--
ALTER TABLE `crops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `crop_details`
--
ALTER TABLE `crop_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_guides`
--
ALTER TABLE `crop_guides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_images`
--
ALTER TABLE `crop_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_info`
--
ALTER TABLE `crop_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_sections`
--
ALTER TABLE `crop_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_data`
--
ALTER TABLE `farm_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `agri_cost`
--
ALTER TABLE `agri_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crop_details`
--
ALTER TABLE `crop_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `crop_guides`
--
ALTER TABLE `crop_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `crop_images`
--
ALTER TABLE `crop_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `crop_info`
--
ALTER TABLE `crop_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `crop_sections`
--
ALTER TABLE `crop_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `farm_data`
--
ALTER TABLE `farm_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
