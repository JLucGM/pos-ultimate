# 🚀 Guía de Deployment a Producción - Landing Page

## 📋 Checklist Pre-Deployment

Antes de subir a producción, verifica:

### ✅ En tu Entorno Local

- [ ] La landing page funciona correctamente en local
- [ ] No hay errores en los logs (`storage/logs/laravel.log`)
- [ ] Todas las rutas funcionan (`/`, `/pricing`)
- [ ] Las imágenes cargan correctamente
- [ ] El diseño se ve bien en móvil y desktop
- [ ] Has personalizado el contenido básico

### ✅ Archivos a Subir al Repo

Estos son TODOS los archivos nuevos/modificados que debes commitear:

```bash
# Archivos NUEVOS
Modules/Superadmin/Http/Controllers/LandingController.php
Modules/Superadmin/Resources/views/landing/index.blade.php
Modules/Superadmin/Resources/views/layouts/landing.blade.php
Modules/Superadmin/Resources/views/pricing/modern.blade.php
public/css/landing.css
public/js/landing.js
public/images/landing/.gitkeep
config/landing.php

# Archivos MODIFICADOS
Modules/Superadmin/Routes/web.php
.env.example
resources/views/layouts/auth2.blade.php
resources/views/layouts/partials/home_header.blade.php
resources/views/layouts/partials/header-auth.blade.php

# Documentación (OPCIONAL - no afecta funcionamiento)
LANDING_PAGE_README.md
PERSONALIZACION_RAPIDA.md
FUNCIONALIDADES_EXTRAS.md
RESUMEN_PROYECTO.md
CHECKLIST_LANZAMIENTO.md
COMANDOS_UTILES.md
SOLUCION_ERROR_PRICING.md
install-landing.sh
```

## 🔄 Proceso de Deployment

### Paso 1: Preparar el Commit

```bash
# Ver qué archivos han cambiado
git status

# Agregar los archivos necesarios
git add Modules/Superadmin/Http/Controllers/LandingController.php
git add Modules/Superadmin/Resources/views/landing/
git add Modules/Superadmin/Resources/views/layouts/landing.blade.php
git add Modules/Superadmin/Resources/views/pricing/modern.blade.php
git add Modules/Superadmin/Routes/web.php
git add public/css/landing.css
git add public/js/landing.js
git add public/images/landing/
git add config/landing.php
git add .env.example
git add resources/views/layouts/auth2.blade.php
git add resources/views/layouts/partials/home_header.blade.php
git add resources/views/layouts/partials/header-auth.blade.php

# O agregar todo junto (si estás seguro)
git add .

# Hacer commit
git commit -m "feat: Add modern landing page and pricing system

- Add LandingController for public pages
- Create modern landing page with hero, features, testimonials
- Add improved pricing page with monthly/annual toggle
- Update routes to use new landing system
- Fix PricingController references in views
- Add landing page configuration file
- Include responsive CSS and interactive JavaScript"

# Push al repositorio
git push origin main  # o tu rama principal
```

### Paso 2: En el Servidor de Producción

Conéctate a tu servidor y ejecuta:

```bash
# 1. Ir al directorio del proyecto
cd /ruta/a/tu/proyecto

# 2. Hacer backup (IMPORTANTE)
php artisan down --message="Actualizando sistema" --retry=60

# 3. Backup de base de datos (por si acaso)
php artisan backup:run  # Si tienes configurado backup
# O manualmente:
# mysqldump -u usuario -p nombre_db > backup_$(date +%Y%m%d_%H%M%S).sql

# 4. Pull de los cambios
git pull origin main  # o tu rama

# 5. Instalar/actualizar dependencias (si es necesario)
composer install --no-dev --optimize-autoloader

# 6. Crear directorios necesarios
mkdir -p public/images/landing
chmod -R 775 public/images/landing

# 7. Limpiar TODA la caché
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# 8. Cachear para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Optimizar autoload
composer dump-autoload -o

# 10. Verificar permisos
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache  # Ajustar según tu servidor

# 11. Activar el sitio
php artisan up
```

## ⚙️ Configuración del .env en Producción

Después del deployment, edita el `.env` en producción:

```bash
# En el servidor
nano .env  # o vim .env
```

Agrega/actualiza estas variables:

```env
# LANDING PAGE CONFIGURATION
CONTACT_EMAIL=contacto@tuempresa.com
CONTACT_PHONE="+52 55 1234 5678"
CONTACT_ADDRESS="Tu dirección real"
WHATSAPP_NUMBER=5215512345678

# SOCIAL MEDIA
FACEBOOK_URL=https://facebook.com/tuempresa
TWITTER_URL=https://twitter.com/tuempresa
INSTAGRAM_URL=https://instagram.com/tuempresa
LINKEDIN_URL=https://linkedin.com/company/tuempresa

# ANALYTICS (si los tienes)
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
FACEBOOK_PIXEL_ID=
GOOGLE_TAG_MANAGER_ID=

# FEATURES
ENABLE_CHAT_WIDGET=false
ENABLE_BLOG=false
ENABLE_DEMO_REQUEST=true
ENABLE_NEWSLETTER=true

# IMPORTANTE: Asegúrate de que esté en producción
APP_ENV=production
APP_DEBUG=false
```

Después de editar el `.env`:

```bash
# Cachear la nueva configuración
php artisan config:cache
```

## 🖼️ Subir Imágenes a Producción

Las imágenes NO se suben al repositorio Git. Debes subirlas manualmente:

### Opción 1: Via SCP/SFTP

```bash
# Desde tu máquina local
scp -r public/images/landing/* usuario@servidor:/ruta/proyecto/public/images/landing/
```

