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
}
