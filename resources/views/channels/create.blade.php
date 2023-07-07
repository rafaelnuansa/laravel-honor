@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Channel</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('channels.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Channel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
