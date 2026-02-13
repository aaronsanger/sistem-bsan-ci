<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SumberDukungan extends Controller
{
    public function index()
    {
        return view('dashboard/sumber_dukungan', ['title' => 'Sumber Dukungan', 'pageTitle' => 'Input Sumber Dukungan']);
    }
}
