<?php
// Simple router: serve static files from public/, route everything else to index.php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // let PHP serve the static file
}
require __DIR__ . '/public/index.php';
