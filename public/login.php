<?php
session_start();
require_once "config.php";

if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$is_ar = ($lang == 'ar');

$login_title = ($is_ar) ? "تسجيل الدخول" : "Login";
$home_text   = ($is_ar) ? "الرئيسية" : "Home";
$email_text  = ($is_ar) ? "البريد الإلكتروني" : "Email";
$pass_text   = ($is_ar) ? "كلمة المرور" : "Password";
$btn_text    = ($is_ar) ? "دخول" : "Login";
$reg_link    = ($is_ar) ? "ليس لديك حساب؟ إنشاء حساب" : "Don't have an account? Register";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: index.php?lang=".$lang);
            exit();
        } else {
            $message = ($is_ar) ? "كلمة المرور غير صحيحة" : "Incorrect password";
        }
    } else {
        $message = ($is_ar) ? "البريد الإلكتروني غير موجود" : "Email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $is_ar?'rtl':'ltr' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $login_title ?></title>
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
    background:rgba(0,0,0,0.65);
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
    background:rgba(255,255,255,0.2);
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
    top:55%;
    left:50%;
    transform:translate(-50%,-50%);
    width:90%;
    max-width:420px;
    padding:35px 30px;
    border-radius:20px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(20px);
    box-shadow:0 20px 60px rgba(0,0,0,0.6);
    text-align:center;
}

.logo{ width:150px; margin-bottom:15px; }
h2{ color:#fff; margin-bottom:20px; }
.auth-message{ color:#ff6b6b; margin-bottom:10px; }

input{
    width:100%;
    height:50px;
    padding:0 16px;
    margin-bottom:12px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.2);
    background:rgba(255,255,255,0.12);
    color:#fff;
    font-size:15px;
    box-sizing:border-box;
    transition:0.3s;
    font-family:'Tajawal',sans-serif;
}

input::placeholder{ color:#ddd; }
input:focus{
    outline:none;
    border:1px solid #3b6df6;
    background:rgba(255,255,255,0.18);
}

.start{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#3b6df6,#5a8cff);
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    margin-top:8px;
    transition:0.3s;
    font-family:'Tajawal',sans-serif;
}

.start:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(59,109,246,0.4);
}

.auth-link{ margin-top:12px; }
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

<!-- الكرت -->
<div class="card">
    <img src="images/unitour_v2.png" class="logo">
    <h2><?= $login_title ?></h2>

    <?php if(!empty($message)){ ?>
    <p class="auth-message"><?= htmlspecialchars($message) ?></p>
    <?php } ?>

    <form method="POST">
        <input type="email" name="email" placeholder="<?= $email_text ?>" required>
        <input type="password" name="password" placeholder="<?= $pass_text ?>" required>
        <button type="submit" class="start"><?= $btn_text ?></button>
    </form>

    <p class="auth-link">
        <a href="register.php?lang=<?= $lang ?>"><?= $reg_link ?></a>
    </p>
    <p class="auth-link">
        <a href="google_login.php?lang=<?= $lang ?>">
            <?= $is_ar ? 'الدخول عبر Google' : 'Login with Google' ?>
        </a>
    </p>
</div>

</section>
</body>
</html>