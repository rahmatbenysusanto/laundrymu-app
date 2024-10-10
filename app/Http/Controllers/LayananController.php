<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LayananController extends Controller
{
    public function index(): View
    {
        $layanan = DB::table('layanan')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', '!=', 1)
            ->paginate(10);

        $title = 'layanan';
        return view('layanan.index', compact('title', 'layanan'));
    }

    public function tambah(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POST('api/layanan', [
            'outlet_id' => Session::get('toko')->id,
            'nama'      => $request->post('nama'),
            'harga'     => $request->post('harga'),
            'type'      => $request->post('tipe'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Layanan Berhasil Ditambahkan');
        } else {
            Session::flash('error', 'Layanan Gagal Ditambahkan');
        }

        return back();
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->PATCH('api/layanan?id=' . $request->post('id'), [
            'nama'      => $request->post('nama'),
            'harga'     => $request->post('harga'),
            'type'      => $request->post('tipe'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Layanan Berhasil Diubah');
        } else {
            Session::flash('error', 'Layanan Gagal Diubah');
        }

        return back();
    }

    public function hapus(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->DELETE('api/layanan?id=' . $request->get('id'));

        if ($hit->status) {
            return response()->json([
                'status'    => true,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hapus layanan gagal',
            ]);
        }
    }
}
