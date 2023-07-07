@extends('components.layout-pegawai')

@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                    <div class="card-body">
                        <form action="{{ route('lainnya.index') }}" method="GET">
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
                            <button type="submit" class="btn btn-outline-primary"><i
                                    class="feather icon-filter"></i>Generate Laporan</button>
                            <a href="{{ route('lainnya.index') }}" class="btn btn-outline-dark"><i
                                    class="feather icon-refresh-cw"></i>Reset</a>
                            <a href="{{ route('lainnya.index', ['export' => true, 'start_at' => $startDate, 'end_at' => $endDate]) }}"
                                class="btn btn-outline-success"><i class="feather icon-download"></i>Export Data</a>

                        </form>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Riwayat Lainnya</h4>
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
                                            <td>{{ $otherPayment->kode_payment }}</td>
                                            <td>{{ $otherPayment->nama_payment }}</td>
                                            <td>{{ $otherPayment->tgl_payment }}</td>
                                            <td>{{ $otherPayment->total_payment }}</td>
                                            <td><span class="badge bg-primary">{{ $otherPayment->channel->nama }}</span></td>
                                            <td>
                                                <a href="{{ route('lainnya.show', $otherPayment->id) }}"
                                                    class="btn btn-icon"><i class="feather icon-printer"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $otherPayments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
