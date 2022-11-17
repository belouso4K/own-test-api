<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyApiEmail extends Notification
{

    public function toMail($notifiable)
    {
        $url = self::verificationUrl( $notifiable );
        $name = $notifiable->name;

        return (new EmailVerification( $url, $name ) )->to( $notifiable->email );
    }

    protected function verificationUrl($notifiable)
    {
        $prefix = env('FRONTEND_URL').'/account/verify/';
        $temporarySignedUrl = URL::temporarySignedRoute('verificationapi.verify',
            Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]);
        return $prefix . '?verify_url=' . urlencode( $temporarySignedUrl );
    }

}
