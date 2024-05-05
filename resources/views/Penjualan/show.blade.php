@extends('layout.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($penjualan)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $penjualan->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th>Staff</th>
                        <td>{{ $penjualan->user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Pembeli</th>
                        <td>{{ $penjualan->pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Penjualan Kode</th>
                        <td>{{ $penjualan->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Penjualan Tanggal</th>
                        <td>{{ $penjualan->penjualan_tanggal }}</td>
                    </tr>
                </table>

                <div class="card card-outline card-primary mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Detail Penjualan</h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        @empty($penjualan)
                            <div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> Data Detail Transaksi Kosong</h5>
                            </div>
                        @else
                            <table class="table table-bordered table-striped table-hover table-sm">
                                <tr>
                                    <th>Detail ID</th>
                                    <th>Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                                @foreach ($penjualan->details as $item)
                                    <tr>
                                        <td>{{ $item->detail_id }}</td>
                                        <td>{{ $item->barang->barang_nama }}</td>
                                        <td>{{ $item->harga }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @endempty
                    </div>
                </div>

            @endempty
            <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt2">Kembali</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush