<?php
session_start();
require_once "config.php";

if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$lang = $_SESSION['lang'] ?? 'ar';
$is_ar = ($lang == 'ar');

$user_name = $_SESSION['user_name'] ?? 'Guest';
$gender    = $_SESSION['gender']    ?? 'male';
$weighted  = floatval($_SESSION['weighted'] ?? 0);

if(isset($_POST['answers'])){
    $_SESSION['answers'] = $_POST['answers'];
}

$answers = $_SESSION['answers'] ?? [];

$scores = [
    'إداري'      => 0,
    'شرعي'       => 0,
    'صحة وحياة'  => 0,
    'هندسة حاسب' => 0,
    'عام'        => 0
];

$track_num_map = [
    1 => 'إداري',
    2 => 'شرعي',
    3 => 'صحة وحياة',
    4 => 'هندسة حاسب',
    5 => 'عام'
];

foreach($answers as $a){
    $track = $track_num_map[$a] ?? '';
    if(isset($scores[$track])){
        $scores[$track]++;
    }
}

arsort($scores);
$top_track_ar = array_key_first($scores);

$selected_track = $_SESSION['track_selected'] ?? 'general';

$track_selected_map = [
    'tech'    => 'هندسة حاسب',
    'health'  => 'صحة وحياة',
    'admin'   => 'إداري',
    'sharia'  => 'شرعي',
    'general' => 'عام'
];

$student_track_ar = $track_selected_map[$selected_track] ?? 'عام';

// ================== التنبؤ بالمسار عبر نموذج التعلم الآلي ==================
// true  = قرار النموذج هو المسار المقترح
// false = المسار اللي اختاره الطالب هو الأساس والنموذج للمقارنة فقط
$ML_DECIDES = true;

$ml_map = [
    'admin'   => 'إداري',
    'sharia'  => 'شرعي',
    'health'  => 'صحة وحياة',
    'tech'    => 'هندسة حاسب',
    'general' => 'عام'
];

function ml_predict($url, $payload){
    $ctx = stream_context_create([
        'http' => [
            'method'        => 'POST',
            'header'        => "Content-Type: application/json\r\n",
            'content'       => json_encode($payload),
            'timeout'       => 8,
            'ignore_errors' => true
        ]
    ]);
    $res = @file_get_contents($url, false, $ctx);
    if ($res === false) return null;
    $j = json_decode($res, true);
    return $j['predicted_track'] ?? null;
}

if (isset($_POST['answers'])) {
    $ml_url = getenv('ML_API_URL') ?: 'http://127.0.0.1:5000';
    $payload = [
        'school'  => floatval($_SESSION['school']  ?? 0),
        'qudrat'  => floatval($_SESSION['qudrat']  ?? 0),
        'tahsili' => floatval($_SESSION['tahsili'] ?? 0),
        'gender'  => ($gender == 'female') ? 'female' : 'male'
    ];
    for ($i = 1; $i <= 10; $i++) {
        $payload['q'.$i] = (int)($answers[$i] ?? 5);
    }
    $_SESSION['ml_track'] = ml_predict(rtrim($ml_url, '/') . '/predict', $payload);
}

$ml_track_en = $_SESSION['ml_track'] ?? null;
$ml_track_ar = $ml_map[$ml_track_en] ?? null;
$ml_used     = ($ml_track_ar !== null);

// المسار الناتج عن التحليل (النموذج، وإذا تعطّل نرجع لحساب الإجابات)
$interest_track_ar = $ml_used ? $ml_track_ar : array_key_first($scores);

if ($ML_DECIDES || $student_track_ar == 'عام') {
    $top_track_ar = $interest_track_ar;
    if ($top_track_ar == 'عام' && !$ml_used) {
        $tracks_sorted = array_keys($scores);
        $second = $tracks_sorted[1] ?? 'عام';
        if (($scores[$second] ?? 0) > 0) { $top_track_ar = $second; }
    }
} else {
    $top_track_ar = $student_track_ar;
}

$academic_note = '';

if ($student_track_ar != 'عام' && $interest_track_ar != $student_track_ar) {
    $academic_note = $ML_DECIDES
        ? "رشّح لك نموذج التعلم الآلي مساراً مختلفاً عن المسار الذي اخترته، بناءً على درجاتك وميولك. يمكنك مقارنته بمسارك الحالي."
        : "تشير إجاباتك إلى ميول مرتبطة بمسار أكاديمي مختلف، لذلك تم تقييد التوصيات لتتوافق مع مسارك الدراسي الحالي ومتطلبات القبول الجامعي.";
}

