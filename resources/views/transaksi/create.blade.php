@extends('layout')
@section('title', 'Transaksi')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Buat Transaksi</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                    <li class="breadcrumb-item active">Buat Transaksi</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="pos-products">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-3">Layanan</h5>
                </div>
                <div class="tabs_container">
                    <div class="tab_content active" data-tab="all">
                        <div class="row" id="listLayanan">

                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-3">Catatan</h5>
                </div>
                <div class="tabs_container">
                    <div class="tab_content active" data-tab="all">
                        <textarea class="form-control" rows="10" cols="10" id="catatan" placeholder="Catatan Laundry ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <aside class="product-order-list">
                <div class="customer-info block-section">
                    <h6>Detail Transaksi</h6>
                    <div class="mb-3">
                        <label for="parfum" class="form-label">Parfum</label>
                        <select class="form-select" id="parfum" onchange="changeParfum(this)">
                            @foreach($parfum as $par)
                                <option value="{{ $par->id }}|{{ $par->nama }}|{{ $par->harga }}">{{ $par->nama }} | Rp {{ number_format($par->harga) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pembayaran" class="form-label">Pembayaran</label>
                        <select class="form-select" id="pembayaran">
                            @foreach($pembayaran as $pem)
                                <option value="{{ $pem->id }}">{{ $pem->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="diskon" class="form-label">Diskon</label>
                        <select class="form-select" id="diskon" onchange="changeDiskon(this)">
                            @foreach($diskon as $dis)
                                <option value="{{ $dis->id }}|{{ $dis->nama }}|{{ $dis->nominal }}|{{ $dis->type }}">{{ $dis->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pengiriman" class="form-label">Pengiriman</label>
                        <select class="form-select" id="pengiriman" onchange="changePengiriman(this)">
                            @foreach($pengiriman as $peng)
                                <option value="{{ $peng->id }}|{{ $peng->nama }}|{{ $peng->harga }}">{{ $peng->nama }} | Rp {{ number_format($peng->harga) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <div class="d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pembayaran" id="pembayaranLunas" checked>
                                <label class="form-check-label" for="status_pembayaran">
                                    Lunas
                                </label>
                            </div>
                            <div class="form-check ms-5">
                                <input class="form-check-input" type="radio" name="status_pembayaran" id="pembayaranBelumLunas">
                                <label class="form-check-label" for="status_pembayaran">
                                    Belum Lunas
                                </label>
                            </div>
                        </div>
                    </div>

                    <h6>Pelanggan</h6>
                    <div class="input-block d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-2-myxb" style="width: 100%;" onclick="changePelanggan()">
                                <span class="selection">
                                    <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-kutw-container" aria-controls="select2-kutw-container">
                                        <span class="select2-selection__rendered" id="pelanggan" role="textbox" aria-readonly="true">-- Pilih Pelanggan --</span>
                                        <span class="select2-selection__arrow" role="presentation">
                                            <b role="presentation"></b>
                                        </span>
                                    </span>
                                </span>
                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                            </span>
                        </div>
                        <a class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#tambahPelanggan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus feather-16">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                        </a>
                    </div>

                </div>
                <div class="product-added block-section">
                    <div class="head-text d-flex align-items-center justify-content-between">
                        <h6 class="d-flex align-items-center mb-0">List Layanan<span class="count" id="jumlahLayanan">0</span></h6>
                    </div>
                    <div class="product-wrap" id="listLayananCheckout">

                    </div>
                </div>
                <div class="block-section">
                    <div class="order-total table-responsive">
                        <table class="table table-responsive table-borderless">
                            <tbody><tr>
                                <td>Sub Total</td>
                                <td class="text-end" id="subHarga">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Parfum</td>
                                <td class="text-end" id="hargaParfum">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Pengiriman</td>
                                <td class="text-end" id="hargaPengiriman">Rp 0</td>
                            </tr>
                            <tr>
                                <td id="titleDiskon" class="danger">Diskon</td>
                                <td class="danger text-end" id="hargaDiskon">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td class="text-end" id="totalHarga">Rp 0</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-grid btn-block">
                    <a class="btn btn-secondary" onclick="prosesTransaksi()">
                        Proses Transaksi
                    </a>
                </div>
            </aside>
        </div>
    </div>

    <div id="pilihPelanggan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Pilih Pelanggan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="listPelanggan">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Default Datatable</h4>
                            <p class="card-text">
                                This is the most basic example of the datatables with zero configuration. Use the <code>.datatable</code> class to initialize datatables.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tambahPelanggan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Tambah Pelanggan Baru</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="listPelanggan">
                    <div class="mb-3">
                        <label id="nama" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="namaPelanggan" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label id="no_hp" class="form-label">No HP Pelanggan</label>
                        <input type="text" class="form-control" id="noHpPelanggan" name="no_hp" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <a class="btn btn-primary" onclick="tambahPelanggan()">Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        localStorage.clear();

        saveLayananLocalStorage();
        function saveLayananLocalStorage() {
            $.ajax({
                url: '{{ route('transaksi.getLayanan') }}',
                method: 'GET',
                success: (res) => {
                    const layanan = res;
                    let data = [];

                    layanan.forEach((lay) => {
                        data.push({
                            id: lay.id,
                            nama: lay.nama,
                            type: lay.type,
                            harga: lay.harga,
                            jumlah: 0,
                            total: 0,
                            active: 0
                        });
                    });

                    localStorage.setItem('layanan', JSON.stringify(data));
                    viewLayanan();
                }
            });
        }

        function viewLayanan() {
            const layanan = JSON.parse(localStorage.getItem('layanan')) ?? [];
            let html = '';

            layanan.forEach((lay) => {
                const harga = parseInt(lay.harga);
                html += `
                    <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                        <div onclick="pilihLayanan('${lay.id}')" style="cursor: pointer;">
                            <div class="product-info card ${lay.active === 1 ? 'active' : ''}">
                                <div class="img-bg">
                                    <img src="{{ asset('assets/img/mesin-cuci.png') }}" alt="Products" width="100">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check feather-16">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </span>
                                </div>
                                <h6 class="product-name">
                                    <a href="javascript:void(0);">${lay.nama}</a>
                                </h6>
                                <div class="d-flex align-items-center justify-content-between price">
                                    <span>${lay.type === 'berat' ? 'Harga Per KG' : 'Harga Satuan'}</span>
                                    <p>Rp ${harga.toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            document.getElementById('listLayanan').innerHTML = html;
        }

        function pilihLayanan(id) {
            const layanan = JSON.parse(localStorage.getItem('layanan')) ?? [];
            let data = [];

            layanan.forEach((lay) => {
                if (lay.id === parseInt(id)) {
                    data.push({
                        id: lay.id,
                        nama: lay.nama,
                        type: lay.type,
                        harga: lay.harga,
                        jumlah: 1,
                        total: parseInt(lay.harga),
                        active: lay.active === 1 ? 0 : 1
                    });
                } else {
                    data.push(lay);
                }
            });

            localStorage.setItem('layanan', JSON.stringify(data));
            viewLayanan();
            listLayananCheckout();
            perhitunganTotalHarga();
            hitungDiskon();
        }

        function listLayananCheckout() {
            const layanan = JSON.parse(localStorage.getItem('layanan')) ?? [];
            let html = '';
            let jumlahLayanan = 0;

            layanan.forEach((lay) => {
                if (lay.active === 1) {
                    html += `
                        <div class="product-list d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center product-info" data-bs-toggle="modal" data-bs-target="#products">
                                <a href="javascript:void(0);" class="img-bg">
                                    <img src="{{ asset('assets/img/mesin-cuci.png') }}" alt="Products">
                                </a>
                                <div class="info">
                                    <span>${lay.type === 'berat' ? 'Harga Per KG' : 'Harga Satuan'}</span>
                                    <h6><a href="javascript:void(0);">${lay.nama}</a></h6>
                                    <p>Rp ${lay.total.toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                            <div class="qty-item text-center">
                                <input type="text" class="form-control text-center" name="qty" value="${lay.jumlah}" onchange="changeJumlahLayanan('${lay.id}', this)">
                            </div>
                            <div class="d-flex align-items-center action">
                                <a class="btn-icon delete-icon confirm-text" onclick="pilihLayanan('${lay.id}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 feather-14"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </div>
                        </div>
                `;
                    jumlahLayanan++;
                }
            });

            document.getElementById('listLayananCheckout').innerHTML = html;
            document.getElementById('jumlahLayanan').innerText = jumlahLayanan;
            perhitunganSubHarga();
            perhitunganTotalHarga();
        }

        // Default Value Rp 0
        localStorage.setItem('hargaParfum', JSON.stringify(0))
        localStorage.setItem('hargaPengiriman', JSON.stringify(0))
        localStorage.setItem('hargaDiskon', JSON.stringify(0))
        localStorage.setItem('totalHarga', JSON.stringify(0))

        localStorage.setItem('parfum', JSON.stringify({
            id: '{{ $parfum[0]->id }}',
            nama: '{{ $parfum[0]->nama }}',
            harga: '{{ $parfum[0]->harga }}'
        }));

        localStorage.setItem('pembayaran', JSON.stringify({
            id: '{{ $pembayaran[0]->id }}',
            nama: '{{ $pembayaran[0]->nama }}',
        }));

        localStorage.setItem('diskon', JSON.stringify({
            id: '{{ $diskon[0]->id }}',
            nama: '{{ $diskon[0]->nama }}',
            nominal: '{{ $diskon[0]->nominal }}',
            type: '{{ $diskon[0]->type }}'
        }));

        localStorage.setItem('pengiriman', JSON.stringify({
            id: '{{ $pengiriman[0]->id }}',
            nama: '{{ $pengiriman[0]->nama }}',
            harga: '{{ $pengiriman[0]->harga }}'
        }));

        function changeJumlahLayanan(id, data) {
            const layanan = JSON.parse(localStorage.getItem('layanan')) ?? [];
            let result = [];

            if (data.value < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Jumlah Harus Lebih Dari 1',
                    showConfirmButton: true
                });
                return true;
            }

            layanan.forEach((lay) => {
                if (lay.id === parseInt(id)) {
                    result.push({
                        id: lay.id,
                        nama: lay.nama,
                        type: lay.type,
                        harga: lay.harga,
                        jumlah: parseInt(data.value),
                        total: parseInt(lay.harga) * parseInt(data.value),
                        active: 1
                    });
                } else {
                    result.push(lay);
                }
            });

            localStorage.setItem('layanan', JSON.stringify(result));

            listLayananCheckout();
            hitungDiskon();
            perhitunganSubHarga();
            perhitunganTotalHarga();
        }

        function changeParfum(data) {
            let parfum = data.value.split('|');
            localStorage.setItem('parfum', JSON.stringify({
                id: parfum[0],
                nama: parfum[1],
                harga: parfum[2]
            }));

            localStorage.setItem('hargaParfum', JSON.stringify(parseInt(parfum[2])))
            document.getElementById('hargaParfum').innerText = 'Rp ' + parfum[2].toLocaleString('id-ID')
            perhitunganTotalHarga();
            hitungDiskon();
        }

        function changePengiriman(data) {
            let pengiriman = data.value.split('|');
            localStorage.setItem('pengiriman', JSON.stringify({
                id: pengiriman[0],
                nama: pengiriman[1],
                harga: pengiriman[2]
            }));

            localStorage.setItem('hargaPengiriman', JSON.stringify(parseInt(pengiriman[2])));
            document.getElementById('hargaPengiriman').innerText = 'Rp '+ parseInt(pengiriman[2]).toLocaleString('id-ID');
            perhitunganTotalHarga();
            hitungDiskon();
        }

        function changeDiskon(data) {
            const subHarga = JSON.parse(localStorage.getItem('subHarga')) ?? 0;
            const subParfum = JSON.parse(localStorage.getItem('hargaParfum')) ?? 0;
            const subPengiriman = JSON.parse(localStorage.getItem('hargaPengiriman')) ?? 0;

            let diskon = data.value.split('|');
            localStorage.setItem('diskon', JSON.stringify({
                id: diskon[0],
                nama: diskon[1],
                nominal: diskon[2],
                type: diskon[3]
            }));

            let totalHarga = subHarga + subParfum + subPengiriman;
            let jumlahDiskon = 0;
            let keteranganDiskon = ''
            if (diskon[3] === 'nominal') {
                jumlahDiskon = diskon[2];
                keteranganDiskon = 'Diskon';
            } else {
                jumlahDiskon = totalHarga * (diskon[2] / 100)
                keteranganDiskon = 'Diskon (' + diskon[2] + '%)'
            }

            localStorage.setItem('hargaDiskon', JSON.stringify(jumlahDiskon));
            document.getElementById('titleDiskon').innerText = keteranganDiskon;
            document.getElementById('hargaDiskon').innerText = 'Rp ' + parseInt(jumlahDiskon).toLocaleString('id-ID');
            perhitunganTotalHarga();
        }

        function hitungDiskon() {
            const diskon = JSON.parse(localStorage.getItem('diskon'));
            const subHarga = JSON.parse(localStorage.getItem('subHarga')) ?? 0;
            const subParfum = JSON.parse(localStorage.getItem('hargaParfum')) ?? 0;
            const subPengiriman = JSON.parse(localStorage.getItem('hargaPengiriman')) ?? 0;

            let totalHarga = subHarga + subParfum + subPengiriman;
            let jumlahDiskon = 0;
            let keteranganDiskon = ''
            if (diskon.type === 'nominal') {
                jumlahDiskon = diskon.nominal;
                keteranganDiskon = 'Diskon';
            } else {
                jumlahDiskon = totalHarga * (diskon.nominal / 100)
                keteranganDiskon = 'Diskon (' + diskon.nominal + '%)'
            }

            localStorage.setItem('hargaDiskon', JSON.stringify(jumlahDiskon));
            document.getElementById('titleDiskon').innerText = keteranganDiskon;
            document.getElementById('hargaDiskon').innerText = 'Rp ' + parseInt(jumlahDiskon).toLocaleString('id-ID');
            perhitunganTotalHarga();
        }

        function perhitunganSubHarga() {
            const layanan = JSON.parse(localStorage.getItem('layanan')) ?? [];
            let subHarga = 0;

            layanan.forEach((lay) => {
                if (lay.active === 1) {
                    subHarga += lay.total;
                }
            });

            localStorage.setItem('subHarga', JSON.stringify(subHarga));
            document.getElementById('subHarga').innerText = 'Rp '+ subHarga.toLocaleString('id-ID');
            perhitunganTotalHarga();
        }

        function perhitunganTotalHarga() {
            const subHarga = JSON.parse(localStorage.getItem('subHarga')) ?? 0;
            const subParfum = JSON.parse(localStorage.getItem('hargaParfum')) ?? 0;
            const subPengiriman = JSON.parse(localStorage.getItem('hargaPengiriman')) ?? 0;
            const subDiskon = JSON.parse(localStorage.getItem('hargaDiskon')) ?? 0;

            const total = (subHarga + subParfum + subPengiriman) - subDiskon;

            localStorage.setItem('totalHarga', JSON.stringify(total));
            document.getElementById('totalHarga').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function changePelanggan() {
            $('#pilihPelanggan').modal('show');

            $.ajax({
                url: '{{ route('transaksi.getPelanggan') }}',
                method: 'GET',
                success: (res) => {
                    const pelanggan = res;
                    let html = `
                    <table class="table display" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    let number = 1;

                    pelanggan.forEach((pel) => {
                        html += `
                            <tr>
                                <td>${number++}</td>
                                <td>${pel.nama}</td>
                                <td>${pel.no_hp}</td>
                                <td><a class="btn btn-primary btn-sm" onclick="pilihPelanggan('${pel.id}', '${pel.nama}', '${pel.no_hp}')">Pilih</a></td>
                            </tr>
                `;
                    });

                    html += `
                        </tbody>
                    </table>
            `;

                    document.getElementById('listPelanggan').innerHTML = html;

                    let table = new DataTable('#datatable', {
                        responsive: true,
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                        },
                    });
                }
            });

            console.log('pilih pelanggan');
        }

        function pilihPelanggan(id, nama, noHp) {
            localStorage.setItem('pelanggan', JSON.stringify({
                id: id,
                nama: nama,
                noHp: noHp
            }));

            document.getElementById('pelanggan').innerText = nama + ' | ' + noHp;
            $('#pilihPelanggan').modal('hide');
        }

        function tambahPelanggan() {
            const nama = document.getElementById('namaPelanggan').value;
            const noHp = document.getElementById('noHpPelanggan').value;

            $.ajax({
                url: '{{ route('createPelanggan') }}',
                method: 'POST',
                data: {
                    _token: '{{ @csrf_token() }}',
                    nama: nama,
                    noHp: noHp
                },
                success: (res) => {
                    if (res.status) {
                        localStorage.setItem('pelanggan', JSON.stringify({
                            id: res.data.id,
                            nama: nama,
                            noHp: noHp
                        }));
                        document.getElementById('pelanggan').innerText = nama + ' | ' + noHp;
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Tambah Pelanggan Berhasil',
                            showConfirmButton: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Tambah Pelanggan Gagal',
                            showConfirmButton: true
                        });
                    }

                    $('#tambahPelanggan').modal('hide');
                }
            });
        }

        function prosesTransaksi() {
            const listLayanan = JSON.parse(localStorage.getItem('layanan')) ?? null;
            let layanan = [];

            const parfum = JSON.parse(localStorage.getItem('parfum'));

            listLayanan.forEach((lay) => {
                if (lay.active === 1) {
                    layanan.push({
                        layanan_id: parseInt(lay.id),
                        parfum_id: parseInt(parfum.id),
                        jumlah: parseInt(lay.jumlah),
                        harga: parseInt(lay.harga),
                        total_harga: parseInt(lay.total)
                    });
                }
            });

            if (layanan.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Silahkan Pilih Layanan Terlebih Dahulu!',
                    showConfirmButton: true
                });
                return true;
            }

            const pelanggan = JSON.parse(localStorage.getItem('pelanggan')) ?? [];
            if (pelanggan.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Silahkan Pilih Pelanggan Terlebih Dahulu!',
                    showConfirmButton: true
                });
                return true;
            }

            const diskon = JSON.parse(localStorage.getItem('diskon'));
            const pengiriman = JSON.parse(localStorage.getItem('pengiriman'));

            Swal.fire({
                icon: 'info',
                title: 'Apakah Kamu Yakin?',
                text: 'Untuk Melanjutkan Pembuatan Transaksi ini?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yakin",
                cancelButtonText: "Tidak",
            }).then((r) => {
                if (r.value) {
                    $.ajax({
                        url: '{{ route('createTransaksiPost') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            layanan: layanan,
                            pelanggan: pelanggan.id,
                            diskon: diskon.id,
                            pengiriman: pengiriman.id,
                            pembayaran: parseInt(document.getElementById('pembayaran').value),
                            status_pembayaran: document.getElementById('pembayaranLunas').checked === true ? 'lunas' : 'belum lunas',
                            catatan: document.getElementById('catatan').value,
                            harga: JSON.parse(localStorage.getItem('subHarga')),
                            harga_diskon: JSON.parse(localStorage.getItem('hargaDiskon')),
                            biaya_pengiriman: JSON.parse(localStorage.getItem('hargaPengiriman')),
                            harga_parfum: JSON.parse(localStorage.getItem('hargaParfum')),
                            total_harga: JSON.parse(localStorage.getItem('totalHarga'))
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Buat Transaksi Berhasil!',
                                    showConfirmButton: true
                                }).then((r) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Buat Transaksi Gagal!',
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
