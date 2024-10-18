<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Verifikasi OTP - LaundryMu APP</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="account-page">
<div id="global-loader">
    <div class="whirly-loader"> </div>
</div>
<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="login-content user-login">
                <div class="login-logo">
                    <img src="assets/img/logo.png" alt="img">
                    <a href="index.html" class="login-logo logo-white">
                        <img src="assets/img/logo-white.png" alt>
                    </a>
                </div>
                <div class="login-userset">
                    <div class="login-userheading text-center">
                        <h3>Verifikasi OTP</h3>
                        <h4 class="verfy-mail-content">Kode OTP telah dikirimkan ke nomor WhatsApp.</h4>
                    </div>
                    <form action="{{ route('verifikasiOTPPost') }}" method="POST" class="digit-group">
                        @csrf
                        <div class="wallet-add">
                            <div class="otp-box">
                                <div class="forms-block text-center">
                                    <input type="text" id="digit-1" maxlength="1" name="otp1" oninput="moveToNext(this, 'digit-2')" autofocus>
                                    <input type="text" id="digit-2" maxlength="1" name="otp2" oninput="moveToNext(this, 'digit-3')">
                                    <input type="text" id="digit-3" maxlength="1" name="otp3" oninput="moveToNext(this, 'digit-4')">
                                    <input type="text" id="digit-4" maxlength="1" name="otp4" oninput="moveToNext(this, 'digit-5')">
                                    <input type="text" id="digit-5" maxlength="1" name="otp5" oninput="moveToNext(this, 'digit-6')">
                                    <input type="text" id="digit-6" maxlength="1" name="otp6" oninput="moveToNext(this, '')">
                                </div>
                            </div>
                        </div>
                        <div class="Otp-expire text-center">
                            <p>Otp will expire in 09 :10</p>
                        </div>
                        <div class="form-login mt-4">
                            <button type="submit" class="btn btn-login">Verifikasi OTP</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                <p>Copyright &copy; 2023 DreamsPOS. All rights reserved</p>
            </div>
        </div>
    </div>
</div>
<div class="customizer-links" id="setdata">
    <ul class="sticky-sidebar">
        <li class="sidebar-icons">
            <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Theme">
                <i data-feather="settings" class="feather-five"></i>
            </a>
        </li>
    </ul>
</div>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/theme-script.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    function moveToNext(current, nextFieldID) {
        if (current.value.length === 1) {
            const nextField = document.getElementById(nextFieldID);
            if (nextField) {
                nextField.focus();
            }
        }
    }
</script>
</body>
</html>
