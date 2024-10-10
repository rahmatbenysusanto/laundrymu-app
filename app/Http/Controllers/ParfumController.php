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
}
