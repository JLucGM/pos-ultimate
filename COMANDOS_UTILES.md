# 🛠️ Comandos Útiles - Landing Page POS

## 🚀 Instalación y Configuración

### Instalación Rápida
```bash
# Ejecutar instalador automático
./install-landing.sh

# O manualmente:
chmod +x install-landing.sh
bash install-landing.sh
```

### Configuración Inicial
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar key de aplicación
php artisan key:generate

# Limpiar y cachear configuración
php artisan config:clear
php artisan config:cache
```

## 🧹 Limpieza de Caché

### Limpiar Todo
```bash
# Limpiar todas las cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# O en un solo comando
php artisan optimize:clear
```

### Cachear para Producción
```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache

# Todo junto
php artisan optimize
```

## 📁 Gestión de Archivos

### Crear Directorios
```bash
# Crear directorio de imágenes
mkdir -p public/images/landing

# Dar permisos correctos
chmod -R 755 public/images
chmod -R 755 storage
```

### Verificar Archivos Creados
```bash
# Listar archivos de landing
ls -la Modules/Superadmin/Resources/views/landing/
ls -la public/css/landing.css
ls -la public/js/landing.js
```

### Backup de Archivos
```bash
# Crear backup de la landing page
tar -czf landing-backup-$(date +%Y%m%d).tar.gz \
  Modules/Superadmin/Resources/views/landing/ \
  Modules/Superadmin/Resources/views/layouts/landing.blade.php \
  Modules/Superadmin/Resources/views/pricing/modern.blade.php \
  Modules/Superadmin/Http/Controllers/LandingController.php \
  public/css/landing.css \
  public/js/landing.js \
  config/landing.php
```

## 🗄️ Base de Datos

### Migraciones
```bash
# Ejecutar migraciones
php artisan migrate

# Rollback última migración
php artisan migrate:rollback

# Refrescar base de datos (¡CUIDADO! Borra datos)
php artisan migrate:fresh
```

### Seeders
```bash
# Ejecutar todos los seeders
php artisan db:seed

# Ejecutar seeder específico
php artisan db:seed --class=PackageSeeder
```

### Tinker (Consola Interactiva)
```bash
# Abrir tinker
php artisan tinker

# Ejemplos de comandos en tinker:
# Ver paquetes
\Modules\Superadmin\Entities\Package::all();

# Contar paquetes
\Modules\Superadmin\Entities\Package::count();

# Crear paquete de prueba
$package = new \Modules\Superadmin\Entities\Package();
$package->name = 'Plan Básico';
$package->price = 29;
$package->interval = 'months';
$package->interval_count = 1;
$package->is_active = 1;
$package->save();
```

## 🔍 Debugging

### Ver Logs
```bash
# Ver últimas líneas del log
tail -f storage/logs/laravel.log

# Ver últimas 100 líneas
tail -n 100 storage/logs/laravel.log

# Buscar errores
grep "ERROR" storage/logs/laravel.log
```

### Modo Debug
```bash
# Activar modo debug (solo desarrollo)
# En .env cambiar:
APP_DEBUG=true

# Desactivar en producción
APP_DEBUG=false
```

### Verificar Rutas
```bash
# Listar todas las rutas
php artisan route:list

# Filtrar rutas de landing
php artisan route:list | grep landing

# Filtrar rutas de pricing
php artisan route:list | grep pricing
```

## 🎨 Assets (CSS/JS)

### Compilar Assets (si usas Laravel Mix)
```bash
# Instalar dependencias
npm install

# Compilar para desarrollo
npm run dev

# Compilar para producción
npm run production

# Watch (recompilar automáticamente)
npm run watch
```

### Minificar CSS Manualmente
```bash
# Usando cssnano (instalar primero: npm install -g cssnano-cli)
cssnano public/css/landing.css public/css/landing.min.css
```

### Minificar JS Manualmente
```bash
# Usando uglify-js (instalar primero: npm install -g uglify-js)
uglifyjs public/js/landing.js -o public/js/landing.min.js -c -m
```

## 🖼️ Optimización de Imágenes

### Usando ImageMagick
```bash
# Instalar ImageMagick (macOS)
brew install imagemagick

# Redimensionar imagen
convert input.jpg -resize 1200x800 output.jpg

# Comprimir imagen
convert input.jpg -quality 85 output.jpg

# Convertir a WebP
convert input.jpg -quality 85 output.webp

