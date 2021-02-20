<?php declare(strict_types=1);

//require __DIR__ . '/core/init.php';
require __DIR__ . '/../vendor/autoload.php';

//phpinfo();

$app = new app\controller\AppController;
$app->router();
//

// init configuration
//$clientID = '1045420460253-j9efcobg371da6c618b2ll06rlhl1kh7.apps.googleusercontent.com';
//$clientSecret = 'V7DrXFM5GmhWjjhASGGmquKi';
//$redirectUri = 'http://localhost:8082/';
//  
//// create Client Request to access Google API
//$client = new Google_Client();
//$client->setClientId($clientID);
//$client->setClientSecret($clientSecret);
//$client->setRedirectUri($redirectUri);
//$client->addScope("email");
//$client->addScope("profile");
//
//
//// authenticate code from Google OAuth Flow
//if (isset($_GET['code'])) {
//  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//  $client->setAccessToken($token['access_token']);
//  
//  // get profile info
//  $google_oauth = new Google_Service_Oauth2($client);
//  $google_account_info = $google_oauth->userinfo->get();
//  $email =  $google_account_info->email;
//  $name =  $google_account_info->name;
// 
//  var_dump($email, $name);
//  // now you can use this profile info to create account in your website and make user logged in.
//} else {
//  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
//}



