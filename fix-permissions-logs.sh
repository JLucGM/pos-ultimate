#!/bin/bash

echo "=========================================="
echo "CORREGIR PERMISOS DE LOGS Y STORAGE"
echo "=========================================="

echo ""
echo "1. Corrigiendo permisos de storage..."
chmod -R 775 storage
chown -R www-data:www-data storage

echo ""
echo "2. Corrigiendo permisos de bootstrap/cache..."
chmod -R 775 bootstrap/cache
chown -R www-data:www-data bootstrap/cache

echo ""
echo "3. Creando directorio de logs si no existe..."
mkdir -p storage/logs
chmod -R 775 storage/logs
chown -R www-data:www-data storage/logs

echo ""
echo "4. Corrigiendo permisos de archivos de log existentes..."
if [ -f storage/logs/laravel.log ]; then
    chmod 664 storage/logs/laravel.log
    chown www-data:www-data storage/logs/laravel.log
    echo "✓ laravel.log corregido"
fi

# Corregir todos los archivos de log
find storage/logs -type f -name "*.log" -exec chmod 664 {} \;
find storage/logs -type f -name "*.log" -exec chown www-data:www-data {} \;

echo ""
echo "5. Verificando permisos..."
ls -la storage/logs/ | head -10

echo ""
echo "=========================================="
echo "✅ PERMISOS CORREGIDOS"
echo "=========================================="
echo ""
echo "Permisos aplicados:"
echo "- storage/: 775 (rwxrwxr-x)"
echo "- storage/logs/: 775 (rwxrwxr-x)"
echo "- *.log: 664 (rw-rw-r--)"
echo "- Propietario: www-data:www-data"
echo ""
