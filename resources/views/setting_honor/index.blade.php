@extends('components.layout')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Setting Honor</h4>
                        <div class="float-right">
                            <a href="{{ route('setting_honor.create') }}" class="btn btn-primary">Create Setting Honor</a>
                        </div>

                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jabatan</th>
                                        <th>Honor per Jam</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($settingHonors as $settingHonor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $settingHonor->jabatan->nama_jabatan }}</td>
                                            <td>{{ $settingHonor->honor_perjam }}</td>
                                            <td>
                                                <a href="{{ route('setting_honor.edit', $settingHonor->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <form action="{{ route('setting_honor.destroy', $settingHonor->id) }}"
                                                    method="POST" style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this setting honor?')">Delete</button>
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
    </div>
@endsection
