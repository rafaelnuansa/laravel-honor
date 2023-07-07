@extends('components.layout', ['title' => 'Edit Jabatan'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Jabatan</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama_jabatan">Nama Jabatan</label>
                                <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control"
                                    value="{{ $jabatan->nama_jabatan }}" required>
                            </div>

                            <div class="form-group">
                                <label for="honor_jabatan">Honor Jabatan</label>
                                <input type="text" name="honor_jabatan" id="honor_jabatan" class="form-control"
                                    value="{{ $jabatan->honor_jabatan }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Tambahkan skrip JavaScript yang diperlukan di sini -->
@endpush
