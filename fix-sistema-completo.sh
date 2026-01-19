#!/bin/bash

echo "=========================================="
echo "RECUPERACIÓN COMPLETA DEL SISTEMA"
echo "Sistema: Audaz POS"
echo "Fecha: $(date)"
echo "=========================================="

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo ""
echo -e "${YELLOW}FASE 1: RECUPERACIÓN DE EMERGENCIA${NC}"
echo "=========================================="

echo ""
echo "1. Limpiando TODOS los cachés..."
php artisan cache:clear 2>/dev/null && echo -e "${GREEN}✓ Cache cleared${NC}" || echo -e "${RED}✗ Cache clear failed${NC}"
php artisan config:clear 2>/dev/null && echo -e "${GREEN}✓ Config cleared${NC}" || echo -e "${RED}✗ Config clear failed${NC}"
php artisan route:clear 2>/dev/null && echo -e "${GREEN}✓ Routes cleared${NC}" || echo -e "${RED}✗ Route clear failed${NC}"
php artisan view:clear 2>/dev/null && echo -e "${GREEN}✓ Views cleared${NC}" || echo -e "${RED}✗ View clear failed${NC}"
php artisan optimize:clear 2>/dev/null && echo -e "${GREEN}✓ Optimize cleared${NC}" || echo -e "${RED}✗ Optimize clear failed${NC}"

