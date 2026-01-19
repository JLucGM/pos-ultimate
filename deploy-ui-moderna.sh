#!/bin/bash

echo "=========================================="
echo "DEPLOYMENT UI MODERNA"
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
echo "3. Cacheando configuración..."
php artisan config:cache

echo ""
echo "=========================================="
echo "✅ DEPLOYMENT COMPLETADO"
echo "=========================================="
echo ""
echo "La nueva UI moderna está activa!"
echo ""
echo "Páginas actualizadas:"
echo "- Landing: https://audaz.site/"
echo "- Login: https://audaz.site/login"
echo "- Registro: https://audaz.site/business/register"
echo "- Calendario Consultorio: https://audaz.site/consultorio/appointments/calendar"
echo ""
echo "Para cambiar entre temas, edita el archivo .env:"
echo "AUTH_THEME=modern  (o 'default' para el tema anterior)"
echo "LANDING_THEME=modern  (o 'default' para el landing anterior)"
echo ""
