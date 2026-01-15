#!/bin/bash

# Script de Deployment del Módulo Manufacturing
# Uso: ./deploy-manufacturing.sh

set -e

# Colores
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}  🏭 Deployment: Módulo Manufacturing${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

SERVER="root@audaz.site"
REMOTE_PATH="/home/audaz.site/public_html"

echo -e "${BLUE}📤 Subiendo módulo al servidor...${NC}"

# Subir todo el módulo Manufacturing
scp -r Modules/Manufacturing $SERVER:$REMOTE_PATH/Modules/

echo -e "${GREEN}✓ Módulo subido${NC}"

echo ""
echo -e "${BLUE}🔧 Configurando en servidor...${NC}"

ssh $SERVER << EOF
cd $REMOTE_PATH

echo "Regenerando autoload..."
composer dump-autoload

echo "Ejecutando migraciones..."
php artisan migrate --force

echo "Limpiando caché..."
php artisan optimize:clear

echo "Configurando permisos..."
chmod -R 777 storage bootstrap/cache

echo "✅ Configuración completada"
EOF

echo -e "${GREEN}✓ Configuración completada${NC}"

echo ""
echo -e "${GREEN}✅ Deployment completado!${NC}"
echo ""
echo -e "${BLUE}📋 Próximos pasos:${NC}"
echo ""
echo "1. Agregar permisos en la base de datos (ver INSTALACION_MODULO_MANUFACTURING.md)"
echo "2. Agregar menú en el sidebar"
echo "3. Acceder a: https://audaz.site/manufacturing/recipes"
echo ""
echo -e "${YELLOW}⚠️  IMPORTANTE: Ejecuta el SQL de permisos en la base de datos${NC}"
echo ""
