# 🚀 Guía Rápida: Configurar Email en 5 Minutos

## Opción Más Rápida: Gmail

### Paso 1: Obtener Contraseña de Aplicación (2 minutos)

1. Ve a: https://myaccount.google.com/security
2. Activa "Verificación en 2 pasos" (si no está activa)
3. Busca "Contraseñas de aplicaciones"
4. Selecciona "Correo" → "Otro" → Escribe "AudazPOS"
5. Copia la contraseña de 16 caracteres (ej: `abcd efgh ijkl mnop`)

### Paso 2: Editar .env (1 minuto)

Abre el archivo `.env` y busca la sección de MAIL. Reemplaza con:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="Audaz POS"
```

**Importante**: Reemplaza:
- `tu-email@gmail.com` con tu email real
- `abcd efgh ijkl mnop` con la contraseña de aplicación que copiaste

### Paso 3: Limpiar Caché (30 segundos)

```bash
php artisan config:clear
php artisan cache:clear
```

### Paso 4: Probar (1 minuto)

```bash
php check-email-config.php
```

Si todo está bien:

```bash
php test-email.php tu-email@gmail.com
```

---

## ✅ ¡Listo!

Si recibes el email de prueba, la configuración está completa.

---

## 🚨 Si Algo Sale Mal

### Error: "Authentication failed"
- Verifica que usaste la contraseña de aplicación (16 caracteres)
- NO uses tu contraseña normal de Gmail

### Error: "Connection refused"
- Verifica que el puerto 587 esté abierto
- Contacta a tu hosting si estás en servidor

### Email va a SPAM
- Normal en las primeras pruebas
- Marca como "No es spam" en tu bandeja

---

## 📋 Comandos Útiles

```bash
# Verificar configuración
php check-email-config.php

# Probar envío
php test-email.php tu-email@ejemplo.com

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Ver configuración actual
php artisan tinker
>>> config('mail')
```

---

## 🔄 Para Producción

Cuando subas a producción, repite los pasos 2 y 3 en el servidor:

```bash
# En el servidor
cd /home/audaz.site/public_html
nano .env
# Pega la configuración de MAIL
# Guarda con Ctrl+O, Enter, Ctrl+X

php artisan config:clear
php artisan cache:clear

# Probar
php test-email.php tu-email@gmail.com
```

---

## 📚 Más Opciones

Para usar SendGrid, Mailgun u otros servicios, consulta:
**CONFIGURACION_EMAIL.md**

---

## 💡 Tip Pro

Para producción, considera usar **SendGrid** (100 emails/día gratis):
- Más profesional
- Mejor entregabilidad
- No va a SPAM
- Dashboard con estadísticas

Configuración SendGrid:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.tu-api-key-aqui
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@audaz.site
MAIL_FROM_NAME="Audaz POS"
```

Regístrate en: https://sendgrid.com/
