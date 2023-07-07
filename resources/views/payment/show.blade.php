@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="printarea">

                        <div class="clearfix">
                            <div class="float-left mb-2">
                                <img src="https://yaspisakotabogor.com/sihonor/app/assets/images/logo-dark.png" alt=""
                                    height="28">
                            </div>
                            <div class="float-right">
                                <h3 class="m-0 d-print-none">SLIP GAJI</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <p></p>
                                    <h5>YTH, {{ $payment->pegawai->nama_pegawai }}</h5>
                                    <p></p>
                                    <p class="text-muted">Terimakasih Atas Loyalitas dan kerja kerasnya dalam mengemban
                                        amanah
                                        pendidikan untuk mencerdaskan Anak Bangsa.Semoga diberikan keberkahan dalam setiap
                                        menjalani aktivitas kehidupan sehari - hari. </p>
                                </div>

                            </div><!-- end col -->
                            <div class="col-md-6">
                                <div class="mt-3 text-md-right">
                                    <p><strong>Tanggal Bayar : </strong> {{ $payment->created_at }}</p>
                                    <p><strong>Metode : </strong> <span
                                            class="badge badge-success">{{ $payment->channel->nama }}</span></p>
                                    <p><strong>Kode : </strong>{{ $payment->kode_bayar }}</p>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5>SMK BINA INSAN MANDIRI</h5>
                                <address class="line-h-24">
                                    Kp. Bojong Kidul RT 07/02<br>
                                    Bojongkerta - Bogor Selatan<br>
                                    Kota Bogor<br>
                                    <abbr title="Whastapp">+6283813555567</abbr>
                                </address>

                            </div>

                            <div class="col-md-6">
                                <div class="text-md-right">
                                    <h5>{{ \Carbon\Carbon::parse($payment->bulan)->format('F, Y') }}</h5>
                                    <address class="line-h-24">
                                        Honor Atas Nama : {{ $payment->pegawai->nama_pegawai}}
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
                                                <th>Total JTM</th>
                                                <th>Total Honor</th>
                                                <th class="text-center">Detail Tugas</th>
                                                <th>Payroll</th>
                                                <th>Koperasi</th>
                                                <th>Bulan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>{{ $payment->total_jtm }}</td>
                                            <td>{{ $payment->total_honor }}</td>
                                            <td>
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
                                            </td>
                                            <td>{{ $payment->payroll }}</td>
                                            <td>{{ $payment->koperasi }}</td>
                                            <td>{{ $payment->bulan }}</td>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">Total</td>
                                                <td colspan="1"><b>{{ $payment->total_bersih }}</b></td>
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
                                        Ini adalah bukti pembayaran honor bulanan SMK Bina Insan Mandiri Kota Bogor yang
                                        dapat di Cetak.
                                    </small>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-md-left">
                                    <h6 class="py-2">Guru Penerima</h6>
                                    <h6 class="mt-5 pt-4">{{ $payment->pegawai->nama_pegawai }} </h6>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="text-md-right">
                                    <h6 class="py-2">Bendahara Sekolah</h6>
                                    <h6 class="mt-5 pt-4">Lena Rahmawati, S.Pd.I</h6>
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
        #printarea, #printarea * {
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
