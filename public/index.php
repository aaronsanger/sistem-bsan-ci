<?php

/**
 * CodeIgniter 4 Front Controller
 * Sistem BSAN - Budaya Sekolah Aman Nasional
 */

use CodeIgniter\Boot;
use Config\Paths;

// Valid PHP version?
$minPhpVersion = '8.2';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf('PHP version %s or newer is required. Current: %s', $minPhpVersion, PHP_VERSION);
    exit($message);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// Load paths config file
require FCPATH . '../app/Config/Paths.php';
$paths = new Paths();

// Load environment variables from .env
if (is_file(FCPATH . '../.env')) {
    $dotenv = parse_ini_file(FCPATH . '../.env');
    if ($dotenv !== false) {
        foreach ($dotenv as $key => $value) {
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

// Load the framework bootstrap file
require $paths->systemDirectory . '/Boot.php';

exit(Boot::bootWeb($paths));
