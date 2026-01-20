<?php
/**
 * Script de Prueba de Envío de Emails
 * AudazPOS - Sistema de Punto de Venta
 * 
 * Uso: php test-email.php tu-email@ejemplo.com
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

// Colores para terminal
$green = "\033[32m";
$red = "\033[31m";
$yellow = "\033[33m";
$blue = "\033[34m";
$reset = "\033[0m";

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║         PRUEBA DE CONFIGURACIÓN DE EMAIL - AUDAZ POS      ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";

// Obtener email de destino
$toEmail = $argv[1] ?? null;

if (!$toEmail) {
    echo "{$red}❌ Error: Debes proporcionar un email de destino{$reset}\n";
    echo "{$yellow}Uso: php test-email.php tu-email@ejemplo.com{$reset}\n\n";
    exit(1);
}

// Validar email
if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
    echo "{$red}❌ Error: Email inválido: {$toEmail}{$reset}\n\n";
    exit(1);
}

echo "{$blue}📧 Email de destino: {$toEmail}{$reset}\n\n";

// Mostrar configuración actual
echo "═══════════════════════════════════════════════════════════\n";
echo "CONFIGURACIÓN ACTUAL:\n";
echo "═══════════════════════════════════════════════════════════\n";

$mailConfig = Config::get('mail');
$mailer = $mailConfig['default'];
$mailerConfig = $mailConfig['mailers'][$mailer] ?? [];

echo "Mailer:       {$yellow}{$mailer}{$reset}\n";
echo "Host:         {$yellow}" . ($mailerConfig['host'] ?? 'N/A') . "{$reset}\n";
echo "Puerto:       {$yellow}" . ($mailerConfig['port'] ?? 'N/A') . "{$reset}\n";
echo "Encriptación: {$yellow}" . ($mailerConfig['encryption'] ?? 'N/A') . "{$reset}\n";
echo "Usuario:      {$yellow}" . ($mailerConfig['username'] ?? 'N/A') . "{$reset}\n";
echo "Desde:        {$yellow}" . $mailConfig['from']['address'] . " ({$mailConfig['from']['name']}){$reset}\n";
echo "\n";

// Confirmar envío
echo "═══════════════════════════════════════════════════════════\n";
echo "{$yellow}¿Deseas enviar un email de prueba? (s/n): {$reset}";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
$confirm = trim(strtolower($line));
fclose($handle);

if ($confirm !== 's' && $confirm !== 'si' && $confirm !== 'y' && $confirm !== 'yes') {
    echo "{$yellow}⚠️  Prueba cancelada{$reset}\n\n";
    exit(0);
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "ENVIANDO EMAIL DE PRUEBA...\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "\n";

try {
    $startTime = microtime(true);
    
    Mail::raw(
        "¡Hola!\n\n" .
        "Este es un email de prueba desde Audaz POS.\n\n" .
        "Si estás recibiendo este mensaje, significa que la configuración de email está funcionando correctamente.\n\n" .
        "Detalles de la prueba:\n" .
        "- Fecha: " . date('d/m/Y H:i:s') . "\n" .
        "- Servidor: " . ($mailerConfig['host'] ?? 'N/A') . "\n" .
        "- Puerto: " . ($mailerConfig['port'] ?? 'N/A') . "\n\n" .
        "Saludos,\n" .
        "Equipo Audaz POS",
        function ($message) use ($toEmail) {
            $message->to($toEmail)
                    ->subject('✅ Prueba de Email - Audaz POS');
        }
    );
    
    $endTime = microtime(true);
    $duration = round(($endTime - $startTime) * 1000, 2);
    
    echo "{$green}✅ ¡Email enviado exitosamente!{$reset}\n\n";
    echo "Detalles:\n";
    echo "- Destinatario: {$green}{$toEmail}{$reset}\n";
    echo "- Tiempo: {$green}{$duration}ms{$reset}\n";
    echo "- Estado: {$green}Enviado{$reset}\n\n";
    
    echo "═══════════════════════════════════════════════════════════\n";
    echo "{$blue}📬 Revisa tu bandeja de entrada (y carpeta de SPAM){$reset}\n";
    echo "═══════════════════════════════════════════════════════════\n\n";
    
    exit(0);
    
} catch (\Swift_TransportException $e) {
    echo "{$red}❌ Error de Transporte SMTP:{$reset}\n";
    echo "{$red}" . $e->getMessage() . "{$reset}\n\n";
    
    echo "═══════════════════════════════════════════════════════════\n";
    echo "POSIBLES SOLUCIONES:\n";
    echo "═══════════════════════════════════════════════════════════\n";
    echo "1. Verifica las credenciales en .env\n";
    echo "2. Verifica que el puerto esté abierto:\n";
    echo "   {$yellow}telnet " . ($mailerConfig['host'] ?? 'smtp.example.com') . " " . ($mailerConfig['port'] ?? '587') . "{$reset}\n";
    echo "3. Si usas Gmail, asegúrate de usar contraseña de aplicación\n";
    echo "4. Limpia la caché: {$yellow}php artisan config:clear{$reset}\n";
    echo "5. Contacta a tu proveedor de hosting si el puerto está bloqueado\n\n";
    
    exit(1);
    
} catch (\Exception $e) {
    echo "{$red}❌ Error General:{$reset}\n";
    echo "{$red}" . $e->getMessage() . "{$reset}\n\n";
    
    echo "═══════════════════════════════════════════════════════════\n";
    echo "INFORMACIÓN DE DEBUG:\n";
    echo "═══════════════════════════════════════════════════════════\n";
    echo "Tipo de error: " . get_class($e) . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n\n";
    
    exit(1);
}
