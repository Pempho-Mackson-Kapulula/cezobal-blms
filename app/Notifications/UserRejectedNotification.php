<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRejectedNotification extends Notification
{
    use Queueable;

    protected string $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $reason = '')
    {
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Your Account Has Been Rejected')
            ->greeting("Hello {$notifiable->name},")
            ->line('We regret to inform you that your account has been rejected.');

        if (!empty($this->reason)) {
            $mail->line('Reason: ' . $this->reason);
        }

        $mail->line('If you believe this is a mistake, please contact the admin.');

        return $mail;
    }
}
