@extends('components.layout', ['title' => 'Edit Tugas'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Tugas</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('tugas.update', $tugas->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_tugas">Nama Tugas</label>
                    <input type="text" class="form-control" id="nama_tugas" name="nama_tugas"
                        value="{{ $tugas->nama_tugas }}" required>
                </div>
                <div class="form-group">
                    <label for="honor">Honor</label>
                    <input type="text" class="form-control" id="honor" name="honor"
                        value="{{ $tugas->honor }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
