@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Payment</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('payment.store') }}">
                            @csrf
                            <!-- Input fields for payment details -->
                            <div class="form-group">
                                <label for="pegawai_id">Pegawai</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-control select2">
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach ($pegawaiList as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama_pegawai }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_bayar">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control"
                                    value="{{ old('tanggal_bayar') }}">
                            </div>

                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <input type="month" name="bulan" id="bulan" class="form-control"
                                    value="{{ old('bulan') }}">
                            </div>

                            <div class="form-group">
                                <label for="total_honor">Total Honor/Bulan</label>
                                <input type="text" name="total_honor" id="total_honor" readonly class="form-control"
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="total_tugas_honor">Total Tugas Honor/Bulan</label>
                                <input type="text" name="total_tugas_honor" id="total_tugas_honor" readonly
                                    class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="koperasi">Koperasi</label>
                                <input type="number" name="koperasi" id="koperasi" class="form-control"
                                    value="{{ old('koperasi') }}">
                            </div>
                            <div class="form-group">
                                <label for="channel">Channel Pembayaran</label>

                                <select name="channel_id" id="channel_id" class="form-control">
                                    @foreach ($channelList as $channel)
                                        <option value="{{ $channel->id }}">{{ $channel->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary">Create Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pegawai_id, #bulan').on('change', function() {
                var pegawaiId = $('#pegawai_id').val();
                var bulan = $('#bulan').val();
                if (bulan && pegawaiId) {
                    $.ajax({
                        url: "{{ route('payment.getTotalHonor') }}",
                        type: "GET",
                        data: {
                            pegawai_id: pegawaiId,
                            bulan: bulan
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Loading',
                                text: 'Please wait...',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Total Honor: ' + response.total_honor,
                                icon: 'success'
                            });
                            $('#total_honor').val(response.total_honor);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred',
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            setTimeout(function() {
                                Swal.close();
                            }, 3000);
                        }
                    });

                    $.ajax({
                        url: "{{ route('payment.getTugasHonor') }}",
                        type: "GET",
                        data: {
                            pegawai_id: pegawaiId,
                        },
                        beforeSend: function() {
                            // Hapus kode ini karena tugas honor tidak memerlukan loading
                        },
                        success: function(response) {
                            $('#total_tugas_honor').val(response.total_tugas_honor);
                        },
                        error: function(xhr, status, error) {
                            $('#total_tugas_honor').val(error);
                        },
                        complete: function() {
                            // Hapus kode ini karena tugas honor tidak memerlukan loading
                        }
                    });
                }

            });
        });
    </script>
@endpush
