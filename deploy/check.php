<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

echo "STEP0 - script start<br>";

$base = realpath(__DIR__ . '/..');
echo "BASE: " . $base . "<br>";

echo "STEP1 - checking autoload<br>";
$autoload = $base . '/vendor/autoload.php';
echo (file_exists($autoload) ? 'OK autoload exists' : 'MISSING autoload') . "<br>";

echo "STEP2 - loading autoload<br>";
require $autoload;
echo "STEP2 done<br>";

echo "STEP3 - checking bootstrap/app.php<br>";
$bootstrap = $base . '/bootstrap/app.php';
echo (file_exists($bootstrap) ? 'OK bootstrap exists' : 'MISSING bootstrap') . "<br>";

echo "STEP4 - loading bootstrap<br>";
$app = require $bootstrap;
echo "STEP4 done: app=" . get_class($app) . "<br>";

echo "ALL-OK<br>";
