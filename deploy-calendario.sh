#!/bin/bash

echo "=========================================="
echo "DEPLOYMENT CALENDARIO CONSULTORIO"
echo "=========================================="

echo ""
echo "1. Descargando cambios desde Git..."
git pull origin main

if [ $? -ne 0 ]; then
    echo "❌ Error al hacer pull de Git"
    exit 1
fi

echo ""
echo "2. Limpiando caché..."
php artisan optimize:clear

echo ""
echo "3. Limpiando caché de rutas..."
php artisan route:clear

echo ""
echo "4. Cacheando rutas..."
php artisan route:cache

echo ""
echo "=========================================="
echo "✅ DEPLOYMENT COMPLETADO"
echo "=========================================="
echo ""
echo "Ahora puedes acceder al calendario en:"
echo "https://audaz.site/consultorio/appointments/calendar"
echo ""
