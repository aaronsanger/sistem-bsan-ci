<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\SupabaseClient;

class Rujukan extends Controller
{
    protected SupabaseClient $supabase;

    public function __construct()
    {
        $this->supabase = new SupabaseClient();
    }

    public function index()
    {
        return view('dashboard/rujukan', ['title' => 'Daftar Rujukan', 'pageTitle' => 'Daftar Rujukan']);
    }

    public function list()
    {
        $rujukan = $this->supabase->from('rujukan')
            ->select('*')
            ->order('created_at', false)
            ->execute();

        return $this->response->setJSON($rujukan);
    }

    public function store()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
            'kategori' => $this->request->getPost('kategori'),
            'kategori_custom' => $this->request->getPost('kategori_custom'),
            'created_by' => session()->get('user_id'),
            'wilayah_id' => session()->get('wilayah_id'),
        ];

        $result = $this->supabase->from('rujukan')->insert($data);

        if (isset($result['error'])) {
            return $this->response->setJSON(['error' => $result['error']['message']]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
            'kategori' => $this->request->getPost('kategori'),
            'kategori_custom' => $this->request->getPost('kategori_custom'),
        ];

        $result = $this->supabase->from('rujukan')
            ->eq('id', $id)
            ->update($data);

        return $this->response->setJSON(['success' => !isset($result['error'])]);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        $result = $this->supabase->from('rujukan')
            ->eq('id', $id)
            ->delete();

        return $this->response->setJSON(['success' => !isset($result['error'])]);
    }
}
