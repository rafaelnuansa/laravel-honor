@extends('components.invoice-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left mb-2">
                                <img src="https://yaspisakotabogor.com/sihonor/app/assets/images/logo-dark.png" alt=""
                                    height="28">
                            </div>
                            <div class="float-right">
                                <h3 class="m-0 d-print-none">SLIP PEMBAYARAN</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <p></p>
                                    <h5>YTH, {{ $otherPayment->pegawai->nama_pegawai }}</h5>
                                    <p></p>
                                    <p class="text-muted">Terimakasih Atas Loyalitas dan kerja kerasnya dalam mengemban
                                        amanah
                                        pendidikan untuk mencerdaskan Anak Bangsa.Semoga diberikan keberkahan dalam setiap
                                        menjalani aktivitas kehidupan sehari - hari. </p>
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
                                    <h5>JANUARI</h5>

                                    <address class="line-h-24">
                                        Honor Atas Nama RAHMAT UBAIDILLAH, MM <br>
                                        Bulan : JANUARI<br>
                                        Lunas Bayar Pada :<abbr title="Bulan"> 2023-02-07 </abbr>

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
                                    <h6 class="mt-5 pt-4">RAHMAT UBAIDILLAH, MM </h6>
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
                </div>
                <div class="mt-4">
                    <a href="{{ route('otherpayment.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')

@endpush
