<?php

/**
 * Vercel Serverless Entry Point for CodeIgniter 4
 * Routes all requests through CI4's front controller
 */

// Set working directory to project root
$projectRoot = dirname(__DIR__);
chdir($projectRoot);

// Define FCPATH as the public directory
define('FCPATH', $projectRoot . '/public/');

// Vercel serverless has a read-only filesystem except /tmp
// Create writable directory structure in /tmp BEFORE CI4 boots
$writablePath = '/tmp/ci4-writable';
if (!is_dir($writablePath)) {
    mkdir($writablePath, 0777, true);
}
foreach (['logs', 'cache', 'session', 'uploads', 'debugbar'] as $dir) {
    $subDir = $writablePath . '/' . $dir;
    if (!is_dir($subDir)) {
        mkdir($subDir, 0777, true);
    }
}

// CRITICAL: Define WRITEPATH constant BEFORE Boot.php checks it
// Boot::definePathConstants() skips WRITEPATH if already defined
define('WRITEPATH', $writablePath . '/');

// Load environment variables
if (is_file($projectRoot . '/.env')) {
    $dotenv = parse_ini_file($projectRoot . '/.env');
    if ($dotenv !== false) {
        foreach ($dotenv as $key => $value) {
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

// Set CI_ENVIRONMENT for production on Vercel
$_ENV['CI_ENVIRONMENT'] = 'production';
$_SERVER['CI_ENVIRONMENT'] = 'production';
putenv('CI_ENVIRONMENT=production');

// Set VERCEL flag for AuthFilter detection
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';
putenv('VERCEL=1');

// Auto-detect baseURL on Vercel (override localhost from .env / App.php)
$scheme = 'https'; // Vercel always uses HTTPS
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
}
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'sistem-bsan-dev.vercel.app';
$autoBaseURL = $scheme . '://' . $host . '/';
$_ENV['app.baseURL'] = $autoBaseURL;
$_SERVER['app.baseURL'] = $autoBaseURL;
putenv("app.baseURL={$autoBaseURL}");

// Remove index.php from URLs on Vercel (rewrite handles routing)
$_ENV['app.indexPage'] = '';
$_SERVER['app.indexPage'] = '';
putenv('app.indexPage=');

// Load paths config and override writable directory
require $projectRoot . '/app/Config/Paths.php';
$paths = new Config\Paths();
$paths->writableDirectory = $writablePath;

// Load the framework bootstrap
require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
