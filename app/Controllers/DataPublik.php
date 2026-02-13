<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DataPublik extends Controller
{
    public function index()
    {
        return view('data_publik/index', ['title' => 'Data Publik']);
    }
}
