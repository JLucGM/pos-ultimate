#!/bin/bash

# Script para desplegar corrección del dashboard multimoneda
# Uso: ./deploy-dashboard-fix.sh

set -e

# Colores
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}  🚀 Deployment: Fix Dashboard Multimoneda${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

SERVER="root@audaz.site"
REMOTE_PATH="/home/audaz.site/public_html"

echo -e "${BLUE}📤 Subiendo archivos al servidor...${NC}"

# Subir HomeController
scp app/Http/Controllers/HomeController.php $SERVER:$REMOTE_PATH/app/Http/Controllers/

# Subir vista del dashboard
scp resources/views/home/index.blade.php $SERVER:$REMOTE_PATH/resources/views/home/

# Subir config de constantes
scp config/constants.php $SERVER:$REMOTE_PATH/config/

echo -e "${GREEN}✓ Archivos subidos${NC}"

echo ""
echo -e "${BLUE}🧹 Limpiando caché en servidor...${NC}"

ssh $SERVER "cd $REMOTE_PATH && php artisan optimize:clear"

echo -e "${GREEN}✓ Caché limpiado${NC}"

echo ""
echo -e "${BLUE}🔐 Configurando permisos...${NC}"

ssh $SERVER "cd $REMOTE_PATH && chmod -R 777 storage bootstrap/cache"

echo -e "${GREEN}✓ Permisos configurados${NC}"

echo ""
echo -e "${GREEN}✅ Deployment completado!${NC}"
echo ""
echo -e "${BLUE}Cambios aplicados:${NC}"
echo "  • Corregido campo 'rate' en lugar de 'exchange_rate'"
echo "  • Widget de tasa de cambio con colores consistentes (sky-blue)"
echo "  • Tamaño de fuente ajustado a xl (consistente con otros widgets)"
echo "  • Grid de 3 columnas en desktop"
echo ""
echo -e "${BLUE}Verifica en: https://audaz.site/${NC}"
echo ""
