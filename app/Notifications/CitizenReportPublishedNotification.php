<?php

namespace App\Notifications;

use App\Models\CitizenReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CitizenReportPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly CitizenReport $report)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    /**
     * Get the web push representation of the notification.
     */
    public function toWebPush(object $notifiable, Notification $notification): WebPushMessage
    {
        $anomalyLabel = match ($this->report->anomaly_type?->value ?? $this->report->anomaly_type) {
            'flood' => 'Banjir',
            'drought' => 'Kekeringan',
            'strong_wind' => 'Angin Kencang',
            default => 'Cuaca Ekstrem',
        };

        return (new WebPushMessage)
            ->title('Laporan Warga: '.$anomalyLabel)
            ->body($this->report->location.' — '.$this->report->description)
            ->icon('/icons/icon-192.png')
            ->data(['url' => '/']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
