<?php

namespace Database\Seeders;

use App\Business;
use App\Contact;
use App\Currency;
use App\InvoiceLayout;
use App\InvoiceScheme;
use App\NotificationTemplate;
use App\Unit;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InitialBusinessSeeder extends Seeder
{
    /**
     * Seeder para crear el negocio inicial con usuarios por defecto.
     *
     * Usuarios creados:
     *   - superadmin / superadmin123  (Super Administrador - acceso total al sistema)
     *   - admin / admin123            (Administrador del negocio - gestión completa)
     *   - cajero / cajero123          (Cajero - ventas y caja)
     *   - compras / compras123        (Compras - gestión de compras y proveedores)
     *
     * IMPORTANTE: En .env debe estar configurado:
     *   ADMINISTRATOR_USERNAMES=superadmin
     *   para que el usuario superadmin tenga acceso al panel de Superadmin.
     */
    public function run()
    {
        // Evitar duplicados si se ejecuta más de una vez
        if (DB::table('business')->count() > 0) {
            $this->command->warn('Ya existen negocios en la base de datos. Seeder omitido.');
            return;
        }

        DB::beginTransaction();

        try {
            // ============================================================
            // 1. Crear usuario admin temporal (necesario por FK de business)
            // ============================================================
            $adminUser = User::create([
                'surname'      => 'Sr.',
                'first_name'   => 'Administrador',
                'last_name'    => null,
                'username'     => 'admin',
                'email'        => 'admin@minegocio.com',
                'password'     => Hash::make('admin123'),
                'language'     => 'es',
                'is_cmmsn_agnt' => 0,
                'cmmsn_percent' => 0,
            ]);

            // ============================================================
            // 2. Crear el negocio principal
            // ============================================================
            $currency = DB::table('currencies')->where('code', 'USD')->first();
            $currency_id = $currency ? $currency->id : 1;

            $business = Business::create([
                'name'                  => 'Mi Negocio',
                'currency_id'           => $currency_id,
                'start_date'            => Carbon::today()->toDateString(),
                'tax_number_1'          => '',
                'tax_label_1'           => '',
                'default_profit_percent' => 25.00,
                'owner_id'              => $adminUser->id,
                'time_zone'             => config('app.timezone', 'America/New_York'),
                'fy_start_month'        => 1,
                'accounting_method'     => 'fifo',
                'sell_price_tax'        => 'includes',
                'enable_tooltip'        => 1,
                'currency_symbol_placement' => 'before',
                'theme_color'           => 'indigo',
                'enabled_modules'       => [
                    'purchases', 'add_sale', 'pos_sale',
                    'stock_transfers', 'stock_adjustment', 'expenses', 'account',
                ],
                'date_format'           => 'd/m/Y',
                'time_format'           => '24',
                'ref_no_prefixes'       => [
                    'purchase'         => 'OC',
                    'stock_transfer'   => 'TS',
                    'stock_adjustment' => 'AJ',
                    'sell_return'      => 'NC',
                    'expense'          => 'GA',
                    'contacts'         => 'CT',
                    'purchase_payment' => 'PP',
                    'sell_payment'     => 'PV',
                    'business_location'=> 'SU',
                ],
                'keyboard_shortcuts'    => json_encode([
                    'pos' => [
                        'express_checkout'        => 'shift+e',
                        'pay_n_ckeckout'          => 'shift+p',
                        'draft'                   => 'shift+d',
                        'cancel'                  => 'shift+c',
                        'edit_discount'           => 'shift+i',
                        'edit_order_tax'          => 'shift+t',
                        'add_payment_row'         => 'shift+r',
                        'finalize_payment'        => 'shift+f',
                        'recent_product_quantity' => 'f2',
                        'add_new_product'         => 'f4',
                    ],
                ]),
            ]);

            $business_id = $business->id;

            // Asignar business_id al admin
            $adminUser->business_id = $business_id;
            $adminUser->save();

            // ============================================================
            // 3. Crear los demás usuarios
            // ============================================================
            $users = $this->createUsers($business_id, $adminUser);

            // ============================================================
            // 4. Crear roles y asignar permisos
            // ============================================================
            $this->createRolesAndPermissions($business_id, $users);

            // ============================================================
            // 5. Crear recursos por defecto del negocio
            // ============================================================
            $this->createDefaultResources($business_id, $adminUser->id);

            // ============================================================
            // 6. Crear paquetes de suscripción y suscripción activa
            // ============================================================
            $this->createPackagesAndSubscription($business_id);

            DB::commit();

            $this->command->info('');
            $this->command->info('╔══════════════════════════════════════════════════════╗');
            $this->command->info('║       NEGOCIO Y USUARIOS CREADOS EXITOSAMENTE       ║');
            $this->command->info('╠══════════════════════════════════════════════════════╣');
            $this->command->info('║  Negocio: Mi Negocio                                ║');
            $this->command->info('╠══════════════════════════════════════════════════════╣');
            $this->command->info('║  Usuario       │ Contraseña    │ Rol                 ║');
            $this->command->info('║  ─────────────────────────────────────────────────── ║');
            $this->command->info('║  superadmin    │ superadmin123 │ Super Admin          ║');
            $this->command->info('║  admin         │ admin123      │ Admin                ║');
            $this->command->info('║  cajero        │ cajero123     │ Cajero               ║');
            $this->command->info('║  compras       │ compras123    │ Compras              ║');
            $this->command->info('╚══════════════════════════════════════════════════════╝');
            $this->command->info('');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error al crear datos iniciales: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Crear los usuarios adicionales del sistema (superadmin, cajero, compras).
     */
    private function createUsers(int $business_id, User $adminUser): array
    {
        $usersData = [
            'superadmin' => [
                'surname'     => 'Sr.',
                'first_name'  => 'Super',
                'last_name'   => 'Admin',
                'username'    => 'superadmin',
                'email'       => 'superadmin@minegocio.com',
                'password'    => Hash::make('superadmin123'),
                'language'    => 'es',
                'business_id' => $business_id,
                'is_cmmsn_agnt' => 0,
                'cmmsn_percent' => 0,
            ],
            'cajero' => [
                'surname'     => 'Sr.',
                'first_name'  => 'Cajero',
                'last_name'   => 'Principal',
                'username'    => 'cajero',
                'email'       => 'cajero@minegocio.com',
                'password'    => Hash::make('cajero123'),
                'language'    => 'es',
                'business_id' => $business_id,
                'is_cmmsn_agnt' => 0,
                'cmmsn_percent' => 0,
            ],
            'compras' => [
                'surname'     => 'Sr.',
                'first_name'  => 'Encargado',
                'last_name'   => 'Compras',
                'username'    => 'compras',
                'email'       => 'compras@minegocio.com',
                'password'    => Hash::make('compras123'),
                'language'    => 'es',
                'business_id' => $business_id,
                'is_cmmsn_agnt' => 0,
                'cmmsn_percent' => 0,
            ],
        ];

        $users = ['admin' => $adminUser];
        foreach ($usersData as $key => $data) {
            $users[$key] = User::create($data);
        }

        return $users;
    }

    /**
     * Crear roles con permisos específicos por tipo de usuario.
     */
    private function createRolesAndPermissions(int $business_id, array $users): void
    {
        // ── Super Admin: acceso total ──
        $superAdminRole = Role::create([
            'name'        => 'Admin#' . $business_id,
            'business_id' => $business_id,
            'guard_name'  => 'web',
            'is_default'  => 1,
        ]);
        // Admin tiene TODOS los permisos (el sistema lo trata como admin por is_default=1)
        $users['superadmin']->assignRole($superAdminRole->name);
        $users['admin']->assignRole($superAdminRole->name);

        // ── Cajero: ventas, caja, clientes ──
        $cajeroRole = Role::create([
            'name'        => 'Cajero#' . $business_id,
            'business_id' => $business_id,
            'guard_name'  => 'web',
        ]);
        $cajeroPermissions = [
            // Ventas
            'sell.view', 'sell.create', 'sell.update',
            // Clientes (consultar y crear rápido)
            'customer.view', 'customer.create',
            // Productos (solo ver)
            'product.view',
            // Caja registradora
            'view_cash_register', 'close_cash_register',
            // POS
            'edit_product_price_from_pos_screen',
            'edit_product_discount_from_pos_screen',
            // Acceso a ubicaciones
            'access_all_locations',
            // Imprimir facturas
            'print_invoice',
            // Dashboard
            'dashboard.data',
            // Borradores y cotizaciones
            'list_drafts', 'list_quotations',
            // Acceso a venta directa
            'direct_sell.access',
        ];
        $cajeroRole->syncPermissions($cajeroPermissions);
        $users['cajero']->assignRole($cajeroRole->name);

        // ── Compras: compras, proveedores, inventario ──
        $comprasRole = Role::create([
            'name'        => 'Compras#' . $business_id,
            'business_id' => $business_id,
            'guard_name'  => 'web',
        ]);
        $comprasPermissions = [
            // Compras
            'purchase.view', 'purchase.create', 'purchase.update', 'purchase.delete',
            'purchase.payments', 'purchase.update_status',
            // Proveedores
            'supplier.view', 'supplier.create', 'supplier.update',
            // Productos
            'product.view', 'product.create', 'product.update',
            'product.opening_stock', 'view_purchase_price',
            // Marcas, categorías, unidades
            'brand.view', 'brand.create',
            'category.view', 'category.create',
            'unit.view', 'unit.create',
            // Impuestos
            'tax_rate.view',
            // Reportes
            'purchase_n_sell_report.view', 'stock_report.view',
            // Gastos
            'expense.access',
            // Acceso a ubicaciones
            'access_all_locations',
            // Dashboard
            'dashboard.data',
            // Envíos
            'access_shipping',
        ];
        $comprasRole->syncPermissions($comprasPermissions);
        $users['compras']->assignRole($comprasRole->name);

        // Crear permiso de ubicación (se crea después con la ubicación)
    }

    /**
     * Crear recursos por defecto: ubicación, contacto walk-in, esquema de factura, etc.
     */
    private function createDefaultResources(int $business_id, int $admin_user_id): void
    {
        // ── Esquema de factura ──
        $invoiceScheme = InvoiceScheme::create([
            'name'         => 'Por Defecto',
            'scheme_type'  => 'blank',
            'prefix'       => '',
            'start_number' => 1,
            'total_digits' => 4,
            'is_default'   => 1,
            'business_id'  => $business_id,
        ]);

        // ── Layout de factura ──
        $invoiceLayout = InvoiceLayout::create([
            'name'               => 'Por Defecto',
            'header_text'        => null,
            'invoice_no_prefix'  => 'Factura No.',
            'invoice_heading'    => 'Factura',
            'sub_total_label'    => 'Subtotal',
            'discount_label'     => 'Descuento',
            'tax_label'          => 'Impuesto',
            'total_label'        => 'Total',
            'total_due_label'    => 'Total Pendiente',
            'paid_label'         => 'Pagado',
            'show_client_id'     => 0,
            'client_id_label'    => null,
            'date_label'         => 'Fecha',
            'table_product_label' => 'Producto',
            'table_qty_label'    => 'Cantidad',
            'table_unit_price_label' => 'Precio Unitario',
            'table_subtotal_label' => 'Subtotal',
            'footer_text'        => null,
            'is_default'         => 1,
            'business_id'        => $business_id,
            'show_business_name' => 1,
            'show_location_name' => 1,
            'show_mobile_number' => 1,
            'show_alternate_number' => 0,
            'show_email'         => 0,
            'show_tax_1'         => 1,
            'show_tax_2'         => 0,
            'show_barcode'       => 0,
            'show_payments'      => 1,
            'show_customer'      => 1,
            'design'             => 'classic',
            'cn_heading'         => 'Nota de Crédito',
            'cn_no_label'        => 'No. Ref',
            'cn_amount_label'    => 'Monto',
            'table_tax_headings' => null,
            'prev_bal_label'     => null,
        ]);

        // ── Ubicación principal ──
        $location = \App\BusinessLocation::create([
            'business_id'          => $business_id,
            'name'                 => 'Sucursal Principal',
            'landmark'             => 'Centro',
            'country'              => 'Venezuela',
            'state'                => 'Estado',
            'city'                 => 'Ciudad',
            'zip_code'             => '00000',
            'invoice_scheme_id'    => $invoiceScheme->id,
            'invoice_layout_id'    => $invoiceLayout->id,
            'sale_invoice_layout_id' => $invoiceLayout->id,
            'print_receipt_on_invoice' => 1,
            'receipt_printer_type' => 'browser',
            'is_active'            => 1,
            'default_payment_accounts' => json_encode([
                'cash'          => ['is_enabled' => '1', 'account' => null],
                'card'          => ['is_enabled' => '1', 'account' => null],
                'cheque'        => ['is_enabled' => '1', 'account' => null],
                'bank_transfer' => ['is_enabled' => '1', 'account' => null],
                'other'         => ['is_enabled' => '1', 'account' => null],
                'custom_pay_1'  => ['is_enabled' => '1', 'account' => null],
                'custom_pay_2'  => ['is_enabled' => '1', 'account' => null],
                'custom_pay_3'  => ['is_enabled' => '1', 'account' => null],
            ]),
        ]);

        // Permiso de ubicación
        Permission::create(['name' => 'location.' . $location->id]);

        // ── Unidad por defecto ──
        Unit::create([
            'business_id' => $business_id,
            'actual_name' => 'Pieza',
            'short_name'  => 'Pz',
            'allow_decimal' => 0,
            'created_by'  => $admin_user_id,
        ]);

        // ── Cliente genérico (Walk-In) ──
        $ref_count = DB::table('reference_counts')
            ->insertGetId([
                'ref_type'    => 'contacts',
                'ref_count'   => 1,
                'business_id' => $business_id,
            ]);

        Contact::create([
            'business_id' => $business_id,
            'type'        => 'customer',
            'name'        => 'Cliente General',
            'created_by'  => $admin_user_id,
            'is_default'  => 1,
            'contact_id'  => 'CT0001',
            'credit_limit' => 0,
        ]);

        // ── Plantillas de notificación por defecto ──
        $this->createNotificationTemplates($business_id);
    }

    /**
     * Crear plantillas de notificación básicas.
     */
    private function createNotificationTemplates(int $business_id): void
    {
        $templates = [
            [
                'business_id'   => $business_id,
                'template_for'  => 'new_sale',
                'email_body'    => '<p>Estimado {contact_name},</p><p>Su factura {invoice_number} por {total_amount} ha sido generada.</p><p>Gracias por su compra.</p>',
                'sms_body'      => 'Estimado {contact_name}, su factura {invoice_number} por {total_amount} ha sido generada. Gracias.',
                'subject'       => 'Nueva venta - {business_name}',
            ],
            [
                'business_id'   => $business_id,
                'template_for'  => 'payment_received',
                'email_body'    => '<p>Estimado {contact_name},</p><p>Hemos recibido su pago de {received_amount}.</p>',
                'sms_body'      => 'Estimado {contact_name}, hemos recibido su pago de {received_amount}.',
                'subject'       => 'Pago recibido - {business_name}',
            ],
            [
                'business_id'   => $business_id,
                'template_for'  => 'payment_reminder',
                'email_body'    => '<p>Estimado {contact_name},</p><p>Este es un recordatorio de que tiene un saldo pendiente de {due_amount}.</p>',
                'sms_body'      => 'Estimado {contact_name}, tiene un saldo pendiente de {due_amount}.',
                'subject'       => 'Recordatorio de pago - {business_name}',
            ],
            [
                'business_id'   => $business_id,
                'template_for'  => 'new_booking',
                'email_body'    => '<p>Estimado {contact_name},</p><p>Su reserva ha sido confirmada.</p>',
                'sms_body'      => 'Estimado {contact_name}, su reserva ha sido confirmada.',
                'subject'       => 'Reserva confirmada - {business_name}',
            ],
            [
                'business_id'   => $business_id,
                'template_for'  => 'new_order',
                'email_body'    => '<p>Estimado {contact_name},</p><p>Su pedido #{invoice_number} ha sido recibido.</p>',
                'sms_body'      => 'Estimado {contact_name}, su pedido #{invoice_number} ha sido recibido.',
                'subject'       => 'Nuevo pedido - {business_name}',
            ],
        ];

        foreach ($templates as $template) {
            NotificationTemplate::create($template);
        }
    }

    /**
     * Crear paquetes de suscripción y asignar suscripción activa al negocio.
     */
    private function createPackagesAndSubscription(int $business_id): void
    {
        $packages = [
            [
                'name' => 'Básico',
                'description' => 'Ideal para emprendedores y pequeños negocios que inician. Incluye las funciones esenciales del punto de venta.',
                'location_count' => 1,
                'user_count' => 3,
                'product_count' => 500,
                'bookings' => 0, 'kitchen' => 0, 'order_screen' => 0, 'tables' => 0,
                'invoice_count' => 0,
                'interval' => 'months',
                'interval_count' => 1,
                'trial_days' => 14,
                'price' => 9.99,
                'custom_permissions' => json_encode([]),
                'created_by' => 1,
                'sort_order' => 1,
                'is_active' => 1,
                'mark_package_as_popular' => 0,
                'is_private' => 0, 'is_one_time' => 0,
                'enable_custom_link' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Profesional',
                'description' => 'Para negocios en crecimiento. Múltiples usuarios, sucursales y módulos avanzados.',
                'location_count' => 3,
                'user_count' => 10,
                'product_count' => 5000,
                'bookings' => 1, 'kitchen' => 0, 'order_screen' => 0, 'tables' => 0,
                'invoice_count' => 0,
                'interval' => 'months',
                'interval_count' => 1,
                'trial_days' => 14,
                'price' => 29.99,
                'custom_permissions' => json_encode(['essentials_module' => 1, 'crm_module' => 1]),
                'created_by' => 1,
                'sort_order' => 2,
                'is_active' => 1,
                'mark_package_as_popular' => 1,
                'is_private' => 0, 'is_one_time' => 0,
                'enable_custom_link' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Empresarial',
                'description' => 'Solución completa. Sucursales ilimitadas, todos los módulos y soporte prioritario.',
                'location_count' => 0,
                'user_count' => 0,
                'product_count' => 0,
                'bookings' => 1, 'kitchen' => 1, 'order_screen' => 1, 'tables' => 1,
                'invoice_count' => 0,
                'interval' => 'months',
                'interval_count' => 1,
                'trial_days' => 14,
                'price' => 79.99,
                'custom_permissions' => json_encode(['essentials_module' => 1, 'manufacturing_module' => 1, 'crm_module' => 1, 'project_module' => 1]),
                'created_by' => 1,
                'sort_order' => 3,
                'is_active' => 1,
                'mark_package_as_popular' => 0,
                'is_private' => 0, 'is_one_time' => 0,
                'enable_custom_link' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ];

        DB::table('packages')->insert($packages);

        // Suscripción Empresarial activa para el negocio
        $empresarial = DB::table('packages')->where('name', 'Empresarial')->first();

        DB::table('subscriptions')->insert([
            'business_id'    => $business_id,
            'package_id'     => $empresarial->id,
            'start_date'     => Carbon::today()->toDateString(),
            'trial_end_date' => Carbon::today()->addDays(14)->toDateString(),
            'end_date'       => Carbon::today()->addYear()->toDateString(),
            'package_price'  => $empresarial->price,
            'original_price' => $empresarial->price,
            'package_details' => json_encode([
                'name' => $empresarial->name,
                'location_count' => $empresarial->location_count,
                'user_count' => $empresarial->user_count,
                'product_count' => $empresarial->product_count,
                'invoice_count' => $empresarial->invoice_count,
            ]),
            'created_id'     => 1,
            'paid_via'       => 'offline',
            'status'         => 'approved',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}
