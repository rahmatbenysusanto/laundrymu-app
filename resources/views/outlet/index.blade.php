@extends('layout')
@section('title', 'Outlet')

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
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Outlet</h4>
                        <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahOutlet">Tambah Outlet</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th class="text-center">Status</th>
                                <th>Expired</th>
                                <th>Alamat</th>
                                <th>Pilihan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($outlet as $index => $out)
                                <tr>
                                    <td>{{ $outlet->firstItem() + $index }}</td>
                                    <td>
                                        {{ $out->nama }}
                                        {!! Session::get('toko')->id == $out->id ? '<span class="badge bg-success">DiPakai</span>' : '' !!}
                                    </td>
                                    <td>{{ $out->no_hp }}</td>
                                    <td class="text-center">
                                        @if($out->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($out->expired)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $out->alamat }}</td>
                                    <td>
                                        @if($out->id == Session::get('toko')->id)
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Pilihan
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Lihat</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('editOutlet', ['id' => base64_encode($out->id)]) }}">Edit</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('perpanjangLisensi') }}">Perpanjang Lisensi</a></li>
                                                </ul>
                                            </div>
                                        @else
                                            <a class="btn btn-dark btn-sm text-white" onclick="changeOutlet('{{ $out->id }}', '{{ $out->nama }}')">Pindah Outlet</a>
                                        @endif
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

@section('js')
    <script>
        function changeOutlet(id, nama) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Mau berpindah ke outlet '+nama,
                icon: 'info',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yakin",
                cancelButtonText: "Tidak",
            }).then((e) => {
                if (e.value) {
                    $.ajax({
                        url: '{{ route('changeOutlet') }}',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Pindah ke outlet '+ nama +' Berhasil!',
                                    showConfirmButton: true
                                }).then((r) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Pindah ke outlet '+ nama +' Gagal!',
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: (err) => {

                        }
                    });
                }
            });
        }
    </script>
@endsection
