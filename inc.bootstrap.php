<?php

use rdx\fuelly\Client;
use rdx\fuelly\WebAuth;

$localPsr4 = array();
require __DIR__ . '/env.php';
require __DIR__ . '/inc.functions.php';

$autoloader = require __DIR__ . '/vendor/autoload.php';
foreach ($localPsr4 as $namespace => $location) {
	$autoloader->setPsr4($namespace, $location);
}

header('Content-type: text/html; charset=utf-8');

$auth = new WebAuth(FUELLY_MAIL, FUELLY_PASS, @$_COOKIE['fuelly_session']);
$client = new Client($auth);

$client->refreshSession();
