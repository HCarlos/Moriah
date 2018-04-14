<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use PharIo\Manifest\InvalidEmailException;

class MyResetPassword extends ResetPassword
{
    public $token;
    public static $toMailCallback;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toMail($notifiable)
    {
        try{
            if (static::$toMailCallback) {
                return call_user_func(static::$toMailCallback, $notifiable, $this->token);
            }

            return (new MailMessage)
                ->subject('Recuperar contraseña')
                ->greeting('Hola')
                ->line('Estás recibiendo este correo porque hiciste una solicitud de recuperación de contraseña para tu cuenta.')
                ->action('Recuperar contraseña', route('password.reset', $this->token))
                ->line('Si no realizaste esta solicitud, no se requiere realizar ninguna otra acción.')
                ->salutation('Saludos, '. config('app.name'));

        }catch (HttpException $e){
            dd($e);
        }

    }

}