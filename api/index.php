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

// Set CI_ENVIRONMENT for production
if (!isset($_ENV['CI_ENVIRONMENT'])) {
    $_ENV['CI_ENVIRONMENT'] = 'production';
    $_SERVER['CI_ENVIRONMENT'] = 'production';
}

// Load paths config and override writable directory
require $projectRoot . '/app/Config/Paths.php';
$paths = new Config\Paths();
$paths->writableDirectory = $writablePath;

// Load the framework bootstrap
require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
