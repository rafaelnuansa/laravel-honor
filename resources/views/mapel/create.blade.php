@extends('components.layout', ['title' => 'Tambah Mapel'])

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Tambah Mapel</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('mapel.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_mapel">Nama Mapel</label>
                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
