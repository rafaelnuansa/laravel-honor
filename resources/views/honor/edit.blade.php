@extends('components.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Honor</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('honor.update', $honor->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="pegawai_id">Pegawai</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-control select2">
                                    @foreach ($pegawaiList as $pegawai)
                                        <option value="{{ $pegawai->id }}"
                                            {{ $honor->pegawai_id == $pegawai->id ? 'selected' : '' }}>
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
                                            {{ $honor->kelas_id == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
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
                                    @foreach ($mapelList as $mapel)
                                        <option value="{{ $mapel->id }}"
                                            {{ $honor->mapel_id == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}</option>
                                    @endforeach
                                </select>
                                @error('mapel_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ $honor->tanggal }}" required>
                                @error('tanggal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jtm">Jam Tugas Mengajar</label>
                                <input type="number" name="jtm" id="jtm" class="form-control"
                                    value="{{ $honor->jtm }}" required>
                                @error('jtm')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status_mengajar_id">Status KBM</label>
                                <select name="status_mengajar_id" id="status_mengajar_id" class="form-control select2">
                                    @foreach ($KBMList as $kbm)
                                        <option value="{{ $kbm->id }}"
                                            {{ $honor->status_mengajar_id == $kbm->id ? 'selected' : '' }}>
                                            {{ $kbm->status_mengajar }}</option>
                                    @endforeach
                                </select>
                                @error('status_mengajar_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('honor.index') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Get the selected pegawai_id from the form data
                var selectedPegawaiId = "{{ $honor->pegawai_id }}";

                // Load the mapel options based on the selected pegawai_id
                loadMapelOptions(selectedPegawaiId);

                // Handle the change event of the pegawai_id select element
                $('#pegawai_id').change(function() {
                    var selectedPegawaiId = $(this).val();
                    loadMapelOptions(selectedPegawaiId);
                });

                // Function to load the mapel options based on the selected pegawai_id
                function loadMapelOptions(selectedPegawaiId) {
                    var url = "{{ route('getMapelByPegawai') }}";

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            pegawai_id: selectedPegawaiId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Clear the existing options
                            $('#mapel_id').empty();

                            // Add the new options
                            $.each(response.mapelList, function(key, value) {
                                var option = $('<option>').val(value.mapel.id).text(value.mapel.nama_mapel);
                                $('#mapel_id').append(option);
                            });

                            // Set the selected mapel_id
                            $('#mapel_id').val("{{ $honor->mapel_id }}");
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
