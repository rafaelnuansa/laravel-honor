@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Kelas List</h4>
                        <a href="{{ route('kelas.create') }}" class="btn btn-outline-dark"><i
                                class="feather icon-plus"></i>Create Kelas</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kelas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelasList as $kelas)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $kelas->nama_kelas }}</td>
                                            <td>
                                                <div class="btn-group">

                                                    <a href="{{ route('kelas.show', $kelas->id) }}" class="btn btn-icon"><i
                                                            class="feather icon-eye"></i></a>
                                                    <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-icon"><i
                                                            class="feather icon-edit"></i></a>
                                                    <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                                        style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon"><i
                                                                class="feather icon-trash"></i></button>
                                                    </form>
                                                </div>
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
@endsection
