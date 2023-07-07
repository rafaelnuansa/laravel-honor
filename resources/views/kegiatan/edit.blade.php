@extends('components.layout', ['title' => 'Edit Kegiatan'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Kegiatan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan"
                        value="{{ $kegiatan->nama_kegiatan }}" required>
                </div>
                <div class="form-group">
                    <label for="honor">Honor</label>
                    <input type="number" class="form-control" id="honor" name="honor"
                        value="{{ $kegiatan->honor }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
