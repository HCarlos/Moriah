<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MyResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $token;
    public static $toMailCallback;

    public function __construct($token)
    {
        $this->token = $token;
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
        try{
            if (static::$toMailCallback) {
                return call_user_func(static::$toMailCallback, $notifiable, $this->token);
            }

            return (new MailMessage)
                ->subject('Recuperar contraseña')
                ->greeting('Hola bb!')
                ->line('Estás recibiendo este correo porque hiciste una solicitud de recuperación de contraseña para tu cuenta.')
                ->action('Recuperar contraseña', route('password.reset', $this->token))
                ->line('Si no realizaste esta solicitud, no se requiere realizar ninguna otra acción.')
                ->salutation('Saludos, '. config('app.name'))
                ;

        }catch (HttpException $e){
            dd($e);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
