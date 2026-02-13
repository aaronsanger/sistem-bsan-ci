<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\SupabaseClient;

class Pokja extends Controller
{
    protected SupabaseClient $supabase;

    public function __construct()
    {
        $this->supabase = new SupabaseClient();
    }

    public function index()
    {
        return view('dashboard/pokja', ['title' => 'Pokja', 'pageTitle' => 'Kelola Pokja']);
    }

    public function list()
    {
        $userId = session()->get('user_id');

        $pokja = $this->supabase->from('pokja')
            ->select('*,pokja_anggota(*,profiles(*))')
            ->execute();

        return $this->response->setJSON($pokja);
    }

    public function invite()
    {
        $email = $this->request->getPost('email');
        $kategori = $this->request->getPost('kategori');
        $pokjaId = $this->request->getPost('pokja_id');

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d\TH:i:s\Z', strtotime('+7 days'));

        $result = $this->supabase->from('invitation_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'pokja_id' => $pokjaId,
            'kategori' => $kategori,
            'role' => 'anggota',
            'expires_at' => $expiresAt,
            'created_by' => session()->get('user_id'),
        ]);

        if (isset($result['error'])) {
            return $this->response->setJSON(['error' => $result['error']['message']]);
        }

        $registerUrl = base_url('auth/register?token=' . $token);
        return $this->response->setJSON(['success' => true, 'link' => $registerUrl]);
    }
}
