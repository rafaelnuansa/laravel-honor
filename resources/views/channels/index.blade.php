@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Channel List</h4> <a href="{{ route('channels.create') }}" class="btn btn-outline-dark float-right"><i class="feather icon-plus"></i>Buat Channel</a>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($channels as $channel)
                                    <tr>
                                        <td>{{ $channel->id }}</td>
                                        <td>{{ $channel->nama }}</td>
                                        <td>
                                            <a href="{{ route('channels.edit', $channel->id) }}" class="btn btn-icon"><i class="feather icon-edit"></i></a>
                                            <form action="{{ route('channels.destroy', $channel->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon" onclick="return confirm('Are you sure?')"><i class="feather icon-trash"></i></button>
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
@endsection
