#!/bin/bash

echo "=========================================="
echo "DIAGNÓSTICO: POS - PRODUCTOS MANUFACTURING"
echo "=========================================="

echo ""
echo "1. Verificando productos manufacturados con stock..."
php artisan tinker --execute="
\$products = DB::table('products')
    ->join('variations', 'products.id', '=', 'variations.product_id')
    ->join('variation_location_details', 'variations.id', '=', 'variation_location_details.variation_id')
    ->where('products.type', 'manufactured')
    ->select('products.name', 'variations.sub_sku', 'variation_location_details.qty_available')
    ->get();
foreach(\$products as \$p) {
    echo \$p->name . ' (' . \$p->sub_sku . ') - Stock: ' . \$p->qty_available . PHP_EOL;
}
"

echo ""
echo "2. Verificando órdenes de producción completadas..."
php artisan tinker --execute="
\$orders = DB::table('mfg_production_orders')
    ->where('status', 'completed')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get(['id', 'production_order_number', 'status', 'final_quantity', 'created_at']);
foreach(\$orders as \$o) {
    echo 'Orden: ' . \$o->production_order_number . ' - Cantidad: ' . \$o->final_quantity . ' - Fecha: ' . \$o->created_at . PHP_EOL;
}
"

echo ""
echo "3. Verificando configuración de sobreventa..."
php artisan tinker --execute="
\$setting = DB::table('business')
    ->select('enable_overselling')
    ->first();
echo 'Sobreventa habilitada: ' . (\$setting->enable_overselling ? 'SÍ' : 'NO') . PHP_EOL;
"

echo ""
echo "4. Verificando últimos errores en logs..."
tail -20 storage/logs/laravel.log | grep -i "error\|exception" || echo "No se encontraron errores recientes"

echo ""
echo "=========================================="
echo "DIAGNÓSTICO COMPLETADO"
echo "=========================================="
echo ""
echo "Si los productos manufacturados no tienen stock:"
echo "1. Verifica que las órdenes de producción estén completadas"
echo "2. Verifica que el stock se haya actualizado correctamente"
echo "3. Considera habilitar 'Permitir sobreventa' en Configuración"
echo ""
echo "Para más detalles, revisa: DIAGNOSTICO_POS_MANUFACTURING.md"
echo ""
