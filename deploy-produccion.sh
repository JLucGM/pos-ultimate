#!/bin/bash

# Script de Deployment para Landing Page en Producción
# Uso: ./deploy-produccion.sh

set -e  # Detener si hay errores

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}  🚀 Deployment Landing Page - Producción${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Error: Este script debe ejecutarse desde la raíz del proyecto Laravel${NC}"
    exit 1
fi

# Confirmar deployment
echo -e "${YELLOW}⚠️  Estás a punto de hacer deployment a PRODUCCIÓN${NC}"
read -p "¿Continuar? (s/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo -e "${RED}❌ Deployment cancelado${NC}"
    exit 1
fi

echo ""
echo -e "${BLUE}📋 Paso 1: Modo Mantenimiento${NC}"
php artisan down --message="Actualizando sistema" --retry=60 || true
echo -e "${GREEN}✓ Sitio en modo mantenimiento${NC}"

echo ""
echo -e "${BLUE}📦 Paso 2: Actualizando código${NC}"
git pull origin main
echo -e "${GREEN}✓ Código actualizado${NC}"

echo ""
echo -e "${BLUE}📚 Paso 3: Instalando dependencias${NC}"
composer install --no-dev --optimize-autoloader --no-interaction
echo -e "${GREEN}✓ Dependencias instaladas${NC}"

echo ""
echo -e "${BLUE}📁 Paso 4: Creando directorios${NC}"
mkdir -p public/images/landing
chmod -R 775 public/images/landing
echo -e "${GREEN}✓ Directorios creados${NC}"

echo ""
echo -e "${BLUE}🧹 Paso 5: Limpiando caché${NC}"
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
echo -e "${GREEN}✓ Caché limpiado${NC}"

echo ""
echo -e "${BLUE}⚡ Paso 6: Optimizando para producción${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload -o
echo -e "${GREEN}✓ Optimización completada${NC}"

echo ""
echo -e "${BLUE}🔐 Paso 7: Configurando permisos${NC}"
chmod -R 775 storage bootstrap/cache
# Descomentar si usas www-data
# chown -R www-data:www-data storage bootstrap/cache
echo -e "${GREEN}✓ Permisos configurados${NC}"

echo ""
echo -e "${BLUE}🔍 Paso 8: Verificando archivos críticos${NC}"

critical_files=(
    "Modules/Superadmin/Http/Controllers/LandingController.php"
    "Modules/Superadmin/Resources/views/landing/index.blade.php"
    "Modules/Superadmin/Resources/views/layouts/landing.blade.php"
    "public/css/landing.css"
    "public/js/landing.js"
    "config/landing.php"
)

all_ok=true
for file in "${critical_files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}  ✓ $file${NC}"
    else
        echo -e "${RED}  ✗ $file (FALTA)${NC}"
        all_ok=false
    fi
done

if [ "$all_ok" = false ]; then
    echo -e "${RED}❌ Faltan archivos críticos. Revisa el deployment.${NC}"
    php artisan up
    exit 1
fi

echo ""
echo -e "${BLUE}✅ Paso 9: Activando sitio${NC}"
php artisan up
echo -e "${GREEN}✓ Sitio activado${NC}"

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${GREEN}✅ Deployment completado exitosamente!${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

echo -e "${YELLOW}📋 Próximos pasos:${NC}"
echo ""
echo "1. Verifica el sitio en tu navegador"
echo "2. Revisa los logs: tail -f storage/logs/laravel.log"
echo "3. Sube las imágenes a public/images/landing/"
echo "4. Configura las variables en .env (contacto, redes sociales)"
echo "5. Crea los paquetes en /superadmin/packages"
echo ""

echo -e "${BLUE}🔗 URLs para verificar:${NC}"
echo "  • Landing: https://tudominio.com/"
echo "  • Pricing: https://tudominio.com/pricing"
echo "  • Login:   https://tudominio.com/login"
echo ""

echo -e "${GREEN}¡Listo para vender! 🎉${NC}"
echo ""
