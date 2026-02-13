<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\SupabaseClient;

class Admin extends Controller
{
    protected SupabaseClient $supabase;

    public function __construct()
    {
        $this->supabase = new SupabaseClient();
    }

    public function index()
    {
        // Check if user is admin
        $role = session()->get('user_role');
        if ($role !== 'kementerian') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        return view('dashboard/admin', ['title' => 'Admin', 'pageTitle' => 'Kelola Pengguna']);
    }

    public function users()
    {
        $users = $this->supabase->from('profiles')
            ->select('*')
            ->order('created_at', false)
            ->execute();

        return $this->response->setJSON($users);
    }

    public function invite()
    {
        $email = $this->request->getPost('email');
        $role = $this->request->getPost('role');

        // Generate token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d\TH:i:s\Z', strtotime('+7 days'));

        $result = $this->supabase->from('invitation_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'role' => $role,
            'expires_at' => $expiresAt,
            'created_by' => session()->get('user_id'),
        ]);

        if (isset($result['error'])) {
            return $this->response->setJSON(['error' => $result['error']['message']]);
        }

        return $this->response->setJSON(['success' => true, 'token' => $token]);
    }

    public function updateRole()
    {
        $userId = $this->request->getPost('user_id');
        $newRole = $this->request->getPost('role');

        $result = $this->supabase->from('profiles')
            ->eq('id', $userId)
            ->update(['role' => $newRole]);

        return $this->response->setJSON(['success' => !isset($result['error'])]);
    }

    public function updateStatus()
    {
        $userId = $this->request->getPost('user_id');
        $newStatus = $this->request->getPost('status');

        $result = $this->supabase->from('profiles')
            ->eq('id', $userId)
            ->update(['status' => $newStatus]);

        return $this->response->setJSON(['success' => !isset($result['error'])]);
    }
}
