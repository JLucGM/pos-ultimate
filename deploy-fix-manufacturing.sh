#!/bin/bash

echo "=== Deployment: Fix Manufacturing Production Orders ==="
echo ""

# Servidor de producción
SERVER_PATH="/home/audaz.site/public_html"

echo "1. Subiendo archivos corregidos..."
scp Modules/Manufacturing/Http/Controllers/ProductionOrderController.php audaz.site:${SERVER_PATH}/Modules/Manufacturing/Http/Controllers/
scp Modules/Manufacturing/Resources/views/production_orders/create.blade.php audaz.site:${SERVER_PATH}/Modules/Manufacturing/Resources/views/production_orders/

echo ""
echo "2. Limpiando caché en servidor..."
ssh audaz.site "cd ${SERVER_PATH} && php artisan optimize:clear"

echo ""
echo "=== Deployment completado ==="
echo "Prueba crear una orden en: https://audaz.site/manufacturing/production-orders/create"
