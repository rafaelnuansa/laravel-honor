@extends('components.layout', ['title' => 'Mapel'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Mata Pelajaran</h4>
            <!-- Button untuk membuka modal -->
            <a href="#" class="btn btn-outline-dark float-right waves-effect waves-light" data-toggle="modal"
                data-target="#tambahMapelModal">
                <i class="feather icon-plus"></i> Tambah Mapel
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
                            <th>Mata Pelajaran</th>
                            <th>Jumlah Pegawai</th>
                            <th>Enroll Pegawai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapelList as $mapel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mapel->nama_mapel }}</td>
                                <td>Pegawai ( {{ $mapel->pegawaiMapel->count() }} )</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#enrollPegawaiModal{{ $mapel->id }}">
                                        Enroll Pegawai
                                    </button>
                                    <a href="{{ route('mapel.enrolledPegawai', $mapel->id) }}" class="btn btn-primary btn-sm">
                                        Lihat Pegawai
                                    </a>
                                </td>
                                <td>

                                    <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('mapel.edit', $mapel->id) }}" class="btn btn-icon">
                                            <i class="feather icon-edit"></i>
                                        </a>
                                        <button type="submit" class="btn btn-icon"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus mapel ini?')">
                                            <i class="feather icon-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            </tr>

                            <!-- Modal Enroll Pegawai -->
                            <div class="modal fade" id="enrollPegawaiModal{{ $mapel->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="enrollPegawaiModalLabel{{ $mapel->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="enrollPegawaiModalLabel{{ $mapel->id }}">
                                                Enroll Pegawai ke Mata Pelajaran
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk memasukkan pegawai ke mata pelajaran -->
                                            <form method="POST"
                                                action="{{ route('mapel.enroll', ['mapel' => $mapel->id]) }}">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="pegawai_id">Pegawai</label>

                                                    <select name="pegawai_id" id="pegawai_id" class="form-control select2">
                                                        <option value="">-- Pilih Pegawai --</option>
                                                        @foreach ($pegawaiList as $pegawai)
                                                            <option value="{{ $pegawai->id }}">
                                                                {{ $pegawai->nama_pegawai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Enroll</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Mapel -->
    <div class="modal fade" id="tambahMapelModal" tabindex="-1" role="dialog" aria-labelledby="tambahMapelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahMapelModalLabel">Tambah Mapel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambahkan mapel -->
                    <form method="POST" action="{{ route('mapel.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="nama_mapel">Nama Mapel</label>
                            <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" required>
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
