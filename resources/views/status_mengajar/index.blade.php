@extends('components.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Status Mengajar</h4>
                        <a href="{{ route('status_mengajar.create') }}" class="btn btn-outline-dark float-right"><i class="feather icon-plus"></i> Tambah Status KBM</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Status Mengajar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statusMengajars as $statusMengajar)
                                    <tr>
                                        <td>{{ $statusMengajar->id }}</td>
                                        <td>{{ $statusMengajar->status_mengajar }}</td>
                                        <td>
                                            <a href="{{ route('status_mengajar.edit', $statusMengajar->id) }}"
                                                class="btn btn-icon"><i class="feather icon-edit"></i></a>
                                            <form action="{{ route('status_mengajar.destroy', $statusMengajar->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon"
                                                    onclick="return confirm('Are you sure you want to delete this item?')"><i class="feather icon-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $statusMengajars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
