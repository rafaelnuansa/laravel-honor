<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\OtherPayment;
use App\Models\OtherPaymentItem;
use App\Models\Pegawai;
use App\Notifications\OtherPaymentCreatedNotification;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class OtherPaymentController extends Controller
{
    public function index()
    {
        $otherPayments = OtherPayment::orderByDesc('tgl_payment')->paginate(15);
        return view('otherpayment.index', compact('otherPayments'));
    }

    public function create()
    {
        $channelList = Channel::all();
        $pegawaiList = Pegawai::all();
        $kegiatanList = Kegiatan::all();

        return view('otherpayment.create', compact('pegawaiList', 'channelList', 'kegiatanList'));
    }
    public function store(Request $request)
    {
        try {
            // Generate the kode_payment automatically
            $year = date('Y');
            $uniqRand = substr(str_shuffle(str_repeat('0123456789', 3)), 0, 3);
            $kodePayment = 'PAY' . $year . $uniqRand;

            DB::beginTransaction(); // Mulai transaksi

            // Simpan data pada tabel OtherPayment
            $otherPayment = new OtherPayment;
            $otherPayment->pegawai_id = $request->pegawai_id;
            $otherPayment->kode_payment = $kodePayment;
            $otherPayment->nama_payment = $request->nama_payment;
            $otherPayment->tgl_payment = $request->tgl_payment;
            $otherPayment->channel_id = $request->channel_id;
            $otherPayment->save(); // Simpan OtherPayment terlebih dahulu untuk mendapatkan ID

            $totalPayment = 0; // Inisialisasi variabel totalPayment
            $otherPaymentItems = $request->input('qty');
            foreach ($otherPaymentItems as $index => $qty) {
                $kegiatanId = $request->input('kegiatan_id')[$index];
                $kegiatan = Kegiatan::find($kegiatanId);
                if ($kegiatan) {
                    $otherPaymentItem = new OtherPaymentItem();
                    $otherPaymentItem->kode_payment = $kodePayment;
                    $otherPaymentItem->other_payment_id = $otherPayment->id; // Tetapkan other_payment_id dengan id dari $otherPayment
                    $otherPaymentItem->kegiatan_id = $kegiatanId;
                    $otherPaymentItem->qty = $qty;
                    $otherPaymentItem->honor = $kegiatan->honor;
                    $otherPaymentItem->total_honor = $qty * $kegiatan->honor;
                    $otherPaymentItem->save(); // Simpan OtherPaymentItem
                    $totalPayment += $otherPaymentItem->total_honor; // Akumulasi nilai total honor
                } else {
                    DB::rollBack(); // Batalkan transaksi jika kegiatan tidak ditemukan
                    return back()->with('error', 'One or more kegiatan not found');
                }
            }

            $otherPayment->total_payment = $totalPayment; // Set nilai total_payment
            $otherPayment->save();

            $pegawaiId = $request->pegawai_id;

            $pegawai = Pegawai::find($pegawaiId);
            if ($pegawai) {
                $pegawai->notify(new OtherPaymentCreatedNotification($otherPayment));
            }

            DB::commit(); // Commit transaksi

            return redirect()->route('otherpayment.index')->with('success', 'Other payment added successfully');
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi kesalahan
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $otherPayment = OtherPayment::findOrFail($id);
            $otherPaymentItems = OtherPaymentItem::where('kode_payment', $otherPayment->kode_payment)->get();

            return view('otherpayment.show', compact('otherPayment', 'otherPaymentItems'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(OtherPayment $otherPayment)
    {

        $channelList = Channel::all();
        $pegawaiList = Pegawai::all();
        $kegiatanList = Kegiatan::all();
        return view('otherpayment.edit', compact('otherPayment', 'channelList', 'pegawaiList', 'kegiatanList'));
    }

    public function update(Request $request, OtherPayment $otherPayment)
    {
        try {
            DB::beginTransaction(); // Mulai transaksi

            // Update data pada tabel OtherPayment
            // $otherPayment = OtherPayment::findOrFail($other->id);
            $otherPayment->pegawai_id = $request->pegawai_id;
            $otherPayment->nama_payment = $request->nama_payment;
            $otherPayment->tgl_payment = $request->tgl_payment;
            $otherPayment->channel_id = $request->channel_id;
            $otherPayment->save();

            // Hapus semua OtherPaymentItem yang terkait dengan OtherPayment
            OtherPaymentItem::where('other_payment_id', $otherPayment->id)->delete();

            $totalPayment = 0; // Inisialisasi variabel totalPayment

            $otherPaymentItems = $request->input('qty');
            foreach ($otherPaymentItems as $index => $qty) {
                $kegiatanId = $request->input('kegiatan_id')[$index];
                $kegiatan = Kegiatan::find($kegiatanId);
                if ($kegiatan) {
                    $otherPaymentItem = new OtherPaymentItem();
                    $otherPaymentItem->other_payment_id = $otherPayment->id; // Set other_payment_id
                    $otherPaymentItem->kegiatan_id = $kegiatanId;
                    $otherPaymentItem->qty = $qty;
                    $otherPaymentItem->honor = $kegiatan->honor;
                    $otherPaymentItem->total_honor = $qty * $kegiatan->honor;
                    $otherPaymentItem->kode_payment = $otherPayment->kode_payment; // Menetapkan nilai 'kode_payment'
                    $otherPaymentItem->save();

                    $totalPayment += $otherPaymentItem->total_honor; // Akumulasi nilai total honor
                } else {
                    DB::rollBack(); // Batalkan transaksi jika kegiatan tidak ditemukan
                    return back()->with('error', 'One or more kegiatan not found');
                }
            }

            $otherPayment->total_payment = $totalPayment; // Set nilai total_payment
            $otherPayment->save();

            DB::commit(); // Commit transaksi

            return redirect()->route('otherpayment.index')->with('success', 'Other payment updated successfully');
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi kesalahan
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(OtherPayment $otherPayment)
    {
        try {
            $otherPayment->delete();
            return redirect()->route('otherpayment.index')->with('success', 'Other payment deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function printSlip($id)
    {
        $otherPayment = OtherPayment::findOrFail($id);
        $otherPaymentItems = OtherPaymentItem::where('other_payment_id', $id)->get();
        $pdf = PDF::loadView('otherpayment.invoice', ['otherPayment' => $otherPayment, 'otherPaymentItems' => $otherPaymentItems]);
        return $pdf->stream('slip_pembayaran.pdf');

        // return $pdf->download('slip_pembayaran.pdf');
    }
}
