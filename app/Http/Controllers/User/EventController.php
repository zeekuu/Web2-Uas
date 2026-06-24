<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('user.event.index');
    }

public function show($id)
{
    $events = Event::with('User')->findOrFail($id);    
    return view('user.event.show', compact('events'));
}

    public function update(Request $request, $id) {
        $events = Event::findOrFail($id);
        $events->update($request->all());
        return redirect()->route('user.event.show', $events->idEvent);
    }
}
