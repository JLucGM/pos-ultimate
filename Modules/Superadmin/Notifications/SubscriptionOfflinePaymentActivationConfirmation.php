<?php

namespace Modules\Superadmin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionOfflinePaymentActivationConfirmation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $business;
    public $package;
    public $offline_details;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($business, $package, $offline_details = [])
    {
        $this->business = $business;
        $this->package = $package;
        $this->offline_details = $offline_details;
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
        $mail = (new MailMessage)
                ->subject('Nuevo Reporte de Pago: ' . $this->business->name)
                ->greeting('¡Hola Superadministrador!')
                ->line('Se ha registrado un nuevo reporte de pago por transferencia / pago móvil:')
                ->line('- Empresa: ' . $this->business->name)
                ->line('- Plan / Paquete: ' . $this->package->name);

        if (!empty($this->offline_details['reference_no'])) {
            $mail->line('- N° de Referencia: ' . $this->offline_details['reference_no']);
        }
        if (!empty($this->offline_details['amount_paid'])) {
            $mail->line('- Monto Pagado: ' . $this->offline_details['amount_paid'] . ' ' . ($this->offline_details['currency'] ?? ''));
        }
        if (!empty($this->offline_details['bank_name'])) {
            $mail->line('- Banco Emisor: ' . $this->offline_details['bank_name']);
        }
        if (!empty($this->offline_details['phone_number'])) {
            $mail->line('- Teléfono Emisor: ' . $this->offline_details['phone_number']);
        }
        if (!empty($this->offline_details['paid_on'])) {
            $mail->line('- Fecha de Pago: ' . $this->offline_details['paid_on']);
        }
        if (!empty($this->offline_details['payment_note'])) {
            $mail->line('- Observaciones: ' . $this->offline_details['payment_note']);
        }

        return $mail->action('Ver y Aprobar Suscripción', url('/superadmin/superadmin-subscription'))
                    ->line('Por favor verifica la acreditación en la cuenta bancaria antes de aprobar la suscripción.')
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
