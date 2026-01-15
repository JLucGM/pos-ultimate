#!/bin/bash

echo "=== DIAGNÓSTICO DEL SERVIDOR ==="
echo ""

cd /home/audaz.site/public_html

echo "1. Estado de Git:"
git status
echo ""

echo "2. Último commit:"
git log -1 --oneline
echo ""

echo "3. Verificando si existe el método getRecipeDetails:"
grep -n "getRecipeDetails" Modules/Manufacturing/Http/Controllers/ProductionOrderController.php
echo ""

echo "4. Últimas 30 líneas del ProductionOrderController:"
tail -30 Modules/Manufacturing/Http/Controllers/ProductionOrderController.php
echo ""

echo "5. Línea 10 del create.blade.php:"
sed -n '10p' Modules/Manufacturing/Resources/views/production_orders/create.blade.php
echo ""

echo "6. Últimos errores del log:"
tail -50 storage/logs/laravel.log | grep -A 5 "ProductionOrderController"
echo ""

echo "=== FIN DEL DIAGNÓSTICO ==="
