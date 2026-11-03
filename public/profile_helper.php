<?php
// حفظ النسبة والمسار والجنس في كوكي (6 أشهر) عشان تبقى حتى بدون تسجيل دخول
function ut_save_profile(array $p) {
    $data = [
        'school'         => $p['school']         ?? '',
        'qudrat'         => $p['qudrat']         ?? '',
        'tahsili'        => $p['tahsili']        ?? '',
        'weighted'       => $p['weighted']       ?? '',
        'gender'         => $p['gender']         ?? '',
        'track_selected' => $p['track_selected'] ?? '',
    ];
    @setcookie('ut_profile', json_encode($data), [
        'expires'  => time() + 60 * 60 * 24 * 180,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']) || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    $_COOKIE['ut_profile'] = json_encode($data);
}

function ut_cookie_profile() {
    if (empty($_COOKIE['ut_profile'])) return [];
    $d = json_decode($_COOKIE['ut_profile'], true);
    return is_array($d) ? $d : [];
}

// لو الـ session فاضية نرجّع البيانات من الكوكي
function ut_restore_profile() {
    if (!empty($_SESSION['weighted']) && !empty($_SESSION['track_selected'])) return;
    $d = ut_cookie_profile();
    if (!empty($d['weighted']) && !empty($d['track_selected'])) {
        foreach (['school', 'qudrat', 'tahsili', 'weighted', 'gender'] as $k) {
            $_SESSION[$k] = $d[$k] ?? '';
        }
        $_SESSION['track_selected'] = $d['track_selected'];
    }
}
