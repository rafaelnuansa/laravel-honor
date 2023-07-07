@extends('components.layout', ['title' => 'Laporan Honor'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Transaksi Lainnya</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.payment.other') }}" method="GET">
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
                            <button type="submit" class="btn btn-outline-primary"><i
                                    class="feather icon-filter"></i>Generate Laporan</button>
                            <a href="{{ route('laporan.payment.other') }}" class="btn btn-outline-dark"><i
                                    class="feather icon-refresh-cw"></i>Reset</a>
                            <a href="{{ route('laporan.payment.other', ['export' => true, 'start_at' => $startDate, 'end_at' => $endDate, 'pegawai_id' => $employeeId]) }}"
                                class="btn btn-outline-success"><i class="feather icon-download"></i>Export Data</a>

                        </form>
                    </div>
                </div>
                @if (isset($otherPayments))
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Laporan Transaksi Lainnya</h4>
                            @if ($startDate && $endDate)
                                <h6 class="card-subtitle">Rentang Tanggal: {{ $startDate }} - {{ $endDate }}</h6>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (count($otherPayments) > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Pegawai</th>
                                            <th>Kode Payment</th>
                                            <th>Nama Payment</th>
                                            <th>Tanggal Payment</th>
                                            <th>Total Payment</th>
                                            <th>Channel Payment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($otherPayments as $otherPayment)
                                            <tr>
                                                <td>{{ $otherPayment->pegawai->nama_pegawai }}</td>
                                                <td>{{ $otherPayment->kode_payment }}</td>
                                                <td>{{ $otherPayment->nama_payment }}</td>
                                                <td>{{ $otherPayment->tgl_payment }}</td>
                                                <td>{{ $otherPayment->total_payment }}</td>
                                                <td>{{ $otherPayment->channel->nama }}</td>
                                                <td>
                                                    <a href="{{ route('otherpayment.show', $otherPayment->id) }}"
                                                        class="btn btn-icon"><i class="feather icon-printer"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
