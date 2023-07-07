@extends('components.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Setting Honor</div>

                    <div class="card-body">
                        <form action="{{ route('setting_honor.update', $settingHonor->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="jabatan_id">Jabatan</label>
                                <select class="form-control" id="jabatan_id" name="jabatan_id">
                                    @foreach ($jabatanList as $jabatan)
                                        <option value="{{ $jabatan->id }}"
                                            {{ $jabatan->id === $settingHonor->jabatan_id ? 'selected' : '' }}>
                                            {{ $jabatan->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="honor_perjam">Honor per Jam</label>
                                <input type="number" class="form-control" id="honor_perjam" name="honor_perjam"
                                    value="{{ $settingHonor->honor_perjam }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
