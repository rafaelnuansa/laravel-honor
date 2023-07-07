@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Pembayaran Honor</h4>

                        <div class="float-right">
                            <a href="{{ route('honor.create') }}" class="btn btn-outline-dark waves-effect"><i class="feather icon-plus mr-1"></i>Tambah Data</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif



                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pegawai</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>JTM</th>
                                        <th>Honor</th>
                                        <th>Jumlah</th>
                                        <th>Status KBM</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($honorList as $honor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $honor->pegawai->nama_pegawai }}</td>
                                            <td>{{ $honor->mapel->nama_mapel }}</td>
                                            <td>{{ $honor->kelas->nama_kelas }}</td>
                                            <td>{{ $honor->jtm }}</td>
                                            <td>{{ $honor->honor }}</td>
                                            <td>{{ $honor->jumlah }}</td>
                                            <td>{{ $honor->status_mengajar->status_mengajar }}</td>
                                            <td>{{ $honor->tanggal }}</td>
                                            <td class="btn-group">
                                                <a href="{{ route('honor.edit', $honor->id) }}"
                                                    class="btn btn-icon"><i class="feather icon-edit"></i></a>
                                                <form action="{{ route('honor.destroy', $honor->id) }}" method="POST"
                                                    style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon"
                                                        onclick="return confirm('Are you sure you want to delete this honor data?')"><i class="feather icon-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $honorList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
