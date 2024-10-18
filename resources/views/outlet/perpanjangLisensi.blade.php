@extends('layout')
@section('title', 'Outlet')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Perpanjang Lisensi</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Outlet</a></li>
                    <li class="breadcrumb-item active">Perpanjang Lisensi Outlet</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td class="fw-bold">Nama Outlet</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ $outlet->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">No HP</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ $outlet->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">
                                        @if($outlet->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Expired</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ \Carbon\Carbon::parse($outlet->expired)->translatedFormat('d F Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lisensi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="lisensi" class="form-label">Lisensi</label>
                                    <select class="form-select" id="lisensi" name="lisensi">
                                        <option> -- Pilih Lisensi -- </option>
                                        @foreach($lisensi as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nama }} | Rp {{ number_format($lis->harga) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                            <div class="d-flex justify-content-end">
                                <a onclick="prosesLisensi()" class="btn btn-primary">Perpanjang Lisensi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function prosesLisensi() {
            const lisensi = document.getElementById('lisensi').value;

            if (lisensi === ' -- Pilih Lisensi -- ') {
                Swal.fire({
                    icon: 'info',
                    title: 'Gagal!',
                    text: 'Lisensi belum dipilih',
                    showConfirmButton: true
                });
                return true;
            }

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Ingin memperpanjang lisensi outlet laundry anda?',
                icon: 'info',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yakin",
                cancelButtonText: "Tidak",
            }).then((e) => {
                if (e.value) {
                    $.ajax({
                        url: '{{ route('perpanjangLisensiProcess') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            lisensi: lisensi
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Perpanjang lisensi berhasil, silahkan melakukan pembayaran dengan link yang sudah dikirimkan',
                                    showConfirmButton: true
                                }).then((r) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Perpanjang lisensi Gagal!',
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
