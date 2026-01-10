#!/bin/bash

# Script de instalación para Landing Page del Sistema POS
# Autor: Kiro AI Assistant
# Fecha: 2026

echo "================================================"
echo "  Instalación de Landing Page - Sistema POS"
echo "================================================"
echo ""

# Colores para output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Función para imprimir con color
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    print_error "Este script debe ejecutarse desde la raíz del proyecto Laravel"
    exit 1
fi

print_info "Iniciando instalación..."
echo ""

# 1. Crear directorios necesarios
print_info "Creando directorios..."
mkdir -p public/images/landing
mkdir -p public/css
mkdir -p public/js
print_success "Directorios creados"

# 2. Verificar archivos creados
print_info "Verificando archivos..."

files=(
    "public/css/landing.css"
    "public/js/landing.js"
    "Modules/Superadmin/Resources/views/landing/index.blade.php"
    "Modules/Superadmin/Resources/views/layouts/landing.blade.php"
    "Modules/Superadmin/Resources/views/pricing/modern.blade.php"
    "Modules/Superadmin/Http/Controllers/LandingController.php"
    "config/landing.php"
)

missing_files=0
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        print_success "$file"
    else
        print_error "Falta: $file"
        missing_files=$((missing_files + 1))
    fi
done

if [ $missing_files -gt 0 ]; then
    print_warning "$missing_files archivo(s) faltante(s)"
    echo ""
fi

# 3. Limpiar caché
print_info "Limpiando caché de Laravel..."
php artisan cache:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1
php artisan route:clear > /dev/null 2>&1
php artisan config:clear > /dev/null 2>&1
print_success "Caché limpiado"

# 4. Configurar permisos
print_info "Configurando permisos..."
chmod -R 755 public/images
chmod -R 755 public/css
chmod -R 755 public/js
print_success "Permisos configurados"

# 5. Descargar imágenes placeholder (opcional)
echo ""
read -p "¿Deseas descargar imágenes placeholder de ejemplo? (s/n): " download_images

if [ "$download_images" = "s" ] || [ "$download_images" = "S" ]; then
    print_info "Descargando imágenes placeholder..."
    
    # Dashboard preview
    curl -s "https://placehold.co/1200x800/667eea/white?text=Dashboard+Preview" \
         -o public/images/landing/dashboard-preview.png
    
    # POS interface
    curl -s "https://placehold.co/800x600/10b981/white?text=POS+Interface" \
         -o public/images/landing/pos-interface.png
    
    # Avatars
    curl -s "https://ui-avatars.com/api/?name=Maria+Gonzalez&size=200&background=667eea&color=fff" \
         -o public/images/landing/avatar1.jpg
    
    curl -s "https://ui-avatars.com/api/?name=Carlos+Ruiz&size=200&background=10b981&color=fff" \
         -o public/images/landing/avatar2.jpg
    
    curl -s "https://ui-avatars.com/api/?name=Ana+Martinez&size=200&background=f59e0b&color=fff" \
         -o public/images/landing/avatar3.jpg
    
    print_success "Imágenes placeholder descargadas"
else
    print_warning "Recuerda agregar tus propias imágenes en public/images/landing/"
fi

# 6. Verificar configuración de .env
echo ""
print_info "Verificando configuración .env..."

if [ ! -f ".env" ]; then
    print_warning "Archivo .env no encontrado. Copiando desde .env.example..."
    cp .env.example .env
    print_success ".env creado"
fi

# Verificar variables importantes
if ! grep -q "CONTACT_EMAIL" .env; then
    print_warning "Variables de landing page no encontradas en .env"
    print_info "Agregando variables de configuración..."
    
    cat >> .env << 'EOF'

# LANDING PAGE CONFIGURATION
CONTACT_EMAIL=contacto@tuempresa.com
CONTACT_PHONE="+1 234 567 8900"
CONTACT_ADDRESS="Tu dirección aquí"
WHATSAPP_NUMBER=

# SOCIAL MEDIA
FACEBOOK_URL=
TWITTER_URL=
INSTAGRAM_URL=
LINKEDIN_URL=
YOUTUBE_URL=

# ANALYTICS
GOOGLE_ANALYTICS_ID=
FACEBOOK_PIXEL_ID=
GOOGLE_TAG_MANAGER_ID=

# FEATURES
ENABLE_CHAT_WIDGET=false
ENABLE_BLOG=false
ENABLE_DEMO_REQUEST=true
ENABLE_NEWSLETTER=true
EOF
    
    print_success "Variables agregadas a .env"
fi

# 7. Cachear configuración
print_info "Cacheando configuración..."
php artisan config:cache > /dev/null 2>&1
print_success "Configuración cacheada"

# 8. Verificar paquetes en la base de datos
echo ""
print_info "Verificando paquetes de suscripción..."
package_count=$(php artisan tinker --execute="echo \Modules\Superadmin\Entities\Package::count();" 2>/dev/null | tail -1)

if [ "$package_count" = "0" ] || [ -z "$package_count" ]; then
    print_warning "No se encontraron paquetes de suscripción"
    print_info "Debes crear paquetes desde el panel de superadmin:"
    echo "   1. Accede a /superadmin/packages"
    echo "   2. Crea al menos 3 paquetes (Básico, Profesional, Empresarial)"
    echo "   3. Configura precios y características"
else
    print_success "Se encontraron $package_count paquete(s)"
fi

# 9. Resumen final
echo ""
echo "================================================"
echo "  ✓ Instalación Completada"
echo "================================================"
echo ""
print_success "Landing page instalada correctamente"
echo ""
echo "Rutas disponibles:"
echo "  • Landing Page:  ${BLUE}http://localhost/${NC}"
echo "  • Pricing:       ${BLUE}http://localhost/pricing${NC}"
echo "  • Features:      ${BLUE}http://localhost/features${NC}"
echo "  • About:         ${BLUE}http://localhost/about${NC}"
echo ""
echo "Próximos pasos:"
echo "  1. ${YELLOW}Personaliza el contenido${NC} en:"
echo "     - Modules/Superadmin/Resources/views/landing/index.blade.php"
echo "     - config/landing.php"
echo ""
echo "  2. ${YELLOW}Agrega tus imágenes${NC} en:"
echo "     - public/images/landing/"
echo ""
echo "  3. ${YELLOW}Configura tus paquetes${NC} en:"
echo "     - /superadmin/packages"
echo ""
echo "  4. ${YELLOW}Personaliza colores${NC} en:"
echo "     - public/css/landing.css (variables CSS)"
echo ""
echo "  5. ${YELLOW}Actualiza .env${NC} con:"
echo "     - Información de contacto"
echo "     - Redes sociales"
echo "     - IDs de analytics"
echo ""
print_info "Lee LANDING_PAGE_README.md para más información"
echo ""
echo "================================================"
echo "  ¡Listo para vender! 🚀"
echo "================================================"