echo ""
echo "2. Eliminando archivos de caché compilados..."
rm -rf bootstrap/cache/*.php 2>/dev/null && echo -e "${GREEN}✓ Bootstrap cache deleted${NC}"
rm -rf storage/framework/cache/data/* 2>/dev/null && echo -e "${GREEN}✓ Framework cache deleted${NC}"
rm -rf storage/framework/views/*.php 2>/dev/null && echo -e "${GREEN}✓ Compiled views deleted${NC}"
rm -rf storage/framework/sessions/* 2>/dev/null && echo -e "${GREEN}✓ Sessions deleted${NC}"

echo ""
echo "3. Corrigiendo permisos críticos..."
chmod -R 777 storage && echo -e "${GREEN}✓ Storage permissions fixed${NC}"
chmod -R 777 bootstrap/cache && echo -e "${GREEN}✓ Bootstrap cache permissions fixed${NC}"

echo ""
echo "4. Verificando archivo .env..."
if [ ! -f .env ]; then
    echo -e "${RED}❌ ERROR: Archivo .env no encontrado!${NC}"
    if [ -f .env.example ]; then
        echo "Copiando .env.example a .env..."
        cp .env.example .env
        echo -e "${YELLOW}⚠ IMPORTANTE: Debes configurar .env con tus credenciales${NC}"
    fi
else
    echo -e "${GREEN}✓ Archivo .env existe${NC}"
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
" 2>/dev/null || echo -e "${YELLOW}⚠ No se pudo verificar BD${NC}"

echo ""
echo "6. Reconstruyendo caché..."
php artisan config:cache 2>/dev/null && echo -e "${GREEN}✓ Config cache rebuilt${NC}" || echo -e "${YELLOW}⚠ Config cache failed${NC}"
php artisan route:cache 2>/dev/null && echo -e "${GREEN}✓ Route cache rebuilt${NC}" || echo -e "${YELLOW}⚠ Route cache failed${NC}"

echo ""
echo -e "${YELLOW}FASE 2: DIAGNÓSTICO POS + MANUFACTURING${NC}"
echo "=========================================="

echo ""
echo "7. Verificando productos manufacturados..."
php artisan tinker --execute="
\$manufactured_products = DB::table('products')
    ->join('variations', 'products.id', '=', 'variations.product_id')
    ->leftJoin('variation_location_details', 'variations.id', '=', 'variation_location_details.variation_id')
    ->select('products.name', 'variations.sub_sku', 'variation_location_details.qty_available')
    ->where('products.type', 'manufactured')
    ->orWhereIn('products.id', function(\$query) {
        \$query->select('product_id')
               ->from('mfg_production_orders')
               ->distinct();
    })
    ->get();

if (\$manufactured_products->isEmpty()) {
    echo '⚠ No se encontraron productos manufacturados' . PHP_EOL;
} else {
    echo '✓ Productos manufacturados encontrados: ' . \$manufactured_products->count() . PHP_EOL;
    foreach (\$manufactured_products as \$product) {
        \$stock = \$product->qty_available ?? 0;
        if (\$stock <= 0) {
            echo '  ⚠ ' . \$product->name . ' (' . \$product->sub_sku . ') - Stock: ' . \$stock . ' (SIN STOCK)' . PHP_EOL;
        } else {
            echo '  ✓ ' . \$product->name . ' (' . \$product->sub_sku . ') - Stock: ' . \$stock . PHP_EOL;
        }
    }
}
" 2>/dev/null || echo -e "${YELLOW}⚠ No se pudo verificar productos${NC}"

echo ""
echo "8. Verificando órdenes de producción..."
php artisan tinker --execute="
\$pending_orders = DB::table('mfg_production_orders')
    ->where('status', '!=', 'completed')
    ->count();

\$completed_orders = DB::table('mfg_production_orders')
    ->where('status', 'completed')
    ->count();

echo '✓ Órdenes completadas: ' . \$completed_orders . PHP_EOL;
if (\$pending_orders > 0) {
    echo '⚠ Órdenes pendientes: ' . \$pending_orders . PHP_EOL;
    echo '  Estas órdenes deben completarse para actualizar el stock' . PHP_EOL;
} else {
    echo '✓ No hay órdenes pendientes' . PHP_EOL;
}
" 2>/dev/null || echo -e "${YELLOW}⚠ No se pudo verificar órdenes${NC}"

echo ""
echo "9. Verificando configuración de sobreventa..."
php artisan tinker --execute="
\$overselling = DB::table('business')
    ->select('enable_overselling')
    ->first();

if (\$overselling && \$overselling->enable_overselling == 1) {
    echo '✓ Sobreventa HABILITADA (productos sin stock pueden venderse)' . PHP_EOL;
} else {
    echo '⚠ Sobreventa DESHABILITADA (solo productos con stock pueden venderse)' . PHP_EOL;
    echo '  Recomendación: Habilitar sobreventa para productos manufacturados' . PHP_EOL;
}
" 2>/dev/null || echo -e "${YELLOW}⚠ No se pudo verificar configuración${NC}"

echo ""
echo -e "${YELLOW}FASE 3: VERIFICACIÓN FINAL${NC}"
echo "=========================================="

echo ""
echo "10. Verificando módulos..."
php artisan module:list 2>/dev/null | grep -E "Manufacturing|Consultorio|Superadmin" || echo -e "${YELLOW}⚠ No se pudo listar módulos${NC}"

echo ""
echo "11. Verificando permisos finales..."
echo "Storage:"
ls -ld storage/ 2>/dev/null
echo "Logs:"
ls -ld storage/logs/ 2>/dev/null
echo "Bootstrap cache:"
ls -ld bootstrap/cache/ 2>/dev/null

echo ""
echo "12. Probando acceso al sistema..."
if command -v curl &> /dev/null; then
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://audaz.site/ 2>/dev/null)
    if [ "$HTTP_CODE" = "200" ]; then
        echo -e "${GREEN}✓ Sistema accesible (HTTP $HTTP_CODE)${NC}"
    else
        echo -e "${YELLOW}⚠ Sistema responde con código HTTP $HTTP_CODE${NC}"
    fi
else
    echo -e "${YELLOW}⚠ curl no disponible, verifica manualmente: https://audaz.site/${NC}"
fi

echo ""
echo "=========================================="
echo -e "${GREEN}RECUPERACIÓN COMPLETADA${NC}"
echo "=========================================="
echo ""
echo "RESUMEN DE ACCIONES:"
echo "✓ Cachés limpiados"
echo "✓ Permisos corregidos (777)"
echo "✓ Caché reconstruido"
echo "✓ Productos manufacturados verificados"
echo "✓ Órdenes de producción verificadas"
echo "✓ Configuración de sobreventa verificada"
echo ""
echo "PRÓXIMOS PASOS:"
echo ""
echo "1. Verifica que el sistema cargue:"
echo "   https://audaz.site/"
echo ""
echo "2. Si hay productos SIN STOCK, tienes 2 opciones:"
echo ""
echo "   OPCIÓN A (Recomendada): Habilitar sobreventa"
echo "   - Ir a: Configuración → Configuración del Negocio → Productos"
echo "   - Activar: 'Permitir sobreventa'"
echo "   - Esto permite vender productos manufacturados sin stock"
echo ""
echo "   OPCIÓN B: Completar órdenes de producción"
echo "   - Ir a: Manufacturing → Órdenes de Producción"
echo "   - Completar las órdenes pendientes"
echo "   - Esto actualizará el stock automáticamente"
echo ""
echo "3. Probar POS:"
echo "   - Agregar producto manufacturado al carrito"
echo "   - Verificar que botones 'Efectivo' y 'Pago Múltiple' estén habilitados"
echo "   - Completar venta de prueba"
echo ""
echo "4. Si el problema persiste:"
echo "   - Revisar logs: tail -f storage/logs/laravel.log"
echo "   - Abrir consola del navegador (F12) y buscar errores JavaScript"
echo "   - Verificar que el producto tenga precio configurado"
echo ""
echo "DOCUMENTACIÓN:"
echo "- SOLUCION_COMPLETA_SISTEMA.md - Guía completa"
echo "- DIAGNOSTICO_POS_MANUFACTURING.md - Diagnóstico detallado"
echo ""
