-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 02:05 PM
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
(3, 'admin', '$2y$10$ibMhac98h81omxaUi0ZYh.ONXc1SGTBvzU7FZQ3qC1C.HgVWhpL8K');

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
(1, 'wheat', 'Wheat', 'گندم', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', ' Wheat\nTotal Estimated Cost: 55,000 – 70,000 PKR\n\nBreakdown:\nSeed: 4,000 – 6,000\nLand preparation: 6,000 – 8,000\nFertilizer: 18,000 – 25,000\nIrrigation: 5,000 – 8,000\nSpray: 3,000 – 5,000\nLabor: 5,000 – 7,000\nHarvesting: 8,000 – 12,000\n\nYield: 35 – 45 Maund\nRate: 3,000 – 3,500\nIncome: 105,000 – 150,000\nProfit: 40,000 – 80,000\n\nLow cost, low risk, stable crop', ' گندم\nکل تخمینی لاگت: 55,000 – 70,000 روپے\n\nتفصیل\nبیج: 4,000 – 6,000\nزمین کی تیاری: 6,000 – 8,000\nکھاد: 18,000 – 25,000\nآبپاشی: 5,000 – 8,000\nاسپرے: 3,000 – 5,000\nمزدوری: 5,000 – 7,000\nکٹائی: 8,000 – 12,000\n\nپیداوار: 35 – 45 من\nریٹ: 3,000 – 3,500\nآمدن: 105,000 – 150,000\nمنافع: 40,000 – 80,000\n\nکم لاگت، کم خطرہ، مستحکم فصل'),
(2, 'maize', 'Maize', 'مکئی', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', 'Maize\nTotal Estimated Cost: 65,000 – 85,000 PKR\n\nBreakdown:\nHybrid Seed: 8,000 – 12,000\nLand preparation: 6,000 – 8,000\nFertilizer: 20,000 – 28,000\nIrrigation: 6,000 – 10,000\nSpray: 4,000 – 7,000\nLabor: 5,000 – 8,000\nHarvesting: 8,000 – 12,000\n\nYield: 60 – 100 Maund\nRate: 2,200 – 2,800\nIncome: 130,000 – 220,000\nProfit: 60,000 – 130,000\n\nModerate investment, good profit', ' مکئی\nکل تخمینی لاگت: 65,000 – 85,000 روپے\n\nتفصیل\nہائبرڈ بیج: 8,000 – 12,000\nزمین کی تیاری: 6,000 – 8,000\nکھاد: 20,000 – 28,000\nآبپاشی: 6,000 – 10,000\nاسپرے: 4,000 – 7,000\nمزدوری: 5,000 – 8,000\nکٹائی: 8,000 – 12,000\n\nپیداوار: 60 – 100 من\nریٹ: 2,200 – 2,800\nآمدن: 130,000 – 220,000\nمنافع: 60,000 – 130,000\n\nدرمیانی سرمایہ، اچھا منافع'),
(3, 'potato', 'Potato', 'آلو', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', ' Potato\r\nTotal Estimated Cost: 120,000 – 160,000 PKR\r\nBreakdown:\r\nSeed: 60,000 – 90,000\r\nLand preparation: 8,000 – 10,000\r\nFertilizer: 20,000 – 30,000\r\nIrrigation: 8,000 – 12,000\r\nSpray: 6,000 – 10,000\r\nLabor: 10,000 – 15,000\r\nHarvesting: 10,000 – 15,000\r\n\r\nYield: 250 – 350 Maund\r\nRate: 1,500 – 2,500\r\nIncome: 375,000 – 875,000\r\nProfit: 200,000 – 600,000\r\n\r\nHigh profit, high investment', ' آلو\r\nکل تخمینی لاگت: 120,000 – 160,000 روپے\r\n\r\nتفصیل\r\nبیج: 60,000 – 90,000\r\nزمین کی تیاری: 8,000 – 10,000\r\nکھاد: 20,000 – 30,000\r\nآبپاشی: 8,000 – 12,000\r\nاسپرے: 6,000 – 10,000\r\nمزدوری: 10,000 – 15,000\r\nکٹائی: 10,000 – 15,000\r\n\r\nپیداوار: 250 – 350 من\r\nریٹ: 1,500 – 2,500\r\nآمدن: 375,000 – 875,000\r\nمنافع: 200,000 – 600,000\r\n\r\nزیادہ منافع، زیادہ سرمایہ'),
(4, 'rice', 'Rice', 'چاول', 'Cost per Acre & Details', 'فی ایکڑ لاگت اور تفصیل', 'Rice\nTotal Estimated Cost: 70,000 – 100,000 PKR\n\nBreakdown:\nNursery + Seed: 4,000 – 7,000\nLand preparation: 8,000 – 12,000\nFertilizer: 20,000 – 30,000\nIrrigation: 10,000 – 15,000\nSpray: 5,000 – 8,000\nLabor: 10,000 – 15,000\nHarvesting: 10,000 – 13,000\n\nYield: 50 – 70 Maund\nRate: 3,500 – 4,500\nIncome: 175,000 – 315,000\nProfit: 80,000 – 200,000\n\nHigh water & labor requirement', ' چاول\nکل تخمینی لاگت: 70,000 – 100,000 روپے\n\nتفصیل\nنرسری اور بیج: 4,000 – 7,000\nزمین کی تیاری: 8,000 – 12,000\nکھاد: 20,000 – 30,000\nآبپاشی: 10,000 – 15,000\nاسپرے: 5,000 – 8,000\nمزدوری: 10,000 – 15,000\nکٹائی: 10,000 – 13,000\n\nپیداوار: 50 – 70 من\nریٹ: 3,500 – 4,500\nآمدن: 175,000 – 315,000\nمنافع: 80,000 – 200,000\n\nزیادہ پانی اور محنت درکار'),
(6, 'test', 'test', 'ksdvnksdvK', 'assaasd', 'ksdnvs.dkvkblB', 'SACXASC', 'DSCSAC');

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
(3, 'potato', 'Potato', 'آلو', 'A versatile tuber crop grown in well-drained soil.', 'ایک قیمتی جڑ والی فصل جو خشک زمین میں اگائی جاتی ہے۔', 'assets/uploads/img_6a12d57a4e6cd.png', '', '', '', '', 3),
(4, 'maize', 'Maize', 'مکئی', 'A popular crop grown in warm climates, used for food and animal feed.', 'ایک مقبول فصل جو گرم علاقوں میں اگائی جاتی ہے اور خوراک کے لیے استعمال ہوتی ہے۔', 'assets/maize-intro.jpg', '', '', '', '', 4),
(9, '9', 'test1', '', 'dcs', '', 'assets/uploads/crop_6a129c7564480.png', '', '', '', '', 99);

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
(1, 'maize', 'english', 'Maize Crop Information', 1, ' Introduction', 'Maize is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes wheat, rice, and barley. Maize is primarily grown for its grains, which are used for human food, animal feed, and industrial products like starch, oil, and biofuel.\n\n<b><u>Key Characteristics of Maize:</u></b>\n Warm-season crop (Kharif crop)\n Plant height: 150 to 300 cm (varies by variety)\nStem: solid and thick\n Leaves: long, broad, and green\n Root system: fibrous and deep\nGrain: rich in carbohydrates, oil, protein, vitamins, and minerals\n\n<b><u>Global Importance:</u></b>\n One of the top 3 staple crops (with wheat and rice)\nAnnual global production: 1100+ million tons\n Major producers: USA, China, Brazil, Argentina, India\n Widely used in food industry and livestock feed\n\n<b><u>Importance for Farmers:</u></b>\n High yield potential\n Used as food and fodder\nHigh demand in poultry feed industry\n Suitable for mechanized farming\nProvides stable and profitable income'),
(2, 'maize', 'english', 'Maize Crop Information', 2, ' Climate Requirement', 'Maize grows best in warm and moderately humid climates.\n\n<b><u>Temperature:</u></b>\nGermination: 18 to 25°C\n Vegetative growth: 25 to 30°C\n Grain filling: 20 to 25°C\nBelow 10°C → poor growth\n Above 35°C → heat stress and reduced yield\n\n<b><u>Rainfall & Moisture:</u></b>\n Total requirement: 500 to 800 mm\nNeeds adequate moisture during germination and flowering\n Water stress at tasseling stage → severe yield loss\n Excess water → root damage and diseases\n\n<b><u>Sunlight:</u></b>\n Requires full sunlight for optimal growth\n Low light reduces yield\n\n<b><u>Wind:</u></b>\n Strong winds may cause lodging (plants fall over)'),
(3, 'maize', 'english', 'Maize Crop Information', 3, ' Soil Requirement', 'Maize performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types:</u></b>\n Loam (ideal)\n Sandy loam\n Silt loam\n\n<b><u>Soil pH:</u></b>\n Ideal range: 5.5 to 7.5\n\n<b><u>Important Soil Properties:</u></b>\nGood drainage (avoid waterlogging)\n High fertility\n Adequate organic matter\n Proper soil aeration\n\n<b><u>Soil Preparation:</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and crop residues\nApply farmyard manure (8 to 10 tons/acre)\nLevel the land properly'),
(4, 'maize', 'english', 'Maize Crop Information', 4, ' Sowing Time', '<b><u>Ideal Sowing Time :</u></b>\n Spring crop: January to February\n Kharif crop: June to July (best season)\n\n<b><u>Seed Selection:</u></b>\nUse certified, hybrid, and disease-free seeds\n Popular hybrids: Pioneer, Monsanto, Local approved hybrids\n\n<b><u>Seed Rate:</u></b>\n 20 to 25 kg per acre\n\n<b><u>Sowing Method:</u></b>\n Drill method (recommended)\nRow spacing: 60 to 75 cm\n Plant spacing: 20 to 25 cm\n Seed depth: 3 to 5 cm'),
(5, 'maize', 'english', 'Maize Crop Information', 5, ' Fertilizer Schedule', '<b><u>Recommended Dose</u> (Per Acre)</b>:\n Urea: 2 bags\nDAP: 1 bag\n Potash: 1/2 bag\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\n1. Basal Dose (At Sowing): Full DAP, Full Potash, Half Urea, Zinc Sulfate\n2. First Irrigation (20 to 25 Days After Sowing): Apply 25% Urea\n3. Second Irrigation (40 to 45 Days After Sowing): Apply remaining 25% Urea\n\n<b><u>Nutrient Importance:</u></b>\n Nitrogen: Promotes leaf growth and yield\n Phosphorus: Enhances root development\nPotassium: Improves plant strength and disease resistance\n Zinc: Helps in better grain formation'),
(6, 'maize', 'english', 'Maize Crop Information', 6, ' Weeds, Pests and Diseases', '<b>A.<u> Weeds:</u></b>\n Common Weeds: Grasses, Bathu (Chenopodium), Dela (Cyperus), Broadleaf weeds\n <b><u>Control:</u></b> Manual weeding at 20 to 30 days, Chemical control: Atrazine, Pendimethalin\n\n<b>B. <u>Pests:</u></b>\n Stem Borer: Feeds inside the stem, weakens the plant. <b><u>Control:</u></b> Chlorantraniliprole spray\n Fall Armyworm: Feeds on leaves, severe damage. <b><u>Control:</u></b> Emamectin Benzoate\n Aphids: Suck plant sap, reduce growth. <b><u>Control:</u></b> Imidacloprid\n\n<b>C.<u> Diseases:</u></b>\n Leaf Blight: Brown lesions on leaves. Control: Fungicide application\n Rust: Orange or brown powder on leaves. Control: Resistant varieties and fungicide spray\n Downy Mildew: Yellowing and stunted plants. Control: Seed treatment before sowing'),
(7, 'maize', 'english', 'Maize Crop Information', 7, ' Harvesting', '<b><u>Harvesting Time:</u></b>\n 90 to 120 days after sowing\n\n<b><U>When to Harvest:</u></b>\nHusks turn dry\nGrains become hard\n Moisture content around 20 to 25%'),
(8, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 1, ' تعارف', 'مکئی دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوایسیا فیملی سے تعلق رکھتی ہے، جس میں گندم، چاول، اور جو شامل ہیں۔ مکئی بنیادی طور پر اپنے دانوں کے لیے اگائی جاتی ہے، جو انسانی غذا، جانوروں کے چارہ، اور صنعتی مصنوعات جیسے نشاستہ، تیل، اور بایوفیول میں استعمال ہوتے ہیں۔\n\n<b>مکئی کی اہم خصوصیات</b>\n- گرم موسم کی فصل (کھڑی فصل)\n- پودے کی اونچائی: 150 سے 300 سینٹی میٹر (نسل کے حساب سے مختلف)\n- تنے: مضبوط اور موٹے\n- پتے: لمبے، چوڑے اور سبز\n- جڑ کا نظام: ریشے دار اور گہرا\n- دانہ: کاربوہائیڈریٹس، تیل، پروٹین، وٹامنز اور معدنیات سے بھرپور\n\n<b>عالمی اہمیت</b>\n- تین اہم غذائی فصلوں میں سے ایک (گندم اور چاول کے ساتھ)\n- سالانہ عالمی پیداوار: 1100+ ملین ٹن\n- بڑے پیدا کرنے والے ممالک: امریکہ، چین، برازیل، ارجنٹینا، بھارت\n- خوراک کی صنعت اور جانوروں کے چارہ میں وسیع استعمال\n\n<b>کسانوں کے لیے اہمیت</b>\n- زیادہ پیداوار کی صلاحیت\n- خوراک اور چارہ کے لیے استعمال\n- پولٹری فیڈ انڈسٹری میں زیادہ طلب\n- مشینی کھیتی کے لیے موزوں\n- مستحکم اور منافع بخش آمدنی فراہم کرتی ہے'),
(9, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 2, 'موسمی تقاضے', 'مکئی سب سے بہتر گرم اور معتدل نمی والے علاقوں میں اگتی ہے۔\n\n<b>درجہ حرارت</b>\n- اگنا: 18 سے 25°C\n- نشوونما: 25 سے 30°C\n- دانہ بھرنے کا مرحلہ: 20 سے 25°C\n- 10°C سے کم → کمزور نمو\n- 35°C سے زیادہ → حرارت کی شدت اور پیداوار میں کمی\n\n<b>بارش اور نمی</b>\n- کل ضرورت: 500 سے 800 ملی میٹر\n- اگنے اور پھولنے کے دوران مناسب نمی کی ضرورت\n- ٹیسلنگ مرحلے میں پانی کی کمی → شدید پیداوار کا نقصان\n- زیادہ پانی → جڑوں کو نقصان اور بیماریاں\n\n<b>روشنی</b>\n- مکمل دھوپ کی ضرورت\n- کم روشنی پیداوار کم کرتی ہے\n\n<b>ہوا</b>\n- شدید ہوائیں پودوں کو گرنے پر مجبور کر سکتی ہیں'),
(10, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 3, 'مٹی کے تقاضے', 'مکئی بہترین زرخیز اور پانی نکالنے والی مٹی میں اگتی ہے۔\n\n<b>مٹی کی بہترین اقسام</b>\n- لوئم (مثالی)\n- ریتلی لوئم\n- سیلٹ لوئم\n\n<b> پی ایچ</b>\n- مثالی حد: 5.5 سے 7.5\n\n<b>اہم مٹی کی خصوصیات</b>\n- اچھی نکاسی (پانی جمع ہونے سے بچیں)\n- زیادہ زرخیزی\n- مناسب نامیاتی مادہ\n- مناسب ہوا دار مٹی\n\n<b>مٹی کی تیاری</b>\n- باریک بیج بچھانے کے لیے 2 سے 3 ہل چلائیں\n- گھاس اور فصل کے باقیات ہٹائیں\n- فارم یارڈ کھاد لگائیں (8 سے 10 ٹن فی ایکڑ)\n- زمین کو مناسب سطح پر لیول کریں'),
(11, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 4, ' بونے کا وقت', '<b>پاکستان میں بونے کا مثالی وقت</b>\n- بہاری فصل: جنوری سے فروری\n- کھڑی فصل: جون سے جولائی (سب سے بہترین موسم)\n\n<b>بیج کا انتخاب</b>\n- تصدیق شدہ، ہائبرڈ، اور بیماری سے پاک بیج استعمال کریں\n- مشہور ہائبرڈز: پائنیئر، مونسانٹو، مقامی منظور شدہ ہائبرڈز\n\n<b>بیج کی مقدار</b>\n- 20 سے 25 کلوگرام فی ایکڑ\n\n<b>بونے کا طریقہ</b>\n- ڈرل طریقہ (سفارش کی جاتی ہے)\n- قطار کا فاصلہ: 60 سے 75 سینٹی میٹر\n- پودے کا فاصلہ: 20 سے 25 سینٹی میٹر\n- بیج کی گہرائی: 3 سے 5 سینٹی میٹر'),
(12, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 5, 'کھادوں کا شیڈول', '<b>فی ایکڑ تجویز شدہ خوراک</b>\n- یوریا: 2 تھیلے\n- ڈی اے پی: 1 تھیلا\n- پوٹاش: 1/2 تھیلا\n- زنک سلفیٹ: 5 سے 10 کلوگرام\n- نامیاتی کھاد: 8 سے 10 ٹن\n\n<b>درخواست کا شیڈول</b>\n1. بنیادی خوراک (بونے کے وقت): مکمل ڈی اے پی، مکمل پوٹاش، نصف یوریا، زنک سلفیٹ\n2. پہلی آبپاشی (بونے کے 20 سے 25 دن بعد): 25% یوریا لگائیں\n3. دوسری آبپاشی (بونے کے 40 سے 45 دن بعد): باقی 25% یوریا لگائیں\n\n<b>غذائی اجزاء کی اہمیت</b>\n- نائٹروجن: پتوں کی نمو اور پیداوار کو فروغ دیتا ہے\n- فاسفورس: جڑوں کی ترقی کو بہتر بناتا ہے\n- پوٹاشیم: پودے کی مضبوطی اور بیماریوں کی مزاحمت بڑھاتا ہے\n- زنک: دانے کی بہتر تشکیل میں مدد دیتا ہے'),
(13, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 6, ' جڑی بوٹیاں، کیڑے اور بیماریاں', '<b> جڑی بوٹیاں</b>\n- عام جڑی بوٹیاں: گھاس، بٹھو ، دیلا ، چوڑی پتیاں والی جڑی بوٹیاں\n- کنٹرول: 20 سے 30 دن بعد ہاتھ سے صفائی، کیمیائی کنٹرول: ایٹرازین، پینڈیمیتھالین\n\n<b> کیڑے</b>\n- اسٹیم بورر: تنوں کے اندر کھاتے ہیں، پودے کو کمزور کرتے ہیں۔ کنٹرول: کلورانٹرانیل پروائل سپرے\n- فال آرمی ورم: پتوں کو کھاتا ہے، شدید نقصان۔ کنٹرول: ایما میکٹن بینزویٹ\n- افڈز: پودے کا رس چوستے ہیں، نمو کم کرتے ہیں۔ کنٹرول: امیڈاکلوپریڈ\n\n<b> بیماریاں</b>\n- لیف بلیٹ: پتوں پر بھوری دھبے۔ کنٹرول: فنگسائیڈ لگائیں\n- رسٹ: پتوں پر نارنجی یا بھوری پاؤڈر۔ کنٹرول: مزاحم اقسام اور فنگسائیڈ سپرے\n- ڈاؤنی میلڈیو: پیلے پن اور بوجھل پودے۔ کنٹرول: بونے سے پہلے بیج کا علاج'),
(14, 'maize', 'urdu', 'مکئی کی فصل کی معلومات', 7, 'فصل کاٹنے کا وقت', '<b>کٹائی کا وقت</b>\n- 90 سے 120 دن بعد بونے کے\n\n<b>کٹائی کے اشارے</b>\n- بھوسے خشک ہو جائیں\n- دانے سخت ہو جائیں\n- نمی تقریباً 20 سے 25%'),
(32, 'potato', 'english', 'Potato Crop Information', 1, 'Introduction', 'Potato is one of the most important food crops in the world. It belongs to the Solanaceae family, which also includes tomato, chili, and eggplant. Potatoes are grown for their underground stems called tubers, which are rich in carbohydrates, vitamins, and minerals.\n\n<b><u>Key Characteristics of Potato:</u></b>\nGrows best in cool climates.\nPlant height generally 60 to 100 cm depending on variety.\nHas compound green leaves arranged spirally.\nTubers grow underground on stolons, not roots.\nShallow root system (80 to 120 cm).\n\n<b><u>Global Importance:</u></b>\nWorld production: More than 375 million tons annually.\nMajor producers: China, India, Russia, Ukraine, USA, Germany.\nPotatoes are the 4th most consumed food crop after rice, wheat, and maize.\n\n<b><u>Importance for Farmers:</u></b>\nHigh demand in markets and processing factories (chips, fries).\nShort duration crop (70 to 120 days).\nHigh yield per acre compared to other vegetables.\nCan be grown in many soil types and climates.'),
(33, 'potato', 'english', 'Potato Crop Information', 2, 'Climate Requirement', 'Potatoes require cool, moist climatic conditions for best performance.\n\n<b><u>Temperature:</u></b>\nIdeal sprouting temperature: 15 to 20°C\nVegetative growth: 18 to 24°C\nTuber formation: 15 to 20°C\nPoor growth above: 30°C\nFrost can damage young plants.\n\n<b><u>Rainfall & Humidity:</u></b>\nTotal requirement: 500 to 700 mm during the crop cycle.\nHumidity: 60 to 80%\nHigh humidity encourages diseases, so ventilation is important.\n\n<b><u>Sunlight:</u></b>\nPotato requires 6 to 7 hours of sunlight per day.\nCloudy weather during tuber development reduces yield.\n\n<b><u>Wind:</u></b>\nStrong winds can damage potato foliage and reduce photosynthesis.'),
(34, 'potato', 'english', 'Potato Crop Information', 3, 'Soil Requirement', 'Potatoes grow best in soils that are loose, fertile, and well-drained.\n\n<b><u>Best Soil Types:</u></b>\nSandy loam (ideal)\nLoam\nSilt loam\n\n<b><u>Soil pH:</u></b>\nIdeal pH: 5.2 to 6.5\nSlightly acidic soils reduce scab disease.\n\n<b><u>Important Soil Properties:</u></b>\nSoil must not be compact.\nShould be rich in organic matter.\nShould not have stones.\nMust hold moisture but not become waterlogged.\n\n<b><u>Soil Preparation:</u></b>\nDeep ploughing to break hardpan.\nApply 8 to 10 tons/acre well-decomposed farmyard manure.\nUse rotavator to make fine tilth.\nCreate raised beds or ridges.\nEnsure level land.'),
(35, 'potato', 'english', 'Potato Crop Information', 4, 'Sowing Time', '<b><u>Ideal Sowing Seasons:</u></b>\nAutumn to Winter Crop: October to December\nSpring Crop: January to February\n\n<b><u>Seed Tubers:</u></b>\nUse certified, disease-free tubers.\nWeight: 30 to 50 grams each.\nSprout length: 1 to 2 cm.\nCut large tubers and dry 24 hours.\n\n<b><u>Seed Rate:</u></b>\n700 to 1000 kg per acre.\n\n<b><u>Planting Method:</u></b>\nPlant 7 to 10 cm deep.\nRow spacing: 60 to 70 cm.\nPlant spacing: 20 to 25 cm.\nSprouts must face upward.'),
(36, 'potato', 'english', 'Potato Crop Information', 5, 'Fertilizer Schedule', '<b><u>Recommended Fertilizer Dose</u> (per acre):</b>\nUrea: 50 to 60 kg\nDAP: 45 to 50 kg\nPotash: 25 to 30 kg\nZinc Sulfate: 5 to 10 kg\nGypsum: 20 to 25 kg\nOrganic Manure: 8 to 10 tons\n\n<b><u>Application Schedule:</u></b>\nBasal Dose: Full DAP, SOP, Zinc, Half Urea, Gypsum\nAfter 25-30 days: 25% Urea\nAfter 40-45 days: Remaining 25% Urea\n\n<b><u>Importance:</u></b>\nNitrogen: foliage growth\nPhosphorus: root development\nPotassium:tuber quality\nZinc: prevents stunted growth'),
(37, 'potato', 'english', 'Potato Crop Information', 6, 'Weeds, Pests and Diseases', '<b><u>Weeds:</u></b>\nBathu, Dela, Wild mustard, Grasses\n<b>Control:</b> weeding + Metribuzin\n\n<b>Pests:</b>\nAphids:Imidacloprid\nCutworms:Chlorpyrifos\nWhiteflies: Thiamethoxam\n\n<b><u>Diseases:</u></b>\nLate Blight:Mancozeb, Ridomil\nEarly Blight: Mancozeb\nCommon Scab: moisture control'),
(38, 'potato', 'english', 'Potato Crop Information', 7, ' Harvesting', 'Harvest after 90 to 120 days.\nWhen vines turn yellow.'),
(39, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 1, 'تعارف', 'آلو دنیا کی سب سے اہم غذائی فصلوں میں سے ایک ہے۔ یہ سولانیسی خاندان سے تعلق رکھتا ہے جس میں ٹماٹر، مرچ اور بینگن بھی شامل ہیں۔ آلو زمین کے اندر اگنے والے تنوں جنہیں ٹبر (گانٹھیں) کہا جاتا ہے کے لیے کاشت کیا جاتا ہے، جو کاربوہائیڈریٹس، وٹامنز اور معدنیات سے بھرپور ہوتے ہیں۔'),
(40, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 2, 'موسمی تقاضے', 'آلو کی بہترین پیداوار کے لیے ٹھنڈا اور مرطوب موسم ضروری ہوتا ہے۔\n\n<b>درجہ حرارت</b>\nاگاؤ کے لیے مثالی درجہ حرارت: 15 سے 20 ڈگری سینٹی گریڈ\nنشوونما کے لیے: 18 سے 24 ڈگری سینٹی گریڈ\nگانٹھ بننے کے لیے: 15 سے 20 ڈگری سینٹی گریڈ\n30 ڈگری سے زیادہ پر نشوونما متاثر ہوتی ہے\nپالا کم عمر پودوں کو نقصان پہنچا سکتا ہے'),
(41, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 3, 'مٹی کے تقاضے', 'آلو کے لیے ڈھیلی، زرخیز اور اچھی نکاسی والی مٹی بہترین ہوتی ہے۔\n\n<b>بہترین مٹی کی اقسام</b>\nریتلی دوامی (سب سے بہتر)\nدوامی\nسلٹ دوامی\n\nپی ایچ: 5.2 سے 6.5 بہترین ہے'),
(42, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 4, 'بونے کا وقت', '<b>بوائی کے موزوں اوقات</b>\nاکتوبر سے دسمبر (اہم فصل)\nجنوری سے فروری (بہار کی فصل)\n\n<b>بیج گانٹھیں</b>\nمصدقہ اور بیماری سے پاک گانٹھیں استعمال کریں\nوزن: 30 سے 50 گرام\nانکر کی لمبائی: 1 سے 2 سینٹی میٹر'),
(43, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 5, 'کھادوں کا شیڈول', '<b>فی ایکڑ کھاد کی مقدار</b>\nیوریا: 50 سے 60 کلوگرام\nڈی اے پی: 45 سے 50 کلوگرام\nپوٹاش: 25 سے 30 کلوگرام\nزنک سلفیٹ: 5 سے 10 کلوگرام\nجپسم: 20 سے 25 کلوگرام\nنامیاتی کھاد: 8 سے 10 ٹن'),
(44, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 6, 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b>جڑی بوٹیاں</b>\nباتھو \nڈیلا \nجنگلی سرسوں\nگھاس\n\n<b>کیڑے</b>\nایفڈز: رس چوستے ہیں → پودا کمزور\nکنٹرول: امیڈاکلوپرڈ\n\nکٹ ورمز: تنے کو کاٹ دیتے ہیں\nکنٹرول: کلورپائریفوس'),
(45, 'potato', 'urdu', 'آلو کی فصل کی معلومات', 7, 'فصل کاٹنے کا وقت', 'جب پتے پیلے اور خشک ہو جائیں'),
(46, 'wheat', 'english', 'Wheat Crop Information', 1, 'Introduction', 'Wheat is one of the most important cereal crops in the world. It belongs to the Poaceae family, which includes rice, maize, and barley. Wheat is primarily grown for its grains, which are used to produce flour for bread, chapati, pasta, and many other food products.\n\n<b><u> Key Characteristics of Wheat</u></b>\n Cool-season crop (Rabi crop)\n Plant height: 60 to 120 cm (varies by variety)\nStem: hollow (except nodes)\n Leaves: long, narrow, and green\nRoot system: fibrous and moderately deep\nGrain: rich in carbohydrates, protein (gluten), vitamins, and minerals\n\n<b><u> Global Importance</u></b>\n One of the top 3 staple crops (with rice and maize)\n Annual global production: 750+ million tons\n Major producers: China, India, Russia, USA, France, Canada\n Staple food for over 35% of the world population\n\n <b><u>Importance for Farmers</u></b>\n High demand in local and global markets\n Essential food crop in Pakistan\nEasy to store compared to vegetables\n Mechanized farming possible\n Stable income crop'),
(47, 'wheat', 'english', 'Wheat Crop Information', 2, 'Climate Requirement', 'Wheat grows best in cool and dry climates.\n\n <b><u>Temperature</u></b>\n Germination: 12 to 25°C\n Tillering stage: 16 to 20°C\n Grain filling: 20 to 25°C\n Above 30°C during grain filling → reduces yield\n Frost can damage crop at flowering stage\n\n<b><u> Rainfall & Moisture</u></b>\n Total requirement: 300–500 mm\n Needs moisture during early growth and grain filling\n Excess rain → lodging and disease risk\n\n <b><u>Sunlight</u></b>\n Requires bright sunlight\n Clear weather during grain filling improves grain quality\n\n<b><u> Wind</u></b>\n Strong winds can cause lodging (plants fall down)'),
(48, 'wheat', 'english', 'Wheat Crop Information', 3, 'Soil Requirement', 'Wheat can grow in various soils but performs best in fertile, well-drained soils.\n\n<b><u>Best Soil Types</u></b>\nLoam (ideal)\n Clay loam\nSilt loam\n\n<b><u> Soil pH</u></b>\n Ideal range: 6.0 to 7.5\n\n <b><u>Important Soil Properties</u></b>\n Good drainage (no waterlogging)\n Moderate water-holding capacity\n Rich in organic matter\n Level field for uniform irrigation\n\n<b><u> Soil Preparation</u></b>\n 2 to 3 ploughings for fine seedbed\n Remove weeds and previous crop residues\n Apply farmyard manure (5 to 8 tons/acre)\n Level land properly (laser leveling is best)'),
(49, 'wheat', 'english', 'Wheat Crop Information', 4, ' Sowing Time', ' <b><u>Ideal Sowing Time </u></b>\n Punjab & Sindh: 15 October to 30 November (best)\nLate sowing → lower yield\n\n <b><u>Seed Selection</u></b>\n Use certified, disease-free seeds\n Popular varieties:\n  Faisalabad-2008\n  Galaxy-2013\n  Punjab-2011\n\n <b><u>Seed Rate</u></b>\n 40 to 50 kg per acre\n\n <b><u>Sowing Method</u></b>\n Drill method (recommended)\n Row spacing: 9 to 12 inches\n Depth: 3 to 5 cm'),
(50, 'wheat', 'english', 'Wheat Crop Information', 5, '5. Fertilizer Schedule', 'Wheat requires balanced nutrients for high yield.\n\n <b><u>Recommended Dose </u>(Per Acre)</b>\nFertilizer\n Urea: 80 to 100 kg\n DAP: 50 kg\nPotash (SOP/MOP): 25 to 30 kg\n Zinc Sulfate: 5 to 10 kg\n Organic Manure: 5 to 8 tons\n\n <b><u>Application Schedule</u></b>\n1. Basal Dose (At Sowing)\nFull DAP\nFull Potash\n Half Urea\n Zinc\n\n2. First Irrigation (20 to 25 Days)\n 25% Urea\n\n3. Second Irrigation (40 to 45 Days)\n Remaining 25% Urea\n\n<b><u> Nutrient Importance</u></b>\n Nitrogen: Leaf growth, tillering\nPhosphorus: Root development\n Potassium: Strength, disease resistance\n Zinc: Better grain formation'),
(51, 'wheat', 'english', 'Wheat Crop Information', 6, '6. Weeds, Pests and Diseases', '<b>A.<u> Weeds</u></b>\n Common Weeds\n Bathu (Chenopodium)\nWild oats (Jangli jai)\n Dela (Cyperus)\n Broadleaf weeds\n\n<b><u>Control</u></b>\nWeeding at 20 to 30 days\n Chemical control:\n  Isoproturon\n  Topik\n  Puma Super\n\n<b>B.<u> Pests</u></b>\n Aphids\n Damage: Sap sucking → weak plants\n Control: Imidacloprid\n\n Termites\n Damage: Attack roots and stems\n Control: Chlorpyrifos\n\n<b>C.<u> Diseases</u></b>\n Rust (Zang)\nTypes:\n Leaf rust\n Stem rust\n Stripe rust\n\nCause: Puccinia species\n\nSymptoms:\n Orange/yellow powder on leaves\n Reduced grain filling\n\nControl:\n Resistant varieties\n Fungicide spray (Tilt, Score)\n\n Smut\nBlack powder in grains\nControl: Seed treatment before sowing\n\n Powdery Mildew\n White powder on leaves\nControl: Fungicide spray'),
(52, 'wheat', 'english', 'Wheat Crop Information', 7, '7. Harvesting', ' <b><u>Harvesting Time</u></b>\n April – May\n\n <b><u>When:</u></b>\n Crop turns golden yellow\n Grains become hard\n Moisture content ~12 to 14%'),
(53, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 1, 'تعارف', 'گندم دنیا کی سب سے اہم اناج کی فصلوں میں سے ایک ہے۔ یہ پوئیسی خاندان سے تعلق رکھتی ہے، جس میں چاول، مکئی اور جو شامل ہیں۔ گندم بنیادی طور پر اس کے دانوں کے لیے اگائی جاتی ہے، جن سے آٹا، روٹی، چپاتی، پاستا اور دیگر غذائی مصنوعات تیار کی جاتی ہیں۔'),
(54, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 2, 'موسمی تقاضے', 'گندم ٹھنڈے اور خشک موسم میں بہترین اگتی ہے۔\n\n <b>درجہ حرارت</b>\n اگاؤ: 12 سے 25 ڈگری سینٹی گریڈ\n ٹلرنگ مرحلہ: 16 سے 20 ڈگری سینٹی گریڈ\n دانہ بھرنے کا مرحلہ: 20 سے 25 ڈگری سینٹی گریڈ'),
(55, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 3, 'مٹی کے تقاضے', 'گندم مختلف اقسام کی مٹی میں اگ سکتی ہے لیکن زرخیز اور اچھی نکاسی والی مٹی میں بہترین پیداوار دیتی ہے۔\n\n <b>بہترین مٹی کی اقسام</b>\n میرا  — سب سے بہتر\n چکنی میرا \n سلٹی میرا'),
(56, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 4, 'بونے کا وقت', '<b> موزوں کاشت کا وقت</b>\n پنجاب اور سندھ: 15 اکتوبر سے 30 نومبر (بہترین)\n دیر سے کاشت کرنے سے پیداوار کم ہو جاتی ہے\n\n<b>بیج کا انتخاب</b>\n تصدیق شدہ اور بیماری سے پاک بیج استعمال کریں'),
(57, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 5, 'کھادوں کا شیڈول', 'گندم کو زیادہ پیداوار کے لیے متوازن غذائی اجزاء درکار ہوتے ہیں۔\n\n <b>سفارش کردہ مقدار (فی ایکڑ)</b>\n یوریا: 80 سے 100 کلوگرام\n ڈی اے پی: 50 کلوگرام\n پوٹاش (SOP/MOP): 25 سے 30 کلوگرام'),
(58, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 6, 'جڑی بوٹیاں، کیڑے اور بیماریاں', '<b> جڑی بوٹیاں</b>\n عام جڑی بوٹیاں\n- باتھو \nجنگلی جئی \n- ڈیلا \n- چوڑی پتوں والی جڑی بوٹیاں\n\n <b>کنٹرول</b>\nگوڈی 20سے30دن میں کریں\n<b> کیڑے</b>\n ایفڈز\n- نقصان: رس چوس کر پودوں کو کمزور کرتے ہیں\n دیمک\n- نقصان: جڑوں اور تنوں پر حملہ کرتے ہیں'),
(59, 'wheat', 'urdu', 'گندم کی فصل کی معلومات', 7, 'فصل کاٹنے کا وقت', '  اپریل سے مئی\nفصل سنہری پیلی ہو جائے\nدانے سخت ہو جائیں\n نمی تقریباً 12 سے 14 فیصد ہو'),
(63, '9', 'english', 'saxasx', 1, 'sx as ', 'ssdsad'),
(64, '9', 'english', 'saxasx', 2, 'sasx', 'scsa'),
(65, '9', 'english', 'qsq', 3, 'asas', 'asxasxsas');

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
(1, 'maize', 'en', 'Maize - Complete Crop Guide', 'Introduction', 'Climate Requirement', 'Soil Requirement', 'Sowing Time', 'Fertilizer Schedule', 'Weeds, Pests and Diseases', 'Harvesting', 'assets/maize-intro.jpg', 'assets/climate.jpg', 'assets/maize-soil.jpg', 'assets/maize-sowing.jpg', 'assets/maize-fertilizer.jpg', 'assets/maize-pest.jpg', 'assets/maize-harvesting.jpg', 'اردو', 'View Detail'),
(2, 'maize', 'ur', 'مکؑی - مکمل کاشتی رہنمائی', 'تعارف', 'آب و ہوا کی ضروریات', 'مٹی کی ضروریات', 'بوائی کا وقت', 'کھاد کا شیڈول', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 'کٹائی', 'assets/maize-intro.jpg', 'assets/climate.jpg', 'assets/maize-soil.jpg', 'assets/maize-sowing.jpg', 'assets/maize-fertilizer.jpg', 'assets/maize-pest.jpg', 'assets/maize-harvesting.jpg', 'English', 'تفصیل'),
(5, 'potato', 'en', 'Potato - Complete Crop Guide', 'Introduction', 'Climate Requirement', 'Soil Requirement', 'Sowing Time', 'Fertilizer Schedule', 'Weeds, Pests and Diseases', 'Harvesting', 'assets/potato-intro.jpeg', 'assets/climate.jpg', 'assets/potato-soil.jpeg', 'assets/potato-sowing.jpg', 'assets/potato-fertilizer.jpg', 'assets/potato-pest.jpg', 'assets/potato-harvesting.jpg', 'اردو', 'View Detail'),
(6, 'potato', 'ur', 'آلو - مکمل کاشتی رہنمائی', 'تعارف', 'آب و ہوا کی ضروریات', 'مٹی کی ضروریات', 'بوائی کا وقت', 'کھاد کا شیڈول', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 'کٹائی', 'assets/potato-intro.jpeg', 'assets/climate.jpg', 'assets/potato-soil.jpeg', 'assets/potato-sowing.jpg', 'assets/potato-fertilizer.jpg', 'assets/potato-pest.jpg', 'assets/potato-harvesting.jpg', 'English', 'تفصیل'),
(7, 'wheat', 'en', 'Wheat - Complete Crop Guide', 'Introduction', 'Climate Requirement', 'Soil Requirement', 'Sowing Time', 'Fertilizer Schedule', 'Weeds, Pests and Diseases', 'Harvesting', 'assets/image.jpeg', 'assets/climate.jpg', 'assets/soil.jpg', 'assets/sowing.jpg', 'assets/fertilizer.jpg', 'assets/pests.jpg', 'assets/harvesting.jpg', 'اردو', 'View Detail'),
(8, 'wheat', 'ur', 'گندم - مکمل کاشتی رہنمائی', 'تعارف', 'آب و ہوا کی ضروریات', 'مٹی کی ضروریات', 'بوائی کا وقت', 'کھاد کا شیڈول', 'جڑی بوٹیاں، کیڑے اور بیماریاں', 'کٹائی', 'assets/image.jpeg', 'assets/climate.jpg', 'assets/soil.jpg', 'assets/sowing.jpg', 'assets/fertilizer.jpg', 'assets/pests.jpg', 'assets/harvesting.jpg', 'English', 'تفصیل'),
(9, 'test', 'en', 'asas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'test', 'ur', 'asas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '9', 'en', 'test1', 'Introduction', 'Climate', 'Soil', 'Sowing', 'Fertilizer', 'Pests', 'Harvest', '', '', '', '', '', '', '', 'اردو', 'View Detail'),
(18, '9', 'ur', 'test1', 'Introduction', 'Climate', 'Soil', 'Sowing', 'Fertilizer', 'Pests', 'Harvest', '', '', '', '', '', '', '', 'English', 'تفصیل');

-- --------------------------------------------------------

--
-- Table structure for table `crop_images`
--

CREATE TABLE `crop_images` (
  `id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `image_path` varchar(300) NOT NULL,
  `caption` varchar(200) DEFAULT '',
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_images`
--

INSERT INTO `crop_images` (`id`, `crop_id`, `image_path`, `caption`, `sort_order`) VALUES
(1, 3, 'assets/uploads/img_6a12d8006bdd9.jpeg', '', 0),
(2, 3, 'assets/uploads/img_6a12d80ace55c.png', '', 1),
(3, 3, 'assets/uploads/img_6a12d8d0b36e0.png', 'wefsf', 2);

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
(1, 'en', 'Rice', 'A staple food crop grown in flooded fields, requiring plenty of water', 'https://cdn.britannica.com/89/140889-050-EC3F00BF/Ripening-heads-rice-Oryza-sativa.jpg', 'rice.php', 1),
(2, 'en', 'Potato', 'A versatile tuber crop grown in well-drained soil', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdFq-FuA8g_OFpM9gHfolOwMppWlOyuPrDjA&s', 'potato.php', 2),
(3, 'en', 'Wheat', 'A primary cereal crop grown in temperate regions', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRyLD_CD4XW-_ktQUJRrT2kwBPbZKEFH7hrQ&s', 'wheat.php', 3),
(4, 'en', 'Maize', 'A popular maize grown in warm climates, used for food and animal feed', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvsJXY7ZlO8BwoVoqu2eP4lI995BWaUYeExQ&s', 'maize.php', 4),
(5, 'ur', '????', '??? ?????? ????? ??? ?? ???? ?? ???? ???? ??? ????? ???? ??', 'https://cdn.britannica.com/89/140889-050-EC3F00BF/Ripening-heads-rice-Oryza-sativa.jpg', 'rice.php', 1),
(6, 'ur', '???', '??? ????? ?? ???? ??? ?? ??? ???? ??? ????? ???? ??', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdFq-FuA8g_OFpM9gHfolOwMppWlOyuPrDjA&s', 'potato.php', 2),
(7, 'ur', '????', '??? ??? ????? ??? ?? ????? ?????? ??? ????? ???? ??', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRyLD_CD4XW-_ktQUJRrT2kwBPbZKEFH7hrQ&s', 'wheat.php', 3),
(8, 'ur', '????', '??? ????? ??? ?? ??? ?????? ??? ????? ???? ?? ??? ????? ?? ??? ??????? ???? ??', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvsJXY7ZlO8BwoVoqu2eP4lI995BWaUYeExQ&s', 'maize.php', 4);

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
(3, 3, 'en', 'sadxsa', 'asx', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `agri_cost`
--
ALTER TABLE `agri_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `crop_details`
--
ALTER TABLE `crop_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `crop_guides`
--
ALTER TABLE `crop_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `crop_images`
--
ALTER TABLE `crop_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `crop_info`
--
ALTER TABLE `crop_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `crop_sections`
--
ALTER TABLE `crop_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `farm_data`
--
ALTER TABLE `farm_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
