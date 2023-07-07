@extends('components.layout', ['title' => 'Settings'])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Application Settings</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nama_aplikasi">Application Name</label>
                                <input type="text" class="form-control" id="nama_aplikasi" name="nama_aplikasi" value="{{ $settings->nama_aplikasi }}">
                            </div>

                            <div class="form-group">
                                <label for="logo_aplikasi">Application Logo</label>
                                <input type="file" class="form-control-file" id="logo_aplikasi" name="logo_aplikasi">
                                @if ($settings->logo_aplikasi)
                                    <img src="{{ asset('storage/' . $settings->logo_aplikasi) }}" alt="Application Logo" class="img-thumbnail mt-2" style="max-width: 200px">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="nama_sekolah">School Name</label>
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="{{ $settings->nama_sekolah }}">
                            </div>

                            <div class="form-group">
                                <label for="logo_sekolah">School Logo</label>
                                <input type="file" class="form-control-file" id="logo_sekolah" name="logo_sekolah">
                                @if ($settings->logo_sekolah)
                                    <img src="{{ asset('storage/' . $settings->logo_sekolah) }}" alt="School Logo" class="img-thumbnail mt-2" style="max-width: 200px">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="alamat_sekolah">School Address</label>
                                <textarea class="form-control" id="alamat_sekolah" name="alamat_sekolah">{{ $settings->alamat_sekolah }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="nomor_kontak">Contact Number</label>
                                <input type="text" class="form-control" id="nomor_kontak" name="nomor_kontak" value="{{ $settings->nomor_kontak }}">
                            </div>

                            <div class="form-group">
                                <label for="nama_ttd_invoice">Invoice Signer Name</label>
                                <input type="text" class="form-control" id="nama_ttd_invoice" name="nama_ttd_invoice" value="{{ $settings->nama_ttd_invoice }}">
                            </div>

                            <div class="form-group">
                                <label for="jabatan_ttd_invoice">Invoice Signer Position</label>
                                <input type="text" class="form-control" id="jabatan_ttd_invoice" name="jabatan_ttd_invoice" value="{{ $settings->jabatan_ttd_invoice }}">
                            </div>

                            <div class="form-group">
                                <label for="catatan_invoice">Invoice Note</label>
                                <textarea class="form-control" id="catatan_invoice" name="catatan_invoice">{{ $settings->catatan_invoice }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="img_login">Login Image</label>
                                <input type="file" class="form-control-file" id="img_login" name="img_login">
                                @if ($settings->img_login)
                                    <img src="{{ asset('storage/' . $settings->img_login) }}" alt="Login Image" class="img-thumbnail mt-2" style="max-width: 200px">
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
