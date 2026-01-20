# Configuración de Envío de Emails - AudazPOS

## 📧 Opciones de Configuración

Tienes varias opciones para configurar el envío de emails. Aquí están las más recomendadas:

---

## 🎯 Opción 1: Gmail (Recomendado para Pruebas)

### Ventajas:
- ✅ Gratis
- ✅ Fácil de configurar
- ✅ Confiable
- ⚠️ Límite: 500 emails/día

### Configuración:

#### Paso 1: Habilitar "Contraseñas de Aplicación" en Gmail

1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. Seguridad → Verificación en 2 pasos (debes activarla primero)
3. Contraseñas de aplicaciones
4. Selecciona "Correo" y "Otro (nombre personalizado)"
5. Escribe "AudazPOS" y genera
6. Copia la contraseña de 16 caracteres

#### Paso 2: Configurar .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx  # Contraseña de aplicación (16 caracteres)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="Audaz POS"
```

---

## 🚀 Opción 2: SendGrid (Recomendado para Producción)

### Ventajas:
- ✅ Plan gratuito: 100 emails/día
- ✅ Muy confiable
- ✅ Buena entregabilidad
- ✅ Dashboard con estadísticas
- ✅ Fácil escalabilidad

### Configuración:

#### Paso 1: Crear cuenta en SendGrid

1. Regístrate en: https://sendgrid.com/
2. Verifica tu email
3. Ve a Settings → API Keys
4. Crea una nueva API Key con permisos "Full Access"
5. Copia la API Key (solo se muestra una vez)

#### Paso 2: Configurar .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  # Tu API Key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@audaz.site
MAIL_FROM_NAME="Audaz POS"
```

#### Paso 3: Verificar dominio (Opcional pero recomendado)

1. En SendGrid: Settings → Sender Authentication
2. Authenticate Your Domain
3. Sigue las instrucciones para agregar registros DNS
4. Esto mejora la entregabilidad

---

## 💼 Opción 3: Mailgun (Alternativa Profesional)

### Ventajas:
- ✅ Plan gratuito: 5,000 emails/mes (primeros 3 meses)
- ✅ Muy usado en producción
- ✅ API potente
- ✅ Buenas estadísticas

### Configuración:

#### Paso 1: Crear cuenta en Mailgun

1. Regístrate en: https://www.mailgun.com/
2. Verifica tu email
3. Ve a Sending → Domains
4. Usa el dominio sandbox para pruebas o agrega tu dominio

#### Paso 2: Obtener credenciales

1. Ve a Sending → Domain Settings
2. Copia el "SMTP hostname"
3. Copia el "Default SMTP Login"
4. Copia el "Default password"

#### Paso 3: Configurar .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@sandbox123456.mailgun.org  # Tu SMTP login
MAIL_PASSWORD=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  # Tu password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@audaz.site
MAIL_FROM_NAME="Audaz POS"
```

---

## 🏢 Opción 4: SMTP de tu Hosting (cPanel/Plesk)

### Ventajas:
- ✅ Ya incluido en tu hosting
- ✅ Usa tu dominio directamente
- ⚠️ Puede tener límites según el plan

### Configuración:

#### Paso 1: Crear cuenta de email en cPanel

1. Entra a cPanel de tu hosting
2. Email Accounts → Create
3. Crea: noreply@audaz.site
4. Anota la contraseña

#### Paso 2: Obtener configuración SMTP

Configuración típica para cPanel:
- Host: mail.audaz.site (o smtp.audaz.site)
- Puerto: 587 (TLS) o 465 (SSL)
- Usuario: noreply@audaz.site
- Contraseña: la que creaste

#### Paso 3: Configurar .env

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.audaz.site
MAIL_PORT=587
MAIL_USERNAME=noreply@audaz.site
MAIL_PASSWORD=tu-contraseña-segura
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@audaz.site
MAIL_FROM_NAME="Audaz POS"
```

---

## 🧪 Opción 5: Mailtrap (Solo para Desarrollo/Pruebas)

### Ventajas:
- ✅ Perfecto para desarrollo
- ✅ No envía emails reales
- ✅ Puedes ver los emails en su dashboard
- ⚠️ NO usar en producción

### Configuración:

#### Paso 1: Crear cuenta en Mailtrap

1. Regístrate en: https://mailtrap.io/
2. Ve a Email Testing → Inboxes
3. Copia las credenciales SMTP

#### Paso 2: Configurar .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu-username-mailtrap
MAIL_PASSWORD=tu-password-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@audaz.site
MAIL_FROM_NAME="Audaz POS"
```

---

## 🔧 Configuración en el Servidor

### Paso 1: Editar .env en producción

```bash
# Conectar al servidor
ssh root@audaz.site

# Ir al directorio del proyecto
cd /home/audaz.site/public_html

