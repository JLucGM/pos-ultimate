#!/bin/bash

echo "=========================================="
echo "VERIFICACIÓN DE ESTADO DEL SISTEMA"
echo "=========================================="

echo ""
echo "1. Verificando PHP..."
php -v | head -1

echo ""
echo "2. Verificando Composer..."
composer --version 2>/dev/null || echo "⚠ Composer no disponible"

echo ""
echo "3. Verificando permisos de storage..."
ls -ld storage/
ls -ld storage/logs/
ls -ld bootstrap/cache/

echo ""
echo "4. Verificando archivos críticos..."
[ -f .env ] && echo "✓ .env existe" || echo "❌ .env NO existe"
[ -f artisan ] && echo "✓ artisan existe" || echo "❌ artisan NO existe"
[ -f composer.json ] && echo "✓ composer.json existe" || echo "❌ composer.json NO existe"

echo ""
echo "5. Verificando últimos logs (últimas 20 líneas)..."
if [ -f storage/logs/laravel.log ]; then
    echo "--- Últimos errores en laravel.log ---"
    tail -20 storage/logs/laravel.log | grep -i "error\|exception\|fatal" || echo "No hay errores recientes"
else
    echo "⚠ No existe storage/logs/laravel.log"
fi

echo ""
echo "6. Verificando espacio en disco..."
df -h . | tail -1

echo ""
echo "7. Verificando procesos PHP..."
ps aux | grep php | grep -v grep | head -5 || echo "No hay procesos PHP visibles"

echo ""
echo "8. Verificando servidor web..."
if systemctl is-active --quiet apache2; then
    echo "✓ Apache está corriendo"
elif systemctl is-active --quiet nginx; then
    echo "✓ Nginx está corriendo"
else
    echo "⚠ No se detectó Apache ni Nginx corriendo"
fi

echo ""
echo "9. Verificando módulos de Laravel..."
php artisan module:list 2>/dev/null | head -10 || echo "⚠ No se pudo listar módulos"

echo ""
echo "10. Verificando caché..."
[ -d bootstrap/cache ] && echo "✓ bootstrap/cache existe" || echo "❌ bootstrap/cache NO existe"
[ -d storage/framework/cache ] && echo "✓ storage/framework/cache existe" || echo "❌ storage/framework/cache NO existe"

echo ""
echo "=========================================="
echo "VERIFICACIÓN COMPLETADA"
echo "=========================================="
echo ""
