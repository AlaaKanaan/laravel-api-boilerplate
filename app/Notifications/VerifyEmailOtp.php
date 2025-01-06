<?php

namespace App\Notifications;

use App\Enums\CacheKeys;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class VerifyEmailOtp extends Notification
{
    use Queueable;

    protected string $otp;

    public function __construct()
    {
        // Generate a random 6-digit OTP
        $this->otp = rand(100000, 999999);
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        // Store the OTP in cache for 10 minutes
        Cache::put(CacheKeys::OTP_KEY->value . $notifiable->id, $this->otp, now()->addMinutes(10));

        return (new MailMessage)
            ->subject(__('notifications.email_verification_subject'))
            ->line(__('notifications.email_verification_line', ['otp' => $this->otp]))
            ->line(__('notifications.email_verification_expiry', ['minutes' => 10]))
            ->line(__('notifications.email_verification_ignore'));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
