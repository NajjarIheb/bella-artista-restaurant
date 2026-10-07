<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

define('LARAVEL_START', microtime(true));

register_shutdown_function(function () {
    $e = error_get_last();
    if ($e !== null) {
        echo "\n<pre>SHUTDOWN-CATCH: type=" . $e['type'] . " msg=" . $e['message'] . "\nfile=" . $e['file'] . ":" . $e['line'] . "</pre>";
    }
});

ini_set('output_buffering', '0');
ini_set('zlib.output_compression', '0');

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "\n<!-- KERNEL-MADE -->";

try {
    $response = $kernel->handle($request = Illuminate\Http\Request::capture());
    $response->send();
    $kernel->terminate($request, $response);
    echo "\n<!-- HANDLE-FINISHED-OK -->";
} catch (\Throwable $e) {
    echo "<pre>EXCEPTION: " . $e->getMessage() . "\n\n";
    echo "FILE: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString() . "</pre>";
}
