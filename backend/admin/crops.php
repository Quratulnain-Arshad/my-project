<?php
require_once __DIR__ . '/../config.php';
requireLogin();

$conn->query("CREATE TABLE IF NOT EXISTS `crops` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,`slug` VARCHAR(50) NOT NULL UNIQUE,
  `name_en` VARCHAR(100) DEFAULT '',`name_ur` VARCHAR(100) DEFAULT '',
  `desc_en` TEXT,`desc_ur` TEXT,`thumbnail` VARCHAR(255) DEFAULT '',
  `video_1` VARCHAR(100) DEFAULT '',`video_2` VARCHAR(100) DEFAULT '',
  `video_3` VARCHAR(100) DEFAULT '',`video_4` VARCHAR(100) DEFAULT '',
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$conn->query("CREATE TABLE IF NOT EXISTS `crop_guides` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,`crop` VARCHAR(50) NOT NULL,
  `lang` VARCHAR(10) NOT NULL DEFAULT 'en',`title` VARCHAR(200) DEFAULT '',
  `lang_btn` VARCHAR(50) DEFAULT '',`next_btn` VARCHAR(50) DEFAULT '',
  `section_intro` VARCHAR(100) DEFAULT '',`section_climate` VARCHAR(100) DEFAULT '',
  `section_soil` VARCHAR(100) DEFAULT '',`section_sowing` VARCHAR(100) DEFAULT '',
  `section_fertilizer` VARCHAR(100) DEFAULT '',`section_pests` VARCHAR(100) DEFAULT '',
  `section_harvest` VARCHAR(100) DEFAULT '',`img_intro` VARCHAR(255) DEFAULT '',
  `img_climate` VARCHAR(255) DEFAULT '',`img_soil` VARCHAR(255) DEFAULT '',
  `img_sowing` VARCHAR(255) DEFAULT '',`img_fertilizer` VARCHAR(255) DEFAULT '',
  `img_pests` VARCHAR(255) DEFAULT '',`img_harvest` VARCHAR(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$conn->query("CREATE TABLE IF NOT EXISTS `crop_details` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,`crop` VARCHAR(50) NOT NULL,
  `lang` VARCHAR(20) NOT NULL DEFAULT 'english',`title` VARCHAR(200) DEFAULT '',
  `section_order` INT DEFAULT 0,`heading` VARCHAR(200) DEFAULT '',
  `content` MEDIUMTEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$cnt = (int)$conn->query("SELECT COUNT(*) FROM crops")->fetch_row()[0];
if ($cnt === 0) {
    $seeds = [
        ['rice','Rice','چاول','A staple food crop.','ایک بنیادی غذائی فصل۔','assets/rice-intro.jpeg',1],
        ['wheat','Wheat','گندم','A primary cereal crop.','ایک اہم اناجی فصل۔','assets/image.jpeg',2],
        ['potato','Potato','آلو','A versatile tuber crop.','ایک قیمتی جڑ والی فصل۔','assets/potato-intro.jpeg',3],
        ['maize','Maize','مکئی','A popular warm-climate crop.','ایک مقبول فصل۔','assets/maize-intro.jpg',4],
    ];
    foreach ($seeds as [$s,$ne,$nu,$de,$du,$t,$ord]) {
        $s_=$conn->real_escape_string($s);$ne_=$conn->real_escape_string($ne);$nu_=$conn->real_escape_string($nu);
        $de_=$conn->real_escape_string($de);$du_=$conn->real_escape_string($du);$t_=$conn->real_escape_string($t);
        $conn->query("INSERT IGNORE INTO crops (slug,name_en,name_ur,desc_en,desc_ur,thumbnail,sort_order) VALUES ('$s_','$ne_','$nu_','$de_','$du_','$t_',$ord)");
    }
}

function getUploadsDir() {
    // dirname(dirname()) is pure string — no realpath() needed, works on Windows
    $dir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'frontend'
         . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($dir)) @mkdir($dir, 0777, true);
    return $dir;
}
function uploadImg($field) {
    if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) return null;
    $dir = getUploadsDir();
    $name = 'crop_' . uniqid() . '.' . $ext;
    return move_uploaded_file($_FILES[$field]['tmp_name'], $dir . DIRECTORY_SEPARATOR . $name)
        ? 'assets/uploads/' . $name : null;
}
function removeUpload($path) {
    if (empty($path) || strpos($path, 'assets/uploads/') === false) return;
    $dir = getUploadsDir();
    @unlink($dir . DIRECTORY_SEPARATOR . basename($path));
}
function assetUrl($path) {
    if (empty($path)) return '';
    if (preg_match('#^https?://#i', $path)) return $path;
    $clean = str_replace(['\\', '/'], '/', ltrim($path, '/\\'));
    return '../../frontend/' . $clean;
}

$section = $_POST['_section'] ?? '';
$editId  = (int)($_GET['edit'] ?? 0);
$msg = ''; $msgType = 'success';

if ($section === 'add_crop') {
    $ne = $conn->real_escape_string(trim($_POST['name_en'] ?? ''));
    $nu = $conn->real_escape_string(trim($_POST['name_ur'] ?? ''));
    if ($ne) {
        // Insert with a temporary unique slug, then update to the auto-increment ID
        $tmpSlug = $conn->real_escape_string('tmp_' . uniqid());
        $conn->query("INSERT INTO crops (slug,name_en,name_ur,sort_order) VALUES ('$tmpSlug','$ne','$nu',99)");
        $newId = $conn->insert_id;
        if ($newId) {
            $conn->query("UPDATE crops SET slug='$newId' WHERE id=$newId");
            $s = $conn->real_escape_string((string)$newId);
            foreach (['en'=>['اردو','View Detail'],'ur'=>['English','تفصیل']] as $l=>[$lb,$nb]) {
                $lb_=$conn->real_escape_string($lb);$nb_=$conn->real_escape_string($nb);$l_=$conn->real_escape_string($l);
                $conn->query("INSERT IGNORE INTO crop_guides (crop,lang,title,lang_btn,next_btn,section_intro,section_climate,section_soil,section_sowing,section_fertilizer,section_pests,section_harvest) VALUES ('$s','$l_','$ne','$lb_','$nb_','Introduction','Climate','Soil','Sowing','Fertilizer','Pests','Harvest')");
            }
            header("Location: crops.php?edit=$newId&added=1"); exit;
        } else { $msg = 'Could not create crop. Try again.'; $msgType = 'error'; }
    } else { $msg = 'English name is required.'; $msgType = 'error'; }
}

if ($section === 'save_basic' && $editId) {
    $row = $conn->query("SELECT * FROM crops WHERE id=$editId")->fetch_assoc();
    if ($row) {
        $ne=$conn->real_escape_string(trim($_POST['name_en']??''));
        $nu=$conn->real_escape_string(trim($_POST['name_ur']??''));
        $de=$conn->real_escape_string(trim($_POST['desc_en']??''));
        $du=$conn->real_escape_string(trim($_POST['desc_ur']??''));
        $ord=(int)($_POST['sort_order']??99);
        $thumb=$row['thumbnail'];
        if (!empty($_POST['remove_thumbnail'])) { removeUpload($thumb); $thumb=''; }
        $newT=uploadImg('thumbnail');
        if ($newT!==null) { removeUpload($thumb); $thumb=$newT; }
        $thumb_=$conn->real_escape_string($thumb);
        $conn->query("UPDATE crops SET name_en='$ne',name_ur='$nu',desc_en='$de',desc_ur='$du',thumbnail='$thumb_',sort_order=$ord WHERE id=$editId");
    }
    header("Location: crops.php?edit=$editId&saved=basic"); exit;
}

  if ($section === 'delete_guide_image' && $editId) {
    $row = $conn->query("SELECT slug FROM crops WHERE id=$editId")->fetch_assoc();
    $field = $_POST['guide_field'] ?? '';
    $allowedFields = ['img_intro','img_climate','img_soil','img_sowing','img_fertilizer','img_pests','img_harvest'];
    if ($row && in_array($field, $allowedFields, true)) {
      $s = $conn->real_escape_string($row['slug']);
      $fieldSql = $conn->real_escape_string($field);
      // Map image field to section label field (e.g., img_intro -> section_intro)
      $labelField = str_replace('img_', 'section_', $field);
      $currentRows = $conn->query("SELECT id, `$fieldSql` AS img FROM crop_guides WHERE crop='$s'");
      while ($currentRows && ($gRow = $currentRows->fetch_assoc())) {
        if (!empty($gRow['img'])) removeUpload($gRow['img']);
        $guideId = (int)$gRow['id'];
        // Clear both image and label to remove entire section
        $labelSql = $conn->real_escape_string($labelField);
        $conn->query("UPDATE crop_guides SET `$fieldSql`='', `$labelSql`='' WHERE id=$guideId");
      }
    }
    header("Location: crops.php?edit=$editId&saved=guide_removed"); exit;
  }

if ($section === 'save_guide' && $editId) {
    $row = $conn->query("SELECT slug FROM crops WHERE id=$editId")->fetch_assoc();
    if ($row) {
        $s = $conn->real_escape_string($row['slug']);
        $imgKeys = ['intro','climate','soil','sowing','fertilizer','pests','harvest'];
        $guideEn = $conn->query("SELECT * FROM crop_guides WHERE crop='$s' AND lang='en'")->fetch_assoc() ?? [];
        $imgs = [];
        foreach ($imgKeys as $k) {
            $f = 'img_'.$k;
            $new = uploadImg($f);
            if ($new !== null) { removeUpload($guideEn[$f]??''); $imgs[$f]=$new; }
            else $imgs[$f] = $_POST[$f.'_current'] ?? ($guideEn[$f]??'');
        }
        foreach (['en','ur'] as $lang) {
            $gRow = ($lang==='en') ? $guideEn : ($conn->query("SELECT * FROM crop_guides WHERE crop='$s' AND lang='ur'")->fetch_assoc()??[]);
            $fields = array_merge($imgs,[
                'title'              => $_POST['title_'.$lang]??'',
                'lang_btn'           => $_POST['lang_btn_'.$lang]??($lang==='en'?'اردو':'English'),
                'next_btn'           => $_POST['next_btn_'.$lang]??($lang==='en'?'View Detail':'تفصیل'),
                'section_intro'      => $_POST['section_intro_'.$lang]??'',
                'section_climate'    => $_POST['section_climate_'.$lang]??'',
                'section_soil'       => $_POST['section_soil_'.$lang]??'',
                'section_sowing'     => $_POST['section_sowing_'.$lang]??'',
                'section_fertilizer' => $_POST['section_fertilizer_'.$lang]??'',
                'section_pests'      => $_POST['section_pests_'.$lang]??'',
                'section_harvest'    => $_POST['section_harvest_'.$lang]??'',
            ]);
            $l=$conn->real_escape_string($lang);
            $exists=$conn->query("SELECT id FROM crop_guides WHERE crop='$s' AND lang='$l'")->fetch_row();
            if ($exists) {
                $sets=implode(',',array_map(fn($k,$v)=>"`$k`='".$conn->real_escape_string($v)."'",array_keys($fields),array_values($fields)));
                $conn->query("UPDATE crop_guides SET $sets WHERE crop='$s' AND lang='$l'");
            } else {
                $cols=implode(',',array_map(fn($k)=>"`$k`",array_keys($fields)));
                $vals=implode(',',array_map(fn($v)=>"'".$conn->real_escape_string($v)."'",array_values($fields)));
                $conn->query("INSERT INTO crop_guides (crop,lang,$cols) VALUES ('$s','$l',$vals)");
            }
        }
    }
        header("Location: crops.php?edit=$editId&saved=guide"); exit;
}

if ($section === 'save_videos' && $editId) {
    $vs=[];
    for($i=1;$i<=4;$i++){
        $v=trim($_POST["video_$i"]??'');
        if(preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([a-zA-Z0-9_-]{11})/',$v,$m)) $v=$m[1];
        $vs[$i]=$conn->real_escape_string(preg_replace('/[^a-zA-Z0-9_-]/','',substr($v,0,20)));
    }
    $conn->query("UPDATE crops SET video_1='{$vs[1]}',video_2='{$vs[2]}',video_3='{$vs[3]}',video_4='{$vs[4]}' WHERE id=$editId");
    header("Location: crops.php?edit=$editId&saved=videos"); exit;
}

if ($section === 'save_details' && $editId) {
    $row = $conn->query("SELECT slug FROM crops WHERE id=$editId")->fetch_assoc();
    if ($row) {
        $s    = $conn->real_escape_string($row['slug']);
        $lang = in_array($_POST['det_lang']??'',['english','urdu']) ? $_POST['det_lang'] : 'english';
        $lang_= $conn->real_escape_string($lang);
        foreach (explode(',', $_POST['delete_ids']??'') as $did) {
            $did=(int)trim($did); if($did>0) $conn->query("DELETE FROM crop_details WHERE id=$did AND crop='$s'");
        }
        $secIds    = $_POST['sec_id']    ?? [];
        $secTitles = $_POST['sec_title'] ?? [];
        $headings  = $_POST['sec_heading'] ?? [];
        $contents  = $_POST['sec_content'] ?? [];
        foreach ($secIds as $i=>$sid) {
            $sid=(int)$sid;
            $t=$conn->real_escape_string($secTitles[$i]??'');
            $h=$conn->real_escape_string($headings[$i]??'');
            $c=$conn->real_escape_string($contents[$i]??'');
            $ord=$i+1;
            if($sid>0) $conn->query("UPDATE crop_details SET title='$t',heading='$h',content='$c',section_order=$ord WHERE id=$sid AND crop='$s'");
            else        $conn->query("INSERT INTO crop_details (crop,lang,title,section_order,heading,content) VALUES ('$s','$lang_','$t',$ord,'$h','$c')");
        }
    }
    header("Location: crops.php?edit=$editId&saved=detail&det_lang=".urlencode($_POST['det_lang']??'english')); exit;
}

if ($section === 'delete_crop') {
    $id=(int)($_POST['id']??0);
    $row=$conn->query("SELECT * FROM crops WHERE id=$id")->fetch_assoc();
    if($row){
        $s=$conn->real_escape_string($row['slug']);
        removeUpload($row['thumbnail']);
        $gr=$conn->query("SELECT * FROM crop_guides WHERE crop='$s'");
        while($r=$gr->fetch_assoc()) foreach(['intro','climate','soil','sowing','fertilizer','pests','harvest'] as $k) removeUpload($r['img_'.$k]);
        $conn->query("DELETE FROM crop_guides WHERE crop='$s'");
        $conn->query("DELETE FROM crop_details WHERE crop='$s'");
        $conn->query("DELETE FROM crops WHERE id=$id");
    }
    header("Location: crops.php?deleted=1"); exit;
}

// Data load
$editRow=null; $guideEn=[]; $guideUr=[]; $detEn=[]; $detUr=[];
if ($editId) {
    $editRow=$conn->query("SELECT * FROM crops WHERE id=$editId")->fetch_assoc();
    if(!$editRow){header("Location: crops.php");exit;}
    $s=$conn->real_escape_string($editRow['slug']);
    $g=$conn->query("SELECT * FROM crop_guides WHERE crop='$s'");
    while($r=$g->fetch_assoc()){if($r['lang']==='en')$guideEn=$r;else $guideUr=$r;}
    $detEn=$conn->query("SELECT * FROM crop_details WHERE crop='$s' AND lang='english' ORDER BY section_order")->fetch_all(MYSQLI_ASSOC);
    $detUr=$conn->query("SELECT * FROM crop_details WHERE crop='$s' AND lang='urdu'    ORDER BY section_order")->fetch_all(MYSQLI_ASSOC);
    if(isset($_GET['added']))              $msg='Crop created! Fill in all the details below.';
    elseif(($_GET['saved']??'')==='basic') $msg='Basic info saved!';
    elseif(($_GET['saved']??'')==='guide') $msg='Guide images & labels saved!';
    elseif(($_GET['saved']??'')==='guide_removed') $msg='Guide image removed!';
    elseif(($_GET['saved']??'')==='videos')$msg='Videos saved!';
    elseif(($_GET['saved']??'')==='detail')$msg='Detail sections saved!';
}
if(isset($_GET['deleted'])) $msg='Crop deleted.';
$allCrops=$conn->query("SELECT * FROM crops ORDER BY sort_order,name_en")->fetch_all(MYSQLI_ASSOC);
function gv($a,$k){return htmlspecialchars($a[$k]??'');}
$imgMeta=['intro'=>['Introduction','تعارف'],'climate'=>['Climate','آب و ہوا'],
          'soil'=>['Soil','مٹی'],'sowing'=>['Sowing','بوائی'],
          'fertilizer'=>['Fertilizer','کھاد'],'pests'=>['Pests','کیڑے'],'harvest'=>['Harvesting','کٹائی']];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $editRow ? 'Edit '.htmlspecialchars($editRow['name_en']).' — ' : 'Manage Crops — ' ?>FarmEase Admin</title>
<?php include __DIR__ . '/partials/head-styles.php'; ?>
<style>
/* ── Crop list ── */
.crop-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:14px;margin-top:16px}
.crop-card{background:#fff;border:1px solid #d4ebd4;border-radius:10px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,.06);transition:box-shadow .2s}
.crop-card:hover{box-shadow:0 4px 16px rgba(4,57,21,.12)}
.crop-card-thumb{width:100%;height:110px;object-fit:cover;display:block}
.crop-card-empty{width:100%;height:110px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;color:#b0c4b1;font-size:2rem}
.crop-card-body{padding:10px 12px}
.crop-card-body h3{font-size:.88rem;font-weight:700;color:#043915;margin-bottom:2px}
.crop-card-body .slug{font-size:.65rem;color:#888;font-family:monospace;background:#f0f4f0;padding:1px 5px;border-radius:3px;display:inline-block;margin-bottom:6px}
.crop-card-body p{font-size:.73rem;color:#666;line-height:1.4;margin-bottom:8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.crop-card-actions{display:flex;gap:5px}

/* ── Modal ── */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center}
.modal-overlay.open{display:flex}
.modal-box{background:#fff;border-radius:12px;padding:28px;width:460px;max-width:95vw;box-shadow:0 20px 60px rgba(0,0,0,.25)}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.modal-header h3{font-size:1rem;font-weight:700;color:#043915;margin:0}
.modal-close{width:30px;height:30px;background:#f5f5f5;border:none;border-radius:50%;cursor:pointer;font-size:.9rem;display:flex;align-items:center;justify-content:center;color:#555}
.modal-close:hover{background:#e0e0e0}
.modal-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}

/* ── Edit page ── */
.back-link{display:inline-flex;align-items:center;gap:6px;color:#043915;text-decoration:none;font-size:.82rem;font-weight:600;margin-bottom:16px;opacity:.7;transition:opacity .15s}
.back-link:hover{opacity:1}
.edit-header{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:24px;flex-wrap:wrap}
.edit-header h1{font-size:1.15rem;font-weight:700;color:#043915;margin:0;display:flex;align-items:center;gap:8px}
.edit-header .slug-badge{font-size:.65rem;font-family:monospace;background:#e8f5e9;color:#2e7d32;padding:2px 7px;border-radius:4px}
.edit-header-actions{display:flex;gap:8px}

.sec-title{font-size:.75rem;font-weight:700;color:#4caf50;text-transform:uppercase;letter-spacing:.8px;margin-bottom:14px;display:flex;align-items:center;gap:6px}

/* ── Thumbnail ── */
.thumb-preview-wrap{position:relative;width:180px;height:130px;border-radius:8px;overflow:hidden;background:#e8f5e9;border:2px dashed #a5d6a7;flex-shrink:0;display:flex;align-items:center;justify-content:center}
.thumb-preview-wrap img{width:100%;height:100%;object-fit:cover}
.thumb-preview-wrap .placeholder{color:#b0c4b1;font-size:2.5rem}
.thumb-actions{display:flex;flex-direction:column;gap:8px;margin-left:16px}

/* ── Guide image grid ── */
.guide-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(148px,1fr));gap:12px;margin-bottom:18px}
.guide-img-card{background:#fff;border:1px solid #d4ebd4;border-radius:8px;overflow:hidden}
.guide-img-preview{width:100%;height:112px;background:#e8f5e9;position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden}
.guide-img-preview img{width:100%;height:100%;object-fit:cover;display:block}
.guide-img-preview .ph{color:#c8e6c9;font-size:2rem}
.guide-img-footer{padding:7px 8px;border-top:1px solid #e8f5e9;background:#fafffe}
.guide-img-name{font-size:.7rem;font-weight:700;color:#043915;margin-bottom:5px}
.guide-img-btns{display:flex;gap:4px;margin-bottom:6px}
.btn-img-upload{cursor:pointer;padding:4px 8px;background:#e8f5e9;border-radius:4px;font-size:.72rem;color:#043915;border:1px solid #c8e6c9;transition:background .15s;display:inline-flex;align-items:center;gap:4px}
.btn-img-upload:hover{background:#c8e6c9}
.btn-img-remove{padding:4px 8px;background:#fff0f0;border:1px solid #ffcdd2;border-radius:4px;font-size:.72rem;color:#c62828;cursor:pointer;transition:background .15s}
.btn-img-remove:hover{background:#ffcdd2}
.guide-img-labels{padding:0 8px 8px}
.guide-img-labels input{font-size:.72rem;padding:4px 6px;border:1px solid #d4ebd4;border-radius:4px;width:100%;margin-bottom:4px;box-sizing:border-box}

/* ── Videos ── */
.video-item{display:flex;align-items:center;gap:8px;margin-bottom:8px}
.video-item input{flex:1;font-family:'Poppins',sans-serif}
.video-item .btn-del{padding:7px 10px;background:#fff0f0;border:1px solid #ffcdd2;border-radius:6px;color:#c62828;cursor:pointer;font-size:.8rem}
.btn-add-video{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:#e8f5e9;border:1px solid #a5d6a7;border-radius:6px;color:#043915;font-size:.8rem;font-weight:600;cursor:pointer;transition:background .15s}
.btn-add-video:hover{background:#c8e6c9}

/* ── Detail sections ── */
.det-tabs{display:flex;gap:0;margin-bottom:18px;border-bottom:2px solid #e0f0e0}
.det-tab{padding:8px 20px;cursor:pointer;font-size:.84rem;font-weight:600;color:#888;border-bottom:3px solid transparent;margin-bottom:-2px;transition:color .15s;background:none;border-left:none;border-right:none;border-top:none;font-family:'Poppins',sans-serif}
.det-tab.active,.det-tab:hover{color:#043915;border-bottom-color:#4caf50}
.det-panel{display:none}.det-panel.active{display:block}

.sec-item{background:#f9fdf9;border:1px solid #d4ebd4;border-radius:8px;margin-bottom:10px;overflow:hidden}
.sec-item-header{display:flex;align-items:center;gap:8px;padding:10px 12px;background:#fff;border-bottom:1px solid #e8f5e9}
.sec-num{width:24px;height:24px;border-radius:50%;background:#043915;color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sec-heading-input{flex:1;border:1px solid #d4ebd4;border-radius:5px;padding:6px 10px;font-size:.84rem;font-family:'Poppins',sans-serif;color:#043915}
.sec-heading-input:focus{outline:none;border-color:#4caf50}
.sec-delete-btn{padding:5px 9px;background:#fff0f0;border:1px solid #ffcdd2;border-radius:5px;color:#c62828;cursor:pointer;font-size:.78rem}
.sec-delete-btn:hover{background:#ffcdd2}

/* ── WYSIWYG ── */
.wysiwyg-wrap{border-top:none}
.wysiwyg-toolbar{display:flex;flex-wrap:wrap;gap:3px;padding:7px 10px;background:#f5faf5;border-bottom:1px solid #e8f5e9}
.wysiwyg-toolbar button{padding:3px 9px;background:#fff;border:1px solid #d4ebd4;border-radius:4px;cursor:pointer;font-size:.76rem;color:#043915;font-family:'Poppins',sans-serif;transition:background .15s;line-height:1.4}
.wysiwyg-toolbar button:hover{background:#e8f5e9}
.wysiwyg-body{min-height:130px;max-height:320px;overflow-y:auto;padding:10px 14px;outline:none;font-size:.84rem;line-height:1.65;color:#333;font-family:'Poppins',sans-serif}
.wysiwyg-body:focus{background:#fafffe}
.wysiwyg-body h2{font-size:1rem;color:#043915;margin:8px 0 4px;font-weight:700}
.wysiwyg-body h3{font-size:.9rem;color:#2e7d32;margin:6px 0 3px;font-weight:600}
.wysiwyg-body mark{background:#fff176;padding:0 2px;border-radius:2px}
.wysiwyg-body ul,.wysiwyg-body ol{padding-left:20px;margin:4px 0}
.wysiwyg-body p{margin:4px 0}

.det-actions-bar{display:flex;align-items:center;justify-content:space-between;margin-top:14px;flex-wrap:wrap;gap:10px}
.btn-add-section{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#e8f5e9;border:1px dashed #4caf50;border-radius:7px;color:#043915;font-size:.82rem;font-weight:600;cursor:pointer;transition:background .15s}
.btn-add-section:hover{background:#c8e6c9}

/* ── Section Groups ── */
.group-item{background:#fff;border:1px solid #d4ebd4;border-radius:10px;margin-bottom:14px;overflow:hidden}
.group-header{display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f0faf0;border-bottom:1px solid #d4ebd4}
.group-title-input{flex:1;font-size:.88rem;font-weight:700;color:#043915;border:1px solid #c8e6c9;border-radius:6px;padding:6px 10px;font-family:'Poppins',sans-serif}
.group-title-input:focus{outline:none;border-color:#4caf50;box-shadow:0 0 0 2px rgba(76,175,80,.1)}
.group-body{padding:12px 14px 10px}
.group-sections{margin-bottom:8px}
.btn-del-group{padding:5px 10px;background:#fff0f0;border:1px solid #ffcdd2;border-radius:5px;color:#c62828;cursor:pointer;font-size:.76rem;white-space:nowrap;display:inline-flex;align-items:center;gap:4px;flex-shrink:0}
.btn-del-group:hover{background:#ffcdd2}
.btn-add-group{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#e8f5e9;border:2px dashed #4caf50;border-radius:7px;color:#043915;font-size:.82rem;font-weight:600;cursor:pointer;transition:background .15s}
.btn-add-group:hover{background:#c8e6c9}
</style>
</head>
<body>
<div class="layout">
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<main class="content">

<?php if ($msg): ?>
<div class="alert alert-<?= $msgType==='error'?'error':'success' ?>">
  <i class="fa-solid fa-<?= $msgType==='error'?'circle-xmark':'circle-check' ?>"></i>
  <?= htmlspecialchars($msg) ?>
</div>
<?php endif; ?>

<?php if ($editRow): ?>
<!-- ═══════════════════════ EDIT MODE ═══════════════════════ -->
<a href="crops.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to all crops</a>

<div class="edit-header">
  <h1><i class="fa-solid fa-seedling"></i>
    <?= htmlspecialchars($editRow['name_en']) ?>
    <span class="slug-badge"><?= htmlspecialchars($editRow['slug']) ?></span>
  </h1>
  <div class="edit-header-actions">
    <a href="../../frontend/crop.php?slug=<?= urlencode($editRow['slug']) ?>" target="_blank" class="btn btn-outline btn-sm">
      <i class="fa-solid fa-eye"></i> View on Site
    </a>
    <form method="POST" style="display:inline" onsubmit="return confirm('Delete <?= htmlspecialchars(addslashes($editRow['name_en'])) ?>? This cannot be undone.')">
      <input type="hidden" name="_section" value="delete_crop">
      <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
      <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
    </form>
  </div>
</div>

<!-- ── Card 1: Basic Info ── -->
<div class="card">
  <h2><i class="fa-solid fa-circle-info"></i> Basic Info</h2>
  <form method="POST" enctype="multipart/form-data" id="form-basic">
    <input type="hidden" name="_section" value="save_basic">

    <!-- Thumbnail -->
    <div class="sec-title" style="margin-bottom:10px"><i class="fa-solid fa-image"></i> Crop Thumbnail</div>
    <div style="display:flex;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:12px">
      <div class="thumb-preview-wrap" id="thumb-preview-wrap">
        <?php if ($editRow['thumbnail']): ?>
          <img id="thumb-preview-img" src="../../frontend/<?= htmlspecialchars($editRow['thumbnail']) ?>" alt="">
        <?php else: ?>
          <div class="placeholder" id="thumb-preview-ph"><i class="fa-solid fa-image"></i></div>
        <?php endif; ?>
      </div>
      <div class="thumb-actions">
        <label class="btn-img-upload" style="padding:7px 14px;font-size:.8rem">
          <i class="fa-solid fa-upload"></i> Upload New
          <input type="file" name="thumbnail" accept="image/*" style="display:none" onchange="previewThumb(this)">
        </label>
        <?php if ($editRow['thumbnail']): ?>
        <label style="display:flex;align-items:center;gap:6px;font-size:.78rem;color:#c62828;cursor:pointer;margin-top:4px">
          <input type="checkbox" name="remove_thumbnail" value="1"> Remove current
        </label>
        <?php endif; ?>
        <div style="font-size:.72rem;color:#888;margin-top:6px">Recommended: 400×300px</div>
      </div>
    </div>

    <!-- Names & Descriptions -->
    <div class="sec-title"><i class="fa-solid fa-language"></i> Names & Descriptions</div>
    <div class="form-grid">
      <div class="form-group"><label>Name (English)</label><input type="text" name="name_en" value="<?= gv($editRow,'name_en') ?>" required></div>
      <div class="form-group"><label>Name (اردو)</label><input type="text" name="name_ur" dir="rtl" value="<?= gv($editRow,'name_ur') ?>"></div>
      <div class="form-group"><label>Description (English)</label><textarea name="desc_en" rows="3"><?= gv($editRow,'desc_en') ?></textarea></div>
      <div class="form-group"><label>Description (اردو)</label><textarea name="desc_ur" dir="rtl" rows="3"><?= gv($editRow,'desc_ur') ?></textarea></div>
    </div>
    <div class="form-group" style="max-width:120px;margin-top:8px"><label>Sort Order</label><input type="number" name="sort_order" value="<?= (int)$editRow['sort_order'] ?>"></div>
    <div style="margin-top:16px"><button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Basic Info</button></div>
  </form>
</div>

<!-- ── Card 2: Guide Images ── -->
<div class="card">
  <h2><i class="fa-solid fa-images"></i> Guide Images & Labels</h2>
  <p style="font-size:.78rem;color:#888;margin-bottom:16px">Upload an image for each crop section. Labels appear under images on the website. Click any image slot to upload.</p>
  <form method="POST" enctype="multipart/form-data" id="guide-form">

    <!-- Image grid -->
    <div class="guide-grid">
    <?php
    $guideHasRow = !empty($guideEn);
    foreach ($imgMeta as $key=>[$labelEn,$labelUr]):
      $f='img_'.$key; $cur=$guideEn[$f]??'';
      // Skip cards that were explicitly deleted (guide row exists, both image and label are empty)
      if ($guideHasRow && empty($cur) && ($guideEn['section_'.$key]??'') === '') continue;
    ?>
    <div class="guide-img-card">
      <div class="guide-img-preview" id="prev-<?= $f ?>" onclick="document.getElementById('fi-<?= $f ?>').click()" style="cursor:pointer" title="Click to upload">
        <?php if($cur): ?>
          <img src="<?= htmlspecialchars(assetUrl($cur)) ?>" alt="">
        <?php else: ?>
          <div class="ph"><i class="fa-solid fa-image"></i></div>
        <?php endif; ?>
      </div>
      <input type="file" id="fi-<?= $f ?>" name="<?= $f ?>" accept="image/*" style="display:none" onchange="previewGuideImg(this,'prev-<?= $f ?>')">
      <div class="guide-img-footer">
        <div class="guide-img-name"><?= $labelEn ?></div>
        <div class="guide-img-btns">
          <button type="button" class="btn-img-upload" onclick="document.getElementById('fi-<?= $f ?>').click()" title="Upload image">
            <i class="fa-solid fa-upload"></i>
          </button>
          <button type="button" class="btn-img-remove" onclick="deleteGuideImg('<?= $f ?>','prev-<?= $f ?>')" title="Remove"><i class="fa-solid fa-trash"></i></button>
        </div>
        <input type="hidden" name="<?= $f ?>_current" value="<?= htmlspecialchars($cur) ?>">
        <input type="hidden" name="remove_<?= $f ?>" id="rm-<?= $f ?>" value="">
      </div>
      <div class="guide-img-labels">
        <input type="text" name="section_<?= $key ?>_en" value="<?= gv($guideEn,'section_'.$key)?:$labelEn ?>" placeholder="EN label">
        <input type="text" name="section_<?= $key ?>_ur" value="<?= gv($guideUr,'section_'.$key)?:$labelUr ?>" placeholder="UR label" dir="rtl">
      </div>
    </div>
    <?php endforeach; ?>
    </div>

    <!-- Page-level labels -->
    <details style="margin-bottom:14px">
      <summary style="cursor:pointer;font-size:.8rem;font-weight:600;color:#043915;padding:8px 0"><i class="fa-solid fa-sliders"></i> Page Titles & Button Labels</summary>
      <div style="padding:14px 0 0;display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div class="form-group"><label>Page Title (EN)</label><input type="text" name="title_en" value="<?= gv($guideEn,'title') ?>"></div>
        <div class="form-group"><label>Page Title (UR)</label><input type="text" name="title_ur" dir="rtl" value="<?= gv($guideUr,'title') ?>"></div>
        <div class="form-group"><label>Lang Button (EN page)</label><input type="text" name="lang_btn_en" value="<?= gv($guideEn,'lang_btn')?:'اردو' ?>"></div>
        <div class="form-group"><label>Lang Button (UR page)</label><input type="text" name="lang_btn_ur" dir="rtl" value="<?= gv($guideUr,'lang_btn')?:'English' ?>"></div>
        <div class="form-group"><label>Detail Button (EN)</label><input type="text" name="next_btn_en" value="<?= gv($guideEn,'next_btn')?:'View Detail' ?>"></div>
        <div class="form-group"><label>Detail Button (UR)</label><input type="text" name="next_btn_ur" dir="rtl" value="<?= gv($guideUr,'next_btn')?:'تفصیل' ?>"></div>
      </div>
    </details>

    <button type="submit" class="btn btn-primary" name="_section" value="save_guide"><i class="fa-solid fa-floppy-disk"></i> Save Guide Images & Labels</button>
  </form>
</div>

<form method="POST" id="guide-delete-form" action="?edit=<?= (int)$editRow['id'] ?>" style="display:none">
  <input type="hidden" name="_section" value="delete_guide_image">
  <input type="hidden" name="guide_field" id="guide-delete-field" value="">
</form>

<!-- ── Card 3: YouTube Videos ── -->
<div class="card">
  <h2><i class="fa-brands fa-youtube" style="color:#f44336"></i> YouTube Videos</h2>
  <p style="font-size:.78rem;color:#888;margin-bottom:14px">Paste YouTube video URLs or IDs (e.g. <code>dQw4w9WgXcQ</code>). Max 4 videos.</p>
  <form method="POST" id="form-videos">
    <input type="hidden" name="_section" value="save_videos">
    <div id="video-list">
    <?php
    $vids=array_values(array_filter([$editRow['video_1'],$editRow['video_2'],$editRow['video_3'],$editRow['video_4']]));
    if(empty($vids)) $vids=[''];
    foreach($vids as $i=>$v): ?>
    <div class="video-item">
      <input type="text" name="video_<?= $i+1 ?>" class="vid-input" value="<?= htmlspecialchars($v) ?>" placeholder="YouTube ID or URL">
      <button type="button" class="btn-del" onclick="removeVideoItem(this)"><i class="fa-solid fa-trash"></i></button>
    </div>
    <?php endforeach; ?>
    </div>
    <div style="display:flex;gap:10px;align-items:center;margin-top:8px;flex-wrap:wrap">
      <button type="button" class="btn-add-video" onclick="addVideo()"><i class="fa-solid fa-plus"></i> Add Video</button>
      <button type="submit" class="btn btn-primary" onclick="reindexVideos()"><i class="fa-solid fa-floppy-disk"></i> Save Videos</button>
    </div>
  </form>
</div>

<!-- ── Card 4: Detail Sections ── -->
<div class="card">
  <h2><i class="fa-solid fa-file-lines"></i> Crop Detail Sections</h2>
  <p style="font-size:.78rem;color:#888;margin-bottom:16px">Add content sections (Introduction, Climate, Soil care, etc.) with rich text. Visitors see these under "View Detail".</p>

  <div class="det-tabs">
    <button class="det-tab active" onclick="showDetTab('en',this)">English Sections</button>
    <button class="det-tab" onclick="showDetTab('ur',this)">اردو Sections</button>
  </div>

  <?php foreach(['en'=>['english',$detEn],'ur'=>['urdu',$detUr]] as $tab=>[$dbLang,$detRows]):
    // Group rows by consecutive title value
    $groups=[];
    foreach($detRows as $row){
      $last=count($groups)-1;
      if($last<0||$groups[$last]['title']!==$row['title']){$groups[]=['title'=>$row['title'],'sections'=>[]];$last++;}
      $groups[$last]['sections'][]=$row;
    }
  ?>
  <div class="det-panel <?= $tab==='en'?'active':'' ?>" id="det-panel-<?= $tab ?>">
    <form method="POST" id="form-details-<?= $tab ?>">
      <input type="hidden" name="_section" value="save_details">
      <input type="hidden" name="det_lang" value="<?= $dbLang ?>">
      <input type="hidden" name="delete_ids" id="delete-ids-<?= $tab ?>" value="">

      <div id="sections-<?= $tab ?>">
        <?php foreach($groups as $group): ?>
        <div class="group-item">
          <div class="group-header">
            <input type="text" class="group-title-input" value="<?= htmlspecialchars($group['title']) ?>" placeholder="Group title..." <?= $tab==='ur'?'dir="rtl"':'' ?>>
            <button type="button" class="btn-del-group" onclick="removeGroup(this,'<?= $tab ?>')">
              <i class="fa-solid fa-trash"></i> Delete Group
            </button>
          </div>
          <div class="group-body">
            <div class="group-sections">
              <?php foreach($group['sections'] as $si=>$sec): ?>
              <div class="sec-item" data-secid="<?= $sec['id'] ?>">
                <div class="sec-item-header">
                  <div class="sec-num"><?= $si+1 ?></div>
                  <input type="text" class="sec-heading-input" value="<?= htmlspecialchars($sec['heading']) ?>" placeholder="Section heading..." <?= $tab==='ur'?'dir="rtl"':'' ?>>
                  <button type="button" class="sec-delete-btn" onclick="removeSection(this,'<?= $tab ?>',<?= $sec['id'] ?>)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
                <div class="wysiwyg-wrap" data-content="<?= htmlspecialchars($sec['content']) ?>" <?= $tab==='ur'?'dir="rtl"':'' ?>></div>
              </div>
              <?php endforeach; ?>
            </div>
            <button type="button" class="btn-add-section" style="margin-top:4px" onclick="addSectionToGroup(this.closest('.group-item'),'<?= $tab ?>')">
              <i class="fa-solid fa-plus"></i> Add Section
            </button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="det-actions-bar">
        <button type="button" class="btn-add-group" onclick="addGroup('<?= $tab ?>')">
          <i class="fa-solid fa-folder-plus"></i> Add Group
        </button>
        <button type="button" class="btn btn-primary" onclick="saveDetails('<?= $tab ?>')">
          <i class="fa-solid fa-floppy-disk"></i> Save <?= $tab==='en'?'English':'Urdu' ?> Sections
        </button>
      </div>
    </form>
  </div>
  <?php endforeach; ?>
</div>

<?php else: ?>
<!-- ═══════════════════════ LIST MODE ═══════════════════════ -->
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
  <h1><i class="fa-solid fa-seedling"></i> Manage Crops</h1>
  <button class="btn btn-primary" onclick="openModal('modal-add')">
    <i class="fa-solid fa-plus"></i> Add New Crop
  </button>
</div>

<div class="card">
  <h2><i class="fa-solid fa-list"></i> All Crops (<?= count($allCrops) ?>)</h2>
  <?php if(empty($allCrops)): ?>
    <p style="color:#999;font-size:.84rem">No crops yet. Click "Add New Crop" to get started.</p>
  <?php else: ?>
  <div class="crop-grid">
    <?php foreach($allCrops as $c): ?>
    <div class="crop-card">
      <?php if($c['thumbnail']): ?>
        <img class="crop-card-thumb" src="../../frontend/<?= htmlspecialchars($c['thumbnail']) ?>" alt="">
      <?php else: ?>
        <div class="crop-card-empty"><i class="fa-solid fa-image"></i></div>
      <?php endif; ?>
      <div class="crop-card-body">
        <h3><?= htmlspecialchars($c['name_en']) ?></h3>
        <span class="slug"><?= htmlspecialchars($c['slug']) ?></span>
        <p><?= htmlspecialchars($c['desc_en']) ?></p>
        <div class="crop-card-actions">
          <a href="?edit=<?= $c['id'] ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>
          <a href="../../frontend/crop.php?slug=<?= urlencode($c['slug']) ?>" target="_blank" class="btn btn-outline btn-sm"><i class="fa-solid fa-eye"></i></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<!-- Add Crop Modal -->
<div class="modal-overlay" id="modal-add">
  <div class="modal-box">
    <div class="modal-header">
      <h3><i class="fa-solid fa-seedling" style="color:#4caf50"></i> Add New Crop</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-add')"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <?php if($msg && $msgType==='error'): ?>
      <div class="alert alert-error" style="margin-bottom:14px;font-size:.82rem"><i class="fa-solid fa-circle-xmark"></i> <?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="hidden" name="_section" value="add_crop">
      <div class="form-group">
        <label>Name (English)</label>
        <input type="text" name="name_en" placeholder="e.g. Sugarcane" required autofocus>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-add')">Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrow-right"></i> Create & Edit</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

</main>
</div>

<!-- ═══════════════════════ JAVASCRIPT ═══════════════════════ -->
<script>
// ── Modal ──
function openModal(id){document.getElementById(id).classList.add('open');}
function closeModal(id){document.getElementById(id).classList.remove('open');}
document.querySelectorAll('.modal-overlay').forEach(m=>m.addEventListener('click',e=>{if(e.target===m)m.classList.remove('open');}));

// ── Thumbnail preview ──
function previewThumb(input){
  if(!input.files[0]) return;
  const reader=new FileReader();
  reader.onload=e=>{
    const wrap=document.getElementById('thumb-preview-wrap');
    wrap.innerHTML=`<img id="thumb-preview-img" src="${e.target.result}" alt="" style="width:100%;height:100%;object-fit:cover">`;
  };
  reader.readAsDataURL(input.files[0]);
}

// ── Guide image preview & clear ──
function previewGuideImg(input,previewId){
  if(!input.files[0]) return;
  // sync to the first file input for the same slot (the hidden label one)
  const reader=new FileReader();
  reader.onload=e=>{
    const prev=document.getElementById(previewId);
    prev.innerHTML=`<img src="${e.target.result}" alt="" style="width:100%;height:100%;object-fit:cover">`;
    // clear the remove flag
    const field=previewId.replace('prev-','');
    const rmInput=document.getElementById('rm-'+field);
    if(rmInput) rmInput.value='';
  };
  reader.readAsDataURL(input.files[0]);
}
function clearGuideImg(field,previewId){
  document.getElementById(previewId).innerHTML='<div class="ph"><i class="fa-solid fa-image"></i></div>';
  document.getElementById('rm-'+field).value='1';
  const fi=document.getElementById('fi-'+field);
  if(fi) fi.value='';
}
function deleteGuideImg(field,previewId){
  clearGuideImg(field,previewId);
  const input=document.getElementById('guide-delete-field');
  const form=document.getElementById('guide-delete-form');
  if(input) input.value=field;
  if(form) form.submit();
}

// ── Videos ──
function addVideo(){
  const list=document.getElementById('video-list');
  if(list.querySelectorAll('.video-item').length>=4){alert('Maximum 4 videos.');return;}
  const div=document.createElement('div');
  div.className='video-item';
  div.innerHTML='<input type="text" class="vid-input" placeholder="YouTube ID or URL"><button type="button" class="btn-del" onclick="removeVideoItem(this)"><i class="fa-solid fa-trash"></i></button>';
  list.appendChild(div);
}
function removeVideoItem(btn){
  const item=btn.closest('.video-item');
  const list=document.getElementById('video-list');
  if(list.querySelectorAll('.video-item').length>1) item.remove();
  else item.querySelector('input').value='';
}
function reindexVideos(){
  document.querySelectorAll('.vid-input').forEach((inp,i)=>{inp.name='video_'+(i+1);});
}

// ── WYSIWYG ──
function initWysiwyg(wrap,content){
  const isRtl=wrap.getAttribute('dir')==='rtl';
  const toolbar=document.createElement('div');
  toolbar.className='wysiwyg-toolbar';
  toolbar.innerHTML=`
    <button type="button" data-cmd="bold"><b>B</b></button>
    <button type="button" data-cmd="italic"><i>I</i></button>
    <button type="button" data-cmd="underline"><u>U</u></button>
    <button type="button" data-cmd="h2" title="Heading 2">H2</button>
    <button type="button" data-cmd="h3" title="Heading 3">H3</button>
    <button type="button" data-cmd="p" title="Normal paragraph">¶</button>
    <button type="button" data-cmd="highlight" title="Highlight">🖊 Hi</button>
    <button type="button" data-cmd="insertUnorderedList" title="Bullet list">• List</button>
    <button type="button" data-cmd="insertOrderedList" title="Numbered list">1. List</button>
    <button type="button" data-cmd="removeFormat" title="Clear formatting">Clear</button>`;
  const body=document.createElement('div');
  body.className='wysiwyg-body';
  body.contentEditable='true';
  body.dir=isRtl?'rtl':'ltr';
  body.innerHTML=content.replace(/\n/g,'<br>');
  wrap.appendChild(toolbar);
  wrap.appendChild(body);
  toolbar.addEventListener('mousedown',e=>{
    e.preventDefault();
    const btn=e.target.closest('[data-cmd]');
    if(!btn) return;
    const cmd=btn.dataset.cmd;
    body.focus();
    if(cmd==='h2'||cmd==='h3'||cmd==='p') document.execCommand('formatBlock',false,cmd==='p'?'p':cmd);
    else if(cmd==='highlight'){
      try{
        const sel=window.getSelection();
        if(sel.rangeCount&&!sel.isCollapsed){const r=sel.getRangeAt(0);const m=document.createElement('mark');r.surroundContents(m);}
      }catch(err){document.execCommand('hiliteColor',false,'#FFF176');}
    } else document.execCommand(cmd,false,null);
  });
}

// ── Section Groups ──
function addGroup(lang){
  const container=document.getElementById('sections-'+lang);
  const isUr=lang==='ur';
  const div=document.createElement('div');
  div.className='group-item';
  div.innerHTML=`
    <div class="group-header">
      <input type="text" class="group-title-input" placeholder="Group title..." ${isUr?'dir="rtl"':''}>
      <button type="button" class="btn-del-group" onclick="removeGroup(this,'${lang}')">
        <i class="fa-solid fa-trash"></i> Delete Group
      </button>
    </div>
    <div class="group-body">
      <div class="group-sections"></div>
      <button type="button" class="btn-add-section" style="margin-top:4px" onclick="addSectionToGroup(this.closest('.group-item'),'${lang}')">
        <i class="fa-solid fa-plus"></i> Add Section
      </button>
    </div>`;
  container.appendChild(div);
  addSectionToGroup(div,lang);
  div.querySelector('.group-title-input').focus();
}
function addSectionToGroup(groupEl,lang){
  const sectionsDiv=groupEl.querySelector('.group-sections');
  const idx=sectionsDiv.querySelectorAll('.sec-item').length;
  const isUr=lang==='ur';
  const div=document.createElement('div');
  div.className='sec-item';
  div.dataset.secid='0';
  div.innerHTML=`
    <div class="sec-item-header">
      <div class="sec-num">${idx+1}</div>
      <input type="text" class="sec-heading-input" placeholder="Section heading..." ${isUr?'dir="rtl"':''}>
      <button type="button" class="sec-delete-btn" onclick="removeSection(this,'${lang}',0)">
        <i class="fa-solid fa-trash"></i>
      </button>
    </div>
    <div class="wysiwyg-wrap" ${isUr?'dir="rtl"':''}></div>`;
  sectionsDiv.appendChild(div);
  initWysiwyg(div.querySelector('.wysiwyg-wrap'),'');
  div.querySelector('.sec-heading-input').focus();
}
function removeGroup(btn,lang){
  const group=btn.closest('.group-item');
  const inp=document.getElementById('delete-ids-'+lang);
  group.querySelectorAll('.sec-item').forEach(item=>{
    const sid=parseInt(item.dataset.secid||'0');
    if(sid>0) inp.value=inp.value?inp.value+','+sid:String(sid);
  });
  group.remove();
}
function removeSection(btn,lang,id){
  if(id>0){
    const inp=document.getElementById('delete-ids-'+lang);
    inp.value=inp.value?inp.value+','+id:String(id);
  }
  const secItem=btn.closest('.sec-item');
  const groupEl=secItem.closest('.group-item');
  secItem.remove();
  if(groupEl) groupEl.querySelectorAll('.sec-item').forEach((item,i)=>{
    const n=item.querySelector('.sec-num');if(n)n.textContent=i+1;
  });
}
function saveDetails(lang){
  const form=document.getElementById('form-details-'+lang);
  form.querySelectorAll('.dyn').forEach(el=>el.remove());
  document.querySelectorAll('#sections-'+lang+' .group-item').forEach(group=>{
    const groupTitle=group.querySelector('.group-title-input')?.value||'';
    group.querySelectorAll('.sec-item').forEach(item=>{
      const secId=item.dataset.secid||'0';
      const heading=item.querySelector('.sec-heading-input')?.value||'';
      const content=item.querySelector('.wysiwyg-body')?.innerHTML||'';
      const add=(n,v)=>{const inp=document.createElement('input');inp.type='hidden';inp.name=n;inp.value=v;inp.className='dyn';form.appendChild(inp);};
      add('sec_id[]',secId);
      add('sec_title[]',groupTitle);
      add('sec_heading[]',heading);
      add('sec_content[]',content);
    });
  });
  form.submit();
}

// ── Tabs ──
function showDetTab(lang,btn){
  document.querySelectorAll('.det-tab').forEach(t=>t.classList.remove('active'));
  document.querySelectorAll('.det-panel').forEach(p=>p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('det-panel-'+lang).classList.add('active');
}

// ── Init on load ──
document.addEventListener('DOMContentLoaded',()=>{
  // Init all WYSIWYG editors for existing sections
  document.querySelectorAll('.wysiwyg-wrap').forEach(wrap=>{
    const content=wrap.dataset.content||'';
    initWysiwyg(wrap,content);
  });
  // Auto-open UR tab if saved from urdu
  const url=new URL(location.href);
  if(url.searchParams.get('det_lang')==='urdu') document.querySelectorAll('.det-tab')[1]?.click();
  // Open modal if there was a slug error
  <?php if($msg && $msgType==='error' && !$editRow): ?>openModal('modal-add');<?php endif; ?>
});
</script>
</body>
</html>
