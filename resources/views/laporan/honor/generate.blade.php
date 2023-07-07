@extends('components.layout', ['title' => 'Laporan Honor'])

@section('content')
    <div class="container">
        <h2 class="mt-4 mb-3">Laporan Honor Bulan {{ $namaBulan }} {{ $tahun }}</h2>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pegawai</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jumlah Honor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($honor as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $item->pegawai->nama }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Honor</th>
                    <th>{{ $totalHonor }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