# Editar .env
nano .env
```

### Paso 2: Agregar/Modificar las líneas de MAIL

Pega la configuración que elegiste (Gmail, SendGrid, etc.)

### Paso 3: Limpiar caché

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

---

## ✅ Probar el Envío de Emails

### Método 1: Desde Artisan Tinker

```bash
php artisan tinker
```

Luego ejecuta:

```php
Mail::raw('Email de prueba desde Audaz POS', function ($message) {
    $message->to('tu-email@gmail.com')
            ->subject('Prueba de Email');
});
```

Si no hay errores, revisa tu bandeja de entrada.

### Método 2: Crear un comando de prueba

Crea el archivo: `test-email.php` en la raíz del proyecto:

```php
<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Este es un email de prueba desde Audaz POS', function ($message) {
        $message->to('tu-email@gmail.com')
                ->subject('Prueba de Configuración de Email');
    });
    
    echo "✅ Email enviado exitosamente!\n";
    echo "Revisa tu bandeja de entrada: tu-email@gmail.com\n";
} catch (Exception $e) {
    echo "❌ Error al enviar email:\n";
    echo $e->getMessage() . "\n";
}
```

Ejecutar:

```bash
php test-email.php
```

---

## 🔍 Verificar Configuración Actual

### Ver configuración de mail:

```bash
php artisan tinker
```

```php
config('mail');
```

### Ver si hay emails en cola:

```bash
php artisan queue:work --once
```

---

## 🚨 Solución de Problemas Comunes

### Error: "Connection could not be established"

**Causa**: Credenciales incorrectas o firewall bloqueando

**Solución**:
1. Verifica usuario y contraseña
2. Verifica que el puerto esté abierto:
   ```bash
   telnet smtp.gmail.com 587
   ```
3. Contacta a tu hosting si el puerto está bloqueado

### Error: "Authentication failed"

**Causa**: Contraseña incorrecta o 2FA no configurado (Gmail)

**Solución**:
1. Gmail: Usa contraseña de aplicación, no tu contraseña normal
2. Verifica que no haya espacios en la contraseña
3. Regenera la contraseña de aplicación

### Error: "SSL certificate problem"

**Causa**: Certificados SSL no actualizados en el servidor

**Solución**:
```bash
# Actualizar certificados
sudo apt-get update
sudo apt-get install ca-certificates
```

### Emails van a SPAM

**Solución**:
1. Configura SPF, DKIM y DMARC en tu dominio
2. Usa un servicio profesional (SendGrid, Mailgun)
3. Verifica tu dominio en el servicio de email
4. No uses palabras spam en el asunto

---

## 📊 Comparación de Servicios

| Servicio | Gratis/Mes | Confiabilidad | Dificultad | Recomendado Para |
|----------|------------|---------------|------------|------------------|
| Gmail | 500/día | ⭐⭐⭐⭐ | Fácil | Desarrollo/Pruebas |
| SendGrid | 100/día | ⭐⭐⭐⭐⭐ | Fácil | Producción |
| Mailgun | 5,000 (3 meses) | ⭐⭐⭐⭐⭐ | Media | Producción |
| SMTP Hosting | Variable | ⭐⭐⭐ | Fácil | Pequeña escala |
| Mailtrap | Ilimitado | ⭐⭐⭐⭐⭐ | Fácil | Solo desarrollo |

---

## 🎯 Mi Recomendación

### Para Empezar (Hoy):
**Gmail** - Rápido y fácil de configurar

### Para Producción (Largo plazo):
**SendGrid** - Profesional, confiable y escalable

### Configuración Dual (Ideal):
```env
# Producción: SendGrid
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.tu-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@audaz.site
MAIL_FROM_NAME="Audaz POS"
```

---

## 📝 Checklist de Configuración

- [ ] Elegir servicio de email
- [ ] Crear cuenta en el servicio
- [ ] Obtener credenciales (usuario, contraseña/API key)
- [ ] Editar .env en local
- [ ] Probar envío en local
- [ ] Editar .env en servidor
- [ ] Limpiar caché en servidor
- [ ] Probar envío en producción
- [ ] Verificar que no vaya a SPAM
- [ ] (Opcional) Configurar SPF/DKIM

---

## 🔐 Seguridad

### Nunca hagas esto:
- ❌ Subir .env a Git
- ❌ Compartir contraseñas en texto plano
- ❌ Usar tu contraseña personal de Gmail

### Siempre haz esto:
- ✅ Usar contraseñas de aplicación (Gmail)
- ✅ Usar API keys (SendGrid, Mailgun)
- ✅ Mantener .env fuera de Git (.gitignore)
- ✅ Usar variables de entorno en producción

---

## 📧 Emails que Envía el Sistema

El sistema AudazPOS envía emails para:

1. **Registro de usuario** - Email de bienvenida
2. **Recuperación de contraseña** - Link para resetear
3. **Notificaciones de ventas** - Recibos por email
4. **Recordatorios de citas** - Para módulo consultorio
5. **Alertas de inventario** - Stock bajo
6. **Reportes programados** - Reportes diarios/semanales

---

¿Qué servicio prefieres usar? Te ayudo a configurarlo paso a paso.
