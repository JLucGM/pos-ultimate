<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Retrives notification template from database
     *
     * @param  int  $business_id
     * @param  string  $template_for
     * @return array $template
     */
    public static function getTemplate($business_id, $template_for)
    {
        $notif_template = NotificationTemplate::where('business_id', $business_id)
                                                        ->where('template_for', $template_for)
                                                        ->first();
        $template = [
            'subject' => ! empty($notif_template->subject) ? $notif_template->subject : '',
            'sms_body' => ! empty($notif_template->sms_body) ? $notif_template->sms_body : '',
            'whatsapp_text' => ! empty($notif_template->whatsapp_text) ? $notif_template->whatsapp_text : '',
            'email_body' => ! empty($notif_template->email_body) ? $notif_template->email_body
                             : '',
            'template_for' => $template_for,
            'cc' => ! empty($notif_template->cc) ? $notif_template->cc : '',
            'bcc' => ! empty($notif_template->bcc) ? $notif_template->bcc : '',
            'auto_send' => ! empty($notif_template->auto_send) ? 1 : 0,
            'auto_send_sms' => ! empty($notif_template->auto_send_sms) ? 1 : 0,
            'auto_send_wa_notif' => ! empty($notif_template->auto_send_wa_notif)
             ? 1 : 0,
        ];

        return $template;
    }

    public static function customerNotifications()
    {
        return [
            'new_sale' => [
                'name' => __('lang_v1.new_sale'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{invoice_number}', '{invoice_url}', '{total_amount}', '{paid_amount}', '{due_amount}', '{cumulative_due_amount}', '{due_date}'],
                    ['{location_name}', '{location_address}', '{location_email}', '{location_phone}', '{location_custom_field_1}', '{location_custom_field_2}', '{location_custom_field_3}', '{location_custom_field_4}'],
                    ['{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                    ['{sell_custom_field_1}', '{sell_custom_field_2}', '{sell_custom_field_3}', '{sell_custom_field_4}'],
                    ['{shipping_custom_field_1}', '{shipping_custom_field_2}', '{shipping_custom_field_3}', '{shipping_custom_field_4}', '{shipping_custom_field_5}'],
                ],
            ],
            'payment_received' => [
                'name' => __('lang_v1.payment_received'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{invoice_number}', '{payment_ref_number}', '{received_amount}'],
                    ['{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                ],
            ],
            'payment_reminder' => [
                'name' => __('lang_v1.payment_reminder'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{invoice_number}', '{due_amount}', '{cumulative_due_amount}', '{due_date}'],
                    ['{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],

                ],
            ],
            'new_booking' => [
                'name' => __('lang_v1.new_booking'),
                'extra_tags' => self::bookingNotificationTags(),
            ],
            'new_quotation' => [
                'name' => __('lang_v1.new_quotation'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{invoice_number}', '{total_amount}', '{quote_url}'],
                    ['{location_name}', '{location_address}', '{location_email}', '{location_phone}', '{location_custom_field_1}', '{location_custom_field_2}', '{location_custom_field_3}', '{location_custom_field_4}'],
                    ['{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],

                ],
            ],
        ];
    }

    public static function generalNotifications()
    {
        return [
            'send_ledger' => [
                'name' => __('lang_v1.send_ledger'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{balance_due}'],
                    ['{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                ],
            ],
        ];
    }

    public static function supplierNotifications()
    {
        return [
            'new_order' => [
                'name' => __('lang_v1.new_order'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{order_ref_number}', '{total_amount}', '{received_amount}', '{due_amount}'],
                    ['{location_name}', '{location_address}', '{location_email}', '{location_phone}', '{location_custom_field_1}', '{location_custom_field_2}', '{location_custom_field_3}', '{location_custom_field_4}'],
                    ['{purchase_custom_field_1}', '{purchase_custom_field_2}', '{purchase_custom_field_3}', '{purchase_custom_field_4}', '{contact_business_name}'],
                    ['{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                    ['{shipping_custom_field_1}', '{shipping_custom_field_2}', '{shipping_custom_field_3}', '{shipping_custom_field_4}', '{shipping_custom_field_5}'],
                ],
            ],
            'payment_paid' => [
                'name' => __('lang_v1.payment_paid'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{order_ref_number}', '{payment_ref_number}', '{paid_amount}'],
                    ['{contact_name}', '{contact_business_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                ],
            ],
            'items_received' => [
                'name' => __('lang_v1.items_received'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{order_ref_number}'],
                    ['{contact_business_name}', '{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                ],
            ],
            'items_pending' => [
                'name' => __('lang_v1.items_pending'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{order_ref_number}'],
                    ['{contact_business_name}', '{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                ],
            ],

            'purchase_order' => [
                'name' => __('lang_v1.purchase_order'),
                'extra_tags' => [
                    ['{business_name}', '{business_logo}'],
                    ['{order_ref_number}'],
                    ['{contact_business_name}', '{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
                ],
            ],
        ];
    }

    public static function notificationTags()
    {
        return ['{contact_name}', '{invoice_number}', '{total_amount}',
            '{paid_amount}', '{due_amount}', '{business_name}', '{business_logo}', '{cumulative_due_amount}', '{due_date}', '{contact_business_name}', ];
    }

    public static function bookingNotificationTags()
    {
        return [
            ['{business_name}', '{business_logo}'],
            ['{table}', '{start_time}', '{end_time}', '{service_staff}', '{correspondent}'],
            ['{location}', '{location_name}', '{location_address}', '{location_email}', '{location_phone}', '{location_custom_field_1}', '{location_custom_field_2}', '{location_custom_field_3}', '{location_custom_field_4}'],
            ['{contact_name}', '{contact_custom_field_1}', '{contact_custom_field_2}', '{contact_custom_field_3}', '{contact_custom_field_4}', '{contact_custom_field_5}', '{contact_custom_field_6}', '{contact_custom_field_7}', '{contact_custom_field_8}', '{contact_custom_field_9}', '{contact_custom_field_10}'],
        ];
    }

    public static function defaultNotificationTemplates($business_id = null)
    {
        $notification_template_data = [
            [
                'business_id' => $business_id,
                'template_for' => 'new_sale',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Su número de factura es {invoice_number}<br />
                    Monto total: {total_amount}<br />
                    Monto pagado: {received_amount}</p>

                    <p>Gracias por su preferencia y por comprar con nosotros.</p>

                    <p>{business_logo}</p>

                    <p>&nbsp;</p>',
                'sms_body' => 'Estimado(a) {contact_name}, gracias por su compra. Factura: {invoice_number}, Total: {total_amount}. {business_name}',
                'subject' => 'Gracias por su compra en {business_name}',
                'auto_send' => '0',
            ],

            [
                'business_id' => $business_id,
                'template_for' => 'payment_received',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                <p>Hemos recibido su pago por un monto de {received_amount}.</p>

                <p>Gracias por su puntualidad.</p>

                <p>{business_logo}</p>',
                'sms_body' => 'Estimado(a) {contact_name}, hemos recibido su pago de {received_amount}. {business_name}',
                'subject' => 'Comprobante de Pago Recibido - {business_name}',
                'auto_send' => '0',
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'payment_reminder',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Le recordamos cordialmente que tiene un saldo pendiente de {due_amount}. Le agradecemos realizar su pago a la brevedad posible.</p>

                    <p>{business_logo}</p>',
                'sms_body' => 'Estimado(a) {contact_name}, le recordamos que tiene un saldo pendiente de {due_amount}. {business_name}',
                'subject' => 'Recordatorio de Pago Pendiente - {business_name}',
                'auto_send' => '0',
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'new_booking',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Su reserva ha sido confirmada exitosamente.</p>

                    <p>Horario: {start_time} a {end_time}</p>

                    <p>Mesa: {table}</p>

                    <p>Ubicación: {location}</p>

                    <p>{business_logo}</p>',
                'sms_body' => 'Estimado(a) {contact_name}, su reserva está confirmada. Horario: {start_time} a {end_time}, Mesa: {table}, Ubicación: {location}. {business_name}',
                'subject' => 'Reserva Confirmada - {business_name}',
                'auto_send' => '0',
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'new_order',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Hemos generado un nuevo pedido con el número de referencia {order_ref_number}. Por favor procesar los productos a la brevedad.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'Estimado(a) {contact_name}, nuevo pedido con referencia {order_ref_number}. {business_name}',
                'subject' => 'Nuevo Pedido - {business_name}',
                'auto_send' => '0',
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'payment_paid',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Hemos emitido un pago por {paid_amount} correspondiente a la factura {order_ref_number}.<br />
                    Por favor tomar nota del registro.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'Hemos emitido el pago de {paid_amount} para la factura {order_ref_number}. {business_name}',
                'subject' => 'Pago Realizado - {business_name}',
                'auto_send' => '0',
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'items_received',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Hemos recibido satisfactoriamente todos los artículos de la factura {order_ref_number}. Muchas gracias por su gestión.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'Hemos recibido todos los artículos de la factura {order_ref_number}. Muchas gracias. {business_name}',
                'subject' => 'Artículos Recibidos - {business_name}',
                'auto_send' => '0',
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'items_pending',
                'email_body' => '<p>Estimado(a) {contact_name},<br />
                    Le informamos que aún tenemos artículos pendientes por recibir correspondientes a la referencia {order_ref_number}. Por favor procesar su envío a la brevedad.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'Recordatorio: artículos pendientes por recibir de la referencia {order_ref_number}. Por favor verificar. {business_name}',
                'subject' => 'Artículos Pendientes de Entrega - {business_name}',
                'auto_send' => '0',
            ],

            [
                'business_id' => $business_id,
                'template_for' => 'new_quotation',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Adjunto encontrará su cotización número {invoice_number}<br />
                    Monto total: {total_amount}</p>

                    <p>Quedamos a su entera disposición para cualquier consulta.</p>

                    <p>{business_logo}</p>

                    <p>&nbsp;</p>',
                'sms_body' => 'Estimado(a) {contact_name}, cotización número {invoice_number}, Total: {total_amount}. {business_name}',
                'subject' => 'Cotización {invoice_number} - {business_name}',
                'auto_send' => '0',
            ],
            [
                'business_id' => $business_id,
                'template_for' => 'purchase_order',
                'email_body' => '<p>Estimado(a) {contact_name},</p>

                    <p>Hemos emitido una nueva orden de compra con el número de referencia {order_ref_number}. Encontrará la orden adjunta a este correo.</p>

                    <p>{business_logo}</p>',
                'sms_body' => 'Nueva orden de compra con referencia {order_ref_number}. {business_name}',
                'subject' => 'Orden de Compra - {business_name}',
                'auto_send' => '0',
            ],
        ];

        return $notification_template_data;
    }
}
