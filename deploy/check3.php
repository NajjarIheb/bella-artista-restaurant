<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$logPath = __DIR__ . '/../storage/logs/check.log';

function logline($msg) {
    global $logPath;
    file_put_contents($logPath, $msg . "\n", FILE_APPEND);
}

register_shutdown_function(function () use ($logPath) {
    $e = error_get_last();
    if ($e !== null) {
        file_put_contents($logPath, "SHUTDOWN: " . json_encode($e) . "\n", FILE_APPEND);
    } else {
        file_put_contents($logPath, "SHUTDOWN: no error recorded\n", FILE_APPEND);
    }
});

define('LARAVEL_START', microtime(true));
logline("=== NEW RUN " . date('H:i:s') . " ===");
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$envFile = $app->environmentFile();
$envPath = $app->environmentPath() . '/' . $envFile;
logline("envFile=" . $envFile . " envPath=" . $envPath);
logline("exists=" . (file_exists($envPath) ? 'yes' : 'NO') . " size=" . (file_exists($envPath) ? filesize($envPath) : 0));

if (file_exists($envPath)) {
    $bytes = file_get_contents($envPath);
    logline("first bytes hex: " . bin2hex(substr($bytes, 0, 16)));
    logline("null bytes count: " . substr_count($bytes, "\x00"));
    $lines = explode("\n", $bytes);
    logline("line count: " . count($lines));
    foreach ($lines as $i => $line) {
        $trimmed = trim($line);
        if ($trimmed !== '' && strpos($trimmed, '#') !== 0) {
            logline("  line" . ($i+1) . ": [" . $line . "]");
        }
    }
}

logline("--- now testing dotenv directly ---");
try {
    $dotenv = Dotenv\Dotenv::createImmutable($app->environmentPath(), $app->environmentFile());
    logline("dotenv object created");
    $dotenv->safeLoad();
    logline("dotenv loaded OK");
} catch (\Throwable $e) {
    logline("dotenv EXCEPTION: " . get_class($e) . ": " . $e->getMessage() . " @ " . $e->getFile() . ":" . $e->getLine());
}
logline("DONE");
