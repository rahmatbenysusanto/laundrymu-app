<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statusTransaksi = DB::table('status_transaksi_outlet')
            ->where('outlet_id', Session::get('toko')->id)
            ->first();

        $totalPendapatan = DB::table('transaksi')
            ->where('outlet_id', Session::get('toko')->id)
            ->whereBetween('created_at', [strtotime(date('Y-m-d 00:00:00')) * 1000, strtotime(date('Y-m-d 23:59:59')) * 1000])
            ->sum('total_harga');

        $totalPelanggan = DB::table('pelanggan')
            ->where('outlet_id', Session::get('toko')->id)
            ->count();

        $jumlahTransaksi = DB::table('transaksi')
            ->where('outlet_id', Session::get('toko')->id)
            ->whereBetween('created_at', [strtotime(date('Y-m-d 00:00:00')) * 1000, strtotime(date('Y-m-d 23:59:59')) * 1000])
            ->count();

        $pelangganBaru = DB::table('pelanggan')
            ->where('outlet_id', Session::get('toko')->id)
            ->whereBetween('created_at', [strtotime(date('Y-m-01 00:00:00')) * 1000, strtotime(date('Y-m-t 23:59:59')) * 1000])
            ->count();

        $title = 'dashboard';
        return view('dashboard.index', compact('title', 'statusTransaksi', 'totalPendapatan', 'totalPelanggan', 'pelangganBaru', 'jumlahTransaksi'));
    }
}
