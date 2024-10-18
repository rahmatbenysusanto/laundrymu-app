@extends('layout')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Daftar Transaksi</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                    <li class="breadcrumb-item active">Daftar Transaksi</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Number</th>
                                <th>Pelanggan</th>
                                <th>Pengiriman</th>
                                <th class="text-center">Status</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                                <th class="text-center">Pembayaran</th>
                                <th>Catatan</th>
                                <th>Pilihan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaksi as $index => $tra)
                                <tr>
                                    <td>{{ $transaksi->firstItem() + $index }}</td>
                                    <td>{{ $tra->order_number }}</td>
                                    <td>{{ $tra->pelanggan }}</td>
                                    <td>{{ $tra->pengiriman }}</td>
                                    <td class="text-center">
                                        @switch($tra->status)
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
                                    <td>{{ \Carbon\Carbon::parse($tra->created_at / 1000)->translatedFormat('d F Y H:i') }}</td>
                                    <td>Rp {{ number_format($tra->total_harga) }}</td>
                                    <td class="text-center">
                                        @if($tra->status_pembayaran == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-danger">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td>{{ $tra->catatan }}</td>
                                    <td>
                                        <a href="{{ route('detailTransaksi', ['order_number' => $tra->order_number]) }}" class="btn btn-primary btn-sm">
                                            <i class="fa-light fa-eye"></i>
                                        </a>
                                        @if($tra->status != 'close' && $tra->status != 'batal')
                                            <a class="btn btn-secondary btn-sm ms-2">
                                                <i class="fa-light fa-washing-machine" onclick="prosesTransaksi('{{ $tra->id }}', '{{ $tra->status }}')"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm ms-2" onclick="cancelTransaksi('{{ $tra->id }}')">
                                                <i class="fa-light fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            @if ($transaksi->hasPages())
                                <ul class="pagination">
                                    @if ($transaksi->onFirstPage())
                                        <li class="disabled"><span>&laquo; Sebelumnya</span></li>
                                    @else
                                        <li><a href="{{ $transaksi->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
                                    @endif

                                    @foreach ($transaksi->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="disabled"><span>{{ $element }}</span></li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $transaksi->currentPage())
                                                    <li class="active"><span>{{ $page }}</span></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($transaksi->hasMorePages())
                                        <li><a href="{{ $transaksi->nextPageUrl() }}" rel="next">Selanjutnya &raquo;</a></li>
                                    @else
                                        <li class="disabled"><span>Selanjutnya &raquo;</span></li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancelTransaksi(id) {
            Swal.fire({
                icon: 'info',
                title: 'Apakah Kamu Yakin?',
                text: 'Untuk Membatalkan Transaksi ini?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yakin",
                cancelButtonText: "Tidak",
            }).then((e) => {
                if (e.value) {
                    $.ajax({
                        url: '{{ route('cancelTransaksi') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Cancel Transaksi Berhasil!',
                                    showConfirmButton: true
                                }).then((r) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Cancel Transaksi Gagal!',
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            });
        }

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