$track_translate_en = [
    'هندسة حاسب' => 'Computer Engineering',
    'صحة وحياة'  => 'Health & Life',
    'إداري'      => 'Business Administration',
    'شرعي'       => 'Sharia Sciences',
    'عام'        => 'General'
];

$top_track_display = $is_ar ? $top_track_ar : ($track_translate_en[$top_track_ar] ?? $top_track_ar);
$top_track_sql     = $top_track_ar;


// ===== حفظ النتيجة للمستخدم المسجّل (مرة واحدة عند إرسال الاختبار) =====
if (isset($_POST['answers']) && !empty($_SESSION['user_email'])) {
    try {
        $st = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $st->bind_param("s", $_SESSION['user_email']);
        $st->execute();
        $u = $st->get_result()->fetch_assoc();
        if ($u) {
            $uid = (int)$u['id'];
            $sc  = floatval($_SESSION['school']  ?? 0);
            $qd  = floatval($_SESSION['qudrat']  ?? 0);
            $th  = floatval($_SESSION['tahsili'] ?? 0);
            $gd  = $_SESSION['gender'] ?? '';
            $tsel = $_SESSION['track_selected'] ?? '';
            $ins = $conn->prepare("INSERT INTO user_results
                (user_id, school, qudrat, tahsili, weighted, gender, track_selected, result_track)
                VALUES (?,?,?,?,?,?,?,?)");
            $ins->bind_param("iddddsss", $uid, $sc, $qd, $th, $weighted, $gd, $tsel, $top_track_ar);
            $ins->execute();
        }
    } catch (Throwable $e) {
        error_log("save result failed: " . $e->getMessage());
    }
}

$gender_allowed = ($gender == "female") ? "female" : "both";
$universities = [];

// ===== شروط القبول (النسبة الموزونة) لكل جامعة =====
// min          = الحد الأدنى العام للجامعة
// high_cats    = المسارات اللي تحتاج نسبة أعلى في هذي الجامعة
// high_min     = الحد الأدنى لتلك المسارات
$admission = [
    1 => ['min' => 75, 'high_cats' => [],                          'high_min' => 75],  // القصيم - عنيزة (طالبات)
    5 => ['min' => 75, 'high_cats' => [],                          'high_min' => 75],  // القصيم - المليداء
    2 => ['min' => 85, 'high_cats' => ['صحة وحياة', 'هندسة حاسب'], 'high_min' => 95],  // الملك سعود
    3 => ['min' => 80, 'high_cats' => [],                          'high_min' => 80],  // الأميرة نورة (عدّليها حسب شروطهم)
    4 => ['min' => 99, 'high_cats' => [],                          'high_min' => 99],  // كاوست
];

$sql_unis = "SELECT u.id, u.name_ar, u.name_en, u.city_ar, u.city_en, u.logo_url,
                    MAX(vt.tour_url) as tour_url
             FROM universities u
             LEFT JOIN virtual_tours vt ON u.id = vt.university_id
             WHERE (u.gender_allowed = ? OR u.gender_allowed = 'both')
             GROUP BY u.id, u.name_ar, u.name_en, u.city_ar, u.city_en, u.logo_url
             ORDER BY CASE WHEN u.id IN (1, 5) THEN 0 ELSE 1 END, u.id";
$stmt = $conn->prepare($sql_unis);
$stmt->bind_param("s", $gender_allowed);
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

foreach ($rows as $row) {
    $rule = $admission[(int)$row['id']] ?? ['min' => 60, 'high_cats' => [], 'high_min' => 60];
    $required = in_array($top_track_sql, $rule['high_cats'], true) ? $rule['high_min'] : $rule['min'];
    if ($weighted < $required) continue;   // نسبتك أقل من شرط القبول

    $majors = [];
    $stmt2 = $conn->prepare("SELECT name_ar, name_en FROM majors
                             WHERE university_id = ? AND category = ? LIMIT 3");
    $uid_tmp = (int)$row['id'];
    $stmt2->bind_param("is", $uid_tmp, $top_track_sql);
    $stmt2->execute();
    $mr = $stmt2->get_result();
    while ($m = $mr->fetch_assoc()) {
        $majors[] = $is_ar ? $m['name_ar'] : $m['name_en'];
    }
    if (empty($majors)) {
        $majors[] = $is_ar ? 'لا تتوفر تخصصات في هذا المسار حالياً' : 'No majors available for this track yet';
    }

    $universities[] = [
        'id'     => $row['id'],
        'name'   => $is_ar ? $row['name_ar'] : $row['name_en'],
        'city'   => $is_ar ? $row['city_ar'] : $row['city_en'],
        'logo'   => $row['logo_url'],
        'tour'   => $row['tour_url'] ?? '',
        'min'    => $required,
        'majors' => $majors
    ];
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $is_ar ? 'rtl' : 'ltr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniTour - <?= $is_ar ? 'النتائج' : 'Results' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">

<style>
*{ box-sizing:border-box; margin:0; padding:0; }

body{
    font-family:'Tajawal',sans-serif;
    background:
        linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
        url('images/index5.webp') center/cover no-repeat fixed;
    color:#fff;
    min-height:100vh;
    display:flex;
    flex-direction:column;
}

.nav-header{
    position:fixed;top:16px;
    left:0;
    right:0;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 40px;
    z-index:100;
}

.top-btn{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);
    color:#fff;
    padding:10px 18px;
    border-radius:10px;
    border:1px solid rgba(59,109,246,0.6);
    text-decoration:none;
    font-size:14px;
    font-weight:bold;
    transition:0.3s;
    box-shadow:0 0 8px rgba(59,109,246,0.3);
}

.top-btn:hover{
    background:rgba(255,255,255,0.15);
    box-shadow:0 0 14px rgba(59,109,246,0.5);
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
.lang-toggle a:hover{ background:rgba(59,109,246,0.5); }

.container{
    flex:1;
    display:flex;
    flex-direction:column;
    align-items:center;
    padding-top:80px;
    padding-bottom:30px;
    text-align:center;
}

.unitour-logo{
    width:180px;
    margin-bottom:6px;
    filter:drop-shadow(0 4px 15px rgba(0,0,0,0.4));
}

.sub-text{
    font-size:14px;
    color:rgba(255,255,255,0.85);
    margin-bottom:2px;
}

.track{
    font-size:36px;
    font-weight:900;
    color:#a8c4ff;
    margin:4px 0 10px;
    text-shadow:0 0 20px rgba(59,109,246,0.5);
}

.badges{
    display:flex;
    justify-content:center;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:10px;
}

.ml-badge{
    background:rgba(59,109,246,0.2);
    border:1px solid #3b6df6;
    color:#fff;
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
}

.weighted-badge{
    background:rgba(255,255,255,0.1);
    border:1px solid rgba(255,255,255,0.3);
    color:#fff;
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
}

.section-title{
    font-size:16px;
    font-weight:700;
    color:#fff;
    margin-bottom:12px;
}

.cards{
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:16px;
    padding:0 40px;
    width:100%;
    max-width:860px;
    margin:auto;
}

.result-card{
    background:rgba(255,255,255,0.96);
    color:#222;
    border-radius:18px;
    text-align:center;
    box-shadow:0 8px 25px rgba(0,0,0,0.3);
    overflow:hidden;
    display:flex;
    flex-direction:column;
    transition:transform 0.3s;
}

.result-card:hover{ transform:translateY(-4px); }

.card-body{
    padding:12px 12px 8px;
    flex:1;
}

.uni-logo{
    width:100%;
    height:100px;
    object-fit:contain;
    padding:0 8px;
    margin-bottom:8px;
}

.result-card h3{
    font-size:15px;
    font-weight:700;
    margin-bottom:4px;
    color:#111;
}

.result-card p{
    font-size:12px;
    color:#777;
    margin-bottom:6px;
}

.majors-title{
    font-size:11px;
    color:#3b6df6;
    font-weight:700;
    margin-bottom:5px;
}

.majors-wrap{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:5px;
    background:#eef3ff;
    border-radius:8px;
    padding:6px;
    margin:0 4px 6px;
}

.major{
    background:#5d8dee;
    color:#fff;
    padding:4px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

.btn-tour{
    display:block;
    width:100%;
    padding:11px;
    background:linear-gradient(135deg,#5b8dee,#89b4ff);
    color:#fff;
    text-decoration:none;
    font-weight:bold;
    font-size:13px;
    font-family:'Tajawal',sans-serif;
    transition:0.3s;
}

.btn-tour:hover{ background:linear-gradient(135deg,#4a7de0,#6fa0f0); }

.no-result{
    background:rgba(255,255,255,0.1);
    border:1px solid rgba(255,255,255,0.2);
    border-radius:16px;
    padding:30px;
    max-width:450px;
    margin:20px auto;
    font-size:15px;
}
.academic-note{
    background: #fff8e1;
    color: #8a6d3b;
    padding: 14px 22px;
    border-radius: 14px;

    margin-top: 25px;
    margin-bottom: 25px;

    max-width: 850px;
    width: 90%;

    font-size: 15px;
    line-height: 1.9;
    text-align: center;

    border: 1px solid #f0d98a;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

@media(max-width:700px){
    .cards{
        grid-template-columns:1fr;
        padding:0 20px;
    }

    .nav-header{
        padding:0 18px;
    }

    .track{
        font-size:28px;
    }

    .unitour-logo{width:150px;
    }
}
</style>
</head>

<body>

<div class="nav-header">
    <div style="display:flex; gap:10px;">
        <a href="clear.php" class="top-btn">↺ <?= $is_ar ? 'إعادة' : 'Retake' ?></a>
        <a href="index1.php" class="top-btn"><?= $is_ar ? 'الرئيسية' : 'Home' ?></a>
    </div>

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
    <img src="images/unitour_v2.png" alt="UniTour" class="unitour-logo">

    <p class="sub-text"><?= $is_ar ? 'المسار المقترح لك:' : 'Your suggested track:' ?></p>
    <div class="track"><?= htmlspecialchars($top_track_display) ?></div>
    <?php if (!empty($academic_note)): ?>
    <div class="academic-note">
        <?= $academic_note ?>
    </div>
    <?php endif; ?>

    <div class="badges">
        <span class="ml-badge"><?= $ml_used ? ($is_ar ? 'تم التحليل باستخدام التعلم الآلي' : 'Generated using Machine Learning') : ($is_ar ? 'تم التحليل بناءً على إجاباتك' : 'Based on your answers') ?></span>
        <span class="weighted-badge"><?= $is_ar ? 'نسبتك:' : 'Your score:' ?> <?= $weighted ?>%</span>
    </div>

    <?php if($weighted < 60): ?>

        <div class="no-result">
            <p><?= $is_ar ? 'نسبتك أقل من 60% — لا توجد توصيات جامعية حالياً' : 'Score below 60% — No university recommendations available' ?></p>
        </div>

    <?php elseif(!empty($universities)): ?>

        <p class="section-title"><?= $is_ar ? 'الجامعات المقترحة لك' : 'Recommended Universities' ?>:</p>

        <div class="cards">
            <?php foreach($universities as $uni): ?>
                <div class="result-card">
                    <div class="card-body">
                        <?php $logo = !empty($uni['logo']) ? $uni['logo'] : 'images/default.png'; ?>

                        <img src="<?= htmlspecialchars($logo) ?>" class="uni-logo" alt="logo">

                        <h3><?= htmlspecialchars($uni['name']) ?></h3>
                        <p><?= htmlspecialchars($uni['city']) ?></p>
                        <p class="majors-title"><?= $is_ar ? 'الحد الأدنى للقبول: ' : 'Minimum admission: ' ?><?= (float)$uni['min'] ?>%</p>

                        <p class="majors-title"><?= $is_ar ? 'التخصصات المقترحة:' : 'Suggested Majors:' ?></p>

                        <div class="majors-wrap">
                            <?php foreach($uni['majors'] as $m): ?>
                                <span class="major"><?= htmlspecialchars($m) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if(!empty($uni['tour'])): ?>
                        <a href="<?= htmlspecialchars($uni['tour']) ?>" target="_blank" class="btn-tour">
                            <?= $is_ar ? 'جولة افتراضية' : 'Virtual Tour' ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>

        <div class="no-result">
            <p><?= $is_ar ? 'نسبتك الموزونة أقل من شروط القبول في الجامعات المتاحة' : 'Your weighted percentage is below the admission requirements' ?></p>
        </div>

    <?php endif; ?>

</div>

</body>
</html>