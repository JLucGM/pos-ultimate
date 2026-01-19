#!/bin/bash

echo "=========================================="
echo "CORREGIR PERMISOS - VERSIÓN SIMPLE"
echo "=========================================="

echo ""
echo "Aplicando permisos 777 a storage y bootstrap/cache..."
chmod -R 777 storage
chmod -R 777 bootstrap/cache

echo ""
echo "Limpiando caché..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo ""
echo "✅ PERMISOS CORREGIDOS"
echo ""
echo "Ahora intenta crear la orden de producción nuevamente"
echo ""
