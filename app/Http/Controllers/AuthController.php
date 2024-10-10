<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function loginPost(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data["no_hp"] = $request->post("no_hp");
        $data["password"] = $request->post("password");

        $hit = $this->POSTLOGIN("api/auth/login", $data);
        if (isset($hit) && $hit->status) {
            Session::put("nama", $hit->data->nama);
            Session::put("role", $hit->data->role);
            Session::put("token", $hit->data->access_token);
            Session::put('user_id', $hit->data->user_id);

            // Get Toko
            if ($hit->data->role == "owner") {
                $toko = $this->GET('api/outlet/user', []);
                Session::put('toko', $toko->data[0]->outlet);
                if ($hit->data->status != "active") {
                    return redirect()->to(route('verifikasiOtp'));
                }
            } else {
                $toko = $this->GET('api/toko/pegawai/'.$hit->data->id, []);
                Session::put('toko', $toko->data->toko);
            }

            return redirect()->action([DashboardController::class, 'index']);
        } else {
            Session::flash("error", "Login gagal, email atau password salah!");
            return back();
        }
    }
}
