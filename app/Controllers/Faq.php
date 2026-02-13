<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Faq extends Controller
{
    public function index()
    {
        return view('faq/index', ['title' => 'FAQ']);
    }
}
