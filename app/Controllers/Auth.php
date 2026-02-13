<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\SupabaseClient;

class Auth extends Controller
{
    protected SupabaseClient $supabase;

    public function __construct()
    {
        $this->supabase = new SupabaseClient();
    }

    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login', ['title' => 'Masuk']);
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $result = $this->supabase->signIn($email, $password);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']['message'] ?? 'Login gagal.');
        }

        // Store session
        $session = session();
        $session->set([
            'user_id' => $result['user']['id'] ?? '',
            'user_email' => $result['user']['email'] ?? $email,
            'user_name' => ($result['user']['user_metadata']['nama_depan'] ?? '') . ' ' . ($result['user']['user_metadata']['nama_belakang'] ?? ''),
            'access_token' => $result['access_token'] ?? '',
            'refresh_token' => $result['refresh_token'] ?? '',
        ]);

        // Fetch profile
        $profile = $this->supabase->from('profiles')
            ->select('*')
            ->eq('id', $result['user']['id'])
            ->single();

        if (!isset($profile['error']) && !empty($profile['nama_depan'])) {
            $session->set([
                'user_name' => $profile['nama_depan'] . ' ' . ($profile['nama_belakang'] ?? ''),
                'user_role' => $profile['role'] ?? 'anggota',
            ]);
        }

        return redirect()->to('/dashboard');
    }

    public function register()
    {
        return view('auth/register', ['title' => 'Daftar']);
    }

    public function doRegister()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        if ($password !== $passwordConfirm) {
            return redirect()->back()->with('error', 'Password tidak cocok.');
        }

        $metadata = [
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'jabatan' => $this->request->getPost('jabatan'),
            'instansi' => $this->request->getPost('instansi'),
        ];

        $result = $this->supabase->signUp($email, $password, $metadata);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']['message'] ?? 'Registrasi gagal.');
        }

        return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi.');
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password', ['title' => 'Lupa Password']);
    }

    public function doForgotPassword()
    {
        $email = $this->request->getPost('email');
        $redirectTo = base_url('auth/reset-password');

        $result = $this->supabase->resetPasswordForEmail($email, $redirectTo);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']['message'] ?? 'Gagal mengirim email reset.');
        }

        return redirect()->back()->with('success', 'Email reset password telah dikirim!');
    }

    public function resetPassword()
    {
        return view('auth/reset_password', ['title' => 'Reset Password']);
    }

    public function doResetPassword()
    {
        $accessToken = $this->request->getPost('access_token');
        $newPassword = $this->request->getPost('password');

        $result = $this->supabase->updatePassword($accessToken, $newPassword);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']['message'] ?? 'Gagal mereset password.');
        }

        return redirect()->to('/auth/login')->with('success', 'Password berhasil diubah!');
    }

    public function callback()
    {
        // Handle Supabase OAuth/email confirm callback
        // This is handled client-side via Supabase JS
        return view('auth/callback');
    }

    public function logout()
    {
        $accessToken = session()->get('access_token');
        if ($accessToken) {
            $this->supabase->signOut($accessToken);
        }

        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
