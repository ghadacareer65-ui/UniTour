<?php
session_start();

require_once "../vendor/autoload.php";
require_once "config.php";

$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URI);

$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {

    // للنسخ القديمة من المكتبة
    $client->authenticate($_GET['code']);
    $accessToken = $client->getAccessToken();
    $client->setAccessToken($accessToken);

    $google_service = new Google_Service_Oauth2($client);
    $data = $google_service->userinfo->get();

    $_SESSION['user_name'] = $data->name;
    $_SESSION['user_email'] = $data->email;

    header("Location: index.php");
    exit();

} else {
    echo "No authorization code received";
}
?>