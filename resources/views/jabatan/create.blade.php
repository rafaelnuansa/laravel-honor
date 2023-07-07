@extends('components.layout', ['title' => 'Tambah Jabatan'])

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Tambah Jabatan</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('jabatan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_jabatan">Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="honor_jabatan">Honor Jabatan</label>
                            <input type="number" name="honor_jabatan" id="honor_jabatan" class="form-control" required>
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
