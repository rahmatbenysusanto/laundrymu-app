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
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Parfum</h4>
                        <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahParfum">Tambah Parfum</a>
                    </div>
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
                                            <a class="btn btn-secondary btn-sm" onclick="editParfum('{{ $pel->id }}', '{{ $pel->nama }}', '{{ $pel->harga }}')">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm ms-2" onclick="hapusParfum('{{ $pel->id }}')">
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

    <div class="modal fade" id="tambahParfum" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Tambah Parfum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahParfum') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga" required>
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

    <div class="modal fade" id="editParfum" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Edit Parfum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="formEditParfum">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function editParfum(id, nama, harga) {
            document.getElementById('formEditParfum').innerHTML = `
                <form action="{{ route('updateParfum') }}" method="POST">
                    @csrf
            <input type="hidden" name="id" value="${id}">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama diskon" value="${nama}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga" value="${harga}" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                    </div>
                </form>
            `;

            $('#editParfum').modal('show');
        }

        function hapusParfum(id) {
            Swal.fire({
                icon: 'info',
                title: 'Apakah Kamu Yakin?',
                text: 'Untuk Menghapus Parfum ini?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yakin",
                cancelButtonText: "Tidak",
            }).then((r) => {
                if (r.value) {
                    $.ajax({
                        url: '{{ route('hapusParfum') }}',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Hapus Parfum Berhasil!',
                                    showConfirmButton: true
                                }).then((r) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Hapus Parfum Gagal!',
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
