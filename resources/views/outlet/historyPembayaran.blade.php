@extends('layout')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Daftar Pembayaran Lisensi</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Pembayaran Lisensi</a></li>
                    <li class="breadcrumb-item active">Daftar Pembayaran Lisensi</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pembayaran Lisensi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Outlet</th>
                                <th>No Pembayaran</th>
                                <th>Lisensi</th>
                                <th>Status</th>
                                <th>URL Payment</th>
                                <th>Tanggal</th>
                                <th>Pilihan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pembayaran as $index => $pem)
                                <tr>
                                    <td>{{ $pembayaran->firstItem() + $index }}</td>
                                    <td>{{ $pem->outlet }}</td>
                                    <td>{{ $pem->nomor_pembayaran }}</td>
                                    <td>{{ $pem->lisensi }}</td>
                                    <td>
                                        @if($pem->status == 'success')
                                            <span class="badge bg-success">Sukses</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $pem->url_payment }}</td>
                                    <td>{{ \Carbon\Carbon::createFromTimestamp($pem->created_at / 1000)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') }}</td>
                                    <td>
                                        <a class="btn btn-secondary btn-sm">
                                            <i class="fa-light fa-pen-to-square"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm ms-2">
                                            <i class="fa-light fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            @if ($pembayaran->hasPages())
                                <ul class="pagination">
                                    @if ($pembayaran->onFirstPage())
                                        <li class="disabled"><span>&laquo; Sebelumnya</span></li>
                                    @else
                                        <li><a href="{{ $pembayaran->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
                                    @endif

                                    @foreach ($pembayaran->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="disabled"><span>{{ $element }}</span></li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $pembayaran->currentPage())
                                                    <li class="active"><span>{{ $page }}</span></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($pembayaran->hasMorePages())
                                        <li><a href="{{ $pembayaran->nextPageUrl() }}" rel="next">Selanjutnya &raquo;</a></li>
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
