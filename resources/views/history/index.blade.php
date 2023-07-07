@extends('components.layout-pegawai', ['title' => 'History Honor'])

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('laporan.honor.index') }}" method="GET">
                            <div class="form-group">
                                <label for="start_at">Mulai:</label>
                                <input type="month" class="form-control" id="start_at" name="start_at"
                                    value="{{ $startDate ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="end_at">Selesai:</label>
                                <input type="month" class="form-control" id="end_at" name="end_at"
                                    value="{{ $endDate ?? '' }}">
                            </div>
                            <button type="submit" class="btn btn-outline-primary"><i class="feather icon-filter"></i>Generate</button>
                            <a href="{{ route('history.index') }}" class="btn btn-outline-dark"><i class="feather icon-refresh-cw"></i>Reset</a>
                            <a href="{{ route('history.index', ['export' => true, 'start_at' => $startDate, 'end_at' => $endDate]) }}"
                                class="btn btn-outline-success"><i class="feather icon-download"></i>Export Data</a>

                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>JTM Harian Saya</h4>
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
                                        <th>Tanggal</th>
                                        <th>JTM</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Honor</th>
                                        <th>Jumlah</th>
                                        <th>Status KBM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($honorList as $honor)
                                        <tr>
                                            <td>{{ $honor->tanggal }}</td>
                                            <td>{{ $honor->jtm }}</td>
                                            <td>{{ $honor->mapel->nama_mapel }}</td>
                                            <td>{{ $honor->kelas->nama_kelas }}</td>
                                            <td>{{ $honor->honor }}</td>
                                            <td>{{ $honor->jumlah }}</td>
                                            <td>{{ $honor->status_mengajar->status_mengajar }}</td>
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
