<?php
/**
 * Script de Verificación de Configuración de Email
 * AudazPOS - Sistema de Punto de Venta
 * 
 * Uso: php check-email-config.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Config;

// Colores para terminal
$green = "\033[32m";
$red = "\033[31m";
$yellow = "\033[33m";
$blue = "\033[34m";
$cyan = "\033[36m";
$reset = "\033[0m";

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║      VERIFICACIÓN DE CONFIGURACIÓN DE EMAIL - AUDAZ POS   ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";

$mailConfig = Config::get('mail');
$mailer = $mailConfig['default'];
$mailerConfig = $mailConfig['mailers'][$mailer] ?? [];

$issues = [];
$warnings = [];

// Verificar configuración básica
echo "═══════════════════════════════════════════════════════════\n";
echo "1. CONFIGURACIÓN GENERAL\n";
echo "═══════════════════════════════════════════════════════════\n";

echo "Mailer por defecto: ";
if ($mailer) {
    echo "{$green}✓ {$mailer}{$reset}\n";
} else {
    echo "{$red}✗ No configurado{$reset}\n";
    $issues[] = "Mailer no configurado en .env (MAIL_MAILER)";
}

echo "Dirección 'From':   ";
$fromAddress = $mailConfig['from']['address'] ?? null;
if ($fromAddress && $fromAddress !== 'hello@example.com') {
    echo "{$green}✓ {$fromAddress}{$reset}\n";
} else {
    echo "{$red}✗ No configurado o usando valor por defecto{$reset}\n";
    $issues[] = "Configura MAIL_FROM_ADDRESS en .env";
}

echo "Nombre 'From':      ";
$fromName = $mailConfig['from']['name'] ?? null;
if ($fromName && $fromName !== 'Example') {
    echo "{$green}✓ {$fromName}{$reset}\n";
} else {
    echo "{$yellow}⚠ Usando valor por defecto{$reset}\n";
    $warnings[] = "Configura MAIL_FROM_NAME en .env para personalizar";
}

echo "\n";

// Verificar configuración SMTP
if ($mailer === 'smtp') {
    echo "═══════════════════════════════════════════════════════════\n";
    echo "2. CONFIGURACIÓN SMTP\n";
    echo "═══════════════════════════════════════════════════════════\n";
    
    echo "Host:         ";
    $host = $mailerConfig['host'] ?? null;
    if ($host && $host !== 'smtp.mailgun.org' && $host !== 'smtp.mailtrap.io') {
        echo "{$green}✓ {$host}{$reset}\n";
    } else {
        echo "{$yellow}⚠ {$host} (valor por defecto){$reset}\n";
        $warnings[] = "Verifica que MAIL_HOST sea correcto";
    }
    
    echo "Puerto:       ";
    $port = $mailerConfig['port'] ?? null;
    if ($port) {
        $portColor = in_array($port, [25, 465, 587, 2525]) ? $green : $yellow;
        echo "{$portColor}✓ {$port}{$reset}";
        
        if ($port == 25) echo " {$yellow}(puede estar bloqueado){$reset}";
        if ($port == 465) echo " {$cyan}(SSL){$reset}";
        if ($port == 587) echo " {$cyan}(TLS - recomendado){$reset}";
        if ($port == 2525) echo " {$cyan}(alternativo){$reset}";
        echo "\n";
    } else {
        echo "{$red}✗ No configurado{$reset}\n";
        $issues[] = "Configura MAIL_PORT en .env";
    }
    
    echo "Encriptación: ";
    $encryption = $mailerConfig['encryption'] ?? null;
    if ($encryption) {
        echo "{$green}✓ {$encryption}{$reset}";
        if ($encryption === 'tls') echo " {$cyan}(recomendado){$reset}";
        echo "\n";
    } else {
        echo "{$yellow}⚠ Sin encriptación{$reset}\n";
        $warnings[] = "Considera usar TLS o SSL (MAIL_ENCRYPTION)";
    }
    
    echo "Usuario:      ";
    $username = $mailerConfig['username'] ?? null;
    if ($username && $username !== 'null') {
        echo "{$green}✓ " . substr($username, 0, 20) . "...{$reset}\n";
    } else {
        echo "{$red}✗ No configurado{$reset}\n";
        $issues[] = "Configura MAIL_USERNAME en .env";
    }
    
    echo "Contraseña:   ";
    $password = $mailerConfig['password'] ?? null;
    if ($password && $password !== 'null') {
        echo "{$green}✓ Configurada (" . strlen($password) . " caracteres){$reset}\n";
    } else {
        echo "{$red}✗ No configurada{$reset}\n";
        $issues[] = "Configura MAIL_PASSWORD en .env";
    }
    
    echo "\n";
}

// Verificar conectividad
echo "═══════════════════════════════════════════════════════════\n";
echo "3. VERIFICACIÓN DE CONECTIVIDAD\n";
echo "═══════════════════════════════════════════════════════════\n";

if ($mailer === 'smtp' && $host && $port) {
    echo "Probando conexión a {$host}:{$port}... ";
    
    $connection = @fsockopen($host, $port, $errno, $errstr, 5);
    
    if ($connection) {
        echo "{$green}✓ Conectado{$reset}\n";
        fclose($connection);
    } else {
        echo "{$red}✗ No se pudo conectar{$reset}\n";
        echo "Error: {$errstr} (código: {$errno})\n";
        $issues[] = "No se puede conectar al servidor SMTP. Verifica firewall o contacta a tu hosting.";
    }
} else {
    echo "{$yellow}⚠ Omitiendo prueba de conectividad (configuración incompleta){$reset}\n";
}

echo "\n";

// Detectar servicio de email
echo "═══════════════════════════════════════════════════════════\n";
echo "4. SERVICIO DETECTADO\n";
echo "═══════════════════════════════════════════════════════════\n";

$service = "Desconocido";
$serviceIcon = "❓";

if ($host) {
    if (strpos($host, 'gmail') !== false) {
        $service = "Gmail";
        $serviceIcon = "📧";
        echo "{$cyan}{$serviceIcon} {$service}{$reset}\n";
        echo "Recomendaciones:\n";
        echo "- Usa contraseña de aplicación (no tu contraseña normal)\n";
        echo "- Activa verificación en 2 pasos primero\n";
        echo "- Límite: 500 emails/día\n";
    } elseif (strpos($host, 'sendgrid') !== false) {
        $service = "SendGrid";
        $serviceIcon = "🚀";
        echo "{$cyan}{$serviceIcon} {$service}{$reset}\n";
        echo "Recomendaciones:\n";
        echo "- Usuario debe ser 'apikey'\n";
        echo "- Contraseña es tu API Key\n";
        echo "- Plan gratuito: 100 emails/día\n";
    } elseif (strpos($host, 'mailgun') !== false) {
        $service = "Mailgun";
        $serviceIcon = "💼";
        echo "{$cyan}{$serviceIcon} {$service}{$reset}\n";
        echo "Recomendaciones:\n";
        echo "- Verifica tu dominio para mejor entregabilidad\n";
        echo "- Plan gratuito: 5,000 emails/mes (3 meses)\n";
    } elseif (strpos($host, 'mailtrap') !== false) {
        $service = "Mailtrap";
        $serviceIcon = "🧪";
        echo "{$yellow}{$serviceIcon} {$service} (SOLO DESARROLLO){$reset}\n";
        echo "⚠️  ADVERTENCIA: Mailtrap NO envía emails reales\n";
        echo "   Solo para pruebas en desarrollo\n";
    } elseif (strpos($host, 'mail.') !== false || strpos($host, 'smtp.') !== false) {
        $service = "SMTP de Hosting";
        $serviceIcon = "🏢";
        echo "{$cyan}{$serviceIcon} {$service}{$reset}\n";
        echo "Recomendaciones:\n";
        echo "- Verifica límites de envío con tu hosting\n";
        echo "- Configura SPF/DKIM para evitar SPAM\n";
    } else {
        echo "{$yellow}{$serviceIcon} {$service}{$reset}\n";
    }
}

echo "\n";

// Resumen
echo "═══════════════════════════════════════════════════════════\n";
echo "5. RESUMEN\n";
echo "═══════════════════════════════════════════════════════════\n";

if (count($issues) === 0 && count($warnings) === 0) {
    echo "{$green}✅ ¡Configuración completa y correcta!{$reset}\n\n";
    echo "Puedes probar el envío con:\n";
    echo "{$cyan}php test-email.php tu-email@ejemplo.com{$reset}\n";
} else {
    if (count($issues) > 0) {
        echo "{$red}❌ PROBLEMAS ENCONTRADOS ({count($issues)}):{$reset}\n";
        foreach ($issues as $i => $issue) {
            echo "   " . ($i + 1) . ". {$issue}\n";
        }
        echo "\n";
    }
    
    if (count($warnings) > 0) {
        echo "{$yellow}⚠️  ADVERTENCIAS ({count($warnings)}):{$reset}\n";
        foreach ($warnings as $i => $warning) {
            echo "   " . ($i + 1) . ". {$warning}\n";
        }
        echo "\n";
    }
    
    if (count($issues) > 0) {
        echo "Corrige los problemas antes de probar el envío.\n";
    } else {
        echo "Puedes probar el envío, pero considera las advertencias:\n";
        echo "{$cyan}php test-email.php tu-email@ejemplo.com{$reset}\n";
    }
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "DOCUMENTACIÓN COMPLETA: CONFIGURACION_EMAIL.md\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "\n";

exit(count($issues) > 0 ? 1 : 0);
