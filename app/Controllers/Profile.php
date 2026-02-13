<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\SupabaseClient;

class Profile extends Controller
{
    protected SupabaseClient $supabase;

    public function __construct()
    {
        $this->supabase = new SupabaseClient();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $profile = $this->supabase->from('profiles')
            ->select('*')
            ->eq('id', $userId)
            ->single();

        $data = [
            'title' => 'Profil',
            'pageTitle' => 'Profil Saya',
            'profile' => $profile,
        ];

        return view('dashboard/profile', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');

        $updates = [
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'jabatan' => $this->request->getPost('jabatan'),
            'instansi' => $this->request->getPost('instansi'),
            'satker' => $this->request->getPost('satker'),
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
            'nip' => $this->request->getPost('nip'),
        ];

        $result = $this->supabase->from('profiles')
            ->eq('id', $userId)
            ->update($updates);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', 'Gagal menyimpan profil.');
        }

        // Update session name
        session()->set('user_name', $updates['nama_depan'] . ' ' . $updates['nama_belakang']);

        return redirect()->back()->with('success', 'Profil berhasil disimpan!');
    }
}
