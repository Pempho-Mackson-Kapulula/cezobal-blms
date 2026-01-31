<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserApprovedNotification extends Notification
{
    use Queueable;

    public function __construct() {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your account has been approved')
                    ->greeting("Hello {$notifiable->name},")
                    ->line('Your account has been approved by the admin.')
                    ->line('You can now log in and access your dashboard.')
                    ->action('Login', url(route('login')))
                    ->line('Thank you for registering!');
    }
}
