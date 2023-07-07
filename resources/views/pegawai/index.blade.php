@extends('components.layout', ['title' => 'Pegawai'])

@section('content')
    <div class="card">
        <div class="card-header">
           <h4> Pegawai List</h4>

           <div class="btn-group float-right">
            <a href="{{ route('pegawai.create') }}" class="btn btn-outline-dark btn-icon"><i class="feather icon-plus-square"></i> Create Pegawai</a>
            <a href="{{ route('pegawai.export') }}" class="btn btn-dark btn-icon"><i class="feather icon-download"></i> Export</a>
        </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pegawai</th>
                        <th>Kode Pegawai</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawaiList as $pegawai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pegawai->nama_pegawai }}</td>
                            <td>{{ $pegawai->kode_pegawai }}</td>
                            <td>{{ $pegawai->jabatan->nama_jabatan }}</td>
                            <td>
                                <form id="delete-form-{{ $pegawai->id }}" action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-icon">
                                        <i class="feather icon-eye"></i>
                                    </a>

                                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-icon">
                                        <i class="feather icon-edit"></i>
                                    </a>

                                    <button type="button" class="btn btn-icon" onclick="deletePegawai({{ $pegawai->id }})">
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
@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan sweet alert confirm
    function deletePegawai(pegawaiId) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus pegawai ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengklik "Ya, Hapus", submit form delete
                document.getElementById('delete-form-' + pegawaiId).submit();
            }
        });
    }
</script>
@endpush
