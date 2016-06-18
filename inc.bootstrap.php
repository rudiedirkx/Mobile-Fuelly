<?php

use rdx\fuelly\Client;
use rdx\fuelly\InputConversion;
use rdx\fuelly\WebAuth;

require __DIR__ . '/env.php';
require __DIR__ . '/inc.functions.php';

require __DIR__ . '/vendor/autoload.php';

header('Content-type: text/html; charset=utf-8');

$auth = new WebAuth(FUELLY_MAIL, FUELLY_PASS, @$_COOKIE['fuelly_session']);
$input = new InputConversion(FUELLY_INPUT_DISTANCE, FUELLY_INPUT_VOLUME, FUELLY_INPUT_MILEAGE, FUELLY_INPUT_DECIMALS, FUELLY_INPUT_THOUSANDS);
$client = new Client($auth, $input);
$client->ensureSession();

require __DIR__ . '/OutputConversion.php';

$output = new OutputConversion('km', 'l', 'kmpl', '.', ' ');
