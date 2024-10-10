@extends('layout')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Daftar Pelanggan</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                    <li class="breadcrumb-item active">Daftar Pelanggan</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Pelanggan</h4>
                        <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPelanggan">Tambah Pelanggan</a>
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
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelanggan as $index => $pel)
                                    <tr>
                                        <td>{{ $pelanggan->firstItem() + $index }}</td>
                                        <td>{{ $pel->nama }}</td>
                                        <td>{{ $pel->no_hp }}</td>
                                        <td>
                                            <a class="btn btn-secondary btn-sm" onclick="editPelanggan('{{ $pel->id }}', '{{ $pel->nama }}', '{{ $pel->no_hp }}')">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm ms-2" onclick="hapusPelanggan('{{ $pel->id }}')">
                                                <i class="fa-light fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            @if ($pelanggan->hasPages())
                                <ul class="pagination">
                                    @if ($pelanggan->onFirstPage())
                                        <li class="disabled"><span>&laquo; Sebelumnya</span></li>
                                    @else
                                        <li><a href="{{ $pelanggan->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
                                    @endif

                                    @foreach ($pelanggan->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="disabled"><span>{{ $element }}</span></li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $pelanggan->currentPage())
                                                    <li class="active"><span>{{ $page }}</span></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($pelanggan->hasMorePages())
                                        <li><a href="{{ $pelanggan->nextPageUrl() }}" rel="next">Selanjutnya &raquo;</a></li>
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

    <div class="modal fade" id="tambahPelanggan" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahPelanggan') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="noHp" class="form-label">Nomor HP</label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" required>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPelanggan" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="formEditPelanggan">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function editPelanggan(id, nama, noHp) {
            document.getElementById('formEditPelanggan').innerHTML = `
                 <form action="{{ route('updatePelanggan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="${id}">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" value="${nama}" required>
                    </div>
                    <div class="mb-3">
                        <label for="noHp" class="form-label">Nomor HP</label>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" value="${noHp}" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary ms-2">Edit</button>
                    </div>
                </form>
            `;

            $('#editPelanggan').modal('show');
        }

        function hapusPelanggan(id) {
            Swal.fire({
                icon: 'info',
                title: 'Apakah Kamu Yakin?',
                text: 'Untuk Menghapus Pelanggan ini?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yakin",
                cancelButtonText: "Tidak",
            }).then((r) => {
                if (r.value) {
                    $.ajax({
                        url: '{{ route('hapusPelanggan') }}',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Hapus Pelanggan Berhasil!',
                                    showConfirmButton: true
                                }).then((r) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Hapus Pelanggan Gagal!',
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
