@extends('components.layout', ['title' => 'Detail Pegawai'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Detail Pegawai</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <h5>Informasi Pegawai</h5>
                    <span>Nama: {{ $pegawai->nama_pegawai }}</span><br>
                    <span>Jabatan: {{ $pegawai->jabatan->nama_jabatan }}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <h5>Mata Pelajaran yang Diampu</h5>
                    @if (isset($mapelList))
                        <ul>
                            @foreach ($mapelList as $mapel)
                                <li>{{ $mapel->nama_mapel }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Tidak ada mata pelajaran yang diampu.</p>
                    @endif

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignMapelModal">
                            Assign Mapel
                        </button>
                    </div>
                </div>

                <div class="col-md-6 mb-2">
                    <h5>Tugas Tambahan</h5>
                    @if (isset($tugasList))
                        <ul>
                            @foreach ($tugasList as $tugas)
                                <li>{{ $tugas->nama_tugas }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Tidak ada tugas tambahan yang diambil.</p>
                    @endif

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignTugasModal">
                            Assign Tugas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total JTM Harian</h4>
                </div>
                <div class="card-body">
                    <h5>{{ $totalJtmDaily }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total JTM Mingguan</h4>
                </div>
                <div class="card-body">
                    <h5>{{ $totalJtmWeek }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total JTM Bulanan</h4>
                </div>
                <div class="card-body">
                    <h5>{{ $totalJtmMonth }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total JTM Tahunan</h4>
                </div>
                <div class="card-body">
                    <h5>{{ $totalJtmYear }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">History Jam Mengajar</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @if (count($honorList) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pegawai</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>JTM</th>
                                    <th>Honor</th>
                                    <th>Jumlah</th>
                                    <th>Status KBM</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($honorList as $honor)
                                    <tr>
                                        <td>{{ $honor->pegawai->nama_pegawai }}</td>
                                        <td>{{ $honor->mapel->nama_mapel }}</td>
                                        <td>{{ $honor->kelas->nama_kelas }}</td>
                                        <td>{{ $honor->jtm }}</td>
                                        <td>{{ $honor->honor }}</td>
                                        <td>{{ $honor->jumlah }}</td>
                                        <td>{{ $honor->status_mengajar->status_mengajar }}</td>
                                        <td>{{ $honor->tanggal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Tidak ada data untuk pegawai ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Assign Mapel -->
    <div class="modal fade" id="assignMapelModal" tabindex="-1" role="dialog" aria-labelledby="assignMapelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignMapelModalLabel">Assign Mapel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk assign mapel -->
                    <form action="{{ route('pegawai.assign-mapel', ['pegawai' => $pegawai->id]) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="mapel_id">Pilih Mapel:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkAllMapel"
                                    onclick="checkUncheckAllMapel(this)">
                                <label class="form-check-label" for="checkAllMapel">
                                    Pilih Semua
                                </label>
                            </div>
                            @foreach ($availableMapelList as $mapel)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="mapel_id[]"
                                        value="{{ $mapel->id }}" id="mapel_{{ $mapel->id }}">
                                    <label class="form-check-label" for="mapel_{{ $mapel->id }}">
                                        {{ $mapel->nama_mapel }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Tambahkan input fields lainnya sesuai kebutuhan -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkUncheckAllMapel(checkbox) {
            var checkboxes = document.getElementsByName('mapel_id[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = checkbox.checked;
            }
        }
    </script>

    <!-- Modal Assign Tugas -->
    <div class="modal fade" id="assignTugasModal" tabindex="-1" role="dialog" aria-labelledby="assignTugasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignTugasModalLabel">Assign Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk assign tugas -->
                    <form action="{{ route('pegawai.assign-tugas', ['pegawai' => $pegawai->id]) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="tugas_id">Pilih Tugas Tambahan:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkAllTugas"
                                    onclick="checkUncheckAllTugas(this)">
                                <label class="form-check-label" for="checkAllTugas">
                                    Pilih Semua
                                </label>
                            </div>
                            @foreach ($availableTugasList as $tugas)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tugas_id[]"
                                        value="{{ $tugas->id }}" id="tugas_{{ $tugas->id }}">
                                    <label class="form-check-label" for="tugas_{{ $tugas->id }}">
                                        {{ $tugas->nama_tugas }}, {{ $tugas->honor }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Tambahkan input fields lainnya sesuai kebutuhan -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkUncheckAllTugas(checkbox) {
            var checkboxes = document.getElementsByName('tugas_id[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = checkbox.checked;
            }
        }
    </script>


    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    @endpush

    @push('scripts')
    @endpush
@endsection
