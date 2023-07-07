@extends('components.layout', ['title' => 'Kegiatan'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Kegiatan</h4>
            <!-- Button untuk membuka modal -->
            <a href="#" class="btn btn-outline-dark float-right waves-effect waves-light" data-toggle="modal"
                data-target="#tambahKegiatanModal">
                <i class="feather icon-plus"></i> Tambah Kegiatan
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
                            <th>Kegiatan</th>
                            <th>Honor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kegiatanList as $kegiatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kegiatan->nama_kegiatan }}</td>
                                <td>{{ $kegiatan->honor }}</td>
                                <td>

                                    <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-icon">
                                            <i class="feather icon-edit"></i>
                                        </a>
                                        <button type="submit" class="btn btn-icon"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
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


    <!-- Modal Tambah Kegiatan -->
    <div class="modal fade" id="tambahKegiatanModal" tabindex="-1" role="dialog" aria-labelledby="tambahKegiatanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKegiatanModalLabel">Tambah Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambahkan kegiatan -->
                    <form method="POST" action="{{ route('kegiatan.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" placeholder="Nama Kegiatan" id="nama_kegiatan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="honor">Honor Kegiatan</label>
                            <input type="number" name="honor" id="honor" placeholder="Honor Kegiatan" class="form-control" required>
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
