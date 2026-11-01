<?php
session_start();
require_once "config.php";

if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$is_ar = ($lang == 'ar');

$title      = $is_ar ? "إنشاء حساب" : "Register";
$home_text  = $is_ar ? "الرئيسية" : "Home";
$name_text  = $is_ar ? "الاسم" : "Name";
$email_text = $is_ar ? "البريد الإلكتروني" : "Email";
$pass_text  = $is_ar ? "كلمة المرور" : "Password";
$btn_text   = $is_ar ? "تسجيل" : "Register";
$login_link = $is_ar ? "لديك حساب؟ تسجيل الدخول" : "Already have an account? Login";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    /* تحقق إن الإيميل مو مسجل */
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        $message = $is_ar ? "⚠️ هذا البريد الإلكتروني مسجل مسبقاً" : "⚠️ Email already registered";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if($stmt->execute()){
            header("Location: login.php?lang=".$lang);
            exit();
        } else {
            $message = $is_ar ? "حدث خطأ أثناء التسجيل" : "Registration error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $is_ar?'rtl':'ltr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
<style>
body{ margin:0; font-family:'Tajawal',sans-serif; }

.section{
    min-height:100vh;
    background:url('images/index5.png') center/cover no-repeat;
    position:relative;
    overflow:hidden;
}

.overlay{
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    backdrop-filter:blur(8px);
}

.top-bar{
    position:absolute;
    top:25px;
    left:0;
    right:0;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 30px;
    z-index:10;
    box-sizing:border-box;
}

.btn{
    background:rgba(255,255,255,0.15);
    color:#fff;
    padding:8px 18px;
    border-radius:10px;
    text-decoration:none;
    transition:0.3s;
    font-size:14px;
}

.btn:hover{ background:#3b6df6; }

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

.card{
    position:absolute;
    top:52%;
    left:50%;
    transform:translate(-50%,-50%);
    width:90%;
    max-width:430px;
    padding:40px 30px;
    border-radius:22px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(25px);
    box-shadow:0 25px 70px rgba(0,0,0,0.7);
    text-align:center;
}

.logo{ width:140px; margin-bottom:10px; }
h2{ color:#fff; margin-bottom:25px; }

.auth-message{
    color:#ff6b6b;
    margin-bottom:12px;
    background:rgba(255,100,100,0.1);
    border:1px solid rgba(255,100,100,0.3);
    padding:10px;
    border-radius:10px;
    font-size:14px;
}

input{
    width:100%;
    height:50px;
    padding:0 16px;
    margin-bottom:14px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.2);
    background:rgba(255,255,255,0.12);
    color:#fff;
    font-size:15px;
    box-sizing:border-box;
    transition:0.3s;
}

input::placeholder{ color:#ddd; }
input:focus{
    outline:none;
    border:1px solid #3b6df6;
    background:rgba(255,255,255,0.18);
}

.start{
    width:100%;
    padding:15px;
    border:none;
    border-radius:14px;background:linear-gradient(135deg,#3b6df6,#5a8cff);
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    margin-top:10px;
    transition:0.3s;
    font-family:'Tajawal',sans-serif;
}

.start:hover{
    transform:translateY(-2px);
    box-shadow:0 15px 35px rgba(59,109,246,0.6);
}

.auth-link{ margin-top:14px; }
.auth-link a{ color:#9ec3ff; text-decoration:none; }
</style>
</head>

<body>
<section class="section">
<div class="overlay"></div>

<div class="top-bar">
    <a href="index.php?lang=<?= $lang ?>" class="btn"> <?= $home_text ?></a>
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

<div class="card">
    <img src="images/unitour_v2.png" class="logo">
    <h2><?= $title ?></h2>

    <?php if(!empty($message)): ?>
    <p class="auth-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="<?= $name_text ?>" required>
        <input type="email" name="email" placeholder="<?= $email_text ?>" required>
        <input type="password" name="password" placeholder="<?= $pass_text ?>" required>
        <button type="submit" class="start"><?= $btn_text ?></button>
    </form>

    <p class="auth-link">
        <a href="login.php?lang=<?= $lang ?>"><?= $login_link ?></a>
    </p>
</div>

</section>
</body>
</html>