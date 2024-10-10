<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PelangganController extends Controller
{
    public function index(): View
    {
        $pelanggan = DB::table('pelanggan')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', '!=', 1)
            ->paginate(10);

        $title = 'pelanggan';
        return view('pelanggan.index', compact('title', 'pelanggan'));
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->POST('api/pelanggan', [
            'outlet_id' => Session::get('toko')->id,
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('noHp'),
        ]);

        Log::info(json_encode($request->all()));

        if ($hit->status) {
            return response()->json([
                'status'    => true,
                'data'      => $hit->data
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'data'      => null
            ]);
        }
    }

    public function tambah(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POST('api/pelanggan', [
            'outlet_id' => Session::get('toko')->id,
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('no_hp'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Tambah pelanggan berhasil');
        } else {
            Session::flash('error', 'Tambah pelanggan gagal');
        }

        return back();
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->PATCH('api/pelanggan?id=' . $request->post('id'), [
            'nama'      => $request->post('nama'),
            'no_hp'     => $request->post('no_hp'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Update pelanggan berhasil');
        } else {
            Session::flash('error', 'Update pelanggan gagal');
        }

        return back();
    }

    public function hapus(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->DELETE('api/pelanggan?id=' . $request->get('id'));

        if ($hit->status) {
            return response()->json([
                'status'    => true,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hapus pelanggan gagal',
            ]);
        }
    }
}
