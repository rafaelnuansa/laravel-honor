@extends('components.layout', ['title' => 'Tugas'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tugas Tambahan</h4>
            <!-- Button untuk membuka modal -->
            <a href="#" class="btn btn-dark float-right waves-effect waves-light" data-toggle="modal"
                data-target="#tambahTugasModal">
                <i class="feather icon-plus"></i> Tambah Tugas
            </a>

        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Tugas</th>
                            <th>Honor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tugasList as $tugas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tugas->nama_tugas }}</td>
                                <td>{{ $tugas->honor }}</td>
                                <td>

                                    <form action="{{ route('tugas.destroy', $tugas->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('tugas.edit', $tugas->id) }}" class="btn btn-icon">
                                            <i class="feather icon-edit"></i>
                                        </a>
                                        <button type="submit" class="btn btn-icon"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                            <i class="feather icon-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Tugas -->
    <div class="modal fade" id="tambahTugasModal" tabindex="-1" role="dialog" aria-labelledby="tambahTugasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTugasModalLabel">Tambah Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambahkan tugas -->
                    <form method="POST" action="{{ route('tugas.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="nama_tugas">Nama Tugas</label>
                            <input type="text" name="nama_tugas" id="nama_tugas" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="honor">Honor Tugas</label>
                            <input type="number" name="honor" id="honor" class="form-control" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
