@extends('components.layout-pegawai')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="printarea">

                            <div class="clearfix">
                                <div class="float-left mb-2">
                                    <img src="https://yaspisakotabogor.com/sihonor/app/assets/images/logo-dark.png"
                                        alt="" height="28">
                                </div>
                                <div class="float-right">
                                    <h3 class="m-0 d-print-none">SLIP PEMBAYARAN</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <h5>{{ $otherPayment->pegawai->nama_pegawai }}</h5>
                                        <p class="text-muted">{{ $settings->catatan_invoice}}</p>
                                    </div>

                                </div><!-- end col -->
                                <div class="col-md-6">
                                    <div class="mt-3 text-md-right">
                                        <p><strong>Tanggal Bayar : </strong> {{ $otherPayment->tgl_payment }}</p>
                                        <p><strong>Metode : </strong> <span
                                                class="badge badge-success">{{ $otherPayment->channel->nama }}</span></p>
                                        <p><strong>Kode : </strong>{{ $otherPayment->kode_payment }}</p>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5>{{ $settings->nama_sekolah }}</h5>
                                    <address class="line-h-24">
                                        {{ $settings->nomor_kontak }}<br>
                                        <abbr title="Whastapp">{{ $settings->nomor_kontak }}</abbr>
                                    </address>
                                </div>

                                <div class="col-md-6">
                                    <div class="text-md-right">
                                        <h5>{{ $otherPayment->nama_payment }}</h5>

                                        <address class="line-h-24">
                                            Atas Nama {{ $otherPayment->pegawai->nama_pegawai }} <br>
                                        </address>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mt-4">
                                            <thead>
                                                <tr>
                                                    <th>Kegiatan</th>
                                                    <th>Qty</th>
                                                    <th>Honor</th>
                                                    <th>Total Honor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($otherPaymentItems as $item)
                                                    <tr>
                                                        <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ $item->honor }}</td>
                                                        <td>{{ $item->total_honor }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3">Total</td>
                                                    <td colspan="1"><b>{{ $otherPayment->total_payment }}</b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="clearfix pt-4">
                                        <h6 class="text-muted">Notes:</h6>

                                        <small>
                                            Ini adalah bukti pembayaran honor {{ $settings->nama_sekolah }} yang
                                            dapat di Cetak.
                                        </small>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-md-left">
                                        <h6 class="py-2">Penerima</h6>
                                        <h6 class="mt-5 pt-4">{{ $otherPayment->pegawai->nama_pegawai }} </h6>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="text-md-right">
                                        <h6 class="py-2">{{ $settings->jabatan_ttd_invoice }}</h6>
                                        <h6 class="mt-5 pt-4">{{ $settings->nama_ttd_invoice}}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="hidden-print mt-4">
                            <div class="text-right d-print-none">
                                <a href="javascript:window.print()" class="btn btn-outline-dark waves-effect waves-light"><i
                                        class="fa fa-print mr-1"></i> Print</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('otherpayment.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printarea,
            #printarea * {
                visibility: visible;
            }

            #printarea {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endpush
