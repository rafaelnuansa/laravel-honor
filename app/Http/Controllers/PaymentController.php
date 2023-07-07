<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Honor;
use App\Models\Jabatan;
use App\Models\Notif;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Pegawai;
use App\Models\PegawaiTugas;
use Carbon\Carbon;
use App\Notifications\PaymentCreatedNotification; // Import the notification class


class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderBy('tanggal_bayar', 'desc')->paginate(10);
        return view('payment.index', compact('payments'));
    }
    public function show(Payment $payment)
    {
        $pegawai = Pegawai::findOrFail($payment->pegawai_id);
        $pegawaiId = $pegawai->id;
        $bulan = Carbon::parse($payment->bulan)->format('Y-m');
        $totalJtm = Honor::where('pegawai_id', $pegawaiId)
            ->whereDate('tanggal', 'LIKE', $bulan . '%')
            ->sum('jtm');

        $totalHonor = Honor::where('pegawai_id', $pegawaiId)
            ->whereMonth('tanggal', Carbon::parse($payment->bulan)->format('m'))
            ->whereYear('tanggal', Carbon::parse($payment->bulan)->format('Y'))
            ->sum('jumlah');

        return view('payment.show', compact('payment', 'pegawai', 'totalJtm', 'totalHonor'));
    }

    public function create()
    {
        $pegawaiList = Pegawai::all();
        $jabatanList = Jabatan::all();
        $channelList = Channel::all();
        return view('payment.create', compact('pegawaiList', 'jabatanList', 'channelList'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'pegawai_id' => 'required',
        ]);

        $payment = new Payment();
        $payment->pegawai_id = $request->pegawai_id;

        $pegawaiId = $request->pegawai_id;
        // Mengambil objek Pegawai
        $pegawai = Pegawai::find($pegawaiId);

        if ($pegawai) {
            // Mengambil jabatan dari pegawai
            $jabatan_id = $pegawai->jabatan_id;
            $payment->jabatan_id = $jabatan_id;
        }
        $year = date('Y');
        $uniqRand = substr(str_shuffle(str_repeat('0123456789', 3)), 0, 3);
        $kodePayment = 'PAY' . $year . $uniqRand;

        $payment->kode_bayar = $kodePayment;
        $payment->bulan = $request->bulan;
        $payment->tanggal_bayar = $request->tanggal_bayar;
        $bulan = Carbon::parse($request->bulan)->format('Y-m');
        $totalJtm = Honor::where('pegawai_id', $pegawaiId)
            ->whereDate('tanggal', 'LIKE', $bulan . '%')
            ->sum('jtm');

        $totalHonor = Honor::where('pegawai_id', $pegawaiId)
            ->whereMonth('tanggal', Carbon::parse($request->bulan)->format('m'))
            ->whereYear('tanggal', Carbon::parse($request->bulan)->format('Y'))
            ->sum('jumlah');
        $payment->total_jtm = $totalJtm;
        $payment->total_honor = $totalHonor;


        $tugas = PegawaiTugas::with('tugas')->where('pegawai_id', $pegawaiId)->get();
        $tugasData = [];

        foreach ($tugas as $tugasItem) {
            $tugasData[] = [
                'tugas_id' => $tugasItem->tugas_id,
                'nama_tugas' => $tugasItem->tugas->nama_tugas,
                'honor' => $tugasItem->tugas->honor,
            ];
        }

        $payment->tugas_honor = json_encode($tugasData);
        $totalTugasHonor = collect($tugasData)->sum('honor');
        $totalHonor = $totalHonor + $totalTugasHonor;
        $koperasi = $request->koperasi;

        if ($totalHonor < $koperasi) {
            return redirect()->back()->with('error', 'Payroll tidak dapat kurang dari koperasi.');
        }

        $payment->payroll = $totalHonor;
        $payment->koperasi = $koperasi;
        $payment->total_bersih = $totalHonor - $koperasi;
        $payment->channel_id = $request->channel_id;
        $payment->save();


        if ($pegawai) {
            $pegawai->notify(new PaymentCreatedNotification($payment));
        }
        return redirect()->route('payment.index')->with('success', 'Payment created successfully.');
    }


    public function edit($id)
    {
        $payment = Payment::find($id);
        $pegawaiList = Pegawai::all(); // Ambil data pegawai dari database
        $jabatanList = Jabatan::all(); // Ambil data jabatan dari database

        $channelList = Channel::all();
        return view('payment.edit', compact('payment', 'pegawaiList', 'jabatanList', 'channelList'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = $request->validate([
                'pegawai_id' => 'required',
            ]);

            $payment = Payment::findOrFail($id);
            $payment->pegawai_id = $request->pegawai_id;

            $pegawaiId = $request->pegawai_id;
            // Mengambil objek Pegawai
            $pegawai = Pegawai::find($pegawaiId);

            if ($pegawai) {
                // Mengambil jabatan dari pegawai
                $jabatan_id = $pegawai->jabatan_id;
                $payment->jabatan_id = $jabatan_id;
            }

            $year = date('Y');
            $uniqRand = substr(str_shuffle(str_repeat('0123456789', 3)), 0, 3);
            $kodePayment = 'PAY' . $year . $uniqRand;

            $payment->kode_bayar = $kodePayment;
            $payment->bulan = $request->bulan;
            $payment->tanggal_bayar = $request->tanggal_bayar;
            $bulan = Carbon::parse($request->bulan)->format('Y-m');
            $totalJtm = Honor::where('pegawai_id', $pegawaiId)
                ->whereDate('tanggal', 'LIKE', $bulan . '%')
                ->sum('jtm');

            $totalHonor = Honor::where('pegawai_id', $pegawaiId)
                ->whereMonth('tanggal', Carbon::parse($request->bulan)->format('m'))
                ->whereYear('tanggal', Carbon::parse($request->bulan)->format('Y'))
                ->sum('jumlah');

            $tugas = PegawaiTugas::with('tugas')->where('pegawai_id', $pegawaiId)->get();
            $tugasData = $tugas->map(function ($tugasItem) {
                return [
                    'tugas_id' => $tugasItem->tugas_id,
                    'nama_tugas' => $tugasItem->tugas->nama_tugas,
                    'honor' => $tugasItem->tugas->honor,
                ];
            });

            $totalTugasHonor = $tugasData->sum('honor');
            $totalHonor += $totalTugasHonor;
            $koperasi = $request->koperasi;

            if ($totalHonor < $koperasi) {
                return redirect()->back()->with('error', 'Payroll tidak dapat kurang dari koperasi.');
            }

            $payment->total_jtm = $totalJtm;
            $payment->total_honor = $totalHonor;
            $payment->tugas_honor = $tugasData;
            $payment->payroll = $totalHonor;
            $payment->koperasi = $koperasi;
            $payment->total_bersih = $totalHonor - $koperasi;
            $payment->channel_id = $request->channel_id;
            $payment->save();

            return redirect()->route('payment.index')->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }




    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();

        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully.');
    }
    public function getTotalHonor(Request $request)
    {
        $pegawaiId = $request->pegawai_id;
        $bulan = $request->bulan;

        if (empty($bulan)) {
            $bulan = now()->format('Y-m');
        }

        $totalHonor = Honor::where('pegawai_id', $pegawaiId)
            ->whereMonth('tanggal', Carbon::parse($bulan)->format('m'))
            ->whereYear('tanggal', Carbon::parse($bulan)->format('Y'))
            ->sum('jumlah');

        return response()->json(['total_honor' => $totalHonor]);
    }

    public function getTugasHonor(Request $request)
    {
        $pegawaiId = $request->pegawai_id;
        // Mengambil semua tugas dengan relasi ke pegawai_id
        $tugas = PegawaiTugas::with('tugas')->where('pegawai_id', $pegawaiId)->get();

        // Menghitung total honor dari semua tugas
        $totalTugasHonor = $tugas->sum(function ($tugas) {
            return $tugas->tugas->honor;
        });


        return response()->json(['total_tugas_honor' => $totalTugasHonor]);
    }
}
