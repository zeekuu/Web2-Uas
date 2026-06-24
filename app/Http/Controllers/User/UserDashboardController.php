<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'approved')->get();
        return view('user.dashboard', compact('events'));
    }

    
}
