<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanitiaDashboardController extends Controller
{
    public function index()
    {
        return view('panitia.dashboard');
    }
}
