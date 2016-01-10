<?php

use rdx\fuelly\Client;
use rdx\fuelly\WebAuth;

require __DIR__ . '/env.php';
require __DIR__ . '/inc.functions.php';

require WHERE_IS_HTTP . '/autoload.php';
require WHERE_IS_FUELLY . '/autoload.php';

header('Content-type: text/html; charset=utf-8');

$auth = new WebAuth(FUELLY_MAIL, FUELLY_PASS, @$_COOKIE['fuelly_session']);
$client = new Client($auth);

$client->refreshSession();
