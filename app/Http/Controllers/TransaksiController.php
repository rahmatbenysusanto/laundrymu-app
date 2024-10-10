<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function listTransaksi(): View
    {
        $transaksi = DB::table('transaksi')
            ->where('transaksi.outlet_id', Session::get('toko')->id)
            ->leftJoin('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
            ->leftJoin('diskon', 'transaksi.diskon_id', '=', 'diskon.id')
            ->leftJoin('pengiriman', 'transaksi.pengiriman_id', '=', 'pengiriman.id')
            ->leftJoin('pembayaran', 'transaksi.pembayaran_id', '=', 'pembayaran.id')
            ->select([
                'transaksi.*',
                'pelanggan.nama as pelanggan',
                'diskon.nama as diskon',
                'pengiriman.nama as pengiriman',
                'pembayaran.nama as pembayaran',
            ])
            ->orderBy('transaksi.id', 'desc')
            ->paginate(10);

        $title = 'list transaksi';
        return view('transaksi.list', compact('transaksi', 'title'));
    }

    public function createTransaksi(): View
    {
        $parfum = DB::table('parfum')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', 0)
            ->get();

        $diskon = DB::table('diskon')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', 0)
            ->get();

        $pengiriman = DB::table('pengiriman')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', 0)
            ->get();

        $pembayaran = DB::table('pembayaran')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', 0)
            ->get();

        $title = 'tambah transaksi';
        return view('transaksi.create', compact('title', 'parfum', 'diskon', 'pengiriman', 'pembayaran'));
    }

    public function createTransaksiPost(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->POST('api/transaksi', [
            'outlet_id' => Session::get('toko')->id,
            'pelanggan_id'      => (int)$request->post('pelanggan'),
            'diskon_id'         => (int)$request->post('diskon'),
            'pengiriman_id'     => (int)$request->post('pengiriman'),
            'pembayaran_id'     => (int)$request->post('pembayaran'),
            'status'            => 'baru',
            'status_pembayaran' => $request->post('status_pembayaran'),
            'harga'             => (int)$request->post('harga'),
            'harga_diskon'      => (int)$request->post('harga_diskon'),
            'biaya_pengiriman'  => (int)$request->post('biaya_pengiriman'),
            'harga_parfum'      => (int)$request->post('harga_parfum'),
            'total_harga'       => (int)$request->post('total_harga'),
            'catatan'           => $request->post('catatan'),
            'detail'            => $request->post('layanan'),
        ]);

        if ($hit->status) {
            return response()->json([
                'status'    => true
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => $hit->message
            ]);
        }
    }

    public function getLayanan(): \Illuminate\Http\JsonResponse
    {
        $layanan = DB::table('layanan')
            ->where('outlet_id', Session::get('toko')->id)
            ->where('delete', 0)
            ->get();

        return response()->json($layanan);
    }

    public function getPelanggan(): \Illuminate\Http\JsonResponse
    {
        $pelanggan = DB::table('pelanggan')
            ->where('outlet_id', Session::get('toko')->id)
            ->get();

        return response()->json($pelanggan);
    }
}
