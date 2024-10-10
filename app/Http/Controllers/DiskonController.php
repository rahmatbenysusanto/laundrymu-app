<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DiskonController extends Controller
{
    public function index(): View
    {
        $diskon = DB::table('diskon')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', '!=', 1)
            ->paginate(10);

        $title = 'diskon';
        return view('diskon.index', compact('diskon', 'title'));
    }

    public function tambah(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POST('api/diskon', [
            'outlet_id' => Session::get('toko')->id,
            'nama'      => $request->post('nama'),
            'nominal'   => $request->post('nominal'),
            'type'      => $request->post('tipe'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Diskon Berhasil Ditambahkan');
        } else {
            Session::flash('error', 'Diskon Gagal Ditambahkan');
        }

        return back();
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->PATCH('api/diskon?id=' . $request->post('id'), [
            'nama'      => $request->post('nama'),
            'nominal'   => $request->post('nominal'),
            'type'      => $request->post('tipe'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Diskon Berhasil Diubah');
        } else {
            Session::flash('error', 'Diskon Gagal Diubah');
        }

        return back();
    }

    public function hapus(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->DELETE('api/diskon?id=' . $request->get('id'));

        if ($hit->status) {
            return response()->json([
                'status'    => true,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hapus diskon gagal',
            ]);
        }
    }
}
