<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function index(): View
    {
        $pembayaran = DB::table('pembayaran')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', '!=', 1)
            ->paginate(10);

        $title = 'pembayaran';
        return view('pembayaran.index', compact('pembayaran', 'title'));
    }

    public function tambah(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POST('api/pembayaran', [
            'outlet_id' => Session::get('toko')->id,
            'nama'      => $request->post('nama'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Tambah pembayaran berhasil');
        } else {
            Session::flash('error', 'Tambah pembayaran gagal');
        }

        return back();
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->PATCH('api/pembayaran?id=' . $request->post('id'), [
            'nama'      => $request->post('nama'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Update pembayaran berhasil');
        } else {
            Session::flash('error', 'Update pembayaran gagal');
        }

        return back();
    }

    public function hapus(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->DELETE('api/pembayaran?id=' . $request->get('id'));

        if ($hit->status) {
            return response()->json([
                'status'    => true,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hapus pembayaran gagal',
            ]);
        }
    }
}
