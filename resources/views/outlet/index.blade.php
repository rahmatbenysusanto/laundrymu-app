@extends('layout')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Daftar Outlet</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Outlet</a></li>
                    <li class="breadcrumb-item active">Daftar Outlet</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Outlet</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Expired</th>
                                <th>Alamat</th>
                                <th>Pilihan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($outlet as $index => $out)
                                <tr>
                                    <td>{{ $outlet->firstItem() + $index }}</td>
                                    <td>{{ $out->nama }}</td>
                                    <td>{{ $out->no_hp }}</td>
                                    <td>
                                        @if($out->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($out->expired)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $out->alamat }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilihan
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Lihat</a></li>
                                                <li><a class="dropdown-item" href="#">Perpanjang Lisensi</a></li>
                                                @if($out->id != Session::get('toko')->id)
                                                    <li><a class="dropdown-item" href="#">Pindah Outlet</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            @if ($outlet->hasPages())
                                <ul class="pagination">
                                    @if ($outlet->onFirstPage())
                                        <li class="disabled"><span>&laquo; Sebelumnya</span></li>
                                    @else
                                        <li><a href="{{ $outlet->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
                                    @endif

                                    @foreach ($outlet->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="disabled"><span>{{ $element }}</span></li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $outlet->currentPage())
                                                    <li class="active"><span>{{ $page }}</span></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($outlet->hasMorePages())
                                        <li><a href="{{ $outlet->nextPageUrl() }}" rel="next">Selanjutnya &raquo;</a></li>
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
