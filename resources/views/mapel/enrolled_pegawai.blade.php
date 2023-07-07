@extends('components.layout', ['title' => 'Enrolled Pegawai'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Enrolled in {{ $mapel->nama_mapel }}</h4>
            <!-- Tombol Enroll Semua Pegawai -->
        </div>
        <div class="card-body">
            <a href="{{ route('mapel.index')}}" class="btn btn-outline-dark"> Kembali</a>
            <form action="{{ route('mapel.enrollAll', $mapelList[0]->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin enroll semua pegawai?')">
                @csrf
                <button type="submit" class="btn btn-outline-primary waves-effect waves-light">
                    Enroll Semua Pegawai
                </button>
            </form>

            <form action="{{ route('mapel.unenrollAll', ['mapel' => $mapel->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin unenroll semua pegawai?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light">Unenroll All</button>
            </form>
        <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pegawai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawaiList as $pegawai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pegawai->pegawai->nama_pegawai }}</td>
                            <td>
                                <form
                                    action="{{ route('mapel.unenroll', ['mapel' => $mapel->id, 'pegawaiMapel' => $pegawai->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Unenroll</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
