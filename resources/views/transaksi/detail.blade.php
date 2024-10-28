@extends('layout')
@section('title', 'Transaksi')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Lihat Transaksi</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Transaksi</li>
                    <li class="breadcrumb-item"><a href="{{ route('listTransaksi') }}">Daftar Transaksi</a></li>
                    <li class="breadcrumb-item active">Lihat Transaksi</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td class="fw-bold">Order Number</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->order_number }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Pelanggan</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->pelanggan }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Diskon</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->diskon }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Pengiriman</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->pengiriman }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td class="fw-bold">Pembayaran</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->pembayaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status Pembayaran</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">
                                        @if($transaksi->status_pembayaran == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-danger">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status Transaksi</td>
                                    <td class="fw-bold ps-2">:</td>
                                    <td class="ps-2">
                                        @switch($transaksi->status)
                                            @case('baru')
                                                <span class="badge bg-success">Baru</span>
                                                @break
                                            @case('diproses')
                                                <span class="badge bg-primary">Diproses</span>
                                                @break
                                            @case('selesai')
                                                <span class="badge bg-warning">Menunggu Pengambilan</span>
                                                @break
                                            @case('diambil')
                                                <span class="badge bg-secondary">Selesai</span>
                                                @break
                                            @case('close')
                                                <span class="badge bg-secondary">Selesai</span>
                                                @break
                                            @case('batal')
                                                <span class="badge bg-danger">Batal</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>Detail Layanan</h4>
                        @if($transaksi->status != 'close' && $transaksi->status != 'batal' && $transaksi->status != 'diambil')
                            <a class="btn btn-primary" onclick="prosesTransaksi('{{ $transaksi->id }}', '{{ $transaksi->status }}')">Proses Transaksi</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Layanan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transaksiDetail as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->layanan }}</td>
                                        <td>Rp {{ number_format($detail->harga) }}</td>
                                        <td>{{ $detail->jumlah }} {{ $detail->layanan == 'berat' ? ' KG' : ' Pcs' }}</td>
                                        <td>Rp {{ number_format($detail->total_harga) }}</td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="fw-bold">Harga</td>
                                        <td>Rp {{ number_format($transaksi->harga) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="fw-bold">Harga Parfum</td>
                                        <td>Rp {{ number_format($transaksiDetail[0]->parfum_harga) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="fw-bold">Biaya Pengiriman</td>
                                        <td>Rp {{ number_format($transaksi->biaya_pengiriman) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="fw-bold">Diskon</td>
                                        <td>Rp {{ number_format($transaksi->harga_diskon) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="fw-bold">Total Harga</td>
                                        <td class="fw-bold">Rp {{ number_format($transaksi->total_harga) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <table>
                                @foreach($transaksiHistory as $history)
                                    <div class="card p-3">
                                        <div class="d-flex">
                                            <p class="fw-bold">
                                                @switch($history->status)
                                                    @case('baru')
                                                        <span class="badge bg-success">Baru</span>
                                                        @break
                                                    @case('diproses')
                                                        <span class="badge bg-primary">Diproses</span>
                                                        @break
                                                    @case('selesai')
                                                        <span class="badge bg-warning">Menunggu Pengambilan</span>
                                                        @break
                                                    @case('diambil')
                                                        <span class="badge bg-secondary">Selesai</span>
                                                        @break
                                                    @case('close')
                                                        <span class="badge bg-secondary">Selesai</span>
                                                        @break
                                                    @case('batal')
                                                        <span class="badge bg-danger">Batal</span>
                                                        @break
                                                @endswitch
                                            </p>
                                            <p class="fw-bold ms-2"> - {{ \Carbon\Carbon::parse($history->created_at / 1000)->translatedFormat('d F Y H:i') }}</p>
                                        </div>
                                        <p>{{ $history->keterangan }}</p>
                                    </div>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function prosesTransaksi(id, status) {
            Swal.fire({
                icon: 'info',
                title: 'Apakah Kamu Yakin?',
                text: 'Untuk Memproses Transaksi ini?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yakin",
                cancelButtonText: "Tidak",
            }).then((e) => {
                if (e.value) {
                    $.ajax({
                        url: '{{ route('prosesTransaksi') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: status
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Memproses Transaksi Berhasil!',
                                    showConfirmButton: true
                                }).then((r) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Memproses Transaksi Gagal!',
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
