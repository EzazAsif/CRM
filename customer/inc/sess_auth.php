<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];
if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php')){
	redirect('customer/login.php');
}
if(isset($_SESSION['userdata']) && strpos($link, 'login.php')){
	redirect('customer/index.php');
}
$module = array('','admin','customer','users');
if(isset($_SESSION['userdata']) && (strpos($link, 'index.php') || strpos($link, 'customer/')) && $_SESSION['userdata']['login_type'] !=  2){
	echo "<script>alert('Access Denied!');location.replace('".base_url.$module[$_SESSION['userdata']['login_type']]."');</script>";
    exit;
}
// require_once './vendor/autoload.php';
// // init configuration
// $clientID = '256236500563-stdpk67frgaln84dkvi76lc06lo8plrc.apps.googleusercontent.com';
// $clientSecret = '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';
// $redirectUri = 'http://localhost/crm/customer/login.php';

// // create Client Request to access Google API
// $client = new Google_Client();
// $client->setClientId($clientID);
// $client->setClientSecret($clientSecret);
// $client->setRedirectUri($redirectUri);
// $client->addScope("email");
// $client->addScope("profile");

// // authenticate code from Google OAuth Flow
// if (isset($_GET['code'])) {
//   $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//   $client->setAccessToken($token['access_token']);

//   // get profile info
//   $google_oauth = new Google_Service_Oauth2($client);
//   $google_account_info = $google_oauth->userinfo->get();
//   $email =  $google_account_info->email;
//   $name =  $google_account_info->name;

//   // now you can use this profile info to create account in your website and make user logged in.
//   redirect('customer/index.php');
// }