# Procesar todas las imágenes en un directorio
for img in public/images/landing/*.jpg; do
  convert "$img" -quality 85 -resize 1200x800 "${img%.jpg}-optimized.jpg"
done
```

### Usando TinyPNG CLI
```bash
# Instalar tinypng-cli
npm install -g tinypng-cli

# Configurar API key
tinypng set-key YOUR_API_KEY

# Comprimir imagen
tinypng public/images/landing/dashboard-preview.png

# Comprimir todas las imágenes
tinypng public/images/landing/*.{png,jpg}
```

## 🧪 Testing

### Ejecutar Tests
```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests específicos
php artisan test --filter LandingTest

# Con coverage
php artisan test --coverage
```

### Crear Tests
```bash
# Crear test
php artisan make:test LandingPageTest

# Crear test unitario
php artisan make:test LandingPageTest --unit
```

## 📊 Performance

### Verificar Velocidad
```bash
# Usando curl
curl -o /dev/null -s -w "Time: %{time_total}s\n" http://localhost/

# Usando Apache Bench
ab -n 100 -c 10 http://localhost/
```

### Optimizar Autoload
```bash
# Optimizar autoload de Composer
composer dump-autoload -o
```

### Habilitar OPcache
```bash
# Verificar si OPcache está habilitado
php -i | grep opcache

# Limpiar OPcache
php artisan opcache:clear
```

## 🔒 Seguridad

### Generar Nueva Key
```bash
# Generar nueva application key
php artisan key:generate
```

### Permisos Correctos
```bash
# Permisos para storage y bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Propietario correcto (ajustar según tu servidor)
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### Verificar Vulnerabilidades
```bash
# Verificar dependencias de Composer
composer audit

# Verificar dependencias de NPM
npm audit
```

## 🌐 Deployment

### Preparar para Producción
```bash
# 1. Actualizar dependencias
composer install --optimize-autoloader --no-dev

# 2. Cachear todo
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Optimizar autoload
composer dump-autoload -o

# 4. Compilar assets
npm run production

# 5. Verificar permisos
chmod -R 775 storage bootstrap/cache
```

### Deploy con Git
```bash
# En servidor de producción
cd /path/to/project

# Pull últimos cambios
git pull origin main

# Actualizar dependencias
composer install --no-dev

# Ejecutar migraciones
php artisan migrate --force

# Limpiar y cachear
php artisan optimize

# Reiniciar servicios
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
```

## 📧 Email Testing

### Usar Mailtrap (Desarrollo)
```bash
# En .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

### Enviar Email de Prueba
```bash
# Usando tinker
php artisan tinker

# Enviar email
Mail::raw('Test email', function($msg) {
    $msg->to('test@example.com')->subject('Test');
});
```

## 🔄 Mantenimiento

### Modo Mantenimiento
```bash
# Activar modo mantenimiento
php artisan down

# Con mensaje personalizado
php artisan down --message="Actualizando el sistema" --retry=60

# Desactivar modo mantenimiento
php artisan up
```

### Limpiar Logs Antiguos
```bash
# Eliminar logs de más de 7 días
find storage/logs -name "*.log" -mtime +7 -delete

# Ver tamaño de logs
du -sh storage/logs/
```

### Backup Automático
```bash
# Crear script de backup (backup.sh)
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups"

# Backup de base de datos
php artisan backup:run

# Backup de archivos
tar -czf $BACKUP_DIR/files-$DATE.tar.gz \
  public/images \
  storage/app

# Eliminar backups antiguos (más de 30 días)
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete
```

### Cron Jobs
```bash
# Editar crontab
crontab -e

# Agregar tarea de Laravel
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1

# Backup diario a las 2 AM
0 2 * * * cd /path/to/project && php artisan backup:run
```

## 📈 Analytics y Monitoreo

### Ver Estadísticas de Acceso (Nginx)
```bash
# Ver últimas visitas
tail -f /var/log/nginx/access.log

# Contar visitas por IP
awk '{print $1}' /var/log/nginx/access.log | sort | uniq -c | sort -nr | head -10

# Ver páginas más visitadas
awk '{print $7}' /var/log/nginx/access.log | sort | uniq -c | sort -nr | head -10
```

### Monitorear Recursos del Servidor
```bash
# Ver uso de CPU y memoria
top

# Ver uso de disco
df -h

# Ver procesos de PHP
ps aux | grep php

# Ver conexiones activas
netstat -an | grep :80 | wc -l
```

## 🐛 Troubleshooting

### Error 500
```bash
# Ver último error
tail -n 50 storage/logs/laravel.log

# Verificar permisos
ls -la storage/
ls -la bootstrap/cache/

# Limpiar todo
php artisan optimize:clear
composer dump-autoload
```

### Error 404 en Rutas
```bash
# Limpiar caché de rutas
php artisan route:clear

# Verificar que la ruta existe
php artisan route:list | grep landing

# Verificar .htaccess (Apache)
cat public/.htaccess
```

### Imágenes no Cargan
```bash
# Verificar permisos
ls -la public/images/

# Crear enlace simbólico de storage
php artisan storage:link

# Verificar que las imágenes existen
ls -la public/images/landing/
```

### CSS/JS no se Aplican
```bash
# Limpiar caché del navegador (Ctrl + Shift + R)

# Verificar que los archivos existen
ls -la public/css/landing.css
ls -la public/js/landing.js

# Verificar permisos
chmod 644 public/css/landing.css
chmod 644 public/js/landing.js

# Agregar versión al archivo para forzar recarga
# En blade: asset('css/landing.css?v='.time())
```

## 🔧 Comandos Personalizados

### Crear Comando Artisan
```bash
# Crear nuevo comando
php artisan make:command GenerateSitemap

# Ejecutar comando
php artisan app:generate-sitemap
```

### Ejemplo: Comando para Generar Sitemap
```php
// app/Console/Commands/GenerateSitemap.php
public function handle()
{
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    $urls = ['/', '/pricing', '/features', '/about'];
    
    foreach ($urls as $url) {
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . config('app.url') . $url . '</loc>';
        $sitemap .= '<changefreq>weekly</changefreq>';
        $sitemap .= '<priority>0.8</priority>';
        $sitemap .= '</url>';
    }
    
    $sitemap .= '</urlset>';
    
    file_put_contents(public_path('sitemap.xml'), $sitemap);
    
    $this->info('Sitemap generated successfully!');
}
```

## 📱 Comandos Útiles de Git

### Workflow Básico
```bash
# Ver estado
git status

# Agregar cambios
git add .

# Commit
git commit -m "Update landing page"

# Push
git push origin main

# Pull
git pull origin main
```

### Branches
```bash
# Crear nueva rama
git checkout -b feature/landing-improvements

# Cambiar de rama
git checkout main

# Merge rama
git merge feature/landing-improvements

# Eliminar rama
git branch -d feature/landing-improvements
```

### Deshacer Cambios
```bash
# Deshacer cambios no commiteados
git checkout -- .

# Deshacer último commit (mantener cambios)
git reset --soft HEAD~1

# Deshacer último commit (eliminar cambios)
git reset --hard HEAD~1
```

## 🎯 Comandos Rápidos de Desarrollo

### Servidor de Desarrollo
```bash
# Iniciar servidor de desarrollo
php artisan serve

# En puerto específico
php artisan serve --port=8080

# Accesible desde red local
php artisan serve --host=0.0.0.0
```

### Watch de Archivos
```bash
# Watch de assets
npm run watch

# Watch de tests
php artisan test --watch
```

## 📦 Comandos de Composer

### Gestión de Paquetes
```bash
# Instalar dependencias
composer install

# Actualizar dependencias
composer update

# Instalar paquete específico
composer require vendor/package

# Remover paquete
composer remove vendor/package

# Ver paquetes instalados
composer show
```

---

## 💡 Tips Útiles

### Alias Útiles (agregar a ~/.bashrc o ~/.zshrc)
```bash
# Alias para Laravel
alias art='php artisan'
alias artisan='php artisan'
alias tinker='php artisan tinker'
alias migrate='php artisan migrate'
alias fresh='php artisan migrate:fresh --seed'
alias cache='php artisan optimize:clear'

# Alias para Composer
alias ci='composer install'
alias cu='composer update'
alias cda='composer dump-autoload'

# Alias para NPM
alias ni='npm install'
alias nrd='npm run dev'
alias nrp='npm run production'
alias nrw='npm run watch'
```

### Script de Desarrollo Rápido
```bash
# dev.sh - Script para iniciar desarrollo
#!/bin/bash

echo "🚀 Iniciando entorno de desarrollo..."

# Terminal 1: Servidor Laravel
php artisan serve &

# Terminal 2: Watch de assets
npm run watch &

# Terminal 3: Logs
tail -f storage/logs/laravel.log &

echo "✅ Entorno listo!"
echo "📱 Servidor: http://localhost:8000"
echo "📊 Logs: storage/logs/laravel.log"
```

---

**¿Necesitas más comandos?** Consulta la documentación oficial de Laravel: https://laravel.com/docs
