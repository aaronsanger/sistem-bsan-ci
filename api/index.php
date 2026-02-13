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

// Load environment variables from Vercel's environment
// (Set via Vercel Dashboard > Settings > Environment Variables)
// Also try loading from .env if it exists (for local dev)
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

// Load paths config
require $projectRoot . '/app/Config/Paths.php';
$paths = new Config\Paths();

// Load the framework bootstrap
require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
