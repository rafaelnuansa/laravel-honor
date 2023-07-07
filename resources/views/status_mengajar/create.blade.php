@extends('components.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Status Mengajar</h4>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('status_mengajar.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="status_mengajar">Status Mengajar</label>
                                <input type="text" name="status_mengajar" id="status_mengajar" class="form-control" value="{{ old('status_mengajar') }}" required>
                                @error('status_mengajar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('status_mengajar.index') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
