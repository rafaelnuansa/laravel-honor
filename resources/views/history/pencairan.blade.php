@extends('components.layout-pegawai', ['title' => 'History Pencairan'])

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pencairan.index') }}" method="GET">
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
                            <a href="{{ route('pencairan.index') }}" class="btn btn-outline-dark"><i class="feather icon-refresh-cw"></i>Reset</a>
                            <a href="{{ route('pencairan.index', ['export' => true, 'start_at' => $startDate, 'end_at' => $endDate, 'pegawai_id' => $employeeId]) }}"
                                class="btn btn-outline-success"><i class="feather icon-download"></i>Export Data</a>

                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-bold">Riwayat Pencairan</h4>
                    </div>

                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered" id="paymentTable">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Kode Bayar</th>
                                        <th>JTM</th>
                                        <th>Honor</th>
                                        <th>Tugas</th>
                                        <th>Payroll</th>
                                        <th>Koperasi</th>
                                        <th>Total Bersih</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Channel</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($payment->bulan)->format('F Y') }}</td>
                                            <td><b>{{ $payment->kode_bayar }}</b></td>
                                            <td>{{ $payment->total_jtm }}</td>
                                            <td>{{ $payment->total_honor }}</td>
                                            <td>
                                                @php
                                                    $totalTugasHonor = 0;
                                                    foreach (json_decode($payment->tugas_honor, true) as $item) {
                                                        $totalTugasHonor += $item['honor'];
                                                    }
                                                @endphp

                                                {{ $totalTugasHonor }}

                                            </td>
                                            <td>{{ $payment->payroll }}</td>
                                            <td>{{ $payment->koperasi }}</td>
                                            <td>{{ $payment->total_bersih }}</td>
                                            <td>{{ $payment->tanggal_bayar }}</td>
                                            <td><span class="badge bg-primary">{{ $payment->channel->nama }}</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('pencairan.show', $payment->id) }}"
                                                        class="btn btn-icon"><i class="feather icon-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
