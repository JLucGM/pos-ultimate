# ✅ Checklist Rápido de Deployment

## 🏠 En tu Máquina Local (ANTES de subir)

### 1. Preparar el Commit
```bash
# Ver cambios
git status

# Agregar archivos
git add .

# Commit
git commit -m "feat: Add landing page and pricing system"

# Push
git push origin main
```

**Archivos que se subirán:**
- ✅ Controladores (LandingController.php)
- ✅ Vistas (landing/, pricing/modern.blade.php)
- ✅ CSS y JS (landing.css, landing.js)
- ✅ Configuración (config/landing.php)
- ✅ Rutas actualizadas (web.php)
- ✅ Vistas corregidas (auth2, headers)

**Archivos que NO se suben (agregar a .gitignore):**
- ❌ Imágenes (public/images/landing/*.jpg, *.png)
- ❌ .env (ya está en .gitignore)

## 🚀 En el Servidor de Producción

### Opción A: Usar el Script Automático (RECOMENDADO)

```bash
# 1. Conectarte al servidor
ssh usuario@tuservidor.com

# 2. Ir al directorio del proyecto
cd /ruta/a/tu/proyecto

# 3. Subir el script (si no está en el repo)
# Copia el contenido de deploy-produccion.sh y créalo en el servidor

# 4. Ejecutar
./deploy-produccion.sh
```

### Opción B: Manual (Paso a Paso)

```bash
# 1. Conectarte al servidor
ssh usuario@tuservidor.com

# 2. Ir al directorio
cd /ruta/a/tu/proyecto

# 3. Modo mantenimiento
php artisan down --message="Actualizando" --retry=60

# 4. Pull cambios
git pull origin main

# 5. Instalar dependencias
composer install --no-dev --optimize-autoloader

# 6. Crear directorios
mkdir -p public/images/landing
chmod -R 775 public/images/landing

# 7. Limpiar caché
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# 8. Cachear para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Optimizar
composer dump-autoload -o

# 10. Permisos
chmod -R 775 storage bootstrap/cache

# 11. Activar sitio
php artisan up
```

## 🖼️ Subir Imágenes (IMPORTANTE)

Las imágenes NO están en Git. Debes subirlas manualmente:

### Via SCP (desde tu máquina local)
```bash
scp -r public/images/landing/* usuario@servidor:/ruta/proyecto/public/images/landing/
```

### Via SFTP (FileZilla, Cyberduck, etc.)
1. Conectar al servidor
2. Navegar a `/ruta/proyecto/public/images/landing/`
3. Subir las imágenes

### Via SSH (placeholders temporales)
```bash
cd /ruta/proyecto/public/images/landing/
curl -o dashboard-preview.png "https://placehold.co/1200x800/667eea/white?text=Dashboard"
curl -o pos-interface.png "https://placehold.co/800x600/10b981/white?text=POS"
curl -o avatar1.jpg "https://ui-avatars.com/api/?name=Maria+Gonzalez&size=200"
curl -o avatar2.jpg "https://ui-avatars.com/api/?name=Carlos+Ruiz&size=200"
curl -o avatar3.jpg "https://ui-avatars.com/api/?name=Ana+Martinez&size=200"
```

## ⚙️ Configurar .env en Producción

```bash
# En el servidor
nano .env  # o vim .env
```

Agregar/actualizar:
```env
# Landing Page
CONTACT_EMAIL=contacto@tuempresa.com
CONTACT_PHONE="+52 55 1234 5678"
CONTACT_ADDRESS="Tu dirección"
WHATSAPP_NUMBER=5215512345678

# Redes Sociales
FACEBOOK_URL=https://facebook.com/tuempresa
TWITTER_URL=https://twitter.com/tuempresa
INSTAGRAM_URL=https://instagram.com/tuempresa
LINKEDIN_URL=https://linkedin.com/company/tuempresa

# Analytics (opcional)
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX

# IMPORTANTE
APP_ENV=production
APP_DEBUG=false
```

Después:
```bash
php artisan config:cache
```

## 🔍 Verificar que Todo Funcione

### 1. Desde el servidor
```bash
# Ver logs
tail -f storage/logs/laravel.log

# Probar URLs
curl -I https://tudominio.com/
curl -I https://tudominio.com/pricing
```

### 2. Desde el navegador
- ✅ https://tudominio.com/ (Landing)
- ✅ https://tudominio.com/pricing (Pricing)
- ✅ https://tudominio.com/login (Login)

### 3. Desde el móvil
- ✅ Diseño responsive
- ✅ Menú hamburguesa funciona
- ✅ Botones funcionan

## 🚨 Si Algo Sale Mal

### Error 500
```bash
tail -n 100 storage/logs/laravel.log
chmod -R 775 storage bootstrap/cache
php artisan cache:clear
```

### CSS/JS no cargan
```bash
ls -la public/css/landing.css
ls -la public/js/landing.js
chmod 644 public/css/landing.css
chmod 644 public/js/landing.js
```

### Imágenes no cargan
```bash
ls -la public/images/landing/
chmod -R 755 public/images/landing/
```

### Rutas no funcionan
```bash
php artisan route:clear
php artisan route:cache
```

## 📊 Después del Deployment

### Inmediatamente
- [ ] Verificar que el sitio cargue
- [ ] Probar todas las páginas
- [ ] Revisar logs por errores
- [ ] Probar en móvil

### Primeras 24 horas
- [ ] Monitorear logs constantemente
- [ ] Verificar que no haya errores
- [ ] Recopilar feedback inicial

### Primera semana
- [ ] Revisar analytics
- [ ] Hacer ajustes según feedback
- [ ] Optimizar según sea necesario

## 🎯 Resumen Ultra-Rápido

```bash
# LOCAL
git add .
git commit -m "feat: Add landing page"
git push origin main

# SERVIDOR
ssh usuario@servidor
cd /ruta/proyecto
./deploy-produccion.sh

# CONFIGURAR
nano .env  # Agregar variables de landing
php artisan config:cache

# SUBIR IMÁGENES
scp -r public/images/landing/* usuario@servidor:/ruta/proyecto/public/images/landing/

# VERIFICAR
# Abrir https://tudominio.com/ en el navegador
```

## ✅ Checklist Final

- [ ] Código subido al repo
- [ ] Deployment ejecutado en servidor
- [ ] .env configurado
- [ ] Imágenes subidas
- [ ] Sitio funciona sin errores
- [ ] Responsive funciona
- [ ] Login sigue funcionando
- [ ] No hay errores en logs

## 🎉 ¡Listo!

Si todos los checks están ✅, tu landing page está en producción.

---

**Tiempo estimado total**: 15-30 minutos

**Dificultad**: ⭐⭐☆☆☆ (Fácil-Medio)
