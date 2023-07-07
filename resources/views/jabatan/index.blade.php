@extends('components.layout', ['title' => 'Jabatan'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Daftar Jabatan</h2>
                        <a href="#" class="btn btn-outline-dark float-right waves-effect waves-light" data-toggle="modal"
                            data-target="#tambahJabatanModal">
                            <i class="feather icon-plus"></i> Tambah Jabatan
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Jabatan</th>
                                        <th>Honor Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Tampilkan data jabatan di sini -->
                                    @foreach ($jabatanList as $jabatan)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jabatan->nama_jabatan }}</td>
                                            <td>{{ $jabatan->honor_jabatan }}</td>
                                            <td>
                                                <form action="{{ route('jabatan.destroy', $jabatan->id) }}"
                                                    class="btn-group" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('jabatan.edit', $jabatan->id) }}"
                                                        class="btn btn-icon">
                                                        <i class="feather icon-edit"></i>
                                                    </a>

                                                    <button type="submit" class="btn btn-icon delete-jabatan">
                                                        <i class="feather icon-trash"></i>
                                                    </button>

                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jabatan -->
    <div class="modal fade" id="tambahJabatanModal" tabindex="-1" role="dialog" aria-labelledby="tambahJabatanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahJabatanModalLabel">Tambah Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambahkan jabatan -->
                    <form method="POST" action="{{ route('jabatan.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="nama_jabatan">Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="honor_jabatan">Honor Jabatan</label>
                            <input type="number" name="honor_jabatan" id="honor_jabatan" class="form-control" required>
                        </div>

                        <!-- Tambahkan input fields lainnya sesuai kebutuhan -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendaftarkan event click pada tombol delete dengan class delete-jabatan
            var deleteButtons = document.getElementsByClassName('delete-jabatan');
            Array.prototype.forEach.call(deleteButtons, function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var form = this.parentNode;
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Anda tidak akan dapat mengembalikan jabatan ini!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
