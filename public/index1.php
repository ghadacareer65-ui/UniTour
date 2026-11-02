<?php
session_start();
require_once "config.php";

// لايحفظ بيانات السيشن 
unset($_SESSION['answers']);
unset($_SESSION['school']);
unset($_SESSION['qudrat']);
unset($_SESSION['tahsili']);
unset($_SESSION['weighted']);
unset($_SESSION['gender']);
unset($_SESSION['track_selected']);

// ===== تعبئة آخر نتيجة محفوظة للمستخدم المسجّل =====
$prev = [];
if (!empty($_SESSION['user_email'])) {
    try {
        $st = $conn->prepare("SELECT r.* FROM user_results r JOIN users u ON u.id = r.user_id
                              WHERE u.email = ? ORDER BY r.id DESC LIMIT 1");
        $st->bind_param("s", $_SESSION['user_email']);
        $st->execute();
        $prev = $st->get_result()->fetch_assoc() ?: [];
    } catch (Throwable $e) { $prev = []; }
}
if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$is_ar = ($lang == 'ar');

$texts = [
    'school'   => $is_ar ? "نسبة الثانوية"      : "School Grade",
    'qudrat'   => $is_ar ? "درجة القدرات"        : "Qudrat Score",
    'tahsili'  => $is_ar ? "درجة التحصيلي"       : "Tahsili Score",
    'weighted' => $is_ar ? "النسبة الموزونة"     : "Weighted Score",
    'gender'   => $is_ar ? "الجنس"               : "Gender",
    'male'     => $is_ar ? "طالب"                : "Male",
    'female'   => $is_ar ? "طالبة"               : "Female",
    'track'    => $is_ar ? "اختر المسار"         : "Select Track",
    'start'    => $is_ar ? "ابدأ الاختبار"       : "Start Quiz",
    'home'     => $is_ar ? "الرئيسية"            : "Home",
    'login_g'  => $is_ar ? "الدخول عبر Google"  : "Login with Google",
    'reg'      => $is_ar ? "إنشاء حساب"          : "Register",
    'logout'   => $is_ar ? "تسجيل الخروج"        : "Logout",
    'welcome'  => $is_ar ? "مرحباً"              : "Welcome"
];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>" dir="<?= $is_ar ? 'rtl' : 'ltr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniTour</title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body { font-family: 'Tajawal', sans-serif; }

.main-section {
    min-height: 100vh;
    background:
        linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
        url('images/index5.png') center/cover no-repeat;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 90px;
}

.overlay {
    background: linear-gradient(to bottom, rgba(10,15,25,0.85), rgba(10,15,25,0.65));
    backdrop-filter: blur(4px);
}

.header-wrapper {
    position: absolute;
    top: 0;
    width: 100%;
    padding: 20px 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
    flex-wrap: wrap;
}

.nav-group, .lang-group {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-style {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 8px 16px;
    border-radius: 10px;
    border: 1px solid rgba(59,109,246,0.6);
    text-decoration: none;
    transition: 0.3s;
    box-shadow: 0 0 8px rgba(59,109,246,0.3);
}

.btn-style:hover {
    background: rgba(255,255,255,0.15);
    border-color: #3b6df6;
    box-shadow: 0 0 14px rgba(59,109,246,0.5);
}

.lang-toggle {
    display: flex;
    background: rgba(255,255,255,0.15);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.2);
}

.lang-toggle a {
    padding: 8px 16px;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    transition: 0.3s;
    border-radius: 20px;
}

.lang-toggle a.active-lang { background: #3b6df6; }
.lang-toggle a:hover { background: rgba(59,109,246,0.6); }

.user-welcome {
    color: #fff;
    font-weight: bold;
}

.data-card {
    position: relative;
    z-index: 10;
    width: 50%;
    max-width: 400px;
    padding: 20px 15px;
    border-radius: 25px;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(25px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.6);
    text-align: center;
    transform: translateY(-20px);
}

.logo {
    width: 180px;
    margin-bottom: 20px;
    filter: drop-shadow(0 5px 15px rgba(0,0,0,0.6));
}

input, select {
    width: 100%;
    height: 52px;
    padding: 0 16px;
    margin-bottom: 14px;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.25);
    background: rgba(255,255,255,0.18);
    color: #fff;
    font-size: 15px;
    font-family: 'Tajawal', sans-serif;
}

input::placeholder { color: rgba(255,255,255,0.85); }
select:invalid { color: #ccc; }
option { color: #000; }

.submit-btn {
    width: 100%;
    padding: 16px;border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #3b6df6, #5a8cff);
    color: #fff;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s;
    font-family: 'Tajawal', sans-serif;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(59,109,246,0.4);
}
</style>

<script>
function calculateWeighted() {
    let s = +document.getElementById("school_input").value  || 0;
    let q = +document.getElementById("qudrat_input").value  || 0;
    let t = +document.getElementById("tahsili_input").value || 0;
    document.getElementById("weighted_input").value = (s*0.3 + q*0.3 + t*0.4).toFixed(2);
}
</script>
</head>

<body>
<section class="main-section">
<div class="overlay"></div>

<header class="header-wrapper">

    
    <div class="nav-group">
        <?php if(isset($_SESSION['user_name'])): ?>
            <span class="user-welcome"><?= htmlspecialchars($texts['welcome']." ".$_SESSION['user_name']) ?></span>
            <a href="logout.php" class="btn-style"><?= $texts['logout'] ?></a>
        <?php else: ?>
            <a href="google_login.php" class="btn-style"><?= $texts['login_g'] ?></a>
            <a href="register.php" class="btn-style"><?= $texts['reg'] ?></a>
        <?php endif; ?>
        <a href="index.php?lang=<?= htmlspecialchars($lang) ?>" class="btn-style"><?= $texts['home'] ?></a>
    </div>

    
    <div class="lang-toggle">
        <?php if($is_ar): ?>
            <a href="?lang=ar" class="active-lang">AR</a>
            <a href="?lang=en">EN</a>
        <?php else: ?>
            <a href="?lang=en" class="active-lang">EN</a>
            <a href="?lang=ar">AR</a>
        <?php endif; ?>
    </div>

</header>

<div class="data-card">
    <img src="images/unitour_v2.png" class="logo" alt="UniTour">

    <form action="quiz.php" method="POST">

        <input type="number" name="school" id="school_input"
               placeholder="<?= htmlspecialchars($texts['school']) ?>"
               min="0" max="100" value="<?= htmlspecialchars($prev['school'] ?? '') ?>"
               oninput="calculateWeighted()" required>

        <input type="number" name="qudrat" id="qudrat_input"
               placeholder="<?= htmlspecialchars($texts['qudrat']) ?>"
               min="0" max="100" value="<?= htmlspecialchars($prev['qudrat'] ?? '') ?>"
               oninput="calculateWeighted()" required>

        <input type="number" name="tahsili" id="tahsili_input"
               placeholder="<?= htmlspecialchars($texts['tahsili']) ?>"
               min="0" max="100" value="<?= htmlspecialchars($prev['tahsili'] ?? '') ?>"
               oninput="calculateWeighted()" required>

        <input type="text" name="weighted" id="weighted_input"
               placeholder="<?= htmlspecialchars($texts['weighted']) ?>" value="<?= htmlspecialchars($prev['weighted'] ?? '') ?>" readonly>

        <select name="gender" required>
            <option disabled selected value=""><?= $texts['gender'] ?></option>
            <option value="male" <?= ($prev['gender'] ?? '')=='male'?'selected':'' ?>><?= $texts['male'] ?></option>
            <option value="female" <?= ($prev['gender'] ?? '')=='female'?'selected':'' ?>><?= $texts['female'] ?></option>
        </select>

        <select name="track" required>
            <option disabled selected value=""><?= $texts['track'] ?></option>
            <option value="tech" <?= ($prev['track_selected'] ?? '')=='tech'?'selected':'' ?>><?= $is_ar ? "هندسة الحاسب" : "Computer Engineering" ?></option>
            <option value="health" <?= ($prev['track_selected'] ?? '')=='health'?'selected':'' ?>><?= $is_ar ? "صحة وحياة" : "Health & Life" ?></option>
            <option value="admin" <?= ($prev['track_selected'] ?? '')=='admin'?'selected':'' ?>><?= $is_ar ? "إداري" : "Business" ?></option>
            <option value="sharia" <?= ($prev['track_selected'] ?? '')=='sharia'?'selected':'' ?>><?= $is_ar ? "شرعي" : "Sharia" ?></option>
            <option value="general" <?= ($prev['track_selected'] ?? '')=='general'?'selected':'' ?>><?= $is_ar ? "عام" : "General" ?></option>
        </select>

        <button type="submit" class="submit-btn"><?= $texts['start'] ?></button>

    </form>
</div>

</section>
</body>
</html>