@extends('components.layout', ['title' => 'Laporan Honor'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Honor</h4>
                    </div>
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
                            <div class="form-group">
                                <label for="pegawai_id">Pegawai:</label>
                                <select class="form-control select2" id="pegawai_id" name="pegawai_id">
                                    <option value="">Semua Pegawai</option>
                                    @foreach ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">
                                            {{ $pegawai->nama_pegawai . ' - ' . $pegawai->kode_pegawai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-primary"><i class="feather icon-filter"></i>Generate Laporan</button>
                            <a href="{{ route('laporan.honor.index') }}" class="btn btn-outline-dark"><i class="feather icon-refresh-cw"></i>Reset</a>
                            <a href="{{ route('laporan.honor.index', ['export' => true, 'start_at' => $startDate, 'end_at' => $endDate, 'pegawai_id' => $employeeId]) }}"
                                class="btn btn-outline-success"><i class="feather icon-download"></i>Export Data</a>

                        </form>
                    </div>
                </div>
                @if (isset($honor))
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Laporan Honor</h4>
                            @if ($startDate && $endDate)
                                <h6 class="card-subtitle">Rentang Tanggal: {{ $startDate }} - {{ $endDate }}</h6>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (count($honor) > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Pegawai</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>JTM</th>
                                            <th>Honor</th>
                                            <th>Jumlah</th>
                                            <th>Status KBM</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($honor as $item)
                                            <tr>
                                                <td>{{ $item->pegawai->nama_pegawai }}</td>
                                                <td>{{ $item->mapel->nama_mapel }}</td>
                                                <td>{{ $item->kelas->nama_kelas }}</td>
                                                <td>{{ $item->jtm }}</td>
                                                <td>{{ $item->honor }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>{{ $item->status_mengajar->status_mengajar }}</td>
                                                <td>{{ $item->tanggal }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <h5>Total Honor: {{ $totalHonor }}</h5>
                                    <h5>Total JTM: {{ $totalJtm }}</h5>
                                </div>
                            @else
                                <p>Tidak ada data honor dalam rentang tanggal yang dipilih.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
