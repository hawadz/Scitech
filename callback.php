<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('159984912932-katp4f5lgtep46jkkid9jed9vs4n9onq.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/hawa/callback.php');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['error'])) {
        // Menampilkan error jika terjadi kesalahan dalam memperoleh token
        echo 'Error: ' . htmlspecialchars($token['error']);
        exit();
    }

    // Cek apakah token valid
    if (isset($token['access_token'])) {
        $client->setAccessToken($token['access_token']);

        // Mendapatkan informasi pengguna
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        // Simpan informasi pengguna dalam sesi
        $_SESSION['user_email'] = $userInfo->email;
        $_SESSION['user_name'] = $userInfo->name;

        // Redirect ke halaman utama
        header('Location: index.php');
        exit();
    } else {
        echo 'Error: Access token is not available.';
        exit();
    }
} else {
    echo "Error: Tidak ada kode autentikasi.";
    exit();
}
?>
