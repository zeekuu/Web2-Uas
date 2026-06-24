<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransaksiController extends Controller
{
    public function index(){
        $transaksis = Transaksi::all();
        $users = User::all();
        $events = Event::all();
        return view('admin.transaksi.index', compact('transaksis', 'users', 'events'));
    }

    public function create(){

    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function store(Request $request, $id){
        
    }

    public function destroy($id){

    }
}
