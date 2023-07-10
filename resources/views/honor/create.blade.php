@extends('components.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Honor</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('honor.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="pegawai_id">Pegawai</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-control">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($pegawaiList as $pegawai)
                                        <option value="{{ $pegawai->id }}"
                                            {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->nama_pegawai }}</option>
                                    @endforeach
                                </select>
                                @error('pegawai_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kelas_id">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-control select2">
                                    @foreach ($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mapel_id">Mata Pelajaran</label>
                                <select name="mapel_id" id="mapel_id" class="form-control select2">

                                </select>
                                @error('mapel_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ old('tanggal') }}" required>
                                @error('tanggal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jtm">Jam Tugas Mengajar</label>
                                <input type="number" name="jtm" id="jtm" class="form-control"
                                    value="{{ old('jtm') }}" required>
                                @error('jtm')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status_mengajar_id">Status KBM</label>
                                <select name="status_mengajar_id" id="status_mengajar_id" class="form-control select2"
                                    required>
                                    @foreach ($KBMList as $kbm)
                                        <option value="{{ $kbm->id }}">{{ $kbm->status_mengajar }}</option>
                                    @endforeach
                                </select>
                                @error('status_mengajar_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('honor.index') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Tangani perubahan pemilihan pegawai
            $('#pegawai_id').change(function() {
                var url = "{{ route('getMapelByPegawai') }}";
                var pegawaiId = $(this).val();

                if (pegawaiId) {
                    getMapel(url, pegawaiId);
                } else {
                    $('#mapel_id').empty();
                }
            });

            // Fungsi untuk mengambil daftar mata pelajaran
            function getMapel(url, pegawaiId) {

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        pegawai_id: pegawaiId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Bersihkan opsi mata pelajaran sebelumnya
                        $('#mapel_id').empty();

                        // Tambahkan opsi mata pelajaran baru
                        $.each(response.mapelList, function(key, value) {
                            var option = $('<option>').val(value.mapel.id).text(value.mapel
                                .nama_mapel);
                            console.log(value)
                            $('#mapel_id').append(option);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        console.log(error);
                    }
                });
            }
        });
    </script>
@endpush
