<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
}
