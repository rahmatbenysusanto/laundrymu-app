<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function edit($id)
    {
        $hit = $this->GET('api/outlet?id='.base64_decode($id), []);

        dd($hit);
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
            ->orderBy('outlet_pembayaran.created_at', 'desc')
            ->paginate(10);


        $title = 'historyPembayaran';
        return view('outlet.historyPembayaran', compact('title', 'pembayaran'));
    }

    public function changeOutlet(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $hit =  $this->GET('api/outlet/user', []);
            $outlet = $hit->data ?? [];

            foreach ($outlet as $out) {
                if ($out->outlet->id == $request->get('id')) {
                    Session::put('toko', $out->outlet);
                }
            }

            return response()->json([
                'status'    => true
            ]);
        } catch (\Exception $err) {
            Log::error($err->getMessage());
            return response()->json([
                'status'    => false
            ]);
        }
    }

    public function perpanjangLisensi(): View
    {
        $outlet = DB::table('outlet')
            ->where('id', Session::get('toko')->id)
            ->first();

        $lisensi = DB::table('lisensi')->get();

        $title = 'outlet';
        return view('outlet.perpanjangLisensi', compact('title', 'outlet', 'lisensi'));
    }

    public function perpanjangLisensiProcess(Request $request): \Illuminate\Http\JsonResponse
    {
        $hit = $this->POST('api/outlet/pembayaran', [
            'outlet_id'     => Session::get('toko')->id,
            'lisensi_id'    => $request->post('lisensi'),
            'user_id'       => Session::get('user_id'),
        ]);

        if ($hit->status) {
            return response()->json([
                'status'    => true,
            ]);
        } else {
            return response()->json([
                'status'    => false
            ]);
        }
    }
}
