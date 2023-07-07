@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <h4>Pembayaran Lainnya</h4>

                        <a href="{{ route('otherpayment.create') }}" class="btn btn-outline-dark btn-icon"><i class="feather icon-plus"></i>Create Payment</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $otherPayment->pegawai->nama_pegawai }}</td>
                                        <td>{{ $otherPayment->kode_payment }}</td>
                                        <td>{{ $otherPayment->nama_payment }}</td>
                                        <td>{{ $otherPayment->tgl_payment }}</td>
                                        <td>{{ $otherPayment->total_payment }}</td>
                                        <td>{{ $otherPayment->channel->nama }}</td>
                                        <td>
                                            <a href="{{ route('otherpayment.show', $otherPayment->id) }}"
                                                class="btn btn-icon"><i class="feather icon-printer"></i></a>
                                            <a href="{{ route('otherpayment.edit', $otherPayment->id) }}"
                                                class="btn btn-icon"><i class="feather icon-edit"></i></a>
                                            <form action="{{ route('otherpayment.destroy', $otherPayment->id) }}"
                                                method="POST" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon"
                                                    onclick="return confirm('Are you sure you want to delete this payment data?')"><i class="feather icon-trash"></i></button>
                                            </form>
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
@endsection
