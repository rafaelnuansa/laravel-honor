@extends('components.layout', ['title' => 'Laporan Honor'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Transaksi Honor</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.payment.index') }}" method="GET">
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
                            <a href="{{ route('laporan.payment.index') }}" class="btn btn-outline-dark"><i class="feather icon-refresh-cw"></i>Reset</a>
                            <a href="{{ route('laporan.payment.index', ['export' => true, 'start_at' => $startDate, 'end_at' => $endDate, 'pegawai_id' => $employeeId]) }}"
                                class="btn btn-outline-success"><i class="feather icon-download"></i>Export Data</a>

                        </form>
                    </div>
                </div>
                @if (isset($payment))
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Laporan Transaksi Honor</h4>
                            @if ($startDate && $endDate)
                                <h6 class="card-subtitle">Rentang Tanggal: {{ $startDate }} - {{ $endDate }}</h6>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (count($payment) > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Kode Bayar</th>
                                        <th>Pegawai</th>
                                        <th>JTM</th>
                                        <th>Honor</th>
                                        {{-- <th class="text-center">Detail Tugas</th> --}}
                                        {{-- <th>Payroll</th>
                                        <th>Koperasi</th> --}}
                                        <th>Total Bersih</th>
                                        <th>Bulan</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payment as $item)
                                            <tr>
                                                <td><b>{{ $item->kode_bayar }}</b></td>
                                            <td>
                                                {{ $item->pegawai->nama_pegawai }}
                                            </td>
                                            <td>{{ $item->total_jtm }}</td>
                                            <td>{{ $item->total_honor }}</td>
                                            {{-- <td>
                                                <table class="inner-table table">
                                                    <thead>
                                                        <tr>
                                                            <th>Tugas</th>
                                                            <th>Honor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $tugasHonor = json_decode($item->tugas_honor, true);
                                                            $totalTugasHonor = 0;
                                                        @endphp
                                                        @foreach ($tugasHonor as $item)
                                                            <tr>
                                                                <td>{{ $item['nama_tugas'] }}</td>
                                                                <td>{{ $item['honor'] }}</td>
                                                            </tr>
                                                            @php
                                                                $totalTugasHonor += $item['honor'];
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td> --}}
                                            {{-- <td>{{ $item->payroll }}</td>
                                            <td>{{ $item->koperasi }}</td> --}}
                                            <td>{{ $item->total_bersih }}</td>
                                            <td>{{ $item->bulan }}</td>
                                            <td>{{ $item->tanggal_bayar }}</td>
                                            <td>
                                                <div class="btn-group">

                                                    <a href="{{ route('payment.show', $item->id) }}"
                                                        class="btn btn-icon"><i class="feather icon-eye"></i></a>
                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <h5>Total: {{ $totalHonor }}</h5>
                                    <h5>JTM: {{ $totalJtm }}</h5>
                                </div>
                            @else
                                <p>Tidak ada data payment dalam rentang tanggal yang dipilih.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
