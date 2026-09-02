<?php

namespace Modules\Superadmin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriptionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
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
        $paid_via = ! empty($this->subscription->paid_via) ? $this->subscription->paid_via : 'Gratuito / Prueba';
        $package_name = !empty($this->subscription->package) ? $this->subscription->package->name : ($this->subscription->package_details['name'] ?? 'N/A');

        return (new MailMessage)
                ->subject('Nueva Suscripción de Paquete - ' . config('app.name'))
                ->greeting('¡Hola!')
                ->line('La empresa ' . $this->subscription->business->name . ' ha activado una nueva suscripción:')
                ->line('Plan / Paquete: ' . $package_name)
                ->line('Método de Pago: ' . ucfirst($paid_via))
                ->line('ID de Transacción: ' . ($this->subscription->payment_transaction_id ?? 'N/A'))
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
