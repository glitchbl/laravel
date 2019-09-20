<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordBase
{
    public $user;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @param  \App\Client|\App\Admin  $user
     * @return void
     */
    public function __construct($token, $user)
    {
        parent::__construct($token);
        $this->user = $user;
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $route = 'password.reset';
        $is_admin = false;

        if ($this->user instanceof \App\Admin) {
            $is_admin = true;
            $route = "admin.{$route}";
        }

        $token = $this->token;
        $email = $this->user->email;

        return (new MailMessage)
            ->subject(config('app.name') . ($is_admin? ' Administration': '') . ' - Réinitialisation de votre mot de passe')
            ->line('Vous recevez cet e-mail suite à une demande de réinitialisation du mot de passe de votre compte.')
            ->action('Réinitialiser votre mot de passe', url(config('app.url').route($route, compact('token', 'email'), false)))
            ->line('Si vous n’avez pas demandé à réinitialiser votre mot de passe, ne prenez pas en compte cet e-mail.');
    }
}
