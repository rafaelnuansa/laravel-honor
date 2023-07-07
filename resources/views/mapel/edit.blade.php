@extends('components.layout', ['title' => 'Edit Mapel'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Mapel</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_mapel">Nama Mapel</label>
                    <input type="text" class="form-control" id="nama_mapel" name="nama_mapel"
                        value="{{ $mapel->nama_mapel }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
