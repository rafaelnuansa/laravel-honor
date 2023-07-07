@extends('components.layout', ['title' => 'Tambah Mapel'])

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Tambah Kegiatan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kegiatan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_kegiatan">Nama Kegiatan</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
            </div>

            <div class="form-group">
                <label for="honor">Honor Kegiatan</label>
                <input type="number" class="form-control" id="honor" name="honor" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
