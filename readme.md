# Kubre - Plataforma de Gestión Comercial & POS Todo en Uno (`kubre.site`)

Sistema de Punto de Venta (POS), Facturación, Inventario, Manufactura y Gestión Empresarial Multimoneda con arquitectura SaaS multiempresa.

## 🚀 Requisitos del Sistema
- PHP 8.1 / 8.2 / 8.3 / 8.4
- MySQL 8.0+ / MariaDB 10.4+
- Composer 2.x
- Extensiones PHP: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `gd`, `zip`, `curl`

## 🛠️ Instalación Rápida en Local
```bash
# 1. Instalar dependencias
composer install --ignore-platform-reqs

# 2. Configurar entorno
cp .env.example .env
php artisan key:generate

# 3. Migraciones y Seeders iniciales
php artisan migrate
php artisan db:seed

# 4. Iniciar servidor local
php artisan serve
```

## 👥 Credenciales por Defecto
- **Super Administrador**: `superadmin` / `superadmin123`
- **Administrador de Negocio**: `admin` / `admin123`
- **Cajero**: `cajero` / `cajero123`
- **Compras**: `compras` / `compras123`
