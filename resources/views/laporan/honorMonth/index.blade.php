@extends('components.layout', ['title' => 'Laporan Honor'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Honor Perbulan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.honorMonth.index') }}" method="GET">
                            <div class="form-group">
                                <label for="bulan">Bulan :</label>
                                <input type="month" class="form-control" id="bulan" name="bulan"
                                    value="{{ $bulan ?? '' }}">
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
                            <a href="{{ route('laporan.honorMonth.index') }}" class="btn btn-outline-dark"><i class="feather icon-refresh-cw"></i>Reset</a>
                            <a href="{{ route('laporan.honorMonth.index', ['export' => true, 'bulan' => $bulan, 'pegawai_id' => $employeeId]) }}"
                                class="btn btn-outline-success"><i class="feather icon-download"></i>Export Data</a>

                        </form>
                    </div>
                </div>
                @if (isset($groupedHonor))
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Laporan Honor Perbulan</h4>
                            @if ($bulan)
                                <h6 class="card-subtitle">Laporan : {{ $bulan }}</h6>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (count($groupedHonor) > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Guru</th>
                                        <th>Total JTM</th>
                                        <th>Jumlah Honor</th>
                                        <th>Bulan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($groupedHonor as $group)
                                        @php
                                            $totalJtm = $group->sum('jtm');
                                            $totalJumlah = $group->sum('jumlah');
                                        @endphp
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $group[0]->pegawai->nama_pegawai }}</td>
                                            <td>{{ $totalJtm }}</td>
                                            <td>{{ $totalJumlah }}</td>
                                            <td>{{ \Carbon\Carbon::parse($group[0]->tanggal)->format('F Y') }}</td>

                                        </tr>
                                        {{-- @foreach ($group as $item)
                                            <tr>
                                                <td></td>
                                                <td>{{ $item->mapel->nama_mapel }}</td>
                                                <td>{{ $item->jtm }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>{{ $item->tanggal }}</td>
                                            </tr>
                                        @endforeach --}}
                                    @endforeach
                                </tbody>
                            </table>
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
