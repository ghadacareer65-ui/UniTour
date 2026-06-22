<?php
session_start();

if(isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'ar';
$dir = ($lang == 'ar') ? 'rtl' : 'ltr';

$title     = ($lang=='ar') ? "منصة UniTour" : "UniTour Platform";
$headline  = ($lang=='ar') ? "اكتشف مسارك الجامعي" : "Discover Your University Path";
$sub       = ($lang=='ar') ? "منصة ذكية تساعدك في اختيار تخصصك المناسب بناءً على اهتماماتك ودرجاتك." : "A smart platform to guide your academic path.";
$btn_start = ($lang=='ar') ? "ابدأ" : "Start";

$toggle_position = ($lang == 'ar') ? 'left:20px' : 'right:20px';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>" dir="<?php echo htmlspecialchars($dir); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body.home {
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            background-image: url('images/index5.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: rgba(0,0,0,0.45);
            padding: 20px;
        }

        .logo-wrap img { width: 280px; margin-bottom: 30px; }

        .headline {
            font-size: 48px;
            font-weight: 900;
            color: #fff;
            margin-bottom: 16px;
        }

        .sub {
            font-size: 18px;
            color: rgba(255,255,255,0.85);
            margin-bottom: 40px;
            max-width: 500px;
        }

        .cta {
            background: #3b6df6;
            color: #fff;
            padding: 14px 50px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .cta:hover { background: #2a56d4; }

        /* Language Toggle */
        .lang-toggle {
            position: fixed;
            top: 20px;
            display: flex;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.2);
            z-index: 999;
        }

        .lang-toggle a {
            padding: 8px 16px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            border-radius: 20px;
            transition: background 0.3s;
        }

        .lang-toggle a.active { background: #3b6df6; }
        .lang-toggle a:hover { background: rgba(59,109,246,0.6); }
    </style>
</head>
<body class="home">

<!-- Language Toggle -->
<div class="lang-toggle" style="<?php echo $toggle_position; ?>">
    <?php if($lang == 'ar'): ?>
        <a href="?lang=ar" class="active">AR</a>
        <a href="?lang=en">EN</a>
    <?php else: ?>
        <a href="?lang=en" class="active">EN</a>
        <a href="?lang=ar">AR</a>
    <?php endif; ?>
</div>

<!-- Hero -->
<section class="hero">
    <div class="logo-wrap">
        <img src="images/unitour_v2.png" alt="UniTour">
    </div>
    <h1 class="headline"><?php echo htmlspecialchars($headline); ?></h1>
    <p class="sub"><?php echo htmlspecialchars($sub); ?></p>
    <a href="index1.php?lang=<?php echo htmlspecialchars($lang); ?>" class="cta">
        <?php echo htmlspecialchars($btn_start); ?>
    </a>
</section>

</body>
</html>