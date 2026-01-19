#!/bin/bash

echo "=========================================="
echo "LIMPIEZA COMPLETA DE CACHÉ"
echo "=========================================="

echo ""
echo "1. Limpiando caché de Laravel..."
php artisan cache:clear

echo ""
echo "2. Limpiando caché de configuración..."
php artisan config:clear

echo ""
echo "3. Limpiando caché de rutas..."
php artisan route:clear

echo ""
echo "4. Limpiando caché de vistas..."
php artisan view:clear

echo ""
echo "5. Limpiando caché optimizado..."
php artisan optimize:clear

echo ""
echo "6. Limpiando archivos de caché compilados..."
rm -rf bootstrap/cache/*.php

echo ""
echo "7. Limpiando caché de Blade..."
rm -rf storage/framework/views/*.php

echo ""
echo "8. Reconstruyendo caché de configuración..."
php artisan config:cache

echo ""
echo "9. Reconstruyendo caché de rutas..."
php artisan route:cache

echo ""
echo "=========================================="
echo "✅ CACHÉ COMPLETAMENTE LIMPIADO"
echo "=========================================="
echo ""
echo "Ahora presiona Ctrl+Shift+R en tu navegador para forzar recarga"
echo ""
