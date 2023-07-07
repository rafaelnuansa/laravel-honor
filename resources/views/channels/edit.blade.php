@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Channel</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('channels.update', $channel->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ $channel->nama }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Channel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
