<?php

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '32311185941-d8joij6r4io9j4vgkrfoa0djrlkap6q0.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'kiZMD7ImLxj7pRcdZNbPAmWz'; //Google client secret
$redirectURL = 'http://localhost/JSS_students_portal/login.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('JSS_students_portal');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>