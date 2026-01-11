#!/bin/bash

# Script para solucionar conflictos de Git en producción
# Ejecutar en el servidor: bash FIX_GIT_CONFLICT.sh

echo "🔧 Solucionando conflictos de Git..."
echo ""

# 1. Cancelar el merge actual
echo "1️⃣ Cancelando merge conflictivo..."
git merge --abort

# 2. Hacer backup de archivos importantes de storage
echo "2️⃣ Haciendo backup de storage..."
cp -r storage storage_backup_$(date +%Y%m%d_%H%M%S)

# 3. Eliminar archivos de caché y logs que causan conflicto
echo "3️⃣ Limpiando archivos problemáticos..."
rm -rf storage/framework/cache/data/*
rm -rf storage/logs/*.log

# 4. Asegurarse de que .gitignore esté correcto
echo "4️⃣ Verificando .gitignore..."
if ! grep -q "storage/framework/cache" .gitignore; then
    echo "storage/framework/cache/*" >> .gitignore
fi
if ! grep -q "storage/logs" .gitignore; then
    echo "storage/logs/*.log" >> .gitignore
fi

# 5. Hacer stash de cambios locales
echo "5️⃣ Guardando cambios locales..."
git stash

# 6. Pull limpio
echo "6️⃣ Haciendo pull..."
git pull origin main

# 7. Restaurar cambios si es necesario
echo "7️⃣ Verificando si hay cambios guardados..."
if git stash list | grep -q "stash@{0}"; then
    echo "Hay cambios guardados. ¿Quieres restaurarlos? (s/n)"
    # Por seguridad, no los restauramos automáticamente
    echo "Ejecuta 'git stash pop' si necesitas restaurar cambios"
fi

# 8. Limpiar caché de Laravel
echo "8️⃣ Limpiando caché de Laravel..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# 9. Recrear estructura de storage
echo "9️⃣ Recreando estructura de storage..."
php artisan storage:link

# 10. Configurar permisos
echo "🔟 Configurando permisos..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo ""
echo "✅ ¡Conflictos resueltos!"
echo ""
echo "Próximos pasos:"
echo "1. Verifica que el sitio funcione"
echo "2. Ejecuta: php artisan config:cache"
echo "3. Ejecuta: php artisan route:cache"
echo ""
