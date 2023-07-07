@extends('components.layout', ['title' => 'Tambah Pegawai'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Pegawai</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pegawai.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="kode_pegawai">Kode Pegawai</label>
                    <input type="text" name="kode_pegawai" id="kode_pegawai" class="form-control">
                </div>

                <div class="form-group">
                    <label for="nama_pegawai">Nama Pegawai</label>
                    <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control">
                </div>

                <div class="form-group">
                    <label for="jabatan_id">Jabatan</label>
                    <select name="jabatan_id" id="jabatan_id" class="form-control">
                        @foreach($jabatanList as $jabatan)
                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