### Opción 2: Via Panel de Control (cPanel, Plesk, etc.)

1. Accede al File Manager
2. Navega a `public/images/landing/`
3. Sube las imágenes manualmente

### Opción 3: Via SSH

```bash
# En el servidor
cd /ruta/proyecto/public/images/landing/

# Descargar imágenes placeholder temporales
curl -o dashboard-preview.png "https://placehold.co/1200x800/667eea/white?text=Dashboard+Preview"
curl -o pos-interface.png "https://placehold.co/800x600/10b981/white?text=POS+Interface"
curl -o avatar1.jpg "https://ui-avatars.com/api/?name=Maria+Gonzalez&size=200&background=667eea&color=fff"
curl -o avatar2.jpg "https://ui-avatars.com/api/?name=Carlos+Ruiz&size=200&background=10b981&color=fff"
curl -o avatar3.jpg "https://ui-avatars.com/api/?name=Ana+Martinez&size=200&background=f59e0b&color=fff"
```

## 🔍 Verificación Post-Deployment

Después del deployment, verifica:

### 1. Verificar que el sitio funcione

```bash
# En el servidor
curl -I https://tudominio.com/
curl -I https://tudominio.com/pricing
```

Deberías ver `HTTP/2 200` en ambos.

### 2. Verificar logs

```bash
# Ver últimos errores
tail -n 50 storage/logs/laravel.log

# Monitorear en tiempo real
tail -f storage/logs/laravel.log
```

### 3. Verificar desde el navegador

Abre en tu navegador:
- ✅ `https://tudominio.com/` - Landing page
- ✅ `https://tudominio.com/pricing` - Pricing
- ✅ `https://tudominio.com/login` - Login (debe funcionar normal)
- ✅ `https://tudominio.com/home` - Dashboard (después de login)

### 4. Verificar en móvil

Abre desde tu teléfono y verifica que:
- El diseño sea responsive
- Los botones funcionen
- El menú hamburguesa funcione
- Las imágenes carguen

## 🚨 Troubleshooting en Producción

### Error 500

```bash
# Ver el error exacto
tail -n 100 storage/logs/laravel.log

# Verificar permisos
ls -la storage/
ls -la bootstrap/cache/

# Corregir permisos
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### CSS/JS no se aplican

```bash
# Verificar que los archivos existan
ls -la public/css/landing.css
ls -la public/js/landing.js

# Verificar permisos
chmod 644 public/css/landing.css
chmod 644 public/js/landing.js

# Limpiar caché del navegador
# Ctrl + Shift + R (o Cmd + Shift + R)
```

### Imágenes no cargan

```bash
# Verificar que existan
ls -la public/images/landing/

# Verificar permisos
chmod -R 755 public/images/landing/

# Verificar en el navegador
curl -I https://tudominio.com/images/landing/dashboard-preview.png
```

### Error de rutas

```bash
# Limpiar y recachear rutas
php artisan route:clear
php artisan route:cache

# Verificar que la ruta exista
php artisan route:list | grep pricing
```

## 🔐 Seguridad en Producción

### 1. Verificar configuración de producción

```bash
# En .env debe estar:
APP_ENV=production
APP_DEBUG=false
```

### 2. Proteger archivos sensibles

```bash
# Verificar que .env no sea accesible públicamente
curl https://tudominio.com/.env
# Debe dar 404 o 403
```

### 3. HTTPS

Asegúrate de que tu sitio use HTTPS:
- Instala certificado SSL (Let's Encrypt es gratis)
- Fuerza HTTPS en tu servidor web

## 📊 Monitoreo Post-Lanzamiento

### Primeras 24 horas

```bash
# Monitorear logs constantemente
tail -f storage/logs/laravel.log

# Verificar uso de recursos
top
htop

# Verificar espacio en disco
df -h
```

### Primera semana

- Revisar Google Analytics (si lo configuraste)
- Verificar que no haya errores en logs
- Recopilar feedback de usuarios
- Hacer ajustes según sea necesario

## 📝 Script de Deployment Automatizado

Puedes crear un script para automatizar el proceso:

```bash
# deploy.sh
#!/bin/bash

echo "🚀 Iniciando deployment..."

# Modo mantenimiento
php artisan down --message="Actualizando" --retry=60

# Pull cambios
git pull origin main

# Dependencias
composer install --no-dev --optimize-autoloader

# Limpiar caché
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Cachear para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimizar
composer dump-autoload -o

# Permisos
chmod -R 775 storage bootstrap/cache

# Activar sitio
php artisan up

echo "✅ Deployment completado!"
```

Uso:
```bash
chmod +x deploy.sh
./deploy.sh
```

## ✅ Checklist Final

Antes de considerar el deployment exitoso:

- [ ] El sitio carga sin errores
- [ ] La landing page se ve correctamente
- [ ] La página de pricing funciona
- [ ] El login sigue funcionando
- [ ] El dashboard funciona normal
- [ ] Las imágenes cargan
- [ ] El diseño es responsive
- [ ] No hay errores en los logs
- [ ] El SSL/HTTPS funciona
- [ ] Los formularios funcionan
- [ ] Los enlaces de redes sociales son correctos
- [ ] La información de contacto es correcta

## 🎉 ¡Listo!

Si todos los checks están ✅, tu landing page está en producción y lista para recibir clientes.

## 📞 Soporte

Si encuentras problemas:

1. Revisa los logs: `storage/logs/laravel.log`
2. Verifica la configuración: `.env`
3. Limpia la caché: `php artisan optimize:clear`
4. Verifica permisos de archivos
5. Consulta esta documentación

---

**Importante**: Siempre haz un backup antes de hacer cambios en producción.
