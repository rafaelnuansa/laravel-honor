@extends('components.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Other Payment</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('otherpayment.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="pegawai_id">Pegawai</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-control">
                                    @foreach ($pegawaiList as $pegawai)
                                        <option value="{{ $pegawai->id }}"
                                            {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->nama_pegawai }}</option>
                                    @endforeach
                                </select>
                                @error('pegawai_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nama_payment">Nama Pembayaran</label>
                                <input type="text" name="nama_payment" id="nama_payment" class="form-control" value="{{ old('pegawai_id') }}">
                                @error('pegawai_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div id="kegiatan-fields">
                                <div class="row kegiatan-field">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kegiatan_id[]">Kegiatan</label>
                                            <select name="kegiatan_id[]" class="form-control">
                                                @foreach ($kegiatanList as $kegiatan)
                                                    <option value="{{ $kegiatan->id }}">
                                                        {{ $kegiatan->nama_kegiatan }} - {{ $kegiatan->honor }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kegiatan_id[]')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="qty[]">Quantity</label>
                                            <input type="number" name="qty[]" class="form-control"
                                                value="{{ old('qty[]') }}" required>
                                            @error('qty[]')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-kegiatan" class="btn btn-secondary">Tambah Kegiatan</button>

                            <div class="form-group">
                                <label for="tgl_payment">Tanggal Payment</label>
                                <input type="date" name="tgl_payment" id="tgl_payment" class="form-control"
                                    value="{{ old('tgl_payment') }}" required>
                                @error('tgl_payment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="channel_id">Channel</label>
                                <select name="channel_id" id="channel_id" class="form-control">
                                    @foreach ($channelList as $channel)
                                        <option value="{{ $channel->id }}"
                                            {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->nama }}</option>
                                    @endforeach
                                </select>
                                @error('channel_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('otherpayment.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var kegiatanFields = document.getElementById('kegiatan-fields');
                var addKegiatanButton = document.getElementById('add-kegiatan');

                addKegiatanButton.addEventListener('click', function() {
                    var kegiatanField = document.createElement('div');
                    kegiatanField.className = 'row kegiatan-field';

                    var kegiatanCol = document.createElement('div');
                    kegiatanCol.className = 'col-md-6';

                    var kegiatanSelect = document.createElement('select');
                    kegiatanSelect.name = 'kegiatan_id[]';
                    kegiatanSelect.className = 'form-control';

                    @foreach ($kegiatanList as $kegiatan)
                        var kegiatanOption = document.createElement('option');
                        kegiatanOption.value = '{{ $kegiatan->id }}';
                        kegiatanOption.textContent =
                            '{{ $kegiatan->nama_kegiatan }} - {{ $kegiatan->honor }}';
                        kegiatanSelect.appendChild(kegiatanOption);
                    @endforeach

                    kegiatanCol.appendChild(kegiatanSelect);

                    var qtyCol = document.createElement('div');
                    qtyCol.className = 'col-md-6';

                    var qtyInput = document.createElement('input');
                    qtyInput.type = 'number';
                    qtyInput.name = 'qty[]';
                    qtyInput.className = 'form-control';
                    qtyInput.required = true;

                    qtyCol.appendChild(qtyInput);

                    var removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'btn btn-danger btn-sm mb-1';
                    removeButton.textContent = 'Hapus';
                    removeButton.addEventListener('click', function() {
                        kegiatanField.remove();
                    });

                    var actionCol = document.createElement('div');
                    actionCol.className = 'col-md-2 mt-2';
                    actionCol.appendChild(removeButton);

                    kegiatanField.appendChild(kegiatanCol);
                    kegiatanField.appendChild(qtyCol);
                    kegiatanField.appendChild(actionCol);
                    kegiatanFields.appendChild(kegiatanField);

                });

            });
        </script>
    @endpush
@endsection
