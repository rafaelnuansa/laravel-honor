@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit User</div>

                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control select2" id="username" name="username"
                                    value="{{ $user->username }}" required>
                            </div>

                            <div class="form-group">
                                <label for="level">Level</label>
                                <select class="form-control" id="level" name="level" required>
                                    <option value="Administrator"
                                        {{ $user->level === 'Administrator' ? 'selected' : '' }}>Administrator
                                    </option>
                                    <option value="Bendahara" {{ $user->level === 'Bendahara' ? 'selected' : '' }}>
                                        Bendahara</option>
                                    <option value="Operator" {{ $user->level === 'Operator' ? 'selected' : '' }}>
                                        Operator</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <button type="submit" class="btn btn-primary">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
