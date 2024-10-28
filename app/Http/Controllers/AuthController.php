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
        dd($hit);
        if (isset($hit) && $hit->status) {
            Session::put("nama", $hit->data->nama);
            Session::put("role", $hit->data->role);
            Session::put("token", $hit->data->access_token);
            Session::put('user_id', $hit->data->user_id);
            Session::put('no_hp', $hit->data->no_hp);

            // Get Toko
            if ($hit->data->role == "owner") {
                $toko = $this->GET('api/outlet/user', []);
                Session::put('toko', $toko->data[0]->outlet);
                if ($hit->data->status != "active") {
                    return redirect()->to(route('verifikasiOTP'));
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

    public function register(): View
    {
        return view('auth.register');
    }

    public function registerPost(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hit = $this->POSTLOGIN("api/auth/register", [
            "nama"          => $request->post("nama"),
            'email'         => $request->post("email"),
            "password"      => $request->post("password"),
            'no_hp'         => $request->post("no_hp"),
            'no_hp_outlet'  => $request->post("no_hp"),
            'nama_outlet'   => $request->post("nama_outlet"),
        ]);

        if ($hit->status) {
            Session::put('expired_otp', date('d F Y h:i', strtotime('+7 horse')));
            Session::flash('success', 'Register Berhasil Silahkan melanjutkan login');
        } else {
            Session::flash('error', 'Register Gagal');
        }

        return back();
    }

    public function verifikasiOTP(): View
    {
        return view('auth.verifikasi_otp');
    }

    public function verifikasiOTPPost(Request $request): \Illuminate\Http\RedirectResponse
    {
        $otp1 = $request->post("otp1");
        $otp2 = $request->post("otp2");
        $otp3 = $request->post("otp3");
        $otp4 = $request->post("otp4");
        $otp5 = $request->post("otp5");
        $otp6 = $request->post("otp6");

        $hit = $this->POST('api/auth/verifikasi-otp', [
            'otp'       => $otp1.$otp2.$otp3.$otp4.$otp5.$otp6,
            'no_hp'     => Session::get('no_hp')
        ]);

        if ($hit->status) {
            return redirect()->action([DashboardController::class, 'index']);
        } else {
            Session::flash('error', 'Verifikasi OTP Gagal');
            return back();
        }
    }
}
