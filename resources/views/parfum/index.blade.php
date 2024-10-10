@extends('layout')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Daftar Parfum</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                    <li class="breadcrumb-item active">Daftar Parfum</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Parfum</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parfum as $index => $pel)
                                    <tr>
                                        <td>{{ $parfum->firstItem() + $index }}</td>
                                        <td>{{ $pel->nama }}</td>
                                        <td>Rp {{ number_format($pel->harga) }}</td>
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
                            @if ($parfum->hasPages())
                                <ul class="pagination">
                                    @if ($parfum->onFirstPage())
                                        <li class="disabled"><span>&laquo; Sebelumnya</span></li>
                                    @else
                                        <li><a href="{{ $parfum->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
                                    @endif

                                    @foreach ($parfum->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="disabled"><span>{{ $element }}</span></li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $parfum->currentPage())
                                                    <li class="active"><span>{{ $page }}</span></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($parfum->hasMorePages())
                                        <li><a href="{{ $parfum->nextPageUrl() }}" rel="next">Selanjutnya &raquo;</a></li>
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
