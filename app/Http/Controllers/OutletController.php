<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class OutletController extends Controller
{
    public function index(): View
    {
        $outlet = DB::table('outlet')
            ->where('user_id', Session::get('user_id'))
            ->paginate(10);

        $title = 'outlet';
        return view('outlet.index', compact('title', 'outlet'));
    }

    public function historyPembayaran(): View
    {
        $pembayaran = DB::table('outlet_pembayaran')
            ->where('outlet_pembayaran.outlet_id', Session::get('toko')->id)
            ->leftJoin('outlet', 'outlet.id', '=', 'outlet_pembayaran.outlet_id')
            ->leftJoin('lisensi', 'lisensi.id', '=', 'outlet_pembayaran.lisensi_id')
            ->select([
                'outlet_pembayaran.*',
                'outlet.nama as outlet',
                'lisensi.nama as lisensi',
            ])
            ->paginate(10);


        $title = 'historyPembayaran';
        return view('outlet.historyPembayaran', compact('title', 'pembayaran'));
    }
}
