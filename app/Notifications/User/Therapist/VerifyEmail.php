<?php

namespace App\Notifications\User\Therapist;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->connection = 'database';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appUrl = config('app.client_url', config('app.url'));  
        $url = URL::temporarySignedRoute(
            'therapist.verify.email', 
            Carbon::now()->addMinutes(60),
            ['user_id' => $notifiable->id]
        );

        return (new MailMessage)->view(
            'notifications.user.therapist.verifyemail',
            ['user' => $notifiable, 'url' => str_replace(url('/api'), $appUrl, $url)]
        );
                    
    }

}
