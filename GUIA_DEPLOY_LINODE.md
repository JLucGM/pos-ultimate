# Guía de Deploy en Linode VPS - Audaz POS

## PASO 1: Crear el VPS en Linode

1. Ve a [https://cloud.linode.com](https://cloud.linode.com) y crea una cuenta (o inicia sesión)
2. Click en **"Create Linode"**
3. Configura así:

| Campo | Valor recomendado |
|---|---|
| **Image** | Ubuntu 22.04 LTS |
| **Region** | La más cercana a tus usuarios (ej: Miami para Latam) |
| **Plan** | Shared CPU - Nanode 1GB ($5/mes) o Linode 2GB ($12/mes) recomendado |
| **Linode Label** | audaz-pos |
| **Root Password** | (una contraseña segura, anótala) |

4. Click en **"Create Linode"**
5. Espera que el status cambie a **"Running"**
6. Copia la **IP pública** que aparece (ej: `172.xxx.xxx.xxx`)

## PASO 2: Conectarte al VPS por SSH

Desde tu terminal en Mac:

```bash
ssh root@TU_IP_DEL_VPS
```

Acepta la huella digital (yes) e ingresa tu contraseña root.

## PASO 3: Ejecutar el script de instalación

Una vez dentro del VPS, copia y pega estos comandos **uno por uno** en orden.

### 3.1 - Actualizar el sistema

```bash
apt update && apt upgrade -y
```

### 3.2 - Instalar dependencias base

```bash
apt install -y nginx mysql-server php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-bcmath php8.1-curl php8.1-zip php8.1-gd php8.1-intl php8.1-soap php8.1-readline unzip git curl software-properties-common

```

### 3.3 - Instalar Composer

```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
```

### 3.4 - Configurar MySQL

```bash
mysql_secure_installation
```

Responde:
- VALIDATE PASSWORD: **N**
- New root password: **(pon una contraseña segura y anótala)**
- Remove anonymous users: **Y**
- Disallow root login remotely: **Y**
- Remove test database: **Y**
- Reload privilege tables: **Y**

Luego crea la base de datos:

```bash
mysql -u root -p
```

Dentro de MySQL:

```sql
CREATE DATABASE audaz_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'audaz_user'@'localhost' IDENTIFIED BY 'TU_PASSWORD_SEGURA_AQUI';
GRANT ALL PRIVILEGES ON audaz_pos.* TO 'audaz_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3.5 - Clonar el proyecto

```bash
cd /var/www
git clone TU_REPO_GIT audaz_pos
cd audaz_pos
```

Si no tienes repo git, puedes subir los archivos con scp desde tu Mac:

```bash
# Desde tu Mac (NO en el VPS):
scp -r /Users/evills/Documents/Audaz_pos root@TU_IP_DEL_VPS:/var/www/audaz_pos
```

### 3.6 - Instalar dependencias del proyecto

```bash
cd /var/www/audaz_pos
composer install --no-dev --optimize-autoloader
```

### 3.7 - Configurar el .env

```bash
cp .env.example .env
nano .env
```

Modifica estas líneas:

```env
APP_NAME="Audaz POS"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://TU_IP_DEL_VPS

ADMINISTRATOR_USERNAMES=superadmin

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=audaz_pos
DB_USERNAME=audaz_user
DB_PASSWORD=TU_PASSWORD_SEGURA_AQUI

SESSION_DRIVER=file
SESSION_SECURE_COOKIE=false
```

Guarda con `Ctrl+O`, Enter, `Ctrl+X`.

### 3.8 - Generar key y migrar

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### 3.9 - Permisos

```bash
chown -R www-data:www-data /var/www/audaz_pos
chmod -R 755 /var/www/audaz_pos
chmod -R 775 /var/www/audaz_pos/storage
chmod -R 775 /var/www/audaz_pos/bootstrap/cache
```

### 3.10 - Configurar Nginx

```bash
nano /etc/nginx/sites-available/audaz_pos
```

Pega este contenido:

```nginx
server {
    listen 80;
    server_name TU_IP_DEL_VPS;
    root /var/www/audaz_pos/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;
    charset utf-8;

    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Guarda y activa:

```bash
ln -s /etc/nginx/sites-available/audaz_pos /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl restart nginx
```

### 3.11 - Optimizar Laravel para producción

```bash
cd /var/www/audaz_pos
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## PASO 4: Probar

Abre en tu navegador: `http://TU_IP_DEL_VPS`

Login:
- **superadmin** / superadmin123
- **admin** / admin123
- **cajero** / cajero123
- **compras** / compras123

## PASO 5 (Opcional): Agregar dominio y SSL

Si tienes un dominio, apunta el DNS (registro A) a la IP del VPS, luego:

```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d tudominio.com
```

Después actualiza en `.env`:

```env
APP_URL=https://tudominio.com
SESSION_SECURE_COOKIE=true
```

Y recachea:

```bash
cd /var/www/audaz_pos
php artisan config:cache
```

## Comandos útiles de mantenimiento

```bash
# Ver logs de errores
tail -f /var/www/audaz_pos/storage/logs/laravel-$(date +%Y-%m-%d).log

# Limpiar caché
cd /var/www/audaz_pos && php artisan optimize:clear

# Reiniciar servicios
systemctl restart nginx
systemctl restart php8.1-fpm
systemctl restart mysql

# Estado de servicios
systemctl status nginx php8.1-fpm mysql
```
