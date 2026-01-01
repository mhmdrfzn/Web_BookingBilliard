<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Tentukan pesan berdasarkan status
        $status = ucfirst($this->booking->status); // Jadi "Approved" atau "Rejected"
        $color  = $this->booking->status == 'approved' ? 'success' : 'error';
        $message = $this->booking->status == 'approved' 
                    ? 'Hore! Booking Anda telah disetujui. Silakan datang tepat waktu.' 
                    : 'Maaf, Booking Anda ditolak karena jadwal penuh atau alasan lain.';

        return (new MailMessage)
                    ->subject('Status Booking: ' . $status)
                    ->greeting('Halo, ' . $notifiable->name)
                    ->line('Status booking meja biliar Anda telah diperbarui menjadi: **' . $status . '**')
                    ->line('Detail: Meja ' . $this->booking->table_number . ' pada ' . $this->booking->start_time)
                    ->line($message) // Pesan khusus
                    ->action('Lihat Detail', route('my-bookings')) // Link ke halaman customer
                    ->line('Terima kasih telah bermain di tempat kami!');
    }
}