#!/bin/bash

echo "=========================================="
echo "RECUPERACIÓN DE EMERGENCIA DEL SISTEMA"
echo "=========================================="

echo ""
echo "1. Limpiando TODOS los cachés..."
php artisan cache:clear 2>/dev/null || echo "⚠ Cache clear falló"
php artisan config:clear 2>/dev/null || echo "⚠ Config clear falló"
php artisan route:clear 2>/dev/null || echo "⚠ Route clear falló"
php artisan view:clear 2>/dev/null || echo "⚠ View clear falló"
php artisan optimize:clear 2>/dev/null || echo "⚠ Optimize clear falló"

echo ""
echo "2. Eliminando archivos de caché compilados..."
rm -rf bootstrap/cache/*.php 2>/dev/null
rm -rf storage/framework/cache/data/* 2>/dev/null
rm -rf storage/framework/views/*.php 2>/dev/null
rm -rf storage/framework/sessions/* 2>/dev/null

echo ""
echo "3. Corrigiendo permisos críticos..."
chmod -R 777 storage
chmod -R 777 bootstrap/cache

echo ""
echo "4. Verificando archivo .env..."
if [ ! -f .env ]; then
    echo "❌ ERROR: Archivo .env no encontrado!"
    if [ -f .env.example ]; then
        echo "Copiando .env.example a .env..."
        cp .env.example .env
        echo "⚠ IMPORTANTE: Debes configurar .env con tus credenciales"
    fi
else
    echo "✓ Archivo .env existe"
fi

echo ""
echo "5. Verificando conexión a base de datos..."
php artisan tinker --execute="
try {
    DB::connection()->getPdo();
    echo '✓ Conexión a base de datos OK' . PHP_EOL;
} catch (Exception \$e) {
    echo '❌ ERROR de conexión a BD: ' . \$e->getMessage() . PHP_EOL;
}
" 2>/dev/null || echo "⚠ No se pudo verificar BD"

echo ""
echo "6. Reconstruyendo caché de configuración..."
php artisan config:cache 2>/dev/null && echo "✓ Config cache OK" || echo "⚠ Config cache falló"

echo ""
echo "7. Reconstruyendo caché de rutas..."
php artisan route:cache 2>/dev/null && echo "✓ Route cache OK" || echo "⚠ Route cache falló"

echo ""
echo "8. Verificando módulos..."
php artisan module:list 2>/dev/null || echo "⚠ No se pudo listar módulos"

echo ""
echo "9. Verificando permisos finales..."
ls -la storage/ | head -5
ls -la bootstrap/cache/ | head -5

echo ""
echo "=========================================="
echo "RECUPERACIÓN COMPLETADA"
echo "=========================================="
echo ""
echo "Próximos pasos:"
echo "1. Intenta acceder al sistema: https://audaz.site/"
echo "2. Si no funciona, revisa los logs: tail -f storage/logs/laravel.log"
echo "3. Si hay error de BD, verifica las credenciales en .env"
echo "4. Si persiste, puede ser necesario reiniciar el servidor web"
echo ""
echo "Para reiniciar servicios (si tienes acceso root):"
echo "  sudo systemctl restart apache2"
echo "  sudo systemctl restart nginx"
echo "  sudo systemctl restart php8.2-fpm"
echo ""
