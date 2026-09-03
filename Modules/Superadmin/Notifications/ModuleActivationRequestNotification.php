<?php

namespace Modules\Superadmin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModuleActivationRequestNotification extends Notification
{
    use Queueable;

    public $business;
    public $user;
    public $module_key;
    public $module_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($business, $user, $module_key, $module_name)
    {
        $this->business = $business;
        $this->user = $user;
        $this->module_key = $module_key;
        $this->module_name = $module_name;
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
        $business_location = $this->business->locations->first();
        $contact_number = !empty($business_location) ? $business_location->mobile : ($this->user->contact_no ?? 'N/A');

        return (new MailMessage)
                ->subject('Solicitud de Activación de Módulo: ' . $this->module_name . ' - ' . $this->business->name)
                ->greeting('¡Hola Superadministrador!')
                ->line('El siguiente cliente ha solicitado la activación de un módulo en su sistema:')
                ->line('• Módulo Solicitado: ' . $this->module_name)
                ->line('• Empresa: ' . $this->business->name)
                ->line('• Solicitante / Propietario: ' . $this->user->user_full_name)
                ->line('• Correo Electrónico: ' . $this->user->email)
                ->line('• Teléfono: ' . $contact_number)
                ->action('Ver y Administrar Empresa', url('/superadmin/business/' . $this->business->id))
                ->line('Puedes habilitarle este módulo de forma directa desde la pestaña de gestión de la empresa.')
                ->salutation('Saludos cordiales, Plataforma ' . config('app.name'));
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
