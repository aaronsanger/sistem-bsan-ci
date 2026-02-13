<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * Sistem BSAN Routes
 */

// ==========================================
// PUBLIC ROUTES (no auth required)
// ==========================================
$routes->get('/', 'Home::index');
$routes->get('/data-publik', 'DataPublik::index');
$routes->get('/faq', 'Faq::index');

// Temporary diagnostic route for Vercel debugging (remove after fix)
$routes->get('/debug-env', static function () {
    $app = config('App');
    return json_encode([
        'baseURL' => $app->baseURL,
        'indexPage' => $app->indexPage,
        'VERCEL' => $_ENV['VERCEL'] ?? $_SERVER['VERCEL'] ?? getenv('VERCEL'),
        'CI_ENVIRONMENT' => $_ENV['CI_ENVIRONMENT'] ?? 'not_set',
        'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'not_set',
        'SERVER_NAME' => $_SERVER['SERVER_NAME'] ?? 'not_set',
        'env_app_baseURL' => $_ENV['app.baseURL'] ?? 'not_set',
        'server_app_baseURL' => $_SERVER['app.baseURL'] ?? 'not_set',
        'getenv_app_baseURL' => getenv('app.baseURL') ?: 'not_set',
        'WRITEPATH' => defined('WRITEPATH') ? WRITEPATH : 'not_defined',
    ], JSON_PRETTY_PRINT);
});

// ==========================================
// AUTH ROUTES
// ==========================================
$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::doLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::doRegister');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::doForgotPassword');
    $routes->get('reset-password', 'Auth::resetPassword');
    $routes->post('reset-password', 'Auth::doResetPassword');
    $routes->get('callback', 'Auth::callback');
    $routes->get('logout', 'Auth::logout');
});

// ==========================================
// DASHBOARD ROUTES (auth required)
// ==========================================
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('profile', 'Profile::index');
    $routes->post('profile', 'Profile::update');
    $routes->get('pokja', 'Pokja::index');
    $routes->post('pokja/invite', 'Pokja::invite');
    $routes->get('pelaporan', 'Pelaporan::index');
    $routes->get('sumber-rujukan', 'SumberDukungan::index');
    $routes->get('admin', 'Admin::index');
    $routes->post('admin/invite', 'Admin::invite');
    $routes->post('admin/update-role', 'Admin::updateRole');
    $routes->post('admin/update-status', 'Admin::updateStatus');
});

// ==========================================
// API ROUTES (AJAX endpoints)
// ==========================================
$routes->group('api', function ($routes) {
    $routes->get('dashboard/stats', 'Dashboard::stats');
    $routes->get('pokja/list', 'Pokja::list');
    $routes->get('admin/users', 'Admin::users');
});
