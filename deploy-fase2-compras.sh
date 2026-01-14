#!/bin/bash

echo "========================================="
echo "Deployment Fase 2: Compras Multimoneda"
echo "========================================="
echo ""

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: No se encuentra el archivo artisan. Asegúrate de estar en el directorio raíz del proyecto.${NC}"
    exit 1
fi

echo -e "${YELLOW}1. Haciendo pull de los cambios...${NC}"
git pull origin main
if [ $? -ne 0 ]; then
    echo -e "${RED}Error al hacer git pull${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Pull completado${NC}"
echo ""

echo -e "${YELLOW}2. Ejecutando migraciones...${NC}"
php artisan migrate --force
if [ $? -ne 0 ]; then
    echo -e "${RED}Error al ejecutar migraciones${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Migraciones completadas${NC}"
echo ""

echo -e "${YELLOW}3. Limpiando caché...${NC}"
php artisan optimize:clear
if [ $? -ne 0 ]; then
    echo -e "${RED}Error al limpiar caché${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Caché limpiado${NC}"
echo ""

echo -e "${YELLOW}4. Ajustando permisos...${NC}"
chmod -R 777 storage bootstrap/cache
if [ $? -ne 0 ]; then
    echo -e "${RED}Error al ajustar permisos${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Permisos ajustados${NC}"
echo ""

echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}Deployment completado exitosamente!${NC}"
echo -e "${GREEN}=========================================${NC}"
echo ""
echo -e "${YELLOW}Próximos pasos para probar:${NC}"
echo "1. Ir a Compras > Agregar Compra"
echo "2. Seleccionar una moneda (USD o Bs)"
echo "3. Verificar que la tasa de cambio se actualiza automáticamente"
echo "4. Crear una compra de prueba"
echo ""
