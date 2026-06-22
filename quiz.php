<?php
session_start();
require_once "config.php";

if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: quiz.php");
    exit();
}

if(isset($_POST['school'])){
    $_SESSION['school']         = $_POST['school'];
    $_SESSION['qudrat']         = $_POST['qudrat'];
    $_SESSION['tahsili']        = $_POST['tahsili'];
    $_SESSION['weighted']       = $_POST['weighted'];
    $_SESSION['gender']         = $_POST['gender'];
    $_SESSION['track_selected'] = $_POST['track'];
    $_SESSION['user_name']      = $_SESSION['user_name'] ?? 'Guest';
}

$lang = $_SESSION['lang'] ?? 'ar';
$is_ar = ($lang == 'ar');

$weighted       = $_SESSION['weighted']       ?? 0;
$track_selected = $_SESSION['track_selected'] ?? '';

$track_map_display_ar = [
    'tech'    => 'هندسة حاسب',
    'health'  => 'صحة وحياة',
    'admin'   => 'إداري',
    'sharia'  => 'شرعي',
    'general' => 'عام'
];

$track_map_display_en = [
    'tech'    => 'Computer Engineering',
    'health'  => 'Health & Life',
    'admin'   => 'Business Administration',
    'sharia'  => 'Sharia Sciences',
    'general' => 'General'
];

$track_display = $is_ar
    ? ($track_map_display_ar[$track_selected] ?? $track_selected)
    : ($track_map_display_en[$track_selected] ?? $track_selected);

$sql = "SELECT q.id as q_id, q.question_ar, q.question_en,
               o.text_ar, o.text_en, o.track_id
        FROM quiz_questions q
        JOIN quiz_options o ON q.id = o.question_id
        ORDER BY q.id ASC";

$result = mysqli_query($conn, $sql);

$quiz_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $q_id = $row['q_id'];
    if (!isset($quiz_data[$q_id])) {
        $quiz_data[$q_id] = [
            'question' => $is_ar ? $row['question_ar'] : $row['question_en'],
            'options'  => []
        ];
    }
    $quiz_data[$q_id]['options'][] = [
        'text'  => $is_ar ? $row['text_ar'] : $row['text_en'],
        'track' => $row['track_id']
    ];
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $is_ar ? 'rtl' : 'ltr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $is_ar ? 'اختبار الميول' : 'Interest Quiz' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">

<style>
*{ box-sizing:border-box; margin:0; padding:0; }

body{
    font-family:'Tajawal',sans-serif;
    background:
        linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
        url('images/index5.png') center/cover no-repeat fixed;
    color:#fff;
    min-height:100vh;
}

/*  ثابت فوق دايماً */
.nav-header{
    position:fixed;
    top:0;
    left:0;
    right:0;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 40px;
    z-index:1000;   
}

.lang-toggle{
    display:flex;
    background:rgba(255,255,255,0.15);
    border-radius:20px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.2);
}

.lang-toggle a{
    padding:8px 16px;
    color:#fff;
    text-decoration:none;
    font-weight:bold;
    font-size:14px;
    border-radius:20px;
    transition:0.3s;
}

.lang-toggle a.active{ background:#3b6df6; }
.lang-toggle a:hover{ background:rgba(59,109,246,0.6); }

.top-btn{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    color:#fff;
    padding:10px 16px;
    border-radius:10px;
    border:1px solid rgba(59,109,246,0.6);
    text-decoration:none;
    transition:0.3s;
    box-shadow:0 0 8px rgba(59,109,246,0.3);
}

.top-btn:hover{
    background:rgba(255,255,255,0.15);
    box-shadow:0 0 14px rgba(59,109,246,0.5);
}

.container{
    max-width:900px;
    margin:0 auto;
    padding:100px 30px 100px;
}

h1{ text-align:center; margin-bottom:20px; }

.info-box{
    text-align:center;
    margin-bottom:25px;
    background:rgba(255,255,255,0.1);
    padding:12px;
    border-radius:12px;
}

.q-card{
    background:rgba(255,255,255,0.08);
    padding:18px;
    border-radius:14px;
    margin-bottom:20px;border:1px solid rgba(255,255,255,0.15);
}

.q-card b{ display:block; margin-bottom:12px; }

.option-item{
    display:flex;
    align-items:center;
    gap:10px;
    padding:8px 10px;
    border-radius:8px;
    cursor:pointer;
    transition:0.2s;
}

.option-item:hover{ background:rgba(255,255,255,0.1); }
.option-item input{ accent-color:#3b6df6; }

.btn-submit{
    width:100%;
    padding:15px;
    background:#3b6df6;
    border:none;
    border-radius:12px;
    color:#fff;
    font-weight:bold;
    font-size:16px;
    cursor:pointer;
    font-family:'Tajawal',sans-serif;
    transition:0.3s;
    margin-top:20px;
}

.btn-submit:hover{ background:#2f5be0; }
</style>
</head>

<body>

<!--  ثابت فوق -->
<div class="nav-header">
    <a href="index1.php" class="top-btn">
         <?= $is_ar ? 'الرئيسية' : 'Home' ?>
    </a>
    <div class="lang-toggle">
        <?php if($is_ar): ?>
            <a href="?lang=ar" class="active">AR</a>
            <a href="?lang=en">EN</a>
        <?php else: ?>
            <a href="?lang=en" class="active">EN</a>
            <a href="?lang=ar">AR</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">

    <h1><?= $is_ar ? "اختبار الميول" : "Interest Quiz" ?></h1>

    <div class="info-box">
        <?= $is_ar ? "النسبة:" : "Weighted:" ?>
        <b><?= $weighted ?>%</b> |
        <?= $is_ar ? "المسار:" : "Track:" ?>
        <b><?= htmlspecialchars($track_display) ?></b>
    </div>

    <form action="result.php" method="POST">

    <?php foreach ($quiz_data as $q_id => $content): ?>
        <div class="q-card">
            <b><?= htmlspecialchars($content['question']) ?></b>
            <?php foreach ($content['options'] as $option): ?>
            <label class="option-item">
                <input type="radio"
                    name="answers[<?= $q_id ?>]"
                    value="<?= $option['track'] ?>"
                    required>
                <span><?= htmlspecialchars($option['text']) ?></span>
            </label>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

        <button type="submit" class="btn-submit">
            <?= $is_ar ? "تحليل النتائج" : "Analyze Results" ?>
        </button>

    </form>

</div>

</body>
</html>