<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KonfirmasibayarController extends Controller
{
    public function index(){
        $transaksis = Transaksi::all();
        return view('admin.transaksi.konfirmasi', compact('transaksis'));
    }

    public function approve(Request $request, $id){
        $transaksis = Transaksi::findOrFail($id);
        $transaksis->status = $request->status;
        $transaksis->save();
        return redirect()->route('konfirmasi.index');
    }
}
