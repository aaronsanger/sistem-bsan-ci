<?php

/**
 * Vercel Serverless Entry Point for CodeIgniter 4
 * 
 * Best Practice: Public Supabase keys (URL, anon key) are hardcoded in SupabaseClient.php.
 * Only SUPABASE_SERVICE_KEY needs to be set via Vercel Environment Variables:
 *   - SUPABASE_SERVICE_KEY (secret — bypasses RLS)
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

// =========================================================
// VERCEL ENVIRONMENT CONFIGURATION
// No .env on Vercel — all config via Vercel Environment Variables
// or auto-detected from request headers.
// =========================================================

// Force production environment
$_ENV['CI_ENVIRONMENT'] = 'production';
$_SERVER['CI_ENVIRONMENT'] = 'production';
putenv('CI_ENVIRONMENT=production');

// Set VERCEL flag for AuthFilter detection
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';
putenv('VERCEL=1');

// Auto-detect baseURL from request (no hardcoded URLs needed)
$scheme = 'https'; // Vercel always terminates SSL
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
}
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'sistem-bsan-dev.vercel.app';
$autoBaseURL = $scheme . '://' . $host . '/';

// Set at ALL levels so CI4's BaseConfig picks it up
$_ENV['app.baseURL'] = $autoBaseURL;
$_SERVER['app.baseURL'] = $autoBaseURL;
putenv("app.baseURL={$autoBaseURL}");

// Remove index.php from URLs (Vercel rewrite handles routing)
$_ENV['app.indexPage'] = '';
$_SERVER['app.indexPage'] = '';
putenv('app.indexPage=');

// =========================================================
// Load paths config and boot CI4
// =========================================================
require $projectRoot . '/app/Config/Paths.php';
$paths = new Config\Paths();
$paths->writableDirectory = $writablePath;

require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
