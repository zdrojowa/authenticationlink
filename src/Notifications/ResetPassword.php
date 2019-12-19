<?php

namespace Zdrojowa\AuthenticationLink\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Username for user.
     *
     * @var string
     */
    public $name;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $username)
    {
        $this->token = $token;
        $this->name = $username;
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
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('general.reset_password_subject'))
            ->greeting(trans('general.reset_password_greeting', ['username' => $this->name]))
            ->line(trans('general.reset_password_line1'))
            ->action(trans('general.reset_password'), url('password/reset', $this->token))
            ->line(trans('general.reset_password_line2'));
    }
}
