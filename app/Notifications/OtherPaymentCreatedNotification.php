<?php

namespace App\Notifications;

use App\Models\OtherPayment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtherPaymentCreatedNotification extends Notification
{
    use Queueable;

    protected $otherPayment;

    /**
     * Create a new notification instance.
     */
    public function __construct(OtherPayment $otherPayment)
    {
        $this->otherPayment = $otherPayment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        $otherPayment = $this->otherPayment; // Mengambil data pembayaran dari properti class

        return [
            'pegawai_id' => $notifiable->id,
            'title' => 'Pencairan ' . $otherPayment->nama_payment,
            'content' => $otherPayment->total_payment . ' telah dicairkan melalui ' . $otherPayment->channel->nama,
            'read' => false,
        ];
    }

    public function toArray($notifiable)
    {
        $otherPayment = $this->otherPayment; // Mengambil data pembayaran dari properti class
        return [
            'pegawai_id' => $notifiable->id,
            'title' => 'Pencairan ' . $otherPayment->nama_payment,
            'content' => $otherPayment->total_payment . ' telah dicairkan melalui ' . $otherPayment->channel->nama,
            'read' => false,
        ];
    }

}
