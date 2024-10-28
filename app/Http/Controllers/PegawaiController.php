<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PegawaiController extends Controller
{
    public function index(): View
    {
        $pegawai = DB::table('pegawai')
            ->where('outlet_id', Session::get('toko')->id)
            ->leftJoin('users', 'users.id', '=', 'pegawai.user_id')
            ->select([
                'pegawai.id',
                'users.nama',
                'users.no_hp',
                'users.status'
            ])
            ->paginate(10);

        $title = 'pegawai';
        return view('pegawai.index', compact('title', 'pegawai'));
    }

    public function tambahPegawai(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POST('api/pegawai', [
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('no_hp'),
            'password'  => $request->post('password'),
            'outlet_id' => Session::get('toko')->id
        ]);

        if ($hit->status) {
            Session::flash('success', 'Tambah Pegawai Berhasil');
        } else {
            Session::flash('error', 'Tambah Pegawai Gagal');
        }

        return back();
    }
}
