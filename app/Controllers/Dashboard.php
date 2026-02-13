<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\SupabaseClient;

class Dashboard extends Controller
{
    protected SupabaseClient $supabase;

    public function __construct()
    {
        $this->supabase = new SupabaseClient();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard',
        ];

        return view('dashboard/index', $data);
    }

    /**
     * API endpoint for dashboard stats (AJAX)
     */
    public function stats()
    {
        $token = session()->get('access_token');

        // Fetch pokja count
        $pokja = $this->supabase->from('pokja')->select('id')->execute();
        $totalPokja = is_array($pokja) && !isset($pokja['error']) ? count($pokja) : 0;

        // Fetch rujukan count
        $rujukan = $this->supabase->from('rujukan')->select('id')->execute();
        $totalRujukan = is_array($rujukan) && !isset($rujukan['error']) ? count($rujukan) : 0;

        // Fetch profiles (anggota) count
        $profiles = $this->supabase->from('profiles')->select('id')->execute();
        $totalAnggota = is_array($profiles) && !isset($profiles['error']) ? count($profiles) : 0;

        // Pending approval
        $pending = $this->supabase->from('pokja')->select('id')->eq('status', 'pending')->execute();
        $pendingCount = is_array($pending) && !isset($pending['error']) ? count($pending) : 0;

        return $this->response->setJSON([
            'totalPokja' => $totalPokja,
            'totalRujukan' => $totalRujukan,
            'totalAnggota' => $totalAnggota,
            'pendingApproval' => $pendingCount,
        ]);
    }
}
