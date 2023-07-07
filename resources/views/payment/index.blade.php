@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-bold">Payment List</h4>
                        <a href="{{ route('payment.create') }}" class="btn btn-outline-dark float-right"><i
                                class="feather icon-plus"></i>Create Payment</a>
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
                                        <th>#</th>
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
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><b>{{ $payment->kode_bayar }}</b></td>
                                            <td>
                                                {{ $payment->pegawai->nama_pegawai }}
                                            </td>
                                            <td>{{ $payment->total_jtm }}</td>
                                            <td>{{ $payment->total_honor }}</td>
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
                                                            $tugasHonor = json_decode($payment->tugas_honor, true);
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
                                            {{-- <td>{{ $payment->payroll }}</td>
                                            <td>{{ $payment->koperasi }}</td> --}}
                                            <td>{{ $payment->total_bersih }}</td>
                                            <td>{{ $payment->bulan }}</td>
                                            <td>{{ $payment->tanggal_bayar }}</td>
                                            <td>
                                                <div class="btn-group">

                                                    <form action="{{ route('payment.destroy', $payment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('payment.show', $payment->id) }}"
                                                            class="btn btn-icon"><i class="feather icon-eye"></i></a>
                                                        <a href="{{ route('payment.edit', $payment->id) }}"
                                                            class="btn btn-icon"><i class="feather icon-edit"></i></a>
                                                        <button type="submit" class="btn btn-icon"
                                                            onclick="return confirm('Are you sure you want to delete this payment data?')"><i
                                                                class="feather icon-trash"></i></button>
                                                    </form>
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
