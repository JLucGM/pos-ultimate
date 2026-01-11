#!/bin/bash

# Script para aplicar correcciones en producción
# Ejecutar: bash aplicar-correcciones.sh

echo "🔧 Aplicando correcciones a la landing page..."
echo ""

# Limpiar caché de vistas
echo "1️⃣ Limpiando caché de vistas..."
php artisan view:clear

# Limpiar caché general
echo "2️⃣ Limpiando caché general..."
php artisan cache:clear

# Limpiar caché de configuración
echo "3️⃣ Limpiando caché de configuración..."
php artisan config:clear

echo ""
echo "✅ Correcciones aplicadas!"
echo ""
echo "Verifica los cambios:"
echo "1. FAQ: https://audaz.site/#faq"
echo "2. Link Precios: Click en 'Precios' en el menú"
echo "3. Botón Demo: Debe ser blanco en el hero"
echo ""
echo "Si no ves los cambios, presiona Ctrl+Shift+R en tu navegador"
echo ""
