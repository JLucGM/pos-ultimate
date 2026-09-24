<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            // Gastos (Expenses)
            'all_expense.access',
            'view_own_expense',
            'expense.access',
            'expense.add',
            'expense.edit',
            'expense.delete',
            'expense_report.view',

            // Tasas de cambio (Exchange rates)
            'view_exchange_rate',
            'create_exchange_rate',
            'edit_exchange_rate',
            'delete_exchange_rate',

            // Permisos de roles y vistas adicionales
            'view_export_buttons',
            'send_notifications',
            'supplier.view_own',
            'customer.view_own',
            'customer_irrespective_of_sell',
            'view_own_purchase',
            'purchase_requisition.view_all',
            'purchase_requisition.view_own',
            'purchase_order.view_all',
            'purchase_order.view_own',
            'direct_sell.view',
            'so.view_all',
            'so.view_own',
            'draft.view_all',
            'draft.view_own',
            'quotation.view_all',
            'quotation.view_own',
            'access_own_shipping',
            'access_tables',
        ];

        $now = now();

        foreach ($permissions as $permName) {
            $exists = DB::table('permissions')->where('name', $permName)->where('guard_name', 'web')->exists();
            if (!$exists) {
                DB::table('permissions')->insert([
                    'name' => $permName,
                    'guard_name' => 'web',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Asignar los nuevos permisos a todos los roles de tipo Admin y roles que tengan expense.access
        $adminRoles = DB::table('roles')->where('name', 'like', 'Admin%')->get();
        $allPermIds = DB::table('permissions')->whereIn('name', $permissions)->pluck('id')->toArray();

        foreach ($adminRoles as $role) {
            foreach ($allPermIds as $pId) {
                $hasPivot = DB::table('role_has_permissions')
                    ->where('role_id', $role->id)
                    ->where('permission_id', $pId)
                    ->exists();

                if (!$hasPivot) {
                    DB::table('role_has_permissions')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $pId,
                    ]);
                }
            }
        }

        // Roles con expense.access previo: darles expense.add, expense.edit, expense.delete, all_expense.access
        $expensePerms = DB::table('permissions')->whereIn('name', ['expense.add', 'expense.edit', 'expense.delete', 'all_expense.access'])->pluck('id')->toArray();
        $expenseAccessPerm = DB::table('permissions')->where('name', 'expense.access')->value('id');

        if ($expenseAccessPerm) {
            $rolesWithExpense = DB::table('role_has_permissions')->where('permission_id', $expenseAccessPerm)->pluck('role_id')->toArray();
            foreach ($rolesWithExpense as $rId) {
                foreach ($expensePerms as $pId) {
                    $hasPivot = DB::table('role_has_permissions')
                        ->where('role_id', $rId)
                        ->where('permission_id', $pId)
                        ->exists();

                    if (!$hasPivot) {
                        DB::table('role_has_permissions')->insert([
                            'role_id' => $rId,
                            'permission_id' => $pId,
                        ]);
                    }
                }
            }
        }

        // Limpiar caché de Spatie Permission
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No destructivo
    }
};
