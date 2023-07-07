<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentCreatedNotification extends Notification
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // You can add other channels like 'database', 'broadcast', etc.
    }
    public function toDatabase($notifiable)
    {
        $payment = $this->payment; // Mengambil data pembayaran dari properti class
        $bulan = Carbon::parse($payment->bulan)->format('F Y');

        return [
            'pegawai_id' => $notifiable->id,
            'title' => 'Pencairan ' . $payment->kode_bayar . $bulan,
            'content' => 'Honor dengan kode bayar ' . $payment->kode_bayar . ' telah dicairkan melalui ' . $payment->channel->nama,
            'read' => false,
        ];
    }

    public function toArray($notifiable)
    {
        $payment = $this->payment; // Mengambil data pembayaran dari properti class
        $bulan = Carbon::parse($payment->bulan)->format('F Y');
        return [
            'pegawai_id' => $notifiable->id,
            'title' => 'Pencairan ' . $payment->kode_bayar . $bulan,
            'content' => 'Honor dengan kode bayar ' . $payment->kode_bayar . ' telah dicairkan melalui ' . $payment->channel->nama,
            'read' => false,
        ];
    }

}
