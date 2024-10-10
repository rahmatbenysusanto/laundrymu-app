<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ParfumController extends Controller
{
    public function index(): View
    {
        $parfum = DB::table('parfum')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', '!=', 1)
            ->paginate(10);

        $title = 'parfum';
        return view('parfum.index', compact('parfum', 'title'));
    }

    public function tambah(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POST('api/parfum', [
            'outlet_id' => Session::get('toko')->id,
            'nama'      => $request->post('nama'),
            'harga'     => $request->post('harga'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Tambah parfum berhasil');
        } else {
            Session::flash('error', 'Tambah parfum gagal');
        }

        return back();
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->PATCH('api/parfum?id=' . $request->post('id'), [
            'nama'      => $request->post('nama'),
            'harga'     => $request->post('harga'),
        ]);

        if ($hit->status) {
            Session::flash('success', 'Update parfum berhasil');
        } else {
            Session::flash('error', 'Update parfum gagal');
        }

        return back();
    }

    public function hapus(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->DELETE('api/parfum?id=' . $request->get('id'));

        if ($hit->status) {
            return response()->json([
                'status'    => true,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hapus parfum gagal',
            ]);
        }
    }
}
