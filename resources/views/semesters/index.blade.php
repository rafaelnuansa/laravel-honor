@extends('components.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Semester List</h4>
                        <a href="{{ route('semesters.create') }}" class="btn btn-primary float-right">Add Semester</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Semesters</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semesters as $semester)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $semester->nama }}</td>
                                        <td>{{ $semester->tanggal_mulai }}</td>
                                        <td>{{ $semester->tanggal_selesai }}</td>
                                        <td>
                                            @if (!$semester->aktif)
                                                <form action="{{ route('semesters.setActive', $semester->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Set Active</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('semesters.edit', $semester->id) }}"
                                                class="btn btn-primary">Edit</a>

                                            <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
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
