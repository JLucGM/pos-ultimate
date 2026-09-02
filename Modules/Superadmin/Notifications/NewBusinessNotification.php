<?php

namespace Modules\Superadmin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBusinessNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($business)
    {
        $this->business = $business;
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
        $first_location = $this->business->locations->first();
        $mobile = !empty($first_location) ? $first_location->mobile : ($this->business->owner->contact_no ?? 'N/A');

        return (new MailMessage)
                ->subject('Nuevo Registro de Empresa - ' . config('app.name'))
                ->greeting('¡Hola!')
                ->line('Se ha registrado una nueva empresa exitosamente en la plataforma:')
                ->line('Empresa: ' . $this->business->name)
                ->line('Propietario: ' . $this->business->owner->user_full_name)
                ->line('Correo: ' . $this->business->owner->email)
                ->line('Teléfono de Contacto: ' . $mobile)
                ->salutation('Saludos cordiales, Equipo de ' . config('app.name'));
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
