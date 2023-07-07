@extends('components.layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Kelas</div>

                    <div class="card-body">
                        <form action="{{ route('kelas.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="nama_kelas">Nama Kelas:</label>
                                <input type="text" name="nama_kelas" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
