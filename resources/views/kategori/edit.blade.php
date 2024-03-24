@extends('layout.app')

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Tambah Kategori')

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Kategori</h3>
            </div>
            <form action="{{ url('kategori/update', [$data->kategori_id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeKategori">Kode Kategori</label>
                        <input type="text" class="form-control" id="kodeKategori" name="kodeKategori"
                            placeholder="Kode Kategori" value="{{ $data->kategori_kode }}">
                    </div>
                    <div class="form-group">
                        <label for="namaKategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="namaKategori" name="namaKategori"
                            placeholder="Nama Kategori" value="{{ $data->kategori_nama }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
