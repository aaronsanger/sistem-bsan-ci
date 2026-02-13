<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Auth Filter - Protects dashboard routes
 * Checks for valid Supabase session in PHP session
 * NOTE: Skipped on Vercel serverless (stateless — no persistent sessions)
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Skip auth on Vercel — serverless functions can't persist PHP sessions
        if ($this->isVercel()) {
            return;
        }

        $session = session();

        if (!$session->get('user_id')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after
    }

    /**
     * Detect if running on Vercel serverless
     */
    private function isVercel(): bool
    {
        return isset($_ENV['VERCEL']) 
            || isset($_SERVER['VERCEL'])
            || (defined('WRITEPATH') && strpos(WRITEPATH, '/tmp') === 0);
    }
}
