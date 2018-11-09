<?php 

require '../vendor/autoload.php'; // Module dependencies
require '../vendor/mailer/Mailerclass.php';
// == Initialize the app ==
$app = new \Slim\Slim();


// set 'json response' header
$app->contentType('application/json');

// == Routes ==
require 'routes/mailer.php';
require 'routes/mail_get.php';

// == enable CORS ==
$app->response->headers->set('Access-Control-Allow-Origin', '*');
$app->response->headers->set('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
$app->response->headers->set('Access-Control-Allow-Headers', 'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version');

// == Run the app ==
$app->run();