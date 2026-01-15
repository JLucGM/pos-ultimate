#!/bin/bash

# Script de deployment del módulo Consultorio
# Ejecutar desde: /home/audaz.site/public_html

echo "=========================================="
echo "DEPLOYMENT MÓDULO CONSULTORIO"
echo "=========================================="
echo ""

# 1. Pull de cambios
echo "1. Descargando cambios desde Git..."
git pull origin main

if [ $? -ne 0 ]; then
    echo "❌ Error al hacer pull de Git"
    exit 1
fi

echo "✅ Cambios descargados"
echo ""

# 2. Permisos
echo "2. Configurando permisos..."
chmod -R 777 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
echo "✅ Permisos configurados"
echo ""

# 3. Ejecutar migraciones
echo "3. Ejecutando migraciones..."
php artisan migrate --force

if [ $? -ne 0 ]; then
    echo "❌ Error al ejecutar migraciones"
    exit 1
fi

echo "✅ Migraciones ejecutadas"
echo ""

# 4. Limpiar caché
echo "4. Limpiando caché..."
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo "✅ Caché limpiado"
echo ""

# 5. Optimizar
echo "5. Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
echo "✅ Aplicación optimizada"
echo ""

echo "=========================================="
echo "✅ DEPLOYMENT COMPLETADO"
echo "=========================================="
echo ""
echo "PRÓXIMOS PASOS:"
echo ""
echo "1. AGREGAR PERMISOS (elige una opción):"
echo ""
echo "   OPCIÓN A - Comando Artisan (LA MÁS FÁCIL):"
echo "   php artisan consultorio:install-permissions"
echo ""
echo "   OPCIÓN B - Usando Tinker:"
echo "   php artisan tinker < agregar-permisos-consultorio.php"
echo ""
echo "   OPCIÓN C - Usando SQL:"
echo "   mysql -u root -p audaz_pos < add-consultorio-permissions.sql"
echo ""
echo "2. Ir a Configuración → Módulos"
echo "3. Habilitar el módulo 'Consultorio'"
echo "4. Verificar que aparezca en el menú lateral"
echo ""
