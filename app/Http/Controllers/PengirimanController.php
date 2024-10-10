<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PengirimanController extends Controller
{
    public function index(): View
    {
        $pengiriman = DB::table('pengiriman')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', '!=', 1)
            ->paginate(10);

        $title = 'pengiriman';
        return view('pengiriman.index', compact('title', 'pengiriman'));
    }

    public function tambah(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POST('api/pengiriman', [
            'outlet_id' => Session::get('toko')->id,
            'nama'      => $request->post('nama'),
            'harga'     => $request->post('harga'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Tambah pengiriman berhasil');
        } else {
            Session::flash('error', 'Tambah pengiriman gagal');
        }

        return back();
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->PATCH('api/pengiriman?id=' . $request->post('id'), [
            'nama'      => $request->post('nama'),
            'harga'     => $request->post('harga'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Update pengiriman berhasil');
        } else {
            Session::flash('error', 'Update pengiriman gagal');
        }

        return back();
    }

    public function hapus(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->DELETE('api/pengiriman?id=' . $request->get('id'));

        if ($hit->status) {
            return response()->json([
                'status'    => true,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hapus pengiriman gagal',
            ]);
        }
    }
}
