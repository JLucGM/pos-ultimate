#!/bin/bash

echo "=========================================="
echo "FIX: Duplicate Ref No en Production Orders"
echo "=========================================="

echo ""
echo "1. Verificando órdenes duplicadas..."
php artisan tinker --execute="
\$orders = DB::table('mfg_production_orders')
    ->where('ref_no', 'LIKE', 'PRD202601%')
    ->orderBy('id', 'desc')
    ->get(['id', 'ref_no', 'status', 'created_at']);

echo 'Total órdenes encontradas: ' . \$orders->count() . PHP_EOL;
echo '---' . PHP_EOL;

foreach (\$orders as \$order) {
    echo 'ID: ' . \$order->id . ' | Ref: ' . \$order->ref_no . ' | Status: ' . \$order->status . ' | Fecha: ' . \$order->created_at . PHP_EOL;
}
"

echo ""
echo "2. Eliminando orden duplicada PRD2026010001..."
php artisan tinker --execute="
\$deleted = DB::table('mfg_production_orders')
    ->where('ref_no', 'PRD2026010001')
    ->where('status', 'pending')
    ->delete();
echo 'Órdenes eliminadas: ' . \$deleted . PHP_EOL;
"

echo ""
echo "3. Limpiando caché..."
php artisan cache:clear
php artisan config:clear

echo ""
echo "=========================================="
echo "✅ COMPLETADO"
echo "=========================================="
echo ""
echo "Ahora puedes intentar crear la orden de producción nuevamente."
echo ""
