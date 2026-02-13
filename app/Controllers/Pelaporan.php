<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pelaporan extends Controller
{
    public function index()
    {
        return view('dashboard/pelaporan', ['title' => 'Pelaporan', 'pageTitle' => 'Pelaporan']);
    }
}
