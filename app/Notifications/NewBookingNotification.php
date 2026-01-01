<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    // Terima data booking saat notifikasi dipanggil
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['mail']; // Kirim via email
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Booking Baru Masuk! - Meja ' . $this->booking->table_number)
                    ->greeting('Halo Admin,')
                    ->line('Ada pesanan meja baru dari customer: ' . $this->booking->user->name)
                    ->line('Meja: ' . $this->booking->table_number)
                    ->line('Waktu: ' . $this->booking->start_time)
                    ->line('Durasi: ' . $this->booking->start_time->diffInHours($this->booking->end_time) . ' Jam')
                    ->action('Cek Dashboard', url('/admin/bookings'))
                    ->line('Segera konfirmasi pesanan ini.');
    }
}