<?php
require_once __DIR__ . '/../config.php';
requireLogin();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['en', 'ur'] as $lang) {
        $title    = $conn->real_escape_string($_POST["title_$lang"] ?? '');
        $subtitle = $conn->real_escape_string($_POST["subtitle_$lang"] ?? '');
        $bci      = $conn->real_escape_string($_POST["btn_crop_info_$lang"] ?? '');
        $bcalc    = $conn->real_escape_string($_POST["btn_calculator_$lang"] ?? '');
        $bhel     = $conn->real_escape_string($_POST["btn_helpline_$lang"] ?? '');
        $sw       = $conn->real_escape_string($_POST["switch_language_$lang"] ?? '');
        $ah       = $conn->real_escape_string($_POST["about_heading_$lang"] ?? '');
        $ap1      = $conn->real_escape_string($_POST["about_p1_$lang"] ?? '');
        $ap2      = $conn->real_escape_string($_POST["about_p2_$lang"] ?? '');
        $ap3      = $conn->real_escape_string($_POST["about_p3_$lang"] ?? '');
        $conn->query("UPDATE farm_data SET title='$title',subtitle='$subtitle',btn_crop_info='$bci',btn_calculator='$bcalc',btn_helpline='$bhel',switch_language='$sw',about_heading='$ah',about_p1='$ap1',about_p2='$ap2',about_p3='$ap3' WHERE lang='$lang'");
    }
    $msg = 'success';
}

$data = [];
$res = $conn->query("SELECT * FROM farm_data");
while ($row = $res->fetch_assoc()) { $data[$row['lang']] = $row; }

function v($data, $lang, $key) {
    return htmlspecialchars($data[$lang][$key] ?? '');
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Home Content</title>
<?php include __DIR__ . '/partials/head-styles.php'; ?>
</head><body>
<div class="layout">
<?php include __DIR__ . '/partials/sidebar.php'; ?>
<main class="content">
  <div class="page-header"><h1>Home Content</h1></div>
  <?php if ($msg === 'success'): ?><div class="alert alert-success">✔ Saved successfully!</div><?php endif; ?>
  <form method="POST">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

    <!-- English -->
    <div class="card">
      <h2>🇬🇧 English</h2>
      <?php foreach ([
        'title'=>'Page Title','subtitle'=>'Subtitle',
        'btn_crop_info'=>'Button: Crop Info','btn_calculator'=>'Button: AgriCost',
        'btn_helpline'=>'Button: Helpline','switch_language'=>'Language Toggle Button',
        'about_heading'=>'About Heading','about_p1'=>'About Para 1',
        'about_p2'=>'About Para 2','about_p3'=>'About Para 3'
      ] as $field => $label): ?>
      <div class="form-group" style="margin-bottom:10px">
        <label><?= $label ?></label>
        <?php if (str_starts_with($field,'about_p')): ?>
        <textarea name="<?= $field ?>_en"><?= v($data,'en',$field) ?></textarea>
        <?php else: ?>
        <input type="text" name="<?= $field ?>_en" value="<?= v($data,'en',$field) ?>">
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Urdu -->
    <div class="card">
      <h2>🇵🇰 اردو</h2>
      <?php foreach ([
        'title'=>'عنوان','subtitle'=>'ذیلی عنوان',
        'btn_crop_info'=>'بٹن: فصل','btn_calculator'=>'بٹن: لاگت',
        'btn_helpline'=>'بٹن: ہیلپ لائن','switch_language'=>'زبان بدلنے کا بٹن',
        'about_heading'=>'ہمارے بارے میں','about_p1'=>'پیراگراف 1',
        'about_p2'=>'پیراگراف 2','about_p3'=>'پیراگراف 3'
      ] as $field => $label): ?>
      <div class="form-group" style="margin-bottom:10px">
        <label><?= $label ?></label>
        <?php if (str_starts_with($field,'about_p')): ?>
        <textarea name="<?= $field ?>_ur" dir="rtl"><?= v($data,'ur',$field) ?></textarea>
        <?php else: ?>
        <input type="text" name="<?= $field ?>_ur" dir="rtl" value="<?= v($data,'ur',$field) ?>">
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
  </form>
</main></div></body></html>
